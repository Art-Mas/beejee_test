<?php

namespace Beejee\Classes;

class TemplateEngine implements \Beejee\Interfaces\TemplateEngine {
    public function render(string $templateName, array $vars = [])
    {
        $_vars = array_merge($vars, ['template' => $templateName]);
        extract($_vars);
        include(DIR_TEMPLATES . DS . 'main.phtml');
    }
}