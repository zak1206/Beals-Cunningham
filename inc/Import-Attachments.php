<?php
include ('config.php');
ini_set('error_reporting', E_ALL);

// Read the data
$handle = fopen("frontier-import.csv", "r");


$i=0;


while (($info = fgetcsv($handle, 1000, ',')))
{



    if($i == 0)
    {
        $i++;
        continue;
    }

    //$query = 'INSERT INTO attachment_data SET category = "'.$data[0].'", name = "'.$data[1].'", price = "'.trim($data[2]).'", dealer_price = "'.trim($data[3]).'", code = "'.$data[1].'", type = "implement", active ="true"';

    $cat = $info[0];
    $name = $info[1];
    $price = trim($info[2]);
   // $dealerprice = trim($info[3]);

//    echo $query.'<br>';
    $data->query("INSERT INTO attachment_data SET category = '$cat', name = '$name', price = '$price', code = '$name', type = 'implement', active = 'true', updated = '" . time() . "'");

    if ($data == false)
    {
        echo 'Error description';
    } else {
        echo 'Inserted';
    }
}






?>