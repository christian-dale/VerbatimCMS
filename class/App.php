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

        session_start();
    }

    function loadConfig() {
        $config_file = file_get_contents("configs/config.json");
        $this->config = json_decode($config_file, true);
        $this->title = $this->config["title"];
        $this->appname = $this->title;
        $this->description = $this->config["description"];
    }

    function render() {
        $this->smarty->assign([
            "lang" => $this->lang,
            "title" => $this->title,
            "description" => $this->description,
            "content" => $this->content
        ]);

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
