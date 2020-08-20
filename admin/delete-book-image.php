<?php

require_once '../include/init.php';

Auth::ifNotLoggedIn();

$conn = require_once '../include/db.php';

if (!isset($_POST['id'])) {
    echo 'Такой книги нет';
    exit;
}

$bookItem = new Book();

$book = $bookItem->getBook($conn, $_POST['id']);

$previousImage = $book->image;

if ($book->setBookImage($conn, null)) {
    if ($previousImage) {
        unlink($ROOT . $previousImage);
    }
}

