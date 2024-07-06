<?php

spl_autoload_register(function ($class) {
    include 'Controller/' . $class . '.php';
});
require __DIR__ . '/vendor/autoload.php';
set_exception_handler("ErrorHandler::handleException"); // we make it go to our class that we creat it when any error happen
header("Content-type:application/json;charset:UTF-8"); // if we do not add this the content type will show as html despite we we want it to be json so we change the type through header function
// Simulate an exception
$dotenc = Dotenv\Dotenv::createImmutable(__DIR__); //we call the class and put __dir__ param inside settImuutable to tell it that env file in this directory
$dotenc->load(); // load all vals in env files inside $_ENV global variable

/*
$stmt = $db->prepare("SELECT * FROM `task`");
$stmt->execute();
$vals = $stmt->fetchAll();
*/