<?php
require_once './vendor/autoload.php';
include './src/defines.php';

use Beejee\Classes\Router;
use Beejee\Classes\TemplateEngine;
use Beejee\Application;
use Dotenv\Dotenv;
use Rakit\Validation\Validator;

$dotenv = Dotenv::create(__DIR__);
$dotenv->load();
$templateEngine = new TemplateEngine();
$router = new Router();
$validator = new Validator();
$db = new MysqliDb($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'], $_ENV['DB_NAME']);
(new Application($templateEngine, $router, $validator, $db))->run();
