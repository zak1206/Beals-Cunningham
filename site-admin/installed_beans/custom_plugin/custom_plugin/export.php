<?php
//export.php
if(isset($_POST["export"]))
{
    $connect = mysqli_connect("stellar.caffeinerde.com", "stellar_equip", "BCss1957!@", "admin_stellar");
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=data.csv');
    $output = fopen("php://output", "w");
    fputcsv($output, array('ID', 'Parent Cat', 'Cat One', 'Title', 'Equipment Image', 'Specification', 'MSRP', 'Sales Price', 'Active','Description'));
    $query = "SELECT * from custom_equipment order by id ASC ";
    $result = mysqli_query($connect, $query);
    while($row = mysqli_fetch_assoc($result))
    {
        fputcsv($output, $row);
    }
    fclose($output);
}
?>