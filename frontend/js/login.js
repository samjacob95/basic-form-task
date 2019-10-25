$(document).ready(function () {
    var usernameWarning = $('#usernameResult');

    $('#login').click(function() {
        var url = "http://localhost/mobiotics/api/user/login.php";
        var formData = {
        'email' : $('#InputEmail').val(),
        'password' : $('#InputPassword').val(),
        };
        $.ajax({
        type : 'POST',
        url : url,
        data : JSON.stringify(formData),
        dataType : 'JSON',
        encode : true,
        success: function (response, status, xhr) {
            window.location = "http://localhost/mobiotics/frontend/dashboard.html?id=" + response.id;
        },
        error: function (xhr, status, error) {
            var err = eval("(" + xhr.responseText + ")");
            $('#usernameResult').show();
            usernameWarning.html(err.message);
        }
        });
    });
});
