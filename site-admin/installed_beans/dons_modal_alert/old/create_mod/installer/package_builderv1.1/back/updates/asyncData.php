<?php
if(file_exists('../../inc/harness.php')){
    include('../../inc/harness.php');
}else{
    include('inc/harness.php');
}

include('functions.php');
$tractorstuff = new packageclass();
$act = $_REQUEST["action"];

if($act == 'newpackageform') {
    $html = '<div class="row search-container">
                <div class="col-md-8">
                    <label>Search Equipment</label><br>
                    <input name="searchtext" id="searchtext" type="text" class="form-control" placeholder="i.e. 1023e 2025r" />
                </div>
                 <div class="col-md-4">
                    <button type="button" class="btn btn-success" onclick="searchEquip()" style="margin-top: 30px;">Search</button>
                 </div>
                 <div class="col-md-12 equip-search-results"></div>
             </div>
             <div id="form-container" class="row"></div>';

    echo $html;
}

if($act == 'getcategories') {
        $maincats = $tractorstuff->getMainCategories();
//       
    $html .= '<div class="row"><div class="col-md-12"><h2>Categories</h2></div></div><div class="row">';

    for($i = 0; $i < count($maincats); $i++) {
        $html .= '<div class="col-md-4" style="margin-bottom: 20px;"><div class="card"><img src="../../../'.$maincats[$i]["package_image"].'" class="img-responsive" style="width: 100%;"><h3 class="text-center" style="background-color: #333; color: white; margin-bottom: 0; padding: 4px 10px;">'.$maincats[$i]["package_name"].'</h3></div><div style="width: 100%;" class="btn-group" role="group" aria-label="Basic example">
  <button style="width: 50%;" type="button" class="btn btn-primary" onclick="editMainCat('.$maincats[$i]["id"].')"><i class="fa fa-edit"></i></button>
  <button style="width: 50%; background: #F8CE54; border-color: #F8CE54;" type="button" class="btn btn-danger" onclick="confirmMainCatDel('.$maincats[$i]["id"].')"><i class="fa fa-minus-circle"></i></button>
</div></div>';
    }

    $html .= '</div>';


    echo $html;
}

if($act == 'editcategory'){
    $id = $_REQUEST["id"];
    $getmaincat = $tractorstuff->getMainCat($id);


    $html = '<h2>Edit Category</h2><form id="editcatform" name="editcatform" method="post" action="">
                <div class="col-md-12">
                <label>Category Name</label>
                <input class="form-control" type="text" name="pack_name" id="pack_name" value="'.$getmaincat["package_name"].'" required>
                </div>
                <div class="col-md-12">
                <label>Category Image</label>
                <div class="input-group mb-3">
                        <input type="text" class="form-control" name="cat_img" id="cat_img" placeholder="No Image" aria-label="Category Image" value="'.$getmaincat["package_image"].'" required>
                        <div class="input-group-append">
                            <button class="btn btn-success img-browser" data-setter="cat_img" type="button">Browse Images</button>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-12">
                <label>Description</label>
                <textarea  class="form-control" name="pack_descr" id="pack_descr">'.$getmaincat["package_description"].'</textarea>
                <input type="hidden" name="id" value="'.$getmaincat["id"].'">
                </div>
                <div class="col-md-12">
                <button type="submit" class="btn btn-success" style="margin-top: 20px; background: #F8CE54;">Update Category</button>
                </div>
            </form>';

    echo $html;
}

if($act == 'finishcatedit') {
    $a = $tractorstuff->finishCatEdit($_POST);
}

if($act == 'addnewcat') {
    $a = $tractorstuff->finishCatAdd($_POST);
}

if($act == 'createnewcategory'){
    $html = '<h2>Create Category</h2><form id="addcatform" name="addcatform" method="post" action="">
                <div class="col-md-12">
                <label>Category Name</label>
                <input class="form-control" type="text" name="new_pack_name" id="new_pack_name" value="" required>
                </div>
                <div class="col-md-12">
                <label>Category Image</label>
                <div class="input-group mb-3">
                        <input type="text" class="form-control" name="new_cat_img" id="new_cat_img" placeholder="No Image" aria-label="Category Image" value="" required>
                        <div class="input-group-append">
                            <button class="btn btn-success img-browser" data-setter="new_cat_img" type="button">Browse Images</button>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-12">
                <label>Description</label>
                <textarea  class="form-control" name="new_pack_descr" id="new_pack_descr"></textarea>
                </div>
                <div class="col-md-12">
                <button type="submit" class="btn btn-success" style="margin-top: 20px; background: #F8CE54;">Create Category</button>
                </div>
            </form>';

    echo $html;
}

