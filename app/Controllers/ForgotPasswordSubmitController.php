<?php

namespace Controllers;


use Request;

class ForgotPasswordSubmitController
{
    /**
     * @var Request
     */
    private $request;

    /**
     * ForgotPasswordSubmitController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function submit() {
        $this->markForgotPasswordSent();
        $params = $this->request->getParams();
        return [
            "redirect:/forgotpass", [
                "title" => "Forgot password"
            ]
        ];
    }

    public function markForgotPasswordSent()
    {
        $this->request->getSession()->put("sentPassword", 1);
    }

}