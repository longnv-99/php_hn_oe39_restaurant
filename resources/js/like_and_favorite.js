$(document).on('click', '.btn-like', function (ev) {
    ev.preventDefault();
    var btn_like = $(this);
    var book_id = btn_like.attr('id');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/likes',
        data: {
            'book_id': book_id,
        },
        type: 'POST',
        success: function (response) {
            var response = JSON.parse(response);
            if (response.statusCode == 200) {
                total_like = parseInt($('.btn-like #total-like-' + book_id).text());
                $('.btn-like #total-like-' + book_id).text(total_like + 1);
                btn_like.removeClass('btn-like btn-outline-primary');
                btn_like.addClass('btn-unlike btn-primary');
            }
        }
    });
});

$(document).on('click', '.btn-unlike', function (ev) {
    ev.preventDefault();
    var btn_unlike = $(this);
    var book_id = btn_unlike.attr('id');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/likes/' + book_id,
        data: {
            'book_id': book_id,
        },
        type: 'DELETE',
        success: function (response) {
            var response = JSON.parse(response);
            if (response.statusCode == 200) {
                total_like = parseInt($('.btn-unlike #total-like-' + book_id).text());
                $('.btn-unlike #total-like-' + book_id).text(total_like - 1);
                btn_unlike.removeClass('btn-unlike btn-primary');
                btn_unlike.addClass('btn-like btn-outline-primary');
            }
        }
    });
});

$(document).on('click', '.btn-mark-favorite', function (ev) {
    ev.preventDefault();
    var btn_mark_favorite = $(this);
    var book_id = btn_mark_favorite.attr('id');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/favorites',
        type: 'POST',
        data: {
            'book_id': book_id,
        },
        success: function (response) {
            var response = JSON.parse(response);
            if (response.statusCode == 200) {
                btn_mark_favorite.removeClass('btn-mark-favorite btn-outline-danger');
                btn_mark_favorite.addClass('btn-unmark-favorite btn-danger');
            }
        }
    });
});

$(document).on('click', '.btn-unmark-favorite', function (ev) {
    ev.preventDefault();
    var btn_unmark_favorite = $(this);
    var book_id = btn_unmark_favorite.attr('id');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/favorites/' + book_id,
        type: 'DELETE',
        data: {
            'book_id': book_id,
        },
        success: function (response) {
            var response = JSON.parse(response);
            if (response.statusCode == 200) {
                btn_unmark_favorite.removeClass('btn-unmark-favorite btn-danger');
                btn_unmark_favorite.addClass('btn-mark-favorite btn-outline-danger');
            }
        }
    });
});
