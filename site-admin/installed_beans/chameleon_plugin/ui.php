<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link href="plugins/switchery/switchery.min.css" rel="stylesheet" />
    <link href="../../plugins/sweet-alert/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap-switch.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.5/css/rowReorder.dataTables.min.css">
    <link rel="stylesheet" href="../../assets/css/bootstrap-datetimepicker.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.6/css/all.css">
    <title>Chameleon Engine</title>

    <style>
        .campinfo{
            font-style: italic;
            color: #a2a0a0;
        }
    </style>

</head>
<body style="height: 100vh">

<?php


//editobj

if($_REQUEST["viewtype"] == 'editobj'){ ?>
    <!--EDIT OBJECTS HERE-->

    <div id="campstuff" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="theformhold">

                    </div>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>


    <img style="max-width: 200px; margin: 15px 0px;float: right;" src="ce_logo.png">
    <h1>Chameleon Engine</h1>
    <p>Create / Edit Chameleon objects.</p>
    <div class="clearfix"></div>
    <div style="padding: 10px; text-align: right"><a href="ui.php" class="btn btn-primary"> < Back to objects</a></div>

<?php
include('functions.php');
$chamel = new chameleon();

if(isset($_POST["objname"])){
    $chamel->updateObj($_POST);
}

$objItems = $chamel->getObjItem($_REQUEST["id"]);


$object_name = $objItems["object_name"];
$campaigns = json_decode($objItems["campaigns"],true);
$default_info = $objItems["default_info"];
$type = $objItems["type"];

if($type == 'box'){
    $typeOut = 'Page Object';
}else{
    $typeOut = 'Slider';
}

$html .= '<form name="editobjs" id="editobjs" method="post" action="">';
$html .= '<div class="row" style="margin:0">';
$html .= '<div class="col-md-4"><label>Object Name</label><br><input type="text" class="form-control" id="objname" name="objname" value="'.$object_name.'"></div>';
$html .= '<div class="col-md-4"><label>Type</label><br><div style="background: #efefef; padding: 5px">'.$typeOut.'</div></div>';
$html .= '</div><br><br>';
if($typeOut == 'Page Object') {
    $html .= '<div class="row" style="margin:0">';
    $html .= '<div class="col-md-12">';
    $html .= '<label>Default Content</label><br>';
    $html .= '<textarea class="summernote" name="default_content" id="default_content">' . $default_info . '</textarea>';
    $html .= '</div>';
    $html .= '</div><br><br>';
}else{
    $html .= '<p style="display: block; margin: 10px"><strong>NOTE!</strong> Default content is controlled by the Caffeine Slider.</p><br><br>';
}
$html .= '<div class="row" style="margin:0">';
$html .= '<div class="col-md-12">';
$html .= '<h3>'.$typeOut.' Campaigns</h3>';
$html .= '<div style="background: #efefef; padding: 5px">';

$allCamps = $chamel->getAllCampaigns($type);

for($i=0; $i<count($allCamps); $i++){
    if(in_array($allCamps[$i]["id"],$campaigns)){
        $html .= '<label style="display: inline-block; padding: 5px; margin: 5px 5px;"><input type="checkbox" name="campsels[]" value="'.$allCamps[$i]["id"].'" checked="checked"> '.$allCamps[$i]["campaign_name"].'</label>';
    }else{
        $html .= '<label style="display: inline-block; padding: 5px; margin: 5px 5px;"><input type="checkbox" name="campsels[]" value="'.$allCamps[$i]["id"].'"> '.$allCamps[$i]["campaign_name"].'</label>';
    }

}

$html .='</div>';
$html .= '</div>';
$html .= '</div><br><br>';
$html .= '<div class="row" style="margin: 0">';
$html .= '<input type="hidden" name="objid" id="objid" value="'.$_REQUEST["id"].'">';
$html .= '<div class="col-md-12"><button class="btn btn-success">Save Object</button></div>';
$html .= '</div>';
$html .= '</form>';

echo $html;

?>


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

        $(function(){
            intEdits();
        })

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
    </script>

<?php }

