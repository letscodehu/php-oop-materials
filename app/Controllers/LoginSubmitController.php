<?php

namespace Controllers;

use Services\AuthService;

class LoginSubmitController {

    private $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    public function submit() {
        $password = trim($_POST["password"]);
        $email = trim($_POST["email"]);
        $success = $this->authService->loginUser($email, $password);
        if ($success) {
            $view = "redirect:/";
        } else {
            $this->markAsLoginFailed();
            $view = "redirect:/login";
        }
        return [
            $view, []
        ];   
    }

    private function markAsLoginFailed() {
        $_SESSION["containsError"] = 1;
    }

}