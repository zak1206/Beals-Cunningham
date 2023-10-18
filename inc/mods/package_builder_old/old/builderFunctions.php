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

    function getImpDetails($cat) {
        include('../../config.php');
        $a = $data->query("SELECT * FROM attachment_data WHERE category = '$cat' AND active = 'true' LIMIT 1");
        while($b = $a->fetch_array()){
            if(!empty($b["description"]) || !empty($b["add_image"])) {
                $content[] = $b;
            } else {

            }
        }
        return $content;
    }

    function getImpImage($cat) {
        include('../../config.php');
        $a = $data->query("SELECT * FROM attachment_data WHERE category = '$cat' AND active = 'true' LIMIT 1");
        while($b = $a->fetch_array()){
            if(!empty($b["add_image"])) {
                $content[] = $b;
            } else {

            }
        }
        return $content;
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

    function saveForm($post)
    {
        include('../../config.php');
        include('../../siteFunctions.php');
        $process = new site();

        $equip = $post["equipment-type"];
        // format equipment infor

        $equipstart = explode(" - ", $equip);

       $equipprices = str_replace('$', '<br>',$equipstart[1]);


        //Start formatting general information table

        $generalinfo = explode("<br>", $post["general-information"]);

        $removelastone = array_pop($generalinfo);


        $formgeninfo .= '<table class="table">';

        $i=0;
        foreach($generalinfo as $geninfo){
            ++$i;
            if($i==1){
                $formgeninfo .= '<tr>';
                $formgeninfo .= '<td>'.$geninfo.'</td>';
            }
            if($i==2){
                $formgeninfo .= '<td>'.$geninfo.'</td>';
                $formgeninfo .= '</tr>';
        $i=0;
    }
        }

        $formgeninfo .= '</table>';

        //Start formatting payment information table

        $paymentinfo = explode("<br>", $post["payment-information"]);

        $removelastone = array_pop($paymentinfo);


        $formpayinfo .= '<table class="table">';

        $i=0;
        foreach($paymentinfo as $payinfo){
            ++$i;
            if($i==1){
                $formpayinfo .= '<tr>';
                $formpayinfo .= '<td>'.$payinfo.'</td>';
            }
            if($i==2){
                $formpayinfo .= '<td>'.$payinfo.'</td>';
                $formpayinfo .= '</tr>';
                $i=0;
            }
        }

        $formpayinfo .= '</table>';

        // Send the Form Data to Email
        $to[] = array("email" => 'joycem@bealscunningham.com', "name" => "Joyce McMillar");
        $fromemail = "system@bcssdevelopment.com";
        $fromName = "Dealer Name";
        $subject = "Tractor Package Request";

        $message .= '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><html lang="en"><head> <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> <meta name="viewport" content="width=device-width, initial-scale=1"> <meta http-equiv="X-UA-Compatible" content="IE=edge"> <title></title> <style type="text/css"> </style> </head><body style="margin:0; padding:0;">';
        $message .= '<div style="padding: 20px"><h2>'.$subject.'</h2></div>';
        $message .= '<div style="padding: 20px"><h2>Contact Information</h2><p>Name: '.$post["first_name"].' '.$post["last_name"].'</p><p>Phone: '.$post["phone"].'</p><p>Email: '.$post["email"].'</p><p>Comments: '.$post["comments"].'</p></div>';
        $message .= '<div style="padding: 20px"><h2>Equipment Information</h2><p>'.$equipstart[0].'</p>';
        $message .= '<p>'.$equipprices.'</p></div>';
        $message .= '<div style="padding: 20px"><h2>General Information</h2>'.$formgeninfo.'</div>';
        $message .= '<div style="padding: 20px"><h2>Payment Information</h2>'.$formpayinfo.'</div>';
        $message .= '</body></html>';



        $a = $data->query("INSERT INTO tractor_package_leads SET first_name = '" . $data->real_escape_string($post["first_name"]) . "', last_name = '" . $data->real_escape_string($post["last_name"]) . "', email = '" . $data->real_escape_string($post["email"]) . "', comments = '" . $data->real_escape_string($post["comments"]) . "', equip_detail = '" . $data->real_escape_string($equipstart[0]).' - '.$equipprices. "', general_information = '" . $data->real_escape_string($formgeninfo) . "', payment_information = '" . $data->real_escape_string($formpayinfo) . "', active = 'true'")or die($data->error);

        $process->mailIt($to,$fromemail,$fromName,$subject,$message);
//        echo $equip;


    }

}







