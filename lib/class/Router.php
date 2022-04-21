<?php

namespace App;

class Request {
    public string $path = "/";
    public array $params = [];
    public string $method = "get";

    public static function request($url) {
        $c = curl_init();
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
        curl_setopt($c, CURLOPT_URL, $url);
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($c, CURLOPT_USERAGENT, "VerbatimCMS");

        $content = curl_exec($c);
        curl_close($c);

        return $content;
    }
}

class Response {
    
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

            if ($res && $_SERVER["REQUEST_METHOD"] == $route["method"]) {
                $req = new \App\Request();
                $req->path = $_SERVER["REQUEST_URI"];
                $req->method = $route["method"];

                // If this is a route parameter.
                if (count($match) > 1) {
                    $req->params["id"] = $match[1];
                    call_user_func_array($route["fn"], [$req]);
                } else {
                    call_user_func_array($route["fn"], [$req]);
                }

                return true;
            }
        }

        return false;
    }
}
