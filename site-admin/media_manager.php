<?php
//error_reporting(0);

function mime_content_type_fallback($filename)
{

    $mime_types = array(

        'txt' => 'text/plain',
        'htm' => 'text/html',
        'html' => 'text/html',
        'php' => 'text/html',
        'css' => 'text/css',
        'js' => 'application/javascript',
        'json' => 'application/json',
        'xml' => 'application/xml',
        'swf' => 'application/x-shockwave-flash',
        'flv' => 'video/x-flv',

        // images
        'png' => 'image/png',
        'jpe' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'gif' => 'image/gif',
        'bmp' => 'image/bmp',
        'ico' => 'image/vnd.microsoft.icon',
        'tiff' => 'image/tiff',
        'tif' => 'image/tiff',
        'svg' => 'image/svg+xml',
        'svgz' => 'image/svg+xml',

        // archives
        'zip' => 'application/zip',
        'rar' => 'application/x-rar-compressed',
        'exe' => 'application/x-msdownload',
        'msi' => 'application/x-msdownload',
        'cab' => 'application/vnd.ms-cab-compressed',

        // audio/video
        'mp3' => 'audio/mpeg',
        'qt' => 'video/quicktime',
        'mov' => 'video/quicktime',

        // adobe
        'pdf' => 'application/pdf',
        'psd' => 'image/vnd.adobe.photoshop',
        'ai' => 'application/postscript',
        'eps' => 'application/postscript',
        'ps' => 'application/postscript',

        // ms office
        'doc' => 'application/msword',
        'rtf' => 'application/rtf',
        'xls' => 'application/vnd.ms-excel',
        'ppt' => 'application/vnd.ms-powerpoint',

        // open office
        'odt' => 'application/vnd.oasis.opendocument.text',
        'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
    );

    $value = explode(".", $filename);
    $ext = strtolower(array_pop($value));
    if (array_key_exists($ext, $mime_types)) {
        return $mime_types[$ext];
    } elseif (function_exists('finfo_open')) {
        $finfo = finfo_open(FILEINFO_MIME);
        $mimetype = finfo_file($finfo, $filename);
        finfo_close($finfo);
        return $mimetype;
    } else {
        return 'application/octet-stream';
    }
}

//VIEW TYPE SESSION//
session_start();

if(isset($_REQUEST["setviewsess"])){
    $_SESSION["mediaview"] = $_REQUEST["setviewsess"];
    $viewType = $_REQUEST["setviewsess"];
}

if(isset($_SESSION["mediaview"])){
    $viewType = $_SESSION["mediaview"];
}else{
    $viewType = 'box';
}


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

if(isset($_POST["setfiletypes"])){
    include('inc/harness.php');
    $data->query("UPDATE site_settings SET media_types = '".$data->real_escape_string($_POST["setfiletypes"])."' WHERE id = '1'")or die($data->error);
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

                if(isset($_REQUEST["returntarget"]) && $_REQUEST["returntarget"] != ''){
                    $returnInput = '&returntarget='.$_REQUEST["returntarget"];
                }else{
                    $returnInput = '';
                }


                $dirObj .= '<a href="?'.$typeset.'directory=../img/'.$hangit . $navout .$returnInput.'">' . $navout . ' <i class="fa fa-angle-right" aria-hidden="true"></i> </a>';
                $backOps = '<a href="?'.$typeset.'directory=../img/'.$hangit . $navout .$returnInput.'"><div class="col-md-2 col-sm-2 col-xs-3 object" style="padding: 5px; border:solid thick #fff; background: #fff;"><span style="display:block; padding:5px; background:#fff; text-align:center; position:absolute; bottom:0px; left:0px; width:100%; overflow:hidden; height:25px">' . $navout. '</span><img style="width:100%" src="img/go_back.jpg"/></div></a>';
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

        if(isset($_REQUEST["returntarget"]) && $_REQUEST["returntarget"] != ''){
            $returnInput = '&returntarget='.$_REQUEST["returntarget"];
        }else{
            $returnInput = '';
        }
        $dirObj .= '<a href="?'.$typeset.'directory=../img' .$returnInput.'">img <i class="fa fa-angle-right" aria-hidden="true"></i> </a>';
    }
    $i++;
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

//function make_thumb($src, $dest, $desired_width) {
//
//    /* read the source image */
//    $source_image = imagecreatefromjpeg($src);
//    $width = imagesx($source_image);
//    $height = imagesy($source_image);
//
//    /* find the "desired height" of this thumbnail, relative to the desired width  */
//    $desired_height = floor($height * ($desired_width / $width));
//
//    /* create a new, "virtual" image */
//    $virtual_image = imagecreatetruecolor($desired_width, $desired_height);
//
//    /* copy source image at a resized size */
//    imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
//
//    /* create the physical thumbnail image to its destination */
//    imagejpeg($virtual_image, $dest);
//}

