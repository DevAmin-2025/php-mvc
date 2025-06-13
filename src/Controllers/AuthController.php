<?php

namespace Controllers;

class AuthController {
    protected function authorize(): void {
        if(!isLoggedIn()) {
            redirect("/user/login", ["error" => "You don't have permission to access this page, Please log in"]);
        }
    }
}
