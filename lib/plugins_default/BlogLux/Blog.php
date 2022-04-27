<?php

namespace Plugin;

require_once("lib/class/Item.php");

class BlogPost extends \VerbatimCMS\Item {
    private string $table = "post";

    function __construct($id = null) {
        parent::__construct($this->table, []);
    }
}

class Blog {
    public array $posts = [];
    public array $posts_rendered = [];
    private string $table = "post";
    private int $postscount = 7;

    // Default properties for blog post.
    public static $blog_default = [
        "id" => "",
        "title" => "",
        "date" => "",
        "dateUpdate" => "",
        "draft" => false,
        "categories" => [],
        "image" => "",
        "attrib" => "",
        "lang" => "en"
    ];

    function __construct() {

    }

    function loadPostMeta(String $file_name): Array {
        $post_meta = \VerbatimCMS\Util::loadJSON($file_name);
        $post_meta = array_merge(self::$blog_default, $post_meta);
        $post_meta["id"] = $this->getPostID($file_name);
        return $post_meta;
    }

    function loadPostContent(String $file_name): String {
        return file_get_contents(preg_replace("#.json#", ".md", $file_name));
    }

    function getPostID(String $file_name): String {
        $match = [];
        preg_match("#/([a-z0-9-_]+).json#", $file_name, $match);

        return $match[1];
    }

    public static function getEmptyPost() {
        return \VerbatimCMS\Item::simpleLoad(BlogPost::class, array_merge(self::$blog_default, [
            "date" => date("Y-m-d", time()),
            "dateUpdated" => date("Y-m-d", time())
        ]));
    }

    function loadPosts() {
        foreach (glob("content/posts/*.json") as $file_name) {
            $post_meta = $this->loadPostMeta($file_name);
            $post_meta["content"] = $this->loadPostContent($file_name);
            $this->posts[$post_meta["id"]] = \VerbatimCMS\Item::simpleLoad(BlogPost::class, $post_meta);
        }

        // Sort posts based on date.
        uasort($this->posts, fn($a, $b) => strtotime($a->get("date")) < strtotime($b->get("date")));
    }

    function renderPosts() {
        $parsedown = new \Parsedown();

        $this->posts_rendered = array_map(function($post) use($parsedown) {
            $post->set([
                "content" => $parsedown->text($post->get("content")),
                "attrib" => $parsedown->text($post->get("attrib"))
            ]);

            return $post;
        }, $this->posts);
    }
}
