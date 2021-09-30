<?php

require_once("class/DB.php");

abstract class ItemState {
    public const CREATE = 0;
    public const LOAD = 1;
}

class Item extends DB {
    private array $attrs = [];
    private array $structure = [];
    private int $state = ItemState::CREATE;
    private string $table = "";

    function __construct(string $table, $column = []) {
        $this->table = $table;
    }

    function load(int $id) {
        $query = "SELECT * FROM ? WHERE id = ?";
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

    function fetchStructure() {
        $structure = DB::query("DESCRIBE {$this->table}")->fetchAll();
        $this->structure = $structure;
    }

    static function simpleLoad($item, $attributes) {
        $item = new $item();
        $item->set($attributes);
        return $item;
    }

    function save(array $attrs) {
        $this->fetchStructure();
        if ($attrs) $this->set($attrs);

        $values = array_map(fn($value) => "'" . $value . "'", $this->attrs);

        $keys = implode(",", array_keys($this->attrs));
        $values = implode(",", array_values($values));

        if ($this->state == ItemState::CREATE) {
            DB::query("INSERT INTO {$this->table} (" . $keys . ") VALUES (" . $values . ")");
        } else {
            DB::query("UPDATE {$this->table} (" . $keys . ") VALUES (" . $values . ")");
        }
    }
}
