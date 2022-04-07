<?php

class DisqusComments {
    public string $user_id = "";

    function init(&$app) {
        $this->user_id = \App\App::loadJSON(__DIR__ . "/config.json")["user_id"];
        return $app->smarty->fetch(__DIR__ . "/disqus_comments.tpl", ["user_id" => $this->user_id]);
    }
}
