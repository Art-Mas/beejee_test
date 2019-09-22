<?php


namespace Beejee\Models;


use Beejee\Application;
use Beejee\Classes\Helper;
use Beejee\Classes\Model;

class Task extends Model
{
    const FIELD_ID = 'id';
    const FIELD_EMAIL = 'email';
    const FIELD_NAME = 'name';
    const FIELD_TEXT = 'text';
    const FIELD_IS_EDITED = 'is_edited';
    const FIELD_IS_COMPLETED = 'is_completed';
    const LIMIT_PER_PAGE = 3;

    public static function tableName()
    {
        return 'task';
    }


    public static function rules()
    {
        return [
            self::FIELD_EMAIL => 'required|email',
            self::FIELD_NAME => 'required',
            self::FIELD_IS_COMPLETED => 'default:0|in:0,1'
        ];
    }

    public function fetchTasks($page, $sort)
    {
        Application::db()->pageLimit = self::LIMIT_PER_PAGE;
        if ($sort) {
            $sortData = Helper::parseSort($sort);
            Application::db()->orderBy($sortData['field'], $sortData['type']);
        }
        $tasks = Application::db()->paginate(self::tableName(), $page);
        return $tasks;
    }

    public function getTotal()
    {
        return Application::db()->getValue(self::tableName(), 'count(*)');
    }

}