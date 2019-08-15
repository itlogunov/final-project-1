<?php

require_once '../vendor/autoload.php';
require_once 'functions.php';

use \Twig\Environment;
use \Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader('../views/');
$twig = new Environment($loader, [
    'cache' => '../views/cache/',
]);
