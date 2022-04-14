<?php

namespace App;

class PluginLoader {
    static function loadPlugin(\App\App &$app, string $plugin, $res = [], array $opts = []) {
        $path = "public/plugins/${plugin}/index.php";

        if (file_exists($path)) {
            require_once($path);
            $instance = new $plugin();
            return $instance->init($app, $res, $opts);
        }
    }

    /**
     * Get the directory of the plugin by name.
     */

    static function getPluginDirectory(string $plugin_name): string {
        return "public/plugins/${plugin_name}/index.php";
    }

    static function getPluginsList(): array {
        $plugins = [];

        foreach (glob("public/plugins/*", GLOB_ONLYDIR) as $dir) {
            $plugins[] = ["name" => basename($dir)];
        }

        return $plugins;
    }
}
