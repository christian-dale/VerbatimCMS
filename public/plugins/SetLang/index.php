<?php

class SetLang {
    public $pluginInfo = [
        "name" => "SetLang",
        "type" => \App\PluginType::DEFAULT
    ];

    function init(\App\App &$app, \App\Request $req, array $opts = []) {
        $app->lang->setLang($_GET["lang"]);
        echo $app->lang->getLang();
        exit();
    }
}
