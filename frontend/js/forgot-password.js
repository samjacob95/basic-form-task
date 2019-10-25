$(document).ready(function () {
    var usernameWarning = $('#mailResultError');

    $('#reset').click(function() {
        var url = "http://localhost/mobiotics/api/user/forgot-password.php";
        var formData = {
        'email' : $('#InputEmail').val(),
        };
        $.ajax({
        type : 'POST',
        url : url,
        data : JSON.stringify(formData),
        dataType : 'JSON',
        encode : true,
        success: function (response, status, xhr) {
            $('#mailResultSuccess').show();
            $('#mailResultError').hide();
            $('#mailResultSuccess').html(response.message);
         },
        error: function (xhr, status, error) {
            var err = eval("(" + xhr.responseText + ")");
            $('#mailResultError').show();
            $('#mailResultSuccess').hide();
            usernameWarning.html(err.message);
        }
        });
    });
});
