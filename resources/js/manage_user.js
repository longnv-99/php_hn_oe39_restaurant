$('.btn-delete').click(function (ev) {
    ev.preventDefault();
    var _href = $(this).attr('href');

    $('form#form-delete').attr('action', _href);
    if (confirm('Are you sure to want to delete?')) {
        $('form#form-delete').submit();
    }
});

var is_active = document.getElementsByClassName('is-active'),
    btn_change_user_status = document.getElementsByClassName('btn-change-user-status');

for (var i = 0; i < is_active.length; i++) {
    if (is_active[i].innerText == 1) {
        if (btn_change_user_status[i].classList.contains('btn-success')) {
            btn_change_user_status[i].classList.remove('btn-success');
        }
        btn_change_user_status[i].classList.add('btn-secondary');
    } else {
        if (btn_change_user_status[i].classList.contains('btn-secondary')) {
            btn_change_user_status[i].classList.remove('btn-secondary');
        }
        btn_change_user_status[i].classList.add('btn-success');
    }
}

$('.btn-change-user-status').click(function (ev) {
    ev.preventDefault();
    var _href = $(this).attr('href');

    $('form#form-update').attr('action', _href);
        $('form#form-update').submit(); console.log('hihi');
});
