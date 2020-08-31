<?php

require_once 'include/init.php';
$conn = require_once 'include/db.php';

require_once 'include/header.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (User::authenticate($conn, $_POST['username'], $_POST['password'])) {
        Auth::login();
        Url::redirect($ROOT_URL . '/admin/?page=1');
    } else {
        echo 'Авторизоваться не удалось. Проверьте логин и пароль';
        exit;
    }
}

?>

<div class="container">
    <div class="row">
        <div class="col">
            <div class="main-content login-page">
                <h1 class="login-form-title">Авторизация</h1>
                <div class="login-form">
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="username">Логин</label>
                            <input type="text" name="username" class="form-control" id="username">
                        </div>
                        <div class="form-group">
                            <label for="password">Пароль</label>
                            <input type="password" name="password" class="form-control" id="password">
                        </div>
                        <button type="submit" class="btn btn-primary">Войти</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<?php require_once 'include/footer.php' ?>

