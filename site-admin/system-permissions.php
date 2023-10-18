<?php include('inc/header.php');

if(isset($_POST["per-name"])){
    $create = $site->savePermissions($_POST);

    if($create["result"] == '1'){
        $alert = '<div class="alert alert-success">'.$create["result_message"].'</div>';
    }else{
        $alert = '<div class="alert alert-danger">'.$create["result_message"].'</div>';
    }
}

if(isset($_POST["per-name-edit"])){
    $edit = $site->updatePermissions($_POST);
    if($edit["result"] == '1'){
        $alert = '<div class="alert alert-success">'.$edit["result_message"].'</div>';
    }else{
        $alert = '<div class="alert alert-danger">'.$edit["result_message"].'</div>';
    }
}

?>

<!-- Begin page -->
<div id="wrapper">

    <div id="usersets" class="modal large" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body table-bordered">
                    <h3>Create Permission Group</h3>
                    <p>You can use this to turn on certain areas of the editor and assign this to users.</p>




                    <form name="permissions" id="permissions" method="post" action="">
                        <label>Group Name</label><br>
                        <input class="form-control" type="text" name="per-name" id="per-name" placeholder="Group Name Here..." required><br>
                        <div style="max-height: 300px; overflow-y: scroll">
                            <table class="table">

                                <?php

                                $permissions = array('Pages','Content','Site Forms','Locations','Menus','Media','Site Information','Header Tag Events','System Permissions','System Users','Core Site Files', 'Vendor Panel', 'End Users');

                                foreach ($permissions as $pers){
                                    $inputName = str_replace(' ','_',$pers);
                                    echo '<tr><td><strong>'.$pers.'</strong></td><td><label class="switch"><input type="checkbox" name="permiss[]" value="'.$inputName.'"><span class="slider round"></span></label></td></tr>';
                                }

                                ?>
                            </table>
                        </div><br>
                        <button class="btn btn-primary">Create Permission Group</button>
                    </form>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>

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
                                        <li class="breadcrumb-item active">System Permissions</li>
                                    </ol>




                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>

                        <div class="card-box" style="margin-top:20px">
                            <div style="padding: 20px">
                                <h4 class="m-t-0 header-title">System Permissions Groups</h4>
                                <p class="text-muted font-14 m-b-30">
                                    Create site permission groups / levels
                                </p>
                                <?php
                                if(isset($alert)){
                                    echo $alert;
                                }
                                ?>
                                <button class="btn btn-warning" style="float: right;" onclick="addNewMods()">Create New Group</button>
                                <div style="clear: both"></div>
                                <hr>
                                <?php
                                $pers = $site->getPermissions();


                                $html .= '<table class="table table-bordered">';
                                $html .='<thead style="background: #5d5d5d; color:#fff;"><tr><th>Group Name</th><th>Permission Objects</th><th style="text-align: right">Actions</th></thead>';

                                for($i=0; $i<count($pers); $i++){

                                    $persmi = json_decode($pers[$i]["permissions"],true);
                                    $perBadge = '';
                                    foreach($persmi as $permsd){
                                        $perBadge .= '<span style="margin: 1px" class="badge badge-warning">'.$permsd.'</span>';
                                    }

                                    $html .= '<tr><td>'.$pers[$i]["name"].'</td><td>'.$perBadge.'</td><td style="text-align: right"><button class="btn btn-success" onclick="getPermissionSet(\''.$pers[$i]["id"].'\')">Edit</button></td></tr>';
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

    function addNewMods(){
        $("#usersets").modal();
    }

    function getPermissionSet(id){
        $.ajax({
            url: 'inc/asyncCalls.php?action=getpermission&id='+id,
            success: function(data){
                $("#usersets .modal-body").html(data);
                $("#usersets").modal()
            }
        })
    }
</script>

    </body>
</html>