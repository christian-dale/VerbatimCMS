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
        $app->addAsset("/assets/styles/normalize.css", \App\AssetType::CSS);
        $app->addAsset("/plugins/DefaultTheme/theme.css", \App\AssetType::CSS);
    }
}
