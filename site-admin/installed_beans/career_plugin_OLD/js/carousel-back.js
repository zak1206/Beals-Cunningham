


    $(function(){
        $(".toggle-edit").on('click',function(){
            $(".formeditars").toggle();
        });
    });

    $( function() {
        $( "#sortable" ).sortable();
        $( "#sortable" ).disableSelection();
    } );


    var form_name = $("#form_name").val();
    var post_action = $("#post_action").val();
    var form_class = $("#form_class").val();

    //multi
    if ($('#multi').is(':checked')) {
        var multi = 'true';
    }else{
        var multi = 'false';
    }

    var recipients = $("#recipients").val();


    // $.ajax({
    //     type: 'POST',
    //     // make sure you respect the same origin policy with this url:
    //     // http://en.wikipedia.org/wiki/Same_origin_policy
    //     url: 'inc/asyncCalls.php?action=saveform',
    //     data: {
    //         'formcontent': theData,
    //         'form_json': thefrm,
    //         'form_name': form_name,
    //         'post_action': post_action,
    //         'form_class':form_class,
    //         'multi':multi,
    //         'recipients':recipients
    //     },
    //     success: function(msg){
    //         alert(msg);
    //     }
    // });
    function recallAddSlides() {
        var sliderid = $(".save-img").data("slideid");
        $("#add-slide-form").validate({

            submitHandler: function (form) {
                $.ajax({

                    type: "POST",
                    url: "installed_beans/carousel_plugin/asyncData.php?action=addindslide&sliderid=" + sliderid,
                    data: $("#add-slide-form").serialize(),
                    success: function (data) {
                        $("#sortable ul").append(data);

                    }
                })
            }
        })
    };

    $("[name='multi']").bootstrapSwitch();

    $(function(){
        $(".img-browser").on('click',function(){
            var itemsbefor = $(this).data('setter');
            $("#myModalAS .modal-title").html('Select an Image For Link');
            $("#myModalAS .modal-body").html('<iframe id="themedia" style="width: 100%; height: 450px; border: none" src="filedfiles.php?typeset=simple&fldset='+itemsbefor+'"></iframe>');
            $(".modal-dialog").css('width','869px');
            $("#myModalAS").modal();
        })

        $('#page_desc').keyup(function () {
            var left = 300 - $(this).val().length;
            if (left < 0) {
                left = 0;
            }
            $('.counter-text').text('Characters left: ' + left);
        });
    })

    function passImage(imgpath,fld){
        $("#"+fld).val(imgpath);
        $("#myModalAS").modal('hide');
    }






