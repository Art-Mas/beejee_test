<?php


namespace Beejee\Controllers;


use Beejee\Application;
use Beejee\Classes\Controller;
use Beejee\Classes\Helper;

class LoginController extends Controller
{
    private $users = [
        [
            'login' => 'admin',
            'pass' => '123'
        ]
    ];

    private $errors = [];

    public function actionView()
    {
        return Application::templateEngine()->render('login.phtml', [
            'errors' => $this->errors
        ]);
    }

    public function actionCreate()
    {
        $validation = Application::validator()->validate($_POST, [
            'login' => 'required',
            'pass' => 'required'
        ]);
        $isSessionStarted = false;

        if ($validation->fails()) {
            $this->errors = $validation->errors->firstOfAll();
        }

        foreach ($this->users as $user) {
            if (
                $user['login'] === $_POST['login']
                && $user['pass'] === $_POST['pass']
            ) {
                $_SESSION['login'] = $user['login'];
                $_SESSION['is_login'] = true;
                $isSessionStarted = true;
                break;
            }
        }

        if (!$isSessionStarted) {
            $this->errors = array_merge(
                $this->errors,
                ['session' => 'login or pass is incorrect']
            );
            return $this->actionView();
        } else {
            Helper::redirect('/');
        }
    }

}