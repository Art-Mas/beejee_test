<?php


namespace Beejee\Classes;


class Controller
{
    private $requestMethod_action = [
      'GET' => 'View',
      'POST' => 'Create',
      'PUT' => 'Update'
    ];

    public final function runAction($params)
    {
        $requestMethod = mb_strtoupper($_POST['_method'] ?? $_SERVER['REQUEST_METHOD']);
        $action = $this->requestMethod_action[$requestMethod];
        $method = 'action' . $action;
        if (method_exists($this, 'action' . $action)) {
            $content = $this->$method($params);
            if ($content) {
                echo $content;
            }
        } else {
            throw new \Exception('method ' . $method . ' not exists');
        }
    }

}