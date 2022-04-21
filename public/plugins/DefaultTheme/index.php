<?php

class DefaultTheme extends \App\Plugin {
    public $pluginInfo = [
        "name" => "DefaultTheme",
        "description" => "The default theme for VerbatimCMS",
        "type" => \App\PluginType::THEME,
        "version" => "1.0.0"
    ];

    function init(\App\App &$app, \App\Request $req, array $opts = []) {
        // TODO: Add built-in method for getting plugin directory.
        $app->addCSS("/assets/styles/normalize.css");
        $app->addCSS("/plugins/DefaultTheme/theme.css");
    }
}
