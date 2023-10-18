<?php include('inc/header.php'); ?>

<!-- Begin page -->
<div id="wrapper">

    <?php include('inc/topnav.php'); ?>


    <?php include('inc/sidebarnav.php'); ?>

            <!-- Top Bar Start -->



            <?php include('inc/sidebarnav.php'); ?>

    <?php
    if(isset($_POST["fname"])){
        $response = $site->createNewAccout($_POST);

        if($response["messagecode"] == '1'){

            $alert = '<div class="alert alert-success">
  <strong><i class="fa fa-check"></i> Success!</strong> User account has been created successfully.<br><a href="system-users.php">Click here</a> to return to account section.
</div>';

            $userAdd = true;

        }else{
            $fname = $_POST["fname"];
            $lname = $_POST["lname"];
            $email = $_POST["email"];
            $userAdd = false;
        }

    }else{
        $fname = '';
        $lname = '';
        $email = '';
        $userAdd = false;
    }
    ?>




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
                                        <li class="breadcrumb-item"><a href="system-users.php">System Users</a></li>
                                        <li class="breadcrumb-item active">Create User</li>
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
                                <hr>
                                <?php echo $alert; ?>

                                <?php
                                if($userAdd == true){

                                }else{
                                ?>
                                <form class="validform" id="accountform" name="accountform" method="post" action="" enctype="multipart/form-data">
                                    <div class="row">
                                    <div class="col-md-3"><label>First Name</label><br><input class="form-control" type="text" name="fname" id="fname" value="<?php echo $fname; ?>" required=""></div>
                                    <div class="col-md-3"><label>Last Name</label><br><input class="form-control" type="text" name="lname" id="lname" value="<?php echo $fname; ?>" required=""></div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-5"><label>Email</label><br><input class="form-control" type="email" name="email" id="email" value="<?php echo $email; ?>" required=""></div>
                                    <div class="col-md-3"><label>Password</label><br><input class="form-control" type="password" name="password" id="password" value="" required=""></div>
                                    <div class="col-md-3"><label>Confirm Password</label><br><input class="form-control" type="password" name="confirmpassword" id="confirmpassword" value="" required=""></div>
                                    </div>

                                    <br>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Select a permission group.</label><br>
                                            <select class="form-control" name="access_level" id="access_level">
                                                <option value="">Select Permission Group</option>
                                                <?php
                                                    $permissionsProfiles = $site->getPermissions();
                                                    for($i=0; $i<count($permissionsProfiles); $i++){
                                                        echo '<option value="'.$permissionsProfiles[$i]["id"].'">'.$permissionsProfiles[$i]["name"].'</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row"></div>
<br>
                                    <button class="btn btn-success" type="submit">Create Account</button>

                                </form>

                                <?php } ?>
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