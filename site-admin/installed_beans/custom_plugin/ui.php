<?php
header('Content-Type: text/html; charset=utf-8');
include('../../inc/caffeine.php');
$site = new caffeine();
$userArray = $site->auth();

?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">

    <title>Hello, world!</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../../codemirror/lib/codemirror.css" />
    <link rel="stylesheet" href="../../codemirror/theme/mbo.css">
    <link href="../../assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="../../plugins/sweet-alert/sweetalert2.min.css" rel="stylesheet">
    <link href="https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css" rel="stylesheet" />
    <style>
        * {
            box-sizing: border-box
        }

        /* Style the tab */
        .tab {
            float: left;
            border: 1px solid #ccc;
            background-color: #f1f1f1;
            width: 100%;
        }

        /* Style the buttons that are used to open the tab content */
        .tab button {
            display: block;
            background-color: inherit;
            color: black;
            padding: 13px 16px;
            width: 100%;
            border: none;
            outline: none;
            text-align: left;
            cursor: pointer;
            transition: 0.3s;
            border-bottom: solid thin #c0c0c0;
        }

        /* Change background color of buttons on hover */
        .tab button:hover {
            background-color: #ddd;
        }

        /* Create an active/current "tab button" class */
        .tab button.active {
            background-color: #ccc;
        }

        /* Style the tab content */
        .tabcontent {
            float: left;
            padding: 0px 12px;
            border: 1px solid #ccc;
            width: 70%;
            border-left: none;
            height: 300px;
        }

        .tablinks {
            font-weight: bold;
        }

        .modal-dialog {
            width: 90%;
            margin: 1.75rem auto;
        }

        .modal-lg,
        .modal-xl {
            max-width: 100%;
        }

        .mt-50 {
            margin-top: 50px
        }

        .mb-50 {
            margin-bottom: 50px
        }

        .card {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(0, 0, 0, .125);
            border-radius: .1875rem
        }

        .card-img-actions {
            position: relative
        }

        .card-body {
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            padding: 1.25rem;
            text-align: center
        }

        .card-title {
            margin-top: 10px;
            font-size: 17px
        }

        .invoice-color {
            color: #000000 !important
        }

        .card-header {
            padding: .9375rem 1.25rem;
            margin-bottom: 0;
            background-color: rgba(0, 0, 0, .02);
            border-bottom: 1px solid rgba(0, 0, 0, .125)
        }

        a {
            text-decoration: none !important
        }

        .btn-light {
            color: #333;
            background-color: #fafafa;
            border-color: #ddd
        }

        .header-elements-inline {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-pack: justify;
            justify-content: space-between;
            -ms-flex-wrap: nowrap;
            flex-wrap: nowrap
        }

        @media (min-width: 768px) {
            .wmin-md-400 {
                min-width: 400px !important
            }
        }

        .btn-primary {
            color: #fff;
            background-color: #2196f3
        }

        .btn-labeled>b {
            position: absolute;
            top: -1px;
            background-color: blue;
            display: block;
            line-height: 1;
            padding: .62503rem
        }

        .dropdown-item {
            cursor: pointer;
        }

        @media print {

            .no-print,
            .no-print * {
                display: none !important;
            }
        }

        .prodblox {
            font-size: 15px;
            margin: 3px;
        }

        .fa-window-close {
            color: #a80303;
        }

        .inpcontainer {
            display: block;
            position: relative;
            margin-bottom: 12px;
            cursor: pointer;
            font-size: 22px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        /* Hide the browser's default checkbox */
        .inpcontainer input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }

        /* Create a custom checkbox */
        .checkmark {
            position: absolute;
            top: -7px;
            left: 50%;
            margin-left: -18%;
            height: 25px;
            width: 25px;
            background-color: #eee;
            border: solid thin #d3d3d3;
        }

        /* On mouse-over, add a grey background color */
        .inpcontainer:hover input~.checkmark {
            background-color: #ccc;
        }

        /* When the checkbox is checked, add a blue background */
        .inpcontainer input:checked~.checkmark {
            background-color: #2196F3;
        }

        /* Create the checkmark/indicator (hidden when not checked) */
        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        /* Show the checkmark when checked */
        .inpcontainer input:checked~.checkmark:after {
            display: block;
        }

        /* Style the checkmark/indicator */
        .inpcontainer .checkmark:after {
            left: 9px;
            top: 5px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 3px 3px 0;
            -webkit-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            transform: rotate(45deg);
        }

        .dragsa {
            cursor: move;
        }

        .catblox {
            font-size: 15px;
            margin: 3px;
        }

        .error {
            color: red;
        }

        .ui-sortable-helper {
            display: table;
        }

        .attrdrg {
            background: #fff;
        }

        .attrbx {
            border: dashed thin #b4b4b4;
        }
    </style>
</head>

