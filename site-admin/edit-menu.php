<?php include('inc/header.php'); ?>

<!-- Begin page -->
<div id="wrapper">

    <?php include('inc/topnav.php'); ?>


    <?php include('inc/sidebarnav.php'); ?>

            <!-- Top Bar Start -->



            <?php include('inc/sidebarnav.php'); ?>
    <div id="mediamodal" class="modal large" tabindex="-1" role="dialog">
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


    <div class="modal large" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body table-bordered">
                    <h4 class="m-t-0 header-title">Create New Link</h4>
                    <p class="text-muted font-14 m-b-30">
                        Add menu objects.
                    </p>
                    <hr>

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
                                        <li class="breadcrumb-item"><a href="navigation.php">Navigations</a></li>
                                        <li class="breadcrumb-item active">Edit Navigation</li>
                                    </ol>

                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>

                        <?php
                            $navigationInfo = $site->getNavHtml($_REQUEST["navid"]);
                        ?>

                        <div class="card-box" style="margin-top:20px">
                            <div style="padding: 20px">
                                <h4 class="m-t-0 header-title">Create New Menu</h4>
                                <p class="text-muted font-14 m-b-30">
                                    Add menu objects.
                                </p>
                                <hr>
                                <div class="row">
                                    <form class="row" name="menu_infos" id="menu_infos" method="post" action="">
                                    <div class="col-md-4">
                                        <label>Menu Name</label>
                                    <input class="form-control" type="text" name="menu_name" id="menu_name" value="<?php echo $navigationInfo["menu_name"]; ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Main ul class(s)</label>
                                        <input class="form-control" type="text" name="menu_ul_class" id="menu_ul_class" value="<?php echo $navigationInfo["menu_class"]; ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label>&nbsp;</label><br>
                                        <input type="hidden" name="themenuid" id="themenuid" value="<?php echo $_REQUEST["navid"]; ?>">
                                        <button class="btn btn-success">Update Details</button>
                                    </div>
                                    </form>
                                </div>

                                <br>
                                <hr>
                                <br>

                                <label>Create Links</label><br><small>Here you can create / edit individual navigation items for your menu</small><br><br>

                                <div class="col-md-12" style="padding: 10px; background: #efefef">
                                    <form name="new_link_set" id="new_link_set" method="post" action="">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Nav Display</label>
                                                <input class="form-control" type="text" name="link_display" id="link_display" required><br>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Nav Link</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" name="link_item" id="link_item" class="form-control" placeholder="Add Link Here..." required>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary" type="button"><i class="ti ti-link" onclick="openMediaBrowse('link_item')"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>li Class(s)</label>
                                                <input class="form-control" type="text" name="li_class" id="li_class"><br>
                                            </div>
                                            <div class="col-md-3">
                                                <label>HREF Class(s)</label>
                                                <input class="form-control" type="text" name="link_class" id="link_class"><br>
                                            </div>

                                            <div class="col-md-3">
                                                <label>ul Class(s) <a href="#" style="color: #22a7ff"><i class="ti ti-info-alt"></i></a></label>
                                                <input class="form-control" type="text" name="ul_class" id="ul_class"><br>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Target</label>
                                                <select class="form-control" name="link_target" id="link_target">
                                                    <option>Select Target</option>
                                                    <option value="_self">_self</option>
                                                    <option value="_blank">_blank</option>
                                                    <option value="_parent">_parent</option>
                                                    <option value="_top">_top</option>
                                                </select><br>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Data Attributes / Other tag types</label>
                                                <input class="form-control" type="text" name="link_attr" id="link_attr"><br>
                                            </div>
                                        </div>

                                        <label>Mega Menu</label><br><small>If turned on, this will allow you to code a mega menu dropdown object.</small><br>
                                        <label class="switch"><input type="checkbox" name="mega" id="mega" value="true"><span class="slider round"></span></label><br><br>

                                        <div class="megas" style="display: none">
                                            <textarea class="summernote" id="mega_content" name="mega_content"></textarea>
                                        </div>

                                        <hr>

                                        <label>Inherent</label><br><small>If turned on, this will inherent the parents category.</small><br>
                                        <label class="switch"><input type="checkbox" name="inherent" id="inherent" value="true"><span class="slider round"></span></label><br><br>

                                        <input type="hidden" name="menu_parent" id="menu_parent" value="<?php echo $_REQUEST["navid"]; ?>">
                                        <button class="btn btn-success navitmbut">Add To Below</button>


                                    </form>
                                </div>
                                <br><br>

                                <label>Menu Objects</label><br>
                                <small>Drag to order your navigation items below. You can also nest navigation items under any item by dragging nav items slightly right.</small><br><br>

                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="custom-dd-empty dd" id="nestable_list_1" style="min-width: 100%">
                                           <ol class="dd-list parents" style="border:dashed thin #b6b6b6; padding: 5px; background: #efefef">
                                               <?php echo $navigationInfo["nav_html"]; ?>
                                           </ol>

                                        </div>
                                    </div>
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
<!--Nestable list-->
<script src="plugins/nestable/jquery.nestable.js"></script>
<script src="assets/pages/nestable.js"></script>

