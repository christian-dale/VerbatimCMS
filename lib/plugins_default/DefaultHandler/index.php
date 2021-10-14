<?php

class DefaultHandler {
    function init($res, &$app, $opts) {
        $app->title = $opts["title"];
        $app->content = $app->smarty->fetch($opts["path"]);
    }
}
