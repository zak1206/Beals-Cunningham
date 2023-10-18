<?php
$act = $_REQUEST["action"];


if($act == 'formsubmit'){
    include('config.php');
    include('siteFunctions.php');
    $process = new site();
    $a = $data->query("SELECT * FROM forms_data WHERE form_name = '".$_POST["form_table"]."'");
    $b = $a->fetch_array();



    if(isset($_POST["files_dir"]) && $_FILES['form_files']['name'] != null){
        $valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp' , 'pdf' , 'doc' , 'ppt');
        $fl = $_FILES['form_files']['name'];
        $tmp = $_FILES['form_files']['tmp_name'];
        $ext = strtolower(pathinfo($fl, PATHINFO_EXTENSION));
        $path = '../'.$_POST["files_dir"].$fl;

        if(in_array($ext, $valid_extensions)){
            if(move_uploaded_file($tmp,$path)){
                $link = '<a href="'.$path.'" target="_blank">'.$fl.'</a>';
                //echo 'File uploaded';
                $thsql .= "form_files = '" . $link . "',";
            }else{
                echo '{ "code":"invalid", "message":"It appears you have supplied an invalid file for upload."}';
            }
        }else{
            echo '{ "code":"invalid", "message":"It appears you have supplied an invalid file for upload."}';
            die();
        }

        }

    if($b["subject"] != null){
        $subject = $b["subject"];
    }else{
        $subject = 'System Message';
    }

    if($b["recipients"] != null){
        //EMAIL IT//
        $rec = explode(',',$b["recipients"]);
        foreach($rec as $anemail){
            if($anemail != null) {
                $to[] = array("email" => $anemail, "name" => "System Collector");
            }
        }
        $fromemail = "system@bcssdevelopment.com";
        $fromName = "Website Request";
        $subject = $subject;


        $message .= '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><html lang="en"><head> <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> <meta name="viewport" content="width=device-width, initial-scale=1"> <meta http-equiv="X-UA-Compatible" content="IE=edge"> <title></title> <style type="text/css"> </style> </head><body style="margin:0; padding:0;">';
        $message .= '<div style="padding: 20px"><h2>'.$subject.'</h2></div>';
        $message .= '<div style="padding: 20px"><table width="50%" border="0" cellpadding="0" cellspacing="0">';
        foreach($_POST as $postkey=>$val){
            if($postkey != 'form_table') {
                if(is_array($val)){
                    foreach($val as $opt){
                        $outOp .= $opt.', ';
                    }
                    $message .= '<tr><td style="padding: 5px; background: #efefef; border-bottom:solid thin #a3a3a3" align="left"><strong>' . ucwords(str_replace('_',' ',$postkey)) . ': </strong></td><td style="padding: 5px; border-bottom:solid thin #a3a3a3"  align="left">' . $outOp . '</td></tr>';
                }else{
                    $message .= '<tr><td style="padding: 5px; background: #efefef; border-bottom:solid thin #a3a3a3" align="left"><strong>' . ucwords(str_replace('_',' ',$postkey)) . ': </strong></td><td style="padding: 5px; border-bottom:solid thin #a3a3a3"  align="left">' . $val . '</td></tr>';
                }

            }
        }
        $message .='</table></div>';
        $message .= '</body></html>';



        $process->mailIt($to,$fromemail,$fromName,$subject,$message);


    }

    ///STORE IN DB//
    foreach($_POST as $postkey=>$val){
        if($postkey != 'form_table' && $postkey != 'button') {
            if($postkey != 'files_dir') {
                if(is_array($val)){
                    $obz = json_encode($val);
                    $thsql .= "$postkey = '" . $data->real_escape_string($obz) . "',";
                }else{
                    $thsql .= "$postkey = '" . $data->real_escape_string($val) . "',";
                }

            }
        }
    }

    $thsql = rtrim($thsql,',');
    $table = $_POST["form_table"];

    //var_dump($_POST);

    $data->query("INSERT INTO $table SET $thsql, receive_date = '".time()."'")or die($data->error);

    if($b["success_mess"] != null){
        $succMess = $b["success_mess"];
    }else{
        $succMess = 'We have received your message and will get back with you shortly.';
    }

    echo '{ "code":"good", "message":"'.$data->real_escape_string($succMess).'"}';
    die();
}

if($act == 'loginfront'){
    include('config.php');
    $front_email = $_POST["front_email"];
    $front_password = $_POST["front_password"];


    $a = $data->query("SELECT * FROM caffeine_users WHERE email = '$front_email' AND passcode = '".md5($front_password)."'")or die('ERROR');

    if($a->num_rows > 0){
        $b = $a->fetch_array();
        //check permissions///

        $c = $data->query("SELECT * FROM permissions WHERE id = '".$b["access_level"]."'")or die('ERROR');

        if($c->num_rows > 0){
            $d = $c->fetch_array();
            $thepersmissions = json_decode($d["permissions"],true);

            if(in_array('End_Users',$thepersmissions)){
                session_start();
                $thissess = md5(date('dYms').$front_email);
                $_SESSION["front_user"] = $thissess;
                $data->query("UPDATE caffeine_users SET usr_session = '$thissess', last_login = '".time()."' WHERE email = '$front_email' AND passcode = '".md5($front_password)."'");
                echo '{ "code":"good", "message":"You do have permission."}';
            }else{
                echo '{ "code":"bad", "message":"You do not have permission to access this page.'.$thepersmissions.'"}';
            }
        }else{
           echo '{ "code":"bad", "message":"You do not have permission to access this page.'.$thepersmissions.'"}';
        }
    }else{
        echo '{ "code":"bad", "message":"Login information incorrect.<br>Please try again.'.$thepersmissions.'"}';
    }



    die();
}
