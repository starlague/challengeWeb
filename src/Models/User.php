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

    //getters
    public function getId() {
        return $this->id;
    }
    public function getUsername() {
        return $this->username;
    }
    public function getEmail() {
        return $this->email;
    }
    public function getPassword() {
        return $this->password;
    }
    public function getBio() {
        return $this->bio;
    }
    public function getAvatar() {
        return $this->avatar;
    }

    //setters
    public function setId($id) {
        $this->id = $id;
    }
    public function setUsername($username) {
        $this->username = $username;
    }
    public function setEmail($email) {
        $this->email = $email;
    }
    public function setPassword($password) {
        $this->password = $password;
    }
    public function setBio($bio) {
        $this->bio = $bio;
    }
    public function setAvatar($avatar) {
        $this->avatar = $avatar;
    }

    //methods
    public function getAllUsers() {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }   

    public function getUserById($id) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function saveUser() {
        $pdo = Database::getInstance();

        $hashedPassword = password_hash($this->password, PASSWORD_BCRYPT);

        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, bio) VALUES (?, ?, ?, ?)");
        $stmt->execute([$this->username, $this->email, $hashedPassword, $this->bio]);
    }
}