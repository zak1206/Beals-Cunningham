<?php include('inc/header.php'); ?>

<!-- Begin page -->
<div id="wrapper">

    <?php include('inc/topnav.php'); ?>


    <?php include('inc/sidebarnav.php'); ?>

            <!-- Top Bar Start -->



            <?php include('inc/sidebarnav.php'); ?>

    <div class="modal large" tabindex="-1" role="dialog">
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
                                        <li class="breadcrumb-item active"><a href="site-forms.php">Site Forms</a></li>
                                        <li class="breadcrumb-item active">Create Form</li>
                                    </ol>

                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>

                        <div class="card-box" style="margin-top:20px">

                            <div style="padding: 20px">
                                <h4 class="m-t-0 header-title">Create New Form</h4>
                                <p class="text-muted font-14 m-b-30">
                                    Use the builder below to create a new form for site.
                                </p>
                                <div class="msghold"></div>
                                <div style="clear:both;"></div>
                                <hr>

                                <div class="formbuilder row">
                                    <div class="col-md-6" style="padding: 20px">
                                        <label class="frmname">Form Name</label><br><small>Name of the form should not contain spaces or special characters. EG.. "Contact Form" should be "Contact_Form"</small>  <br>
                                        <input class="form-control" type="text" name="form_name" id="form_name" value="" required="" placeholder="Name of the form is required.">
                                    </div>

                                    <div class="col-md-6" style="padding: 20px">
                                        <label>Post Action</label><br><small>If you would like to submit form data to a custom form processor. NOTICE - Remove form-process from class area.</small><br>
                                        <input class="form-control" type="text" name="post_action" id="post_action" value="" placeholder="Leave blank to submit to system.">
                                    </div>
                                    <div class="clearfix"></div>

                                    <div class="col-md-6" style="padding: 20px">
                                        <label>Form Class</label><br><small>To have system submit and store form data, leave <code>form-process</code> in place below.</small><br>
                                        <input class="form-control" type="text" name="form_class" id="form_class" value="form-process" required="" placeholder="Here you can apply a style class">
                                    </div>

                                    <div class="col-md-6" style="padding: 20px">
                                        <label>multipart/form-data</label><br><small>This only needs to be on if you are using file uploads.</small><br>
                                        <input type="checkbox" name="multi" id="multi" value="true">
                                    </div>

                                    <div class="clearfix"></div>

                                    <div class="col-md-6" style="padding: 20px">
                                        <label class="frmsubj">Email Subject</label><br><small>This is the subject of the email to recipients</small><br>
                                        <input class="form-control" type="text" name="subject" id="subject" value="" required="" placeholder="Put Subject Here">
                                    </div>

                                    <?php
                                    include('inc/harness.php');

                                    $a = $data->query("SELECT crm_settings FROM mail_settings WHERE id = '1'");
                                    $b = $a->fetch_array();

                                    if($b["crm_settings"] != ''){
                                    ?>

                                    <div class="col-md-6" style="padding: 20px">
                                        <label>Pair Your CRM (Handle / SalesForce)</label><br><small>When turned on this will push form data to you selected CRM. NOTE! <a href="#crmnotes" style="color: #337aff; text-decoration: underline">How It Works?</a></small><br>
                                        <input class="checkcrm" type="checkbox" name="crmset" id="crmset" value="true">
                                    </div>

                                    <?php } ?>

                                    <div class="clearfix"></div>

                                    <div class="col-md-12" style="padding: 20px">
                                        <label>Success Message</label><br><small>This will be the message to the users once form is submitted. If left blank the system will supply a generic message.</small><br>
                                        <textarea class="form-control summernote" name="success_mess" id="success_mess" style="height: 200px"><div class="alert alert-success" style="margin: 20px">Put your success message here or overwrite to supply custom message.</div></textarea>
                                    </div>

                                    <div class="clearfix"></div>

                                    <div class="col-md-12" style="padding: 20px">
                                        <label>Recipients</label><br>
                                        <small>If Recipient emails are present the system will also send a copy to the email address's. To use multiple emails separate them with a comma.</small>
                                        <input class="form-control" type="text" name="recipients" id="recipients" value="" required="" placeholder="Place forms recipients here separated by comma.">
                                    </div>
                                </div>


                                    <div class="clearfix"></div>
                                <?php if($b["crm_settings"] != ''){ ?>
                                <a name="crmnotes"></a>
                                <div class="jumbotron crmnow" style="display: none"><h3>CRM Form Usage Instructions</h3><br>
                                    <p>Review below on how to setup your forms for CRM receiving.</p>
                                    <div class="handle">
                                        <strong>Handle Parameters.</strong><br><br>
                                        <ul style="padding: 0">
                                            <li style="display: block; padding: 10px 10px; background: #fff; font-style: italic;">1. Input field name and id's need to be set like <strong>"first_name" & "last_name"</strong> to capture users Full Name</li>
                                            <li style="display: block; padding: 10px 10px; background: #fff; font-style: italic;">2. Input field name and id's need to be set like <strong>"email"</strong> to capture users Email address</li>
                                            <li style="display: block; padding: 10px 10px; background: #fff; font-style: italic;">3. Input field name and id's need to be set like <strong>"phone"</strong> to capture users Phone Number</li>
                                            <li style="display: block; padding: 10px 10px; background: #fff; font-style: italic;">4. Input field name and id's need to be set like <strong>"mobile"</strong> to capture users Mobile Number</li>
                                            <li style="display: block; padding: 10px 10px; background: #fff; font-style: italic;">5. Textinput field name and id's need to be set like <strong>"description"</strong> to capture users questions / concerns</li>
                                        </ul>
                                    </div>
                                </div>
                                <?php } ?>

                                    <div class="build-wrap row" style="padding: 20px">
                                        <div class="col-md-8">
                                            <div class="droparea" style="border: dashed thin #333; padding: 20px 10px; background: #f7f7f7"><p class="frm-notice" style="text-align: center">Drag Items Here ...</p></div>
                                            <div class="jsonout"></div>
                                            <br>
                                            <button class="btn btn-success btn-fill" onclick="proessThings()">Create Form</button>
                                        </div>
                                        <div class="col-md-4">

                                            <ul id="draggable" class="list-group">
                                                <div class="list-group-item active" style="text-align: right">Form Items<br><small>Drag & drop items in builder box to the left.</small></div>
                                                <li class="list-group-item list-group-item-default" data-frelm="text_field"><i class="textfld_icon"></i> &nbsp; &nbsp; Text Field</li>
                                                <li class="list-group-item list-group-item-default" data-frelm="text_area"><i class="textars_icon"></i> &nbsp; &nbsp; Text Area</li>
                                                <li class="list-group-item list-group-item-default" data-frelm="hidden"><i class="hidden_icon"></i> &nbsp; &nbsp; Hidden</li>
                                                <li class="list-group-item list-group-item-default" data-frelm="select"><i class="select_icon"></i> &nbsp; &nbsp; Select</li>
                                                <li class="list-group-item list-group-item-default" data-frelm="location_selector"><i class="select_icon"></i> &nbsp; &nbsp; Location Recipients</li>
                                                <li class="list-group-item list-group-item-default" data-frelm="file_upload"><i class="fileups_icon"></i> &nbsp; &nbsp; File Upload</li>
                                                <li class="list-group-item list-group-item-default" data-frelm="checkbox_group"><i class="checkbox_icon"></i> &nbsp; &nbsp; Checkbox Group</li>
                                                <li class="list-group-item list-group-item-default" data-frelm="radio_group"><i class="radio_icon"></i> &nbsp; &nbsp; Radio Group</li>
                                                <li class="list-group-item list-group-item-default" data-frelm="header"><i class="header_icon"></i> &nbsp; &nbsp; Header</li>
                                                <li class="list-group-item list-group-item-default" data-frelm="paragraph"><i class="para_icon"></i> &nbsp; &nbsp; Paragraph</li>
                                                <li class="list-group-item list-group-item-default" data-frelm="div"><i class="div_icon"></i> &nbsp; &nbsp; Div</li>
                                                <li class="list-group-item list-group-item-default" data-frelm="button"><i class="button_icon"></i> &nbsp; &nbsp; Button</li>
                                            </ul>

                                        </div>
                                        <div class="clearfix"></div>
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
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
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
<script src="assets/js/bootstrap-switch.js"></script>
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

    $(function() {
        $( ".list-group-item" ).draggable({helper: "clone", appendTo: 'body', items: 'li'});
        $( ".droparea" ).droppable({
            drop: function( event, ui ) {
                var elem = ui.draggable.data('frelm');
                $.ajax({
                    url: 'inc/form_settings.php?action=createnew&type='+elem,
                    cache: false,
                    success: function(data){
                        $(".droparea").append(data);
                        $( ".droparea" ).sortable();
                        setmods();
                        refreshMediaBrowse();
                    }
                })

            }
        });
        $("[name='multi']").bootstrapSwitch();
        $("[name='crmset']").bootstrapSwitch({
            onSwitchChange: function(event, state) {
                if(state == true){
                    $(".crmnow").show();
                }else{
                    $(".crmnow").hide();
                }
            }
        });

        tinymce.init({
            selector: ".summernote",
            skin: "caffiene",
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
                "table contextmenu directionality emoticons paste textcolor codemirror"
            ],
            content_css : 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css',

            contextmenu: "link image | myitem",
            setup: function(editor) {
                editor.addMenuItem('myitem', {
                    text: 'Open Content',
                    onclick: function() {
                        var beanName = editor.selection.getContent();


                        ///MINIMOD edit-content.php?id=3&minimod=true///
                        $.ajax({
                            url: 'inc/asyncCalls.php?action=minimod&beanid='+beanName,
                            cache:false,
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
            height: '100',
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




    } );

    function setmods(){


        if ($(".frm-notice")[0]){
            $('.frm-notice').remove();
        }

        $(".edits-area").unbind("click");
        $(".edits-area").on('click',function(){
            var idars = $(this).data('fieldars');
            $('.text_filed_edits_'+idars).slideToggle('fast');
        })

        $(".labsset").on('keyup',function(){
            var randcode = $(this).data('fldname');


            if (! $(".fldnames-"+randcode).find('.asrtric').length) {
                $(".fldnames-"+randcode).html($(this).val());
            }else{
                $(".fldnames-"+randcode).html($(this).val()+'<span class="asrtric" style="color:red"> *</span>');
            }


        })

        $(".addopts").unbind("click");
        $(".addopts").on('click',function(){
            var itemid = $(this).data('optionfld');
            var optcount = $(".sele-opt"+itemid+' li').length;
            var countUpNum = parseInt(optcount) + 1;
            var max_top = 340;

            var dt = new Date();
            var countUp = dt.getHours() + "" + dt.getMinutes() + "" + dt.getSeconds()+countUpNum;

            $('.sele-opt'+itemid).append('<li class="list-group-item selopts-'+itemid+'-'+countUp+'"><div class="row"><div class="col-md-5"><input class="form-control" type="text" name="option-'+itemid+'-'+countUp+'" id="option-'+itemid+'-'+countUp+'" value="" placeholder="Label"></div><div class="col-md-5"><input class="form-control" type="text" name="value-'+itemid+'-'+countUp+'-value" id="value-'+itemid+'-'+countUp+'-value" value="" placeholder="Value"></div><div class="col-md-2"><button class="btn btn-sm btn-danger removeoption" data-optionid="'+itemid+'-'+countUp+'">X</button></div></div><div style="clear: both"></div></li>');
            $( ".sortable" ).sortable();

            $(".removeoption").on('click',function () {
                var selitem = $(this).data('optionid');
                $('.selopts-'+selitem).remove();
            })

        })
        $(".theremoves").unbind("click");
        $(".theremoves").on('click',function () {
            var contia = $(this).data('frmitm');

            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success mt-2',
                cancelButtonClass: 'btn btn-danger ml-2 mt-2',
                buttonsStyling: false
            }).then(function () {
                removeFrmItm(contia);

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


        })

        $(".reqs").unbind("click");
        $(".reqs").on('click',function () {
            var checkids = $(this).data('checkdata');
            if ($('#required-'+checkids).is(':checked')) {
                $(".fldnames-"+checkids).append('<span class="asrtric" style="color:red"> *</span>');
            }else{
                $(".fldnames-"+checkids+" .asrtric").remove();
            }
        })

    }

    function removeFrmItm(idset){
        $(".allcont-"+idset).remove();
    }

    function proessThings(){
        jsonObj = [];
        items = [];
        opt = [];
        optval = {}
        vaz = [];
        vazout = {}
        itemz = {}
        $(".frmarrs").each(function(e){

            //item ["fldtype"] = $(this).data('elmtype');

            eachitem = {}
            item = {}

            $(this).find(':input').each(function(e){

                id = this.id;
                if($(this).is(':checkbox')){
                    if($(this).is(":checked")){
                        var idfix = id.split('-');
                        //item ["type"] = idfix[0];
                        item [idfix[0]] = this.value;
                    }
                }else{

                    var idfix = id.split('-');
                    //item ["type"] = idfix[0];

                    if(idfix[0] == 'option'){
                        optval = this.value;
                        opt.push(optval);
                    }else{
                        if(idfix[0] == 'value'){
                            vazout = this.value;
                            vaz.push(vazout);
                        }else{
                            item [idfix[0]] = this.value;
                        }

                    }

                }
                // jsonObj.push(item);

            })

            if($(this).data('elmtype') == 'select' || $(this).data('elmtype') == 'location_selector' || $(this).data('elmtype') == 'checkbox' || $(this).data('elmtype') == 'radio') {
                $.each(opt, function (i, item) {
                    itemz [opt[i]] = vaz[i];
                })

                eachitem ["options"] = itemz;
            }

            eachitem ["field"] = item;
            eachitem ["fldTypes"] =  $(this).data('elmtype');
            items.push(eachitem);
            jsonObj = [];
            opt = [];
            itemz = {}
            vaz = [];
            vazout = {}
        });

        var myJSON = JSON.stringify(items);
        ///$('.jsonout').html(myJSON);

        processForm(myJSON);
    }


    function processForm(thefrm){


        var form_name = $("#form_name").val();
        var post_action = $("#post_action").val();
        var form_class = $("#form_class").val();

        //multi
        if ($('#multi').is(':checked')) {
            var multi = 'true';
        }else{
            var multi = 'false';
        }

        if ($('#crmset').is(':checked')) {
            var crmset = 'true';
        }else{
            var crmset = 'false';
        }



        var thesubject = $("#subject").val();
        var recipients = $("#recipients").val();
        var success_mess = tinyMCE.get('success_mess').getContent();

        var mess = '';
        $(".frmserr").remove();
        if(form_name != ''){
             mess += '';

        }else{
             mess += true;
            $('.frmname').append(' <div class="alert alert-danger frmserr">Must enter form name.</div>');
        }

        if(thesubject != ''){
             mess += '';
        }else{
             mess += true;
            $(".frmsubj").append(' <div class="alert alert-danger frmserr">Must enter a subject.</div>');
        }



        if(mess == '') {

            $.ajax({
                type: 'POST',
                // make sure you respect the same origin policy with this url:
                // http://en.wikipedia.org/wiki/Same_origin_policy
                url: 'inc/asyncCalls.php?action=saveform',
                cache:false,
                data: {
                    'form_json': thefrm,
                    'form_name': form_name,
                    'post_action': post_action,
                    'form_class': form_class,
                    'multi': multi,
                    'crmset': crmset,
                    'subject': thesubject,
                    'recipients': recipients,
                    'success_mess': success_mess
                },
                success: function (msg) {
                    if (msg == 'success') {
                        $(".msghold").html('<br><div class="alert alert-success"><strong>Success!</strong> - Your form has been created..</div>');
                        $(".formbuilder").hide();
                        $(".build-wrap").hide();
                        $('html,body').animate({
                            scrollTop: $(".msghold").offset().top
                        });
                    } else {
                        $(".msghold").html('<br><div class="alert alert-success"><strong>Something Went Wrong!</strong> - ' + msg + '</div>');
                        $('html,body').animate({
                            scrollTop: $(".msghold").offset().top
                        });
                    }
                }
            });
        }else{
            $("html, body").animate({ scrollTop: 0 }, "slow");
        }

        ///hljs.highlightBlock(code);
    }

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

   function refreshMediaBrowse(){
       $(".img-browser").on('click',function(){
           //alert('sdfsdf')
           var itemsbefor = $(this).data('setter');

           $(".modal-title").html('Select Media Folder');
           $(".modal-body").html('<iframe id="themedia" style="width: 100%; height: 450px; border: none" src="media_manager.php?typeset=simple&returntarget='+itemsbefor+'&dirset=true"></iframe>');
           $(".modal-dialog").css('width','869px');
           $(".modal").modal();
       })
   }

</script>

    </body>
</html>