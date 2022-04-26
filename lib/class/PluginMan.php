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
        return PluginMan::loadPluginConfig($this->pluginInfo["name"]);
    }

    public function storeConfig($config) {
        Util::storeConfig("content/configs/plugins/{$this->pluginInfo["name"]}/config.json", $config);
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
        require_once(self::getPluginDirectory($plugin_name));

        $plugin = new $plugin_name();

        return $plugin->init($app, $req, $opts);
    }

    static function loadGlobalPlugins(App &$app, Request $req = new Request(), array $opts = []) {
        $pages = Util::loadJSON("content/configs/pages.json");

        foreach ($pages["pages_all"]["plugins"] as $plugin_name) {
            require_once(self::getPluginDirectory($plugin_name));
            (new $plugin_name)->init($app, $req, $opts);
        }
    }

    static function getPlugin(App &$app, string $plugin_name) {
        require_once(self::getPluginDirectory($plugin_name));
        return new $plugin_name($app, new Request());
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
                $plugin = self::getPlugin($app, $plugin_name);
                $plugin_config = array_merge(self::$plugin_default, $plugin->createConfig());

                mkdir("content/configs/plugins/{$plugin_name}");
                Util::storeConfig("content/configs/plugins/{$plugin_name}/config.json", $plugin_config);
            }
        }
    }

    static function loadPluginConfig(string $plugin_name) {
        return Util::loadJSON("content/configs/plugins/{$plugin_name}/config.json");
    }
}
