<?php

namespace Controllers;

use Views\Viewer;

class HomeController {
    public function index() {
        $title = "Personal Blog";
        $viewer = new Viewer;
        $viewer->render("/home/HomeController__index.php", ["title" => $title]);
    }
}
