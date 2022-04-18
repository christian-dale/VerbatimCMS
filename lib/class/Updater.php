<?php

namespace App;

class Updater {
    private $config_path = "lib/configs/verbatimcms.json";
    private $config = [];

    function __construct() {
        $this->config = \App\Util::loadJSON($this->config_path);
        $release = $this->releaseAvailable();

        if ($release) {
            $this->update($release);
        }
    }

    public function releaseAvailable() {
        if (time() - $this->config["lastUpdateCheck"] > 86400 || true) {
            $res = \App\Request::request("https://api.github.com/repos/christian-dale/VerbatimCMS/releases/latest");

            $this->config["lastUpdateCheck"] = time();
            \App\Util::storeConfig($this->config_path, $this->config);

            $latest_release = json_decode($res, true);

            if ($latest_release->name != $this->config["version"]) {
                return $latest_release;
            }
        }

        return false;
    }

    public static function update($release) {
        // file_put_contents("lib/update.zip", file_get_contents($release["assets"][0]["browser_download_url"]));
        $zip = new \ZipArchive();
        $zip->open("lib/update.zip");
        $zip->extractTo("lib/update");
        $zip->close();
    }

    private static function loadConfigs() {

    }

    private static function updateConfigs() {

    }
}
