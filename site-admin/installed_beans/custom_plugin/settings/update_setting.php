<?php

include('../../../inc/harness.php');

$column_to_update = $_POST['column'];
$current_value = $_POST['value'];

if ($current_value == 'true') {
    $current_value = 0;
} else if ($current_value == 'false') {
    $current_value = 1;
}

$query = "UPDATE custom_equipment_shop_settings SET '" . $column_to_update . "' = '" . $current_value . "' WHERE id = 1";
$a = $data->query($query);
$b = $a->fetch_array();

if ($a) {
    echo "Success";
} else {
    echo "Failure";
}
