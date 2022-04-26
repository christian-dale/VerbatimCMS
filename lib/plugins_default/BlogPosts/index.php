<?php

require_once("Blog.php");

class BlogPosts {
    function init(\VerbatimCMS\App &$app, \VerbatimCMS\Request $req, array $opts = []) {
        $app->addAsset("/plugins/BlogLux/style.css", \VerbatimCMS\AssetType::CSS);

        $blog = new \Plugin\Blog();

        $blog->loadPosts();
        $blog->renderPosts();

        // Check if requst contains query string.
        if (empty($req->params)) {
            $this->blogPosts($app, $blog);
        } else {
            $this->blogPostView($app, $req, $blog);
        }

        if (isset($opts["template"]) && $opts["template"] == true) {
            return $blog->posts;
        }
    }

    /**
     * View a particular blog post.
     */

     function blogPostView(\VerbatimCMS\App &$app, \VerbatimCMS\Request $req, \Plugin\Blog $blog) {
        $post = $blog->posts[$req->params["id"]];

        $app->title = $post->get("title");
        $app->description = substr(strip_tags($post->get("content")), 0, 150) . " ...";
        
        $app->content = $app->smarty->fetch(__DIR__ . "/post.tpl", [
            "post" => $post, "disqus_comments" => \VerbatimCMS\PluginMan::loadPlugin($app, "DisqusComments")
        ]);
    }

    /**
     * Show a list of blog posts.
     */

    function blogPosts(\VerbatimCMS\App &$app, \Plugin\Blog $blog) {
        $app->title = "Blog";
        $app->content = $app->smarty->fetch(__DIR__ . "/blog.tpl", ["posts" => $blog->posts]);
    }
}
