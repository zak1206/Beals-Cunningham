<?php

include('caffeine.php');
$site = new caffeine();
$site->auth();

$output_dir = "../../uploads/";

if(isset($_FILES["filestoupload"]))
{
    //Filter the file types , if you want.
    if ($_FILES["filestoupload"]["error"] > 0)
    {
        echo "Error: " . $_FILES["file"]["error"] . "<br>";
    }
    else
    {
        //move the uploaded file to uploads folder;
        move_uploaded_file($_FILES["filestoupload"]["tmp_name"],$output_dir. $_FILES["filestoupload"]["name"]);
        echo "Uploaded File :".$_FILES["filestoupload"]["name"];
        $site->insertUploads($_FILES["filestoupload"]["name"]);
    }

}
?>