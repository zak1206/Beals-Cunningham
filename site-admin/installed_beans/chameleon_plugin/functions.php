<?php
class chameleon{
    function getSlideForm(){
    if(file_exists('../../inc/harness.php')){
        include('../../inc/harness.php');
    }else{
        include('inc/harness.php');
    }

    $html .= '<br><div class="slide campinfo" style=""><small>NOTE! Caffeine Slider must be installed to use this type. This will allow you to create a slide object to pair with the Caffeine Slider. No Tokens will be given as the Caffeine Slider has the chameleon built in.</small></div><br>';

    $html .= '<form name="slider_ch" id="slider_ch" method="post" action="">';
    $html .= '<label>Object Name</label><br>';
    $html .= '<input class="form-control" type="text" name="object_name" id="object_name" value="" required autocomplete="off">';
    $html .= '<br>';
    $html .= '<label>Select a Slider</label><br>';

    $v = $data->query("SELECT slider_id FROM chameleon_objects WHERE type = 'slide'");
    while($p = $v->fetch_assoc()){
        $ars[] = $p["slider_id"];
    }


    $a = $data->query("SELECT id, slide_name FROM caffeine_sliders WHERE active = 'true'");
    if($a->num_rows > 0){
        $html .= '<select class="form-control" name="slider_sel" id="slider_sel" required>';

        $html .= '<option value="">Select a Slider</option>';
        while ($b = $a->fetch_array()) {

            if(in_array($b["id"],$ars, true)){
                //do nothing//
            }else{
                $html .= '<option value="' . $b["id"] . '">' . $b["slide_name"] . '</option>';
            }
        }

        $html .= '</select>';

        $html .= '<br>';

        $html .= '<button class="btn btn-success" type="submit">Create</button>';
    }else{
        $html .= '<div class="alert alert-danger">It appears that there is no sliders in the system. Please make sure the Caffeine Slider is installed and that there are at least one slider created.</div>';
    }


    $html .= '</form>';

    return $html;
}

    function getBoxForm(){
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }

        $html .= '<br><div class="box campinfo" style=""><small>Create a page object and add campaigns to it for use on any page in the site. This will produce a usage token.</small></div><br>';

        $html .= '<form name="box_ch" id="box_ch" method="post" action="">';
        $html .= '<label>Object Name</label><br>';
        $html .= '<input class="form-control" type="text" name="object_name" id="object_name" value="" required autocomplete="off">';

            $html .= '<br>';

            $html .= '<button class="btn btn-success" type="submit">Create</button>';

        $html .= '</form>';

