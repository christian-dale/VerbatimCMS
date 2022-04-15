<?php

namespace App;

require_once("vendor/autoload.php");
require_once("lib/class/Util.php");
require_once("lib/class/Lang.php");
require_once("lib/class/Item.php");
require_once("lib/class/PluginLoader.php");
require_once("lib/class/Router.php");
require_once("lib/class/PageLoader.php");
require_once("lib/class/Updater.php");

class App {
    public string $version = "1.0.0";
    public string $title = "";
    public string $appname = "";
    public string $description = "";
    public string $content = "";
    public array $config = [];
    public array $css_paths = [];
    public array $js_paths = [];
    public array $custom_meta = [];

    public $smarty = null;
	public $lang = null;
    public $page_loader = null;
    public $plugin_loader = null;

    function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

		$this->smarty = new \Smarty();
        $this->smarty->setCompileDir("lib/templates_cache");

        $this->lang = new \App\Lang($_SESSION["lang"] ?? "en");

        $this->loadConfig();

        // \App\Updater::update();

        $router = new \App\Router();

        $this->page_loader = new \App\PageLoader();
        $this->page_loader->loadPages($this);
        $this->page_loader->loadRoutes($this, $router);

        $this->plugin_loader = new \App\PluginLoader();

        // Some variables needs to be assigned before template is fetched
        // and some need to be loaded after.
        $this->assign($this->page_loader);

        if (!$router->begin()) {
            $this->show404();
        }

        $this->assign($this->page_loader);
    }

    public static function loadJSON(string $path): array {
        $file = file_get_contents($path);
        return json_decode($file, true);
    }

    function loadConfig() {
        $this->config = $this->loadJSON("content/configs/config.json");
        $this->title = $this->config["title"];
        $this->appname = $this->title;
        $this->description = $this->config["description"];
    }

    function getConfigAttr($attr) {
        return $this->config[$attr] ?? null;
    }

    function show404() {
        $this->addCSS("/plugins/DefaultTheme/theme.css");
        $this->content = $this->smarty->fetch("lib/templates/pages/404.tpl");
        http_response_code(404);
    }

    function assign(PageLoader $page_loader) {
        $this->smarty->assign("app", $this);

        $this->smarty->assign([
            "nav" => $page_loader->getNav($this->lang, $this->smarty),
            "footer" => $page_loader->getFooter($this->smarty),
            "lang" => $this->lang,
            "title" => $this->title,
            "description" => $this->description,
            "content" => $this->content
        ]);
    }

    function render() {
        return $this->smarty->fetch("lib/templates/main.tpl", [
            "css_paths" => $this->css_paths,
            "js_paths" => $this->js_paths
        ]);
    }

    public function getPlugin(string $plugin_name) {
        return $this->plugin_loader->getPlugin($this, $plugin_name);
    }

    public function pluginExists(string $plugin_name) {
        return \App\PluginLoader::pluginExists($plugin_name);
    }

    public function getTitle() {
        return $this->title;
    }

    /**
     * Redirect to url.
     */
    public static function redirect($url) {
        header("Location: {$url}");
    }

    public static function prettyPrint($text) {
        return "<pre>" . print_r($text, true) . "</pre>";
    }

    function addCSS(string $path) {
        $this->css_paths[] = $path;
    }

    function addJS(string $path) {
        $this->js_paths[] = $path;
    }

    function addMeta(string $name, string $content) {
        $this->custom_meta[] = ["name" => $name, "content" => $content];
    }
}
