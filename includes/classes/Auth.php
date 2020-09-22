<?php

namespace Task;

/**
 * Упрашенная авторизация by Rustam
 * Class Auth
 * @package Task
 */
class Auth
{
    /**
     * Авторизация
     * @param string $login
     * @param string $password
     * @return bool
     * @throws \Pixie\Exception
     */
    public static function login (string $login, string $password) :bool
    {
        $login = htmlspecialchars($login);
        $password = htmlspecialchars($password);
        $passwordHash = md5($password);

        $qb = DB::getConnection();
        $rsUser = $qb->table('user')->where("login", $login)->where("password", $passwordHash);
        if ($arUser = $rsUser->get()) {
            $_SESSION['login'] = $arUser[0]->login;
            return true;
        } else {
            return false;
        }
    }

    /**
     * Выход
     */
    public static function logout ()
    {
        session_destroy();
        session_unset();
        self::redirectToHome();
    }

    /**
     * Проверка авторизации
     * @return bool
     */
    public static function isAuthorized () :bool
    {
        return !empty($_SESSION['login']);
    }

    /**
     * Редирект к админке
     */
    public static function redirectToAdmin ()
    {
        header('Location: /admin');
        die();
    }

    /**
     * Редирект к форме авторизации
     */
    public static function redirectToLogin ()
    {
        header('Location: /login');
        die();
    }

    /**
     * Редирект на главную
     */
    public static function redirectToHome ()
    {
        header('Location: /');
        die();
    }
}