<?php
include('inc/config.php');
$savedPromos = json_decode($_SESSION["prmotrack"],true);
for($i=0; $i<count($savedPromos); $i++){
    $eqTitle = $savedPromos[$i]["equip"];

    ///DEERE PROMOS HERE//
    $a = $data->query("SELECT extra_content FROM deere_equipment WHERE title = '$eqTitle'")or die($data->error);
    $b = $a->fetch_array();

    $returnSlide .= '<div>'.str_replace('../../../','', $b["extra_content"]).'</div>';
}
?>