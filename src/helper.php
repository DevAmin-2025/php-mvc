<?php

function redirect(string $path, array $session = []): void {
    $_SESSION[key($session)] = $session[key($session)];
    header("Location:" . URL_ROOT . $path);
    exit;
}

function isLoggedIn() {
    return isset($_SESSION["user_id"]);
}
