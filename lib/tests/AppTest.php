<?php

require_once("lib/class/App.php");
require_once("lib/class/Lang.php");

use \PHPUnit\Framework\TestCase;

class AppTest extends TestCase {
    public $app = null;

    public function setUp(): void {
        $this->app = new \App\App();
    }

    public function testAppRender() {
        $this->assertStringContainsString("<meta charset=\"utf-8\">", $this->app->render());
    }

    public function testAppPrettyPrint() {
        $this->assertMatchesRegularExpression("/<pre>example<\/pre>/", \App\App::prettyPrint("example", true));
    }
}