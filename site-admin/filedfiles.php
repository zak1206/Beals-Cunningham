<?php

//error_reporting(0);
$mountmessage = '';
$directory = $_REQUEST["directory"];
if(isset($_REQUEST["directory"])){
    if($_REQUEST["directory"] != '') {
        $directory = $_REQUEST["directory"];
    }else{
        $directory = '../img';
    }
}else{

    $directory = '../img';
}


if(isset($_REQUEST["directname"])){
    if($_REQUEST["directname"] != '') {
        $newdir = preg_replace("/[^A-Za-z0-9]/", "", $_REQUEST["directname"]);
        mkdir($directory .'/'. $newdir, 0775);
    }
}

if(isset($_REQUEST["deleteitem"])){
    unlink($_REQUEST["deleteitem"]);
}

if($_REQUEST["directory"] == ''){$dirs = '../img';}else{$dirs = $_REQUEST["directory"];}



//This function transforms the php.ini notation for numbers (like '2M') to an integer (2*1024*1024 in this case)
function humanFileSize($size,$unit="") {
    if( (!$unit && $size >= 1<<30) || $unit == "GB")
        return number_format($size/(1<<30),2)."GB";
    if( (!$unit && $size >= 1<<20) || $unit == "MB")
        return number_format($size/(1<<20),2)."MB";
    if( (!$unit && $size >= 1<<10) || $unit == "KB")
        return number_format($size/(1<<10),2)."KB";
    return number_format($size)." bytes";
}

function convertPHPSizeToBytes($sSize)
{
    if ( is_numeric( $sSize) ) {
        return $sSize;
    }
    $sSuffix = substr($sSize, -1);
    $iValue = substr($sSize, 0, -1);
    switch(strtoupper($sSuffix)){
        case 'P':
            $iValue *= 1024;
        case 'T':
            $iValue *= 1024;
        case 'G':
            $iValue *= 1024;
        case 'M':
            $iValue *= 1024;
        case 'K':
            $iValue *= 1024;
            break;
    }
    return $iValue;
}

function getMaximumFileUploadSize()
{
    return humanFileSize(min(convertPHPSizeToBytes(ini_get('post_max_size')), convertPHPSizeToBytes(ini_get('upload_max_filesize'))));
}




$files = scandir($directory, 1);

error_reporting(0);
$outss .= '<div id="medholds" class="default_list">';
foreach($files as $key) {
    if ($key != '.' && $key != '..' && $key != '.DS_Store') {
        $te = explode('.', $key);
        if ($te[1] != '') {
            $test = 'file';
            $fileOut[] = array('tumbnail' => $directory.'/thumbnail/'.$key, 'name' => $key, 'link' => '../img/' . $key, 'size' => 'Not Captured', 'type' => $test);
        } else {
            $test = 'directory';
            $dirOut[] = array('tumbnail' => $directory.'/thumbnail/'.$key, 'name' => $key, 'link' => '../img/' . $key, 'size' => 'Not Captured', 'type' => $test);
        }
    }
}


function sortByName($a, $b)
{
    $a = $a['name'];
    $b = $b['name'];

    if ($a == $b) return 0;
    return ($a < $b) ? -1 : 1;
}



