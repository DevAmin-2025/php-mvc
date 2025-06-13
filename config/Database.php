<?php

class Database
{
    public PDO $pdo;
    private $server_name = ""; // Fill this
    private $dbname = ""; // Fill this
    private $username = ""; // Fill this
    private $password = ""; // Fill this

    public function __construct() {
        try {
            $this->pdo = new PDO(
                "mysql:host=$this->server_name;dbname=$this->dbname",
                $this->username,
                $this->password
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            exit;
        }
    }
}

/**
 * In order to be able to use this program you need to create the following tables.
 *
 * Categories table:
 * create table categories
 *  (
 *      category_id int unsigned auto_increment
 *         primary key,
 *    title       varchar(255) not null
 * );
 *
 * Posts table:
 * create table posts
 *  (
 *      id          int unsigned auto_increment
 *          primary key,
 *      title       varchar(255) not null,
 *      body        varchar(255) not null,
 *      category_id int unsigned not null,
 *      constraint fk_posts_category
 *          foreign key (category_id) references categories (category_id)
 *              on delete cascade
 *  );
 *
 * Users table:
 * create table users
 *   (
 *       id       int auto_increment
 *           primary key,
 *       email    varchar(255) not null,
 *       password varchar(255) not null,
 *       constraint email
 *           unique (email)
 *   );
 */
