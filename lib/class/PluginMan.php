<?php

namespace VerbatimCMS;

enum PluginType: string {
    case DEFAULT = "Default";
    case THEME = "Theme";
}

class Plugin {
    public $pluginInfo = [];
    public $routes = [];

    public function init(App &$app, Request $req, array $opts = []) {

    }

    public function createConfig(): array {
        return [
            "enabled" => true
        ];
    }

    public function loadConfig(): array {
        return Config::pluginLoad($this->pluginInfo["name"]);
    }

    public function storeConfig($config) {
        Config::pluginStore($this->pluginInfo["name"], $config);
    }
}

class PluginMan {
    public static $plugin_dir = "public/plugins";
    private static $plugin_default = ["enabled" => true];

    /**
     * App - Reference to the app object.
     * Plugin - The name of the plugin to be loaded.
     * res - The request object.
     */
    static function loadPlugin(App &$app, string $plugin_name, Request $req = new Request(), array $opts = []) {
        $plugin = self::getPlugin($app, $plugin_name);

        if ($plugin) {
            return $plugin->init($app, $req, $opts);
        }
    }

    static function loadGlobalPlugins(App &$app, Request $req = new Request(), array $opts = []) {
        $pages = Config::load("pages.json");

        foreach ($pages["pages_all"]["plugins"] as $plugin_name) {
            self::loadPlugin($app, $plugin_name, $req, $opts);
        }
    }

    static function getPlugin(App &$app, string $plugin_name, bool $check_enabled = false) {
        if (self::pluginEnabled($plugin_name) && self::pluginExists($plugin_name) || $check_enabled) {
            require_once(self::getPluginDirectory($plugin_name));
            return new $plugin_name($app, new Request());
        }

        return false;
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

    static function pluginEnabled(string $plugin_name) {
        return self::pluginExists($plugin_name) && self::loadPluginConfig($plugin_name)["enabled"];
    }

    /**
     * Get a list of all plugins with related info.
     */

     static function getPluginsList(): array {
        $plugin_names = array_map(fn($x) => basename($x), glob(self::$plugin_dir . "/*"));

        return array_map(fn($plugin_name) =>
            self::getPlugin(App::$instance, $plugin_name, true)->pluginInfo, $plugin_names);
    }

    /**
     * Create inital configs for plugins.
     */
    static function initPlugins(App &$app) {
        if (!is_dir("content/configs/plugins")) {
            mkdir("content/configs/plugins");
        }

        $plugin_names = array_map(fn($x) => basename($x), glob(self::$plugin_dir . "/*"));

        foreach ($plugin_names as $plugin_name) {
            if (!file_exists("content/configs/plugins/{$plugin_name}/config.json")) {
                mkdir("content/configs/plugins/{$plugin_name}");

                $plugin = self::getPlugin($app, $plugin_name);
                Config::pluginStore($plugin_name, array_merge(self::$plugin_default, $plugin->createConfig()));
            }
        }
    }

    static function loadPluginConfig(string $plugin_name) {
        return Config::pluginLoad($plugin_name);
    }
}
