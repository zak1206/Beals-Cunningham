<?php
include('e-commerce-header.php');
?>
<div class="row" style="margin:0;">

    <div class="col-md-12">
        <div>
            <div class="header">
                <div class="clearfix"></div>
                <h2 class="title">Custom Category Templates</h2>
                <p class="category">Here are your sites custom categories.<br></p>
                <a onclick="location.href='edit-product.php'" class="btn btn-warning btn-fill" style="float:right; margin: 20px">
                    Manage Products
                </a><a href="create-category.php" class="btn btn-success btn-fill" style="float:right; margin: 20px">Create New Category</a>
                <div class="clearfix"></div>
            </div>
            <div class="content table-responsive table-full-width">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="font-weight: bold;background: #5d5d5d;color: #fff; border-right:solid thin #efefef">Category</th>
                            <th style="font-weight: bold;background: #5d5d5d;color: #fff; border-right:solid thin #efefef">Category Type</th>

                            <th class="nosort" style="text-align: right; font-weight:bold;background: #5d5d5d;color: #fff;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //$site->checkInPages();
                        $pages = $deere->getPagesCat('deere');
                        $j = 0;
                        for ($i = 0; $i < count($pages); $i++) {
                            if ($pages[$i]["active"] != 'false') {
                                if ($j == 0) {
                                    $j = 1;
                                    $back = 'background:#fff';
                                } else {
                                    $j = 0;
                                    $back = '';
                                }

                                if ($pages[$i]["page_lock"] == 'User' || $pages[$i]["page_lock"] == 'false' || $pages[$i]["page_lock"] == 'none' || $pages[$i]["page_lock"] == '') {
                                    if ($userArray["user_type"] == 'Developer' || $userArray["user_type"] == 'Admin' || $userArray["user_type"] == 'User' || $pages[$i]["page_lock"] == 'false' || $pages[$i]["page_lock"] == 'none' || $pages[$i]["page_lock"] == '') {
                                        if ($pages[$i]["check_out"] == '') {
                                            $editCon = '<a href="edit-category.php?editview=true&eqid='.$pages[$i]["id"].'" style="" class="btn btn-xs btn-success"><i class="ti-check"></i> Checkout</a>';
                                        } else {
                                            $checkedDetails = $site->getCheckOut($pages[$i]["check_out"]);
                                            $checkoutDate = date('m/d/Y h:i:a', $pages[$i]["check_out_date"]);
                                            $editCon = '<small class="text-warning">Checked Out by: <a href="javascript:openProfile(\'' . $pages[$i]["check_out"] . '\')">' . $checkedDetails["fname"] . '</a> - ' . $checkoutDate . '</small> | <button style="" class="btn btn-xs btn-danger btn-fill"><i class="ti-unlock"></i> Force Check In</button>';
                                        }
                                    } else {
                                        $editCon = '<button style="" class="btn btn-xs btn-warning btn-fill" disabled><i class="fa fa-pencil"></i> Page Locked :( </button>';
                                    }
                                } else {
                                    if ($pages[$i]["page_lock"] == 'Admin' && $userArray["user_type"] == 'Admin' || $pages[$i]["page_lock"] == 'Admin' && $userArray["user_type"] == 'Developer' || $pages[$i]["page_lock"] == 'Developer' && $userArray["user_type"] == 'Developer') {

                                        if ($pages[$i]["check_out"] == '') {
                                            $editCon = '<a href="edit-category.php?editview=true&eqid='.$pages[$i]["id"].'" style="" class="btn btn-xs btn-success"><i class="ti-check"></i> Checkout</a>';
                                        } else {
                                            $checkedDetails = $site->getCheckOut($pages[$i]["check_out"]);
                                            $checkoutDate = date('m/d/Y h:i:a', $pages[$i]["check_out_date"]);
                                            $editCon = '<small class="text-warning">Checked Out by: <a href="javascript:openProfile(\'' . $pages[$i]["check_out"] . '\')">' . $checkedDetails["fname"] . '</a> - ' . $checkoutDate . '</small> | <button style="" class="btn btn-xs btn-danger btn-fill"><i class="ti-unlock"></i> Force Check In</button>';
                                        }
                                    } else {
                                        $editCon = '<button style="color:#100b00; font-weight:bold" class="btn btn-xs btn-warning btn-fill" disabled><i class="ti-lock"></i> Page Locked</button>';
                                    }
                                }

                                echo '
                                    <tr>
                                        <td><a style="color: #333" href="">' . $pages[$i]["page_name"] . '</a></td>
                                        <td><a style="color: #333" href="">' . ucwords(str_replace('-', ' ', $pages[$i]["category_type"])) . '</a></td>
                                        <td style="text-align:right">' . $editCon . '</td>
                                    </tr>';
                            }
                        }

                        ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <!-- end container -->
</div>
<!-- end content -->
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
<?php
include('e-commerce-footer.php');
?>
</body>

</html>