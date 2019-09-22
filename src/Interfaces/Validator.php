<?php


namespace Beejee\Interfaces;


interface Validator
{
    public function validate(array $inputs, array $rules);
}