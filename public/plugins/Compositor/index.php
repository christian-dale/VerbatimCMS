<?php

class Compositor extends \App\Plugin {
    public $pluginInfo = [
        "name" => "Compositor",
        "description" => "An editing system for VerbatimCMS.",
        "type" => \App\PluginType::DEFAULT,
        "version" => "1.0.0"
    ];

    public $routes = [
        ["path" => "/compositor", "method" => "get"],
        ["path" => "/compositor/setup", "method" => "get"],
        ["path" => "/compositor/setup", "method" => "post"],
        ["path" => "/compositor/media", "method" => "get", "state" => "PageMedia"],
        ["path" => "/compositor/media", "method" => "post"],
        ["path" => "/compositor/lang", "method" => "get"],
        ["path" => "/compositor/view-post/([a-zA-Z-]+)", "method" => "get", "state" => "ViewPost"],
        ["path" => "/compositor/create-post", "method" => "get", "state" => "CreatePost"],
        ["path" => "/compositor/save", "method" => "post"],
        ["path" => "/compositor/plugin/(.+)", "method" => "get", "state" => "ViewPlugin"],
        ["path" => "/compositor/plugin/(.+)", "method" => "post", "state" => "ViewPlugin"],
        ["path" => "/compositor/page", "method" => "get", "state" => "EditPage"],
        ["path" => "/compositor/page/(.+)", "method" => "get", "state" => "EditPage"],
        ["path" => "/compositor/edit-page", "method" => "post"],
        ["path" => "/compositor/page-delete/(.+)", "method" => "get", "state" => "PageDelete"],
        ["path" => "/compositor/custom", "method" => "post"],
        ["path" => "/compositor/settings", "method" => "get"]
    ];

