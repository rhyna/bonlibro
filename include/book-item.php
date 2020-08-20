<div class="books-item">
    <?php if ($book->image): ?>
        <div class="books-item__img"
             style="background-image: url('<?= $ROOT_URL ?><?= $book->image ?>')">
            <a class="books-item__img-link"
               href="<?= $ROOT_URL ?>/book.php?id=<?= $book->id ?>">
            </a>
        </div>
    <?php else: ?>
        <div class="books-item__img books-item__img--deleted">
            <a class="books-item__img-link"
               href="<?= $ROOT_URL ?>/book.php?id=<?= $book->id ?>">
                Изображение отсутствует
            </a>
        </div>
    <?php endif; ?>
    <div class="books-item__info books-item__title">
        <a class="books-item__title-link"
           href="<?= $ROOT_URL ?>/book.php?id=<?= $book->id ?>">
            <?= $book->name ?>
        </a>
    </div>
    <div class="books-item__info books-item__author">
        <?= $book->author_name ?>
    </div>
    <div class="books-item__info books-item__publisher">
        <?= $book->publisher_name ?>
    </div>
    <div class="books-item__info books-item__series">
        <?= $book->series_name ?>
    </div>
    <?php if ($book->discount): ?>
        <div class="books-item__price--discounted"><?= $book->getDiscountedPrice() ?> p.</div>
        <div class="books-item__discount">
            <div><?= $book->price ?> p.</div>
            <span>(<?= $book->discount ?> %)</span>
        </div>
    <?php else: ?>
        <div class="books-item__info books-item__price">
            <?= $book->price ?>
            <span> p.</span>
        </div>
    <?php endif; ?>
</div>
