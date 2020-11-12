$('.edit-book-delete-image-button').on('click', function (e) {

    let bookId = $(this).data('id');
    let button = $(this);

    $.ajax({
        url: '/admin/delete-book-image.php',
        type: 'POST',
        data: {id: bookId},
    })
        .done(function (response) { // when the server code is 200
            $('.edit-book-form-image')
                .html('Изображение отсутствует')
                .addClass('edit-book-form-image--deleted')
                .css('background-image', '');
            $(button).addClass('edit-book-delete-image-button--deleted');
        })
        .fail(function (response) { // when the server code is other than 200
            alert('An error occurred');
        })
})

$('.admin-books-item__delete button').on('click', function (e) {
    let bookId = $(this).data('id');

    $(".delete-book-form input[type='hidden']").val(bookId);

})