<?php

use \PHPUnit\Framework\TestCase;

class AppTest extends TestCase {
    public $app = null;

    public function setUp(): void {
        $this->app = new \App\App();
    }

    public function testAppRender() {
        $this->assertTrue(true);
    }
}
