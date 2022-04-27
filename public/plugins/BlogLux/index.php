<?php

require_once("Blog.php");

class BlogLux extends \VerbatimCMS\Plugin {
    public $pluginInfo = [
        "name" => "BlogLux",
        "description" => "A blogging platform.",
        "type" => \VerbatimCMS\PluginType::DEFAULT,
        "version" => "1.0.0"
    ];

    public $routes = [
        ["title" => "Blog", "path" => "/blog", "method" => "get", "nav_item" => true, "bg-color" => "#3d5afe", "color" => "#fff"],
        ["title" => "Blog", "path" => "/blog/(.+)", "method" => "get"]
    ];

    function init(\VerbatimCMS\App &$app, \VerbatimCMS\Request $req, array $opts = []) {
        $app->addAsset("/plugins/BlogLux/style.css", \VerbatimCMS\AssetType::CSS);

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

    function createConfig(): array {
        return [
            "enabled" => true,
            "description" => ""
        ];
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

    function createPost($post_name, $content, $opts) {
        $post_name = str_replace(" ", "-", strtolower($post_name));
        file_put_contents("content/posts/{$post_name}.md", $content);
        \VerbatimCMS\Util::storeConfig("content/posts/{$post_name}.json", $opts);
    }
        
    function editPost($post_name, $content, $opts) {
        file_put_contents("content/posts/{$post_name}.md", $content);

        $post_meta = \VerbatimCMS\Util::loadJSON("content/posts/{$post_name}.json");
        $post_meta["title"] = $opts["title"];
        $post_meta["date"] = $opts["date"];
        $post_meta["image"] = "/assets/media/{$opts["media"]}";

        \VerbatimCMS\Util::storeConfig("content/posts/{$post_name}.json", $post_meta);
    }
}
