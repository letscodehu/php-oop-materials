<?php

class LogoutSubmitController {

    function submit() {
        unset($_SESSION["user"]);
        return [
            "redirect:/", [
            ]
        ];
    }

}

