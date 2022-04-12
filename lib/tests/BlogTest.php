<?php

require_once("lib/class/Item.php");
require_once("lib/plugins_default/BlogPosts/Blog.php");

use \PHPUnit\Framework\TestCase;

class BlogTest extends TestCase {
    public $blog = null;

    public function setUp(): void {
        $this->blog = new \Plugin\Blog();
    }

    public function testBlogLoadPosts() {
        $this->blog->loadPosts();

        foreach ($this->blog->posts as $post) {
            $this->assertInstanceOf(\App\Item::class, $post);
        }
    }

    public function testBlogRenderPosts() {
        $this->blog->loadPosts();

        foreach ($this->blog->posts as $post) {
            $this->assertIsString($post->get("content"));
        }
    }
}