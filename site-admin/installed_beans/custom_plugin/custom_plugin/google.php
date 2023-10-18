<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="../../plugins/switchery/switchery.min.css" rel="stylesheet" />

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
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
    <script src="md5.min.js"></script>
    <script src="jquery.sticky.js"></script>
    <script src="jquery.hideseek.js"></script>
    <script src="../../plugins/sweet-alert/sweetalert2.min.js"></script>
    <script src="../../assets/pages/jquery.sweet-alert.init.js"></script>

    <title>Hello, world!</title>

    <style>
        .modal-lg {
            max-width: 80%;
        }

    </style>
</head>
<body>
<?php
date_default_timezone_set('America/Chicago');
?>

<!-- Modal -->
<div class="header">
    <h4 class="title">Create Custom Equipment Category</h4>
    <p class="category">Use this to create custom categories for equipment.</p>

    <div class="clearfix"></div>
</div>
<div class="content table-responsive table-full-width">
    <form class="validforms" id="page-layout" name="page-layout" style="padding: 20px" method="post" action="">
        <input class="form-control" type="hidden" name="line_type" id="line_type" value="custom">
       <label>Child Category</label><small>(Choose from the existing dropdown or add new)</small></br>
        </br>
        <label>Title</label><br>
        <input class="form-control" type="text" id="title" name="title" value="" ><br>
        <label>Description</label><small>(Character Limit: 300)</small><br>
        <input class="form-control" type="text" id="item_description" name="item_description" value="" ><br>
        <label>Link</label><small>(Links Only)</small><br>
        <input class="form-control" type="text" id="link" name="link" value="" ><br>
        <label>Image Link</label><small>(Image URL Only)</small><br>
        <input class="form-control" type="text" id="image_link" name="image_link" value="" ><br>
        <label>Mobile Link</label><small>(Mobile URL Only)</small><br>
        <input class="form-control" type="text" id="mobile_link" name="mobile_link" value="" ><br>
        <label>Additional Image Link</label><small>(Optional)</small><br>
        <input class="form-control" type="text" id="additional_image_link" name="additional_image_link" value="" ><br>
        <label>Availability</label><br>
        <input class="form-control" type="text" id="availability" name="availability" value="" r><br>
        <label>Availability Date</label><br>
        <input class="form-control" type="text" id="availability_date" name="availability_date" value="" ><br>
        <label>Cost of Goods Sold</label><br>
        <input class="form-control" type="text" id="cost_of_goods_sold" name="cost_of_goods_sold" value="" ><br>
        <label>Expiration Date</label><br>
        <input class="form-control" type="text" id="expiration_date" name="expiration_date" value="" ><br>
        <label>Price</label><br>
        <input class="form-control" type="text" id="price" name="price" value="" ><br>
        <label>Sale Price</label><br>
        <input class="form-control" type="text" id="sale_price" name="sale_price" value="" ><br>
        <label>Sale Price Effective Date</label><br>
        <input class="form-control" type="text" id="sale_price_effective_date" name="sale_price_effective_date" value="" ><br>
        <label>Unit Pricing Measure</label><br>
        <input class="form-control" type="text" id="unit_pricing_measure" name="unit_pricing_measure" value="" ><br>
        <label>Unit Pricing Base Measure</label><br>
        <input class="form-control" type="text" id="unit_pricing_base_measure" name="unit_pricing_base_measure" value="" ><br>
        <label>Installment</label><br>
        <input class="form-control" type="text" id="installment" name="installment" value="" ><br>
        <label>Subscription Cost</label><br>
        <input class="form-control" type="text" id="subscription_cost" name="subscription_cost" value="" ><br>
        <label>Loyalty Points</label><br>
        <input class="form-control" type="text" id="loyalty_points" name="loyalty_points" value="" ><br>
        <label>Google Product Category</label><br>
        <input class="form-control" type="text" id="google_product_category" name="google_product_category" value="" ><br>
        <label>Product Type</label><br>
        <input class="form-control" type="text" id="product_type" name="product_type" value="" ><br>
        <label>Brand</label><br>
        <input class="form-control" type="text" id="brand" name="brand" value="" ><br>
        <label>GTin</label><br>
        <input class="form-control" type="text" id="gtin" name="gtin" value="" ><br>
        <label>MPN</label><br>
        <input class="form-control" type="text" id="mpn" name="mpn" value="" ><br>
        <label>Identifier Exists</label><br>
        <input class="form-control" type="text" id="identifier_exists" name="identifier_exists" value="" ><br>
        <label>Condition</label><br>
        <input class="form-control" type="text" id="condition" name="condition" value="" ><br>
        <label>Adult</label><br>
        <input class="form-control" type="text" id="adult" name="adult" value="" ><br>
        <label>Multipack</label><br>
        <input class="form-control" type="text" id="multipack" name="multipack" value="" ><br>
        <label>Is Bundle</label><br>
        <input class="form-control" type="text" id="is_bundle" name="is_bundle" value="" ><br>
        <label>Age Group</label><br>
        <input class="form-control" type="text" id="age_group" name="age_group" value="" ><br>
        <label>Color</label><br>
        <input class="form-control" type="text" id="color" name="color" value="" ><br>
        <label>Gender</label><br>
        <input class="form-control" type="text" id="gender" name="gender" value="" ><br>
        <label>Material</label><br>
        <input class="form-control" type="text" id="material" name="material" value="" ><br>
        <label>Pattern</label><br>
        <input class="form-control" type="text" id="pattern" name="pattern" value="" ><br>
        <label>Google Size</label><br>
        <input class="form-control" type="text" id="google_size" name="google_size" value="" ><br>
        <label>Size Type</label><br>
        <input class="form-control" type="text" id="size_type" name="size_type" value="" ><br>
        <label>Size System</label><br>
        <input class="form-control" type="text" id="size_system" name="size_system" value=""><br>
        <label>Item Group ID</label><br>
        <input class="form-control" type="text" id="item_group_by_id" name="item_group_by_id" value="" ><br>
        <label>Ads Redirect</label><br>
        <input class="form-control" type="text" id="ads_redirect" name="ads_redirect" value="" ><br>
        <label>Custom Label</label><br>
        <input class="form-control" type="text" id="custom_label" name="custom_label" value="" ><br>
        <label>Promotion ID</label><br>
        <input class="form-control" type="text" id="promotion_id" name="promotion_id" value="" ><br>
        <label>Excluded Destination</label><br>
        <input class="form-control" type="text" id="excluded_destination" name="excluded_destination" value="" ><br>
        <label>Included Destination</label><br>
        <input class="form-control" type="text" id="included_destination" name="included_destination" value="" ><br>
        <label>Shipping</label><br>
        <input class="form-control" type="text" id="shipping" name="shipping" value="" ><br>
        <label>Shipping Label</label><br>
        <input class="form-control" type="text" id="shipping_label" name="shipping_label" value="" ><br>
        <label>Shipping Weight</label><br>
        <input class="form-control" type="text" id="shipping_weight" name="shipping_weight" value="" ><br>
        <label>Shipping Length</label><br>
        <input class="form-control" type="text" id="shipping_length" name="shipping_length" value="" ><br>
        <label>Shipping Width</label><br>
        <input class="form-control" type="text" id="shipping_width" name="shipping_width" value="" ><br>
        <label>Shipping Height</label><br>
        <input class="form-control" type="text" id="shipping_height" name="shipping_height" value="" ><br>
        <label>Shipping Width</label><br>
        <input class="form-control" type="text" id="shipping_width" name="shipping_width" value="" ><br>
        <label>Shipping Height</label><br>
        <input class="form-control" type="text" id="shipping_height" name="shipping_height" value="" ><br>
        <label>Transmit Time Label</label><br>
        <input class="form-control" type="text" id="transmit_time_label" name="transmit_time_label" value="" ><br>
        <label>Max Handling Time</label><br>
        <input class="form-control" type="text" id="max_handling_time" name="max_handling_time" value="" ><br>
        <label>Min Handling Time</label><br>
        <input class="form-control" type="text" id="min_handling_time" name="min_handling_time" value="" ><br>
        <label>Tax</label><br>
        <input class="form-control" type="text" id="tax" name="tax" value="" ><br>
        <label>Tax Category</label><br>
        <input class="form-control" type="text" id="tax_category" name="tax_category" value="" ><br>
        <label>Energy Efficiency Class</label><br>
        <input class="form-control" type="text" id="energy_efficiency_class" name="energy_efficiency_class" value="" ><br>
        <label>Min Energy Efficiency Class</label><br>
        <input class="form-control" type="text" id="min_energy_efficiency_class" name="min_energy_efficiency_class" value="" ><br>
        <label>Max Energy Efficiency Class</label><br>
        <input class="form-control" type="text" id="max_energy_efficiency_class" name="max_energy_efficiency_class" value="" ><br>
        <label>Category Image</label><small>(Ex: hello.png. Select an image and remove url path)</small><br>
        <div class="input-group mb-3">
            <input type="text" class="form-control" name="cat_img" id="cat_img" placeholder="No Image" aria-label="Category Image" value="<?php echo $catImg; ?>">
            <div class="input-group-append">
                <button class="btn btn-success img-browser" data-setter="cat_img" type="button">Browse Images</button>
            </div>
        </div>
        <br><label>Specs</label><br>
        <br><textarea class="summernotes" id="description" name="description"></textarea><br><br>
        <button type="submit" class="btn btn-success" id="submit1" name="submit1">Save Page</button>
    </form>
