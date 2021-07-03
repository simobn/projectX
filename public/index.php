<?php

require_once __DIR__ . '/../vendor/autoload.php';

use app\Controllers\SiteController;
use app\Core\Application;
$app = new Application(dirname(__DIR__));

$app->router->get('/',[SiteController::class , 'home']);
$app->router->get('/contact',[SiteController::class , 'contact']);
$app->router->post('/contact',[SiteController::class,'handleContact']);

//auth routes
$app->router->get('/login',[\app\Controllers\AuthController::class,'login']);
$app->router->get('/register',[\app\Controllers\AuthController::class,'register']);
$app->router->post('/login',[\app\Controllers\AuthController::class,'handleLogin']);
$app->router->post('/register',[\app\Controllers\AuthController::class,'handleRegister']);

$app->run();