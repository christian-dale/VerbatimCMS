<?php

class App {
    public $smarty = null;
    public $lang = null;
    public $title = "";
    public $appname = "";
    public $config = [];
    public $description = "";
    public $content = "";
    public $css_paths = [];

    function __construct(Smarty $smarty, Lang $lang) {
        $this->smarty = $smarty;
        $this->lang = $lang;
    }

    function loadPlugin(&$app, string $plugin) {
        require_once("plugins/${plugin}/index.php");
        $instance = new $plugin($app);
        return $instance->init($app);
    }

    public static function loadJSON(string $path): array {
        $file = file_get_contents($path);
        return json_decode($file, true);
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

        return $this->smarty->fetch("templates/main.tpl", [
            "css_paths" => $this->css_paths
        ]);
    }

    function prettyPrint($text, $ret = false) {
        return "<pre>" . print_r($text, $ret) . "</pre>";
    }

    function addCSS(string $path) {
        $this->css_paths[] = $path;
    }
}