<script>
    $('.dd').nestable('serialize');
    $('.dd').on('change', function() {
        updateMenu()
    });

    function processNewLink(){
        $("#new_link_set").submit(function(e) {
            tinymce.triggerSave();

            e.preventDefault(); // avoid to execute the actual submit of the form.

            var form = $(this);
            var url = 'inc/asyncCalls.php?action=addsinglenavobject';



            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(), // serializes the form's elements.
                success: function(data)
                {

                    console.log(data);
                    var obj = jQuery.parseJSON(data);
                    if(obj.newid != undefined){
                        $(".custom-dd-empty .parents").append('<li class="dd-item dd3-item" data-id="'+obj.newid+'"> <div class="dd-handle dd3-handle"></div> <div class="dd3-content"> <div class="row"> <div class="col-md-8 namcol-'+obj.newid+'">'+obj.navread+'</div> <div class="col-md-4" style="text-align: right"><a href="javascript:editNavObj('+obj.newid+')" style="display: inline-block; padding: 0px 10px; background: green; color: #fff">Edit</a> | <a href="javascript:removeNavObj('+obj.newid+')" style="display: inline-block; padding: 0px 10px; background: red; color: #fff">Delete</a></div> </div> </div> </li>');
                    }else{
                        //navread
                        $(".namcol-"+obj.editid).html(obj.navread);
                        $("#itemid").remove();
                        $(".canedits").remove();
                    }
                    $('#new_link_set')[0].reset();
                    $("#inherent").attr('checked', false);
                    $("#mega").attr('checked', false);
                    $(".megas").hide();
                    $(".navitmbut").text('Add To Below');
                    updateMenu();
                }
            });


        });
    }

    function removeNavObj(id){


        swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonClass: 'btn btn-confirm mt-2',
            cancelButtonClass: 'btn btn-cancel ml-2 mt-2',
            confirmButtonText: 'Yes, delete it!'
        }).then(function () {

            var licount = $("li[data-id='"+id+"']").closest('ol').children().length;

            if(licount > 1){
                //LEAVE OL//
                $("li[data-id='"+id+"']").remove();
            }else{
                if($("li[data-id='"+id+"']").closest('ol').hasClass('parents')){
                    $("li[data-id='"+id+"']").remove();
                }else{
                    $("li[data-id='"+id+"']").closest('ol').remove();
                }

            }

            updateMenu();

            swal({
                    title: 'Deleted !'+id,
                    text: "Your file has been deleted",
                    type: 'success',
                    confirmButtonClass: 'btn btn-confirm mt-2'
                }
            )
        })



    }

    function updateMenu(){
        var navobjects = $('.dd').nestable('serialize');
        var menuid = $("#menu_parent").val();
        var menulayout = $(".parents").html();
        $.ajax({
            url: 'inc/asyncCalls.php?action=updatenavigation',
            type: 'POST',
            data: { navid:menuid, navobjects:navobjects, menulayout:menulayout},
            success: function(response){
                console.log(response);
            }
        })

    }

    function editNavObj(id){
        $.ajax({
            url: 'inc/asyncCalls.php?action=editnavobject&id='+id,
            cache:false,
            success: function(data)
            {
                var obj = jQuery.parseJSON(data);




                $("#link_display").val(obj.nav_read);
                $("#link_item").val(obj.nav_link);
                $("#link_class").val(obj.nav_class);
                $("#li_class").val(obj.li_class);
                $("#ul_class").val(obj.ul_class);
                $("#link_target").val(obj.nav_target);
                $("#link_attr").val(obj.nav_data_attr);
                if(obj.mega_area != null) {
                    tinymce.get("mega_content").execCommand('mceInsertContent', false, obj.mega_area);
                }
                $("#itemid").remove();
                $("#new_link_set").append('<input type="hidden" name="itemid" id="itemid" value="'+id+'">');
                //inherent

                $(".navitmbut").text('Save Edits');
                $(".canedits").remove();
                $('.navitmbut').after('<a class="canedits" href="javascript:canCeledit()" style="color: #de0000"> | Cancel Edit</a>');
                if(obj.add_parent != 'true'){
                    $("#inherent").attr('checked', false);
                }else{
                    $("#inherent").attr('checked', true);
                }

                if(obj.mega_active != 'true'){
                    $("#mega").attr('checked', false);
                    $(".megas").hide();
                }else{
                    $("#mega").attr('checked', true);
                    $(".megas").show();
                }

               // console.log(obj);
            }
        });
    }

    function openMediaBrowse(inputid){
        console.log(inputid);

        $("#mediamodal .modal-body").html('<iframe src="media_manager.php?returntarget='+inputid+'" style="height:600px;width:100%; border: none"></iframe>')
        $("#mediamodal .modal-title").html('Media');
        $("#mediamodal").modal();


        // $('input[name="src"]').val('http://192.168.100.65/Caff5.0/img/metal-background_720.jpg');

    }

    function setImgDat(inputTarget,img,alttext){
        //alert(inputTarget);
        $('input[name="'+inputTarget+'"]').val(img);
        $('input[name="alt"]').val(alttext);
        $('input[name="'+inputTarget+'"]').focus();
        $('input[name="alt"]').focus();
        imgSucc();
    }

    function canCeledit(){
        $('#new_link_set')[0].reset();
        $("#inherent").attr('checked', false);
        $(".canedits").remove();
        $(".navitmbut").text('Add To Below');
        $("#mega").attr('checked', false);
        $(".megas").hide();
    }

    function imgSucc(){
        swal({
            title: 'Object Added',
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

    $(function(){
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

        $("#mega").on('click',function(){
            if ($(this).prop('checked')) {
                $(".megas").show();
            }else{
                $(".megas").hide();
            }
        })
    })

    function setplacer(ids,url){

        $(".modal .modal-body").html('<iframe src="media_manager.php?returntarget='+ids+'" style="height:600px;width:100%; border: none"></iframe>');
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

    $(function(){
        $("#menu_infos").submit(function(e) {

            e.preventDefault(); // avoid to execute the actual submit of the form.

            var form = $(this);
            var url = 'inc/asyncCalls.php?action=changemenuinfo';

            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(), // serializes the form's elements.
                success: function(data)
                {
                    swal({
                            title: 'Menu Has Been Updated!',
                            text: "You can just close me now.",
                            type: 'success',
                            confirmButtonClass: 'btn btn-confirm mt-2'
                        }
                    )
                }
            });
        });

    })

    processNewLink();
</script>

    </body>
</html>