if($act == 'getusage') {
    $html = '<h2>Usage</h2><p>To display the job board, copy/paste the code below into a page<br>
{mod}package_configurator-packageCall-1{/mod}</p>';

    echo $html;
}



if($act == 'getsubs') {
    $value = $_REQUEST["value"];
    $getsubcats = $tractorstuff->getSubCategories($value);
        $html .= '<option>Choose An Option</option>';

    foreach($getsubcats as $val) {
        $html .= '<option value ="'.$val.'">'.$val.'</option>';
    }

   echo $html;
}

if($act == 'getsubsedit') {
    $value = $_REQUEST["value"];
    $id = $_REQUEST["id"];
    $getsubcats = $tractorstuff->getSubCategories($value);
    $packageinfo = $tractorstuff->getPackage($id);

    foreach($getsubcats as $val) {
        if($packageinfo["sub_category"] == $val) {
            $html .= '<option value="'.$val.'" selected>'.$val.'</option>';
        } else {
            $html .= '<option value="' . $val . '">' . $val . '</option>';
        }
    }

    echo $html;
}

if($act == 'createaddform') {
    if(file_exists('../../inc/harness.php')){
        include('../../inc/harness.php');
    }else{
        include('inc/harness.php');
    }
    $equipid = $_REQUEST["equipid"];

    $equipmentinfo = $tractorstuff->getEquipment($equipid);

    $equiptitle = $equipmentinfo["title"];

    $html = '<div class="col-md-8">
                 <form name="addpackage" id="addpackage" method="post" action="">
                <div class="row">
                    <div class="col-md-12">
                        <input type="hidden" name="equipment_id" id="equipment_id" value="'.$equipmentinfo["title"].'">
                        <label>Package Title</label>
                        <input type="text" name="equip_title" id="equip_title" value="'.$equipmentinfo["title"].'" class="form-control"/>
                    </div>
                    <div class="col-md-6">
                         <label>MSRP</label>
                         <input type="number" name="price" id="price" value="'.$equipmentinfo["price"].'" class="form-control">
                    </div>
                    <div class="col-md-6">
                         <label>Dealer Price</label>
                         <input type="number" name="dealer_price" id="dealer_price"  value="'.$equipmentinfo["dealer_price"].'" class="form-control">
                    </div>
                    <div class="col-md-6">
                         <label>Package Category</label>
                         <select name="package_cat" id="package_cat"  class="form-control" onchange="getSubCats()" required>
                            <option value="">Select An Option</option>';
                            $getcats = $tractorstuff->getCategories();
                            foreach($getcats as $value) {
                                $html .= '<option value="'.$value.'">'.$value.'</option>';
                            }

                        $html .= '</select>
                    </div>
                    <div class="col-md-6">
                     <label>Sub Category</label>
                        <select name="package_sub" id="package_sub"  class="form-control">
                            <option value="">Select An Option</option>';


                       $html .= '</select>
                    </div>
                    <div class="col-md-6">
                         <label>Create New Sub-Category</label>
                         <input class="form-control" name="new-sub-cat" id="new-sub-cat" value="">
                      </div>
                    <div class="col-md-12">
                            <input type="hidden" name="equip_id" id="equip_id" value="'.$equipmentinfo["id"].'">
                         <input type="hidden" name="lines" id="lines" value="">
                         <label>Implements Included</label>
                            <div id="implements" class="droparea ui-droppable ui-sortable" style="background: #efefef; border:dashed thin #a0a0a0; padding: 30px;"></div>
                         <label>Attachments Included</label>
                        <div id="attachments" class="droparea ui-droppable ui-sortable" style="background: #efefef; border:dashed thin #a0a0a0; padding: 30px;"></div>
                    </div>
                    <button type="submit" class="btn btn-primary" style="margin-top: 20px;">Add Package</button>
                    </div>
                </form>
                </div>';

               include ('line-sidebar.php');
    $html .= '</div>';

    echo $html;

}

