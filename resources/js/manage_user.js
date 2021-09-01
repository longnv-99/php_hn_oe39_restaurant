$('.btn-delete').click(function (ev) {
    ev.preventDefault();
    var _href = $(this).attr('href');

    $('form#form-delete').attr('action', _href);
    if (confirm('Are you sure to want to delete?')) {
        $('form#form-delete').submit();
    }
});

var is_active = document.getElementsByClassName('is_active'),
    btn_enable = document.getElementsByClassName('btn-enable'),
    btn_disable = document.getElementsByClassName('btn-disable');

for (var i = 0; i < is_active.length; i++) {
    if (is_active[i].innerText == 1) {
        btn_enable[i].style.display = 'none';
    } else {
        btn_disable[i].style.display = 'none';
    }
}
