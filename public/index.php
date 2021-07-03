<?php

require_once __DIR__ . '/../vendor/autoload.php';

use app\Controllers\SiteController;
use app\Core\Application;
$app = new Application(dirname(__DIR__));

$app->router->get('/',[SiteController::class , 'home']);
$app->router->get('/contact','contact');
$app->router->post('/contact',[SiteController::class,'handleContact']);

$app->run();