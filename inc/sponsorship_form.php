<?php
include("config.php");
if(isset($_POST["Company_Name"])){
    $message .= '<table>';
    $post = $_POST;

    $message .= '<h2>Sponsorship Request</h2><br>';
    
    foreach($post as $key=>$val){

        $setchange = str_replace('_',' ',$key);
        $setchange = ucwords($setchange);

        if(is_array($val)){
            $message .= '<tr><td><strong>'.$setchange.': </strong></td><td>';
            foreach($val as $key2){
                $message .= $key2.',';
            }
            $message .= '</td></tr>';
        }else{
            $message .= '<tr><td><strong>'.$setchange.': </strong></td><td>'.$val.'</td></tr>';
        }

    }



    if(!empty($_FILES['tax_docs']['tmp_name'][0]) or !empty($_FILES['tax_docs']['tmp_name'][1]) or !empty($_FILES['tax_docs']['tmp_name'][2]) or !empty($_FILES['tax_docs']['tmp_name'][3]) or !empty($_FILES['tax_docs']['tmp_name'][4])){
        $message .= '<tr><td colspan="2"><strong>Attached Tax Files Below</strong></td></tr>';


        //$message .= 'Should be starting process....';

        $total = count($_FILES['tax_docs']['name']);

       // echo "THIS IS THE COUNT". $total;


        if ($total > 0) {
            // Loop through each file
            for ($i = 0; $i < $total; $i++) {
                //Get the temp file path
                $tmpFilePath = $_FILES['tax_docs']['tmp_name'][$i];

                $explods = explode('.', $_FILES['tax_docs']['name'][$i]);
                $oldName = $explods[0];
                $ext = $explods[1];

                if ($ext == 'doc' || $ext == 'docx' || $ext == 'pdf' || $ext == 'PDF') {
                    $error = '';
                } else {
                    $error = 'true';
                }

                //$message .= 'THIS '. $_FILES['tax_docs']['name'][$i];

                //Make sure we have a filepath
                if ($tmpFilePath != "" && $error != 'true') {
                    //$message .= 'Not empty and no errors...';
                    //Setup our new file path
                    $newFilePath = "sponsor_docs/" . $oldName . '_' . date('Ymds') . '.' . $ext;

                    //Upload the file into the temp dir
                    if (move_uploaded_file($tmpFilePath, $newFilePath)) {

                        //Handle other code here
                        // $message .= $newFilePath. ' Successfully Uploaded..';
                        $message .= '<tr><td colspan="2"><a href="http://blanchardequipment.com/' . $newFilePath . '">Download Tax File</a></td></tr>';

                    } else {
                        $fileerror .= 'Tax File(s) not uploaded... Please contact us for further information..';
                        $systemerror = true;
                       // echo 'error 1-2';
                    }
                } else {
                    $fileerror .= 'Non supported file(s) selected for upload on tax documents. Please only upload <strong>pdf, doc, docx</strong><br>';
                    $systemerror = true;
                    //echo 'error 1-3';
                }
            }
        } else {
            //$message .= 'No Files To Upload..';
        }
    }

    if(!empty($_FILES['documents']['tmp_name'][0]) or !empty($_FILES['documents']['tmp_name'][1]) or !empty($_FILES['documents']['tmp_name'][2]) or !empty($_FILES['documents']['tmp_name'][3]) or !empty($_FILES['documents']['tmp_name'][4])){
        $message .= '<tr><td colspan="2"><strong>Supported Files Below</strong></td></tr>';


       // $message .= 'Should be starting process....';

        $total2 = count($_FILES['documents']['name']);
        // Loop through each file
        for($j=0; $j<$total2; $j++) {
            //Get the temp file path
            $tmpFilePath2 = $_FILES['documents']['tmp_name'][$j];

            $explods2 = explode('.',$_FILES['documents']['name'][$j]);
            $oldName2 = $explods2[0];
            $ext2 = $explods2[1];

            if($ext2 == 'doc' || $ext2 == 'docx' || $ext2 == 'pdf' || $ext2 == 'PDF'){$error2 = '';}else{$error2 = 'true';}

            //$message .= 'THIS '. $_FILES['documents']['name'][$j];

            //Make sure we have a filepath
            if ($tmpFilePath2 != "" && $error2 != 'true'){
                $message .= 'Not empty and no errors...';
                //Setup our new file path
                $newFilePath2 = "sponsor_docs/" . $oldName2.'_'.date('Ymds').'.'.$ext2;

                //Upload the file into the temp dir
                if(move_uploaded_file($tmpFilePath2, $newFilePath2)) {

                    //Handle other code here
                    //$message .= $newFilePath2. ' Successfully Uploaded..';
                    $message .= '<tr><td colspan="2"><a href="http://blanchardequipment.com/'.$newFilePath2.'">Download Supporting File</a></td></tr>';

                }else{
                    $file2error .= 'Support File(s) not uploaded... Please contact us for further information..';
                    $systemerror = true;
                   // echo 'error 1-4';
                }
            }else{
                $file2error .= 'Non supported file(s) selected for upload on support documents. Please only upload <strong>pdf, doc, docx</strong><br>';
                $systemerror = true;
                //echo 'error 1-5';
            }
        }
    }else{
        //$message .= 'No Files To Upload..';
    }



    $message .= '</table>';
    echo $message;
    

    if($systemerror != true){
        ///mail here//
        //echo $message;
        include('siteFunctions.php')or die('sdfsdf');
        $to[] = array('email'=>'augusta@blanchardequipment.com','name'=>'Blanchard Equipment');
        $a = new site();
        $mail = $a->mailIt($to,'contact@blanchardequipment.com','blanchard equipment','Blanchard Equipment Sponsorship', $message);

        $successSent = '<div class="alert alert-success"><strong>Thank You</strong> - We have received your request for sponsorship and will be getting in touch with you A.S.A.P.</div>';

    }else{
        echo '<div class="alert alert-danger">ERROR! - '.$fileerror.' '.$file2error.'</div>';
    }
    
    

}

