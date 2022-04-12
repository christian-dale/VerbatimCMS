<?php

class DefaultHandler {
    function __construct(\App\App &$app, $res, array $opts = []) {
        $app->title = $opts["title"];
        $app->content = $app->smarty->fetch($opts["path"]);
    }
}
