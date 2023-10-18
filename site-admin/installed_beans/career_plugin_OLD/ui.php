<?php


if(file_exists('../../inc/harness.php')){
    include('../../inc/harness.php');
}else{
    include('inc/harness.php');
}

$modFolder = 'installed_beans/career_plugin';
include('../career_plugin/functions.php');
$contentStuff = new career_block();
date_default_timezone_set('America/Chicago');
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->

    <title>Edit Career Section</title>
    <link href="../../plugins/switchery/switchery.min.css" rel="stylesheet" />

    <link href="../../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../../codemirror/lib/codemirror.css"/>
    <link rel="stylesheet" href="../../codemirror/theme/mbo.css">
    <link href="../../assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="../../plugins/sweet-alert/sweetalert2.min.css" rel="stylesheet">
    <link href="../../plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="../../plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="../../plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Multi Item Selection examples -->
    <link href="../../plugins/datatables/select.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="../../plugins/nestable/jquery.nestable.css" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/bootstrap-datetimepicker.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="../../assets/css/style.css" rel="stylesheet" type="text/css">
    <style>
        body {

        }

        iframe#content: 100vh !important;
    </style>
</head>

<body style="height: 100vh; background: white;">
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">
            </div>

        </div>

    </div>
</div>

<div id="myModalAS" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
<h1>Career Plugin</h1>
<small>This plugin allows you to create and modify careers. </small>
<hr>
<p class="usage">To display the job board, copy/paste the code below into a page<br>
    {mod}career_plugin-careerCall-2{/mod}
</p>
<button class="btn btn-success" style="float: right; margin: 10px" onclick="createCareer()"><i class="fa fa-plus"></i> Create New Career Listing</button>
<div class="clearfix"></div>
<?php
if(isset($_POST["title"])){
    if(isset($_POST["editform"])){
        $contentStuff->editJob($_POST);
        echo '<div class="alert alert-success" role="alert">
  Content block has been updated successfully.
</div>';
    }else{
        $contentStuff->addJob($_POST);
        echo '<div class="alert alert-success" role="alert">
  Content block has been updated successfully.
</div>';
    }


}
?>

<div class="modareas">

</div>

<div>
    <h2>Current Job Listings</h2>

    <table id="example" class="table table-bordered dataTable no-footer" style="width:100%">
        <thead>
        <tr>
            <th style="background: rgb(93, 93, 93); color: rgb(255, 255, 255); border-right: thin solid rgb(239, 239, 239);">Job Title</th>
            <th style="background: rgb(93, 93, 93); color: rgb(255, 255, 255); border-right: thin solid rgb(239, 239, 239);">Category</th>
            <th style="background: rgb(93, 93, 93); color: rgb(255, 255, 255); border-right: thin solid rgb(239, 239, 239);">Location</th>
            <th style="background: rgb(93, 93, 93); color: rgb(255, 255, 255); border-right: thin solid rgb(239, 239, 239);">Position Type</th>
            <th style="background: rgb(93, 93, 93); color: rgb(255, 255, 255); border-right: thin solid rgb(239, 239, 239);">Date Created</th>
            <th style="background: rgb(93, 93, 93); color: rgb(255, 255, 255); border-right: thin solid rgb(239, 239, 239);">Action</th>
        </tr>
        </thead>
        <tbody>

        <?php

        $jbs = $contentStuff->getJobs();

        for($i=0; $i<count($jbs); $i++){

            $location = $contentStuff->getJobLocationName($jbs[$i]["location"]);
            $jobsout .= '<tr class="linese'.$jbs[$i]["id"].'">
            <td>'.$jbs[$i]["career_title"].'</td>
            <td>'.$jbs[$i]["category"].'</td>
            <td>'.$location.'</td>
            <td>'.$jbs[$i]["position_type"].'</td>
            <td>'.date('m/d/Y',$jbs[$i]["date_set"]).'</td>
            <td> <button class="btn btn-xs btn-success" onclick="editCareer(\''.$jbs[$i]["id"].'\')">Edit</button> | <button class="btn btn-xs btn-danger btn-fill" onclick="confirmDel(\''.$jbs[$i]["id"].'\')">Delete</button></td>
        </tr>';
        }

        echo $jobsout;

        ?>
        </tbody>
        <tfoot>
        <tr>
            <th>Job Title</th>
            <th>Category</th>
            <th>Location</th>
            <th>Position Type</th>
            <th>Date Created</th>
            <th>Action</th>
        </tr>
        </tfoot>
    </table>
</div>
</div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js" integrity="" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script src="js/bootstrap-switch.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
<script src="js/carousel-back.js"></script>
<!-- Required datatable js -->
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables/dataTables.bootstrap4.min.js"></script>
<!-- Buttons examples -->

