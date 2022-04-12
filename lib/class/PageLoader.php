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
            if (!file_exists("content/plugins/{$plugin}/index.php")) {
                $plugin = "DefaultHandler";
            }

            $router->add($item["url"], "get", function($res) use(&$app, $item, $plugin) {
                PluginLoader::loadPlugin($app, $plugin, $res, $item);
            });
        }
    }

    function loadPages(\App\App &$app) {
        $pages = \App\App::loadJSON("content/configs/pages.json");
        
        foreach ($pages["pages_all"]["css"] as $css) {
            $app->addCSS($css);
        }

        foreach ($pages["pages_all"]["js"] as $js) {
            $app->addJS($js);
        }

        // Add default properties to pages which do not have all properties.
        $this->nav_items = array_map(fn($x) => array_merge($this->page_default, $x), $pages["pages"]);
    }

    function getNav(\App\Lang &$lang, $smarty): string {
        $nav_items = array_filter($this->nav_items, fn($x) => $x["visible"]);

        foreach ($nav_items as &$nav_item) {
            $item_title = strtolower($nav_item['title']);
            $nav_item["title"] = $lang->get("nav:{$item_title}");
        }

        return $smarty->fetch("lib/templates/partials/nav.tpl", [
            "nav_items" => $nav_items
        ]);
    }

    function getFooter($smarty): string {
        return $smarty->fetch("lib/templates/partials/footer.tpl");
    }
}
