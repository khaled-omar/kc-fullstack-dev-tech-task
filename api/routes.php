<?php

require_once 'Libs/Router.php';
require_once 'Controllers/CategoryController.php';
require_once 'Controllers/CourseController.php';

use Libs\Router;

$router = new Router();

$router->get('/categories', ['CategoryController', 'index']);
$router->get('/categories/{id}', ['CategoryController', 'show']);

$router->get('/courses', ['CourseController', 'index']);
$router->get('/courses/{id}', ['CourseController', 'show']);

// Dispatch the request
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
