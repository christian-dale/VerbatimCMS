<?php

class App {
    public $smarty = null;
    public $lang = null;
    public $title = "";
    public $appname = "";
    public $config = [];
    public $description = "";
    public $content = "";

    function __construct(Smarty $smarty, Lang $lang) {
        $this->smarty = $smarty;
        $this->lang = $lang;
    }

    function loadConfig() {
        $config_file = file_get_contents("configs/config.json");
        $this->config = json_decode($config_file, true);
        $this->title = $this->config["title"];
        $this->appname = $this->title;
        $this->description = $this->config["description"];
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
