<?php

use app\Controllers\AuthController;
use app\Controllers\SiteController;
use app\Core\Application;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

//loading config from env
$config = [
    'userClass' => \app\Models\User::class,
    'db' => [
        'host'        => $_ENV['DB_HOST'],
        'port'        => $_ENV['DB_PORT'],
        'db_name'     =>  $_ENV['DB_NAME'],
        'user'        => $_ENV['DB_USER'],
        'password'    => $_ENV['DB_PASSWORD']
    ]
];
$app = new Application(dirname(__DIR__),$config);



$app->router->get('/',[SiteController::class , 'home']);
$app->router->get('/contact',[SiteController::class , 'contact']);
$app->router->post('/contact',[SiteController::class,'handleContact']);

//auth routes
$app->router->get('/login',[AuthController::class,'login']);
$app->router->get('/logout',[AuthController::class,'logout']);
$app->router->get('/register',[AuthController::class,'register']);
$app->router->post('/login',[AuthController::class,'handleLogin']);
$app->router->post('/register',[AuthController::class,'handleRegister']);

$app->run();