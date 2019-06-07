<?php
declare(strict_types=1);

session_start();
error_reporting(E_ALL);
ini_set("display_errors", "1");

require_once "../core/functions.php";
require_once "../core/config.php";
require_once "../core/controllers.php";
require_once "../autoload.php";

class Something {

}

class Validator extends Something  {

    protected final function assertTrue($condition, $text) {
        if (!$condition) {
            throw new InvalidArgumentException($text);
        }
    }

}


class EmailValidator extends Validator {

    public function validate($email) {
        $this->assertTrue(filter_var($email, FILTER_VALIDATE_EMAIL), "The given email is not valid!");
    }
}

class NotEmptyValidator  extends Validator {

    public function validate($text) {
        $this->assertTrue(!($text == null || $text == ''), "The given string is empty!");
    }
}


$validator = new EmailValidator();
$validator->validate("");

die;
(new \Application(new ServiceContainer(include "../services.php")))->start(realpath(__DIR__. "/../"));