usort($fileOut, 'sortByName');




        //{ "title": "Some Image", "name": "1.jpg", "link": "/images/1.jpg", "size": "301Kb" }, //echo $key; } }
         for($i=0; $y <= count($dirOut); $y++){
             if($dirOut[$y]["type"] == 'directory' && $dirOut[$y]["name"] != 'thumbnail'){
                 //$outss .= '<a class="col-md-2 col-sm-2 col-xs-3" style="padding: 0px 5px 0px; display:inline-block" href="javascript:migrate(\''.$directory .'/'. $dirOut[$y]["name"] . '\')"><div style="padding: 5px; border:solid thick #fff; background: #efefef"><img style="width:100%" src="img/folder.png"/><span style="display:block; padding:5px; background:#fff; text-align:center; position:absolute; bottom:0px; left:0px; width:100%; overflow:hidden; height:25px">' . $dirOut[$y]["name"] . '</span></div></a>';
                 $outss .= '<div class="col-md-2 col-sm-2 col-xs-3 folderset" data-object="'.$directory .'/'. $dirOut[$y]["name"].'" style="padding: 5px; border:solid thick #fff; background: #efefef;" onclick="migrate(\''.$directory .'/'. $dirOut[$y]["name"] . '\')"><img style="width:100%" src="img/folder.png"/><div class="" style="display:block; padding:5px; text-align:center;  background:#333; color:#fff; position:absolute; bottom:0px; left:0px; width:100%; z-index:700; height:25px"><a href="#" style="color:#fff; margin:5px"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> <a href="#" style="color:#fff; margin:5px"><i class="fa fa-trash" aria-hidden="true"></i></a></div><span class="editobj" style="display:block; padding:5px; background:#fff; text-align:center; position:absolute; bottom:0px; left:0px; width:100%; overflow:hidden; height:25px; z-index:800">' . $dirOut[$y]["name"] . '</span></div>';
             }
         }
        for ($i = 0; $i <= count($fileOut); $i++) {
            if ($fileOut[$i]["type"] == 'file') {
                $tes = substr($fileOut[$i]["name"], strrpos($fileOut[$i]["name"], '.') + 1);


                list($width, $height) = getimagesize($directory .'/'. $fileOut[$i]["name"]);


                if($width != ''){
                    if(file_exists($fileOut[$i]["tumbnail"])){
                        $image = '<img style="width:100%" src="' . $fileOut[$i]["tumbnail"] . '"/>';
                        $backset = '';
                        $filetyp = 'data-toggle="lightbox" data-type="image" data-gallery="gall-images"';
                    }else{
                        $image = '<img style="width:100%" src="img/isimg_but.png"/>';
                        $backset = 'background-image:url(\''.$directory .'/'. $fileOut[$i]["name"] . '\'); background-size:cover; background-repeat:no-repeat; background-position: center center;';
                    }
                }else{

                    ///$imageFileType != "pdf" && $imageFileType != "txt" && $imageFileType != "rtf"  && $imageFileType != "doc"
                    /// && $imageFileType != "docx" && $imageFileType != "xls" && $imageFileType != "xlsx" && $imageFileType != "xlsm" && $imageFileType != "zip" && $imageFileType != "mov" && $imageFileType != "webm" && $imageFileType != "mp4" && $imageFileType != "wav" && $imageFileType != "mp3" && $imageFileType != "mpeg" && $imageFileType != "wmv" && $imageFileType != "avi"


                    switch ($tes) {
                        case 'tiff';
                            $image = '<img style="width:100%" src="img/gen_ico.png"/>';
                            $filetyp = 'data-toggle="lightbox" data-type="image" data-gallery="gall-images"';
                            break;
                        case 'pdf':
                            $image = '<img style="width:100%" src="img/pdffile.png"/>';
                            $filetyp = '';
                            break;
                        case 'txt':
                            $image = '<img style="width:100%" src="img/txtfile.png"/>';
                            $filetyp = 'data-toggle="lightbox" data-type="url" data-gallery="gall-images"';
                            break;
                        case 'rtf':
                            $image = '<img style="width:100%" src="img/rtffile.png"/>';
                            $filetyp = 'data-toggle="lightbox" data-type="url" data-gallery="gall-images"';
                            break;
                        case 'doc':
                            $image = '<img style="width:100%" src="img/word.png"/>';
                            $filetyp = '';
                            break;
                        case 'docx':
                            $image = '<img style="width:100%" src="img/word.png"/>';
                            $filetyp = '';
                            break;
                        case 'xls':
                            $image = '<img style="width:100%" src="img/csv.png"/>';
                            $filetyp = '';
                            break;
                        case 'xlsx':
                            $image = '<img style="width:100%" src="img/csv.png"/>';
                            $filetyp = '';
                            break;
                        case 'xlsm':
                            $image = '<img style="width:100%" src="img/csv.png"/>';
                            $filetyp = '';
                            break;
                        case 'csv':
                            $image = '<img style="width:100%" src="img/csv.png"/>';
                            $filetyp = '';
                            break;
                        case 'zip':
                            $image = '<img style="width:100%" src="img/zip.png"/>';
                            $filetyp = '';
                            break;
                        case 'mov':
                            $image = '<img style="width:100%" src="img/vidfile.png"/>';
                            $filetyp = 'data-toggle="lightbox" data-type="video" data-gallery="gall-images"';
                            $backset = '';
                            break;
                        case 'webm':
                            $image = '<img style="width:100%" src="img/vidfile.png"/>';
                            $filetyp = 'data-toggle="lightbox" data-type="video" data-gallery="gall-images"';
                            $backset = '';
                            break;
                        case 'mp4':
                            $image = '<img style="width:100%" src="img/vidfile.png"/>';
                            $filetyp = 'data-toggle="lightbox" data-type="video" data-gallery="gall-images"';
                            $backset = '';
                            break;
                        case 'mpeg':
                            $image = '<img style="width:100%" src="img/vidfile.png"/>';
                            $filetyp = 'data-toggle="lightbox" data-type="video" data-gallery="gall-images"';
                            $backset = '';
                            break;
                        case 'wmv':
                            $image = '<img style="width:100%" src="img/vidfile.png"/>';
                            $filetyp = 'data-toggle="lightbox" data-type="video" data-gallery="gall-images"';
                            $backset = '';
                            break;
                        case 'avi':
                            $image = '<img style="width:100%" src="img/vidfile.png"/>';
                            $filetyp = 'data-toggle="lightbox" data-type="video" data-gallery="gall-images"';
                            $backset = '';
                            break;
                        case 'avi':
                            $image = '<img style="width:100%" src="img/vidfile.png"/>';
                            $filetyp = 'data-toggle="lightbox" data-type="video" data-gallery="gall-images"';
                            $backset = '';
                            break;
                        case 'mp3':
                            $image = '<img style="width:100%" src="img/audiofile.png"/>';
                            $filetyp = 'data-toggle="lightbox" data-type="video" data-gallery="gall-images"';
                            $backset = '';
                            break;
                        case 'wav':
                            $image = '<img style="width:100%" src="img/audiofile.png"/>';
                            $filetyp = 'data-toggle="lightbox" data-type="video" data-gallery="gall-images"';
                            $backset = '';
                            break;
                        case 'jpg':
                            $filetyp = 'data-toggle="lightbox" data-type="image" data-gallery="gall-images"';
                            break;
                        case 'jpeg':
                            $filetyp = 'data-toggle="lightbox" data-type="image" data-gallery="gall-images"';
                            break;
                        case 'gif':
                            $filetyp = 'data-toggle="lightbox" data-type="image" data-gallery="gall-images"';
                            break;
                        case 'png':
                            $filetyp = 'data-toggle="lightbox" data-type="image" data-gallery="gall-images"';
                            break;
                        case 'jpg':
                            $filetyp = 'data-toggle="lightbox" data-type="image" data-gallery="gall-images"';
                            break;
                    }



                }

                $objPath = ''.$directory .'/'.$fileOut[$i]["name"].'';

                if(isset($_REQUEST["typeset"])){
                    if($_REQUEST["typeset"] == 'core') {
                        if($tes == 'pdf'){
                            $outss .= '<div id="item-' . $fileOut[$i]["name"] . '" data-imgpath="'.$objPath.'" class="col-md-2 col-sm-2 col-xs-3 object" style="padding: 5px; border:solid thick #fff; background: #efefef; ' . $backset . '"><a class="fancybox" '.$filetyp.'   href="' . $objPath . '" target="_blank">' . $image . '</a><div class="" style="display:block; padding:5px; text-align:center;  background:#333; color:#fff; position:absolute; bottom:0px; left:0px; width:100%; z-index:700; height:25px"><a href="javascript:renameFile(\'' . $objPath . '\')" style="color:#fff; margin:5px"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> <a href="javascript:deleteFile(\'' . $objPath . '\')" style="color:#fff; margin:5px"><i class="fa fa-trash" aria-hidden="true"></i></a> <a href="' . $objPath . '" download="' . $fileOut[$i]["name"] . '" style="color:#fff; margin:5px"><i class="fa fa-download" aria-hidden="true"></i></a></div><span class="editobj" style="display:block; padding:5px; background:#fff; text-align:center; position:absolute; bottom:0px; left:0px; width:100%; overflow:hidden; height:25px; z-index:800">' . $fileOut[$i]["name"] . '</span></div>';
                        }else{
                            $outss .= '<div id="item-' . $fileOut[$i]["name"] . '" class="col-md-2 col-sm-2 col-xs-3 object" data-imgpath="'.$objPath.'" style="padding: 5px; border:solid thick #fff; background: #efefef; ' . $backset . '"><a class="fancybox" '.$filetyp.'   href="' . $objPath . '">' . $image . '</a><div class="" style="display:block; padding:5px; text-align:center;  background:#333; color:#fff; position:absolute; bottom:0px; left:0px; width:100%; z-index:700; height:25px"><a href="javascript:renameFile(\'' . $objPath . '\')" style="color:#fff; margin:5px"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> <a href="javascript:deleteFile(\'' . $objPath . '\')" style="color:#fff; margin:5px"><i class="fa fa-trash" aria-hidden="true"></i></a> <a href="' . $objPath . '" download="' . $fileOut[$i]["name"] . '" style="color:#fff; margin:5px"><i class="fa fa-download" aria-hidden="true"></i></a></div><span class="editobj" style="display:block; padding:5px; background:#fff; text-align:center; position:absolute; bottom:0px; left:0px; width:100%; overflow:hidden; height:25px; z-index:800">' . $fileOut[$i]["name"] . '</span></div>';
                        }

                    }

                    if($_REQUEST["typeset"] == 'simple') {
                        $outss .= '<div id="item-' . $fileOut[$i]["name"] . '" class="col-md-2 col-sm-2 col-xs-3 object" data-imgpath="'.$objPath.'" style="padding: 5px; border:solid thick #fff; background: #efefef; ' . $backset . '"><div class="imgholds" onClick="setsimple(\''.$objPath.'\',\''.$_REQUEST["fldset"].'\')">' . $image . '</div><div class="" style="display:block; padding:5px; text-align:center;  background:#333; color:#fff; position:absolute; bottom:0px; left:0px; width:100%; z-index:700; height:25px"><a href="javascript:renameFile(\'' . $objPath . '\')" style="color:#fff; margin:5px"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> <a href="javascript:deleteFile(\'' . $objPath . '\')" style="color:#fff; margin:5px"><i class="fa fa-trash" aria-hidden="true"></i></a> <a href="' . $objPath . '" download="' . $fileOut[$i]["name"] . '" style="color:#fff; margin:5px"><i class="fa fa-download" aria-hidden="true"></i></a></div><span class="editobj" style="display:block; padding:5px; background:#fff; text-align:center; position:absolute; bottom:0px; left:0px; width:100%; overflow:hidden; height:25px; z-index:800">' . $fileOut[$i]["name"] . '</span></div>';
                    }

                    if($_REQUEST["typeset"] == '') {
                        $outss .= '<div class="col-md-2 col-sm-2 col-xs-3 object" data-imgpath="'.$objPath.'" style="padding: 5px; border:solid thick #fff; background: #efefef; ' . $backset . '"><div class="imgholds" onClick="setplace(\'' . $objPath . '\')">' . $image . '</div><div class="" style="display:block; padding:5px; text-align:center;  background:#333; color:#fff; position:absolute; bottom:0px; left:0px; width:100%; z-index:700; height:25px"><a href="#" style="color:#fff; margin:5px"><a href="javascript:renameFile(\'' . $objPath . '\')" style="color:#fff; margin:5px"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> <a href="javascript:deleteFile(\'' . $objPath . '\')" style="color:#fff; margin:5px"><i class="fa fa-trash" aria-hidden="true"></i></a> <a href="' . $objPath . '" download="' . $fileOut[$i]["name"] . '" style="color:#fff; margin:5px"><i class="fa fa-download" aria-hidden="true"></i></a></div><span class="editobj" style="display:block; padding:5px; background:#fff; text-align:center; position:absolute; bottom:0px; left:0px; width:100%; overflow:hidden; height:25px; z-index:800">' . $fileOut[$i]["name"] . '</span></div>';
                    }
                }else{
                    $outss .= '<div class="col-md-2 col-sm-2 col-xs-3 object" data-imgpath="'.$objPath.'" style="padding: 5px; border:solid thick #fff; background: #efefef; '.$backset.'"><div class="imgholds" onClick="setplace(\'' . $objPath . '\')">'.$image.'</div><div class="" style="display:block; padding:5px; text-align:center;  background:#333; color:#fff; position:absolute; bottom:0px; left:0px; width:100%; z-index:700; height:25px"><a href="#" style="color:#fff; margin:5px"><a href="javascript:renameFile(\'' . $objPath . '\')" style="color:#fff; margin:5px"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> <a href="javascript:deleteFile(\'' . $objPath . '\')" style="color:#fff; margin:5px"><i class="fa fa-trash" aria-hidden="true"></i></a> <a href="' . $objPath . '" download="' . $fileOut[$i]["name"] . '" style="color:#fff; margin:5px"><i class="fa fa-download" aria-hidden="true"></i></a></div><span class="editobj" style="display:block; padding:5px; background:#fff; text-align:center; position:absolute; bottom:0px; left:0px; width:100%; overflow:hidden; height:25px; z-index:800">' . $fileOut[$i]["name"] . '</span></div>';

                }


            }
        }

        $outss .= '<div style="clear:both"></div>';

