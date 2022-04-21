<?php

namespace App;

enum UserType: string {
    case GUEST = "User";
    case MOD = "Moderator";
}

class Authenticator {
    function __construct() {
        
    }

    static function auth(string $username, string $password) {
        $config = \App\Util::loadJSON("content/configs/plugins/Authenticator/config.json");

        foreach ($config["users"] as $user) {
            if ($user["username"] == $username && password_verify($password, $user["password"])) {
                $_SESSION["auth"] = true;
                $_SESSION["username"] = $username;
            }
        }
    }

    static function logout() {
        unset($_SESSION["auth"]);
        unset($_SESSION["username"]);

        \App\App::redirect("/");
    }

    static function registerRoutes(\App\App &$app, \App\Router &$router) {
        $config = $config = \App\PluginLoader::loadPluginConfig("Authenticator");

        if (!$config["enabled"]) {
            return;
        }

        $first_user = self::registerUser();

        $router->add("/login", "get", function($req) use(&$app, $first_user) {
            $app->addCSS("/assets/styles/kernel.css");

            if (\App\Util::getReqAttr($_GET, "logout")) {
                self::logout();
            }

            $app->title = "Login";
            $app->content = $app->smarty->fetch("lib/templates/pages/login.tpl", [
                "first_user" => $first_user
            ]);

            PluginLoader::loadGlobalPlugins($app, $req);
        });

        $router->add("/login", "post", function($req) use(&$app, $config) {
            $username = \App\Util::getReqAttr($_POST, "username");
            $password = \App\Util::getReqAttr($_POST, "password");

            self::auth($username, $password);

            \App\App::redirect(\App\PluginLoader::pluginExists("Compositor") ? "/compositor" : "/");
        });
    }

    private static function registerUser(string $username = null, string $password = null) {
        if ($username == null) {
            $config = \App\Util::loadJSON("content/configs/plugins/Authenticator/config.json");

            $username = uniqid("user_");
            $password = uniqid("", true);

            if (empty($config["users"])) {
                $config["users"][] = [
                    "username" => $username,
                    "password" => password_hash($password, PASSWORD_DEFAULT)
                ];

                \App\Util::storeConfig("content/configs/plugins/Authenticator/config.json", $config);

                return [
                    "username" => $username,
                    "password" => $password
                ];
            }
        }
    }

    static function isLoggedIn() {
        return $_SESSION["auth"] == true;
    }

    static function getUser() {
        if (self::isLoggedIn()) {
            return $_SESSION["username"];
        }

        return false;
    }
}
