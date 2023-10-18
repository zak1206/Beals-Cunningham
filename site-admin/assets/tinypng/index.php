<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css"
          href="css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <form method="post"
                  enctype="multipart/form-data" style="margin-top:20px;">
                <div class="form-group">
                    <label for="exampleInputFile">File input</label>
                    <input type="file" name="myfile"
                           id="exampleInputFile">
                </div>
                <button type="submit" name="submit"
                        class="btn btn-default">Submit</button>
            </form>
        </div>
        <div class="col-md-2"></div>
    </div>
</div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>

<?php
require_once("vendor/autoload.php");
\Tinify\setKey("37HJwRhQ6ZqMDXwPWR1dZLtyGHmgGzV9");

if (isset($_POST['submit'])) {
    $supported_image = array('gif', 'jpg', 'jpeg', 'png');

    if (isset($_FILES['myfile']['name'])
        && (0 == $_FILES['myfile']['error'])) {

        $src_file_name = $_FILES['myfile']['name'];

        $ext = strtolower(pathinfo($src_file_name,
            PATHINFO_EXTENSION));

        if (in_array($ext, $supported_image)) {
            if (!file_exists(getcwd(). '/uploads')) {
                mkdir(getcwd(). '/uploads', 0777);
            }

            move_uploaded_file($_FILES['myfile']['tmp_name'],
                getcwd(). '/uploads/'.$src_file_name);

            //optimize image using TinyPNG
            $source = \Tinify\fromFile(getcwd(). '/uploads/'.$src_file_name);
            $source->toFile(getcwd(). '/uploads/'.$src_file_name);

            echo "File uploaded successfully";
        } else {
            echo 'Invalid file format';
        }
    }
}
?>

<script>
    jQuery(document).ready(function($) {
        $('a[href$=".pdf"]')
            .attr('download', '')
            .attr('target', '_blank');
    });
</script>