        return $html;
    }

    function processBuild($post){
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }

        $a = $data->query("INSERT INTO chameleon_objects SET object_name = '".$data->real_escape_string($post["object_name"])."', type = 'slide', slider_id = '".$post["slider_sel"]."'");
    }

    function processBuildBox($post){
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }

        $a = $data->query("INSERT INTO chameleon_objects SET object_name = '".$data->real_escape_string($post["object_name"])."', type = 'box'");
    }

    function getSlideTable(){
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }
        $html .= '<table id="example" class="display thetabls" style="width:100%">
                <thead>
                <tr>
                    <th style="font-weight: bold; background: rgb(93, 93, 93); color: rgb(255, 255, 255); border-right: thin solid rgb(239, 239, 239); width: 728px;">Name</th>
                    <th style="font-weight: bold; background: rgb(93, 93, 93); color: rgb(255, 255, 255); border-right: thin solid rgb(239, 239, 239); width: 728px;">Associated Campaigns</th>
                    <th style="font-weight: bold; background: rgb(93, 93, 93); color: rgb(255, 255, 255); border-right: thin solid rgb(239, 239, 239); width: 728px;">Type</th>
                    <th style="font-weight: bold; background: rgb(93, 93, 93); color: rgb(255, 255, 255); border-right: thin solid rgb(239, 239, 239); width: 728px;">Usage Token</th>
                    <th style="font-weight: bold; background: rgb(93, 93, 93); color: rgb(255, 255, 255); border-right: thin solid rgb(239, 239, 239); width: 728px; text-align: right">Action</th>
                </tr>
                </thead>';
                $html .= '<tbody>';

                $a = $data->query("SELECT * FROM chameleon_objects WHERE active = 'true'");
                while($b = $a->fetch_array()){

                    if($b["type"] == 'slide'){
                        $c = $data->query("SELECT * FROM caffeine_sliders WHERE id = '".$b["slider_id"]."'");
                        $d = $c->fetch_array();
                        $type = 'Slider: '.$d["slide_name"];
                    }else{
                        $type = 'Page Object';
                    }

                    $html .= '<tr class="lineitem'.$b["id"].'"><td>'.$b["object_name"].'</td><td>No Campaigns Attached</td><td>'.$type.'</td><td>{mod}chameleon-chamel-'.$b["id"].'{/mod}</td><td style="text-align: right"><a href="?viewtype=editobj&id='.$b["id"].'" class="btn btn-success"><i class="fas fa-edit"></i></a> <button class="btn btn-danger" onclick="deleteObject(\''.$b["id"].'\')"><i class="fas fa-trash-alt"></i></button> </td></tr>';
                }


                $html .= '</tbody>
            </table>';

                return $html;
    }

    function startCampaign(){
        $html .= '<div class="camp_alerts"></div>';
        $html .= '<form name="new-campagin" id="new-campagin" method="post" action="">';
        $html .= '<label>Campaign Name</label><br><input type="text" class="form-control" name="campaign_name" id="campaign_name" value="" required="required"><br><br>';
        $html .= '<label>Campaign Item Type</label><br>';
        $html .= '<select class="form-control" name="campaign_type" id="campaign_type" required="required">';
        $html .= '<option value="">Select Type</option>';
        $html .= '<option value="box">Page Object</option>';
        $html .= '<option value="slider">Slider</option>';
        $html .= '</select><br><br>';
        $html .= '<button class="btn btn-success">Create</button>';
        $html .= '</form>';

        return $html;

    }

    function getCampTable(){
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }
        $html .= '<table id="example" class="display thecamptabls" style="width:100%">
                <thead>
                 <tr>
                    <th style="font-weight: bold; background: rgb(93, 93, 93); color: rgb(255, 255, 255); border-right: thin solid rgb(239, 239, 239); width: 728px;">Campaign Name</th>
                    <th style="font-weight: bold; background: rgb(93, 93, 93); color: rgb(255, 255, 255); border-right: thin solid rgb(239, 239, 239); width: 728px;">Type</th>
                    <th style="font-weight: bold; background: rgb(93, 93, 93); color: rgb(255, 255, 255); border-right: thin solid rgb(239, 239, 239); width: 728px;">Impressions</th>
                    <th style="font-weight: bold; background: rgb(93, 93, 93); color: rgb(255, 255, 255); border-right: thin solid rgb(239, 239, 239); width: 728px;">Interactions</th>
                    <th style="font-weight: bold; background: rgb(93, 93, 93); color: rgb(255, 255, 255); border-right: thin solid rgb(239, 239, 239); width: 728px; text-align: right">Action</th>
                </tr>
                </thead>';
        $html .= '<tbody>';

        $a = $data->query("SELECT * FROM chameleon_campaigns WHERE active = 'true'");
        while($b = $a->fetch_array()){

            if($b["campaign_type"] == 'box'){
                $campaign_type = 'Page Object';
            }else{
                $campaign_type = 'Slider';
            }

            $html .= '<tr class="lineitemcamp'.$b["id"].'"><td>'.$b["campaign_name"].'</td><td>'.$campaign_type.'</td><td>0</td><td>0</td><td style="text-align: right"><a href="?viewtype=editcamp&id='.$b["id"].'" class="btn btn-success"><i class="fas fa-edit"></i></a> <button class="btn btn-danger" onclick="deleteCampagin(\''.$b["id"].'\')"><i class="fas fa-trash-alt"></i></button> </td></tr>';
        }


        $html .= '</tbody>
            </table>';

        return $html;
    }

    function saveIntCamp($post){
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }

        $name = $post["campaign_name"];
        $type = $post["campaign_type"];

        $a = $data->query("SELECT * FROM chameleon_campaigns WHERE campaign_name = '".$data->real_escape_string($name)."'");

        if($a->num_rows == 0) {

            $data->query("INSERT INTO chameleon_campaigns SET campaign_name = '" . $data->real_escape_string($name) . "', campaign_type = '" . $data->real_escape_string($type) . "'");
            return json_encode(array("result"=>'success', "message"=>'Campaign has been successfully created.'));
        }else{
            return json_encode(array("result"=>'error', "message"=>'Campaign with that name already exist. Please choose a different name.'));
        }
    }


    function getCampItem($id){

        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }

        $a = $data->query("SELECT * FROM chameleon_campaigns WHERE id = '$id'");

        $b = $a->fetch_assoc();



        return $b;

    }

    function updateCamp($post){
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }

        $campaign_name = $post["campagin_name"];
        $keywords = $post["campagin_keywords"];
        $campaign_details = $post["object_content"];
        $camp_id = $post["camp_id"];

        $data->query("UPDATE chameleon_campaigns SET campaign_name = '".$data->real_escape_string($campaign_name)."', keywords = '".$data->real_escape_string($keywords)."', campaign_details = '".$data->real_escape_string($campaign_details)."' WHERE id = '$camp_id'");
    }

    function getObjItem($id){

        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }

        $a = $data->query("SELECT * FROM chameleon_objects WHERE id = '$id'");

        $b = $a->fetch_assoc();



        return $b;

    }

    function getAllCampaigns($type){
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }

        if($type == 'box'){
            $type = $type;
        }else{
            $type = 'slider';
        }

        $a = $data->query("SELECT campaign_name, id FROM chameleon_campaigns WHERE active = 'true' AND campaign_type = '$type'");
        while($b = $a->fetch_assoc()){
            $ars[] = $b;
        }

        return $ars;
    }

    function updateObj($post){
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }

        $objname = $post["objname"];
        $default_content = $post["default_content"];
        $campsels = json_encode($post["campsels"]);

        $data->query("UPDATE chameleon_objects SET object_name = '".$data->real_escape_string($objname)."', campaigns = '".$data->real_escape_string($campsels)."', default_info = '".$data->real_escape_string($default_content)."' WHERE id = '".$post["objid"]."'")or die($data->error);

    }

    function deleteObject($id){
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }

        $data->query("DELETE FROM chameleon_objects WHERE id = '$id'");
    }

    function deleteCampaign($id){
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }

        $data->query("DELETE FROM chameleon_campaigns WHERE id = '$id'");
    }
}