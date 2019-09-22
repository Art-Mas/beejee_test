<?php


namespace Beejee\Controllers;


use Beejee\Classes\Controller;
use Beejee\Classes\Helper;

class LogoutController extends Controller
{
    public function actionView()
    {
        session_destroy();
        Helper::redirect('/');
    }

}