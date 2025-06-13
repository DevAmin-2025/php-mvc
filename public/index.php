<?php

use Views\Viewer;

require __DIR__ . "/../bootstrap.php";

$path = trim(str_replace("php-mvc", "", parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH)), "/");

$routes = [
    "GET" => [
        "" => ["controller" => "Controllers\HomeController", "action" => "index"],

        "category/create" => ["controller" => "Controllers\CategoryController", "action" => "create"],
        "category" => ["controller" => "Controllers\CategoryController", "action" => "index"],
        "category/edit/(?<id>[0-9]+)" => ["controller" => "Controllers\CategoryController", "action" => "edit"],

        "post/create" => ["controller" => "Controllers\PostController", "action" => "create"],
        "posts" => ["controller" => "Controllers\PostController", "action" => "index"],
        "post/edit/(?<id>[0-9]+)" => ["controller" => "Controllers\PostController", "action" => "edit"],
        "post/search" => ["controller" => "Controllers\PostController", "action" => "search"],

        "user/register" => ["controller" => "Controllers\UserController", "action" => "register"],
        "user/login" => ["controller" => "Controllers\UserController", "action" => "login"],
        "user/logout" => ["controller" => "Controllers\UserController", "action" => "logout"]
    ],
    "POST" => [
        "category/store" => ["controller" => "Controllers\CategoryController", "action" => "store"],
        "category/update/(?<id>[0-9]+)" => ["controller" => "Controllers\CategoryController", "action" => "update"],
        "category/delete/(?<id>[0-9]+)" => ["controller" => "Controllers\CategoryController", "action" => "delete"],

        "post/delete/(?<id>[0-9]+)" => ["controller" => "Controllers\PostController", "action" => "delete"],
        "post/store" => ["controller" => "Controllers\PostController", "action" => "store"],
        "post/update/(?<id>[0-9]+)" => ["controller" => "Controllers\PostController", "action" => "update"],

        "user/store" => ["controller" => "Controllers\UserController", "action" => "store"],
        "user/authenticate" => ["controller" => "Controllers\UserController", "action" => "authenticate"]
    ]
];
$method = $_SERVER["REQUEST_METHOD"];

foreach ($routes[$method] as $route => $info) {
    if (preg_match("#^$route$#", $path, $matches)) {
        $matches = array_filter($matches, fn($key) => is_string($key), ARRAY_FILTER_USE_KEY);
        $id = $matches["id"] ?? null;
        $controller = new $info["controller"];
        if ($method == "POST") {
            $controller->{$info["action"]}($_POST, $id);
        } elseif ($method == "GET") {
            $controller->{$info["action"]}($id);
        }
        break;
    }
}

if (!isset($controller)) {
    $viewer = new Viewer;
    $viewer->render("/errors/404.php");
}