$name = $_POST["Company_Name"];
$phone = $_POST["phone"];
$address = $_POST["address"];
$city = $_POST["city"];
$state = $_POST["state"];
$zip = $_POST["zip"];
$email = $_POST["email"];
$data->query("INSERT INTO sponsorship_form SET name = '".$data->real_escape_string($name)."', phone = '".$data->real_escape_string($phone)."', address = '".$data->real_escape_string($address)."', city = '".$data->real_escape_string($city)."', state = '".$data->real_escape_string($state)."', zip = '".$data->real_escape_string($zip)."', email = '".$data->real_escape_string($email)."'") or die("error");


?>

<?php if(isset($successSent)){
    echo $successSent;
}else{ ?>


<form id="sponsorship_program" name="sponsorship_program" method="post" action="" enctype="multipart/form-data">
    <label class="top_label" style="font-size:20px">Name of Company/Individual Requesting: </label><br>
    <input type="text" class="form-control" id="Company_Name" name="Company_Name" value="<?php echo $_POST["Company_Name"]; ?>" required><br>
    <h3>Contact Details</h3>
    <label class="top_label" style="font-size:20px">Phone Number: </label><br>
    <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $_POST["phone"]; ?>" required><br>
    <div class="col-md-4" style="padding-left:0"><label class="top_label" style="font-size:20px">Address: </label><br>
    <input type="text" class="form-control" id="address" name="address" value="<?php echo $_POST["address"]; ?>" required>
    </div>
    <div class="col-md-3"><label class="top_label" style="font-size:20px">City: </label><br>
    <input type="text" class="form-control" id="city" name="city" value="<?php echo $_POST["city"]; ?>" required>
    </div>
    <div class="col-md-3"><label class="top_label" style="font-size:20px">State: </label><br>
    <input type="text" class="form-control" id="state" name="state" value="<?php echo $_POST["state"]; ?>" required>
    </div>
    <div class="col-md-2"><label class="top_label" style="font-size:20px">Zip: </label><br>
    <input type="text" class="form-control" id="zip" name="zip" value="<?php echo $_POST["zip"]; ?>" maxlength="5" required>
    </div>
    <div class="clearfix"></div>
    <label class="top_label" style="font-size:20px">Email Address: </label><br>
    <input type="email" class="form-control" id="email" name="email" value="<?php echo $_POST["email"]; ?>" required><br>
    <label class="top_label" style="font-size:20px">Are you a non-profit organization? : </label><br>
    <?php if(isset($_POST["non_profit"]) && $_POST["non_profit"] == 'Yes') {
        $nonprofitYes = 'checked="checked"';
    }else{
        $nonprofitYes = '';
    }

     if(isset($_POST["non_profit"]) && $_POST["non_profit"] == 'No') {
        $nonprofitNo = 'checked="checked"';
    }else{
        $nonprofitNo = '';
    }
?>
    <label class="sponsor_tax" style="padding:5px" data-val="Yes">Yes <input type="radio" class=""  name="non_profit" value="Yes" <?php echo $nonprofitYes; ?>></label>
    <label class="sponsor_tax" style="padding:5px" data-val="No">No <input type="radio" class=""  name="non_profit" value="No" <?php echo $nonprofit; ?>></label>
    <br>

    <?php if($nonprofitYes == 'checked="checked"'){$disyes = 'block';}else{$disyes = 'none';} ?>
    
    <div class="tax_documents" style="display:<?php echo $disyes; ?>">
        <div class="tax_alert"><?php echo $fileerror; ?></div>
        <small>If so, please provide proof that you are a recognized 501 (c) (3) exempt organization for tax purposes. Please attach supporting documents proving your 501 (c) (3) status.<br><strong>Allowed document types - pdf, doc, docx</strong></small><br>
        <input type="file" name="tax_docs[]" id="tax_docs" multiple>
    </div>
    
    <br><br>
    <label class="top_label" style="font-size:20px">Reason For Request</label><br>

    <?php
        if(isset($_POST["Reason_For_Request"])){
            if($_POST["Reason_For_Request"] == 'Event'){$eventset = 'checked="checked"';}else{$eventset = '';}
            if($_POST["Meeting"] == 'Event'){$meetingset = 'checked="checked"';}else{$meetingset = '';}
            if($_POST["Meeting"] == 'School Advertisement'){$schoolset = 'checked="checked"';}else{$schoolset = '';}
            if($_POST["Meeting"] == 'Other'){$other = 'checked="checked"';}else{$other = '';}
        }
    ?>

    <label style="padding:3px">Event <input type="radio" class=""  name="Reason_For_Request" value="Event" <?php echo $eventset; ?>></label>
    <label style="padding:3px">Meeting <input type="radio" class=""  name="Reason_For_Request" value="Meeting" <?php echo $meetingset; ?>></label>
    <label style="padding:3px">School Advertisement <input type="radio" class=""  name="Reason_For_Request" value="School Advertisement" <?php echo $schoolset; ?>></label>
    <label style="padding:3px">Other <input type="radio" class=""  name="Reason_For_Request" value="Other" <?php echo $other; ?>></label>
    
    <br>
    <br>
    <label>Please list any additional requests such as event participation, auction item donation, etc.</label><br>
    <textarea class="form-control" id="additional_requests" name="additional_requests" required><?php echo $_POST["additional_requests"]; ?></textarea><br>
    <label style="font-size:20px">Check any of the items below that will need to be included with the donation/sponsorship. </label><br>
    <label style="padding:3px">Media Advertising <input type="checkbox" class="" name="included_donation_items[]" value="Media Advertising" <?php if(isset($_POST["included_donation_items"]) && $_POST["included_donation_items"] == 'Media Advertising'){echo 'checked="checked"';} ?>></label>
    <label style="padding:3px">Other Advertising <input type="checkbox" class="" name="included_donation_items[]" value="Other Advertising" <?php if(isset($_POST["included_donation_items"]) && $_POST["included_donation_items"] == 'Other Advertising'){echo 'checked="checked"';} ?>></label>
    <label style="padding:3px">Event Advertising/Participation <input type="checkbox" class=""  name="included_donation_items[]" value="Event Advertising/Participation" <?php if(isset($_POST["included_donation_items"]) && $_POST["included_donation_items"] == 'Event Advertising/Participation'){echo 'checked="checked"';} ?>></label>
    <br><br>
    <label class="top_label" style="font-size:20px">If you checked Media Advertising, Other Advertising, or Event Advertising/Participation above, please provide details below. Event Date</label>
    <input type="text" class="form-control" name="event_date" id="event_date" value="<?php echo $_POST["event_date"]; ?>" placeholder="00/00/0000"><br>
    <label class="top_label" style="font-size:20px">Event Location</label><br>
    <textarea class="form-control" id="event_location" name="event_location"><?php echo $_POST["event_location"]; ?></textarea><br>
    <label class="top_label" style="font-size:20px">Upload any additional supporting documents you would like to include with your request.</label><br>
    <div class="supporting_alert"><?php echo $file2error; ?></div>
    <input type="file" name="documents[]" id="documents" multiple><br><br>
    <button class="btn btn-success">Submit</button>
    
</form>

<?php } ?>