$outss .='</div>';


function process(){

}


/////PROCESS STEPBACK///
$parts = explode('/',$directory);
$hangit = '';
$i=1;
$partsCount = count($parts);
foreach($parts as $navout){
        if ($navout != 'img') {
            if($navout == '..') {

            }else{
                if($i == $partsCount){
                    $dirObj .= '<span>' . $navout . ' </span>';
                    if($partsCount == 3) {
                        //echo $_REQUEST["typeset"];
                        if(isset($_REQUEST["typeset"])){
                            if(isset($_REQUEST["fldset"])){
                                $typeset = 'typeset='.$_REQUEST["typeset"].'&fldset='.$_REQUEST["fldset"].'&mceid='.$_REQUEST["mceid"].'&';
                            }else{
                                $typeset = 'typeset='.$_REQUEST["typeset"].'&fldset='.$_REQUEST["fldset"].'&mceid='.$_REQUEST["mceid"].'&';
                            }

                        }else{
                            $typeset ='';
                        }
                        $backOps = '<a href="?'.$typeset.'directory=../img"><div class="col-md-2 col-sm-2 col-xs-3 object"  style="padding: 5px; border:solid thick #fff; background: #fff;"><span style="display:block; padding:5px; background:#fff; text-align:center; position:absolute; bottom:0px; left:0px; width:100%; overflow:hidden; height:25px">img</span><img style="width:100%" src="img/go_back.jpg"/></div></a>';
                    }
                    }else{
                    echo $_REQUEST["typeset"];
                    if(isset($_REQUEST["typeset"])){
                        if(isset($_REQUEST["fldset"])){
                            $typeset = 'typeset='.$_REQUEST["typeset"].'&fldset='.$_REQUEST["fldset"].'&mceid='.$_REQUEST["mceid"].'&';
                        }else{
                            $typeset = 'typeset='.$_REQUEST["typeset"].'&fldset='.$_REQUEST["fldset"].'&mceid='.$_REQUEST["mceid"].'&';
                        }

                    }else{
                        $typeset ='';
                    }
                    $dirObj .= '<a href="?'.$typeset.'directory=../img/'.$hangit . $navout . '">' . $navout . ' <i class="fa fa-angle-right" aria-hidden="true"></i> </a>';
                    $backOps = '<a href="?'.$typeset.'directory=../img/'.$hangit . $navout . '"><div class="col-md-2 col-sm-2 col-xs-3 object" style="padding: 5px; border:solid thick #fff; background: #fff;"><span style="display:block; padding:5px; background:#fff; text-align:center; position:absolute; bottom:0px; left:0px; width:100%; overflow:hidden; height:25px">' . $navout. '</span><img style="width:100%" src="img/go_back.jpg"/></div></a>';
                }
                $hangit .= $navout.'/';
            }
        } else {
            if(isset($_REQUEST["typeset"])){
                if(isset($_REQUEST["fldset"])){
                    $typeset = 'typeset='.$_REQUEST["typeset"].'&fldset='.$_REQUEST["fldset"].'&mceid='.$_REQUEST["mceid"].'&';
                }else{
                    $typeset = 'typeset='.$_REQUEST["typeset"].'&fldset='.$_REQUEST["fldset"].'&mceid='.$_REQUEST["mceid"].'&';
                }

            }else{
                $typeset ='';
            }
            $dirObj .= '<a href="?'.$typeset.'directory=../img">img <i class="fa fa-angle-right" aria-hidden="true"></i> </a>';
    }
$i++;
}

