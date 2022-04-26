<?php

class Editore {
    function init(\VerbatimCMS\App &$app, \VerbatimCMS\Request $req, array $opts = []) {
        $app->addAsset("/assets/styles/kernel.css", \VerbatimCMS\AssetType::CSS);
        $app->addAsset("/plugins/Editor/style.css", \VerbatimCMS\AssetType::CSS);

        if (empty($req->params)) {
            $app->title = "Editore";

            $page_loader = new \VerbatimCMS\PageMan();

            $app->content = $app->smarty->fetch(__DIR__ . "/editor.tpl", [
                "posts" => \VerbatimCMS\PluginMan::loadPlugin($app, "BlogLux", new \VerbatimCMS\Request, ["template" => true]),
                "plugins" => \VerbatimCMS\PluginMan::getPluginsList(),
                "pages" => $page_loader->loadPages($app)
            ]);
        } else {
            $this->blogPostEdit($app, $req);
        }
    }

    /**
     * Edit a particular blog post.
     */

    function blogPostEdit(\VerbatimCMS\App &$app, \VerbatimCMS\Request $req) {
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
