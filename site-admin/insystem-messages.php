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
                                        <li class="breadcrumb-item active">Messages</li>
                                    </ol>

                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>

                        <div class="card-box" style="margin-top:20px">
                            <div style="padding: 20px">
                                <h4 class="m-t-0 header-title">Messages</h4>
                                <p class="text-muted font-14 m-b-30">
                                    Review in system messages and resolve.
                                </p>
                                <button class="btn btn-warning" style="float: right;" onclick="newMess()">Create New System Message</button>
                                <div style="clear:both;"></div>
                                <hr>
                                <?php
                                $nav = $site->getNavList();
                                //var_dump($users);

                                $html .= '<table class="table table-bordered">';
                                $html .='<thead>
      <tr>
        <th style="font-weight: bold;background: #5d5d5d;color: #fff; border-right:solid thin #efefef">Message Title</th>
        <th style="font-weight: bold;background: #5d5d5d;color: #fff; border-right:solid thin #efefef">Created By</th>
        <th style="font-weight: bold;background: #5d5d5d;color: #fff; border-right:solid thin #efefef">Date Created</th>
        <th style="font-weight: bold;background: #5d5d5d;color: #fff; border-right:solid thin #efefef">Status</th>
        <th style="font-weight: bold;background: #5d5d5d;color: #fff; border-right:solid thin #efefef; text-align: right">Action</th>
      </tr>
    </thead>';

                                $messages = $site->getSystMesssAll();
                                for($i=0; $i<=count($messages); $i++){
                                    $checkRead = $site->checkSubs($messages[$i]["id"]);

                                    if($messages[$i]["completed"] == 'true'){
                                        $unread = '<span class="badge badge-dark" style="font-size: 15px;">Closed</span>';
                                    }else {
                                        if ($checkRead == 'false') {
                                            $unread = '<span class="badge badge-info" style="font-size: 15px;">New</span>';
                                        } else {
                                            $unread = '<span class="badge badge-primary" style="font-size: 15px;">Seen</span>';
                                        }
                                    }

                                    $userDets = $site->getUsersAccount($messages[$i]["user"]);
                                    $fullname = $userDets["fname"].' '.$userDets["lname"];

                                    $created_date = date('m/d/Y, h:ia',$messages[$i]["created"]);

                                    if($messages[$i]["title"] != null) {
                                        $html .= '<tr><td>' . str_replace('_',' ',$messages[$i]["title"]) . '</td><td>'.$fullname.'</td><td>'.$created_date.'</td><td>'.$unread.'</td><td style="text-align: right"><button onclick="openMessz(\''.$messages[$i]["id"].'\')" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i> View</button></td></tr>';
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