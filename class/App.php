<?php

class App {
    public $smarty = null;
    public $lang = null;
    public $fsdb = null;
    public $title = "";
    public $description = "";
    public $content = "";

    function __construct(Smarty $smarty, Lang $lang, FSDB $fsdb = null) {
        $this->smarty = $smarty;
        $this->lang = $lang;
        $this->fsdb = $fsdb;
    }

    function render() {
        $this->smarty->assign("lang", $this->lang);
        $this->smarty->assign("title", $this->title);
        $this->smarty->assign("description", $this->description);
        $this->smarty->assign("content", $this->content);
        return $this->smarty->fetch("templates/main.tpl");
    }

    function prettyPrint($i, $r = false) {
        $str = "<pre>" . print_r($i, true) . "</pre>";

        if ($r) {
            return $str;
        }

        echo $str;
    }
}
