<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Bonlibro</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
          crossorigin="anonymous">
    <link rel="stylesheet" href="<?= $ROOT_URL ?>/css/styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Condensed">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=PT+Sans">
    <link rel="stylesheet" href="<?= $ROOT_URL ?>/vendor/fontawesome-free-5.13.1-web/css/all.css">
</head>
<body>
<header>
    <div class="container">
        <div class="row">
            <div class="col-9">
                <div class="logo">
                    <a href="<?= $ROOT_URL ?>/"></a>
                </div>
            </div>
            <div class="col-3">
                <div class="contacts">
                    <div class="contacts-tel">
                        <div class="contacts-tel-img--life"></div>
                        <div class="contacts-tel-text"><span>+375 29</span> 654-85-97</div>
                    </div>
                    <div class="contacts-tel">
                        <div class="contacts-tel-img--mts"></div>
                        <div class="contacts-tel-text"><span>+375 29</span> 207-85-97</div>
                    </div>
                    <div class="contacts-text">Прием звонков с 11.00 до 18.00</div>

                </div>
            </div>
        </div>
        <?php if (Auth::isLoggedIn()): ?>
        <nav class="admin-header-nav navbar navbar-light bg-light">
            <ul class="nav">
                <li class="nav-item">
                    <a href="<?= $ROOT_URL ?>/" class="nav-link">Главная</a>
                </li>
                <li class="nav-item">
                    <a href="<?= $ROOT_URL ?>/admin/?page=1" class="nav-link">Админ-панель</a>
                </li>
                <li class="nav-item">
                    <a href="<?= $ROOT_URL ?>/logout.php" class="nav-link">Выйти</a>
                </li>
            </ul>
        </nav>
        <?php endif; ?>
    </div>
</header>
