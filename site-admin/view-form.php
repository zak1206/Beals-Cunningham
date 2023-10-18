<?php
date_default_timezone_set('America/Chicago');
if(isset($_POST["start_this"])) {

    if($_POST["start_this"] != null && $_POST["end_this"] != null && strtotime($_POST["end_this"]) > strtotime($_POST["start_this"])) {
        //error_reporting(0);
        include('inc/caffeine.php');
        $site = new caffeine();

        $start = strtotime($_POST["start_this"]);
        $end = strtotime($_POST["end_this"]);
        $theOutput = $site->getFormDataCsv($_POST["formname"], $start, $end);
//        echo '<pre>';
//        var_dump($theOutput);
//        echo '</pre>';

        $clenName = ucwords(str_replace('_', ' ', $_POST["formname"]));
        $filename = '' . $_POST["formname"] . '_' . $start . '_' . $end . '.csv';
        $delimiter = ';';
        $headings = $theOutput["headers"];

        // Open the output stream
        $fh = fopen('php://output', 'w');

// Start output buffering (to capture stream contents)
        ob_start();

        fputcsv($fh,$headings);

        // Loop over the * to export
        if (! empty($theOutput["datasets"])) {
            foreach ($theOutput["datasets"] as $item) {
                fputcsv($fh, $item);
            }
        }

// Get the contents of the output buffer
        $string = ob_get_clean();

        $filename = 'csv_' . date('Ymd') .'_' . date('His').'.csv';

// Output CSV-specific headers
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private",false);
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Transfer-Encoding: binary");
        exit($string);


        $pdfError = '';
    }else{
        $pdfError = '<div class="alert alert-danger"><strong>NOTICE! - </strong> You must select both From and End Dates and End date must be greater than From Date in order to produce output csv.</div>';
    }
}else{
    $pdfError = '';
}

