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
                                        <li class="breadcrumb-item active">Site Content</li>
                                    </ol>

                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>

                        <div class="card-box" style="margin-top:20px">
                            <div style="padding: 20px">
                                <h4 class="m-t-0 header-title">Site Content</h4>
                                <p class="text-muted font-14 m-b-30">
                                    This is where your sites content is held.
                                    Once you create / install new content, the system will generate a token to paste into pages.
                                </p>
                                <a href="create-content.php" class="btn btn-warning" style="float: right;">Create Content / Install Plugin</a>
                                <div style="clear:both;"></div>
                                <hr>

                                <div class="content table-responsive table-full-width">



                                    <?php
                                    $bean = $site->getBeans();
                                    echo '<table class="table table-striped page-holder">
                                    <thead>
                                    <tr>
                                        <th style="font-weight: bold;background: #5d5d5d;color: #fff; border-right:solid thin #efefef">Content Name</th>
                                        <th style="font-weight: bold;background: #5d5d5d;color: #fff; border-right:solid thin #efefef">Category</th>
                                        <th style="font-weight: bold;background: #5d5d5d;color: #fff; border-right:solid thin #efefef">Status</th>
                                        <th style="font-weight: bold;background: #5d5d5d;color: #fff; border-right:solid thin #efefef">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>';
                                    $j=0;
                                    for($i=0; $i< count($bean); $i++){
                                        if($j == 0){
                                            $j=1;
                                            $back = 'background:#fff';
                                        }else{
                                            $j=0;
                                            $back = '';
                                        }

                                        if($bean[$i]["bean_lock"] == 'User' || $bean[$i]["bean_lock"] == 'false' || $bean[$i]["bean_lock"] == '' || $bean[$i]["bean_lock"] == 'none'){
                                            if($userArray["user_type"] == 'Developer' || $userArray["user_type"] == 'Admin' || $userArray["user_type"] == 'User' || $bean[$i]["bean_lock"] == 'false' || $bean[$i]["bean_lock"] == 'none' || $bean[$i]["bean_lock"] == ''){
                                                $editCon = '<a href="edit-content.php?id=' . $bean[$i]["id"] . '" style="" class="btn btn-xs btn-success"><i class="ti-check"></i> Checkout</a>';
                                                if($bean[$i]["checkout"] == ''){
                                                    $editCon = '<a href="edit-content.php?id=' . $bean[$i]["id"] . '" style="" class="btn btn-xs btn-success"><i class="ti-check"></i> Checkout</a>';
                                                }else{
                                                    $checkedDetails = $site->getCheckOut($bean[$i]["checkout"]);
                                                    $checkoutDate = date('m/d/Y h:i:a',$bean[$i]["checkout_date"]);
                                                    $editCon = '<small class="text-warning">Checked Out by: <a href="javascript:openProfile(\''.$bean[$i]["check_out"].'\')">'.$checkedDetails["fname"].'</a> - '.$checkoutDate.'</small> | <button style="" class="btn btn-xs btn-danger btn-fill forcecheck" data-contenids="'.$bean[$i]["id"].'" data-contentname="'.$bean[$i]["bean_name"].'" data-curruser="'.$checkedDetails["fname"].'" data-checkdate="'.$checkoutDate.'"><i class="ti-unlock"></i> Force Check In</button>';
                                                }
                                            }else{
                                                $editCon = '<button style="" class="btn btn-xs btn-warning" disabled><i class="fa fa-pencil"></i> Bean Locked :( </button>';
                                            }
                                        }else{
                                            if($bean[$i]["bean_lock"] == 'Admin' && $userArray["user_type"] == 'Admin' || $bean[$i]["bean_lock"] == 'Admin' && $userArray["user_type"] == 'Developer' || $bean[$i]["bean_lock"] == 'Developer' && $userArray["user_type"] == 'Developer'){
                                                $editCon = '<a href="edit-content.php?id=' . $bean[$i]["id"] . '" style="" class="btn btn-xs btn-success"><i class="ti-check"></i> Checkout</a>';
                                            }else{
                                                $editCon = '<button style="" class="btn btn-xs btn-warning" disabled><i class="fa fa-pencil"></i> Bean Locked :( </button>';
                                            }

                                        }

                                        if($bean[$i]["category"] != ''){
                                            $catOut = $bean[$i]["category"];
                                        }else{
                                            $catOut = 'Not Set';
                                        }

                                        if($bean[$i]["end_time"] != 0 && time() >= $bean[$i]["end_time"]){
                                            $expired = '<span style="color:red">Expired: '.date('m/d/Y h:i A',$bean[$i]["end_time"]).'</span>';

                                        }else{
                                            $expired = '<span style="color:green">Active</span>';
                                        }



                                        echo '
                                    <tr>
                                        <td>' . $bean[$i]["bean_name"] . '</td>
                                        <td>'.$catOut.'</td>
                                        <td>'.$expired.'</td>
                                        <td style="text-align:right">'.$editCon.'</td>
                                    </tr>';
                                    }

                                    echo '</tbody>
                                </table>';

                                    ?>
                            </div>
                        </div>

                    </div>
                    <!-- end container -->
                </div>
                <!-- end content -->

                    <?php include('inc/footer.php'); ?>

            </div>


            </div></div>
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
        refreshCategories();
    } );

    function beanSwitchFilter(setval){
        var setAct = $(".setviews").children(".active").attr("data-rel");
        switchView('getbeansLine',setval);
    }

    function switchView(types,filterset){
        $.ajax({
            url: 'inc/asyncCalls.php?action='+types+'&cat='+filterset,
            success: function(data){
                $(".page-holder").html(data);
                dattabs.destroy();
                dattabs = $('.table').DataTable();
                refreshCategories(filterset)

            }
        })
    }

    function refreshCategories(categ){
        $.ajax({
            url: 'inc/asyncCalls.php?action=getcatfilter&setcat='+categ,
            success: function(data){
                var pathname = document.location.href.match(/[^/]+$/)[0];
                if(pathname == 'content.php') {
                    $(".dataTables_filter").append(data);
                }
            }
        })
    }
</script>

    </body>
</html>