?>


<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Edit Files</title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/dropzone.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300" rel="stylesheet">

    <style>
        body{
            font-family: 'Raleway', sans-serif;
        }
  .fileUpload {
    position: relative;
    overflow: hidden;
    margin: 10px;
}
.fileUpload input.upload {
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    padding: 0;
    font-size: 20px;
    cursor: pointer;
    opacity: 0;
    filter: alpha(opacity=0);
}

.breadcrumb>li{
    width:100%
}

.popover-content{
padding: 0
}

.popover-title{
    font-size:12px
}

.popover.top {
    margin: 15px 0;
}

.fileelem{
    height: 34px;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: none;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    font-style: italic;
}

      .modal-dialog{
          margin-top: 200px;
      }

  .dropzone {
      min-height: 150px;
      border: dashed 2px #b7ccd8;
      background: #cde7f5;
      padding: 20px 20px;
      display: none;
  }

        .dropzone .dz-preview.dz-image-preview {
            background: none;
        }


</style>

  <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="crossorigin="anonymous"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/t/bs/jqc-1.12.0,dt-1.10.11/datatables.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.js"></script>
  <script src="assets/js/jquery.validate.js"></script>
  <script src="assets/js/dropzone.js"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/t/bs/jqc-1.12.0,dt-1.10.11/datatables.min.css"/>


  <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  <![endif]-->
