<?php
error_reporting(0);
date_default_timezone_set('America/Chicago');
if($_REQUEST["step_one"] == 'true'){
    include('../../../inc/config.php');
    session_start();

    function halfHourTimes() {
        $formatter = function ($time) {
            if ($time % 3600 == 0) {
                return date('G:i', $time);
            } else {
                return date('G:i', $time);
            }
        };
        $halfHourSteps = range(0, 47*1800, 1800);
        return array_map($formatter, $halfHourSteps);
    }


    if(isset($_SESSION["request_service_session"])){
        $theSession = $_SESSION["request_service_session"];
        $a = $data->query("SELECT * FROM service_sched WHERE session_data = '$theSession'");
        $b = $a->fetch_array();
        $servicesNeeded = json_decode($b["services_needed"],true);
        $serviceDate = $b["service_date"];
        $serviceTime = $b["service_time"];
        $serviceAddInfo = $b["add_info"];
    }else{
        session_start();
        $theSession = md5(date('mdyisa'));
        $_SESSION["request_service_session"] = $theSession;
        $servicesNeeded = '';
        $serviceDate = '';
        $serviceTime = '';
        $serviceAddInfo = '';
        $data->query("INSERT INTO service_sched SET session_data = '$theSession'");
    }


    $html .= '<form style="padding: 20px; padding-bottom: 70px;" name="sched_services" id="sched_services" method="post" action="" onsubmit="return false">
    <h2 style="font-weight:bold; text-align:center; color:#367C2B; ">Request Service</h2>
    <hr>
    <div class="">
        <div class="row" style="text-align: center">
            <ul class="breadcrumb hidden-sm hidden-xs">
                <li class="active"><a href="javascript:void(0);" style="padding: 5px">Select Services & Date</a></li>
                <li class=""><a href="javascript:void(0);" style="padding: 5px">Enter Contact Details</a></li>
                <li class=""><a href="javascript:void(0);" style="padding: 5px">Review Details</a></li>
                <li class=""><a href="javascript:void(0);" style="padding: 5px">Finished</a></li>
            </ul>
        </div>
    </div>

    <div class="generrors"></div>
    
    <div class="row">

    <div class="col-md-5">';


    $serviceArs = array("Oil & Filter Change","Full Service & Inspection Package","Equipment Repair","Other");
    $i=0;
    foreach($serviceArs as $services){
        if(in_array($services,$servicesNeeded)){
            $boxes .= '<div class="col-6 checkbox checkbox-primary">
        <input name="service_check[]" id="service_check_'.$i.'" type="checkbox" value="'.$services.'" checked="checked">
        <label for="service_check_'.$i.'">
            '.$services.'
        </label>
    </div>';
        }else{
            $boxes .= '<div class="col-6 checkbox checkbox-primary">
        <input name="service_check[]" id="service_check_'.$i.'" type="checkbox" value="'.$services.'">
        <label for="service_check_'.$i.'">
            '.$services.'
        </label>
    </div>';
        }

        $i++;
    }

    $html .= '<h4 style="text-transform: uppercase;font-weight:bold; ">Select Service Type</h4><div class="row">
   '.$boxes.'
</div>
        <br>
        <textarea class="form-control" placeholder="Provide any additional information." name="addinfo" id="addinfo" style="color:#000; height:129px; resize: none">'.$serviceAddInfo.'</textarea><br>
        
        <h4 style="text-transform: uppercase;font-weight:bold;">Service Location</h4>
        <select class="form-control" name="service_location" id="service_location"><option value="dropoff">Customer Drop-Off</option><option value="on-site">On-Site Service</option><option value="pick-delivery">Pickup/Delivery</option></select>
        </div>
    <div class="col-md-7">
        <h4 style="text-transform: uppercase;font-weight:bold;">Choose a Date</h4>
        <div style="overflow:hidden;">
            <div class="form-group">
                <div class="">
                    <div class="">
                        <div id="datetimepicker12" data-date="'.$serviceDate.'"></div>
                        <input type="hidden" name="selected_date" id="selected_date" data-msg="Please Select a Service Date." value="'.$serviceDate.'">
                    </div>
                </div>
                <div class="col-md-8">
                <br>
                <label style="    font-size: 19px;
    text-transform: uppercase; font-family: \'Montserrat\', \'Helvetica Neue\', Helvetica, Arial, sans-serif;font-weight:bold;">Pick a Time:</label><br>
    <div class="timeselector">
                    <select name="timeSet" id="timeSet" required data-msg="Please Select a Service Time." class="form-control"><option value="">CHOOSE A DATE FOR SERVICE ABOVE...</option>';




    $html .='</select>
</div>
                </div>
            </div>
        </div>
        <input type="hidden" name="sched_session" id="sched_session" value="'.$theSession.'">
        <button style="float:right;" class="btn btn-primary" type="submit">NEXT STEP <i class="fa fa-angle-right" aria-hidden="true"></i></button>
    </div>

</form>

<div style="clear: both; height: 70px;"></div>';

    $html .= '<div>';

    echo $html;

}

