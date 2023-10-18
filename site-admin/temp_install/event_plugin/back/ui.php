<?php
include('functions.php');
$contentStuff = new content_block();
date_default_timezone_set('America/Chicago');
?>
<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->

    <title>Edit Career Section</title>
    <link href="../../plugins/switchery/switchery.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="../../assets/css/style.css" rel="stylesheet" type="text/css">
<!--   <link rel="stylesheet" href="css/datetimepicker.css" />-->
    <link href="css/fullcalendar.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />
    <style>
        body, html {
            background: white;
        }

        iframe#content: 100vh !important;

        .jumbotron {
            background: wh
        }

        .btn-primary {
            color: #fff;
            background-color: #3bafda;
            border-color: #3bafda;
        }

        .fc-event {
            border: none;
        }

        a.fc-day-grid-event {
            border-radius: 2px;
            border: none;
            cursor: move;
            font-size: .8125rem;
            margin: 5px 7px;
            padding: 5px 5px;
            text-align: center;
        }

        .bootstrap-datetimepicker-widget.dropdown-menu {
            width: auto;
        }



    </style>
</head>

<body>
<!--modal 1 -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--modal 1 -->
<!--modal 2 -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--modal 2 -->
<!--modal 3 -->
<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--modal 3 -->
<!--modal AS -->
<div class="modal fade" id="myModalAS" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--modal AS -->


<h1>Event Module</h1>
<small>This module allows you to create events for your website. </small>
<p><br>To display a calendar with event information, please use code:<br><b>{mod}event_plugin-eventCall-1{/mod}</b></p><br>
<p>To display a list of your events as content, please use code: <br><b>{mod}event_plugin-eventListCall-1{/mod}</b></p>
<hr>

<!--<button class="btn btn-success" style="float: right; margin: 10px" onclick="createBlock()"><i class="fa fa-plus"></i> Create New Content Block</button>-->

<div class="container-fluid">

    <div class="row">
        <div class="col-lg-3">
            <a href="#" data-toggle="modal" data-target="#quick-add" class="btn btn-lg font-16 btn-primary btn-block" onclick="quickAdd()">
                <i class="mdi mdi-plus-circle-outline"></i> Create a Quick Event
            </a>
            <div id="external-events" class="m-t-20">
                <br>
                <p class="text-muted">Drag and drop your event or click in the calendar</p>
                <?php  $blocks = $contentStuff->get_nodates();
                for($i = 0; $i < count($blocks); $i++) {
                    echo '<div class="external-event '.$blocks[$i]['className'].' ui-draggable ui-draggable-handle" data-id="'.$blocks[$i]['id'].'" data-class="'.$blocks[$i]['className'].'" style="position: relative;">
                    <i class="mdi mdi-checkbox-blank-circle mr-2 vertical-middle"></i>'.$blocks[$i]['title'].'
                <!--<a style="float: right; cursor: pointer" onclick="editEvent('.$blocks[$i]['id'].');"><i class="fa fa-edit"></i></a>--></div>';
                }
                ?>
            </div>

            <!-- checkbox -->


        </div> <!-- end col-->

        <div class="col-lg-9">
            <div id="calendar"></div>
        </div> <!-- end col -->

    </div>
</div>