</head>
<body>

<div id="covers" style="background: #000; opacity: .7; position: fixed; left: 0; top: 0; width:100%; height:100%; z-index: 9000; "></div>
<div id="loaddder" style="width: 70px; height: 70px; position: fixed; left: 50%;  top:40%; z-index: 9001; color: #fff; background: #222222; padding:15px; border-radius: 50%"><img style="width: 100%" src="img/medload.gif"/></div>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">
            </div>

        </div>

    </div>
</div>

<?php if(isset($_REQUEST["systemlinks"]) && $_REQUEST["systemlinks"] == 'true'){
    $siteLinks = $site->getSystemLinks();
    echo $siteLinks;
}else{
}
?>
<?php echo $mymess; ?>

<div class="uploadboj" style="display: block; padding:10px; background: #efefef; z-index: 7000; width: 100%; top:0">
    <div class="alert alert-warning">NOTICE! - Files cannot exceed : <?php echo getMaximumFileUploadSize(); ?> for upload<br><small>If you need to upload larger files you will need to contact your hosting provider to adjust upload size limits.</small></div>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><?php echo $dirObj; ?></li>
</ol>


    <button class="btn btn-warning openuploads"><i class="fa fa-cloud-upload" aria-hidden="true"></i> Upload Files...</button> <button type="button" class="btn btn-default" title="Add Directory" onClick="addDirs()"><i class="fa fa-plus" aria-hidden="true"></i> <i class="fa fa-folder" aria-hidden="true"></i></button><br><br>

    <div class="mess-hls"></div>

    <form method="post" id="myAwesomeDropzone" class="dropzone" enctype="multipart/form-data" action="inc/testmove.php?typeset=<?php echo $_REQUEST["typeset"]; ?>&mceid=<?php echo $_REQUEST["mceid"]; ?>&fldset=<?php echo $_REQUEST["fldset"]; ?>&directory=<?php echo $_REQUEST["directory"]; ?>">
        <div class="fallback">
            <input name="file" type="file" multiple />
        </div>
    </form><div style="padding:10px; text-align:right; font-size:20px">
