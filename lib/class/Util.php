<?php

namespace App;

class Util {
    public static function issetAndTrue($var) {
        return isset($var) && $var == true;
    }

    public static function getReqAttr(array $method, string $attr) {
        return $method[$attr];
    }

    public static function filterInput($type, $var, $filter) {
        return filter_input($type, $var, $filter);
    }

    public static function loadJSON(string $path): array {
        $file = file_get_contents($path);
        return json_decode($file, true);
    }

    public static function storeConfig($path, $config) {
        file_put_contents($path, json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public static function prettyPrint($text) {
        return "<pre>" . print_r($text, true) . "</pre>";
    }

    static function copyRecursive($src, $dest) {
        $dir = opendir($src);
        @mkdir($dest);

        while (($file = readdir($dir))) {
            if ($file != "." && $file != "..") {
                if (is_dir("{$src}/{$file}")) {
                    self::copyRecursive("{$src}/{$file}", "{$dest}/{$file}");
                } else {
                    copy("{$src}/{$file}", "{$dest}/{$file}");
                }
            }
        }
    }
}
