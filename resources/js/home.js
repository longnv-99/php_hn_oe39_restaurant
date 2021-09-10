$(document).on('change', '.custom-file-input', function() {
    let image = $("input[name=image]").prop('files')[0]['name'];
    $('.custom-file-label').text(image);
})

$(".alert.alert-block").fadeTo(2000, 500).slideUp(500, function() {
    $(".alert.alert-block").slideUp(500);
});

$(document).on('click', '.clickable-row', function() {
    window.location = $(this).data('href');
});

$(document).on('click', '#logout-btn', function () {
    event.preventDefault();
    document.getElementById('logout-form').submit();
});

$("form.delete-form").submit(function (e) {
  var $message = $(this).data('message');
  if(!confirm($message)){
    e.preventDefault();
  }
});