</div>
    <div style="clear:both"></div>
    <div style="background: #f5f5f5;" class="col-md-12"><i class="fa fa-search" style="font-size: 20px;position: absolute;top: 9px;color: #949494;"></i><input type="text" style="padding: 10px 0 10px 29px;width: 100%;background: none;border: none;outline: none;font-size: 14px;font-weight: bold;color: #888;" id="searchmed" id="searchmed" data-list=".default_list" autocomplete="off" value="" placeholder="Search..."> </div>
    <div style="clear:both"></div>
</div>
<div style="clear:both"></div>

<?php echo $backOps; ?>
<?php echo $outss; ?>
<input type="hidden" id="mcefield" name="mcefield" value="<?php echo $_REQUEST["mceid"]; ?>"/>

<script src="assets/js/jquery.sticky.js"></script>
<script src="assets/js/jquery.hideseek.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>

<script>
    $(function(){
       // $(".uploadboj").sticky({topSpacing:0});
    })

    $( function() {
        $( ".object" ).draggable({helper: "clone",opacity: 0.7,zIndex: 800, });
    } );

    $(function(){
        $(".folderset").droppable({
            drop: function (event, ui) {
                //display the ID in the console log:
                var folder = $(this).data('object');
                var imagepull = ui.draggable.data("imgpath");


                 $.ajax({
                     url: 'recallMedia.php?action=movefile&file='+imagepull+'&dir='+folder,
                     success:function(data){
                         console.log(data);
                         ui.draggable.remove();
                     }
                 })



            }
        });
    });
