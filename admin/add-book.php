<?php

require_once '../include/init.php';

Auth::ifNotLoggedIn();

$conn = require_once '../include/db.php';

$book = new Book();

$allCategories = Category::getAllCategories($conn);

$allAuthors = Author::getAllAuthors($conn);

$allPublishers = Publisher::getAllPublishers($conn);

$allSeries = Series::getAllSeries($conn);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $book->fillBookObject($_POST);

    $book->createBook($conn);

    include_once $ROOT . '/admin/include/upload-image.php';

    if (!$book->imageErrors && !$book->errors) {
        Url::redirect("$ROOT_URL/admin");
    }

}

$mode = 'add-book';

require_once '../include/header.php';

?>

<div class="container">
    <div class="main-content add-book-page">
        <div class="add-book-title">
            Добавить книгу
        </div>
        <?php include_once 'book-form.php' ?>
    </div>
</div>

<?php require_once '../include/footer.php'; ?>
