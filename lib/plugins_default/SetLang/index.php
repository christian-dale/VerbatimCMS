<?php

class SetLang {
    function __construct(\App\App &$app, $res, array $opts = []) {
        $app->lang->setLang($_GET["lang"]);
        exit();
    }
}
