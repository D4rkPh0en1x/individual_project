<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Movie Database</title>
  
  <meta property="og:title" content="Fidelity System">
  <meta property="og:type" content="article">
  <meta property="og:url" content="http://movie_database.eliza.family">
  <meta property="og:image" content="">
  <meta property="og:description" content="Fidelity System">
  <meta property="fb:admin" content="">

  <link rel="stylesheet" href="/css/normalize.css">
  <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/v4-shims.js"></script>
  <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="/css/style.min.css">

</head>
<h1>Welcome to the Movie Database</h1>
<?php


session_start();

require_once __DIR__.'/../vendor/autoload.php';

$configs = require __DIR__. '/../config/app.conf.php';

Service\DBConnector::setConfig($configs['db']);

$map = [
    '' => __DIR__.'/../src/Controller/login.php',
    '/account' => __DIR__.'/../src/Controller/account.php',
    '/register' => __DIR__.'/../src/Controller/register.php',
    '/login' => __DIR__.'/../src/Controller/login.php',
    '/logout' => __DIR__.'/../src/Controller/logout.php',
    '/create' => __DIR__.'/../src/Controller/create.php',
    '/read' => __DIR__.'/../src/Controller/read.php',
    '/delete' => __DIR__.'/../src/Controller/delete.php',
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

  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
