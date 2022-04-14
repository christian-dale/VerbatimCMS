<?php

namespace App;

class Util {
    public static function issetAndTrue($var) {
        return isset($var) && $var == true;
    }
}