<?php
$act = $_REQUEST["action"];

if($act == 'getsmtpdetsOLD'){
    include('caffeine.php');
    $site = new caffeine();
    $userArray = $site->auth();
    $smtpdets = $site->getSmtpDets();

    if($smtpdets["smtp_auth"] != null){
        $smtpsuth = 'checked="checked"';
    }else{
        $smtpsuth = '';
    }
    $html .= '<div class="mail-results" style="background: #efefef; padding: 5px; margin: 3px">Results will appears here...</div>
<form id="test-smtp" name="test-smtp" method="post" action="" onsubmit="return false"> 
<div class="col-md-12" style="padding: 5px"><label>Host</label><br><input class="form-control" type="text" name="mail_host" id="mail_host" value="'.$smtpdets["host"].'" required placeholder="smtp.yourdomain.com"></div>
<div class="clearfix"></div>
<div class="col-md-2" style="padding: 5px"><label>Port</label><br><input class="form-control" type="text" name="mail_port" id="mail_port" value="'.$smtpdets["port"].'" required placeholder="25"></div>
<div class="col-md-10" style="padding: 5px"><label>Username</label><br><input class="form-control" type="text" name="mail_username" id="mail_username" value="'.$smtpdets["user"].'" required placeholder="Username"></div>
<div class="clearfix"></div>
<div class="col-md-12" style="padding: 5px"><label>Password</label><br><input class="form-control" type="password" name="mail_password" id="mail_password" value="'.$smtpdets["password"].'" required></div>
<div class="clearfix"></div>
<div class="col-md-6" style="padding: 5px"><label>From Name</label><br><input class="form-control" type="text" name="mail_from" id="mail_from" value="'.$smtpdets["from_name"].'" required placeholder="From Name"></div>
<div class="col-md-6" style="padding: 5px"><label>From Email Address</label><br><input class="form-control" type="text" name="mail_from_email" id="mail_from_email" value="'.$smtpdets["from_email"].'" required placeholder="From Email Address"></div> 
<div class="clearfix"></div>
<br><br>
<div style="padding: 5px;color: red;font-size: 12px;"><strong style="color: red">NOTICE!</strong> - In order to test smtp sends you must supply a to name and a to email address below</div>
<div class="col-md-6" style="padding: 5px"><label>To Name</label><br><input class="form-control" type="text" name="mail_to" id="mail_to" value=""></div>
<div class="col-md-6" style="padding: 5px"><label>To Email</label><br><input class="form-control" type="text" name="mail_email" id="mail_email" value=""></div>
<div class="clearfix"></div>
<div class="col-md-4" style="padding: 5px"><label>SMTP Auth <input type="checkbox" name="mail_smtp_auth" id="mail_smtp_auth" value="true" '.$smtpsuth.'></label></div>
<div class="col-md-4" style="padding: 5px"><label>Debug <input type="checkbox" name="mail_debug" id="mail_debug" value="true"></label></div>
<div class="clearfix"></div>
<div class="col-md-12" style="padding: 5px">&nbsp; &nbsp;<button type="button" class="btn btn-danger btn-fill pull-right" style="margin: 3px" onclick="saveThesmtp()">Save Settings</button> <button style="margin: 3px" class="btn btn-warning btn-fill pull-right">Test Mail</button></form></div>
<div class="clearfix"></div>';

    echo $html;
}

