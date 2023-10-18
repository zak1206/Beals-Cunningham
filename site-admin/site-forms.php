<?php include('inc/header.php'); ?>

        <!-- Begin page -->
        <div id="wrapper">

            <?php include('inc/topnav.php'); ?>


            <?php include('inc/sidebarnav.php'); ?>

            <div id="myModal" class="modal large" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Create New Page</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body table-bordered">
                            <form name="createpage" id="createpage" method="post" action="">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Page Name</label><br>
                                        <input class="form-control" type="text" name="page_name" id="page_name" value="" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Page Title</label><br>
                                        <input class="form-control" type="text" name="page_title" id="page_title" value="" required>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Page Description</label><br>
                                        <textarea class="form-control" name="page_desc" id="page_desc"></textarea>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Parent Page</label><br><small>Select a parent page to keep page under certian categories.</small><br><br>
                                        <select class="form-control" name="parent_page" id="parent_page">
                                            <option value="">Select Parent Page</option>
                                            <?php
                                                $pages = $site->getPages();
                                                for($i=0; $i<count($pages); $i++){
                                                    echo '<option value="'.$pages[$i]["id"].'">'.$pages[$i]["page_name"].'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <br><br>
                                <div class="row">
                                    <div class="col-md-12"><button class="btn btn-success">Create / Build</button></div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">

                        </div>
                    </div>
                </div>
            </div>




            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container-fluid">

                        <!-- Page-Title -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="page-title-box">
                                    <?php include('inc/welcomears.php'); ?>
                                    <ol class="breadcrumb float-right">
                                        <li class="breadcrumb-item active">Site Forms</li>
                                    </ol>

                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>

                        <div class="card-box" style="margin-top:20px">
                            <div style="padding: 20px">
                            <h4 class="m-t-0 header-title">Site Forms</h4>
                            <p class="text-muted font-14 m-b-30">
                                List of sites forms.
                            </p>
                                <button class="btn btn-danger" style="float:right; margin: 20px" onclick="openSmtp()"><i class="fa fa-server"></i> Mail Settings</button>
                                <a style="float:right; margin: 20px" href="create-form.php" class="btn btn-warning" style="float: right">Create New Form</a>
                                <div class="clearfix"></div>
                                <hr>

                            </div>

                                <?php


                                echo '<table class="table  table-bordered table-striped">
    <thead>
      <tr>
        <th style="font-weight: bold;background: #5d5d5d;color: #fff; border-right:solid thin #efefef">Form Name</th>
        <th style="font-weight: bold;background: #5d5d5d;color: #fff; border-right:solid thin #efefef; text-align: center">Total Messages</th>
        <th style="font-weight: bold;background: #5d5d5d;color: #fff; border-right:solid thin #efefef; text-align: center">Unread</th>
        <th style="font-weight: bold;background: #5d5d5d;color: #fff; border-right:solid thin #efefef; text-align: right">Action</th>
      </tr>
    </thead>
    <tbody>';

                                $forms = $site->getForms();
                                for($i=0; $i<=count($forms); $i++){
                                    if($forms[$i]["form_name"] != null) {
                                        echo '<tr><td>' . str_replace('_',' ',$forms[$i]["form_name"]) . '</td><td style="text-align: center">'.$forms[$i]["messageCount"].'</td> <td style="text-align: center">'.$forms[$i]["messUnread"].'</td><td style="text-align: right"><a href="view-form.php?form='.$forms[$i]["form_name"].'" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i> View/Edit</a></td></tr>';
                                    }
                                }



                                echo'</tbody>
  </table>';
                                ?>

                        </div>


                    </div>
                    <!-- end container -->
                </div>
                <!-- end content -->

                <?php include('inc/footer.php'); ?>

            </div>
            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->




        </div>
        <!-- END wrapper -->



        <script>
            var resizefunc = [];
        </script>

        <!-- Plugins  -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/popper.min.js"></script><!-- Popper for Bootstrap -->
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/detect.js"></script>
<script src="assets/js/fastclick.js"></script>
<script src="assets/js/jquery.slimscroll.js"></script>
<script src="assets/js/jquery.blockUI.js"></script>
<script src="assets/js/waves.js"></script>
<script src="assets/js/wow.min.js"></script>
<script src="assets/js/jquery.nicescroll.js"></script>
<script src="assets/js/jquery.scrollTo.min.js"></script>
<script src="plugins/switchery/switchery.min.js"></script>
<script src="plugins/sweet-alert/sweetalert2.min.js"></script>
<script src="assets/pages/jquery.sweet-alert.init.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>

<!-- Required datatable js -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap4.min.js"></script>
<!-- Buttons examples -->

<!-- Key Tables -->
<script src="plugins/datatables/dataTables.keyTable.min.js"></script>

<!-- Responsive examples -->
<script src="plugins/datatables/dataTables.responsive.min.js"></script>
<script src="plugins/datatables/responsive.bootstrap4.min.js"></script>

<!-- Selection table -->
<script src="plugins/datatables/dataTables.select.min.js"></script>


<script src="assets/js/pace.min.js"></script>
<!-- Custom main Js -->
<script src="assets/js/jquery.core.js"></script>
<script src="assets/js/jquery.app.js"></script>

<script>
    $(document).ready(function() {
        $('.table').DataTable();
    } );
    function openSmtp(){
        $.ajax({
            url: 'inc/testMail.php?action=getsmtpdets',
            cache:false,
            success: function(data){
                $("#myModal .modal-title").html('Edit Postmark');
                $("#myModal .modal-footer").hide();
                $("#myModal .modal-body").html(data);
                $("#myModal").modal();
                $("#crm_sets").on('change',function(){
                    $(".crmsets").show();
                })

                $("#postmarkupdate").validate({
                    submitHandler: function(form) {
                        $.ajax({
                            type: "POST",
                            cache: false,
                            url: 'inc/testMail.php?action=savesmtp',
                            data: $("#postmarkupdate").serialize(), // serializes the form's elements.
                            success: function(data)
                            {
                                $("#myModal .modal-body").html('<div class="alert alert-success">Form Settings have been updated.</div>');// show response from the php script.
                            }
                        });
                    }
                });

                $(".crmtest").on('click',function(){
                    $(".crmtestmess").html('<img style="max-width: 13px" src="img/loader_sm.gif"> Please wait.. Test in progress.');
                    var baseLink = $("#handle_base").val();
                    var handle_user = $("#handle_user").val();
                    var handle_pass = $("#handle_pass").val();

                    $.ajax({
                        type: 'POST',
                        // make sure you respect the same origin policy with this url:
                        // http://en.wikipedia.org/wiki/Same_origin_policy
                        url: 'inc/testMail.php?action=testcrm',
                        data: {
                            'baseLink': baseLink,
                            'handle_user': handle_user,
                            'handle_pass': handle_pass
                        },
                                success: function(msg){
                                    $(".crmtestmess").html(msg);
                                }
                    });

                })

            }
        })

    }
</script>


    </body>
</html>