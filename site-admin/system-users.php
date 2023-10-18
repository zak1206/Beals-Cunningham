<?php include('inc/header.php'); ?>

<!-- Begin page -->
<div id="wrapper">

    <?php include('inc/topnav.php'); ?>


    <?php include('inc/sidebarnav.php'); ?>

            <!-- Top Bar Start -->



            <?php include('inc/sidebarnav.php'); ?>




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
                                        <li class="breadcrumb-item"><a href="system-settings.php">System Settings</a></li>
                                        <li class="breadcrumb-item active">System Users</li>
                                    </ol>

                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>

                        <div class="card-box" style="margin-top:20px">
                            <div style="padding: 20px">
                                <h4 class="m-t-0 header-title">System Users</h4>
                                <p class="text-muted font-14 m-b-30">
                                    Add, Edit, Delete Users.
                                </p>
                                <a href="create-user.php" class="btn btn-warning" style="float: right;">Create New Users</a>
                                <div style="clear:both;"></div>
                                <hr>
                                <?php
                                $users = $site->getUsersAccounts();
                                //var_dump($users);

                                $html .= '<table class="table table-bordered">';
                                $html .='<thead style="background: #5d5d5d; color:#fff;"><tr><th>Users Name</th><th>Email</th><th>Last Logged In</th><th>Permission Group</th><th style="text-align: right">Actions</th></thead>';

                                $j=0;
                                for($i=0;$i<count($users);$i++){
                                    $fullname = $users[$i]["fname"]. ' ' .$users[$i]["lname"];
                                    if($users[$i]["last_login"] != ''){
                                        $lastLogin = date('m/d/Y H:is', $users[$i]["last_login"]);
                                    }else{
                                        $lastLogin = 'No login times available';
                                    }

                                    $permiPre = $site->getSinglePermission($users[$i]["access_level"]);
                                    $permisName = $permiPre["name"];
                                    if($permisName != null){
                                        $permisName = $permiPre["name"];
                                    }else{
                                        $permisName = 'Not Assigned';
                                    }


                                    if($users[$i]["access_level"] == 'Developer' && $userArray["user_type"] != 'Developer'){
                                    }else{
                                        if($j==0){
                                            $html .= '<tr style="background: #fff"><td>'.$fullname.'</td><td>'.$users[$i]["email"].'</td><td>'.$lastLogin.'</td><td>'.$permisName.'</td><td style="text-align:right"><a href="edit-user.php?userid='.$users[$i]["id"].'" class="btn btn-xs btn-success"><i class="fa fa-pencil"></i> Manage</a></td></tr>';
                                            $j=1;
                                        }else{
                                            $html .= '<tr style="background: #efefef"><td>'.$fullname.'</td><td>'.$users[$i]["email"].'</td><td>'.$lastLogin.'</td><td>'.$permisName.'</td><td style="text-align:right"><a href="edit-user.php?userid='.$users[$i]["id"].'" class="btn btn-xs btn-success"><i class="fa fa-pencil"></i> Manage</a></td></tr>';
                                            $j=0;
                                        }
                                    }

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
</script>

    </body>
</html>