if($act == 'editpackage') {
    if(file_exists('../../inc/harness.php')){
        include('../../inc/harness.php');
    }else{
        include('inc/harness.php');
    }
    $id = $_REQUEST["id"];

    $packageinfo = $tractorstuff->getPackage($id);

    $equiptitle = $packageinfo["equip_id"];

    $html = '<h2>Edit Package</h2><div class="row"><div class="col-md-8">
                 <form name="editpackage" id="editpackage" method="post" action="">
                <div class="row">
                    <div class="col-md-12">
                        
                        <label>Package Title</label>
                        <input type="text" name="equip_title_edit" id="equip_title_edit" value="'.$packageinfo["equipment_title"].'" class="form-control" required/>
                    </div>
                    <div class="col-md-6">
                         <label>MSRP</label>
                         <input type="number" name="price_edit" id="price_edit" value="'.$packageinfo["msrp"].'" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                         <label>Dealer Price</label>
                         <input type="number" name="dealer_price_edit" id="dealer_price_edit"  value="'.$packageinfo["price"].'" class="form-control">
                    </div>
                    <div class="col-md-6">
                         <label>Package Category</label>
                         <select name="package_cat_edit" id="package_cat_edit"  class="form-control" onchange="changeSubCats()" required>
                            <option value="">Select An Option</option>';
                    $getcats = $tractorstuff->getCategories();
                    foreach($getcats as $value) {
                        if($value == $packageinfo["package"]) {
                            $html .= '<option value="'.$value.'" selected>'.$value.'</option>';
                        } else {
                            $html .= '<option value="' . $value . '">' . $value . '</option>';
                        }
                    }

    $html .= '</select>
                    </div>
                    <div class="col-md-6">
                     <label>Sub Category</label>
                        <select name="package_sub_edit" id="package_sub_edit"  class="form-control">';
    $html .= '</select>
                    </div>
                    <div class="col-md-6">
                         <label>Create New Sub-Category</label>
                         <input class="form-control" name="new-sub-cat_edit" id="new-sub-cat_edit" value="">
                      </div>
                    <div class="col-md-12">
                        <input type="hidden" name="package_id" id="package_id" value="'.$packageinfo["id"].'">
                        <input type="hidden" name="lines" id="lines" value="">
                         <label>Implements Included</label>
                            <div id="implements" class="implements droparea ui-droppable ui-sortable" style="background: #efefef; border:dashed thin #a0a0a0; padding: 30px;">';

                            $imps = $tractorstuff->getPackageImps($packageinfo["lines_items"]);

                            $html .= $imps;

                            $html .= '</div>
                         <label>Attachments Included</label>
                         <div id="attachments" class="droparea ui-droppable ui-sortable" style="background: #efefef; border:dashed thin #a0a0a0; padding: 30px;">';

                              $atts = $tractorstuff->getPackageAtts($packageinfo["lines_items"]);

                            $html .= $atts;
                            $html .= '</div><button type="submit" class="btn btn-primary" style="margin-top: 20px;">Update Package</button> </div>
                    </div>
                    
                </form>
                </div>';

                            include ('line-sidebar.php');

               $html .= '</div>';

    echo $html;
}

if($act == 'searchequip') {
    if(file_exists('../../inc/harness.php')){
        include('../../inc/harness.php');
    }else{
        include('inc/harness.php');
    }
    $search = $_REQUEST["searchtext"];
    $equips = $tractorstuff->getEquip($search);
    $html .= '<ul style="margin: 20px 0px 20px 0px; padding-left: 0px; width: 78%;" class="equiplist">';
    if($equips != null) {
        for ($i = 0; $i < count($equips); $i++) {
            $html .= '<li class="equiplist-item" style="padding: 10px; width: 85%;background: #E9ECEF; border: solid 1px #ccc; border-radius: 4px; list-style: none;">' . $equips[$i]["title"] . '<button style="padding: 0px 20px; display: block; margin-bottom: 10px; float: right; background: black; color: white;" type="button" class="btn btn-warning" onclick="addFormDetails(' . $equips[$i]["id"] . ')">SELECT</button></li>';
        }
    } else {
        $html .= '<li>No Results, Please Be More Specific</li>';
    }
    $html .= '</ul>';
    echo $html;
}

