<?php

namespace Controllers;

use Models\Category;
use PDOException;
use Views\Viewer;

class CategoryController extends AuthController {
    private Category $model;
    private Viewer $viewer;

    public function __construct() {
        $this->model = new Category;
        $this->viewer = new Viewer;
    }

    public function index(): void {
        $categories_per_page = 10;
        $current_page = isset($_GET["page"]) ? $_GET["page"] : 1;
        $total_categories = $this->model->getTotalCategories();
        $total_pages = ceil($total_categories / $categories_per_page);
        $categories = $this->model->getCategories($current_page, $categories_per_page);

        $this->viewer->render(
            "category/CategoryController_index.php",
            [
                "categories" => $categories,
                "total_pages" => $total_pages,
                "current_page" => $current_page
            ]
        );
    }

    public function create(): void {
        $this->authorize();
        $this->viewer->render("category/CategoryController_create.php");
    }

    public function store(array $data): void {
        $title = trim($data["title"]);
        $errors = [];
        if (empty($title)) {
            $errors += ["title" => "Title is required"];
        }

        $category_exists = $this->model->getCategoryByTitle($title);
        if ($category_exists) {
            $errors += ["category" => "Category already exists"];
        }

        if (empty($errors)) {
            $this->model->createCategory($title);
            if (!isset($_SESSION["error"])) {
                redirect("/category", ["success" => "Category created successfully"]);
            } else {
                redirect("/category/create", ["error" => $_SESSION["error"]]);
            }
        } else {
            redirect("/category/create", ["form_errors" => $errors]);
        }
    }

    public function edit(string $id): void {
        $this->authorize();
        $category = $this->model->getCategory($id);
        if ($category) {
            $this->viewer->render("category/CategoryController_edit.php", ["category" => $category]);
        } else {
            $this->viewer->render("errors/404.php");
        }
    }

    public function update(array $data, string $id): void {
        $title = trim($data["title"]);
        $old_title = $this->model->getCategory($id)["title"];

        $errors = [];
        if (empty($title)) {
            $errors += ["title" => "Title is required"];
        }

        $category_exists = $this->model->getCategoryByTitle($title);
        if ($old_title != $title and $category_exists) {
            $errors += ["category" => "Category already exists"];
        }

        if (empty($errors)) {
            $this->model->updateCategory($id, $title);
            if (!isset($_SESSION["error"])) {
                redirect("/category", ["success" => "Category updated successfully"]);
            } else {
                redirect("/category/edit/$id", ["error" => $_SESSION["error"]]);
            }
        } else {
            redirect("/category/edit/$id", ["form_errors" => $errors]);
        }
    }

    public function delete(array $data, string $id): void {
        $this->authorize();
        $this->model->deleteCategory($id);
        redirect("/category", ["success" => "Category deleted successfully"]);
    }
}
