<?php
error_reporting(0);
$act = $_REQUEST["action"];

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


if($act == 'upload') {
    include('harness.php');
//    require_once("../assets/tinypng/vendor/autoload.php");
//    \Tinify\setKey("37HJwRhQ6ZqMDXwPWR1dZLtyGHmgGzV9");
    
    $currentDir = $_REQUEST["directory"];

    if($currentDir != ''){
        $currentDir = $currentDir;
    }else{
        $currentDir = '../img';
    }

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





    $storeFolder = '../'.$currentDir.'/';
//    $myfile = fopen("readthis.txt", "w") or die("Unable to open file!");
//    fwrite($myfile, $storeFolder);
//    fclose($myfile);


    $filename = $storeFolder.'/thumbnail';

    if (!file_exists($filename)) {
        mkdir($storeFolder."/thumbnail", 0777);
    } else {
        ///DO NOTHING//
    }

    echo $storeFolder;

    if (!empty($_FILES)) {

        $tempFile = $_FILES['file']['tmp_name'];

        $targetPath = $storeFolder;  //4

        $targetFile = $targetPath . $_FILES['file']['name'];

        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

        $z = $data->query("SELECT media_types FROM site_settings WHERE id = '1'");
        $p = $z->fetch_array();

        $allowedFiles = explode(',', $p["media_types"]);

       /// $allowedFiles = array('jpg', 'JPG', 'JPEG', 'jpeg', 'png', 'gif', 'svg', 'doc', 'docx', 'txt', 'pdf', 'mov', 'mp3', 'mp4', 'webm', 'zip');

        if (in_array($ext, $allowedFiles)) {
            if(move_uploaded_file($tempFile, $targetFile)) {

                if(function_exists('mime_content_type')) {
                    $fileType = mime_content_type($targetFile);
                }else{
                    $fileType = mime_content_type_fallback($targetFile);
                }

                //resize_crop_image($targetFile, $storeFolder, 221);




                $fileName = $_FILES['file']['name'];
                //$fileSize = filesize_formatted($targetFile);

                if (@is_array(getimagesize($targetFile))) {

//                    $source = \Tinify\fromFile($storeFolder . $_FILES['file']['name']);
//                    $source->toFile($storeFolder . $_FILES['file']['name']);
                    createThumbnail($targetFile,$storeFolder."thumbnail/".$_FILES['file']['name'], 391, 321);


                } else {
                    $totalDim = '';
                }


                $a = $data->query("SELECT * FROM media WHERE media_name = '$fileName'");
                if ($a->num_rows > 0) {
                    $data->query("UPDATE media SET file_size = '$fileSize', file_type = '$fileType', date_uploaded = '" . time() . "', dimensions = '$totalDim' WHERE media_name = '$fileName'");
                } else {
                    $data->query("INSERT INTO media SET media_name = '" . $data->real_escape_string($fileName) . "', date_uploaded = '".time()."'");
                }
            }


        }
    }
}

