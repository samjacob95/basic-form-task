$(document).ready(function () {
    var usernameWarning = $('#mailResultError');
    var tech = getUrlParameter('key');
    $('#reset').click(function() {
        var url = "http://localhost/mobiotics/api/user/reset-password.php";
        var formData = {
        'email' : $('#InputEmail').val(),
        'key' : key,
        'password' : $('#InputPassword').val(),
        };
        $.ajax({
        type : 'POST',
        url : url,
        data : JSON.stringify(formData),
        dataType : 'JSON',
        encode : true,
        success: function (response, status, xhr) {
            window.location = "http://localhost/mobiotics/frontend/login.html";
         },
        error: function (xhr, status, error) {
            var err = eval("(" + xhr.responseText + ")");
            $('#mailResultError').show();
            usernameWarning.html(err.message);
        }
        });
    });
});

var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
};
