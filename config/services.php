<?php

$allowedEnv = ['dev', 'prod', 'test', 'testing'];
$dbPrefix = 'lumino_';
// change all the \ to / in the path
$basePath = str_replace("\\", "/", dirname(__DIR__));
$dotenv = new Symfony\Component\Dotenv\Dotenv();
$dotenv->loadEnv($basePath . '/.env');

$container = new Container();

$container->delegate(new ReflectionContainer());

// parameters for application config






