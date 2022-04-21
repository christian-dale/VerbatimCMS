<?php

class DisqusComments extends \App\Plugin {
    public $pluginInfo = [
        "name" => "DisqusComments",
        "description" => "Disqus comments plugin.",
        "type" => \App\PluginType::DEFAULT,
        "version" => "1.0.0"
    ];

    public string $user_id = "";

    function init(\App\App &$app, \App\Request $req = new \App\Request(), $opts = []) {
        $this->user_id = $app->config["user_id"];
        return $app->smarty->fetch(__DIR__ . "/disqus_comments.tpl", ["user_id" => $this->user_id]);
    }
}
