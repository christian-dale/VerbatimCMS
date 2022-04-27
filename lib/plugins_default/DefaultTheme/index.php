<?php

class DefaultTheme extends \VerbatimCMS\Plugin {
    public $pluginInfo = [
        "name" => "DefaultTheme",
        "description" => "The default theme for VerbatimCMS",
        "type" => \VerbatimCMS\PluginType::THEME,
        "version" => "1.0.0"
    ];

    function init(\VerbatimCMS\App &$app, \VerbatimCMS\Request $req, array $opts = []) {
        // TODO: Add built-in method for getting plugin directory.
        $app->addAsset("/assets/styles/normalize.css", \VerbatimCMS\AssetType::CSS);
        $app->addAsset("/plugins/DefaultTheme/theme.css", \VerbatimCMS\AssetType::CSS);
    }
}