if($_REQUEST["viewtype"] == 'editcamp') { ?>

    <!--EDIT CAMPAIGNS HERE-->

    <div id="campstuff" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="theformhold">

                    </div>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>


    <img style="max-width: 200px; margin: 15px 0px;float: right;" src="ce_logo.png">
    <h1>Chameleon Engine</h1>
    <p>Create / Edit Chameleon objects.</p>

    <div class="clearfix"></div>
    <div style="padding: 10px; text-align: right"><a href="ui.php" class="btn btn-primary"> < Back to campaigns</a></div>


<?php
include('functions.php');
$chamel = new chameleon();



if(isset($_POST["object_content"])){
    $chamel->updateCamp($_POST);
}

$campItem = $chamel->getCampItem($_REQUEST["id"]);

$campaign_name = $campItem["campaign_name"];
$campaign_type = $campItem["campaign_type"];
$impressions = $campItem["impressions"];
$interactions = $campItem["interactions"];
$keywords = $campItem["keywords"];
$campaign_details = $campItem["campaign_details"];

$html .= '<form name="camp_info" id="camp_info" method="post" action="">';

$html .= '<div class="row" style="margin: 0">';
$html .= '<div class="col-md-4">';
$html .= '<label>Campaign Name:</label><br>';
$html .= '<input type="text" class="form-control" name="campagin_name" value="'.$campaign_name.'">';
$html .= '</div>';
$html .= '<div class="col-md-4">';
$html .= '<label>Campaign Type:</label><br>';

$CPtypes = array('Select Type'=>'','Page Object'=>'box','Slider'=>'slider');

foreach($CPtypes as $val=>$key){
    if($campaign_type == $key){
        $html .= '<div style="background: #efefef; padding: 5px">'.$val.'</div>';
    }

}

$html .= '</select><br><br>';
$html .= '</div>';
$html .= '</div>';

$html .= '<div class="clearfix"></div>';

$html .= '<div class="row" style="margin: 0">';

$html .= '<div class="col-md-12">';
$html .= '<label>Campaign Keywords:</label><br><small>Separate each with comma.</small><br>';
$html .= '<input type="text" class="form-control" name="campagin_keywords" id="campagin_keywords" value="'.$keywords.'">';
$html .= '</div>';
$html .= '</div><br><br>';

$html .= '<div class="row" style="margin: 0">';

$html .= '<div class="col-md-12">';
$html .= '<label>Campaign Content:</label><br>';
$html .= '<textarea name="object_content" id="object_content" class="form-control summernote">'.$campaign_details.'</textarea>';

$html .= '</div>';

$html .= '</div><br>';

$html .= '<div class="row" style="margin: 0">';
$html .= '<div class="col-md-12">';
$html .= '<input type="hidden" name="camp_id" id="camp_id" value="'.$_REQUEST["id"].'">';
$html .= '<button class="btn btn-success">Save Campaign</button>';
$html .= '</div>';
$html .= '</div>';
$html .= '</form>';

echo $html;



?>





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

        $(function(){
            intEdits();
        })

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
    </script>

    <!--END EDIT CAMPAIGNS HERE-->

<?php } ?>