<!-- Key Tables -->
<script src="../../plugins/datatables/dataTables.keyTable.min.js"></script>

<!-- Responsive examples -->
<script src="../../plugins/datatables/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables/responsive.bootstrap4.min.js"></script>

<!-- Selection table -->
<script src="../../plugins/datatables/dataTables.select.min.js"></script>

<script src="../../codemirror/lib/codemirror.js"></script>
<script src="../../codemirror/mode/css/css.js"></script>
<script src="../../codemirror/mode/javascript/javascript.js"></script>
<script src="../../codemirror/mode/xml/xml.js"></script>
<script src="../../codemirror/mode/htmlmixed/htmlmixed.js"></script>
<script src="../../tinymce/js/tinymce/tinymce.min.js"></script>
<script src="js/md5.min.js"></script>
<script src="js/jquery.sticky.js"></script>
<script src="js/jquery.hideseek.js"></script>
<script src="../../plugins/sweet-alert/sweetalert2.min.js"></script>
<script src="../../assets/pages/jquery.sweet-alert.init.js"></script>

<script>



    $(document).ready( function () {
        $('#example').DataTable();
    } );

    function createCareer(){
        $.ajax({
            url: 'async-data.php?action=newform',
            cache: false,
            success: function(data){
                $(".modareas").html(data);
                validateMy();
                rerunEditor();

                $(".canempadd").on('click',function(){
                    $(".modareas").empty();
                })
            }

        })
    }

    function editCareer(id){
        $.ajax({
            url: 'async-data.php?action=editform&id='+id,
            cache: false,
            success: function(data){
                $(".modareas").html(data);
                validateMyEdit();
                rerunEditor();

                $(".canempadd").on('click',function(){
                    $(".modareas").empty();
                })
            }

        })
    }


    function addNewLoc(){
        $.ajax({
            url: 'async-data.php?action=addloc',
            cache: false,
            success: function(data){
                $("#myModal .modal-body").html(data);
                $("#myModal").modal();
                $("#myModal .modal-dialog").css('width','70%');
                $("#myModal .modal-title").html('Add New Location');
                $("#addloc").validate({
                    submitHandler: function(form) {
                        $.ajax({
                            url: 'async-data.php?action=addlocfin',
                            type: 'post',
                            data: $('#addloc').serialize(),
                            success: function(data) {
                                getnewLocations();
                            }
                        });
                    }
                });

            }
        })
    }

    function getnewLocations(){
        $("#location").empty();
        $.ajax({
            url: 'async-data.php?action=getnewlocs',
            cache: false,
            success: function(data){
                $("#location").append(data);
                $("#location").focus();
                $("#myModal").modal('toggle');
            }

        })
    }

    function validateMy(){
        $("#new_job_posting").validate();
    }

    function validateMyEdit(){
        $("#edit_job_posting").validate();
    }

    function rerunEditor(){
        tinymce.remove();
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
    }

    function intEdits(){
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
                            cache: false,
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
    }

    function setplacer(ids,url){

        $(".modal .modal-body").html('<iframe src="../../media_manager.php?returntarget='+ids+'" style="height:600px;width:100%; border: none"></iframe>');
        $(".modal .modal-title").html('Media Browser');
        $(".modal").modal();
        $(".modal").css('z-index','75541');
        $(".modal-dialog").css('width','70%');
        $(".modal-backdrop").css('z-index','70000');
        $('#themedias').contents().find('#mcefield').val('myValue');
    }

    function setImgDat(inputTarget,img,alttext){
        //alert(inputTarget);
        // $('input[name="'+inputTarget+'"]').val(img);
        // $('input[name="alt"]').val(alttext);
        // $('input[name="'+inputTarget+'"]').focus();
        // $('input[name="alt"]').focus();
        var imgClean = img.replace("../../../../", "../../../");
        $('#'+inputTarget).val(imgClean);
        imgSucc();
    }
    function imgSucc(){
    alert('Image Added');
    }

    function confirmDel(id){
        var info = '<p>Are you sure you want to delete this listing?</p><br><button class="btn btn-danger btn-fill" onclick="finishDel('+id+')">Yes Delete</button> <button class="btn btn-success" data-dismiss="modal">No Keep It</button>';
        $("#myModal .modal-body").html(info);
        $(".modal-title").html('Notice!');
        $("#myModal").modal();
    }

    function finishDel(id){
        $.ajax({
            url: 'async-data.php?action=deleteit&id='+id,
            cache: false,
            success: function(data){
                //DO THINGS HERE
                $(".linese"+id).remove();
                $("#myModal").modal('toggle');
            }
        })
    }
</script>
</body>
</html>