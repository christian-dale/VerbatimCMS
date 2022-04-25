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
        $config = Util::loadJSON("content/configs/users.json");

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

        App::redirect("/");
    }

    static function registerRoutes(App &$app, Router &$router) {
        $config = Util::loadJSON("content/configs/users.json");

        if (!$config["enabled"]) {
            return;
        }

        $first_user = self::registerUser();

        $router->add("/login", "get", function($req) use(&$app, $first_user) {
            $app->addAsset("/assets/styles/kernel.css", \App\Assettype::CSS);

            if (Util::getReqAttr($_GET, "logout")) {
                self::logout();
            }

            $app->title = "Login";
            $app->content = $app->smarty->fetch("lib/templates/pages/login.tpl", [
                "first_user" => $first_user
            ]);

            PluginMan::loadGlobalPlugins($app, $req);
        });

        $router->add("/login", "post", function($req) use(&$app, $config) {
            $username = Util::getReqAttr($_POST, "username");
            $password = Util::getReqAttr($_POST, "password");

            self::auth($username, $password);

            App::redirect(PluginMan::pluginExists("Compositor") ? "/compositor" : "/");
        });
    }

    private static function registerUser(string $username = null, string $password = null) {
        if ($username == null) {
            $config = Util::loadJSON("content/configs/users.json");

            $username = uniqid("user_");
            $password = uniqid("", true);

            if (empty($config["users"])) {
                $config["users"][] = [
                    "username" => $username,
                    "password" => password_hash($password, PASSWORD_DEFAULT)
                ];

                Util::storeConfig("content/configs/users.json", $config);

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
