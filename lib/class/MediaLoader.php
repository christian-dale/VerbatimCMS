<?php

namespace App;

class MediaLoader {
    public static string $media_directory = "public/assets/media";

    function __construct() {
        
    }

    public static function getMediaList(): array {
        $media = glob("public/assets/media/*");

        return array_map(fn($x) => basename($x), $media);
    }

    public static function getConfigFromID(string $id, string $attr = null) {
        foreach (\App\Util::loadJSON("content/configs/media.json")["media"] as $media) {
            if ($media["id"] == $id) {
                if ($attr) {
                    return $media[$attr];
                }

                return $media;
            }
        }
    }

    public static function storeMediaMeta($file, string $media_name) {
        $config = \App\Util::loadJSON("content/configs/media.json");
        $config["media"][] = [
            "id" => $media_name,
            "name" => $file["name"],
            "date" => time()
        ];
        \App\Util::storeConfig("content/configs/media.json", $config);
    }

    public static function storeMedia($file) {
        if (!file_exists(self::$media_directory)) {
            mkdir(self::$media_directory);
        }

        $media_name = uniqid() . "." . pathinfo($file["name"], PATHINFO_EXTENSION);
        move_uploaded_file($file["tmp_name"], self::$media_directory . "/" . $media_name);
        self::storeMediaMeta($file, $media_name);
    }
}
