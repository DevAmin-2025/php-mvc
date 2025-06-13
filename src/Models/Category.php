<?php

namespace Models;

use Database;
use PDOException;

class Category {
    private Database $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getCategories(int $current_page = 1, int $categories_per_page = 1000): array|bool {
        $offset = ($current_page - 1) * $categories_per_page;
        $stmt = $this->db->pdo->prepare("SELECT * FROM categories ORDER BY category_id DESC LIMIT :offset, :limit");
        try {
            $stmt->bindParam("offset", $offset, \PDO::PARAM_INT);
            $stmt->bindParam("limit", $categories_per_page, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            $_SESSION["error"] = $e->getMessage();
            return false;
        }
    }

    public function getCategory(string $id): array|bool {
        $stmt = $this->db->pdo->prepare("SELECT * FROM categories WHERE category_id = :id");
        try {
            $stmt->execute(["id" => $id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            $_SESSION["error"] = $e->getMessage();
            return false;
        }
    }

    public function getCategoryByTitle(string $title): array|bool {
        $stmt = $this->db->pdo->prepare("SELECT * FROM categories WHERE title = :title");
        try {
            $stmt->execute(["title" => $title]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            $_SESSION["error"] = $e->getMessage();
            return false;
        }
    }

    public function createCategory(string $title): void {
        $stmt = $this->db->pdo->prepare("INSERT INTO categories (title) VALUES (:title)");
        try {
            $stmt->execute(["title" => $title]);
        } catch (PDOException $e) {
            $_SESSION["error"] = $e->getMessage();
        }
    }

    public function updateCategory(string $id, string $title): void {
        $stmt = $this->db->pdo->prepare("UPDATE categories SET title = :title WHERE category_id = :id");
        try {
            $stmt->execute(["id" => $id, "title" => $title]);
        } catch (PDOException $e) {
            $_SESSION["error"] = $e->getMessage();
        }
    }

    public function deleteCategory(string $id): void {
        $stmt = $this->db->pdo->prepare("DELETE FROM categories WHERE category_id = :id");
        try {
            $stmt->execute(["id" => $id]);
        } catch (PDOException $e) {
            $_SESSION["error"] = $e->getMessage();
        }
    }

    public function getTotalCategories(): int {
        try {
            $stmt = $this->db->pdo->query("SELECT COUNT(*) FROM categories");
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            $_SESSION["error"] = $e->getMessage();
            return 0;
        }
    }
}
