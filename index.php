<?php

declare(strict_types=1);
session_start();
error_reporting(E_ALL);
ini_set("display_errors", "1");


require_once "core/functions.php";
require_once "core/Photo.php";
require_once "core/config.php";
require_once "core/controllers.php";
require_once "core/Dispatcher.php";
require_once "core/Application.php";
require_once "core/Response.php";
require_once "core/ResponseEmitter.php";
require_once "core/ResponseFactory.php";
require_once "core/ViewRenderer.php";
require_once "core/ModelAndView.php";

(new Application())->start();
