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
$modFolder = 'installed_beans/custom_plugin';
include('functions.php');
$custom = new customClass();

include('../../inc/caffeine.php');
$site = new caffeine();
?>

<!-- Modal -->

<div id="myModal" class="modal" tabindex="-1" role="dialog">
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

            </div>
        </div>
    </div>
</div>

<div class="header">
    <h4 class="title">Create Custom Equipment Category</h4>
    <p class="category">Use this to create custom categories for equipment.</p>

    <div class="clearfix"></div>
</div>
<div class="content table-responsive table-full-width">
    <form class="validforms" id="page-layout" name="page-layout" style="padding: 20px" method="post" action="">
        <input class="form-control" type="hidden" name="line_type" id="line_type" value="custom">
        <label for="parent">Enter Parent Category</label><small>(Choose from the existing dropdown or add new)</small></br>
        <?php
        include('config.php');
        echo '<input list="parent1" id="parent" name="parent" style="width: 100%">
        <datalist id="parent1">';
        $result = $data->query("SELECT DISTINCT parent_cat FROM custom_equipment WHERE active = 'true'");
        foreach ($result as $row) {
            echo  '<option value="'.$row["parent_cat"].'"/>'; // Format for adding options
}
        echo "</datalist>";
        ?>
    </br></br>
        <label>Child Category</label><small>(Choose from the existing dropdown or add new)</small></br>
    <?php
    include('config.php');
    $catImg = $_POST["cat_img"];
    echo '<input class="form-control" list="child1" id="child" name="child" style="width: 100%">
        <datalist id="child1">';
    $result1 = $data->query("SELECT DISTINCT cat_one FROM custom_equipment WHERE active = 'true'");
    foreach ($result1 as $row) {
        echo  '<option value="'.$row["cat_one"].'"/>'; // Format for adding options
    }
    echo "</datalist>";
    ?>
    </br>
        <label>Title</label><br>
        <input class="form-control" type="text" id="title" name="title" value="" required=""><br>
        <label>Description</label><small>(Character Limit: 300)</small><br>
        <input class="form-control" type="text" id="features" name="features" value="" required=""><br>
        <label>MSRP</label><small>(Integers Only)</small><br>
        <input class="form-control" type="text" id="msrp" name="msrp" value="" required=""><br>
        <label>Sales Price</label><small>(Integers Only)</small><br>
        <input class="form-control" type="text" id="price" name="price" value="" required=""><br>
        <label>Category Image</label><small>(Ex: hello.png. Select an image and remove url path)</small><br>
        <div class="input-group mb-3">
            <input type="text" class="form-control" name="cat_img" id="cat_img" placeholder="No Image" aria-label="Category Image" value="<?php echo $catImg; ?>">
            <div class="input-group-append">
                <button class="btn btn-success img-browser" data-setter="cat_img" type="button">Browse Images</button>
            </div>
        </div>
        <br><label>Specs</label><br>
        <br><textarea class="summernotes" id="description" name="description"></textarea><br><br>
        <button class="btn btn-success" id="submit" name="submit">Save Page</button>
    </form>
</div>

<?php
include('config.php');

$parent = $_POST["parent"];
$child = $_POST["child"];
$title = $_POST["title"];
$description = $_POST["description"];
$msrp = $_POST["msrp"];
$price = $_POST["price"];
$img = $_POST["cat_img"];
$features = $_POST["features"];

if(isset($_POST['submit'])) {
    $data->query("INSERT INTO custom_equipment SET id= '', parent_cat = '$parent', cat_one = '$child', title = '$title', description = '$description', eq_image = '\[\"$img\"\]', msrp = '$msrp' , sales_price = '$price',features = '$features', active= 'true' ") or die($data->error);
    $message = "Custom Equipments Data Entry Completed";
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