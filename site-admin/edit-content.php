<?php include('inc/header.php'); ?>

<!-- Begin page -->
<div id="wrapper">

    <?php include('inc/topnav.php'); ?>


    <?php include('inc/sidebarnav.php'); ?>

            <!-- Top Bar Start -->



            <?php include('inc/sidebarnav.php'); ?>

    <div id="pagemodal" class="modal large" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Create New Page</h3>
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
                                        <li class="breadcrumb-item active"><a href="content.php">Content</a></li>
                                        <li class="breadcrumb-item active">Edit Content</li>
                                    </ol>

                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>

                        <div class="card-box" style="margin-top:20px">

                            <?php
                                $record = $site->getBean($_REQUEST["id"]);
                                if($record["bean_type"] == 'installed'){
                                    echo '<div class="">';
                                    //include('installed_beans/'.$record["bean_folder"].'/ui.php');
                                    echo '<iframe id="content" style="width:100%; height:100vh; border:none" src="installed_beans/'.$record["bean_folder"].'/ui.php"></iframe>';
                                    echo '</div>';

                                    echo '<script>function resizeIframe(obj) {obj.style.height = obj.contentWindow.document.body.scrollHeight + \'px\';}</script>';
                                }else{
                                    ?>

                            <div style="padding: 20px">
                                <h4 class="m-t-0 header-title">Edit Content</h4>
                                <p class="text-muted font-14 m-b-30">
                                    Below you can make modifications to the content and it will distribute to all pages the token is held on.
                                </p>
                                <?php
                                if(isset($_POST["submit_bean_content"])){
                                    $update = $site->editContentBean($_POST,$_REQUEST["id"]);
                                    echo '<div class="alert alert-success" role="alert" style="padding: 20px; font-size: 15px">
        <strong>Well done!</strong> You content has been successfully updated..
    </div>';
                                    $record = $site->getBean($_REQUEST["id"]);
                                }
                                ?>

                                <form class="beanform" name="content-bean" id="content-bean" method="post" action="">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Bean Name</label>
                                        <input type="text" class="form-control" name="bean_name" id="bean_name" value="<?php echo $record["bean_name"]; ?>" required>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Category</label><br>
                                        <select class="form-control" id="category" name="category">
                                            <option value="none">Select Existing Category OR -></option>';
                                            <?php
                                            $cats = $site->getBeanCategory();
                                            foreach($cats as $category) {
                                                if ($record["category"] == $category) {
                                                    $html .= '<option value="' . $category . '" selected="selected">' . $category . '</option>';
                                                } else {
                                                    $html .= '<option value="' . $category . '">' . $category . '</option>';
                                                }
                                            }
                                            echo $html
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>&nbsp;</label><br>
                                        <input class="form-control" type="text" name="new-cat" id="new-cat" value="" placeholder="Add New Category">
                                    </div>
                                </div>

                                <br>

                                <?php


                                    if($record["start_time"] != 0){
                                        $startTime = date('m/d/Y h:i A',$record["start_time"]);
                                        $startOutput = 'Start: '.$startTime;
                                    }else{
                                        $startTime = '';
                                        $startOutput = '';

                                    }
                                    if($record["end_time"] != 0) {
                                        $endTime = date('m/d/Y h:i A', $record["end_time"]);
                                        if($endTime != '' && $endTime != 0){
                                            $endOutput = ' - End: '.$endTime;
                                        }else{
                                            $endOutput = '';
                                        }

                                    }else{
                                        $endTime = '';
                                        $endOutput = '';
                                    }

                                    if($startOutput != '' ||  $endOutput != ''){
                                        $runtime = ' | Runtime Setup: ';
                                    }

                                    if($record["end_time"] != 0 && time() >= $record["end_time"]){
                                        $expired = '<span style="color:red"> - Content Expired: '.$endTime.'</span>';
                                        $endOutput = '';
                                        $startOutput = '';
                                    }
                                ?>

                                <div class="row">
                                    <div class="col-md-12">
                                        <button class="btn btn-fill btn-warning timerbutton" type="button"><i class="fa fa-clock-o" aria-hidden="true"></i> Setup Content Runtime</button>
                                    </div>
                                    <div style="height: 30px">&nbsp;</div>
                                    <div class="col-md-12 runtimer" style="background: #f3bc44; display: none; border-radius: 7px; padding: 20px;">
                                        <h3 style="color: #886a27"><i class="fa fa-clock-o" aria-hidden="true"></i> Content Runtime.</h3>
                                        <p>If you would like your content to be date sensitive set the below start and end time. <br>You do not need to set both to run you may select just a start date with no end date or a end date and content will start immediately.</p>
                                        <div class="row">
                                        <div class="col-md-4" style="padding-left: 0"><label style="color: #333;font-weight: bold;">From:</label><br><input class="form-control datepickerzz" type="text" name="start_this" id="start_this" value="<?php echo $startTime; ?>" autocomplete="off"></div>
                                        <div class="col-md-4"><label style="color: #333;font-weight: bold;">To:</label><br><input class="form-control datepickerzz" type="text" name="end_this" id="end_this" value="<?php echo $endTime; ?>" autocomplete="off"></div>
                                        </div>
                                    </div>
                                </div>
                                    <br>

                                    <div class="row">
                                        <div class="col-md-12">
                                        <label>Page Inclusion</label><br>
                                            <small>Below are the pages that this content bean are associated with.</small><br><br>
                                            <div style="background: #efefef; padding: 10px; border: solid thin #d6d6d6;">
                                                <?php

                                                    $checks = $site->checkBeanPages($record["bean_id"]);
                                                    foreach($checks as $pages){
                                                        echo '<span style="display: inline-block; padding: 5px; background: #fff; margin: 3px">'.$pages.'</span>';
                                                    }
                                                ?>
                                            </div>
                                        </div>

                                    </div>

                                    <br><br>

                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Bean Content</label><br>
                                        <textarea class="summernote" id="bean_content" name="bean_content" required=""><?php echo $record["bean_content"]; ?></textarea>
                                        <br><br>
                                        <button class="btn btn-fill btn-success" type="submit" id="submit_bean_content" name="submit_bean_content" onclick="saveBean()">Edit Content Bean</button>
                                        <button class="btn btn-danger" type="button" style="float: right;" onclick="deleteBean('<?php echo $record["id"]; ?>')"><i class="fa fa-trash"></i> Delete Bean For Good!</button>
                                        </form>
                                    </div>
                                </div>
<?php } ?>

                            </div>
                        </div>


                <?php if($record["bean_type"] != 'installed'){ ?>
                <div class="card">
                    <div class="row" style="padding: 20px">
                        <div class="col-md-12">

                                <div class="header">
                                    <h4>Bean Revision History</h4>
                                    <small>You can restore up to the last 12 previous versions of the content by selecting restore and confirming reset.<br><strong>(NOTE!)</strong> Revisions do not contain bean name or title tag settings.</small>
                                    <br><br>

                                    <div class="alert-warning reset-confirm" style="padding: 10px; display: none"></div>

                                    <table class="table-bordered table">
                                        <tr>
                                            <th>Revision Date</th>
                                            <th>Modified By</th>
                                            <th style="text-align:right">Action</th>
                                        </tr>
                                        <tr>
                                            <?php
                                            $pageHistory = $site->getBeanHistory($_REQUEST["id"]);
                                            $wt=0;
                                            for($i=0; $i<count($pageHistory); $i++){
                                                if($wt == 0){
                                                    $bak = 'style="background:#fff"';
                                                    $wt=1;
                                                }else{
                                                    $bak = '';
                                                    $wt=0;
                                                }
                                                if($pageHistory[$i]["codediff"] == 'true'){
                                                    $codeRepo = '| <button class="btn btn-xs btn-default btn-fill" data-toggle="tooltip" title="View Code Changes" onclick="reviewSource(\''.$pageHistory[$i]["id"].'\')"><i class="fa fa-download" aria-hidden="true"></i> View Source Changes</button>';
                                                }else{
                                                    $codeRepo = '';
                                                }
                                                echo '<tr '.$bak.'><td id="version_info_'.$pageHistory[$i]["id"].'" class="backup-items">'.date('m/d/Y H:i:s', $pageHistory[$i]["backup_date"]).'</td><td>'.$pageHistory[$i]["last_user"].'</td><td style="text-align:right"><button class="btn btn-xs btn-warning btn-fill" data-toggle="tooltip" title="Restore Version" onclick="restoreVersion(\''.$pageHistory[$i]["id"].'\')"><i class="fa fa-download" aria-hidden="true"></i> Restore</button> | <button class="btn btn-xs btn-primary btn-fill" onclick="openRevision(\''.$pageHistory[$i]["id"].'\')"><i class="fa fa-search" aria-hidden="true"></i> View Version</button>'.$codeRepo.'</td></tr>';
                                            }
                                            ?>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                    </div>
                </div>
                <?php } ?>

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
<script src="assets/js/moment.js"></script>
<script src="assets/js/bootstrap-datetimepicker.min.js"></script>

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
    function deleteBean(contentid){
        swal({
            title: 'Are you sure?',
            text: "Once you delete this content all data will be removed and you will no longer be able to access any of it's data.",
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
                url: 'inc/asyncCalls.php?action=deletebean&beanid='+contentid,
                success:function(data){
                    window.location.replace("content.php");
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

    function modalClose(){
        $('#myModalAS').modal('hide')
    }

    function saveBean(){
        if($(".note-editor").hasClass('codeview')){
            $( ".btn-codeview" ).trigger( "click" );
        }
        $(".beanform").submit();
    }

    function openRevision(id){
        $.ajax({
            url: 'inc/asyncCalls.php?action=captureversion&id='+id,
            success: function(data){
                $("#pagemodal .modal-body").html(data);
                $("#pagemodal .modal-title").html('Review Version');
                $("#pagemodal .modal-dialog").css('width','90%');
                $("#pagemodal").modal();
                $('.backup-items').css('background','none');
                $('#version_info_'+id).css('background-color','#fcf8e3');
            }
        })
    }

    function restoreVersion(id){
        var versioninfo = $('#version_info_'+id).html();
        $(".reset-confirm").html('<strong>NOTICE!</strong> - Are you sure you want to restore <strong style="text-decoration: underline ">'+versioninfo+'</strong> | <button class="btn btn-xs btn-default" onClick="restoreVersionFin(\''+id+'\',\'bean\')">Yes Restore</button> <button class="btn btn-xs btn-warning" onclick="cancelRevis()">Cancel </button>').slideDown('fast');
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
                $(".reset-confirm").html(data);
            }
        })
    }

    function reviewSource(id){
        $.ajax({
            url: 'inc/asyncCalls.php?action=reviewcodes&id='+id,
            success: function(data){
                $("#pagemodal .modal-body").html(data);
                $("#pagemodal .modal-title").html('Review Code Changes');
                $("#pagemodal .modal-dialog").css('width','90%');
                $("#pagemodal").modal();
                $('.backup-items').css('background','none');
                $('#version_info_'+id).css('background-color','#fcf8e3');
            }
        })
    }

    $(function(){
        $(".timerbutton").on('click',function(){
            $(".runtimer").toggle();
        })

        $('.datepickerzz').datetimepicker({
            inline: true,
            sideBySide: true,
            useCurrent: false
        });
        tinymce.init({
            selector: ".summernote",
            skin: "caffiene",
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
                "table contextmenu directionality emoticons paste textcolor codemirror"
            ],
            content_css : '../css/bootstrap.css, assets/css/helpers.css',

            contextmenu: "link image | myitem",
            setup: function(editor) {
                editor.addMenuItem('myitem', {
                    text: 'Open Content',
                    onclick: function() {
                        var beanName = editor.selection.getContent();


                        ///MINIMOD edit-content.php?id=3&minimod=true///
                        $.ajax({
                            url: 'inc/asyncCalls.php?action=minimod&beanid='+beanName,
                            success: function(data){
                                $("#myModal .modal-body").html(data);
                                $("#myModal").modal();
                                $(".modal-dialog").css('width','70%');

                            }
                        })
                    }
                });
            },
            file_browser_callback: function(field_name, url, type, win) {
                setplacer(field_name,url);
            },
            image_description: true,
            verify_html: false,
            toolbar1: "styleselect  bold italic underline alignleft aligncenter alignright alignjustify  bullist numlist outdent indent link unlink responsivefilemanager image media fontsizeselect forecolor backcolor code",
            menubar:false,
            image_advtab: true ,
            height: '400',
            forced_root_block: false,
            image_dimensions: false,
            image_class_list: [
                {title: 'Responsive', value: 'img-responsive'},
                {title: 'Image 100% Width', value: 'img-full-width'}
            ],
            // style_formats: [
            //     { width: 'Bold text', inline: 'strong' },
            //     { title: 'Red text', inline: 'span', styles: { color: '#ff0000' } },
            //     { title: 'Red header', block: 'h1', styles: { color: '#ff0000' } },
            //     { title: 'Badge', inline: 'span', styles: { display: 'inline-block', border: '1px solid #2276d2', 'border-radius': '5px', padding: '2px 5px', margin: '0 2px', color: '#2276d2' } },
            //     { title: 'Table row 1', selector: 'tr', classes: 'tablerow1' }
            // ],
            codemirror: {
                indentOnInit: true,
                path: 'codemirror-4.8',
                config: {
                    lineNumbers: true,
                    mode: "htmlmixed",
                    autoCloseTags: true,

                }
            },
            //external_plugins: { "filemanager" : "responsive_filemanager/filemanager/plugin.min.js"}
        });
    })

    function setplacer(ids,url){

        $("#pagemodal .modal-body").html('<iframe src="media_manager.php?returntarget='+ids+'" style="height:600px;width:100%; border: none"></iframe>');
        $("#pagemodal .modal-title").html('Media Browser');
        $("#pagemodal").modal();
        $("#pagemodal").css('z-index','75541');
        $("#pagemodal .modal-dialog").css('width','70%');
        $("#pagemodal .modal-backdrop").css('z-index','70000');
        $('#themedias').contents().find('#mcefield').val('myValue');
    }

    function setImgDat(inputTarget,img,alttext){
        //alert(inputTarget);
        // $('input[name="'+inputTarget+'"]').val(img);
        // $('input[name="alt"]').val(alttext);
        // $('input[name="'+inputTarget+'"]').focus();
        // $('input[name="alt"]').focus();
        var imgClean = img.replace("../../../../", "../");
        $('#'+inputTarget).val(imgClean);
        imgSucc();
    }
    function imgSucc(){
        swal({
            title: 'Object Added',
            text: 'I will now close.',
            type: 'success'
            //timer: 2000
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
</script>

    </body>
</html>