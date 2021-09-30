<?php

class DB {
    public static PDO $connection;
    public static array $options = [
        "host" => "localhost",
        "dbname" => "portfolio"
    ];

    private static string $host = "localhost";
    private static string $db = "portfolio";

    public static function setup() {
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];
        
        $host = self::$host;
        $db = self::$db;

        self::$connection = new PDO("mysql:host={$host};dbname={$db};charset=utf8mb4;", "root", "", $options);
    }

    public static function query(string $query, ...$params) {
        $stmt = self::$connection->prepare($query);
        $stmt->execute($params);
        $result = $stmt;
        return $result;
    }
}