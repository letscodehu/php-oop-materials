<?php

namespace Controllers;

use Session\Session;

class LoginFormController{

    /**
     * @var Session
     */
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function show() {
        $containsError = $this->checkForError();
        return [
            "login", [
                "title" => "Login",
                "containsError" => $containsError
            ]
        ];    
    }

    private function checkForError() {
        $containsError = $this->session->has("containsError");
        $this->session->remove("containsError");
        return $containsError;
    }

}