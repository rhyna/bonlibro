<?php

require_once 'include/init.php';
$conn = require_once 'include/db.php';

require_once 'include/header.php';

$book = new Book();

if (isset($_GET['id'])) {
    $bookItem = $book->getBook($conn, $_GET['id']);

} else {
    $bookItem = null;
}

?>
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-3">
                <?php include_once 'include/sidebar.php' ?>
            </div>
            <div class="col-9">
                <div class="book">
                    <?php if (!$bookItem): ?>
                        <p>Книга не найдена</p>
                    <?php else: ?>
                        <?php if ($bookItem->image): ?>
                            <div class="book-img"
                                 style="background-image: url('<?= $ROOT_URL ?><?= $bookItem->image ?>')">
                            </div>
                        <?php else: ?>
                            <div class="book-img book-img--deleted">
                                Изображение отсутствует
                            </div>
                        <?php endif; ?>
                        <div class="book-info">
                            <ul class="breadcrumbs breadcrumbs--book">
                                <li class="breadcrumbs-item">
                                    <a href="<?= $ROOT_URL ?>/">Главная</a>
                                </li>
                                <span class="breadcrumbs-arrow">></span>
                                <li class="breadcrumbs-item">
                                    <a href="<?= $ROOT_URL ?>/category.php?category=<?= $bookItem->category_id ?>"><?= $bookItem->category_name ?></a>
                                </li>
                                <span class="breadcrumbs-arrow">></span>
                                <li class="breadcrumbs-item">
                                    <span><?= $bookItem->name ?></span>
                                </li>
                            </ul>
                            <div class="book-title"><?= $bookItem->name ?></div>
                            <div class="book-item-info book-setnumber">
                                <span>Артикул: </span><span><?= $bookItem->set_number ?></span></div>
                            <?php if ($bookItem->discount): ?>
                                <div class="book-price book-price--discounted"><?= $bookItem->getDiscountedPrice() ?> p.</div>
                                <div class="book-price-discount">
                                    <div><?= $bookItem->price ?> p.</div>
                                    <span>(<?= $bookItem->discount ?> %)</span>
                                </div>
                            <?php else: ?>
                                <div class="book-price"><?= $bookItem->price ?> p.</div>
                            <?php endif; ?>
                            <div class="book-item-info book-publisher"><span>Издательство: </span><a
                                        href=""><?= $bookItem->publisher_name ?></a></div>
                            <div class="book-item-info book-author"><span>Автор: </span><a
                                        href=""><?= $bookItem->author_name ?></a></div>
                            <div class="book-item-info book-series"><span>Серия: </span><a
                                        href=""><?= $bookItem->series_name ?></a></div>
                            <div class="book-description"><?= $bookItem->description ?></div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'include/footer.php' ?>

