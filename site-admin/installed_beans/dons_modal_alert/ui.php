<?php
include('../../inc/caffeine.php');
$site = new caffeine();
$userArray = $site->auth();
?>
<!DOCTYPE HTML>
<html lang="en">
    <head>
        <!-- Required Meta Tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <!-- Data Tables CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

        <!-- Switchery CSS
        <link href="plugins/switchery/switchery.min.css" rel="stylesheet" />-->

        <!-- Sweet Alert -->
        <link href="../../plugins/sweet-alert/sweetalert2.min.css" rel="stylesheet">

        <!-- Bootstrap Switch CSS
        <link rel="stylesheet" href="assets/css/bootstrap-switch.css">-->

        <!-- Data Tables CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.5/css/rowReorder.dataTables.min.css">

        <!-- Date & Time Picker -->
        <link rel="stylesheet" href="../../assets/css/bootstrap-datetimepicker.css">

        <!-- Fontawesome v5.0.6 -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.6/css/all.css">

        <title>Caffeine Modal</title>
    </head>

    <body>
        <!-- Settings Modal -->
        <div id="create-modal" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create a Modal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1>Caffeine Modal</h1>
                    <p>Use the below settings to create and edit your sites modals.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-success" style="float: right; margin: 10px;" onclick="createModal()">Create New Modal</button>
                </div>
            </div>
        </div>


        <?php if(isset($_REQUEST["addmodals"])) { ?>
        <!-- Section for adding new modals -->

        <?php }else{ ?>
        <!-- Section for showing the current modals -->

        <?php } ?>

        <!-- JQuery v2.24 -->
        <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>

        <!-- Bootstrap JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

        <!-- Data Tables JS -->
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/rowreorder/1.2.5/js/dataTables.rowReorder.min.js"></script>

        <!-- jQuery Validate v1.19.1 -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>

        <!-- Sweet Alert JS
        <script src="../../plugins/sweet-alert/sweetalert2.min.js"></script>
        <script src="../../assets/pages/jquery.sweet-alert.init.js"></script>-->

        <!-- TinyMCE JS -->
        <script src="../../tinymce/js/tinymce/tinymce.min.js"></script>

        <!-- Moment JS -->
        <script src="../../assets/js/moment.js"></script>

        <!-- Date & Time Picker JS -->
        <script src="../../assets/js/bootstrap-datetimepicker.min.js"></script>

        <!-- Modal JS Functions -->
        <script>
        <?php if(isset($_REQUEST["addmodals"])) { ?>
        <?php }else{ ?>
        <?php } ?>

        function createModal() {
            $.ajax({
                url: 'async.php?action=createNewModal',
                success: function(data) {
                    $("#create-modal .modal-body").html(data);
                }
            });
            $("#create-modal").modal("show");
        }
        </script>
    </body>
</html>
