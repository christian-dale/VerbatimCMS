<?php

class App {
    public $title = "";
    public $appname = "";
    public $config = [];
    public $description = "";
    public $content = "";
    public $css_paths = [];
    public $smarty = null;

    function __construct() {
        session_start();
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
        $this->config = $this->loadJSON("configs/config.json");
        $this->title = $this->config["title"];
        $this->appname = $this->title;
        $this->description = $this->config["description"];
    }

    function show404() {
        $this->content = $this->smarty->fetch("templates/pages/404.tpl");
        http_response_code(404);
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
