<?php
class chamel{
    function runOutput($comid){

        $sercKeys = array();
        include('inc/config.php');
        $a = $data->query("SELECT * FROM chameleon_objects WHERE id = '$comid'");
        $b = $a->fetch_array();

        $campaigns = json_decode($b["campaigns"],true);
        $default_info = str_replace('../../','',$b["default_info"]);

        foreach($campaigns as $keyout){
            $c = $data->query("SELECT * FROM chameleon_campaigns WHERE id = '$keyout'");
            while($d = $c->fetch_array()){
                $campaign_details = str_replace('../','',$d["campaign_details"]);
                $convertArs = explode(',',$d["keywords"]);



                foreach($convertArs as $keys){
                    $sercKeys[$keys] = $campaign_details;
                }

            }
        }


        if(isset($_SESSION["page_track"])){
            $captures = array_unique(json_decode($_SESSION["page_track"],true));
            $captures = array_reverse($captures, true);

            foreach ($captures as $key){

                if($sercKeys[$key] != null) {
                    return $sercKeys[$key];
                }
            }

        }else{

        }


        return $default_info;


    }
}