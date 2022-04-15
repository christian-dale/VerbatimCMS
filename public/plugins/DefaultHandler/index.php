<?php

class DefaultHandler {
    public $pluginInfo = [
        "name" => "DefaultHandler",
        "description" => "Default plugin for pages with no other plugin.",
        "type" => \App\PluginType::DEFAULT,
        "version" => "1.0.0"
    ];

    function init(\App\App &$app, \App\Request $req, array $opts = []) {
        if (isset($opts["additional_template"]) && $this->templateExists($opts["additional_template"])) {
            $app->smarty->assign("additional_template", $app->smarty->fetch($opts["additional_template"]));
        }

        $app->title = $opts["title"];
        $app->content = $app->smarty->fetch($opts["path"]);
    }

    private function templateExists(?string $file): bool {
        return file_exists($file);
    }
}
