<?php

namespace Services;

use Session;

class AuthService {

    /**
     * @var mysqli
     */
    private $connection;
    /**
     * @var Session
     */
    private $session;

    public function __construct(\mysqli $connection, Session $session) {
        $this->connection = $connection;
        $this->session = $session;
    }

    public function loginUser($email, $password) {
        if ($statement = mysqli_prepare($this->connection, 'SELECT name, password FROM photos_users WHERE email = ?')) {
            mysqli_stmt_bind_param($statement, "s", $email);
            mysqli_stmt_execute($statement);
            $result = mysqli_stmt_get_result($statement);
            $record = mysqli_fetch_assoc($result);
            if ($record != null && password_verify($password, $record["password"])) {
                $this->session->put("user", [
                    "name" => $record["name"]
                ]);
                return true;
            }
            return false;
        } else {
            throw new SqlException('Query error: '. mysqli_error($this->connection));
        }
    }

    public function check() {
        return $this->session->has("user");
    }

    public function logout() {
        $this->session->remove("user");
    }

}