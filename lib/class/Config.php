<?php

namespace VerbatimCMS;

class Config {
    public static $config_dir = "content/configs";

    public static function load(string $name) {
        return Util::loadJSON(self::$config_dir . "/{$name}");
    }

    public static function store(string $name, array $config) {
        Util::storeConfig(self::$config_dir . "/{$name}", $config);
    }

    public static function pluginLoad(string $plugin_name) {
        return self::load("plugins/{$plugin_name}/config.json");
    }

    public static function pluginStore(string $plugin_name, array $config) {
        self::store("plugins/{$plugin_name}/config.json", $config);
    }
}
