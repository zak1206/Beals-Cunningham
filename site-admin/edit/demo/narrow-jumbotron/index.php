<?php include('../header.php'); ?>
<style>
    /* DONT REMOVE THE BELOW CSS CODE. IT GIVES THE BODY EDIT AREA SOME PRESENTS */
    body{
        border:dashed thin red;
        padding: 10px;
    }
</style>
<?php
include('../../../inc/harness.php');
$page = $_REQUEST["page"];
$a = $data->query("SELECT * FROM pages WHERE id = '$page'")or die($data->error);
$b = $a->fetch_array();

if($b["content_edit"] != ''){
    echo $b["content_edit"];
}else{
    echo '<div class="">Put objects here.</div>';
}
?>
  </body>
</html>