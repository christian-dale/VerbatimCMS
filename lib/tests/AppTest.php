<?php

require_once("class/App.php");
require_once("class/Lang.php");

use \PHPUnit\Framework\TestCase;

class AppTest extends TestCase {
    public $app = null;

    public function setUp(): void {
        $this->app = new App(new Smarty(), new Lang("en"), null);
    }

    public function testAppRender() {
        $this->app->content = "phpunit";
        $this->assertStringContainsString($this->app->content, $this->app->render());
    }

    public function testAppPrettyPrint() {
        $this->assertMatchesRegularExpression("/<pre>example<\/pre>/", $this->app->prettyPrint("example", true));
    }
}