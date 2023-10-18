<?php


if(file_exists('../../inc/harness.php')){
    include('../../inc/harness.php');
}else{
    include('inc/harness.php');
}

$modFolder = 'installed_beans/package_builder';
include('../package_builder/functions.php');
$packStuff = new packageclass();
date_default_timezone_set('America/Chicago');
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->

    <title>Package Builder</title>
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
<!--    <link rel="stylesheet" href="../assets/css/bootstrap-datetimepicker.css">-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="../../assets/css/style.css" rel="stylesheet" type="text/css">
    <style>
        body {

        }

        iframe#content: 100vh !important;

        li.equiplist-item {
            padding: 10px;
            width: 100%;
            background: #E9ECEF;
            border: solid 1px #ccc;
            border-radius: 4px;
            list-style: none;
        }

        a {
            color: black;
        }

        #body-row {
            margin-left:0;
            margin-right:0;
        }
        #sidebar-container {
            min-height: 100vh;
            background-color: #333;
            padding: 0;
        }

        /* Sidebar sizes when expanded and expanded */
        .sidebar-expanded {
            width: 230px;
        }
        .sidebar-collapsed {
            width: 60px;
        }

        /* Menu item*/
        #sidebar-container .list-group a {
            height: 50px;
            color: white;
        }

        /* Submenu item*/
        #sidebar-container .list-group .sidebar-submenu a {
            height: 45px;
            padding-left: 30px;
        }
        .sidebar-submenu {
            font-size: 0.9rem;
        }

        /* Separators */
        .sidebar-separator-title {
            background-color: #333;
            height: 35px;
        }
        .sidebar-separator {
            background-color: #333;
            height: 25px;
        }
        .logo-separator {
            background-color: #333;
            height: 60px;
        }

        /* Closed submenu icon */
        #sidebar-container .list-group .list-group-item[aria-expanded="false"] .submenu-icon::after {
            content: " \f0d7";
            font-family: FontAwesome;
            display: inline;
            text-align: right;
            padding-left: 10px;
        }
        /* Opened submenu icon */
        #sidebar-container .list-group .list-group-item[aria-expanded="true"] .submenu-icon::after {
            content: " \f0da";
            font-family: FontAwesome;
            display: inline;
            text-align: right;
            padding-left: 10px;
        }

        .btn-primary {
            background-color: #097F0E;
            border: 1px solid #097F0E;
        }
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
    <?php
    include ('sidebar.php');

    ?>
    <!-- MAIN -->
    <div class="col p-4">
        <h1>Equipment Package Configurator</h1>
        <small>This plugin allows you to create and modify equipment packages. </small>
        <hr>
