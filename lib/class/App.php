<?php

namespace VerbatimCMS;

require_once("vendor/autoload.php");
require_once("lib/class/Util.php");
require_once("lib/class/Lang.php");
require_once("lib/class/Item.php");
require_once("lib/class/PluginMan.php");
require_once("lib/class/MediaLoader.php");
require_once("lib/class/Authenticator.php");
require_once("lib/class/Router.php");
require_once("lib/class/PageMan.php");
require_once("lib/class/Updater.php");

enum AssetType: string {
    case CSS = "CSS";
    case JS = "JS";
}

class App {
    public string $version = "1.0.0";
    public string $title = "";
    public string $appname = "";
    public string $description = "";
    public string $content = "";
    public array $config = [];
    public array $assets = [];
    public array $custom_meta = [];

    public \Smarty $smarty;
	public Lang $lang;
    public PageMan $pageman;
    public PluginMan $pluginman;
    public Router $router;
    public Updater $updater;

    public static $instance = null;

    function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (self::$instance == null) {
            self::$instance = $this;
        }

        $this->loadConfig();

		$this->smarty = new \Smarty();
        $this->smarty->setCompileDir("lib/templates_cache");

        $this->lang = new Lang($_SESSION["lang"] ?? "en");
        $this->updater = new Updater();
        $this->router = new Router();

        $this->pluginman = new PluginMan();
        // Create initial configs for plugins.
        $this->pluginman->initPlugins($this);

        $this->pageman = new PageMan();
        $this->pageman->loadPages($this);
        $this->pageman->loadRoutes($this, $this->router);

        // Some variables needs to be assigned before template is fetched
        // and some need to be loaded after.
        $this->assign($this->pageman);

        if (!$this->router->begin()) {
            $this->pageman->show404($this);
        }

        $this->assign($this->pageman);

        if (App::pluginExists("Compositor") && App::getPlugin("Compositor")->loadConfig()["setup"] &&
            parse_url($_SERVER["REQUEST_URI"])["path"] != "/compositor/setup") {
            Response::redirect("/compositor/setup");
        }
    }

    function loadConfig() {
        $this->config = Util::loadJSON("content/configs/config.json");
        $this->title = $this->config["title"];
        $this->appname = $this->title;
        $this->description = $this->config["description"];
    }

    /**
     * Gets config attribute from the config.json file.
     */

     function getConfigAttr($attr) {
        return $this->config[$attr] ?? null;
    }

    function assign(PageMan $pageman) {
        $this->smarty->assign("app", $this);

        $this->smarty->assign([
            "lang" => $this->lang,
            "title" => $this->title,
            "description" => $this->description,
            "content" => $this->content
        ]);

        if ($this->pluginman->pluginExists("DefaultHandler")) {
            $this->smarty->assign([
                "nav" => $this->pluginDefault()->getNav(),
                "footer" => $this->pluginDefault()->getFooter($this)
            ]);
        } else {
            $this->smarty->assign([
                "nav" => "",
                "footer" => ""
            ]);
        }
    }

    function render() {
        $this->addAsset("/plugins/Compositor/custom.css", AssetType::CSS);
        $this->addAsset("/plugins/Compositor/custom.js", AssetType::JS);

        return $this->smarty->fetch("lib/templates/main.tpl", [
            "assets" => $this->assets
        ]);
    }

    public function pluginDefault() {
        return $this->pluginman->getPlugin($this, "DefaultHandler");
    }

    public function getPlugin(string $plugin_name) {
        return $this->pluginman->getPlugin($this, $plugin_name);
    }

    public function pluginExists(string $plugin_name) {
        return PluginMan::pluginExists($plugin_name);
    }

    public function getTitle() {
        return $this->title;
    }

    function addAsset(string $path, AssetType $type) {
        $this->assets[] = [
            "type" => $type,
            "path" => $path
        ];
    }

    function addMeta(string $name, string $content) {
        $this->custom_meta[] = ["name" => $name, "content" => $content];
    }
}
