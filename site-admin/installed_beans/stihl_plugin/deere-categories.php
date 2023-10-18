<?php include('inc/header.php'); ?>

<!-- Modal -->

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

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
    <div class="modal-dialog">

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

<div class="wrapper">
    <div class="sidebar" data-background-color="white" data-active-color="danger">

        <!--
            Tip 1: you can change the color of the sidebar's background using: data-background-color="white | black"
            Tip 2: you can change the color of the active button using the data-active-color="primary | info | success | warning | danger"
        -->

        <?php include('inc/sidebar.php'); ?>
    </div>

    <div class="main-panel">
        <?php include('inc/top_nav.php'); ?>


        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <img style="margin: 15px 0px;float: right;" src="img/stihl_logo.png">
                                <div class="clearfix"></div>
                                <h4 class="title">Stihl Category Templates</h4>
                                <p class="category">Here are your sites custom Stihl categories.<br></p>

                                <button class="btn btn-warning btn-fill mod-prods" style="float:right; margin: 20px">Manage Products</button> <a href="create-category.php" class="btn btn-success btn-fill" style="float:right; margin: 20px">Create New Category</a>
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
                                    $site->checkInPages();
                                    $pages = $site->getPagesCat('stihl');
                                    $j = 0;
                                    for ($i = 0; $i < count($pages); $i++) {
                                    if ($pages[$i]["active"] != 'false'  && $pages[$i]["page_type"] != 'link') {
                                    if ($j == 0) {
                                    $j = 1;
                                    $back = 'background:#fff';
                                    } else {
                                    $j = 0;
                                    $back = '';
                                    }

                                    if($pages[$i]["page_lock"] == 'User' || $pages[$i]["page_lock"] == 'false' || $pages[$i]["page_lock"] == 'none' || $pages[$i]["page_lock"] == ''){
                                    if($userArray["user_type"] == 'Developer' || $userArray["user_type"] == 'Admin' || $userArray["user_type"] == 'User' || $pages[$i]["page_lock"] == 'false' || $pages[$i]["page_lock"] == 'none' || $pages[$i]["page_lock"] == ''){
                                        if($pages[$i]["check_out"] == ''){
                                            $editCon = '<a href="edit-category.php?id=' . $pages[$i]["id"] . '" style="" class="btn btn-xs btn-success"><i class="ti-check"></i> Checkout</a>';
                                        }else{
                                            $checkedDetails = $site->getCheckOut($pages[$i]["check_out"]);
                                            $checkoutDate = date('m/d/Y h:i:a',$pages[$i]["check_out_date"]);
                                            $editCon = '<small class="text-warning">Checked Out by: <a href="javascript:openProfile(\''.$pages[$i]["check_out"].'\')">'.$checkedDetails["fname"].'</a> - '.$checkoutDate.'</small> | <button style="" class="btn btn-xs btn-danger btn-fill"><i class="ti-unlock"></i> Force Check In</button>';
                                        }
                                    }else{
                                    $editCon = '<button style="" class="btn btn-xs btn-warning btn-fill" disabled><i class="fa fa-pencil"></i> Page Locked :( </button>';
                                    }
                                    }else{
                                    if($pages[$i]["page_lock"] == 'Admin' && $userArray["user_type"] == 'Admin' || $pages[$i]["page_lock"] == 'Admin' && $userArray["user_type"] == 'Developer' || $pages[$i]["page_lock"] == 'Developer' && $userArray["user_type"] == 'Developer'){

                                        if($pages[$i]["check_out"] == ''){
                                            $editCon = '<a href="edit-category.php?id=' . $pages[$i]["id"] . '" style="" class="btn btn-xs btn-success"><i class="ti-check"></i> Checkout</a>';
                                        }else{
                                            $checkedDetails = $site->getCheckOut($pages[$i]["check_out"]);
                                            $checkoutDate = date('m/d/Y h:i:a',$pages[$i]["check_out_date"]);
                                            $editCon = '<small class="text-warning">Checked Out by: <a href="javascript:openProfile(\''.$pages[$i]["check_out"].'\')">'.$checkedDetails["fname"].'</a> - '.$checkoutDate.'</small> | <button style="" class="btn btn-xs btn-danger btn-fill"><i class="ti-unlock"></i> Force Check In</button>';
                                        }

                                    }else{
                                    $editCon = '<button style="color:#100b00; font-weight:bold" class="btn btn-xs btn-warning btn-fill" disabled><i class="ti-lock"></i> Page Locked</button>';
                                    }

                                    }

                                    echo '
                                    <tr>
                                        <td><a style="color: #333" href="">' . $pages[$i]["page_name"].'</a></td>
                                        <td><a style="color: #333" href="">' . ucwords(str_replace('-',' ',$pages[$i]["category_type"])).'</a></td>
                                        <td style="text-align:right">'.$editCon.'</td>
                                    </tr>';
                                    }

                                    }

                                    ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>


