<?php

namespace Services;


use mysqli;

class ForgotPasswordService {

    /**
     * @var mysqli
     */
    private $connection;

    /**
     * ForgotPasswordService constructor.
     * @param mysqli $connection
     */
    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }


    public function forgotPassword($email) {
        if ($this->userExists($email)) {
            $token = $this->createForgotPasswordToken($email);
            $this->sendForgotPasswordEmail($email, $token);
        }
    }

    private function userExists($email) {
        if ($statement = mysqli_prepare($this->connection, 'SELECT name FROM photos_users WHERE email = ?')) {
            mysqli_stmt_bind_param($statement, "s", $email);
            mysqli_stmt_execute($statement);
            $result = mysqli_stmt_get_result($statement);
            $record = mysqli_fetch_assoc($result);
            if ($record != null) {
                return true;
            }
        }
        return false;
    }

    private function createForgotPasswordToken($email)
    {
        $token = hash("sha256", uniqid(time(), true));
        $this->deleteTokensForEmail($email);
        $this->addToken($email, $token);
        return $token;
    }

    private function sendForgotPasswordEmail($email, $token)
    {

    }

    private function deleteTokensForEmail($email)
    {

    }

    private function addToken($email, string $token)
    {

    }


}