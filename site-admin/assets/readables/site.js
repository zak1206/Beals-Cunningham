$(function() {

  ///THIS IS A CORE FUNCTION THAT HELPS THE FORMS WORK.. DO NOT DELETE///
    $(".form-process").validate({
        submitHandler: function(form) {
            var formName = $(form).attr('id');
            $.ajax({
                type: "POST",
                url: 'inc/shortCalls.php?action=formsubmit',
                data: new FormData(form),
                contentType: !1,
                cache: !1,
                processData: !1,
                success: function(data) {
                    var response = $.parseJSON(data);
                    var rescode = response.code;
                    var resmessage = response.message;
                    if (rescode == 'invalid') {
                        $("#" + formName + "_alerts").html('<div class="alert alert-danger">' + resmessage + '</div>')
                    } else {
                        $("#" + formName).remove();
                        $("#" + formName + "_alerts").html('' + resmessage + '')
                    }
                }
            })
        }
    })

    //Caffeine Click Event - DO NOT DELETE//

    $("[data-cafftrak]").on( "click", function () {
        var eventTar = $(this).data('cafftrak');
        var href = document.location.href;
        var lastPathSegment = href.substr(href.lastIndexOf('/') + 1);
        //console.log(eventTar);
        $.ajax({
            url:'inc/ajaxCalls.php?action=eventtrak&target='+eventTar+'&page='+lastPathSegment,
            success: function(data){
                // alert(data);
            }
        })
    } );
  
})

lozad('.lozad', {
    load: function(el) {
        el.src = el.dataset.src;
        el.onload = function() {
        }
    }
}).observe()
