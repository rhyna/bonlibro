<?php

require_once '../include/init.php';

Auth::ifNotLoggedIn();

$conn = require_once '../include/db.php';

$bookItem = new Book();

if (isset($_POST['bookId'])) {
    $book = $bookItem->getBook($conn, $_POST['bookId']);

} else {
    $book = null;
}


if ($book) {
    if ($book->deleteBook($conn)) {
        $bookImage = $book->image;

        if ($bookImage) {
            unlink($ROOT . $bookImage);
        }

        Url::redirect("$ROOT_URL/admin");
    }
} else {
    echo 'Книга не найдена';
}




