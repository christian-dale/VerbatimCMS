<?php

class Editore {
    function init(\App\App &$app, \App\Request $req, array $opts = []) {
        $app->addAsset("/assets/styles/kernel.css", \App\AssetType::CSS);
        $app->addAsset("/plugins/Editor/style.css", \App\AssetType::CSS);

        if (empty($req->params)) {
            $app->title = "Editore";

            $page_loader = new \App\PageMan();

            $app->content = $app->smarty->fetch(__DIR__ . "/editor.tpl", [
                "posts" => \App\PluginMan::loadPlugin($app, "BlogLux", new \App\Request, ["template" => true]),
                "plugins" => \App\PluginMan::getPluginsList(),
                "pages" => $page_loader->loadPages($app)
            ]);
        } else {
            $this->blogPostEdit($app, $req);
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
}
