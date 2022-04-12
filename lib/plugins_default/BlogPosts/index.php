<?php

require_once("Blog.php");

class BlogPosts {
    function init(\App\App &$app, $res, array $opts = []) {
        $app->addCSS("/content/plugins/BlogPosts/style.css");

        $blog = new \Plugin\Blog();

        $blog->loadPosts();
        $blog->renderPosts();

        // Check if response contains query string.
        if (isset($res->attr)) {
            $this->blogPostView($app, $res, $blog);
        } else {
            $this->blogPosts($app, $blog);
        }
    }

    /**
     * View a particular blog post.
     */

     function blogPostView(\App\App &$app, $res, \Plugin\Blog $blog) {
        $post = $blog->posts[$res->attr["id"]];

        $app->title = $post->get("title");
        $app->description = substr(strip_tags($post->get("content")), 0, 150) . " ...";
        
        $app->content = $app->smarty->fetch(__DIR__ . "/post.tpl", [
            "post" => $post, "disqus_comments" => \App\PluginLoader::loadPlugin($app, "DisqusComments")
        ]);
    }

    /**
     * Show a list of blog posts.
     */

    function blogPosts(\App\App &$app, \Plugin\Blog $blog) {
        $app->title = "Blog";
        $app->content = $app->smarty->fetch(__DIR__ . "/blog.tpl", ["posts" => $blog->posts]);
    }
}