<script>
    $(function(){
        $(".mod-prods").on('click',function(){
            $.ajax({
                url: 'inc/asyncCalls.php?action=modprods',
                success:function(data){
                    $("#myModal .modal-body").html(data);
                    $("#myModal .modal-title").html('Manage Stihl Products');
                    $("#myModal").modal();
                    $(".modal-dialog").css('width','70%');
                }
            })
        })
    })

    function changeCats(catname,cattype){
        $.ajax({
            type: "POST",
            url: 'inc/asyncCalls.php?action=getprodcatsedits&catname='+catname+'&cattype='+cattype,
            cache: false,
            success: function(data){
                $(".modprodshold").html(data);
            }
        })
    }

    function openProduct(prod,cat){
        $(".modprodshold").html('<iframe id="prodedits" style="width: 100%; height: 100vh; border: none" src="product_mod.php?prod='+prod+'&cat='+cat+'"></iframe>');
    }

    function addNewCats(){
        ///addneweq
        $.ajax({
            url: 'inc/asyncCalls.php?action=addneweq',
            success:function(data){
                $(".modprodshold").html(data);
                fireProcessLinks();
                setupswtch();
            }
        })
    }


    function fireProcessLinks(){
        $("#processurlform").validate({
            submitHandler: function(form) {
                $.ajax({
                    type: "POST",
                url: "inc/asyncCalls.php?action=processEquip",
                data: $("#processurlform").serialize(),
                    success: function(data)
                {
                    alert(data);
                }
            });
            }
        });
    }


    function setupswtch(){
        var content = "<input type='text' class='bss-input' onKeyDown='event.stopPropagation();' onKeyPress='addSelectInpKeyPress(this,event)' onClick='event.stopPropagation()' placeholder='Add item'> <span class='glyphicon glyphicon-plus addnewicon' onClick='addSelectItem(this,event,1);'></span>";

        var divider = $('<option/>')
            .addClass('divider')
            .data('divider', true);


        var addoption = $('<option/>', {class: 'addItem'})
            .data('content', content)

        $('.selectpicker')
            .append(divider)
            .append(addoption)
            .selectpicker();

    }

    function addSelectItem(t,ev)
    {
        ev.stopPropagation();

        var bs = $(t).closest('.bootstrap-select')
        var txt=bs.find('.bss-input').val().replace(/[|]/g,"");
        var txt=$(t).prev().val().replace(/[|]/g,"");
        if ($.trim(txt)=='') return;

        // Changed from previous version to cater to new
        // layout used by bootstrap-select.
        var p=bs.find('select');
        var o=$('option', p).eq(-2);
        o.before( $("<option>", { "selected": true, "text": txt}) );
        p.selectpicker('refresh');
    }

    function addSelectInpKeyPress(t,ev)
    {
        ev.stopPropagation();

        // do not allow pipe character
        if (ev.which==124) ev.preventDefault();

        // enter character adds the option
        if (ev.which==13)
        {
            ev.preventDefault();
            addSelectItem($(t).next(),ev);
        }
    }

</script>



<?php include('inc/footer.php'); ?>