if($_REQUEST["action"] == 'gettimelist'){
    include('../../../inc/config.php');
    function halfHourTimes() {
        $formatter = function ($time) {
            if ($time % 3600 == 0) {
                return date('G:i', $time);
            } else {
                return date('G:i', $time);
            }
        };
        $halfHourSteps = range(0, 47*1800, 1800);
        return array_map($formatter, $halfHourSteps);
    }
    $html .= ' <select name="timeSet" id="timeSet" required data-msg="Please Select a Service Time." class="form-control"><option value="">Select Time...</option>';

    $timesArsOne = halfHourTimes();
    $serviceDate = $_REQUEST["seldate"];

    foreach($timesArsOne as $key){
        $cleanTime = strtotime($key);
        $startTime = strtotime('7:00');
        $endTime = strtotime('17:00');

        if($cleanTime >= $startTime && $cleanTime < $endTime){
            if($serviceTime == date('g:ia',$cleanTime)){
                $html .= '<option value="'.date('g:ia',$cleanTime).'" selected="selected">'.date('g:ia',$cleanTime).'</option>';
            }else{



                if(strtotime($serviceDate. $key) > strtotime(date('m/d/Y g:ia')) + 60*60){
                    $v = $data->query("SELECT * FROM service_sched WHERE service_date = '$serviceDate' AND service_time = '".date('g:ia',$cleanTime)."' AND completed = 'true'");
                    if($v->num_rows > 1){
                        $html .= '<option value="'.date('g:ia',$cleanTime).'" disabled="disabled">'.date('g:ia',$cleanTime).' Not Available</option>';
                    }else{
                        $html .= '<option value="'.date('g:ia',$cleanTime).'">'.date('g:ia',$cleanTime).'</option>';
                    }

                }else{
                    $html .= '<option class="timelimit" value="'.date('g:ia',$cleanTime).'" disabled="disabled" style="display:none">'.date('g:ia',$cleanTime).'</option>';
                }

            }

        }
    }


    $html .='</select>';

    echo $html;
}

