<?php
$connect = mysqli_connect("stellar.caffeinerde.com", "stellar_equip", "BCss1957!@", "admin_stellar");
$query ="SELECT * FROM google_shop ORDER BY id ASC ";
$result = mysqli_query($connect, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Export Google Shop Data</title>
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
    <h4 class="title" style="color: #000; font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 25px;">Google Shopping Data</h4><hr>
    <div class="row">
        <div class="col-md-6">
            <form method="post" action="google-export.php" align="center">
                <input type="submit" name="export" value="CSV Export" class="btn btn-dark" style="min-width: 200px; color: #fff; font-size: 15px;  border-radius: 0px; box-shadow: 0 1px 1px 0 rgba(0,0,0,0.2), 0 3px 5px 0 rgba(0,0,0,0.19); background:#000;"/>
            </form>
        </div>
        <div class="col-md-6">
            <form method="post" action="test_run.php" align="center">
                <input type="submit" name="export" value="CSV Import" class="btn btn-dark" style="min-width: 200px; color: #fff; font-size: 15px; border-radius: 0px; box-shadow: 0 1px 1px 0 rgba(0,0,0,0.2), 0 3px 5px 0 rgba(0,0,0,0.19);background:#000;"/>
            </form>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="row-application" style="height:150px;">
                <img src="../../../../img/step1.png" class="img-responsive" style="float:left;"><p style="font-size: 15px; text-align: right; margin-top:30px;">Export the current Google Shopping products database csv file.</p>
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
                <th width="100%">ID</th>
                <th width="100%">Title</th>
                <th width="100%">Item Description</th>
                <th width="100%">Link</th>
                <th width="100%">Image Link</th>
                <th width="100%">Mobile Link</th>
                <th width="100%">Additional Image Link</th>
                <th width="100%">Availability</th>
                <th width="100%">Availability Date</th>
                <th width="100%">Cost of Goods Sold</th>
                <th width="100%">Expiration Date</th>
                <th width="100%">Price</th>
                <th width="100%">Sale Price</th>
                <th width="100%">Sale Price Effective Date</th>
                <th width="100%">Unit Pricing Measure</th>
                <th width="100%">Unit Pricing Base Measure</th>
                <th width="100%">Installment</th>
                <th width="100%">Subscription Cost</th>
                <th width="100%">Loyalty Points</th>
                <th width="100%">Google Product Category</th>
                <th width="100%">Product Type</th>
                <th width="100%">Brand</th>
                <th width="100%">Gtin</th>
                <th width="100%">MPN</th>
                <th width="100%">Identifier Exists</th>
                <th width="100%">Item Condition</th>
                <th width="100%">Adult</th>
                <th width="100%">Multipack</th>
                <th width="100%">Is Bundle</th>
                <th width="100%">Age Group</th>
                <th width="100%">Color</th>
                <th width="100%">Gender</th>
                <th width="100%">Material</th>
                <th width="100%">Pattern</th>
                <th width="100%">Google Size</th>
                <th width="100%">Size Type</th>
                <th width="100%">Size System</th>
                <th width="100%">Item Group ID</th>
                <th width="100%">Ads Direct</th>
                <th width="100%">Custom Label</th>
                <th width="100%">Promotion ID</th>
                <th width="100%">Excluded Destination</th>
                <th width="100%">Included Destination</th>
                <th width="100%">Shipping</th>
                <th width="100%">Shipping Label</th>
                <th width="100%">Shipping Weight</th>
                <th width="100%">Shipping Length</th>
                <th width="100%">Shipping Width</th>
                <th width="100%">Shipping Height</th>
                <th width="100%">Transmit Time Label</th>
                <th width="100%">Max Handling Time</th>
                <th width="100%">Min Handling Time</th>
                <th width="100%">Tax</th>
                <th width="100%">Tax Category</th>
                <th width="100%">Energy Efficiency Class</th>
                <th width="100%">Min Energy Efficiency Class</th>
                <th width="100%">Max Energy Efficiency Class</th>
                <th width="100%">Active</th>
            </tr>
            <?php
            while ($row = mysqli_fetch_array($result))
            {
                ?>
                <tr>
                    <td><?php echo $row["id"]; ?></td>
                    <td><?php echo $row["title"]; ?></td>
                    <td><?php echo $row["item_description"]; ?></td>
                    <td><?php echo $row["link"]; ?></td>
                    <td><?php echo $row["image_link"]; ?></td>
                    <td><?php echo $row["mobile_link"]; ?></td>
                    <td><?php echo $row["additional_image_link"]; ?></td>
                    <td><?php echo $row["availability"]; ?></td>
                    <td><?php echo $row["availability_date"]; ?></td>
                    <td><?php echo $row["cost_of_goods_sold"]; ?></td>
                    <td><?php echo $row["expiration_date"]; ?></td>
                    <td><?php echo $row["price"]; ?></td>
                    <td><?php echo $row["sale_price"]; ?></td>
                    <td><?php echo $row["sale_price_effective_date"]; ?></td>
                    <td><?php echo $row["unit_pricing_measure"]; ?></td>
                    <td><?php echo $row["unit_pricing_base_measure"]; ?></td>
                    <td><?php echo $row["installment"]; ?></td>
                    <td><?php echo $row["subscription_cost"]; ?></td>
                    <td><?php echo $row["loyalty_points"]; ?></td>
                    <td><?php echo $row["google_product_category"]; ?></td>
                    <td><?php echo $row["product_type"]; ?></td>
                    <td><?php echo $row["brand"]; ?></td>
                    <td><?php echo $row["gtin"]; ?></td>
                    <td><?php echo $row["mpn"]; ?></td>
                    <td><?php echo $row["identifier_exists"]; ?></td>
                    <td><?php echo $row["item_condition"]; ?></td>
                    <td><?php echo $row["adult"]; ?></td>
                    <td><?php echo $row["multipack"]; ?></td>
                    <td><?php echo $row["is_bundle"]; ?></td>
                    <td><?php echo $row["age_group"]; ?></td>
                    <td><?php echo $row["color"]; ?></td>
                    <td><?php echo $row["gender"]; ?></td>
                    <td><?php echo $row["material"]; ?></td>
                    <td><?php echo $row["pattern"]; ?></td>
                    <td><?php echo $row["google_size"]; ?></td>
                    <td><?php echo $row["size_type"]; ?></td>
                    <td><?php echo $row["size_system"]; ?></td>
                    <td><?php echo $row["itemgroup_id"]; ?></td>
                    <td><?php echo $row["ads_direct"]; ?></td>
                    <td><?php echo $row["custom_label"]; ?></td>
                    <td><?php echo $row["promotion_id"]; ?></td>
                    <td><?php echo $row["excluded_destination"]; ?></td>
                    <td><?php echo $row["included_destination"]; ?></td>
                    <td><?php echo $row["shipping"]; ?></td>
                    <td><?php echo $row["shipping_label"]; ?></td>
                    <td><?php echo $row["shipping_weight"]; ?></td>
                    <td><?php echo $row["shipping_length"]; ?></td>
                    <td><?php echo $row["shipping_width"]; ?></td>
                    <td><?php echo $row["shipping_height"]; ?></td>
                    <td><?php echo $row["transmit_time_label"]; ?></td>
                    <td><?php echo $row["max_handling_time"]; ?></td>
                    <td><?php echo $row["min_handling_time"]; ?></td>
                    <td><?php echo $row["tax"]; ?></td>
                    <td><?php echo $row["tax_category"]; ?></td>
                    <td><?php echo $row["energy_efficiency_class"]; ?></td>
                    <td><?php echo $row["min_energy_efficiency_class"]; ?></td>
                    <td><?php echo $row["max_energy_efficiency_class"]; ?></td>
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