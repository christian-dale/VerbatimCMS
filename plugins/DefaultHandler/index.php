<?php

class DefaultHandler {
    function __construct(&$app, $opts) {
        $app->title = $item["title"];
        $app->content = $app->smarty->fetch($opts["path"]);
    }
}