    function init(\App\App &$app, \App\Request $req, array $opts = []) {
        $app->addCSS("/assets/styles/kernel.css");
        $app->addCSS("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css");

        if ($this->loadConfig()["setup"] == true && $req->path != "/compositor/setup") {
            \App\App::redirect("/compositor/setup");
        }

        if (!\App\Authenticator::isLoggedIn()) {
            \App\App::redirect("/login");
        }

        if ($req->path == "/compositor/save" && $req->method == "POST") {
            $post_name = \App\Util::getReqAttr($_POST, "post_name");
            $post_title = \App\Util::getReqAttr($_POST, "post_title");
            $post_date = \App\Util::getReqAttr($_POST, "post_date");
            $post_media = \App\Util::getReqAttr($_POST, "post_media");
            $post_create = \App\Util::getReqAttr($_POST, "post_create");

            $content = \App\Util::getReqAttr($_POST, "content");

            if ($post_create) {
                $app->getPlugin("BlogLux")->createPost($post_title, $content, [
                    "title" => $post_title,
                    "date" => $post_date,
                    "dateUpdate" => $post_date,
                    "lang" => "en",
                    "draft" => false,
                    "categories" => [],
                    "image" => "/assets/media/" . $post_media,
                    "attrib" => ""
                ]);
            } else {
                $app->getPlugin("BlogLux")->editPost($post_name, $content, [
                    "title" => $post_title,
                    "date" => $post_date,
                    "media" => $post_media
                ]);
            }

            \App\App::redirect("/compositor");
        } else if ($req->path == "/compositor/settings") {
            $app->content = $app->smarty->fetch(__DIR__ . "/setup.tpl", [
                "config" => \App\Util::loadJSON("content/configs/config.json"),
                "settings" => true
            ]);
        } else if ($req->path == "/compositor/custom" && $req->method == "POST") {
            $custom_css = \App\Util::getReqAttr($_POST, "custom_css");
            $custom_js = \App\Util::getReqAttr($_POST, "custom_js");

            file_put_contents("public/plugins/Compositor/custom.css", $custom_css);
            file_put_contents("public/plugins/Compositor/custom.js", $custom_js);

            \App\App::redirect("/compositor");
        } else if (strpos($req->path, "/compositor/page") != -1 && $opts["state"] == "EditPage") {
            if (empty($req->params)) {
                $app->content = $app->smarty->fetch(__DIR__ . "/edit_page.tpl", [
                    "page" => [
                        "name" => "New page",
                        "content" => ""
                    ],
                    "create_page" => true
                ]);
            } else {
                $app->content = $app->smarty->fetch(__DIR__ . "/edit_page.tpl", [
                    "page" => \App\PageLoader::getPageInfo($req->params["id"])
                ]);
            }
        } else if ($req->path == "/compositor/edit-page") {
            $page_name = \App\Util::getReqAttr($_POST, "name");
            $page_content = \App\Util::getReqAttr($_POST, "content");

            \App\PageLoader::editPage($page_name, $page_content);

            \App\App::redirect("/compositor");
        } else if (strpos($req->path, "/compositor/page-delete") != -1 && $opts["state"] == "PageDelete") {
            \App\PageLoader::deletePage($req->params["id"]);

            \App\App::redirect("/compositor");
        } else if ($req->path == "/compositor/media" && $req->method == "GET" && $opts["state"] == "PageMedia") {
            $app->content = $app->smarty->fetch(__DIR__ . "/media.tpl", [
                "media" => \App\MediaLoader::getMediaList()
            ]);
        } else if ($req->path == "/compositor/media" && $req->method == "POST") {
            $media = \App\Util::getReqAttr($_FILES, "media");

            if (!$media["error"]) {
                \App\MediaLoader::storeMedia($media);
                \App\App::redirect("/compositor/media");
            }
        } else if ($req->path == "/compositor/lang") {
            $lang_files = array_map(fn($x) => basename($x), glob("content/lang/*"));
            $lang = array_map(fn($x) => ["name" => $x, "lang" => \App\Util::loadJSON("content/lang/{$x}")], $lang_files);

            $app->content = $app->smarty->fetch(__DIR__ . "/lang.tpl", [
                "lang" => $lang
            ]);
        } else if ($req->path == "/compositor/setup" && $req->method == "GET") {
            $app->content = $app->smarty->fetch(__DIR__ . "/setup.tpl");  
        } else if ($req->path = "/compositor/setup" && $req->method == "POST") {
            \App\Util::storeConfig("content/configs/config.json", array_merge(
                \App\Util::loadJSON("content/configs/config.json"), [
                "title" => \App\Util::getReqAttr($_POST, "title"),
                "header_title" => \App\Util::getReqAttr($_POST, "header_title"),
                "description" => \App\Util::getReqAttr($_POST, "description"),
                "copyright" => \App\Util::getReqAttr($_POST, "copyright")
            ]));

            $config = $this->loadConfig();
            $config["setup"] = false;
            $this->storeConfig($config);

            \App\App::redirect("/compositor");
        } else if (strpos($req->path, "/compositor/plugin") != -1 && $req->method == "POST") {
            $plugin_name = $req->params["id"];
            $plugin_config = \App\Util::getReqAttr($_POST, "config");
            $plugin_enabled = \App\Util::getReqAttr($_POST, "enabled");
            $config = array_merge(json_decode($plugin_config, true), $this->loadConfig());
            $config["enabled"] = ($plugin_enabled == "on") ? true : false;
            $this->storeConfig($config);
            \App\App::redirect("/compositor/plugin/{$plugin_name}");
        } else if ($req->path = "/compositor/create-post" && $opts["state"] == "CreatePost") {
            $this->blogPostEdit($app, $req, true);
        } else {
            if (empty($req->params)) {
                $app->title = "Compositor";

                $page_loader = new \App\PageLoader();

                $app->content = $app->smarty->fetch(__DIR__ . "/editor.tpl", [
                    "posts" => \App\PluginLoader::loadPlugin($app, "BlogLux", new \App\Request, ["template" => true]),
                    "pages" => $page_loader->loadPages($app),
                    "plugins" => \App\PluginLoader::getPluginsList(),
                    "custom_css" => file_get_contents("public/plugins/Compositor/custom.css"),
                    "custom_js" => file_get_contents("public/plugins/Compositor/custom.jss")
                ]);
            } else if ($opts["state"] == "ViewPost"){
                $this->blogPostEdit($app, $req);
            } else if ($opts["state"] == "ViewPlugin") {
                $this->editPlugin($app, $req);
            }
        }
    }

    function createConfig(): array {
        return [
            "setup" => true
        ];
    }

    /**
     * Edit a particular blog post.
     */

    function blogPostEdit(\App\App &$app, \App\Request $req, bool $create_post = false) {
        require_once("public/plugins/BlogLux/Blog.php");

        if ($create_post) {
            $app->content = $app->smarty->fetch(__DIR__ . "/edit_post.tpl", [
                "post" => \Plugin\Blog::getEmptyPost(),
                "media" => \App\MediaLoader::getMediaList(),
                "create_post" => $create_post
            ]);
        } else {
            $blog = new \Plugin\Blog();

            $blog->loadPosts();
    
            $post = $blog->posts[$req->params["id"]];
    
            $app->title = $post->get("title");
            $app->description = substr(strip_tags($post->get("content")), 0, 150) . " ...";
    
            $app->content = $app->smarty->fetch(__DIR__ . "/edit_post.tpl", [
                "post" => $post,
                "media" => \App\MediaLoader::getMediaList()
            ]);
        }
    }

    /**
     * Edit a particular plugin.
     */
    function editPlugin(\App\App &$app, \App\Request $req) {
        $app->title = "Edit plugin";
        $app->content = $app->smarty->fetch(__DIR__ . "/edit_plugin.tpl", [
            "plugin" => \App\PluginLoader::getPlugin($app, $req->params["id"]),
            "plugin_config" => $this->loadConfig()
        ]);
    }
}
