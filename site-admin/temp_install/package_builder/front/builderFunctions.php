<?php
class builder {
    function getCats($packagename) {
        include('../../config.php');

        $a = $data->query("SELECT * FROM package_equipment WHERE package = '$packagename' GROUP BY sub_category");
        while($b = $a->fetch_array()){
            $content[] = $b["sub_category"];
        }
        return $content;

    }

    function getEquipById($id) {
        include('../../config.php');
        $a = $data->query("SELECT * FROM package_equipment WHERE id = '$id' AND active = 'true'");
        $b = $a->fetch_array();

        return $b;

    }

    function getEquipDetail($id) {
        include('../../config.php');
        $a = $data->query("SELECT * FROM deere_equipment WHERE title = '$id' AND active = 'true'");
        $b = $a->fetch_array();

        return $b;
    }


    function getEquipment($equipcat) {
        include('../../config.php');
        $a = $data->query("SELECT * FROM package_equipment WHERE sub_category = '$equipcat' AND active = 'true'");
        while($b = $a->fetch_array()){
            $content[] = $b;
        }
        return $content;

    }

    function getImplementsOG($id) {
        include('../../config.php');
        $a = $data->query("SELECT * FROM package_equipment WHERE id = '$id'");
        $b = $a->fetch_assoc();

        //echo $b["implements"];

        if($b["implements"] == 'true') {
            $content = array();
            $c = $data->query("SELECT * FROM package_attachments WHERE active = 'true' AND type = 'implement'");
            while ($d = $c->fetch_array()) {

                $equipids = json_decode($d["equipment_id"], true);
                for($i = 0; $i < count($equipids); $i++) {

                    if (in_array("$id", $equipids[$i], false)) {
                        $content[] = $d;
                    } else {

                    }
                }

            }

            return $content;

        } else {
          return 'None Found';
        }
        // var_dump($content);
    }


    function getImplements($id) {
        include('../../config.php');
        $a = $data->query("SELECT * FROM package_equipment WHERE id = '$id'");
        $b = $a->fetch_assoc();

        $adds = json_decode($b["lines_items"], true);

        $content = array();

        for($i = 0; $i < count($adds); $i++) {
            $ids = $adds[$i]["id"];
            $c = $data->query("SELECT * FROM attachment_data WHERE name = '$ids' AND type = 'implement'");
            $d = $c->fetch_array();
            if(is_null($d)) {

            } else {
                $content[] = $d;
            }

        }
        //var_dump($content);

        return $content;

    }


    function getAttachments($id) {
        include('../../config.php');
        $a = $data->query("SELECT * FROM package_equipment WHERE id = '$id'");
        $b = $a->fetch_assoc();

        $adds = json_decode($b["lines_items"], true);

        $content = array();

        for($i = 0; $i < count($adds); $i++) {
            $ids = $adds[$i]["id"];
            $c = $data->query("SELECT * FROM attachment_data WHERE name = '$ids' AND type = 'attachment'");
            $d = $c->fetch_array();
            if(is_null($d)) {
            } else {

                $content[] = $d;
            }

        }

        return $content;

    }

    function produceForm($id){
        include('../../config.php');
        $a = $data->query("SELECT * FROM forms_data WHERE form_name = '$id'");
        $b = $a->fetch_array();
        if($b["form_class"] != ''){
            $formClass = 'class="'.$b["form_class"].' row"';
        }else{
            $formClass = '';
        }

        if($b["is_multi"] != 'false'){
            $mult = 'multipart/form-data';
        }else{
            $mult = '';
        }

        if($b["post_link"] != null){
            $postLink = $b["post_link"];
            $returnIt = '';
        }else{
            $postLink = '';
            $returnIt = 'onsubmit="return false"';
        }

        $form .= '<div id="'.$b["form_name"].'_alerts"></div>';

        $form .= '<form '.$formClass.' name="'.$b["form_name"].'" id="'.$b["form_name"].'" '.$mult.' action="'.$postLink.'" method="post" '.$returnIt.'>';
        $form .= '<input type="hidden" name="form_table" id="form_table" value="'.$b["form_name"].'">';

        $form .= $b["form_elems"];

        $form .= '</form>';

        return $form;
    }

}







