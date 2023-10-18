<?php
include('functions.php');
$site = new deereClass();
//$userArray = $site->auth();

if(isset($_POST["cat_img"])){
    $site->updateProduct($_POST);
    echo '<div class="alert alert-success"><strong>Success!</strong> - Product has been updated!</div>';
}

$product = $site->getProduct($_REQUEST["prod"],'');

//var_dump($product);

//var_dump($product);
$html .= '<h2>'.$product["title"].'</h2>';
if($_REQUEST["cat"] == 'cat_four'){$back = 'cat_three'; $backCat = $product["cat_three"];}
if($_REQUEST["cat"] == 'cat_three'){$back = 'cat_two'; $backCat = $product["cat_two"];}
if($_REQUEST["cat"] == 'cat_two'){$back = 'cat_one'; $backCat = $product["cat_one"];}
$html .= '<div class="col-md-12" style="text-align: right"><a href="javascript:void(0)" class="btn btn-warning btn-sm btn-fill" onclick="window.parent.changeCats(\''.$backCat.'\',\''.$back.'\')"><i class="fa fa-angle-left" aria-hidden="true"></i> Go Back</a></div>';
$prodImg = json_decode($product["eq_image"],true);


if (json_last_error() === JSON_ERROR_NONE) {
    // JSON is valid
    $theMain = $prodImg[0];
    $theSave = json_encode($prodImg);
}else{
    $theMain = str_replace('"','',$product["eq_image"]);
    $theSave = str_replace('"','',$product["eq_image"]);
}




$html .= '<img class="img-thumbnail" style="max-width: 300px;" src="../../../img/equip_images/'.$theMain.'">';
$html .= '<form name="updateprod" id="updateprod" method="post" action="">';
$html .= '<div class="clearfix"></div><br><br>';
$html .= '<div class="row">';
$html .= "<input type='hidden' class='form-control' name='cat_img' id='cat_img'  value='$theSave'>";
//$html .= '<div class="col-md-4">';
//
//var_dump($prodImg);
//
//
//$html .= '<label>Category Image</label><br>
//<div class="input-group mb-3">
//                    <input type="text" class="form-control" name="cat_img" id="cat_img" placeholder="No Image" aria-label="Category Image" value="'.json_encode($prodImg).'">
//                    <div class="input-group-append">
//                        <button class="btn btn-success img-browser" data-setter="cat_img" type="button">Browse Images</button>
//                    </div>
//                </div>';
//$html .= '</div>';


$html .= '<div class="col-md-4">';
$html .= '<label>Dealer Price:</label><br><input class="form-control" name="msrp" id="msrp" type="text" value="'.$product["dealer_price"].'" ><br><br>';
$html .= '</div>';
$html .= '<div class="col-md-4"><label>Price:</label><br><input class="form-control" name="pricepoint" id="pricepoint" type="text" value="'.$product["price"].'" >';
$html .= '</div><div class="col-md-4"><label>Button Text</label><br><input class="form-control" name="cta-text" id="cta-text" value="'.$product["cta_text"].'"/></div>';



$html .= '<div class="clearfix"></div>';

$html .= '<div class="col-md-12"><p>Below you can turn on and off each product section fed by Deere.</p></div>';

if($product["api_price_active"] == 'true'){$apiprice = 'fa-toggle-on';} else{$apiprice = 'fa-toggle-off';}
if($product["quick_links_active"] == 'true'){$quick = 'fa-toggle-on';}else{$quick = 'fa-toggle-off';}
if($product["offers_active"] == 'true'){$offers = 'fa-toggle-on';}else{$offers = 'fa-toggle-off';}
if($product["videos_active"] == 'true'){$videos = 'fa-toggle-on';}else{$videos = 'fa-toggle-off';}
if($product["access_active"] == 'true'){$access = 'fa-toggle-on';}else{$access = 'fa-toggle-off';}
if($product["reviews_active"] == 'true'){$reviews = 'fa-toggle-on';}else{$reviews = 'fa-toggle-off';}

