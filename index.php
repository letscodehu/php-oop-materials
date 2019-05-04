<?php
declare(strict_types=1);

session_start();
error_reporting(E_ALL);
ini_set("display_errors", "1");

require_once "autoload.php";
require_once "core/functions.php";
require_once "core/controllers.php";
require_once "core/config.php";

new Controllers\NotFoundController();

(new \Application())->start();

