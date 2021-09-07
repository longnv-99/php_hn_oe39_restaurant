import I18n from './vendor/I18n';
window.I18n = I18n;
/** click unfollow user from my profile */
$(document).on('click', '.btn.btn-secondary.unfollow', function() {
    let translator = new I18n;
    var id = $(this).attr("id");
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/follows/' + id,
        type: 'DELETE',
        data: {
            'id': id,
        },
        success: function(response) {
            var response = JSON.parse(response);
            if (response.statusCode == 200) {
                var number = parseInt($('#followingNumber').text());
                $('#followingNumber').text(number - 1);
                $('.btn.btn-secondary.unfollow#' + id).html('<i class="fas fa-user-plus"></i> ' + translator.trans('messages.follow'));
                $('.btn.btn-secondary.unfollow#' + id).attr('class', 'btn btn-info follow');
            }
        }
    });
});

/** click follow user from my profile */
$(document).on('click', '.btn.btn-info.follow', function() {
    let translator = new I18n;
    var id = $(this).attr("id");
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/follows',
        type: 'POST',
        data: {
            'id': id,
        },
        success: function(response) {
            var response = JSON.parse(response);
            if (response.statusCode == 200) {
                var number = parseInt($('#followingNumber').text());
                $('#followingNumber').text(number + 1);
                $('.btn.btn-info.follow#' + id).html('<i class="fas fa-ban"></i> ' + translator.trans('messages.unfollow'));
                $('.btn.btn-info.follow#' + id).attr('class', 'btn btn-secondary unfollow');
            }
        }
    });
});

/** click follow user from his/her profile */
$(document).on('click', '.btn.btn-primary.btn-block.follow', function() {
    let translator = new I18n;
    var id = $(this).attr("id");
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/follows',
        type: 'POST',
        data: {
            'id': id,
        },
        success: function(response) {
            var response = JSON.parse(response);
            if (response.statusCode == 200) {
                $('.btn.btn-primary.btn-block.follow').html(translator.trans('messages.unfollow'));
                $('.btn.btn-primary.btn-block.follow').attr('class', 'btn btn-danger btn-block unfollow');
            }
        }
    });
});

/** click unfollow user from his/her profile */
$(document).on('click', '.btn.btn-danger.btn-block.unfollow', function() {
    var id = $(this).attr("id");
    let translator = new I18n;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/follows/' + id,
        type: 'DELETE',
        data: {
            'id': id,
        },
        success: function(response) {
            var response = JSON.parse(response);
            if (response.statusCode == 200) {
                $('.btn.btn-danger.btn-block.unfollow').html(translator.trans('messages.follow'));
                $('.btn.btn-danger.btn-block.unfollow').attr('class', 'btn btn-primary btn-block follow');
            }
        }
    });
});
