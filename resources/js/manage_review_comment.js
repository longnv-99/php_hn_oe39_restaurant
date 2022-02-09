var review_display = document.getElementsByClassName('review-display'),
    comment_display = document.getElementsByClassName('comment-display'),
    review_content = document.getElementsByClassName('review-content'),
    comment_content = document.getElementsByClassName('comment-content'),
    rv_hide = document.getElementsByClassName('rv-hide'),
    rv_show = document.getElementsByClassName('rv-show'),
    cmt_hide = document.getElementsByClassName('cmt-hide'),
    cmt_show = document.getElementsByClassName('cmt-show');

for (i = 0; i < review_display.length; i++) {
    if (review_display[i].innerText == 1) {
        rv_show[i].style.display = 'none';
        review_content[i].style.display = 'block';
    } else {
        rv_hide[i].style.display = 'none';
        review_content[i].style.display = 'none';
    }
}

for (i = 0; i < comment_display.length; i++) {
    if (comment_display[i].innerText == 1) {
        cmt_show[i].style.display = 'none';
        comment_content[i].style.display = 'block';
    } else {
        cmt_hide[i].style.display = 'none';
        comment_content[i].style.display = 'none';
    }
}

$(document).on('click', '.rv-hide', function (ev) {
    ev.preventDefault();
    var review_id = $(this).attr('id');
    $('#' + review_id + '.review-content').hide();
    $('#' + review_id + '.rv-hide').hide();
    $('#' + review_id + '.rv-show').show();

    $.ajax({
        url: $(this).attr('href'),
        type: 'GET',
        success: function (response) {
            $('#' + review_id + '.rv-success').append(`
                <span class="badge badge-success">${response.success}</span>
            `);

            $('.badge.badge-success').fadeTo(2000, 500).slideUp(500, function() {
                $('.badge.badge-success').slideUp(500);
            });
        }
    });

    $('.badge.badge-success').remove();

    $('.cmt-hide-rv-' + review_id).hide();
    $('.cmt-content-rv-' + review_id).hide();
    $('.cmt-show-rv-' + review_id).show();
});

$(document).on('click', '.rv-show', function (ev) {
    ev.preventDefault();
    var review_id = $(this).attr('id');
    $('#' + review_id + '.review-content').show();
    $('#' + review_id + '.rv-hide').show();
    $('#' + review_id + '.rv-show').hide();

    $.ajax({
        url: $(this).attr('href'),
        type: 'GET',
        success: function (response) {
            $('#' + review_id + '.rv-success').append(`
                <span class="badge badge-success">${response.success}</span>
            `);

            $('.badge.badge-success').fadeTo(2000, 500).slideUp(500, function() {
                $('.badge.badge-success').slideUp(500);
            });
        }
    });

    $('.badge.badge-success').remove();

    $('.cmt-hide-rv-' + review_id).show();
    $('.cmt-content-rv-' + review_id).show();
    $('.cmt-show-rv-' + review_id).hide();
});

$(document).on('click', '.cmt-hide', function (ev) {
    ev.preventDefault();
    var comment_id = $(this).attr('id');
    $('#' + comment_id + '.comment-content').hide();
    $('#' + comment_id + '.cmt-hide').hide();
    $('#' + comment_id + '.cmt-show').show();

    $.ajax({
        url: $(this).attr('href'),
        type: 'GET',
        success: function (response) {
            $('#' + comment_id + '.cmt-success').append(`
                <span class="badge badge-success">${response.success}</span>
            `);
            $('.badge.badge-success').fadeTo(2000, 500).slideUp(500, function() {
                $('.badge.badge-success').slideUp(500);
            });
        }
    });

    $('.badge.badge-success').remove();
});

$(document).on('click', '.cmt-show', function (ev) {
    ev.preventDefault();
    var comment_id = $(this).attr('id');
    $('#' + comment_id + '.comment-content').show();
    $('#' + comment_id + '.cmt-hide').show();
    $('#' + comment_id + '.cmt-show').hide();

    $.ajax({
        url: $(this).attr('href'),
        type: 'GET',
        success: function (response) {
            $('#' + comment_id + '.cmt-success').append(`
                <span class="badge badge-success">${response.success}</span>
            `);
            $('.badge.badge-success').fadeTo(2000, 500).slideUp(500, function() {
                $('.badge.badge-success').slideUp(500);
            });
        }
    });

    $('.badge.badge-success').remove();
});
