<?php

class SetLang {
    function init($res, &$app, $opts) {
        $app->lang->setLang($_GET["lang"]);
        exit();
    }
}
