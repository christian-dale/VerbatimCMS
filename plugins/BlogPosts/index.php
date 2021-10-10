<?php

require_once("Blog.php");

class BlogPosts {
    function init($res, &$app, $opts) {
        $app->addCSS("/plugins/BlogPosts/style.css");

        $blog = new Blog();

        $blog->loadPosts();
        $blog->renderPosts();

        // Check if response contains query string.
        if (isset($res->attr)) {
            $this->blogPostView($res, $app, $blog);
        } else {
            $this->blogPosts($app, $blog);
        }
    }

    /**
     * View a particular blog post.
     */

     function blogPostView($res, App &$app, Blog $blog) {
        $post = $blog->posts[$res->attr["id"]];

        $app->title = $post->get("title");
        $app->description = substr(strip_tags($post->get("content")), 0, 150) . " ...";
        
        $app->content = $app->smarty->fetch(__DIR__ . "/post.tpl", ["post" => $post]);
    }

    /**
     * Show a list of blog posts.
     */

    function blogPosts(App &$app, Blog $blog) {
        $app->title = "Title - Blog";
        $app->content = $app->smarty->fetch(__DIR__ . "/blog.tpl", ["posts" => $blog->posts]);
    }
}
