<?php

require_once("class/App.php");
require_once("class/Router.php");

class PageLoader {
    public $nav_items = [];

    function __construct() {
            
    }

    function loadRoutes(App $app, Router $router) {
        foreach ($this->nav_items as $item) {
            $router->add($item["url"], "get", function() use(&$app, $item) {
                require_once("plugins/" . $item["plugin"] . "/index.php");
                $instance = new $item["plugin"]($app, $item);
            });
        }
    }

    function loadPages() {
        $json_file = file_get_contents("pages.json");
        $pages = json_decode($json_file, true);

        $this->nav_items = $pages["pages"];
    }

    function getNav($smarty): string {
        return $smarty->fetch("templates/partials/nav.tpl", ["nav_items" => $this->nav_items]);
    }
}