<!--        <p class="usage">To display the job board, copy/paste the code below into a page<br>-->
<!--            {mod}package_configurator-packageCall-1{/mod}-->
<!--        </p>-->
<!--        <button class="btn btn-success" style="float: right; margin: 10px; background: black; color: white;" onclick="manageLines()"><i class="fa fa-edit"></i> Manage Addons</button> <button class="btn btn-primary" style=" background: #333333; float: right; margin-top: 10px;" onclick="createNewAddon();"><i class="fa fa-plus"></i> Create New Addon</button><button class="btn btn-success" style="float: right; margin: 10px; background: #FAD335; color: black;" onclick="createPackage()"><i class="fa fa-plus"></i> Create New Package</button><button class="btn btn-success" style="float: right; margin: 10px; background: #FAD335; color: black;" onclick="getMainCats()"><i class="fa fa-plus"></i> Manage Categories</button>-->
        <div class="clearfix"></div>

        <div class="modareas">

        </div>

        <div>
            <table id="example" class="table table-bordered dataTable no-footer" style="width:100%">
                <thead>
                <tr>
                    <th style="background: #333; color: rgb(255, 255, 255); border-right: thin solid rgb(239, 239, 239);">Equipment</th>
                    <th style="background: #333; color: rgb(255, 255, 255); border-right: thin solid rgb(239, 239, 239);">Category</th>
                    <th style="background: #333; color: rgb(255, 255, 255); border-right: thin solid rgb(239, 239, 239);">Sub Category</th>
                    <th style="background: #333; color: rgb(255, 255, 255); border-right: thin solid rgb(239, 239, 239);">Action</th>

                </tr>
                </thead>
                <tbody>

                <?php

                $packages = $packStuff->getPackages();

                for($i=0; $i<count($packages); $i++){

                    $packsout .= '<tr id="'.$packages[$i]["id"].'">
                              <td>'.$packages[$i]["equipment_title"].'</td>
                              <td>'.$packages[$i]["package"].'</td>
                              <td>'.$packages[$i]["sub_category"].'</td>
                              <td><button class="btn" onclick="editPackage(\''.$packages[$i]["id"].'\')"><i class="fa fa-edit"></i></button> | <button class="btn" onclick="confirmDel(\''.$packages[$i]["id"].'\')"><i style="color: red;" class="fa fa-minus-circle"></i></button> <!-- <button class="btn"  onclick="confirmClone(\''.$packages[$i]["id"].'\')"><i class="fa fa-clone"></i></button>--></td>
                                </tr>';
                }

                echo $packsout;

                ?>
                </tbody>
            </table>
        </div>
    </div>







    </div><!-- Main Col END -->
</div><!-- body-row END -->

</div>