if($act =='updatepackage') {
    if(file_exists('../../inc/harness.php')){
        include('../../inc/harness.php');
    }else{
        include('inc/harness.php');
    }

    $tractorstuff->sendUpdate($_POST);

    echo 'updated';
}

if($act =='addpackage') {
    if(file_exists('../../inc/harness.php')){
        include('../../inc/harness.php');
    }else{
        include('inc/harness.php');
    }

    $tractorstuff->sendAdd($_POST);

    echo 'updated';
}

if($act == 'deleteit') {
    $id = $_REQUEST["id"];
    if(file_exists('../../inc/harness.php')){
        include('../../inc/harness.php');
    }else{
        include('inc/harness.php');
    }
    $tractorstuff->deletePackage($id);


}

if($act == 'deleteitline') {
    $id = $_REQUEST["id"];
    if(file_exists('../../inc/harness.php')){
        include('../../inc/harness.php');
    }else{
        include('inc/harness.php');
    }
    $tractorstuff->deleteAdd($id);


}

if($act == 'deleteitcat'){
    $id = $_REQUEST["id"];
    if(file_exists('../../inc/harness.php')){
        include('../../inc/harness.php');
    }else{
        include('inc/harness.php');
    }
    $tractorstuff->deleteCat($id);
}

if($act == 'cloneit') {
    $id = $_REQUEST["id"];
    if(file_exists('../../inc/harness.php')){
        include('../../inc/harness.php');
    }else{
        include('inc/harness.php');
    }
    $tractorstuff->clonePackage($id);
}

if($act == 'quickedit') {
    $id = $_REQUEST["id"];
    if(file_exists('../../inc/harness.php')){
        include('../../inc/harness.php');
    }else{
        include('inc/harness.php');
    }
    $linestuff = $tractorstuff->getLineInfo($id);

    if($linestuff["type"] == 'attachment') {
        $html = '<form name="addonquick" id="addonquick" method="post" action="">
                    <label>Addon Title</label>  
                    <input name="title" id="title" type="text" class="form-control" value="'.$linestuff["name"].'" required>
                    <label>Description</label>
                    <textarea name="description" id="description" class="form-control">'.$linestuff["description"].'</textarea>
                    <label>MSRP</label>
                    <input name="price" id="price" type="text" class="form-control" value="'.$linestuff["price"].'" required>
                    <label>Dealer Price</label>
                    <input name="dealer_price" id="dealer_price" type="text" class="form-control" value="'.$linestuff["dealer_price"].'">
                    <input name="line_id" value="'.$linestuff["id"].'" type="hidden">
                    <button style="margin-top: 30px;" class="btn btn-primary" type="submit">Update</button>
                </form>';
    } else {
        $html = '<form name="addonquick" id="addonquick" method="post" action="">
                    <label>Addon Title</label>  
                    <input name="title" id="title" type="text" class="form-control" value="'.$linestuff["name"].'" required>
                    <!--<label>Category</label>  
                    <input name="title" id="title" type="text" class="form-control" value="'.$linestuff["category"].'" required>-->
                    <label>Description</label>
                    <textarea name="description" id="description" class="form-control">'.$linestuff["description"].'</textarea>
                    <label>MSRP</label>
                    <input name="price" id="price" type="number" class="form-control" value="'.$linestuff["price"].'" required>
                    <label>Dealer Price</label>
                    <input name="dealer_price" id="dealer_price" type="number" class="form-control" value="'.$linestuff["dealer_price"].'">
                    <input name="line_id" value="'.$linestuff["id"].'" type="hidden">
                    <button style="margin-top: 30px;" class="btn btn-primary" type="submit">Update</button>
                </form>';
    }

    echo $html;
}


