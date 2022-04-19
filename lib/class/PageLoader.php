<?php

namespace App;

require_once("lib/class/App.php");
require_once("lib/class/Router.php");

class PageLoader {
    public $routes = [];

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

    function loadRoutes(\App\App &$app, \App\Router &$router) {
        // Add routes from plugins.
        foreach (\App\PluginLoader::getPluginsList() as $plugin) {
            $plugin_obj = new $plugin["name"];

            if (\App\PluginLoader::loadPluginConfig($plugin["name"])["enabled"]) {
                // The routes defined in the plugin.
                foreach ($plugin_obj->routes as $index => $route) {
                    $router->add($route["path"], $route["method"] ?? "get", function(\App\Request $req) use(&$app, $route, $plugin) {
                        PluginLoader::loadGlobalPlugins($app, $req, $route);
                        PluginLoader::loadPlugin($app, $plugin["name"], $req, $route);
                    });
                }
            }
        }

        // Add authentication routes.
        \App\Authenticator::registerRoutes($app, $router);

        foreach ($this->routes as $route) {
            $plugin = file_exists("public/plugins/{$route["plugin"]}/index.php") ? 
                $route["plugin"] : "DefaultHandler";

            if (\App\PluginLoader::loadPluginConfig($plugin)["enabled"]) {
                $router->add($route["url"], $route["method"] ?? "get", function($req) use(&$app, $route, $plugin) {
                    PluginLoader::loadGlobalPlugins($app, $req, $route);
                    PluginLoader::loadPlugin($app, $plugin, $req, $route);
                });
            }
        }
    }

    function loadPages(\App\App &$app) {
        $pages = \App\Util::loadJSON("content/configs/pages.json");

        $this->loadCustomAssets($pages);

        // Add default properties to pages which do not have all properties.
        $this->routes = array_map(fn($x) => array_merge($this->page_default, $x), $pages["pages"]);

        // Filter visible pages.
        $pages_visible = array_filter($this->routes, fn($x) => $x["visible"]);

        return $pages_visible;
    }

    /**
     * Get info relating to a page.
     */

    public static function getPageInfo(string $page_name) {
        return [
            "name" => $page_name,
            "content" => file_get_contents("content/pages/{$page_name}.tpl")
        ];
    }

    public static function editPage(string $page_name, string $content) {
        $page_name_clean = strtolower(str_replace(" ", "-", $page_name));

        file_put_contents("content/pages/{$page_name_clean}.tpl", $content);
        $pages = \App\Util::loadJSON("content/configs/pages.json");
        
        $pages["pages"][] = [
            "title" => $page_name,
            "url" => "/{$page_name_clean}",
            "path" => "content/pages/{$page_name_clean}.tpl",
            "visible" => true
        ];

        \App\Util::storeConfig("content/configs/pages.json", $pages);
    }

    public static function deletePage($page_name) {
        $pages = \App\Util::loadJSON("content/configs/pages.json");
        $page_name_clean = strtolower(str_replace(" ", "-", $page_name));

        foreach ($pages["pages"] as $index => &$page) {
            if (strtolower(str_replace(" ", "-", $page["title"])) == $page_name) {
                unset($pages["pages"][$index]);
            }
        }

        \App\Util::storeConfig("content/configs/pages.json", $pages);
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
}
