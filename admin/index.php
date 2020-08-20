<?php

require_once '../include/init.php';

Auth::ifNotLoggedIn();

$conn = require_once '../include/db.php';

$books = Book::getAllBooks($conn);

require_once '../include/header.php';

?>

<div class="main-content admin-page">
    <div class="container">
        <a href="<?= $ROOT_URL ?>/admin/add-book.php" class="admin-add-book">Добавить книгу</a>
        <div class="admin-books">
            <div class="admin-books__header">
                <div class="row">
                    <div class="col-9">Название</div>
                    <div class="col">Артикул</div>
                    <div class="col"></div>
                    <div class="col"></div>
                </div>
            </div>
            <?php foreach ($books as $book): ?>
                <div class="admin-books-item">
                    <div class="row">
                        <div class="col-9">
                            <div class="admin-books-item__title">
                                <a href="<?= $ROOT_URL ?>/book.php?id=<?= $book['id'] ?>">
                                    <?= $book['name'] ?>
                                </a>
                            </div>
                        </div>
                        <div class="col">
                            <div class="admin-books-item__setnumber"><?= $book['set_number'] ?></div>
                        </div>
                        <div class="col">
                            <div class="admin-books-item__edit">
                                <a href="<?= $ROOT_URL ?>/admin/edit-book.php?id=<?= $book['id'] ?>">
                                    <i class="far fa-edit"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col">
                            <div class="admin-books-item__delete">
                                <button type="button" data-toggle="modal"
                                        data-target="#exampleModal" data-id="<?= $book['id'] ?>" style="background: none">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<form action="<?= $ROOT_URL ?>/admin/delete-book.php" class="delete-book-form" method="post">
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    Вы уверены, что хотите удалить книгу?
                </div>
                <input type="hidden" value="" name="bookId">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-danger">Удалить</button>
                </div>
            </div>
        </div>
    </div>
</form>


<?php require_once '../include/footer.php'; ?>

