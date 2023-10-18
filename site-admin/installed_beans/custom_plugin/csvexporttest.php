<?php
include('../../inc/harness.php');
$result = $data->query("SELECT * FROM custom_equipment WHERE active = 'true'");
if (!$result) die('Couldn\'t fetch records');
$result2 = $data->query("SELECT * FROM custom_equipment WHERE active = 'true'");
$post = $result2->fetch_assoc();


foreach($post as $title => $value){
    $fields[] = $title;
}
$fp = fopen('php://output', 'w');
if ($fp && $result) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="products.csv"');
    header('Pragma: no-cache');
    header('Expires: 0');
    fputcsv($fp, $fields);

    while ($row = $result->fetch_row()) {
        fputcsv($fp, array_values($row));
    }
    die;
}