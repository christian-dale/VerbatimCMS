<?php

require_once("Blog.php");

class BlogPosts {
    function blogPostView($res, App &$app, Blog $blog) {
        $post = $blog->posts[$res->attr["id"]];

        $app->title = $post->get("title");
        $description = substr(strip_tags($post->get("content")), 0, 150);
        $app->description = "${description} ...";
    
        $app->content = $app->smarty->fetch("templates/pages/post.tpl", ["post" => $post]);
    }

    function blogPosts(App &$app, Blog $blog) {
        $app->title = "Title - Blog";
        $app->content = $app->smarty->fetch("templates/pages/blog.tpl", ["posts" => $blog->posts]);
    }

    function __construct($res, &$app, $opts) {
        $blog = new Blog();

        $blog->loadPosts();
        $blog->renderPosts();

        if (isset($res->attr)) {
            $this->blogPostView($res, $app, $blog);
        } else {
            $this->blogPosts($app, $blog);
        }
    }
}
