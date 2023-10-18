<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="../plugins/switchery/switchery.min.css" rel="stylesheet" />

    <link href="../../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../../codemirror/lib/codemirror.css"/>
    <link rel="stylesheet" href="../../codemirror/theme/mbo.css">
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="../../plugins/sweet-alert/sweetalert2.min.css" rel="stylesheet">
    <link href="../../plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="../../plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="../../plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Multi Item Selection examples -->
    <link href="../../plugins/datatables/select.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="../../plugins/nestable/jquery.nestable.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">

    <style>
        .dropitemsin {
            padding: 10px;
            text-align: center;
            background: #f5dda3;
            margin: 2px;
            font-weight: bold;
        }

        .droparea {
            padding: 20px;
            background: #efefef;
            border: dashed thin #333;
        }
    </style>

    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js" integrity="" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>

<div  class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" style="max-width: 80%;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Updates</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Modal body text goes here.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="header">
    <img style="margin: 15px 0px;float: right;" src="mflogo.jpg">
    <div class="clearfix"></div>
    <h4 class="title">Machine Finder</h4>
    <p class="category">You can use the settings below to set default orders for your categories and update your Machine Finder API information and set request form tokens.<br></p>

    <?php
    include('functions.php');
    $MfStuff = new machinefinderui();
    $checkItOut = $MfStuff->checkmachineSystem();


    if($checkItOut == true){

        ?>

    <div style="text-align: right">
        <button class="btn btn-info" onclick="launchFeatures()">Open Feature Panel</button>
        <button class="btn btn-warning manlods" style="color:#fff" onclick="rerunMachines()">Manual Update</button>
        <button class="btn btn-success" onclick="getUsage()">Usage Info</button>
        <button class="btn btn-outline-primary" onclick="updateCreds()">Update Details</button><br><br>
        <?php
            $lastPull = $MfStuff->getLastUpdate();



            $theLast = $lastPull["pulldate"];
            $pullstatus = $lastPull["pullstatus"];

            if($theLast != null && $pullstatus == 'Good'){
                echo '<span style="color:#16db39">Equipment Last Pulled: ' .date('m/d/Y h:ia',$theLast).' - Status: Good</span>';
            }else{
                echo '<span style="color:red">Equipment Last Attempted Pull: ' .date('m/d/Y h:ia',$theLast).' - Status: Connect Error</span>';
            }
        ?>

    </div>
    <br>



    <div class="jumbotron">
        <h4>Request Token.</h4>
        <label>Enter request form token below.</label><br><small>This form will be set in pace for all used equipment requests.</small><br><br>
        <?php
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }

        $c = $data->query("SELECT settings FROM beans WHERE bean_id = 'MF-v3'");
        $d = $c->fetch_array();

        $sets = json_decode($d["settings"],true);

        $formToken = $sets["form_token"];

        ?>
        <form id="formupdate" name="formupdate" method="post" action="">
            <div class="input-group mb-3" style="max-width: 400px">
                <input type="text" class="form-control" name="formtoken" id="formtoken" placeholder="Form Token" value="<?php echo $formToken; ?>">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Update</button>
                </div>
            </div>
        </form>
    </div>
    <div class="jumbotron">
        <h4>Order default category output.</h4><small>Drag categories to order.</small><br><br>

        <div class="orderpan" style="height: 500px; overflow-y: scroll ">
            <?php

            $a = $data->query("SELECT id, category FROM used_equipment WHERE active = 'true' GROUP BY category ORDER BY order_pro ASC");
            while($b = $a->fetch_array()){
                if($b["category"] != null) {

                    $cats .= '<div style="cursor: move; padding: 5px; background: #10a0ff; margin: 2px; color: #fff" data-cat="' . $b["category"] . '">' . $b["category"] . '</div>';
                }
            }

            echo $cats;


            ?>
        </div>
    </div>

    <?php }else{
        $html .= ' <div class="jumbotron mfsetupdds">
        <h4>Setup Machine Finder.</h4>
        <label>Enter your Machine Finder API details below.</label><br><br>';

        $html .= '<form id="usedFeedInt" name="usedFeedInt" method="post" action="">
<div class="row">
<div class="col-md-3" style="margin: 2px; padding: 5px">
            <input class="form-control" type="text" name="feed_url" id="feed_url" placeholder="Feed URL" value="'.$settings["url"].'" required="">
            </div>
            <div class="col-md-3" style="margin: 2px; padding: 5px">
            <input class="form-control" type="text" name="secrete_key" id="secrete_key" placeholder="Secrete Key" value="'.$settings["key"].'" required="">
            </div>
<div class="col-md-3" style="margin: 2px; padding: 5px">
            <input class="form-control" type="password" name="pass" id="pass" placeholder="Password" value="'.$settings["pass"].'" required="">
            </div>
            <button style="padding: 5px 10px; font-size: 12px;height: 40px; margin-top: 6px;" type="submit" name="login" class="btn btn-primary">Connect & Setup</button>
            </div>
        </form>';

        $html .= '</div>';



        echo $html;
    } ?>




    <div class="clearfix"></div>
</div>
<script src="../../plugins/switchery/switchery.min.js"></script>
<script src="../../plugins/sweet-alert/sweetalert2.min.js"></script>
<script src="../../assets/pages/jquery.sweet-alert.init.js"></script>

