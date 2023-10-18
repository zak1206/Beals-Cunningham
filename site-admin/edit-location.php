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
    <div id="myModalAS" class="modal" tabindex="-1" role="dialog">
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
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
                                        <li class="breadcrumb-item"><a href="locations.php">Locations</a></li>
                                        <li class="breadcrumb-item active">Edit Location</li>
                                    </ol>

                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>

                        <div class="card-box" style="margin-top:20px">
                            <div style="padding: 20px">
                                <h4 class="m-t-0 header-title">Edit Locations</h4>
                                <p class="text-muted font-14 m-b-30">
                                    Edit Locations.
                                </p>
                                <button style="float: right" class="btn btn-warning" onclick="openContent()"><i class="ti-package"></i> Form Tokens</button>
                                <div style="clear:both;"></div>
                                <hr>
                                <form name="locationform" id="locationform" method="post" action="">
                                    <?php
                                    if(isset($_POST["location-address"])){
                                        $phones = $_POST["phone-name"];

                                        $ph=0;
                                        foreach($phones as $phone){
                                            $phoneNum = $_POST["phone-num"][$ph];
                                            $phoneClass = $_POST["phone-class"][$ph];
                                            $jsnPh[] = array("phoneName"=>$phone, "phoneNum"=>$phoneNum, "phoneClass"=>$phoneClass);
                                            $ph++;
                                        }

                                        $phoneJson = json_encode($jsnPh);

                                        $emails = $_POST["email-name"];
                                        $em=0;
                                        foreach($emails as $email){
                                            $emailAdds = $_POST["email-add"][$em];
                                            $emailClass = $_POST["email-class"][$em];
                                            $jsnEm[] = array("emailName"=>$email, "emailOut"=>$emailAdds, "emailClass"=>$emailClass);
                                            $em++;
                                        }

                                        $emailJson = json_encode($jsnEm);

                                        $days = $_POST["day-days"];
                                        $dy=0;
                                        foreach($days as $day){
                                            $dayAdds = $_POST["day-hrs"][$dy];
                                            $dayClass = $_POST["day-class"][$dy];
                                            $jsnDy[] = array("day"=>$day, "hours"=>$dayAdds, "dayClass"=>$dayClass);
                                            $dy++;
                                        }

                                        $dayJson = json_encode($jsnDy);
                                        $address = $_POST["location-address"].' '.$_POST["location-city"].' '.$_POST["location-state"];
                                        $map = '<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDirzbLQ0h3FxGw__4ccm8mRDY0BL_3NEM&q='.$address.'" allowfullscreen></iframe></div>';

                                        $return = $site->createLocation($_POST,$phoneJson,$emailJson,$dayJson,$map);

                                        echo '<div class="alert alert-success"><strong>Success</strong> - Location has been updated.</div>';
                                    }

                                    if($return != null){
                                        echo '<input type="hidden" id="newrecord" name="newrecord" value="'.$return.'">';
                                        $locData = $site->getLocation($return);
                                    }else{
                                        $locData = $site->getLocation($_REQUEST["id"]);
                                        echo '<input type="hidden" id="newrecord" name="newrecord" value="'.$_REQUEST["id"].'">';
                                    }

                                    ?>

                                    <h3>Location Details</h3>
                                    <label>Location Name</label><br>
                                    <input type="text" class="form-control" name="location-name" id="location-name" value="<?php echo $locData["location_name"]; ?>" required="">
                                    <div class="row" style="padding: 10px">
                                    <div class="form-group col-md-4" style="padding-left: 0">
                                        <label for="location-address">Location Address</label>
                                        <input type="text" class="form-control" name="location-address" placeholder="Address" required="" value="<?php echo $locData["location_address"]; ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="location-city">Location City</label>
                                        <input type="text" class="form-control" name="location-city" placeholder="City" required="" value="<?php echo $locData["location_city"]; ?>">
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label for="location-state">Location State</label>
                                        <select class="form-control" name="location-state" id="location-state" required="">
                                            <option>Select State</option>
                                            <?php
                                            $state = $site->stateArs();
                                            foreach($state as $stateout=> $val){
                                                if($locData["location_state"] == $val){
                                                    echo '<option value="'.$val.'" selected="selected">'.$stateout.'</option>';
                                                }else{
                                                    echo '<option value="'.$val.'">'.$stateout.'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="location-city">Location Zip</label>
                                        <input type="text" class="form-control" id="location-zip" name="location-zip" placeholder="Address" value="<?php echo $locData["location_zip"]; ?>">
                                    </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <label>Choose Location Page Url - <small>If you have one setup. If not you can setup a location page later and direct it later.</small></label><br>
                                    <div class="input-group mb-3">
                                        <input type="text" id="nav-link" name="nav-link" class="form-control" placeholder="http://www.yourlinkwillgohere.com"  value="<?php echo $locData["location_link"]; ?>">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary img-browser" data-setter="nav-link" type="button"><i class="fa fa-link" aria-hidden="true"></i></button>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="clearfix"></div>
                                    <label>Choose Location Image</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="loc-img" id="loc-img" placeholder="No Image" value="<?php echo $locData["location_img"]; ?>">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary img-browser" data-setter="loc-img" type="button">Browse Images</button>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <br>
                                    <label>Form Token</label>
                                    <input type="text" class="form-control" name="form-code" id="form-code" placeholder="Form Code" value="<?php echo $locData["form_code"]; ?>">
                                    <div class="clearfix"></div>
                                    <hr>
                                    <h3 style="display: inline-block">Location Phone Numbers</h3>

                                    <div class="clearfix"></div>
                                    <br>

                                    <div class="phone-nums" style="padding: 5px; background: #eee">

                                        <?php
                                        $phoneLocs = $locData["location_phones"];
                                        $phonAes = json_decode($phoneLocs,true);
                                        for($i=0; $i<count($phonAes); $i++){
                                            echo '<div class="phn-grp row">
                                            <div class="form-group col-md-4">
                                                <label for="location-city">Phone Name</label>
                                                <input style="background: #fff" type="text" class="form-control" name="phone-name[]" placeholder="Phone Name" value="'.$phonAes[$i]["phoneName"].'">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="location-city">Phone Number</label>
                                                <input style="background: #fff" type="text" class="form-control" name="phone-num[]" placeholder="Phone Number" value="'.$phonAes[$i]["phoneNum"].'">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="location-city">Style Class</label>
                                                <input style="background: #fff" type="text" class="form-control" name="phone-class[]" placeholder="Style Class" value="'.$phonAes[$i]["phoneClass"].'">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label>&nbsp;</label><br>
                                                <button type="button" class="btn btn-xs btn-danger phn-remove" style="margin-top: 5px"><i class="fa fa-times"></i></button>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>';
                                        }
                                        ?>
                                    </div>
                                    <br>
                                    <button type="button" class="btn btn-success btn-sm add-phn"><i class="fa fa-plus-circle"></i> Add New</button>
                                    <br><br>
                                    <div class="clearfix"></div>
                                    <hr>
                                    <h3 style="display: inline-block">Location Emails</h3>

                                    <div class="clearfix"></div>
                                    <br>

                                    <div class="loc-emails" style="padding: 5px; background: #eee">

                                        <?php
                                        $emailLocs = $locData["location_emails"];
                                        $emailAes = json_decode($emailLocs,true);
                                        for($i=0; $i<count($emailAes); $i++){
                                            echo '<div class="eml-grp row">
                                            <div class="form-group col-md-4">
                                                <label for="location-city">Email Label</label>
                                                <input style="background: #fff" type="text" class="form-control" name="email-name[]" placeholder="Email Label" value="'.$emailAes[$i]["emailName"].'">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="location-city">Email Address</label>
                                                <input style="background: #fff" type="text" class="form-control" name="email-add[]" placeholder="Email Address" value="'.$emailAes[$i]["emailOut"].'">
                                            </div>
                                             <div class="form-group col-md-2">
                                                <label for="location-class">Style Class</label>
                                                <input style="background: #fff" type="text" class="form-control" name="email-class[]" placeholder="Style Class" value="'.$emailAes[$i]["emailClass"].'">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label>&nbsp;</label><br>
                                                <button type="button" class="btn btn-xs btn-danger eml-remove" style="margin-top: 5px"><i class="fa fa-times"></i></button>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>';
                                        }
                                        ?>

                                    </div>
                                    <br>
                                    <button type="button" class="btn btn-success btn-sm add-eml"><i class="fa fa-plus-circle"></i> Add New</button>
                                    <div class="clearfix"></div>
                                    <hr>
                                    <h3 style="display: inline-block">Location Hours</h3>

                                    <div class="clearfix"></div>
                                    <br>

                                    <div class="loc-hrs" style="padding: 5px; background: #eee">

                                        <?php
                                        $hoursLocs = $locData["location_hours"];
                                        $hoursAes = json_decode($hoursLocs,true);
                                        for($i=0; $i<count($hoursAes); $i++){
                                            echo '<div class="hrs-grp row">
                                            <div class="form-group col-md-4">
                                                <label for="location-city">Days</label>
                                                <input style="background: #fff" type="text" class="form-control" name="day-days[]" placeholder="Day - Day" value="'.$hoursAes[$i]["day"].'">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="location-city">Hours</label>
                                                <input style="background: #fff" type="text" class="form-control" name="day-hrs[]" placeholder="00:00am - 00:00pm" value="'.$hoursAes[$i]["hours"].'">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="location-city">Style Class</label>
                                                <input style="background: #fff" type="text" class="form-control" name="day-class[]" placeholder="Style Class" value="'.$hoursAes[$i]["dayClass"].'">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label>&nbsp;</label><br>
                                                <button type="button" class="btn btn-xs btn-danger hrs-remove" style="margin-top: 5px"><i class="fa fa-times"></i></button>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>';
                                        }
                                        ?>
                                    </div>
                                    <br>
                                    <button type="button" class="btn btn-success btn-sm add-hrs"><i class="fa fa-plus-circle"></i> Add New</button>
                                    <br><br>
                                    <div style="text-align: right">
                                         <button  class="btn btn-success">Save Location</button> <button class="btn btn-danger" type="button" onclick="deleteLocation('<?php echo $locData["id"]; ?>')">Delete Location</button>

                                    </div>

                                    <div class="clearfix"></div>
                                    <br>
                                </form>

                                <div class="new-phs" style="display: none">
                                    <div class="phn-grp row" style="border-top:solid thin #fff">
                                        <div class="form-group col-md-4">
                                            <label for="location-city">Phone Name</label>
                                            <input style="background: #fff" type="text" class="form-control" name="phone-name[]" placeholder="Phone Name">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="location-phone">Phone Number</label>
                                            <input style="background: #fff" type="text" class="form-control" name="phone-num[]" placeholder="Phone Number">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="location-class">Style Class</label>
                                            <input style="background: #fff" type="text" class="form-control" name="phone-class[]" placeholder="Style Class">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label>&nbsp;</label><br>
                                            <button type="button" class="btn btn-xs btn-danger phn-remove" style="margin-top: 5px"><i class="fa fa-times"></i></button>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="new-eml" style="display: none">
                                    <div class="eml-grp row" style="border-top:solid thin #fff">
                                        <div class="form-group col-md-4">
                                            <label for="location-city">Email Label</label>
                                            <input style="background: #fff" type="text" class="form-control" name="email-name[]" placeholder="Email Label">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="location-city">Email Address</label>
                                            <input style="background: #fff" type="text" class="form-control" name="email-add[]" placeholder="Email Address">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="location-city">Style Class</label>
                                            <input style="background: #fff" type="text" class="form-control" name="email-class[]" placeholder="Style Class">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label>&nbsp;</label><br>
                                            <button type="button" class="btn btn-xs btn-danger eml-remove" style="margin-top: 5px"><i class="fa fa-times"></i></button>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="new-hrs" style="display: none">
                                    <div class="hrs-grp row" style="border-top:solid thin #fff">
                                        <div class="form-group col-md-4">
                                            <label for="location-city">Days</label>
                                            <input style="background: #fff" type="text" class="form-control" name="day-days[]" placeholder="Day - Day">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="location-city">Hours</label>
                                            <input style="background: #fff" type="text" class="form-control" name="day-hrs[]" placeholder="00:00am - 00:00pm">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="location-city">Style Class</label>
                                            <input style="background: #fff" type="text" class="form-control" name="day-class[]" placeholder="Style Class">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label>&nbsp;</label><br>
                                            <button type="button" class="btn btn-xs btn-danger hrs-remove" style="margin-top: 5px"><i class="fa fa-times"></i></button>
                                        </div>
                                        <div class="clearfix"></div>
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
<script>
    $(function(){
        $('.add-phn').on('click',function(){
            var replica = $(".new-phs").html();
            $(".phone-nums").append(replica);
            removePhn();
        })
        $('.add-eml').on('click',function(){
            var replica = $(".new-eml").html();
            $(".loc-emails").append(replica);
            removeEml();
        })
        $('.add-hrs').on('click',function(){
            var replica = $(".new-hrs").html();
            $(".loc-hrs").append(replica);
            removeHrs();
        })
        removePhn();
        removeEml();
        removeHrs();
    })

    function removePhn(){
        $(".phn-remove").on('click',function(){
            $(this).closest('.phn-grp').remove();
        })
    }
    function removeEml(){
        $(".eml-remove").on('click',function(){
            $(this).closest('.eml-grp').remove();
        })
    }
    function removeHrs(){
        $(".hrs-remove").on('click',function(){
            $(this).closest('.hrs-grp').remove();
        })
    }

    $(function(){
        $(".img-browser").on('click',function(){
            var itemsbefor = $(this).data('setter');
            $("#myModalAS .modal-title").html('Select an Image For Link');
            $("#myModalAS .modal-body").html('<iframe id="themedia" style="width: 100%; height: 450px; border: none" src="media_manager.php?typeset=simple&returntarget='+itemsbefor+'"></iframe>');
            $(".modal-dialog").css('width','869px');
            $("#myModalAS").modal();
        })

        $('#page_desc').keyup(function () {
            var left = 300 - $(this).val().length;
            if (left < 0) {
                left = 0;
            }
            $('.counter-text').text('Characters left: ' + left);
        });

        $(".link-browser").on('click',function(){
            var itemsbefor = $(this).data('setter');
            $("#myModalAS .modal-title").html('Select a system link');
            $("#myModalAS .modal-body").html('<iframe id="theurls" style="width: 100%; height: 450px; border: none" src="systemLinks.php?typeset=simple&fldset='+itemsbefor+'"></iframe>');
            $(".modal-dialog").css('width','869px');
            $("#myModalAS").modal();
        })


    })

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
        $("#myModalAS").modal('hide');
    }

    function openContent(){
        $(".modal .modal-body").html('<iframe src="content_plugins.php?viewtype=forms" style="width: 100%; height: 400px; border:none"></iframe>');
        $(".modal-title").html('Content / Plugin Tokens');
        $(".modal-dialog").css('width','90%');
        $(".modal").modal();
    }

    function deleteLocation(locationid){
        swal({
            title: 'Are you sure?',
            text: "Once you delete this location all data will be removed and you will no longer be able to access any of it's data.",
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
                url: 'inc/asyncCalls.php?action=deletelocation&locationid='+locationid,
                success:function(data){
                    window.location.replace("locations.php");
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