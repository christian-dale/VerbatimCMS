<?php

class DefaultHandler {
    function __construct(\App\App &$app, $res, array $opts = []) {
        if ($this->templateExists($opts["additional_template"])) {
            $app->smarty->assign("additional_template", $app->smarty->fetch($opts["additional_template"]));
        }

        $app->title = $opts["title"];
        $app->content = $app->smarty->fetch($opts["path"]);
    }

    private function templateExists(?string $file): bool {
        return file_exists($file);
    }
}
