<?php
class sliderMod{

    function add_lazyload($content) {

        $content = mb_convert_encoding($content, 'HTML-ENTITIES', "UTF-8");
        $dom = new DOMDocument();
        @$dom->loadHTML($content);

        // Convert Images
        $images = [];

        foreach ($dom->getElementsByTagName('img') as $node) {
            $images[] = $node;
        }

        foreach ($images as $node) {
            $fallback = $node->cloneNode(true);

            $oldsrc = $node->getAttribute('src');
            $node->setAttribute('data-lazy', $oldsrc );
            $newsrc = '/images/placeholder.gif';
            $node->removeAttribute('src');

            $oldsrcset = $node->getAttribute('srcset');

            $newsrcset = '';

//            $classes = $node->getAttribute('class');
//            $newclasses = $classes . ' lazy lazy-hidden';
//            $node->setAttribute('class', $newclasses);


        }




        $newHtml = preg_replace('/^<!DOCTYPE.+?>/', '', str_replace( array('<html>', '</html>', '<body>', '</body>'), array('', '', '', ''), $dom->saveHTML()));
        return $newHtml;
    }

    function runOutput($comid){

        include('inc/config.php');
        date_default_timezone_set('America/Chicago');

        $a = $data->query("SELECT * FROM caffeine_sliders WHERE id = '$comid'")or die($data->error);
        $b = $a->fetch_array();

        if($b["multi_slide"] != 'false' && $b["numbslide"] != 0 && $b["numbslide"] != 1){$multiSlide = '"slidesToShow": '.$b["numbslide"].', "slidesToScroll": '.$b["numbslide"].',';}else{$multiSlide='';}
        if($b["navi_slide"] != 'false'){$naviSlide = '"dots": true,';}else{$naviSlide='';}
        if($b["arrows"] != 'false'){$arrowsSlide = '"arrows": true,';}else{$arrowsSlide='"arrows": false,';}
        if($b["fade_slide"] != 'false'){$fadeSlide = '"fade": true,';}else{$fadeSlide='';}
        if($b["infinite"] != 'false'){$infiniteSlide = '"infinite": true';}else{$infiniteSlide='"infinite": false';}
        if($b["auto_slide"] != 'false'){
            $autoSlide = '"autoplay": true,';
            $autoPlaySpeed = $b["slide_speed"];
            $plaspeed = '"autoplaySpeed": '.$b["slide_speed"].',';
        }else{
            $autoSlide='';
        }

        $lazy = $b["lazy"];

        if($lazy == 'true'){
            $theLaz = '"lazyLoad": ondemand';
        }else{
            $theLaz = '';
        }

        $returnSlide .= '<div class="caffeine-slider" data-slick=\'{'.$multiSlide.' '.$naviSlide.' '.$fadeSlide.' '.$autoSlide.' '.$arrowsSlide.' '.$plaspeed.' '.$infiniteSlide.' '.$theLaz.'}\'>';
        $d = $data->query("SELECT * FROM caffeine_slides WHERE slide_blong = '$comid' ORDER BY slide_order ASC");

        if ($result = $data->query("SHOW TABLES LIKE 'chameleon_objects'")) {
            if($result->num_rows == 1) {
                $bn = $data->query("SELECT * FROM chameleon_objects WHERE slider_id = '$comid' AND active = 'true'");
                $fg = $bn->fetch_array();

                $slideObjects = json_decode($fg["campaigns"],true);
                $sercKeys = array();
                foreach($slideObjects as $campObj){
                    $zv = $data->query("SELECT * FROM chameleon_campaigns WHERE id = '".$campObj."' AND active = 'true'");
                    $lk = $zv->fetch_array();



                    $campaign_details = str_replace('../','',$lk["campaign_details"]);
                    $convertArs = explode(',',$lk["keywords"]);

                    //var_dump($convertArs);
                    foreach($convertArs as $keys){
                        $sercKeys[$keys] = $campaign_details;


                    }


                }

                //var_dump($sercKeys);

                $sercKeys = array_unique($sercKeys);


                if(isset($_SESSION["page_track"])){
                    $captures = array_unique(json_decode($_SESSION["page_track"],true));

                    $captures = array_reverse($captures, true);


                    foreach ($captures as $key){

                        ///echo $key;
                        if($sercKeys[$key] != null) {
                           // echo $key;
                            $returnSlide .= $sercKeys[$key];
                        }
                    }

                }else{

                }


            }
        }else{
            $returnSlide .= 'NOOOO';
        }






        while($e = $d->fetch_array()){


            if($e["slide_start"] == '' && $e["slide_end"] == '' || $e["slide_start"] == '' && time() <= $e["slide_end"] || time() >= $e["slide_start"] && $e["slide_end"] == '' || time() >= $e["slide_start"] && time() <= $e["slide_end"]){
               $returnSlide .= '<div>'.str_replace('../../','', $e["slide_content"]).'</div>';
            }else{

            }

        }
        $returnSlide .= '</div>';


        if($lazy == 'true'){
            $returnSlide = $this->add_lazyload($returnSlide);
        }



        $de = $data->query("SELECT id FROM beans WHERE bean_id = 'CAFFEINESLIDE_v1'");
        $pe = $de->fetch_array();

        $depId = $pe["id"];

        $op = $data->query("SELECT * FROM beans_dep WHERE bean_id = '$depId' AND active = 'true' AND load_type = 'mod'")or die($data->error);
        while($fg = $op->fetch_array()){
            if($fg["type"] == 'css'){
                $css[] = $fg["file"];
            }

            if($fg["type"] == 'js'){
                $js[] = $fg["file"];
            }
        }


            return $returnSlide;
    }
}
?>