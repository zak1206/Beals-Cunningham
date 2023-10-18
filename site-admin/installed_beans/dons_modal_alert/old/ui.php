<?php
include('../../inc/caffeine.php');
$site = new caffeine();
$userArray = $site->auth();
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Dons Modal Alert</title>
</head>
<body>
    <div class="container-fluid">
        <div id="modalstuff" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Modal body text goes here.</p>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>

        <h1>Caffeine Modal</h1>
        <p>Use the below settings to create and edit your sites modals.</p>
        <hr>
<?php
        //This section is for adding new modals
        if(isset($_REQUEST["addmodals"])) {
?>
        <button style="float: right; margin: 10px;" class="btn btn-primary" onclick="history.back()">Back to Modals</button>
        <button style="float: right; margin: 10px" class="btn btn-warning" onclick="modalsholders()">Add New Modal</button>
        <br>
        <div class="modalsholder" style="background: red; padding: 10px display: none;">
            <label>Modal Name</label>
            <input class="form-control" type="text" name="modal_name" value="" required="" autocomplete="off">
            <br>
            <label>Modal Content</label>
            <textarea class="summernote" id="bean_content" name="bean_content"></textarea><br>
        </div>
        <div class="row" style="margin: 0">
            <div class="col-md-12">
                <button class="btn btn-fill btn-warning timerbutton" type="button"><i class="fa fa-clock-o" aria-hidden="true"></i> Setup Content Runtime</button>
            </div>
            <div style="height: 30px">&nbsp;</div>
            <div class="col-md-12 runtimer" style="background: #f3bc44; display: none; border-radius: 7px; padding: 20px;">
                <h3 style="color: #886a27"><i class="fa fa-clock-o" aria-hidden="true"></i> Content Runtime.</h3>
                <p>If you would like your content to be date sensitive set the below start and end time. <br>You do not need to set both to run you may select just a start date with no end date or a end date and content will start immediately.</p>
                <div class="row">
                    <div class="col-md-4" style="padding-left: 0">
                        <label style="color: #333;font-weight: bold;">From:</label><br>
                        <input class="form-control datepickerzz" type="text" name="start_this" id="start_this" value="<?php echo $startTime; ?>" autocomplete="off">
                    </div>
                    <div class="col-md-4">
                        <label style="color: #333;font-weight: bold;">To:</label><br>
                        <input class="form-control datepickerzz" type="text" name="end_this" id="end_this" value="<?php echo $endTime; ?>" autocomplete="off">
                    </div>
                </div>
            </div>
        </div>
<?php
        }else{
        //This will show the current sliders
?>
            <button class="btn btn-outline-primary" style="float: right; margin: 10px" onclick="createNewModal()">Create New Modal</button>
            <div class="listholders"></div>
<?php
    }
?>
    </div>
    <script>
        <?php if(isset($_REQUEST["addmodals"])){ ?>

        function slidesholders(){
            if($(".slidesholders").is(":visible")){

            }else{
                $(".slidesholders").toggle();
            }

            var activeEditor = tinyMCE.get('bean_content');
            activeEditor.setContent('');
            $('#bean_content').val('');
            $("#singleslideid").val('');
            $("#slide_name").val('');
            $(".slidmodbod").text('Create');

            $(".timerbutton").on('click',function(){
                $(".runtimer").toggle();
            })

            $('.datepickerzz').datetimepicker({
                inline: true,
                sideBySide: true,
                useCurrent: false
            });
        }

        <?php }else{ ?>

        function createNewModal(){
            $("#modalstuff .modal-title").text('Create New Modal');

            $.ajax({
                url:'async.php?action=createnewmodal',
                cache: false,
                success: function(data){
                    $("#modalstuff .modal-body").html(data);

                    $(".settings").on('click', function(){
                        var set = $(this).data('sett');

                        if ($(this).is(':checked')) {
                            // alert(set);
                            $(".numslide").show();
                        }else{
                            //alert('not checked');
                            $(".numslide").hide();
                        }
                    });

                    ///FORM PROCESS///

                    $("#modal_settings").validate({
                        submitHandler: function(form) {
                            var formName = $(form).attr('id');
                            $.ajax({
                                type: "POST",
                                url: 'async.php?action=finishcreate',
                                data: new FormData(form),
                                contentType: !1,
                                cache: false,
                                processData: !1,
                                success: function(data) {
                                    $("#modalstuff .modal-body").html(data)
                                }
                            });
                        }
                    })
                }
            });

            $("#modalstuff").modal()
        }






        <?php } ?>

    </script>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
</body>
</html>