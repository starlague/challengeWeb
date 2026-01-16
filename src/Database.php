<?php

namespace App;

use PDO;

class Database {
    // Hold the single instance of the Database class (Singleton pattern)
    private static $instance;
    private $pdo;

    // Private constructor to prevent multiple instances
    private function __construct() {
        // Create a new PDO connection to the MySQL database
        $this->pdo = new PDO(
            'mysql:host=localhost;dbname=blog;charset=utf8mb4', // DSN: host, database, charset
            'root', // Database username
            '',     // Database password
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION] // Set PDO to throw exceptions on errors
        );
    }

    // Get the PDO instance (Singleton pattern ensures only one connection)
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self(); // Create a new Database instance if it doesn't exist
        }
        return self::$instance->pdo; // Return the PDO connection
    }
}
