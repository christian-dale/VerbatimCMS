<?php

class DisqusComments extends \VerbatimCMS\Plugin {
    public $pluginInfo = [
        "name" => "DisqusComments",
        "description" => "Disqus comments plugin.",
        "type" => \VerbatimCMS\PluginType::DEFAULT,
        "version" => "1.0.0"
    ];

    public string $user_id = "";

    function init(\VerbatimCMS\App &$app, \VerbatimCMS\Request $req = new \VerbatimCMS\Request(), $opts = []) {
        $this->user_id = $app->config["user_id"];
        return $app->smarty->fetch(__DIR__ . "/disqus_comments.tpl", ["user_id" => $this->user_id]);
    }
}
