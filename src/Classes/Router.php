<?php


namespace Beejee\Classes;

use Beejee\Controllers\AdminController;
use Beejee\Controllers\LoginController;
use Beejee\Controllers\LogoutController;
use FastRoute;
use Beejee\Controllers\IndexController;

class Router implements \Beejee\Interfaces\Router
{
    private $dispatcher;

    public function __construct()
    {
        $this->dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
            $r->addRoute('GET', '/', IndexController::class);
            $r->addRoute('POST', '/', IndexController::class);
            $r->addRoute('POST', '/{id:\d+}', IndexController::class);
            $r->addRoute('GET', '/admin', AdminController::class);
            $r->addRoute('GET', '/login', LoginController::class);
            $r->addRoute('POST', '/login', LoginController::class);
            $r->addRoute('GET', '/logout', LogoutController::class);
        });
    }

    public function handle()
    {
        // Fetch method and URI from somewhere
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        $routeInfo = $this->dispatcher->dispatch($httpMethod, $uri);
        switch ($routeInfo[0]) {
            case FastRoute\Dispatcher::FOUND:
                /** @var Controller $handler */
                $handler = new $routeInfo[1]();
                $vars = $routeInfo[2];
                $handler->runAction($vars);
                break;
            default:
                throw new \Exception('handler for route not found');
        }
    }

}