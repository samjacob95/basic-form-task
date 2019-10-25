$(document).ready(function () {
    var usernameWarning = $('#listingResult');

    var qsParm = new Array();
    function qs() {
        var query = window.location.search.substring(1);
        var parms = query.split('&');
        for (var i=0; i < parms.length; i++) {
            var pos = parms[i].indexOf('=');
            if (pos > 0) {
                var key = parms[i].substring(0, pos);
                var val = parms[i].substring(pos + 1);
                qsParm[key] = val;
            }
        }
    }

    getData();
    qs();
    function getData(){
        $.ajax({
            type : 'GET',
            url : "http://localhost/mobiotics/api/user/dashboard.php",
            dataType : 'JSON',
            encode : true,
            success: function (response, status, xhr) {
            if(xhr.status == '201'){
                $('#thetable').show();
                $('#listingResult').hide();
                var table = $("#thetable tbody");
                $.each(response.data, function(idx, elem){
                    table.append('<tr><th scope="row">'+elem.id+"</th><td>"
                                    +elem.title+"</td>   <td>"
                                    +elem.category+"</td>   <td>"
                                    +elem.initiator+"</td>   <td>"
                                    +elem.initiator_email+"</td>   <td>"
                                    +elem.assignee+"</td>   <td>"
                                    +elem.priority+"</td>   <td>"
                                    +elem.status+"</td>   <td>"
                                    +elem.created_date+"</td><td>"
                                    +'<button type="button" id="update" class="btn btn-success" data-id="'+elem.id+'">Update</button></td></tr>'
                    );
                });
            }
            if(xhr.status == '200'){
                $('#thetable').hide();
                $('#listingResult').show();
                usernameWarning.html(response.message);
            }
            },
            error: function (xhr, status, error) {
                $('#listingResult').show();
                usernameWarning.html('Something unexpected occured');
            }
        });
    }

    $('#create').click(function() {
        var url = "http://localhost/mobiotics/api/user/request.php";
        var formData = {
        'title' : $('#InputTitle').val(),
        'category' : $('#InputCategory').val(),
        'initiator' : $('#InputInitiator').val(),
        'initiator_email' : $('#InputEmail').val(),
        'assignee' : $('#InputAssignee').val(),
        'priority' : $('#InputPriority').val(),
        'status' : $('#InputStatus').val(),
        'created_date' : $('#InputDate').val(),
        'user_id' : qsParm['id'],
        };
        $.ajax({
        type : 'POST',
        url : url,
        data : JSON.stringify(formData),
        dataType : 'JSON',
        encode : true,
        success: function (response, status, xhr) {
            getData();
            $('#listingResultSuccess').show();
            $('#listingResult').hide();
            $('#listingResultSuccess').html(response.message);
         },
        error: function (xhr, status, error) {
            var err = eval("(" + xhr.responseText + ")");
            $('#listingResult').show();
            $('#listingResultSuccess').hide();
            usernameWarning.html(err.message);
        }
        });
    });
    $(document).on("click", "#update" , function() {
        var url = "http://localhost/mobiotics/api/user/read.php";
        var formData = {
        'id' : $(this).attr("data-id")
        };
        $.ajax({
        type : 'POST',
        url : url,
        data : JSON.stringify(formData),
        dataType : 'JSON',
        encode : true,
        success: function (response, status, xhr) {
            var res = response.data.created_date.split(" ");
    
            jQuery.noConflict();
            $('#myModal').modal('show');
                    $("#InputTitle").val(response.data.title);
            $("#InputCategory").val(response.data.category);
            $("#InputInitiator").val(response.data.initiator);
            $("#InputEmail").val(response.data.initiator_email);
            $("#InputAssignee").val(response.data.assignee);
            $("#titlInputPriority").val(response.data.priority);
            $("#InputStatus").val(response.data.status);
            $("#InputDate").val(res[0]);
    
         },
        error: function (xhr, status, error) {
            var err = eval("(" + xhr.responseText + ")");
            $('#listingResult').show();
            $('#listingResultSuccess').hide();
            usernameWarning.html(err.message);
        }
        });
    });
});


