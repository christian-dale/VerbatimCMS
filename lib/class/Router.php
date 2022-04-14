<?php

namespace App;

class Response {
    public $params = [];
}

class Router {
    public static $routes = [];
    public $parsed_url = null;

    function __construct() {
        // The path requested by the client.
        $this->parsed_url = parse_url($_SERVER["REQUEST_URI"]);
    }

    function add($path, $method, $fn) {
        self::$routes[] = [
            "path" => $path,
            "method" => strtoupper($method),
            "fn" => $fn
        ];
    }

    function begin(): bool {
        foreach (self::$routes as $route) {
            $res = preg_match("#^{$route["path"]}$#", $this->parsed_url["path"], $match);

            if ($res) {
                $response = new \App\Response();

                // If this is a route parameter.
                if (count($match) > 1) {
                    $response->params["id"] = $match[1];
                    call_user_func_array($route["fn"], [$response]);
                } else {
                    call_user_func_array($route["fn"], [$response]);
                }

                return true;
            }
        }

        return false;
    }
}