$html .= '<div class="col-md-4"><label>Deere Price</label><br><span class="api-price" style="font-size: 40px;color: #21d021;"><i class="fa '.$apiprice.' fa-3 thetoggle" data-elmclos="api_price_active" aria-hidden="true"></i><input type="hidden" name="api_price_active" id="api_price_active" value="'.$product["api_price_active"].'"></span></div>';
$html .= '<div class="col-md-4"><label>Offers & Discounts</label><br><span class="offers-links" style="font-size: 40px;color: #21d021;"><i class="fa '.$offers.' fa-3 thetoggle" data-elmclos="offers_active" aria-hidden="true"></i><input type="hidden" name="offers_active" id="offers_active" value="'.$product["offers_active"].'"></span></div>';
$html .= '<div class="col-md-4"><label>Videos</label><br><span class="videos-links" style="font-size: 40px;color: #21d021;"><i class="fa '.$videos.' fa-3 thetoggle" data-elmclos="videos_active" aria-hidden="true"></i><input type="hidden" name="videos_active" id="videos_active" value="'.$product["videos_active"].'"></span></div>';
$html .= '<div class="clearfix"></div>';
$html .= '<div class="col-md-4"><label>Reviews</label><br><span class="review-links" style="font-size: 40px;color: #21d021;"><i class="fa '.$reviews.' fa-3 thetoggle" data-elmclos="reviews_active" aria-hidden="true"></i><input type="hidden" name="reviews_active" id="reviews_active" value="'.$product["reviews_active"].'"></span></div>';
$html .= '<div class="col-md-4"><label>Accessories & Attachments</label><br><span class="access-links" style="font-size: 40px;color: #21d021;"><i class="fa '.$access.' fa-3 thetoggle" data-elmclos="access_active" aria-hidden="true"></i></span> <input type="hidden" name="access_active" id="access_active" value="'.$product["access_active"].'"></div>';
$html .= '<div class="clearfix"></div>';
$html .= '<div class="col-md-12"><label>Promotion / Additional Info Area. </label><br><small>This area is located between the product image and features area. If content is provided the area will show up.</small><br><textarea class="summernotes" id="promoarea" name="promoarea">'.$product["extra_content"].'</textarea></div>';
$html .= '<div class="clearfix"></div>';
$html .= '<input type="hidden" name="proid" id="proid" value="'.$product["id"].'">';
$html .= '<div class="col-md-12" style="text-align: right; padding: 20px"><button class="btn btn-success btn-fill">Save Edits</button></div>';
$html .= '</div>';
$html .= '</form>';


?>

