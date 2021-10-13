<?php

namespace App;

abstract class ItemState {
    public const CREATE = 0;
    public const LOAD = 1;
}

class Item {
    private array $attrs = [];
    private array $structure = [];
    private string $table = "";

    function __construct(string $table, $column = []) {
        $this->table = $table;
    }

    function set(array $attr) {
        $this->attrs = array_merge($this->attrs, $attr);
    }

    function get(string $k) {
        return $this->attrs[$k];
    }

    function attributes() {
        return $this->attrs;
    }

    static function simpleLoad($item, $attributes) {
        $item = new $item();
        $item->set($attributes);
        return $item;
    }
}
