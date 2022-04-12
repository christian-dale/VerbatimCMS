<?php

namespace App;

class Lang {
    public $lang = "en";

    public function __construct($lang) {
        if (isset($lang)) {
            $this->lang = $lang;
        }
    }
    
    public function getLang(): string {
        return $this->lang;
    }
    
    public function setLang(string $lang) {
        $_SESSION["lang"] = $lang;
        $this->lang = $lang;
    }

    public function get(string $w) {
        return json_decode(file_get_contents("lib/lang/{$this->lang}.json"), true)[$w] ?? $w;
    }
}
