<?php
include('../../inc/caffeine.php');
$site = new caffeine();
$userArray = $site->auth();
?><!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link href="plugins/switchery/switchery.min.css" rel="stylesheet" />
    <link href="../../plugins/sweet-alert/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap-switch.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.5/css/rowReorder.dataTables.min.css">
    <link rel="stylesheet" href="../../assets/css/bootstrap-datetimepicker.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.6/css/all.css">

    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        /* Hide default HTML checkbox */
        .switch input {display:none;}

        /* The slider */
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input.default:checked + .slider {
            background-color: #444;
        }
        input.primary:checked + .slider {
            background-color: #2196F3;
        }
        input.success:checked + .slider {
            background-color: #8bc34a;
        }
        input.info:checked + .slider {
            background-color: #3de0f5;
        }
        input.warning:checked + .slider {
            background-color: #FFC107;
        }
        input.danger:checked + .slider {
            background-color: #f44336;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        .swal2-container {
            z-index: 75542;
        }
    </style>

    <title>Caffeine Slider!</title>
</head>
<body style="height: 100vh">

<div id="slidestuff" class="modal" tabindex="-1" role="dialog">
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
<h1>Caffeine Slider</h1>
<p>Use the below settings to create and edit your sites media slider.</p>
<hr>


<div class="clearfix"></div>
<br>

<?php
//THIS SECTION IS FOR ADDING NEW SLIDES///
if(isset($_REQUEST["addslides"])){
?>
    <button style="float: right; margin: 10px" class="btn btn-primary" onclick="history.back()">Back To Sliders</button>
    <button style="float: right; margin: 10px" class="btn btn-warning" onclick="slidesholders()">Add New Slide</button>
    <div class="clearfix"></div>
    <br>
    <div class="slidesholders" style="background: #efefef; padding: 10px; display: none">

    <form name="newslide" id="newslide" method="post" action="">
        <label>Slide Name</label><br>
        <input class="form-control" type="text" name="slide_name" id="slide_name" value="" required="" autocomplete="off"><br>

        <label>Slide Content</label><br>
        <textarea class="summernote" id="bean_content" name="bean_content" required=""></textarea><br>

        <div class="row" style="margin: 0">
            <div class="col-md-12">
                <button class="btn btn-fill btn-warning timerbutton" type="button"><i class="fa fa-clock-o" aria-hidden="true"></i> Setup Content Runtime</button>
            </div>
            <div style="height: 30px">&nbsp;</div>
            <div class="col-md-12 runtimer" style="background: #f3bc44; display: none; border-radius: 7px; padding: 20px;">
                <h3 style="color: #886a27"><i class="fa fa-clock-o" aria-hidden="true"></i> Content Runtime.</h3>
                <p>If you would like your content to be date sensitive set the below start and end time. <br>You do not need to set both to run you may select just a start date with no end date or a end date and content will start immediately.</p>
                <div class="row">
                    <div class="col-md-4" style="padding-left: 0">
                        <label style="color: #333;font-weight: bold;">From:</label><br>
                        <input class="form-control datepickerzz" type="text" name="start_this" id="start_this" value="<?php echo $startTime; ?>" autocomplete="off">
                    </div>
                    <div class="col-md-4">
                        <label style="color: #333;font-weight: bold;">To:</label><br>
                        <input class="form-control datepickerzz" type="text" name="end_this" id="end_this" value="<?php echo $endTime; ?>" autocomplete="off">
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="slideid" id="slideid" value="<?php echo $_REQUEST["id"]; ?>">
        <input type="hidden" name="singleslideid" id="singleslideid" value="">
        <button type="button" style="float: right; margin: 10px" class="btn btn-warning" onclick="cancelSLide()">Cancel</button> <button style="float: right; margin: 10px" class="btn btn-success slidmodbod">Create</button>
    </form>
    <div class="clearfix"></div>
    </div>

    <h3>Current Slides</h3>
    <div id="result"></div>
    <div class="slidecarry">
        <table id="example" class="display" style="width:100%">
            <thead>
            <tr>
                <th style="font-weight: bold; background: rgb(93, 93, 93); color: rgb(255, 255, 255); border-right: thin solid rgb(239, 239, 239); width: 728px;">Slide Name</th>
                <th style="font-weight: bold; background: rgb(93, 93, 93); color: rgb(255, 255, 255); border-right: thin solid rgb(239, 239, 239); width: 728px; text-align: right">Action</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>

<?php
 }else{
    ////THIS WILL SHOW THE CURRENT SLIDERS//
    ?>
    <button class="btn btn-outline-primary" style="float: right; margin: 10px" onclick="createNewSlide()">Create New Slide</button>
    <div class="listholders"></div>

 <?php } ?>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/rowreorder/1.2.5/js/dataTables.rowReorder.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script src="../../plugins/sweet-alert/sweetalert2.min.js"></script>
