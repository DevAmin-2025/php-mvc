<?php

namespace Views;

class Viewer {
    public function render(string $template, array $data = []) {
        extract($data);
        require BASE_DIR . "/Views/layout/header.php";
        require BASE_DIR . "/Views/$template";
        require BASE_DIR . "/Views/layout/footer.php";
    }
}
