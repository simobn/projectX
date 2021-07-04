<?php

require_once __DIR__ . '/../vendor/autoload.php';

use app\Controllers\AuthController;
use app\Controllers\SiteController;
use app\Core\Application;
$app = new Application(dirname(__DIR__));

$app->router->get('/',[SiteController::class , 'home']);
$app->router->get('/contact',[SiteController::class , 'contact']);
$app->router->post('/contact',[SiteController::class,'handleContact']);

//auth routes
$app->router->get('/login',[AuthController::class,'login']);
$app->router->get('/register',[AuthController::class,'register']);
$app->router->post('/login',[AuthController::class,'handleLogin']);
$app->router->post('/register',[AuthController::class,'handleRegister']);

$app->run();