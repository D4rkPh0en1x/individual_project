<h1>Welcome to the Movie Database</h1>
<?php 
session_start();

require_once __DIR__.'/../vendor/autoload.php';

$configs = require __DIR__. '/../config/app.conf.php';

Service\DBConnector::setConfig($configs['db']);

$map = [
    
    '/account' => __DIR__.'/../src/Controller/account.php',
    '' => __DIR__.'/../src/Controller/login.php',
    '/register' => __DIR__.'/../src/Controller/register.php',
    '/login' => __DIR__.'/../src/Controller/login.php',
    '/logout' => __DIR__.'/../src/Controller/logout.php',
    '/update' => __DIR__.'/../src/Controller/update.php'
];

$url = $_SERVER['REQUEST_URI'];

if (substr($url, 0, strlen('/index.php')) == '/index.php'){
    $url = substr($url, strlen('/index.php'));
} else if ($url == '/'){
    $url = '';
}

$urlPart = explode("?", $url);

if (array_key_exists($urlPart[0], $map)){
    include $map[$urlPart[0]];
}



?>