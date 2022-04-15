<?php

class DefaultTheme {
    public $pluginInfo = [
        "name" => "DefaultTheme",
        "description" => "The default theme for VerbatimCMS",
        "type" => \App\PluginType::THEME,
        "version" => "1.0.0"
    ];

    function init(\App\App &$app, \App\Request $req, array $opts = []) {
        // TODO: Add built-in method for getting plugin directory.
        $app->addCSS("/asset/styles/normalize.css");
        $app->addCSS("/plugins/DefaultTheme/theme.css");
    }
}
