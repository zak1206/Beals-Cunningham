<?php
echo"workbitchhhh"
?>
<div class="header">
    <?php echo "sneha"; ?>
    <h4 class="title">Create New Equipment Category</h4>
    <p class="category">Use this to create custom categories for equipment.</p>

    <button class="btn btn-primary btn-success" style="float: right; margin:3px" type="button" onclick="openContent()"><i class="ti-layers"></i> Open Content / Plugins</button>
    <div class="clearfix"></div>
</div>
<div class="content table-responsive table-full-width">
    <form class="validforms" id="page-layout" name="page-layout" style="padding: 20px" method="post" action="">
        <input type="hidden" name="line_type" id="line_type" value="custom">
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
        <div class="input-group mb-3">
            <input type="text" class="form-control" name="cat_img" id="cat_img" placeholder="No Image" aria-label="Category Image" value="<?php echo $catImg; ?>">
            <div class="input-group-append">
                <button class="btn btn-success img-browser" data-setter="cat_img" type="button">Browse Images</button>
            </div>
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
        <input type="hidden" id="dropped-info" name="dropped-info" value="<?php echo $equipmentArs;?>">
        <br>

        <label>Page Details</label><br>
        <textarea class="summernote" id="page_template" name="page_template"><?php echo $currTemplate; ?><?php echo $page_template; ?></textarea>
        <?php echo $existPage; ?>
        <br><br>
        <button class="btn btn-success" onclick="savePage()">Save Page</button>
    </form>
</div>