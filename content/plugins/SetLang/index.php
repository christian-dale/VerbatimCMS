<?php

class SetLang {
    function init(\App\App &$app, $res, array $opts = []) {
        $app->lang->setLang($_GET["lang"]);
        echo $app->lang->getLang();
        exit();
    }
}
