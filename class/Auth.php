<?php


class Auth
{
    static public function login()
    {
        session_regenerate_id(true);
        $_SESSION['is_logged_in'] = true;
    }

    static public function isLoggedIn()
    {
        return isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'];
    }

    static public function logout()
    {
        $_SESSION = array();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();
    }

    static public function ifNotLoggedIn() {
        global $ROOT_URL;

        if (!self::isLoggedIn()) {
            echo 'Доступ запрещен, ' . '<a href="' . $ROOT_URL . '/login.php' . '">авторизуйтесь</a>';
            die;
        }
    }
}