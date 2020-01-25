<?php


namespace Controllers;


class PasswordResetSubmitController
{

    /**
     * @var \Request
     */
    private $request;

    /**
     * PasswordResetSubmitController constructor.
     * @param \Request $request
     */
    public function __construct(\Request $request)
    {
        $this->request = $request;
    }

    public function submit() {
        $params = $this->request->getParams();
        $session = $this->request->getSession();
        $valid = $this->validate($params);
        if ($valid) {
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
        return $password == $passwordConf && strlen($password) >= 8;
    }

}