<?php 
session_start();

require_once __DIR__.'/../vendor/autoload.php';

$configs = require __DIR__. '/../config/app.conf.php';

Service\DBConnector::setConfig($configs['db']);

$map = [
    
    '/account' => __DIR__.'/../src/Controller/account.php',
    '' => __DIR__.'/../src/Controller/login.php',
    '/register' => __DIR__.'/../src/Controller/register.php',
    '/login' => __DIR__.'/../src/Controller/login.php'
];

$url = $_SERVER['REQUEST_URI'];

if (substr($url, 0, strlen('/index.php')) == '/index.php'){
    $url = substr($url, strlen('/index.php'));
} else if ($url == '/'){
    $url = '';
}

if (array_key_exists($url, $map)){
    include $map[$url];
}



?>