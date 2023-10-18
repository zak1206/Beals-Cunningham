<?php include('inc/header.php'); ?>
<script>
    $(function(){


        $('.my_codemirror_html').each(function(index, elem){
            CodeMirror.fromTextArea(elem, {
                tabsize: 2,
                theme: "mbo",
                lineNumbers: true});
        });
    })
</script>

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
                                        <li class="breadcrumb-item active">Core System Settings</li>
                                    </ol>

                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>

                        <div class="card-box" style="margin-top:20px">
                            <div style="padding: 20px">
                                <h4 class="m-t-0 header-title">Core System Settings</h4>
                                <p class="text-muted font-14 m-b-30">
                                    <small style="color: red;">This section is for advanced users and should be accessed with caution.</small><br>
                                    Access to header, footer, main css and main javascript files
                                </p>
                                <p>
                                    <label>Error Reporting</label><br>
                                    <small>Turn error reporting on / off</small><br>

                                    <?php
                                        $settings = $site->getSiteSettings();
                                        $errorReporting = $settings["error_reporting"];
                                        if($errorReporting == '' || $errorReporting == 'no'){
                                            $setsErr = '';
                                        }else{
                                            $setsErr = 'checked="checked"';
                                        }
                                    ?>

                                    <label class="switch tabers"><input class="primary settings" type="checkbox" name="error_reportings" data-sett="errprt" value="error_reportings" <?php echo $setsErr ?> ><span class="slider round"></span></label>
                                </p>

                                <div style="clear:both;"></div>
                                <hr>
                                <?php
                                $headerMessage = '';
                                $footerMessage = '';
                                if(isset($_POST["myTextarea"])){
                                    if($_REQUEST["coretype"] == 'header') {

                                        $fixScript = str_replace("[script]", "<script>", $_POST["myTextarea"]);
                                        $fixScript = str_replace("[/script]", "</script>", $fixScript);
                                        $fixScript = str_replace("[script ", "<script ", $fixScript);
                                        $fixScript = str_replace('.js"]', '.js">', $fixScript);

                                        file_put_contents('../inc/header.php', $fixScript);
                                        $headerMessage = '<div class="alert alert-success">
  <strong>Success!</strong> Header file has been updated.
</div>';
                                    }

                                    if($_REQUEST["coretype"] == 'footer') {
                                        $fixScript = str_replace("[script]", "<script>", $_POST["myTextarea"]);
                                        $fixScript = str_replace("[/script]", "</script>", $fixScript);
                                        $fixScript = str_replace("[script ", "<script ", $fixScript);
                                        $fixScript = str_replace("]</script>", "></script>", $fixScript);
                                        file_put_contents('../inc/footer.php', $fixScript);
                                        $footerMessage = '<div class="alert alert-success">
  <strong>Success!</strong> Footer file has been updated.
</div>';
                                    }

                                    if($_REQUEST["coretype"] == 'sitestyles') {
                                        $fixCss = str_replace("caffeinebackgrounds-image", "background-image", $_POST["myTextarea"]);
                                        file_put_contents('assets/readables/styles.css', $fixCss);
                                        file_put_contents('../css/styles.css', $fixCss);

                                        $footerMessage = '<div class="alert alert-success">
  <strong>Success!</strong> Style file has been updated.
</div>';
                                    }

                                    if($_REQUEST["coretype"] == 'sitejs') {
                                        $fixJs = $_POST["myTextarea"];
                                        file_put_contents('assets/readables/site.js', $fixJs);
                                        file_put_contents('../js/site.js', $fixJs);
                                        $footerMessage = '<div class="alert alert-success">
  <strong>Success!</strong> Site JS file has been updated.
</div>';
                                    }
                                }
                                ?>

                                <?php
                                if($_REQUEST["coretype"] == 'header') {
                                    $myfile = file_get_contents('../inc/header.php');
                                    $myfile = str_replace("<script>", "[script]", $myfile);
                                    $myfile = str_replace("</script>", "[/script]", $myfile);

                                    $myfile = str_replace("<script ", "[script ", $myfile);
                                    $myfile = str_replace('.js">', '.js"]', $myfile);

                                    $coreTitle = 'Edit Header File';
                                    $head = 'active';
                                }

                                if($_REQUEST["coretype"] == 'footer') {
                                    $myfile = file_get_contents('../inc/footer.php');
                                    $myfile = str_replace("<script>", "[script]", $myfile);
                                    $myfile = str_replace("</script>", "[/script]", $myfile);
                                    $myfile = str_replace("<script ", "[script ", $myfile);
                                    $myfile = str_replace(">[/script", "][/script", $myfile);
                                    $foot = 'active';


                                    $coreTitle = 'Edit Footer File';
                                }

                                if($_REQUEST["coretype"] == 'sitestyles') {
                                    $myfile = file_get_contents('assets/readables/styles.css');
                                    $myfile = str_replace("background-image", "caffeinebackgrounds-image", $myfile);
                                    $coreTitle = 'Edit Styles File';
                                    $mapDets = '<button type="button" class="btn btn-sm btn-danger btn-fill" onclick="compressFiles(\'css\')"><i class="ti-zip"></i> Compress Styles</button>';
                                    $cssact = 'active';
                                }

                                if($_REQUEST["coretype"] == 'sitejs') {
                                    $myfile = file_get_contents('assets/readables/site.js');
                                    $coreTitle = 'Edit Core JS File';
                                    $mapDets = '<button type="button" class="btn btn-sm btn-danger btn-fill" onclick="compressFiles(\'js\')"><i class="ti-zip"></i> Compress js</button>';
                                    $jsact = 'active';
                                }


                                ?>

                                <h1>Core Site Files</h1><small>Select the file that you would like to modify below. <strong>(NOTE! Make sure you create a backup before any modifications.. Just In Case ;) ) <br>ANOTHER NOTE! - If you need to restore a backup of the header or footer file these are saved within inc/backups/ on your sites root. You will need an FTP program to access them. </strong></small><br><strong>Having 406 mod_security Issues?</strong> - <small style="color:red">Since the inclusion of mod_security all script tags need to be formatted uniquely. <span style="cursor: pointer" class="modsec-info text-info">Click here</span> to open particulars. </small><br>
                                <br>
                                <div class="modsec-info-box" style="padding: 10px; background: #efefef; display: none"><code><strong>Known Javascript Issues</strong><br>PROBLEM: &lt;script&gt; your code.... &lt;/script&gt; <br>SOLUTION: [script] your code.... [/script]<br><br><strong>Known css Issues</strong><br>PROBLEM: background-image<br>SOLUTION: caffeinebackground-image</code></div>
                                <br><br>
                                <div class="clearfix"></div>

                                <a href="core-settings.php?coretype=header" class="btn btn-warning actbtn <?php echo $head; ?>">Edit Header</a> <a href="core-settings.php?coretype=footer" class="btn btn-warning actbtn <?php echo $foot; ?>">Edit Footer</a> <a href="core-settings.php?coretype=sitestyles" class="btn btn-warning actbtn <?php echo $cssact; ?>">Edit Site Style</a> <a href="core-settings.php?coretype=sitejs" class="btn btn-warning actbtn <?php echo $jsact; ?>">Edit Site JS</a>

                                <?php if(isset($_REQUEST["coretype"])){ ?>
                                    <br><br>
                                    <h1><?php echo $coreTitle; ?></h1>

                                    <br><hr><br>
                                    <button id="noticebutton" class="btn btn-primary backupbutton" onclick="createBackup('<?php echo $_REQUEST["coretype"]; ?>')"><i class="fa fa-floppy-o" aria-hidden="true"></i> &nbsp; &nbsp; Create a Backup</button><br><br>
                                    <?php echo $headerMessage; ?>
                                    <?php echo $footerMessage; ?>
                                    <form name="edit-cores" id="edit-cores" method="post" action="" enctype="multipart/form-data">
                                        <textarea class="my_codemirror_html" name="myTextarea" id="myTextarea"><?php echo stripcslashes($myfile); ?></textarea>
                                        <br><br>

                                        <button class="btn btn-primary">Update File</button> | <a href="core-settings.php" class="btn btn-success">Close Edit / Done</a>
                                        <div class="mapdets" style="display: block; float: right"><?php echo $mapDets; ?></div>
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
    function resetButton(){
        $('.backupbutton').html('<i class="fa fa-floppy-o" aria-hidden="true"></i> &nbsp; &nbsp; Create Another Backup');
        $('.backupbutton').removeClass('btn-success').addClass('btn-primary');
        $('.backupbutton').removeAttr("disabled");
    }

    function giveBackResponse(data){
        $('.backupbutton').html('<i class="fa fa-floppy-o" aria-hidden="true"></i> &nbsp; &nbsp; Backup Created Successfully!');
        $('.backupbutton').removeClass('btn-primary').addClass('btn-success');
        setTimeout(resetButton, 8000);
    }

    function createBackup(backtype){
        $('.backupbutton').html('<img style="width: 20px" src="img/small_primary_loader.gif">&nbsp; &nbsp;Creating a Backup - Please Wait..');
        $(".backupbutton").attr("disabled","disabled");
        $.ajax({
            url: 'inc/asyncCalls.php?action=createbackup&type='+backtype,
            success: function(data){

                setTimeout(giveBackResponse, 5000);

            }
        })
    }

    <?php if(isset($_REQUEST["coretype"])){ ?>

    $(function(){
        $('html, body').animate({
            scrollTop: $('.backupbutton').offset().top - 120
        }, 'fast');
    });

    <?php } ?>

    $(function(){
        $(".img-browser").on('click',function(){
            var itemsbefor = $(this).data('setter');
            $("#myModalAS .modal-title").html('Select an Image For Link');
            $("#myModalAS .modal-body").html('<iframe id="themedia" style="width: 100%; height: 450px; border: none" src="filedfiles.php?typeset=simple&fldset='+itemsbefor+'"></iframe>');
            $(".modal-dialog").css('width','869px');
            $("#myModalAS").modal();
        })
        ///$('.color-selector').colorpicker();
    })

    function passImage(imgpath,fld){
        $("#"+fld).val(imgpath);
        $("#myModalAS").modal('hide');
    }

    $(function(){
        $(".modsec-info").on('click',function(){
            $(".modsec-info-box").slideToggle();
            $(window).scrollTop($('.modsec-info-box').offset().top);
        })

        $(".tabers").on('mouseup',function(evt){
            if ( $('input[name="error_reportings"]').is(':checked') ) {
                var errstatus = 'no';
            }else{
                var errstatus = 'yes'
            }


            $.ajax({
                url: 'inc/asyncCalls.php?action=seterrsstatus&status='+errstatus,
                success: function(data){

                }
            })


            evt.preventDefault();
        })

    });

    function compressFiles(type){
        $.ajax({
            url: 'inc/asyncCalls.php?action=compressfiles&type='+type,
            success: function (data){
                alert('Compressed.'+data)
            }
        })
    }


</script>

    </body>
</html>