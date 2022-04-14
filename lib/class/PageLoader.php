<?php

namespace App;

require_once("lib/class/App.php");
require_once("lib/class/Router.php");

class PageLoader {
    public $nav_items = [];

    // Default properties for a page.
    public $page_default = [
        "title" => "",
        "visible" => true,
        "url" => "/",
        "path" => "lib/templates/pages/404.tpl",
        "plugin" => "DefaultHandler",
        "template" => true,
        "bg-color" => "#fff",
        "color" => "#000"
    ];

    function __construct() {
            
    }

    function loadRoutes(\App\App &$app, \App\Router $router) {
        foreach ($this->nav_items as $item) {
            $plugin = $item["plugin"];

            // Use default plugin if specified plugin does not exist.
            if (!file_exists("public/plugins/{$item["plugin"]}/index.php")) {
                $plugin = "DefaultHandler";
            }

            $router->add($item["url"], "get", function($res) use(&$app, $item, $plugin) {
                PluginLoader::loadGlobalPlugins($app, $res, $item);
                PluginLoader::loadPlugin($app, $plugin, $res, $item);
            });
        }
    }

    function loadPages(\App\App &$app) {
        $pages = \App\App::loadJSON("content/configs/pages.json");

        $this->loadCustomAssets($pages);

        // Add default properties to pages which do not have all properties.
        $this->nav_items = array_map(fn($x) => array_merge($this->page_default, $x), $pages["pages"]);

        return $this->nav_items;
    }

    /**
     * Loads all custom assets from config/pages.json.
     */

    function loadCustomAssets($pages) {
        foreach ($pages["pages_all"]["css"] as $css) {
            $app->addCSS($css);
        }

        foreach ($pages["pages_all"]["js"] as $js) {
            $app->addJS($js);
        }
    }

    /**
     * Get the nav bar for the header.
     */
    function getNav(\App\Lang &$lang, $smarty): string {
        // Filter nav items which are set to visible.
        $nav_items_filtered = array_filter($this->nav_items, fn($x) => $x["visible"]);

        // Get the correct lang for nav items.
        $nav_items_lang = array_map(fn($x) => 
            array_merge($x, ["title" => $lang->get("nav:" . strtolower($x["title"]))
        ]), $nav_items_filtered);

        return $smarty->fetch("lib/templates/partials/nav.tpl", [
            "nav_items" => $nav_items_lang
        ]);
    }

    function getFooter($smarty): string {
        return $smarty->fetch("lib/templates/partials/footer.tpl");
    }
}
