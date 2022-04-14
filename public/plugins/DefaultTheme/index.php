<?php

class DefaultTheme {
    public $pluginInfo = [
        "name" => "DefaultTheme",
        "type" => \App\PluginType::THEME
    ];

    function init(\App\App &$app, \App\Request $req, array $opts = []) {
        // TODO: Add built-in method for getting plugin directory.
        $app->addCSS("/plugins/DefaultTheme/theme.css");
    }
}
