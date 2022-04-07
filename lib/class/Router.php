<?php

namespace App;

class Router {
    public static $routes = [];
    public $res = [];

    function __construct() {
        $this->res = (object) [];
    }

    function add($path, $method, $fn) {
        self::$routes[] = ["path" => $path, "method" => strtoupper($method), "fn" => $fn];
    }

    function begin(): bool {
        $parsed = parse_url($_SERVER["REQUEST_URI"]);

        foreach (self::$routes as $route) {
            if (preg_match("@/+[a-z0-9-_]+/+([a-z0-9-_]+)@", $parsed["path"], $val) && preg_match("@{(.*?)}@", $route["path"], $selector)) {
                preg_match("@/+[a-z0-9-_]+@", $parsed["path"], $match);

                if (strpos($match[0], $route["path"]) != -1) {
                    if ($route["method"] == $_SERVER["REQUEST_METHOD"]) {
                        $this->res->attr = [$selector[1] => $val[1]];
                        call_user_func_array($route["fn"], [$this->res]);  
                        return true;                      
                    }
                }
            } else {
                if ($route["path"] == $parsed["path"]) {
                    if ($route["method"] == $_SERVER["REQUEST_METHOD"]) {
                        call_user_func_array($route["fn"], [$this->res]);
                        return true;
                    }
                }
            }
        }

        return false;
    }
}
