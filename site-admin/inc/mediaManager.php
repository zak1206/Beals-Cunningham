<?php
error_reporting(0);
function formatSizeUnits($bytes)
{
    if ($bytes >= 1073741824)
    {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    }
    elseif ($bytes >= 1048576)
    {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    }
    elseif ($bytes >= 1024)
    {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    }
    elseif ($bytes > 1)
    {
        $bytes = $bytes . ' bytes';
    }
    elseif ($bytes == 1)
    {
        $bytes = $bytes . ' byte';
    }
    else
    {
        $bytes = '0 bytes';
    }

    return $bytes;

}
if($_REQUEST["dirset"] != ''){
    $dirIn = $_REQUEST["dirset"].'/';
}else{
    $dirIn = "../../img/";
}


if($_REQUEST["intset"] == true) {

    $html .= '<div id="mediaselect" style="width: 798px; height:450px; background: #fff; position: fixed; margin-left:-399px; top:16%; left:50%; z-index: 65537;">';
    $html .= '<input type="hidden" id="img-links" name="img-links" value="">';
    $files = scandir($dirIn, 1);
    foreach ($files as $key) {
        if ($key != '.' && $key != '.DS_Store') {
            $imgout[] = array('thumb' => $key);
        }
    }

    $diEx = explode('/', $dirIn);
    $basCh = str_replace('../../', '', $dirIn);
    $basCh = trim($basCh, '/');
    $current = substr(strrchr($basCh, "/"), 1);
//$html .= "this is ".$current;





    asort($imgout);
    if ($dirIn == '../../img/') {
        $html .= '
    <div id="progress" class="progress" style="height: 3px; margin-bottom: 0">
        <div class="progress-bar progress-bar-success" style="background: #FF7AC4"></div>
    </div>
    <!-- The container for the uploaded files -->
    <div id="files" class="files" style="display: none"></div>';

        $html .= '<div style="padding: 10px; background: #52c8ff; height:93px">

<span class="fileinput-button" style="color: #fff; font-size: 20px;padding:25px">
        <i class="fa fa-upload" aria-hidden="true"></i>
        <span>Upload Files...</span>
        <!-- The file input field used as target for the file upload widget -->
        <input id="fileupload" type="file" name="files[]" multiple>
    </span>

<span style="display: block;padding: 10px; float: right;"><small style="position: absolute; right: 9px; top: 7px; cursor: pointer" onclick="closeBrowser()"><i class="fa fa-times" aria-hidden="true"></i> close</small><br><a href="javascript:openDirCr()"><i class="fa fa-folder-open" aria-hidden="true"></i> Create Directory</a></span>
<div style="clear: both"></div>

</div>';
        $html .= '<div class="bubble" style="padding: 10px; position: absolute; left: 48%; top:24px; background: #fff; display: none"><input type="text" name="dircname" id="dircname" value="" placeholder="Name of Directory"> <button onclick="createDir()">Create</button></div>';
    }

    $html .= '<div id="medholds" style="overflow-y: scroll; height: 350px;">';

    $html .= '<ol class="breadcrumb" style="margin-bottom: 5px; border-radius: 0px;">';
    $previousValue = null;
    foreach ($diEx as $key) {
       // echo $key;
        if ($previousValue) {
            $previousValue = ltrim($previousValue,'/');
            $html .= '<li><a href="javascript:moveToFile(\''. $previousValue . '/' . $key . '\')">' . $key . '</a></li>';
        }
        $previousValue = $previousValue . '/' . $key;
    }
    $html .= '</ol>';

    foreach ($imgout as $key) {
        $filesize = formatSizeUnits(filesize($dirIn . $key["thumb"]));
        ///$html .= '<tr style="font-size: 12px"><td>'.$key["thumb"].'</td><td>'.$filesize.'</td><td>Type</td><td>Modification</td></tr>';
        if (filetype($dirIn . $key["thumb"]) == 'dir' && $key["thumb"] != '..') {
            $dirLink = 'img/' . $key["thumb"] .
                $html .= '<div class="col-md-2" style="background: #F7E2A2; background-image: url(\'../img/' . $key["thumb"] . '\'); background-size:cover; height:90px; padding: 5px; border: solid thick #fff; overflow: hidden; cursor:pointer" onClick="moveToFile(\'' . $dirIn . $key["thumb"] . '\')"><span style="padding:2px; background:#fff; font-size:10px">' . $key["thumb"] . '</span></div>';
        }
    }

    foreach ($imgout as $key) {
        $fileTypeArs = array("psd" => "psfile.png", "pdf" => "pfdfile.png", "indd" => "indesign.png", "csv" => "csv.png", "xls" => "csv.png", "zip" => "zip.png", "doc" => "word.png", "docx" => "word.png");
        $filesize = formatSizeUnits(filesize('../../img/offers/' . $key["thumb"]));
        ///$html .= '<tr style="font-size: 12px"><td>'.$key["thumb"].'</td><td>'.$filesize.'</td><td>Type</td><td>Modification</td></tr>';
        if (filetype($dirIn . $key["thumb"]) == 'file') {
            $ext = explode('.', $key["thumb"]);

            if (array_key_exists($ext[1], $fileTypeArs)) {
                $layover = 'img/' . $fileTypeArs[$ext[1]];
            } else {
                $fixDir = substr($dirIn, 3);
                $layover = $fixDir . $key["thumb"];
            }


            $html .= '<div class="col-md-2 grablinks" style="background: #efefef; background-image: url(\'' . $layover . '\'); background-size:cover; height:90px; padding: 5px; border: solid thick #fff; overflow: hidden; cursor:pointer" data-info="'.$layover.'"><span style="padding:2px; background:#fff; font-size:10px">' . $key["thumb"] . '</span></div>';
        }
    }
    $html .= '<input type="hidden" name="linkins" id="linkins" value="">';
    $html .= '</div></div>';
    echo $html;
}

