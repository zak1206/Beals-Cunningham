<?php
$act = $_REQUEST["action"];
include('../../inc/caffeine.php');
$site = new caffeine();
$userArray = $site->auth();
include('functions.php');
$honda = new hondaClass();


if($act == 'openproduct'){

    $product = $honda->getProduct($_REQUEST["prod"]);
    //var_dump($product);
    $html .= '<h2>'.$product["title"].'</h2>';
    $html .= '<img class="img-thumbnail" style="max-width: 300px;" src="../img/'.$product["eq_image"].'">';
    $html .= '<div class="clearfix"></div><br><br>';
    $html .= '<div class="row">';
    $html .= '<label>Category Image</label><br>
                                    <div class="input-group col-md-12">

                                        <input type="text" class="form-control" name="cat_img" id="cat_img" placeholder="No Image" value="'.$product["eq_image"].'">
                                        <span class="input-group-btn">
        <button class="btn btn-primary img-browser" style="border: solid thin #ccc;background: #cccccc; color: #333;" data-setter="cat_img" type="button">Browse Images</button>
      </span>
                                    </div>';
    $html .= '<label>Price:</label><br><input class="form-control" name="pricepoint" id="pricepoint" type="text" value="'.$product["price"].'">';

    $html .= '<br><br><p>Below you can turn on and off each product section fed by Stihl.</p>';
    $html .= '<div class="col-md-4"><label>Quick Links</label><br><span class="quick-links" style="font-size: 40px;color: #21d021;"><i class="fa fa-toggle-on fa-3" aria-hidden="true"></i></span></div>';
    $html .= '<div class="col-md-4"><label>Offers & Discounts</label><br><span class="offers-links" style="font-size: 40px;color: #21d021;"><i class="fa fa-toggle-on fa-3" aria-hidden="true"></i></span></div>';
    $html .= '<div class="col-md-4"><label>Videos</label><br><span class="videos-links" style="font-size: 40px;color: #21d021;"><i class="fa fa-toggle-on fa-3" aria-hidden="true"></i></span></div>';
    $html .= '<div class="col-md-4"><label>Accessories & Attachments</label><br><span class="videos-links" style="font-size: 40px;color: #21d021;"><i class="fa fa-toggle-on fa-3" aria-hidden="true"></i></span></div>';
    $html .= '<div class="clearfix"></div>';
    $html .= '<div class="col-md-12"><label>Promotion / Additional Info Area. </label><br><small>This area is located between the product image and features area.</small><br><textarea class="summernotes" id="promoarea" name="promoarea"></textarea></div>';
    $html .= '</div>';
    $html .= '<div class="clearfix"></div>';

    echo $html;

}

if($act == 'addneweq'){
    $html .= '<div class="row">';

    $html .= '<form name="processurlform" id="processurlform" method="post" action="">';

    $parentCats = $honda->getcats('parent_cat');
    for($o=0; $o<=count($parentCats); $o++){if($parentCats[$o]["cat"] != ''){$parent .= '<option value="'.$parentCats[$o]["cat"].'">'.$parentCats[$o]["cat"].'</option>';}}

    $html .= '<div class="col-md-2"><label>Parent Category</label><div class="parent_cat_holder"><select class="selectpicker" name="parent_cat" id="parent_cat" required><option value="">Select Option</option>'.$parent.'</select></div></div>';

    $cat_one = $honda->getcats('cat_one');
    for($p=0; $p<=count($cat_one); $p++){if($cat_one[$p]["cat"] != ''){$sec .= '<option value="'.$cat_one[$p]["cat"].'">'.$cat_one[$p]["cat"].'</option>';}}

    $html .= '<div class="col-md-2"><label>Second Category</label><select class="selectpicker" name="cat_one" id="cat_one" required><option value="">Select Option</option>'.$sec.'</select></div>';

    $cat_two = $honda->getcats('cat_two');
    for($q=0; $q<=count($cat_two); $q++){if($cat_two[$q]["cat"] != ''){$third .= '<option value="'.$cat_two[$q]["cat"].'">'.$cat_two[$q]["cat"].'</option>';}}

    $html .= '<div class="col-md-2"><label>Third Category</label><select class="selectpicker" name="cat_two" id="cat_two"><option>Select Option</option>'.$third.'</select></div>';

    $cat_three = $honda->getcats('cat_three');
    for($r=0; $r<=count($cat_three); $r++){if($cat_three[$r]["cat"] != ''){$fourth .= '<option value="'.$cat_three[$r]["cat"].'">'.$cat_three[$r]["cat"].'</option>';}}

    $html .= '<div class="col-md-2"><label>Fourth Category</label><select class="selectpicker" name="cat_three" id="cat_three"><option>Select Option</option>'.$fourth.'</select></div>';

    $cat_four = $honda->getcats('cat_four');
    if(!empty($cat_four) ){
        for ($s = 0; $s <= count($cat_four); $s++) {
            if ($cat_four[$s]["cat"] != '') {
                $five .= '<option value="' . $cat_four[$s]["cat"] . '">' . $cat_four[$s]["cat"] . '</option>';
            }
        }

        $html .= '<div class="col-md-2"><label>Fourth Category</label><select class="form-control" name="cat_four" id="cat_four"><option>Select Option</option>' . $five . '</select></div>';
    }

    $html .= '<div class="col-md-12" style="margin-top:20px"><label>Stihl URL</label><input type="text" class="form-control" name="stihl_url" name="stihl_url" value="" placeholder="Copy and Paste Stihl Equipment URL Here..." required></div>';

    $html .= '<div class="col-md-12" style="text-align: right; margin-top:20px"><button class="btn btn-success btn-fill">Process</button></div>';

    $html .= '</form>';

    $html .='</div>';

    echo $html;
}