?>
<?php include('inc/header.php'); ?>

        <!-- Begin page -->
        <div id="wrapper">

            <?php include('inc/topnav.php'); ?>


            <?php include('inc/sidebarnav.php'); ?>

            <div id="myModal" class="modal large" tabindex="-1" role="dialog">
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
                                        <li class="breadcrumb-item active">Edit Form</li>
                                    </ol>

                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>

                        <div class="card-box" style="margin-top:20px">
                            <?php if (!empty($_POST["headerssets"])){

                                if(count($_POST["headerssets"]) < 5){
                                    $site->doformsets($_POST);
                                    echo '<div class="alert alert-success">Setup Successfull</div>';
                                }else{
                                    echo '<div class="alert alert-danger"><strong>NOTICE! - </strong>It appears you have selected to many headers. Please only choose up to 4.</div>';
                                }
                            }

                            ?>
                            <div style="padding: 20px">
                                <h4 class="title">View <?php echo str_replace('_',' ',$_REQUEST["form"]) ?> Data and Modify.</h4>
                                <p class="category">Your form data is stored below.</p>
                                <a href="site-forms.php" class="btn btn-success btn-fill" style="float:right; margin: 20px"><i class="fa fa-angle-double-left" aria-hidden="true"></i> Back To Forms</a>
                                <br>
                                <p><button class="btn btn-warning toggle-edit">Click here to edit</button></p>
                                <div class="clearfix"></div>
                                <hr>

                            </div>

                            <?php
                            $formData = $site->getSingleForm($_REQUEST["form"]);
                            ?>

                            <div class="daalert"></div>

                            <div class="formeditars" style="display: none">
                                <div class="row">
                                <div class="col-md-6" style="padding: 20px">
                                    <label>Form Name</label><br>
                                    <small>Name of the form should not contain spaces or special characters. EG.. "Contact Form" should be "Contact_Form"</small><br>
                                    <span style="font-size: 20px;background: #efefef;display: block;padding: 5px;border-radius: 4px;border: solid thin #dcdcdc;"><?php echo $_REQUEST["form"]; ?></span><input type="hidden" name="form_name" id="form_name" value="<?php echo $_REQUEST["form"]; ?>">
                                </div>

                                <div class="col-md-6" style="padding: 20px">
                                    <label>Post Action</label><br>
                                    <small>If you would like to submit form data to a custom form processor. NOTICE - Remove form-process from class area.</small>
                                    <br>
                                    <input class="form-control" type="text" name="post_action" id="post_action" value="<?php echo $formData["post_link"]; ?>" placeholder="Leave blank to submit to system.">
                                </div>
                                <div class="clearfix"></div>

                                <div class="col-md-6" style="padding: 20px">
                                    <label>Form Class</label><br>
                                    <small>To have system submit and store form data, leave <code>form-process</code> in place below.</small><br>
                                    <input class="form-control" type="text" name="form_class" id="form_class" value="<?php echo $formData["form_class"]; ?>" required="" placeholder="Here you can apply a style class">
                                </div>

                                <div class="col-md-6" style="padding: 20px">
                                    <label>multipart/form-data</label><br>
                                    <small>This only needs to be on if you are using file uploads.</small><br>
                                    <?php if($formData["is_multi"] == 'true'){$checked = 'checked="checked"';}else{$checked = '';} ?>
                                    <input type="checkbox" name="multi" id="multi" value="true" <?php echo $checked; ?>>
                                </div>

                                <div class="clearfix"></div>
                                <div class="col-md-6" style="padding: 20px">
                                    <label>Email Subject</label><br><small>This is the subject of the email to recipients</small><br>
                                    <input class="form-control" type="text" name="subject" id="subject" value="<?php echo $formData["subject"]; ?>" required="" placeholder="Put Subject Here">
                                </div>

                                    <?php
                                    include('inc/harness.php');

                                    $a = $data->query("SELECT crm_settings FROM mail_settings WHERE id = '1'");
                                    $b = $a->fetch_array();

                                    if($b["crm_settings"] != ''){
                                        ?>

                                        <div class="col-md-6" style="padding: 20px">
                                            <label>Pair Your CRM (Handle / SalesForce)</label><br><small>When turned on this will push form data to you selected CRM. NOTE! <a href="#crmnotes" style="color: #337aff; text-decoration: underline">How It Works?</a></small><br>
                                            <?php if($formData["crmpush"] == 'true'){$checked = 'checked="checked"';}else{$checked = '';} ?>
                                            <input type="checkbox" name="crmset" id="crmset" value="true" <?php echo $checked; ?>>
                                        </div>

                                    <?php } ?>

                                <div class="clearfix"></div>

                                <div class="col-md-12" style="padding: 20px">
                                    <label>Success Message</label><br><small>This will be the message to the users once form is submitted. If left blank the system will supply a generic message.</small><br>
                                    <textarea style="height: 200px;" class="form-control summernote" name="success_mess" id="success_mess"><?php echo $formData["success_mess"]; ?></textarea>
                                </div>

                                    <div class="col-md-12" style="padding: 20px">
                                        <label>Reply Message</label><br><small>With this turned on it will send a reply to the user.</small><br>
                                        <?php if($formData["reply_active"] == 'true'){$checked = 'checked="checked"'; $showit = 'display:block';}else{$checked = ''; $showit = 'display:none';} ?>
                                        <input type="checkbox" name="replyset" id="replyset" value="true" <?php echo $checked; ?>><br><br>
                                        <div class="replybox" style="<?php echo $showit; ?>">
                                        <textarea name="respmess" id="respmess" class="summernote"><?php echo $formData["reply_message"]; ?></textarea>
                                        </div>
                                    </div>

                                <div class="clearfix"></div>

                                <div class="col-md-12" style="padding: 20px">
                                    <label>Recipients</label><br>
                                    <input class="form-control" type="text" name="recipients" id="recipients" value="<?php echo $formData["recipients"]; ?>" required="" placeholder="Place forms recipients here separated by comma.">
                                </div>
                                </div>

                                <div class="clearfix"></div>
                                <br><br>
                                <div style="color: #fff; background: #ef5d2a; padding: 10px 10px;margin: 1px 33px;">NOTICE! - Making any changes to the forms elements will create a new form in the system that will need to be set back up to view inqueries. <br>The system will also archive older inqueries.</div>

                                <div class="clearfix"></div>
                                <?php if($b["crm_settings"] != ''){ ?>
                                    <br><br>
                                    <a name="crmnotes"></a>
                                    <?php if($formData["crmpush"] == 'true'){
                                        $showJumbo = 'block';
                                    }else{
                                        $showJumbo = 'none';
                                    }
                                    ?>
                                    <div class="jumbotron crmnow" style="display: <?php echo $showJumbo; ?>"><h3>CRM Form Usage Instructions</h3><br>
                                        <p>Review below on how to setup your forms for CRM receiving. <span style="color:red">All fields below must be present inside your form with the exception of phone & mobile.</span></p>
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


                                <div class="build-wrap" style="padding: 20px">
                                    <div class="row">
                                    <div class="col-md-8">
                                        <div class="droparea" style="border: dashed thin #333; padding: 20px 10px; background: #f7f7f7">
                                            <?php
                                            ///GET FORM ELEMENTS////
                                            $formsElems = $site->getFormElems($formData["form_data"]);
                                            echo $formsElems;
                                            ?>
                                        </div>
                                        <div class="jsonout"></div>
                                        <br>
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
                                    </div>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="col-md-12" style="text-align: right; padding: 20px">
                                    <button class="btn btn-fill btn-success" onclick="proessThings()">Update Form</button> | <button class="btn btn-danger" onclick="deleteForm('<?php echo $formData["id"]; ?>')"><i class="ti-alert"></i> DELETE FORM</button>
                                </div>
                                <div class="clearfix"></div>


                            </div>

                            <div class="header">
                                <h4 class="title">Requests Below.</h4>
                                <p class="category">Your form data is stored below.</p>

                                <?php echo $pdfError; ?>

                                <div class="col-md-12" style="padding: 20px; text-align: right"><a class="btn btn-default btn-sm btn-fill" href="javascript:openExport()"><i class="ti-calendar"></i> Export Form Data by Date</a> <a class="btn btn-primary btn-fill btn-sm" href="javascript:openArchive('<?php echo $_REQUEST["form"]; ?>')"><i class="ti-archive"></i> View Archive</a><br>

                                    <div class="exportcontainer" style="background: #efefef; padding: 10px; display: none">
                                        <form name="export-form" id="export-form" method="post" action="">
                                            <p>Select both "From and End Date" below in order to export a request pdf.</p>
                                            <div class="row">
                                            <div class="col-md-4"></div>
                                            <div class="col-md-4" style="padding-left: 0"><label style="color: #333;font-weight: bold;">From:</label><br><input style="background: #fff" class="form-control datepickerzz" type="text" name="start_this" id="start_this" value="" autocomplete="off"></div>
                                            <div class="col-md-4"><label style="color: #333;font-weight: bold;">End:</label><br><input style="background: #fff" class="form-control datepickerzz" type="text" name="end_this" id="end_this" value="" autocomplete="off"></div>

                                            <input type="hidden" id="formname" name="formname" value="<?php echo $_REQUEST["form"]; ?>">
                                            <div class="clearfix"></div>
                                            <br>
                                            <div class="col-md-12" style="text-align: right"><button type="submit" class="btn btn-warning btn-fill">Export</button></div>
                                            <div class="clearfix"></div>
                                            </div>
                                        </form>
                                    </div>
                                </div>


                                <div class="clearfix"></div>
                            </div>

                            <?php
                            ////build header////
                            ///
                            if($_REQUEST["form"] != null) {



                                $headerInfo = $site->getFormHeaders($_REQUEST["form"]);
                                $headerInfoprocess = $site->getProceeHeaders($_REQUEST["form"]);
                                $settings = $site->getFromSetting($_REQUEST["form"]);



                                if(!empty($settings)){

                                    if(!empty($headerInfo)) {

                                        for ($i = 0; $i <= count($headerInfoprocess); $i++) {
                                            if ($headerInfoprocess[$i]["column"] != null && $headerInfoprocess[$i]["column"] != 'active' && $headerInfoprocess[$i]["column"] != 'message') {
                                                $headerTab = ucwords(str_replace('_', ' ', $headerInfoprocess[$i]["column"]));
                                                $tabs .= '<th style="font-weight: bold;background: rgb(93, 93, 93);color: rgb(255, 255, 255); border-right: thin solid rgb(239, 239, 239);">' . $headerTab . '</th>';
                                                $columns .= $headerInfoprocess[$i]["column"] . ', ';
                                            }
                                        }

                                        $columnOut = rtrim($columns, ', ');

                                        $getList = $site->getFormsData($_REQUEST["form"], $columnOut);

                                        //var_dump($getList);


                                        for ($j = 0; $j < count($getList); $j++) {
                                            $ex = explode(', ', $columnOut);

                                            if ($getList[$j]["status"] == 'new') {
                                                $back = 'style="background:#bcf3bc; border-bottom:solid thin #dff7df"';
                                            } else {
                                                $back = '';
                                            }
                                            $results .= '<tr ' . $back . ' class="mess-'.$getList[$j]["id"].'">';
                                            foreach ($ex as $keys) {
                                                //echo $keys;
                                                if ($keys == 'receive_date') {
                                                    $outty = date('m/d/Y h:ia', $getList[$j][$keys]);
                                                } else {

                                                    $outty = $getList[$j][$keys];
                                                }

                                                if($keys != 'form_files') {
                                                    if (strlen($outty) > 40) {
                                                        $outty = substr($outty, 0, 40) . '...';
                                                    }
                                                }else{
                                                    $str = $getList[$j][$keys];
                                                    preg_match_all('/<a .*?>(.*?)<\/a>/',$str,$matches);
                                                    $fileName = $matches[1][0];
                                                    if (strlen($fileName) > 40) {
                                                        $fileName = substr($fileName, 0, 40) . '...';
                                                    }
                                                    $link = $getList[$j][$keys];
                                                    preg_match_all('/<a[^>]+href=([\'"])(?<href>.+?)\1[^>]*>/i', $link, $result);

                                                    if (!empty($result)) {
                                                        # Found a link.

                                                        $outty = '<a href="'.$result['href'][0].'" target="_blank">'.$fileName.'</a>';
                                                    }

                                                }



                                                $results .= '<td style="text-align: left">' . $outty . '</td>';
                                            }

                                            $results .= '<td style="text-align: right"><button class="btn btn-sm btn-success btn-xs readmess" data-messid="' . $getList[$j]["id"] . '" data-form="' . $_REQUEST["form"] . '"><i class="fa fa-search" aria-hidden="true"></i> Read</button> <button class="btn btn-sm btn-danger btn-xs delmess" data-messid="' . $getList[$j]["id"] . '" data-form="' . $_REQUEST["form"] . '"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button></td>';

                                            $results .= '</tr>';
                                        }
                                        $empty = 'false';
                                    }else{
                                        $empty = 'true';
                                    }
                                }else{
                                    $empty = 'true';
                                    ///DO SETTINGS
                                    ///
                                    if(!empty($headerInfo)) {
                                        echo '<div style="padding: 20px"><h2>Settings</h2><small>Please select up to four relevant columns to use as list output.</small><br><br>';

                                        echo '<form name="setupform" id="setupform" method="post" action="">';



                                        for ($p = 0; $p < count($headerInfo); $p++) {
                                            if ($headerInfo[$p]["column"] != 'receive_date' && $headerInfo[$p]["column"] != 'active' && $headerInfo[$p]["column"] != 'status' && $headerInfo[$p]["column"] != 'id') {
                                                echo '<label style="display: inline-block; padding: 10px; background: #efefef; margin: 2px"><input type="checkbox" name="headerssets[]" value="' . $headerInfo[$p]["column"] . '"> - ' . $headerInfo[$p]["column"] . '</label>';
                                            }

                                        }
                                        echo '<input type="hidden" id="theform" name="theform" value="'.$_REQUEST["form"].'">';
                                        echo '<div class="clearfix"></div><br><button class="btn btn-success btn-sm btn-fill">Setup</button>';
                                        echo '</form>';

                                        echo '</div>';
                                    }else{
                                        echo '<div class="container"><div class="alert alert-warning"><strong>NOTICE! - </strong>It appears either no forms in the system exist with this name or you have not setup the form headers. <br>Once you receive a request through the form on the site you will then be able to setup the view.</div></div>';
                                    }
                                }

                                ?>


                                <?php if($empty != 'true'){?>

                                    <table style="width: 100%" class="tableforms table table-striped">
                                        <thead>

                                        <tr><?php echo $tabs; ?> <th style="font-weight: bold;background: rgb(93, 93, 93);color: rgb(255, 255, 255); border-right: thin solid rgb(239, 239, 239);">Action</th></tr></thead>
                                        <tbody>

                                        <?php echo $results; ?>

                                        </tbody>
                                    </table>

                                <?php }else{
                                    echo '<div style="padding: 20px;font-style: italic;">No messages have been received.</div>';
                                } ?>

                                <?php
                            }else{
                                echo '<div class="container"><div class="alert alert-warning"><strong>NOTICE! - </strong>It appears no forms in the system exist with this name.</div></div>';
                            } ?>

                        </div>



                        </div>


                    </div>
                    <!-- end container -->
                </div>
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

    $(document).ready(function() {
        var table = $('.tableforms').DataTable();
        refreshMediaBrowse();



        $('.tableforms').on( 'page.dt', function () {

            console.log('test');

            setTimeout(function(){
                $(".readmess").on('click',function(){
                    var messId = $(this).data("messid");
                    var formType = $(this).data("form");

                    $.ajax({
                        url: 'inc/asyncCalls.php?action=getformrequest&requestid='+messId+'&form='+formType,
                        cache:false,
                        success:function(data){
                            $("#myModal .modal-header").html('Read Message <button type="button" class="close" data-dismiss="modal">×</button>');
                            $("#myModal .modal-body").html(data);
                            $("#myModal").modal();
                            $(".modal-dialog").css('width','50%');
                            //$(this).closest('tr').css("background-color", "");
                        }
                    })
                })

            }, 1000);



            $(".delmess").on('click',function(){
                var messId = $(this).data("messid");
                var formType = $(this).data("form");

                $("#myModal .modal-header").html('Delete Message <button type="button" class="close" data-dismiss="modal">×</button>');
                $("#myModal .modal-body").html('<h3>Are you sure you want to delete this message?</h3><br><button class="btn btn-danger btn-fill confirmed" data-messid="'+messId+'" data-form="'+formType+'">Yes Delete</button> <button class="btn btn-success" data-dismiss="modal">Cancel</button>');
                $("#myModal").modal();

                $(".confirmed").on('click',function(){
                    var messId = $(this).data("messid");
                    var formType = $(this).data("form");
                    $.ajax({
                        url: 'inc/asyncCalls.php?action=deletemess&form='+formType+'&messid='+messId,
                        cache:false,
                        success:function(data){
                            $(".mess-"+messId).remove();
                            $('#myModal').modal('toggle');
                        }
                    })

                })

                // $.ajax({
                //     url: 'inc/asyncCalls.php?action=deleteformrequest&requestid='+messId+'&form='+formType,
                //     cache:false,
                //     success:function(data){
                //         $(".mess-"+messId).remove();
                //     }
                // })
            })
        } );


    } );

    $(function() {
        $( ".list-group-item" ).draggable({ revert: true, appendTo: 'body',  helper: "clone", });
        $( ".droparea" ).droppable({
            drop: function( event, ui ) {
                var elem = ui.draggable.data('frelm');
                $.ajax({
                    url: 'inc/form_settings.php?action=createnew&type='+elem,
                    cache:false,
                    success: function(data){
                        $(".droparea").append(data);
                        $( ".droparea" ).sortable();
                        setmods();
                        refreshMediaBrowse();

                    }
                })

            }
        });
        setmods();

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

        $('.datepickerzz').datetimepicker({
            inline: true,
            sideBySide: true,
            useCurrent: false
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
            $(".fldnames-"+randcode).html($(this).val());
        })

        $(".addopts").unbind("click");
        $(".addopts").on('click',function(){
            var itemid = $(this).data('optionfld');
            var optcount = $(".sele-opt"+itemid+' li').length;
            var countUpNum = parseInt(optcount) + 1;
            var max_top = 340

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

        $(".removeoption").on('click',function () {
            var selitem = $(this).data('optionid');
            $('.selopts-'+selitem).remove();
        })

    }

    function removeFrmItm(idset){
        $(".allcont-"+idset).remove();
    }

    <?php
    ///GET FORMS DATA///

    ?>
    jQuery(function($) {
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

        if ($('#replyset').is(':checked')) {
            var replyset = 'true';
        }else{
            var replyset = 'false';
        }




        var recipients = $("#recipients").val();


        // $.ajax({
        //     type: 'POST',
        //     // make sure you respect the same origin policy with this url:
        //     // http://en.wikipedia.org/wiki/Same_origin_policy
        //     url: 'inc/asyncCalls.php?action=saveform',
        //     data: {
        //         'formcontent': theData,
        //         'form_json': thefrm,
        //         'form_name': form_name,
        //         'post_action': post_action,
        //         'form_class':form_class,
        //         'multi':multi,
        //         'recipients':recipients
        //     },
        //     success: function(msg){
        //         alert(msg);
        //     }
        // });

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

        $("[name='replyset']").bootstrapSwitch({
            onSwitchChange: function(event, state) {
                if(state == true){
                    $(".replybox").show();
                }else{
                    $(".replybox").hide();
                }
            }
        });

    });

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
        //$('.jsonout').html(myJSON);
        updatedFormSets(myJSON);
        $(".daalert").html('<div class="alert alert-success" style="border-radius: 0;">Form Successfully Updated!</div>')
    }

    function updatedFormSets(thefrm){
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

        if ($('#replyset').is(':checked')) {
            var replyset = 'true';
        }else{
            var replyset = 'false';
        }




        var thesubject = $("#subject").val();
        var recipients = $("#recipients").val();
        var success_mess = tinyMCE.get('success_mess').getContent();
        var reply_mess = tinyMCE.get('respmess').getContent();


        $.ajax({
            type: 'POST',
            // make sure you respect the same origin policy with this url:
            // http://en.wikipedia.org/wiki/Same_origin_policy
            url: 'inc/asyncCalls.php?action=updateform',
            cache:false,
            data: {
                'form_json': thefrm,
                'form_name': form_name,
                'post_action': post_action,
                'form_class':form_class,
                'multi':multi,
                'crmset':crmset,
                'replyset': replyset,
                'subject':thesubject,
                'recipients':recipients,
                'success_mess':success_mess,
                'reply_mess': reply_mess
            },
            success: function(msg){
                console.log(msg)
                if(msg == 'success'){
                    $(".daalert").html('<br><div class="alert alert-success" style="border-radius: 0"><strong>Success!</strong> - Your form has been updated..</div>');
                    $(".formeditars").hide();
                    $('.main-panel').scrollTop(0);
                }else{
                    $(".daalert").html('<br><div class="alert alert-wanring" style="border-radius: 0"><strong>Something Went Wrong!</strong> - '+msg+'</div>');
                    $('.main-panel').scrollTop(0);
                }
            }
        });
    }


</script>

<script>

    $(function(){

        $(".readmess").on('click',function(){
            var messId = $(this).data("messid");
            var formType = $(this).data("form");

            $.ajax({
                url: 'inc/asyncCalls.php?action=getformrequest&requestid='+messId+'&form='+formType,
                cache:false,
                success:function(data){
                    $("#myModal .modal-header").html('Read Message <button type="button" class="close" data-dismiss="modal">×</button>');
                    $("#myModal .modal-body").html(data);
                    $("#myModal").modal();
                    $(".modal-dialog").css('width','50%');
                    //$(this).closest('tr').css("background-color", "");
                }
            })
        })

        $(".delmess").on('click',function(){
            var messId = $(this).data("messid");
            var formType = $(this).data("form");

            $("#myModal .modal-header").html('Delete Message <button type="button" class="close" data-dismiss="modal">×</button>');
            $("#myModal .modal-body").html('<h3>Are you sure you want to delete this message?</h3><br><button class="btn btn-danger btn-fill confirmed" data-messid="'+messId+'" data-form="'+formType+'">Yes Delete</button> <button class="btn btn-success" data-dismiss="modal">Cancel</button>');
            $("#myModal").modal();

            $(".confirmed").on('click',function(){
                var messId = $(this).data("messid");
                var formType = $(this).data("form");
                $.ajax({
                    url: 'inc/asyncCalls.php?action=deletemess&form='+formType+'&messid='+messId,
                    cache:false,
                    success:function(data){
                        $(".mess-"+messId).remove();
                        $('#myModal').modal('toggle');
                    }
                })

            })

            // $.ajax({
            //     url: 'inc/asyncCalls.php?action=deleteformrequest&requestid='+messId+'&form='+formType,
            //     cache:false,
            //     success:function(data){
            //         $(".mess-"+messId).remove();
            //     }
            // })
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
        $(".toggle-edit").on('click',function(){
            $(".formeditars").toggle();
            //$(".mce-edit-area").height('200px');
            //$(".mce-edit-area").css('background','#efefef')
        });


    })

    function openExport(){
        $(".exportcontainer").slideToggle('fast');
    }

    function openArchive(form){
        $.ajax({
            url: 'inc/asyncCalls.php?action=pullarchive&formname='+form,
            cache: false,
            success: function(data){
                $("#myModal .modal-title").html('Archive');
                $("#myModal .modal-body").html(data);
                $("#myModal").modal();
                $('#example').DataTable({
                    "paging":   false,
                    "ordering": false,
                    "info":     false
                });
            }
        })
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

    function deleteForm(id){
        swal({
            title: 'Are you sure?',
            text: "Once you delete this form all data will be removed and you will no longer be able to access any of it's data.",
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
                url: 'inc/asyncCalls.php?action=deleteform&formid='+id,
                cache:false,
                success:function(data){
                    window.location.replace("site-forms.php");
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

</script>


    </body>
</html>