if($_REQUEST["step_two"] == 'true'){
    include('../../../inc/config.php');
    session_start();
    if(isset($_SESSION["request_service_session"])){
        $session = $_SESSION["request_service_session"];

        if(isset($_REQUEST["stepback"])){
            $a = $data->query("SELECT * FROM service_sched WHERE session_data = '$session'");
            $b = $a->fetch_array();
            $theServices = json_decode($b["services_needed"],true);
            $setDate = $b["service_date"];
            $setTime = $b["service_time"];
            $car_year = $b["car_year"];
            if($b["add_info"] != '') {
                $add_info = $data->real_escape_string($b["add_info"]);
            }else{
                $add_info = 'No Additional Details.';
            }
        }else{
            $needs = json_encode($_POST["service_check"]);
            $theServices = $_POST["service_check"];
            $setDate = $_POST["selected_date"];
            $setTime = $_POST["timeSet"];
            $car_year = $_POST["car_year"];
            $serviceLocation = $_POST["service_location"];
            if($_POST["addinfo"] != '') {
                $add_info = $data->real_escape_string($_POST["addinfo"]);
            }else{
                $add_info = 'No Additional Details.';
            }
            $data->query("UPDATE service_sched SET services_needed = '".$data->real_escape_string($needs)."', service_location = '$serviceLocation', service_date = '$setDate', service_time = '".$_POST["timeSet"]."', add_info = '$add_info', date_set = NOW() WHERE session_data = '$session'")or die($data->error);
            $a = $data->query("SELECT * FROM service_sched WHERE session_data = '$session'");
            $b = $a->fetch_array();
            $theServices = $_POST["service_check"];
        }


        $fname = $b["fname"];
        $lname = $b["lname"];
        $email = $b["email"];
        $address = $b["address"];
        $city = $b["city"];
        $state = $b["state"];
        $zip = $b["zip"];
        $phone = $b["phone"];
        $car_make = $b["car_make"];
        $car_model = $b["car_model"];
        $car_year = $b["car_year"];

    }else{
        session_start();
        $needs = json_encode($_POST["service_check"]);
        $setDate = $_POST["selected_date"];
        $setTime = $_POST["timeSet"];
        $session = $_POST["sched_session"];
        $theServices = $_POST["service_check"];
        $serviceLocation = $_POST["service_location"];
        if($_POST["addinfo"] != '') {
            $add_info = $data->real_escape_string($_POST["addinfo"]);
        }else{
            $add_info = 'No Additional Details.';
        }


        $_SESSION["request_service_session"] = $session;
        $data->query("INSERT INTO service_sched SET services_needed = '".$data->real_escape_string($needs)."', service_date = '$setDate', service_time = '$setTime', service_location = '$serviceLocation', add_info = '$add_info', session_data = '$session', date_set = NOW()")or die($data->error);
    }





    $html .= '<h2>SCHEDULE SERVICES</h2><hr>';

    $html .= '<div class="">
        <div class="row" style="text-align: center">
            <ul class="breadcrumb hidden-sm hidden-xs">
                <li class=""><a href="javascript:goStepOne();" style="padding: 5px">Select Services & Date</a></li>
                <li class="active"><a href="javascript:void(0);" style="padding: 5px">Enter Contact Details</a></li>
                <li class=""><a href="javascript:void(0);" style="padding: 5px">Review Details</a></li>
                <li class=""><a href="javascript:void(0);" style="padding: 5px">Finished</a></li>

            </ul>
        </div>
    </div>

    <div class="generrors"></div>';

    foreach($theServices as $keys){
        $tags .= '<span class="label label-default">'.ucwords($keys).'</span>, ';
    }

    $html .= '<form name="client_info" id="client_info" method="post" action="" onsubmit="return false" style="padding-bottom: 60px;">';
    $html .= '<div class="row" style="margin: 20px">';
    $html .= '<div class="col-md-5">';
    $html .= '<h3 style="font-weight:bold;">Service Details</h3>';
    $html .= '<table class="table" style="background: #efefef">';

    $html .= '<tr><td><strong>Selected Services:</strong></td><td>'.rtrim($tags, ', ').'</td></tr>';
    $html .= '<tr><td><strong>Service Date:</strong></td><td>'.$setDate.'</td></tr>';
    $html .= '<tr><td><strong>Service Time:</strong></td><td>'.$setTime.'</td></tr>';
    $html .= '<tr><td><strong>Additional Details:</strong></td><td><textarea name="addinfo" id="addinfo" style="color:#000; height:129px; width:100%; resize: none; border: solid thin #c7c7c7; padding:5px">'.stripslashes($add_info).'</textarea></td></tr>';
    $html .= '</table>';
    $html .= '</div>';




    $html .= '<div class="col-md-7">';
    $html .= '<h3 style="font-weight:bold;">Enter Contact Details</h3>';
    $html .= '<div class="row">';
    $html .= '<div class="col-md-4"><label>First Name</label><br><input class="form-control" type="text" name="fname" id="fname" required="" value="'.$fname.'"></div>';
    $html .= '<div class="col-md-4"><label>Last Name</label><br><input class="form-control" type="text" name="lname" id="lname" required="" value="'.$lname.'"></div>';
    $html .= '<div class="col-md-4"><label>Email</label><br><input class="form-control" type="email" name="email" id="email" required="" value="'.$email.'"></div>';
    $html .= '<div class="clearfix"></div>';
    $html .= '<div class="col-md-3"><label>Address</label><br><input class="form-control" type="text" name="address" id="address" required="" value="'.$address.'"></div>';
    $html .= '<div class="col-md-3"><label>City</label><br><input class="form-control" type="text" name="city" id="city"  required="" value="'.$city.'"></div>';
    $html .= '<div class="col-md-3"><label>State</label><br><select class="form-control" id="state" name="state"><option value="">Select State</option> ';

    $us_state_abbrevs_names = array(
        'AL'=>'ALABAMA',
        'AK'=>'ALASKA',
        'AZ'=>'ARIZONA',
        'AR'=>'ARKANSAS',
        'CA'=>'CALIFORNIA',
        'CO'=>'COLORADO',
        'CT'=>'CONNECTICUT',
        'DE'=>'DELAWARE',
        'DC'=>'DISTRICT OF COLUMBIA',
        'FL'=>'FLORIDA',
        'GA'=>'GEORGIA',
        'HI'=>'HAWAII',
        'ID'=>'IDAHO',
        'IL'=>'ILLINOIS',
        'IN'=>'INDIANA',
        'IA'=>'IOWA',
        'KS'=>'KANSAS',
        'KY'=>'KENTUCKY',
        'LA'=>'LOUISIANA',
        'ME'=>'MAINE',
        'MD'=>'MARYLAND',
        'MA'=>'MASSACHUSETTS',
        'MI'=>'MICHIGAN',
        'MN'=>'MINNESOTA',
        'MS'=>'MISSISSIPPI',
        'MO'=>'MISSOURI',
        'MT'=>'MONTANA',
        'NE'=>'NEBRASKA',
        'NV'=>'NEVADA',
        'NH'=>'NEW HAMPSHIRE',
        'NJ'=>'NEW JERSEY',
        'NM'=>'NEW MEXICO',
        'NY'=>'NEW YORK',
        'NC'=>'NORTH CAROLINA',
        'ND'=>'NORTH DAKOTA',
        'OH'=>'OHIO',
        'OK'=>'OKLAHOMA',
        'OR'=>'OREGON',
        'PA'=>'PENNSYLVANIA',
        'RI'=>'RHODE ISLAND',
        'SC'=>'SOUTH CAROLINA',
        'SD'=>'SOUTH DAKOTA',
        'TN'=>'TENNESSEE',
        'TX'=>'TEXAS',
        'UT'=>'UTAH',
        'VT'=>'VERMONT',
        'VI'=>'VIRGIN ISLANDS',
        'VA'=>'VIRGINIA',
        'WA'=>'WASHINGTON',
        'WV'=>'WEST VIRGINIA',
        'WI'=>'WISCONSIN',
        'WY'=>'WYOMING',
    );

    foreach($us_state_abbrevs_names as $key => $val){
        if($state == $key){
            $html .= '<option value="'.$key.'" selected="selected">'.$val.'</option>';
        }else{
            $html .= '<option value="'.$key.'">'.$val.'</option>';
        }

    }

    $html .= '</select></div>';

    $html .= '<div class="col-md-2"><label>Zip</label><br><input class="form-control" type="text" name="zip" id="zip"  required="" value="'.$zip.'"></div>';
    $html .= '<div class="clearfix"></div>';
    $html .= '<div class="col-md-4"><label>Phone</label><br><input class="form-control" type="text" name="phone" id="phone" required="" value="'.$phone.'"></div>';
    $html .= '<div class="clearfix"></div>';
    $html .= '<hr>';
    $html .= '<div class="col-md-4"><label>Equipment Make</label><br><input class="form-control" type="text" name="car_make" id="car_make" required="" value="'.$car_make.'"></div>';
    $html .= '<div class="col-md-4"><label>Equipment Model</label><br><input class="form-control" type="text" name="car_model" id="car_model"  required="" value="'.$car_model.'"></div>';
    $html .= '<div class="col-md-4"><label>Equipment Year</label><br><input class="form-control" type="text" name="car_year" id="car_year"  required="" value="'.$car_year.'"></div>';
    $html .= '</div>';
    $html .= '<div class="clearfix"></div>';
    $html .= '<input type="hidden" name="sched_session" id="sched_session" value="'.$session.'">';
    $html .= '<div class="clearfix"></div>';
    $html .= '<br><br>';
    $html .= '<button style="float:left;" class="btn btn-primary" type="button" onclick="goStepOne()"><i class="fa fa-angle-left" aria-hidden="true"></i> GO BACK</button>';
    $html .= '<button style="float:right;" class="btn btn-primary">REVIEW & SUBMIT <i class="fa fa-angle-right" aria-hidden="true"></i></button>';
    $html .= '<div class="clearfix"></div>';
    $html .= '<br><br>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</form>';

    echo $html;
}

