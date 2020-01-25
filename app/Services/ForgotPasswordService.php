<?php

namespace Services;


use Exception\SqlException;
use mysqli;
use Swift_Mailer;
use Swift_Message;

class ForgotPasswordService
{

    /**
     * @var mysqli
     */
    private $connection;
    /**
     * @var Swift_Mailer
     */
    private $mailer;

    private $baseUrl;

    /**
     * ForgotPasswordService constructor.
     * @param mysqli $connection
     * @param Swift_Mailer $mailer
     * @param $baseUrl
     */
    public function __construct(mysqli $connection, \Swift_Mailer $mailer, $baseUrl)
    {
        $this->connection = $connection;
        $this->mailer = $mailer;
        $this->baseUrl = $baseUrl;
    }

    public function forgotPassword($email)
    {
        if ($this->userExists($email)) {
            $token = $this->createForgotPasswordToken($email);
            $this->sendForgotPasswordEmail($email, $token);
        }
    }

    private function userExists($email)
    {
        if ($statement = $this->connection->prepare("SELECT name FROM photos_users WHERE email = ?")) {
            $statement->bind_param("s", $email);
            $statement->execute();
            $result = $statement->get_result();
            $record = $result->fetch_assoc();
            if ($record != null) {
                return true;
            }
        } else {
            throw new SqlException($this->connection->error);
        }
        return false;
    }

    public function checkTokenExists($token)
    {
        if ($statement = $this->connection->prepare("SELECT COUNT(*) as total FROM password_reset WHERE token = ? AND expiry > ?")) {
            $now = date("Y-m-d H:i:s");
            $statement->bind_param("ss", $token, $now);
            $statement->execute();
            $result = $statement->get_result();
            $record = $result->fetch_assoc();
            return $record["total"] > 0;
        } else {
            throw new SqlException($this->connection->error);
        }
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
        $message = new Swift_Message();
        $message->addFrom("noreply@training.com", "My photos page");
        $message->setSubject("Password reset");
        $message->setTo($email);
        $url = $this->baseUrl."/reset?token=".$token;
        $message->addPart("Hello there!\n Your password has been reset! You can set a new password by clicking on the link: $url");
        $this->mailer->send($message);
    }

    private function deleteTokensForEmail($email)
    {
        if ($statement = $this->connection->prepare("DELETE FROM password_reset WHERE email = ?")) {
            $statement->bind_param("s", $email);
            $statement->execute();
        } else {
            throw new SqlException($this->connection->error);
        }
    }

    private function addToken($email, string $token)
    {
        if ($statement = $this->connection->prepare("INSERT INTO password_reset (email, token, expiry) VALUES (?, ?, ?)")) {
            $statement->bind_param("sss", $email, $token, date("Y-m-d H:i:s", time() + 7200));
            $statement->execute();
        } else {
            throw new SqlException($this->connection->error);
        }
    }

    public function updatePassword($token, $password)
    {
        if ($statement = $this->connection->prepare("UPDATE photos_users SET password = ? WHERE email = (SELECT email FROM password_reset WHERE token = ?)")) {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $statement->bind_param("ss", $hash, $token);
            $statement->execute();
        } else {
            throw new SqlException($this->connection->error);
        }
        $this->deleteToken($token);
    }

    private function deleteToken($token)
    {
        if ($statement = $this->connection->prepare("DELETE FROM password_reset WHERE token = ?")) {
            $statement->bind_param("s", $token);
            $statement->execute();
        } else {
            throw new SqlException($this->connection->error);
        }
    }

}