if($_REQUEST["getdata"] == 'true'){
    $html .= '<input type="hidden" id="dirnow" name="dirnow" value="'.$dirIn.'">';
    $files = scandir($dirIn, 1);
    foreach ($files as $key) {
        if ($key != '.' && $key != '.DS_Store') {
            $imgout[] = array('thumb' => $key);
        }
    }

    $diEx = explode('/', $dirIn);
    $basCh = str_replace('../../', '', $dirIn);
    $basCh = trim($basCh, '/');
    $current = substr(strrchr($basCh, "/"), 1);

    $html .= '<ol class="breadcrumb" style="margin-bottom: 5px; border-radius: 0px;">';
    $previousValue = null;
    foreach ($diEx as $key) {
        if ($previousValue) {
            $previousValue = ltrim($previousValue,'/');
            $html .= '<li><a href="javascript:moveToFile(\''. $previousValue . '/' . $key . '\')">' . $key . '</a></li>';
        }
        $previousValue = $previousValue . '/' . $key;
    }
    $html .= '</ol>';
//$html .= "this is ".$current;

    foreach ($imgout as $key) {
        $filesize = formatSizeUnits(filesize($dirIn . $key["thumb"]));
        ///$html .= '<tr style="font-size: 12px"><td>'.$key["thumb"].'</td><td>'.$filesize.'</td><td>Type</td><td>Modification</td></tr>';
        if (filetype($dirIn . $key["thumb"]) == 'dir' && $key["thumb"] != '..') {
            $dirLink = 'img/' . $key["thumb"] .
                $html .= '<div class="col-md-2" style="background: #F7E2A2; background-image: url(\'../img/' . $key["thumb"] . '\'); background-size:cover; height:90px; padding: 5px; border: solid thick #fff; overflow: hidden; cursor:pointer" onClick="moveToFile(\'' . $dirIn . $key["thumb"] . '\')"><span style="padding:2px; background:#fff; font-size:10px">' . $key["thumb"] . '</span></div>';
        }
    }

    foreach ($imgout as $key) {
        $fileTypeArs = array("psd" => "psfile.png", "pdf" => "pfdfile.png", "indd" => "indesign.png", "csv" => "csv.png", "xls" => "csv.png", "zip" => "zip.png", "doc" => "word.png", "docx" => "word.png");
        $filesize = formatSizeUnits(filesize('../../img/offers/' . $key["thumb"]));
        ///$html .= '<tr style="font-size: 12px"><td>'.$key["thumb"].'</td><td>'.$filesize.'</td><td>Type</td><td>Modification</td></tr>';
        if (filetype($dirIn . $key["thumb"]) == 'file') {
            $ext = explode('.', $key["thumb"]);

            if (array_key_exists($ext[1], $fileTypeArs)) {
                $fixDir = substr($dirIn, 3);
                $layover = 'img/' . $fileTypeArs[$ext[1]];
                $trueLink = $fixDir . $key["thumb"];
            } else {
                $fixDir = substr($dirIn, 3);
                $layover = $fixDir . $key["thumb"];
                $trueLink = $fixDir . $key["thumb"];
            }


            $html .= '<div class="col-md-2 grablinks" style="background: #efefef; background-image: url(\'' . $layover . '\'); background-size:cover; height:90px; padding: 5px; border: solid thick #fff; overflow: hidden; cursor:pointer" data-info="'.$trueLink.'"><span style="padding:2px; background:#fff; font-size:10px; cursor: pointer">' . $key["thumb"] . '</span></div>';
        }
    }
    $html .= '<input type="hidden" name="linkins" id="linkins" value="">';
    echo $html;
}

//createdirectory&dirin='+linkins+'&dirname

if($_REQUEST["getdata"] == 'createdirectory'){
    mkdir("../../img/".$_REQUEST["dirin"].'/'.$_REQUEST["dirname"], 0744);
}