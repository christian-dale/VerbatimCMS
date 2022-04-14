<?php

namespace App;

class Util {
    public static function issetAndTrue($var) {
        return isset($var) && $var == true;
    }

    public static function getReqAttr(array $method, string $attr) {
        return $method[$attr];
    }

    public static function filterInput($type, $var, $filter) {
        return filter_input($type, $var, $filter);
    }
}
