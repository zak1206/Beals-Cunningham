
<?php
date_default_timezone_set('America/Chicago');
$modFolder = 'installed_beans/deere_plugin';
include($modFolder.'/functions.php');
$deere = new deereClass();
?>

<?php
if(isset($_REQUEST["createnew"])){
    ?>

    <?php
    if(isset($_POST["page_name"])){
        $page = $site->createPage($_POST);
        $page_name = $_POST["page_name"];
        $page_title = $_POST["page_title"];
        $page_desc = $_POST["page_desc"];
        $page_template = $_POST["page_template"];
        $existPage = '<input type="hidden" id="page_id" name="page_id" value="'.$page.'">';
        $catImg = $_POST["cat_img"];
        $category_type = $_POST["category_type"];
        $currTemplate = '';
        $equipmentArs = $_POST["dropped-info"];
        $alert = '<div class="alert alert-success" role="alert">
  <strong>Well done!</strong> Your page has been saved successfully.
</div>';
    }else{
        $page_name = '';
        $page_title = '';
        $page_desc = '';
        $page_template = '';
        $existPage = '';
        $catImg = '';
        $category_type = '';
        $alert = '';
        $equipmentArs = '';
        $currTemplate = '<div class="container"><h1>Category Title Here</h1>{prodcat}data{/prodcat}</div>';
    }
    ?>

    <div class="coversheet"></div>

    <div class="load_holds">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
            </svg>
        </div>
        <small>Please wait...</small>
    </div>

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

    <div class="col-md-8">


        <div class="header">
            <h4 class="title">Create New Equipment Category</h4>
            <p class="category">Use this to create custom categories for equipment.</p>

            <button class="btn btn-primary btn-fill" style="float: right; margin:3px" type="button" onclick="openBeans()"><i class="ti-layers"></i> Open Content / Plugins</button>
            <div class="clearfix"></div>
        </div>
        <div class="content table-responsive table-full-width">
            <form class="validforms" id="page-layout" name="page-layout" style="padding: 20px" method="post" action="">
                <input type="hidden" name="line_type" id="line_type" value="deere">
                <label>Category Name</label><br>
                <input class="form-control" type="text" id="page_name" name="page_name" value="<?php echo $page_name; ?>" required=""><br>
                <label>Category Type <a href="javascript:openHelpCat()"><i class="ti-info-alt"></i></a></label><br><code class="cat_help" style="padding: 5px; background: #efefef; display: none"><small><strong>Set category types for sorting purposes.</strong> <br><strong>Parent Category</strong> = Category that holds child categories or product categories. <br><strong>Child Category</strong> = Holds custom categories or product categories. <br> <strong>Product Category</strong> = Should only contain products. <br> <strong>Custom Category</strong> = Can hold products or child categories.</small><br><br></code>
                <select class="form-control" name="category_type" id="category_type">
                    <option value="">Select Category Type</option>
                    <?php
                    $catTypeArs = array('Parent Category'=>'parent-category','Child Category'=>'child-category','Product Category'=>'product-category','Custom Category'=>'custom-category');
                    foreach($catTypeArs as $key=>$val){
                        if(isset($category_type) && $category_type == $val){
                            echo '<option value="'.$val.'" selected="selected">'.$key.'</option>';
                        }else{
                            echo '<option value="'.$val.'">'.$key.'</option>';
                        }

                    }
                    ?>
                </select><br>
                <label>(Meta) Title Tag</label><br>
                <input class="form-control" type="text" id="page_title" name="page_title" value="<?php echo $page_title; ?>" required=""><br>
                <label>(Meta) Category Description & Short Text</label><br><small>Try not to exceed 300 Characters.</small><br>
                <textarea class="form-control" id="page_desc" name="page_desc"><?php echo $page_desc; ?></textarea>
                <span class="counter-text" style="font-style: italic;color: #b1b0b0;">Characters left: 300</span><br><br>
                <label>Category Image</label><br>
                <div class="input-group col-md-12">

                    <input type="text" class="form-control" name="cat_img" id="cat_img" placeholder="No Image" value="<?php echo $catImg; ?>">
                    <span class="input-group-btn">
        <button class="btn btn-primary img-browser" style="border: solid thin #ccc;background: #cccccc; color: #333;" data-setter="cat_img" type="button">Browse Images</button>
      </span>
                </div>

                <label>Drop Products & Categories Here</label><br>
                <small>Below is the <span style="color: red">{prodcat}data{/prodcat}</span> You can move and adjust this token anywhere on the category page details.</small>
                <?php

                $trueArs = json_decode($equipmentArs,true);


                for($s=0; $s <= count($trueArs); $s++){
                    if($trueArs[$s]["type"] == 'product'){
                        $theBlocks .= '<div class="dropitemsin" data-thedrop="'.$trueArs[$s]["title"].'" data-thedroptype="'.$trueArs[$s]["type"].'">Product: '.$trueArs[$s]["title"].' | <a href="javascript:void(0)" class="removeites"><i class="fa fa-trash" aria-hidden="true"></i> Remove</a></div>';
                    }

                    if($trueArs[$s]["type"] == 'category'){
                        $theBlocks .= '<div class="dropitemsin" data-thedrop="'.$trueArs[$s]["title"].'" data-thedroptype="'.$trueArs[$s]["type"].'">Category: '.$trueArs[$s]["title"].' | <a href="javascript:void(0)" class="removeites"><i class="fa fa-trash" aria-hidden="true"></i> Remove</a></div>';
                    }

                    if($trueArs[$s]["type"] == 'htmlarea'){
                        $theBlocks .= '<div class="dropitemsin" data-thedrop="'.$trueArs[$s]["title"].'" data-thedroptype="'.$trueArs[$s]["type"].'"><span class="isolatetext">HTML Widget:</span> | <button type="button" class="btn btn-xs btn-default minimodset" data-causedata="'.$trueArs[$s]["title"].'">Edit HTML</button> | '.$trueArs[$s]["title"].' | <a href="javascript:void(0)" class="removeites"><i class="fa fa-trash" aria-hidden="true"></i> Remove</a></div>';
                    }
                }

                ?>
                <div class="droparea"><?php echo $theBlocks; ?></div>
                <input type="hidden" id="dropped-info" name="dropped-info" value="">
                <br>

                <label>Page Details</label><br>
                <textarea class="summernote" id="page_template" name="page_template"><?php echo $currTemplate; ?><?php echo $page_template; ?></textarea>
                <?php echo $existPage; ?>
                <br><br>
                <button class="btn btn-success" onclick="savePage()">Save Page</button>
            </form>
        </div>


    </div>
    <div class="col-md-4">

        <?php

        $cats = $deere->getEquipmentProducts('','');

        for($o=0; $o<=count($cats); $o++){
            if($cats[$o]["title"] != null) {
                $categoryOut .= '<div class="productitem" style="padding: 5px; text-align: center; background: #fff; margin: 5px; cursor:pointer" onclick="changeCats(\''.$cats[$o]["catname"].'\',\''.$cats[$o]["cattype"].'\')">' . $cats[$o]["title"] . ' <i class="fa fa-folder-open" aria-hidden="true"></i></div>';
            }
        }

        $realCats = $deere->getEqCats('');

        if($realCats != null) {
            for ($b = 0; $b <= count($realCats); $b++) {
                if ($realCats[$b]["catname"] != null) {
                    $categoryOutReal .= '<div class="productitem draggable" data-thename="' . $realCats[$b]["catname"] . '" data-listtype="category" style="padding: 5px; text-align: center; background: #fff; margin: 5px; cursor:pointer"><div class="dragsa col-md-2" style="cursor:move; text-align: left"><img style="width: 6px" src="img/grip.png"></div><div class="col-md-10" style="text-align: left">' . $realCats[$b]["catname"] . '</div><div class="clearfix"></div></div>';
                }
            }
        }else{
            $categoryOutReal = '<div class="col-md-12"><div class="box_message">No active categories.</div></div>';
        }


        ?>

        <div style="height: 160px"></div>
        <div style="background: #efefef; padding: 20px; margin: 3px"><div style="text-align: center"><h4>HTML Info</h4><small>Drag & drop html container to add html inside product container.</small></div><div class="productitem draggable" data-thename="" data-listtype="htmlarea" style="padding: 5px; text-align: center; background: #fff; margin: 5px; cursor:pointer"><div class="dragsa col-md-2" style="cursor:move; text-align: left"><img style="width: 6px" src="img/grip.png"></div> <div class="col-md-10" style="text-align: left">HTML Container <i class="fa fa-list-alt" aria-hidden="true"></i></div><div class="clearfix"></div></div></div>
        <div style="background: #efefef; padding: 20px; margin: 3px"><h4 style="text-align: center">Created Categories</h4><div class="col-md-12">
                <label>Sort by Type:</label><br>
                <div style="width:100%;" class="btn-group thefilter" role="group" aria-label="Basic example">
                    <button style="width: 20%" type="button" class="btn btn-primary btn-xs btn-fill active filterbutton" onclick="filterCustomCats('all')">All</button>
                    <button style="width: 20%" type="button" class="btn btn-primary btn-xs btn-fill filterbutton" onclick="filterCustomCats('parent-category')">Parent</button>
                    <button style="width: 20%" type="button" class="btn btn-primary btn-xs btn-fill filterbutton" onclick="filterCustomCats('product-category')">Product</button>
                    <button style="width: 20%" type="button" class="btn btn-primary btn-xs btn-fill filterbutton" onclick="filterCustomCats('child-category')">Child</button>
                    <button style="width: 20%" type="button" class="btn btn-primary btn-xs btn-fill filterbutton" onclick="filterCustomCats('custom-category')">Custom</button>
                </div>
                <div class="input-group col-md-12" style="margin-top:10px"><input type="text" style="background: #fff" class="form-control" name="cat_ser" id="cat_ser" placeholder="Search Categories" data-list=".custcats" autocomplete="off" value=""> <span class="input-group-btn"><button class="btn btn-primary ser-thcats" style="border: solid thin #ccc;background: #cccccc; color: #333;" type="button">Search</button></span></div></div><div class="custcats" style="height: 250px; overflow-y:scroll; width: 100%"><?php echo $categoryOutReal; ?></div></div>

        <div class="productslist" style="background: #efefef; padding: 20px; margin: 3px;"><h4 style="text-align: center">Browse Products</h4><?php echo $categoryOut; ?></div>
    </div>
    <div class="clearfix"></div>

    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>

    <script>

        function savePage(){
            if($(".note-editor").hasClass('codeview')){
                $( ".btn-codeview" ).trigger( "click" );
            }
            $("#page-layout").submit();
        }

        function changeCats(catname,cattype){
            $.ajax({
                type: "POST",
                url: '<?php echo $modFolder; ?>/asyncData.php?action=getprodcats&catname='+catname+'&cattype='+cattype,
                cache: false,
                success: function(data){
                    $(".productslist").html(data);
                    $( ".draggable" ).draggable({
                        helper: 'clone',
                        handle: ".dragsa"
                    });
                }
            })
        }

        function intDropable(){

            var array = [];
            $( ".droparea" ).droppable({
                connectToSortable: '.droparea',
                drop: function( event, ui ) {
                    var thistype = ui.draggable.data('listtype');
                    var nameout = ui.draggable.data('thename');
                    if(nameout != undefined) {
                        if (thistype == 'product') {
                            var nowtype = 'Product: ';
                        }
                        if(thistype == 'category') {
                            var nowtype = 'Category: ';
                        }
                        if(thistype == 'htmlarea') {
                            var dt = new Date($.now());
                            nameout = md5(dt);
                            nameout = nameout.substring(0, 8);

                            $.ajax({
                                url:'<?php echo $modFolder; ?>/asyncData.php?action=createbean&beanname=productbean&bean_id='+nameout,
                                success: function(data){
                                    console.log('Completed');
                                    runMiniEdits();
                                }
                            })

                            var nowtype = '<span class="isolatetext">HTML Widget:</span> | <button type="button" class="btn btn-xs btn-default minimodset" data-causedata="'+nameout+'">Edit HTML</button> | ';
                        }
                        $(".droparea").append('<div class="dropitemsin" data-thedrop="'+nameout+'" data-thedroptype="'+thistype+'">' + nowtype + '' + nameout + ' | <a href="javascript:void(0)" class="removeites"><i class="fa fa-trash" aria-hidden="true"></i> Remove</a></div>');
                    }

                    //dropped-info
                    $('.droparea > .dropitemsin').each(function(){



                        array.push({
                            title: $(this).data('thedrop'),
                            type: $(this).data('thedroptype')
                        });
                    });
                    var jsonString = JSON.stringify(array);
                    //console.log(jsonString);
                    $("#dropped-info").val(jsonString);
                    array = [];
                    setRemoves();
                }
            });

            $( ".droparea" ).sortable({
                containment: "parent",
                stop: function(event,ui){
                    $('.droparea > .dropitemsin').each(function(){

                        array.push({
                            title: $(this).data('thedrop'),
                            type: $(this).data('thedroptype')
                        });
                    });
                    var jsonString = JSON.stringify(array);
                    $("#dropped-info").val(jsonString);
                    array = [];
                }
            });
        }

        function onloadFun(){
            alert('sdfsdfsf');
            $( ".draggable" ).draggable({
                helper: 'clone',
                handle: ".dragsa"
            });

            intDropable();
        }

        function setRemoves(){
            $(".removeites").on('click',function(){
                $(this).parent().remove();
                var array = [];
                //dropped-info
                $('.droparea > .dropitemsin').each(function(){
                    array.push({
                        title: $(this).data('thedrop'),
                        type: $(this).data('thedroptype')
                    });
                });
                var jsonString = JSON.stringify(array);
                //console.log(jsonString);
                $("#dropped-info").val(jsonString);
                array = [];
            })
        }

        $(function(){
            onloadFun();
            alert('sdfsdfsf');
        })

        function runMiniEdits(){
            console.log('Open Edit');
            $(".minimodset").on('click',function(){
                var beanName = $(this).data('causedata');


                ///MINIMOD edit-content.php?id=3&minimod=true///
                $.ajax({
                    url: '<?php echo $modFolder; ?>/asyncData.php?action=minimod&beanid='+beanName,
                    success: function(data){
                        $("#myModal .modal-body").html(data);
                        $("#myModal").modal();
                        $(".modal-dialog").css('width','70%');

                    }
                })
            })

        }

        $(function(){
            $(".img-browser").on('click',function(){
                var itemsbefor = $(this).data('setter');
                $("#myModalAS .modal-title").html('Select an Image For Link');
                $("#myModalAS .modal-body").html('<iframe id="themedia" style="width: 100%; height: 450px; border: none" src="filedfiles.php?typeset=simple&fldset='+itemsbefor+'"></iframe>');
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


        })

        function openHelpCat(){
            $(".cat_help").toggle();
        }

        function filterCustomCats(type){
            $.ajax({
                url: '<?php echo $modFolder; ?>/asyncData.php?action=filtercustomcats&filter='+type,
                success: function(data){
                    $(".custcats").html(data);
                    $( ".draggable" ).draggable({
                        helper: 'clone',
                        handle: ".dragsa"
                    });

                }
            })
        }

        $(function(){
            $(".filterbutton").on('click',function(){

                $('.filterbutton').each(function(i, obj) {
                    $(this).removeClass('active');
                });

                $(this).addClass('active');
            })
        })

        function passImage(imgpath,fld){
            $("#"+fld).val(imgpath);
            $("#myModalAS").modal('hide');
        }

        $(function(){
            $('#cat_ser').hideseek({
                highlight: true
            });
        })

    </script>

    <?php
}else{



    ///IF IN EDIT////

    if(isset($_REQUEST["editview"])){

        $id = $_REQUEST["eqid"];
        $pageDetails = $deere->getDeerePage($id);
        $page_name = $pageDetails["page_name"];
        $page_title = $pageDetails["page_title"];
        $page_desc = $pageDetails["page_desc"];
        $page_template = $pageDetails["page_template"];
        $cat_img = $pageDetails["cat_img"];
        $category_type = $pageDetails["cat_type"];
        $equipmentArs = $pageDetails["equipment_content"];
        $existPage = '<input type="hidden" id="page_id" name="page_id" value="'.$pageDetails["id"].'">';

        if(isset($_POST["page_name"])){
            $page = $site->createPage($_POST);

            if($_POST["checkout"] == 'true'){
                echo "<script>window.location = 'pages.php'</script>";
            }else {
                $alert = '<div class="alert alert-success" role="alert" style="    padding: 20px; font-size: 15px;">
  <strong>Well done!</strong> Your page has been saved successfully @ ' . date('h:i:s:a') . '.
</div>';
                echo $alert;
            }
        }
        ?>

        <div class="load_holds">
            <div class="loader">
                <svg class="circular" viewBox="25 25 50 50">
                    <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
                </svg>
            </div>
            <small>Please wait...</small>
        </div>

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

        <div class="row">

        <div class="col-md-8">


            <div class="header">
                <h4 class="title">Edit Deere Equipment Category</h4>
                <p class="category">Use this to create custom categories for equipment.</p>

                <button class="btn btn-primary btn-fill" style="float: right; margin:3px" type="button" onclick="openBeans()"><i class="ti-layers"></i> Open Content / Plugins</button>
                <div class="clearfix"></div>
            </div>
            <div class="content table-responsive table-full-width">
                <form class="validforms" id="page-layout" name="page-layout" style="padding: 20px" method="post" action="">
                    <label>Category Name</label><br>
                    <input class="form-control" type="text" id="page_name" name="page_name" value="<?php echo $page_name; ?>" required=""><br>
                    <label>Category Type <a href="javascript:openHelpCat()"><i class="ti-info-alt"></i></a></label><br><code class="cat_help" style="padding: 5px; background: #efefef; display: none"><small><strong>Set category types for sorting purposes.</strong> <br><strong>Parent Category</strong> = Category that holds child categories or product categories. <br><strong>Child Category</strong> = Holds custom categories or product categories. <br> <strong>Product Category</strong> = Should only contain products. <br> <strong>Custom Category</strong> = Can hold products or child categories.</small><br><br></code>
                    <select class="form-control" name="category_type" id="category_type">
                        <option value="">Select Category Type</option>
                        <?php
                        $catTypeArs = array('Parent Category'=>'parent-category','Child Category'=>'child-category','Product Category'=>'product-category','Custom Category'=>'custom-category');
                        foreach($catTypeArs as $key=>$val){
                            if(isset($category_type) && $category_type == $val){
                                echo '<option value="'.$val.'" selected="selected">'.$key.'</option>';
                            }else{
                                echo '<option value="'.$val.'">'.$key.'</option>';
                            }

                        }
                        ?>
                    </select><br>
                    <label>(Meta) Title Tag</label><br>
                    <input class="form-control" type="text" id="page_title" name="page_title" value="<?php echo $page_title; ?>" required=""><br>
                    <label>(Meta) Category Description & Short Text</label><br><small>Try not to exceed 300 Characters.</small><br>
                    <textarea class="form-control" id="page_desc" name="page_desc"><?php echo $page_desc; ?></textarea>
                    <span class="counter-text" style="font-style: italic;color: #b1b0b0;">Characters left: 300</span><br><br>
                    <label>Category Image</label><br>
                    <div class="input-group col-md-12">

                        <input type="text" class="form-control" name="cat_img" id="cat_img" placeholder="No Image" value="<?php echo $cat_img; ?>">
                        <span class="input-group-btn">
        <button class="btn btn-primary img-browser" style="border: solid thin #ccc;background: #cccccc; color: #333;" data-setter="cat_img" type="button">Browse Images</button>
      </span>
                    </div>

                    <label>Drop Products & Categories Here</label><br>
                    <small>Below is the <span style="color: red">{prodcat}data{/prodcat}</span> You can move and adjust this token anywhere on the category page details.</small>

                    <?php

                    $trueArs = json_decode($equipmentArs,true);


                    for($s=0; $s <= count($trueArs); $s++){
                        if($trueArs[$s]["type"] == 'product'){
                            $theBlocks .= '<div class="dropitemsin" data-thedrop="'.$trueArs[$s]["title"].'" data-thedroptype="'.$trueArs[$s]["type"].'">Product: '.$trueArs[$s]["title"].' | <a href="javascript:void(0)" class="removeites"><i class="fa fa-trash" aria-hidden="true"></i> Remove</a></div>';
                        }

                        if($trueArs[$s]["type"] == 'category'){
                            $theBlocks .= '<div class="dropitemsin" data-thedrop="'.$trueArs[$s]["title"].'" data-thedroptype="'.$trueArs[$s]["type"].'">Category: '.$trueArs[$s]["title"].' | <a href="javascript:void(0)" class="removeites"><i class="fa fa-trash" aria-hidden="true"></i> Remove</a></div>';
                        }

                        if($trueArs[$s]["type"] == 'htmlarea'){
                            $theBlocks .= '<div class="dropitemsin" data-thedrop="'.$trueArs[$s]["title"].'" data-thedroptype="'.$trueArs[$s]["type"].'"><span class="isolatetext">HTML Widget:</span> | <button type="button" class="btn btn-xs btn-default minimodset" data-causedata="'.$trueArs[$s]["title"].'">Edit HTML</button> | '.$trueArs[$s]["title"].' | <a href="javascript:void(0)" class="removeites"><i class="fa fa-trash" aria-hidden="true"></i> Remove</a></div>';
                        }
                    }

                    ?>

                    <div class="droparea"><?php echo $theBlocks; ?></div>
                    <input type="hidden" id="dropped-info" name="dropped-info" value="">
                    <br>

                    <label>Page Details</label><br>
                    <textarea class="summernote" id="page_template" name="page_template"><?php echo $currTemplate; ?><?php echo $page_template; ?></textarea>
                    <?php echo $existPage; ?>
                    <br><br>
                    <button class="btn btn-success" onclick="savePage()">Save Page</button>
                </form>
            </div>


        </div>

        <div class="col-md-4">

            <?php

            $cats = $deere->getEquipmentProducts('','');

            for($o=0; $o<=count($cats); $o++){
                if($cats[$o]["title"] != null) {
                    $categoryOut .= '<div class="productitem" style="padding: 5px; text-align: center; background: #fff; margin: 5px; cursor:pointer" onclick="changeCats(\''.$cats[$o]["catname"].'\',\''.$cats[$o]["cattype"].'\')">' . $cats[$o]["title"] . ' <i class="fa fa-folder-open" aria-hidden="true"></i></div>';
                }
            }

            $realCats = $deere->getEqCats('');

            if($realCats != null) {
                for ($b = 0; $b <= count($realCats); $b++) {
                    if ($realCats[$b]["catname"] != null) {
                        $categoryOutReal .= '<div class="productitem draggable" data-thename="' . $realCats[$b]["catname"] . '" data-listtype="category" style="padding: 5px; text-align: center; background: #fff; margin: 5px; cursor:pointer"><div class="row"><div class="dragsa col-md-2" style="cursor:move; text-align: left"><img style="width: 6px" src="img/grip.png"></div><div class="col-md-10" style="text-align: left">' . $realCats[$b]["catname"] . '</div></div><div class="clearfix"></div></div>';
                    }
                }
            }else{
                $categoryOutReal = '<div class="col-md-12"><div class="box_message">No active categories.</div></div>';
            }


            ?>

            <div style="height: 160px"></div>
            <div style="background: #efefef; padding: 20px; margin: 3px"><div style="text-align: center"><h4>HTML Info</h4><small>Drag & drop html container to add html inside product container.</small></div><div class="productitem draggable" data-thename="" data-listtype="htmlarea" style="padding: 5px; text-align: center; background: #fff; margin: 5px; cursor:pointer"><div class="row"><div class="dragsa col-md-2" style="cursor:move; text-align: left"><img style="width: 6px" src="img/grip.png"></div> <div class="col-md-10" style="text-align: left"><i class="fa fa-list-alt" aria-hidden="true"></i> HTML Container</div></div><div class="clearfix"></div></div></div>
            <div style="background: #efefef; padding: 20px; margin: 3px"><h4 style="text-align: center">Created Categories</h4><div class="col-md-12">
                    <label>Sort by Type:</label><br>
                    <div style="width:100%;" class="btn-group thefilter" role="group" aria-label="Basic example">
                        <button style="width: 20%" type="button" class="btn btn-primary btn-xs btn-fill active filterbutton" onclick="filterCustomCats('all')">All</button>
                        <button style="width: 20%" type="button" class="btn btn-primary btn-xs btn-fill filterbutton" onclick="filterCustomCats('parent-category')">Parent</button>
                        <button style="width: 20%" type="button" class="btn btn-primary btn-xs btn-fill filterbutton" onclick="filterCustomCats('product-category')">Product</button>
                        <button style="width: 20%" type="button" class="btn btn-primary btn-xs btn-fill filterbutton" onclick="filterCustomCats('child-category')">Child</button>
                        <button style="width: 20%" type="button" class="btn btn-primary btn-xs btn-fill filterbutton" onclick="filterCustomCats('custom-category')">Custom</button>
                    </div>
                    <div class="input-group col-md-12" style="margin-top:10px">
                        <input type="text" style="background: #fff" class="form-control" name="cat_ser" id="cat_ser" placeholder="Search Categories" data-list=".custcats" autocomplete="off" value=""> <span class="input-group-btn"><button class="btn btn-primary ser-thcats" style="border: solid thin #ccc;background: #cccccc; color: #333;" type="button">Search</button></span></div></div><div class="custcats" style="height: 250px; overflow-y:scroll; width: 100%"><?php echo $categoryOutReal; ?></div></div>
            <div class="productslist" style="background: #efefef; padding: 20px; margin: 3px;"><h4 style="text-align: center">Browse Products</h4><?php echo $categoryOut; ?></div>
        </div>
        </div>
        <div class="clearfix"></div>

        <div id="js_editor" class="header">
            <h4 class="title">Page Javascript Events</h4>
            <p class="category">Place any javascript for this page here and not in footer..</p>
            <br>
            <p><a href="javascript:void(0)" class="js-toggle">Open JS Editor</a></p>
            <p>
                <?php if(isset($_POST["myjsCode"])){
                    file_put_contents('../js/'.$pageDetails["page_js"], $_POST["myjsCode"]);
                }
                ?>
            </p>
            <br><br>
            <form name="edit-cores" id="edit-cores" method="post" action="#js_editor" enctype="multipart/form-data" style="display: none">

                <?php $jsEvents = file_get_contents('../js/'.$pageDetails["page_js"]);?>

                <textarea class="my_codemirror_html" name="myjsCode" id="myjsCode"><?php echo $jsEvents; ?></textarea>
                <br><br>

                <button class="btn btn-primary btn-fill">Update JS</button><span class="jsloader" style="display: none"> | <img src="img/loader_sm.gif"> updating js ...</span>
                <br><br>
            </form>
            <!--START HISTORY EDITS-->
            <div class="clearfix"></div>
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Page History</h4>
                        <p class="category">You can restore up to the last 12 previous versions of the content by selecting restore and confirming reset.<br><strong>(NOTE!)</strong> Repositories do not contain page name, title tag and javascript settings.</p>
                        <br>
                        <div class="alert-warning reset-confirm" style="padding: 10px; display: none"></div>

                        <table class="table-bordered table">
                            <tr>
                                <th>Revision Date</th>
                                <th>Modified By</th>
                                <th style="text-align:right">Action</th>
                            </tr>
                            <tr>
                                <?php
                                $pageHistory = $site->getPageHistory($_REQUEST["eqid"]);
                                $wt=0;
                                for($i=0; $i<count($pageHistory); $i++){
                                    if($wt == 0){
                                        $bak = 'style="background:#fff"';
                                        $wt=1;
                                    }else{
                                        $bak = '';
                                        $wt=0;
                                    }


                                    if($pageHistory[$i]["codediff"] == 'true'){
                                        $codeRepo = '| <button class="btn btn-xs btn-default btn-fill" data-toggle="tooltip" title="View Code Changes" onclick="reviewSource(\''.$pageHistory[$i]["id"].'\')"><i class="fa fa-download" aria-hidden="true"></i> View Source Changes</button>';
                                    }else{
                                        $codeRepo = '';
                                    }

                                    echo '<tr '.$bak.'><td id="version_info_'.$pageHistory[$i]["id"].'" class="backup-items">'.date('m/d/Y H:i:s', $pageHistory[$i]["backup_date"]).'</td><td>'.$pageHistory[$i]["last_user"].'</td><td style="text-align:right"><button class="btn btn-xs btn-warning btn-fill" data-toggle="tooltip" title="Restore Version" onclick="restoreVersion(\''.$pageHistory[$i]["id"].'\')"><i class="fa fa-download" aria-hidden="true"></i> Restore</button> | <button class="btn btn-xs btn-primary btn-fill" onclick="openRevision(\''.$pageHistory[$i]["id"].'\')"><i class="fa fa-search" aria-hidden="true"></i> View Version</button> '.$codeRepo.'</td></tr>';
                                }
                                ?>
                            </tr>
                        </table>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>



        <script src="assets/js/jquery.sticky.js"></script>
        <script src="assets/js/jquery.hideseek.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>


        <script>
            function deletePage(){
                $("#myModalAS .modal-title").html('Confirm Actions');
                $("#myModalAS .modal-body").html('<h3>NOTICE!</h3><strong>Are you absolutely sure you want to do this?</strong><br><small>If you do delete this page, please remember to remove it out of your menu items as well otherwise you will receive a 404 when trying to view the page.</small><br><br><a href="edit-page.php?delete=true&id=<?php echo $_REQUEST["id"]; ?>" class="btn btn-danger">Yes Delete!</a> <button class="btn btn-primary" onClick="modalClose()">No I\'m just Kidding! I don\'t want to delete this page.</button>');
                $("#myModalAS").modal();
            }

            function modalClose(){
                $('#myModalAS').modal('hide')
            }

            function savePage(checkout){
                if(checkout == 'true'){$('#page-layout').prepend('<input type="hidden" name="checkout" id="checkout" value="true" />');}
                if($(".note-editor").hasClass('codeview')){
                    $( ".btn-codeview" ).trigger( "click" );
                }
                $("#page-layout").submit();
            }

            function openRevision(id){
                $.ajax({
                    url: 'inc/asyncCalls.php?action=captureversion&id='+id,
                    success: function(data){
                        $("#myModalAS .modal-body").html(data);
                        $(".modal-title").html('Review Version');
                        $(".modal-dialog").css('width','90%');
                        $("#myModalAS").modal();
                        $('.backup-items').css('background','none');
                        $('#version_info_'+id).css('background-color','#fcf8e3');
                    }
                })
            }

            function restoreVersion(id){
                var versioninfo = $('#version_info_'+id).html();
                $(".reset-confirm").html('<strong>NOTICE!</strong> - Are you sure you want to restore <strong style="text-decoration: underline ">'+versioninfo+'</strong> | <button class="btn btn-xs btn-default"  onClick="restoreVersionFin(\''+id+'\',\'page\')">Yes Restore</button> <button class="btn btn-xs btn-warning" onclick="cancelRevis()">Cancel </button>').slideDown('fast');
            }

            function cancelRevis(){
                $(".reset-confirm").empty().slideUp('fast');
                $('.backup-items').css('background','none');
            }

            function restoreVersionFin(id,type){
                $.ajax({
                    url: 'inc/asyncCalls.php?action=restoreversion&id='+id+'&type='+type,
                    success: function(data){
                        $(".reset-confirm").html(data);
                        $(".coversheet").show();
                        $(".load_holds").show();
                        setTimeout(function(){
                            var url = window.location.href;
                            location.href = url;
                        }, 5000);
                    }
                })
            }

            function lockPage(id){
                $.ajax({
                    dataType: "json",
                    url: 'inc/asyncCalls.php?action=lockpage&id='+id,
                    success: function(data){
                        if(data != 'issues'){
                            var newClass = data["button_class"];
                            if($('lockdown').hasClass( "btn-success")){
                                $('.lockdown').removeClass('btn-success');
                                $('.lockdown').addClass(newClass);
                                $(".lockdown").html(data["button_text"]);
                            }else{
                                $('.lockdown').removeClass('btn-danger');
                                $('.lockdown').addClass(newClass);
                                $(".lockdown").html(data["button_text"]);
                            }

                        }
                    }
                })
            }

            function reviewSource(id){
                $.ajax({
                    url: 'inc/asyncCalls.php?action=reviewcodes&id='+id,
                    success: function(data){
                        $("#myModalAS .modal-body").html(data);
                        $(".modal-title").html('Review Code Changes');
                        $(".modal-dialog").css('width','90%');
                        $("#myModalAS").modal();
                        $('.backup-items').css('background','none');
                        $('#version_info_'+id).css('background-color','#fcf8e3');
                    }
                })
            }

            $(function(){


                $('.my_codemirror_html').each(function(index, elem){
                    CodeMirror.fromTextArea(elem, {
                        mode: 'javascript',
                        theme: "mbo",
                        lineNumbers: true});
                });

                $(".js-toggle").on('click',function(){
                    $("#edit-cores").slideToggle();
                    var wh = $(".js-toggle").text();
                    if(wh == 'Open JS Editor'){
                        $(".js-toggle").text('Close JS Editor');
                    }else{
                        $(".js-toggle").text('Open JS Editor');
                    }

                })
            })

            function changeCats(catname,cattype){
                $.ajax({
                    type: "POST",
                    url: '<?php echo $modFolder; ?>/asyncData.php?action=getprodcats&catname='+catname+'&cattype='+cattype,
                    cache: false,
                    success: function(data){
                        $(".productslist").html(data);
                        $( ".draggable" ).draggable({
                            helper: 'clone',
                            handle: ".dragsa"
                        });
                    }
                })
            }

            function intDropable(){

                var array = [];
                $( ".droparea" ).droppable({
                    connectToSortable: '.droparea',
                    drop: function( event, ui ) {
                        var thistype = ui.draggable.data('listtype');
                        var nameout = ui.draggable.data('thename');
                        if(nameout != undefined) {
                            if (thistype == 'product') {
                                var nowtype = 'Product: ';
                            }
                            if(thistype == 'category') {
                                var nowtype = 'Category: ';
                            }
                            if(thistype == 'htmlarea') {
                                var dt = new Date($.now());
                                nameout = md5(dt);
                                nameout = nameout.substring(0, 8);

                                $.ajax({
                                    url:'inc/asyncCalls.php?action=createbean&beanname=productbean&bean_id='+nameout,
                                    success: function(data){
                                        console.log('Completed');
                                        runMiniEdits();
                                    }
                                })

                                var nowtype = '<span class="isolatetext">HTML Widget:</span> | <button type="button" class="btn btn-xs btn-default minimodset" data-causedata="'+nameout+'">Edit HTML</button> | ';
                            }
                            $(".droparea").append('<div class="dropitemsin" data-thedrop="'+nameout+'" data-thedroptype="'+thistype+'">' + nowtype + '' + nameout + ' | <a href="javascript:void(0)" class="removeites"><i class="fa fa-trash" aria-hidden="true"></i> Remove</a></div>');
                        }

                        //dropped-info
                        $('.droparea > .dropitemsin').each(function(){



                            array.push({
                                title: $(this).data('thedrop'),
                                type: $(this).data('thedroptype')
                            });
                        });
                        var jsonString = JSON.stringify(array);
                        //console.log(jsonString);
                        $("#dropped-info").empty();
                        $("#dropped-info").val(jsonString);
                        array = [];
                        setRemoves();
                    }
                });

                $( ".droparea" ).sortable({
                    containment: "parent",
                    stop: function(event,ui){
                        $('.droparea > .dropitemsin').each(function(){

                            array.push({
                                title: $(this).data('thedrop'),
                                type: $(this).data('thedroptype')
                            });
                        });
                        var jsonString = JSON.stringify(array);
                        $("#dropped-info").empty();
                        $("#dropped-info").val(jsonString);
                        array = [];
                    }
                });
            }

            function onloadFun(){
                alert('sdfsdf')
                $( ".draggable" ).draggable({
                    helper: 'clone',
                    handle: ".dragsa"
                });

                intDropable();
            }

            function setRemoves(){
                $(".removeites").on('click',function(){
                    $(this).parent().remove();
                    var array = [];
                    //dropped-info
                    $('.droparea > .dropitemsin').each(function(){
                        array.push({
                            title: $(this).data('thedrop'),
                            type: $(this).data('thedroptype')
                        });
                    });
                    var jsonString = JSON.stringify(array);
                    //console.log(jsonString);
                    $("#dropped-info").empty();
                    $("#dropped-info").val(jsonString);
                    array = [];
                })
            }

            $(function(){
                var array = [];
                onloadFun();
                runMiniEdits();
                setRemoves();
                $('.droparea > .dropitemsin').each(function(){

                    array.push({
                        title: $(this).data('thedrop'),
                        type: $(this).data('thedroptype')
                    });
                });
                var jsonString = JSON.stringify(array);
                $("#dropped-info").empty();
                $("#dropped-info").val(jsonString);
                array = [];
            })

            function runMiniEdits(){
                console.log('Open Edit');
                $(".minimodset").on('click',function(){
                    var beanName = $(this).data('causedata');


                    ///MINIMOD edit-content.php?id=3&minimod=true///
                    $.ajax({
                        url: 'inc/asyncCalls.php?action=minimod&beanid='+beanName,
                        success: function(data){
                            $("#myModal .modal-body").html(data);
                            $("#myModal").modal();
                            $(".modal-dialog").css('width','70%');

                        }
                    })
                })

            }

            $(function(){
                $(".img-browser").on('click',function(){
                    var itemsbefor = $(this).data('setter');
                    $("#myModalAS .modal-title").html('Select an Image For Link');
                    $("#myModalAS .modal-body").html('<iframe id="themedia" style="width: 100%; height: 450px; border: none" src="filedfiles.php?typeset=simple&fldset='+itemsbefor+'"></iframe>');
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
            })

            function passImage(imgpath,fld){
                $("#"+fld).val(imgpath);
                $("#myModalAS").modal('hide');
            }

            $(function(){
                $('#cat_ser').hideseek({
                    highlight: true
                });
            })

            function openHelpCat(){
                $(".cat_help").toggle();
            }



            function filterCustomCats(type){
                $.ajax({
                    url: '<?php echo $modFolder; ?>/asyncData.php?action=filtercustomcats&filter='+type,
                    success: function(data){
                        $(".custcats").html(data);
                        $( ".draggable" ).draggable({
                            helper: 'clone',
                            handle: ".dragsa"
                        });

                    }
                })
            }

            $(function(){
                $(".filterbutton").on('click',function(){

                    $('.filterbutton').each(function(i, obj) {
                        $(this).removeClass('active');
                    });

                    $(this).addClass('active');
                })
            })

        </script>

        <?php

        ?>



        <?php }else{ ///SHOW LIST VIEW ?>



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





                    <div class="header">
                        <img style="margin: 15px 0px;float: right;" src="img/deere_logo.png">
                        <div class="clearfix"></div>
                        <h4 class="title">Deere Category Templates</h4>
                        <p class="category">Here are your sites custom Deere categories.<br></p>


                        <?php
                        $pageCheck = $deere->checkPages();

                        if($pageCheck == true){
                            $pageButton = '';
                        }else{
                            $pageButton = '<button class="btn btn-danger inspg" style="float:right; margin: 20px; background: #EB5E28; color: #fff;" onclick="processsPages()">Install Page Data</button>';
                        }
                        ?>

                        <?php
                        if($deere->checkUpdates() != null){

                            $updateInfo = $deere->checkUpdates();


                            $updateButton = '<button class="btn btn-danger btn-fill animated pulse infinite" style="margin: 20px 0px" onclick="openUpdatePanel()"><i class="ti-cloud-down"></i> Updates Available.</button>';
                            echo '<input name="package_file" id="package_file" type="hidden" value="'.$updateInfo["packagefile"].'">';
                            echo '<input name="update_date" id="update_date" type="hidden" value="'.date('m/d/Y h:is',$updateInfo["updatedate"]).'">';
                            echo '<input name="update_notes" id="update_notes" type="hidden" value="'.$updateInfo["updatnotes"].'">';
                            echo '<input name="version" id="version" type="hidden" value="'.$updateInfo["versioninfo"].'">';
                        }else{
                            $updateButton = '';
                        }
                        ?>




                        <div class="col-md-6" style="padding: 0"><?php echo $updateButton; ?></div>

                        <div class="col-md-6" style="text-align: right">
                        <?php echo $pageButton; ?> <button class="btn btn-warning btn-fill mod-prods" style="margin: 20px">Manage Products</button> <a href="<?php echo $_SERVER['REQUEST_URI']; ?>&createnew=true" class="btn btn-success btn-fill" style="margin: 20px">Create New Category</a>
                        </div>
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

                                    if($pages[$i]["page_lock"] == 'User' || $pages[$i]["page_lock"] == 'false' || $pages[$i]["page_lock"] == 'none' || $pages[$i]["page_lock"] == ''){
                                        if($userArray["user_type"] == 'Developer' || $userArray["user_type"] == 'Admin' || $userArray["user_type"] == 'User' || $pages[$i]["page_lock"] == 'false' || $pages[$i]["page_lock"] == 'none' || $pages[$i]["page_lock"] == ''){
                                            if($pages[$i]["check_out"] == ''){
                                                $editCon = '<a href="'.$_SERVER['REQUEST_URI'].'&editview=true&eqid='.$pages[$i]["id"].'" style="" class="btn btn-xs btn-success"><i class="ti-check"></i> Checkout</a>';
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






<script>
    function changeCats(catname,cattype){
        $.ajax({
            type: "POST",
            url: '<?php echo $modFolder; ?>/asyncData.php?action=getprodcatsedits&catname='+catname+'&cattype='+cattype,
            cache: false,
            success: function(data){
                $(".modprodshold").html(data);
            }
        })
    }

    $(function(){
        $(".mod-prods").on('click',function(){
            $.ajax({
                url: '<?php echo $modFolder; ?>/asyncData.php?action=modprods',
                success:function(data){
                    $("#myModal .modal-body").html(data);
                    $("#myModal .modal-title").html('Manage Deere Products');
                    $("#myModal").modal();
                    $(".modal-dialog").css('width','70%');
                }
            })
        })
    })



    function openProduct(prod,cat){
        $(".modprodshold").html('<iframe id="prodedits" style="width: 100%; height: 100vh; border: none" src="<?php echo $modFolder; ?>/product_mod.php?prod='+prod+'&cat='+cat+'"></iframe>');
    }

    function addNewCats(){
        ///addneweq
        $.ajax({
            url: '<?php echo $modFolder; ?>/asyncData.php?action=addneweq',
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
                    url: "<?php echo $modFolder; ?>/asyncData.php?action=processEquip",
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

    function processsPages(){
        $(".inspg").html('Installing Page Data... <img style="width: 18px; padding: 1px;" src="installed_beans/deere_plugin/loading.gif"> ');
        $.ajax({
            url: '<?php echo $modFolder; ?>/asyncData.php?action=pullpages',
            success:function(data){
                $(".inspg").remove();
                alert(data);
            }
        })
    }

    function openUpdatePanel(){

        var package_file = $("#package_file").val();
        var update_date = $("#update_date").val();
        var update_notes = $("#update_notes").val();
        var version = $("#version").val();

        $("#myModal .modal-body").html('<h2>Deere Plugin Updates</h2><br><small><i>Release Date: '+update_date+' Version: '+version+'</i></small><br><br>'+update_notes+'<br><div style="display: none; padding: 10px; background: #efefef;" class="loadarea"><br><div class="progress" style="height: 2px;">\n' +
            '  <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>\n' +
            '</div> <small class="info-loads">Updating plugin please wait...</small></div><br><button class="btn btn-primary updtrbutton" onclick="getupdatepackage(\''+package_file+'\')">Install Updates.</button>');
        $("#myModal .modal-title").html('Update Deere Plugin');
        $(".modal-dialog").css('width','30%');
        $("#myModal").modal();
    }


    function getProgress() {
        var intervalInMS = 200;
        var doneDelay = intervalInMS * 2;
        var bar = $('.progress-bar');
        var percent = 0;
        var durationInMs = 38000;

        var interval = setInterval(function updateBar() {
            percent += 100 * (intervalInMS/durationInMs);
            bar.css({width: percent + '%'});
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

    var duration = 1000;  // in milliseconds
    function onDone() {
        $(".info-loads").html('Plugin Successfully Updated. You can now close this window.');
        location.reload();
    }



    function getupdatepackage(packageurl){

        $(".loadarea").show();
        $(".updtrbutton").hide();
        getProgress();

        $.ajax({
            url: '<?php echo $modFolder; ?>/asyncData.php?action=pullupdates&pack='+packageurl,
            cache:false,
            success:function(data){
                console.log(data);
            }
        })
    }

</script>

<?php } } ?>
