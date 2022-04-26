<?php

class SetLang {
    function init(\VerbatimCMS\App &$app, \VerbatimCMS\Request $req, array $opts = []) {
        $app->lang->setLang($_GET["lang"]);
        echo $app->lang->getLang();
        exit();
    }
}
