<?php

namespace App;

class PluginLoader {
    public static $plugin_dir = "public/plugins";

    /**
     * App - Reference to the app object.
     * Plugin - The name of the plugin to be loaded.
     * res - The request object.
     */
    static function loadPlugin(\App\App &$app, string $plugin, \App\Request $req = new \App\Request(), array $opts = []) {
        require_once(self::$plugin_dir . "/${plugin}/index.php");
        return (new $plugin)->init($app, $req, $opts);
    }

    /**
     * Get the directory of the plugin by name.
     */

    static function getPluginDirectory(string $plugin_name): string {
        return self::$plugin_dir . "/${plugin_name}/index.php";
    }

    static function getPluginsList(): array {
        return array_map(fn($x) => ["name" => basename($x)], glob(self::$plugin_dir . "/*"));
    }
}
