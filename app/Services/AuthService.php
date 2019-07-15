<?php

namespace Services;

class AuthService {

    /**
     * @var mysqli
     */
    private $connection;

    public function __construct(\mysqli $connection) {
        $this->connection = $connection;
    }

    public function loginUser($email, $password) {
        if ($statement = mysqli_prepare($this->connection, 'SELECT name, password FROM photos_users WHERE email = ?')) {
            mysqli_stmt_bind_param($statement, "s", $email);
            mysqli_stmt_execute($statement);
            $result = mysqli_stmt_get_result($statement);
            $record = mysqli_fetch_assoc($result);
            if ($record != null && password_verify($password, $record["password"])) {
                $_SESSION["user"] = [
                    "name" => $record["name"]
                ];
                return true;
            }
            return false;
        } else {
            throw new SqlException('Query error: '. mysqli_error($this->connection));
        }
    }

    public function check() {
        return array_key_exists("user", $_SESSION);
    }

    public function logout() {
        unset($_SESSION["user"]);
    }

}