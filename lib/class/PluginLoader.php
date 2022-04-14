<?php

namespace App;

class PluginLoader {
    public static $plugin_dir = "public/plugins";

    static function loadPlugin(\App\App &$app, string $plugin, $res = [], array $opts = []) {
        require_once(self::$plugin_dir . "/${plugin}/index.php");
        return (new $plugin)->init($app, $res, $opts);
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