</script>

  <script>
    function migrate(theval){
        window.location.href = 'filedfiles.php?typeset=<?php echo $_REQUEST["typeset"]; ?>&fldset=<?php echo $_REQUEST["fldset"]; ?>&mceid=<?php echo $_REQUEST["mceid"]; ?>&directory='+theval;
    }


function setplace(contentpath){
var mcfieldset = $("#mcefield").val();
    console.log(mcfieldset);
    window.parent.updateMcefld(contentpath,mcfieldset);
}
    function setsimple(pathset,fld){
        window.parent.passImage(pathset,fld);
    }

$(function(){
    $(".upload-button").on("click",function(){
        $(".load-sets").show();
    })

    $(".object").hover(function () {
  $(this).find(".editobj").slideToggle("fast");
});
})

function addDirs(){
    $("#myModal .modal-body").html("<form name='createdir' id='createdir' method='post' action=''><label>Directory Name</label><br><input class='form-control' type='text' name='directname' id='directname' value=''><br><button class='btn btn-warning' type=submit' >Create Directory</button></form>");
    $("#myModal .modal-header").html("<button type='button' class='close' data-dismiss='modal'>&times;</button> <h4>Create New Directory</h4>");
    $("#myModal").modal();
}

function deleteFile(filenarea){
$("#myModal .modal-body").html('<strong>Are you sure you want to delete this image?</strong><br><br><button class="btn btn-danger contdel" onClick="findel(\''+filenarea+'\')">Yes Delete</button> <button class="btn btn-success" data-dismiss="modal">Whoops! NO!</button>');
    $("#myModal .modal-header").html("<button type=\'button\' class=\'close\' data-dismiss=\'modal\'>&times;</button> <h4>Notice</h4>");
    $("#myModal").modal();
}

