<?php

require_once("Blog.php");

class BlogLux extends \App\Plugin {
    public $pluginInfo = [
        "name" => "BlogLux",
        "description" => "A blogging platform.",
        "type" => \App\PluginType::DEFAULT,
        "version" => "1.0.0"
    ];

    public $routes = [
        ["title" => "Blog", "path" => "/blog", "method" => "get", "nav_item" => true],
        ["title" => "Blog", "path" => "/blog/(.+)", "method" => "get"]
    ];

    function init(\App\App &$app, \App\Request $req, array $opts = []) {
        $app->addCSS("/plugins/BlogLux/style.css");

        $blog = new \Plugin\Blog();

        $blog->loadPosts();
        $blog->renderPosts();

        // Check if request contains query string.
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

     function blogPostView(\App\App &$app, \App\Request $req, \Plugin\Blog $blog) {
        $post = $blog->posts[$req->params["id"]];

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

    function createPost($post_name, $content, $opts) {
        $post_name = str_replace(" ", "-", strtolower($post_name));
        file_put_contents("content/posts/{$post_name}.md", $content);
        \App\Util::storeConfig("content/posts/{$post_name}.json", $opts);
    }
        
    function editPost($post_name, $content, $opts) {
        file_put_contents("content/posts/{$post_name}.md", $content);

        $post_meta = \App\Util::loadJSON("content/posts/{$post_name}.json");
        $post_meta["title"] = $opts["title"];
        $post_meta["date"] = $opts["date"];
        $post_meta["image"] = "/assets/media/{$opts["media"]}";

        \App\Util::storeConfig("content/posts/{$post_name}.json", $post_meta);
    }
}
