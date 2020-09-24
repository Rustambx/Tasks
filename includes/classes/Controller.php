<?php

namespace Task;

class Controller
{
    /**
     * Индексная страница
     * @param int $page
     * @throws \Pixie\Exception
     */
    public function index ($page = 1)
    {
        $sort = Task::getSortField();
        $order = Task::getSortOrder();

        $tpl = new Template('./Views/');
        $tasks = Task::getList('*', $sort, $order, $page);

        $paginator = Task::paginator($page);
        $currentPage = Helper::getCurrentUrl();
        $query = Helper::getUrlParams();

        echo $tpl->render('index', [
            "tasks" => $tasks,
            "paginator" => $paginator,
            "showAddBtn" => true,
            "currentPage" => $currentPage,
            "urlQuery" => $query,
            "sort" => $sort,
            "order" => $order,
        ]);
    }

    /**
     * Страница добавления
     * @param null $params
     * @throws \Pixie\Exception
     */
    public function create ($params = null)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (empty($_POST['name'])) {
                $errors["name"] = "Имя пользователя не указано.";
            }
            if (empty($_POST['email'])) {
                $errors["email"] = "Email не указан.";
            }
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $errors["email"] = "Недействительный адрес электронной почты. Пожалуйста, попробуйте еще раз";
            }
            if (empty($_POST['text'])) {
                $errors["text"] = "Текст задачи не указан.";
            }

            if ($errors) {
                $tpl = new Template('./Views/');
                echo $tpl->render('create', ['errors' => $errors]);
            } else {
                if (Task::save($_POST)) {
                    header('Location: /?create=success');
                }
            }
        } else {
            $tpl = new Template('./Views/');

            echo $tpl->render('create', ['showAddBtn' => false]);
        }
    }

    /**
     * Страница редактирования
     * @param $id
     * @throws \Pixie\Exception
     */
    public function update ($id)
    {
        if (!Auth::isAuthorized()) {
            Auth::redirectToLogin();
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (empty($_POST['text'])) {
                $errors["text"] = "Текст задачи не указан.";
            }
            if ($errors) {
                $tpl = new Template('./Views/');
                echo $tpl->render('update', ['errors' => $errors]);
            } else {
                if (Task::update($_POST, $id)) {
                    header('Location: /admin');
                }
            }
        } else {
            $connection = DB::getConnection();
            $task = $connection->table('tasks')->find($id);
            $tpl = new Template('./Views/');

            echo $tpl->render('update', ['task' => $task, 'logout' => true]);
        }
    }

    /**
     * Админ панель
     * @param int $page
     * @throws \Pixie\Exception
     */
    public function admin ($page = 1)
    {
        if (!Auth::isAuthorized()) {
            Auth::redirectToLogin();
        }

        $sort = Task::getSortField();
        $order = Task::getSortOrder();
        $tpl = new Template('./Views/');
        $tasks = Task::getList('*', $sort, $order, $page);
        $paginator = Task::adminPaginator($page);
        $currentPage = Helper::getCurrentUrl();
        $query = Helper::getUrlParams();

        echo $tpl->render('index', [
            'tasks' => $tasks,
            'paginator' => $paginator,
            'showAddBtn' => true,
            "currentPage" => $currentPage,
            "urlQuery" => $query,
            "sort" => $sort,
            "order" => $order,
            'logout' => true,
            'isAdmin' => Auth::isAuthorized()
        ]);
    }

    /**
     * Авторизация
     */
    public function login ()
    {
        $errors = array();

        if (isset($_POST['login-submit'])) {
            $login = htmlspecialchars($_POST['login']);
            $password = htmlspecialchars($_POST['password']);
            if (Auth::login($login, $password)) {
                Auth::redirectToAdmin();
            } else {
                $errors[] = "Ошибка авторизации, неправильный логин или пароль";
            }
        }
        $tpl = new Template('./Views/');

        echo $tpl->render('login', ['showAddBtn' => false, "errors" => $errors]);
    }

    /**
     * Выход
     */
    public function logout ()
    {
        return Auth::logout();
    }

    /**
     * Страница не найдена
     * @param null $params
     */
    public function notFound ($params = null)
    {
        echo "Страница не найдена!";
    }
}