if($act == 'getsmtpdets'){
    include('caffeine.php');
    $site = new caffeine();
    $dets = $site->getMailSettings();


    $handleDets = json_decode($dets["crm_settings"],true);


    $html .= '<form name="postmarkupdate" id="postmarkupdate" method="post" action="">';
    $html .= '<img src="img/postmark.png" style="max-width: 240px"><br><br>';
    $html .= '<div class="row">';
    $html .= '<div class="col-md-6"><label>Postmark Token</label><br><input class="form-control" type="text" name="postmrktkn" id="postmrktkn" value="'.$dets["postmrk_ids"].'"></div><br>';
    $html .= '</div>';
    $html .= '<br><br>';
    $html .= '<div class="row">';
    $html .= '<div class="col-md-6"><label>System Email Address</label><br><input class="form-control" type="text" name="frm_emladd" id="frm_emladd" value="'.$dets["frm_email"].'"></div><br>';
    $html .= '</div>';
    $html .= '<br><br>';
    $html .= '<div class="row">';
    $html .= '<div class="col-md-3"><label>CRM Settings</label><br>';
    $html .= '<p>Select your CRM system below.</p>';
    $html .= '<select name="crm_sets" id="crm_sets" class="form-control"><option value="">Select CRM</option><option value="handle">Handle</option></select></div><br><br>';
    $html .='</div>';
    $html .= '<div class="clearfix"></div>';
    $html .= '<br><br>';
    $html .= '<div class="row crmsets" style="display: none">';
    $html .= '<div class="col-md-12"><p>Enter your Handle details below.</p></div>';
    $html .= '<div class="col-md-3"><label>Base URL</label><br><input type="text" class="form-control" name="handle_base" id="handle_base" value="'.$handleDets["apisets"]["baseUrl"].'"></div>';
    $html .= '<div class="col-md-3"><label>Username</label><br><input type="text" class="form-control" name="handle_user" id="handle_user" value="'.$handleDets["apisets"]["user"].'"></div>';
    $html .= '<div class="col-md-3"><label>Password</label><br><input type="password" class="form-control" name="handle_pass" id="handle_pass" value="'.$handleDets["apisets"]["pass"].'"></div>';
    $html .= '<div class="col-md-3"><label>&nbsp;</label><br><button type="button" class="btn btn-success crmtest">Test CRM</button></div>';
    $html .= '<div class="row"><div class="col-md-12" style="padding: 20px"><small style="color: #e88a12" class="crmtestmess"></small></div></div>';
    $html .='</div>';


    $html .= '<div class="row">';
    $html .= '<div class="col-md-2">';
    $html .= '<br><br>';
    $html .= '<button class="btn btn-success">Update</button>';
    $html .= '</div>';
    $html .= '</form>';

    echo $html;
}

if($act == 'testsmtp') {
    require 'phpmail/PHPMailerAutoload.php';
    date_default_timezone_set('UTC');

    $mail = new PHPMailer;

//MAY NEED TO BE ENABLED FOR LIVE SERVER $mail->isSMTP();

// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages


    $mail_host = $_POST["mail_host"];
    $mail_port = $_POST["mail_port"];
    $mail_username = $_POST["mail_username"];
    $mail_password = $_POST["mail_password"];
    $mail_from = $_POST["mail_from"];
    $mail_from_email = $_POST["mail_from_email"];
    $mail_to = $_POST["mail_to"];
    $mail_email = $_POST["mail_email"];
    $mail_smtp_auth = $_POST["mail_smtp_auth"];
    $mail_debug = $_POST["mail_debug"];


    $mail->isSMTP();
    if (isset($mail_debug)) {
        $mail->SMTPDebug = 3;

        echo '<pre>';
        var_dump($_POST);
        echo '</pre>';
    }

    if (isset($mail_smtp_auth)) {
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->SMTPAuth = true;
    }


//$mail->SMTPSecure = false;
//$mail->SMTPAutoTLS = false;
    $mail->Debugoutput = 'html';
    $mail->Host = $mail_host;
    $mail->Port = $mail_port;
    $mail->Username = $mail_username;
    $mail->Password = $mail_password; ///SHHHHHH! This is a secrete////
    $mail->setFrom($mail_from_email, $mail_from);

    $mail->addReplyTo($mail_from_email, $mail_from);

    $mail->addAddress($mail_email, $mail_to);


    $mail->Subject = "Test Email Server";
    $mail->msgHTML('This is a email test.');

    if (!$mail->send()) {
        echo "<div class='alert alert-danger'>Mailer Error: " . $mail->ErrorInfo . "</div>";
        return false;
    } else {
        echo "<div class='alert alert-success' style='margin: 0'><strong>Success - Mail has been connected and sent..</strong></div>";
        return true;
    }
}

if($act == 'testcrm'){
    include('caffeine.php');
    $site = new caffeine();
    $res = $site->testCRM($_POST);
    echo $res;
}

if($act == 'savesmtp'){
    include('caffeine.php');
    $site = new caffeine();
    $userArray = $site->auth();
    echo $site->saveSmtpDets($_POST);
    //echo '<div class="alert alert-success" style="margin: 0">Postmark Information has been saved!</div>';
}