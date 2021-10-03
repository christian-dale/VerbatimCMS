<?php

class DefaultHandler {
    function __construct($res, &$app, $opts) {
        $app->title = $opts["title"];
        $app->content = $app->smarty->fetch($opts["path"]);
    }
}
