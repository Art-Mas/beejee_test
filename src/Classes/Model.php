<?php


namespace Beejee\Classes;


abstract class Model
{
    public abstract static function tableName();

    public static function rules()
    {
        return [];
    }
}