if($act == 'processEquip'){
    $honda->processSingleEquipment($_POST);
}

if($act == 'modprods'){

    $categoryOut = '<br><br><h4 class="title" style="color: #eb5e29">Manage Stihl Products</h4><p class="category">Here you can manage Stihl products and add new products as they are added to the Stihl site.<br></p>';

    //$categoryOut .= '<div style="text-align: right"><button class="btn btn-default btn-fill" onclick="addNewCats()">Add New Stihl Product</button></div><br><br>';

    $categoryOut .= '<div class="modprodshold">';

    $cats = $honda->getEquipmentProducts('','');

    for($o=0; $o<=count($cats); $o++){
        if($cats[$o]["title"] != null) {
            $categoryOut .= '<div class="productitem" style="padding: 5px; text-align: left; background: #d4d4d4; margin: 5px; cursor:pointer; font-size:18px" onclick="changeCats(\''.$cats[$o]["catname"].'\',\''.$cats[$o]["cattype"].'\')"><div class="row"><div class="col-md-8">' . $cats[$o]["title"] . '</div><div class="col-md-4" style="text-align: right">EDIT</div></div><div class="clearfix"></div></div>';
        }
    }

    $categoryOut .= '</div>';


    echo $categoryOut;
}

if($act == 'getprodcats'){
    //echo $_REQUEST["cattype"].$_REQUEST["catname"];

    if($_REQUEST["cattype"] != null && $_REQUEST["catname"] != null){



        $cats = $honda->getEquipmentProducts($_REQUEST["cattype"],$_REQUEST["catname"]);

        $categoryOut .= '<h4 style="text-align: center">'.$_REQUEST["catname"].'</h4>';


        $backLins = $honda->getBackLink($_REQUEST["cattype"],$_REQUEST["catname"]);

        //var_dump($backLins);

        for($o=0; $o<=count($cats); $o++){
            if($cats[$o]["title"] != null) {
                if($cats[$o]["isproduct"] == true){
                    $categoryOut .= '<div class="productitem draggable" style="padding: 5px; background: #fff; margin: 5px;" data-thename="'.$cats[$o]["catname"].'" data-listtype="product"><div class="dragsa col-md-2" style="cursor:move;"><img style="width: 6px" src="img/grip.png"></div><div class="col-md-10">' . $cats[$o]["catname"] . ' <i class="fa fa-arrows" aria-hidden="true"></i></div><div class="clearfix"></div>
</div>';
                }else{
                    $categoryOut .= '<div class="productitem" style="padding: 5px; text-align: center; background: #fff; margin: 5px; cursor:pointer; white-space: nowrap;overflow: hidden; text-overflow: ellipsis;" onclick="changeCats(\''.$cats[$o]["catname"].'\',\''.$cats[$o]["cattype"].'\')">' . $cats[$o]["catname"] . ' <i class="fa fa-folder-open" aria-hidden="true"></i></div>';
                }

            }
        }

        $categoryOut .= '<div style="text-align: right"><a href="javascript:void(0)" class="btn btn-warning btn-sm btn-fill" onclick="changeCats(\''.$backLins["catname"].'\',\''.$backLins["cattype"].'\')"><i class="fa fa-angle-left" aria-hidden="true"></i> Go Back</a></div>';

    }else{

        $categoryOut .= '<h4 style="text-align: center">Browse Products</h4>';

        $cats = $honda->getEquipmentProducts('','');

        for($o=0; $o<=count($cats); $o++){
            if($cats[$o]["title"] != null) {
                $categoryOut .= '<div class="productitem" style="padding: 5px; text-align: center; background: #fff; margin: 5px; cursor:pointer" onclick="changeCats(\''.$cats[$o]["catname"].'\',\''.$cats[$o]["cattype"].'\')">' . $cats[$o]["title"] . ' <i class="fa fa-folder-open" aria-hidden="true"></i></div>';
            }
        }
    }

    echo $categoryOut;
}

