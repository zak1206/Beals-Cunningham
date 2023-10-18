<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="../../plugins/switchery/switchery.min.css" rel="stylesheet" />

    <link href="../../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../../codemirror/lib/codemirror.css" />
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
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <script src="js/bootstrap-switch.js"></script>
    <script src="js/carousel-back.js"></script>

    <!-- Buttons examples -->
    <title>Create New Equipment Category</title>

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

        li.equiplist-item {
            padding: 10px;
            width: 100%;
            background: #E9ECEF;
            border: solid 1px #ccc;
            border-radius: 4px;
            list-style: none;
        }

        a {
            color: black;
        }

        #body-row {
            margin-left: 0;
            margin-right: 0;
        }

        #sidebar-container {
            min-height: 100vh;
            background-color: #333;
            padding: 0;
        }

        /* Sidebar sizes when expanded and expanded */
        .sidebar-expanded {
            width: 230px;
        }

        .sidebar-collapsed {
            width: 60px;
        }

        /* Menu item*/
        #sidebar-container .list-group a {
            height: 50px;
            color: white;
        }

        /* Submenu item*/
        #sidebar-container .list-group .sidebar-submenu a {
            height: 45px;
            padding-left: 30px;
        }

        .sidebar-submenu {
            font-size: 0.9rem;
        }

        /* Separators */
        .sidebar-separator-title {
            background-color: #333;
            height: 35px;
        }

        .sidebar-separator {
            background-color: #333;
            height: 25px;
        }

        .logo-separator {
            background-color: #333;
            height: 60px;
        }

        /* Closed submenu icon */
        #sidebar-container .list-group .list-group-item[aria-expanded="false"] .submenu-icon::after {
            content: " \f0d7";
            font-family: FontAwesome;
            display: inline;
            text-align: right;
            padding-left: 10px;
        }

        /* Opened submenu icon */
        #sidebar-container .list-group .list-group-item[aria-expanded="true"] .submenu-icon::after {
            content: " \f0da";
            font-family: FontAwesome;
            display: inline;
            text-align: right;
            padding-left: 10px;
        }

        .btn-primary {
            background-color: #097F0E;
            border: 1px solid #097F0E;
        }

        div.image-holder.col-sm-4.col-md-6.four-three {
            display: none;
        }

        div.ctas {
            display: none;
        }
    </style>
</head>

