<?php
if(file_exists('../../inc/harness.php')){
    include('../../inc/harness.php');
}else{
    include('inc/harness.php');
}
class packageclass
{
    //Function searches and retrieves equipment from the deere equipment table from which a user can select the equipment for their package.
    function getEquip($search)
    {
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }

        $a = $data->query("SELECT id, title, price, dealer_price, eq_image FROM deere_equipment WHERE title LIKE '%{$search}%'")or die($data->error);
        if($a->num_rows > 0) {
            while($b = $a->fetch_array()){
                $equips[] = array("id" => $b["id"], "title" => $b["title"], "price" => $b["price"], "dealer_price" => $b["dealer_price"], "eq_image" => $b["eq_image"]);
            }
        } else {
                $equips = 'No Results Found';
        }

        return $equips;

    }
    //Function gets single piece of equipment to pull general details for the user when they create a package
    function getEquipment($equipid)
    {
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }
        $a = $data->query("SELECT * FROM deere_equipment WHERE id = '$equipid'")or die($data->error);
        $b = $a->fetch_array();

        return $b;
    }
    //Function gets package details, mainly for editing purposes
    function getPackage($id) {
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }
        $a = $data->query("SELECT * FROM package_equipment WHERE id = '$id'")or die($data->error);
        $b = $a->fetch_array();

        return $b;
    }


    // Function Pulls ALL available categories for users when they create a package
    function getCategories()
    {
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }
        $a = $data->query("SELECT * FROM package_information WHERE active = 'true'")or die($data->error);

        while ($b = $a->fetch_array()){
            $cats[] .= $b["package_name"];
        }

        return $cats;
    }
    // Function pulls ONLY sub-categories associated to a main category.
    function getSubCategories($value)
    {
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }
        $a = $data->query("SELECT * FROM package_equipment WHERE active = 'true' AND package = '$value' GROUP BY sub_category")or die($data->error);

        while ($b = $a->fetch_array()){
            $cats[] .= $b["sub_category"];
        }

        return $cats;
    }

    function getLineCategories()
    {
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }
        $a = $data->query("SELECT * FROM attachment_data WHERE active = 'true' GROUP BY category")or die($data->error);

        while ($b = $a->fetch_array()){
            $cats[] .= $b["category"];
        }

        return $cats;
    }
    // Function gets All attachments and implements for the side bar of the Add Package and Edit Package functionality
    function getAllAttsImps($equip)
    {
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }
        $a = $data->query("SELECT * FROM attachment_data WHERE active = 'true'")or die($data->error);
        while ($b = $a->fetch_array()) {
            $names = json_decode($b["equipment_names"]);

            if(in_array($equip, $names)) {
                $attsimps[] = array("id" => $b["id"], "title" => $b["name"], "category" => $b["category"], "price" => $b["price"]);
            } else {

            }
        }

        return $attsimps;
    }
    // Function pulls all Implements related to an existing package for updating purposes
    function getPackageImps($lines) {
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }

        $eachline = json_decode($lines, true);

        for($i = 0; $i < count($eachline); $i ++) {

                $id = $eachline[$i]["id"];
                $a = $data->query("SELECT * From attachment_data WHERE name = '$id' AND active = 'true' AND type = 'implement'");
                $b = $a->fetch_array();
                if($b["type"] != 'implement') {
                $html .= '';
            } else {

                    $html .= '<div class="dropitemsin" data-id="'.$b["name"].'" style="background: #F8CE54; border: solid .6px #eee; padding: 6px 10px; color: black; margin-bottom: 10px;"><p style="width: 80%;">' . $b["name"] . '<span style="font-size: .6rem;"></span>  Category:(' . $b["category"] . ') - List Price: ' . $b["price"] . '</p><a style="width: 20%;" class="removeites"><i class="fa fa-trash" aria-hidden="true"></i> Remove</a></div>';
                }
        }
        return $html;
    }
    // Function pulls all Attachments related to an existing package for updating purposes
    function getPackageAtts($lines) {
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }

        $eachline = json_decode($lines, true);

        for($i = 0; $i < count($eachline); $i ++) {

            $id = $eachline[$i]["id"];
            $a = $data->query("SELECT * From attachment_data WHERE name = '$id' AND active = 'true'");
            $b = $a->fetch_array();
            if($b["type"] != 'attachment') {
                $html .= '';
            } else {

                $html .= '<div class="dropitemsin" data-id="'.$b["name"].'"style="background: #F8CE54; border: solid .6px #eee; padding: 6px 10px; color: black; margin-bottom: 10px;"><p>' . $b["name"] . '<span style="font-size: .6rem;"></span> - List Price: ' . $b["price"] . '<span style="float: right;"></span></p><a class="removeites"><i class="fa fa-trash" aria-hidden="true"></i> Remove</a></div>';
            }
        }
       return $html;
    }
    //Function gets all existing package details
    function getPackages()
    {
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }
        $a = $data->query("SELECT * FROM package_equipment WHERE active = 'true' ORDER BY equipment_title ASC");
        while ($b = $a->fetch_array()) {
            $packs[] = $b;
        }
        return $packs;
    }

    function getAdds()
    {
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }
        $a = $data->query("SELECT * FROM attachment_data WHERE active = 'true' ORDER BY name ASC");
        while ($b = $a->fetch_array()) {
            $packs[] = $b;
        }
        return $packs;
    }

    function finishAddLine($post)
    {
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }

        $title = $post["title"];
        $addtype = $post["addtype"];
        if(!empty($post["new-cat"])) {
            $cat = $post["new-cat"];
        } else {
            $cat = $post["cats"];
        }

        $desc = $post["description"];

        $price = $post["price"];

        $dealerprice = $post["dealer_price"];

        $package = json_encode($post["packages"]);




        $a = $data->query("INSERT INTO attachment_data SET
          name =  '" . $data->real_escape_string($title) . "',
          category =  '" . $data->real_escape_string($cat) . "',
          description =  '" . $data->real_escape_string($desc) . "',
          price =  '" . $data->real_escape_string($price) . "',
          dealer_price =  '" . $data->real_escape_string($dealerprice) . "',
          equipment_names =  '" . $data->real_escape_string($package) . "',
          type =  '" . $data->real_escape_string($addtype) . "',
          updated = '".time()."',
          active = 'true'");

    }

    function finishEditLine($post)
    {
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }
        $title = $post["title"];

        $desc = $post["description"];

        $price = $post["price"];

        $dealerprice = $post["dealer_price"];

        $id = $post["line_id"];

        $data->query("UPDATE package_attachments SET title =  '" . $data->real_escape_string($title) . "', description =  '" . $data->real_escape_string($desc) . "', price =  '" . $data->real_escape_string($price) . "', dealer_price =  '" . $data->real_escape_string($dealerprice) . "' WHERE id = '$id'");
    }

    function sendUpdate($post)
    {
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
            }

            if(empty($post["new--sub-cat_edit"])) {
                $package = $post["package_cat_edit"];
            } else {
                $package = $post["new--sub-cat_edit"];
            }

            if(empty($post["new-sub-cat_edit"])) {
                $subpackage = $post["package_sub_edit"];
            } else {
                $subpackage = $post["new-sub-cat_edit"];
            }

        $lines =  json_decode($post["lines_items"], true);
        $newlines = array(json_encode($lines));
        var_dump( array(json_encode($lines)));

        $data->query("UPDATE package_equipment SET 
                      equipment_title = '" . $data->real_escape_string($post["equip_title_edit"]) . "',
                      package = '" . $data->real_escape_string($package) . "',
                      sub_category = '" . $data->real_escape_string($subpackage) . "',
                      msrp = '" . $data->real_escape_string($post["price_edit"]) . "',
                      price = '" . $data->real_escape_string($post["dealer_price_edit"]) . "',
                      lines_items = '" . $data->real_escape_string($post["lines"]) . "'
                      WHERE id = '" . $post["package_id"] . "'") or die($data->error);

    }

    function sendAdd($post)
    {
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }

        if(empty($post["new-cat"])) {
            $package = $post["package_cat"];
        } else {
            $package = $post["new-cat"];
        }

        if(empty($post["new-sub-cat"])) {
            $subpackage = $post["package_sub"];
        } else {
            $subpackage = $post["new-sub-cat"];
        }



        $data->query("INSERT INTO package_equipment SET equip_id = '".$post["equipment_id"]."', equipment_title = '" . $data->real_escape_string($post["equip_title"]) . "', package = '" . $data->real_escape_string($package) . "', sub_category = '" . $data->real_escape_string($subpackage) . "', msrp = '" . $data->real_escape_string($post["price"]) . "', price = '" . $data->real_escape_string($post["dealer_price"]) . "', lines_items = '" . $data->real_escape_string($post["lines"]) . "', active = 'true'");


    }

    function deletePackage($id)
    {
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }

        $data->query("UPDATE package_equipment SET active = 'false' WHERE id = $id");
    }

    function deleteAdd($id)
    {
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }

        $data->query("UPDATE attachment_data SET active = 'false' WHERE id = $id");
    }

    function deleteCat($id)
    {
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }
        $data->query("UPDATE package_information SET active = 'false' WHERE id = $id");
    }

    function clonePackage($id)
    {
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }

        $a = $data->query("SELECT * from package_equipment WHERE id = $id");
        $b = $a->fetch_array();

        $c = $data->query("INSERT INTO package_equipment SET equip_id = '".$b["equip_id"]."', equipment_title = '".$b["equipment_title"]." (COPY)', package = '".$b["package"]."', sub_category = '".$b["sub_category"]."', msrp = '".$b["msrp"]."', price = '".$b["price"]."', lines_items = '".$b["lines_items"]."', active = 'true'");

    }

    function getLineInfo($id)
    {
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }
        $a = $data->query("SELECT * from attachment_data WHERE id = $id");
        $b = $a->fetch_array();

        return $b;
    }

    function getPackageDetails($id)
    {
        if(file_exists('../../inc/harness.php')){
        include('../../inc/harness.php');
    }else{
        include('inc/harness.php');
    }
        $a = $data->query("SELECT * FROM package_equipment WHERE id = '$id'");
        $b = $a->fetch_array();

        return $b;
    }


    function getMainCategories()
    {
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }
        $a = $data->query("SELECT * FROM package_information WHERE active = 'true' ORDER BY package_name ASC");
        while ($b = $a->fetch_array()) {
            $packs[] = $b;
        }
        return $packs;
    }

    function getMainCat($id)
    {
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }
        $a = $data->query("SELECT * FROM package_information WHERE id = '$id'");

        $b = $a->fetch_array();

        return $b;
    }

    function finishCatEdit($post)
    {
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }
        $id = $post["id"];
        $a = $data->query("UPDATE package_information SET package_name = '" . $data->real_escape_string($post["pack_name"]) . "',  package_description = '" . $data->real_escape_string($post["pack_descr"]) . "', package_image = '" . $data->real_escape_string($post["cat_img"]) . "' WHERE id = '$id'");
    }

    function finishCatAdd($post)
    {
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }
        $a = $data->query("INSERT INTO package_information SET package_name = '" . $data->real_escape_string($post["new_pack_name"]) . "',  package_description = '" . $data->real_escape_string($post["new_pack_descr"]) . "', package_image = '" . $data->real_escape_string($post["new_cat_img"]) . "'");

    }

}