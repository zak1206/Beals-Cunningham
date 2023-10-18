<?php
class stihlClass
{
    ///AUTH FUNCTIONS FOR SITE LOGINS////
    function auth(){
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }
        session_start();
        if(isset($_SESSION["usersession"])) {
            $cur_session = $_SESSION["usersession"];
            $a = $data->query("SELECT * FROM caffeine_users WHERE usr_session = '$cur_session'");
            if ($a->num_rows > 0) {
                $b = $a->fetch_array();

                if($b["profile_image"] != ''){
                    $profileImg = $b["profile_image"];
                    $primgleft = $b["img_left"].'px';
                    $primgtop = $b["img_top"].'px';
                }else{
                    $profileImg = 'defaultIcon.png';
                    $primgleft = '0px';
                    $primgtop = '0px';
                }

                $userArray = array("fname"=>$b["fname"],"profile_image"=>$profileImg,"primgleft"=>$primgleft,"primgtop"=>$primgtop,"profileId"=>$b["id"],"user_type"=>$b["access_level"]);
                return $userArray;
            } else {
                die('<!DOCTYPE html><html> <head> <meta charset="utf-8"> <meta name="viewport" content="width=device-width,initial-scale=1"> <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc."> <meta name="author" content="Coderthemes"> <link rel="shortcut icon" href="assets/images/favicon.ico"> <title>Minton - Responsive Admin Dashboard Template</title> <link href="../plugins/switchery/switchery.min.css" rel="stylesheet"/> <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"> <link href="assets/css/icons.css" rel="stylesheet" type="text/css"> <link href="assets/css/style.css" rel="stylesheet" type="text/css"> <script src="assets/js/modernizr.min.js"></script> </head> <body> <div class="wrapper-page"> <div class="text-center"> <a href="#" class="logo-lg"><img style="max-width: 200px" src="img/eq_harvest_2.png"> </a> </div><form method="post" action="index.html" role="form" class="text-center m-t-20"> <div class=""> <a href="pages-login.html" class="text-muted">You have been logged out of EQHarvest</a><br><br><a href="login.php" class="btn btn-warning">Go to login page</a> </div></form> </div><script>var resizefunc=[]; </script> <script src="assets/js/jquery.min.js"></script> <script src="assets/js/popper.min.js"></script> <script src="assets/js/bootstrap.min.js"></script> <script src="assets/js/detect.js"></script> <script src="assets/js/fastclick.js"></script> <script src="assets/js/jquery.slimscroll.js"></script> <script src="assets/js/jquery.blockUI.js"></script> <script src="assets/js/waves.js"></script> <script src="assets/js/wow.min.js"></script> <script src="assets/js/jquery.nicescroll.js"></script> <script src="assets/js/jquery.scrollTo.min.js"></script> <script src="../plugins/switchery/switchery.min.js"></script> <script src="assets/js/jquery.core.js"></script> <script src="assets/js/jquery.app.js"></script> </body></html>');
            }
        }else{
            die('<!DOCTYPE html><html> <head> <meta charset="utf-8"> <meta name="viewport" content="width=device-width,initial-scale=1"> <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc."> <meta name="author" content="Coderthemes"> <link rel="shortcut icon" href="assets/images/favicon.ico"> <title>Minton - Responsive Admin Dashboard Template</title> <link href="../plugins/switchery/switchery.min.css" rel="stylesheet"/> <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"> <link href="assets/css/icons.css" rel="stylesheet" type="text/css"> <link href="assets/css/style.css" rel="stylesheet" type="text/css"> <script src="assets/js/modernizr.min.js"></script> </head> <body> <div class="wrapper-page"> <div class="text-center"> <a href="#" class="logo-lg"><img style="max-width: 200px" src="img/eq_harvest_2.png"> </a> </div><form method="post" action="index.html" role="form" class="text-center m-t-20"> <div class=""> <a href="pages-login.html" class="text-muted">You have been logged out of EQHarvest</a><br><br><a href="login.php" class="btn btn-warning">Go to login page</a> </div></form> </div><script>var resizefunc=[]; </script> <script src="assets/js/jquery.min.js"></script> <script src="assets/js/popper.min.js"></script> <script src="assets/js/bootstrap.min.js"></script> <script src="assets/js/detect.js"></script> <script src="assets/js/fastclick.js"></script> <script src="assets/js/jquery.slimscroll.js"></script> <script src="assets/js/jquery.blockUI.js"></script> <script src="assets/js/waves.js"></script> <script src="assets/js/wow.min.js"></script> <script src="assets/js/jquery.nicescroll.js"></script> <script src="assets/js/jquery.scrollTo.min.js"></script> <script src="../plugins/switchery/switchery.min.js"></script> <script src="assets/js/jquery.core.js"></script> <script src="assets/js/jquery.app.js"></script> </body></html>');
        }
    }

    function getProduct($prod, $cat)
    {
        ///OUTPUT PRODUCT EDIT///
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }
        $a = $data->query("SELECT * FROM stihl_equipment WHERE title = '$prod'");
        $b = $a->fetch_array();

        return $b;
    }

    function getcats($row)
    {
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }
        $a = $data->query("SELECT * FROM stihl_equipment WHERE $row != '' AND active = 'true' GROUP BY $row");
        while ($b = $a->fetch_array()) {
            $cats[] = array("cat" => $b[$row]);
        }

        return $cats;
    }

    function createPage($post){

        //var_dump($post);

        $authCreds = $this->auth();
        $userEdit = $authCreds["profileId"];
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }
        $pageName = str_replace(' ','-',$post["page_name"]);
        if(!isset($post["page_id"])){
            $fileName = $pageName.'_js_events.js';
            $a = $data->query("INSERT INTO stihl_pages SET page_name = '$pageName', page_title = '".$data->real_escape_string($post["page_title"])."', page_content = '".$data->real_escape_string($post["page_template"])."', created = '".time()."', last_user = '$userEdit', page_desc = '".$data->real_escape_string($post["page_desc"])."', page_js = '$fileName', parent_page = '".$data->real_escape_string($post["parent_page"])."', equipment_content = '".$data->real_escape_string($post["dropped-info"])."', cat_img = '".$data->real_escape_string($post["cat_img"])."', cat_type = '".$data->real_escape_string($post["category_type"])."' ") or die($data->error. '@ INSERT');

            $inserid = $data->insert_id;
            //$this->saveIntpage($inserid,$post["page_template"],'page');
            file_put_contents('../../js/page_js/'.$fileName, '//javascript events for this page go here//');
            return $inserid;
        }else{

                $a = $data->query("UPDATE stihl_pages SET page_name = '$pageName', page_title = '".$data->real_escape_string($post["page_title"])."', page_content = '".$data->real_escape_string($post["page_template"])."', last_user = '$userEdit', last_edit = '".time()."', page_desc = '".$data->real_escape_string($post["page_desc"])."', page_lock = '".$post["user_types"]."', equipment_content = '".$data->real_escape_string($post["dropped-info"])."', cat_img = '".$data->real_escape_string($post["cat_img"])."', cat_type = '".$data->real_escape_string($post["category_type"])."'  WHERE id = '".$post["page_id"]."'")or die($data->error);

            return $post["page_id"];
        }
    }

    function processSingleEquipment($post)
    {
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }

        $url = $post["deere_url"];
        $url = $url . 'index.json'; //Use this link to run product level queries

        //<--Process equipment page data -->//

        $json = file_get_contents($url);
        $obj = json_decode($json, true);


        $title = preg_replace("/[^ \w]+/", "", $obj["Page"]["analytics"]["MetaData"]["product-model-number"]);
        if ($title != null) {
            $title = str_replace(' ', '-', $obj["Page"]["analytics"]["MetaData"]["product-model-number"]);
        } else {
            $title = str_replace(' ', '-', $obj["Page"]["product-summary"]["ProductModelNumber"]);
        }
        $subTitle = $obj["Page"]["analytics"]["MetaData"]["product-model-name"];

        if ($subTitle != null) {
            $subTitle = $obj["Page"]["analytics"]["MetaData"]["product-model-name"];
        } else {
            $subTitle = $obj["Page"]["product-summary"]["ProductModelName"];
        }

        $bullets = $obj["Page"]["product-summary"]["ProductOverview"];
        $bullets = str_replace('<ul>', '', $bullets);
        $bullets = str_replace('</ul>', '', $bullets);
        $bullets = str_replace('<li>', '', $bullets);
        $bullets = explode("</li>", $bullets);
        $bullets = array_filter($bullets);
        $bullets = json_encode($bullets);
        $bullets = $bullets;

        $price = str_replace('*', '', $obj["Page"]["product-summary"]["ProductPrice"]);
        $optLinks = json_encode($obj["Page"]["product-summary"]["OptionalLinks"]);

        $image = 'https://www.deere.com/' . $obj["Page"]["product-summary"]["ImageGalleryContainer"]["ImageLarge"];
        $imageNameOld = substr($image, strrpos($image, '/') + 1);
        $imageExp = explode('.', $imageNameOld);
        $ext = $imageExp[1];


        $imageName = str_replace(' ', '_', $title);

        $newImage = preg_replace("/[^ \w]+/", "", $imageName) . '_SEOVAL.' . $ext;

        copy($image, '../../img/equip_images/' . $newImage);

        $imageSAVE = 'equip_images/' . $newImage;

        $features = file_get_contents('https://www.deere.com/' . $obj["Page"]["ESI Include Features"]["ESIFragments"]);
        $features = $this->Minify_Html($features);

        $videos = json_encode($obj["Page"]["video-gallery"]["Videos"]);

        $specLink = $obj["Page"]["ESI Include Specifications"]["ESIFragments"];
        $specLink = file_get_contents('https://www.deere.com' . $specLink);
        $specLink = $this->Minify_Html($specLink);

        $specs = $specLink;
        $offersLink = $url . 'offers-json.html';
        $accori = 'https://www.deere.com' . $obj["Page"]["ESI Include Accessories-Attachments"]["ESIFragments"];
        $ogLink = explode('en/', $_POST["deere_series_link"]);

        $stripLink = explode('/', $ogLink[1]);

        $cat_one = $stripLink[0];
        $cat_two = $stripLink[1];
        $cat_three = $stripLink[2];
        $cat_four = $stripLink[3];

        ///echo $cat_one.' - '.$cat_two.' - '.$cat_three.' - '.$cat_four.'<br>';

        $parent = $data->real_escape_string($_POST["parent_cat"]);
        $data->query("INSERT INTO stihl_equipment SET title = '" . $data->real_escape_string($title) . "', sub_title = '" . $data->real_escape_string($subTitle) . "', deere_cats = '" . $data->real_escape_string($_POST["deere_series_link"]) . "', parent_cat = '" . $post["parent_cat"] . "', cat_one = '" . $post["cat_one"] . "', cat_two = '" . $post["cat_two"] . "', cat_three = '" . $post["cat_three"] . "', cat_four = '" . $post["cat_four"] . "', bullet_points = '" . $data->real_escape_string($bullets) . "', price = '$price', opt_links = '" . $data->real_escape_string($optLinks) . "', eq_image = '$imageSAVE', features = '" . $data->real_escape_string($features) . "', videos = '" . $data->real_escape_string($videos) . "', specs = '" . $data->real_escape_string($specs) . "', offers_link = '" . $data->real_escape_string($offersLink) . "', accessories = '" . $data->real_escape_string($accori) . "', last_updated = '" . time() . "'") or die($data->error);

        echo 'Processed';
        //<--END PAGE PROCESS-->//
    }

    function getEquipmentProducts($cattype, $catname)
    {

        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }

        if ($catname != '') {
            if ($cattype == 'parent_cat') {
                $cattype1 = 'cat_one';
            }
            if ($cattype == 'cat_one') {
                $cattype1 = 'cat_two';
            }
            if ($cattype == 'cat_two') {
                $cattype1 = 'cat_three';
            }
            if ($cattype == 'cat_three') {
                $cattype1 = 'cat_four';
            }
            //echo $cattype . ' - '.$catname;


            $checkRun = $data->query("SELECT * FROM stihl_equipment WHERE active = 'true' AND $cattype = '$catname'");
            $che = $checkRun->fetch_array();

            if ($che["$cattype1"] == '') {
                $a = $data->query("SELECT * FROM stihl_equipment WHERE active = 'true' AND $cattype = '$catname'");
            } else {
                $a = $data->query("SELECT * FROM stihl_equipment WHERE active = 'true' AND $cattype = '$catname' GROUP BY $cattype1");
            }


            while ($b = $a->fetch_array()) {
                if ($b[$cattype1] == 'parent_cat') {
                    $cattype1 = 'cat_one';
                }
                if ($b[$cattype1] == 'cat_one') {
                    $cattype1 = 'cat_two';
                }
                if ($b[$cattype1] == 'cat_two') {
                    $cattype1 = 'cat_three';
                }
                if ($b[$cattype1] == 'cat_three') {
                    $cattype1 = 'cat_four';
                }

                if ($che["$cattype1"] == '') {
                    $thecatname = $b["title"];
                    $prod = true;
                } else {
                    $thecatname = $b[$cattype1];
                    $prod = false;
                }


                $eqOut[] = array("title" => $thecatname, "cattype" => $cattype1, "catname" => $thecatname, "isproduct" => $prod);
            }

        } else {
            $a = $data->query("SELECT * FROM stihl_equipment WHERE active = 'true' GROUP BY parent_cat");
            while ($b = $a->fetch_array()) {
                $eqOut[] = array("title" => $b["parent_cat"], "cattype" => 'parent_cat', "catname" => $b["parent_cat"], "isproduct" => '');
            }
        }

        if (!empty($eqOut)) {
            return $eqOut;
        } else {

        }

    }

    function getBackLink($cattype, $catname)
    {
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }

        //echo $cattype .' - '. $catname;
        $a = $data->query("SELECT * FROM stihl_equipment WHERE $cattype = '$catname'");
        $b = $a->fetch_array();

        if ($cattype == 'cat_four') {
            $link = array("cattype" => "cat_three", "catname" => $b["cat_three"]);
        }
        if ($cattype == 'cat_three') {
            $link = array("cattype" => "cat_two", "catname" => $b["cat_two"]);
        }
        if ($cattype == 'cat_two') {
            $link = array("cattype" => "cat_one", "catname" => $b["cat_one"]);
        }
        if ($cattype == 'cat_one') {
            $link = array("cattype" => "parent_cat", "catname" => $b["parent_cat"]);
        }

        return $link;
    }

    function getDeerePage($name){
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }
        $a = $data->query("SELECT * FROM stihl_pages WHERE id = '$name'");
        $b = $a->fetch_assoc();
        return $b;
    }

    function getEqCats($filter)
    {
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }
        if ($filter != null && $filter != 'all') {
            $addSql = "AND cat_type = '$filter'";
        } else {
            $addSql = '';
        }
        $a = $data->query("SELECT * FROM stihl_pages WHERE active = 'true' $addSql ORDER BY page_name ASC") or die($data->error);
        while ($b = $a->fetch_array()) {
            $catOut[] = array("catname" => $b["page_name"], "catid" => $b["id"]);
        }

        return $catOut;
    }

    function newColors(){
        $colors = array("03658C","1F8DA6","F2CEA2","BF1B1B","8C1111","BF414C","648C81","D9D0B4","D97652","F26B5E","03212B","8C8C8C","D478B7","F2AE72","FCBCCC","8CA7B5","564A47","4F6363","4D6244","A9AF89","C0B39F","C29263","7E5236","B84530","CF6F3A","DBBF30","007399","4C1E3D","400F0C","8E991C","113659","BF5220","03203F","466271","9BA4BF","58724D","663243","C47877","CCC9C9","85A6A4","1F8DA6","F2CEA2","BF1B1B","8C1111","BF414C","648C81","D9D0B4","D97652","F26B5E","4D6244","A9AF89","C0B39F","C29263","7E5236","B84530","CF6F3A","03212B","8C8C8C","D478B7","F2AE72","FCBCCC","8CA7B5","564A47","4F6363");
        $rand_keys = array_rand($colors, 2);
        return $colors[$rand_keys[0]];
    }

    function getPagesCat($line){
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');

        }
        $ars = array();
        $a = $data->query("SELECT * FROM stihl_pages WHERE active = 'true' ORDER BY page_name ASC")or die($data->error);
        while($b = $a->fetch_array()){
            $ars[] = array("id"=>$b["id"],"page_name"=>$b["page_name"],"category_type"=>$b["cat_type"],"page_title"=>$b["page_title"],"color"=>"#".$this->newColors(),"active"=>$b["active"],"page_lock"=>$b["page_lock"],"page_template"=>$b["page_content"],"check_out"=>$b["check_out"],"check_out_date"=>$b["check_out_date"]);
        }
        return $ars;
    }

    function updateProduct($post){
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }
        $data->query("UPDATE stihl_equipment SET eq_image = '".$data->real_escape_string($post["cat_img"])."', price = '".$post["pricepoint"]."', msrp = '".$data->real_escape_string($post["msrp"])."', quick_links_active = '".$post["quick_links_active"]."', offers_active = '".$post["offers_active"]."', videos_active = '".$post["videos_active"]."', access_active = '".$post["access_active"]."', extra_content = '".$data->real_escape_string($post["promoarea"])."' WHERE id = '".$post["proid"]."'")or die($data->error);

    }

    function checkPages(){
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }

        $a = $data->query("SELECT * FROM stihl_pages WHERE active = 'true'");

        if($a->num_rows > 0){
            return true;
        }else{
            return false;
        }
    }

    function getSetupPages(){
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }
        $url = 'http://caffeinerde.com/plugins/stihl_equipment/pageprocess.php';
        $key = 'IBN72234957UTYGALAXY!@';
        $password = 'YELLOANDGREENMAKEBLUE434';

        $dataset = array('key' => $key, 'password' => $password);