</div>

<?php
include('config.php');

//$parent = $_POST["parent"];
//$child = $_POST["child"];
$title = $_POST["title"];
$item_description = $_POST["item_description"];
$link = $_POST["link"];
//$msrp = $_POST["msrp"];
//$img = $_POST["cat_img"];
//$features = $_POST["features"];
$image_link = $_POST["image_link"];
$mobile_link =$_POST["mobile_link"];
$additional_image_link = $_POST["additional_image_link"];
$availability = $_POST["availability"];
$availability_date = $_POST["availability_date"];
$cost_of_goods_sold = $_POST["cost_of_goods_sold"];
$expiration_date = $_POST["expiration_date"];
$price = $_POST["price"];
$sale_price = $_POST["sale_price"];
$sale_price_effective_date = $_POST["sale_price_effective_date"];
$unit_pricing_measure = $_POST["unit_pricing_measure"];
$unit_pricing_base_measure = $_POST["unit_pricing_base_measure"];
$installment = $_POST["installment"];
$subscription_cost = $_POST["subscription_cost"];
$loyalty_points = $_POST["loyalty_points"];
$google_product_category = $_POST["google_product_category"];
$product_type = $_POST["product_type"];
$brand = $_POST["brand"];
$gtin = $_POST["gtin"];
$mpn = $_POST["mpn"];
$identifier_exists = $_POST["identifier_exists"];
$item_condition = $_POST["condition"];
$adult = $_POST["adult"];
$multipack = $_POST["multipack"];
$is_bundle = $_POST["is_bundle"];
$age_group = $_POST["age_group"];
$color = $_POST["color"];
$gender = $_POST["gender"];
$material = $_POST["material"];
$pattern = $_POST["pattern"];
$google_size = $_POST["google_size"];
$size_type = $_POST["size_type"];
$size_system = $_POST["size_system"];
$itemgroup_id = $_POST["item_group_by_id"];
$ads_redirect = $_POST["ads_redirect"];
$custom_label = $_POST["custom_label"];
$promotion_id = $_POST["promotion_id"];
$excluded_destination = $_POST["excluded_destination"];
$included_destination = $_POST["included_destination"];
$shipping = $_POST["shipping"];
$shipping_label = $_POST["shipping_label"];
$shipping_weight = $_POST["shipping_weight"];
$shipping_length = $_POST["shipping_length"];
$shipping_width = $_POST["shipping_width"];
$shipping_height = $_POST["shipping_height"];
$transmit_time_label = $_POST["transmit_time_label"];
$max_handling_time = $_POST["max_handling_time"];
$min_handling_time = $_POST["min_handling_time"];
$tax = $_POST["tax"];
$tax_category = $_POST["tax_category"];
$energy_efficiency_class = $_POST["energy_efficiency_class"];
$min_energy_efficiency_class = $_POST["min_energy_efficiency_class"];
$max_energy_efficiency_class = $_POST["max_energy_efficiency_class"];

