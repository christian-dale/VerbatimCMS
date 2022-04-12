<?php

namespace App;

class PluginLoader {
    static function loadPlugin(\App\App &$app, string $plugin, $res = [], array $opts = []) {
        $path = "content/plugins/${plugin}/index.php";

        if (file_exists($path)) {
            require_once($path);
            $instance = new $plugin();
            return $instance->init($app, $res, $opts);
        }
    }

    /**
     * Get the directory of the plugin by name.
     * Loads plugin from content, or plugins_default if not found.
     */

    static function getPluginDirectory(string $plugin_name): string {
        $plugin_path_content = "content/plugins/${plugin_name}/index.php";
        $plugin_path_lib = "lib/plugins_default/${plugin_name}/index.php";

        if (file_exists($plugin_path_content)) {
            return $plugin_path_content;
        } else if (file_exists($plugin_path_lib)) {
            return $plugin_path_lib;
        } else {
            return "lib/plugins_default/DefaultHandler/index.php";
        }
    }
}
