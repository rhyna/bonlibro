<?php
if ($mode === 'edit-book') {
    $classMode = 'edit';
}

if ($mode === 'add-book') {
    $classMode = 'add';
}
?>

<?php if ($book->errors): ?>
    <ul class="<?= $classMode ?>-book-errors">
        <?php foreach ($book->errors as $error): ?>
            <li class="<?= $classMode ?>-book-errors-item"><?= $error ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
<?php if ($book->imageErrors): ?>
    <ul class="<?= $classMode ?>-book-errors <?= $classMode ?>-book-errors--image">
        <?php foreach ($book->imageErrors as $imageError): ?>
            <li class="<?= $classMode ?>-book-errors-item"><?= $imageError ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
<form action="" method="post" enctype="multipart/form-data" id="bookForm" class="<?= $classMode ?>-book-form">
    <div class="form-group">
        <label for="name">Название</label>
        <input class="form-control" type="text" name="name" id="name"
               value="<?= htmlspecialchars($book->name) ?>">
    </div>
    <div class="form-group">
        <label for="price">Цена, руб</label>
        <input class="form-control" type="number" name="price" id="price"
               value="<?= htmlspecialchars($book->price) ?>">
    </div>
    <div class="form-group">
        <label for="discount">Скидка, %</label>
        <input class="form-control" type="number" name="discount" id="discount"
               value="<?= htmlspecialchars($book->discount) ?>">
    </div>
    <?php if ($book->discount): ?>
        <p style="font-style: italic;">Цена со скидкой - <?= $book->getDiscountedPrice(); ?> руб.</p>
    <?php endif; ?>
    <div class="form-group">
        <label for="setnumber">Артикул</label>
        <input class="form-control" type="number" name="setnumber" id="setnumber"
               value="<?= htmlspecialchars($book->set_number) ?>" <?= ($mode === 'edit-book') ? 'readonly' : '' ?>>
    </div>
    <div class="form-group">
        <label for="description">Описание</label>
        <textarea class="form-control" name="description" id="description"
                  rows="5"><?= htmlspecialchars($book->description) ?></textarea>
    </div>
    <div class="form-group">
        <label for="category">Категория</label>
        <select class="form-control" id="category" name="categoryId">
            <?php foreach ($allCategories as $category): ?>
                <option value="<?= $category['id'] ?>"
                    <?php if ($mode === 'edit-book'): ?>
                        <?php if ($category['id'] === $book->category_id): ?>
                            selected="selected"
                        <?php endif; ?>
                    <?php endif; ?>
                ><?= $category['name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="author">Автор</label>
        <select class="form-control" id="author" name="authorId">
            <?php foreach ($allAuthors as $author): ?>
                <option value="<?= $author['id'] ?>"
                    <?php if ($mode === 'edit-book'): ?>
                        <?php if ($author['id'] === $book->author_id): ?>
                            selected="selected"
                        <?php endif; ?>
                    <?php endif; ?>
                ><?= $author['name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="publisher">Издательство</label>
        <select class="form-control" id="publisher" name="publisherId">
            <option value=""> -</option>
            <?php foreach ($allPublishers as $publisher): ?>
                <option value="<?= $publisher['id'] ?>"
                    <?php if ($mode === 'edit-book'): ?>
                        <?php if ($publisher['id'] === $book->publisher_id): ?>
                            selected="selected"
                        <?php endif; ?>
                    <?php endif; ?>
                ><?= $publisher['name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="series">Серия</label>
        <select class="form-control" id="series" name="seriesId">
            <option value=""> -</option>
            <?php foreach ($allSeries as $series): ?>
                <option value="<?= $series['id'] ?>"
                    <?php if ($mode === 'edit-book'): ?>
                        <?php if ($series['id'] === $book->series_id): ?>
                            selected="selected"
                        <?php endif; ?>
                    <?php endif; ?>
                ><?= $series['name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <p>Бестселлер</p>
        <p>
            <input type="radio" id="bestsellerTrue" name="isBestseller" value="1"
                <?php if ($mode === 'edit-book'): ?>
                    <?php if ($book->is_bestseller === '1'): ?>
                        checked="checked"
                    <?php endif; ?>
                <?php endif; ?>
            >
            <label for="bestsellerTrue">Да</label>
        </p>
        <p>
            <input type="radio" id="bestsellerFalse" name="isBestseller" value="0"
                <?php if ($mode === 'edit-book'): ?>
                    <?php if ($book->is_bestseller === '0'): ?>
                        checked="checked"
                    <?php endif; ?>
                <?php endif; ?>
                <?php if ($mode === 'add-book'): ?>
                    checked="checked"
                <?php endif; ?>
            >
            <label for="bestsellerFalse">Нет</label>
        </p>
    </div>
    <div class="form-group">
        <p>Новинка</p>
        <p>
            <input type="radio" id="newTrue" name="isNew" value="1"
                <?php if ($mode === 'edit-book'): ?>
                    <?php if ($book->is_new === '1'): ?>
                        checked="checked"
                    <?php endif; ?>
                <?php endif; ?>
            >
            <label for="newTrue">Да</label>
        </p>
        <p>
            <input type="radio" id="newFalse" name="isNew" value="0"
                <?php if ($mode === 'edit-book'): ?>
                    <?php if ($book->is_new === '0'): ?>
                        checked="checked"
                    <?php endif; ?>
                <?php endif; ?>
                <?php if ($mode === 'add-book'): ?>
                    checked="checked"
                <?php endif; ?>
            >
            <label for="newFalse">Нет</label>
        </p>
    </div>
    <div class="form-group">
        <label for="image">Изображение</label>
        <div class="<?= $classMode ?>-book-form-image <?= $book->image ? '' : $classMode . '-book-form-image--deleted' ?>"
            <?= ($book->image ? 'style="background-image: url(' . $ROOT_URL . $book->image . ')"' : null) ?>>
            <?= !$book->image ? 'Изображение отсутствует' : null ?>
        </div>
        <input class="form-control-file" name="image" id="image" type="file">
    </div>
    <div class="form-group <?= $classMode ?>-book-delete-image">
        <?php if ($book->image): ?>
            <button type="button" class="btn btn-danger <?= $classMode ?>-book-delete-image-button" name="delete-image"
                    data-id="<?= $book->id ?>">
                Удалить картинку
            </button>
        <?php endif; ?>
    </div>
    <button type="submit" class="btn btn-primary <?= $classMode ?>-book-submit">Отправить</button>
</form>