<script src="../../assets/pages/jquery.sweet-alert.init.js"></script>
<script src="../../tinymce/js/tinymce/tinymce.min.js"></script>
<script src="../../assets/js/moment.js"></script>
<script src="../../assets/js/bootstrap-datetimepicker.min.js"></script>
<script>

    function cancelSLide(){
        if($(".slidesholders").is(":visible")){
            $(".slidesholders").toggle();
        }else{

        }

        var activeEditor = tinyMCE.get('bean_content');
        activeEditor.setContent('');
        $('#bean_content').val('');
        $("#singleslideid").val('');
        $("#slide_name").val('');
        $(".slidmodbod").text('Create');
    }

    <?php if(isset($_REQUEST["addslides"])){ ?>

    function editSlide(slideid){

        $.ajax({
            url: 'async.php?action=getsingleslide&slidesid='+slideid,
            success: function(data){
                var returnedData = JSON.parse(data);
                var slideName = returnedData["slide_name"];
                var start_this = returnedData["slide_start"]
                var end_this = returnedData["slide_end"]
                var slideContent = returnedData["slide_content"];
                $("#slide_name").val(slideName);
                $("#start_this").val(start_this);
                $("#end_this").val(end_this);
                var activeEditor = tinyMCE.get('bean_content');
                if(activeEditor!==null){
                    activeEditor.setContent(slideContent);
                    $('#bean_content').val(slideContent);
                } else {

                }
                $(".slidesholders").show();
                $("#singleslideid").val(slideid);
                $(".slidmodbod").text('Save Edits');

                $(".timerbutton").on('click',function(){
                    $(".runtimer").toggle();
                })

                $('.datepickerzz').datetimepicker({
                    inline: true,
                    sideBySide: true,
                    useCurrent: false
                });

            }
        })

    }

    function slidesholders(){
        if($(".slidesholders").is(":visible")){

        }else{
            $(".slidesholders").toggle();
        }

        var activeEditor = tinyMCE.get('bean_content');
        activeEditor.setContent('');
        $('#bean_content').val('');
        $("#singleslideid").val('');
        $("#slide_name").val('');
        $(".slidmodbod").text('Create');

        $(".timerbutton").on('click',function(){
            $(".runtimer").toggle();
        })

        $('.datepickerzz').datetimepicker({
            inline: true,
            sideBySide: true,
            useCurrent: false
        });
    }

    $(function(){
        intEdits();

        var sliderid = '<?php echo $_REQUEST["id"]; ?>';

        $.ajax({
            url: 'async.php?action=getslideslist&slidesid='+sliderid,
            success: function(data){
                $(".slidecarry").html(data);
                var table = $('#example').DataTable( {
                    rowReorder: true
                } );

                table.on( 'row-reorder', function ( e, diff, details, edit ) {



                    var values = [];


                    $('#example > tbody  > tr').each(function() {
                        var Something = $(this).closest('tr').find('td:eq(1)').text();
                        values.push({ name: Something });
                    });


                    var myString = JSON.stringify(values);

                   // console.log(myString);
                    $.ajax({
                        url: 'async.php?action=postorder',
                        type: "POST",
                        data: {myData:myString},
                        dataType: "text",
                        success: function(result){
                            swal({
                                title: 'Slides Reordered ',
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
                    });

                } );
            }
        })


        $("#newslide").validate({
            submitHandler: function(form) {
                var formName = $(form).attr('id');
                $.ajax({
                    type: "POST",
                    url: 'async.php?action=addslide',
                    data: new FormData(form),
                    contentType: !1,
                    cache: false,
                    processData: !1,
                    success: function(data) {
                        cancelSLide();
                        recallTable();
                    }
                })
            }
        })
    })

    function recallTable(){
        var sliderid = '<?php echo $_REQUEST["id"]; ?>';
        $.ajax({
            url: 'async.php?action=getslideslist&slidesid='+sliderid,
            success: function(data){
                $(".slidecarry").html(data);
                var table = $('#example').DataTable( {
                    rowReorder: true
                } );

                table.on( 'row-reorder', function ( e, diff, details, edit ) {



                    var values = [];


                    $('#example > tbody  > tr').each(function() {
                        var Something = $(this).closest('tr').find('td:eq(1)').text();
                        values.push({ name: Something });
                    });


                    var myString = JSON.stringify(values);

                    // console.log(myString);
                    $.ajax({
                        url: 'async.php?action=postorder',
                        type: "POST",
                        data: {myData:myString},
                        dataType: "text",
                        success: function(result){
                            swal({
                                title: 'Slides Reordered ',
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
                    });

                } );
            }
        })
    }

    function intEdits(){
        var activeEditor = tinymce.init({
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

                editor.on('change', function () {
                    tinymce.triggerSave();
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

    function deleteSlide(id){
        swal({
            title: 'Are you sure?',
            text: "Once you delete this slide all data will be removed and you will no longer be able to access any of it's data.",
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
                url: 'async.php?action=deleteslide&slideid='+id,
                success:function(data){
                    recallTable();
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

    <?php }else{ ?>
    $(document).ready(function() {

        $.ajax({
            url: 'async.php?action=getsliders',
            success: function(data){
                $(".listholders").html(data);
                $('#example').DataTable();
            }
        })
    } );

    function createNewSlide(){
        $("#slidestuff .modal-title").text('Create New Slider');

        $.ajax({
            url:'async.php?action=createnewslide',
            cache: false,
            success: function(data){
                $("#slidestuff .modal-body").html(data);

                $(".settings").on('click', function(){
                    var set = $(this).data('sett');

                    if ($(this).is(':checked')) {
                       // alert(set);
                        $(".numslide").show();
                    }else{
                        //alert('not checked');
                        $(".numslide").hide();
                    }
                })

                ///FORM PROCESS///

                $("#slides_settings").validate({
                    submitHandler: function(form) {
                        var formName = $(form).attr('id');
                        $.ajax({
                            type: "POST",
                            url: 'async.php?action=finishcreate',
                            data: new FormData(form),
                            contentType: !1,
                            cache: false,
                            processData: !1,
                            success: function(data) {
                                $("#slidestuff .modal-body").html(data)
                            }
                        })
                    }
                })
            }
        })

        $("#slidestuff").modal()
    }

    function modSlideSets(id){
        $("#slidestuff .modal-title").text('Edit Slider Settings');

        $.ajax({
            url:'async.php?action=modifyslidesettings&slideid='+id,
            cache: false,
            success: function(data){
                $("#slidestuff .modal-body").html(data);

                $(".settings").on('click', function(){
                    var set = $(this).data('sett');

                    if ($(this).is(':checked')) {
                        // alert(set);
                        $(".numslide").show();
                    }else{
                        //alert('not checked');
                        $(".numslide").hide();
                    }
                })

                ///FORM PROCESS///

                $("#slides_settings_edit").validate({
                    submitHandler: function(form) {
                        var formName = $(form).attr('id');
                        $.ajax({
                            type: "POST",
                            url: 'async.php?action=finishedit',
                            data: new FormData(form),
                            contentType: !1,
                            cache: false,
                            processData: !1,
                            success: function(data) {
                                $("#slidestuff .modal-body").html(data)
                            }
                        })
                    }
                })
            }
        })

        $("#slidestuff").modal()
    }

    function delSlider(id){
        swal({
            title: 'Are you sure?<br>Read Below!!!!',
            text: "You will need to remove the bean code from any pages that this slider bean is on, otherwise it could break the page.",
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
                url: 'async.php?action=deleteslider&sliderid='+id,
                success:function(data){
                    location.reload();
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


    <?php } ?>

</script>
</body>
</html>