<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="../../assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="../../assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Paper Dashboard core CSS    -->
    <link href="../../assets/css/paper-dashboard.css" rel="stylesheet"/>


    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="../../assets/css/demo.css" rel="stylesheet" />


    <!--  Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="../../assets/css/themify-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../../codemirror/lib/codemirror.css"/>
    <link rel="stylesheet" href="../../codemirror/theme/mbo.css">
    <link rel="stylesheet" href="../../assets/css/bootstrap-datetimepicker.css">
    <link rel="stylesheet" href="../../assets/css/bootstrap-switch.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/charts.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/t/bs/jqc-1.12.0,dt-1.10.11/datatables.min.css"/>

    <!--   Core JS Files   -->
    <script type="text/javascript" src="https://cdn.datatables.net/t/bs/jqc-1.12.0,dt-1.10.11/datatables.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>

    <!--<script type="text/javascript" src="js/codemirror.js"></script>-->
    <script src="../../assets/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="../../codemirror/lib/codemirror.js"></script>
    <script src="../../codemirror/mode/css/css.js"></script>
    <script src="../../codemirror/mode/javascript/javascript.js"></script>
    <script src="../../codemirror/mode/xml/xml.js"></script>
    <script src="../../codemirror/mode/htmlmixed/htmlmixed.js"></script>
    <script src="../../assets/js/moment.js"></script>
    <script src="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>
    <script src="../../assets/js/nest-menu.js"></script>
    <script src="../../assets/js/bootstrap-switch.js"></script>
    <script src="../../assets/js/jquery.form.js"></script>
    <script src="../../assets/js/jquery.validate.js"></script>
    <script src="../../assets/js/closetag.js"></script>
    <script src="../../tinymce/js/tinymce/tinymce.min.js"></script>
    <script src="../../assets/js/clipboard.js"></script>
    <script src="../../assets/js/bootstrap-colorpicker.js"></script>
    <script src="../../assets/js/jquery.sticky.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-md5/2.10.0/js/md5.min.js"></script>


    <!--  Checkbox, Radio & Switch Plugins -->
    <script src="../../assets/js/bootstrap-checkbox-radio.js"></script>


    <!--  Notifications Plugin    -->
    <script src="../../assets/js/bootstrap-notify.js"></script>

    <!--  Google Maps Plugin    -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>

    <!-- Paper Dashboard Core javascript and methods for Demo purpose -->


    <!-- Paper Dashboard DEMO methods, don't include it in your project! -->
    <script src="../../assets/js/demo.js"></script>

    <script src="../../assets/js/bootstrap-datetimepicker.min.js"></script>

    <style>
        .ct-series-b .ct-slice-pie, .ct-series-b .ct-area {
            fill: #eb5e29;
        }

        .ct-bar {
            fill: none;
            stroke-width: 35px;
        }

        .dataTables_length{
            padding: 20px;
        }

        .dataTables_filter{
            padding: 20px;
        }

        .dataTables_info{
            padding:20px
        }

        .dataTables_paginate{
            padding:20px
        }

        .form-control {
            background-color: #eee;
            border: medium none;
            border-radius: 4px;
            color: #333;
            font-size: 14px;
            transition: background-color 0.3s ease 0s;
            padding: 7px 18px;
            height: 40px;
            -webkit-box-shadow: none;
            box-shadow: none;
        }

        .form-control:focus {
            background-color: #ffd655;
            -webkit-box-shadow: none;
            box-shadow: none;
            outline: 0 !important;
            color:#333
        }

        table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:after {
            position: absolute;
            bottom: 8px;
            right: 8px;
            display: block;
            font-family: 'themify';
            opacity: 0.5;
        }

        table.dataTable thead .sorting:after {
            opacity: 0.2;
            content: "\e648";
        }

        table.dataTable thead .sorting_asc:after {
            content: "\e64b";
        }

        table.dataTable thead .sorting_desc:after {
            content: "\e648";
        }
        .table-striped tbody > tr:nth-of-type(2n) {
            background-color: #eeeeee;
        }

        .table thead tr > th, .table thead tr > td, .table tbody tr > th, .table tbody tr > td, .table tfoot tr > th, .table tfoot tr > td {
            border-top: 1px solid #efefef;
            /* border: none; */
        }

        .card .title {
            margin: 0;
            color: #eb5e29;
            font-weight: bold;
        }

        .diffDeleted span {
            border: 1px solid rgb(255,192,192);
            background: rgb(255,224,224);
        }

        .diffInserted span {
            border: 1px solid rgb(192,255,192);
            background: rgb(224,255,224);
        }

        .diffUnmodified span{
            border: 1px solid rgb(241, 237, 216);
            background: rgb(252, 248, 227);
        }

        .diff td{
            vertical-align : top;
            white-space    : pre;
            white-space    : pre-wrap;
            font-family    : monospace;
        }

        .diff{
            width:100%
        }

        .pagination>.disabled>a, .pagination>.disabled>a:focus, .pagination>.disabled>a:hover, .pagination>.disabled>span, .pagination>.disabled>span:focus, .pagination>.disabled>span:hover {
            color: #777;
            cursor: not-allowed;
            background-color: #eee;
            border-color: #ddd;
        }

        .pagination>.active>a, .pagination>.active>a:focus, .pagination>.active>a:hover, .pagination>.active>span, .pagination>.active>span:focus, .pagination>.active>span:hover {
            z-index: 2;
            color: #fff;
            cursor: default;
            background-color: #7ac29a;
            border-color: #7ac29a;
        }

        .CodeMirror pre {
            -moz-border-radius: 0;
            -webkit-border-radius: 0;
            border-radius: 0;
            border-width: 0;
            background: transparent;
            font-family: inherit;
            font-size: inherit;
            margin: 0;
            white-space: pre;
            word-wrap: normal;
            line-height: inherit;
            color: inherit;
            z-index: 2;
            position: relative;
            overflow: visible;
            -webkit-tap-highlight-color: transparent;
            padding: 0px 34px;
        }

        .img-full-width{
            width:100%
        }

        .loader {
            position: relative;
            margin: 0 auto;
            width: 50px;
        }
        .loader:before {
            content: '';
            display: block;
            padding-top: 100%;
        }

        .circular {
            -webkit-animation: rotate 2s linear infinite;
            animation: rotate 2s linear infinite;
            height: 100%;
            -webkit-transform-origin: center center;
            transform-origin: center center;
            width: 100%;
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            margin: auto;
        }

        .path {
            stroke-dasharray: 1, 200;
            stroke-dashoffset: 0;
            -webkit-animation: dash 1.5s ease-in-out infinite, color 6s ease-in-out infinite;
            animation: dash 1.5s ease-in-out infinite, color 6s ease-in-out infinite;
            stroke-linecap: round;
        }

        @-webkit-keyframes rotate {
            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @keyframes rotate {
            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
        @-webkit-keyframes dash {
            0% {
                stroke-dasharray: 1, 200;
                stroke-dashoffset: 0;
            }
            50% {
                stroke-dasharray: 89, 200;
                stroke-dashoffset: -35px;
            }
            100% {
                stroke-dasharray: 89, 200;
                stroke-dashoffset: -124px;
            }
        }
        @keyframes dash {
            0% {
                stroke-dasharray: 1, 200;
                stroke-dashoffset: 0;
            }
            50% {
                stroke-dasharray: 89, 200;
                stroke-dashoffset: -35px;
            }
            100% {
                stroke-dasharray: 89, 200;
                stroke-dashoffset: -124px;
            }
        }
        @-webkit-keyframes color {
            100%,
            0% {
                stroke: #E75F34;
            }
            40% {
                stroke: #E75F34;
            }
            66% {
                stroke: #E75F34;
            }
            80%,
            90% {
                stroke: #E75F34;
            }
        }
        @keyframes color {
            100%,
            0% {
                stroke: #E75F34;
            }
            40% {
                stroke: #E75F34;
            }
            66% {
                stroke: #E75F34;
            }
            80%,
            90% {
                stroke: #E75F34;
            }
        }

        .load_holds{
            width:200px;
            text-align: center;
            position: absolute;
            left: 50%;
            top:40%;
            z-index: 6;
            margin-left:-100px;
            display: none;
        }

        .coversheet{
            background: #fff;
            width: 100%;
            height: 100%;
            position: fixed;
            top:0;
            left: 0;
            z-index: 5;
            opacity:.7;
            display: none;
        }

        .mce-branding{
            padding:10px 0px
        }

        .thetoggle{
            cursor: pointer;
        }


    </style>


</head>

<body>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

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
    <div class="modal-dialog modal-lg">

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
<div style="padding: 20px">
<?php echo $html; ?>
</div>

<script>
    $(function(){
        initMobileMce();
        $(".img-browser").on('click',function(){
            var itemsbefor = $(this).data('setter');
            $("#myModalAS .modal-title").html('Select an Image For Link');
            $("#myModalAS .modal-body").html('<iframe id="themedia" style="width: 100%; height: 450px; border: none" src="../../media_manager.php?typeset=simple&returntarget='+itemsbefor+'"></iframe>');
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
        var imgClean = img.replace("../../../../img/", "");
        $('#'+inputTarget).val(imgClean);
        imgSucc();
    }
    function imgSucc(){
        $("#myModalAS").modal('hide');
    }

    function initMobileMce(){
        tinymce.init({
            selector: ".summernotes",
            skin: "caffiene",
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
                "table contextmenu directionality emoticons paste textcolor codemirror"
            ],

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
            style_formats: [
                { width: 'Bold text', inline: 'strong' },
                { title: 'Red text', inline: 'span', styles: { color: '#ff0000' } },
                { title: 'Red header', block: 'h1', styles: { color: '#ff0000' } },
                { title: 'Badge', inline: 'span', styles: { display: 'inline-block', border: '1px solid #2276d2', 'border-radius': '5px', padding: '2px 5px', margin: '0 2px', color: '#2276d2' } },
                { title: 'Table row 1', selector: 'tr', classes: 'tablerow1' }
            ],
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
        //alert(url);
        var t = url;
        t = t.substr(0, t.lastIndexOf('/'));
        if(t != ''){
            var dir = '&directory='+t
        }else{
            var dir = '';
        }

        //$("#myModal .modal-body").html('<iframe id="themedia" style="width: 100%; height: 450px; border: none" src="filedfiles.php?mceid='+ids+'"></iframe>');
        $("#myModal .modal-body").html('<iframe src="../../media_manager.php?returntarget='+ids+'" style="height:600px;width:100%; border: none"></iframe>')
        $("#myModal .modal-title").html('Media Browser');
        $("#myModal").modal();
        $("#myModal").css('z-index','75541');
        $(".modal-dialog").css('width','70%');
        $(".modal-backdrop").css('z-index','70000');
        $('#themedias').contents().find('#mcefield').val('myValue');
    }
    function updateMcefld(mediapath, vals){
        $("#"+vals).val(mediapath);
        $('#myModal').modal('hide');
        console.log(mediapath+' - '+vals);
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
        alert('Image added. You can close media manager.');
    }

    $(function(){
        $(".thetoggle").on('click',function(){
            var theid = $(this).data('elmclos');
            var theStatus = $('#'+theid).val();
            if(theStatus == 'true'){
                $(this).removeClass('fa-toggle-on').addClass('fa-toggle-off');
                $('#'+theid).val('false');
            }else{
                $(this).removeClass('fa-toggle-off').addClass('fa-toggle-on');
                $('#'+theid).val('true');
            }
        })
    })

</script>
</body>
</html>
