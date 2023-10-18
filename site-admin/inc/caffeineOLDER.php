<?php
use MatthiasMullie\Minify;
class caffeine {
    function login($post){
        include('harness.php');
        $a = $data->query("SELECT * FROM caffeine_users WHERE email = '".$post["email"]."' AND passcode = '".md5($post["password"])."'");
        if($a->num_rows > 0){
            $b = $a->fetch_array();
            if($b["active"] == 'true'){
                $sess = md5(date('dYms').$post["email"]);
                session_start();
                $_SESSION["usersession"] = $sess;
                $data->query("UPDATE caffeine_users SET usr_session = '".$sess."', last_login = '".time()."' WHERE id = '".$b["id"]."'");
                if(isset($_POST["remember"])){
                    setcookie('caffeineuser', $_POST["email"], time() + (86400 * 30), "/");
                }else{
                    if(isset($_COOKIE["caffeineuser"])){
                        unset($_COOKIE['caffeineuser']);
                        setcookie('caffeineuser', '', time() - 3600, '/');
                    }
                }
                return array("message_code"=>1,"message"=>"Login successful");
            }
        }else{
            return array("message_code"=>0,"message"=>"Login Incorrect - Please try again.");
        }
    }

    function logout(){
        $this->checkInPages();
        $this->checkInBeans();
        session_start();
        $_SESSION = array();
        header('Location:index.php');
    }

