<?php

namespace App;

use PDO;

class Database {
   private static $instance;
    private $pdo;

    private function __construct() {
        $this->pdo = new PDO(
            'mysql:host=localhost;dbname=blog;charset=utf8mb4',
            'root',
            '',
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance->pdo;
    }
}