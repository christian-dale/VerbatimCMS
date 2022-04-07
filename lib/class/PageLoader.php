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

    /**
     * Get the directory of the plugin by name.
     */

    function getPlugin(string $plugin_name): string {
        $plugin_path_content = "content/plugins/${plugin_name}/index.php";
        $plugin_path_lib = "lib/plugins_default/${plugin_name}/index.php";

        if (file_exists($plugin_path_content)) {
            return $plugin_path_content;
        } else if (file_exists($plugin_path_lib)) {
            return $plugin_path_lib;
        } else {
            return "lib/plugins_default/DefaultHandler/index.php";
        }
    }

    function loadRoutes(\App\App $app, \App\Router $router) {
        foreach ($this->nav_items as $item) {
            $plugin = $item["plugin"];

            // Use default plugin if specified plugin does not exist.
            if (!file_exists("content/plugins/" . $item["plugin"] . "/index.php")) {
                $plugin = "DefaultHandler";
            }

            $router->add($item["url"], "get", function($res) use(&$app, $item, $plugin) {
                require_once($this->getPlugin($plugin));
                $instance = new $plugin();
                $instance->init($res, $app, $item);
            });
        }
    }

    function loadPages() {
        $pages = \App\App::loadJSON("content/configs/pages.json");

        // Add default properties to pages which do not have all properties.
        $this->nav_items = array_map(fn($x) => array_merge($this->page_default, $x), $pages["pages"]);
    }

    function getNav($smarty): string {
        return $smarty->fetch("lib/templates/partials/nav.tpl", [
            "nav_items" => array_filter($this->nav_items, fn($x) => $x["visible"])
        ]);
    }
}
