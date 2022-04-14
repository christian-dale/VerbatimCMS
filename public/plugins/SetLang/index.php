<?php

class SetLang {
    function init(\App\App &$app, \App\Request $req, array $opts = []) {
        $app->lang->setLang($_GET["lang"]);
        echo $app->lang->getLang();
        exit();
    }
}
