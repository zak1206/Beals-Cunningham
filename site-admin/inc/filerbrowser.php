<?php
if(isset($_REQUEST["browsefiles"])){
    $dir    = '../../img/';
    $files1 = scandir($dir);}
foreach($files1 as $key){
    if($key != '.' && $key != '..'){
        echo '<img style="max-height: 70px" class="img-responsive img-thumbnail" src="../img/'.$key.'" onclick="insertImage(\'../img/'.$key.'\')"/>';
    }
}

?>