$(function() {
    $('#package_request').validate({

        submitHandler: function(form) {
            if ($("#package_request input:checkbox:checked").length > 0) {

                $.ajax({
                    type: 'POST',
                    url: '.../installed_beans/package_builder/asyncData.php?action=processpackage',
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
}
