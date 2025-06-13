<?php

namespace Controllers;

use Models\Category;
use Models\Post;
use PDOException;
use Views\Viewer;

class PostController extends AuthController {
    private Post $model;
    private Viewer $viewer;

    public function __construct() {
        $this->model = new Post;
        $this->viewer = new Viewer;
    }

    public function index(): void {
        $current_page = isset($_GET["page"]) ? $_GET["page"] : 1;
        $posts_per_page = 5;
        $total_posts = $this->model->getTotalPosts();
        $total_pages = ceil($total_posts / $posts_per_page);
        $posts = $this->model->getPosts($current_page, $posts_per_page);

        $this->viewer->render(
            "/post/PostController_index.php",
            [
                "posts" => $posts,
                "total_pages" => $total_pages,
                "current_page" => $current_page
            ]
        );
    }

    public function create(): void {
        $this->authorize();
        $category_model = new Category;
        $categories = $category_model->getCategories();
        $this->viewer->render("post/PostController_create.php", ["categories" => $categories]);
    }

    public function store(array $data): void {
        $title = trim($data["title"]);
        $category_id = trim($data["category_id"]);
        $body = trim($data["body"]);

        $errors = [];
        if (empty($title)) {
            $errors += ["title" => "Title is required"];
        }
        if (empty($body)) {
            $errors += ["body" => "Body is required"];
        }
        if (empty($category_id)) {
            $errors += ["category" => "Category is required"];
        }

        if (empty($errors)) {
            $this->model->createPost($title, $body, $category_id);
            if (!isset($_SESSION["error"])) {
                redirect("/posts", ["success" => "Post created successfully"]);
            } else {
                redirect("/post/create", ["error" => $_SESSION["error"]]);
            }
        } else {
            redirect("/post/create", ["form_errors" => $errors]);
        }
    }

    public function edit(string $id): void {
        $this->authorize();
        $post = $this->model->getPost($id);
        if (empty($post)) {
            $this->viewer->render("/errors/404.php");
            exit;
        }
        $category_model = new Category;
        $categories = $category_model->getCategories();
        $this->viewer->render(
            "post/PostController_edit.php", ["post" => $post, "categories" => $categories]
        );
    }

    public function update(array $data, string $id): void {
        $title = $data["title"];
        $body = $data["body"];
        $category_id = $data["category_id"];

        $errors = [];
        if (empty($title)) {
            $errors += ["title" => "Title is required"];
        }
        if (empty($body)) {
            $errors += ["body" => "Body is required"];
        }

        if (empty($errors)) {
            $this->model->updatePost($id, $title, $body, $category_id);
            if (!isset($_SESSION["error"])) {
                redirect("/posts", ["success" => "Post updated successfully"]);
            } else {
                redirect("/post/edit/$id", ["error" => $_SESSION["error"]]);
            }
        } else {
            redirect("/post/edit/$id", ["form_errors" => $errors]);
        }
    }

    public function delete(array $data, string $id): void {
        $this->authorize();
        $this->model->deletePost($id);
        redirect("/posts", ["success" => "Post deleted successfully"]);
    }

    public function search() {
        $query = trim($_GET["query"]);
        $current_page = isset($_GET["page"]) ? $_GET["page"] : 1;
        $posts_per_page = 5;
        $total_posts = $this->model->getTotalPostsByQuery($query);
        $total_pages = ceil($total_posts / $posts_per_page);
        $posts = [];

        if (!empty($query)) {
            $posts = $this->model->searchPosts($query, $current_page, $posts_per_page);
            if (!isset($_SESSION["error"])) {
                $this->viewer->render(
                    "post/PostController_search.php",
                    [
                        "posts" => $posts,
                        "total_pages" => $total_pages,
                        "query" => $query,
                        "current_page" => $current_page
                    ]
                );
            } else {
                redirect("/posts", ["error" => $_SESSION["error"]]);
            }
        } else {
            redirect("/posts", ["error" => "Search query can not be empty"]);
        }
    }
}