<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script src="js/bootstrap-switch.js"></script>
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

    $('#body-row .collapse').collapse('hide');

    // Collapse/Expand icon
    $('#collapse-icon').addClass('fa-angle-double-left');

    // Collapse click
    $('[data-toggle=sidebar-colapse]').click(function() {
        SidebarCollapse();
    });

    function SidebarCollapse () {
        $('.menu-collapsed').toggleClass('d-none');
        $('.sidebar-submenu').toggleClass('d-none');
        $('.submenu-icon').toggleClass('d-none');
        $('#sidebar-container').toggleClass('sidebar-expanded sidebar-collapsed');

        // Treating d-flex/d-none on separators with title
        var SeparatorTitle = $('.sidebar-separator-title');
        if ( SeparatorTitle.hasClass('d-flex') ) {
            SeparatorTitle.removeClass('d-flex');
        } else {
            SeparatorTitle.addClass('d-flex');
        }

        // Collapse/Expand icon
        $('#collapse-icon').toggleClass('fa-angle-double-left fa-angle-double-right');
    }

    function createNewCat(){
        $.ajax({
            url: 'asyncData.php?action=createnewcategory',
            cache: false,
            success: function(data){
                $("#example_wrapper").html(data);
                recallImg();
                finishAddCat();
            }

        });
    }

    function manageLines(){
        $.ajax({
            url: 'asyncData.php?action=getlines',
            cache: false,
            success: function(data) {
                $("#example_wrapper").html(data);
                $('#linetable').DataTable();
                // quickLineEdit();

            }
        })
    }

    function removeOnClick(){
        $(this).parent().remove();
    }

    function startDrag(){
        $( ".draggable" ).draggable({
            helper: 'clone',
            handle: ".dragsa"
        });

        $( ".droparea" ).droppable({
            connectToSortable: '.droparea',
            drop: function( event, ui ) {

                var lineid = ui.draggable.data('id');
                var nameout = ui.draggable.data('thename');
                var itemtype = ui.draggable.data('listtype');
                var itemprice = ui.draggable.data('listprice');

                var id = $(this).attr("id");
                $('#' + id).append('<div class="dropitemsin" data-id="'+lineid+'" style="background: #097F0E; border: solid .6px #eee; padding: 6px 10px; color: white; margin-bottom: 10px;"><p>'+nameout+'<span style="font-size: .6rem;"></span> - List Price: '+itemprice+'<span style="float: right;"></span></p><a class="removeites" onclick="removeOnClick()"><i class="fa fa-trash" aria-hidden="true"></i> Remove</a></div>');

                recallRemove();
                hideSelected();
            }


        });

        $('.removeites').click(function() {
            $(this).parent().remove();
        });
    }

    function filterLines(){
        $("#searchlines").keyup(function() {

            // Retrieve the input field text and reset the count to zero
            var filter = $(this).val(),
                count = 0;

            // Loop through the comment list
            $('.result-container div').each(function() {


                // If the list item does not contain the text phrase fade it out
                if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                    $(this).hide();  // MY CHANGE

                    // Show the list item if the phrase matches and increase the count by 1
                } else {
                    $(this).show(); // MY CHANGE
                    count++;
                }

            });

        });

    }

    function createPackage(){
        $.ajax({
            url: 'asyncData.php?action=newpackageform',
            cache: false,
            success: function(data) {
                $("#example_wrapper").html(data);
            }
        })
    };

    function getUsage(){
        $.ajax({
            url: 'asyncData.php?action=getusage',
            cache: false,
            success: function(data) {
                $("#example_wrapper").html(data);
            }
        })
    }

    function searchEquip() {
       var searchtext = $('#searchtext').val();

        $.ajax({
            url: 'asyncData.php?action=searchequip&searchtext='+searchtext,
            cache: false,
            success: function(data){
                $(".equip-search-results").html(data);
                // validateMy();
                // rerunEditor();
                //
                // $(".canempadd").on('click',function(){
                //     $(".modareas").empty();
                // })
            }

        })
    };

    function addFormDetails(equip_id) {
        $.ajax({
            url: 'asyncData.php?action=createaddform&equipid='+equip_id,
            cache: false,
            success: function(data){
                $(".search-container").hide();
                $("#form-container").html(data);
                changeSubCats();
                filterLines();
                startDrag();
                finishAddPackage();
            }

        });
    }

    function editMainCat(id) {
        $.ajax({
            url: 'asyncData.php?action=editcategory&id='+id,
            cache: false,
            success: function(data){
               $("#example_wrapper").html(data);
                recallImg();
                finishCatEdit();

            }

        });
    }

    function getMainCats() {
        $.ajax({
            url: 'asyncData.php?action=getcategories',
            cache: false,
            success: function(data){
                $("#example_wrapper").html(data);
                $('#maincattable').DataTable();
            }

        });
    }

    function finishAddCat(){
        $("#addcatform").validate({

            submitHandler: function(form) {
                $.ajax({
                    type: "POST",
                    url: "asyncData.php?action=addnewcat",
                    cache: false,
                    data: $("#addcatform").serialize(),
                    success: function(data)
                    {
                        swal({
                            title: 'Your Category Has Been Created',
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
                });
            }
        });
    }

    function finishLineEdit(id) {
        $("#addonquick").validate({

            submitHandler: function(form) {
                $.ajax({
                    type: "POST",
                    url: "asyncData.php?action=finishelineedit",
                    cache: false,
                    data: $("#addonquick").serialize(),
                    success: function(data)
                    {

                        $('#myModal').modal('toggle');
                        swal({
                            title: 'Your Addon Has Been Edited',
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

                });
            }
        });
    }



    function quickLineEdit(id) {
        $.ajax({
            url: 'asyncData.php?action=quickedit&id='+id,
            cache: false,
            success: function(data){
                $("#myModal .modal-body").html(data);
                $("#myModal").modal();
                $("#myModal .modal-dialog").css('width','70%');
                $("#myModal .modal-title").html('Addon Edit');
                finishLineEdit();
            }

        });
    }

    function getSubCats() {
        var value = $('#package_cat').val();
        $.ajax({
            url: 'asyncData.php?action=getsubs&value='+value,
            cache: false,
            success: function(data){
               $("#package_sub").html(data);
            }

        });
    }

    function changeSubCats() {
        var value = $('#package_cat_edit').val();
        $.ajax({
            url: 'asyncData.php?action=getsubs&value='+value,
            cache: false,
            success: function(data){
                $("#package_sub_edit").html(data);
            }

        });
    }

    function getSubCatsEdit() {
        var value = $('#package_cat_edit').val();
        var id = $('#package_id').val();
        $.ajax({
            url: 'asyncData.php?action=getsubsedit&value='+value+'&id='+id,
            cache: false,
            success: function(data){
                $("#package_sub_edit").html(data);
            }

        });
    }

    function editPackage(id){
        $.ajax({
            url: 'asyncData.php?action=editpackage&id='+id,
            cache: false,
            success: function(data) {
                $("#example_wrapper").html(data);

                $('.removeites').click(function() {
                    var checkrem = $(this).parent().attr('data-id');
                    console.log(checkrem);
                    $( ".productitem" ).each(function( index ) {
                        var dragid = $(this).attr('data-id');
                        if(checkrem == dragid) {
                            $(this).show();
                        }
                    });


                    $(this).parent().remove();

                });
                changeSubCats();
                getSubCatsEdit();
                filterLines();
                // quickLineEdit();
                startDrag();
                finishPackUpdate();
                hideSelected();
            }
        })
    };

    function hideSelected(){
        $( ".dropitemsin" ).each(function( index ) {
            var droppedid = $(this).attr('data-id');
            $( ".productitem" ).each(function( index ) {
                var dragid = $(this).attr('data-id');
                if(droppedid == dragid) {
                    $(this).hide();
                }


            });
        });
    }

    function recallRemove(){
        $('.removeites').click(function() {
            var checkrem = $(this).parent().attr('data-id');
            console.log(checkrem);
            $( ".productitem" ).each(function( index ) {
                var dragid = $(this).attr('data-id');
                if(checkrem == dragid) {
                    $(this).show();
                }
            });


            $(this).parent().remove();

        });
    }

    function createNewAddon(){
        $.ajax({
        url: 'asyncData.php?action=addline',
            cache: false,
            success: function(data) {
            $("#example_wrapper").html(data);
                finishAddLine();

            }
        })
    }

    function finishAddPackage(){
        $("#addpackage").validate({

            submitHandler: function(form) {
                var array = [];
                $('.droparea > .dropitemsin').each(function(){
                    console.log ($(this).data('id'));
                    array.push({id: $(this).data('id')})
                });

                $("#lines").val(JSON.stringify(array));

               // console.log('submitted');
                $.ajax({
                    type: "POST",
                    url: "asyncData.php?action=addpackage",
                    cache: false,
                    data: $("#addpackage").serialize(),
                    success: function(data)
                    {
                        swal({
                            title: 'Your Package Has Been Created',
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

                        location.reload();
                    }
                });
            }
        });
    }

    function finishAddLine(){
        $("#addline").validate({

            submitHandler: function(form) {
                var packarr = $('#packages').val();
                //console.log('submitted');
                $.ajax({
                    type: "POST",
                    url: "asyncData.php?action=createline",
                    cache: false,
                    data: $("#addline").serialize(),
                    success: function(data)
                    {
                        swal({
                            title: 'Your Addon Has Been Created',
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
                        $.ajax({
                            url: 'asyncData.php?action=getlines',
                            cache: false,
                            success: function(data) {
                                $("#example_wrapper").html(data);
                                finishAddLine();

                            }
                        })
                        // console.log(data);
                    }
                });
            }
        });
    }

    function finishCatEdit() {

        $("#editcatform").validate({

            submitHandler: function(form) {

                //console.log('submitted');
                $.ajax({
                    type: "POST",
                    url: "asyncData.php?action=finishcatedit",
                    cache: false,
                    data: $("#editcatform").serialize(),
                    success: function(data)
                    {
                        swal({
                            title: 'Your Category Has Been Updated',
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
                        console.log(data);
                        // $.ajax({
                        //     url: 'asyncData.php?action=getlines',
                        //     cache: false,
                        //     success: function(data) {
                        //         $("#example_wrapper").html(data);
                        //         finishAddLine();
                        //
                        //     }
                        // })
                    }
                });
            }
        });
    }

    function finishPackUpdate(){

        $("#editpackage").validate({

            submitHandler: function(form) {
                var array = [];
                $('.droparea > .dropitemsin').each(function(){
                    console.log ($(this).data('id'));
                    array.push({id: $(this).data('id')})
                });

                $("#lines").val(JSON.stringify(array));

                console.log('submitted');
                $.ajax({
                    type: "POST",
                    url: "asyncData.php?action=updatepackage",
                    cache: false,
                    data: $("#editpackage").serialize(),
                    success: function(data)
                    {
                        swal({
                            title: 'Your Package Has Been Updated',
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
                });
            }
        });
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

    function recallImg() {

        $(".img-browser").on('click', function () {
            var itemsbefor = $(this).data('setter');
            $("#myModalAS .modal-title").html('Select an Image For Link');
            $("#myModalAS .modal-body").html('<iframe id="themedia" style="width: 100%; height: 450px; border: none" src="../../media_manager.php?typeset=simple&returntarget=' + itemsbefor + '"></iframe>');
            $(".modal-dialog").css('width', '869px');
            $("#myModalAS").modal();
        })
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
        var imgClean = img.replace("../../../../", "");
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

    function confirmLineDel(id){
        var info = '<p>Are you sure you want to delete this listing?</p><br><button class="btn btn-danger btn-fill" onclick="finishLineDel('+id+')">Yes Delete</button> <button class="btn btn-success" data-dismiss="modal">No Keep It</button>';
        $("#myModal .modal-body").html(info);
        $(".modal-title").html('Notice!');
        $("#myModal").modal();
    }

    function confirmMainCatDel(id){
        var info = '<p>Are you sure you want to delete this listing?</p><br><button class="btn btn-danger btn-fill" onclick="finishCatDel('+id+')">Yes Delete</button> <button class="btn btn-success" data-dismiss="modal">No Keep It</button>';
        $("#myModal .modal-body").html(info);
        $(".modal-title").html('Notice!');
        $("#myModal").modal();
    }



    function confirmClone(id){
        var info = '<p>Are you sure you want to clone this listing?</p><br><button class="btn btn-danger btn-fill" onclick="finishClone('+id+')">Yes Clone</button> <button class="btn btn-success" data-dismiss="modal">No</button>';
        $("#myModal .modal-body").html(info);
        $(".modal-title").html('Notice!');
        $("#myModal").modal();
    }

    function finishDel(id){
        $.ajax({
            url: 'asyncData.php?action=deleteit&id='+id,
            cache: false,
            success: function(data){
                $('#myModal').hide();
                $('.modal-backdrop').hide();
                $('#'+id).remove();
                swal({
                    title: 'Your Package Has Been Deleted',
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
        })
    }

    function finishLineDel(id){
        $.ajax({
            url: 'asyncData.php?action=deleteitline&id='+id,
            cache: false,
            success: function(data){
                $('#myModal').hide();
                $('.modal-backdrop').hide();
                $('#'+id).remove();
                swal({
                    title: 'Your Addon Has Been Deleted',
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
        })
    }

    function finishCatDel(id){
       $.ajax({
            url: 'asyncData.php?action=deleteitcat&id='+id,
            cache: false,
            success: function(data){
                $('#myModal').hide();
                $('.modal-backdrop').hide();
                $('#'+id).remove();
                swal({
                    title: 'Your Category Has Been Deleted',
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
        })
    }




    function finishClone(id){
        $.ajax({
            url: 'asyncData.php?action=cloneit&id='+id,
            cache: false,
            success: function(data){

                swal({
                    title: 'Your Package Has Been Cloned',
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

                $('#myModal').hide();
                $('.modal-backdrop').hide();
            }
        })
    }
</script>
</body>
</html>
