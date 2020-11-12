<?php

if ($_FILES['image']['name'] != '') {
    $extensions = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif'];
    $imageErrors = [];

    try {
        $errorMessages = [];

        if ($_FILES['image']['size'] > 1000000) {
            $errorMessages[] = 'Слишком большой файл, максимум 1 Мб';
        }

        if (!in_array($_FILES['image']['type'], $extensions)) {
            $errorMessages[] = 'Файл не является картинкой, допустимые расширения: png, jpeg, jpg, gif';
        }

        if ($errorMessages) {
            $errorMessage = implode('<br>', $errorMessages);
            throw new Exception($errorMessage);
        }

    } catch (Exception $e) {
        $imageErrors = $e->getMessage();
        $imageErrors = explode('<br>', $imageErrors);
        $book->imageErrors = $imageErrors;
    }

    if (!$book->imageErrors && !$book->errors) {
        $pathInfo = pathinfo($_FILES['image']['name']);

        $base = $pathInfo['filename'];

        $base = preg_replace('/[^a-zA-Z0-9_-]/', '_', $base); // all except a-z, A-Z, 0-9, _, -

        $fileName = $base . '.' . $pathInfo['extension'];

        $imageUploadDestination = '/upload/books-images/' . $fileName;

        for ($i = 1; file_exists($ROOT . $imageUploadDestination); $i++) {
            $imageUploadDestination = '/upload/books-images/' . $base . '-' . $i . '.' . $pathInfo['extension'];
        }

        move_uploaded_file($_FILES['image']['tmp_name'], $ROOT . $imageUploadDestination);

        $previousImage = $book->image;

        $book->image = $imageUploadDestination;

        if ($book->setBookImage($conn, $imageUploadDestination)) {
            if ($previousImage) {
                unlink($ROOT . $previousImage);
            }
        }
    }
}