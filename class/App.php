<?php

require_once("vendor/autoload.php");
require_once("class/Lang.php");
require_once("class/PageLoader.php");

class App {
    public string $title = "";
    public string $appname = "";
    public string $description = "";
    public string $content = "";
    public array $config = [];
    public array $css_paths = [];

    public $smarty = null;
	public $lang = null;

    function __construct() {
        session_start();

		$this->smarty = new Smarty();
		$this->lang = new Lang($_SESSION["lang"]);
    }

    function loadPlugin(&$app, string $plugin) {
        $path = "plugins/${plugin}/index.php";

        if (file_exists($path)) {
            require_once($path);
            $instance = new $plugin($app);
            return $instance->init($app);
        }
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

    function assign(PageLoader $page_loader) {
        $this->smarty->assign("app", $this);

        $this->smarty->assign([
            "nav" => $page_loader->getNav($this->smarty),
            "lang" => $this->lang,
            "title" => $this->title,
            "description" => $this->description
        ]);
    }

    function render() {
        $this->smarty->assign("content", $this->content);

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
