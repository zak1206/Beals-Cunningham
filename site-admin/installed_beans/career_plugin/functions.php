<?php
class career_block{

    function getLocations()
    {
        include('../../inc/harness.php');
        $a = $data->query("SELECT * FROM location WHERE active = 'true'");
        while ($b = $a->fetch_assoc()) {
            $locs[] = $b;
        }

        return $locs;
    }

    function createLocation($post, $phoneJson, $emailJson, $dayJson, $map)
    {
        include('../../inc/harness.php');
        if (isset($post["newrecord"])) {
            $data->query("UPDATE location SET location_name = '" . $data->real_escape_string($post["location-name"]) . "', location_address = '" . $data->real_escape_string($post["location-address"]) . "', location_city = '" . $data->real_escape_string($post["location-city"]) . "', location_state = '" . $data->real_escape_string($post["location-state"]) . "', location_zip = '" . $data->real_escape_string($post["location-zip"]) . "', location_img = '" . $data->real_escape_string($post["loc-img"]) . "', location_link = '" . $data->real_escape_string($post["nav-link"]) . "', location_phones = '" . $data->real_escape_string($phoneJson) . "', location_emails = '" . $data->real_escape_string($emailJson) . "', location_hours = '" . $data->real_escape_string($dayJson) . "', location_map = '" . $data->real_escape_string($map) . "', form_code = '" . $data->real_escape_string($post["form-code"]) . "'  WHERE id = '" . $post["newrecord"] . "'") or die($data->error);
            $iserid = $data->insert_id;
            return $post["newrecord"];
        } else {
            $data->query("INSERT INTO location SET location_name = '" . $data->real_escape_string($post["location-name"]) . "', location_address = '" . $data->real_escape_string($post["location-address"]) . "', location_city = '" . $data->real_escape_string($post["location-city"]) . "', location_state = '" . $data->real_escape_string($post["location-state"]) . "', location_zip = '" . $data->real_escape_string($post["location-zip"]) . "', location_img = '" . $data->real_escape_string($post["loc-img"]) . "', location_link = '" . $data->real_escape_string($post["nav-link"]) . "', location_phones = '" . $data->real_escape_string($phoneJson) . "', location_emails = '" . $data->real_escape_string($emailJson) . "', location_hours = '" . $data->real_escape_string($dayJson) . "', location_map = '" . $data->real_escape_string($map) . "', form_code = '" . $data->real_escape_string($post["form-code"]) . "'") or die($data->error);
            $iserid = $data->insert_id;
            return $iserid;
        }

    }

    function getCategories(){
        include('../../inc/harness.php');
        $a = $data->query("SELECT * FROM career_blocks WHERE active = 'true' GROUP BY category")or die($data->error);
        while($b = $a->fetch_array()){
            $cats[] = $b["category"];
        }

        return $cats;
    }

    function addJob($post){
        include('../../inc/harness.php');

        if($post["new_cat"]!= null){
            $category = $post["new_cat"];
        }else{
            $category = $post["category"];
        }

        $data->query("INSERT INTO career_blocks SET career_title = '".$data->real_escape_string($post["title"])."', career_level = '', category = '".$data->real_escape_string($category)."', location = '".$data->real_escape_string($post["location"])."', position_type = '".$data->real_escape_string($post["position_type"])."', description = '".$data->real_escape_string($post["description"])."', qualifications = '".$data->real_escape_string($post["qualifications"])."', active = 'true', date_set = '".time()."'");
    }

    function editJob($post){
        include('../../inc/harness.php');

        if($post["new_cat"]!= null){
            $category = $post["new_cat"];
        }else{
            $category = $post["category"];
        }

        $data->query("UPDATE career_blocks SET career_title = '".$data->real_escape_string($post["title"])."', career_level = '', category = '".$data->real_escape_string($category)."', location = '".$data->real_escape_string($post["location"])."', position_type = '".$data->real_escape_string($post["position_type"])."', description = '".$data->real_escape_string($post["description"])."', qualifications = '".$data->real_escape_string($post["qualifications"])."' WHERE id = '".$post["editform"]."'");
    }

    function getJobs(){
        include('../../inc/harness.php');
        $a = $data->query("SELECT * FROM career_blocks WHERE active = 'true' ORDER BY date_set DESC");
        while($b = $a->fetch_assoc()){
            $jobsOut[] = $b;
        }

        return $jobsOut;
    }

    function getSingleJob($id){
        include('../../inc/harness.php');
        $a = $data->query("SELECT * FROM career_blocks WHERE id = '$id'");
        $b = $a->fetch_assoc();

        return $b;
    }

    function getJobLocationName($id){
        include('../../inc/harness.php');
        $a = $data->query("SELECT * FROM location WHERE id = '$id'");
        $b = $a->fetch_array();
        return $b["location_name"];
    }

    function removeListing($id){
        include('../../inc/harness.php');
        $a = $data->query("UPDATE career_blocks SET active = 'false' WHERE id = '$id'");
    }

    function stateArs()
    {
        $states = array(
            'Alabama' => 'AL',
            'Alaska' => 'AK',
            'Arizona' => 'AZ',
            'Arkansas' => 'AR',
            'California' => 'CA',
            'Colorado' => 'CO',
            'Connecticut' => 'CT',
            'Delaware' => 'DE',
            'Florida' => 'FL',
            'Georgia' => 'GA',
            'Hawaii' => 'HI',
            'Idaho' => 'ID',
            'Illinois' => 'IL',
            'Indiana' => 'IN',
            'Iowa' => 'IA',
            'Kansas' => 'KS',
            'Kentucky' => 'KY',
            'Louisiana' => 'LA',
            'Maine' => 'ME',
            'Maryland' => 'MD',
            'Massachusetts' => 'MA',
            'Michigan' => 'MI',
            'Minnesota' => 'MN',
            'Mississippi' => 'MS',
            'Missouri' => 'MO',
            'Montana' => 'MT',
            'Nebraska' => 'NE',
            'Nevada' => 'NV',
            'New Hampshire' => 'NH',
            'New Jersey' => 'NJ',
            'New Mexico' => 'NM',
            'New York' => 'NY',
            'North Carolina' => 'NC',
            'North Dakota' => 'ND',
            'Ohio' => 'OH',
            'Oklahoma' => 'OK',
            'Oregon' => 'OR',
            'Pennsylvania' => 'PA',
            'Rhode Island' => 'RI',
            'South Carolina' => 'SC',
            'South Dakota' => 'SD',
            'Tennessee' => 'TN',
            'Texas' => 'TX',
            'Utah' => 'UT',
            'Vermont' => 'VT',
            'Virginia' => 'VA',
            'Washington' => 'WA',
            'West Virginia' => 'WV',
            'Wisconsin' => 'WI',
            'Wyoming' => 'WY'
        );

        return $states;
    }



}