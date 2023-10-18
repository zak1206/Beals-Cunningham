<?php
class pagemods{
    function checkOthers($page){
        include('inc/config.php');
        $a = $data->query("SELECT page_mod_name FROM page_mods WHERE active = 'true'");
        while($b = $a->fetch_assoc()){
            $ars[] = $b;
        }

        for($i=0; $i < count($ars); $i++){
            $pageModName = $ars[$i]["page_mod_name"];

            if(file_exists('inc/mods/'.$pageModName.'/pages.php')){
                include_once('inc/mods/'.$pageModName.'/pages.php');
            }else{
                return '';
                die();
            }


            $checkContent = new $pageModName;
            $checkContent = $checkContent->page($page);
            if($checkContent != null){
                return $checkContent;
                die();
            }
        }


    }
}