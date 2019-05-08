<?php
declare(strict_types=1);

session_start();
error_reporting(E_ALL);
ini_set("display_errors", "1");

require_once "../core/functions.php";
require_once "../core/config.php";
require_once "../core/controllers.php";
require_once "../autoload.php";

(new \Application())->start(realpath(__DIR__. "/../"));

