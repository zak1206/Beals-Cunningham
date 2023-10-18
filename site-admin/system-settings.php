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

                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>

                        <h2>System Settings</h2><br>
                        <p>This section contains your sites core setting and user management.</p><br><br>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card card-body">
                                    <h4 class="card-title">System Default Information </h4>
                                    <p class="card-text">This section contains your website default settings for Site Description and Keywords and also contains header scripts area.</p>
                                    <a href="system-defaults.php" class="btn btn-dark" style="width: fit-content;">View / Edit</a>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card card-body">
                                    <h4 class="card-title">System Permissions</h4>
                                    <p class="card-text">Create site permission groups / levels</p><br>
                                    <a href="system-permissions.php" class="btn btn-dark" style="width: fit-content;">View / Edit</a>
                                </div>
                            </div>
                        </div>
                        <br>

                        <div class="row">

                            <div class="col-lg-6">
                                <div class="card card-body">
                                    <h4 class="card-title">System Users</h4>
                                    <p class="card-text">Add, Edit, Delete Users.</p><br>
                                    <a href="system-users.php" class="btn btn-dark" style="width: fit-content;">View / Edit</a>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="card card-body">
                                    <h4 class="card-title"><span style="color: red"><i class="ti ti-alert"></i></span> Core Site Files</h4>
                                    <small style="color: red">This section is for advanced users and should be accessed with caution.</small>
                                    <p class="card-text">Access to header, footer, main css and main javascript files</p>
                                    <a href="core-settings.php" class="btn btn-danger" style="width: fit-content;">View / Edit</a>
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

        <!-- Custom main Js -->
        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>


    </body>
</html>