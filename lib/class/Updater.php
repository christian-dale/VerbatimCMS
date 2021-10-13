<?php

namespace App;

require_once("lib/class/App.php");

class Updater {
    public static $config_config = [];
    public static $config_pages = [];

    public static $config_config_path = "content/configs/config.json";
    public static $config_pages_path = "content/configs/pages.json";
    public static $default_config_path = "lib/configs_default/config.json";
    public static $default_config_pages_path = "lib/configs_default/pages.json";

    public static function update() {
        self::loadConfigs();

        // Check if configs have been updated.
        if (!self::$config_config["updated"]) {
            self::$config_config["updated"] = true;
            self::updateConfigs();
        }
    }

    private static function loadConfigs() {
        self::$config_config = \App\App::loadJSON(self::$default_config_path);
        self::$config_pages = \App\App::loadJSON(self::$default_config_pages_path);
    }

    private static function updateConfigs() {
        $content_config = \App\App::loadJSON(self::$config_config_path);
        $content_pages = \App\App::loadJSON(self::$config_pages_path);

        // Add any new config properties to content configs.
        $updated_config = array_merge(self::$config_config, $content_config);
        $updated_config_pages = array_merge(self::$config_pages, $content_pages);

        self::storeConfig(self::$config_config_path, $updated_config);
        self::storeConfig(self::$config_pages_path, $updated_config_pages);
    }

    private static function storeConfig($path, $config) {
        file_put_contents($path, json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }
}