<body style="height: 100vh; background: white;">

    <div class="container-fluid">
        <?php
        include('sidebar.php');
        include('../../inc/caffeine.php');
        $site = new caffeine();
        $userArray = $site->auth();
        include('functions.php');
        $deere = new customClass();
        ?>
        <div class="col p-4">
            <?php
            $categoryOut = '<br><br><h4 class="title" style="color: #eb5e29">Manage Custom Products</h4><p class="category">Here you can manage Custom products and add new products as they are added to the custom site.<br></p>';

            $categoryOut .= '<div style="text-align: left"><div class="row"><div class="col-6"><label>Quick Search</label><br><input class="form-control"  type="text" name="equip_search" id="equip_search"/></div><div class="col-3"><button style="margin-left: 20px; margin-top:31px;" class="btn btn-success form-control" onclick="getQuickProds();">Search</button></div><div class="col-2"><button style="margin-left: 20px; margin-top:31px;" class="btn btn-warning form-control" onclick="clearQuick();">Clear</button></div></div></div><br><br>';


            $categoryOut .= '<div class="quick-prod-container"></div>';
            $categoryOut .= '<div class="modprodshold">';

            $cats = $deere->getEquipmentProducts('', '');

            for ($o = 0; $o <= count($cats); $o++) {
                if ($cats[$o]["title"] != null) {
                    $categoryOut .= '<div class="productitem" style="padding: 5px; text-align: left; background: #d4d4d4; margin: 5px; cursor:pointer; font-size:18px" onclick="changeCats(\'' . $cats[$o]["catname"] . '\',\'' . $cats[$o]["cattype"] . '\')"><div class="row"><div class="col-md-8">' . $cats[$o]["title"] . '</div><div class="col-md-4" style="text-align: right">EDIT</div></div><div class="clearfix"></div></div>';
                }
            }

            $categoryOut .= '</div>';


            echo $categoryOut;
            ?>
        </div>
    </div>

    <script>
        function changeCats(catname, cattype) {
            $.ajax({
                type: "POST",
                url: 'asyncData.php?action=getprodcatsedits&catname=' + catname + '&cattype=' + cattype,
                cache: false,
                success: function(data) {
                    $(".modprodshold").html(data);
                }
            })
        }

        $(function() {
            $(".mod-prods").on('click', function() {
                $.ajax({
                    url: 'asyncData.php?action=modprods',
                    success: function(data) {
                        $("#myModal .modal-body").html(data);
                        $("#myModal .modal-title").html('Manage Custom Products');
                        $("#myModal").modal();
                        $(".modal-dialog").css('width', '70%');
                    }
                })
            })
        })



        function openProduct(prod, cat) {
            $(".modprodshold").html('<iframe id="prodedits" style="width: 100%; height: 100vh; border: none" src="product_mod.php?prod=' + prod + '&cat=' + cat + '"></iframe>');
        }

        function addNewCats() {
            ///addneweq
            $.ajax({
                url: 'asyncData.php?action=addneweq',
                success: function(data) {
                    $(".modprodshold").html(data);
                    fireProcessLinks();
                    setupswtch();
                }
            })
        }


        function fireProcessLinks() {
            $("#processurlform").validate({
                submitHandler: function(form) {
                    $.ajax({
                        type: "POST",
                        url: "asyncData.php?action=processEquip",
                        data: $("#processurlform").serialize(),
                        success: function(data) {
                            alert(data);
                        }
                    });
                }
            });
        }


        function setupswtch() {
            var content = "<input type='text' class='bss-input' onKeyDown='event.stopPropagation();' onKeyPress='addSelectInpKeyPress(this,event)' onClick='event.stopPropagation()' placeholder='Add item'> <span class='glyphicon glyphicon-plus addnewicon' onClick='addSelectItem(this,event,1);'></span>";

            var divider = $('<option/>')
                .addClass('divider')
                .data('divider', true);


            var addoption = $('<option/>', {
                    class: 'addItem'
                })
                .data('content', content)

            $('.selectpicker')
                .append(divider)
                .append(addoption)
                .selectpicker();

        }

        function addSelectItem(t, ev) {
            ev.stopPropagation();

            var bs = $(t).closest('.bootstrap-select')
            var txt = bs.find('.bss-input').val().replace(/[|]/g, "");
            var txt = $(t).prev().val().replace(/[|]/g, "");
            if ($.trim(txt) == '') return;

            // Changed from previous version to cater to new
            // layout used by bootstrap-select.
            var p = bs.find('select');
            var o = $('option', p).eq(-2);
            o.before($("<option>", {
                "selected": true,
                "text": txt
            }));
            p.selectpicker('refresh');
        }

        function addSelectInpKeyPress(t, ev) {
            ev.stopPropagation();

            // do not allow pipe character
            if (ev.which == 124) ev.preventDefault();

            // enter character adds the option
            if (ev.which == 13) {
                ev.preventDefault();
                addSelectItem($(t).next(), ev);
            }
        }

        function processsPages() {
            $(".inspg").html('Installing Page Data... <img style="width: 18px; padding: 1px;" src="installed_beans/deere_plugin/loading.gif"> ');
            $.ajax({
                url: 'asyncData.php?action=pullpages',
                success: function(data) {
                    $(".inspg").remove();
                    alert(data);
                }
            })
        }


        function openUpdatePanel() {

            var package_file = $("#package_file").val();
            var update_date = $("#update_date").val();
            var update_date_system = $("#update_date_system").val()
            var update_notes = $("#update_notes").val();
            var version = $("#version").val();


            $("#myModal .modal-body").html('<h2>Custom Plugin Updates</h2><br><small><i>Release Date: ' + update_date + ' Version: ' + version + '</i></small><br><br>' + update_notes + '<br><div style="display: none; padding: 10px; background: #efefef;" class="loadarea"><br><div class="progress" style="height: 2px;">\n' +
                '  <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>\n' +
                '</div> <small class="info-loads">Updating plugin please wait...</small></div><br><button class="btn btn-primary updtrbutton" onclick="getupdatepackage(\'' + package_file + '\',\'' + update_date_system + '\')">Install Updates.</button>');
            $("#myModal .modal-title").html('Update Custom Plugin');
            $(".modal-dialog").css('width', '30%');
            $("#myModal").modal();
        }


        function getProgress() {
            var intervalInMS = 200;
            var doneDelay = intervalInMS * 2;
            var bar = $('.progress-bar');
            var percent = 0;
            var durationInMs = 38000;

            var interval = setInterval(function updateBar() {
                percent += 100 * (intervalInMS / durationInMs);
                bar.css({
                    width: percent + '%'
                });
                bar['aria-valuenow'] = percent;

                if (percent >= 100) {
                    clearInterval(interval);
                    setTimeout(function() {
                        if (typeof onDone === 'function') {
                            onDone();
                        }
                    }, doneDelay);
                }
            }, intervalInMS);
        }

        var duration = 1000; // in milliseconds
        function onDone() {
            $(".info-loads").html('Plugin Successfully Updated. You can now close this window.');
            location.reload();
        }



        function getupdatepackage(packageurl, systemtime) {

            $(".loadarea").show();
            $(".updtrbutton").hide();
            getProgress();

            $.ajax({
                url: 'asyncData.php?action=pullupdates&pack=' + packageurl + '&systemtime=' + systemtime,
                cache: false,
                success: function(data) {
                    console.log(data);
                }
            })
        }

        $(document).ready(function() {
            $('.table').DataTable();
            //refreshCategories();
        });

        function openContent() {
            $("#myModal .modal-body").html('<iframe src="../../content_plugins.php" style="width: 100%; height: 400px; border:none"></iframe>');
            $("#myModal .modal-title").html('Content / Plugin Tokens');
            $("#myModal .modal-dialog").css('width', '90%');
            $("#myModal").modal();
        }
    </script>