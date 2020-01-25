<?php


namespace Controllers;


class PasswordResetController
{

    /**
     * @var \Request
     */
    private $request;

    /**
     * PasswordResetController constructor.
     * @param \Request $request
     */
    public function __construct(\Request $request)
    {
        $this->request = $request;
    }

    public function show() {
        return [
            "reset",
            [
                "title" => "Set your new password",
                "failed" => $this->failed(),
                "sent" => $this->sent(),
                "token" => $this->request->getParams()["token"]
            ]
        ];
    }

    private function failed()
    {
        return $this->getAndDeleteFromSession("failed");
    }

    private function sent()
    {
        return $this->getAndDeleteFromSession("resetPassword");
    }

    private function getAndDeleteFromSession($key) {
        $has = $this->request->getSession()->has($key);
        $this->request->getSession()->remove($key);
        return $has;
    }

}