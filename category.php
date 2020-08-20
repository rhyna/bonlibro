<?php
require_once 'include/init.php';
$conn = require_once 'include/db.php';

require_once 'include/header.php';

$totalBooks = Book::getTotalOfBooksByCategory($conn, $_GET['category']);

$token = '&';

if (!isset($_GET['page'])) {
    $_GET['page'] = 1;
}

$paginator = new Paginator($_GET['page'], 5, $totalBooks);

if (isset($_GET['category'])) {
    $booksByCategory = Book::getCategoryPage($conn, $_GET['category'], $paginator->limit, $paginator->offset);
} else {
    $booksByCategory = null;
}

?>

<div class="main-content categorypage">
    <div class="container">
        <div class="row">
            <div class="col-3">
                <?php require_once 'include/sidebar.php'; ?>
            </div>
            <div class="col-9">
                <div class="row">
                    <div class="col">
                        <?php if (!$booksByCategory): ?>
                            <p>Книги не найдены</p>
                        <?php else: ?>
                            <ul class="breadcrumbs breadcrumbs--booksbycategory">
                                <li class="breadcrumbs-item">
                                    <a href="<?= $ROOT_URL ?>/">Главная</a>
                                </li>
                                <span class="breadcrumbs-arrow"> > </span>
                                <li class="breadcrumbs-item">
                                    <span><?= $booksByCategory[0]->category_name ?></span>
                                </li>
                            </ul>
                            <div class="books booksbycategory">
                                <h2 class="books__title"><?= $booksByCategory[0]->category_name ?></h2>
                                <div class="books__content">
                                    <?php foreach ($booksByCategory as $book): ?>
                                        <?php include "include/book-item.php"; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php include_once 'include/pagination.php' ?>
            </div>
        </div>
    </div>
</div>

<?php require_once 'include/footer.php' ?>

