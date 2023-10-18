<?php
    class caffeineModal {
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
    }
?>