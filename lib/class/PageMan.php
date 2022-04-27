<?php

namespace VerbatimCMS;

require_once("lib/class/App.php");
require_once("lib/class/Router.php");

class PageMan {
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

    function loadRoutes(App &$app, Router &$router) {
        // Add routes from plugins.
        foreach (PluginMan::getPluginsList() as $plugin) {
            $plugin_obj = new $plugin["name"];

            if (PluginMan::loadPluginConfig($plugin["name"])["enabled"]) {
                // The routes defined in the plugin.
                foreach ($plugin_obj->routes as $index => $route) {
                    // If route should be shown in the navigation component.
                    if (isset($route["nav_item"]) && $route["nav_item"] == true) {
                        $this->routes[] = [
                            "id" => $route["id"] ?? Util::normalizeName($route["title"]),
                            "title" => $route["title"] ?? "",
                            "url" => $route["path"],
                            "visible" => true
                        ];
                    }

                    $router->add($route["path"], $route["method"], fn(Request $req) =>
                        $this->registerRoutePlugins($app, $req, $route, $plugin["name"]));
                }
            }
        }

        // Add authentication routes.
        Authenticator::registerRoutes($app, $router);

        foreach ($this->routes as $route) {
            $plugin = PluginMan::pluginEnabled($route["plugin"] ?? "") ? $route["plugin"] : "DefaultHandler";

            if (PluginMan::loadPluginConfig($plugin)["enabled"]) {
                $router->add($route["url"], $route["method"], fn(Request $req) =>
                    $this->registerRoutePlugins($app, $req, $route, $plugin));
            }
        }
    }

    function loadPages(App &$app) {
        $pages = Util::loadJSON("content/configs/pages.json");

        $this->loadCustomAssets($app, $pages);

        // Add default properties to pages which do not have all properties.
        $this->routes = array_map(fn($x) => array_merge($this->page_default, $x), $pages["pages"]);

        // Filter visible pages.
        $pages_visible = array_filter($this->routes, function($page) {
            return $page["visible"] || (strtolower($page["title"]) == "home" &&
                file_exists("content/pages/home.tpl"));
        });

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
        $page_name_clean = Util::normalizeName($page_name);

        file_put_contents("content/pages/{$page_name_clean}.tpl", $content);
        $pages = Util::loadJSON("content/configs/pages.json");

        $page_edit = false;
        $page_new = [
            "id" => $page_name_clean,
            "title" => $page_name,
            "url" => "/{$page_name_clean}",
            "path" => "content/pages/{$page_name_clean}.tpl",
            "visible" => true
        ];

        foreach ($pages["pages"] as $index => $page) {
            if (strtolower(str_replace(" ", "-", $page["title"])) == $page_name_clean) {
                $page_edit = true;

                $pages["pages"][$index] = $page_new;
            }
        }

        if (!$page_edit) {
            $pages["pages"][] = $page_new;
        }

        Util::storeConfig("content/configs/pages.json", $pages);

        $lang = Util::loadJSON("content/lang/en.json");
        $lang["nav:{$page_name_clean}"] = $page_name;
        Util::storeConfig("content/lang/en.json", $lang);
    }

    public static function deletePage($page_name) {
        $pages = Util::loadJSON("content/configs/pages.json");
        $page_name_clean = Util::normalizeName($page_name);

        foreach ($pages["pages"] as $index => &$page) {
            if (Util::normalizeName($page["title"]) == $page_name) {
                unset($pages["pages"][$index]);
            }
        }

        Util::storeConfig("content/configs/pages.json", $pages);
    }

    function show404(App &$app) {
        $app->addAsset("/plugins/DefaultTheme/theme.css", AssetType::CSS);
        $app->content = $app->smarty->fetch("lib/templates/pages/404.tpl");
        http_response_code(404);
    }

    /**
     * Loads all custom assets from config/pages.json.
     */

    function loadCustomAssets(App &$app, $pages) {
        foreach ($pages["pages_all"]["css"] as $css) {
            $app->addAsset($css, AssetType::CSS);
        }

        foreach ($pages["pages_all"]["js"] as $js) {
            $app->addAsset($js, AssetType::JS);
        }
    }

    private function registerRoutePlugins(App &$app, Request $req, array $route, string $plugin_name) {
        PluginMan::loadGlobalPlugins($app, $req, $route);
        PluginMan::loadPlugin($app, $plugin_name, $req, $route);
    }
}