if($_REQUEST["step_three"] == 'true'){
    include('../../../inc/config.php');
    $fname = $data->real_escape_string($_POST["fname"]);
    $lname = $data->real_escape_string($_POST["lname"]);
    $email = $data->real_escape_string($_POST["email"]);
    $address = $data->real_escape_string($_POST["address"]);
    $city = $data->real_escape_string($_POST["city"]);
    $state = $data->real_escape_string($_POST["state"]);
    $zip = $data->real_escape_string($_POST["zip"]);
    $phone = $data->real_escape_string($_POST["phone"]);
    $car_make = $data->real_escape_string($_POST["car_make"]);
    $car_model = $data->real_escape_string($_POST["car_model"]);
    $car_year = $data->real_escape_string($_POST["car_year"]);
    $addinfo = $data->real_escape_string($_POST["addinfo"]);
    $session = $_POST["sched_session"];


    $data->query("UPDATE service_sched SET add_info = '$addinfo', fname = '$fname', lname = '$lname', email = '$email', address = '$address', city = '$city', state = '$state', zip = '$zip', phone = '$phone', car_make = '$car_make', car_model = '$car_model', car_year = '$car_year' WHERE session_data = '$session'")or die($data->error);


    $html .= '<h2>REVIEW SERVICE SCHEDULE</h2><hr>';

    $html .= '<div class="container">
        <div class="row" style="text-align: center">
            <ul class="breadcrumb hidden-sm hidden-xs">
                <li class=""><a href="javascript:void(0);">Select Services & Date</a></li>
                <li class=""><a href="javascript:void(0);">Enter Contact Details</a></li>
                <li class="active"><a href="javascript:void(0);">Review Details</a></li>
                <li class=""><a href="javascript:void(0);">Finished</a></li>
            </ul>
        </div>
    </div>';

    $a = $data->query("SELECT * FROM service_sched WHERE session_data = '$session'");
    $b = $a->fetch_array();

    $services = json_decode($b["services_needed"],true);

    foreach($services as $keys){
        $tags .= '<span class="label label-default">'.ucwords($keys).'</span>, ';
    }

    $html .= '<div class="row" style="margin: 20px">';
    $html .= '<h3>Service Details</h3>';

    $html .= '<table class="table" style="background: #efefef">';
    $html .= '<tr><td><strong>Full Name:</strong></td><td>'.$fname.' '.$lname.'</td></tr>';
    $html .= '<tr><td><strong>Email:</strong></td><td>'.$email.'</td></tr>';
    $html .= '<tr><td><strong>Your Address:</strong></td><td>'.$address.'<br>'.$city.' '.$state.', '.$zip.'</td></tr>';
    $html .= '<tr><td><strong>Phone Number:</strong></td><td>'.$phone.'</td></tr>';
    $html .= '<tr><td><strong>Car Make:</strong></td><td>'.$car_make.'</td></tr>';
    $html .= '<tr><td><strong>Car Model:</strong></td><td>'.$car_model.'</td></tr>';
    $html .= '<tr><td colspan="2" style="padding: 21px 9px;color: #ce122e;font-size: 20px;"><strong>SELECTED SERVICES</strong></td></tr>';
    $html .= '<tr><td><strong>Selected Services:</strong></td><td>'.rtrim($tags, ', ').'</td></tr>';
    $html .= '<tr><td><strong>Requested Service Date:</strong></td><td>'.$b["service_date"].'</td></tr>';
    $html .= '<tr><td><strong>Requested Service Time:</strong></td><td>'.$b["service_time"].'</td></tr>';
    $html .= '<tr><td><strong>Additional Details:</strong></td><td>'.$b["add_info"].'</td></tr>';
    $html .= '</table>';

    $html .= '<form name="service_finish" id="service_finish" method="post" onsubmit="return false"><input type="hidden" name="session_details" id="session_details" value="'.$session.'">';
    $html .= '<div class="clearfix"></div>';
    $html .= '<br><br>';
    $html .= '<button type="button" style="float:left;" class="btn btn-primary" onclick="stepBackTwo()"><i class="fa fa-angle-left" aria-hidden="true"></i> GO BACK</button>';
    $html .= '<button style="float:right;" class="btn btn-primary">COMPLETE REQUEST <i class="fa fa-angle-right" aria-hidden="true"></i></button>';
    $html .= '<div class="clearfix"></div>';
    $html .= '<br><br>';
    $html .= '</form>';
    $html .= '</div>';

    echo $html;

}

