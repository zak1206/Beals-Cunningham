<?php
include('e-commerce-header.php');
?>
<div class="row" style="margin:0">
    <div class="col-md-12">
        <div class="header">
            <h4 class="m-t-0 header-title">Customer Leads</h4>

        </div>
        <div class="content table-responsive table-full-width">
            <!-- TABLE DIV STARTS==================================== -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="font-weight: bold;background: #5d5d5d;color: #fff; border-right:solid thin #efefef; width: 10%">Id</th>
                        <th style="font-weight: bold;background: #5d5d5d;color: #fff; border-right:solid thin #efefef; width: 20%">First Name</th>
                        <th style="font-weight: bold;background: #5d5d5d;color: #fff; border-right:solid thin #efefef; width: 20%">Last Name</th>
                        <th style="font-weight: bold;background: #5d5d5d;color: #fff; border-right:solid thin #efefef; width: 20%">Email</th>
                        <th style="font-weight: bold;background: #5d5d5d;color: #fff; border-right:solid thin #efefef; width: 20%">Phone</th>
                        <th style="font-weight: bold;background: #5d5d5d;color: #fff; border-right:solid thin #efefef; width: 20%">Address</th>
                        <th style="font-weight: bold;background: #5d5d5d;color: #fff; border-right:solid thin #efefef; width: 10%">City</th>
                        <th style="font-weight: bold;background: #5d5d5d;color: #fff; border-right:solid thin #efefef; width: 10%">State</th>
                        <th class="nosort" style="text-align: right; font-weight:bold;background: #5d5d5d;color: #fff; width: 10%">Zipcode</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include('../../inc/harness.php');
                    $ars = array();
                    $a = $data->query("SELECT * FROM shop_orders");
                    while ($b = $a->fetch_array()) {
                        $ars[] = array("first_name" => $b["first_name"], "last_name" => $b["last_name"], "email" => $b["email"], "phone" => $b["phone"], "address" => $b["address"], "city" => $b["city"], "state" => $b["state"], "zip" => $b["zip"]);
                    }
                    $ars1 = array_unique($ars);
                    for ($i = 0; $i < count($ars1); $i++) {
                        echo '
        <tr>
        <th style="width: 5%">' . ($i + 1) . '</th>
        <td style="width: 20%"><a style="color: #333" href="">' . $ars1[$i]["first_name"] . '</a></td>
        <td style="width: 20%"><a style="color: #333" href="">' . $ars1[$i]["last_name"] . '</a></td>
        <td style="width: 20%"><a style="color: #333" href="">' . $ars1[$i]["email"] . '</a></td>
        <td style="width: 10%"><a style="color: #333" href="">' . $ars1[$i]["phone"] . '</a></td>
        <td style="width: 20%"><a style="color: #333" href="">' . $ars1[$i]["address"] . '</a></td>
        <td style="width: 10%"><a style="color: #333" href="">' . $ars1[$i]["city"] . '</a></td>
        <td style="width: 5%"><a style="color: #333" href="">' . $ars1[$i]["state"] . '</a></td>
        <td style="width: 10%"><a style="color: #333" href="">' . $ars1[$i]["zip"] . '</a></td>
        </tr>';
                    }
                    ?>
                </tbody>
            </table>

            <!-- TABLE DIV ENDS====================================== -->

        </div>
    </div>
</div>
<?php
include('e-commerce-footer.php');
?>