function createThumbnail($filepath, $thumbpath, $thumbnail_width, $thumbnail_height, $background=false) {
    list($original_width, $original_height, $original_type) = getimagesize($filepath);
    if ($original_width > $original_height) {
        $new_width = $thumbnail_width;
        $new_height = intval($original_height * $new_width / $original_width);
    } else {
        $new_height = $thumbnail_height;
        $new_width = intval($original_width * $new_height / $original_height);
    }
    $dest_x = intval(($thumbnail_width - $new_width) / 2);
    $dest_y = intval(($thumbnail_height - $new_height) / 2);

    if ($original_type === 1) {
        $imgt = "ImageGIF";
        $imgcreatefrom = "ImageCreateFromGIF";
    } else if ($original_type === 2) {
        $imgt = "ImageJPEG";
        $imgcreatefrom = "ImageCreateFromJPEG";
    } else if ($original_type === 3) {
        $imgt = "ImagePNG";
        $imgcreatefrom = "ImageCreateFromPNG";
    } else {
        return false;
    }

    $old_image = $imgcreatefrom($filepath);
    $new_image = imagecreatetruecolor($thumbnail_width, $thumbnail_height); // creates new image, but with a black background

    // figuring out the color for the background
    if(is_array($background) && count($background) === 3) {
        list($red, $green, $blue) = $background;
        $color = imagecolorallocate($new_image, $red, $green, $blue);
        imagefill($new_image, 0, 0, $color);
        // apply transparent background only if is a png image
    } else if($background === 'transparent' && $original_type === 3) {
        imagesavealpha($new_image, TRUE);
        $color = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
        imagefill($new_image, 0, 0, $color);
    }

    imagecopyresampled($new_image, $old_image, $dest_x, $dest_y, 0, 0, $new_width, $new_height, $original_width, $original_height);
    $imgt($new_image, $thumbpath);
    return file_exists($thumbpath);
}

