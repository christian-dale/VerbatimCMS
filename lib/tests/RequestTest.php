<?php

use \PHPUnit\Framework\TestCase;

class RequestTest extends TestCase {
    public function setUp(): void {

    }

    public function testRequestSend() {
        $req = \App\Request::request("https://api.github.com/repos/christian-dale/VerbatimCMS/tags");

        $this->assertIsString($req);
    }
}