if($act == 'getfiledetails'){
    function filesize_formatted($path)
    {
        $size = filesize($path);
        $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $power = $size > 0 ? floor(log($size, 1024)) : 0;
        return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
    }
    
    include('harness.php');
    $id = $_REQUEST["fileid"];
    if($id != null){

    }else{
        $fileName = basename($_REQUEST["trupath"]);
        $data->query("INSERT INTO media SET media_name = '".$data->real_escape_string($fileName)."', date_uploaded = '".time()."'");
        $id = $data->insert_id;
    }
    $a = $data->query("SELECT * FROM media WHERE id = '$id'");
    $b = $a->fetch_array();


    $dir = $_REQUEST["directory"].'/';

    $targetFile = '../'.$dir.$b["media_name"];
    $targetFileImg = $dir.$b["media_name"];
    //$targetFile2 = '../../../../img/'.$b["media_name"];
    $targetFile2 = '../../../'.$_REQUEST["trupath"];

    if($b["alt_text"] != null){
        $altText = $b["alt_text"];
    }else{
        $altText = '';
    }

    if(function_exists('mime_content_type')) {
        $fileType = mime_content_type($targetFile);
    }else{
        $fileType = mime_content_type_fallback($targetFile);
    }
    $fileName = $b["media_name"];
    $fileSize = filesize_formatted($targetFile);
    list($width, $height) = getimagesize($targetFile);
    $imageWidth = $width;
    $imageHeight = $height;
    $totalDim = $imageWidth . ' by ' . $imageHeight;
    $fileSplit = explode('/',$fileType);



    if($fileSplit[0] == 'image'){
        $fileImage = '<img style="width:100%; max-width:70%" class="" src="'.$targetFileImg.'">';
        $fileName = '<b>File Name:</b> '.$b["media_name"];
        $fileSize = '<b>File Size:</b> '.$fileSize;
        $dataupload = '<b>Uploaded on:</b> '.date('F j, Y',$b["date_uploaded"]);
        $dimensions = '<b>Dimensions:</b> '.$totalDim.' pixels';
        $fileType = '<b>File Type:</b> '.$fileType;

        $imgtitle = $b["title"];
        $imgcaption = $b["caption"];
        $imgalt = $b["alt_text"];
        $returnTarget = $_REQUEST["returntarget"];

        $saveButton = '<button type="button" class="btn btn-primary btn-sm" onclick="processTextData()">Save</button>';

        $cleanEditUrlOg = str_replace('../img/','',$targetFileImg);
        $cleanEditUrl = basename($cleanEditUrlOg);
        $cleanDirs = substr($cleanEditUrlOg, 0, strrpos( $cleanEditUrlOg, '/'));


        $cleanEditUrlOg = str_replace('/','~',$cleanDirs);


        if($cleanEditUrlOg != null){
            $dirsOu = 'dirs='.$cleanEditUrlOg.'&';
        }else{
            $dirsOu = '';
        }

        $editImageButton = '<button type="button" class="btn btn-default btn-sm" onclick="openEditor(\''.$dirsOu.'imagepath='.$cleanEditUrl.'\')"><i class="fas fa-crop"></i> Edit</button>';
        if($returnTarget != '') {
            $insertButton = '<button type="button" class="btn btn-success btn-sm" onclick="window.parent.setImgDat(\'' . $returnTarget . '\',\'' . $targetFile2 . '\',\'' . $altText . '\');">Select</button>';
        }else{
            $insertButton = '';
        }


        $form .= '<small><form name="imgdata" id="imgdata" method="post">';
        $form .= '<lable>Title:</lable><br><input type="text" class="form-control" name="imgtitle" id="imgtitle" value="'.$imgtitle.'"><br>';
        $form .= '<lable>Alt:</lable><br><input type="text" class="form-control" name="imgalt" id="imgalt" value="'.$imgalt.'"><br>';
        $form .= '<lable>Caption:</lable><br><textarea class="form-control" name="imgcaption">'.$imgcaption.'</textarea><br>';
        $form .= '<input type="hidden" name="imgids" id="imgids" value="'.$id.'">';
        $form .='</form></small>';
        $form .= ''.$insertButton.' '.$saveButton.' '.$editImageButton.' <button type="button" class="btn btn-warning btn-sm" onclick="itemDel(\''.$targetFileImg.'\')">Delete</button><br><br>';
    }else{

        $ext = pathinfo($b["media_name"], PATHINFO_EXTENSION);

        switch ($ext) {
            case 'tiff';
                $image = '<img style="width:100%; max-width:50%" src="img/gen_ico.png"/>';
                $filetyp = 'data-toggle="lightbox" data-type="image" data-gallery="gall-images"';
                break;
            case 'pdf':
                $image = '<img style="width:100%; max-width:50%" src="img/pdffile.png"/>';
                $filetyp = '';
                break;
            case 'txt':
                $image = '<img style="width:100%; max-width:50%" src="img/txtfile.png"/>';
                $filetyp = 'data-toggle="lightbox" data-type="url" data-gallery="gall-images"';
                break;
            case 'rtf':
                $image = '<img style="width:100%; max-width:50%" src="img/rtffile.png"/>';
                $filetyp = 'data-toggle="lightbox" data-type="url" data-gallery="gall-images"';
                break;
            case 'doc':
                $image = '<img style="width:100%; max-width:50%" src="img/word.png"/>';
                $filetyp = '';
                break;
            case 'docx':
                $image = '<img style="width:100%; max-width:50%" src="img/word.png"/>';
                $filetyp = '';
                break;
            case 'xls':
                $image = '<img style="width:100%; max-width:50%" src="img/csv.png"/>';
                $filetyp = '';
                break;
            case 'xlsx':
                $image = '<img style="width:100%; max-width:50%" src="img/csv.png"/>';
                $filetyp = '';
                break;
            case 'xlsm':
                $image = '<img style="width:100%; max-width:50%" src="img/csv.png"/>';
                $filetyp = '';
                break;
            case 'csv':
                $image = '<img style="width:100%; max-width:50%" src="img/csv.png"/>';
                $filetyp = '';
                break;
            case 'zip':
                $image = '<img style="width:100%; max-width:50%" src="img/zip.png"/>';
                $filetyp = '';
                break;
            case 'mov':
                //$image = '<img style="width:100%; max-width:50%" src="img/vidfile.png"/>';
                $base = explode('site-admin',$_SERVER['PHP_SELF']);
                $targetView = str_replace('../../','',$targetFile);
                $filePath = $_SERVER['SERVER_NAME'] . $base[0].$targetView;
                $image = '<iframe style="width:100%; border:none; height:300px" src="http://'.$filePath.'"></iframe>';
                $filetyp = 'data-toggle="lightbox" data-type="video" data-gallery="gall-images"';
                $backset = '';
                break;
            case 'MOV':
                //$image = '<img style="width:100%; max-width:50%" src="img/vidfile.png"/>';
                $base = explode('site-admin',$_SERVER['PHP_SELF']);
                $targetView = str_replace('../../','',$targetFile);
                $filePath = $_SERVER['SERVER_NAME'] . $base[0].$targetView;
                $image = '<iframe style="width:100%; border:none; height:300px" src="http://'.$filePath.'"></iframe>';
                $filetyp = 'data-toggle="lightbox" data-type="video" data-gallery="gall-images"';
                $backset = '';
                break;
            case 'webm':
                //$image = '<img style="width:100%; max-width:50%" src="img/vidfile.png"/>';
                $base = explode('site-admin',$_SERVER['PHP_SELF']);
                $targetView = str_replace('../../','',$targetFile);
                $filePath = $_SERVER['SERVER_NAME'] . $base[0].$targetView;
                $image = '<iframe style="width:100%; border:none; height:300px" src="http://'.$filePath.'"></iframe>';
                $filetyp = 'data-toggle="lightbox" data-type="video" data-gallery="gall-images"';
                $backset = '';
                break;
            case 'mp4':
                //$image = '<img style="width:100%; max-width:50%" src="img/vidfile.png"/>';
                $base = explode('site-admin',$_SERVER['PHP_SELF']);
                $targetView = str_replace('../../','',$targetFile);
                $filePath = $_SERVER['SERVER_NAME'] . $base[0].$targetView;
                $image = '<iframe style="width:100%; border:none; height:300px" src="http://'.$filePath.'"></iframe>';
                $filetyp = 'data-toggle="lightbox" data-type="video" data-gallery="gall-images"';
                $backset = '';
                break;
            case 'mpeg':
                //$image = '<img style="width:100%; max-width:50%" src="img/vidfile.png"/>';
                $base = explode('site-admin',$_SERVER['PHP_SELF']);
                $targetView = str_replace('../../','',$targetFile);
                $filePath = $_SERVER['SERVER_NAME'] . $base[0].$targetView;
                $image = '<iframe style="width:100%; border:none; height:300px" src="http://'.$filePath.'"></iframe>';
                $filetyp = 'data-toggle="lightbox" data-type="video" data-gallery="gall-images"';
                $backset = '';
                break;
            case 'wmv':
                //$image = '<img style="width:100%; max-width:50%" src="img/vidfile.png"/>';
                $base = explode('site-admin',$_SERVER['PHP_SELF']);
                $targetView = str_replace('../../','',$targetFile);
                $filePath = $_SERVER['SERVER_NAME'] . $base[0].$targetView;
                $image = '<iframe style="width:100%; border:none; height:300px" src="http://'.$filePath.'"></iframe>';
                $filetyp = 'data-toggle="lightbox" data-type="video" data-gallery="gall-images"';
                $backset = '';
                break;
            case 'avi':
                //$image = '<img style="width:100%; max-width:50%" src="img/vidfile.png"/>';
                $base = explode('site-admin',$_SERVER['PHP_SELF']);
                $targetView = str_replace('../../','',$targetFile);
                $filePath = $_SERVER['SERVER_NAME'] . $base[0].$targetView;
                $image = '<iframe style="width:100%; border:none; height:300px" src="http://'.$filePath.'"></iframe>';
                $filetyp = 'data-toggle="lightbox" data-type="video" data-gallery="gall-images"';
                $backset = '';
                break;
            case 'avi':
                //$image = '<img style="width:100%; max-width:50%" src="img/vidfile.png"/>';
                $base = explode('site-admin',$_SERVER['PHP_SELF']);
                $targetView = str_replace('../../','',$targetFile);
                $filePath = $_SERVER['SERVER_NAME'] . $base[0].$targetView;
                $image = '<iframe style="width:100%; border:none; height:300px" src="http://'.$filePath.'"></iframe>';
                $filetyp = 'data-toggle="lightbox" data-type="video" data-gallery="gall-images"';
                $backset = '';
                break;
            case 'mp3':
                //$image = '<img style="width:100%; max-width:50%" src="img/vidfile.png"/>';
                $base = explode('site-admin',$_SERVER['PHP_SELF']);
                $targetView = str_replace('../../','',$targetFile);
                $filePath = $_SERVER['SERVER_NAME'] . $base[0].$targetView;
                $image = '<iframe style="width:100%; border:none; height:300px" src="http://'.$filePath.'"></iframe>';
                $filetyp = 'data-toggle="lightbox" data-type="video" data-gallery="gall-images"';
                $backset = '';
                break;
            case 'wav':
                //$image = '<img style="width:100%; max-width:50%" src="img/vidfile.png"/>';
                $base = explode('site-admin',$_SERVER['PHP_SELF']);
                $targetView = str_replace('../../','',$targetFile);
                $filePath = $_SERVER['SERVER_NAME'] . $base[0].$targetView;
                $image = '<iframe style="width:100%; border:none; height:300px" src="http://'.$filePath.'"></iframe>';
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
        $fileImage = $image;
        $saveButton = '';
    }

    $returnTarget = $_REQUEST["returntarget"];

    if($returnTarget != '') {
        $insertButton = '<button type="button" class="btn btn-success btn-sm" onclick="window.parent.setImgDat(\'' . $returnTarget . '\',\'' . $targetFile2 . '\',\'' . $altText . '\');">Select</button>';
    }else{
        $insertButton = 'No Path';
    }

    $html .= '<div class="row">';
    $html .= '<div class="col-md-7" style="text-align: center">'.$fileImage.'<br><br><a href="inc/media-handler.php?action=download&file='.$targetFile.'"><i class="fas fa-download"></i> Download</a> </div>';
    $html .= '<div class="col-md-5" style="background: #efefef; white-space: nowrap;overflow: hidden;text-overflow: ellipsis;"><small>'.$fileName.'<br>'.$fileType.'<br>'.$dataupload.'<br>'.$fileSize.'<br>'.$dimensions.'</small><br><hr>'.$form.'</div>';
    $html .= '<div class="col-md-12" style="text-align: right; padding: 30px">'.$insertButton.'</div>';
    $html .= '</div>';

    echo $html;
}

if($act == 'testcompress'){
    $storeFolder = '../../img/';
    require_once("../assets/tinypng/vendor/autoload.php");
    \Tinify\setKey("37HJwRhQ6ZqMDXwPWR1dZLtyGHmgGzV9");
    $source = \Tinify\fromFile($storeFolder.'Screen Shot 2019-03-29 at 3.29.20 PM.png');
    $source->toFile($storeFolder.'things/Screen Shot 2019-03-29 at 3.29.20 PM.png');
}

if($act == 'processmedia'){
    include('harness.php');
    $imgtitle = $_POST["imgtitle"];
    $imgalt = $_POST["imgalt"];
    $imgcaption = $_POST["imgcaption"];
    $imgids = $_POST["imgids"];

    $data->query("UPDATE media SET title = '".$data->real_escape_string($imgtitle)."', caption = '".$data->real_escape_string($imgcaption)."', alt_text = '".$data->real_escape_string($imgalt)."' WHERE id = '$imgids'");
}

if($act == 'download'){
$file = $_REQUEST["file"];

    if(function_exists('mime_content_type')) {
        $fileType = mime_content_type($file);
    }else{
        $fileType = mime_content_type_fallback($file);
    }

header("Content-Description: File Transfer");
header("Content-Type: ".$fileType);
header("Content-Disposition: attachment; filename=" . basename($file));

readfile ($file);
exit();
}

if($act == 'deleteitem'){

    $str = basename($_REQUEST["itempath"]);
    $url = substr($_REQUEST["itempath"], 0, strrpos( $_REQUEST["itempath"], '/'));

    unlink('../'.$_REQUEST["itempath"]);

    if (@is_array(getimagesize($_REQUEST["itempath"]))) {
        unlink('../'.$url.'/thumbnail/'.$str);
    }

    echo '../'.$_REQUEST["itempath"];
}

if($act == 'handeltypes'){

    include('harness.php');

    $a = $data->query("SELECT media_types FROM site_settings WHERE id = '1'") or die($data->error);
    $b = $a->fetch_array();
    echo $b["media_types"];
}

if($act == 'trashdir'){
    $dirPath = $_REQUEST["dir"];
    $files1 = scandir($dirPath);

    function itDir($dir){
        echo $dir;
        $files1 = scandir($dir);
        foreach($files1 as $target){
            if($target != '.' && $target != '..'){
                if(is_dir($dir.'/'.$target)){
                    itDir($dir.'/'.$target);
                }else{
                    unlink($dir.'/'.$target);
                    echo $dir.'/'.$target;
                }

            }
        }
        rmdir($dir);
    }

    foreach($files1 as $target){
        if($target != '.' && $target != '..'){
            if(is_dir($dirPath.'/'.$target)){
                itDir($dirPath.'/'.$target);
                echo 'DIR'.$dirPath.'/'.$target;
            }else{
                unlink($dirPath.'/'.$target);
                echo $dirPath.'/'.$target;
            }

        }
    }

    rmdir($dirPath);
}
?>