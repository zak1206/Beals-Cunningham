<?php include('inc/header.php'); ?>

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
                                        <li class="breadcrumb-item active">Create Content</li>
                                    </ol>

                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>

                        <div class="card-box" style="margin-top:20px">
                            <div style="padding: 20px">
                                <h4 class="m-t-0 header-title">Create Content / Install Plugin</h4>
                                <p class="text-muted font-14 m-b-30">
                                    Here you can create beans and use the bean code to place them within you sites pages.<br>
                                    There are also installable content widgets that can display calendars, forms & more.
                                </p>


                                <div style="height: 30px"></div>

                                <label>Select one of the options below</label><br>
                                <div class="row">
                                <div class="col-md-4" style="padding-left: 0">
                                    <button style="width: 100%" class="btn btn-success btn-fill selection" role="button" value="content">Create Content</button>
                                </div>

                                <div class="col-md-4">
                                    <button style="width: 100%" class="btn btn-primary selection" role="button" value="real_bean">Proceed to Installation</button>
                                </div>
                                </div>
                                <div class="clearfix"></div>
                                <br>

                                <?php
                                if(isset($_POST["bean_name"])){
                                    $newid = $site->createContentBean($_POST);
                                    echo '<div class="alert alert-success" role="alert"><strong>Well done!</strong> The bean has been successfully brewed..</div>';
                                    echo '<meta http-equiv="refresh" content="0; url=edit-content.php?id='.$newid.'">';
                                }


                                if(isset($_POST["modups"])){

//                                    echo "this is: ".$_FILES["beanpackage"]["name"];
                                    $target_dir = "temp_install/";
                                    $target_file = $target_dir . basename($_FILES["beanpackage"]["name"]);
                                    $uploadOk = 1;
                                    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

// Check if file already exists
                                    if (file_exists($target_file)) {
                                        echo "Sorry, file already exists.";
                                        $uploadOk = 0;
                                    }

// Allow certain file formats
                                    if($imageFileType != "zip") {
                                        echo "Not a valid bean installation file.";
                                        $uploadOk = 0;
                                    }
// Check if $uploadOk is set to 0 by an error
                                    if ($uploadOk == 0) {
                                        echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
                                    } else {
                                        if (move_uploaded_file($_FILES["beanpackage"]["tmp_name"], $target_file)) {
                                            echo '<div class="theprogress" style="display: none;padding: 5px;background: #efefef;font-style: italic;"><img style="width: 30px" src="img/simpl_loads.gif"> Installing Please Wait...</div>';

                                            $zip = new ZipArchive;
                                            $zip->open($target_dir.'/'.$_FILES["beanpackage"]["name"]);
                                            $zip->extractTo($target_dir.'/');
                                            $zip->close();

                                            $fileName = str_replace('.zip','',$_FILES["beanpackage"]["name"]);


                                            echo '<script> $(function(){$(".theprogress").show();$.ajax({url: \''.$target_dir.'/'.$fileName.'/install.php\',success: function(data){$(".theprogress").html(data);console.log(data)}})}) </script>';

                                            unlink($target_dir.'/'.$_FILES["beanpackage"]["name"]);

                                        } else {
                                            echo "Sorry, there was an error uploading your file.";
                                        }
                                    }
                                }else{

                                }
                                ?>



                                <div class="row bean-holder" style="padding: 5px;">
                                    <div id="bean-content-holder" style="display: none; width:100%">
                                        <form style="padding: 20px" class="validforms" name="content-bean" id="content-bean" method="post" action="">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label>Bean Name</label>
                                                    <input type="text" class="form-control" name="bean_name" id="bean_name" value="" required>
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
                                                        echo $html;
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label>&nbsp;</label><br>
                                                    <input class="form-control" type="text" name="new-cat" id="new-cat" value="" placeholder="Add New Category">
                                                </div>
                                            </div>
                                            <br>
                                            <button class="btn btn-primary" type="submit" id="submit_bean_content" name="submit_bean_content">Create Content Bean</button>
                                        </form>
                                    </div>

                                    <div id="bean-install-holder" style="display: none; padding-top:5px; width:100%">
                                        <form style="background: #efefef; padding: 10px" name="install_bean" id="install_bean" method="post" enctype="multipart/form-data" action="">
                                            <label>Select Content Package to Install</label><br><small class="progress-filename" style="    background: #e5ec24; padding: 5px;font-style: italic;margin-bottom: 2px;display: inline-block;"></small><br>
                                            <label class="btn btn-danger btn-file">
                                                Select Installable Zip <input type="file" id="beanpackage" name="beanpackage"  style="display: none;">
                                            </label>

                                            <input type="hidden" name="modups" id="modups" value="true">
                                            <button style="margin-top: -7px;" class="btn btn-primary btn-fill" type="submit" id="submit_bean" name="submit_bean">Install Bean</button>
                                        </form>
                                        <div class="theprogress" style="display: none;padding: 5px;background: #efefef;font-style: italic;"><img style="width: 30px" src="img/simpl_loads.gif"> Installing Please Wait...</div>
                                    </div>
                                </div>
                        </div>

                    </div>

                        <div class="card" style="padding: 20px">
                            <div class="header">
                                <h4 class="title">Modules & Plugins</h4>
                                <p class="category">Below you can browse for modules & plugins for instillation. </p>

                                <div style="background: #efefef; margin: 20px 0">
                                    <div class="row" style="padding: 10px"><!--<img style="width: 25px" src="img/simpld.gif"> <small>Connecting to server...</small>-->

                                        <?php
                                        $url = 'http://caffeinerde.com/projects.php';
                                        $key = 'IJFNENNIW9399592UFJNDJE!@';
                                        $password = 'ANOTHERDAY';

                                        $dataset = array('key' => $key, 'password' => $password);

                                        // use key 'http' even if you send the request to https://...
                                        $options = array(
                                            'http' => array(
                                                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                                                'method'  => 'POST',
                                                'content' => http_build_query($dataset),
                                            ),
                                        );
                                        $context  = stream_context_create($options);
                                        $result = file_get_contents($url, false, $context);

                                        $theArs = json_decode($result,true);


                                        if($theArs["status"] == 'Good'){
                                            $plugins = json_decode($theArs["objects"],true);
                                            for($i=0; $i<count($plugins); $i++){
                                                $plugs .= '<div class="col-md-3 img-thumbnail" style="background-image: url(http://caffeinerde.com/'.$plugins[$i]["icon"].'); background-size: cover; background-position: center; background-repeat: no-repeat; border: solid 3px #F5EFEF"><img style="width: 100%" src="img/isimg_but.png"> <div style="position: absolute; bottom: 0; left: 0; width: 100%; background: #2fa1f9; color:#fff; text-align: center; font-weight: bold; padding: 10px">'.$plugins[$i]["name"].'</div></div>';
                                            }

                                            echo $plugs;
                                        }else{
                                            echo '<i class="fa fa-exclamation-triangle"></i> <i>ERROR! - Failed to connect to API.</i>';
                                        }

                                        ?>
                                        <div class="clearfix"></div>

                                    </div>
                                    <div class="clearfix"></div>
                                </div>


                            </div>
                        </div>
                    <!-- end container -->
                </div>
                <!-- end content -->

                    <?php include('inc/footer.php'); ?>

            </div>


        </div>
