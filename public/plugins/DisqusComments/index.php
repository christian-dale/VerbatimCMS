<?php

class DisqusComments {
    public $pluginInfo = [
        "name" => "DisqusComments",
        "type" => \App\PluginType::DEFAULT,
        "version" => "1.0.0"
    ];

    public string $user_id = "";

    function init(\App\App &$app, \App\Request $req, $opts) {
        $this->user_id = $app->config["user_id"];
        return $app->smarty->fetch(__DIR__ . "/disqus_comments.tpl", ["user_id" => $this->user_id]);
    }
}
