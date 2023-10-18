<?php
$act = $_REQUEST["act"];
include('config.php');

if ($act == 'getzipbase') {

    $address = $_REQUEST["zip"];
    $address = str_replace(" ", "+", $address);
    $region = "USA";

    $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?key=AIzaSyAgUxXC39x0LdaXhFnASOMq_npAx7qtIK0&address=$address&sensor=false&region=$region");
    $json = json_decode($json);


    $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
    $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};

    $locArray = array();

    // echo json_encode(array("dir" => array("lat" => $lat, "long" => $long)));
    // echo "Lat";
    // var_dump($lat);
    // echo "Long";
    // var_dump($long);
    $a = $data->query("SELECT *, (6371 * acos (cos ( radians($lat) )* cos( radians( latitude ) )* cos( radians( longitude ) - radians($long) )+ sin ( radians($lat) )* sin( radians( latitude ) ))) AS distance FROM location ORDER BY distance LIMIT 3");
    $html = '<ul id="locationLocatorDetail" style="margin-bottom:0;">
    <div id="location-detail">';
    $html .= '<div class="row row12" style="color: #181E22">';
    while ($b = $a->fetch_assoc()) {
        // array_push($locArray, $b["id"]);
        // var_dump($b["id"]);
        $phone = json_decode($b["location_phones"], true);
        $phone = $phone[0]["phoneNum"];
        $html .= '<div class="col-md-12">
        <a href="' . $b["location_link"] . '"><h4 style="text-align: center; margin: 5px 0;"><b><i class="fas fa-map-marker-alt" style="padding-right: 5px;"></i>' . $b["location_name"] . '</b></h4></a><h6 style="text-align: center"><a class="text-link" href="tel:' . $phone . '">' . $phone . '</a></h6><hr style="margin: 10px 0;">
        </div>';
    }
    $html .= "</div>";
    $html .= '</div></ul>';
    $html .= '<h5 class="text-center" style=" margin-top: 0;"><a href="locations" class="btn btn-blue-sm" style="color: #181E22; font-weight: 600;">See All Locations</a></h5>';
    echo $html;
}
