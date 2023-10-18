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
        $sqlTruncate = "TRUNCATE TABLE google_shop";
        $result = mysqli_query($conn, $sqlTruncate);

        $file = fopen($fileName, "r");

        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {

            $sqlInsert = "INSERT into google_shop (id,title,Item Description,Link,Image Link,Mobile Link,Additional Image Link,Availability,Availability Date,Cost of Goods Sold,Expiration Date , , , , , , , , , , , , , , , , ,)
                   values ('" . $column[0] . "','" . $column[1] . "','" . $column[2] . "','" . $column[3] . "','" . $column[4] . "', '" . $column[5] . "', '" . $column[6] . "', '" . $column[7] . "', '" . $column[8] . "', '" . $column[9] . "', '" . $column[10] . "', '" . $column[11] . "', '" . $column[12] . "', '" . $column[13] . "', '" . $column[14] . "', '" . $column[15] . "', '" . $column[16] . "', '" . $column[17] . "', '" . $column[18] . "', '" . $column[19] . "', '" . $column[20] . "', '" . $column[21] . "', '" . $column[22] . "', '" . $column[23] . "', '" . $column[24] . "', '" . $column[25] . "', '" . $column[26] . "', '" . $column[27] . "','" . $column[28] . "', '" . $column[29] . "', '" . $column[30] . "', '" . $column[31] . "', '" . $column[32] . "', '" . $column[33] . "', '" . $column[34] . "', '" . $column[35] . "', '" . $column[36] . "', '" . $column[37] . "', '" . $column[38] . "', '" . $column[39] . "', '" . $column[40] . "', '" . $column[41] . "', '" . $column[42] . "','" . $column[43] . "', '" . $column[44] . "', '" . $column[45] . "', '" . $column[46] . "', '" . $column[47] . "', '" . $column[48] . "', '" . $column[49] . "', '" . $column[50] . "', '" . $column[51] . "', '" . $column[52] . "', '" . $column[53] . "', '" . $column[54] . "', '" . $column[55] . "', '" . $column[56] . "')";
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
$sqlSelect = "SELECT * FROM google_shop";
$result = mysqli_query($conn, $sqlSelect);

if (mysqli_num_rows($result) > 0) {
    ?>
    <table id='userTable'>
        <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Item Description</th>
            <th>Link</th>
            <th>Image Link</th>
            <th>Mobile Link</th>
            <th>Additional Image Link</th>
            <th>Availability</th>
            <th>Availability Date</th>
            <th>Cost of Goods Sold</th>
            <th>Expiration Date</th>
            <th>Price</th>
            <th>Sale Price</th>
            <th>Sale Price Effective Date</th>
            <th>Unit Pricing Measure</th>
            <th>Unit Pricing Base Measure</th>
            <th>Installment</th>
            <th>Subscription Cost</th>
            <th>Loyalty Points</th>
            <th>Google Product Category</th>
            <th>Product Type</th>
            <th>Brand</th>
            <th>GTIN</th>
            <th>MPN</th>
            <th>Identifier Exists</th>
            <th>Item Condition</th>
            <th>Adult</th>
            <th>Multipack</th>
            <th>Is Bundle</th>
            <th>Age Group</th>
            <th>Color</th>
            <th>Gender</th>
            <th>Material</th>
            <th>Pattern</th>
            <th>Google Size</th>
            <th>Size Type</th>
            <th>Size System</th>
            <th>Item Group ID</th>
            <th>Ads Direct</th>
            <th>Custom Label</th>
            <th>Promotion ID</th>
            <th>Excluded Destination</th>
            <th>Included Destination</th>
            <th>Shipping</th>
            <th>Shipping Label</th>
            <th>Shipping Weight</th>
            <th>Shipping Length</th>
            <th>Shipping Width</th>
            <th>Shipping Height</th>
            <th>Transmit Time Label</th>
            <th>Max Handling Time</th>
            <th>Min Handling Time</th>
            <th>Tax</th>
            <th>Tax Category</th>
            <th>Energy Efficiency Class</th>
            <th>Min Energy Efficiency Class</th>
            <th>Max Energy Efficiency Class</th>
        </tr>
        </thead>
        <?php
        while ($row = mysqli_fetch_array($result)) {
        ?>
        <tbody>
        <tr>
            <td><?php  echo $row['id']; ?></td>
            <td><?php  echo $row['title']; ?></td>
            <td><?php  echo $row['item_description']; ?></td>
            <td><?php  echo $row['link']; ?></td>
            <td><?php  echo $row['mobile_link']; ?></td>
            <td><?php  echo $row['additional_image_link']; ?></td>
            <td><?php  echo $row['availability']; ?></td>
            <td><?php  echo $row['availability_date']; ?></td>
            <td><?php  echo $row['cost_of_goods_sold']; ?></td>
            <td><?php  echo $row['expiration_date']; ?></td>
            <td><?php  echo $row['price']; ?></td>
            <td><?php  echo $row['sale_price']; ?></td>
            <td><?php  echo $row['sale_price_effective_date']; ?></td>
            <td><?php  echo $row['unit_pricing_measure']; ?></td>
            <td><?php  echo $row['unit_pricing_base_measure']; ?></td>
            <td><?php  echo $row['installment']; ?></td>
            <td><?php  echo $row['subscription_cost']; ?></td>
            <td><?php  echo $row['loyalty_points']; ?></td>
            <td><?php  echo $row['google_product_category']; ?></td>
            <td><?php  echo $row['product_type']; ?></td>
            <td><?php  echo $row['brand']; ?></td>
            <td><?php  echo $row['gtin']; ?></td>
            <td><?php  echo $row['mpn']; ?></td>
            <td><?php  echo $row['identifier_exists']; ?></td>
            <td><?php  echo $row['item_condition']; ?></td>
            <td><?php  echo $row['adult']; ?></td>
            <td><?php  echo $row['multipack']; ?></td>
            <td><?php  echo $row['is_bundle']; ?></td>
            <td><?php  echo $row['age_group']; ?></td>
            <td><?php  echo $row['color']; ?></td>
            <td><?php  echo $row['gender']; ?></td>
            <td><?php  echo $row['material']; ?></td>
            <td><?php  echo $row['pattern']; ?></td>
            <td><?php  echo $row['google_size']; ?></td>
            <td><?php  echo $row['size_type']; ?></td>
            <td><?php  echo $row['size_system']; ?></td>
            <td><?php  echo $row['itemgroup_id']; ?></td>
            <td><?php  echo $row['ads_direct']; ?></td>
            <td><?php  echo $row['custom_label']; ?></td>
            <td><?php  echo $row['promotion_id']; ?></td>
            <td><?php  echo $row['excluded_destination']; ?></td>
            <td><?php  echo $row['included_destination']; ?></td>
            <td><?php  echo $row['shipping']; ?></td>
            <td><?php  echo $row['shipping_label']; ?></td>
            <td><?php  echo $row['shipping_weight']; ?></td>
            <td><?php  echo $row['shipping_length']; ?></td>
            <td><?php  echo $row['shipping_width']; ?></td>
            <td><?php  echo $row['shipping_height']; ?></td>
            <td><?php  echo $row['transmit_time_label']; ?></td>
            <td><?php  echo $row['max_handling_time']; ?></td>
            <td><?php  echo $row['min_handling_time']; ?></td>
            <td><?php  echo $row['tax']; ?></td>
            <td><?php  echo $row['tax_category']; ?></td>
            <td><?php  echo $row['energy_efficiency_class']; ?></td>
            <td><?php  echo $row['min_energy_efficiency_class']; ?></td>
            <td><?php  echo $row['max_energy_efficiency_class']; ?></td>
            <td><?php  echo $row['active']; ?></td>
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