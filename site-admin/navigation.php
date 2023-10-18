<?php include('inc/header.php'); ?>

<!-- Begin page -->
<div id="wrapper">

    <?php include('inc/topnav.php'); ?>


    <?php include('inc/sidebarnav.php'); ?>

            <!-- Top Bar Start -->



            <?php include('inc/sidebarnav.php'); ?>

    <div id="createnavs" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

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
                                        <li class="breadcrumb-item active">System Navigations</li>
                                    </ol>

                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>

                        <div class="card-box" style="margin-top:20px">
                            <div style="padding: 20px">
                                <h4 class="m-t-0 header-title">System Navigations</h4>
                                <p class="text-muted font-14 m-b-30">
                                    Add, Edit, Delete Navigations.
                                </p>
                                <button class="btn btn-warning" style="float: right;" onclick="createNav()">Create New Navigation</button>
                                <div style="clear:both;"></div>
                                <hr>
                                <?php
                                $nav = $site->getNavList();
                                //var_dump($users);

                                $html .= '<table class="table table-bordered">';
                                $html .='<thead style="background: #5d5d5d; color:#fff;"><tr><th>Nav Name</th><th>Nav Code</th><th style="text-align: right">Actions</th></thead>';

                                for($i=0; $i<count($nav); $i++){
                                    $html .= '<tr><td>'.$nav[$i]["menu_name"].'</td><td>{nav}'.$nav[$i]["navigation_id"].'{/nav}</td><td style="text-align: right"><a href="edit-menu.php?navid='.$nav[$i]["id"].'" class="btn btn-xs btn-success"><i class="fa fa-pencil"></i> Manage</a></td></tr>';
                                }

                                $html .= '</table>';
                                echo $html;
                                ?>
                            </div>
                        </div>

                    </div>
                    <!-- end container -->
                </div>
                <!-- end content -->

                <?php include('inc/footer.php'); ?>

            </div>


        </div>
        <!-- END wrapper -->



        <script>
            var resizefunc = [];
        </script>

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

    function createNav(){
        $.ajax({
            url: 'inc/asyncCalls.php?action=createnav',
            success: function(data){
                $('#createnavs .modal-body').html(data);
                $('#createnavs .modal .modal-title').html('Create New Navigation');
                $('#createnavs').modal();
                runFormCall();
            }
        })
    }

    function runFormCall(){
        $("#createnav").submit(function(e) {

            e.preventDefault(); // avoid to execute the actual submit of the form.

            var form = $(this);
            var url = 'inc/asyncCalls.php?action=completenavcreate';

            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(), // serializes the form's elements.
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.message != 'bad') {
                        location.href = 'edit-menu.php?navid=' + obj.newid;
                    } else {
                        //BAD THINGS//
                        $(".createmess").html('Menu already exist with name.');

                    }
                }
            })
        })
    }
</script>

    </body>
</html>