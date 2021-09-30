<?php

class FSDB {
    public string $path = "./fsdb";
    public array $structures = [];
    public array $data = [];

    function __construct() {
        
    }

    /**
     * Create a new table in the database.
     */
    
    function createTable(string $name, array $structure) {
        $this->structures[$name] = $structure;
        $this->data[$name] = [];
    }

    /**
     * Add a new row to a table.
     */

    function addRow(string $table, array $row) {
        $data = ["id" => count($this->data[$table])];

        foreach ($this->structures[$table] as $column) {
            if (isset($row[$column])) {
                $data[$column] = $row[$column];
            }
        }

        $this->data[$table][] = $data;
    }

    /**
     * Get a row from a table.
     */

    function getRow(string $table, array $row): array {
        $matches = [];

        foreach ($this->data[$table] as $dbRow) {
            $matchesCount = 0;

            foreach ($dbRow as $key => $val) {
                if (array_key_exists($key, $row) && in_array($val, $row)) {
                    $matchesCount++;
                }
            }

            if ($matchesCount == count($row)) {
                $matches[] = $dbRow;
            }
        }

        return $matches;
    }

    /**
     * Encrypt database data.
     */

    function dataEncrypt(string $data) {
        $cipher = "aes-256-ctr";
        $key = openssl_random_pseudo_bytes(32);
        $res = openssl_encrypt($data, $cipher, $key, OPENSSL_RAW_DATA, openssl_random_pseudo_bytes(16));

        return $res;
    }

    /**
     * Store database data to filesystem.
     */

    function commit() {
        foreach ($this->structures as $key => $structure) {
            $file = fopen("{$this->path}/fsdb_{$key}.json", "w");
            $storage = ["structures" => $this->structures[$key], "data" => $this->data[$key]];
            fwrite($file, json_encode($storage, JSON_PRETTY_PRINT));
        }
    }
}
