<?php

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

    function loadRoutes(App $app, Router $router) {
        foreach ($this->nav_items as $item) {
            $router->add($item["url"], "get", function($res) use(&$app, $item) {
                require_once("content/plugins/" . $item["plugin"] . "/index.php");
                $instance = new $item["plugin"]();
                $instance->init($res, $app, $item);
            });
        }
    }

    function loadPages() {
        $pages = App::loadJSON("content/configs/pages.json");
        $this->nav_items = array_map(fn($x) => array_merge($this->page_default, $x), $pages["pages"]);
    }

    function getNav($smarty): string {
        return $smarty->fetch("lib/templates/partials/nav.tpl", [
            "nav_items" => array_filter($this->nav_items, fn($x) => $x["visible"])
        ]);
    }
}
