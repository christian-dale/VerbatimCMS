<?php

namespace App;

enum PluginType {
    case DEFAULT;
    case THEME;
}

class PluginLoader {
    public static $plugin_dir = "public/plugins";

    /**
     * App - Reference to the app object.
     * Plugin - The name of the plugin to be loaded.
     * res - The request object.
     */
    static function loadPlugin(\App\App &$app, string $plugin_name, \App\Request $req = new \App\Request(), array $opts = []) {
        require_once(self::getPluginDirectory($plugin_name));

        $plugin = new $plugin_name();

        return $plugin->init($app, $req, $opts);
    }

    static function loadGlobalPlugins(\App\App &$app, \App\Request $req = new \App\Request(), array $opts = []) {
        $pages = \App\App::loadJSON("content/configs/pages.json");
        
        foreach ($pages["pages_all"]["plugins"] as $plugin_name) {
            require_once(self::getPluginDirectory($plugin_name));
            (new $plugin_name)->init($app, $req, $opts);
        }
    }

    static function getPlugin(\App\App &$app, string $plugin_name) {
        require_once(self::getPluginDirectory($plugin_name));
        return new $plugin_name($app, new \App\Request(), );
    }

    /**
     * Get the directory of the plugin by name.
     */

    static function getPluginDirectory(string $plugin_name): string {
        return self::$plugin_dir . "/${plugin_name}/index.php";
    }

    static function pluginExists(string $plugin_name): bool {
        return file_exists(self::getPluginDirectory($plugin_name));
    }

    /**
     * Get a list of all plugins with related info.
     */

     static function getPluginsList(): array {
        $plugin_names = array_map(fn($x) => basename($x), glob(self::$plugin_dir . "/*"));
        $plugins = [];

        foreach ($plugin_names as $plugin_name) {
            require_once(self::getPluginDirectory($plugin_name));
            $plugin = new $plugin_name();
            $plugins[] = $plugin->pluginInfo;
        }

        return $plugins;
    }
}