if($_REQUEST["step_four"] == 'true'){
    include('../../../inc/config.php');
    $session = $_POST["session_details"];

    $data->query("UPDATE service_sched SET completed = 'true' WHERE session_data = '$session'");

    $a = $data->query("SELECT * FROM service_sched WHERE session_data = '$session'");
    $b = $a->fetch_array();

    $services = json_decode($b["services_needed"],true);

    foreach($services as $keys){
        $tags .= '<span class="label label-default" style="margin:5px">'.ucwords($keys).'</span>';
    }

    $html .= '<h3>Service Details</h3>';

    if($b["car_make"] != ''){$car_make = $b["car_make"];}else{$car_make = 'Not Specified';}
    if($b["car_make"] != ''){$car_model = $b["car_model"];}else{$car_model = 'Not Specified';}


    $html .= '<table class="table" style="background: #efefef">';
    $html .= '<tr><td><strong>Full Name:</strong></td><td>'.$b["fname"].' '.$b["lname"].'</td></tr>';
    $html .= '<tr><td><strong>Email:</strong></td><td>'.$b["email"].'</td></tr>';
    $html .= '<tr><td><strong>Your Address:</strong></td><td>'.$b["address"].'<br>'.$b["city"].' '.$b["state"].', '.$b["zip"].'</td></tr>';
    $html .= '<tr><td><strong>Phone Number:</strong></td><td>'.$b["phone"].'</td></tr>';
    $html .= '<tr><td><strong>Car Make:</strong></td><td>'.$car_make.'</td></tr>';
    $html .= '<tr><td><strong>Car Model:</strong></td><td>'.$car_model.'</td></tr>';
    $html .= '<tr><td><strong>Car Year:</strong></td><td>'.$b["car_year"].'</td></tr>';
    $html .= '<tr><td colspan="2" style="padding: 21px 9px;color: #ce122e;font-size: 20px;"><strong>SELECTED SERVICES</strong></td></tr>';
    $html .= '<tr><td><strong>Selected Services:</strong></td><td>'.$tags.'</td></tr>';
    $html .= '<tr><td><strong>Service Date:</strong></td><td>'.$b["service_date"].'</td></tr>';
    $html .= '<tr><td><strong>Service Time:</strong></td><td>'.$b["service_time"].'</td></tr>';
    $html .= '<tr><td><strong>Additional Details:</strong></td><td>'.$b["add_info"].'</td></tr>';
    $html .= '</table><br><br>';

    $to = 'jasonc@bealscunningham.com'; // note the comma

// Subject
    $subject = 'GoldKey Service Request';

// Message
    $message .= 'New GoldKey Service Request Below<br><br>';
    $message .= $html;


// To send HTML mail, the Content-type header must be set
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=iso-8859-1';

// Additional headers
    $headers[] = 'To: '.$fname.' '.$lname.' <'.$b["email"].'>';
    $headers[] = 'From: EQHarvest <no-reply@eqharvest.com';

// Mail it
    //mail($to, $subject, $message, implode("\r\n", $headers));

    $html2 .= '
        <div class="row" style="text-align: center">
            <ul class="breadcrumb hidden-sm hidden-xs">
                <li class=""><a href="javascript:void(0);">Select Services & Date</a></li>
                <li class=""><a href="javascript:void(0);">Enter Contact Details</a></li>
                <li class=""><a href="javascript:void(0);">Review Details</a></li>
                <li class="completed"><a href="javascript:void(0);">Finished</a></li>
            </ul>
        </div>';

    $html2 .= '<div class="alert alert-success"><strong>THANK YOU</strong><br><p>We have successfully received your service request.</p><p>We will be in contact with you to confirm.</p></div>';
    $html2 .= '<div>Please print this page for your records.</div><br><br>';
    $html2 .= $html;

    echo '<div style="margin: 20px">';
    echo $html2;
    echo '</div>';

    session_start();
    $_SESSION = array();
    session_destroy();
}



?>

