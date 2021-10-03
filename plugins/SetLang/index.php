<?php

class SetLang {
    function __construct($res, &$app, $opts) {
        $app->lang->setLang($_GET["lang"]);
        exit();
    }
}
