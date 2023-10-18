$(function() {
    $('#package_request').validate({

        submitHandler: function(form) {
            if ($("#package_request input:checkbox:checked").length > 0) {

                $.ajax({
                    type: 'POST',
                    url: 'asyncCall.php?action=processpackage',
                    data: $('#package_request').serialize(),
                    success: function(data)
                    {
                        $('.packs').html('<div class="alert alert-success">Thank You! - We have received your request and will get back with you A.S.A.P.</div>');
                        console.log(data);
                    }
                });
            }else{
                $(".checkboxerror").html('Please select one option here.');
                $(".checkboxerror").show();
            }
        }
    });
})

$(function(){
    $(".builderlink").on('click',function(){
        var gotlink = $(this).data('eqlink');
        var gotlink1 = $(this).data('eqtitle');
        var gotlink2 = $(this).data('eqimage');

        $("#myModal .modal-title").html('');
        if(gotlink != undefined){
            $("#myModal .modal-body").html('<iframe style="width: 100%; height: 450px;" border: none src="http://eqharvest.caffeinerde.com/'+gotlink+'" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe>');
            $(".modal-dialog").css('width','869px');
        }else{
            $("#myModal .modal-body").html('<h2>'+gotlink1+'</h2><br><img style="width: 100%; height: 450px;" src="'+gotlink2+'">');
        }
        $("#myModal").modal();

    })
});




