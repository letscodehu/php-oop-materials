<?php

namespace Controllers;

use Session\Session;

class ForgotPasswordController
{
    /**
     * @var Session
     */
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function show() {
        return [
            "forgotpass", [
                "sent" => $this->sent(),
                "title" => "Forgot password"
            ]
        ];
    }

    private function sent() {
        $sentPassword = $this->session->has("sentPassword");
        $this->session->remove("sentPassword");
        return $sentPassword;
    }

}