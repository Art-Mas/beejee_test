<?php


namespace Beejee\Classes;


class Validator implements \Beejee\Interfaces\Validator
{
    private $validator;

    public function __construct()
    {
        $this->validator = new \Rakit\Validation\Validator();
    }

    public function validate(array $inputs, array $rules)
    {
        $this->validator->validate($inputs, $rules);
    }

}