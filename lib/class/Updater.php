<?php

namespace VerbatimCMS;

class Updater {
    private $config_path = "lib/configs/verbatimcms.json";
    private $config = [];

    function __construct() {
        $this->config = Util::loadJSON($this->config_path);
        $release = $this->releaseAvailable();

        if ($release) {
            $this->update($release);
        }
    }

    public function releaseAvailable() {
        // Check for updates once a day.
        if (time() - $this->config["lastUpdateCheck"] > 86400) {
            $res = Request::request("https://api.github.com/repos/christian-dale/VerbatimCMS/releases/latest");

            $this->config["lastUpdateCheck"] = time();
            Util::storeConfig($this->config_path, $this->config);

            $latest_release = json_decode($res, true);

            if ($latest_release->name != $this->config["version"]) {
                return $latest_release;
            }
        }

        return false;
    }

    public static function update($release) {
        file_put_contents("lib/{$release["tag_name"]}", file_get_contents($release["assets"][0]["browser_download_url"]));
        $zip = new \ZipArchive();
        $zip->open("lib/VerbatimCMS-{$release["tag_name"]}");
        $zip->extractTo("lib/update");
        $zip->close();

        Util::copyRecursive("lib/update/lib", "./lib");
        Util::copyRecursive("lib/update/public", "./public");
        Util::copyRecursive("lib/update/vendor", "./vendor");
        self::updateConfigs($release);

        unlink("lib/{$release["tag_name"]}");
    }

    private static function loadConfigs() {

    }

    private static function updateConfigs($release) {
        // $config_old = \VerbatimCMS\Util::loadJSON("content/configs/config.json");
        // $config_new = \VerbatimCMS\Util::loadJSON("lib/update/content/configs/config.json");

        // \VerbatimCMS\Util::storeConfig("content/configs/config.json", array_merge($config_old, $config_new));

        // $media_old = \VerbatimCMS\Util::loadJSON("content/configs/media.json");
        // $media_new = \VerbatimCMS\Util::loadJSON("lib/update/content/configs/media.json");

        // \VerbatimCMS\Util::storeConfig("content/configs/media.json", array_merge($media_old, $media_new));

        // $pages_old = \VerbatimCMS\Util::loadJSON("content/configs/pages.json");
        // $pages_new = \VerbatimCMS\Util::loadJSON("lib/update/content/configs/pages.json");

        // \VerbatimCMS\Util::storeConfig("content/configs/pages.json", array_merge($pages_old, $pages_new));
    }
}