foreach($files as $key) {
    if ($key != '.' && $key != '..' && $key != '.DS_Store') {
        $te = explode('.', $key);
        $extzz = pathinfo($key, PATHINFO_EXTENSION);
        if ($extzz != '') {
            $test = 'file';
            $fileOut[] = array('tumbnail' => $directory.'/thumbnail/'.$key, 'name' => $key, 'link' => '../img/' . $key, 'size' => 'Not Captured', 'type' => $test);

            //make_thumb('../img/'.$key.'');

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
usort($dirOut, 'sortByName');

$listView .= '<table id="medlist" class="table table-bordered">
        <thead>
        <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Date</th>
            <th>File Size</th>
            <th style="text-align: center" class="no-sort">Actions</th>

        </tr>
        </thead>
        <tbody>';

function filesize_formatted($path)
{
    $size = filesize($path);
    $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $power = $size > 0 ? floor(log($size, 1024)) : 0;
    return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
}

if(isset($_REQUEST["dirset"])){
    for ($y = 0; $y <= count($dirOut); $y++) {
        $returnTarget = $_REQUEST["returntarget"];
        if ($dirOut[$y]["type"] == 'directory' && $dirOut[$y]["name"] != 'thumbnail') {
            //$outss .= '<a class="col-md-2 col-sm-2 col-xs-3" style="padding: 0px 5px 0px; display:inline-block" href="javascript:migrate(\''.$directory .'/'. $dirOut[$y]["name"] . '\')"><div style="padding: 5px; border:solid thick #fff; background: #efefef"><img style="width:100%" src="img/folder.png"/><span style="display:block; padding:5px; background:#fff; text-align:center; position:absolute; bottom:0px; left:0px; width:100%; overflow:hidden; height:25px">' . $dirOut[$y]["name"] . '</span></div></a>';
            $outss .= '<div class="col-md-2 col-sm-2 col-xs-3 folderset" data-object="' . $directory . '/' . $dirOut[$y]["name"] . '/" style="padding: 5px; border:solid thick #fff; background: #efefef;" onclick="window.parent.setImgDat(\'' . $returnTarget . '\',\'' . $directory . '/' . $dirOut[$y]["name"] . '/\',\'' . $altText . '\');"><img style="width:100%" src="img/folder.png"/><div class="" style="display:block; padding:5px; text-align:center;  background:#333; color:#fff; position:absolute; bottom:0px; left:0px; width:100%; z-index:700; height:25px"><a href="#" style="color:#fff; margin:5px"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> <a href="#" style="color:#fff; margin:5px"><i class="fa fa-trash" aria-hidden="true"></i></a></div><span class="editobj" style="display:block; padding:5px; background:#fff; text-align:center; position:absolute; bottom:0px; left:0px; width:100%; overflow:hidden; height:25px; z-index:800">' . $dirOut[$y]["name"] . '</span></div>';

            $listView .= '<tr>
            <td style="max-width: 20%; padding: 5px"><a href="javascript:void(0)" class="folderset" data-object="' . $directory . '/' . $dirOut[$y]["name"] . '/" onclick="window.parent.setImgDat(\'' . $returnTarget . '\',\'' . $directory . '/' . $dirOut[$y]["name"] . '/\',\'\');"> <i class="fas fa-folder"></i> ' . $dirOut[$y]["name"] . '</a></td>
            <td>Directory</td>
            <td>n/a</td>
            <td>n/a</td>
            <td style="text-align: center"><a href="javascript:void(0)" class="folderset" data-object="' . $directory . '/' . $dirOut[$y]["name"] . '/" onclick="migrate(\'' . $directory . '/' . $dirOut[$y]["name"] . '\')">Open</a></td>
           
        </tr>';
        }
    }
}else {


    for ($y = 0; $y <= count($dirOut); $y++) {
        if ($dirOut[$y]["type"] == 'directory' && $dirOut[$y]["name"] != 'thumbnail') {
            //$outss .= '<a class="col-md-2 col-sm-2 col-xs-3" style="padding: 0px 5px 0px; display:inline-block" href="javascript:migrate(\''.$directory .'/'. $dirOut[$y]["name"] . '\')"><div style="padding: 5px; border:solid thick #fff; background: #efefef"><img style="width:100%" src="img/folder.png"/><span style="display:block; padding:5px; background:#fff; text-align:center; position:absolute; bottom:0px; left:0px; width:100%; overflow:hidden; height:25px">' . $dirOut[$y]["name"] . '</span></div></a>';
            $outss .= '<div class="col-md-2 col-sm-2 col-xs-3 folderset" data-object="' . $directory . '/' . $dirOut[$y]["name"] . '" style="padding: 5px; border:solid thick #fff; background: #efefef;" onclick="migrate(\'' . $directory . '/' . $dirOut[$y]["name"] . '\')"><div style="position: absolute;"><button class="btn btn-xs btn-default" style="padding: 1px 7px; text-align: center" event.stopPropagation(); onclick="event.stopPropagation(); changeDirName(\''.$dirOut[$y]["name"].'\')"><i class="fas fa-edit"></i></button>  <button class="btn btn-xs btn-danger" style="padding: 1px 7px; text-align: center" event.stopPropagation(); onclick="event.stopPropagation(); dirTrash(\'../' . $directory . '/' . $dirOut[$y]["name"] . '\')"><i class="fas fa-trash-alt"></i></button></div><img style="width:100%" src="img/folder.png"/><div class="" style="display:block; padding:5px; text-align:center;  background:#333; color:#fff; position:absolute; bottom:0px; left:0px; width:100%; z-index:700; height:25px"><a href="#" style="color:#fff; margin:5px"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> <a href="#" style="color:#fff; margin:5px"><i class="fa fa-trash" aria-hidden="true"></i></a></div><span class="editobj" style="display:block; padding:5px; background:#fff; text-align:center; position:absolute; bottom:0px; left:0px; width:100%; overflow:hidden; height:25px; z-index:800">' . $dirOut[$y]["name"] . '</span></div>';

            $listView .= '<tr>
            <td style="max-width: 20%; padding: 5px"><a href="javascript:void(0)" class="folderset" data-object="' . $directory . '/' . $dirOut[$y]["name"] . '" onclick="migrate(\'' . $directory . '/' . $dirOut[$y]["name"] . '\')"> <i class="fas fa-folder"></i> ' . $dirOut[$y]["name"] . '</a></td>
            <td>Directory</td>
            <td>n/a</td>
            <td>n/a</td>
            <td style="text-align: center"><a href="javascript:void(0)" class="folderset" data-object="' . $directory . '/' . $dirOut[$y]["name"] . '" onclick="migrate(\'' . $directory . '/' . $dirOut[$y]["name"] . '\')">Open</a></td>
           
        </tr>';
        }
    }

    for ($i = 0; $i <= count($fileOut); $i++) {
        if ($fileOut[$i]["type"] == 'file') {
            $tes = substr($fileOut[$i]["name"], strrpos($fileOut[$i]["name"], '.') + 1);


            list($width, $height) = getimagesize($directory . '/' . $fileOut[$i]["name"]);


            if ($width != '') {
                if (file_exists($fileOut[$i]["tumbnail"])) {
//                    $image = '<img class="lazy" style="width:100%" src="' . $fileOut[$i]["tumbnail"] . '"/>';
//                    $backset = '';


                    $image = '<img style="width:100%" src="img/isimg_but.png"/>';
                    $backset = 'background-image:url(\'' . $fileOut[$i]["tumbnail"] . '\'); background-size:cover; background-repeat:no-repeat; background-position: center center;';


                    $filetyp = 'data-toggle="lightbox" data-type="image" data-gallery="gall-images"';
                } else {
                    $image = '<img style="width:100%" src="img/isimg_but.png"/>';
                    $backset = 'background-image:url(\'' . $directory . '/' . $fileOut[$i]["name"] . '\'); background-size:cover; background-repeat:no-repeat; background-position: center center;';


                    $filename = $directory.'/thumbnail';

                    if (!file_exists($filename)) {
                        mkdir($directory."/thumbnail", 0777);
                    } else {
                        ///DO NOTHING//
                    }

                    createThumbnail($directory . '/' . $fileOut[$i]["name"],$directory."/thumbnail/".$fileOut[$i]["name"], 391, 321);
                }
            } else {

                ///$imageFileType != "pdf" && $imageFileType != "txt" && $imageFileType != "rtf"  && $imageFileType != "doc"
                /// && $imageFileType != "docx" && $imageFileType != "xls" && $imageFileType != "xlsx" && $imageFileType != "xlsm" && $imageFileType != "zip" && $imageFileType != "mov" && $imageFileType != "webm" && $imageFileType != "mp4" && $imageFileType != "wav" && $imageFileType != "mp3" && $imageFileType != "mpeg" && $imageFileType != "wmv" && $imageFileType != "avi"

                $backset = '';
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

            $objPath = '' . $directory . '/' . $fileOut[$i]["name"] . '';
            $objPath2 = '' . $directory . '/thumbnail/' . $fileOut[$i]["name"] . '';

            //mkdir( '' . $directory . '/thumbnail', 0777);

            ///DO THUMB HERE///
            //createThumbnail($objPath,$objPath2,'300px','300px');

            if (isset($_REQUEST["typeset"])) {
                include('inc/harness.php');

                $a = $data->query("SELECT * FROM media WHERE media_name = '" . $fileOut[$i]["name"] . "'")or die($data->error);
                $b = $a->fetch_array();
                if ($_REQUEST["typeset"] == 'core' || $_REQUEST["typeset"] == null) {
                    if ($tes == 'pdf') {
                        //$outss .= '<div id="item-' . $fileOut[$i]["name"] . '" data-imgpath="'.$objPath.'" class="col-md-2 col-sm-2 col-xs-3 object" style="padding: 5px; border:solid thick #fff; background: #efefef; ' . $backset . '"><a class="fancybox" '.$filetyp.'   href="' . $objPath . '" target="_blank">' . $image . '</a><div class="" style="display:block; padding:5px; text-align:center;  background:#333; color:#fff; position:absolute; bottom:0px; left:0px; width:100%; z-index:700; height:25px"><a href="javascript:renameFile(\'' . $objPath . '\')" style="color:#fff; margin:5px"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> <a href="javascript:deleteFile(\'' . $objPath . '\')" style="color:#fff; margin:5px"><i class="fa fa-trash" aria-hidden="true"></i></a> <a href="' . $objPath . '" download="' . $fileOut[$i]["name"] . '" style="color:#fff; margin:5px"><i class="fa fa-download" aria-hidden="true"></i></a></div><span class="editobj" style="display:block; padding:5px; background:#fff; text-align:center; position:absolute; bottom:0px; left:0px; width:100%; overflow:hidden; height:25px; z-index:800">' . $fileOut[$i]["name"] . '</span></div>';
                        //$outss .= '<div class="col-md-2 col-sm-2 col-xs-3 object" data-imgpath="'.$objPath.'" data-fileid="'.$b["id"].'" style="padding: 5px; border:solid thick #efefef; background: #efefef; '.$backset.'"><div class="imgholds">'.$image.'</div></div>';

                        $fileSize = filesize_formatted($objPath);

                        $cleanName = strlen($fileOut[$i]["name"]);

                        if ($cleanName > 20) {
                            $extz = pathinfo($fileOut[$i]["name"], PATHINFO_EXTENSION);
                            $cleanName = substr($fileOut[$i]["name"], 0, 20) . '...';
                        } else {
                            $cleanName = $fileOut[$i]["name"];
                        }


                        if(function_exists('mime_content_type')) {
                            $memiInfo = mime_content_type($objPath);
                        }else{
                            $memiInfo = mime_content_type_fallback($objPath);
                        }

                        $outss .= '<div class="col-md-2 col-sm-2 col-xs-3 object" data-imgpath="' . $objPath . '" data-fileid="' . $b["id"] . '" style="padding: 5px; border:solid thick #efefef; background: #efefef; ' . $backset . '"><div class="imgholds"><div style="position: absolute; bottom: 0; background: #fff; left: 0; padding: 3px; overflow: hidden; text-overflow: ellipsis; width:100%; text-align: center">'.$cleanName.' </div>' . $image . '</div></div>';
                        $listView .= '<tr>
            <td style="max-width: 20%">' . $cleanName . '</td>
            <td>' . $memiInfo . '</td>
            <td>' . date('F j, Y', $b["date_uploaded"]) . '</td>
            <td>' . $fileSize . '</td>
            <td style="text-align: center"><button class="btn btn-primary btn-sm object" data-imgpath="' . $objPath . '" data-fileid="' . $b["id"] . '">View</button></td>
        </tr>';
                    } else {
                        // $outss .= '<div id="item-' . $fileOut[$i]["name"] . '" class="col-md-2 col-sm-2 col-xs-3 object" data-imgpath="'.$objPath.'" style="padding: 5px; border:solid thick #fff; background: #efefef; ' . $backset . '"><a class="fancybox" '.$filetyp.'   href="' . $objPath . '">' . $image . '</a><div class="" style="display:block; padding:5px; text-align:center;  background:#333; color:#fff; position:absolute; bottom:0px; left:0px; width:100%; z-index:700; height:25px"><a href="javascript:renameFile(\'' . $objPath . '\')" style="color:#fff; margin:5px"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> <a href="javascript:deleteFile(\'' . $objPath . '\')" style="color:#fff; margin:5px"><i class="fa fa-trash" aria-hidden="true"></i></a> <a href="' . $objPath . '" download="' . $fileOut[$i]["name"] . '" style="color:#fff; margin:5px"><i class="fa fa-download" aria-hidden="true"></i></a></div><span class="editobj" style="display:block; padding:5px; background:#fff; text-align:center; position:absolute; bottom:0px; left:0px; width:100%; overflow:hidden; height:25px; z-index:800">' . $fileOut[$i]["name"] . '</span></div>';
                        //$outss .= '<div class="col-md-2 col-sm-2 col-xs-3 object" data-imgpath="'.$objPath.'" data-fileid="'.$b["id"].'" style="padding: 5px; border:solid thick #efefef; background: #efefef; '.$backset.'"><div class="imgholds">'.$image.'</div></div>';
                        $fileSize = filesize_formatted($objPath);

                        $cleanName = strlen($fileOut[$i]["name"]);

                        if ($cleanName > 20) {
                            $extz = pathinfo($fileOut[$i]["name"], PATHINFO_EXTENSION);
                            $cleanName = substr($fileOut[$i]["name"], 0, 20) . '...';
                        } else {
                            $cleanName = $fileOut[$i]["name"];
                        }

                        if(function_exists('mime_content_type')) {
                            $memiInfo = mime_content_type($objPath);
                        }else{
                            $memiInfo = mime_content_type_fallback($objPath);
                        }

                        $outss .= '<div class="col-md-2 col-sm-2 col-xs-3 object lazy" data-imgpath="' . $objPath . '" data-fileid="' . $b["id"] . '" style="padding: 5px; border:solid thick #efefef; background: #efefef; ' . $backset . '"><div class="imgholds"><div style="position: absolute; bottom: 0; background: #fff; left: 0; padding: 3px; overflow: hidden; text-overflow: ellipsis; width:100%; text-align: center">'.$cleanName.' </div>' . $image . '</div></div>';
                        $listView .= '<tr>
            <td style="max-width: 20%">' . $cleanName . '</td>
            <td>' . $memiInfo. '</td>
            <td>' . date('F j, Y', $b["date_uploaded"]) . '</td>
            <td>' . $fileSize . '</td>
            <td style="text-align: center"><button class="btn btn-primary btn-sm object" data-imgpath="' . $objPath . '" data-fileid="' . $b["id"] . '"><i class="fas fa-cog"></i></button></td>
        </tr>';
                    }

                }

                if ($_REQUEST["typeset"] == 'simple') {
                    //$outss .= '<div id="item-' . $fileOut[$i]["name"] . '" class="col-md-2 col-sm-2 col-xs-3 object" data-imgpath="'.$objPath.'" style="padding: 5px; border:solid thick #fff; background: #efefef; ' . $backset . '"><div class="imgholds" onClick="setsimple(\''.$objPath.'\',\''.$_REQUEST["fldset"].'\')">' . $image . '</div><div class="" style="display:block; padding:5px; text-align:center;  background:#333; color:#fff; position:absolute; bottom:0px; left:0px; width:100%; z-index:700; height:25px"><a href="javascript:renameFile(\'' . $objPath . '\')" style="color:#fff; margin:5px"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> <a href="javascript:deleteFile(\'' . $objPath . '\')" style="color:#fff; margin:5px"><i class="fa fa-trash" aria-hidden="true"></i></a> <a href="' . $objPath . '" download="' . $fileOut[$i]["name"] . '" style="color:#fff; margin:5px"><i class="fa fa-download" aria-hidden="true"></i></a></div><span class="editobj" style="display:block; padding:5px; background:#fff; text-align:center; position:absolute; bottom:0px; left:0px; width:100%; overflow:hidden; height:25px; z-index:800">' . $fileOut[$i]["name"] . '</span></div>';
                    $fileSize = filesize_formatted($objPath);

                    $cleanName = strlen($fileOut[$i]["name"]);

                    if ($cleanName > 20) {
                        $extz = pathinfo($fileOut[$i]["name"], PATHINFO_EXTENSION);
                        $cleanName = substr($fileOut[$i]["name"], 0, 20) . '...';
                    } else {
                        $cleanName = $fileOut[$i]["name"];
                    }

                    if(function_exists('mime_content_type')) {
                        $memiInfo = mime_content_type($objPath);
                    }else{
                        $memiInfo = mime_content_type_fallback($objPath);
                    }

                    $outss .= '<div class="col-md-2 col-sm-2 col-xs-3 object" data-imgpath="' . $objPath . '" data-fileid="' . $b["id"] . '" style="padding: 5px; border:solid thick #efefef; background: #efefef; ' . $backset . '"><div class="imgholds">' . $image . '</div></div>';
                    $listView .= '<tr>
            <td style="max-width: 20%">' . $cleanName . '</td>
            <td>' . $memiInfo. '</td>
            <td>' . date('F j, Y', $b["date_uploaded"]) . '</td>
            <td>' . $fileSize . '</td>
            <td style="text-align: center"><button class="btn btn-primary btn-sm object" data-imgpath="' . $objPath . '" data-fileid="' . $b["id"] . '"><i class="fas fa-cog"></i></button> </td>
        </tr>';
                }


            } else {

                include('inc/harness.php');

                $a = $data->query("SELECT * FROM media WHERE media_name = '" . $fileOut[$i]["name"] . "'");
                $b = $a->fetch_array();

                $fileSize = filesize_formatted($objPath);

                $cleanName = strlen($fileOut[$i]["name"]);

                if ($cleanName > 20) {
                    $extz = pathinfo($fileOut[$i]["name"], PATHINFO_EXTENSION);
                    $cleanName = substr($fileOut[$i]["name"], 0, 20) . '...';
                } else {
                    $cleanName = $fileOut[$i]["name"];
                }

                if(function_exists('mime_content_type')) {
                    $memiInfo = mime_content_type($objPath);
                }else{
                    $memiInfo = mime_content_type_fallback($objPath);
                }

                $outss .= '<div class="col-md-2 col-sm-2 col-xs-3 object" data-imgpath="' . $objPath . '" data-fileid="' . $b["id"] . '" style="padding: 5px; border:solid thick #efefef; background: #efefef; ' . $backset . '"><div class="imgholds">' . $image . '</div></div>';
                $listView .= '<tr>
            <td style="max-width: 20%">' . $cleanName . '</td>
            <td>' . $memiInfo. '</td>
            <td>' . date('F j, Y', $b["date_uploaded"]) . '</td>
            <td>' . $fileSize . '</td>
            <td style="text-align: center"><button class="btn btn-primary btn-sm object" data-imgpath="' . $objPath . '" data-fileid="' . $b["id"] . '"><i class="fas fa-cog"></i></button></td>
        </tr>';

            }


        }
    }
}

$listView .= '</table>';

?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <!-- Bootstrap CSS -->
    <!-- DataTables -->
    <link href="plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Multi Item Selection examples -->
    <link href="plugins/datatables/select.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <link href="plugins/switchery/switchery.min.css" rel="stylesheet" />
    <link href="plugins/sweet-alert/sweetalert2.min.css" rel="stylesheet">


    <link rel="stylesheet" href="assets/css/dropzone.css">

    <title>Media Manager</title>
    <style>
        body{
            margin: 10px;
        }

        .headeracts{
            border-bottom: solid thin #efefef; padding: 10px;
        }

        .infobar-media{
            background: #efefef;
            height: 100%;
        }

        .modal-lg {
            max-width: 80%;
        }

        .btn-default{
            background: #717171;
            color: #fff;
        }
        .pace {
            -webkit-pointer-events: none;
            pointer-events: none;

            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        .pace-inactive {
            display: none;
        }

        .pace .pace-progress {
            background: #f9cd48;
            position: fixed;
            z-index: 2000;
            top: 0;
            right: 100%;
            width: 100%;
            height: 2px;
            z-index: 3000;
        }

        .pace {
            -webkit-pointer-events: none;
            pointer-events: none;

            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;

            z-index: 3000;
            position: fixed;
            margin: auto;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            height: 5px;
            width: 200px;
            background: #fff;
            border: 1px solid #f9cd48;

            overflow: hidden;
        }

        .pace .pace-progress {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            -ms-box-sizing: border-box;
            -o-box-sizing: border-box;
            box-sizing: border-box;

            -webkit-transform: translate3d(0, 0, 0);
            -moz-transform: translate3d(0, 0, 0);
            -ms-transform: translate3d(0, 0, 0);
            -o-transform: translate3d(0, 0, 0);
            transform: translate3d(0, 0, 0);

            max-width: 200px;
            position: fixed;
            z-index: 2000;
            display: block;
            position: absolute;
            top: 0;
            right: 100%;
            height: 100%;
            width: 100%;
            background: #f9cd48;
        }

        .pace.pace-inactive {
            display: none;
        }

        .page_overlay{
            position: fixed;
            top:0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #fff;
            z-index: 2000;
        }

        .table td {
            padding: 5px;
            vertical-align: inherit;
            border-top: 1px solid #dee2e6;
            font-size: 13px;
        }

        .no-sort::after { display: none!important; }
        .no-sort::before { display: none!important; }

        .no-sort { pointer-events: none!important; cursor: default!important; }


        #linklist_filter, #medlist_filter{
            text-align: right;
        }

        .lds-ring {
            display: inline-block;
            position: absolute;
            width: 80px;
            height: 80px;
            z-index: 900;
            left:50%;
            margin-left: -40px;
            top: 40%;
        }
        .lds-ring div {
            box-sizing: border-box;
            display: block;
            position: absolute;
            width: 64px;
            height: 64px;
            margin: 8px;
            border: 8px solid #ffc401;
            border-radius: 50%;
            animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
            border-color: #ffc401 transparent transparent transparent;
        }
        .lds-ring div:nth-child(1) {
            animation-delay: -0.45s;
        }
        .lds-ring div:nth-child(2) {
            animation-delay: -0.3s;
        }
        .lds-ring div:nth-child(3) {
            animation-delay: -0.15s;
        }
        @keyframes lds-ring {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }


    </style>
</head>
<body>
<div class="imgeds-set" style="position: fixed; top: 0; left: 0; z-index: 9000; background: #fff; width: 100%; height: 100%; display: none"></div>
<div id="page_overlay" class="page_overlay"></div>

<div class="modal large" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Modal body text goes here.</p>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>


<?php
if($_REQUEST["directory"] != ''){
    $currdirectory = $_REQUEST["directory"];
}else{
    $currdirectory = '../img';
}
?>
<div class="row" style="margin: 0;">
    <div style="height: 30px; width:100%"></div>
    <ul class="nav nav-tabs" role="tablist" style="width: 100%">
        <li class="nav-item">
            <a class="nav-link active" href="#media" role="tab" data-toggle="tab">Media</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#system_links" role="tab" data-toggle="tab">System Links</a>
        </li>

    </ul>
    <div class="col-md-12" style="">


        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="media">

<div class="headeracts" style="background: #fff; z-index: 1000">
<h2>Media Manager</h2>

    <button class="btn btn-primary btn-sm pull-left" onclick="openUpload()">Upload Files</button>
    <div class="btn-group pull-right" role="group" aria-label="Basic example" style="padding: 20px">
        <button type="button" class="btn btn-secondary btn-sm"><i class="fas fa-th-large" onclick="setView('box')"></i></button>
        <button type="button" class="btn btn-secondary btn-sm"><i class="fas fa-list" onclick="setView('list')"></i></button>
    </div>
    <button class="btn btn-outline-dark btn-sm float-right" style="margin-top:20px;" onclick="openFilesTypes()">File Types</button> <button class="btn btn-warning btn-sm float-right" style="margin:20px; color:#fff" onclick="addDirs()"><i class="fas fa-folder"></i> Create Directory</button>

    <form style="display: none" action="inc/media-handler.php?action=upload&directory=<?php echo $currdirectory ?>" class="dropzone">
        <div class="fallback">
            <input name="file" type="file" multiple />
        </div>
    </form>
    <ol class="breadcrumb" style="z-index: 10">
        <li class="breadcrumb-item"><?php echo $dirObj; ?></li>
    </ol>

    <div class="plslod"></div>

</div>







                    <br>
                    <div class="row">
                    <?php
                    if(isset($viewType)){
                        if($viewType == 'box'){
                            echo $outss;
                        }else{
                            echo $listView;
                        }
                    }

                    ?>
                </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="system_links">
                    <br>
                    <table id="linklist" class="table-bordered table">
                        <thead><tr><th>Name</th><th style="text-align: right">Action</th></tr></thead>
                        <tbody>
                    <?php
                        include('inc/harness.php');
                        $a = $data->query("SELECT * FROM pages WHERE active = 'true'");
                        while($b = $a->fetch_array()){
                            echo '<tr><td style="padding: 5px">'.$b["page_name"].'</td><td style="padding: 5px; text-align: right"><button class="btn btn-primary btn-sm" onclick="window.parent.setImgDat(\''.$_REQUEST["returntarget"].'\',\''.$b["page_name"].'\')"><i class="fas fa-check-square"></i></button> </td></tr>';
                        }
                    ?>
                        </tbody>
                    </table>
                </div>



           </div></div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.0.min.js" integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<!-- Required datatable js -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap4.min.js"></script>
<!-- Buttons examples -->
<script src="plugins/datatables/dataTables.buttons.min.js"></script>
<script src="plugins/datatables/buttons.bootstrap4.min.js"></script>
<script src="plugins/datatables/jszip.min.js"></script>
<script src="plugins/datatables/pdfmake.min.js"></script>
<script src="plugins/datatables/vfs_fonts.js"></script>
<script src="plugins/datatables/buttons.html5.min.js"></script>
<script src="plugins/datatables/buttons.print.min.js"></script>
<!-- Key Tables -->
<script src="plugins/datatables/dataTables.keyTable.min.js"></script>

<!-- Responsive examples -->
<script src="plugins/datatables/dataTables.responsive.min.js"></script>
<script src="plugins/datatables/responsive.bootstrap4.min.js"></script>

<!-- Selection table -->
<script src="plugins/datatables/dataTables.select.min.js"></script>
<script src="assets/js/pace.min.js"></script>
<script src="assets/js/dropzone.js"></script>
<script src="plugins/sweet-alert/sweetalert2.min.js"></script>
<script src="assets/pages/jquery.sweet-alert.init.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.plugins.min.js"></script>
<script>

    $(function() {
        $('.lazy').Lazy();
    });

    // This example uses jQuery so it creates the Dropzone, only when the DOM has
    // loaded.

    // Disabling autoDiscover, otherwise Dropzone will try to attach twice.
    Dropzone.autoDiscover = false;
    // or disable for specific dropzone:
    // Dropzone.options.myDropzone = false;

    $(function() {
        // Now that the DOM is fully loaded, create the dropzone, and setup the
        // event listeners
        var myDropzone = new Dropzone(".dropzone");

        myDropzone.on("queuecomplete", function(file, res) {
            if ( myDropzone.files[0].status != Dropzone.SUCCESS && myDropzone.getQueuedFiles().length <= 1 ) {
                // solve for dropzone.js bug : https://github.com/enyo/dropzone/issues/578
                // if the first file is invalid & there is nothing in the queue, then do nothing
                // this event has been fired prematurely
            } else {
                // do stuff
                location.reload();
            }
        });

        $(".object").on('click',function(){

            var fileId = $(this).data('fileid');
            var filePath = $(this).data('imgpath');

            $.ajax({
                url: 'inc/media-handler.php?action=getfiledetails&fileid='+fileId+'&returntarget=<?php echo $_REQUEST["returntarget"]; ?>&trupath='+filePath+'&directory=<?php echo $currdirectory; ?>',
                success: function(data){
                    $(".modal .modal-title").html('File Details');
                    $(".modal-body").html(data);
                    $(".modal").modal();
                }
            })

            $(".modal").on("hidden.bs.modal", function () {
                $(".modal-body").html('');
            });
        })
    });

    function processTextData(){
        $("#imgdata").submit(function(e) {

            e.preventDefault(); // avoid to execute the actual submit of the form.

            var form = $(this);

            $.ajax({
                type: "POST",
                url: 'inc/media-handler.php?action=processmedia',
                data: form.serialize(), // serializes the form's elements.
                success: function(data)
                {
                    swal({
                        title: 'Image Content Saved',
                        text: 'I will now close.',
                        type: 'success',
                        timer: 2000
                    }).then(
                        function () {
                        },
                        // handling the promise rejection
                        function (dismiss) {
                            if (dismiss === 'timer') {

                            }
                        }
                    )
                }
            });


        });
        
        $("#imgdata").submit();
    }

    function migrate(theval){
        window.location.href = 'media_manager.php?typeset=<?php echo $_REQUEST["typeset"]; ?>&fldset=<?php echo $_REQUEST["fldset"]; ?>&mceid=<?php echo $_REQUEST["mceid"]; ?>&directory='+theval+'&returntarget=<?php echo $_REQUEST["returntarget"]; ?>';
    }

    function openUpload(){
        $(".dropzone").toggle();
    }

    Pace.on("done", function() {
        $('#page_overlay').delay(300).fadeOut(600);
    });



        $(document).ready(function() {
            $('#medlist').DataTable({
                "paging": false
            });

            $('#linklist').DataTable({
                "paging": false
            });
        } );

        function openEditor(img){
            $(".imgeds-set").html('<div style="background: #fff; padding: 3px; text-align: right"><a href=""><i class="fas fa-times"></i> Close Editor</a></div><iframe style="width: 100%; height: 100%; border: none" src="assets/imgedits/pixie/index.php?'+img+'"></iframe>');
            $(".imgeds-set").show();
        }

        function setView(vwtype){

            window.location.replace('<?php echo $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>&setviewsess='+vwtype);

            //alert('<?php echo $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>&setviewsess='+vwtype)
        }

    function addDirs(){
        $(".modal .modal-title").html('Create Directory');
        $(".modal-body").html("<form name='createdir' id='createdir' method='post' action=''><label>Directory Name</label><br><input class='form-control' type='text' name='directname' id='directname' value=''><br><button class='btn btn-warning' type=submit' >Create Directory</button> </form>");
        $(".modal").modal();
    }

    function itemDel(path){
        swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success mt-2',
            cancelButtonClass: 'btn btn-danger ml-2 mt-2',
            buttonsStyling: false
        }).then(function () {
            $.ajax({
                url: 'inc/media-handler.php?action=deleteitem&itempath='+path,
                success: function(data){
                    swal({
                        title: 'Deleted !',
                        text: "Your file has been deleted",
                        type: 'success',
                        confirmButtonClass: 'btn btn-confirm mt-2'
                    }).then(function () {
                        location.reload();
                    })

                    console.log(data);
                }
        })

        }, function (dismiss) {
            // dismiss can be 'cancel', 'overlay',
            // 'close', and 'timer'
            if (dismiss === 'cancel') {
                swal({
                        title: 'Cancelled',
                        text: "Your imaginary file is safe :)",
                        type: 'error',
                        confirmButtonClass: 'btn btn-confirm mt-2'
                    }
                )
            }
        })
    }

    function imgSaveSucc(){
        $(".imgeds-set").hide();
        swal({
            title: 'Image Saved',
            text: 'I will now close.',
            type: 'success',
            timer: 2000
        }).then(
            function () {
            },
            // handling the promise rejection
            function (dismiss) {
                if (dismiss === 'timer') {
                    $('.modal').on('hidden.bs.modal', function () {
                        location.reload();
                    });
                }
            }
        )
    }

    $(function(){
        $(".folderset").on('click',function(){


            $(".plslod").html('Please wait.. Loading.....');
            $("body").append('<div style="position: fixed; top: 0px; left: 0px; width: 100%; height: 100%; background: #fff; z-index: 800"></div>');
            $("body").append('<div class="lds-ring"><div></div><div></div><div></div><div></div></div>');
        })
    })

    function openFilesTypes(){
        $(".modal .modal-title").html('Allowed File Types');
        $.ajax({
            url: 'inc/media-handler.php?action=handeltypes',
            cache: false,
            success:function(data){

                $(".modal-body").html("<form name='modmedtypes' id='modmedtypes' method='post' action=''><label>File Types</label><br><small style='color: red'>Note! - Use caution when denoting which files types are allowed to upload to the media area.</small><br><input class='form-control' type='text' name='setfiletypes' id='setfiletypes' value='"+data+"'><br><button class='btn btn-warning' type=submit' >Save</button> </form>");
            }
        })

        $(".modal").modal();
    }

    function dirTrash(path){
        swal({
            title: 'Are you sure?',
            text: "Are you sure you want to delete this directory?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success mt-2',
            cancelButtonClass: 'btn btn-danger ml-2 mt-2',
            buttonsStyling: false
        }).then(function () {

            $.ajax({
                url: 'inc/media-handler.php?action=trashdir&dir='+path,
                success: function(data){
                    swal({
                        title: 'Deleted !',
                        text: "Directory has been deleted",
                        type: 'success',
                        confirmButtonClass: 'btn btn-confirm mt-2'
                    }).then(function () {
                        location.reload();
                    })
                }
            })

        }, function (dismiss) {
            // dismiss can be 'cancel', 'overlay',
            // 'close', and 'timer'
            if (dismiss === 'cancel') {
                swal({
                        title: 'Cancelled',
                        text: "Your directory is safe :)",
                        type: 'error',
                        confirmButtonClass: 'btn btn-confirm mt-2'
                    }
                )
            }
        })
    }

    function changeDirName(dirname){
        $('.modal .modal-title').text("Change Directory Name");
        $(".modal-body").html('<form id="dirnamechg" name="dirnamechg" method="post" action=""><label>Directory Name</label><br><input type="text" class="form-control" name="dirname" id="dirname" value="'+dirname+'"><br><button class="btn btn-success">Update</button></form>');
        $('.modal').modal();
    }



</script>

</body>
</html>