<body style="padding: 10px">

    <div id="infopan" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Large modal</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
            </div>
        </div>
    </div>

    <div id="myModalAS" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Large modal</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
            </div>
        </div>
    </div>

    <h1>EQ Commerce</h1>
    <p>Modify Categories, Products & Settings</p>
    <br>


    <div class="row" style="margin: 0">
        <div class="col-md-2">
            <div class="tab">
                <button class="tablinks active" onclick="openOrders()"><i style="font-size: 20px" class="fa fa-money" aria-hidden="true"></i> &nbsp;&nbsp; Orders</button>
                <button class="tablinks" onclick="editHomePage()"><i class="fa fa-home" aria-hidden="true"></i> &nbsp;&nbsp; Home Page</button>
                <button class="tablinks" onclick="pullCategories()"><i class="fa fa-list-ul" aria-hidden="true"></i> &nbsp;&nbsp; Categories</button>
                <button class="tablinks" onclick="pullProducts()"><i style="font-size: 20px" class="fa fa-tag" aria-hidden="true"></i> &nbsp;&nbsp; Products</button>
                <button class="tablinks" onclick="pullShipping()"><i class="fa fa-share" aria-hidden="true"></i> &nbsp;&nbsp; Shipping</button>
                <button class="tablinks" onclick="openTax()"><i class="fa fa-percent" aria-hidden="true"></i> &nbsp;&nbsp; Tax Settings</button>
                <button class="tablinks" onclick="openPayments()"><i class="fa fa-address-card-o" aria-hidden="true"></i> &nbsp;&nbsp; Payments API's</button>
                <button class="tablinks" onclick="coupon_settings()"><i class="fa fa-ticket" aria-hidden="true"></i> &nbsp;&nbsp; Coupons</button>
                <button class="tablinks" onclick="receipt_settings()"><i class="fa fa-file-text-o" aria-hidden="true"></i> &nbsp;&nbsp; Receipt Settings</button>
                <button class="tablinks" onclick="OpenLogs()"><i class="fa fa-file-text-o" aria-hidden="true"></i> &nbsp;&nbsp; Logs</button>
            </div>
        </div>
        <div class="col-md-10 eqpurchasecontent">

        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js" integrity="" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script type="text/JavaScript" src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.6.0/jQuery.print.js"></script>

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
    <script src="jquery.minicolors.js"></script>
    <script type="text/javascript" src="jquery.autoresize.js"></script>
    <script type="text/javascript" src="jquery.inline-edit.js"></script>


    <script>
        $(function() {
            openOrders();
            $('.tablinks').on('click', function() {
                $('.tablinks').removeClass('active');
                $(this).addClass('active');
            })
        })

        function openOrders() {
            $.ajax({
                url: 'ajaxfile.php?action=orders',
                cache: false,
                success: function(data) {
                    $(".eqpurchasecontent").html(data);
                    $('#example').DataTable();
                }
            })
        }


        function editHomePage() {
            $.ajax({
                url: 'ajaxfile.php?action=homepageedit',
                cache: false,
                success: function(data) {
                    $(".eqpurchasecontent").html(data);
                }
            })
        }

        function reviewOrder(orderid) {
            $.ajax({
                url: 'ajaxfile.php?action=pullorder&orderid=' + orderid,
                cache: false,
                success: function(data) {
                    $(".modal-body").html(data);
                    $(".modal-header").html(' <h4 class="modal-title" id="myLargeModalLabel">Review Order</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>');

                    //INIT THINGS THAT GO CLICK IN THE NIGHT//
                    $(".itemstattus").on('click', function() {
                        var theStat = $(this).data('stat');
                        $.ajax({
                            url: 'ajaxfile.php?action=updatestatus&status=' + theStat + '&orderid=' + orderid,
                            cache: false,
                            success: function(data) {
                                $(".currstat").html(theStat);
                            }
                        })
                    })
                }
            })
        }

        function printSales() {
            $(".hidbutton").hide();
            $(".sales_order").print();
        }

        function deleteOrder(orderid) {
            $(".eqcomnotice").html('<b>Are you sure you want to delete this Sales Receipt?</b><br><p>NOTICE! - Deleting sales receipt will not refund the purchase amount to the customer.<br>This will need to be done within your payment processor. e.g. (Elavon, Stripe etc).</p> <br><button type="button" class="btn btn-secondary btn-sm" onclick="confirmDel()">Yes Delete</button> <button type="button" class="btn btn-light btn-sm" onclick="hidenotice()">Cancel</button>');
            $(".eqcomnotice").show();
        }

        function confirmDel() {
            var orderids = $("#orderids").val();
            $.ajax({
                url: 'ajaxfile.php?action=confirmdel&orderid=' + orderids,
                cache: false,
                success: function(data) {
                    $('#infopan .model-body').html('');
                    $(".modal-header").html('Title Here');
                    $('#infopan').modal('toggle');
                    openOrders();
                }
            })
        }

        function hidenotice() {
            $(".eqcomnotice").html('');
            $(".eqcomnotice").hide();
            $(".prodmess").html('');
            $(".prodmess").hide();
        }

        //DO CATEGORY THINGS//
        function pullCategories() {
            $.ajax({
                url: 'ajaxfile.php?action=getcategories',
                cache: false,
                success: function(data) {
                    $(".eqpurchasecontent").html(data);
                    $('#example').DataTable();
                }
            })
        }

        function createNewCat() {
            $.ajax({
                url: 'ajaxfile.php?action=createcustcat',
                cache: false,
                success: function(data) {
                    $(".eqpurchasecontent").html(data);
                    tinymce.remove();
                    tinymce.init({
                        selector: ".summernote",
                        skin: "caffiene",
                        plugins: [
                            "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                            "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
                            "table contextmenu directionality emoticons paste textcolor codemirror"
                        ],
                        content_css: '../css/bootstrap.css, assets/css/helpers.css',

                        contextmenu: "link image | myitem",
                        setup: function(editor) {
                            editor.addMenuItem('myitem', {
                                text: 'Open Content',
                                onclick: function() {
                                    var beanName = editor.selection.getContent();


                                    ///MINIMOD edit-content.php?id=3&minimod=true///
                                    $.ajax({
                                        url: 'inc/asyncCalls.php?action=minimod&beanid=' + beanName,
                                        success: function(data) {
                                            $("#myModal .modal-body").html(data);
                                            $("#myModal").modal();
                                            $(".modal-dialog").css('width', '70%');

                                        }
                                    })
                                }
                            });
                        },
                        file_browser_callback: function(field_name, url, type, win) {
                            setplacer(field_name, url);
                        },
                        image_description: true,
                        verify_html: false,
                        toolbar1: "styleselect  bold italic underline alignleft aligncenter alignright alignjustify  bullist numlist outdent indent link unlink responsivefilemanager image media fontsizeselect forecolor backcolor code",
                        menubar: false,
                        image_advtab: true,
                        height: '400',
                        forced_root_block: false,
                        image_dimensions: false,
                        image_class_list: [{
                                title: 'Responsive',
                                value: 'img-responsive'
                            },
                            {
                                title: 'Image 100% Width',
                                value: 'img-full-width'
                            }
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

                    initMedia();

                    //capture form submit stuff//

                    $("#createcategory").validate({
                        submitHandler: function(form) {
                            $.ajax({
                                type: "POST",
                                url: "ajaxfile.php?action=savecat",
                                data: $(form).serialize(), // serializes the form's elements.
                                success: function(data) {
                                    //$(".theresults").html(data); // show response from the php script.
                                    var returnedData = JSON.parse(data);
                                    console.log("Selected Items: " + returnedData.items);
                                    $(".theresults").html(returnedData.message);
                                    if (returnedData.page_id != null) {
                                        if ($("#page_id").length) {
                                            //do nothing cause it already exist//
                                        } else {
                                            $("#createcategory").prepend('<input type="hidden" name="page_id" id="page_id" value="' + returnedData.page_id + '">');
                                        }
                                    }

                                    $('#content').contents().scrollTop();
                                    $("html, body").parent().scrollTop(0);
                                }
                            });
                        }
                    });

                    //init the viewtype buttons//
                    $(".viewtypbtn").on('click', function() {
                        var view = $(this).data('viewtype');
                        $("#view_type").val(view);
                        $(".viewtypbtn").removeClass('active');
                        $(this).addClass('active');
                    })

                }

            })
        }

        function editCat(id) {
            $.ajax({
                url: 'ajaxfile.php?action=editcustcat&catid=' + id,
                cache: false,
                success: function(data) {
                    $(".eqpurchasecontent").html(data);
                    tinymce.remove();
                    tinymce.init({
                        selector: ".summernote",
                        skin: "caffiene",
                        plugins: [
                            "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                            "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
                            "table contextmenu directionality emoticons paste textcolor codemirror"
                        ],
                        content_css: '../css/bootstrap.css, assets/css/helpers.css',

                        contextmenu: "link image | myitem",
                        setup: function(editor) {
                            editor.addMenuItem('myitem', {
                                text: 'Open Content',
                                onclick: function() {
                                    var beanName = editor.selection.getContent();


                                    ///MINIMOD edit-content.php?id=3&minimod=true///
                                    $.ajax({
                                        url: 'inc/asyncCalls.php?action=minimod&beanid=' + beanName,
                                        success: function(data) {
                                            $("#myModal .modal-body").html(data);
                                            $("#myModal").modal();
                                            $(".modal-dialog").css('width', '70%');

                                        }
                                    })
                                }
                            });
                        },
                        file_browser_callback: function(field_name, url, type, win) {
                            setplacer(field_name, url);
                        },
                        image_description: true,
                        verify_html: false,
                        toolbar1: "styleselect  bold italic underline alignleft aligncenter alignright alignjustify  bullist numlist outdent indent link unlink responsivefilemanager image media fontsizeselect forecolor backcolor code",
                        menubar: false,
                        image_advtab: true,
                        height: '400',
                        forced_root_block: false,
                        image_dimensions: false,
                        image_class_list: [{
                                title: 'Responsive',
                                value: 'img-responsive'
                            },
                            {
                                title: 'Image 100% Width',
                                value: 'img-full-width'
                            }
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

                    initMedia();

                    //capture form submit stuff//

                    $("#createcategory").validate({
                        submitHandler: function(form) {
                            $.ajax({
                                type: "POST",
                                url: "ajaxfile.php?action=savecat",
                                data: $(form).serialize(), // serializes the form's elements.
                                success: function(data) {
                                    //$(".theresults").html(data); // show response from the php script.
                                    var returnedData = JSON.parse(data);
                                    $(".theresults").html(returnedData.message);
                                    if (returnedData.page_id != null) {
                                        if ($("#page_id").length) {
                                            //do nothing cause it already exist//
                                        } else {
                                            $("#createcategory").prepend('<input type="hidden" name="page_id" id="page_id" value="' + returnedData.page_id + '">');
                                        }
                                    }

                                    $('#content').contents().scrollTop();
                                    $("html, body").parent().scrollTop(0);
                                }
                            });
                        }
                    });

                    //init the viewtype buttons//
                    $(".viewtypbtn").on('click', function() {
                        var view = $(this).data('viewtype');
                        $("#view_type").val(view);
                        $(".viewtypbtn").removeClass('active');
                        $(this).addClass('active');
                    })

                }

            })
        }

        function getProdsAndCats() {
            var getItems = [];

            $(".selecteditems > .draggable").each(function() {
                if ($(this).data('prodids') != undefined) {
                    getItems.push({
                        type: 'prod',
                        id: $(this).data('prodids')
                    });
                } else {
                    getItems.push({
                        type: 'cat',
                        id: $(this).data('catids')
                    });
                }
            })

            console.log(getItems);
            return JSON.stringify(getItems);
        }

        //process added items//
        function getSelection() {
            var getItems = [];
            $(".product-holder > .draggable").each(function() {
                if ($(this).data('prodids') != undefined) {
                    getItems.push({
                        type: 'prod',
                        id: $(this).data('prodids')
                    });
                } else {
                    getItems.push({
                        type: 'cat',
                        id: $(this).data('catids')
                    });
                }
            })

            console.log(getItems);
            $("#selecteditems").val(JSON.stringify(getItems));
        }

        function openProds() {
            var getChecks = []
            $(".prodblox").each(function(i) {
                getChecks[i] = $(this).data('prodids');
            })

            $.ajax({
                type: "POST",
                url: 'ajaxfile.php?action=openprods',
                cache: false,
                data: {
                    checkdata: getChecks
                },
                success: function(msg) {
                    $("#myModalAS .modal-body").html('<div>' + msg + '</div>');
                    $("#myModalAS .modal-title").html('Add Products');
                    $("#myModalAS").modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $("#myModalAS .modal-dialog").css('width', '70%');
                    $('#products').DataTable({
                        "drawCallback": function(settings) {
                            initChecks();
                        }
                    });
                    $('html, body', window.parent.document).animate({
                        scrollTop: 0
                    }, 'slow');
                }
            })
        }

        function initDrag() {
            $(".droparea").sortable({
                containment: "parent",
                handle: ".dragsa",
                stop: function(event, ui) {
                    getSelection();
                }
            });

        }


        function initChecks() {
            var $chkboxes = $('.prodoptions');
            var lastChecked = null;

            $chkboxes.click(function(e) {
                if (!lastChecked) {
                    lastChecked = this;
                    return;
                }

                if (e.shiftKey) {
                    var start = $chkboxes.index(this);
                    var end = $chkboxes.index(lastChecked);

                    $chkboxes.slice(Math.min(start, end), Math.max(start, end) + 1).prop('checked', lastChecked.checked);
                }

                lastChecked = this;
            });
        }

        function initChecksCat() {
            var $chkboxes = $('.catoptions');
            var lastChecked = null;

            $chkboxes.click(function(e) {
                if (!lastChecked) {
                    lastChecked = this;
                    return;
                }

                if (e.shiftKey) {
                    var start = $chkboxes.index(this);
                    var end = $chkboxes.index(lastChecked);

                    $chkboxes.slice(Math.min(start, end), Math.max(start, end) + 1).prop('checked', lastChecked.checked);
                }

                lastChecked = this;
            });
        }

        function OpenLogs() {
            $.ajax({
                url: 'ajaxfile.php?action=openlogs',
                cache: false,
                success: function(data) {
                    $(".eqpurchasecontent").html(data);
                }
            })
        }

        function openCats() {
            $.ajax({
                url: 'ajaxfile.php?action=opencats',
                cache: false,
                success: function(data) {
                    $("#myModalAS .modal-body").html('<div>' + data + '</div>');
                    $("#myModalAS .modal-title").html('Add Category');
                    $("#myModalAS").modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $("#myModalAS .modal-dialog").css('width', '70%');
                    $('#products').DataTable();
                }
            })
        }

        function findValueInArray(value, arr) {
            var result = "Doesn't exist";

            for (var i = 0; i < arr.length; i++) {
                var name = arr[i];
                if (name == value) {
                    result = 'Exist';
                    break;
                }
            }
            return result;
        }

        function arr_diff(a1, a2) {
            var a = [],
                diff = [];
            for (var i = 0; i < a1.length; i++) {
                a[a1[i]] = true;
            }
            for (var i = 0; i < a2.length; i++) {
                if (a[a2[i]]) {
                    delete a[a2[i]];
                } else {
                    a[a2[i]] = true;
                }
            }
            for (var k in a) {
                diff.push(k);
            }
            return diff;
        }


        function getSelectedProducts() {
            var getChecks = []
            $(".prodblox").each(function(i) {
                getChecks[i] = $(this).data('prodids');
            })


            var oTable = $('#products').dataTable();
            var rowcollection = oTable.$(".prodoptions:checked", {
                "page": "all"
            });

            var getMarks = []
            $(rowcollection).each(function(i) {
                getMarks[i] = $(this).val();
            })

            //BUILD ARRAY DATA///
            rowcollection.each(function(index, elem) {
                var checkbox_value = $(elem).val();
                var prodname = $(elem).data('prodname');
                if (findValueInArray(checkbox_value, getChecks) == 'Exist') {
                    ///DO NOTHING BECAUSE WE DO NOT WANT THE ARRAY PUSH TO MODIFY THE DRAGGABLE ORDER OF PRODUCTS///
                    var absent = arr_diff(getChecks, getMarks);
                    $(absent).each(function(i) {
                        if (findValueInArray(absent[i], getChecks) == 'Exist') {
                            $('span[data-prodids=' + absent[i] + ']').remove();
                        } else {
                            //NO NEED TO DO ANYTHING//
                        }
                    })
                } else {
                    $(".product-holder").append('<span class="badge badge-light prodblox draggable" data-prodids="' + checkbox_value + '"><i style="color: #e3e3e3;padding: 3px;" class="fa fa-th dragsa" aria-hidden="true"></i> ' + prodname + ' <i class="fa fa-window-close closeitem" data-prodids="' + checkbox_value + '" aria-hidden="true"></i></span>');

                }

            });

            initDrag();
            $('.closeitem').on('click', function() {
                var itemId = $(this).data('prodids');
                $(this).parent().remove();

            })

            getSelection();
        }

        function openCatz() {
            var getChecks = []
            $(".catblox").each(function(i) {
                getChecks[i] = $(this).data('catids');
            })

            $.ajax({
                type: "POST",
                url: 'ajaxfile.php?action=opencats',
                cache: false,
                data: {
                    checkdata: getChecks
                },
                success: function(msg) {
                    $("#myModalAS .modal-body").html('<div>' + msg + '</div>');
                    $("#myModalAS .modal-title").html('Add Category');
                    $("#myModalAS").modal();
                    $("#myModalAS .modal-dialog").css('width', '70%');
                    $('#cateogries').DataTable({
                        "drawCallback": function(settings) {
                            initChecksCat();
                        }
                    });
                    $('html, body', window.parent.document).animate({
                        scrollTop: 0
                    }, 'slow');
                }
            })
        }

        function getSelectedCategories() {
            var getChecks = []
            $(".catblox").each(function(i) {
                getChecks[i] = $(this).data('catids');
            })


            var oTable = $('#cateogries').dataTable();
            var rowcollection = oTable.$(".catoptions:checked", {
                "page": "all"
            });

            var getMarks = []
            $(rowcollection).each(function(i) {
                getMarks[i] = $(this).val();
            })


            //BUILD ARRAY DATA///
            rowcollection.each(function(index, elem) {
                var checkbox_value = $(elem).val();
                var catname = $(elem).data('catname');
                if (findValueInArray(checkbox_value, getChecks) == 'Exist') {
                    ///DO NOTHING BECAUSE WE DO NOT WANT THE ARRAY PUSH TO MODIFY THE DRAGGABLE ORDER OF PRODUCTS///
                    var absent = arr_diff(getChecks, getMarks);
                    $(absent).each(function(i) {
                        if (findValueInArray(absent[i], getChecks) == 'Exist') {
                            $('span[data-catids=' + absent[i] + ']').remove();
                        } else {
                            //NO NEED TO DO ANYTHING//
                        }
                    })
                } else {
                    $(".product-holder").append('<span class="badge badge-secondary catblox draggable" data-catids="' + checkbox_value + '"><i style="color: #e3e3e3;padding: 3px;" class="fa fa-th dragsa" aria-hidden="true"></i> ' + catname + ' <i class="fa fa-window-close closeitem" data-catids="' + checkbox_value + '" aria-hidden="true"></i></span>');
                }

            });

            initDrag();
            $('.closeitem').on('click', function() {
                var itemId = $(this).data('prodids');
                $(this).parent().remove();

            })

            getSelection();
        }

        function pullProducts() {
            $.ajax({
                url: 'ajaxfile.php?action=getproducts',
                cache: false,
                success: function(data) {
                    console.log(data);
                    $(".eqpurchasecontent").html(data);
                    $('#example').DataTable();
                }
            })
        }

        function createProduct() {
            $.ajax({
                url: 'ajaxfile.php?action=createproduct',
                cache: false,
                success: function(data) {
                    $(".eqpurchasecontent").html(data);
                    tinymce.remove();
                    tinymce.init({
                        selector: ".summernote",
                        skin: "caffiene",
                        plugins: [
                            "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                            "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
                            "table contextmenu directionality emoticons paste textcolor codemirror"
                        ],
                        content_css: '../css/bootstrap.css, assets/css/helpers.css',

                        contextmenu: "link image | myitem",
                        setup: function(editor) {
                            editor.addMenuItem('myitem', {
                                text: 'Open Content',
                                onclick: function() {
                                    var beanName = editor.selection.getContent();


                                    ///MINIMOD edit-content.php?id=3&minimod=true///
                                    $.ajax({
                                        url: 'inc/asyncCalls.php?action=minimod&beanid=' + beanName,
                                        success: function(data) {
                                            $("#myModal .modal-body").html(data);
                                            $("#myModal").modal();
                                            $(".modal-dialog").css('width', '70%');

                                        }
                                    })
                                }
                            });
                        },
                        file_browser_callback: function(field_name, url, type, win) {
                            setplacer(field_name, url);
                        },
                        image_description: true,
                        verify_html: false,
                        toolbar1: "styleselect  bold italic underline alignleft aligncenter alignright alignjustify  bullist numlist outdent indent link unlink responsivefilemanager image media fontsizeselect forecolor backcolor code",
                        menubar: false,
                        image_advtab: true,
                        height: '200',
                        forced_root_block: false,
                        image_dimensions: false,
                        image_class_list: [{
                                title: 'Responsive',
                                value: 'img-responsive'
                            },
                            {
                                title: 'Image 100% Width',
                                value: 'img-full-width'
                            }
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

                    initMedia();

                    $("#product_type").on('change', function() {
                        if ($(this).val() == 'digital') {
                            $(".shipping_properties").hide();
                            $(".digital_properties").show();
                        } else {
                            $(".shipping_properties").show();
                            $(".digital_properties").hide();
                        }
                    })


                    $('#delivery_type').on('change', function() {
                        $(".delivery_options").hide();
                        if ($(this).val() == 'flat_rate') {
                            $(".flat_option").show();
                        }

                        if ($(this).val() == 'pickup_only') {
                            $(".pickup_option").show();
                        }

                        if ($(this).val() == 'api_system') {
                            $(".system_option").show();
                        }
                    })

                    //capture form submit stuff//

                    $("#newproductadd").validate({
                        submitHandler: function(form) {
                            $.ajax({
                                type: "POST",
                                url: "ajaxfile.php?action=createproductfin",
                                data: $(form).serialize(), // serializes the form's elements.
                                success: function(data) {
                                    var returnedData = JSON.parse(data);

                                    $(".prodmess").html(returnedData.message);
                                    if ($('#prod_id').val()) {
                                        //DO NOTHING CAUSE IT EXIST//
                                    } else {
                                        $("#newproductadd").prepend('<input type="hidden" name="prod_id" id="prod_id" value="' + returnedData.prod_id + '">');
                                        $(".prosubbutton").text('Update Product');
                                    }
                                }
                            });
                        }
                    });

                }

            })
        }

        function editProduct(prodid) {
            $.ajax({
                url: 'ajaxfile.php?action=editproduct&prod_id=' + prodid,
                cache: false,
                success: function(data) {
                    $(".eqpurchasecontent").html(data);
                    tinymce.remove();
                    tinymce.init({
                        selector: ".summernote",
                        skin: "caffiene",
                        plugins: [
                            "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                            "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
                            "table contextmenu directionality emoticons paste textcolor codemirror"
                        ],
                        content_css: '../css/bootstrap.css, assets/css/helpers.css',

                        contextmenu: "link image | myitem",
                        setup: function(editor) {
                            editor.addMenuItem('myitem', {
                                text: 'Open Content',
                                onclick: function() {
                                    var beanName = editor.selection.getContent();


                                    ///MINIMOD edit-content.php?id=3&minimod=true///
                                    $.ajax({
                                        url: 'inc/asyncCalls.php?action=minimod&beanid=' + beanName,
                                        success: function(data) {
                                            $("#myModal .modal-body").html(data);
                                            $("#myModal").modal();
                                            $(".modal-dialog").css('width', '70%');

                                        }
                                    })
                                }
                            });
                        },
                        file_browser_callback: function(field_name, url, type, win) {
                            setplacer(field_name, url);
                        },
                        image_description: true,
                        verify_html: false,
                        toolbar1: "styleselect  bold italic underline alignleft aligncenter alignright alignjustify  bullist numlist outdent indent link unlink responsivefilemanager image media fontsizeselect forecolor backcolor code",
                        menubar: false,
                        image_advtab: true,
                        height: '200',
                        forced_root_block: false,
                        image_dimensions: false,
                        image_class_list: [{
                                title: 'Responsive',
                                value: 'img-responsive'
                            },
                            {
                                title: 'Image 100% Width',
                                value: 'img-full-width'
                            }
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

                    initMedia();

                    $("#product_type").on('change', function() {
                        if ($(this).val() == 'digital') {
                            $(".shipping_properties").hide();
                            $(".digital_properties").show();
                        } else {
                            $(".shipping_properties").show();
                            $(".digital_properties").hide();
                        }
                    })


                    $('#delivery_type').on('change', function() {
                        $(".delivery_options").hide();
                        if ($(this).val() == 'flat_rate') {
                            $(".flat_option").show();
                        }

                        if ($(this).val() == 'pickup_only') {
                            $(".pickup_option").show();
                        }

                        if ($(this).val() == 'api_system') {
                            $(".system_option").show();
                        }
                    })

                    //capture form submit stuff//

                    $("#editproductadd").validate({
                        submitHandler: function(form) {
                            $.ajax({
                                type: "POST",
                                url: "ajaxfile.php?action=createproductfin",
                                data: $(form).serialize(), // serializes the form's elements.
                                success: function(data) {
                                    var returnedData = JSON.parse(data);

                                    $(".prodmess").html(returnedData.message);
                                    $('html, body', window.parent.document).scrollTop(0);
                                    $("html, body").scrollTop(0);
                                    if ($('#prod_id').val()) {
                                        //DO NOTHING CAUSE IT EXIST//
                                    } else {
                                        $("#newproductadd").prepend('<input type="hidden" name="prod_id" id="prod_id" value="' + returnedData.prod_id + '">');
                                        $(".prosubbutton").text('Update Product');
                                    }
                                    $('html, body', window.parent.document).animate({
                                        scrollTop: 0
                                    }, 'slow');
                                }
                            });
                        }
                    });

                    $(".ridattr").on('click', function() {
                        var attrrm = $(this).data('attrrm');
                        $('tr[data-attrids=' + attrrm + ']').remove();
                    })

                    $('html, body', window.parent.document).scrollTop(0);
                    $("html, body").scrollTop(0);

                }

            })
        }

        function openProdProps() {
            $.ajax({
                url: 'ajaxfile.php?action=moreprodopts',
                cache: false,
                success: function(data) {
                    $("#myModalAS .modal-body").html('<div>' + data + '</div>');
                    $("#myModalAS .modal-title").html('Product Options');
                    $("#myModalAS").modal({
                        backdrop: 'static',
                        keyboard: false
                    });

                    $("#myModalAS .modal-dialog").css('width', '70%');
                    $('#myModalAS').animate({
                        scrollTop: 0
                    }, 'slow');
                    $('html, body', window.parent.document).animate({
                        scrollTop: 0
                    }, 'slow');
                }
            })

        }


        function buildOutAttr() {

            var getChecks = []
            $(".attrblox").each(function(i) {
                getChecks[i] = $(this).data('attrids');
            })


            $.ajax({
                type: "POST",
                url: 'ajaxfile.php?action=selectattr',
                cache: false,
                data: {
                    checkdata: getChecks
                },
                success: function(msg) {
                    $("#myModalAS .modal-body").html('<div>' + msg + '</div>');
                    $("#myModalAS .modal-title").html('Product Attributes');
                    $("#myModalAS").modal({
                        backdrop: 'static',
                        keyboard: false
                    });

                    $("#myModalAS .modal-dialog").css('width', '70%');
                    $('#myModalAS').animate({
                        scrollTop: 0
                    }, 'slow');
                    $('html, body', window.parent.document).animate({
                        scrollTop: 0
                    }, 'slow');

                    $('#attrlist').DataTable({
                        "drawCallback": function(settings) {
                            //initChecksCat();

                        }
                    });

                    // $("#attradd").validate({
                    //     submitHandler: function(form) {
                    //
                    //     }
                    // });
                }
            })
        }

        function buildAttr() {
            $.ajax({
                url: 'ajaxfile.php?action=buildattrs_stepone',
                cache: false,
                success: function(data) {
                    $("#myModalAS .modal-body").html('<div>' + data + '</div>');
                    //attraddog

                    $("#attraddog").validate({
                        submitHandler: function(form) {
                            $.ajax({
                                type: "POST",
                                url: "ajaxfile.php?action=buildattrs_steptwo",
                                data: $(form).serialize(), // serializes the form's elements.
                                success: function(data) {
                                    var returnedData = JSON.parse(data);
                                    if (returnedData.status == 'good') {
                                        $("#myModalAS .modal-body").html('<div>' + returnedData.message + '</div>');
                                        // $('#attrtabs').DataTable();
                                        processEachAtt();
                                    } else {
                                        $('.sysmess').html(returnedData.message);
                                    }
                                }
                            });
                        }
                    });
                }
            })
        }

        function editAttr(attrid) {
            $.ajax({
                url: "ajaxfile.php?action=editattr&attrid=" + attrid,
                success: function(data) {
                    $("#myModalAS .modal-body").html('<div>' + data + '</div>');
                    // $('#attrtabs').DataTable();
                    $("#attrtabs tbody").sortable({
                        containment: "parent",
                        stop: function(event, ui) {
                            //getSelection();
                            const idsInOrder = $("#attrtabs tbody").sortable('toArray', {
                                attribute: 'data-id'
                            });

                            var parentid = $("#newgrp_id").val();

                            $.ajax({
                                url: 'ajaxfile.php?action=setattrorder',
                                type: "POST",
                                data: {
                                    'attrid_order': idsInOrder,
                                    'parent_id': parentid
                                },
                                success: function(data) {
                                    console.log(data);
                                }
                            })
                        }
                    });

                    $('.editable').inlineEdit({
                        defaultText: false,
                        hoverClass: 'attrbx',
                        onUpdate: function(val) {
                            var attrid = $(this).attr("data-attrid");
                            var subtype = $(this).attr("data-subtype");
                            $.ajax({
                                url: 'ajaxfile.php?action=modifyattrs_add',
                                type: "POST",
                                data: {
                                    'attrid': attrid,
                                    'attrtype': subtype,
                                    'updval': val
                                },
                                success: function(data) {
                                    console.log(val);
                                }
                            })
                            console.log(attrid);
                        }
                    });

                    $(".delbutton").on('click', function() {
                        var deleteID = $(this).data('delid');
                        $.ajax({
                            url: 'ajaxfile.php?action=deleteattrs&id=' + deleteID,
                            success: function(data) {
                                $(".attrtr_" + deleteID).remove();
                            }
                        })
                    })

                    processEachAtt();
                }
            });
        }

        function StartDeleteProd(id) {
            $(".prodmess").show();
            $(".prodmess").html('<div class="alert alert-warning"><p><b>Are you sure you want to delete this product?</b></p><button type="button" class="btn btn-secondary btn-sm mb-4" onclick="deleteProd(' + id + ')">Yes Delete</button> <button type="button" class="btn btn-light btn-sm mb-4" onclick="hidenotice()">Cancel</button></div>');
        }

        function StartDeleteCat(id) {
            console.log("Starting Delete Category: " + id);
            $(".prodmess").show();
            $(".prodmess").html('<div class="alert alert-warning"><p><b>Are you sure you want to delete this category?</b></p><button type="button" class="btn btn-secondary btn-sm mb-4" onclick="deleteCat(\'' + id + '\')">Yes Delete</button> <button type="button" class="btn btn-light btn-sm mb-4" onclick="hidenotice()">Cancel</button></div>');
        }

        function deleteCat(id) {
            $.ajax({
                url: 'ajaxfile.php?action=deletecategory&id=' + id,
                cache: false,
                success: function(data) {
                    var returnedData = JSON.parse(data);
                    pullCategories();
                    $(".prodmess").html(returnedData.message);
                }
            })
        }

        function deleteProd(id) {
            $.ajax({
                url: 'ajaxfile.php?action=deleteproduct&id=' + id,
                cache: false,
                success: function(data) {
                    var returnedData = JSON.parse(data);
                    $.ajax({
                        url: 'ajaxfile.php?action=getproducts',
                        cache: false,
                        success: function(data2) {
                            console.log(data);
                            $(".eqpurchasecontent").html(data2);
                            $('#example').DataTable();
                            $(".prodmess").html(returnedData.message);
                        }
                    })
                }
            })
        }

        function processEachAtt() {
            $("#attradd").validate({
                submitHandler: function(form) {
                    $.ajax({
                        type: "POST",
                        url: "ajaxfile.php?action=buildattrs_add",
                        data: $(form).serialize(), // serializes the form's elements.
                        success: function(data) {
                            $("#attr_name").val('');
                            $("#attr_value").val('');
                            $("#attr_price").val('');
                            $("#attrtid").val('');

                            $("#attr_name").focus();

                            //$('#attrtabs').DataTable().destroy();
                            $('#attrtabs tbody').append(data);
                            $("#attrtabs tbody").sortable({
                                containment: "parent",
                                stop: function(event, ui) {
                                    //getSelection();
                                }
                            });

                            $('.editable').inlineEdit({
                                defaultText: false,
                                onUpdate: function(val) {
                                    var attrid = $(this).attr("data-attrid");
                                    var subtype = $(this).attr("data-subtype");
                                    $.ajax({
                                        url: 'ajaxfile.php?action=modifyattrs_add',
                                        type: "POST",
                                        data: {
                                            'attrid': attrid,
                                            'attrtype': subtype,
                                            'updval': val
                                        },
                                        success: function(data) {
                                            console.log(val);
                                        }
                                    })
                                    console.log(attrid);
                                }
                            });


                            $(".attredits").on('click', function() {
                                var attid = $(this).data('attid');
                                var price = $(this).data('price');
                                var attrval = $(this).data('value');
                                var attrname = $(this).data('name');
                                $("#attr_name").val(attrname);
                                $("#attr_value").val(attrval);
                                $("#attr_price").val(price);
                                $("#attrtid").val(attid);
                            })

                            $(".delbutton").on('click', function() {
                                var deleteID = $(this).data('delid');
                                $.ajax({
                                    url: 'ajaxfile.php?action=deleteattrs&id=' + deleteID,
                                    success: function(data) {
                                        $(".attrtr_" + deleteID).remove();
                                    }
                                })

                            })
                        }
                    });
                }
            });
        }

        function deleteAttr(id) {
            $.ajax({
                url: 'ajaxfile.php?action=deleteattrs&id=' + id,
                cache: false,
                success: function(data) {
                    $.ajax({
                        url: 'ajaxfile.php?action=deleteattrs&id=' + id,
                        cache: false,
                        success: function(data) {

                        }
                    })
                }
            })
        }

        function getSelectedAttrs() {
            var getChecks = []
            $(".attrblox").each(function(i) {
                getChecks[i] = $(this).data('attrids');
            })


            var oTable = $('#attrlist').dataTable();
            var rowcollection = oTable.$(".attroptions:checked", {
                "page": "all"
            });

            var getMarks = []
            $(rowcollection).each(function(i) {
                getMarks[i] = $(this).val();
            })

            //BUILD ARRAY DATA///
            rowcollection.each(function(index, elem) {
                var checkbox_value = $(elem).val();
                var attrame = $(elem).data('attrame');
                var attritems = $(elem).data('inditems');
                if (findValueInArray(checkbox_value, getChecks) == 'Exist') {
                    ///DO NOTHING BECAUSE WE DO NOT WANT THE ARRAY PUSH TO MODIFY THE DRAGGABLE ORDER OF ATTRIBUTES///
                    var absent = arr_diff(getChecks, getMarks);
                    $(absent).each(function(i) {
                        if (findValueInArray(absent[i], getChecks) == 'Exist') {
                            $('tr[data-attrids=' + absent[i] + ']').remove();
                        } else {
                            //NO NEED TO DO ANYTHING//
                        }
                    })
                } else {
                    $(".attr_bholder").append('<tr class="attrblox draggable" data-attrids="' + checkbox_value + '"><td>' + attrame + '</td><td>' + attritems + '</td><td style="text-align: right"><button class="btn btn-sm btn-danger ridattr" data-attrrm="' + checkbox_value + '"><input type="hidden" name="attrsel[]" id="attrsel[]" value="' + checkbox_value + '"> <i class="fa fa-trash" aria-hidden="true"></i> Remove</button></td></tr>');

                }

            });

            initDrag();
            $('.closeitem').on('click', function() {
                var itemId = $(this).data('prodids');
                $(this).parent().remove();

            })

            $(".ridattr").on('click', function() {
                var attrrm = $(this).data('attrrm');
                $('tr[data-attrids=' + attrrm + ']').remove();
            })
        }

        function importpanel() {
            $.ajax({
                url: 'ajaxfile.php?action=importpanel',
                cache: false,
                success: function(data) {
                    $("#myModalAS .modal-body").html('<div>' + data + '</div>');

                    $("#importer").submit(function(evt) {
                        evt.preventDefault();
                        var formData = new FormData($(this)[0]);
                        $.ajax({
                            url: 'ajaxfile.php?action=importproducts',
                            type: 'POST',
                            data: formData,
                            processData: false, // tell jQuery not to process the data
                            contentType: false, // tell jQuery not to set contentType
                            success: function(data) {
                                console.log(data);
                            }
                        });
                        return false;
                    });
                }
            })
        }



        function initMedia() {
            $(".img-browser").on('click', function() {
                var itemsbefor = $(this).data('setter');
                console.log("Return Target: " + itemsbefor);
                $("#myModalAS .modal-title").html('Select an Image For Link');
                $("#myModalAS .modal-body").html('<iframe id="themedia" style="width: 100%; height: 450px; border: none" src="../../media_manager.php?typeset=simple&returntarget=' + itemsbefor + '"></iframe>');
                $("#myModalAS .modal-dialog").css('width', '70%');
                $("#myModalAS .modal-backdrop").css('z-index', '70000');
                $("#myModalAS").modal();
            })
        }

        function setplacer(ids, url) {
            $("#myModalAS .modal-body").html('<iframe src="../../media_manager.php?returntarget=' + ids + '" style="height:600px;width:100%; border: none"></iframe>');
            $("#myModalAS .modal-title").html('Media Browser');
            $("#myModalAS").modal();
            $("#myModalAS").css('z-index', '75541');
            $("#myModalAS .modal-dialog").css('width', '70%');
            $("#myModalAS .modal-backdrop").css('z-index', '70000');
            $('#myModalAS').contents().find('#mcefield').val('myValue');
        }

        function setImgDat(inputTarget, img, alttext) {
            //alert(inputTarget);
            // $('input[name="'+inputTarget+'"]').val(img);
            // $('input[name="alt"]').val(alttext);
            // $('input[name="'+inputTarget+'"]').focus();
            // $('input[name="alt"]').focus();
            var imgClean = img.replace("../../../../", "../");
            $('#' + inputTarget).val(imgClean);
            $("." + inputTarget).css('background-image', 'url("../../' + imgClean + '")');
            console.log(inputTarget);
            imgSucc();
        }

        function imgSucc() {
            $("#myModalAS").modal('hide');
        }

        function pullShipping() {
            $.ajax({
                url: 'ajaxfile.php?action=getshipping',
                cache: false,
                success: function(data) {
                    $(".eqpurchasecontent").html(data);
                    shippingActions();
                }
            })
        }

        function shippingActions() {
            $("#shiptyp").on('change', function() {
                if ($(this).val() != '') {
                    $(".tokenarea").show();
                }
            })
        }

        function saveShipToken() {
            var tokenid = $("#tokenid").val();
            var shiptyp = $("#shiptyp").val();
            var ship_usage = $("#ship_usage").val();
            $.ajax({
                url: 'ajaxfile.php?action=settoken&shiptype=' + shiptyp + '&token=' + tokenid + '&shipusage=' + ship_usage,
                success: function(data) {
                    var returnedData = JSON.parse(data);
                    $(".theresults").html(returnedData.message);
                    $('html, body', window.parent.document).animate({
                        scrollTop: 0
                    }, 'slow');
                }
            })
        }

        function openTax() {
            $.ajax({
                url: 'ajaxfile.php?action=taxsettings',
                cache: false,
                success: function(data) {
                    $(".eqpurchasecontent").html(data);
                }
            })
        }

        function updateTaxKey() {
            var ziptax = $("#ziptax").val();
            $.ajax({
                url: 'ajaxfile.php?action=finishtax&apival=' + ziptax,
                cache: false,
                success: function(data) {
                    var returnedData = JSON.parse(data);
                    $(".theresults").html(returnedData.message);
                    $('html, body', window.parent.document).animate({
                        scrollTop: 0
                    }, 'slow');
                }
            })
        }

        function openPayments() {
            $.ajax({
                url: 'ajaxfile.php?action=payment_gatways',
                cache: false,
                success: function(data) {
                    $(".eqpurchasecontent").html(data);
                    processPaySel();
                }
            })
        }

        function processPaySel() {
            $("#payment_api").on('change', function() {
                var select_val = $(this).val();

                $.ajax({
                    url: 'ajaxfile.php?action=paytypes&paytype=' + select_val,
                    cache: false,
                    success: function(data) {
                        $(".paydetails").html(data);
                    }
                })
            })

            //GET SELECTION IF ANY//
            var payment_api = $("#payment_api").val();
            if (payment_api != '') {

                $("#paymentsapis").submit(function(e) {

                    e.preventDefault(); // avoid to execute the actual submit of the form.

                    var form = $(this);

                    $.ajax({
                        type: "POST",
                        url: 'ajaxfile.php?action=savepayment_api',
                        data: $(form).serialize(), // serializes the form's elements.
                        success: function(data) {
                            var returnedData = JSON.parse(data);
                            $(".theresults").html(returnedData.message);
                            $('html, body', window.parent.document).animate({
                                scrollTop: 0
                            }, 'slow');
                        }
                    });

                });

                $.ajax({
                    url: 'ajaxfile.php?action=paytypes&paytype=' + payment_api,
                    cache: false,
                    success: function(data) {
                        $(".paydetails").html(data);
                    }
                });
            }

        }

        //SYSTEM SETTINGS//
        function coupon_settings() {
            $.ajax({
                url: 'ajaxfile.php?action=coupon_settings',
                cache: false,
                success: function(data) {
                    $(".eqpurchasecontent").html(data);
                    $('#example').DataTable();
                }
            })
        }

        function createNewCoupon() {
            $.ajax({
                url: 'ajaxfile.php?action=create_coupon',
                cache: false,
                success: function(data) {
                    $(".eqpurchasecontent").html(data);
                    //start form process//
                    $("#createcoupon").validate({
                        submitHandler: function(form) {
                            $.ajax({
                                type: "POST",
                                url: "ajaxfile.php?action=createcoupon_fin",
                                data: $(form).serialize(), // serializes the form's elements.
                                success: function(data) {
                                    //console.log(data);
                                    var returnedData = JSON.parse(data);
                                    $(".theresults").html(returnedData.message);
                                    if (returnedData.coupon_id != null) {
                                        if ($("#coup_id").length) {
                                            //do nothing cause it already exist//
                                        } else {
                                            $("#createcoupon").prepend('<input type="hidden" name="coup_id" id="coup_id" value="' + returnedData.coupon_id + '">');
                                        }
                                    }
                                }
                            });
                        }
                    });
                    //end process//


                    initCouponType();
                }
            })
        }

        function initCouponType() {
            $("#coupon_type").on('change', function() {
                if ($(this).val() == 'product_discount') {
                    $(".prodselparent").show();
                    $(".usageparent").hide();
                    $("#prodsel").rules("add", "required");
                    $("#usage_scenario").rules("remove", "required");
                } else {
                    $(".prodselparent").hide();
                    $(".usageparent").show();
                    $("#prodsel").rules("remove", "required");
                    $("#usage_scenario").rules("add", "required");
                }
            })
        }

        function editCoupon(id) {
            $.ajax({
                url: 'ajaxfile.php?action=edit_coupon&coupon_id=' + id,
                cache: false,
                success: function(data) {
                    $(".eqpurchasecontent").html(data);
                    $('[data-toggle="tooltip"]').tooltip();
                    //start form process//
                    $("#createcoupon").validate({
                        submitHandler: function(form) {
                            $.ajax({
                                type: "POST",
                                url: "ajaxfile.php?action=createcoupon_fin&coupon_id=" + id,
                                data: $(form).serialize(), // serializes the form's elements.
                                success: function(data) {
                                    //console.log(data);
                                    var returnedData = JSON.parse(data);
                                    $(".theresults").html(returnedData.message);
                                }
                            });
                        }
                    });
                    //end process//


                    initCouponType();
                }
            })
        }

        function deleteCoupon(id) {
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
            }).then(function() {
                $.ajax({
                    url: 'ajaxfile.php?action=deletecoupon&couponid=' + id,
                    success: function(data) {
                        swal({
                            title: 'Deleted !',
                            text: "Your coupon has been deleted",
                            type: 'success',
                            confirmButtonClass: 'btn btn-confirm mt-2'
                        }).then(function() {
                            coupon_settings();
                        })

                        // console.log(data);
                    }
                })

            }, function(dismiss) {
                // dismiss can be 'cancel', 'overlay',
                // 'close', and 'timer'
                if (dismiss === 'cancel') {
                    swal({
                        title: 'Cancelled',
                        text: "Your imaginary file is safe :)",
                        type: 'error',
                        confirmButtonClass: 'btn btn-confirm mt-2'
                    })
                }
            })
        }

        function receipt_settings() {
            $.ajax({
                url: 'ajaxfile.php?action=modsalesreceipt',
                cache: false,
                success: function(data) {
                    //start form process//
                    $(".eqpurchasecontent").html(data);
                    tinymce.remove();
                    tinymce.init({
                        selector: ".summernote",
                        skin: "caffiene",
                        plugins: [
                            "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                            "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
                            "table contextmenu directionality emoticons paste textcolor codemirror"
                        ],
                        content_css: '../css/bootstrap.css, assets/css/helpers.css',

                        contextmenu: "link image | myitem",
                        setup: function(editor) {
                            editor.addMenuItem('myitem', {
                                text: 'Open Content',
                                onclick: function() {
                                    var beanName = editor.selection.getContent();


                                    ///MINIMOD edit-content.php?id=3&minimod=true///
                                    $.ajax({
                                        url: 'inc/asyncCalls.php?action=minimod&beanid=' + beanName,
                                        success: function(data) {
                                            $("#myModal .modal-body").html(data);
                                            $("#myModal").modal();
                                            $(".modal-dialog").css('width', '70%');

                                        }
                                    })
                                }
                            });
                        },
                        file_browser_callback: function(field_name, url, type, win) {
                            setplacer(field_name, url);
                        },
                        image_description: true,
                        verify_html: false,
                        toolbar1: "styleselect  bold italic underline alignleft aligncenter alignright alignjustify  bullist numlist outdent indent link unlink responsivefilemanager image media fontsizeselect forecolor backcolor code",
                        menubar: false,
                        image_advtab: true,
                        height: '400',
                        forced_root_block: false,
                        image_dimensions: false,
                        image_class_list: [{
                                title: 'Responsive',
                                value: 'img-responsive'
                            },
                            {
                                title: 'Image 100% Width',
                                value: 'img-full-width'
                            }
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

                    initMedia();

                    $("#savesalesreceipt").validate({
                        submitHandler: function(form) {
                            $.ajax({
                                type: "POST",
                                url: "ajaxfile.php?action=savesalesreceipt",
                                data: $(form).serialize(), // serializes the form's elements.
                                success: function(data) {
                                    //console.log(data);
                                    var returnedData = JSON.parse(data);
                                    $(".theresults").html(returnedData.message);

                                }
                            });
                        }
                    });
                }
            })
        }

        function save_receipt_settings() {
            $.ajax({
                type: "POST",
                url: "ajaxfile.php?action=savesalesreceipt",
                data: $(form).serialize(), // serializes the form's elements.
                success: function(data) {
                    //start form process//
                    $("#savesalesreceipt").validate({
                        submitHandler: function(form) {
                            $.ajax({
                                type: "POST",
                                url: "ajaxfile.php?action=savesalesreceipt",
                                data: $(form).serialize(), // serializes the form's elements.
                                success: function(data) {
                                    //console.log(data);
                                    var returnedData = JSON.parse(data);
                                    $(".theresults").html(returnedData.message);
                                }
                            });
                        }
                    });
                }
            })
        }
    </script>
</body>

</html>