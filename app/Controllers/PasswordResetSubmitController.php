<?php


namespace Controllers;


use Services\ForgotPasswordService;

class PasswordResetSubmitController
{

    /**
     * @var \Request
     */
    private $request;

    /**
     * @var ForgotPasswordService
     */
    private $service;

    /**
     * PasswordResetSubmitController constructor.
     * @param \Request $request
     * @param ForgotPasswordService $service
     */
    public function __construct(\Request $request, \Services\ForgotPasswordService $service)
    {
        $this->request = $request;
        $this->service = $service;
    }

    public function submit() {
        $params = $this->request->getParams();
        $session = $this->request->getSession();
        $valid = $this->validate($params);
        if ($valid) {
            $this->service->updatePassword($params["token"], $params["password"]);
            $session->put("resetPassword", true);
            return [
                "redirect:/reset"
            ];
        } else {
            $session->put("failed", true);
            return [
                "redirect:/reset"
            ];
        }
    }

    private function validate(array $params)
    {
        $password = $params["password"];
        $passwordConf = $params["password_confirmation"];
        return $password == $passwordConf && strlen($password) >= 8 && $this->service->checkTokenExists($params["token"]);
    }

}