if(isset($_POST['title'])) {
    $data->query("INSERT INTO google_shop SET id = '', title = '$title', item_description = '$item_description', link = '$link', image_link = '$image_link', mobile_link = '$mobile_link', additional_image_link = '$additional_image_link' , availability = '$availability', availability_date = '$availability_date',cost_of_goods_sold = '$cost_of_goods_sold ', expiration_date = '$expiration_date', price= '$price', sale_price= '$sale_price', sale_price_effective_date= '$sale_price_effective_date', unit_pricing_measure= '$unit_pricing_measure',  unit_pricing_base_measure= '$unit_pricing_base_measure',installment= '$installment',  subscription_cost= '$subscription_cost',loyalty_points= '$loyalty_points',google_product_category= '$google_product_category', product_type= '$product_type', brand= '$brand', gtin= '$gtin', mpn= '$mpn', identifier_exists= '$identifier_exists',item_condition = '$item_condition',adult = '$adult', multipack = '$multipack', is_bundle = '$is_bundle', age_group = '$age_group', color = '$color', gender = '$gender', material = '$material', pattern = '$pattern', google_size = '$google_size', size_type = '$size_type', size_system = '$size_system', itemgroup_id = '$itemgroup_id', ads_redirect = '$ads_redirect', custom_label = '$custom_label', promotion_id = '$promotion_id', excluded_destination = '$excluded_destination', included_destination = '$included_destination', shipping = '$shipping', shipping_label = '$shipping_label', shipping_weight = '$shipping_weight', shipping_length = '$shipping_length', shipping_width = '$shipping_width', shipping_height = '$shipping_height', transmit_time_label = '$transmit_time_label', max_handling_time = '$max_handling_time', min_handling_time = '$min_handling_time', tax = '$tax', tax_category = '$tax_category', energy_efficiency_class = '$energy_efficiency_class', min_energy_efficiency_class = '$min_energy_efficiency_class', max_energy_efficiency_class = '$max_energy_efficiency_class', active = 'true' ") or die($data->error);
    $message = "Google Shop Data Entry Completed";
    echo "<script type='text/javascript'>alert('$message');</script>";

}