function findel(val){
window.location.href = 'filedfiles.php?deleteitem='+val+'&typeset=<?php echo $_REQUEST["typeset"]; ?>&mceid=<?php echo $_REQUEST["mceid"]; ?>&directory=<?php echo $dirs; ?>';
}
  </script>

  <script type="text/javascript">

      $(document).on('click', '[data-toggle="lightbox"]', function(event) {
          event.preventDefault();
          $(this).ekkoLightbox();
      });


	$(document).ready(function() {
		//$(".fancybox").fancybox();
        $("#loaddder").hide();
        $("#covers").hide();
        $('#searchmed').hideseek({
            highlight: true
        });

        $(".openuploads").on('click',function(data){
            $(".dropzone").slideToggle();
        })

        $('.table').DataTable({
            "columnDefs": [ {
                "targets": 'nosort',
                "orderable": false
            } ]
        });
	});
</script>

 <script>


     function renameFile(curfilename){
         var uri = curfilename;
         var lastslashindex = uri.lastIndexOf('/');
         var result = uri.substring(lastslashindex  + 1);
         var b = result.substring(result.lastIndexOf(".")) //23

         var fileName = result.split('.');

         $("#myModal .modal-body").html("<div class='alert alert-success renamemess' style='display: none'>Image rename successful. </div><form name='chnfilename' id='chnfilename' method='post' action=''><label>File Name</label><br><div class='col-md-8' style='padding-left:0'><input class='form-control' type='text' name='newfilename' id='newfilename' value='' required></div><div class='col-md-4'><span class=\"label label-default\">"+b+"</span><div style='clear:both'></div></div><div style='clear:both'></div><br><input type='hidden' name='pathset' id='pathset' value='"+uri+"'><button class='btn btn-warning' type=submit' >Save Name</button></form>");
         $("#newfilename").val(fileName[0]);
         $("#myModal .modal-header").html("<button type='button' class='close' data-dismiss='modal'>&times;</button> <h4>Edit File Name</h4>");
         $("#myModal").modal();

         $("#chnfilename").validate({
             submitHandler: function(form) {
                 $.ajax({
                     type: 'POST',
                     data: $("#chnfilename").serialize(),
                     url: 'recallMedia.php?action=rename',
                     success: function (data) {
                         recallDirectory();
                         $(".renamemess").show()
                         setTimeout(function(){
                             $(".renamemess").hide();
                         }, 5000);

                     }
                 })
             }
         })

     }

     Dropzone.options.myAwesomeDropzone = {
         paramName: "file", // The name that will be used to transfer the file
         maxFilesize: 2, // MB
         queuecomplete: function(file, done) {
             $(".mess-hls").html('<div class="alert alert-success">All uploads processed.</div>');
             recallDirectory();
             setTimeout(function(){
                 $(".mess-hls").html('');
                 $(".mess-hls").hide();
             }, 5000);
         }
     };

     function recallDirectory(){
         $.ajax({
             type: 'POST',
             url: 'recallMedia.php?action=recall&typeset=<?php echo $_REQUEST["typeset"]; ?>',
             data: {
                 'directory': '<?php echo $directory; ?>'
             },
             success: function (data) {
                 $("#medholds").html(data);
                 $(".object").hover(function () {
                     $(this).find(".editobj").slideToggle("fast");
                 });
             }
         })
     }

     $(function(){
         $('.gif_class').freezeframe();
     })


</script>
</body>
</html>