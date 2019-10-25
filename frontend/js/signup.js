$(document).ready(function () {
    var usernameWarning = $('#usernameResult');

    $('#register').click(function() {
        var url = "http://localhost/mobiotics/api/user/registration.php";
        var formData = {
        'name' : $('#InputName').val(),
        'email' : $('#InputEmail').val(),
        'password' : $('#InputPassword').val(),
        'confirm_password' : $('#RepeatPassword').val(),
        };
        $.ajax({
        type : 'POST',
        url : url,
        data : JSON.stringify(formData),
        dataType : 'JSON',
        encode : true,
        success: function (response, status, xhr) {alert(response.message);
            window.location = "http://localhost/mobiotics/frontend/login.html";
        },
        error: function (xhr, status, error) {
            var err = eval("(" + xhr.responseText + ")");
            $('#usernameResult').show();
            usernameWarning.html(err.message);
        }
        });
    });
});
