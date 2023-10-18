<?php
include('inc/header.php');
$id = $_REQUEST["page"];
if(isset($_POST["page_name"])){
    $page = $site->createPage($_POST);
    $pageModMess = true;
}

if(isset($_POST["deps"])){
var_dump($_POST);
    $savDeps = $site->savePageDeps($_POST);
}


$pageDetails = $site->getPage($_REQUEST["page"]);
$site->checkOutItem('page',$id);

?>

<div id="editmod" class="modal large" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Modal body text goes here.</p>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>

        <!-- Begin page -->
        <div id="wrapper">

            <?php include('inc/topnav.php'); ?>


            <?php include('inc/sidebarnav.php'); ?>




            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">

                    <div class="container-fluid thedatas">

                        <!-- Page-Title -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="page-title-box">
                                    <?php include('inc/welcomears.php'); ?>
                                    <div class="row">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-9" style="text-align: right"><button class="btn btn-warning" onclick="openContent()"><i class="ti-package"></i> Content / Plugins</button></div>
                                    </div>

                                    <!--<ol class="breadcrumb float-right">
                                        <li class="breadcrumb-item"><a href="#">Minton</a></li>
                                        <li class="breadcrumb-item"><a href="#">Pages</a></li>
                                        <li class="breadcrumb-item active">Dashboard</li>
                                    </ol>-->
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>

                        <div class="card-box" style="margin-top:20px">
                            <h3>Page Details</h3><br>

                                <form name="pagedets" id="pagedets" action="" method="post">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Page Name:</label><br><input type="text" class="form-control" name="page_name" id="page_name" value="<?php echo $pageDetails["page_name"]; ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label>TItle Tag:</label><br><input type="text" class="form-control" name="page_title" id="page_title" value="<?php echo $pageDetails["page_title"]; ?>">
                                    </div>
                                </div>





                                <div class="row">
                                    <div class="col-md-12">
                                        <br>
                                        <label>Page Description</label><br>
                                        <textarea class="form-control" name="page_desc" id="page_desc"><?php echo $pageDetails["page_desc"]; ?></textarea>
                                    </div>
                                </div>
                                    <br>

                                    <div class="row">
                                        <?php
                                            $issecure = $pageDetails["secure_page"];
                                            if($issecure != 'false' && $issecure != ''){
                                                $secureCheck = 'checked="checked"';
                                            }else{
                                                $secureCheck = '';
                                            }
                                        ?>
                                        <div class="col-md-3"><label>Secure Page:</label> <br><label class="switch"><input class="primary settings" type="checkbox" name="securepage" data-sett="pgsecr" value="securepage" <?php echo $secureCheck ?> ><span class="slider round"></span></label></div>
                                        <div class="col-md-6"> <label>Select User Group</label><br>
                                            <?php
                                            $permiss = $site->getPermissions();
                                            //var_dump($permiss);
                                            ?>
                                            <select class="form-control" name="permisgrp" id="permisgrp">
                                                <option value="none">Select Permission Group</option>
                                                <?php
                                                for($i=0; $i<count($permiss); $i++){
                                                    if($pageDetails["user_group"] == $permiss[$i]["id"]){
                                                        echo '<option value="'.$permiss[$i]["id"].'" selected="selected">'.$permiss[$i]["name"].'</option>';
                                                    }else{
                                                        echo '<option value="'.$permiss[$i]["id"].'">'.$permiss[$i]["name"].'</option>';
                                                    }

                                                }
                                                ?>

                                            </select></div>
                                    </div>
                                    <div class="col-md-12">
                                        <br>
                                        <button class="btn btn-success">Save Page Details</button> <button type="button" class="btn btn-danger" onclick="deletePage('<?php echo $_REQUEST["page"]; ?>')">DELETE PAGE</button>

                                    </div>
                                    <input type="hidden" name="page_id" id="page_id" value="<?php echo $_REQUEST["page"]; ?>">

                                </form>
                            </div>
                        </div>

                        <iframe src="edit/editor.php?page=<?php echo $_REQUEST["page"]; ?>" style="width: 100%; height: 100vh; border:none"></iframe>

                    <div id="js_deps" class="card-box" style="margin-top:20px">
                        <h3 class="title">Page Dependencies</h3>
                        <p class="category">Select your page dependencies<br>When turned on these will load with the page.</p>
                        <form name="pagedeps" id="pagedeps" method="post" action="">
                            <h3>CSS</h3>
                            <div style="padding: 10px; background: #efefef" class="row">

                                <?php
                                    $setDep = json_decode($pageDetails["dependants"],true);

                                    $cssDep = $setDep["css"];

                                    $deps = $site->getDeps();

                                  //  var_dump($deps["css"]);

                                    for($i=0; $i<count($deps["css"]); $i++){

                                       // echo $deps["css"][$i][0];
                                        $depName = substr($deps["css"][$i][0], strrpos($deps["css"][$i][0], '/') + 1);
                                        if(in_array($deps["css"][$i][0],$cssDep)){
                                            echo '<div class="col-md-3"><label class="switch active"><input class="primary settings" type="checkbox" name="deps[]"  value="'.$deps["css"][$i][0].'" checked="checked"><span class="slider round"></span></label> <span>'.$depName.'</span> </div>';
                                        }else{
                                            echo '<div class="col-md-3"><label class="switch"><input class="primary settings" type="checkbox" name="deps[]"  value="'.$deps["css"][$i][0].'" ><span class="slider round"></span></label> <span>'.$depName.'</span> </div>';
                                        }

                                    }
                                ?>


                            </div>
                            <br>
                            <h3>Javascript</h3>
                            <div style="padding: 10px; background: #efefef" class="row">

                                <?php
                                $jsDep = $setDep["js"];
                                for($i=0; $i<count($deps["js"]); $i++){

                                    // echo $deps["css"][$i][0];
                                    $depName = substr($deps["js"][$i][0], strrpos($deps["js"][$i][0], '/') + 1);
                                if(in_array($deps["js"][$i][0],$jsDep)) {
                                    echo '<div class="col-md-3"><label class="switch active"><input class="primary settings" type="checkbox" name="deps[]" value="' . $deps["js"][$i][0] . '" checked="checked"><span class="slider round"></span></label> <span>' . $depName . '</span> </div>';
                                }else{
                                    echo '<div class="col-md-3"><label class="switch"><input class="primary settings" type="checkbox" name="deps[]" value="' . $deps["js"][$i][0] . '" ><span class="slider round"></span></label> <span>' . $depName . '</span> </div>';
                                }

                                }
                                ?>


                        </div>

                        <br><br>

                            <input type="hidden" name="page_id" id="page_id" value="<?php echo $_REQUEST["page"]; ?>">

                            <button class="btn btn-primary">Save Dependencies</button>
                        </form>



                    </div>


                        <div id="js_editor" class="card-box" style="margin-top:20px">
                            <h3 class="title">Page Javascript Events</h3>
                            <p class="category">Place any javascript for this page here and not in footer..</p>
                            <br>
                            <p>
                                <?php if(isset($_POST["myjsCode"])){
                                    file_put_contents('../js/page_js/'.$pageDetails["page_js"], $_POST["myjsCode"]);
                                    echo '<script>$(function(){swal({title:\'JS Updated\',text:\'I will now close.\',type:\'success\',timer:2000}).then(function(){},function(dismiss){if(dismiss===\'timer\'){console.log(\'I was closed by the timer\')}})}</script>';
                                }
                                ?>
                            </p>
                            <form name="edit-cores" id="edit-cores" method="post" action="" enctype="multipart/form-data"">

                            <?php $jsEvents = file_get_contents('../js/page_js/'.$pageDetails["page_js"]); ?>

                            <textarea class="my_codemirror_html" name="myjsCode" id="myjsCode"><?php echo $jsEvents; ?></textarea>
                            <br><br>

                            <button class="btn btn-primary btn-fill">Update JS</button><span class="jsloader" style="display: none"> | <img src="img/loader_sm.gif"> updating js ...</span>
                            <br><br>
                            </form>
                        </div>

                        <div class="card-box" style="margin-top:20px">
                            <div class="alert-warning reset-confirm" style="padding: 10px; display: none"></div>
                            <h3 style="padding: 10px">Page History</h3>
                            <?php
                            echo '<table class="table table-bordered">';
                            echo '<tr><td><strong>Version Date</strong></td><td><strong>Modified By</strong></td><td style="text-align: right"><strong>Actions</strong></td></tr>';
                            $pageHistory = $site->getPageHistory($_REQUEST["page"]);
                            $wt = 0;
                            for ($i = 0; $i < count($pageHistory); $i++) {
                                if ($wt == 0) {
                                    $bak = 'style="background:#fff"';
                                    $wt = 1;
                                } else {
                                    $bak = '';
                                    $wt = 0;
                                }



                                if ($pageHistory[$i]["codediff"] == 'true') {
                                    $codeRepo = '| <button class="btn btn-xs btn-secondary btn-fill btn-sm" data-toggle="tooltip" title="View Code Changes" onclick="reviewSource(\'' . $pageHistory[$i]["id"] . '\')"><i class="fa fa-download" aria-hidden="true"></i> View Source Changes</button>';
                                } else {
                                    $codeRepo = '';
                                }

                                echo '<tr ' . $bak . '><td id="version_info_' . $pageHistory[$i]["id"] . '" class="backup-items">' . date('m/d/Y H:i:s', $pageHistory[$i]["backup_date"]) . '</td><td>' . $pageHistory[$i]["last_user"] . '</td><td style="text-align:right"><button class="btn btn-xs btn-warning btn-fill btn-sm" data-toggle="tooltip" title="Restore Version" onclick="restoreVersion(\'' . $pageHistory[$i]["id"] . '\')"><i class="fa fa-download" aria-hidden="true"></i> Restore</button> | <button class="btn btn-xs btn-primary btn-fill btn-sm" onclick="openRevision(\'' . $pageHistory[$i]["id"] . '\')"><i class="fa fa-search" aria-hidden="true"></i> View Version</button> ' . $codeRepo . '</td></tr>';


                            }
                            echo '</table>';
                            ?>
                        </div>


                    </div>
                    <!-- end container -->


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

        <!-- Custom main Js -->
        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>

            <?php if(isset($_POST["myjsCode"])){

                echo '<script>$(function(){swal({title:\'JS Updated\',text:\'I will now close.\',type:\'success\',timer:2000}).then(function(){},function(dismiss){if(dismiss===\'timer\'){console.log(\'I was closed by the timer\')}})})</script>';
            }
            ?>

