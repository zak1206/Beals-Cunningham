$(function(){
    $("#front_signin").validate({
        submitHandler: function(form) {
            var formName = $(form).attr('id');
            $.ajax({
                type: "POST",
                url: 'inc/shortCalls.php?action=loginfront',
                data: new FormData(form),
                contentType: !1,
                cache: !1,
                processData: !1,
                success: function(data) {
                    var response = $.parseJSON(data);
                    var rescode = response.code;
                    var resmessage = response.message;
                    if (rescode != 'good') {
                        $("#" + formName).prepend('<div class="alert alert-danger">' + resmessage + '</div>')
                    } else {
                       // $("#" + formName).remove();
                        $("#" + formName).prepend('<div class="alert alert-success">' + resmessage + '</div>');
                        location.reload();
                    }
                }
            })
        }
    })
})