<script>
    $( function() {
        $( ".orderpan" ).sortable({
            helper: "clone",
            stop: function(){
                jsonObj = [];
                $(".orderpan div").each(function(e){
                    var category = $(this).data('cat');
                    jsonObj.push(category);
                })

                console.log(jsonObj);

                $.ajax({
                    type: 'POST',
                    cache:false,
                    processData: true,
                    url: 'async.php?action=setorder',
                    data: {
                        sortorder: JSON.stringify(jsonObj),
                    },


                    success: function(msg) {
                        swal({
                            title: 'Order Saved',
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

                    },
                    error: function(xml, error) {
                        console.log("This is "+error);
                    }
                });
            }
        });

        $("#formupdate").submit(function(e) {

            e.preventDefault(); // avoid to execute the actual submit of the form.

            var form = $(this);

            $.ajax({
                type: "POST",
                cache:false,
                url: 'async.php?action=updateform',
                data: form.serialize(), // serializes the form's elements.
                success: function(data)
                {
                    swal({
                        title: 'Form Saved',
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


        });
    } );

    function launchFeatures(){
        $(".modal-title").text('Select Featured Equipment');

        $.ajax({
            url: 'async.php?action=getfetpan',
            cache: false,
            success: function(data){
                $('.modal-body').html(data);
                $(".fetselection").on('click',function(){
                    if ($(this).find(".checked").length > 0){
                        $(this).find(".checked").remove();
                        fetSetter($(this).data('usedid'),'true');
                    }else{
                        $(this).append('<div class="checked" style="position: absolute;top: 0;right: 0;padding: 1px 6px;color: #53ff65;font-size: 19px;background: #4a4a4a;border-radius: 30px;"><i class="fa fa-check"></i></div>');
                        fetSetter($(this).data('usedid'),'false');
                    }

                    //alert($(this).data('usedid'));
                })

                $("#catsels").on('change',function(){
                    var selection = $(this).val();

                    getCatsNow(selection);


                })
            }
        })

        $(".modal").modal();
    }

    function fetSetter(equipid,isset){
        $.ajax({
            url: 'async.php?action=doworkfet&equipid='+equipid+'&isset='+isset,
            success:function (data) {

            }
        })
    }

    function getCatsNow(cat){
        cat = encodeURIComponent(cat);
        $.ajax({
            url: 'async.php?action=getcatsnow&cat='+cat,
            cache:false,
            success:function (data) {
                $(".featureselect").html(data);

                $(".fetselection").on('click',function(){
                    if ($(this).find(".checked").length > 0){
                        $(this).find(".checked").remove();
                        fetSetter($(this).data('usedid'),'true');
                    }else{
                        $(this).append('<div class="checked" style="position: absolute;top: 0;right: 0;padding: 1px 6px;color: #53ff65;font-size: 19px;background: #4a4a4a;border-radius: 30px;"><i class="fa fa-check"></i></div>');
                        fetSetter($(this).data('usedid'),'false');
                    }

                    //alert($(this).data('usedid'));
                })
            }
        })
    }

    function updateCreds(){
        $.ajax({
            url: 'async.php?action=updatecreds',
            cache:false,
            success:function(data){
                $("#usedmodal .model-header").html('Update Details');
                $('.modal-body').html(data);
                $(".modal").modal();
                $("#usedFeedUpdate").validate({
                    submitHandler: function (form) {
                        var url = "async.php?action=updatecredsfin"; // the script where you handle the form input.

                        $.ajax({
                            type: "POST",
                            cache:false,
                            url: url,
                            data: $("#usedFeedUpdate").serialize(), // serializes the form's elements.
                            success: function (data) {
                                $(".modal-body").prepend('<div class="alert alert-success">Machine Finder Details Updated' + data + '</div>')
                            }
                        });

                        return; // avoid to execute the actual submit of the form.

                    }
                });
            }
        })
    }

    function getUsage(){
        $("#usedmodal .model-header").html('Update Details');
        $.ajax({
            url: 'async.php?action=usage',
            cache:false,
            success:function(data){
                $('.modal-body').html(data);
                $(".modal").modal();
            }
        })
    }

    function rerunMachines(){
        $(".manlods").html('<img class="dalds" style="width: 20px" src="loads.gif"> Updating Machines...');
        $.ajax({
            url: 'async.php?action=rerun',
            cache:false,
            success:function(data){
                $(".manlods").html('Update Complete');
            }
        })
    }

    <?php if($checkItOut != true){ ?>

    function setupMFSystem(){
        $("#usedFeedInt").validate({
            submitHandler: function (form) {
                $('.mfsetupdds').slideUp();
                $('body').append('<span class="lods" style="display: block;background: #efefef;padding: 10px;"><img style="width: 20px" src="load.gif"> <small>Loading Equipment. Please Wait...</small></span>')
                var url = "async.php?action=setupmf"; // the script where you handle the form input.

                $.ajax({
                    type: "POST",
                    cache:false,
                    url: url,
                    data: $("#usedFeedInt").serialize(), // serializes the form's elements.
                    success: function (data) {
                        if(data == 'good'){
                            $(".lods").remove();
                            location.reload();
                        }else{
                            //$(".lods").remove();
                            $(".mfsetupdds").prepend('<div class="alert alert-danger">' + data + '</div>');
                            $('.mfsetupdds').slideDown();
                            $(".lods").remove();
                        }

                    }
                });

                return; // avoid to execute the actual submit of the form.

            }
        });
    }

    setupMFSystem();


    <?php } ?>


</script>
</body>
</html>