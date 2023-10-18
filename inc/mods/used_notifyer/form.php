<?php
include('inc/config.php');
    if($_POST != null){
        $emai = $_POST["notice_email"];
        $a = $data->query("SELECT email FROM used_equipment_notifications WHERE email = '$emai'");
        if($a->num_rows == 0){
            $fname = $data->real_escape_string($_POST["notice_fname"]);
            $lname = $data->real_escape_string($_POST["notice_lname"]);
            $email = $data->real_escape_string($_POST["notice_email"]);
            $equipment = json_encode($_POST["selcats"]);
            $data->query("INSERT INTO used_equipment_notifications SET fname = '$fname', lname = '$lname', email = '$email', equipments = '$equipment', lastsentdate = '".time()."'") or die($data->error);

            $error = false;
            $issub = true;
        }else{
            $error = true;
            $message = '<div class="alert alert-warning"><strong>Whoops!</strong><br><p>It appears you have already signed up to receive notifications.<br>If you are not receiving any notifications please check your spam folders or contact us for further details.</p></div>';
            $issub = false;
        }

    }else{
        $error = false;
        $message = '';
        $issub = false;
    }
?>

<?php if($issub == true && $error == false){ ?>
    <div class="alert alert-success"><strong>Thank You!</strong><br><p>We have received your request to be notified for used equipment that is added daily.</p></div>
<?php }else{ ?>

    <?php echo $message; ?>
<form name="used_request_notify" id="used_request_notify" method="post" action="">
    <div class="row">
        <div class="col-md-12">
            <h2>Used Equipment Notification</h2>
            <small>Sign up for our Used Equipment notifications and get notified when we get more units.</small>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-4"><label><b>First Name</b></label><br><input class="form-control" type="text" name="notice_fname" id="notice_fname"></div>
        <div class="col-md-4"><label><b>Last Name</b></label><br><input class="form-control" type="text" name="notice_lname" id="notice_lname"></div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6"><label><b>Email</b></label><br><input class="form-control" type="text" name="notice_email" id="notice_email"></div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <label><b>Select Equipment Categories</b></label><br>
            <div class="jumbotron">
                <div class="row">
                <?php
                    $a = $data->query("SELECT category FROM used_equipment WHERE active = 'true' GROUP BY category ORDER BY category ASC");
                    while($b = $a->fetch_array()){
                        if($b["category"] != null) {
                            echo '<label class="col-md-3 col-sm-5"><input type="checkbox" name="selcats[]" id="selcats[]" value="' . $b["category"] . '"> ' . $b["category"] . '</label>';
                        }
                    }
                ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row"><div class="col-md-12"><button class="btn btn-primary">Submit</button></div></div>
</form>

<?php } ?>
