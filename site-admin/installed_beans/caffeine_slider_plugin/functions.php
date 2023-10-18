<?php
class caffeineSlide{

    function getSlideList(){
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }

        $a = $data->query("SELECT * FROM caffeine_sliders WHERE active = 'true'")or die($data->error);
        while($b = $a->fetch_assoc()){
            $ars[] = $b;
        }

        return $ars;
    }

    function getCountSlides($id){
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }

        $a = $data->query("SELECT * FROM caffeine_slides WHERE slide_blong = '$id'");
        $b = $a->num_rows;

        return $b;
    }

    function createnew($post){
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }

        $slidename = $post["slide_name"];
        $speedslide = $post["speedslide"];
        $slideSets = $post["slides"];
        $numbslide = $post["numbslide"];

        if(in_array('multi_slide',$slideSets)){$multi_slide = 'true'; $numbslide = $numbslide;}else{$multi_slide = 'false'; $numbslide = '0';}
        if(in_array('navi_slide',$slideSets)){$navi_slide = 'true'; }else{$navi_slide = 'false';}
        if(in_array('arrows_slide',$slideSets)){$arrow_slide = 'true'; }else{$arrow_slide = 'false';}
        if(in_array('fade_slide',$slideSets)){$fade_slide = 'true'; }else{$fade_slide = 'false';}
        if(in_array('auto_slide',$slideSets)){$auto_slide = 'true'; }else{$auto_slide = 'false';}
        if(in_array('lazy',$slideSets)){$lazy = 'true'; }else{$lazy = 'false';}
        if(in_array('infinite',$slideSets)){$infinite = 'true'; }else{$infinite = 'false';}


        $a = $data->query("INSERT INTO caffeine_sliders SET slide_name = '".$data->real_escape_string($slidename)."', slide_speed = '$speedslide', multi_slide = '$multi_slide', navi_slide = '$navi_slide', arrows = '$arrow_slide', fade_slide = '$fade_slide', auto_slide = '$auto_slide', lazy = '$lazy', infinite = '$infinite', numbslide = '$numbslide', created = '".time()."'")or die($data->error);

        $insertId = $data->insert_id;
        //DON'T FORGET TO ADD THIS TO THE PLUGIN LIST//

        $d = $data->query("SELECT id FROM beans WHERE bean_name = 'Caffeine Slider'")or die($data->error);
        $e = $d->fetch_array();

        $token = '{mod}caffeine_slider-sliderMod-'.$insertId.'{/mod}';
        $data->query("INSERT INTO mod_tokens SET mod_parent = '".$e["id"]."', token_name = '".$data->real_escape_string($slidename)."', the_token = '".$data->real_escape_string($token)."', created = '".time()."'")or die($data->error);


    }

    function editsetss($post){
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }

        $slidename = $post["slide_name"];
        $speedslide = $post["speedslide"];
        $slideSets = $post["slides"];
        $numbslide = $post["numbslide"];
        $sliderid = $post["sliderid"];

        if(in_array('multi_slide',$slideSets)){$multi_slide = 'true'; $numbslide = $numbslide;}else{$multi_slide = 'false'; $numbslide = '0';}
        if(in_array('navi_slide',$slideSets)){$navi_slide = 'true'; }else{$navi_slide = 'false';}
        if(in_array('arrows_slide',$slideSets)){$arrow_slide = 'true'; }else{$arrow_slide = 'false';}
        if(in_array('fade_slide',$slideSets)){$fade_slide = 'true'; }else{$fade_slide = 'false';}
        if(in_array('auto_slide',$slideSets)){$auto_slide = 'true'; }else{$auto_slide = 'false';}
        if(in_array('lazy',$slideSets)){$lazy = 'true'; }else{$lazy = 'false';}
        if(in_array('infinite',$slideSets)){$infinite = 'true'; }else{$infinite = 'false';}


        $a = $data->query("UPDATE caffeine_sliders SET slide_name = '".$data->real_escape_string($slidename)."', slide_speed = '$speedslide', multi_slide = '$multi_slide', navi_slide = '$navi_slide', arrows = '$arrow_slide', fade_slide = '$fade_slide', auto_slide = '$auto_slide', lazy = '$lazy', infinite = '$infinite', numbslide = '$numbslide' WHERE id = '$sliderid'")or die($data->error);

    }

    function addTheSlide($post){
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }

        $slide_name = $post["slide_name"];
        $bean_content = $post["bean_content"];
        $slideid = $post["slideid"];

        $startThis = strtotime($_POST["start_this"]);
        $endThis = strtotime($_POST["end_this"]);

        if(isset($post["singleslideid"]) && $post["singleslideid"] != null){
            $data->query("UPDATE caffeine_slides SET slide_name = '".$data->real_escape_string($slide_name)."', slide_content = '".$data->real_escape_string($bean_content)."', slide_start = '$startThis', slide_end = '$endThis' WHERE id = '".$post["singleslideid"]."'");
        }else{
            $a = $data->query("INSERT INTO caffeine_slides SET slide_name = '".$data->real_escape_string($slide_name)."', slide_content = '".$data->real_escape_string($bean_content)."', slide_start = '$startThis', slide_end = '$endThis', slide_blong = '$slideid'");

        }

    }

    function getSlides($slide_id){
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }

        $a = $data->query("SELECT * FROM caffeine_slides WHERE slide_blong = '$slide_id' ORDER BY slide_order ASC")or die($data->error);
        while($b = $a->fetch_assoc()){
            $ars[] = $b;
        }
        return $ars;
    }

    function updateOrder($ars){
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }
        $ords = json_decode($ars,true);
        for($i=0; $i < count($ords); $i++){
            //echo $ords[$i]["name"];
             $data->query("UPDATE caffeine_slides SET slide_order = '$i' WHERE slide_name = '".$ords[$i]["name"]."'");
        }
    }

    function getSingleSlide($id){

        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }

        $a = $data->query("SELECT * FROM caffeine_slides WHERE id = '$id'");
        $b = $a->fetch_array();

        if($b["slide_start"] != '') {
            $slideStart = date('m/d/Y h:i A', $b["slide_start"]);
        }else{
            $slideStart = '';
        }
        if($b["slide_end"] != '') {
            $slideEnd = date('m/d/Y h:i A', $b["slide_end"]);
        }else{
            $slideEnd = '';
        }
        $ars = array("slide_name"=>$b["slide_name"], "slide_start"=> $slideStart, "slide_end"=>$slideEnd, "slide_content"=>$b["slide_content"]);

        return json_encode($ars);
    }


    function deleteSlide($id){
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }

        $data->query("DELETE FROM caffeine_slides WHERE id = '$id'");
    }

    function getSlideSettings($id){
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }

        $a = $data->query("SELECT * FROM caffeine_sliders WHERE id = '$id'");
        $b = $a->fetch_assoc();

        return $b;

    }

    function deleteSlider($id){
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }

        ///DELETE FROM PLUGIN MOD TABLE//
        $a = $data->query("SELECT slide_name FROM caffeine_sliders WHERE id = '$id'");
        $b = $a->fetch_array();

        $data->query("DELETE FROM mod_tokens WHERE token_name = '".$b["slide_name"]."'");

        $data->query("DELETE FROM caffeine_sliders WHERE id = '$id'");
        $data->query("DELETE FROM caffeine_slides WHERE slide_blong = '$id'");



    }
}

