<?php

function resize_image($source_image, $destination_filename, $width = 200, $height = 150, $quality = 70, $crop = true)
{

    echo $source_image.'<br>'.$destination_filename;


    if( ! $image_data = getimagesize( $source_image ) )
    {
        return false;
    }


    switch( $image_data['mime'] )
    {
        case 'image/gif':
            $get_func = 'imagecreatefromgif';
            $suffix = ".gif";
            break;
        case 'image/jpeg';
            $get_func = 'imagecreatefromjpeg';
            $suffix = ".jpg";
            break;
        case 'image/png':
            $get_func = 'imagecreatefrompng';
            $suffix = ".png";
            break;
    }

    $img_original = call_user_func( $get_func, $source_image );
    $old_width = $image_data[0];
    $old_height = $image_data[1];
    $new_width = $width;
    $new_height = $height;
    $src_x = 0;
    $src_y = 0;
    $current_ratio = round( $old_width / $old_height, 2 );
    $desired_ratio_after = round( $width / $height, 2 );
    $desired_ratio_before = round( $height / $width, 2 );

    echo $old_width;

    if( $old_width < $width || $old_height < $height )
    {
        /**
         * The desired image size is bigger than the original image.
         * Best not to do anything at all really.
         */
        return false;
    }


    /**
     * If the crop option is left on, it will take an image and best fit it
     * so it will always come out the exact specified size.
     */
    if( $crop )
    {
        /**
         * create empty image of the specified size
         */
        $new_image = imagecreatetruecolor( $width, $height );

        /**
         * Landscape Image
         */
        if( $current_ratio > $desired_ratio_after )
        {
            $new_width = $old_width * $height / $old_height;
        }

        /**
         * Nearly square ratio image.
         */
        if( $current_ratio > $desired_ratio_before && $current_ratio < $desired_ratio_after )
        {
            if( $old_width > $old_height )
            {
                $new_height = max( $width, $height );
                $new_width = $old_width * $new_height / $old_height;
            }
            else
            {
                $new_height = $old_height * $width / $old_width;
            }
        }

        /**
         * Portrait sized image
         */
        if( $current_ratio < $desired_ratio_before  )
        {
            $new_height = $old_height * $width / $old_width;
        }

        /**
         * Find out the ratio of the original photo to it's new, thumbnail-based size
         * for both the width and the height. It's used to find out where to crop.
         */
        $width_ratio = $old_width / $new_width;
        $height_ratio = $old_height / $new_height;

        /**
         * Calculate where to crop based on the center of the image
         */
        $src_x = floor( ( ( $new_width - $width ) / 2 ) * $width_ratio );
        $src_y = round( ( ( $new_height - $height ) / 2 ) * $height_ratio );
    }
    /**
     * Don't crop the image, just resize it proportionally
     */
    else
    {
        if( $old_width > $old_height )
        {
            $ratio = max( $old_width, $old_height ) / max( $width, $height );
        }else{
            $ratio = max( $old_width, $old_height ) / min( $width, $height );
        }

        $new_width = $old_width / $ratio;
        $new_height = $old_height / $ratio;

        $new_image = imagecreatetruecolor( $new_width, $new_height );
    }

    /**
     * Where all the real magic happens
     */
    imagecopyresampled( $new_image, $img_original, 0, 0, $src_x, $src_y, $new_width, $new_height, $old_width, $old_height );

    /**
     * Save it as a JPG File with our $destination_filename param.
     */
    imagejpeg( $new_image, $destination_filename, $quality  );

    /**
     * Destroy the evidence!
     */
    imagedestroy( $new_image );
    imagedestroy( $img_original );

    /**
     * Return true because it worked and we're happy. Let the dancing commence!
     */
    //return true;
}

function is_image($path)
{
    $a = getimagesize($path);
    $image_type = $a[2];

    if(in_array($image_type , array(IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG , IMAGETYPE_BMP)))
    {
        return true;
    }
    return false;
}

if(isset($_FILES['file']['name'])) {

    $fileName =  basename($_FILES['file']['name']);
    $imageFileType = substr(strrchr($fileName, "."), 1);

if ($imageFileType != "png" && $imageFileType != "gif" && $imageFileType != "jpeg" && $imageFileType != "JPG" && $imageFileType != "jpg" && $imageFileType != "pdf" && $imageFileType != "txt" && $imageFileType != "rtf" && $imageFileType != "doc"
    && $imageFileType != "docx" && $imageFileType != "xls" && $imageFileType != "xlsx" && $imageFileType != "xlsm" && $imageFileType != "csv" && $imageFileType != "zip" && $imageFileType != "mov" && $imageFileType != "webm" && $imageFileType != "mp4" && $imageFileType != "wav" && $imageFileType != "mp3" && $imageFileType != "mp4" && $imageFileType != "mpeg" && $imageFileType != "wmv" && $imageFileType != "avi"
) {
    echo 'error type';
}else{
    echo 'good';

    if(isset($_REQUEST["directory"]) && $_REQUEST["directory"] != null){
        $uploaddir = '../../img/'.$_REQUEST["directory"].'/';
    }else{
        $uploaddir = '../../img/';
    }

    $uploadfile = $uploaddir . basename($_FILES['file']['name']);

    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
        $isImage = is_image($uploadfile);
        if($isImage == true){
            echo 'Image Uploaded';
            $thumbdirs = $uploaddir.'thumbnail/'.basename($_FILES['file']['name']);
            resize_image($uploadfile,$thumbdirs,'300', '224', 70, true);
        }else{
            echo 'File Uploaded';
        }
   // echo "File is valid, and was successfully uploaded.\n";
} else {
    echo "Possible file upload attack!\n";
}

}
}







?>

<form name="testme" id="testme" method="post" action="" enctype="multipart/form-data">
    <input type="file" name="file">
    <button>Submit</button>
</form>
