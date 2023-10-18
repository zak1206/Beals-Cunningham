<?php
include('inc/caffeine.php');
include('inc/harness.php');
$site = new caffeine();
$act = $_REQUEST["action"];

$authCredentails = $site->auth();
$userEdited = $authCredentails["profileId"];
$a = $data->query("SELECT fname FROM caffeine_users WHERE id = '$userEdited'");
if ($a->num_rows > 0) {
 $b = $a->fetch_array();
}

function updateCheckboxData($table, $checkboxVal, $id){
 include('inc/harness.php');
 
 global $b;
 
 date_default_timezone_set('America/Chicago');
 $data->query("UPDATE ".$table." SET checked = '".$checkboxVal."', completedBy = '".$b['fname']."', checkedOutOn = '".date("Y-m-d h:i:sa")."' WHERE id = $id");
}

if($act == 'getRowVal'){
 $row_id=$_REQUEST["row_id"];
 $table_name=$_REQUEST["table_name"];

 $checkboxValueArr = $data->query("SELECT checked FROM ".$table_name." WHERE id = '$row_id'");
 if ($checkboxValueArr->num_rows > 0) {
  $checkboxValue = $checkboxValueArr->fetch_array();
 }
 if($checkboxValue['checked'] == "true"){
  $newCheckboxVal = "false";
 }else{
  $newCheckboxVal = "true";
 }
 updateCheckboxData($table_name, $newCheckboxVal, $row_id);

}

if($act == 'userWorking'){
 $row_id=$_REQUEST["row_id"];
 $table1=$_REQUEST["table_name"];
 $userWorkingOn = $_REQUEST["userName"];

 // echo $table_name;
 $data->query("UPDATE ".$table1." SET workingOnIt = '".$userWorkingOn."' WHERE id = $row_id");
 echo $userWorkingOn;
}
?>