<?php if($_REQUEST["viewtype"] == null){ ?>
    <!--CREATE CAMPAIGNS / OBJECTS HERE-->
<img style="max-width: 200px; margin: 15px 0px;float: right;" src="ce_logo.png">
<h1>Chameleon Engine</h1>
<p>Create / Edit Chameleon objects.</p>
<div class="clearfix"></div>

<br>

<div id="campstuff" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="theformhold">

                </div>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>

<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="true">Campaigns</a>
        <a class="nav-item nav-link" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="false">Chameleon Objects</a>
    </div>
</nav>
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"><br>
        <h3>Chameleon Objects</h3><br>
        <button class="btn btn-outline-primary" style="float:right; margin: 5px" onclick="createNewCampaign()">Create New Object</button><br><div class="clearfix"></div><br>
        <div class="cham-obj slides">
            <table id="example" class="display thetabls" style="width:100%">
                <thead>
                <tr>
                    <th style="font-weight: bold; background: rgb(93, 93, 93); color: rgb(255, 255, 255); border-right: thin solid rgb(239, 239, 239); width: 728px;">Name</th>
                    <th style="font-weight: bold; background: rgb(93, 93, 93); color: rgb(255, 255, 255); border-right: thin solid rgb(239, 239, 239); width: 728px;">Associated Campaigns</th>
                    <th style="font-weight: bold; background: rgb(93, 93, 93); color: rgb(255, 255, 255); border-right: thin solid rgb(239, 239, 239); width: 728px;">Usage Token</th>
                    <th style="font-weight: bold; background: rgb(93, 93, 93); color: rgb(255, 255, 255); border-right: thin solid rgb(239, 239, 239); width: 728px; text-align: right">Action</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
    <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab"><br>
        <h3>Chameleon Campaigns</h3><br>
        <button class="btn btn-outline-warning create-camp" style="float:right; margin: 5px" onclick="createCamp()">Create New Campaign</button><br><div class="clearfix"></div><br>
        <div class="cham-obj objex">
            <table id="example" class="display thetabls" style="width:100%">
                <thead>
                <tr>
                    <th style="font-weight: bold; background: rgb(93, 93, 93); color: rgb(255, 255, 255); border-right: thin solid rgb(239, 239, 239); width: 728px;">Campaign Name</th>
                    <th style="font-weight: bold; background: rgb(93, 93, 93); color: rgb(255, 255, 255); border-right: thin solid rgb(239, 239, 239); width: 728px;">Type</th>
                    <th style="font-weight: bold; background: rgb(93, 93, 93); color: rgb(255, 255, 255); border-right: thin solid rgb(239, 239, 239); width: 728px;">Impressions</th>
                    <th style="font-weight: bold; background: rgb(93, 93, 93); color: rgb(255, 255, 255); border-right: thin solid rgb(239, 239, 239); width: 728px;">Interactions</th>
                    <th style="font-weight: bold; background: rgb(93, 93, 93); color: rgb(255, 255, 255); border-right: thin solid rgb(239, 239, 239); width: 728px; text-align: right">Action</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>



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
    $(function(){
        $.ajax({
            url: 'async.php?action=getslidetab',
            cache: false,
            success:function(data){
                $(".slides").html(data);
                var table = $('.thetabls').DataTable()
            }
        })

        $.ajax({
            url: 'async.php?action=getcamptab',
            cache: false,
            success:function(data){
                $(".objex").html(data);
                var table = $('.thecamptabls').DataTable()
            }
        })

        getCampTable
    })

    function createNewCampaign(){

        $(".cham_opts").remove();
        $(".modal-body").prepend('<div class="cham_opts"><p>Select type of chameleon object.</p><div class="btn-group btn-group-toggle" data-toggle="buttons"><label class="btn btn-outline-primary sel-typ" data-camptyp="slide"><input type="radio" name="options" id="option1" value="slide" autocomplete="off"> Slider Object</label><label class="btn btn-outline-primary sel-typ" data-camptyp="box"><input type="radio" name="options" id="option2" value="box" autocomplete="off"> Page Object</div></div>')

        $("#campstuff .modal-title").html('Create New Object');
        $("#campstuff").modal();

        $(".sel-typ").on('click',function(){
           if($(this).data('camptyp') == 'slide'){
               $.ajax({
                   url: 'async.php?action=getslideform',
                   cache: false,
                   success: function(data){
                       $(".theformhold").html(data);

                       $("#slider_ch").validate({
                           submitHandler: function(form) {
                                // avoid to execute the actual submit of the form.

                                   var form = $(form);
                                   var url = 'async.php?action=processbuild';

                                   $.ajax({
                                       type: "POST",
                                       url: url,
                                       data: form.serialize(), // serializes the form's elements.
                                       success: function(data)
                                       {
                                           alert('GOOD'); // show response from the php script.
                                       }
                                   });
                           }

                           })

                   }
               })
           }else{
               $.ajax({
                   url: 'async.php?action=getboxform',
                   cache: false,
                   success: function(data){
                       $(".theformhold").html(data);

                       $("#box_ch").validate({
                           submitHandler: function(form) {
                               // avoid to execute the actual submit of the form.

                               var form = $(form);
                               var url = 'async.php?action=processbuildbox';

                               $.ajax({
                                   type: "POST",
                                   url: url,
                                   data: form.serialize(), // serializes the form's elements.
                                   success: function(data)
                                   {
                                       alert('GOOD'); // show response from the php script.
                                   }
                               });
                           }

                       })

                   }
               })
           }


        })
    }



    function createCamp(){
        $.ajax({
            url: 'async.php?action=startCampaign',
            success: function (data) {
                $(".cham_opts").empty();
                $(".theformhold").html(data);
                $("#campstuff .modal-title").text('Create New Campaign');
                $("#campstuff").modal();

                $("#new-campagin").validate({
                    submitHandler: function(form) {
                        // avoid to execute the actual submit of the form.

                        var form = $(form);
                        var url = 'async.php?action=startcampaign';

                        $.ajax({
                            type: "POST",
                            url: url,
                            data: form.serialize(), // serializes the form's elements.
                            success: function(data)
                            {
                                var Data = $.parseJSON(data);
                                var result = Data.result;
                                var message = Data.message;

                                if(result != 'error'){
                                    $(".camp_alerts").html('<div class="alert alert-success">'+message+'</div>');
                                }else{
                                    $(".camp_alerts").html('<div class="alert alert-danger">'+message+'</div>');
                                }
                            }
                        });
                    }

                })
            }
        })

    }

    function  deleteObject(id){
        swal({
            title: 'Are you sure?',
            text: "Once you delete this object all data will be removed and you will no longer be able to access any of it's data.",
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
                url: 'async.php?action=deleteobject&onjid='+id,
                success:function(data){
                    //DO SOMETHING//
                    $(".lineitem"+id).remove();
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

    function deleteCampagin(id){
        swal({
            title: 'Are you sure?',
            text: "Once you delete campaign object all data will be removed and you will no longer be able to access any of it's data.",
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
                url: 'async.php?action=deletecampaign&onjid='+id,
                success:function(data){
                    //DO SOMETHING//
                    $(".lineitemcamp"+id).remove();
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
<?php } ?>
</body>
</html>