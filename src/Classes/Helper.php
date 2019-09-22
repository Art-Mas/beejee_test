<?php


namespace Beejee\Classes;


class Helper
{
    public static function parseSort(string $sort)
    {
        $type = 'asc';
        $field = $sort;
        if ($sort[0] == '-') {
            $type = 'desc';
            $field = substr($sort, 1);
        }
        return ['type' => $type, 'field' => $field];
    }

    public static function redirect($url)
    {
        header('HTTP/1.1 200 OK');
        header('Location: http://' . $_SERVER['HTTP_HOST'] . $url);
    }

}