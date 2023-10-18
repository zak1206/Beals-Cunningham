<?php include('inc/header.php'); ?>

<!-- Begin page -->
<div id="wrapper">

    <?php include('inc/topnav.php'); ?>


    <?php include('inc/sidebarnav.php'); ?>

            <!-- Top Bar Start -->



            <?php include('inc/sidebarnav.php'); ?>




    <div class="modal large" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body table-bordered">

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
                                        <li class="breadcrumb-item"><a href="system-settings.php">System Settings</a></li>
                                        <li class="breadcrumb-item"><a href="system-users.php">System Users</a></li>
                                        <li class="breadcrumb-item active">Edit User</li>
                                    </ol>

                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>

                        <div class="card-box" style="margin-top:20px">
                            <div style="padding: 20px">
                                <h4 class="m-t-0 header-title">Edit User</h4>
                                <p class="text-muted font-14 m-b-30">
                                    Edit user account.
                                </p>
                                <hr>
                                <?php

                                if(isset($_POST["fname"])){
                                    $response = $site->editAccount($_POST);

                                    if($response["messagecode"] == '1'){
                                        $alert = '<div class="alert alert-success">
  <strong><i class="fa fa-check"></i> Success!</strong> User account has been edited successfully.<br><a href="system-users.php">Click here</a> to return to account section.
</div>';

                                    }else{
                                        $fname = $_POST["fname"];
                                        $lname = $_POST["lname"];
                                        $email = $_POST["email"];
                                    }

                                }else{
                                    $fname = '';
                                    $lname = '';
                                    $email = '';
                                }
                                ?>

                                <br><br>

                                <?php
                                if($response["messagecode"] == '1') {
                                    echo $alert;
                                }else{

                                    if(isset($response["message"])) {
                                        echo '<div class="alert alert-warning">
  <strong><i class="fa fa-exclamation-triangle"></i> Creation Failed!</strong> ' . $response["message"] . '
</div>';
                                    }
                                }

                                ?>
                                <?php $userInfo = $site->getUsersAccount($_REQUEST["userid"]); ?>
                                <?php
                                if(isset($_REQUEST["userid"])) {
                                    if(!is_array($userInfo)){
                                        echo '<div class="alert alert-warning">
  <strong><i class="fa fa-exclamation-triangle"></i> User pull Failed!</strong> It appears there is no users in the system that has that id assigned to them or the user you are trying to access has been removed from the system..<br>Please <a href="system-users.php">go back</a> to the accounts page and select a valid user account.
</div>';
                                        $no = true;
                                    }else{
                                    }
                                }else{
                                    $no = true;
                                    echo '<div class="alert alert-warning">
  <strong><i class="fa fa-exclamation-triangle"></i> User pull Failed!</strong> It appears that there is no valid user id supplied to pull information.<br>Please <a href="system-users.php">go back</a> to the accounts page and select a valid user account.
</div>';
                                }
                                ?>

                                <?php
                                $fname = $userInfo["fname"];
                                $lname = $userInfo["lname"];
                                $email = $userInfo["email"];
                                $access_level = $userInfo["access_level"];
                                if($access_level == 'Admin'){
                                    $adminCheck = 'checked="checked"';
                                    $adminActive = 'active';
                                }else{
                                    $adminCheck = '';
                                    $adminActive = '';
                                }

                                if($access_level == 'User'){
                                    $userCheck = 'checked="checked"';
                                    $userActive = 'active';
                                }else{
                                    $userCheck = '';
                                    $userActive = '';
                                }

                                if($access_level == 'Developer'){
                                    $devCheck = 'checked="checked"';
                                    $devActive = 'active';
                                }else{
                                    $devCheck = '';
                                    $devActive = '';
                                }

                                if($userInfo["profile_image"] != ''){
                                    $profileImage = $userInfo["profile_image"];
                                    $imgLeft = $userInfo["left"].'px';
                                    $imgtop = $userInfo["top"].'px';
                                }else{
                                    $profileImage = 'defaultIcon.png';
                                    $imgLeft = '0px';
                                    $imgtop = '0px';
                                }
                                ?>


                                    <form class="validform" id="accountform" name="accountform" method="post" action="" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-4"><label>First Name</label><br><input class="form-control" type="text" name="fname" id="fname" value="<?php echo $fname; ?>" required=""></div>
                                            <div class="col-md-4"><label>Last Name</label><br><input class="form-control" type="text" name="lname" id="lname" value="<?php echo $lname; ?>" required=""></div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-5"><label>Email</label><br><input class="form-control" type="email" name="email" id="email" value="<?php echo $email; ?>" required=""></div>
                                            <div class="col-md-3"><label>Password</label><br><input class="form-control" type="password" name="password" id="password" value=""></div>
                                            <div class="col-md-3"><label>Confirm Password</label><br><input class="form-control" type="password" name="confirmpassword" id="confirmpassword" value=""></div>
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
                                                        if($access_level == $permissionsProfiles[$i]["id"]){
                                                            echo '<option value="'.$permissionsProfiles[$i]["id"].'" selected="selected">'.$permissionsProfiles[$i]["name"].'</option>';
                                                        }else{
                                                            echo '<option value="'.$permissionsProfiles[$i]["id"].'">'.$permissionsProfiles[$i]["name"].'</option>';
                                                        }

                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <input type="hidden" id="id" name="id" value="<?php echo $_REQUEST["userid"]; ?>">
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12" ><button class="btn btn-success" type="submit">Edit Account</button>
                                                <a href="javascript:deleteUser()" class="text-danger" style="float: right;"><i class="fa fa-trash"></i> Remove This User!</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script>
    $(".validform").validate({
        rules: {
            confirmpassword: {
                equalTo: "#password"
            }
        }
    });



    function deleteUser(){
        $(".modal .modal-title").html('Confirm Actions');
        $(".modal .modal-body").html('<h3>NOTICE!</h3><strong>Are you absolutely sure you want to do this?</strong><br><small>Select Choice Below!</small><br><br><a href="edit-menu.php?delete=true&id=<?php echo $_REQUEST["id"]; ?>" class="btn btn-danger">Yes Delete!</a> <button class="btn btn-primary" onClick="modalClose()">No I\'m just Kidding! I don\'t want to delete this user.</button>');
        $(".modal").modal();
    }
    function modalClose(){
        $('#myModalAS').modal('hide')
    }

</script>

    </body>
</html>