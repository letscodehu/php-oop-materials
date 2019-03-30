<?php

session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);


require_once "core/functions.php";
require_once "core/Photo.php";

$photo = new Photo(null, "null", "null", "null");

die;

require_once "core/config.php";
require_once "core/controllers.php";
require_once "core/app.php";