<?php
if($pageModMess == true){

    echo '<script>$(function(){swal({title:\'Page Details Updated\',text:\'I will now close.\',type:\'success\',timer:2000}).then(function(){},function(dismiss){if(dismiss===\'timer\'){console.log(\'I was closed by the timer\')}})})</script>';
}
?>

    <script>
        function imgSucc(){
            swal({
                title: 'Media Added',
                text: 'I will now close.',
                type: 'success',
                timer: 2000
            }).then(
                function () {
                },
                // handling the promise rejection
                function (dismiss) {
                    if (dismiss === 'timer') {
                        console.log('I was closed by the timer')
                    }
                }
            )
        }

        function openRevision(id){
            $.ajax({
                url: 'inc/asyncCalls.php?action=captureversion&id='+id,
                success: function(data){
                    $("#editmod .modal-body").html(data);
                    $("#editmod .modal-title").html('Review Version');
                    $("#editmod .modal-lg").css('max-width','90%');
                    $("#editmod").modal();
                    $('.backup-items').css('background','none');
                    $('#version_info_'+id).css('background-color','#fcf8e3');
                }
            })
        }

        function deletePage(){
            $(".modal .modal-title").html('Confirm Actions');
            $(".modal .modal-body").html('<h3>NOTICE!</h3><strong>Are you absolutely sure you want to do this?</strong><br><small>If you do delete this page, please remember to remove it out of your menu items as well otherwise you will receive a 404 when trying to view the page.</small><br><br><a href="edit-page.php?delete=true&id=<?php echo $_REQUEST["id"]; ?>" class="btn btn-danger">Yes Delete!</a> <button class="btn btn-primary" onClick="modalClose()">No I\'m just Kidding! I don\'t want to delete this page.</button>');
            $(".modal").modal();
        }

        function modalClose(){
            $('.modal').modal('hide')
        }

        function savePage(checkout){
            if(checkout == 'true'){$('#page-layout').prepend('<input type="hidden" name="checkout" id="checkout" value="true" />');}
            if($(".note-editor").hasClass('codeview')){
                $( ".btn-codeview" ).trigger( "click" );
            }
            $("#page-layout").submit();
        }



        function restoreVersion(id){
            var versioninfo = $('#version_info_'+id).html();
            $(".reset-confirm").html('<strong>NOTICE!</strong> - Are you sure you want to restore <strong style="text-decoration: underline ">'+versioninfo+'</strong> | <button class="btn btn-xs btn-warning"  onClick="restoreVersionFin(\''+id+'\',\'page\')">Yes Restore</button> <button class="btn btn-xs btn-secondary" onclick="cancelRevis()">Cancel </button>').slideDown('fast');
        }

        function cancelRevis(){
            $(".reset-confirm").empty().slideUp('fast');
            $('.backup-items').css('background','none');
        }

        function restoreVersionFin(id,type){
            $.ajax({
                url: 'inc/asyncCalls.php?action=restoreversion&id='+id+'&type='+type,
                success: function(data){
                    $(".reset-confirm").html(data);
                    $(".coversheet").show();
                    $(".load_holds").show();
                    setTimeout(function(){
                        var url = window.location.href;
                        location.href = url;
                    }, 5000);
                }
            })
        }

        function lockPage(id){
            $.ajax({
                dataType: "json",
                url: 'inc/asyncCalls.php?action=lockpage&id='+id,
                success: function(data){
                    if(data != 'issues'){
                        var newClass = data["button_class"];
                        if($('lockdown').hasClass( "btn-success")){
                            $('.lockdown').removeClass('btn-success');
                            $('.lockdown').addClass(newClass);
                            $(".lockdown").html(data["button_text"]);
                        }else{
                            $('.lockdown').removeClass('btn-danger');
                            $('.lockdown').addClass(newClass);
                            $(".lockdown").html(data["button_text"]);
                        }

                    }
                }
            })
        }

        function reviewSource(id){
            $.ajax({
                url: 'inc/asyncCalls.php?action=reviewcodes&id='+id,
                success: function(data){
                    $("#editmod  .modal-body").html(data);
                    $("#editmod .modal-title").html('Review Code Changes');
                    $("#editmod .modal-dialog").css('width','90%');
                    $("#editmod").modal();
                    $('.backup-items').css('background','none');
                    $('#version_info_'+id).css('background-color','#fcf8e3');
                }
            })
        }

        $(function(){


            $('.my_codemirror_html').each(function(index, elem){
                CodeMirror.fromTextArea(elem, {
                    mode: 'javascript',
                    theme: "mbo",
                    lineNumbers: true});
            });

            $(".js-toggle").on('click',function(){
                $("#edit-cores").slideToggle();
                var wh = $(".js-toggle").text();
                if(wh == 'Open JS Editor'){
                    $(".js-toggle").text('Close JS Editor');
                }else{
                    $(".js-toggle").text('Open JS Editor');
                }

            })

            checkPageStatus();
        })

        function alertSoundSave(){
            swal({
                title: 'Page Saved',
                text: 'I will now close.',
                type: 'success',
                timer: 2000
            }).then(
                function () {
                },
                // handling the promise rejection
                function (dismiss) {
                    if (dismiss === 'timer') {
                        console.log('I was closed by the timer')
                    }
                }
            )
        }

        function openContent(){
            $("#editmod .modal-body").html('<iframe src="content_plugins.php" style="width: 100%; height: 400px; border:none"></iframe>');
            $("#editmod .modal-title").html('Content / Plugin Tokens');
            $("#editmod .modal-dialog").css('width','90%');
            $("#editmod").modal();
        }

        function deletePage(pageid){
            swal({
                title: 'Are you sure?',
                text: "Once you delete this page all data will be removed and you will no longer be able to access any of it's data.",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success mt-2',
                cancelButtonClass: 'btn btn-danger ml-2 mt-2',
                buttonsStyling: false
            }).then(function () {
                ///DO DELETE//
                $.ajax({
                    url: 'inc/asyncCalls.php?action=deletepage&pageid='+pageid,
                    success:function(data){
                        window.location.replace("pages.php");
                    }
                })


            }, function (dismiss) {
                // dismiss can be 'cancel', 'overlay',
                // 'close', and 'timer'
                if (dismiss === 'cancel') {
                    swal({
                            title: 'Cancelled',
                            text: "Ok we will keep it around :)",
                            type: 'error',
                            confirmButtonClass: 'btn btn-confirm mt-2'
                        }
                    )
                }
            })
        }


        function checkPageStatus(){
            $.ajax({
                url: 'inc/asyncCalls.php?action=checkpage&pageid=<?php echo $_REQUEST["page"]; ?>',
                success:function(data){
                    if(data == 'true'){
                        //DO NOTHING//
                        setTimeout(function(){
                            checkPageStatus();
                        }, 3000);
                        console.log('GOOD');
                    }else{
                        //HIDE PAGE AND GIVE NOTICE//
                        $(".thedatas").append('<div style="background:#fff; position:absolute; top:0; left:0; width:100%; height:100%;"><div style="position: absolute; top:10%; left: 40%"><h1>WHOOPS!</h1><br>This page was just forced checked in from another user.</div></div>');
                    }
                }
            })
        }

        function intDeps(){

        }


    </script>

    </body>
</html>