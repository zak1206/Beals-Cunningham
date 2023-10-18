<?php
//if(isset($_POST["submit"]))
//{
//    $host="stellar.caffeinerde.com"; // Host name.
//    $db_user="stellar_equip"; //mysql user
//    $db_password="BCss1957!@"; //mysql pass
//    $db='custom_test'; // Database name.
////$conn=mysql_connect($host,$db_user,$db_password) or die (mysql_error());
////mysql_select_db($db) or die (mysql_error());
//    $con=mysqli_connect($host,$db_user,$db_password,$db);
//// Check connection
//    if (mysqli_connect_errno())
//    {
//        echo "Failed to connect to MySQL: " . mysqli_connect_error();
//    }
//
//
//    echo $filename=$_FILES["file"]["name"];
//    $ext=substr($filename,strrpos($filename,"."),(strlen($filename)-strrpos($filename,".")));
//
////we check,file must be have csv extention
//    if($ext=="csv")
//    {
//        $file = fopen($filename, "r");
//        while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
//        {
//            $sql = "INSERT into custom_test SET id = '$emapData[0]' , name = '$emapData[1]'  ,email = '$emapData[2]', address = '$emapData[3]'";
//            mysqli_query($con, $sql);
//        }
//        fclose($file);
//        echo "CSV File has been successfully Imported.";
//    }
//    else {
//        echo "Error: Please Upload only CSV File";
//    }
//
//
//}
//?>

<?php
$conn = mysqli_connect("stellar.caffeinerde.com", "stellar_equip", "BCss1957!@", "admin_stellar");

if (isset($_POST["import"])) {
    $fileName = $_FILES["file"]["tmp_name"];

    if ($_FILES["file"]["size"] > 0) {
        $sqlTruncate = "TRUNCATE TABLE custom_test";
        $result = mysqli_query($conn, $sqlTruncate);

        $file = fopen($fileName, "r");

        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {

            $sqlInsert = "INSERT into custom_test (id,name,email,address)
                   values ('" . $column[0] . "','" . $column[1] . "','" . $column[2] . "','" . $column[3] . "')";
            $result = mysqli_query($conn, $sqlInsert);

            if (! empty($result)) {
                $type = "success";
                $message = "CSV Data Imported into the Database";
            } else {
                $type = "error";
                $message = "Problem in Importing CSV Data";
            }
        }
    }
}
?>

<?php
$sqlSelect = "SELECT * FROM custom_test";
$result = mysqli_query($conn, $sqlSelect);

if (mysqli_num_rows($result) > 0) {
    ?>
    <table id='userTable'>
        <thead>
        <tr>
            <th>User ID</th>
            <th>User Name</th>
            <th>Email</th>
            <th>Address</th>

        </tr>
        </thead>
        <?php
        while ($row = mysqli_fetch_array($result)) {
        ?>

        <tbody>
        <tr>
            <td><?php  echo $row['id']; ?></td>
            <td><?php  echo $row['name']; ?></td>
            <td><?php  echo $row['email']; ?></td>
            <td><?php  echo $row['address']; ?></td>
        </tr>
        <?php
        }
        ?>
        </tbody>
    </table>
<?php } ?>


<script type="text/javascript">
    $(document).ready(
        function() {
            $("#frmCSVImport").on(
                "submit",
                function() {

                    $("#response").attr("class", "");
                    $("#response").html("");
                    var fileType = ".csv";
                    var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+("
                        + fileType + ")$");
                    if (!regex.test($("#file").val().toLowerCase())) {
                        $("#response").addClass("error");
                        $("#response").addClass("display-block");
                        $("#response").html(
                            "Invalid File. Upload : <b>" + fileType
                            + "</b> Files.");
                        return false;
                    }
                    return true;
                });
        });
</script>