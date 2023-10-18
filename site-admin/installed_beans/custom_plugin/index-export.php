<?php
$connect = mysqli_connect("stellar.caffeinerde.com", "stellar_equip", "BCss1957!@", "admin_stellar");
$query ="SELECT * FROM custom_equipment ORDER BY id ASC ";
$result = mysqli_query($connect, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Export Custom Equipment Data</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        .row-application {
            background-color: #eceeef;
            padding: 20px;
            margin: 26px 0;
            box-shadow: 0 3px 6px rgba(0,0,0,.16), 0 3px 6px rgba(0,0,0,.23);
        }
    </style>
</head>
<body>
<br /><br />
<div class="container">
    <h4 class="title" style="color: #000; font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 25px;">Custom Product Data</h4><hr>
    <div class="row">
        <div class="col-md-6">
    <form method="post" action="export.php" align="center">
        <input type="submit" name="export" value="CSV Export" class="btn btn-danger" style="min-width: 200px; color: #fff; font-size: 15px;  border-radius: 0px; box-shadow: 0 1px 1px 0 rgba(0,0,0,0.2), 0 3px 5px 0 rgba(0,0,0,0.19);"/>
    </form>
        </div>
        <div class="col-md-6">
    <form method="post" action="test_run.php" align="center">
        <input type="submit" name="export" value="CSV Import" class="btn btn-success" style="min-width: 200px; color: #fff; font-size: 15px; border-radius: 0px; box-shadow: 0 1px 1px 0 rgba(0,0,0,0.2), 0 3px 5px 0 rgba(0,0,0,0.19);"/>
    </form>
        </div>
    </div>
</div>
    <div class="container">
        <div class="row">
        <div class="col-md-6">
            <div class="row-application" style="height:150px;">
                <img src="../../../../img/step1.png" class="img-responsive" style="float:left;"><p style="font-size: 15px; text-align: right; margin-top:30px;">Export the current Custom Products database csv file.</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row-application" style="height:150px;">
                <img src="../../../../img/step2.png" class="img-responsive" style="float:left;"> <p style="font-size: 15px; text-align: right; margin-top:30px;">Open the csv file and a make any required product changes or additions. <strong>DO NOT CHANGE THE STRUCTURE OF THE FILE.</strong></p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row-application" style="height:150px;">
                <img src="../../../../img/step3.png" class="img-responsive" style="float:left;"><p style="font-size: 15px; text-align: right; margin-top:30px;">Export a new csv file and verify that its format is exactly the same as the original exported file. If the file structure is not exactly the same, it will not work.</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row-application" style="height:150px;">
                <img src="../../../../img/step4.png" class="img-responsive" style="float:left;"> <p style="font-size: 15px; text-align: right; margin-top:30px;"> Upload the new csv file to import it into the custom products database.</p>
            </div>
        </div>
        <div class="col-md-12">
            <p style="color:#ff0000;"><strong><span style="font-size:18px;">NOTE:</span></strong> The import file format has to be formatted in exactly the same way as the original export file. Any misplaced commas or information will not render correctly.</p>
        </div>
    </div>
    </div>
    <div class="container card" style="border-radius: 0px;box-shadow: 0 2px 2px rgba(204, 197, 185, 0.5); background-color: #eceeef; color: #252422; margin-bottom: 20px; position: relative; z-index: 1;">
    <div class="table-responsive" id="employee_table" style="margin-top:20px;">
        <table class="table table-bordered">
            <tr>
                <th width="5%">ID</th>
                <th width="25%">Parent Cat</th>
                <th width="25%">Cat One</th>
                <th width="35%">Title</th>
                <th width="10%">Image</th>
                <th width="20%">MSRP</th>
                <th width="20%">Sales Price</th>
                <th width="35%">Description</th>
                <th width="35%">Specifications</th>
                <th width="5%">Active</th>
            </tr>
            <?php
            while ($row = mysqli_fetch_array($result))
            {
                ?>
                <tr>
                    <td><?php echo $row["id"]; ?></td>
                    <td><?php echo $row["parent_cat"]; ?></td>
                    <td><?php echo $row["cat_one"]; ?></td>
                    <td><?php echo $row["title"]; ?></td>
                    <td><?php echo $row["eq_image"]; ?></td>
                    <td><?php echo $row["msrp"]; ?></td>
                    <td><?php echo $row["sales_price"]; ?></td>
                    <td><?php echo $row["features"]; ?></td>
                    <td><?php echo $row["description"]; ?></td>
                    <td><?php echo $row["active"]; ?></td>


                </tr>
                <?php
            }
            ?>
        </table>
    </div>
    </div>
</div>
</body>
</html>