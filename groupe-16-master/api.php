<?php
set_include_path("./src");
require_once('ApiRouter.php');
require_once('model/AnimalStorageSession.php');
require_once("model/AnimalStorage.php");

session_start();


$storage = new AnimalStorageSession();
$router = new ApiRouter();
$router->main($storage);