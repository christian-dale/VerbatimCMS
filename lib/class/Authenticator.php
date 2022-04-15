<?php

namespace App;

enum UserType: string {
    case GUEST = "User";
    case MOD = "Moderator";
}

class Authenticator {
    function __construct() {
        
    }

    static function auth(string $email, string $token) {
        $_SESSION["auth"] = true;
        $_SESSION["user"] = $email;

        \App\App::redirect("/");
    }

    static function logout() {
        unset($_SESSION["auth"]);
        unset($_SESSION["user"]);

        \App\App::redirect("/");
    }

    static function registerRoutes(\App\App &$app, \App\Router &$router) {
        $config = $config = \App\PluginLoader::loadPluginConfig("Authenticator");

        if (!$config["enabled"]) {
            return;
        }

        $router->add("/login", "get", function($req) use(&$app) {
            $app->addCSS("/assets/styles/kernel.css");

            if (\App\Util::getReqAttr($_GET, "logout")) {
                self::logout();
            }

            $app->title = "Login";
            $app->content = $app->smarty->fetch("lib/templates/pages/login.tpl");

            PluginLoader::loadGlobalPlugins($app, $req);
        });

        $router->add("/login", "post", function($req) use(&$app) {
            $app->addCSS("/assets/styles/kernel.css");

            $id = uniqid();
            // mail(\App\Util::getReqAttr($_POST, "email"), "VerbatimCMS Login", "Login to VerbatimCMS: " . $id);
        });

        $router->add("/login/(([a-zA-Z0-9]+))", "get", function($req) use(&$app, $config) {
            foreach ($config["users"] as $user) {
                $email = \App\Util::getReqAttr($_GET, "email");
                $token = $req->params["id"];

                if ($user["email"] == $email && $user["token"] == $token) {
                    \App\Authenticator::auth($email, $token);
                }
            }
        });
    }

    static function isLoggedIn() {
        return $_SESSION["auth"] == true;
    }

    static function getUser() {
        if (self::isLoggedIn()) {
            return $_SESSION["user"];
        }

        return false;
    }
}