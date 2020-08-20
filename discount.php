<?php

require_once 'include/init.php';
$conn = require_once 'include/db.php';

require_once 'include/header.php';

$totalBooks = Book::getTotalOfDiscountBooks($conn);

$token = '?';

if (!isset($_GET['page'])) {
    $_GET['page'] = 1;
}

$paginator = new Paginator($_GET['page'], 5, $totalBooks);

$discountBooks = Book::getDiscountBooksPage($conn, $paginator->limit, $paginator->offset) ?: null;
?>

<div class="main-content discountpage">
    <div class="container">
        <div class="row">
            <div class="col-3">
                <?php require_once 'include/sidebar.php'; ?>
            </div>
            <div class="col-9">
                <div class="row">
                    <div class="col">
                        <?php if (!$discountBooks): ?>
                            <p>Книги не найдены</p>
                        <?php else: ?>
                            <ul class="breadcrumbs breadcrumbs--discountbooks">
                                <li class="breadcrumbs-item">
                                    <a href="<?= $ROOT_URL ?>/">Главная</a>
                                </li>
                                <span class="breadcrumbs-arrow"> > </span>
                                <li class="breadcrumbs-item">
                                    <span>Акции</span>
                                </li>
                            </ul>
                            <div class="books discountbooks">
                                <h2 class="books__title">Акции</h2>
                                <div class="books__content">
                                    <?php foreach ($discountBooks as $book): ?>
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
