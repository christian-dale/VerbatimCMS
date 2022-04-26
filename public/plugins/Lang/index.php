<?php

class Lang extends \VerbatimCMS\Plugin {
    public $pluginInfo = [
        "name" => "Lang",
        "description" => "Language plugin",
        "type" => \VerbatimCMS\PluginType::DEFAULT
    ];

    function init(\VerbatimCMS\App &$app, \VerbatimCMS\Request $req, array $opts = []) {
        if (\VerbatimCMS\Util::issetAndTrue($opts["set-lang"] ?? null)) {
            $this->setLang($app);
        }
    }

    public function getLang(\VerbatimCMS\App &$app): string {
        return $app->lang->getLang();
    }

    private function setLang(\VerbatimCMS\App &$app) {
        $app->lang->setLang(\VerbatimCMS\Util::getReqAttr($_GET, "lang") ?? "en");
        $app->redirect(\VerbatimCMS\Util::getReqAttr($_GET, "prev") ?? "/");
        exit();
    }
}
