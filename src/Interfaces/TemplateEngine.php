<?php

namespace Beejee\Interfaces;


interface TemplateEngine
{
    public function render(string $templateName, array $vars = []);


}