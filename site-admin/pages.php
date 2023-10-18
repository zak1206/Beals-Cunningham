<?php include('inc/header.php'); ?>

        <!-- Begin page -->
        <div id="wrapper">

            <?php include('inc/topnav.php'); ?>


            <?php include('inc/sidebarnav.php'); ?>

            <div id="pagecreate" class="modal large" tabindex="-1" role="dialog">
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

                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>

                        <div class="card-box" style="margin-top:20px">
                            <div style="padding: 20px">
                            <h4 class="m-t-0 header-title">Site Pages</h4>
                            <p class="text-muted font-14 m-b-30">
                                NOTICE! To edit page content select Content/Plugins from the navigation.<br>
                                Pages are strictly for template use only and effect the way the pages content display to visitors.
                            </p>
                                <button class="btn btn-warning" style="float: right" onclick="createPage()">Create New Page</button>
                                <div class="clearfix"></div>
                                <hr>

                            </div>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th style="font-weight: bold;background: #5d5d5d;color: #fff; border-right:solid thin #efefef">Page</th>
                                    <th style="font-weight: bold;background: #5d5d5d;color: #fff; border-right:solid thin #efefef">Created</th>
                                    <th class="nosort" style="text-align: right; font-weight:bold;background: #5d5d5d;color: #fff;">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $site->checkInPages();
                                $pages = $site->getPages();
                                $j = 0;
                                for ($i = 0; $i < count($pages); $i++) {
                                    if ($pages[$i]["active"] != 'false'  && $pages[$i]["page_type"] != 'link') {
                                        if ($j == 0) {
                                            $j = 1;
                                            $back = 'background:#fff';
                                        } else {
                                            $j = 0;
                                            $back = '';
                                        }

                                        if($pages[$i]["page_lock"] == 'User' || $pages[$i]["page_lock"] == 'false' || $pages[$i]["page_lock"] == 'none' || $pages[$i]["page_lock"] == ''){
                                            if($userArray["user_type"] == 'Developer' || $userArray["user_type"] == 'Admin' || $userArray["user_type"] == 'User' || $pages[$i]["page_lock"] == 'false' || $pages[$i]["page_lock"] == 'none' || $pages[$i]["page_lock"] == ''){
                                                if($pages[$i]["check_out"] == ''){
                                                    $editCon = '<a href="edit-page.php?page=' . $pages[$i]["id"] . '" style="" class="btn btn-xs btn-success"><i class="ti-check"></i> Checkout</a>';
                                                }else{
                                                    $checkedDetails = $site->getCheckOut($pages[$i]["check_out"]);
                                                    $checkoutDate = date('m/d/Y h:i:a',$pages[$i]["check_out_date"]);
                                                    $editCon = '<small class="text-warning">Checked Out by: <a href="javascript:openProfile(\''.$pages[$i]["check_out"].'\')">'.$checkedDetails["fname"].'</a> - '.$checkoutDate.'</small> | <button style="" class="btn btn-xs btn-danger btn-fill forcecheck" data-pageids="'.$pages[$i]["id"].'" data-pagename="'.$pages[$i]["page_name"].'" data-curruser="'.$checkedDetails["fname"].'" data-checkdate="'.$checkoutDate.'"><i class="ti-unlock"></i> Force Check In</button>';
                                                }
                                            }else{
                                                $editCon = '<button style="" class="btn btn-xs btn-warning btn-fill" disabled><i class="fa fa-pencil"></i> Page Locked :( </button>';
                                            }
                                        }else{
                                            if($pages[$i]["page_lock"] == 'Admin' && $userArray["user_type"] == 'Admin' || $pages[$i]["page_lock"] == 'Admin' && $userArray["user_type"] == 'Developer' || $pages[$i]["page_lock"] == 'Developer' && $userArray["user_type"] == 'Developer'){

                                                if($pages[$i]["check_out"] == ''){
                                                    $editCon = '<a href="edit-page.php?page=' . $pages[$i]["id"] . '" style="" class="btn btn-xs btn-success"><i class="ti-check"></i> Checkout</a>';
                                                }else{
                                                    $checkedDetails = $site->getCheckOut($pages[$i]["check_out"]);
                                                    $checkoutDate = date('m/d/Y h:i:a',$pages[$i]["check_out_date"]);
                                                    $editCon = '<small class="text-warning">Checked Out by: <a href="javascript:openProfile(\''.$pages[$i]["check_out"].'\')">'.$checkedDetails["fname"].'</a> - '.$checkoutDate.'</small> | <button style="" class="btn btn-xs btn-danger btn-fill forcecheck" data-pageids="'.$pages[$i]["id"].'" data-pagename="'.$pages[$i]["page_name"].'" data-curruser="'.$checkedDetails["fname"].'" data-checkdate="'.$checkoutDate.'"><i class="ti-unlock"></i> Force Check In</button>';
                                                }

                                            }else{
                                                $editCon = '<button style="color:#100b00; font-weight:bold" class="btn btn-xs btn-warning btn-fill" disabled><i class="ti-lock"></i> Page Locked</button>';
                                            }

                                        }

                                        echo '
                                    <tr>
                                        <td><a style="color: #333" href="">' . $pages[$i]["page_name"].'</a></td>
                                        <td><a style="color: #333" href="">' . date('m/d/Y h:i a',$pages[$i]["created"]).'</a></td>
                                        <td style="text-align:right">'.$editCon.'</td>
                                    </tr>';
                                    }

                                }

                                ?>
                                </tbody>
                            </table>
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
        var tables = $('.table').DataTable();

        tables.on( 'search.dt', function () {
            $(".forcecheck").on('click',function(){
                var pagename = $(this).data('pagename');
                var curruser = $(this).data('curruser');
                var checkDate = $(this).data('checkdate');
                var pageid = $(this).data('pageids');
                swal({
                    title: 'Are you sure you want to force check in?',
                    text: "Changes made by others may be overwritten if you do this.",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, check in!',
                    cancelButtonText: 'No, cancel!',
                    confirmButtonClass: 'btn btn-success mt-2',
                    cancelButtonClass: 'btn btn-danger ml-2 mt-2',
                    buttonsStyling: false
                }).then(function () {

                    $.ajax({
                        url: 'inc/asyncCalls.php?action=runforce&pageid='+pageid,
                        success: function(data){
                            window.location = 'edit-page.php?page='+pageid
                        }
                    })


                }, function (dismiss) {
                    // dismiss can be 'cancel', 'overlay',
                    // 'close', and 'timer'
                    if (dismiss === 'cancel') {
                        swal({
                                title: 'Cancelled',
                                text: "Ok we will keep it checked out :)",
                                type: 'error',
                                confirmButtonClass: 'btn btn-confirm mt-2'
                            }
                        )
                    }
                })

            })
        } );

        $(".forcecheck").on('click',function(){
            var pagename = $(this).data('pagename');
            var curruser = $(this).data('curruser');
            var checkDate = $(this).data('checkdate');
            var pageid = $(this).data('pageids');
            swal({
                title: 'Are you sure you want to force check in?',
                text: "Changes made by others may be overwritten if you do this.",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, check in!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success mt-2',
                cancelButtonClass: 'btn btn-danger ml-2 mt-2',
                buttonsStyling: false
            }).then(function () {

                    $.ajax({
                        url: 'inc/asyncCalls.php?action=runforce&pageid='+pageid,
                        success: function(data){
                            window.location = 'edit-page.php?page='+pageid
                        }
                    })


            }, function (dismiss) {
                // dismiss can be 'cancel', 'overlay',
                // 'close', and 'timer'
                if (dismiss === 'cancel') {
                    swal({
                            title: 'Cancelled',
                            text: "Ok we will keep it checked out :)",
                            type: 'error',
                            confirmButtonClass: 'btn btn-confirm mt-2'
                        }
                    )
                }
            })

        })
    } );

    function createPage(){
        $("#pagecreate").modal();
        setForm();
    }

    function setForm(){
        $("#createpage").submit(function(e) {

            e.stopImmediatePropagation(); // avoid to execute the actual submit of the form.

            var form = $(this);
            var url = 'inc/asyncCalls.php?action=createpage';

            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(), // serializes the form's elements.
                success: function(data)
                {

                    //alert(data);
                    window.location.replace("edit-page.php?page="+data);
                }
            });


        });
    }

    $(function (){
        $(".paginate_button").on('click',function(){
            $(".forcecheck").on('click',function(){
                var pagename = $(this).data('pagename');
                var curruser = $(this).data('curruser');
                var checkDate = $(this).data('checkdate');
                var pageid = $(this).data('pageids');
                swal({
                    title: 'Are you sure you want to force check in?',
                    text: "Changes made by others may be overwritten if you do this.",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, check in!',
                    cancelButtonText: 'No, cancel!',
                    confirmButtonClass: 'btn btn-success mt-2',
                    cancelButtonClass: 'btn btn-danger ml-2 mt-2',
                    buttonsStyling: false
                }).then(function () {

                    $.ajax({
                        url: 'inc/asyncCalls.php?action=runforce&pageid='+pageid,
                        success: function(data){
                            window.location = 'edit-page.php?page='+pageid
                        }
                    })


                }, function (dismiss) {
                    // dismiss can be 'cancel', 'overlay',
                    // 'close', and 'timer'
                    if (dismiss === 'cancel') {
                        swal({
                                title: 'Cancelled',
                                text: "Ok we will keep it checked out :)",
                                type: 'error',
                                confirmButtonClass: 'btn btn-confirm mt-2'
                            }
                        )
                    }
                })

            })
        })

    })

</script>


    </body>
</html>