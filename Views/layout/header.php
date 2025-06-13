<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MVC Architecture</title>
    <link rel="stylesheet" href="<?= URL_ROOT ?>/public/css/reset.css">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="<?= URL_ROOT ?>/public/css/app.css">
</head>

<body>
    <header class="header">
        <nav class="nav">
            <div class="nav_links">
                <a href="<?= URL_ROOT ?>" class="nav__brand">Personal Blog</a>
                <ul class="nav__list">
                    <li class="nav__item"><a href="<?= URL_ROOT ?>/posts" class="nav__link">Posts</a></li>
                    <li class="nav__item"><a href="<?= URL_ROOT ?>/category" class="nav__link">Category</a></li>
                </ul>
            </div>
            <?php if (!isLoggedIn()): ?>
                <div class="nav__btns">
                    <a href="<?= URL_ROOT ?>/user/login" class="nav__login">Login</a>
                    <a href="<?= URL_ROOT ?>/user/register" class="nav__register">Register</a>
                </div>
            <?php else: ?>
                <div class="nav__info">
                    <span class="nav__email"><?= $_SESSION["email"] ?></span>
                    <a href="<?= URL_ROOT ?>/user/logout" class="nav__logout">Logout</a>
                </div>
            <?php endif; ?>
        </nav>
    </header>
