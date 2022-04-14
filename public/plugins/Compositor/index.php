<?php

class Compositor {
    public $pluginInfo = [
        "name" => "Compositor",
        "type" => \App\PluginType::DEFAULT,
        "version" => "1.0.0"
    ];

    function init(\App\App &$app, \App\Request $req, array $opts = []) {
        $app->addCSS("/assets/styles/kernel.css");
        $app->addCSS("/plugins/Editor/style.css");

        if (empty($req->params)) {
            $app->title = "Compositor";

            $page_loader = new \App\PageLoader();

            $app->content = $app->smarty->fetch(__DIR__ . "/editor.tpl", [
                "posts" => \App\PluginLoader::loadPlugin($app, "BlogLux", new \App\Request, ["template" => true]),
                "plugins" => \App\PluginLoader::getPluginsList(),
                "pages" => $page_loader->loadPages($app)
            ]);
        } else if ($opts["state"] == "ViewPost"){
            $this->blogPostEdit($app, $req);
        } else if ($opts["state"] == "ViewPlugin") {
            $this->editPlugin($app, $req);
        }
    }

    /**
     * Edit a particular blog post.
     */

    function blogPostEdit(\App\App &$app, \App\Request $req) {
        require_once("public/plugins/BlogLux/Blog.php");

        $blog = new \Plugin\Blog();

        $blog->loadPosts();

        $post = $blog->posts[$req->params["id"]];

        $app->title = $post->get("title");
        $app->description = substr(strip_tags($post->get("content")), 0, 150) . " ...";
        
        $app->content = $app->smarty->fetch(__DIR__ . "/edit_post.tpl", [
            "post" => $post
        ]);
    }

    /**
     * Edit a particular plugin.
     */
    function editPlugin(\App\App &$app, \App\Request $req) {
        $app->title = "Edit plugin";
        $app->content = $app->smarty->fetch(__DIR__ . "/edit_plugin.tpl", [
            "plugin" => \App\PluginLoader::getPlugin($app, $req->params["id"])
        ]);
    }
}