<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js" integrity="" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
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
<link href="https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css" rel="stylesheet"/>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<!--<script src="js/bootstrap-datetimepicker.js"></script>-->
<script src="js/fullcalendar.min.js"></script>
<scirpt src="https://unpkg.com/@fullcalendar/interaction@4.3.0/main.min.js"></scirpt>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>
<script>

    //alerts HERE

    function eventUpdateAlert(){
        swal({
            title: 'Event Updated',
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

    </script>

<script>

    function eventAddedAlert(){
        swal({
            title: 'Event Added',
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

    </script>

<script>
    function deleteProcess(){
        $( "#delete-btn" ).click(function() {
            alert( "Clicked" );
        });
    }
</script>


<!---->
<script>

    function deleteEvent(id){

        $.ajax({
            url: 'async-data.php?action=deletetheevent&id='+id,
            cache: false,
            success: function(data){
                $("#myModal").hide();
                $('#calendar').fullCalendar( 'refetchEvents' );
                $('.modal-backdrop').hide();
                swal({
                    title: 'Your Event Has Been Deleted',
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

    function deleteAlert(id){
        console.log(id);
        $.ajax({
            url: 'async-data.php?action=deleteconfirm&id='+id,
            cache: false,
            success: function(data){
                $("#myModal .modal-title").html('Notice - Delete Event');
                $("#myModal .modal-body").html(data);
                $("#myModal").modal();
                $("#myModal .modal-dialog").css('width','40%');



            }
        })
    };

    </script>

<script>



    </script>

    <script>

    //alerts END

    //quick add stuff

    function quickAdd(){
        $.ajax({
            url: 'async-data.php?action=quickadd',
            cache: false,
            success: function(data){
                $("#myModal .modal-title").html('Add Event');
                $("#myModal .modal-body").html(data);
                $("#myModal").modal();
                $("#myModal .modal-dialog").css('width','100%');

                validateQuickAdd();


            }
        })
    };

    function validateQuickAdd() {

        $('#quick-add-form').validate({
            submitHandler: function (form) {
                $.ajax({
                    type: 'POST',
                    url: 'async-data.php?action=quickaddsave',
                    data: $('#quick-add-form').serialize(),
                    success: function (data) {
                        $('#myModal').modal('hide');
                        eventAddedAlert();
                        recallNoDateEvents();


                    }
                });
            }
        });
    }

    </script>
    <script>

    function recallNoDateEvents() {
        $.ajax({
            url: 'async-data.php?action=nodatesrecall',
            success: function (data) {
                $("#external-events").html(data);
                recallDrag();

            }
        });
    }
    </script>

    <script>
    //quick add stuff ends here

    function validateAdd() {

        $('#save-event').validate({
            submitHandler: function (form) {
                $.ajax({
                    type: 'POST',
                    url: 'async-data.php?action=saveevent',
                    data: $('#save-event').serialize(),
                    success: function (data) {
                        $('#save-event').slideUp('fast');
                        $('#myModal3').modal('hide');
                        eventAddedAlert();
                        $('#calendar').fullCalendar( 'refetchEvents' );
                        console.log(data);


                    }
                });
            }
        });
    };
    </script>
    <script>

    //edit events stuff starts

    //edit events stuff starts

    function editEvent(id){
        $.ajax({
            url: 'async-data.php?action=editevent&id='+id,
            cache: false,
            success: function(data){
                $("#myModal3 .modal-title").html('Edit Event');
                $("#myModal3 .modal-body").html(data);
                $("#myModal3").modal();
                $("#myModal3 .modal-dialog").css('width','100%');
                processEdit();

            }
        })
    }
    </script>

    <script>
    //image stuff, tinymce, core stuff


    function passImage(imgpath,fld){
        $("#"+fld).val(imgpath);
        $("#myModalAS").modal('hide');
    }


    $(function(){
        $(".img-browser").on('click',function(){
            var itemsbefor = $(this).data('setter');
            $("#myModalAS .modal-title").html('Select an Image For Link');
            $("#myModalAS .modal-body").html('<iframe id="themedia" style="width: 100%; height: 450px; border: none" src="filedfiles.php?typeset=simple&fldset='+itemsbefor+'"></iframe>');
            $(".modal-dialog").css('width','869px');
            $("#myModalAS").modal();
        })

    });


    $(function(){
        $(".timerbutton").on('click',function(){
            $(".runtimer").toggle();
        })

        // $('.datepickerzz').datetimepicker({
        //     inline: true,
        //     sideBySide: true,
        //     useCurrent: false
        // });
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
                                $("#myModal2 .modal-body").html(data);
                                $("#myModal2").modal();
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

            $("#myModalAS .modal-body").html('<iframe src="../../media_manager.php?returntarget='+ids+'" style="height:600px;width:100%; border: none"></iframe>');
            $("#myModalAS .modal-title").html('Media Browser');
            $("#myModalAS").modal();
            $("#myModalAS").css('z-index','75541');
            $("#myModalAS .modal-dialog").css('width','70%');
            // $(".modal-backdrop").css('z-index','70000');
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
                title: 'Imaged Added',
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

            $("#myModalAS").hide();
        }


        function recallDatePicker() {
            $('.datepickert').datepicker({
                pickTime: false
            });
        };

    </script>

    <script>

    function recallEndDatePicker() {
        $('.datepicker').datepicker({
            uiLibrary: 'bootstrap4'
        });
    };

    // $(function() {
    //     $('.datepicker').datetimepicker({
    //         pickTime: false
    //     });
    // });

    //image stuff, tinymce, core stuff

    //full calendar function start

    function recallDrag(){
        $('#external-events div.external-event').each(function() {
            var color = $(this).attr('data-class');
            var eventid = $(this).attr('data-id');

            // store data so the calendar knows to render an event upon drop
            $(this).data('event', {
                id: eventid,
                className: color,
                title: $.trim($(this).text()), // use the element's text as the event title
                stick: false // maintain when user navigates (see docs on the renderEvent method)

            });

            // make the event draggable using jQuery UI
            $(this).draggable({
                zIndex: 999,
                revert: true,      // will cause the event to go back to its
                revertDuration: 0  //  original position after the drag
            });

        });
    }

    </script>
    <script>

    $(document).ready(function() {
            /* initialize the external events -----------------------------------------------------------------*/
            $('#external-events div.external-event').each(function() {
                var color = $(this).attr('data-class');
                var eventid = $(this).attr('data-id');


                // store data so the calendar knows to render an event upon drop
                $(this).data('event', {
                    id: eventid,
                    className: color,
                    title: $.trim($(this).text()), // use the element's text as the event title
                    stick: false // maintain when user navigates (see docs on the renderEvent method)
                });



                // make the event draggable using jQuery UI
                $(this).draggable({
                    zIndex: 999,
                    revert: true,      // will cause the event to go back to its
                    revertDuration: 0  //  original position after the drag
                });


            });

        setTimeout(function(){

            $('#calendar').fullCalendar({
                timeZone: 'UTC',
                plugins: ['interaction'],
                // defaultDate: moment.utc().format(),
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month'
                },
                editable: true,
                droppable: true, // this allows things to be dropped onto the calendar
                events: {
                    cache: false,
                    url: 'eventReader.php',
                    type: 'GET', // Send post data
                    error: function() {
                        console.log('There was an error while fetching events.');
                    }

                },

                dayClick: function(date) {

                  var dateform = $(this).attr("data-date");

                   // console.log(dateform);

                    var eventform = date._d;

                    var eventdate = date._i;


                    $.ajax({
                        url: 'async-data.php?action=addevent&eventdate='+eventdate+'&eventform='+eventform,
                        cache: false,
                        success: function(data){
                            $("#myModal3 .modal-title").html('Add Event');
                            $("#myModal3 .modal-body").html(data);
                            $("#myModal3").modal();
                            $("#myModal3 .modal-dialog").css('width','100%');
                            $('#startdate').datetimepicker({
                                debug: true,
                                keepOpen: true
                            });
                            $('#enddate').datetimepicker({
                                debug: true,
                                keepOpen: true
                            });
                            rerunEditor();
                            recallDatePicker();

                            validateAdd();

                        }
                    })


                    // change the day's background color just for fun

                },
                eventClick: function(calEvent, jsEvent, view) {
                    var eventId = calEvent.id;
                    $.ajax({
                        cache: false,
                        url: 'async-data.php?action=editevent&id='+eventId,
                        success: function(data){
                            $("#myModal .modal-title").html('Edit Event');
                            $("#myModal .modal-body").html(data);
                            $("#myModal").modal('show');
                            rerunEditor();
                            $(function () {
                                $('#startdate').datetimepicker({
                                    debug: true,
                                    keepOpen: true
                                });
                                $('#enddate').datetimepicker({
                                    debug: true,
                                    keepOpen: true
                                });
                            });
                            processEdit();
                        }

                    })
                  //  alert(eventId);
                },
                drop: function(date , calEvent) {

                        var eventid = calEvent.toElement.dataset["id"];

                        var dateset = date.format();
                        console.log(dateset);

                        $(this).remove();

                    $.ajax({
                        url: 'async-data.php?action=addexternalevent&id='+eventid+'&date='+dateset,
                        cache: false,
                        success: function(data){
                            eventUpdateAlert();
                            $('#calendar').fullCalendar( 'refetchEvents' );

                        }
                    })

                },
                eventDrop: function(event, delta, revertFunc) {
                    //inner column movement drop so get start and call the ajax function......
                    var id = event.id;
                    var start = event.start.format();
                    var end = event.end || event.start.clone().add(defaultDuration);
                    var defaultDuration = moment.duration($('#calendar').fullCalendar('option', 'defaultTimedEventDuration')); // get the default and convert it to proper type

                    var endday = end.format();

                    $.ajax({
                        url: 'async-data.php?action=updatedate&id='+id+'&start='+start+'&end='+endday,
                        cache: false,
                        success: function (data) {
                            eventUpdateAlert();

                        }
                    });

                },
                eventResize: function(info) {
                     var id = info.id;
                     var end = info.end.toISOString();

                    $.ajax({
                        url: 'async-data.php?action=updatedrag&id='+id+'&end='+end,
                        cache: false,
                        success: function (data) {
                            eventUpdateAlert();

                        }
                    });
                    console.log(info.end.toISOString());

                }


            });
        }, 1000);
    });

    //full calendar function end

    function processEdit() {

        $('#edit-event').validate({
            submitHandler: function (form) {
                $.ajax({
                    type: 'POST',
                    url: 'async-data.php?action=processedit',
                    cache: false,
                    data: $('#edit-event').serialize(),
                    success: function (data) {
                        $('#myModal').modal('hide');
                        eventUpdateAlert();
                        $('#calendar').fullCalendar( 'refetchEvents' );
                          console.log(data);


                    }
                });
            }
        });
    }
</script>
</body>
</html>