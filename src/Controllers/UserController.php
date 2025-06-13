<?php

namespace Controllers;

use Models\User;
use PDOException;
use Views\Viewer;

class UserController {
    private User $model;
    private Viewer $viewer;

    public function __construct() {
        $this->model = new User;
        $this->viewer = new Viewer;
    }

    public function register(): void {
        $this->viewer->render("user/UserController_register.php");
    }

    public function store(array $data): void {
        $email = $data["email"];
        $password = $data["password"];
        $confirm_password = $data["confirm-password"];

        $errors = [];
        if (empty($email)) {
            $errors += ["email" => "Email is required"];
        }

        if (empty($password)) {
            $errors += ["password" => "Password is required"];
        } elseif (strlen($password) < 6) {
            $errors += ["password" => "Password must atleast have 6 characters"];
        }

        if (empty($confirm_password)) {
            $errors += ["confirm_password" => "Password is required"];
        } elseif ($password != $confirm_password) {
            $errors += ["confirm_password" => "Password does not match"];
        }

        if (empty($errors)) {
            $email_exists = $this->model->getUserByEmail($email);
            if ($email_exists) {
                $errors += ["email" => "Email already exists"];
                redirect("/user/register", ["form_errors" => $errors]);
            }

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $this->model->createUser($email, $hashed_password);
            if (!isset($_SESSION["error"])) {
                redirect("/user/login", ["success" => "User created successfully. <br> Please log in"]);
            } else {
                redirect("/user/register", ["error" => "User creation failed"]);
            }
        } else {
            redirect("/user/register", ["form_errors" => $errors]);
        }
    }

    public function login(): void {
        $this->viewer->render("user/UserController_login.php");
    }

    public function authenticate(array $data): void {
        $email = $data["email"];
        $password = $data["password"];

        $errors = [];
        if (empty($email)) {
            $errors += ["email" => "Email is required"];
        }

        if (empty($password)) {
            $errors += ["password" => "Password is required"];
        }

        if (empty($errors)) {
            $user = $this->model->getUserByEmail($email);
            if (!$user) {
                redirect("/user/register", ["error" => "User does not exists. <br> Please sign up"]);
            } else {
                if (password_verify($password, $user["password"])) {
                    $_SESSION["user_id"] = $user["id"];
                    $_SESSION["email"] = $user["email"];
                    redirect("/", ["success" => "You have successfully logged in"]);
                } else {
                    redirect("/user/login", ["error" => "Incorrect password"]);
                }
            }
        } else {
            redirect("/user/login", ["form_errors" => $errors]);
        }
    }

    public function logout(): void {
        session_destroy();
        redirect("/", ["success" => "You have successfully logged out"]);
    }
}