</div>
        <!-- END wrapper -->



        <script>
            var resizefunc = [];
        </script>


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

        $(function(){

            $(".selection").on('click',function(){
                var vals = $(this).val();
                if(vals == 'content'){
                    $("#bean-content-holder").show();
                    $("#bean-install-holder").hide();
                }

                if(vals == 'real_bean'){
                    $("#bean-install-holder").show();
                    $("#bean-content-holder").hide();
                }
            })

            $('input[type=file]').change(function(e){
                var str = $(this).val();
                var result=str.split('\\').pop();
                $(".progress-filename").html(result);


            });
        })

        $(function($, window, undefined) {
            //is onprogress supported by browser?
            var hasOnProgress = ("onprogress" in $.ajaxSettings.xhr());

            //If not supported, do nothing
            if (!hasOnProgress) {
                return;
            }

            //patch ajax settings to call a progress callback
            var oldXHR = $.ajaxSettings.xhr;
            $.ajaxSettings.xhr = function() {
                var xhr = oldXHR.apply(this, arguments);
                if(xhr instanceof window.XMLHttpRequest) {
                    xhr.addEventListener('progress', this.progress, false);
                }

                if(xhr.upload) {
                    xhr.upload.addEventListener('progress', this.progress, false);
                }

                return xhr;
            };
        });
    </script>

    </body>
</html>