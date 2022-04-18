<?php

class Lang extends \App\Plugin {
    public $pluginInfo = [
        "name" => "Lang",
        "description" => "Language plugin",
        "type" => \App\PluginType::DEFAULT
    ];

    function init(\App\App &$app, \App\Request $req, array $opts = []) {
        if (\App\Util::issetAndTrue($opts["set-lang"] ?? null)) {
            $this->setLang($app);
        }
    }

    public function getLang(\App\App &$app): string {
        return $app->lang->getLang();
    }

    private function setLang(\App\App &$app) {
        $app->lang->setLang(\App\Util::getReqAttr($_GET, "lang") ?? "en");
        $app->redirect(\App\Util::getReqAttr($_GET, "prev") ?? "/");
        exit();
    }
}