?>
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

<!--<script>-->
<!---->
<!--    $(function(){-->
<!--        $(".img-browser").on('click',function(){-->
<!--            var itemsbefor = $(this).data('setter');-->
<!--            $("#myModalAS .modal-title").html('Select an Image For Link');-->
<!--            $("#myModalAS .modal-body").html('<iframe id="themedia" style="width: 100%; height: 450px; border: none" src="../../media_manager.php?typeset=simple&returntarget='+itemsbefor+'"></iframe>');-->
<!--            $(".modal-dialog").css('width','869px');-->
<!--            $("#myModalAS").modal();-->
<!--        })-->
<!---->
<!--        $('#page_desc').keyup(function () {-->
<!--            var left = 300 - $(this).val().length;-->
<!--            if (left < 0) {-->
<!--                left = 0;-->
<!--            }-->
<!--            $('.counter-text').text('Characters left: ' + left);-->
<!--        });-->
<!---->
<!--        tinymce.init({-->
<!--            selector: ".summernote",-->
<!--            skin: "caffiene",-->
<!--            plugins: [-->
<!--                "advlist autolink link image lists charmap print preview hr anchor pagebreak",-->
<!--                "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",-->
<!--                "table contextmenu directionality emoticons paste textcolor codemirror"-->
<!--            ],-->
<!--            content_css : '../css/bootstrap.css, assets/css/helpers.css',-->
<!---->
<!--            contextmenu: "link image | myitem",-->
<!--            setup: function(editor) {-->
<!--                editor.addMenuItem('myitem', {-->
<!--                    text: 'Open Content',-->
<!--                    onclick: function() {-->
<!--                        var beanName = editor.selection.getContent();-->
<!---->
<!---->
<!--                        ///MINIMOD edit-content.php?id=3&minimod=true///-->
<!--                        $.ajax({-->
<!--                            url: 'inc/asyncCalls.php?action=minimod&beanid='+beanName,-->
<!--                            success: function(data){-->
<!--                                $("#myModal .modal-body").html(data);-->
<!--                                $("#myModal").modal();-->
<!--                                $(".modal-dialog").css('width','70%');-->
<!---->
<!--                            }-->
<!--                        })-->
<!--                    }-->
<!--                });-->
<!--            },-->
<!--            file_browser_callback: function(field_name, url, type, win) {-->
<!--                setplacer(field_name,url);-->
<!--            },-->
<!--            image_description: true,-->
<!--            verify_html: false,-->
<!--            toolbar1: "styleselect  bold italic underline alignleft aligncenter alignright alignjustify  bullist numlist outdent indent link unlink responsivefilemanager image media fontsizeselect forecolor backcolor code",-->
<!--            menubar:false,-->
<!--            image_advtab: true ,-->
<!--            height: '400',-->
<!--            forced_root_block: false,-->
<!--            image_dimensions: false,-->
<!--            image_class_list: [-->
<!--                {title: 'Responsive', value: 'img-responsive'},-->
<!--                {title: 'Image 100% Width', value: 'img-full-width'}-->
<!--            ],-->
<!--            // style_formats: [-->
<!--            //     { width: 'Bold text', inline: 'strong' },-->
<!--            //     { title: 'Red text', inline: 'span', styles: { color: '#ff0000' } },-->
<!--            //     { title: 'Red header', block: 'h1', styles: { color: '#ff0000' } },-->
<!--            //     { title: 'Badge', inline: 'span', styles: { display: 'inline-block', border: '1px solid #2276d2', 'border-radius': '5px', padding: '2px 5px', margin: '0 2px', color: '#2276d2' } },-->
<!--            //     { title: 'Table row 1', selector: 'tr', classes: 'tablerow1' }-->
<!--            // ],-->
<!--            codemirror: {-->
<!--                indentOnInit: true,-->
<!--                path: 'codemirror-4.8',-->
<!--                config: {-->
<!--                    lineNumbers: true,-->
<!--                    mode: "htmlmixed",-->
<!--                    autoCloseTags: true,-->
<!---->
<!--                }-->
<!--            },-->
<!--            //external_plugins: { "filemanager" : "responsive_filemanager/filemanager/plugin.min.js"}-->
<!--        });-->
<!--    })-->
<!--</script>-->