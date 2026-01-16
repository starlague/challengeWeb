<?php

namespace App\Models;

use App\Database;
use PDO;

class User {
    private $id;
    private $username;
    private $email;
    private $password;
    private $bio;
    private $avatar;

    // =======================
    // Getters
    // =======================

    /** @return int Returns the user ID */
    public function getId() {
        return $this->id;
    }

    /** @return string Returns the username */
    public function getUsername() {
        return $this->username;
    }

    /** @return string Returns the email */
    public function getEmail() {
        return $this->email;
    }

    /** @return string Returns the password (hashed) */
    public function getPassword() {
        return $this->password;
    }

    /** @return string Returns the bio of the user */
    public function getBio() {
        return $this->bio;
    }

    /** @return string|null Returns the avatar filename or null */
    public function getAvatar() {
        return $this->avatar;
    }

    // =======================
    // Setters
    // =======================

    /** @param int $id Set the user ID */
    public function setId($id) {
        $this->id = $id;
    }

    /** @param string $username Set the username */
    public function setUsername($username) {
        $this->username = $username;
    }

    /** @param string $email Set the email */
    public function setEmail($email) {
        $this->email = $email;
    }

    /** @param string $password Set the password (plain text, will be hashed on save) */
    public function setPassword($password) {
        $this->password = $password;
    }

    /** @param string $bio Set the user bio */
    public function setBio($bio) {
        $this->bio = $bio;
    }

    /** @param string $avatar Set the avatar filename */
    public function setAvatar($avatar) {
        $this->avatar = $avatar;
    }

    // =======================
    // Methods
    // =======================

    /**
     * Retrieve all users from the database.
     *
     * @return array Returns an array of all users as associative arrays
     */
    public function getAllUsers() {
        $pdo = Database::getInstance(); // Get database connection
        $stmt = $pdo->prepare("SELECT * FROM users");
        $stmt->execute(); // Execute query
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all results
    }   

    /**
     * Retrieve a single user by ID.
     *
     * @param int $id ID of the user
     * @return array|null Returns user as associative array or null if not found
     */
    public function getUserById($id) {
        $pdo = Database::getInstance(); // Get database connection
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]); // Execute query with ID
        return $stmt->fetch(PDO::FETCH_ASSOC); // Fetch single result
    }

    /**
     * Save a new user to the database.
     *
     * Password is hashed before saving.
     *
     * @return void
     */
    public function saveUser() {
        $pdo = Database::getInstance(); // Get database connection

        $hashedPassword = password_hash($this->password, PASSWORD_BCRYPT); // Hash password

        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, bio) VALUES (?, ?, ?, ?)");
        $stmt->execute([$this->username, $this->email, $hashedPassword, $this->bio]); // Execute insert
    }

    /**
     * Find a user by email.
     *
     * @param string $email Email address to search
     * @return array|null Returns user as associative array or null if not found
     */
    public static function findByEmail($email){
        $pdo = Database::getInstance(); // Get database connection
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]); // Execute query
        return $stmt->fetch(PDO::FETCH_ASSOC); // Fetch result
    }

    /**
     * Update an existing user in the database.
     *
     * @return bool Returns true on success, false on failure
     */
    public function updateUser(){
        $pdo = Database::getInstance(); // Get database connection
        $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ?, password = ?, bio = ? WHERE id = ?");
        return $stmt->execute([$this->username, $this->email, $this->password, $this->bio, $this->id]); // Execute update
    }

    /**
     * Delete a user from the database.
     *
     * @param int $id ID of the user to delete
     * @return void
     */
    public function delete($id) {
        $pdo = Database::getInstance(); // Get database connection
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]); // Execute delete
    }
}
