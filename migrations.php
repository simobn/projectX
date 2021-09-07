<?php

use app\Controllers\AuthController;
use app\Controllers\SiteController;
use app\Core\Application;

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

//loading config from env
$config = [
    'userClass' => \app\Core\UserModel::class,
    'db' => [
        'host'        => $_ENV['DB_HOST'],
        'port'        => $_ENV['DB_PORT'],
        'db_name'     =>  $_ENV['DB_NAME'],
        'user'        => $_ENV['DB_USER'],
        'password'    => $_ENV['DB_PASSWORD']
    ]
];
$app = new Application(__DIR__,$config);

$app->db->applyMigrations();