    ///AUTH FUNCTIONS FOR SITE LOGINS////
    function auth(){
        include('harness.php');
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
                die('<!DOCTYPE html><html> <head> <meta charset="utf-8"> <meta name="viewport" content="width=device-width,initial-scale=1"> <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc."> <meta name="author" content="Coderthemes"> <link rel="shortcut icon" href="assets/images/favicon.ico"> <title>EQHarvest - Dealer Platform</title> <link href="../plugins/switchery/switchery.min.css" rel="stylesheet"/> <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"> <link href="assets/css/icons.css" rel="stylesheet" type="text/css"> <link href="assets/css/style.css" rel="stylesheet" type="text/css"> <script src="assets/js/modernizr.min.js"></script> </head> <body> <div class="wrapper-page"> <div class="text-center"> <a href="#" class="logo-lg"><img style="max-width: 200px" src="img/eq_harvest_2.png"> </a> </div><form method="post" action="index.html" role="form" class="text-center m-t-20"> <div class=""> <a href="pages-login.html" class="text-muted">You have been logged out of EQHarvest</a><br><br><a href="login.php" class="btn btn-warning">Go to login page</a> </div></form> </div><script>var resizefunc=[]; </script> <script src="assets/js/jquery.min.js"></script> <script src="assets/js/popper.min.js"></script> <script src="assets/js/bootstrap.min.js"></script> <script src="assets/js/detect.js"></script> <script src="assets/js/fastclick.js"></script> <script src="assets/js/jquery.slimscroll.js"></script> <script src="assets/js/jquery.blockUI.js"></script> <script src="assets/js/waves.js"></script> <script src="assets/js/wow.min.js"></script> <script src="assets/js/jquery.nicescroll.js"></script> <script src="assets/js/jquery.scrollTo.min.js"></script> <script src="../plugins/switchery/switchery.min.js"></script> <script src="assets/js/jquery.core.js"></script> <script src="assets/js/jquery.app.js"></script> </body></html>');
            }
        }else{
            die('<!DOCTYPE html><html> <head> <meta charset="utf-8"> <meta name="viewport" content="width=device-width,initial-scale=1"> <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc."> <meta name="author" content="Coderthemes"> <link rel="shortcut icon" href="assets/images/favicon.ico"> <title>EQHarvest - Dealer Platform</title> <link href="../plugins/switchery/switchery.min.css" rel="stylesheet"/> <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"> <link href="assets/css/icons.css" rel="stylesheet" type="text/css"> <link href="assets/css/style.css" rel="stylesheet" type="text/css"> <script src="assets/js/modernizr.min.js"></script> </head> <body> <div class="wrapper-page"> <div class="text-center"> <a href="#" class="logo-lg"><img style="max-width: 200px" src="img/eq_harvest_2.png"> </a> </div><form method="post" action="index.html" role="form" class="text-center m-t-20"> <div class=""> <a href="pages-login.html" class="text-muted">You have been logged out of EQHarvest</a><br><br><a href="login.php" class="btn btn-warning">Go to login page</a> </div></form> </div><script>var resizefunc=[]; </script> <script src="assets/js/jquery.min.js"></script> <script src="assets/js/popper.min.js"></script> <script src="assets/js/bootstrap.min.js"></script> <script src="assets/js/detect.js"></script> <script src="assets/js/fastclick.js"></script> <script src="assets/js/jquery.slimscroll.js"></script> <script src="assets/js/jquery.blockUI.js"></script> <script src="assets/js/waves.js"></script> <script src="assets/js/wow.min.js"></script> <script src="assets/js/jquery.nicescroll.js"></script> <script src="assets/js/jquery.scrollTo.min.js"></script> <script src="../plugins/switchery/switchery.min.js"></script> <script src="assets/js/jquery.core.js"></script> <script src="assets/js/jquery.app.js"></script> </body></html>');
        }
    }

    function saveIntpage($pageid,$content,$contentedit,$backup_type){
        $authCreds = $this->auth();
        $userEdit = $authCreds["profileId"];
        include('harness.php');
        $a = $data->query("SELECT * FROM page_repo WHERE page_id = '$pageid' ORDER BY id DESC LIMIT 1")or die('SOMETHING WENT WRONG!');
        $b = $a->fetch_array();
        if($content == $b["page_content"]){
           ///DO NOTHING BECAUSE WE DONT WANT TO WASTE SPACE///
        }else{
            $data->query("INSERT INTO page_repo SET page_id = '$pageid', page_content = '".$data->real_escape_string($content)."', page_content_edits = '".$data->real_escape_string($content)."', backup_date = '".time()."', backup_type = '$backup_type', last_user = '$userEdit'") or die($data->error);
        }

    }

    function createPage($post){
        $authCreds = $this->auth();
        $userEdit = $authCreds["profileId"];
        include('harness.php');
        $pageName = str_replace(' ','-',$post["page_name"]);
        if(!isset($post["page_id"])){
            $fileName = $pageName.'_js_events.js';
                $a = $data->query("INSERT INTO pages SET page_name = '$pageName', page_title = '".$data->real_escape_string($post["page_title"])."',  created = '".time()."', last_user = '$userEdit', page_desc = '".$data->real_escape_string($post["page_desc"])."', page_js = '$fileName', parent_page = '".$data->real_escape_string($post["parent_page"])."'") or die($data->error);

            $inserid = $data->insert_id;
            //$this->saveIntpage($inserid,$post["page_template"],'page');
           file_put_contents('../../js/page_js/'.$fileName, '//javascript events for this page go here//');
           return $inserid;
        }else{
            if(isset($post["user_types"])){
                $a = $data->query("UPDATE pages SET page_name = '$pageName', page_title = '".$data->real_escape_string($post["page_title"])."', last_user = '$userEdit', last_edit = '".time()."', page_desc = '".$data->real_escape_string($post["page_desc"])."', page_lock = '".$post["user_types"]."', equipment_content = '".$data->real_escape_string($post["dropped-info"])."', cat_img = '".$data->real_escape_string($post["cat_img"])."', cat_type = '".$data->real_escape_string($post["category_type"])."', secure_page = '".$post["securepage"]."', user_group = '".$post["permisgrp"]."'   WHERE id = '".$post["page_id"]."'");
            }else{
                $a = $data->query("UPDATE pages SET page_name = '$pageName', page_title = '".$data->real_escape_string($post["page_title"])."', last_user = '$userEdit', last_edit = '".time()."', page_desc = '".$data->real_escape_string($post["page_desc"])."', secure_page = '".$post["securepage"]."', user_group = '".$post["permisgrp"]."'   WHERE id = '".$post["page_id"]."'")or die($data->error);
            }

            return $post["page_id"];
        }
    }

    function savePageDeps($post){
        $authCreds = $this->auth();
        include('harness.php');
        $pageID = $post["page_id"];
        $depsPost = $post['deps'];


        foreach($depsPost as $keys){
            $ext = pathinfo($keys, PATHINFO_EXTENSION);
            if($ext == 'css'){
                $cssArs[] = $keys;
            }else{
                $jsArs[] = $keys;
            }
        }

        $newArs =  array_merge(array("css"=>$cssArs), array("js"=>$jsArs));

        $newArs = json_encode($newArs);


        $data->query("UPDATE pages SET dependants = '$newArs' WHERE id = '$pageID'");
    }


    function random_color_part() {
        return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
    }

    function random_color() {
        return $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
    }

    function newColors(){
        $colors = array("03658C","1F8DA6","F2CEA2","BF1B1B","8C1111","BF414C","648C81","D9D0B4","D97652","F26B5E","03212B","8C8C8C","D478B7","F2AE72","FCBCCC","8CA7B5","564A47","4F6363","4D6244","A9AF89","C0B39F","C29263","7E5236","B84530","CF6F3A","DBBF30","007399","4C1E3D","400F0C","8E991C","113659","BF5220","03203F","466271","9BA4BF","58724D","663243","C47877","CCC9C9","85A6A4","1F8DA6","F2CEA2","BF1B1B","8C1111","BF414C","648C81","D9D0B4","D97652","F26B5E","4D6244","A9AF89","C0B39F","C29263","7E5236","B84530","CF6F3A","03212B","8C8C8C","D478B7","F2AE72","FCBCCC","8CA7B5","564A47","4F6363");
        $rand_keys = array_rand($colors, 2);
        return $colors[$rand_keys[0]];
    }

    function getPages(){
        $this->auth();
        include('harness.php');
        $ars = array();
        $a = $data->query("SELECT * FROM pages WHERE active = 'true' ORDER BY page_name ASC");
        while($b = $a->fetch_array()){
            $ars[] = array("id"=>$b["id"],"page_name"=>$b["page_name"], "page_title"=>$b["page_title"],"color"=>"#".$this->newColors(),"active"=>$b["active"],"page_lock"=>$b["page_lock"],"page_template"=>$b["page_template"],"page_type"=>$b["page_type"],"check_out"=>$b["check_out"],"check_out_date"=>$b["check_out_date"],"created"=>$b["created"]);
        }
        return $ars;
    }



    function checkOutItem($type,$id){
        $person = $this->auth();
        include('harness.php');
        if($type == 'page'){
            $a = $data->query("UPDATE pages SET check_out = '".$person["profileId"]."', check_out_date = '".time()."' WHERE id = '$id'")or die($data->error);
        }else{
            date_default_timezone_set('America/Chicago');
            $a = $data->query("UPDATE beans SET checkout = '".$person["profileId"]."', checkout_date = '".time()."' WHERE id = '$id'");
        }
    }

    function checkInPages(){
    $person = $this->auth();
    include('harness.php');
    $data->query("UPDATE pages SET check_out = '', check_out_date = '' WHERE check_out = '".$person["profileId"]."'");
}

    function checkInBeans(){
        $person = $this->auth();
        include('harness.php');
        $data->query("UPDATE beans SET checkout = '', checkout_date = '' WHERE checkout = '".$person["profileId"]."'");
    }

    function checkCheckOut($page){
        $person = $this->auth();
        include('harness.php');
        $a = $data->query("SELECT * FROM pages WHERE id = '$page'");
        $b = $a->fetch_array();

        if($b["check_out"] != '' && $b["check_out"] != $person["profileId"]){
            return true;
        }else{
            return false;
        }
    }

    function checkCheckOutBean($bean){
        $person = $this->auth();
        include('harness.php');
        $a = $data->query("SELECT * FROM beans WHERE id = '$bean'");
        $b = $a->fetch_array();

        if($b["checkout"] != '' && $b["checkout"] != $person["profileId"]){
            return true;
        }else{
            return false;
        }
    }

    function displayList($navArr){
        $this->auth();
        include('harness.php');
        $pagesSet .= '<ol class="dd-list">';
        foreach($navArr as $item){
            $a = $data->query("SELECT * FROM pre_nav WHERE id = '".$item["id"]."'");
            $b = $a->fetch_array();
            $pagesSet .='<li class="dd-item" data-id="'.$item["id"].'"><div class="dd-handle">'.$b["nav_read"].'</div>';
            if (array_key_exists("children", $item)){
                $pagesSet .= $this->displayList($item["children"]);
            }
            $pagesSet .= '</li>';
        }
        $pagesSet .= '</ol>';
        return $pagesSet;
    }

    function getPagesNav($id){
        $this->auth();
        include('harness.php');
        $ars = array();
        ///CHECK SETUP//
        $check = $data->query("SELECT * FROM navigation WHERE id = '$id'");
        $nav = $check->fetch_array();

        if($nav["ordered"] == 'false'){
            $navArr = json_decode($nav["menu_json"],true);
            for($i=0; $i < count($navArr); $i++){
                $a = $data->query("SELECT * FROM pre_nav WHERE id = '".$navArr[$i]."'");
                $b = $a->fetch_array();
                $pagesSet .= '<li class="dd-item" data-id="'.$b["id"].'">
                    <div class="dd-handle">'.$b["nav_read"].'</div>
                </li>';
            }
        }else{
            $navArr = json_decode($nav["menu_json"],true);
            foreach($navArr as $item){
                $a = $data->query("SELECT * FROM pre_nav WHERE id = '".$item["id"]."'");
                $b = $a->fetch_array();

                if($b["page_type"] == 'link'){
                    $pagename = '<span style="color: orange">external-link - '.$b["nav_read"].'</span>';
                }else{
                    $pagename = $b["nav_read"];
                }

                $pagesSet .='<li class="dd-item" data-id="'.$item["id"].'"><div class="dd-handle">'.$pagename.'</div>';
                if (array_key_exists("children", $item)){
                    $pagesSet .= $this->displayList($item["children"]);
                }
            }
        $pagesSet .'</li>';
        }
        return $pagesSet;
    }

    function getPage($name){
        $this->auth();
        include('harness.php');
        $a = $data->query("SELECT * FROM pages WHERE id = '$name'");
        $b = $a->fetch_assoc();
        return $b;
    }

    function getDeps(){
        $this->auth();
        include('harness.php');

        $a = $data->query("SELECT file, type FROM beans_dep WHERE active = 'true' AND load_type = 'mod' ORDER by type ASC");
        while($b = $a->fetch_array()){

            if($b["type"] == 'js') {
                $depjsArs[] = array($b["file"]);
            }else{
                $depArscss[] = array($b["file"]);
            }

        }

        $result = array_merge(array("css"=>$depArscss), array("js"=>$depjsArs));

        return $result;
    }

    function getCheckOut($id){
        $this->auth();
        include('harness.php');
        $a = $data->query("SELECT * FROM caffeine_users WHERE id = '$id'");
        $b = $a->fetch_assoc();
        return $b;
    }

    function createNewMenu($post){
        $this->auth();
        include('harness.php');
        $menu_json = json_encode($_POST["selpage"]);
        if(isset($post["nav_id"])){
            $data->query("UPDATE navigation SET menu_name = '".$post["menu_name"]."', menu_class = '".$post["menu_class"]."' WHERE id = '".$post["nav_id"]."'");
            return $post["nav_id"];
        }else{
            $navId = 'NAV'.md5(date('siYm'));
        $data->query("INSERT INTO navigation SET menu_name = '".$post["menu_name"]."', menu_class = '".$post["menu_class"]."', menu_json = '$menu_json', navigation_id = '$navId', ordered = 'true'")or die($data->error);
        return $data->insert_id;
        }
    }

    function updateMenu($id,$menuarr){
        $this->auth();
        include('harness.php');
        $data->query("UPDATE navigation SET menu_json = '$menuarr', ordered = 'true' WHERE id = '$id'");
    }

    function removeNavObj($id,$menuid){
        $this->auth();
        include('harness.php');
        $a = $data->query("SELECT * FROM navigation WHERE id = '$id'");
        $b = $a->fetch_array();

        $convert = json_decode($b["menu_json"],true);
        if($this->in_array_r_og($menuid,$convert,false) == true){
            $i=0;
            foreach ($convert as $key => $value){
                if ($value['id'] == $menuid){
                    unset($convert[$key]);
                }
                if(!empty($convert[$i]["children"])){
                    // echo 'Hello';
                    //var_dump($convert[$i]["children"]);
                    foreach ($convert[$i]["children"] as $key1 => $value1){
                        if ($value1['id'] == $menuid){
                            unset($convert[$i]["children"][$key1]);
                        }
                    }
                }
                $i++;
            }
        }else{
            $adds = true;
            $neval = $convert[]['id'] = $menuid;
            array_push($convert,$neval);
        }


        if($adds == true){
            $convert = array_slice($convert, 0, -1);
        }
        $convert = json_encode($convert);

        echo $convert;

        $data->query("UPDATE navigation SET menu_json = '".$convert."' WHERE id = '$id'");
            return $convert;
    }

    function getNavigation($id){
        $this->auth();
        include('harness.php');
        $a = $data->query("SELECT * FROM navigation WHERE id = '$id'");
        $b = $a->fetch_array();
        return json_decode($b["menu_json"],true);

    }

    function getNavList(){
        $this->auth();
        include('harness.php');
        $a = $data->query("SELECT * FROM navigation WHERE active = 'true' ORDER BY menu_name ASC");
        while($b = $a->fetch_array()){
            $ars[] = array("id"=>$b["id"],"menu_name"=>$b["menu_name"],"navigation_id"=>$b["navigation_id"],"color"=>"#".$this->newColors());
        }
        return $ars;
    }


    function getBeanCategory(){
        $this->auth();
        include('harness.php');
        $a = $data->query("SELECT * FROM beans WHERE category != '' AND bean_name != 'productbean' GROUP BY category")or die($data->error);
        while($b = $a->fetch_array()){
            $cats[] = $b["category"];
        }

        return $cats;
    }

    function getSinglenav($id){
        $this->auth();
        include('harness.php');
        $a = $data->query("SELECT * FROM navigation WHERE id = '$id'");
        $b = $a->fetch_assoc();
        return $b;
    }

    function in_array_r_og($needle, $haystack, $strict = false) {
        $this->auth();
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && $this->in_array_r_og($needle, $item, $strict))) {
                return true;
            }
        }

        return false;
    }

    function deleteNavigation($id){
        $this->auth();
        include('harness.php');
        $data->query("UPDATE navigation SET active = 'false' WHERE id = '$id'");
    }

    function createContentBean($post){
        $this->auth();
        include('harness.php');
        if($post["new-cat"] != ''){
            $category = $post["new-cat"];
        }else{
            $category = $post["category"];
        }

        $beanID = 'bean-obj-'.str_replace(' ','-',$_POST["bean_name"]);
        $data->query("INSERT INTO beans SET bean_name = '".$data->real_escape_string($_POST["bean_name"])."', bean_id = '$beanID', bean_type = 'native', user_type = 'all', created = '".time()."', category = '$category', active = 'true'");
        $inserid =$data->insert_id;
        $this->saveIntpage($inserid,'','','bean');
        return $inserid;

    }

    function editContentBean($post,$id){
        $this->auth();
        include('harness.php');
        if($post["new-cat"] != ''){
            $category = $post["new-cat"];
        }else{
            $category = $post["category"];
        }

        $startThis = strtotime($_POST["start_this"]);
        $endThis = strtotime($_POST["end_this"]);

        $data->query("UPDATE beans SET bean_name = '".$data->real_escape_string($post["bean_name"])."', bean_content = '".$data->real_escape_string($post["bean_content"])."', category = '$category', start_time = '$startThis', end_time = '$endThis' WHERE id = '$id'")or die($data->error);
        $this->saveIntpage($id,$post["bean_content"],'','bean');
    }

    function getBeans(){
        $this->auth();
        include('harness.php');
        $a = $data->query("SELECT * FROM beans WHERE active = 'true' AND bean_name != 'productbean' ORDER BY bean_name ASC");
        while($b = $a->fetch_array()){
        $bean[] = array("id"=>$b["id"],"bean_name"=>$b["bean_name"],"bean_description"=>$b["bean_description"],"bean_type","user_type"=>$b["user_type"],"color"=>"#".$this->newColors(),"bean_id"=>$b["bean_id"],"bean_lock"=>$b["bean_lock"], "category"=>$b["category"],"start_time"=>$b["start_time"],"end_time"=>$b["end_time"],"checkout"=>$b["checkout"], "checkout_date"=>$b["checkout_date"]);
        }
        return $bean;
    }

    function getBean($id){
        $this->auth();
        include('harness.php');
        $a = $data->query("SELECT * FROM beans WHERE id = '$id'");
        $b = $a->fetch_assoc();
        return $b;

    }

    function checkBean($program){
        $this->auth();
        include('harness.php');
        $a = $data->query("SELECT * FROM beans WHERE bean_id = '$program'");
        $b = $a->fetch_assoc();
        return $b;
    }

    function searchBeans($val){
        $this->auth();
        include('harness.php');
        $a = $data->query("SELECT * FROM beans WHERE bean_name LIKE '$val%'");
        while($b = $a->fetch_array()){
            $bean[] = array("id"=>$b["id"],"bean_name"=>$b["bean_name"],"bean_description"=>$b["bean_description"],"bean_type","user_type"=>$b["user_type"],"color"=>"#".$this->newColors(),"bean_id"=>$b["bean_id"]);
        }
        return $bean;
    }

    function checkBeanPages($beanid){
        $this->auth();
        include('harness.php');

        $a = $data->query("SELECT page_content, page_name FROM pages WHERE active = 'true'");
        while($b = $a->fetch_array()){
            $pos = strpos($b["page_content"], $beanid);
            if ($pos === false) {
                //return nothing here//
            }else{
                $retArs[] = $b["page_name"];

            }
        }

        return $retArs;
    }

    function searchForms($val){
        $this->auth();
        include('harness.php');
        $a = $data->query("SELECT * FROM forms_data WHERE form_name LIKE '$val%'");
        while($b = $a->fetch_array()){
            $form[] = array("id"=>$b["id"],"form_name"=>$b["form_name"]);
        }
        return $form;
    }

    function deletePage($pageId){
        include('harness.php');

        $a = $data->query("SELECT * FROM pages WHERE id = '$pageId'");
        $b = $a->fetch_array();

        $pageJs = $b["page_js"];
        unlink('../../js/page_js/'.$pageJs);

        $data->query("DELETE FROM pages WHERE id = '$pageId'");
        $data->query("DELETE FROM page_repo WHERE page_id = '$pageId'");

    }

    function deleteBean($id){
        include('harness.php');
        $data->query("UPDATE beans SET active = 'false' WHERE id = '$id'")or die($data->error);
    }

    function getUsersAccounts(){
        include('inc/harness.php');
        $a = $data->query("SELECT * FROM caffeine_users WHERE active = 'true' ORDER BY fname ASC");
        while($b = $a->fetch_array()){
            $usersInfo[] = array("id"=>$b["id"],"fname"=> $b["fname"],"lname"=>$b["lname"],"email"=>$b["email"],"last_login"=>$b["last_login"],"access_level"=>$b["access_level"]);
        }

        return $usersInfo;
    }

    function getUsersAccount($id){
        include('harness.php');
        $a = $data->query("SELECT * FROM caffeine_users WHERE id = '$id' AND active = 'true' ORDER BY fname ASC")or die($data->error);
        if($a->num_rows > 0) {
            $b = $a->fetch_array();
            $usersInfo = array("id" => $b["id"], "fname" => $b["fname"], "lname" => $b["lname"], "email" => $b["email"], "last_login" => $b["last_login"],"access_level"=>$b["access_level"],"profile_image"=>$b["profile_image"],"left"=>$b["img_left"],"top"=>$b["img_top"]);
        }else{
            $usersInfo = false;
        }
        return $usersInfo;
    }


    function resize_crop_image($max_width, $max_height, $source_file, $dst_dir, $quality = 80)
    {
        $imgsize = getimagesize($source_file);
        $width = $imgsize[0];
        $height = $imgsize[1];
        $mime = $imgsize['mime'];

        switch ($mime) {
            case 'image/gif':
                $image_create = "imagecreatefromgif";
                $image = "imagegif";
                break;

            case 'image/png':
                $image_create = "imagecreatefrompng";
                $image = "imagepng";
                $quality = 7;
                break;

            case 'image/jpeg':
                $image_create = "imagecreatefromjpeg";
                $image = "imagejpeg";
                $quality = 90;
                break;

            default:
                return false;
                break;
        }

        //$dst_img = imagecreatetruecolor($max_width, $max_height);
        $src_img = $image_create($source_file);
        list($width_orig, $height_orig) = getimagesize($source_file);

        $width_new = $height * $max_width / $max_height;
        $height_new = $width * $max_height / $max_width;

        $dst_height = ($max_width/$width_orig)*$height_orig;
        $dst_img = imagecreatetruecolor($max_width, $dst_height);

        //if the new width is greater than the actual width of the image, then the height is too large and the rest cut off, or vice versa
        if ($width_new > $width) {
            //cut point by height
            $h_point = (($height - $height_new) / 2);
            //copy image
            //imagecopyresampled($dst_img, $src_img, 0, 0, 0, $h_point, $max_width, $max_height, $width, $height_new);
            imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $max_width, $dst_height, $width_orig, $height_orig);
        } else {
            //cut point by width
            $w_point = (($width - $width_new) / 2);
            //imagecopyresampled($dst_img, $src_img, 0, 0, $w_point, 0, $max_width, $max_height, $width_new, $height);
            imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $max_width, $dst_height, $width_orig, $height_orig);
        }

        $image($dst_img, $dst_dir, $quality);

        if ($dst_img) imagedestroy($dst_img);
        if ($src_img) imagedestroy($src_img);
    }


    function resize($img){
        /*
        only if you script on another folder get the file name
        $r =explode("/",$img);
        $name=end($r);
        */
        //new folder
        $vdir_upload = "where u want to move";
        list($width_orig, $height_orig) = getimagesize($img);
        //ne size
        $dst_width = 110;
        $dst_height = ($dst_width/$width_orig)*$height_orig;
        $im = imagecreatetruecolor($dst_width,$dst_height);
        $image = imagecreatefromjpeg($img);
        imagecopyresampled($im, $image, 0, 0, 0, 0, $dst_width, $dst_height, $width_orig, $height_orig);
        //modive the name as u need
        imagejpeg($im,$vdir_upload . "small_" . $name);
        //save memory
        imagedestroy($im);
    }

    function createNewAccout($post){
        include('inc/harness.php');
        $check = $this->checkExisting($post["email"]);
        if($check == true){
            return array("messagecode"=>0,"message"=>"The users already exist in the system...");
        }else{

            if($_FILES["profile-image"]["name"] != '') {
                $fileName = $_FILES["profile-image"]["name"]; // The file name
                $fileTmpLoc = $_FILES["profile-image"]["tmp_name"]; // File in the PHP tmp folder
                $fileType = $_FILES["profile-image"]["type"]; // The type of file it is
                $fileSize = $_FILES["profile-image"]["size"]; // File size in bytes
                $fileErrorMsg = $_FILES["uploaded_file"]["error"]; // 0 for false... and 1 for true
                $fileName = preg_replace('#[^a-z.0-9]#i', '', $fileName);
                $kaboom = explode(".", $fileName); // Split file name into an array using the dot
                $fileExt = end($kaboom); // Now target the last array element to get the file extension
                 $fileName = time().rand().".".$fileExt;
                // START PHP Image Upload Error Handling --------------------------------------------------
                if ($fileSize > 5242880) { // if file size is larger than 5 Megabytes
                    $errors .= "ERROR: Your file was larger than 5 Megabytes in size.";
                    unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder
                } else if (!preg_match("/.(gif|jpg|png)$/i", $fileName)) {
                    // This condition is only if you wish to allow uploading of specific file types
                    $errors .= "ERROR: Your image was not .gif, .jpg, or .png.";
                    unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder

                } else if ($fileErrorMsg == 1) { // if file upload error key is equal to 1
                    $errors .= "ERROR: An error occured while processing the file. Try again.";
                }
                // END PHP Image Upload Error Handling ----------------------------------------------------
                // Place it into your "uploads" folder mow using the move_uploaded_file() function
                $moveResult = move_uploaded_file($fileTmpLoc, "img/profileimages/$fileName");
                // Check to make sure the move result is true before continuing
                if ($moveResult != true) {
                    $errors .=  "ERROR: File not uploaded. Try again.";
                }else{
                    $errors = 'none';
                    $this->resize_crop_image(200, 200, "img/profileimages/$fileName", "img/profileimages/$fileName");
                }
            }else{
                $errors = 'none';
            }

            if($errors == 'none'){
                $data->query("INSERT INTO caffeine_users SET fname = '".$data->real_escape_string($post["fname"])."', lname = '".$data->real_escape_string($post["lname"])."', email = '".$data->real_escape_string($post["email"])."', passcode = '".md5($post["password"])."', active = 'true', profile_image = '".$fileName."', access_level = '".$post["access_level"]."'");
                return array("messagecode"=>1,"message"=>"User has been created in the system.");
            }else{
                return array("messagecode"=>0, "message"=>$errors);
            }
        }
    }

    function checkExisting($email){
        include('inc/harness.php');
        $a = $data->query("SELECT * FROM caffeine_users WHERE email = '$email'");
        if($a->num_rows > 0){
            return true;
        }else{
            return false;
        }
    }

    function editAccount($post){
        include('inc/harness.php');

        if($_FILES["profile-image"]["name"] != '') {
            $fileName = $_FILES["profile-image"]["name"]; // The file name
            $fileTmpLoc = $_FILES["profile-image"]["tmp_name"]; // File in the PHP tmp folder
            $fileType = $_FILES["profile-image"]["type"]; // The type of file it is
            $fileSize = $_FILES["profile-image"]["size"]; // File size in bytes
            $fileErrorMsg = $_FILES["uploaded_file"]["error"]; // 0 for false... and 1 for true
            $fileName = preg_replace('#[^a-z.0-9]#i', '', $fileName);
            $kaboom = explode(".", $fileName); // Split file name into an array using the dot
            $fileExt = end($kaboom); // Now target the last array element to get the file extension
            $fileName = time().rand().".".$fileExt;
            // START PHP Image Upload Error Handling --------------------------------------------------
            if ($fileSize > 5242880) { // if file size is larger than 5 Megabytes
                $errors .= "ERROR: Your file was larger than 5 Megabytes in size.";
                unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder
            } else if (!preg_match("/.(gif|jpg|png)$/i", $fileName)) {
                // This condition is only if you wish to allow uploading of specific file types
                $errors .= "ERROR: Your image was not .gif, .jpg, or .png.";
                unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder

            } else if ($fileErrorMsg == 1) { // if file upload error key is equal to 1
                $errors .= "ERROR: An error occured while processing the file. Try again.";
            }
            // END PHP Image Upload Error Handling ----------------------------------------------------
            // Place it into your "uploads" folder mow using the move_uploaded_file() function
            $moveResult = move_uploaded_file($fileTmpLoc, "img/profileimages/$fileName");
            // Check to make sure the move result is true before continuing
            if ($moveResult != true) {
                $errors .=  "ERROR: File not uploaded. Try again.";
            }else{
                $errors = 'none';
                $this->resize_crop_image(100, 100, "img/profileimages/$fileName", "img/profileimages/$fileName");
            }

            $imagemod = "profile_image = '".$fileName."',";
        }else{
            $errors = 'none';
            $imagemod = '';
        }

        if($post["password"] != ''){
            $passWord = "passcode = '".md5($post["password"])."',";
        }else{
            $passWord = '';
        }

        if($errors == 'none'){
            $data->query("UPDATE caffeine_users SET fname = '".$data->real_escape_string($post["fname"])."', lname = '".$data->real_escape_string($post["lname"])."', $passWord email = '".$data->real_escape_string($post["email"])."', $imagemod access_level = '".$post["access_level"]."' WHERE id = '".$post["id"]."'");
            return array("messagecode"=>1,"message"=>"User has been created in the system.");
        }else{
            return array("messagecode"=>0, "message"=>$errors);
        }

    }

    function updateImgPos($proid,$left,$top){
        include('harness.php');
        $data->query("UPDATE caffeine_users SET img_left = '$left', img_top = '$top' WHERE id = '$proid'");
    }

    function insertUploads($filename){
        include('harness.php');
        $filename = $data->real_escape_string($filename);
        $filetypeSet = explode('.',$filename);
        $fileType = $filetypeSet[1];
        $userInfo = $this->auth();
        $userId = $userInfo["profileId"];
        $data->query("INSERT INTO uploads SET upload_name = '$filename', upload_type = '$fileType', upload_date = '".time()."', upload_by = '$userId'");
    }

    function getUploads(){
        include('harness.php');
        $a = $data->query("SELECT * FROM uploads WHERE active = 'true' ORDER BY upload_name DESC");
        $files = array();
        while($b = $a->fetch_array()){
            $files[] = array("upload_name"=>$b["upload_name"], "upload_type"=>$b["upload_type"],"upload_date"=>$b["upload_date"],"upload_by"=>$b["upload_by"],"active"=>$b["active"]);
        }

        return $files;
    }

    function getStats($begin,$end){
        include('harness.php');
        $response = array();
        if($begin == null && $end == null){
            $time = time();
            $timeout = date('Y-m-d', strtotime(' -12 day'));
            $timeout = strtotime($timeout);
            $a = $data->query("SELECT * FROM capture_visits WHERE visit_date BETWEEN $timeout AND $time");
            while($b = $a->fetch_assoc()){
                $response[] = $b;
            }
        }
        return $response;
    }

    function getPageviews(){
        include('harness.php');
        $time = time();
        $timeout = date('Y-m-d', strtotime(' -12 day'));
        $timeout = strtotime($timeout);
        $a = $data->query("SELECT * FROM capture_visits WHERE read_type = 'New' AND visit_date BETWEEN $timeout AND $time GROUP BY user_ip");
        $new = $a->num_rows;
        $c = $data->query("SELECT * FROM capture_visits WHERE read_type = 'Old' AND visit_date BETWEEN $timeout AND $time GROUP BY user_ip");
        $returning = $c->num_rows;
        $details = array("new_visits"=>$new, "returning"=>$returning);

        return $details;
    }

    function returnDates(){

        $begin = date('Y-m-d', strtotime(' -5 day'));
        $begin = new DateTime($begin);
        $end = date('Y-m-d', strtotime(' +1 day'));
        $end = new DateTime($end);

        $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);

        foreach($daterange as $date){
            include('harness.php');
            $datsz = $date->format("m/d/Y");

            $a = $data->query("SELECT visit_date FROM capture_visits WHERE read_date = '$datsz'");
            $dater = explode('/',$datsz);
            $dateout .= '"'.$dater[0].'/'.$dater[1].'",';
            $count .= $a->num_rows.',';
        }

        return array("dates"=>$dateout,"hits"=>$count);
    }

    function array_columnsno(array $array, $columnKey, $indexKey = null)
    {
        $result = array();
        foreach ($array as $subArray) {
            if (!is_array($subArray)) {
                continue;
            } elseif (is_null($indexKey) && array_key_exists($columnKey, $subArray)) {
                $result[] = $subArray[$columnKey];
            } elseif (array_key_exists($indexKey, $subArray)) {
                if (is_null($columnKey)) {
                    $result[$subArray[$indexKey]] = $subArray;
                } elseif (array_key_exists($columnKey, $subArray)) {
                    $result[$subArray[$indexKey]] = $subArray[$columnKey];
                }
            }
        }
        return $result;
    }


    function pageViews(){
        include('harness.php');
        $begin = date('Y-m-d', strtotime(' -11 day'));
        $begin = strtotime($begin);
        $end = date('Y-m-d', strtotime(' +1 day'));
        $end = strtotime($end);

        $a = $data->query("SELECT page FROM capture_visits WHERE visit_date BETWEEN '$begin' AND '$end' GROUP BY page LIMIT 50")or die('Error');
        while($b = $a->fetch_array()){
            $page[] = array("page"=>$b["page"]);
        }


        for($i=0; $i <= count($page); $i++){
            $c = $data->query("SELECT page FROM capture_visits WHERE page = '".$page[$i]["page"]."' AND visit_date BETWEEN '$begin' AND '$end'")or die('Error');
            $countPage = $c->num_rows;
            if($page[$i]["page"] != '') {
                if(strlen($page[$i]["page"]) > 13){
                    $pageOut = substr($page[$i]["page"], 0, 10).'...';
                }else{
                    $pageOut = $page[$i]["page"];
                }
                $pageCount[] = array("page" => $pageOut, "page_hits" => $countPage);
            }
        }

        //var_dump($pageCount);



        array_multisort($this->array_columnsno($pageCount, 'page_hits'), SORT_DESC, $pageCount);

        return $pageCount;
    }

    function getCaffDataEvents(){
        include('harness.php');
        $begin = date('Y-m-d', strtotime(' -11 day'));
        $begin = strtotime($begin);
        $end = date('Y-m-d', strtotime(' +1 day'));
        $end = strtotime($end);

        $a = $data->query("SELECT target, count(*) AS counter FROM caffeine_event_tracker WHERE date_set BETWEEN '$begin' AND '$end' GROUP BY target LIMIT 50") or die($data->error);

        while($b = $a->fetch_array()){
            $pageData[] = array("target"=>$b["target"],"hits"=>$b["counter"]);
        }

        if(!empty($pageData)){
            array_multisort($this->array_columnsno($pageData, 'page_hits'), SORT_DESC, $pageCount);
            return $pageData;
        }else{
            //DO NOTHING///

        }


    }

    function getUserAnalytics(){
        include('harness.php');
        $begin = date('Y-m-d', strtotime(' -11 day'));
        $begin = strtotime($begin);
        $end = date('Y-m-d', strtotime(' +1 day'));
        $end = strtotime($end);

        $a = $data->query("SELECT country, count(*) AS totcounter FROM capture_visits WHERE visit_date BETWEEN '$begin' AND '$end' AND country = 'United States' LIMIT 100") or die($data->error);

        while($b = $a->fetch_array()){
            $theDatas = array();
            $c = $data->query("SELECT state, count(*) AS counter FROM capture_visits WHERE visit_date BETWEEN '$begin' AND '$end' AND country = '".$b["country"]."' GROUP BY state LIMIT 100") or die($data->error);
            while($d = $c->fetch_array()){
            $theDatas[] = array("state"=>$d["state"], "hitcount"=>$d["counter"]);
            }

            $theDatasCountry[] = array("country"=>$b["country"], "totalcount"=>$b["totcounter"], "states_data"=>$theDatas);
        }

        return $theDatasCountry;
    }



    function getPageHistory($pagename){
        include('harness.php');
        $a = $data->query("SELECT * FROM page_repo WHERE page_id = '".$pagename."' AND backup_type = 'page' ORDER BY backup_date DESC LIMIT 8");
        if($a->num_rows >0) {
            while ($b = $a->fetch_array()) {
                $c = $data->query("SELECT * FROM caffeine_users WHERE id = '" . $b["last_user"] . "'");
                $d = $c->fetch_array();
                $pageDiff = $this->getPageRepoLine($b["id"]);
                if (is_array($pageDiff)) {
                    $repo = true;
                } else {
                    $repo = false;
                }
                $results[] = array("id" => $b["id"], "page_id" => $b["pager_id"], "page_content" => $b["page_content"], "backup_date" => $b["backup_date"], "last_user" => $d["fname"] . ' ' . $d["lname"], "codediff" => $repo);
            }

            return $results;
        }

    }

    function formatBytes($bytes, $precision = 2) {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        // Uncomment one of the following alternatives
        // $bytes /= pow(1024, $pow);
         $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    function dirSize($dir)
    {
        if(is_file($dir)) return array('size'=>filesize($dir),'howmany'=>0);
        if($dh=opendir($dir)) {
            $size=0;
            $n = 0;
            while(($file=readdir($dh))!==false) {
                if($file=='.' || $file=='..') continue;
                $n++;
                $data = $this->dirsize($dir.'/'.$file);
                $size += $data['size'];
                $n += $data['howmany'];
            }
            closedir($dh);
            $size = round($size);
            $check = $this->formatBytes($size);
            return $check;
        }
        return array('size'=>0,'howmany'=>0);
    }

    function getPageRepoLine($latest){
        include('harness.php');
        $a = $data->query("SELECT * FROM page_repo WHERE id = '$latest'");
        $b = $a->fetch_array();
        $c = $data->query("SELECT * FROM page_repo WHERE page_id = '".$b["page_id"]."' AND backup_date < '".$b["backup_date"]."' ORDER BY backup_date DESC LIMIT 1") or die('ERROR DIED');
        if($c->num_rows > 0){
            $d = $c->fetch_array();
            $results = array("message"=>"success","old"=>$d["page_content"],"new"=>$b["page_content"]);
        }else{
            $results = 'false';
        }
        return $results;
    }



    function renderContent($content){
        include('harness.php');
        $a = $data->query("SELECT * FROM page_repo WHERE id = '$content'");
        $b = $a->fetch_array();
        return $b["page_content"];
    }

    function restorePageContent($id,$type){
        include('harness.php');
        $authCreds = $this->auth();
        $userEdit = $authCreds["profileId"];
        $a = $data->query("SELECT * FROM page_repo WHERE id = '$id'");
        $b = $a->fetch_array();
        if($type == 'page') {
            $c = $data->query("UPDATE pages SET page_content = '" . $data->real_escape_string($b["page_content"]) . "', content_edit = '" . $data->real_escape_string($b["page_content_edits"]) . "', last_user = '$userEdit' WHERE id = '" . $b["page_id"] . "'")or die($data->error);
            return "<strong><i class=\"fa fa-check\" aria-hidden=\"true\"></i> Success!</strong> - Page " . date('m/d/Y H:i:s', $b["backup_date"]) . "Has been successfully restored. Refresh page to see changes.";
        }else{
            $c = $data->query("UPDATE beans SET bean_content = '" . $data->real_escape_string($b["page_content"]) . "', last_user = '$userEdit' WHERE id = '" . $b["page_id"] . "'");
            return "<strong><i class=\"fa fa-check\" aria-hidden=\"true\"></i> Success!</strong> - Bean " . date('m/d/Y H:i:s', $b["backup_date"]) . "Has been successfully restored. Refresh page to see changes.";
        }
    }

    function getBeanHistory($id){
        include('harness.php');
        $a = $data->query("SELECT * FROM page_repo WHERE page_id = '$id' AND backup_type = 'bean' ORDER BY backup_date DESC LIMIT 8");
        if($a->num_rows > 0) {
            while ($b = $a->fetch_array()) {
                $c = $data->query("SELECT * FROM caffeine_users WHERE id = '" . $b["last_user"] . "'");
                $d = $c->fetch_array();
                $pageDiff = $this->getBeanRepoLine($b["id"]);
                if (is_array($pageDiff)) {
                    $repo = true;
                } else {
                    $repo = false;
                }
                $results[] = array("id" => $b["id"], "page_id" => $b["pager_id"], "page_content" => $b["page_content"], "backup_date" => $b["backup_date"], "last_user" => $d["fname"] . ' ' . $d["lname"], "codediff" => $repo);
            }

            return $results;
        }

    }

    function getBeanRepoLine($latest){
        include('harness.php');
        $a = $data->query("SELECT * FROM page_repo WHERE id = '$latest' AND backup_type = 'bean'");
        $b = $a->fetch_array();
        $c = $data->query("SELECT * FROM page_repo WHERE page_id = '".$b["page_id"]."' AND backup_type = 'bean' AND backup_date < '".$b["backup_date"]."' ORDER BY backup_date DESC LIMIT 1") or die('ERROR DIED');
        if($c->num_rows > 0){
            $d = $c->fetch_array();
            $results = array("message"=>"success","old"=>$d["page_content"],"new"=>$b["page_content"]);
        }else{
            $results = 'false';
        }
        return $results;
    }

    function getVistLines(){
        include('harness.php');
        $begin = date('Y-m-d', strtotime(' -11 day'));
        $begin = strtotime($begin);
        $end = date('Y-m-d', strtotime(' +1 day'));
        $end = strtotime($end);
        $infoArs = array();

        $a = $data->query("SELECT * FROM capture_visits WHERE visit_date BETWEEN '$begin' AND '$end'  GROUP BY user_ip ORDER BY visit_date  DESC LIMIT 20");
        while($b = $a->fetch_assoc()){
            $infoArs[] = $b;
        }
        return $infoArs;

    }

    function getSiteSettings(){
        include('harness.php');
        $a = $data->query("SELECT * FROM site_settings WHERE id = '1'");
        $b = $a->fetch_assoc();
        return $b;
    }

    function updateSiteSettings($post){
        include('harness.php');
        $data->query("UPDATE site_settings SET site_name = '".$data->real_escape_string($post["site_name"])."', site_description = '".$data->real_escape_string($post["site_description"])."', site_keywords = '".$data->real_escape_string($post["site_keywords"])."', google_analytics = '".$data->real_escape_string($post["google_analytics"])."', timezone = '".$data->real_escape_string($post["timezone_set"])."' WHERE id = '1'");
    }

    function updateAdminColors($post){
        include('harness.php');
        $data->query("UPDATE site_settings SET admin_logo = '".$data->real_escape_string($post["admin_logo"])."', admin_color = '".$data->real_escape_string($post["admin_color"])."', default_color = '".$data->real_escape_string($post["default_color"])."', primary_color = '".$data->real_escape_string($post["primary_color"])."', success_color = '".$data->real_escape_string($post["success_color"])."', warning_color = '".$data->real_escape_string($post["warning_color"])."', danger_color = '".$data->real_escape_string($post["danger_color"])."' WHERE id = '1'");
    }

    function createSiteMap($siteUrl){
        $sitemaps .= '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
      http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';

        $pages = $this->getPages();
        for($i=0; $i < count($pages); $i++){
            if($pages[$i]["active"] == 'true') {
                $updateDate = date('Y-m-d') . 'T' . date('H:i:s') . '+00:00';
                $sitemaps .= '<url>
  <loc>http://' . $siteUrl . '/' . $pages[$i]["page_name"] . '</loc>
  <lastmod>' . $updateDate . '</lastmod>
</url>';
            }
        }

        $sitemaps .='</urlset>';

        file_put_contents("../sitemap.xml", $sitemaps);
    }

    function lockPage($id){
        include('harness.php');
        $a = $data->query("SELECT * FROM pages WHERE id = '$id'");
        $b = $a->fetch_array();
        if($b["page_lock"] == 'true'){
            $myArs = array("button_class"=>"btn btn-success","icon_set"=>"","button_text"=>"<i class=\"fa fa-lock\" aria-hidden=\"true\"></i> Lock Page to Developers");
            $data->query("UPDATE pages SET page_lock = 'false' WHERE id = '$id'");
        }else{
            $myArs = array("button_class"=>"btn btn-danger","icon_set"=>"","button_text"=>"<i class=\"fa fa-unlock\" aria-hidden=\"true\"></i> Unlock Page for Admins");
            $data->query("UPDATE pages SET page_lock = 'true' WHERE id = '$id'");
        }

        return $myArs;
    }

    function checkPage($pageid){
        include('harness.php');
        $a = $data->query("SELECT * FROM pages WHERE id = '$pageid'");
        $b = $a->fetch_array();

        $currentUser = $this->auth();
        $currentUser = $currentUser["profileId"];

        if($b["check_out"] != $currentUser){
            return 'false';
        }else{
            return 'true';
        }
    }

    function tidyHTML($buffer) {
        // load our document into a DOM object
        $dom = new DOMDocument();
        // we want nice output
        $dom->preserveWhiteSpace = false;
        $dom->loadHTML($buffer);
        $dom->formatOutput = true;
        return($dom->saveHTML());
    }

    function createExternalLink($link,$readlink){
        include('harness.php');
        $data->query("INSERT INTO pages SET page_name = '$link', page_title = 'link_type', page_template = '$readlink', page_type = 'link'");
    }

    //////NEW MENU FUNCTIONS HERE V2.5//////
    function createMenuShell($post){
        include('harness.php');
        if(isset($post["editid"])){
            $data->query("UPDATE pre_nav SET nav_link = '".$data->real_escape_string($post["nav-link"])."', nav_read = '".$data->real_escape_string($post["nav-image"])."', add_parent = '".$post["parent_link"]."' WHERE id = '".$post["editid"]."'");
        }else{
            $a = $data->query("INSERT INTO pre_nav SET nav_link = '".$data->real_escape_string($post["nav-link"])."', nav_read = '".$data->real_escape_string($post["nav-image"])."', is_image = '".$post["is_image"]."', navigation_id = '".$post["nav_id2"]."', add_parent = '".$post["parent_link"]."'");
            $newId = $data->insert_id;
            $this->removeNavObj($post["nav_id2"],$newId);
            return "this is ".$newId;
        }
    }

    function getSingleNavObj($id){
        include('harness.php');
        $a = $data->query("SELECT * FROM pre_nav WHERE id = '$id'");
        $b = $a->fetch_assoc();
        return $b;
    }

    function createNavi($post){
        include('harness.php');
        $menu_name = $post["menu_name"];
        $menu_id = str_replace(' ','_',$menu_name);
        $a = $data->query("SELECT * FROM navigation WHERE menu_name = '$menu_name'");
        if($a->num_rows == 0){
            $data->query("INSERT INTO navigation SET menu_name = '".$data->real_escape_string($menu_name)."', navigation_id = '".$data->real_escape_string($menu_id)."'");
            return json_encode(array("message"=>'good',"newid"=>$data->insert_id));
        }else{
            return json_encode(array("message"=>'bad',"newid"=>''));
        }
    }

    function updateMenuInfo($post){
        include('harness.php');
        $menu_name = $post["menu_name"];
        $menu_ul_class = $post["menu_ul_class"];
        $themenuid = $post["themenuid"];
        $data->query("UPDATE navigation SET menu_name = '$menu_name', menu_class = '$menu_ul_class' WHERE id = '$themenuid'");
    }

    function addMenuItem($post){
        include('harness.php');

        $link_display = $post["link_display"];
        $link_item = $post["link_item"];
        $link_class = $post["link_class"];
        $ul_class = $post["ul_class"];
        $li_class = $post["li_class"];
        $link_target = $post["link_target"];
        $link_attr = $post["link_attr"];
        $menu_parent = $post["menu_parent"];
        $mega_content = $post["mega_content"];
        $mega = $post["mega"];
        if(isset($post["inherent"])){
            $inherent = 'true';
        }else{
            $inherent = 'false';
        }

        if(isset($post["itemid"])){
            $data->query("UPDATE pre_nav SET nav_link = '".$data->real_escape_string($link_item)."', nav_read = '".$data->real_escape_string($link_display)."', nav_class = '".$data->real_escape_string($link_class)."', li_class = '".$data->real_escape_string($li_class)."', ul_class = '".$data->real_escape_string($ul_class)."',  nav_data_attr = '".$data->real_escape_string($link_attr)."', nav_target = '$link_target', mega_area = '".$data->real_escape_string($mega_content)."', mega_active = '$mega', add_parent = '$inherent' WHERE id = '".$post["itemid"]."'")or die($data->error);
            return json_encode(array("navread"=>$link_display,"editid"=>$post["itemid"]));
        }else{
            $data->query("INSERT INTO pre_nav SET nav_link = '".$data->real_escape_string($link_item)."', nav_read = '".$data->real_escape_string($link_display)."', nav_class = '".$data->real_escape_string($link_class)."', li_class = '".$data->real_escape_string($li_class)."', ul_class = '".$data->real_escape_string($ul_class)."', nav_data_attr = '".$data->real_escape_string($link_attr)."', nav_target = '$link_target', navigation_id = '$menu_parent', add_parent = '$inherent'")or die($data->error);
            return json_encode(array("newid"=>$data->insert_id, "navread"=>$link_display));
        }

    }

    function updatesNavi($post){
        include('harness.php');
        $menulayout =  $post["menulayout"];
        $data->query("UPDATE navigation SET menu_json = '".$data->real_escape_string(json_encode($post["navobjects"]))."', nav_html = '".$data->real_escape_string($menulayout)."' WHERE id = '".$post["navid"]."'");
    }

    function getNavHtml($navid){
        include('harness.php');
        $a = $data->query("SELECT * FROM navigation WHERE id = '$navid'");
        $b = $a->fetch_assoc();

        return $b;
    }

    function getNavObjects($menuid){
        include('harness.php');
        $ars = array();
        $a = $data->query("SELECT * FROM pre_nav WHERE navigation_id = '$menuid'");
        while($b = $a->fetch_assoc()){
            $ars[] = $b;
        }
        return $ars;
    }

    function navItemActive($nvitem)
    {
        include('harness.php');
        $a = $data->query("SELECT * FROM pre_nav WHERE id = '$nvitem'");
        $b = $a->fetch_array();
        if ($b["active"] == 'true') {
            $data->query("UPDATE pre_nav SET active= 'false' WHERE id = '" . $nvitem . "'");
        } else {
            $data->query("UPDATE pre_nav SET active= 'true' WHERE id = '" . $nvitem . "'");
        }
    }

        function getSingelNavObj($id){
            include('harness.php');
            $ars = array();
            $a = $data->query("SELECT * FROM pre_nav WHERE id = '$id'");
            $b = $a->fetch_assoc();
            $ars[] = $b;
            return $ars;
        }

    function deleteNavItem($id){
        include('harness.php');
        $data->query("DELETE FROM pre_nav WHERE id = '$id'")or die($data->error);
    }

    function deleteUser($id){
        include('harness.php');
        $data->query("UPDATE caffeine_users SET active = 'false' WHERE id = '$id'");

    }

    function navincludecose($id){
        include('harness.php');
        $a = $data->query("SELECT * FROM navigation WHERE id = '$id'");
            $b = $a->fetch_array();
        return $b["navigation_id"];
    }

    function getActivePages(){
        include('harness.php');
        $a = $data->query("SELECT * FROM pages WHERE active = 'true'");
        return $a->num_rows;
    }


    function Minify_Html($Html)
    {
        $Search = array(
            '/(\n|^)(\x20+|\t)/',
            '/(\n|^)\/\/(.*?)(\n|$)/',
            '/\n/',
            '/\<\!--.*?-->/',
            '/(\x20+|\t)/', # Delete multispace (Without \n)
            '/\>\s+\</', # strip whitespaces between tags
            '/(\"|\')\s+\>/', # strip whitespaces between quotation ("') and end tags
            '/=\s+(\"|\')/'); # strip whitespaces between = "'

        $Replace = array(
            "\n",
            "\n",
            " ",
            "",
            " ",
            "><",
            "$1>",
            "=$1");

        $Html = preg_replace($Search,$Replace,$Html);
        return $Html;
    }



    function createForm($post){

        include('harness.php');

        $form_name = str_replace(' ','_',$post["form_name"]);
        $form_json = $post["form_json"];
        $post_action = $post["post_action"];
        $form_class = $post["form_class"];
        $multi = $post["multi"];
        $crmset = $post["crmset"];
        $replyset = $post["replyset"];
        $subject = $post["subject"];
        $recipients = $post["recipients"];
        $success_mess = $data->real_escape_string($post["success_mess"]);
        $reply_mess = $data->real_escape_string($post["reply_mess"]);

        ///CREATE FROM ITEMS////

        $newArs = json_decode($form_json,true);


        for($i=0; $i < count($newArs); $i++) {
            $inputType = $newArs[$i]["fldTypes"];
            $anyOptions = $newArs[$i]["options"];


            if ($inputType == 'text_field') {
                $label = $newArs[$i]["field"]["lab"];
                $placeHolder = $newArs[$i]["field"]["placeholder"];
                $fieldclass = $newArs[$i]["field"]["fieldclass"];
                $containerclass = $newArs[$i]["field"]["containerclass"];
                $fieldname = $newArs[$i]["field"]["fieldname"];
                $fieldvalue = $newArs[$i]["field"]["fieldvalue"];
                $fieldtype = $newArs[$i]["field"]["fieldtype"];
                $maxlenght = $newArs[$i]["field"]["maxlenght"];
                if (isset($newArs[$i]["field"]["required"])) {
                    $required = 'required="required"';
                } else {
                    $required = '';
                }

                if ($placeHolder != null) {
                    $placeHolder = 'placeholder="' . $placeHolder . '"';
                } else {
                    $placeHolder = '';
                }

                if ($maxlenght != null) {
                    $maxlenght = 'maxlength="' . $maxlenght . '"';
                } else {
                    $maxlenght = '';
                }

                $form .= '<div class="' . $containerclass . '"><label>' . $label . '</label><br><input class="' . $fieldclass . '" type="'.$fieldtype.'" name="' . $fieldname . '" id="' . $fieldname . '" value="' . $fieldvalue . '" ' . $placeHolder . ' ' . $maxlenght . ' ' . $required . '></div>';

                $item .= '' . $fieldname . ' VARCHAR(100) NOT NULL,';
            }

            if ($inputType == 'select') {
                $label = $newArs[$i]["field"]["lab"];
                $placeHolder = $newArs[$i]["field"]["placeholder"];
                $fieldclass = $newArs[$i]["field"]["fieldclass"];
                $containerclass = $newArs[$i]["field"]["containerclass"];
                $fieldname = $newArs[$i]["field"]["fieldname"];

                if (isset($newArs[$i]["field"]["required"])) {
                    $required = 'required="required"';
                } else {
                    $required = '';
                }

                $form .= '<div class="' . $containerclass . '"><label>' . $label . '</label><br><select name="' . $fieldname . '" id="' . $fieldname . '" class="' . $fieldclass . '" ' . $required . '>';

                foreach ($anyOptions as $key => $val) {
                    $form .= '<option value="' . $val . '">' . $key . '</option>';
                }

                $form .= '</select></div>';

                $item .= '' . $fieldname . ' VARCHAR(200) NOT NULL,';

            }

            if ($inputType == 'checkbox') {
                $label = $newArs[$i]["field"]["lab"];
                $placeHolder = $newArs[$i]["field"]["placeholder"];
                $fieldclass = $newArs[$i]["field"]["fieldclass"];
                $containerclass = $newArs[$i]["field"]["containerclass"];
                $fieldname = $newArs[$i]["field"]["fieldname"];

                if (isset($newArs[$i]["field"]["required"])) {
                    $required = 'required minlength="1"';
                    $ersLab = '<label for="' . $fieldname . '[]" class="error" style="display:none">Must select at least one</label>';
                } else {
                    $required = '';
                    $ersLab = '';
                }

                $form .= '<div class="' . $containerclass . '"><label>' . $label . '</label><br>'.$ersLab;

                if(isset($newArs[$i]["field"]["inline"])){
                    $inline = 'style="display:inline-block; padding:5px"';
                }else{
                    $inline = '';
                }

                $ch=0;
                foreach ($anyOptions as $key => $val) {
                    if($ch == 0){
                        $required = $required;
                    }else{
                        $required = '';
                    }
                    $form .= '<div '.$inline.'><input class="' . $fieldclass . '" type="checkbox" id="'.$fieldclass.''.$ch.'" name="' . $fieldname . '[]" value="' . $val . '" '.$required.'> <label for="'.$fieldclass.''.$ch.'">' . $key . ' </label></div>';
                    $ch++;
                }

                $form .= '</div>';
                $item .= '' . $fieldname . ' VARCHAR(200) NOT NULL,';
            }

            if ($inputType == 'radio') {
                $label = $newArs[$i]["field"]["lab"];
                $placeHolder = $newArs[$i]["field"]["placeholder"];
                $fieldclass = $newArs[$i]["field"]["fieldclass"];
                $containerclass = $newArs[$i]["field"]["containerclass"];
                $fieldname = $newArs[$i]["field"]["fieldname"];

                if (isset($newArs[$i]["field"]["required"])) {
                    $required = 'required minlength="1"';
                    $ersLab = '<label for="' . $fieldname . '" class="error" style="display:none">Must select at least one</label>';
                } else {
                    $required = '';
                    $ersLab = '';
                }

                if(isset($newArs[$i]["field"]["inline"])){
                    $inline = 'style="display:inline-block; padding:5px"';
                }else{
                    $inline = '';
                }

                $form .= '<div class="' . $containerclass . '"><label>' . $label . '</label><br>'.$ersLab;

                $ch=0;
                foreach ($anyOptions as $key => $val) {
                    if($ch == 0){
                        $required = $required;
                    }else{
                        $required = '';
                    }
                    $form .= '<div '.$inline.'><input class="' . $fieldclass . '" type="radio" name="' . $fieldname . '" id="' . $fieldname . ''.$ch.'" value="'.$val.'" '.$required.'> <label for="' . $fieldname . ''.$ch.'">' . $key . ' </label></div>';
                    $ch++;
                }

                $form .= '</div>';
                $item .= '' . $fieldname . ' VARCHAR(200) NOT NULL,';

            }

            if ($inputType == 'text_area') {
                $label = $newArs[$i]["field"]["lab"];
                $placeHolder = $newArs[$i]["field"]["placeholder"];
                $fieldclass = $newArs[$i]["field"]["fieldclass"];
                $containerclass = $newArs[$i]["field"]["containerclass"];
                $fieldname = $newArs[$i]["field"]["fieldname"];
                $fieldvalue = $newArs[$i]["field"]["fieldvalue"];
                if (isset($newArs[$i]["field"]["required"])) {
                    $required = 'required="required"';
                } else {
                    $required = '';
                }

                if ($placeHolder != null) {
                    $placeHolder = 'placeholder="' . $placeHolder . '"';
                } else {
                    $placeHolder = '';
                }

                $form .= '<div class="' . $containerclass . '"><label>' . $label . '</label><br><textarea class="' . $fieldclass . '" name="' . $fieldname . '" id="' . $fieldname . '" ' . $placeHolder . '>' . $fieldvalue . '</textarea></div>';
                $item .= '' . $fieldname . ' TEXT  NOT NULL,';
            }

            if ($inputType == 'div') {
                $containerclass = $newArs[$i]["field"]["containerclass"];
                $divcontents = $newArs[$i]["field"]["div"];

                $form .= '<div class="' . $containerclass . '">' . $divcontents . '</div>';

            }

            if ($inputType == 'hidden') {
                $fieldname = $newArs[$i]["field"]["fieldname"];
                $fieldvalue = $newArs[$i]["field"]["fieldvalue"];
                $fieldclass = $newArs[$i]["field"]["fieldclass"];

                $form .= '<input type="hidden" name="' . $fieldname . '" id="' . $fieldname . '" value="' . $fieldvalue . '">';
                $item .= '' . $fieldname . ' VARCHAR(200) NOT NULL,';

            }

            if ($inputType == 'header') {
                $headertype = $newArs[$i]["field"]["headertype"];
                $containerclass = $newArs[$i]["field"]["containerclass"];
                $lab = $newArs[$i]["field"]["lab"];

                if ($containerclass != null) {
                    $class = 'class="' . $containerclass . '"';
                } else {
                    $class = '';
                }

                $form .= '<' . $headertype . ' ' . $class . '>' . $lab . '</' . $headertype . '>';

            }


            if ($inputType == 'paragraph') {
                $fieldclass = $newArs[$i]["field"]["fieldclass"];
                $containerclass = $newArs[$i]["field"]["containerclass"];
                $para = $newArs[$i]["field"]["para"];

                if ($containerclass != null) {
                    $class = 'class="' . $containerclass . '"';
                } else {
                    $class = '';
                }

                if ($fieldclass != null) {
                    $paraClass = 'class="' . $fieldclass . '"';
                } else {
                    $paraClass = '';
                }

                $form .= '<div ' . $class . '><p ' . $paraClass . '>' . $para . '</p></div>';

            }

            if ($inputType == 'file_upload') {
                $lab = $newArs[$i]["field"]["lab"];
                $fieldclass = $newArs[$i]["field"]["fieldclass"];
                $containerclass = $newArs[$i]["field"]["containerclass"];
                $fieldname = $newArs[$i]["field"]["fieldname"];
                $fielddesti = $newArs[$i]["field"]["fielddesti"];

                if ($containerclass != null) {
                    $class = 'class="' . $containerclass . '"';
                } else {
                    $class = '';
                }

                if ($fieldclass != null) {
                    $fieldclass = 'class="' . $fieldclass . '"';
                } else {
                    $fieldclass = '';
                }

                if (isset($newArs[$i]["field"]["required"])) {
                    $required = 'required="required"';
                } else {
                    $required = '';
                }

                $form .= '<div ' . $class . '><lable>' . $lab . '</lable><br><input ' . $fieldclass . ' type="file" id="' . $fieldname . '" name="' . $fieldname . '" '.$required.'><input class="upload_desti" type="hidden" name="files_dir" id="files_dir" value="' . $fielddesti . '"></div>';
                $item .= '' . $fieldname . ' TEXT  NOT NULL,';
            }

            if ($inputType == 'button') {
                $buttonclass = $newArs[$i]["field"]["buttonclass"];
                $containerclass = $newArs[$i]["field"]["containerclass"];
                $lab = $newArs[$i]["field"]["lab"];

                if ($buttonclass != null) {
                    $class = 'class="' . $buttonclass . '"';
                } else {
                    $class = '';
                }

                if ($containerclass != null) {
                    $containclass = 'class="' . $containerclass . '"';
                } else {
                    $containclass = '';
                }

                $form .= '<div ' . $containclass . '><button ' . $class . '>' . $lab . '</button></div>';

            }
        }

            //$formcontent .= '<form class="'.$form_class.'" id="'.$form_name.'" name="'.$form_name.'" method="post" action="">';
            $formcontent .= $form;
            //$formcontent .= '</form>';

        $df = $data->query("SELECT * FROM forms_data WHERE form_name = '$form_name'");

        if($df->num_rows == 0){
            $data->query("INSERT INTO forms_data SET form_name = '$form_name', post_link = '$post_action', form_class = '$form_class', is_multi = '$multi', crmpush = '$crmset', recipients = '$recipients', subject = '$subject', form_data = '$form_json', form_elems = '$formcontent', success_mess = '".$success_mess."', reply_message = '".$reply_mess."', reply_active = '$replyset'");
        }else{
            //die('NOTICE - A form with that name already exists.');
        }


        $data->query("DROP TABLE $form_name");

        $sql = 'CREATE TABLE '.str_replace(' ','_',$form_name).' (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,'.$item.'receive_date INT(100) NOT NULL, active VARCHAR(12) DEFAULT \'true\', status VARCHAR(12) DEFAULT \'new\')';
        $data->query($sql)or die($data->error);

        return 'success';
    }

    function getFormElems($json){
        $newArs = json_decode($json,true);


        for($i=0; $i < count($newArs); $i++) {
            $inputType = $newArs[$i]["fldTypes"];
            $anyOptions = $newArs[$i]["options"];


            if ($inputType == 'text_field') {
                $rand = rand(5, 500).date('is');
                $label = $newArs[$i]["field"]["lab"];
                $placeHolder = $newArs[$i]["field"]["placeholder"];
                $fieldclass = $newArs[$i]["field"]["fieldclass"];
                $containerclass = $newArs[$i]["field"]["containerclass"];
                $fieldname = $newArs[$i]["field"]["fieldname"];
                $fieldvalue = $newArs[$i]["field"]["fieldvalue"];
                $maxlenght = $newArs[$i]["field"]["maxlenght"];
                $fieldtype = $newArs[$i]["field"]["fieldtype"];
                if (isset($newArs[$i]["field"]["required"])) {
                    $required = 'required="required"';
                    $checked = 'checked="checked"';
                } else {
                    $required = '';
                    $checked = '';
                }

                if ($placeHolder != null) {
                    $placeHolder = $placeHolder;
                } else {
                    $placeHolder = '';
                }

                if ($maxlenght != null) {
                    $maxlenght = 'maxlength="' . $maxlenght . '"';
                } else {
                    $maxlenght = '';
                }

                if($required != ''){
                    $isre ='<span class="asrtric" style="color:red"> *</span>';
                }else{
                    $isre = '';
                }


                $html .= '<div style="padding: 10px; background: #efefef; margin: 3px;" class="allcont-'.$rand.' row"><div class="col-md-4"><i class="textfld_icon"></i> &nbsp; &nbsp; <span class="fldnames-'.$rand.'">'.$label.'</span>'.$isre.'</div><div class="col-md-8" style="text-align: right"><button class="btn btn-sm btn-secondary edits-area" data-fieldars="'.$rand.'">Edit</button> <button class="btn btn-sm btn-danger theremoves" data-frmitm="'.$rand.'">Remove</button></div><div class="clearfix"></div>';
                $html .= '<div class="text_filed_edits_'.$rand.' frmarrs" style="background: #fff; padding:5px; margin-top:5px; display:none" data-elmtype="text_field">';

                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Required</label></div><div class="col-md-9"><input class="reqs" data-checkdata="'.$rand.'" type="checkbox" name="required-'.$rand.'" id="required-'.$rand.'" '.$checked.'></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Label</label></div><div class="col-md-9"><input class="form-control labsset"  type="text" value="'.$label.'" name="lab-'.$rand.'" id="lab-'.$rand.'" data-fldname="'.$rand.'"></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Placeholder</label></div><div class="col-md-9"><input class="form-control" type="text" value="'.$placeHolder.'" name="placeholder-'.$rand.'" id="placeholder-'.$rand.'"></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Field Class</label></div><div class="col-md-9"><input class="form-control" type="text" value="'.$fieldclass.'" name="fieldclass-'.$rand.'" id="fieldclass-'.$rand.'"></div></div>';
                $html .= '<div class="clearfix" class="row"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Container Class</label></div><div class="col-md-9"><input class="form-control" type="text" value="'.$containerclass.'" name="containerclass-'.$rand.'" id="containerclass-'.$rand.'"></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Name</label></div><div class="col-md-9"><input class="form-control" type="text" value="'.$fieldname.'" name="fieldname-'.$rand.'" id="fieldname-'.$rand.'"></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Value</label></div><div class="col-md-9"><input class="form-control" type="text" value="'.$fieldvalue.'" name="fieldvalue-'.$rand.'" id="fieldvalue-'.$rand.'"></div></div>';



                $text_typs = array("text"=>"Text Field","email"=>"Email","password"=>"Password");

                foreach($text_typs as $val=>$key){

                    if($fieldtype == $val){
                        $optsOuts .= '<option value="'.$val.'" selected="selected">'.$key.'</option>';
                    }else{
                        $optsOuts .= '<option value="'.$val.'">'.$key.'</option>';
                    }

                }

                $html .= '<div class="clearfix"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Type</label></div><div class="col-md-9"><select class="form-control" name="fieldtype-'.$rand.'" id="fieldtype-'.$rand.'">'.$optsOuts.'</select></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Max Length</label></div><div class="col-md-2"><input class="form-control" type="text" value="'.$maxlenght.'" name="maxlength-'.$rand.'" id="maxlenght-'.$rand.'"></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<hr>';
                $html .= '<div style="padding:5px; text-align: center"><button class="btn btn-success edits-area" data-fieldars="'.$rand.'">Done</button></div>';


                $html .= '</div></div>';
                $optsOuts = '';
            }

            if ($inputType == 'select') {
                $label = $newArs[$i]["field"]["lab"];
                $placeHolder = $newArs[$i]["field"]["placeholder"];
                $fieldclass = $newArs[$i]["field"]["fieldclass"];
                $containerclass = $newArs[$i]["field"]["containerclass"];
                $fieldname = $newArs[$i]["field"]["fieldname"];

                if (isset($newArs[$i]["field"]["required"])) {
                    $required = 'required="required"';
                    $checked = 'checked="checked"';
                } else {
                    $required = '';
                    $checked = '';
                }

                if($required != ''){
                    $isre ='<span class="asrtric" style="color:red"> *</span>';
                }else{
                    $isre = '';
                }


                $rand = rand(5, 500).date('is');
                $html .= '<div style="padding: 10px; background: #efefef; margin: 3px;" class="allcont-'.$rand.' row"><div class="col-md-4"><i class="select_icon"></i> &nbsp; &nbsp; <span class="fldnames-'.$rand.'">'.$label.'</span>'.$isre.'</div><div style="text-align: right" class="col-md-8"><button class="btn btn-sm btn-secondary edits-area" data-fieldars="'.$rand.'">Edit</button> <button class="btn btn-sm btn-danger theremoves" data-frmitm="'.$rand.'">Remove</button></div><div class="clearfix"></div>';
                $html .= '<div class="text_filed_edits_'.$rand.' frmarrs" style="background: #fff; padding:5px; margin-top:5px; display:none" data-elmtype="select">';

                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Required</label></div><div class="col-md-9"><input type="checkbox" class="reqs" data-checkdata="'.$rand.'" name="required-'.$rand.'" id="required-'.$rand.'" '.$checked.'></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Label</label></div><div class="col-md-9"><input class="form-control labsset"  type="text" value="'.$label.'" name="lab-'.$rand.'" id="lab-'.$rand.'" data-fldname="'.$rand.'"></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Placeholder</label></div><div class="col-md-9"><input class="form-control" type="text" value="'.$placeHolder.'" name="placeholder-'.$rand.'" id="placeholder-'.$rand.'"></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Field Class</label></div><div class="col-md-9"><input class="form-control" type="text" value="'.$fieldclass.'" name="fieldclass-'.$rand.'" id="fieldclass-'.$rand.'"></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Container Class</label></div><div class="col-md-9"><input class="form-control" type="text" value="'.$containerclass.'" name="containerclass-'.$rand.'" id="containerclass-'.$rand.'"></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Name</label></div><div class="col-md-9"><input class="form-control" type="text" value="'.$fieldname.'" name="fieldname-'.$rand.'" id="fieldname-'.$rand.'"></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<input type="hidden" name="fieldtype-'.$rand.'" id="fieldtype-'.$rand.'" value="select">';
                $html .= '<div class="clearfix"></div>';
                $html .= '<br><br>';

                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Options</label></div><div class="col-md-9">';

                $html .= '<ul class="list-group sele-opt'.$rand.' sortable">';

                $itt = 0;
                foreach ($anyOptions as $key => $val) {
                    if($itt == 0){
                        $html .= '<li class="list-group-item selopts-'.$itt.''.$rand.'"><div class="row"><div class="col-md-5"><input class="form-control" type="text" name="option-'.$itt.''.$rand.'" id="option-'.$itt.''.$rand.'" value="'.$key.'"></div><div class="col-md-5"><input class="form-control" type="text" name="value-'.$itt.''.$rand.'" id="value-'.$itt.''.$rand.'" value="'.$val.'"></div><div class="col-md-2"></div></div><div style="clear: both"></div></li>';
                    }else{
                        $html .= '<li class="list-group-item selopts-'.$itt.''.$rand.'"><div class="row"><div class="col-md-5"><input class="form-control" type="text" name="option-'.$itt.''.$rand.'" id="option-'.$itt.''.$rand.'" value="'.$key.'"></div><div class="col-md-5"><input class="form-control" type="text" name="value-'.$itt.''.$rand.'" id="value-'.$itt.''.$rand.'" value="'.$val.'"></div><div class="col-md-2"><button class="btn btn-sm btn-danger removeoption" data-optionid="'.$itt.''.$rand.'">X</button></div></div><div style="clear: both"></div></li>';
                    }

                    $itt++;
                }

              $html .= '</ul>';


                $html .= '<button style="float: right; margin:20px" class="btn btn-primary addopts" data-optionfld="'.$rand.'">Add Option +</button>';

                $html .='</div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<hr>';
                $html .= '<div style="padding:5px; text-align: center"><button class="btn btn-success edits-area" data-fieldars="'.$rand.'">Done</button></div>';
                $html .= '<div class="clearfix"></div>';

                $html .= '</div></div>';

            }



            if ($inputType == 'location_selector') {
                $label = $newArs[$i]["field"]["lab"];
                $placeHolder = $newArs[$i]["field"]["placeholder"];
                $fieldclass = $newArs[$i]["field"]["fieldclass"];
                $containerclass = $newArs[$i]["field"]["containerclass"];
                $fieldname = $newArs[$i]["field"]["fieldname"];

                if (isset($newArs[$i]["field"]["required"])) {
                    $required = 'required="required"';
                    $checked = 'checked="checked"';
                } else {
                    $required = '';
                    $checked = '';
                }

                if($required != ''){
                    $isre ='<span class="asrtric" style="color:red"> *</span>';
                }else{
                    $isre = '';
                }


                $rand = rand(5, 500).date('is');
                $html .= '<div style="padding: 10px; background: #efefef; margin: 3px;" class="allcont-'.$rand.' row"><div class="col-md-4"><i class="select_icon"></i> &nbsp; &nbsp; <span class="fldnames-'.$rand.'">'.$label.'</span>'.$isre.'</div><div style="text-align: right" class="col-md-8"><button class="btn btn-sm btn-secondary edits-area" data-fieldars="'.$rand.'">Edit</button> <button class="btn btn-sm btn-danger theremoves" data-frmitm="'.$rand.'">Remove</button></div><div class="clearfix"></div>';
                $html .= '<div class="text_filed_edits_'.$rand.' frmarrs" style="background: #fff; padding:5px; margin-top:5px; display:none" data-elmtype="location_selector">';

                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Required</label></div><div class="col-md-9"><input type="checkbox" class="reqs" data-checkdata="'.$rand.'" name="required-'.$rand.'" id="required-'.$rand.'" '.$checked.'></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Label</label></div><div class="col-md-9"><input class="form-control labsset"  type="text" value="'.$label.'" name="lab-'.$rand.'" id="lab-'.$rand.'" data-fldname="'.$rand.'"></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Placeholder</label></div><div class="col-md-9"><input class="form-control" type="text" value="'.$placeHolder.'" name="placeholder-'.$rand.'" id="placeholder-'.$rand.'"></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Field Class</label></div><div class="col-md-9"><input class="form-control" type="text" value="'.$fieldclass.'" name="fieldclass-'.$rand.'" id="fieldclass-'.$rand.'"></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Container Class</label></div><div class="col-md-9"><input class="form-control" type="text" value="'.$containerclass.'" name="containerclass-'.$rand.'" id="containerclass-'.$rand.'"></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Name</label></div><div class="col-md-9"><input class="form-control" type="text" value="'.$fieldname.'" name="fieldname-'.$rand.'" id="fieldname-'.$rand.'" disabled="disabled"></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<input type="hidden" name="fieldtype-'.$rand.'" id="fieldtype-'.$rand.'" value="location_selector">';
                $html .= '<div class="clearfix"></div>';
                $html .= '<br><br>';

                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Options</label></div><div class="col-md-9">';

                $html .= '<ul class="list-group sele-opt'.$rand.' sortable">';


                $itt = 0;
                //var_dump($anyOptions);
                if(array_key_exists('Select Location', $anyOptions)){

                }else{
                    $html .= '<li class="list-group-item selopts-' . $itt . '' . $rand . '"><div class="row"><div class="col-md-5"><input class="form-control" type="text" name="option-' . $itt . '' . $rand . '" id="option-' . $itt . '' . $rand . '" value="Select Location" disabled="disabled"></div><div class="col-md-5"><input class="form-control" type="text" name="value-' . $itt . '' . $rand . '" id="value-' . $itt . '' . $rand . '" value="" disabled="disabled"></div><div class="col-md-2"></div></div><div style="clear: both"></div></li>';
                }

                foreach ($anyOptions as $key => $val) {
                    if($itt == 0){
                        if($key != 'Select Location') {
                            $html .= '<li class="list-group-item selopts-' . $itt . '' . $rand . '"><div class="row"><div class="col-md-5"><input class="form-control" type="text" name="option-' . $itt . '' . $rand . '" id="option-' . $itt . '' . $rand . '" value="' . $key . '" disabled="disabled"></div><div class="col-md-5"><input class="form-control" type="text" name="value-' . $itt . '' . $rand . '" id="value-' . $itt . '' . $rand . '" value="' . $val . '"></div><div class="col-md-2"></div></div><div style="clear: both"></div></li>';
                        }else{
                            $html .= '<li class="list-group-item selopts-' . $itt . '' . $rand . '"><div class="row"><div class="col-md-5"><input class="form-control" type="text" name="option-' . $itt . '' . $rand . '" id="option-' . $itt . '' . $rand . '" value="' . $key . '" disabled="disabled"></div><div class="col-md-5"><input class="form-control" type="text" name="value-' . $itt . '' . $rand . '" id="value-' . $itt . '' . $rand . '" value="" disabled="disabled"></div><div class="col-md-2"></div></div><div style="clear: both"></div></li>';
                        }
                    }else{
                        if($key != 'Select Location') {
                            $html .= '<li class="list-group-item selopts-' . $itt . '' . $rand . '"><div class="row"><div class="col-md-5"><input class="form-control" type="text" name="option-' . $itt . '' . $rand . '" id="option-' . $itt . '' . $rand . '" value="' . $key . '" disabled="disabled"></div><div class="col-md-5"><input class="form-control" type="text" name="value-' . $itt . '' . $rand . '" id="value-' . $itt . '' . $rand . '" value="' . $val . '"></div><div class="col-md-2"></div></div><div style="clear: both"></div></li>';
                        }else{
                            $html .= '<li class="list-group-item selopts-' . $itt . '' . $rand . '"><div class="row"><div class="col-md-5"><input class="form-control" type="text" name="option-' . $itt . '' . $rand . '" id="option-' . $itt . '' . $rand . '" value="' . $key . '" disabled="disabled"></div><div class="col-md-5"><input class="form-control" type="text" name="value-' . $itt . '' . $rand . '" id="value-' . $itt . '' . $rand . '" value="" disabled="disabled"></div><div class="col-md-2"></div></div><div style="clear: both"></div></li>';
                        }
                    }

                    $itt++;
                }

                $html .= '</ul>';


               //$html .= '<button style="float: right; margin:20px" class="btn btn-primary addopts" data-optionfld="'.$rand.'">Add Option +</button>';

                $html .='</div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<hr>';
                $html .= '<div style="padding:5px; text-align: center"><button class="btn btn-success edits-area" data-fieldars="'.$rand.'">Done</button></div>';
                $html .= '<div class="clearfix"></div>';

                $html .= '</div></div>';

            }

            if ($inputType == 'checkbox') {
                $label = $newArs[$i]["field"]["lab"];
                $placeHolder = $newArs[$i]["field"]["placeholder"];
                $fieldclass = $newArs[$i]["field"]["fieldclass"];
                $containerclass = $newArs[$i]["field"]["containerclass"];
                $fieldname = $newArs[$i]["field"]["fieldname"];

                if (isset($newArs[$i]["field"]["required"])) {
                    $required = 'required="required"';
                    $checked = 'checked="checked"';
                } else {
                    $required = '';
                    $checked = '';
                }

                if($required != ''){
                    $isre ='<span class="asrtric" style="color:red"> *</span>';
                }else{
                    $isre = '';
                }


                if(isset($newArs[$i]["field"]["inline"])){
                    $inlin = 'checked="checked"';
                }else{
                    $inlin = '';
                }


                $rand = rand(5, 500).date('is');
                $html .= '<div style="padding: 10px; background: #efefef; margin: 3px;" class="allcont-'.$rand.' row"><div class="col-md-4"><i class="checkbox_icon"></i> &nbsp; &nbsp; <span class="fldnames-'.$rand.'">'.$label.'</span>'.$isre.'</div><div style="text-align: right" class="col-md-8"><button class="btn btn-sm btn-secondary edits-area" data-fieldars="'.$rand.'">Edit</button> <button class="btn btn-sm btn-danger theremoves" data-frmitm="'.$rand.'">Remove</button></div><div class="clearfix"></div>';
                $html .= '<div class="text_filed_edits_'.$rand.' frmarrs" style="background: #fff; padding:5px; margin-top:5px; display:none" data-elmtype="checkbox">';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Required</label></div><div class="col-md-9"><input type="checkbox" class="reqs" data-checkdata="'.$rand.'" name="required-'.$rand.'" id="required-'.$rand.'" '.$checked.'></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Label</label></div><div class="col-md-9"><input class="form-control labsset"  type="text" value="'.$label.'" name="lab-'.$rand.'" id="lab-'.$rand.'" data-fldname="'.$rand.'"></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Field Class</label></div><div class="col-md-9"><input class="form-control" type="text" value="'.$fieldclass.'" name="fieldclass-'.$rand.'" id="fieldclass-'.$rand.'"></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Container Class</label></div><div class="col-md-9"><input class="form-control" type="text" value="'.$containerclass.'" name="containerclass-'.$rand.'" id="containerclass-'.$rand.'"></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Name</label></div><div class="col-md-9"><input class="form-control" type="text" value="'.$fieldname.'" name="fieldname-'.$rand.'" id="fieldname-'.$rand.'"></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Inline</label></div><div class="col-md-9"><input type="checkbox" name="inline-'.$rand.'" id="inline-'.$rand.'" '.$inlin.'> | <small>Display checkboxes inline.</small></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<input type="hidden" name="fieldtype-'.$rand.'" id="fieldtype-'.$rand.'" value="checkbox">';
                $html .= '<div class="clearfix"></div>';
                $html .= '<br><br>';

                $html .= '<div style="padding:5px"><div class="col-md-3"><label>Checkbox Options</label></div><div class="col-md-9">';

                $html .= '<ul class="list-group sele-opt'.$rand.' sortable">';

                $checkss = 0;
                foreach ($anyOptions as $key => $val) {

                    if($checkss == 0){
                        $remCheck = '';
                    }else{
                        $remCheck = '<button class="btn btn-sm btn-danger removeoption" data-optionid="'.$rand.'-'.$checkss.'">X</button>';
                    }

                    $html .='<li class="list-group-item selopts-'.$rand.'-'.$checkss.'"><div class="row"><div class="col-md-5"><input class="form-control" type="text" name="option-'.$rand.'-'.$checkss.'" id="option-'.$rand.'-'.$checkss.'" value="'.$key.'"></div><div class="col-md-5"><input class="form-control" type="text" name="value-'.$rand.'-'.$checkss.'" id="value-'.$rand.'-'.$checkss.'" value="'.$val.'"></div><div class="col-md-2">'.$remCheck.'</div></div><div style="clear: both"></div></li>';
                    $checkss++;
                }
$html .= '</ul>';

                $html .= '<button style="float: right; margin:20px" class="btn btn-primary addopts" data-optionfld="'.$rand.'">Add Option +</button>';

                $html .='</div></div>';
                $html .= '<hr>';
                $html .= '<div style="padding:5px; text-align: center"><button class="btn btn-success edits-area" data-fieldars="'.$rand.'">Done</button></div>';
                $html .= '<div class="clearfix"></div>';

                $html .= '</div></div>';
            }

            if ($inputType == 'radio') {
                $label = $newArs[$i]["field"]["lab"];
                $placeHolder = $newArs[$i]["field"]["placeholder"];
                $fieldclass = $newArs[$i]["field"]["fieldclass"];
                $containerclass = $newArs[$i]["field"]["containerclass"];
                $fieldname = $newArs[$i]["field"]["fieldname"];

                if (isset($newArs[$i]["field"]["required"])) {
                    $required = 'required="required"';
                    $checked = 'checked="checked"';
                } else {
                    $required = '';
                    $checked = '';
                }

                if($required != ''){
                    $isre ='<span class="asrtric" style="color:red"> *</span>';
                }else{
                    $isre = '';
                }

                $rand = rand(5, 500).date('is');
                $html .= '<div style="padding: 10px; background: #efefef; margin: 3px;" class="allcont-'.$rand.' row"><div class="col-md-4"><i class="radio_icon"></i> &nbsp; &nbsp; <span class="fldnames-'.$rand.'">Radio</span>'.$isre.'</div><div style="text-align: right" class="col-md-8"><button class="btn btn-sm btn-secondary edits-area" data-fieldars="'.$rand.'">Edit</button> <button class="btn btn-sm btn-danger theremoves" data-frmitm="'.$rand.'">Remove</button></div><div class="clearfix"></div>';
                $html .= '<div class="text_filed_edits_'.$rand.' frmarrs" style="background: #fff; padding:5px; margin-top:5px; display:none" data-elmtype="radio">';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Required</label></div><div class="col-md-9"><input type="checkbox" class="reqs" data-checkdata="'.$rand.'" name="required-'.$rand.'" id="required-'.$rand.'" '.$checked.'></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Label</label></div><div class="col-md-9"><input class="form-control labsset"  type="text" value="'.$label.'" name="lab-'.$rand.'" id="lab-'.$rand.'" data-fldname="'.$rand.'"></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Field Class</label></div><div class="col-md-9"><input class="form-control" type="text" value="'.$fieldclass.'" name="fieldclass-'.$rand.'" id="fieldclass-'.$rand.'"></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Container Class</label></div><div class="col-md-9"><input class="form-control" type="text" value="'.$containerclass.'" name="containerclass-'.$rand.'" id="containerclass-'.$rand.'"></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Name</label></div><div class="col-md-9"><input class="form-control" type="text" value="'.$fieldname.'" name="fieldname-'.$rand.'" id="fieldname-'.$rand.'"></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Inline</label></div><div class="col-md-9"><input type="checkbox" name="inline-'.$rand.'" id="inline-'.$rand.'"> | <small>Display radios inline.</small></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<input type="hidden" name="fieldtype-'.$rand.'" id="fieldtype-'.$rand.'" value="checkbox">';
                $html .= '<div class="clearfix"></div>';
                $html .= '<br><br>';

                $html .= '<div style="padding:5px"><div class="col-md-3"><label>Radio Options</label></div><div class="col-md-9">';



                $html .= '<ul class="list-group sele-opt'.$rand.' sortable">';
                $rads = 0;
                foreach ($anyOptions as $key => $val) {
                    if($rads == 0){
                        $edrads = '';
                    }else{
                        $edrads = '<button class="btn btn-sm btn-danger removeoption" data-optionid="'.$rand.'-'.$rads.'">X</button>';
                    }
                    $html .= '<li class="list-group-item selopts-'.$rand.'-'.$rads.'""><div class="row"><div class="col-md-5"><input class="form-control" type="text" name="option-'.$rand.'-'.$rads.'" id="option-'.$rand.'-'.$rads.'" value="'.$key.'"></div><div class="col-md-5"><input class="form-control" type="text" name="value-'.$rand.'-'.$rads.'" id="value-'.$rand.'-1" value="'.$val.'"></div><div class="col-md-2">'.$edrads.'</div></div><div style="clear: both"></div></li>';
                    $rads++;
                }

$html .='</ul>';

                $html .= '<button style="float: right; margin:20px" class="btn btn-primary addopts" data-optionfld="'.$rand.'">Add Option +</button>';

                $html .='</div></div>';
                $html .= '<hr>';
                $html .= '<div style="padding:5px; text-align: center"><button class="btn btn-success edits-area" data-fieldars="'.$rand.'">Done</button></div>';
                $html .= '<div class="clearfix"></div>';

                $html .= '</div></div>';



            }

            if ($inputType == 'text_area') {
                $label = $newArs[$i]["field"]["lab"];
                $placeHolder = $newArs[$i]["field"]["placeholder"];
                $fieldclass = $newArs[$i]["field"]["fieldclass"];
                $containerclass = $newArs[$i]["field"]["containerclass"];
                $fieldname = $newArs[$i]["field"]["fieldname"];
                $fieldvalue = $newArs[$i]["field"]["fieldvalue"];
                if (isset($newArs[$i]["field"]["required"])) {
                    $required = 'required="required"';
                } else {
                    $required = '';
                }

                if ($placeHolder != null) {
                    $placeHolder = $placeHolder;
                    $checked = 'checked="checked"';
                } else {
                    $placeHolder = '';
                    $checked = '';
                }

                if($required != ''){
                    $isre ='<span class="asrtric" style="color:red"> *</span>';
                }else{
                    $isre = '';
                }



                $rand = rand(5, 500).date('is');
                $html .= '<div style="padding: 10px; background: #efefef; margin: 3px;" class="allcont-'.$rand.' row"><div class="col-md-4"><i class="textars_icon"></i> &nbsp; &nbsp; <span class="fldnames-'.$rand.'">'.$label.'</span>'.$isre.'</div><div style="text-align: right" class="col-md-8"><button class="btn btn-sm btn-secondary edits-area" data-fieldars="'.$rand.'">Edit</button> <button class="btn btn-sm btn-danger theremoves" data-frmitm="'.$rand.'">Remove</button></div><div class="clearfix"></div>';
                $html .= '<div class="text_filed_edits_'.$rand.' frmarrs" style="background: #fff; padding:5px; margin-top:5px; display:none" data-elmtype="text_area">';

                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Required</label></div><div class="col-md-9"><input class="reqs" data-checkdata="'.$rand.'" type="checkbox" name="required-'.$rand.'" id="required-'.$rand.'" '.$checked.'></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Label</label></div><div class="col-md-9"><input class="form-control labsset"  type="text" value="'.$label.'" name="lab-'.$rand.'" id="lab-'.$rand.'" data-fldname="'.$rand.'"></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Placeholder</label></div><div class="col-md-9"><input class="form-control" type="text" value="'.$placeHolder.'" name="placeholder-'.$rand.'" id="placeholder-'.$rand.'"></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Field Class</label></div><div class="col-md-9"><input class="form-control" type="text" value="'.$fieldclass.'" name="fieldclass-'.$rand.'" id="fieldclass-'.$rand.'"></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Container Class</label></div><div class="col-md-9"><input class="form-control" type="text" value="'.$containerclass.'" name="containerclass-'.$rand.'" id="containerclass-'.$rand.'"></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Name</label></div><div class="col-md-9"><input class="form-control" type="text" value="'.$fieldname.'" name="fieldname-'.$rand.'" id="fieldname-'.$rand.'"></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Value</label></div><div class="col-md-9"><input class="form-control" type="text" value="'.$fieldvalue.'" name="fieldvalue-'.$rand.'" id="fieldvalue-'.$rand.'"></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<input type="hidden" name="fieldtype-'.$rand.'" id="fieldtype-'.$rand.'" value="textarea">';

                $html .= '<div class="clearfix"></div>';
                $html .= '<hr>';
                $html .= '<div style="padding:5px; text-align: center"><button class="btn btn-success edits-area" data-fieldars="'.$rand.'">Done</button></div>';
                $html .= '<div class="clearfix"></div>';

                $html .= '</div></div>';
            }

            if ($inputType == 'div') {
                $containerclass = $newArs[$i]["field"]["containerclass"];
                $divcontents = $newArs[$i]["field"]["div"];

                $rand = rand(5, 500).date('is');
                $html .= '<div style="padding: 10px; background: #efefef; margin: 3px;" class="allcont-'.$rand.' row"><div class="col-md-4"><i class="div_icon"></i> &nbsp; &nbsp; <span class="fldnames-'.$rand.'" style="display:none">Div</span></div><div style="text-align: right" class="col-md-8"><button class="btn btn-sm btn-secondary edits-area" data-fieldars="'.$rand.'">Edit</button> <button class="btn btn-sm btn-danger theremoves" data-frmitm="'.$rand.'">Remove</button></div><div class="clearfix"></div>';
                $html .= '<div class="text_filed_edits_'.$rand.' frmarrs" style="background: #fff; padding:5px; margin-top:5px; display:none" data-elmtype="div">';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Contents</label></div><div class="col-md-9"><textarea class="form-control" name="div-'.$rand.'" id="div-'.$rand.'" placeholder="You can put contents here or use this as a clear">'.$divcontents.'</textarea></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Div Class</label></div><div class="col-md-9"><input class="form-control" type="text" value="'.$containerclass.'" name="divclass-'.$rand.'" id="containerclass-'.$rand.'"></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<input type="hidden" name="fieldtype-'.$rand.'" id="fieldtype-'.$rand.'" value="div">';
                $html .= '<div class="clearfix"></div>';
                $html .= '<hr>';
                $html .= '<div style="padding:5px; text-align: center"><button class="btn btn-success edits-area" data-fieldars="'.$rand.'">Done</button></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '</div></div>';

            }

            if ($inputType == 'hidden') {
                $fieldname = $newArs[$i]["field"]["fieldname"];
                $fieldvalue = $newArs[$i]["field"]["fieldvalue"];
                $fieldclass = $newArs[$i]["field"]["fieldclass"];

                $rand = rand(5, 500).date('is');
                $html .= '<div style="padding: 10px; background: #efefef; margin: 3px;" class="allcont-'.$rand.' row"><div class="col-md-4"><i class="hidden_icon"></i> &nbsp; &nbsp; <span class="fldnames-'.$rand.'">Hidden Input</span></div><div style="text-align: right" class="col-md-8"><button class="btn btn-sm btn-secondary edits-area" data-fieldars="'.$rand.'">Edit</button> <button class="btn btn-sm btn-danger theremoves" data-frmitm="'.$rand.'">Remove</button></div><div class="clearfix"></div>';
                $html .= '<div class="text_filed_edits_'.$rand.' frmarrs" style="background: #fff; padding:5px; margin-top:5px; display:none" data-elmtype="hidden">';



                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Name</label></div><div class="col-md-9"><input class="form-control" type="text" value="'.$fieldname.'" name="fieldname-'.$rand.'" id="fieldname-'.$rand.'"></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Value</label></div><div class="col-md-9"><input class="form-control" type="text" value="'.$fieldvalue.'" name="fieldvalue-'.$rand.'" id="fieldvalue-'.$rand.'"></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Field Class</label></div><div class="col-md-9"><input class="form-control" type="text" value="'.$fieldclass.'" name="fieldclass-'.$rand.'" id="fieldclass-'.$rand.'"></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<input type="hidden" name="fieldtype-'.$rand.'" id="fieldtype-'.$rand.'" value="hidden">';

                $html .= '<div class="clearfix"></div>';
                $html .= '<hr>';
                $html .= '<div style="padding:5px; text-align: center"><button class="btn btn-success edits-area" data-fieldars="'.$rand.'">Done</button></div>';
                $html .= '<div class="clearfix"></div>';

                $html .= '</div></div>';

            }

            if ($inputType == 'header') {
                $headertype = $newArs[$i]["field"]["headertype"];
                $containerclass = $newArs[$i]["field"]["containerclass"];
                $lab = $newArs[$i]["field"]["lab"];


                $headTypes = array('h1'=>'H1', 'h2'=>'H2', 'h3'=>'H3', 'h4'=>'H4');

                foreach ($headTypes as $val=>$key){

                    if($headertype == $val){
                        $ops .= '<option value="'.$val.'" selected="selected">'.$key.'</option>';
                    }else{
                        $ops .= '<option value="'.$val.'">'.$key.'</option>';
                    }

                }

                $rand = rand(5, 500).date('is');
                $html .= '<div style="padding: 10px; background: #efefef; margin: 3px;" class="allcont-'.$rand.' row"><div class="col-md-4"><i class="header_icon"></i> &nbsp; &nbsp; <span class="fldnames-'.$rand.'">Header</span></div><div style="text-align: right" class="col-md-8"><button class="btn btn-sm btn-secondary edits-area" data-fieldars="'.$rand.'">Edit</button> <button class="btn btn-sm btn-danger theremoves" data-frmitm="'.$rand.'">Remove</button></div><div class="clearfix"></div>';
                $html .= '<div class="text_filed_edits_'.$rand.' frmarrs" style="background: #fff; padding:5px; margin-top:5px; display:none" data-elmtype="header">';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Label</label></div><div class="col-md-9"><input class="form-control labsset"  type="text" value="'.$lab.'" name="lab-'.$rand.'" id="lab-'.$rand.'" data-fldname="'.$rand.'"></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Header Type</label></div><div class="col-md-9"><select class="form-control" name="headertype-'.$rand.'" id="headertype-'.$rand.'">'.$ops.'</select></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Container Class</label></div><div class="col-md-9"><input class="form-control" type="text" value="'.$containerclass.'" name="containerclass-'.$rand.'" id="containerclass-'.$rand.'"></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<input type="hidden" name="fieldtype-'.$rand.'" id="fieldtype-'.$rand.'" value="header">';
                $html .= '<div class="clearfix"></div>';
                $html .= '<hr>';
                $html .= '<div style="padding:5px; text-align: center"><button class="btn btn-success edits-area" data-fieldars="'.$rand.'">Done</button></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '</div></div>';

            }


            if ($inputType == 'paragraph') {
                $fieldclass = $newArs[$i]["field"]["fieldclass"];
                $containerclass = $newArs[$i]["field"]["containerclass"];
                $para = $newArs[$i]["field"]["para"];

                $rand = rand(5, 500).date('is');
                $html .= '<div style="padding: 10px; background: #efefef; margin: 3px;" class="allcont-'.$rand.' row"><div class="col-md-4"><i class="para_icon"></i> &nbsp; &nbsp; <span class="fldnames-'.$rand.'" style="display:none">Paragraph</span></div><div style="text-align: right" class="col-md-8"><button class="btn btn-sm btn-secondary edits-area" data-fieldars="'.$rand.'">Edit</button> <button class="btn btn-sm btn-danger theremoves" data-frmitm="'.$rand.'">Remove</button></div><div class="clearfix"></div>';
                $html .= '<div class="text_filed_edits_'.$rand.' frmarrs" style="background: #fff; padding:5px; margin-top:5px; display:none" data-elmtype="paragraph">';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Content</label></div><div class="col-md-9"><textarea class="form-control" name="para-'.$rand.'" id="para-'.$rand.'">'.$para.'</textarea></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Paragraph Class</label></div><div class="col-md-9"><input class="form-control" type="text" value="'.$fieldclass.'" name="fieldclass-'.$rand.'" id="fieldclass-'.$rand.'"></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Container Class</label></div><div class="col-md-9"><input class="form-control" type="text" value="'.$containerclass.'" name="containerclass-'.$rand.'" id="containerclass-'.$rand.'"></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<input type="hidden" name="fieldtype-'.$rand.'" id="fieldtype-'.$rand.'" value="paragraph">';
                $html .= '<div class="clearfix"></div>';
                $html .= '<hr>';
                $html .= '<div style="padding:5px; text-align: center"><button class="btn btn-success edits-area" data-fieldars="'.$rand.'">Done</button></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '</div></div>';

            }

            if ($inputType == 'file_upload') {
                $lab = $newArs[$i]["field"]["lab"];
                $fieldclass = $newArs[$i]["field"]["fieldclass"];
                $containerclass = $newArs[$i]["field"]["containerclass"];
                $fieldname = $newArs[$i]["field"]["fieldname"];
                $fielddesti = $newArs[$i]["field"]["fielddesti"];

                if($required != ''){
                    $isre ='<span class="asrtric" style="color:red"> *</span>';
                    $checked = 'checked="checked"';
                }else{
                    $isre = '';
                    $checked = '';
                }

                $rand = rand(5, 500).date('is');
                $html .= '<div style="padding: 10px; background: #efefef; margin: 3px;" class="allcont-'.$rand.' row"><div class="col-md-4"><i class="fileups_icon"></i>&nbsp; &nbsp; <span class="fldnames-'.$rand.'">'.$lab.'</span>'.$isre.'</div><div style="text-align: right" class="col-md-8"><button class="btn btn-sm btn-secondary edits-area" data-fieldars="'.$rand.'">Edit</button> <button class="btn btn-sm btn-danger theremoves" data-frmitm="'.$rand.'">Remove</button></div><div class="clearfix"></div>';
                $html .= '<div class="text_filed_edits_'.$rand.' frmarrs" style="background: #fff; padding:5px; margin-top:5px; display:none" data-elmtype="file_upload">';

                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Required</label></div><div class="col-md-9"><input type="checkbox" class="reqs" data-checkdata="'.$rand.'" name="required-'.$rand.'" id="required-'.$rand.'" '.$checked.'></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Label</label></div><div class="col-md-9"><input class="form-control labsset"  type="text" value="'.$lab.'" name="lab-'.$rand.'" id="lab-'.$rand.'" data-fldname="'.$rand.'"></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Placeholder</label></div><div class="col-md-9"><input class="form-control" type="text" value="" name="placeholder-'.$rand.'" id="placeholder-'.$rand.'"></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Field Class</label></div><div class="col-md-9"><input class="form-control" type="text" value="'.$fieldclass.'" name="fieldclass-'.$rand.'" id="fieldclass-'.$rand.'"></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Container Class</label></div><div class="col-md-9"><input class="form-control" type="text" value="'.$containerclass.'" name="containerclass-'.$rand.'" id="containerclass-'.$rand.'"></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Name</label></div><div class="col-md-9"><input class="form-control" type="text" value="'.$fieldname.'" name="fieldname-'.$rand.'" id="fieldname-'.$rand.'"></div></div>';
                $html .= '<div class="clearfix"></div>';

                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Destination Folder</label></div><div class="col-md-9"><div class="input-group mb-3">
                        <input type="text" class="form-control" name="fielddesti-'.$rand.'" id="fielddesti-'.$rand.'" placeholder="img/foldername/" value="'.$fielddesti.'" aria-label="Category Image" value="">
                        <div class="input-group-append">
                            <button class="btn btn-success img-browser" data-setter="fielddesti-'.$rand.'" type="button">Select Directory</button>
                        </div>
                    </div></div>
</div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<input type="hidden" name="fieldtype-'.$rand.'" id="fieldtype-'.$rand.'" value="fileupload">';

                $html .= '<div class="clearfix"></div>';
                $html .= '<hr>';
                $html .= '<div style="padding:5px; text-align: center"><button class="btn btn-success edits-area" data-fieldars="'.$rand.'">Done</button></div>';
                $html .= '<div class="clearfix"></div>';

                $html .= '</div></div>';
            }

            if ($inputType == 'button') {
                $buttonclass = $newArs[$i]["field"]["buttonclass"];
                $containerclass = $newArs[$i]["field"]["containerclass"];
                $buttonattr = $newArs[$i]["field"]["buttonattr"];
                $lab = $newArs[$i]["field"]["lab"];

                $rand = rand(5, 500).date('is');
                $html .= '<div style="padding: 10px; background: #efefef; margin: 3px;" class="allcont-'.$rand.' row"><div class="col-md-4"><i class="button_icon"></i> &nbsp; &nbsp; <span class="fldnames-'.$rand.'">'.$lab.'</span></div><div style="text-align: right" class="col-md-8"><button class="btn btn-sm btn-secondary edits-area" data-fieldars="'.$rand.'">Edit</button> <button class="btn btn-sm btn-danger theremoves" data-frmitm="'.$rand.'">Remove</button></div><div class="clearfix"></div>';
                $html .= '<div class="text_filed_edits_'.$rand.' frmarrs" style="background: #fff; padding:5px; margin-top:5px; display:none" data-elmtype="button">';
                $html .= '<small style="display: block; padding: 5px; color: red">NOTICE! To use in system conversion tracking via "Data Attributes Class" field below, copy and paste the following: <span style="display: inline-block; padding: 3px; background: #efefef; color:#333">data-cafftrak=\'Your Value\'</span> Do not use double quotes to wrap value. Only excepts single quotes.</small>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Label</label></div><div class="col-md-9"><input class="form-control labsset"  type="text" value="'.$lab.'" name="lab-'.$rand.'" id="lab-'.$rand.'" data-fldname="'.$rand.'"></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Button Class</label></div><div class="col-md-9"><input class="form-control" type="text" value="'.$buttonclass.'" name="buttonclass-'.$rand.'" id="buttonclass-'.$rand.'"></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Data Attributes Class</label></div><div class="col-md-9"><input class="form-control" type="text" value="'.$buttonattr.'" name="buttonattr-'.$rand.'" id="buttonattr-'.$rand.'"></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Container Class</label></div><div class="col-md-9"><input class="form-control" type="text" value="'.$containerclass.'" name="containerclass-'.$rand.'" id="containerclass-'.$rand.'"></div></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '<input type="hidden" name="fieldtype-'.$rand.'" id="fieldtype-'.$rand.'" value="button">';
                $html .= '<div class="clearfix"></div>';
                $html .= '<hr>';
                $html .= '<div style="padding:5px; text-align: center"><button class="btn btn-success edits-area" data-fieldars="'.$rand.'">Done</button></div>';
                $html .= '<div class="clearfix"></div>';
                $html .= '</div></div>';

            }
        }

        return $html;
    }

    function getSystemLinks(){
        include('harness.php');
        $a = $data->query("SELECT * FROM pages WHERE active = 'true' ORDER BY page_name ASC");
        $html .= '<table class="table" style="width: 100%"><thead><tr><th>Page Name</th> <th>Action</th></tr></thead>';
        while($b=$a->fetch_array()){
            $html .= '<tr><td>'.$b["page_name"].'</td><td><button class="btn btn-fill btn-success" onclick="setsimple(\''.$b["page_name"].'\',\'nav-link\')">Add Link</button></td></tr>';
        }
        $html .= '</table>';

        echo $html;
    }

    function getForms(){
        include('harness.php');
        $a = $data->query("SELECT * FROM forms_data WHERE active = 'true'");
        while($b = $a->fetch_assoc()){
            $form = $b["form_name"];
            $c = $data->query("SELECT * FROM $form WHERE active = 'true'");
            $ct = $c->num_rows;
            $e = $data->query("SELECT * FROM $form WHERE active = 'true' AND status = 'new'");
            $ctf = $e->num_rows;
            $b["messageCount"] = $ct;
            $b["messUnread"] = $ctf;
            $ars[] = $b;
        }
        return $ars;
    }

    function getSingleForm($form){
        include('harness.php');
        $a = $data->query("SELECT * FROM forms_data WHERE form_name = '$form'");
        $b = $a->fetch_array();
        return $b;
    }

    function getFromSetting($form){
        include('harness.php');
        $a = $data->query("SELECT * FROM forms_data WHERE form_name = '$form'");
        $b = $a->fetch_assoc();
        return $b["settings"];
    }

    function doformsets($post){
        include('harness.php');
        $headersout = json_encode($post["headerssets"]);
        $data->query("UPDATE forms_data SET settings = '$headersout' WHERE form_name = '".$post["theform"]."'");
    }


    function getFormHeaders($id){
        include('harness.php');
        $a = $data->query("SELECT * FROM $id WHERE active = 'true'");
        if($a->num_rows > 0) {
            $row = $a->fetch_assoc();
            foreach ($row as $key => $value) {
                $formArs[] = array('column' => $key);
            }
        }else{
            $formArs = array();
        }

        return $formArs;

    }

    function getProceeHeaders($id){
        include('harness.php');
        $a = $data->query("SELECT * FROM forms_data WHERE form_name = '$id'");
        $b = $a->fetch_array();

        $headers = json_decode($b["settings"],true);

        $formArs[] = array('column' => 'receive_date');
        $formArs[] = array('column' => 'id');
        foreach($headers as $keys){
            $formArs[] = array('column' => $keys);
        }

        $formArs[] = array('column' => 'status');

        return $formArs;
    }

    function getFormsData($id,$sel){
        include('harness.php');
        $a = $data->query("SELECT $sel FROM $id WHERE active = 'true' ORDER BY receive_date DESC");
        while($b = $a->fetch_assoc()){
            $formData[] = $b;
        }

        return $formData;
    }

    function getFormsDataDate($id,$sel,$start,$end){
        include('harness.php');
        $a = $data->query("SELECT $sel FROM $id WHERE receive_date BETWEEN $start AND $end AND active = 'true' ORDER BY receive_date DESC") or die($data->error);
        while($b = $a->fetch_assoc()){
            $formData[] = $b;
        }

        return $formData;
    }

    function getFormMessage($formid,$form){
        include('harness.php');
        $a = $data->query("SELECT * FROM $form WHERE id = '$formid'");
        $b = $a->fetch_assoc();
        $data->query("UPDATE $form SET status = 'read' WHERE id = '$formid'");
        return $b;
    }

    function delMess($formid,$form){
        include('harness.php');
        $data->query("UPDATE $form SET active = 'false' WHERE id = '$formid'");
    }

    function updateForm($post){
        include('harness.php');

        $a = $data->query("SELECT * FROM forms_data WHERE form_name = '".$post["form_name"]."'");
        $b = $a->fetch_array();

        if($b["form_data"] == $post["form_json"]){

            $data->query("UPDATE forms_data SET post_link = '".$post["post_link"]."', subject = '".$post["subject"]."', form_class = '".$post["form_class"]."', is_multi = '".$post["multi"]."', crmpush = '".$post["crmset"]."', success_mess = '".$data->real_escape_string($post["success_mess"])."', reply_message = '".$post["reply_mess"]."', reply_active = '".$data->real_escape_string($post["replyset"])."', recipients = '".$post["recipients"]."' $formEdits WHERE form_name = '".$post["form_name"]."'")or die($data->error.' - Cannot update forms data');
            return 'success';
        }else{
            /////BEGIN FORM BUILDER PROCESS///

            $output = "";
            $formName = $post["form_name"];

                $sql = $data->query("SELECT * FROM $formName WHERE active = 'true' ");

                if($sql->num_rows > 0) {
                    $columns_total = $sql->field_count;

                    for ($i = 0; $i < $columns_total; $i++) {
                        $finfo = $sql->fetch_field_direct($i);
                        $heading = $finfo->name;
                        $output .= '"' . $heading . '",';
                    }
                    $output .= "\n";

                    while ($row = $sql->fetch_array()) {
                        for ($i = 0; $i < $columns_total; $i++) {
                            $output .= '"' . $row["$i"] . '",';
                        }
                        $output .= "\n";
                    }

                    $dirCheck = '../form_backups/' . $post["form_name"];

                    if (file_exists($dirCheck)) {
                        $filename = "$dirCheck/" . $post["form_name"] . '_' . date('mdyhia') . ".csv";
                        file_put_contents($filename, $output);


                    } else {
                        $filename = "$dirCheck/" . $post["form_name"] . '_' . date('mdyhia') . ".csv";
                        mkdir($dirCheck, 0777, true);
                        file_put_contents($filename, $output);
                    }
                }else{
                    $this->createForm($post);
                }



            //var_dump($post);

            include('formBuild.php');
            $bld = new buildForm();
            $formBuild = $bld->build($post["form_json"],$formName);

            $data->query("UPDATE forms_data SET form_data = '".$data->real_escape_string($post["form_json"])."', form_elems = '".$data->real_escape_string($formBuild)."', settings = '' WHERE form_name = '$formName'")or die('Cant Remove forms data');
            return 'success';

        }

    }

    function getFormDataOut($form,$start,$end){
        $headerInfo = $this->getFormHeaders($form);
        $headerInfoprocess = $this->getFormHeaders($form);
        $settings = $this->getFromSetting($form);

        if(!empty($headerInfo)) {

            for ($i = 0; $i <= count($headerInfoprocess); $i++) {
                if ($headerInfoprocess[$i]["column"] != null && $headerInfoprocess[$i]["column"] != 'active') {
                    $headerTab = ucwords(str_replace('_', ' ', $headerInfoprocess[$i]["column"]));
                    $tabs .= '<th style="background:#efefef; border-left:solid thin #ffffff">' . $headerTab . '</th>';
                    $columns .= $headerInfoprocess[$i]["column"] . ', ';
                }
            }

            $columnOut = rtrim($columns, ', ');

            $getList = $this->getFormsDataDate($form,$columnOut,$start,$end);


            for ($j = 0; $j < count($getList); $j++) {
                $ex = explode(', ', $columnOut);
                if ($getList[$j]["status"] == 'new') {
                    $back = 'style="background:#bcf3bc; border-bottom:solid thin #dff7df"';
                } else {
                    $back = '';
                }
                $results .= '<tr ' . $back . ' class="mess-'.$getList[$j]["id"].'">';
                foreach ($ex as $keys) {
                    if ($keys == 'receive_date') {
                        $outty = date('m/d/Y h:ia', $getList[$j][$keys]);
                    } else {
                        $outty = $getList[$j][$keys];
                    }

                    if (strlen($outty) > 40) {
                        $outty = substr($outty, 0, 40) . '...';
                    }

                    $results .= '<td style="border-bottom:solid thin #333">' . $outty . '</td>';
                    $ctArs[] = '';
                }

                //$results .= '<td style="text-align: right"><button class="btn btn-sm btn-success btn-xs readmess" data-messid="' . $getList[$j]["id"] . '" data-form="' . $_REQUEST["form"] . '"><i class="fa fa-search" aria-hidden="true"></i> Read</button> <button class="btn btn-sm btn-danger btn-xs delmess" data-messid="' . $getList[$j]["id"] . '" data-form="' . $_REQUEST["form"] . '"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button></td>';

                $results .= '</tr>';
            }
            $empty = 'false';
        }else{
            $empty = 'true';
        }

        if($empty != 'true') {
            $html .= '<table style="font-family:Arial, Helvetica, sans-serif; font-size: 10px" width="100%" border="0" cellspacing="0" cellpadding="10" class="tableforms table-striped">
                                   <thead>

                                    <tr>' . $tabs . ' </tr></thead>
                                   <tbody>

                                   ' . $results . '

                                   </tbody>
                               </table>';
            $html .= '<div style="text-align: right; color:#333; font-family:Arial, Helvetica, sans-serif; padding: 10px; background: #efefef"><span style="font-size:10px; font-style: italic"><strong>Date Range:</strong> '.date('m/d/Y h:ia',$start).' - '.date('m/d/Y h:ia',$end).'</span><br><span style="font-size:15px;">'.count($getList).' Messages Received </span></div>';
        }else{
            $html = '<div style="padding: 20px;font-style: italic;">No messages have been received.</div>';
        }
        return $html;
    }

    function getFormDataCsv($formName,$start,$end){
        include('harness.php');

       // echo $start. ' ' .$end;
        $sql = $data->query("SELECT * FROM $formName WHERE receive_date BETWEEN $start AND $end AND active = 'true'")or die($data->error);

        if($sql->num_rows > 0) {
            $columns_total = $sql->field_count;

            for ($i = 0; $i < $columns_total; $i++) {
                $finfo = $sql->fetch_field_direct($i);
                $heading = $finfo->name;
                $outputHeader[] = $heading;
            }


            while ($row = $sql->fetch_array()) {

                $colm = array();

                for ($i = 0; $i < $columns_total; $i++) {
                    $finfo = $sql->fetch_field_direct($i);
                    $heading = $finfo->name;
                    if($heading == 'receive_date'){
                        $colm[] = date('m/d.Y h:ia',$row["$i"]);
                    }else{
                        $colm[] = $row["$i"];
                    }

                }

                $outputContent[] = $colm;
                $colm = '';

            }

            $output = $outputContent;

            $sendArs = array('headers'=>$outputHeader, 'datasets'=>$output);

           return $sendArs;
        }
    }

    function getArchive($formname){
        $dir    = '../form_backups/'.$formname;
        $files1 = scandir($dir);

        return $files1;
    }

    function getUnreadsDash()
    {
        include('harness.php');
        $countOut = 0;
        $a = $data->query("SELECT * FROM forms_data WHERE active = 'true'");
        while ($b = $a->fetch_array()) {
            $formName = $b['form_name'];
            $c = $data->query("SELECT * FROM $formName WHERE status != 'read'");
            $countOut += $c->num_rows;
        }

        return $countOut;

    }

    function deleteForm($id){
        include('harness.php');
        $a = $data->query("SELECT * FROM forms_data WHERE id = '$id'");
        $b = $a->fetch_array();

        $formName = $b["form_name"];
        $data->query("DROP TABLE $formName;");
        $data->query("DELETE FROM forms_data WHERE id = '$id'");

    }

    function stateArs(){
        $states = array(
            'Alabama'=>'AL',
            'Alaska'=>'AK',
            'Arizona'=>'AZ',
            'Arkansas'=>'AR',
            'California'=>'CA',
            'Colorado'=>'CO',
            'Connecticut'=>'CT',
            'Delaware'=>'DE',
            'Florida'=>'FL',
            'Georgia'=>'GA',
            'Hawaii'=>'HI',
            'Idaho'=>'ID',
            'Illinois'=>'IL',
            'Indiana'=>'IN',
            'Iowa'=>'IA',
            'Kansas'=>'KS',
            'Kentucky'=>'KY',
            'Louisiana'=>'LA',
            'Maine'=>'ME',
            'Maryland'=>'MD',
            'Massachusetts'=>'MA',
            'Michigan'=>'MI',
            'Minnesota'=>'MN',
            'Mississippi'=>'MS',
            'Missouri'=>'MO',
            'Montana'=>'MT',
            'Nebraska'=>'NE',
            'Nevada'=>'NV',
            'New Hampshire'=>'NH',
            'New Jersey'=>'NJ',
            'New Mexico'=>'NM',
            'New York'=>'NY',
            'North Carolina'=>'NC',
            'North Dakota'=>'ND',
            'Ohio'=>'OH',
            'Oklahoma'=>'OK',
            'Oregon'=>'OR',
            'Pennsylvania'=>'PA',
            'Rhode Island'=>'RI',
            'South Carolina'=>'SC',
            'South Dakota'=>'SD',
            'Tennessee'=>'TN',
            'Texas'=>'TX',
            'Utah'=>'UT',
            'Vermont'=>'VT',
            'Virginia'=>'VA',
            'Washington'=>'WA',
            'West Virginia'=>'WV',
            'Wisconsin'=>'WI',
            'Wyoming'=>'WY'
        );

        return $states;
    }

    function createLocation($post,$phoneJson,$emailJson,$dayJson,$map){
        include('harness.php');
        if(isset($post["newrecord"])){

            $a = $data->query("SELECT googlekey FROM location_api_details WHERE id = '1'");
            $b = $a->fetch_array();

            $gapikey = $b["googlekey"];

            if($gapikey != '' && $post["location-address"] != '' && $post["location-city"] != '' && $post["location-state"] != '' && $post["location-zip"] != ''){

                $addressFull = $post["location-address"].' '.$post["location-city"].', '.$post["location-state"].' '.$post["location-zip"];
                $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($addressFull)."&sensor=false&key=$gapikey";
                $result_string = file_get_contents($url);
                $result = json_decode($result_string, true);
                if(!empty($result['results'])){
                    $loc['lat'] = $result['results'][0]['geometry']['location']['lat'];
                    $loc['lgn'] = $result['results'][0]['geometry']['location']['lng'];
                }

                $cords = ", latitude = '".$loc['lat']."', longitude = '".$loc['lgn']."'";
            }else{
                $cords = '';
            }

            $data->query("UPDATE location SET location_name = '".$data->real_escape_string($post["location-name"])."', location_address = '".$data->real_escape_string($post["location-address"])."', location_city = '".$data->real_escape_string($post["location-city"])."', location_state = '".$data->real_escape_string($post["location-state"])."', location_zip = '".$data->real_escape_string($post["location-zip"])."', location_img = '".$data->real_escape_string($post["loc-img"])."', location_link = '".$data->real_escape_string($post["nav-link"])."', location_phones = '".$data->real_escape_string($phoneJson)."', location_emails = '".$data->real_escape_string($emailJson)."', location_hours = '".$data->real_escape_string($dayJson)."', location_map = '".$data->real_escape_string($map)."', form_code = '".$data->real_escape_string($post["form-code"])."' $cords   WHERE id = '".$post["newrecord"]."'")or die($data->error);
            $iserid = $data->insert_id;
            return $post["newrecord"];
        }else{
            $a = $data->query("SELECT googlekey FROM location_api_details WHERE id = '1'");
            $b = $a->fetch_array();

            $gapikey = $b["googlekey"];
            if($gapikey != '' && $post["location-address"] != '' && $post["location-city"] != '' && $post["location-state"] != '' && $post["location-zip"] != ''){

                $addressFull = $post["location-address"].' '.$post["location-city"].', '.$post["location-state"].' '.$post["location-zip"];
                $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($addressFull)."&sensor=false&key=$gapikey";
                $result_string = file_get_contents($url);
                $result = json_decode($result_string, true);
                if(!empty($result['results'])){
                    $loc['lat'] = $result['results'][0]['geometry']['location']['lat'];
                    $loc['lgn'] = $result['results'][0]['geometry']['location']['lng'];
                }

                $cords = ", latitude = '".$loc['lat']."', longitude = '".$loc['lgn']."'";
            }else{
                $cords = '';
            }
            $data->query("INSERT INTO location SET location_name = '".$data->real_escape_string($post["location-name"])."', location_address = '".$data->real_escape_string($post["location-address"])."', location_city = '".$data->real_escape_string($post["location-city"])."', location_state = '".$data->real_escape_string($post["location-state"])."', location_zip = '".$data->real_escape_string($post["location-zip"])."', location_img = '".$data->real_escape_string($post["loc-img"])."', location_link = '".$data->real_escape_string($post["nav-link"])."', location_phones = '".$data->real_escape_string($phoneJson)."', location_emails = '".$data->real_escape_string($emailJson)."', location_hours = '".$data->real_escape_string($dayJson)."', location_map = '".$data->real_escape_string($map)."', form_code = '".$data->real_escape_string($post["form-code"])."' $cords")or die($data->error);
            $iserid = $data->insert_id;
            return $iserid;
        }

    }

    function getLocation($id){
        include('harness.php');
        $a = $data->query("SELECT * FROM location WHERE id = '$id'");
        $b = $a->fetch_array();
        return $b;
    }

    function getLocations(){
        include('harness.php');
        $a = $data->query("SELECT * FROM location WHERE active = 'true'");
        while($b = $a->fetch_assoc()){
            $locs[] = $b;
        }

        return $locs;
    }

    function deleteLocation($locid){
        include('harness.php');
        $data->query("DELETE FROM location WHERE id = '$locid'");
    }

    function getgapikey(){
        include('harness.php');
        $a = $data->query("SELECT * FROM location_api_details WHERE id = '1'");
        $b = $a->fetch_array();

        return $b["googlekey"];
    }

    function updategapikey($post){
        include('harness.php');
        $keyData = $post["googlekey"];
        $data->query("UPDATE location_api_details SET googlekey = '$keyData' WHERE id = '1'");
    }

    function getReviews(){
        include('harness.php');
        $a = $data->query("SELECT * FROM reveiws WHERE active = 'true'");
        while($b = $a->fetch_assoc()){
            $reviews[] = $b;
        }

        return $reviews;
    }

    function readMess($id){
        include('harness.php');
        $a = $data->query("SELECT * FROM reveiws WHERE id = '$id'");
        $b = $a->fetch_array();
        return $b;
    }

    function delRevs($id){
        include('harness.php');
        $data->query("DELETE FROM reveiws WHERE id = '$id'");
    }

    function apprvRevs($id){
        include('harness.php');
        $data->query("UPDATE reveiws SET approved = 'true' WHERE id = '$id'");
    }

    function getOrders(){
        include('harness.php');
        $a = $data->query("SELECT * FROM shop_orders WHERE status != 'deleted'");
        while($b = $a->fetch_array()){
            $shopArs[] = $b;
        }

        return $shopArs;
    }

    function readOrder($id){
        include('harness.php');
        $a = $data->query("SELECT * FROM shop_orders WHERE id = '$id'");
        $b = $a->fetch_array();
        return $b;
    }

    function delOrds($id){
        include('harness.php');
        $data->query("DELETE FROM shop_orders WHERE id = '$id'");
    }

    function updatePros($id){
        include('harness.php');
        $data->query("UPDATE shop_orders SET status = 'Processed' WHERE id = '$id'");
    }

    function getUnProcessedOrders(){
        include('harness.php');
        $a = $data->query("SELECT * FROM shop_orders WHERE status = 'New'");
        return $a->num_rows;
    }



    function forceCheckIn($pageid){
        include('harness.php');
        $data->query("UPDATE pages SET check_out = '', check_out_date = '' WHERE id = '$pageid'");
    }

    function forceCheckInContent($conid){
        include('harness.php');
        $data->query("UPDATE beans SET checkout = '', checkout_date = '' WHERE id = '$conid'");
    }

    function getSmtpDets(){
        include('harness.php');
        $a = $data->query("SELECT * FROM mail_settings WHERE id = '1'");
        $b = $a->fetch_array();
        return $b;
    }

    function saveSmtpDets($post){
        include('harness.php');

        var_dump($post);
        $postmrktkn = $post["postmrktkn"];
        $frm_emladd = $post["frm_emladd"];

        $a = $data->query("SELECT * FROM mail_settings WHERE id = '1'");
        $b = $a->fetch_array();

        $crmSets = $b["crm_settings"];

        $handleBase = $post["handle_base"];
        $handleUser = $post["handle_user"];
        $handlePass = $post["handle_pass"];



        if($crmSets == ''){
            //CREATE IT//
            if($handleBase != '' && $handleUser != '' && $handlePass != ''){
                $sets = array('baseUrl'=>$handleBase,'user'=>$handleUser,'pass'=>$handlePass);
                $settingsArs = array('crm_type'=>'handle','apisets'=>$sets);
                $settingsArs = json_encode($settingsArs);
                $data->query("UPDATE mail_settings SET crm_settings = '".$data->real_escape_string($settingsArs)."' WHERE id = '1'");
            }

        }else{
            if($handleBase != '' && $handleUser != '' && $handlePass != ''){
                $sets = array('baseUrl'=>$handleBase,'user'=>$handleUser,'pass'=>$handlePass);
                $settingsArs = array('crm_type'=>'handle','apisets'=>$sets);
                $settingsArs = json_encode($settingsArs);
                $data->query("UPDATE mail_settings SET crm_settings = '".$data->real_escape_string($settingsArs)."' WHERE id = '1'");
            }else{
                $sets = array('baseUrl'=>'','user'=>'','pass'=>'');
                $settingsArs = array('crm_type'=>'handle','apisets'=>$sets);
                $settingsArs = json_encode($settingsArs);
                $data->query("UPDATE mail_settings SET crm_settings = '".$data->real_escape_string($settingsArs)."' WHERE id = '1'");
            }
        }

        $data->query("UPDATE mail_settings SET postmrk_ids = '$postmrktkn', frm_email = '$frm_emladd' WHERE id = '1'")or die($data->error);

        return 'success';
    }

    function getMailSettings(){
        include('harness.php');
        $a = $data->query("SELECT * FROM mail_settings WHERE id = '1'");
        $b = $a->fetch_assoc();

        return $b;
    }

    function testCRM($post){
        //var_dump($post);

        include('../../inc/handle_processor.php');

        $username = $post["handle_user"];
        $password = $post["handle_pass"];
        $baseUri = $post["baseLink"];
        $service = new Handle($baseUri);

        $response = $service->Login($username, $password);

        $phone = '555-555-5555';

        $phoneMob = '';

        $properties = array(
            "Title" => "Form Submission",
            "Description" => 'Credentials Test',
            "FirstName" => 'Test',
            "LastName" => 'Me',
            "Email" => 'test.me@email.com',
            "Phone" => $phone,
            "Mobile" => $phoneMob,
            "SalesStage" => 'Contact'
        );
        $response2 = $service->CreateEntity("Lead", "", $properties);

        $crmRes = $response2['body'];

        return $crmRes;

    }
    
    function JasonFunction(){
        ///This is my new function.
    }

    //COMPRESS JS AND CSS FILES//

    function compressFiles($type){

        echo "this is ".$type;
        // make sure to update the path to where you cloned the projects to!
        require_once '../minify/src/Minify.php';
        require_once '../minify/src/CSS.php';
        require_once '../minify/src/JS.php';
        require_once '../minify/src/Exception.php';
        require_once '../minify/src/Exceptions/BasicException.php';
        require_once '../minify/src/Exceptions/FileImportException.php';
        require_once '../minify/src/Exceptions/IOException.php';
        require_once '../path-converter/src/ConverterInterface.php';
        require_once '../path-converter/src/Converter.php';

        if($type == 'js'){
            echo "this is ".$type;
            $minifier = new Minify\JS('../assets/readables/site.js');
            $minifier->minify('../../js/site.js');
        }

        if($type == 'css'){
            $minifier = new Minify\CSS('../assets/readables/styles.css');
            $minifier->minify('../../css/styles.css');
        }



    }

    function savePermissions($post){
        include('harness.php');
        $auth = $this->auth();
        $name = $post["per-name"];
        $per = json_encode($post["permiss"]);

        $a = $data->query("SELECT name FROM permissions WHERE name = '$name'");
        if($a->num_rows >0){
            $mess = array('result'=>'0','result_message'=>'Cannot create duplicate permission group.');
        }else{
            $data->query("INSERT INTO permissions SET name = '".$data->real_escape_string($name)."', permissions = '$per', created_by = '".$auth["profileId"]."', created = '".time()."'");
            $mess = array('result'=>'1','result_message'=>'Permission group created successfully.');
        }

        return $mess;
    }

    function getPermissions(){
        include('harness.php');
        $a = $data->query("SELECT * FROM permissions WHERE active = 'true'");
        while($b = $a->fetch_assoc()){
            $permis[] = $b;
        }

        return $permis;
    }

    function getSinglePermission($id){
        include('harness.php');
        $a = $data->query("SELECT * FROM permissions WHERE id = '$id'");
        $b = $a->fetch_array();

        return $b;
    }

    function updatePermissions($post){
        include('harness.php');
        $auth = $this->auth();
        $name = $post["per-name-edit"];
        $per = json_encode($post["permiss"]);
        $data->query("UPDATE permissions SET name = '".$data->real_escape_string($name)."', permissions = '$per' WHERE id = '".$post["permisid"]."'");
        $mess = array('result'=>'1','result_message'=>'Permission group updated successfully.');
        return $mess;
    }

    function getSystMesss(){
        include('harness.php');
        ///$a = $data->query("SELECT * FROM insys_chat WHERE NOT (id = '' AND response = 'true') ORDER BY created ASC LIMIT 10")or die($data->error);
        $a = $data->query("SELECT * FROM insys_chat WHERE response IS NULL ORDER BY created DESC LIMIT 10")or die($data->error);
       // echo $a->num_rows;
        while($b = $a->fetch_assoc()){
            $ars[] = $b;
        }

        return $ars;
    }

    function getSystMesssAll(){
        include('harness.php');
        ///$a = $data->query("SELECT * FROM insys_chat WHERE NOT (id = '' AND response = 'true') ORDER BY created ASC LIMIT 10")or die($data->error);
        $a = $data->query("SELECT * FROM insys_chat WHERE response IS NULL ORDER BY created DESC ")or die($data->error);
        // echo $a->num_rows;
        while($b = $a->fetch_assoc()){
            $ars[] = $b;
        }

        return $ars;
    }

    function checkSubs($messid){
        include('harness.php');
        $userId = $this->auth();
        $userId = $userId["profileId"];
        $c = $data->query("SELECT * FROM insys_chat WHERE id = '$messid'");
        while($d = $c->fetch_array()){
            $jsonids = json_decode($d["read_ids"],true);
            if(in_array($userId,$jsonids)){
                $results[] = 'true';
            }else{
                $results[] = 'false';
            }
        }


        if(in_array('false',$results)){
            return 'false';
        }else{
            return 'true';
        }
    }

    function getUnreadCount(){
        include('harness.php');
        $userId = $this->auth();
        $userId = $userId["profileId"];
        $c = $data->query("SELECT * FROM insys_chat WHERE title != 'REPLY'");
        while($d = $c->fetch_array()){
            $jsonids = json_decode($d["read_ids"],true);
            if(in_array($userId,$jsonids)){
                //$results[] = 'true';
            }else{
                $messCount[] = 'false';
            }
        }

        return count($messCount);
    }

    function storeInsysMess($post){
        include('harness.php');
        $title = $post["insys_title"];
        $messys = $post["messys"];
        $priority = $post["priority"];

        $userId = $this->auth();
        $userId = $userId["profileId"];

        if(isset($post["currmess"]) && $post["currmess"] != ''){
            if(isset($post["mess_resolve"])){
                $data->query("UPDATE insys_chat SET completed = 'true' WHERE id = '".$post["currmess"]."'")or die($data->error);
                if($messys != '') {
                    $data->query("INSERT INTO insys_chat SET title = 'REPLY', user = '$userId', message = '" . $data->real_escape_string($messys) . "', priority = '$priority', created = '" . time() . "', response = 'true', messid = '" . $post["currmess"] . "'") or die($data->error);
                }
            }else{
                $data->query("INSERT INTO insys_chat SET title = 'REPLY', user = '$userId', message = '".$data->real_escape_string($messys)."', priority = '$priority', created = '".time()."', response = 'true', messid = '".$post["currmess"]."'")or die($data->error);
                $data->query("UPDATE insys_chat SET read_ids = '', completed = '' WHERE id = '".$post["currmess"]."'")or die($data->error);
            }

        }else{
            $data->query("INSERT INTO insys_chat SET title = '".$data->real_escape_string($title)."', user = '$userId', message = '".$data->real_escape_string($messys)."', priority = '$priority', created = '".time()."'")or die($data->error);
        }


    }
    function joycebreaksthis() {
        echo 'muwahahahahahahahahahaha';
    }

    function getSingelMess($id){
        include('harness.php');
        $userId = $this->auth();
        $userId = $userId["profileId"];
        $a = $data->query("SELECT * FROM insys_chat WHERE id = '$id'");
        $b = $a->fetch_array();

        if($b["message"] != '') {
            $ars[] = array("title" => $b["title"], "message" => $b["message"], "priority" => $b["priority"], "user" => $b["user"], "created" => $b["created"], "completed" => $b["completed"], "messid" => $id);
        }

        ///MARK IT AS READ//
        $readIDs = json_decode($b["read_ids"],true);
        $ids = array();
        foreach($readIDs as $redid){
            $ids[] = $redid;
        }

        $ids[] = $userId;

        $readIdsSet = json_encode($ids);

        $data->query("UPDATE insys_chat SET read_ids = '".$readIdsSet."' WHERE id = '$id' OR messid = '$id'");

        $c = $data->query("SELECT * FROM insys_chat WHERE messid = '$id'");
        while($d = $c->fetch_array()){
            if($d["message"] != '') {
                $arsz[] = array("title" => $d["title"], "message" => $d["message"], "priority" => $d["priority"], "user" => $d["user"], "created" => $d["created"]);
            }
        }

        return array("main_message"=>$ars,"replies"=>$arsz);

    }

    function setErrorStatus($stat){
        include('harness.php');
        $userId = $this->auth();
        $data->query("UPDATE site_settings SET error_reporting = '$stat' WHERE id = '1'");
    }

    function checkerrorstat(){
        include('harness.php');
        $a = $data->query("SELECT error_reporting FROM site_settings WHERE id = '1'");
        $b = $a->fetch_array();

        if($b["error_reporting"] == 'yes'){
            return 'true';
        }else{
            return 'false';
        }
    }

} 