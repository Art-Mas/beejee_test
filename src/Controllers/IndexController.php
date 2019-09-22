<?php
namespace Beejee\Controllers;

use Beejee\Application;
use Beejee\Classes\Controller;
use Beejee\Classes\Helper;
use Beejee\Models\Task;

class IndexController extends Controller {
    private $errors = [];
    private $isTaskCreated = false;

    private function renderIndex() {
        $model = new Task();
        $page = key_exists('page', $_GET) ? (int)$_GET['page'] : 1;
        $sort = key_exists('sort', $_GET) ? $_GET['sort'] : null;
        $tasks = $model->fetchTasks($page, $sort);
        $cnt = $model->getTotal();
        return Application::templateEngine()->render(
            'index.phtml',
            [
                'tasks' => $tasks,
                'errors' => $this->errors,
                'isTaskCreated' => $this->isTaskCreated,
                'pages' => ceil($cnt / Task::LIMIT_PER_PAGE),
            ]
        );
    }

    public function actionView()
    {
        return $this->renderIndex();
    }

    public function actionCreate()
    {
        $validation = Application::validator()->validate($_POST, Task::rules());
        if ($validation->fails()) {
            $this->errors = $validation->errors()->firstOfAll();
        } else {
            Application::db()->insert(Task::tableName(), [
                Task::FIELD_NAME => $_POST['name'],
                Task::FIELD_EMAIL => $_POST['email'],
                Task::FIELD_TEXT => htmlentities(htmlspecialchars($_POST['text'])),
            ]);
            $this->isTaskCreated = true;
        }
        return $this->renderIndex();
    }


    public function actionUpdate($params)
    {
        if (!$_SESSION['login']) {
            Helper::redirect('/');
            exit;
        }
        $validation = Application::validator()->validate($_POST, Task::rules());
        $errors = [];
        if ($validation->fails()) {
            $errors = $validation->errors()->firstOfAll();
        } else {
            $prevText = Application::db()->getOne(Task::tableName())[Task::FIELD_TEXT];
            $newData = [
                Task::FIELD_NAME => $_POST['name'],
                Task::FIELD_EMAIL => $_POST['email'],
                Task::FIELD_TEXT => htmlentities(htmlspecialchars($_POST['text'])),
                Task::FIELD_IS_COMPLETED => isset($_POST['is_completed']) ? (int)$_POST['is_completed'] : 0
            ];
            if ($prevText != $newData[Task::FIELD_TEXT]) {
                $newData[Task::FIELD_IS_EDITED] = 1;
            }
            Application::db()->where(Task::FIELD_ID, $params['id'])->update(Task::tableName(), $newData);
        }

        return Application::templateEngine()->render('admin_task_view.phtml', [
            'errors' => $errors,
            'task' => Application::db()->where(Task::FIELD_ID, $params['id'])->getOne(Task::tableName())
        ]);
    }
}