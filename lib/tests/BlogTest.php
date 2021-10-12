<?php

require_once("class/Item.php");
require_once("class/Blog.php");

use \PHPUnit\Framework\TestCase;

class BlogTest extends TestCase {
    public $blog = null;

    public function setUp(): void {
        $this->blog = new Blog();
    }

    public function testBlogLoadPosts() {
        $this->blog->loadPosts();

        foreach ($this->blog->posts as $post) {
            $this->assertInstanceOf(Item::class, $post);
        }
    }

    public function testBlogRenderPosts() {
        $this->blog->loadPosts();

        foreach ($this->blog->posts as $post) {
            $this->assertIsString($post->get("content"));
        }
    }
}