if($act == 'addline') {

    $html .= '<div class="row"><form name="addline" id="addline" method="post" action="">
                    <div class="row">
                    <div class="col-md-6">
                    <label>Addon Title</label>  
                    <input name="title" id="title" type="text" class="form-control" value="" required>
                    </div>
                    <div class="col-md-6">
                     <label>Addon Type</label> 
                     <select name="addtype" id="addtype" class="form-control" required>
                     <option value="">Choose Option</option>
                     <option value="attachment">Attachment</option>
                     <option value="implement">Implement</option>
                    </select>
                    </div>  
                    </div>
                    <div class="row">
                    <div class="col-md-6">       
                    <label>Existing Category<span> (Optional: only necessary for implements)</span></label> 
                    <select name="cats" id="cats" class="form-control"><option value="">Choose Category or Enter New</option>';
                    $cats = $tractorstuff->getLineCategories();
                    foreach ($cats as $value) {
                        if($value == '') {
                            $html .= '';
                        } else {
                            $html .= '<option value="' . $value . '">' . $value . '</option>';
                        }
                    }

                    $html .= '</select></div>
                    <div class="col-md-6">
                    <label>Create New Category</label>  
                    <input name="new-cat" id="new-cat" type="text" class="form-control" value="">
                    </div></div>
                     <div class="row">
                     <div class="col-md-12">
                    <label>Description</label>
                    <textarea name="description" id="description" class="form-control">'.$linestuff["description"].'</textarea></div><div class="clearfix"></div>
                    <div class="col-md-6">
                    <label>MSRP</label>
                    <input name="price" id="price" type="text" class="form-control" value="'.$linestuff["price"].'" required></div>
                    <div class="col-md-6">
                    <label>Dealer Price</label>
                    <input name="dealer_price" id="dealer_price" type="text" class="form-control" value="'.$linestuff["dealer_price"].'"></div>
                    <div class="clearfix"></div>
                    <div class="col-md-12">
                    <label> Assign To Existing Package <span>Ctrl + Click for multiple options</span></label>
                    <select name="packages[]" id="packages" class="form-control" multiple style="min-height: 454px;"><option value="">Choose An Option</option>';
                    $packs = $tractorstuff->getPackages();

                    for($i = 0; $i < count($packs); $i++) {
                        $html .= '<option value="' . $packs[$i]["equip_id"] . '">' . $packs[$i]["equipment_title"] . '</option>';
                    }

                    $html .= '</select>
                    </div>
                    <button style="margin-top: 30px;" class="btn btn-primary" type="submit">Create</button>
                    </div>
                    
                </form>';

    echo $html;
}

if($act == 'finishelineedit'){
    $tractorstuff->finishEditLine($_POST);
}

if($act == 'createline') {

    $tractorstuff->finishAddLine($_POST);


}

if($act == 'getlines') {
    $html .= ' <table id="linetable" class="table table-bordered dataTable no-footer" style="width:100%">
                    <thead>
                    <tr>
                        <th style="background: #333; color: rgb(255, 255, 255); border-right: thin solid rgb(239, 239, 239); max-width: 25% !important;">Title</th>   
                        <th style="background: #333; color: rgb(255, 255, 255); border-right: thin solid rgb(239, 239, 239);">Item Code</th>                   
                        <th style="background: #333; color: rgb(255, 255, 255); border-right: thin solid rgb(239, 239, 239);">Type</th>
                        <th style="background: #333; color: rgb(255, 255, 255); border-right: thin solid rgb(239, 239, 239);">Price</th>
                        <th style="background: #333; color: rgb(255, 255, 255); border-right: thin solid rgb(239, 239, 239);">Action</th>
                    </tr>
                    </thead>
                    <tbody>';

                    $adds = $tractorstuff->getAdds();

                    for($i=0; $i<count($adds); $i++){

                        $html .= '<tr id="'. $adds[$i]["id"].'">
                                <td>'.$adds[$i]["name"].'</td>     
                                  <td>'.$adds[$i]["code"].'</td>                         
                              <td>'.$adds[$i]["type"].'</td>
                              <td>'.$adds[$i]["price"].'</td>
                              <td><button class="btn" onclick="quickLineEdit('. $adds[$i]["id"].')"><i class="fa fa-edit"></i></button> | <button class="btn" onclick="confirmLineDel('. $adds[$i]["id"].')"><i style="color: red;" class="fa fa-minus-circle"></i></button> </td>
                             </tr>';
                    }

                    $html .= '</tbody></table>';

                    echo $html;

}