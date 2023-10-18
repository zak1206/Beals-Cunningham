<?php
session_start();
if($b["offers_active"] == 'true' && $b["extra_content"] != null){

    if(isset($_SESSION["prmotrack"])){
        $expand = json_decode($_SESSION["prmotrack"],true);

        if(in_array($page,array_column($expand, 'equip'))){
            ///DO NOTHING//
        }else{
            for($i=0;$i<count($expand); $i++){
                $promo[] = array("equip"=>$expand[$i]["equip"]);
            }
            $promo[] = array("equip"=>$page);

            $_SESSION["prmotrack"] = json_encode($promo);
        }

    }else{
        $promo[] = array("equip"=>$page);
        $_SESSION["prmotrack"] = json_encode($promo);
    }

}