// use key 'http' even if you send the request to https://...
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($dataset),
            ),
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);


        $theArs = json_decode($result,true);

        if($theArs["status"] == 'Good'){

            //PROCESS DATA TO DATABASE//

            $deereEquip = $theArs["objects"];


            for($i=0; $i < count($deereEquip); $i++){

                $g = $data->query("SELECT * FROM stihl_pages WHERE page_name = '".$deereEquip[$i]["page_name"]."'");
                if($g->num_rows > 0){
                    ///DO NOT INSERT//
                }else{
                    $data->query("INSERT INTO stihl_pages SET page_name = '".$data->real_escape_string($deereEquip[$i]["page_name"])."', page_title = '".$data->real_escape_string($deereEquip[$i]["page_title"])."', page_content = '".$data->real_escape_string($deereEquip[$i]["page_template"])."', active = '".$data->real_escape_string($deereEquip[$i]["active"])."', created = '".$data->real_escape_string($deereEquip[$i]["created"])."', last_edit = '".$data->real_escape_string($deereEquip[$i]["last_edit"])."', last_user = '".$data->real_escape_string($deereEquip[$i]["last_user"])."', page_lock = '".$data->real_escape_string($deereEquip[$i]["page_lock"])."', page_type = '".$data->real_escape_string($deereEquip[$i]["page_type"])."', page_desc = '".$data->real_escape_string($deereEquip[$i]["page_desc"])."', page_js = '".$data->real_escape_string($deereEquip[$i]["page_js"])."', equipment_content = '".$data->real_escape_string($deereEquip[$i]["equipment_content"])."', cat_type = '".$data->real_escape_string($deereEquip[$i]["cat_type"])."', cat_img = '".$data->real_escape_string($deereEquip[$i]["cat_img"])."'")or die($data->error);
                }
            }

            echo 'good';

        }else{
            //NOPE//
            echo $theArs["message"];
        }
    }

    function checkUpdates(){
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }

        $a = $data->query("SELECT * FROM beans WHERE bean_folder = 'stihl_plugin'");
        $b = $a->fetch_array();


        $url = 'http://caffeinerde.com/plugins/stihl_equipment/updates.php';
        $key = 'IBN72234957UTYGALAXY!@';
        $password = 'YELLOANDGREENMAKEBLUE434';
        $lastUpdate = $b["last_updated"];

        $dataset = array('key' => $key, 'password' => $password, 'lastupdate' => $lastUpdate);

// use key 'http' even if you send the request to https://...
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($dataset),
            ),
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);


        return json_decode($result,true);
    }

    function getUpdatePackage($updatepackage){
        $url  = $updatepackage;
        $path = 'updates/updatepack.zip';

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $data = curl_exec($ch);

        curl_close($ch);

        file_put_contents($path, $data);

        $zip = new ZipArchive;
        $res = $zip->open('updates/updatepack.zip');
        if ($res === true) {
            $zip->extractTo('updates/');
            $zip->close();
            include('updates/updatefiles/process.php');
        } else {
            echo 'doh!';
        }
    }

    function createEqBean($beanname){
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }
        $data->query("INSERT INTO beans SET bean_name = '".$data->real_escape_string($_REQUEST["beanname"])."', bean_type = 'eq_bean', user_type = 'all', created = '".time()."', bean_id = '".$_REQUEST["bean_id"]."', category = '$category', active = 'true'");
    }
}