<?php
namespace Beejee;

use Beejee\Interfaces\Router;
use Beejee\Interfaces\TemplateEngine;
use Beejee\Interfaces\Validator;

class Application {

    private static $templateEngine;

    private static $router;

    private static $validator;

    private static $db;

    public function __construct(TemplateEngine $templateEngine, Router $router, \Rakit\Validation\Validator $validator, \MysqliDb $db)
    {
        self::$templateEngine = $templateEngine;
        self::$router = $router;
        self::$validator = $validator;
        self::$db = $db;
    }

    public static function validator()
    {
        return self::$validator;
    }

    public static function db()
    {
        return self::$db;
    }

    public static function templateEngine()
    {
        return self::$templateEngine;
    }

    public function run()
    {
        session_start();
        return self::$router->handle();
    }
}