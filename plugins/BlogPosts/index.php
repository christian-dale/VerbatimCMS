<?php

require_once("Blog.php");

class BlogPosts {
    function __construct(&$app, $opts) {
        $app->title = "Title - Blog";

        $blog = new Blog();

        $blog->loadPosts();
        $blog->renderPosts();

        $app->content = $app->smarty->fetch("templates/pages/blog.tpl", ["posts" => $blog->posts]);
    }
}