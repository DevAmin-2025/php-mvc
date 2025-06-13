<?php

namespace Models;

use Database;
use PDOException;

class Post {
    private Database $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getPosts(int $current_page, int $posts_per_page): array|bool {
        $offset = ($current_page - 1) * $posts_per_page;
        $stmt = $this->db->pdo->prepare("
            SELECT p.id, p.title, p.body, p.category_id, c.title AS category_title
            FROM posts p JOIN categories c USING (category_id) ORDER BY p.id DESC
            LIMIT :offset, :limit
        ");
        try {
            $stmt->bindParam("offset", $offset, \PDO::PARAM_INT);
            $stmt->bindParam("limit", $posts_per_page, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            $_SESSION["error"] = $e->getMessage();
            return false;
        }
    }

    public function getPost(string $id): array|bool {
        $stmt = $this->db->pdo->prepare("SELECT * FROM posts WHERE id = :id");
        try {
            $stmt->execute(["id" => $id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            $_SESSION["error"] = $e->getMessage();
            return false;
        }
    }

    public function createPost(string $title, string $body, string $category_id): void {
        $stmt = $this->db->pdo->prepare(
            "INSERT INTO posts (title, body, category_id) VALUES (:title, :body, :category_id)"
        );
        try {
            $stmt->execute(
                ["title" => $title, "body" => $body, "category_id" => $category_id]
            );
        } catch (PDOException $e) {
            $_SESSION["error"] = $e->getMessage();
        }
    }

    public function updatePost(string $id, string $title, string $body, string $category_id): void {
        $stmt = $this->db->pdo->prepare(
            "UPDATE posts SET title = :title, body = :body, category_id = :category_id WHERE id = :id"
        );
        try {
            $stmt->execute(
                ["id" => $id, "title" => $title, "body" => $body, "category_id" => $category_id]
            );
        } catch (PDOException $e) {
            $_SESSION["error"] = $e->getMessage();
        }
    }

    public function deletePost(string $id): void {
        $stmt = $this->db->pdo->prepare("DELETE FROM posts WHERE id = :id");
        try {
            $stmt->execute(["id" => $id]);
        } catch (PDOException $e) {
            $_SESSION["error"] = $e->getMessage();
        }
    }

    public function searchPosts(string $query, int $current_page, int $posts_per_page): array|bool {
        $offset = ($current_page - 1) * $posts_per_page;
        $query = "%" . $query . "%";
        $stmt = $this->db->pdo->prepare(
            "SELECT p.id, p.title, p.body, p.category_id, c.title AS category_title
            FROM posts p JOIN categories c USING(category_id) WHERE p.title LIKE :query
            OR p.body LIKE :query ORDER BY p.id DESC LIMIT :offset, :limit"
        );
        try {
            $stmt->bindParam("offset", $offset, \PDO::PARAM_INT);
            $stmt->bindParam("limit", $posts_per_page, \PDO::PARAM_INT);
            $stmt->bindParam("query", $query);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            $_SESSION["error"] = $e->getMessage();
            return false;
        }
    }

    public function getTotalPostsByQuery(string $query): int {
        $query = "%" . $query . "%";
        try {
            $stmt = $this->db->pdo->prepare(
                "SELECT COUNT(*) FROM posts WHERE title LIKE :query OR body LIKE :query"
            );
            $stmt->execute(["query" => $query]);
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            $_SESSION["error"] = $e->getMessage();
            return 0;
        }
    }

    public function getTotalPosts(): int {
        try {
            $stmt = $this->db->pdo->query("SELECT COUNT(*) FROM posts");
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            $_SESSION["error"] = $e->getMessage();
            return 0;
        }
    }
}
