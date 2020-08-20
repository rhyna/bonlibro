<?php


class User
{
    public $id;
    public $username;
    public $password;

    public static function authenticate($conn, $username, $password): bool
    {
        $sql = 'SELECT * from user WHERE username = :username';
        $statement = $conn->prepare($sql);

        $statement->bindValue(':username', $username, PDO::PARAM_STR);

        $statement->setFetchMode(PDO::FETCH_CLASS, 'User');

        $statement->execute();

        if ($user = $statement->fetch()) {
            return md5($password) === $user->password;
        }

        return false;
    }
}