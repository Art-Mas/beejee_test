<?php


namespace Beejee\Classes;


use Beejee\Interfaces\TemplateEngine;

class TwigTemplateEngine implements TemplateEngine
{
    private $engine;

    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader('./templates');
        $this->engine = new \Twig\Environment($loader);
    }

    public function render(string $templateName, array $vars = [])
    {
        echo $this->engine->render($templateName, $vars);
    }

}