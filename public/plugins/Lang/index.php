<?php

class Lang {
    public $pluginInfo = [
        "name" => "SetLang",
        "type" => \App\PluginType::DEFAULT
    ];

    function init(\App\App &$app, \App\Request $req, array $opts = []) {
        if (\App\Util::issetAndTrue($opts["set-lang"])) {
            $this->setLang($app);
        }
    }

    private function setLang(\App\App &$app) {
        $app->lang->setLang($_GET["lang"] ?? "en");
        $app->redirect($_GET["prev"] ?? "/");
        exit();
    }
}
