<?php

class DisqusComments {
    public string $user_id = "";

    function __construct(\App\App &$app, $res, $opts) {
        $this->user_id = \App\App::loadJSON(__DIR__ . "/config.json")["user_id"];
        return $app->smarty->fetch(__DIR__ . "/disqus_comments.tpl", ["user_id" => $this->user_id]);
    }
}
