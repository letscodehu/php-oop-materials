<?php

namespace Controllers;

class LoginSubmitController {

    public function submit() {
        $password = trim($_POST["password"]);
        $email = trim($_POST["email"]);
        $user = loginUser(getConnection(), $email, $password);
        if ($user != null) {
            $_SESSION["user"] = [
                "name" => $user["name"]
            ];
            $view = "redirect:/";
        } else {
            $_SESSION["containsError"] = 1;
            $view = "redirect:/login";
        }
        return [
            $view, []
        ];   
    }

}