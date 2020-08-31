<?php

require_once '../include/init.php';

Auth::ifNotLoggedIn();

$conn = require_once '../include/db.php';

$bookItem = new Book();

if (isset($_GET['id'])) {
    $book = $bookItem->getBook($conn, $_GET['id']);

} else {
    $book = null;
}

$allCategories = Category::getAllCategories($conn);

$allAuthors = Author::getAllAuthors($conn);

$allPublishers = Publisher::getAllPublishers($conn);

$allSeries = Series::getAllSeries($conn);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $book->fillBookObject($_POST);

    $updateBookResult = $book->updateBook($conn);

    include_once $ROOT . '/admin/include/upload-image.php';

    if (!$book->imageErrors && !$book->errors) {
        Url::redirect("$ROOT_URL/admin");
    }
}

$mode = 'edit-book';

require_once '../include/header.php';

?>

<div class="container">
    <div class="main-content edit-book-page">
        <div class="edit-book-title">Редактировать книгу</div>
        <?php if (!$book): ?>
            <?php echo 'Такой книги нет' ?>
        <?php else: ?>
            <?php include_once 'book-form.php' ?>
        <?php endif; ?>
    </div>
</div>

<?php require_once '../include/footer.php'; ?>


