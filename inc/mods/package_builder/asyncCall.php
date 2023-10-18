<?php
if (file_exists('../../inc/harness.php')) {
    include('../../inc/harness.php');
} else {
    include('inc/harness.php');
}
echo "hello";
include('processor.php');

$a = new packageCall();
$act = $_REQUEST["action"];

if ($act == 'processpackage') {
    var_dump($_POST);
    echo "hello";
    if (file_exists('../../inc/harness.php')) {
        include('../../inc/harness.php');
    } else {
        include('inc/harness.php');
    }

    if (file_exists('../../inc/siteFunctions.php')) {
        include('../../inc/siteFunctions.php');
    } else {
        include('inc/siteFunctions.php');
    }
    $a = new site();
    // configure

    $to = 'sushp@bealscunningham.com';
    $fromemail = 'dev@bcssdevelop.com';
    $fromName = 'R&S Website';
    $subject = 'Tractor Package Contact Request';
    $fullname = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $zip = $_POST['zip'];
    $comment = $_POST['comment'];
    $cashpayment = $_POST['cashpayment'];
    $onlinepayment = $_POST['onlinepayment'];
    $url = $_POST['package_type'];
    $attachements = $_POST['checkbox'];

    foreach ($attachements as $key) {
        $attachement .= $key . ', ';
    }

    $message = '<html>
                <body>
                    <h2>Tractor Package Request</h2>
                    <hr>
                    <p>Package Interest: <br>' . $url . '</p>
                    <p>Attachements: <br>' . $attachement . '</p>
                    <p>Full Name: <br>' . $fullname . '</p>
                    <p>Email: <br>' . $email . '</p>
                    <p>Phone: <br>' . $phone . '</p>
                    <p>Zip: <br>' . $zip . '</p>
                    <p>Comment: <br>' . $comment . '</p>
                </body>
            </html>';

    $send = $a->mailIt($to, $fromemail, $fromName, $subject, $message, $replyTo = null, $emailName = null);


    echo '<div class="alert alert-success"><strong>Thank You - We have received your message and will get back with you shortly.</strong></div>';


    $data->query("INSERT INTO package_data SET full_name = '" . $data->real_escape_string($fullname) . "', email = '" . $data->real_escape_string($email) . "', phone = '" . $data->real_escape_string($phone) . "', zip = '" . $data->real_escape_string($zip) . "',comment = '" . $data->real_escape_string($comment) . "',package_type = '" . $data->real_escape_string($url) . "',checkbox = '" . json_encode($attachements) . "', recieve_time = '" . time() . "'");
}