if($act == 'getprodcatsedits'){
    //echo $_REQUEST["cattype"].$_REQUEST["catname"];

    if($_REQUEST["cattype"] != null && $_REQUEST["catname"] != null){



        $cats = $honda->getEquipmentProducts($_REQUEST["cattype"],$_REQUEST["catname"]);

        $categoryOut .= '<h4 style="text-align: center">'.$_REQUEST["catname"].'</h4>';


        $backLins = $honda->getBackLink($_REQUEST["cattype"],$_REQUEST["catname"]);

        //var_dump($backLins);

        for($o=0; $o<=count($cats); $o++){
            if($cats[$o]["title"] != null) {
                if($cats[$o]["isproduct"] == true){
                    $categoryOut .= '<div class="productitem" style="padding: 5px; text-align: left; background: #d4d4d4; margin: 5px; cursor:pointer; font-size:18px" onclick="openProduct(\''.$cats[$o]["catname"].'\',\''.$cats[$o]["cattype"].'\')"><div class="row"><div class="col-md-8">' . $cats[$o]["title"] . '</div><div class="col-md-4" style="text-align: right">EDIT</div></div><div class="clearfix"></div></div>';
                }else{
                    $categoryOut .= '<div class="productitem" style="padding: 5px; text-align: left; background: #d4d4d4; margin: 5px; cursor:pointer; font-size:18px" onclick="changeCats(\''.$cats[$o]["catname"].'\',\''.$cats[$o]["cattype"].'\')"><div class="row"><div class="col-md-8">' . $cats[$o]["title"] . '</div><div class="col-md-4" style="text-align: right">EDIT</div></div><div class="clearfix"></div></div>';
                }

            }
        }

        $categoryOut .= '<div style="text-align: right"><a href="javascript:void(0)" class="btn btn-warning btn-sm btn-fill" onclick="changeCats(\''.$backLins["catname"].'\',\''.$backLins["cattype"].'\')"><i class="fa fa-angle-left" aria-hidden="true"></i> Go Back</a></div>';

    }else{

        $categoryOut .= '<h4 style="text-align: center">Browse Products</h4>';

        $cats = $honda->getEquipmentProducts('','');

        for($o=0; $o<=count($cats); $o++){
            if($cats[$o]["title"] != null) {
                $categoryOut .= '<div class="productitem" style="padding: 5px; text-align: left; background: #d4d4d4; margin: 5px; cursor:pointer; font-size:18px" onclick="changeCats(\''.$cats[$o]["catname"].'\',\''.$cats[$o]["cattype"].'\')"><div class="row"><div class="col-md-8">' . $cats[$o]["title"] . '</div><div class="col-md-4" style="text-align: right">EDIT</div></div><div class="clearfix"></div></div>';
            }
        }
    }

    echo $categoryOut;
}

if($act == 'filtercustomcats'){
    $realCats = $honda->getEqCats($_REQUEST["filter"]);

    if($realCats != null) {
        for ($b = 0; $b <= count($realCats); $b++) {
            if ($realCats[$b]["catname"] != null) {
                $categoryOutReal .= '<div class="productitem draggable" data-thename="' . $realCats[$b]["catname"] . '" data-listtype="category" style="padding: 5px; text-align: center; background: #fff; margin: 5px; cursor:pointer"><div class="row"><div class="dragsa col-md-2" style="cursor:move; text-align: left"><img style="width: 6px" src="img/grip.png"></div><div class="col-md-10" style="text-align: left">' . $realCats[$b]["catname"] . '</div></div><div class="clearfix"></div></div>';
            }
        }
    }else{
        $categoryOutReal = '<div class="col-md-12"><div class="box_message">No active categories.</div></div>';
    }

    echo $categoryOutReal;
}

if($act == 'pullpages'){
    $res = $honda->getSetupPages();

    if($res == 'good'){
        echo 'Stihl Pages Installed Successfully';
    }else{
        echo 'Something went wrong. Please review API.';
    }

}

if($act == 'pullupdates'){
    echo $honda->getUpdatePackage($_REQUEST["pack"]);

}

if($act == 'createbean'){
    $honda->createEqBean($_REQUEST["bean_id"]);
}

if($act == 'minimod'){

    $theBean = $site->checkBean($_REQUEST["beanid"]);

    if(!(empty($theBean))){
        //edit-content.php?id=3&minimod=true
        echo '<iframe src="../../edit-content-mini.php?id='.$theBean["id"].'&minimod=true" style="width:100%; height:400px; border:0; resize: vertical;"></iframe>';
    }else{
        echo '<div class="alert alert-danger">Sorry! - No content was found for token.</div>';
    }

}