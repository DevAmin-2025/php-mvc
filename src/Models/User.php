<?php

namespace Models;

use Database;
use PDOException;

class User {
    private Database $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function createUser(string $email, string $password): void {
        $stmt = $this->db->pdo->prepare(
            "INSERT INTO users (email, password) VALUES (:email, :password)"
        );
        try {
            $stmt->execute(["email" => $email, "password" => $password]);
        } catch (PDOException $e) {
            $_SESSION["error"] = $e->getMessage();
        }
    }

    public function getUserByEmail(string $email): array|bool {
        $stmt = $this->db->pdo->prepare("SELECT * FROM users WHERE email = :email");
        try {
            $stmt->execute(["email" => $email]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            $_SESSION["error"] = $e->getMessage();
            return false;
        }
    }
}
