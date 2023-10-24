<?php
include('Logger.php');
include('cart.php');

$logFile = 'EQ_Logger.txt';
$logger = new Logger($logFile);


include('../../inc/harness.php');
$act = $_REQUEST["action"];
if ($act != null && $act != "") {
    $logger->log("ajaxfile.php Executing Action: " . $act, "INFO");
}

//EDIT ESTORE HOME PAGE
if ($act == 'homepageedit') {
    try {
        $logger->log("Pulling EQ Commerce Orders...", "INFO");
        $html .= '<h2 style="border-bottom: solid thin #efefef">EDIT ESTORE HOME PAGE</h2><br>';
        echo $html;
    } catch (Exception $ex) {
        $logger->log("Exception Editing Home Page.. ERROR: " . $ex, "ERROR");
    }
}

//PULLS ORDERS THAT ARE NOT DELETED//
if ($act == 'orders') {
    try {
        $logger->log("Pulling EQ Commerce Orders...", "INFO");
        $html .= '<h2 style="border-bottom: solid thin #efefef">ORDERS</h2>
        <br>
        <table id="example" class="display" style="width:100%">
            <thead>
            <tr>
                <th>Name on Order</th>
                <th>Email</th>
                <th>Purchase#</th>
                <th>Purchase Date</th>
                <th>Ship Type</th>
                <th>Purchase Price</th>
                <th>Order Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>';

        $a = $data->query("SELECT * FROM custom_equipment_shop_orders WHERE status != 'deleted' ORDER BY id ASC");
        $logger->log("" . $a->num_rows . " Row/s Pulled From custom_equipment_shop_orders.", "INFO");

        while ($b = $a->fetch_array()) {
            $html .= '<tr>
                <td>' . $b["first_name"] . ' ' . $b["last_name"] . '</td>
                <td>' . $b["email"] . '</td>
                <td>' . $b["purchase_num"] . '</td>
                <td>' . date('m/d/Y', $b["date_sub"]) . '</td>
                <td>' . $b["ship_type"] . '</td>
                <td>$' . $b["purchase_price"] . '</td>
                <td>' . $b["status"] . '</td>
                <td><button class="btn btn-secondary" data-toggle="modal" data-target=".bd-example-modal-lg" onclick="reviewOrder(\'' . $b["id"] . '\')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></td>
            </tr>';
        }


        $html .= '</tbody>
            <tfoot>
            <tr>
                <th>Name on Order</th>
                <th>Email</th>
                <th>Purchase#</th>
                <th>Purchase Date</th>
                <th>Ship Type</th>
                <th>Purchase Price</th>
                <th>Order Status</th>
                <th>Action</th>
            </tr>
            </tfoot>
        </table>';
        $logger->log("Orders Completed Successfully!", "INFO");
    } catch (Exception $error) {
        $logger->log("ERROR:  Error Pulling Orders! - " . $e, "ERROR");
    }

    echo $html;
}

if ($act == 'openlogs') {
    $file = fopen('EQ_Logger.txt', 'r');

    // Create the table structure
    $html =
        '<table class="table table-dark table-striped table-bordered">
            <thead>
                <tr>
                    <th>Date/Time</th>
                    <th>Category</th>
                    <th>Log Message</th>
                </tr>
            </thead>';

    // Read each line of the text file
    while (($line = fgets($file)) !== false) {
        // Split the line by tabs to separate columns
        $columns = explode("~", trim($line));

        // Start a new table row
        $html .= '<tbody>
                    <tr>';

        // Iterate over each column and create a table cell
        foreach ($columns as $column) {
            $html .= '<td>' . htmlspecialchars($column) . '</td>';
        }

        // End the table row
        $html .= '</tr>
                </tbody>';
    }

    // Close the file
    fclose($file);

    // Close the table structure
    $html .= '</table>';

    echo ($html);
}

//==PULLS A SINGLE ORDER TO REVIEW AND UPDATE==//
if ($act == 'pullorder') {
    try {
        $logger->log("Pulling EQ Commerce Orders...", "INFO");

        if ($_REQUEST["orderid"] != null) {
            $orderId = $_REQUEST["orderid"];
            $a = $data->query("SELECT * FROM custom_equipment_shop_orders WHERE id = '$orderId'");
            $b = $a->fetch_array();
            $logger->log("Pulled " . $a->num_rows . " Orders From custom_equipment_shop_orders DataTable.", "INFO");

            $status = $b["status"];
            if ($status == 'New') {
                $status = 'Select Order Status';
            } else {
                $status = $status;
            }

            $html .= '<div class="alert alert-warning eqcomnotice" style="display: none"></div>';

            $html .= '<div class="justify-content-center mt-50 mb-50">
    <div class="row">
        <div class="col-md-12">
            <div class="card sales_order">
                <div class="card-header bg-transparent header-elements-inline">
                    <h3 class="card-title">Sales Receipt</h3>
                    <div class="header-elements"><button type="button" class="btn btn-light btn-sm ml-3 no-print" onclick="printSales()"><i class="fa fa-print mr-2"></i> Print</button> <div style="display: inline; margin: 0 12px 0 0px;" class="dropdown">
                    <a class="btn btn-light btn-sm ml-3 dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-check mr-2"></i> <span class="currstat">' . $status . '</span>
                    </a>
                    <input type="hidden" name="orderids" id="orderids" value="' . $orderId . '">
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <span class="dropdown-item itemstattus" data-stat="Pending">Pending</span>
                        <span class="dropdown-item itemstattus" data-stat="Fulfilling Order">Fulfilling Order</span>
                        <span class="dropdown-item itemstattus" data-stat="Ready for Pickup">Ready for Pickup</span>
                        <span class="dropdown-item itemstattus" data-stat="Shipped">Shipped</span>
                        <span class="dropdown-item itemstattus" data-stat="Order Complete">Order Complete</span>
                        <span class="dropdown-item itemstattus" data-stat="Cancel Order">Cancel Order</span>
                        <span class="dropdown-item itemstattus" data-stat="Order Refunded">Order Refunded</span>
                    </div>
                    </div> 
                    <button type="button" class="btn btn-danger btn-sm no-print" onclick="deleteOrder()"><i class="fa fa-trash mr-2"></i> Delete Order</button></div>
                </div>
                <div class="card-body">
                    <div class="row">
                    
                    <table style="width: 100%">
                    <tr>
                        <td><span class="text-muted" style="float:left;">Sold By:</span><br>
                            <div class="mb-4 pull-left">
                            
                                <h5 class="my-2">Stellar Equipment LLC</h5>
                                <ul class="list list-unstyled mb-0 text-left">
                                    <li>2333 E Britton RD</li>
                                    <li>Oklahoma City, OK</li>
                                    <li>405.478.4752 </li>
                                </ul>
                            </div>
                        </td>
                        <td style="vertical-align:top">
                        <div class="mb-4" style="text-align: right;">
                                <div class="text-sm-right">
                                    <h6 class="invoice-color mb-2 mt-md-2"><strong>Purchase # </strong>' . $b["purchase_num"] . '</h6>
                                    <ul class="list list-unstyled mb-0">
                                        <li><b>Sale Date:</b> <span class="font-weight-semibold">' . date('m/d/Y h:ia', $b["date_sub"]) . '</span></li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="mb-4 mb-md-2 text-left"> <span class="text-muted">Sold To:</span>
                            <ul class="list list-unstyled mb-0">
                                <li>
                                    <h5 class="my-2">' . $b["first_name"] . ' ' . $b["last_name"] . '</h5>
                                </li>
                                <li>' . $b["address"] . '</li>
                                <li>' . $b["city"] . ' ' . $b["state"] . ', ' . $b["zip"] . '</li>
                                <li>' . $b["phone"] . '</li>
                                <li><a href="mailto:' . $b["email"] . '" data-abc="true">' . $b["email"] . '</a></li>
                            </ul>
                        </div>
                        </td>
                        <td>
                        <div class="mb-2 ml-auto" style="text-align: right"> <span class="text-muted">Shipment / Pickup Details:</span>
                            <div class="d-flex flex-wrap wmin-md-400">';

            $shipType = $b["ship_type"];

            if ($shipType == 'Customer Pickup') {
                $html .= '<ul class="list list-unstyled text-right mb-0 ml-auto">
                                    <li>
                                        <h5 class="font-weight-semibold my-2">Pickup Location</h5>
                                    </li>
                                    <li><span class="font-weight-semibold">Hong Kong Bank</span></li>
                                    <li>Hong Kong</li>
                                    <li>Thurnung street, 21</li>
                                    <li>New standard</li>
                                    <li><span class="font-weight-semibold">98574959485</span></li>
                                    <li><span class="font-weight-semibold">BHDHD98273BER</span></li>
                                </ul>';
            } else {
                $html .= '<ul class="list list-unstyled text-right mb-0 ml-auto">
                                    <li>
                                        <h5 class="font-weight-semibold my-2">Shipping Location</h5>
                                    </li>
                                    <li>' . $b["ship_address"] . '</li>
                                    <li>' . $b["ship_city"] . ' ' . $b["ship_state"] . ', ' . $b["ship_zip"] . '</li>';

                if ($b["ship_type"] == 'api_system') {
                    $html .= '<li><span class="font-weight-semibold">' . $b["ship_type"] . '</span></li>
                            <li><span class="font-weight-semibold mt-2"><b>Tracking:</b> <a href="https://www.google.com/search?q=1ZY2572W0399703713" target="_blank"> ' . $b["tracking_number"] . '</a></span></li>';
                } else {
                    $html .= '<li><span class="font-weight-semibold">' . $b["ship_type"] . '</span></li>';
                }



                $html .= '</ul>';
            }



            $html .= '</div>
                        </div>
                        </td>
                    </tr>
                    </table>
                    
                    </div>
                    
                </div>
                <div class="table-responsive">
                    <table class="table table-lg">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            ';



            $cart = $b["items_list"];
            $purchasedItems = json_decode($cart, true);
            $totalPrice = 0;
            for ($i = 0; $i < count($purchasedItems); $i++) {

                $prodId = $purchasedItems[$i]["id"];
                $prodName = str_replace('-', ' ', str_replace('_', ' ', $purchasedItems[$i]["name"]));

                $html .= '<tr>
                                <td>' . $prodName . '</td>
                                <td>' . $purchasedItems[$i]["qty"] . '</td>
                                <td>' . $purchasedItems[$i]["price"] . '</td>
                                <td><span class="font-weight-semibold">$' . number_format((intval($purchasedItems[$i]['qty']) * floatval($purchasedItems[$i]['price'])), 2, '.', ',') . '</span></td>
                            </tr>';

                $totalPrice += (intval($purchasedItems[$i]['qty']) * floatval($purchasedItems[$i]['price']));
            }

            //Shipping Labels
            $labels = $b['ship_label_url'];
            $labelsJson = json_decode($labels, true);

            $html .= '</tbody>
                    </table>
                </div>
                <table>
                    <tr>
                        <td style="width: 60%">
                        <div class="row justify-content-center mb-2 mt-1">
                            <h4 class="col-md-12 text-center"><b>Shipping Labels</b></h4>
                                <select class="form-control mr-3 col-md-6 shipping_label_select" onclick="SetLabelURL()" placeholder="Select Shipping Label">';
            foreach ($labelsJson['labels'][0] as $label) {
                $html .= '<option value="' . $label['label_url'] . '">' . str_replace('.pdf', '', str_replace('../../../shipping_labels/', '', $label['label_url'])) . '</option>';
            }

            //------ PRICE TOTALS
            $sub_total = number_format(doubleval($totalPrice), 2, '.', ',');
            $shipping_cost = number_format(floatval($b["ship_cost"]), 2, '.', ',');
            $applied_tax = number_format(floatval($b["applied_tax"]), 2, '.', ',');
            $total_cost = number_format((doubleval($shipping_cost) + doubleval($applied_tax) + doubleval($totalPrice)), 2, '.', ',');

            $html .= '</select>
                                <a class="ship_url" href="" target="_blank"><button type="button" style="min-width: 210px;" class="col-md-3 btn btn-primary print_label">
                                    <b>
                                        <i class="fa fa-paper-plane-o mr-1"></i>
                                    </b> 
                                    Print Shipping Label
                                </button></a>
                                <script>
                                    function SetLabelURL(){
                                        var url = $(".shipping_label_select").val();
                                        console.log("URL: " + url);
                                        $(".ship_url").attr("href", "https://rowtonengineering.com/stellar/" + url);
                                        console.log("URL SET!");
                                    }
                                </script>
                            </div>
                        </td>
                        <td><div class="card-body">
                    <div class="d-md-flex flex-md-wrap">
                        <div class="pt-2 mb-3 ml-auto" style="width: 100%">
                            <h3 class="mb-3 text-left">Total Paid</h3>
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th class="text-left">Subtotal:</th>
                                            <td class="text-right">$' . $sub_total . '</td>
                                        </tr>';

            if ($b["discount_applied"] != null) {

                $html .= '<tr>
                                                                            <th class="text-left">Applied Discount:</th>
                                                                            <td class="text-right">-$' . number_format($b["discount_applied"], 2, '.', ',') . '</td>
                                                                        </tr>';
            }

            if ($b["applied_tax"] != 0) {

                $html .= '<tr>
                                            <th class="text-left">Tax:</th>
                                            <td class="text-right">$' . $applied_tax . '</td>
                                        </tr>';
            }

            if ($b["ship_price"] != '0.00') {
                $html .= '<tr>
                                            <th class="text-left">Shipping:</th>
                                            <td class="text-right">$' . $shipping_cost . '</td>
                                        </tr>';
            }

            $html .= '<tr>
                                            <th class="text-left">Total:</th>
                                            <td class="text-right text-primary">
                                                <h5 class="font-weight-semibold">$' . $total_cost . '</h5>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-right mt-3 no-print"> <button type="button" class="btn btn-primary"><b><i class="fa fa-paper-plane-o mr-1"></i></b> Send Customer Update</button> </div>
                        </div>
                    </div>
                </div></td>
                    </tr>
                </table>
                <!--<div class="card-footer"> <span class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.Duis aute irure dolor in reprehenderit</span> </div>-->
            </div>
        </div>
    </div>
</div>';
        }

        $logger->log("PullOrder Completed Successfully!", "INFO");
    } catch (Exception $error) {
        $logger->log("ERROR:  Error Pulling Orders! - " . $e, "ERROR");
    }

    echo $html;
}

//UPDATES THE STATUS ON A ORDER//
if ($act == 'updatestatus') {
    try {
        $logger->log("Updating Order Status...", "INFO");

        $status = $_REQUEST["status"];
        $orderId = $_REQUEST["orderid"];
        $logger->log("UpdateStatus() ID: " . $orderid . " |  Status: " . $status, "INFO");

        $data->query("UPDATE custom_equipment_shop_orders SET status = '" . $data->real_escape_string($status) . "' WHERE id = '$orderId'");

        $logger->log("Update Order Status Complete!", "INFO");
    } catch (Exception $e) {
        $logger->log("ERROR:  Failed To Update Order Status! - " . $e, "ERROR");
    }
}

//DELETES A ORDER BUT DOES NOT REFUND COST//
if ($act == 'confirmdel') {
    try {
        $logger->log("ConfirmDel - Starting To Delete Order...", "INFO");
        $orderid = $_REQUEST["orderid"];
        $data->query("UPDATE custom_equipment_shop_orders SET status = 'deleted' WHERE id = '$orderid'");
    } catch (Exception $e) {
        $logger->log("ERROR:  Failed To Delete Order! - " . $e, "ERROR");
    }
}

///===END SALES ORDER STUFF===//

///===BEGIN CATEGORY FUNCTIONS===///

//CREATE A CATEGORY FORM//
if ($act == 'createcustcat') {
    try {
        $logger->log("Opening Category Creator...", "INFO");

        $html .= '<div class="theresults"></div>';
        $html .= '<form name="createcategory" id="createcategory" method="post" action="" onsubmit="return false">';
        $html .= '<div class="row">';
        $html .= '<div class="col-md-12" style="margin-bottom: 30px"><h2 style="border-bottom: solid thin #efefef; max-width: 50%">CREATE NEW CATEGORY</h2></div>';
        $html .= '<div class="col-md-4"><label>Category Name</label><br><input type="text" class="form-control" name="catname" id="catname" required=""></div>';
        $html .= '<div class="col-md-4"><label>Category Type</label><br><select class="form-control" name="category_type" id="category_type" required=""><option value="">Select Category Type</option><option value="parent-category">Parent Category</option><option value="child-category">Child Category</option><option value="product-category">Product Category</option><option value="custom-category">Custom Category</option></select></div>';
        $html .= '<div class="col-md-4"><label>(Meta) Title Tag</label><br><input class="form-control" type="text" id="page_title" name="page_title" value="" required=""></div>';
        $html .= '</div>';

        $html .= '<br>';

        $html .= '<div class="row">';
        $html .= '<div class="col-md-8"><label>(Meta) Category Description & Short Text</label><br><textarea class="form-control" id="page_desc" name="page_desc" required=""></textarea></div>';
        $html .= '<div class="col-md-4"><label>Category Image</label><div class="input-group mb-3"><input type="text" class="form-control" name="cat_img" id="cat_img" placeholder="No Image" aria-label="Category Image" value=""><div class="input-group-append"><button class="btn btn-light img-browser" data-setter="cat_img" type="button">Browse Images</button></div></div></div>';
        $html .= '</div>';
        $html .= '<br>';
        $html .= '<div class="row">';
        $html .= '<div class="col-md-12">';
        $html .= '<div style="width: 100%">Assocated Products & Categories<br><small>You can drag and re-order items below.</small> <button style="float: right" class="btn btn-secondary btn-sm" onclick="openCatz()" type="button"><i class="fa fa-plus" aria-hidden="true"></i> Add Categories</button> <button type="button" style="float: right; margin: 0px 5px" class="btn btn-light btn-sm" onclick="openProds()"><i class="fa fa-plus" aria-hidden="true"></i> Add Products</button></div><br>';
        $html .= '<div class="jumbotron product-holder droparea" style="padding: 10px; border: dashed thin #bcbbbb;">';
        //$html .= '<span class="badge badge-light prodblox">Product Here <i class="fa fa-window-close" aria-hidden="true"></i></span> <span class="badge badge-light prodblox">Product Here <i class="fa fa-window-close" aria-hidden="true"></i></span>';
        $html .= '</div>';
        $html .= '<input type="hidden" name="selecteditems" id="selecteditems" value="">';

        $html .= '<label>Select Product / Category Views</label><br>';
        $html .= '<div class="btn-group btn-group-lg" role="group" aria-label="..."><button type="button" class="btn btn-secondary viewtypbtn active" data-viewtype="grid"><i class="fa fa-th" aria-hidden="true"></i></button>
  <button type="button" class="btn btn-secondary viewtypbtn" data-viewtype="list"><i class="fa fa-list" aria-hidden="true"></i></button></div>';
        $html .= '<input type="hidden" name="view_type" id="view_type" value="grid">';
        $html .= '</div>';
        $html .= '</div>';

        $html .= '<br>';

        $html .= '<div class="row">';
        $html .= '<div class="col-md-12">';
        $html .= '<label>Page Details</label><br>';
        $html .= '<small>Below is the <span style="color: red">{prodcat}data{/prodcat}</span> You can move and adjust this token anywhere on the category page details.</small><br>';
        $html .= '<textarea class="summernote" name="page_details" id="page_details">{prodcat}data{/prodcat}</textarea>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<br>';
        $html .= '<div class="row">';
        $html .= '<div class="col-md-12" style="text-align: right"><button type="submit" class="btn btn-success">Save Category</button></div>';
        $html .= '</div>';
        $html .= '</form>';

        $logger->log("Create Category Form Has Been Created!", "INFO");
    } catch (Exception $e) {
        $logger->log("ERROR:  Error Creating Category Creation Form!! - " . $e, "ERROR");
    }

    echo $html;
}
if ($act == 'saveforlater') {
    // $total = 0;
    // session_start();
    // $eqipid = $_POST["eqipid"];
    // $eqname = $_POST["eqname"];
    // $eqtype = $_POST["eqtype"];
    // $price = $_POST["price"];
    // $url = $_POST["url"];
    // $tabs = $_POST["tabs"];
    // $qty = $_POST["qty"];
    // $itemid = $_POST["itemid"];
    // //$qty = '1';

    // $chk = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'location_select'");
    // $chk1 = $chk->fetch_array();
    // if ($chk1["setting_value"] == 'true') {
    //     $locasel = $_POST["locasel"];
    // } else {
    //     // attempt to get default location//
    //     $loc = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'default_ship_location'");
    //     $defloc = $loc->fetch_array();
    //     $locasel = $defloc["setting_value"];
    // }

    // $theSession = $_COOKIE["savedData"];


    // if (isset($theSession)) {
    //     $theSession = json_decode($theSession, true);
    //     for ($i = 0; $i < count($theSession["cartitems"]); $i++) {
    //         $mydata[] = array("id" => $theSession["cartitems"][$i]["id"], "name" => $theSession["cartitems"][$i]["name"], "eqtype" => $theSession["cartitems"][$i]["eqtype"], "price" => $theSession["cartitems"][$i]["price"], "url" => $theSession["cartitems"][$i]["url"], "eqtabs" => $theSession["cartitems"][$i]["eqtabs"], "qty" => $theSession["cartitems"][$i]["qty"], "itemid" => $theSession["cartitems"][$i]["itemid"]);
    //     }

    //     $mydata[] = array("id" => $eqipid, "name" => $eqname, "eqtype" => $eqtype, "price" => $price, "url" => $url, "eqtabs" => $tabs, "qty" => $qty, "itemid" => $itemid);

    //     $eq = json_encode(array("shop_location" => $theSession["shop_location"], "cartitems" => $mydata, "discount_code" => "", "shipping_type" => "", "shipping_token" => "", "shipping_price" => ""));
    //     $chk = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'location_select'");
    //     $chk1 = $chk->fetch_array();
    //     if ($chk1["setting_value"] == 'true') {
    //         $x = $data->query("SELECT stock FROM equipment_location_manager WHERE equip_id = '$eqipid' AND equip_line = '$tabs' AND location_id = '$locasel'");
    //         if ($x->num_rows > 0) {
    //             $v = $x->fetch_array();
    //             if ($qty <= $v["stock"]) {
    //                 setcookie("savedData", $eq, time() + (86400 * 30), "/", false);
    //                 $retMess = array('response' => 'good', 'message' => 'Added to cart.');
    //             } else {
    //                 $retMess = array('response' => 'bad', 'message' => 'Out of stock at your selected location. Please select another location.');
    //             }
    //         } else {
    //             $retMess = array('response' => 'bad', 'message' => 'Out of stock at your selected location. Please select another location.');
    //         }
    //     } else {
    //         $chk = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'sell_per_qty'");
    //         $chk1 = $chk->fetch_array();

    //         if ($chk1["setting_value"] == 'true') {
    //             $aa = $data->query("SELECT stock FROM equipment_location_manager WHERE location_id = '$locasel' AND equip_id = '$eqipid' AND equip_line = '$tabs'");
    //             $bb = $aa->fetch_array();
    //             if ($bb["stock"] >= $qty) {
    //                 setcookie("savedData", $eq, time() + (86400 * 30), "/", false);
    //                 $retMess = array('response' => 'good', 'message' => 'Added to cart.');
    //             } else {
    //                 $retMess = array('response' => 'bad', 'message' => 'Not enough stock.');
    //             }
    //         } else {
    //             setcookie("savedData", $eq, time() + (86400 * 30), "/", false);
    //             $retMess = array('response' => 'good', 'message' => 'Added to cart.');
    //         }
    //     }



    //     $html .= '<input type="hidden" id="cart_total" name="cart_total" value="' . number_format($total, 2) . '">';
    //     echo json_encode($retMess);
    // } else {
    //     //$mydata[] = array("shop_location"=>$locasel);
    //     $mydata[] = array("id" => $eqipid, "name" => $eqname, "eqtype" => $eqtype, "price" => $price, "url" => $url, "eqtabs" => $tabs, "qty" => $qty, "itemid" => $itemid);

    //     $eq = json_encode(array("shop_location" => $locasel, "cartitems" => $mydata, "discount_code" => "", "shipping_type" => "", "shipping_token" => "", "shipping_price" => ""));

    //     //do some secondary stock checks//
    //     $chk = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'location_select'");
    //     $chk1 = $chk->fetch_array();
    //     if ($chk1["setting_value"] == 'true') {
    //         $x = $data->query("SELECT stock FROM equipment_location_manager WHERE equip_id = '$eqipid' AND equip_line = '$tabs' AND location_id = '$locasel'");
    //         if ($x->num_rows > 0) {
    //             $v = $x->fetch_array();
    //             if ($qty <= $v["stock"]) {
    //                 setcookie("savedData", $eq, time() + (86400 * 30), "/", false);
    //                 $retMess = array('response' => 'good', 'message' => 'Added to cart.');
    //             } else {
    //                 $retMess = array('response' => 'bad', 'message' => 'Out of stock at your selected location. Please select another location.');
    //             }
    //         } else {
    //             $retMess = array('response' => 'bad', 'message' => 'Out of stock at your selected location. Please select another location.');
    //         }
    //     } else {

    //         $chk = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'sell_per_qty'");
    //         $chk1 = $chk->fetch_array();

    //         if ($chk1["setting_value"] == 'true') {
    //             $aa = $data->query("SELECT stock FROM equipment_location_manager WHERE location_id = '$locasel' AND equip_id = '$eqipid' AND equip_line = '$tabs'");
    //             $bb = $aa->fetch_array();
    //             if ($bb["stock"] >= $qty) {
    //                 setcookie("savedData", $eq, time() + (86400 * 30), "/", false);
    //                 $retMess = array('response' => 'good', 'message' => 'Added to cart.');
    //             } else {
    //                 $retMess = array('response' => 'bad', 'message' => 'Not enough stock.');
    //             }
    //         } else {
    //             setcookie("savedData", $eq, time() + (86400 * 30), "/", false);
    //             $retMess = array('response' => 'good', 'message' => 'Added to cart.');
    //         }
    //     }

    //     $html .= '<input type="hidden" id="cart_total" name="cart_total" value="' . number_format($price, 2) . '">';

    //     echo json_encode($retMess);
    // }

    include("cart.php");
    $cart->AddNewCartItem(1508, "S100-Tractor", "custom", 5000.00, "http://localhost", "none", 1);
    $retMess = array('response' => 'good', 'message' => 'Added to cart.');
    echo json_encode($retMess);
}

//EDIT A CATEGORY//
if ($act == 'editcustcat') {
    try {
        $logger->log("Editing Custom Category...", "INFO");
        $selectedCatId = $_REQUEST["catid"];
        $a = $data->query("SELECT * FROM custom_equipment_pages WHERE id = '$selectedCatId'");
        $b = $a->fetch_array();
        $logger->log("" . $a->num_rows . " Categories Pulled From custom_equipment_pages DataTable", "INFO");

        $page_name = $b["page_name"];
        $page_content = $b["page_content"];
        $page_title = $b["page_title"];
        $page_desc = $b["page_desc"];
        $cat_img = $b["cat_img"];
        $cat_type = $b["cat_type"];
        $equipment_content = $b["equipment_content"];
        $view_type = $b["view_type"];

        $html .= '<div class="theresults"></div>';
        $html .= '<form name="createcategory" id="createcategory" method="post" action="" onsubmit="return false">';
        $html .= '<input type="hidden" name="page_id" id="page_id" value="' . $selectedCatId . '">';
        $html .= '<div class="row">';
        $html .= '<div class="col-md-12" style="margin-bottom: 30px"><h2 style="border-bottom: solid thin #efefef; max-width: 50%">EDIT CATEGORY</h2></div>';
        $html .= '<div class="col-md-4"><label>Category Name</label><br><input type="text" class="form-control" name="catname" id="catname" required="" value="' . $page_name . '"></div>';
        $html .= '<div class="col-md-4"><label>Category Type</label><br><select class="form-control" name="category_type" id="category_type" required="">';

        $html .= '<option value="">Select Category Type</option>';
        $typeOptions = array('Parent Category' => 'parent-category', 'Child Category' => 'child-category', 'Product Category' => 'product-category', 'Custom Category' => 'custom-category');
        foreach ($typeOptions as $key => $val) {
            if ($cat_type == $val) {
                $html .= '<option value="' . $val . '" selected="selected">' . $key . '</option>';
            } else {
                $html .= '<option value="' . $val . '">' . $key . '</option>';
            }
        }
        $html .= '</select>';
        $html .= '</div>';
        $html .= '<div class="col-md-4"><label>(Meta) Title Tag</label><br><input class="form-control" type="text" id="page_title" name="page_title" value="' . $page_title . '" required=""></div>';
        $html .= '</div>';

        $html .= '<br>';

        $html .= '<div class="row">';
        $html .= '<div class="col-md-8"><label>(Meta) Category Description & Short Text</label><br><textarea class="form-control" id="page_desc" name="page_desc" required="">' . $page_desc . '</textarea></div>';
        $html .= '<div class="col-md-4"><label>Category Image</label><div class="input-group mb-3"><input type="text" class="form-control" name="cat_img" id="cat_img" placeholder="No Image" aria-label="Category Image" value="' . $cat_img . '"><div class="input-group-append"><button class="btn btn-light img-browser" data-setter="
    " type="button">Browse Images</button></div></div></div>';
        $html .= '</div>';
        $html .= '<br>';
        $html .= '<div class="row">';
        $html .= '<div class="col-md-12">';
        $html .= '<div style="width: 100%">Assocated Products & Categories<br><small>You can drag and re-order items below.</small> <button style="float: right" class="btn btn-secondary btn-sm" onclick="openCatz()" type="button"><i class="fa fa-plus" aria-hidden="true"></i> Add Categories</button> <button type="button" style="float: right; margin: 0px 5px" class="btn btn-light btn-sm" onclick="openProds()"><i class="fa fa-plus" aria-hidden="true"></i> Add Products</button></div><br>';
        //CREATE THE PRODUCT AND CATEGORY OBJECTS//

        $prdCatBreak = json_decode($equipment_content, true);

        for ($i = 0; $i < count($prdCatBreak); $i++) {
            if ($prdCatBreak[$i]["type"] == 'prod') {
                $c = $data->query("SELECT id,title FROM custom_equipment WHERE id = '" . $prdCatBreak[$i]["id"] . "'");
                $d = $c->fetch_array();
                $prodCatOuts .= '<span class="badge badge-light prodblox draggable" data-prodids="' . $prdCatBreak[$i]["id"] . '"><i style="color: #e3e3e3;padding: 3px;" class="fa fa-th dragsa" aria-hidden="true"></i> ' . $d["title"] . ' <i class="fa fa-window-close closeitem" data-prodids="' . $prdCatBreak[$i]["id"] . '" aria-hidden="true"></i></span>';
            } else {
                $c = $data->query("SELECT page_name,page_title,id FROM custom_equipment_pages WHERE id = '" . $prdCatBreak[$i]["id"] . "'");
                $d = $c->fetch_array();
                $prodCatOuts .= '<span class="badge badge-secondary catblox draggable" data-catids="' . $prdCatBreak[$i]["id"] . '"><i style="color: #e3e3e3;padding: 3px;" class="fa fa-th dragsa" aria-hidden="true"></i> ' . $d["page_name"] . ' <i class="fa fa-window-close closeitem" data-catids="' . $prdCatBreak[$i]["id"] . '" aria-hidden="true"></i></span>';
            }
        }
        $html .= '<div class="jumbotron product-holder droparea" style="padding: 10px; border: dashed thin #bcbbbb;">';
        $html .= $prodCatOuts;
        $html .= '</div>';
        $html .= '<input type="hidden" name="selecteditems" id="selecteditems" value="' . $equipment_content . '">';

        //handle view//
        if ($view_type == 'list') {
            $listActive = 'active';
        } else {
            $listActive = '';
        }
        if ($view_type == 'grid') {
            $gridActive = 'active';
        } else {
            $gridActive = '';
        }


        $html .= '<label>Select Product / Category Views</label><br>';
        $html .= '<div class="btn-group btn-group-lg" role="group" aria-label="..."><button type="button" class="btn btn-secondary viewtypbtn ' . $gridActive . '" data-viewtype="grid"><i class="fa fa-th" aria-hidden="true"></i></button>
  <button type="button" class="btn btn-secondary viewtypbtn ' . $listActive . '" data-viewtype="list"><i class="fa fa-list" aria-hidden="true"></i></button></div>';
        $html .= '<input type="hidden" name="view_type" id="view_type" value="' . $view_type . '">';
        $html .= '</div>';
        $html .= '</div>';

        $html .= '<br>';

        $html .= '<div class="row">';
        $html .= '<div class="col-md-12">';
        $html .= '<label>Page Details</label><br>';
        $html .= '<small>Below is the <span style="color: red">{prodcat}data{/prodcat}</span> You can move and adjust this token anywhere on the category page details.</small><br>';
        $html .= '<textarea class="summernote" name="page_details" id="page_details">' . $page_content . '</textarea>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<br>';
        $html .= '<div class="row">';
        $html .= '<div class="col-md-12" style="text-align: right"><button type="submit" class="btn btn-success">Save Category</button></div>';
        $html .= '</div>';
        $html .= '</form>';

        $logger->log("'Edit Category' Form Created Successfully!", "INFO");
    } catch (Exception $e) {
        $logger->log("ERROR:  Failed To Create 'Edit Category' Form! - " . $e, "ERROR");
    }

    echo $html;
}

//FINALIZE A CATEGORY SAVE//
if ($act == 'savecat') {
    $logger->log("SaveCat() Started...", "INFO");
    //[{"type":"prod","id":1508},{"type":"prod","id":1509}]

    try {
        $catname = $_POST["catname"];
        $category_type = $_POST["category_type"];
        $page_title = $_POST["page_title"];
        $page_desc = $_POST["page_desc"];
        $cat_img = $_POST["cat_img"];
        $selecteditems = $_POST["selecteditems"];
        $logger->log("SaveCat() 'selecteditems' = " . $selecteditems, "INFO");
        $page_details = $_POST["page_details"];
        $view_type = $_POST["view_type"];
        $cat_id = $_POST["page_id"];

        if ($selecteditems == null || $selecteditems == "" || !isset($selecteditems)) {
            $selecteditems = "[{}]";
        }

        if (isset($cat_id) && $cat_id != null) {
            $data->query("UPDATE custom_equipment_pages SET page_name = '" . $data->real_escape_string($catname) . "', page_content = '" . $data->real_escape_string($page_details) . "', page_title = '" . $data->real_escape_string($page_title) . "', page_desc = '" . $data->real_escape_string($page_desc) . "', cat_img = '" . $data->real_escape_string($cat_img) . "', cat_type = '" . $data->real_escape_string($category_type) . "', equipment_content = '" . $data->real_escape_string($selecteditems) . "', view_type = '" . $data->real_escape_string($view_type) . "', last_edit = '" . time() . "' WHERE id = '$cat_id'") or die($data->error);
            $results = array("items" => $selecteditems, "status" => "good", "message" => '<div class="alert alert-success"><strong>Awesome!.</strong><br><p>Your category has been successfully updated. </p></div>', "page_id" => $cat_id);
        } else {
            //make sure the is no other category with the same name//
            $a = $data->query("SELECT page_name FROM custom_equipment_pages WHERE page_name = '$catname' AND active = 'true'");
            if ($a->num_rows == 0) {
                $data->query("INSERT INTO custom_equipment_pages SET page_name = '" . $data->real_escape_string($catname) . "', page_content = '" . $data->real_escape_string($page_details) . "', page_title = '" . $data->real_escape_string($page_title) . "', page_desc = '" . $data->real_escape_string($page_desc) . "', cat_img = '" . $data->real_escape_string($cat_img) . "', cat_type = '" . $data->real_escape_string($category_type) . "', equipment_content = '" . $data->real_escape_string($selecteditems) . "', view_type = '" . $data->real_escape_string($view_type) . "', last_edit = '" . time() . "'") or die($data->error);
                $insertID = $data->insert_id;

                $b = $data->query("SELECT page_name FROM custom_equipment_pages WHERE page_name = '$catname' AND active = 'true'");
                $results = array("items" => $selecteditems, "status" => "good", "message" => '<div class="alert alert-success"><strong>You new category has been saved.</strong><br><p>You can continue to edit or you can go back to the category page.</p></div>', "page_id" => $b["id"]);
            } else {
                //already exist//
                $results = array("items" => $selecteditems, "status" => "bad", "message" => '<div class="alert alert-warning"><strong>Whoops!.</strong><br><p>It appears you have a category with the same name already active.<br>Please re-name your category or try accessing it from the category menu.</p></div>', "page_id" => '');
            }
        }
        $logger->log("Updated Category '" . $catname . "' Successfully.", "INFO");
    } catch (Exception $e) {
        $logger->log("ERROR:  Failed To Update Category Info! - " . $e, "ERROR");
    }

    echo json_encode($results);
}

//PULL A LIST OF THE CATEGORIES//
if ($act == 'getcategories') {
    try {
        $logger->log("GetCategories Has Started...", "INFO");
        $html .= '<div class="row">
    <div class="col-md-12 prodmess"></div><div class="col-md-6"><h2 style="border-bottom: solid thin #efefef; max-width: 50%">CATEGORIES</h2></div><div class="col-md-6" style="text-align: right"><button class="btn btn-dark" onclick="createNewCat()"><i class="fa fa-plus" aria-hidden="true"></i> Create New</button></div></div>
        <br>
        <table id="example" class="display" style="width:100%">
            <thead>
            <tr>
                <th>Category</th>
                <th>Products / Categories</th>
                <th style="text-align: right">Action</th>
            </tr>
            </thead>
            <tbody>';

        $a = $data->query("SELECT * FROM custom_equipment_pages WHERE active = 'true'");
        while ($b = $a->fetch_array()) {
            $eqipmentContent = json_decode($b["equipment_content"], true);
            $html .= '<tr>
                <td>' . $b["page_name"] . '</td>
                <td>' . count($eqipmentContent) . '</td>
                <td style="text-align: right"><button class="btn btn-secondary" onclick="editCat(\'' . $b["id"] . '\')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button> <button class="btn btn-danger" onclick="StartDeleteCat(\'' . $b["id"] . '\')"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
            </tr>';
        }

        $html .= '</tbody>
            <tfoot>
            <tr>
                <th>Category</th>
                <th>Products / Categories</th>
                <th style="text-align: right">Action</th>
            </tr>
            </tfoot>
        </table>';
        $logger->log("GetCategories() Completed Successfully!", "INFO");
    } catch (Exception $e) {
        $logger->log("ERROR:  Failed To Get Categories From Database! - " . $e, "ERROR");
    }

    echo $html;
}

//GET A LIST OF ACTIVE PRODUCTS FOR SELECTION//
if ($act == 'openprods') {
    try {
        $logger->log("OpenProds() Started...", "INFO");
        $theChecks = $_POST["checkdata"];
        $logger->log("OpenProds() Check-Data = " . $theChecks, "INFO");

        $html .= '<form name="productssels" id="productssels"><table id="products" class="display" style="width:100%">
            <thead>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Primary Category</th>
                <th>Price</th>
                <th style="text-align: left">Status</th>
            </tr>
            </thead>
            <tbody>';


        $a = $data->query("SELECT id, title, sales_price, reg_price, parent_cat FROM custom_equipment WHERE active = 'true' ORDER BY title DESC") or die($data->error);
        while ($b = $a->fetch_array()) {

            if ($b["parent_cat"] != null) {
                $c = $data->query("SELECT page_name FROM custom_equipment_pages WHERE id = '" . $b["parent_cat"] . "'");
                $d = $c->fetch_array();
                $category = $d["page_name"];
            } else {
                $category = '-Not Set-';
            }

            if (in_array($b["id"], $theChecks)) {
                $html .= '<tr><td style="text-align: center"><label class="inpcontainer"><input class="prodoptions" type="checkbox" name="prodsel[]" id="prodsel[]" value="' . $b["id"] . '" data-prodname="' . $b["title"] . '" checked="checked"><span class="checkmark"></span></label></td><td>' . $b["title"] . '</td><td>' . $category . '</td><td>$' . $b["reg_price"] . '</td><td style="text-align: left">In Stock</td></tr>';
            } else {
                $html .= '<tr><td style="text-align: center"><label class="inpcontainer"><input class="prodoptions" type="checkbox" name="prodsel[]" id="prodsel[]" value="' . $b["id"] . '" data-prodname="' . $b["title"] . '"><span class="checkmark"></span></label></td><td>' . $b["title"] . '</td><td>' . $category . '</td><td>$' . $b["reg_price"] . '</td><td style="text-align: left">In Stock</td></tr>';
            }
        }

        $html .= '</tbody></table></form>';
        $html .= '<br><div style="text-align: right"><button class="btn btn-success" onclick="getSelectedProducts()">Save Selection</button></div>';
        $logger->log("OpenProds() Completed Successfully!", "INFO");
    } catch (Exception $e) {
        $logger->log("ERROR:  Failed To Open Products in 'openprods'! - " . $e, "ERROR");
    }
    echo $html;
}

//OPENS A LIST OF CATEGORIES FOR SELECTION//
if ($act == 'opencats') {
    try {
        $logger->log("OpenCats() Started...", "INFO");

        $theChecks = $_POST["checkdata"];
        $logger->log("OpenCats() Check-Data = " . $theChecks, "INFO");

        $html .= '<form name="categoryssels" id="categoryssels"><table id="cateogries" class="display" style="width:100%">
            <thead>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Products</th>
            </tr>
            </thead>
            <tbody>';

        $a = $data->query("SELECT id, page_name FROM custom_equipment_pages WHERE active = 'true' ORDER BY page_name DESC");
        while ($b = $a->fetch_array()) {
            if (in_array($b["id"], $theChecks)) {
                $html .= '<tr><td style="text-align: center"><label class="inpcontainer"><input class="catoptions" type="checkbox" name="catsel[]" id="catsel[]" value="' . $b["id"] . '" data-catname="' . $b["page_name"] . '" checked="checked"><span class="checkmark"></span></label></td><td>' . $b["page_name"] . '</td><td style="text-align: left">Count Here</td></tr>';
            } else {
                $html .= '<tr><td style="text-align: center"><label class="inpcontainer"><input class="catoptions" type="checkbox" name="catsel[]" id="catsel[]" value="' . $b["id"] . '" data-catname="' . $b["page_name"] . '"><span class="checkmark"></span></label></td><td>' . $b["page_name"] . '</td><td style="text-align: left">Count Here</td></tr>';
            }
        }

        $html .= '</tbody></table></form>';
        $html .= '<br><div style="text-align: right"><button class="btn btn-success" onclick="getSelectedCategories()">Save Selection</button></div>';
        $logger->log("OpenCats() Completed Successfully!", "INFO");
    } catch (Exception $e) {
        $logger->log("ERROR:  Failed To Open Category in 'opencats'! - " . $e, "ERROR");
    }

    echo $html;
}

//GETS THE ENTIRE ACTIVE PRODUCT LIST//
if ($act == 'getproducts') {
    try {
        $logger->log("GetProducts() Started...", "INFO");

        $html .= '<div class="row">
    <div class="col-md-12 prodmess"></div>
    <div class="col-md-6">
    <h2 style="border-bottom: solid thin #efefef; max-width: 50%">PRODUCTS</h2>
    </div><div class="col-md-6" style="text-align: right">
    <button class="btn btn-dark" onclick="createProduct()" style="font-weight: bold">
    <i class="fa fa-plus" aria-hidden="true"></i> Create New</button>
    <button class="btn btn-warning" style="font-weight: bold" onclick="openProdProps()"><i class="fa fa-cog" aria-hidden="true"></i> More Options</button></div></div>
        <br>
        <table id="example" class="display" style="width:100%">
            <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Primary Category</th>
                <th>SKU</th>
                <th>Stock</th>
                <th>Price</th>
                <th style="text-align: right">Action</th>
            </tr>
            </thead>
            <tbody>';

        $a = $data->query("SELECT * FROM custom_equipment WHERE active = 'true'");
        while ($b = $a->fetch_array()) {

            $name = $b["title"];

            $sku = $b["sku"];
            $stock = $b["stock"];
            $price = str_replace(",", "", $b["reg_price"]);

            //sku//
            if ($sku != null) {
                $sku = $sku;
            } else {
                $sku = '-Not Set-';
            }

            if ($b["parent_cat"] != null) {
                $c = $data->query("SELECT page_title FROM custom_equipment_pages WHERE id = '" . $b["parent_cat"] . "'");
                $d = $c->fetch_array();
                $primaryCat = $d["page_title"];
            } else {
                $primaryCat = '-Not Set-';
            }

            //do category stuff//

            $eqimages = json_decode($b["eq_image"], true);

            if ($eqimages[0] != null) {
                $mainImg = '../../' . $eqimages[0];
            } else {
                $mainImg = '../../img/no-image.jpg';
            }

            $html .= '<tr>
                <td><div class="img-thumbnail" style="background-repeat: no-repeat; background-size: contain; background-position: center"><img onclick="" style="width: 100%; cursor: pointer" src="../../img/product_overlay.png"></div></td>
                <td>' . $name . '</td>
                <td>' . $primaryCat . '</td>
                <td>' . $sku . '</td>
                <td>' . $stock . '</td>
                <td>$' . number_format($price, 2) . '</td>
                <td style="text-align: right"><button class="btn btn-secondary" onclick="editProduct(' . $b["id"] . ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button> <button class="btn btn-danger" onclick="StartDeleteProd(' . $b['id'] . ')"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
            </tr>';
        }

        $html .= '</tbody>
        </table>';

        $logger->log("GetProducts() Completed Successfully!", "INFO");
    } catch (Exception $e) {
        $logger->log("ERROR:  Failed To Get Products in 'getproducts'! - " . $e, "ERROR");
    }

    echo $html;
}

if ($act == "deleteproduct") {
    try {
        $logger->log("DeletePoduct() Started... ID: " . $_REQUEST['id'], "INFO");
        $id = $_REQUEST['id'];

        $a = $data->query("UPDATE custom_equipment SET active = 'false' WHERE id = '$id'");
        $b = $data->query("SELECT * FROM custom_equipment WHERE id = '.$id.'");
        if ($b->num_rows == 0) {
            $logger->log("DeleteProduct() Deleted Product Successfully!", "INFO");
            $ars = array('status' => 'good', 'message' => '<div class="alert alert-success"><strong>Awesome!</strong><p>You Product Has Been Successfully Deleted.</p></div>');
            echo json_encode($ars);
        } else {
            $logger->log("DeleteProduct() Failed To Find Product in 'custom_equipment'!", "ERROR");
            $ars = array('status' => 'bad', 'message' => '<div class="alert alert-danger"><strong>Whoops!</strong><p>There Was An Error Deteling Your Product.<br>Please Try Again.</p></div>');
            echo json_encode($ars);
        }
    } catch (Exception $e) {
        $logger->log("ERROR:  Failed To Delete Product in 'deleteproduct'! - " . $e, "ERROR");
        $ars = array('status' => 'bad', 'message' => '<div class="alert alert-danger"><strong>Whoops!</strong><p>There Was An Error Deteling Your Product.<br>Please Try Again.</p></div>', 'error' => $e);
        echo json_encode($ars);
    }
}

// DELETE CATEGORY //
if ($act == "deletecategory") {
    try {
        $logger->log("DeleteCategory() Started... ID: " . $_REQUEST['id'], "INFO");
        $id = $_REQUEST['id'];

        $a = $data->query("UPDATE custom_equipment_pages SET active = 'false' WHERE id = '$id'");
        $b = $data->query("SELECT * FROM custom_equipment_pages WHERE id = '$id'");
        $logger->log("DeleteCategory() Deleted Category Successfully!", "INFO");
        $ars = array('status' => 'good', 'message' => '<div class="alert alert-success"><strong>Awesome!</strong><p>You Product Has Been Successfully Deleted.</p></div>');
        echo json_encode($ars);
    } catch (Exception $e) {
        $logger->log("ERROR:  Failed To Delete Category in 'deletecategory'! - " . $e, "ERROR");
        $ars = array('status' => 'bad', 'message' => '<div class="alert alert-danger"><strong>Whoops!</strong><p>There Was An Error Deteling Your Product.<br>Please Try Again.</p></div>', 'error' => $e);
        echo json_encode($ars);
    }
}

//CREATE PRODUCT FORM//
if ($act == 'createproduct') {
    try {
        $logger->log("createProduct() Started...", "INFO");

        $html .= '<form name="newproductadd" id="newproductadd" method="post" action="">';
        $html .= '<div class="row">';
        $html .= '<div class="col-md-12 prodmess"></div>';
        $html .= '<div class="col-md-12" style="margin-bottom: 30px"><h2 style="border-bottom: solid thin #efefef; max-width: 50%">CREATE PRODUCT</h2></div>';
        $html .= '<div class="col-md-4"><label style="font-weight: bold">Product Name</label><br><input type="text" class="form-control" name="prod_name" id="prod_name" required="required"></div>';
        $html .= '<div class="col-md-4"><label style="font-weight: bold">Primary Category</label><br>';
        $html .= '<select class="form-control" name="categorysel" id="categorysel">';
        $html .= '<option value="">Select Category</option>';

        $cat = $data->query("SELECT id, page_name FROM custom_equipment_pages WHERE active = 'true' ORDER BY page_name ASC");
        while ($catdet = $cat->fetch_array()) {
            if ($category_sel == $catdet["id"]) {
                $html .= '<option value="' . $catdet["id"] . '" selected="selected">' . $catdet["page_name"] . '</option>';
            } else {
                $html .= '<option value="' . $catdet["id"] . '">' . $catdet["page_name"] . '</option>';
            }
        }

        $html .= '</select>';

        $html .= '</div>';
        $html .= '</div>';
        $html .= '<br>';
        $html .= '<div class="row">';
        $html .= '<div class="col-md-4"><label style="font-weight: bold">SKU</label><br><input type="text" class="form-control" name="prod_sku" id="prod_sku"></div>';
        $html .= '<div class="col-md-2"><label style="font-weight: bold">Inventory</label><br><select class="form-control" name="prod_stock" id="prod_stock"><option value="in_stock">In Stock</option><option value="low_inventory">Low Inventory</option><option value="backorder">On Backorder</option><option value="out_of_stock">Out of Stock</option></select></div>';
        $html .= '<div class="col-md-2"><label style="font-weight: bold">Product Price</label><br><input type="text" class="form-control" name="prod_price" id="prod_price" placeholder="0.00" required="required"></div>';
        $html .= '<div class="col-md-2"><label style="font-weight: bold">Sales Price</label><br><input type="text" class="form-control" name="sales_price" id="sales_price" placeholder="0.00"></div>';
        $html .= '</div>';

        $html .= '<br>';

        $html .= '<div class="row">';
        $html .= '<div class="col-md-4"><label style="font-weight: bold">(Meta) Title Tag</label><br><input class="form-control" type="text" id="page_title" name="page_title" value="" required=""></div>';
        $html .= '<div class="col-md-8"><label style="font-weight: bold">(Meta) Product Description</label><br><textarea class="form-control" id="page_desc" name="page_desc" required="">' . $page_desc . '</textarea></div>';
        $html .= '</div>';

        $html .= '<div class="row">';
        $html .= '<div class="col-md-12"><label style="font-weight: bold">Short Descriptions</label><br><small>This information will generally float next to product images.</small><br><br><textarea class="summernote" name="product_page_short_details" id="product_page_short_details" style="max-height: 90px"></textarea></div>';
        $html .= '</div>';

        $html .= '<br>';

        $html .= '<div class="row">';
        $html .= '<div class="col-md-12"><label style="font-weight: bold">Product Information</label><br><textarea class="summernote" name="product_page_details" id="product_page_details" style="max-height: 90px"></textarea></div>';
        $html .= '</div>';

        $html .= '<br>';

        $html .= '<div class="row">';
        $html .= '<div class="col-md-4"><label style="font-weight: bold">Product Type</label><br><select class="form-control" name="product_type" id="product_type"><option value="physical">Physical Product</option> <option value="digital">Digital / Downloadable Product</option></select></div>';

        $html .= '<div class="digital_properties col-md-8 row"style="display: none">';
        $html .= '<label style="font-weight: bold">Select Downloadable File</label><div class="input-group mb-3"><input type="text" class="form-control" name="download_file" id="download_file" placeholder="No File Selected" aria-label="Download File" value=""><div class="input-group-append"><button class="btn btn-light img-browser" data-setter="download_file" type="button">Browse Files</button></div></div>';
        $html .= '<div><label style="font-weight: bold">Download Limit</label><br><input type="number" class="form-control" name="download_limit" id="download_limit" value="1" min="1"></div>';
        $html .= '</div>';

        $html .= '<div class="shipping_properties col-md-8 row">';
        $html .= '<div class="col-md-4"><label style="font-weight: bold">Product Weight</label><br><input type="text" class="form-control" name="prod_weight" id="prod_weight" value=""></div>';
        $html .= '<div class="col-md-8"><label style="font-weight: bold">Product Dimensions <small>(Width X Height X Depth)</small></label><br><div class="input-group"><input type="text" class="form-control input-sm" name="prod_width" id="prod_weight" value="" placeholder="Width"> <input type="text" class="form-control input-sm" name="prod_height" id="prod_height" value="" placeholder="Height"> <input type="text" class="form-control input-sm" name="prod_depth" id="prod_depth" value="" placeholder="Depth"></div></div>';
        $html .= '</div>';
        $html .= '</div>';

        $html .= '<br>';

        $locationOptions .= '<select class="form-control" name="pickup_location" id="pickup_location">';

        $p = $data->query("SELECT id, location_name FROM location WHERE active = 'true' ORDER BY location_name DESC");
        while ($q = $p->fetch_array()) {
            $locationOptions .= '<option value="' . $q["id"] . '">' . $q["location_name"] . '</option>';
        }

        $locationOptions .= '</select>';

        $html .= '<div class="row shipping_properties">';
        $html .= '<div class="col-md-4"><label style="font-weight: bold">Deliverable Options</label><br><select class="form-control" name="delivery_type" id="delivery_type"><option value="api_system">Use Shipping API\'s (UPS, USPS, FEDEX etc..)</option> <option value="flat_rate">Flat Rate Shipping / Delivery</option> <option value="pickup_only">Pickup Only</option></select></div>';
        $html .= '<div class="col-md-8"><div class="jumbotron" style="padding: 20px; color: grey"><div class="flat_option delivery_options" style="display: none"><label>Flat Rate Shipping Cost</label><br><input class="form-control" type="text" name="flat_shipping_cost" id="flat_shipping_cost" placeholder="0.00"></div><div class="system_option delivery_options">System will use shipping API.<br><small style="color: #800101">NOTE! - Product must have weight and dimentions added.</small></div><div class="pickup_option delivery_options" style="display: none"><label>Select Pickup Location</label><br>' . $locationOptions . '</div></div></div>';
        $html .= '</div>';

        $html .= '<br>';

        $html .= '<hr>';

        $html .= '<div class="row">';
        $html .= '<div class="col-md-12"><h5>Images</h5><small>Select up to 4 images.</small></div>';
        $html .= '<br><br><br>';
        $html .= '<div class="col-md-3"><label style="font-weight: bold">Main Image</label><div class="input-group mb-3"><input type="text" class="form-control" name="pro_img" id="pro_img" placeholder="No Image" aria-label="Category Image" value=""><div class="input-group-append"><button class="btn btn-light img-browser" data-setter="pro_img" type="button">Browse Images</button></div></div><div class="imgprev pro_img" style="background-image: url(\'../../img/no-image.jpg\'); background-position: center; background-size: contain; background-repeat: no-repeat"><img style="width: 100%" src="../../img/spacer.png"></div></div>';
        $html .= '<div class="col-md-3"><label style="font-weight: bold">Image Two</label><div class="input-group mb-3"><input type="text" class="form-control" name="pro_img_2" id="pro_img_2" placeholder="No Image" aria-label="Category Image" value=""><div class="input-group-append"><button class="btn btn-light img-browser" data-setter="pro_img_2" type="button">Browse Images</button></div></div><div class="imgprev pro_img_2" style="background-image: url(\'../../img/no-image.jpg\'); background-position: center; background-size: contain; background-repeat: no-repeat"><img style="width: 100%" src="../../img/spacer.png"></div></div>';
        $html .= '<div class="col-md-3"><label style="font-weight: bold">Image Three</label><div class="input-group mb-3"><input type="text" class="form-control" name="pro_img_3" id="pro_img_3" placeholder="No Image" aria-label="Category Image" value=""><div class="input-group-append"><button class="btn btn-light img-browser" data-setter="pro_img_3" type="button">Browse Images</button></div></div><div class="imgprev pro_img_3" style="background-image: url(\'../../img/no-image.jpg\'); background-position: center; background-size: contain; background-repeat: no-repeat"><img style="width: 100%" src="../../img/spacer.png"></div></div>';
        $html .= '<div class="col-md-3"><label style="font-weight: bold">Image Four</label><div class="input-group mb-3"><input type="text" class="form-control" name="pro_img_4" id="pro_img_4" placeholder="No Image" aria-label="Category Image" value=""><div class="input-group-append"><button class="btn btn-light img-browser" data-setter="pro_img_4" type="button">Browse Images</button></div></div><div class="imgprev pro_img_4" style="background-image: url(\'../../img/no-image.jpg\'); background-position: center; background-size: contain; background-repeat: no-repeat"><img style="width: 100%" src="../../img/spacer.png"></div></div>';

        $html .= '</div>';

        $html .= '<br>';
        $html .= '<hr>';

        $html .= '<div class="row">';
        $html .= '<div class="col-md-12"><h5>Attributes</h5><small>Add your products attributes below.</small></div>';

        $html .= '<div style="clear: both; width: 100%; text-align: right; padding: 10px"><button type="button" class="btn btn-sm btn-dark" onclick="buildOutAttr()">Add Attribute</button></div>';
        $html .= '<br>';
        $html .= '<div class="col-md-12">';
        $html .= '<table class="table attr_bholder">';
        $html .= '<tr><td><b>Group Name</b></td><td><b>Attributes</b></td><td style="text-align: right"><b>Action</b></td></tr>';
        $html .= '</table>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<hr>';
        $html .= '<div class="row">';
        $html .= '<div class="col-md-12" style="text-align: right"><button type="submit" class="btn btn-primary btn-lg prosubbutton">Create Product</button></div>';
        $html .= '</div>';
        $html .= '</form>';

        $logger->log("CreateProduct() Completed Successfully!", "INFO");
    } catch (Exception $e) {
        $logger->log("ERROR:  Failed To Create Product Form in 'createproduct'!" . $e, "ERROR");
    }
    echo $html;
}

//SAVE THE PRODUCT//
if ($act == 'createproductfin') {
    try {
        $logger->log("createProductFin() Started...", "INFO");

        $prodId = $_POST["prod_id"];
        $prod_name = $_POST["prod_name"];
        $category_sel = $_POST["categorysel"];
        $prod_sku = $_POST["prod_sku"];
        $prod_stock = $_POST["prod_stock"];
        $prod_price = $_POST["prod_price"];
        $sales_price = $_POST["sales_price"];
        $page_title = $_POST["page_title"];
        $page_desc = $_POST["page_desc"];
        $product_page_short_details = $_POST["product_page_short_details"];
        $product_page_details = $_POST["product_page_details"];
        $product_type = $_POST["product_type"];
        $download_file = $_POST["download_file"];
        $download_limit = $_POST["download_limit"];
        $prod_weight = $_POST["prod_weight"];
        $prod_width = $_POST["prod_width"];
        $prod_height = $_POST["prod_height"];
        $prod_depth = $_POST["prod_depth"];


        $dimensions = $prod_width . 'X' . $prod_height . 'X' . $prod_depth;

        $delivery_type = $_POST["delivery_type"];

        if ($delivery_type == 'pickup') {
            $pickup_only = 'true';
        } else {
            $pickup_only = 'false';
        }

        $flat_shipping_cost = $_POST["flat_shipping_cost"];
        $pickup_location = $_POST["pickup_location"];
        $pro_img[] = $_POST["pro_img"];
        $pro_img[] = $_POST["pro_img_2"];
        $pro_img[] = $_POST["pro_img_3"];
        $pro_img[] = $_POST["pro_img_4"];
        $attrsel = $_POST["attrsel"];


        $proimg = json_encode($pro_img);

        if ($attrsel != null) {
            $attrsel = json_encode($attrsel);
        } else {
            $attrsel = '';
        }

        if (isset($prodId)) {

            //do category stuff//
            if ($category_sel != null) {

                $a = $data->query("SELECT equipment_content FROM custom_equipment_pages WHERE id = '$category_sel'");
                $b = $a->fetch_array();
                $equipment_content = $b["equipment_content"];

                $prdCatBreak = json_decode($equipment_content, true);

                if (in_array($prodId, array_column($prdCatBreak, 'id'))) {
                    //DO NOTHING BECAUSE IT EXIST//
                } else {

                    $c = $data->query("SELECT parent_cat FROM custom_equipment WHERE id = '$prodId'");
                    $d = $c->fetch_array();

                    $currentParent = $d["parent_cat"];

                    if ($currentParent != null) {
                        $e = $data->query("SELECT equipment_content FROM custom_equipment_pages WHERE id = '$currentParent'");
                        $f = $e->fetch_array();

                        $currentBreak = json_decode($f["equipment_content"], true);

                        for ($x = 0; $x < count($currentBreak); $x++) {
                            if ($prodId == $currentBreak[$x]["id"]) {
                                //removes if present//
                            } else {
                                $newArsZero[] = array("type" => $currentBreak[$x]["type"], "id" => $currentBreak[$x]["id"]);
                            }

                            $newArsZero = json_encode($newArsZero);

                            $data->query("UPDATE custom_equipment_pages SET equipment_content = '$newArsZero' WHERE id = '$currentParent'");
                        }
                    }

                    for ($i = 0; $i < count($prdCatBreak); $i++) {
                        $newArs[] = array("type" => $prdCatBreak[$i]["type"], "id" => $prdCatBreak[$i]["id"]);
                    }
                    $newArs[] = array("type" => 'prod', 'id' => $prodId);

                    $newArs = json_encode($newArs);


                    $data->query("UPDATE custom_equipment_pages SET equipment_content = '" . $newArs . "' WHERE id = '$category_sel'");
                    $primary_category = $category_sel;
                }
            } else {
                $primary_category = '';
            }


            $data->query("UPDATE custom_equipment SET parent_cat = '$category_sel', title = '" . $data->real_escape_string($prod_name) . "', eq_image = '" . $data->real_escape_string($proimg) . "', description = '" . $data->real_escape_string($product_page_details) . "', meta_title = '" . $data->real_escape_string($page_title) . "', meta_description = '" . $data->real_escape_string($page_desc) . "', reg_price = '" . $data->real_escape_string($prod_price) . "', sales_price = '" . $data->real_escape_string($sales_price) . "', product_type = '" . $data->real_escape_string($product_type) . "', download_product_link = '" . $data->real_escape_string($download_file) . "', download_limit = '" . $data->real_escape_string($download_limit) . "', product_attributes = '" . $data->real_escape_string($attrsel) . "', features = '" . $data->real_escape_string($product_page_details) . "',  sku = '" . $data->real_escape_string($prod_sku) . "', weight = '" . $data->real_escape_string($prod_weight) . "', ship_type = '" . $data->real_escape_string($delivery_type) . "', pickup_only = '" . $data->real_escape_string($pickup_only) . "', dimentions = '" . $data->real_escape_string($dimensions) . "', flat_rate_shipping = '" . $data->real_escape_string($flat_shipping_cost) . "', pickup_location = '" . $data->real_escape_string($pickup_location) . "', stock = '" . $data->real_escape_string($prod_stock) . "', short_description = '" . $data->real_escape_string($product_page_short_details) . "' WHERE id = '$prodId'") or die($data->error);
            $results = array("status" => "good", "message" => '<div class="alert alert-success"><strong>Notice!</strong><br><p>Product has been updated.</p></div>', "prod_id" => $prodId);
        } else {
            $data->query("INSERT INTO custom_equipment SET parent_cat = '$category_sel', title = '" . $data->real_escape_string($prod_name) . "', eq_image = '" . $data->real_escape_string($proimg) . "', description = '" . $data->real_escape_string($product_page_details) . "', meta_title = '" . $data->real_escape_string($page_title) . "', meta_description = '" . $data->real_escape_string($page_desc) . "', reg_price = '" . $data->real_escape_string($prod_price) . "', sales_price = '" . $data->real_escape_string($sales_price) . "', product_type = '" . $data->real_escape_string($product_type) . "', download_product_link = '" . $data->real_escape_string($download_file) . "', download_limit = '" . $data->real_escape_string($download_limit) . "', product_attributes = '" . $data->real_escape_string($attrsel) . "', features = '" . $data->real_escape_string($product_page_details) . "',  sku = '" . $data->real_escape_string($prod_sku) . "', weight = '" . $data->real_escape_string($prod_weight) . "', ship_type = '" . $data->real_escape_string($delivery_type) . "', pickup_only = '" . $data->real_escape_string($pickup_only) . "', dimentions = '" . $data->real_escape_string($dimensions) . "', flat_rate_shipping = '" . $data->real_escape_string($flat_shipping_cost) . "', pickup_location = '" . $data->real_escape_string($pickup_location) . "', stock = '" . $data->real_escape_string($prod_stock) . "', short_description = '" . $data->real_escape_string($product_page_short_details) . "'") or die($data->error);

            $newProdId = $data->insert_id;
            //do category stuff here//
            if ($category_sel != null) {
                $a = $data->query("SELECT equipment_content FROM custom_equipment_pages WHERE id = '$category_sel'");
                $b = $a->fetch_array();
                $logger->log("CreateProductFin() - " . $a->num_rows . " Rows", "INFO");
                $equipment_content = $b["equipment_content"];

                if ($b['equipment_content'] != null) {
                    $prdCatBreak = json_decode($equipment_content, true);

                    for ($i = 0; $i < count($prdCatBreak); $i++) {
                        $newArs[] = array("type" => $prdCatBreak[$i]["type"], "id" => $prdCatBreak[$i]["id"]);
                    }
                    $newArs[] = array("type" => 'prod', 'id' => $newProdId);
                    $newArs = json_encode($newArs);

                    $data->query("UPDATE custom_equipment_pages SET equipment_content = '$newArs' WHERE id = '$category_sel'");
                }
            }


            $results = array("status" => "good", "message" => '<div class="alert alert-success"><strong>Awesome!.</strong><br><p>Your Product has been successfully CREATED.</div>', "prod_id" => $prodId);
        }

        $logger->log("CreateProductFin() Completed Successfully!", "INFO");
    } catch (Exception $e) {
        $logger->log("ERROR:  Failed To Create Product in 'createproductfin'! - " . $e, "ERROR");
    }

    echo json_encode($results);
}

//EDIT A PRODUCT//
if ($act == 'editproduct') {
    try {
        $logger->log("EditProduct() Started...", "INFO");
        $prod_id = $_REQUEST["prod_id"];
        $logger->log("EditProduct() ID Selected: " . $prod_id, "INFO");

        $a = $data->query("SELECT * FROM custom_equipment WHERE id = '$prod_id'");
        $b = $a->fetch_array();

        $prodId = $b["prod_id"];
        $prod_name = $b["title"];
        $category_sel = $b["parent_cat"];
        $prod_sku = $b["sku"];
        $prod_stock = $b["stock"];
        $prod_price = $b["reg_price"];
        $sales_price = $b["sales_price"];
        $page_title = $b["meta_title"];
        $page_desc = $b["meta_description"];
        $product_page_details = $b["description"];
        $product_weight = $b["weight"];
        $product_type = $b["product_type"];
        $download_file = $b["download_product_link"];
        $download_limit = $b["download_limit"];
        $ship_type = $b["ship_type"];
        $pickup_location = $b["pickup_location"];
        $flat_rate_shipping = $b["flat_rate_shipping"];
        $eq_image = $b["eq_image"];
        $product_attributes = $b["product_attributes"];
        $shortDesc = $b["short_description"];

        $dimensions = explode('X', $b["dimentions"]);

        $prod_weight = $b["weight"];
        $prod_width = $dimensions[0];
        $prod_height = $dimensions[1];
        $prod_depth = $dimensions[2];

        $html .= '<form name="editproductadd" id="editproductadd" method="post" action="">';
        $html .= '<input type="hidden" name="prod_id" id="prod_id" value="' . $prod_id . '">';
        $html .= '<div class="row">';
        $html .= '<div class="col-md-12 prodmess"></div>';
        $html .= '<div class="col-md-12" style="margin-bottom: 30px"><h2 style="border-bottom: solid thin #efefef; max-width: 50%">EDIT PRODUCT</h2></div>';
        $html .= '<div class="col-md-4"><label style="font-weight: bold">Product Name</label><br><input type="text" class="form-control" name="prod_name" id="prod_name" value="' . $prod_name . '" required="required"></div>';
        $html .= '<div class="col-md-4"><label style="font-weight: bold">Primary Category</label><br>';
        $html .= '<select class="form-control" name="categorysel" id="categorysel">';
        $html .= '<option value="">Select Category</option>';

        $cat = $data->query("SELECT id, page_name FROM custom_equipment_pages WHERE active = 'true' ORDER BY page_name ASC");
        while ($catdet = $cat->fetch_array()) {
            if ($category_sel == $catdet["id"]) {
                $html .= '<option value="' . $catdet["id"] . '" selected="selected">' . $catdet["page_name"] . '</option>';
            } else {
                $html .= '<option value="' . $catdet["id"] . '">' . $catdet["page_name"] . '</option>';
            }
        }

        $html .= '</select>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<br>';
        $html .= '<div class="row">';
        $html .= '<div class="col-md-4"><label style="font-weight: bold">SKU</label><br><input type="text" class="form-control" name="prod_sku" id="prod_sku" value="' . $prod_sku . '"></div>';
        $html .= '<div class="col-md-2"><label style="font-weight: bold">Inventory</label><br><select class="form-control" name="prod_stock" id="prod_stock">';

        $stockArs = array("In Stock" => 'in_stock', "Low Inventory" => 'low_inventory', "On Backorder" => 'backorder', "Out of Stock" => 'out_of_stock');

        foreach ($stockArs as $key => $val) {
            if ($prod_stock == $val) {
                $html .= '<option value="' . $val . '" selected="selected">' . $key . '</option>';
            } else {
                $html .= '<option value="' . $val . '">' . $key . '</option>';
            }
        }

        $html .= '</select></div>';
        $html .= '<div class="col-md-2"><label style="font-weight: bold">Product Price</label><br><input type="text" class="form-control" name="prod_price" id="prod_price" placeholder="0.00" required="required" value="' . $prod_price . '"></div>';
        $html .= '<div class="col-md-2"><label style="font-weight: bold">Sales Price</label><br><input type="text" class="form-control" name="sales_price" id="sales_price" placeholder="0.00" value="' . $sales_price . '"></div>';
        $html .= '</div>';

        $html .= '<br>';

        $html .= '<div class="row">';
        $html .= '<div class="col-md-4"><label style="font-weight: bold">(Meta) Title Tag</label><br><input class="form-control" type="text" id="page_title" name="page_title" value="' . $page_title . '" required=""></div>';
        $html .= '<div class="col-md-8"><label style="font-weight: bold">(Meta) Product Description & Short Text</label><br><textarea class="form-control" id="page_desc" name="page_desc" required="">' . $page_desc . '</textarea></div>';
        $html .= '</div>';

        $html .= '<div class="row">';
        $html .= '<div class="col-md-12"><label style="font-weight: bold">Short Descriptions</label><br><small>This information will generally float next to product images.</small><br><br><textarea class="summernote" name="product_page_short_details" id="product_page_short_details" style="max-height: 90px">' . $shortDesc . '</textarea></div>';
        $html .= '</div>';

        $html .= '<br>';

        $html .= '<div class="row">';
        $html .= '<div class="col-md-12"><label style="font-weight: bold">Product Information</label><br><textarea class="summernote" name="product_page_details" id="product_page_details" value="' . $product_page_details . '" style="max-height: 90px">' . $product_page_details . '</textarea></div>';
        $html .= '</div>';

        $html .= '<br>';

        $html .= '<div class="row">';
        $html .= '<div class="col-md-4"><label style="font-weight: bold">Product Type</label><br><select class="form-control" name="product_type" id="product_type">';
        $prodtypars = array("Physical Product" => 'physical', "Digital / Downloadable Product" => 'digital');

        foreach ($prodtypars as $key => $val) {
            if ($product_type == $val) {
                $html .= '<option value="' . $val . '" selected="selected">' . $key . '</option>';
            } else {
                $html .= '<option value="' . $val . '">' . $key . '</option>';
            }
        }

        $html .= '</select></div>';

        if ($product_type == 'digital') {
            $showDigital = 'block';
            $showShipOptions = 'none';
        } else {
            $showDigital = 'none';
            $showShipOptions = 'flex';
        }

        $prod_width = $dimensions[0];
        $prod_height = $dimensions[1];
        $prod_depth = $dimensions[2];

        $html .= '<div class="digital_properties col-md-8 row"style="display: ' . $showDigital . '">';
        $html .= '<label style="font-weight: bold">Select Downloadable File</label><div class="input-group mb-3"><input type="text" class="form-control" name="download_file" id="download_file" placeholder="No File Selected" aria-label="Download File" value="' . $download_file . '"><div class="input-group-append"><button class="btn btn-light img-browser" data-setter="download_file" type="button">Browse Files</button></div></div>';
        $html .= '<div><label style="font-weight: bold">Download Limit</label><br><input type="number" class="form-control" name="download_limit" id="download_limit" value="' . $download_limit . '" min="1"></div>';
        $html .= '</div>';

        $html .= '<div class="shipping_properties col-md-8 row" style="display: ' . $showShipOptions . '">';
        $html .= '<div class="col-md-4"><label style="font-weight: bold">Product Weight</label><br><input type="text" class="form-control" name="prod_weight" id="prod_weight" value="' . $product_weight . '"></div>';
        $html .= '<div class="col-md-8"><label style="font-weight: bold">Product Dimensions <small>(Width X Height X Depth)</small></label><br><div class="input-group"><input type="text" class="form-control input-sm" name="prod_width" id="prod_weight" value="' . $prod_width . '" placeholder="Width"> <input type="text" class="form-control input-sm" name="prod_height" id="prod_height" value="' . $prod_height . '" placeholder="Height"> <input type="text" class="form-control input-sm" name="prod_depth" id="prod_depth" value="' . $prod_depth . '" placeholder="Depth"></div></div>';
        $html .= '</div>';
        $html .= '</div>';

        $html .= '<br>';

        $locationOptions .= '<select class="form-control" name="pickup_location" id="pickup_location">';

        $p = $data->query("SELECT id, location_name FROM location WHERE active = 'true' ORDER BY location_name DESC");
        while ($q = $p->fetch_array()) {
            if ($pickup_location == $q["id"]) {
                $locationOptions .= '<option value="' . $q["id"] . '" selected="selected">' . $q["location_name"] . '</option>';
            } else {
                $locationOptions .= '<option value="' . $q["id"] . '">' . $q["location_name"] . '</option>';
            }
        }

        $locationOptions .= '</select>';

        if ($product_type == 'digital') {
            $deiver = 'display:none';
        } else {
            $deiver = 'display:flex';
        }

        $html .= '<div class="row shipping_properties" style="' . $deiver . '">';
        $html .= '<div class="col-md-4"><label style="font-weight: bold">Deliverable Options</label><br><select class="form-control" name="delivery_type" id="delivery_type">';

        $delOpts = array("Use Shipping API's (UPS, USPS, FEDEX etc..)" => 'api_system', "Flat Rate Shipping / Delivery" => 'flat_rate', "Pickup Only" => 'pickup_only');

        foreach ($delOpts as $key => $val) {
            if ($ship_type == $val) {
                $html .= '<option value="' . $val . '" selected="selected">' . $key . '</option>';
            } else {
                $html .= '<option value="' . $val . '">' . $key . '</option>';
            }
        }

        $html .= '</select></div>';

        if ($ship_type == 'flat_rate') {
            $flat_option = 'display:block';
        } else {
            $flat_option = 'display:none';
        }

        if ($ship_type == 'api_system') {
            $apisys_option = 'display:block';
        } else {
            $apisys_option = 'display:none';
        }

        if ($ship_type == 'pickup_only') {
            $pickup_option = 'display:block';
        } else {
            $pickup_option = 'display:none';
        }


        $html .= '<div class="col-md-8"><div class="jumbotron" style="padding: 20px; color: grey"><div class="flat_option delivery_options" style="' . $flat_option . '"><label>Flat Rate Shipping Cost</label><br><input class="form-control" type="text" name="flat_shipping_cost" id="flat_shipping_cost" placeholder="0.00" value="' . $flat_rate_shipping . '"></div><div class="system_option delivery_options" style="' . $apisys_option . '">System will use shipping API.<br><small style="color: #800101">NOTE! - Product must have weight and dimentions added.</small></div><div class="pickup_option delivery_options" style="' . $pickup_option . '"><label>Select Pickup Location</label><br>' . $locationOptions . '</div></div></div>';
        $html .= '</div>';

        $html .= '<br>';

        $html .= '<hr>';


        $eq_image = json_decode($eq_image, true);

        $imageOne = $eq_image[0];
        $imageTwo = $eq_image[1];
        $imageThree = $eq_image[2];
        $imageFour = $eq_image[3];

        if ($imageOne != null) {
            $oneImg = '../../' . $imageOne;
        } else {
            $oneImg = '../../img/no-image.jpg';
        }
        if ($imageTwo != null) {
            $twoImg = '../../' . $imageTwo;
        } else {
            $twoImg = '../../img/no-image.jpg';
        }
        if ($imageThree != null) {
            $threeImg = '../../' . $imageThree;
        } else {
            $threeImg = '../../img/no-image.jpg';
        }
        if ($imageFour != null) {
            $fourImg = '../../' . $imageFour;
        } else {
            $fourImg = '../../img/no-image.jpg';
        }

        $html .= '<div class="row">';
        $html .= '<div class="col-md-12"><h5>Images</h5><small>Select up to 4 images.</small></div>';
        $html .= '<br><br><br>';
        $html .= '<div class="col-md-3"><label style="font-weight: bold">Main Image</label><div class="input-group mb-3"><input type="text" class="form-control" name="pro_img" id="pro_img" placeholder="No Image" aria-label="Category Image" value="' . $imageOne . '"><div class="input-group-append"><button class="btn btn-light img-browser" data-setter="pro_img" type="button">Browse Images</button></div></div><div class="imgprev pro_img" style="background-image: url(\'' . $oneImg . '\'); background-position: center; background-size: contain; background-repeat: no-repeat"><img style="width: 100%" src="../../img/spacer.png"></div></div>';
        $html .= '<div class="col-md-3"><label style="font-weight: bold">Image Two</label><div class="input-group mb-3"><input type="text" class="form-control" name="pro_img_2" id="pro_img_2" placeholder="No Image" aria-label="Category Image" value="' . $imageTwo . '"><div class="input-group-append"><button class="btn btn-light img-browser" data-setter="pro_img_2" type="button">Browse Images</button></div></div><div class="imgprev pro_img_2" style="background-image: url(\'' . $twoImg . '\'); background-position: center; background-size: contain; background-repeat: no-repeat"><img style="width: 100%" src="../../img/spacer.png"></div></div>';
        $html .= '<div class="col-md-3"><label style="font-weight: bold">Image Three</label><div class="input-group mb-3"><input type="text" class="form-control" name="pro_img_3" id="pro_img_3" placeholder="No Image" aria-label="Category Image" value="' . $imageThree . '"><div class="input-group-append"><button class="btn btn-light img-browser" data-setter="pro_img_3" type="button">Browse Images</button></div></div><div class="imgprev pro_img_3" style="background-image: url(\'' . $threeImg . '\'); background-position: center; background-size: contain; background-repeat: no-repeat"><img style="width: 100%" src="../../img/spacer.png"></div></div>';
        $html .= '<div class="col-md-3"><label style="font-weight: bold">Image Four</label><div class="input-group mb-3"><input type="text" class="form-control" name="pro_img_4" id="pro_img_4" placeholder="No Image" aria-label="Category Image" value="' . $imageFour . '"><div class="input-group-append"><button class="btn btn-light img-browser" data-setter="pro_img_4" type="button">Browse Images</button></div></div><div class="imgprev pro_img_4" style="background-image: url(\'' . $fourImg . '\'); background-position: center; background-size: contain; background-repeat: no-repeat"><img style="width: 100%" src="../../img/spacer.png"></div></div>';
        $html .= '</div>';
        $html .= '<br>';
        $html .= '<hr>';

        $html .= '<div class="row">';
        $html .= '<div class="col-md-12"><h5>Attributes</h5><small>Add your products attributes below.</small></div>';
        $html .= '<div style="clear: both; width: 100%; text-align: right; padding: 10px"><button type="button" class="btn btn-sm btn-dark" onclick="buildOutAttr()">Add Attribute</button></div>';
        $html .= '<br>';
        $html .= '<div class="col-md-12">';
        $html .= '<table class="table attr_bholder">';
        $html .= '<tr><td><b>Group Name</b></td><td><b>Attributes</b></td><td style="text-align: right"><b>Action</b></td></tr>';

        $product_attributes = json_decode($product_attributes, true);

        foreach ($product_attributes as $keys) {
            $p = $data->query("SELECT attr_grp_name FROM custom_equipment_product_attr_parent WHERE id = '$keys' AND active = 'true'");
            $q = $p->fetch_array();
            $attr_grp_name = $q["attr_grp_name"];
            $r = $data->query("SELECT attr_name FROM custom_equipment_product_attr_childs WHERE attr_parent = '$keys' AND active = 'true' ORDER BY output_order DESC");

            while ($s = $r->fetch_array()) {
                $attItems .= $s["attr_name"] . ', ';
            }

            $html .= '<tr class="attrblox draggable" data-attrids="' . $keys . '"><td>' . $attr_grp_name . '</td><td>' . $attItems . '</td><td style="text-align: right"><button class="btn btn-sm btn-danger ridattr" type="button" data-attrrm="' . $keys . '"><input type="hidden" name="attrsel[]" id="attrsel[]" value="' . $keys . '"> <i class="fa fa-trash" aria-hidden="true"></i> Remove</button></td></tr>';
            $attItems = '';
        }

        $html .= '</table>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<hr>';
        $html .= '<div class="row">';
        $html .= '<div class="col-md-12" style="text-align: right"><button type="submit" class="btn btn-primary btn-lg prosubbutton">Update Product</button></div>';
        $html .= '</div>';
        $html .= '</form>';

        $logger->log("EditProduct() Completed Successfully!", "INFO");
    } catch (Exception $e) {
        $logger->log("ERROR:  Failed To Edit Product in 'editproduct'! - " . $e, "ERROR");
    }

    echo $html;
}

//MORE PRODUCT OPTIONS//
if ($act == 'moreprodopts') {
    try {
        $logger->log("MoreProdOpts() Started...", "INFO");
        $html .= '<div class="container">';
        $html .= '<table style="width: 100%">';
        $html .= '<tr><td><a href="#" target="_blank"><i class="fa fa-download" aria-hidden="true"></i> Download Product CSV Template</a><br><small>The above will download an empty product csv for importing into the system.</small></td><td><a href="javascript:void()" onclick="importpanel()"><i class="fa fa-upload" aria-hidden="true"></i> Import New Products</a><br><small>You must use the same CSV template provided by the system.</small></td></tr>';
        $html .= '<tr><td>&nbsp;</td></tr>';
        $html .= '<tr><td><a href="csvexporttest.php"><i class="fa fa-download" aria-hidden="true"></i> Export Products</a><br><small>Here you can export a full list of products with your system.</small></td><td><a href="csvexporttest.php"><i class="fa fa-wrench" aria-hidden="true"></i> Update Products</a><br><small>Submit your updated product CSV here.</small></td></tr>';
        $html .= '</table>';

        $html .= '<br>';

        $htmlNO .= '<div class="progress">
  <div class="progress-bar" style="width: 25%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
</div>';

        $html .= '</div>';
        $logger->log("MoreProdOpts() Completed Successfully!", "INFO");
    } catch (Exception $e) {
        $logger->log("ERROR:  Failed To Load More Product Options in 'moreprodopts'! - " . $e, "ERROR");
    }

    echo $html;
}

//SELECT AND ADD PRODUCT ATTRIBUTES//
if ($act == 'selectattr') {
    try {
        $logger->log("SelectAttr() Started...", "INFO");

        $checkdata = $_POST["checkdata"];

        $html .= '<div class="row">';
        $html .= '<div class="col-md-8"><p>Here you can create or choose custom product attributes groups that your customers can choose from.<br>You can also enter adjustment price\'s based on selection.</p></div>';
        $html .= '<div class="col-md-4" style="text-align: right"><button class="btn btn-dark" onclick="buildAttr()">Create New Attribute Group</button></div>';
        $html .= '</div>';

        $html .= '<table id="attrlist" class="display" style="width:100%">
            <thead>
            <tr>
                <th></th>
                <th>Group Name</th>
                <th>Attributes</th>
                <th style="text-align: right">Action</th>
            </tr>
            </thead>
            <tbody>';

        $a = $data->query("SELECT attr_grp_name,id FROM custom_equipment_product_attr_parent WHERE active = 'true'");
        while ($b = $a->fetch_array()) {
            $c = $data->query("SELECT attr_name FROM custom_equipment_product_attr_childs WHERE attr_parent = '" . $b["id"] . "' ORDER BY output_order ASC");
            while ($d = $c->fetch_array()) {
                $attrNames .= $d["attr_name"] . ',';
            }

            $attrNames = rtrim($attrNames, ',');

            if (in_array($b["id"], $checkdata)) {
                $html .= '<tr><td><label class="inpcontainer"><input class="attroptions" type="checkbox" name="attrsel[]" id="attrsel[]" value="' . $b["id"] . '" data-attrame="' . $b["attr_grp_name"] . '" data-inditems="' . htmlspecialchars($attrNames) . '" checked="checked"><span class="checkmark"></span></label></td><td>' . $b["attr_grp_name"] . '</td><td>' . $attrNames . '</td><td style="text-align: right"><button class="btn btn-secondary" onclick="editAttr(\'' . $b["id"] . '\')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button> <button class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button></td></tr>';
            } else {
                $html .= '<tr><td><label class="inpcontainer"><input class="attroptions" type="checkbox" name="attrsel[]" id="attrsel[]" value="' . $b["id"] . '" data-attrame="' . $b["attr_grp_name"] . '" data-inditems="' . htmlspecialchars($attrNames) . '"><span class="checkmark"></span></label></td><td>' . $b["attr_grp_name"] . '</td><td>' . $attrNames . '</td><td style="text-align: right"><button class="btn btn-secondary" onclick="editAttr(\'' . $b["id"] . '\')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button> <button class="btn btn-danger delbutton" onclick="deleteAttr(' . $b["id"] . ')"><i class="fa fa-trash" aria-hidden="true"></i></button></td></tr>';
            }


            $attrNames = '';
        }



        $html .= '</tbody>';
        $html .= '</table>';

        $html .= '<hr><div style="text-align: right; margin-top: 20px"><button class="btn btn-primary" onclick="getSelectedAttrs()">Save Selected Attributes </button></div>';
        $logger->log("SelectAttr() Completed Successfully!", "INFO");
    } catch (Exception $e) {
        $logger->log("ERROR:  Failed To Select Attribute in 'selectAttr'! - " . $e, "ERROR");
    }

    echo $html;
}

//FORM TO CREATE A PRODUCT ATTRIBUTE GROUP//
if ($act == 'buildattrs_stepone') {
    try {
        $logger->log("BuildAttrs_StepOne() Started...", "INFO");

        $html .= '<form id="attraddog" name="attraddog" method="post" action="">';
        $html .= '<div class="row">';
        $html .= '<div class="col-md-6"><h4>Create New Attribute Group</h4></div>';
        $html .= '<div class="col-md-6" style="text-align: right"><button class="btn btn-info" type="button" onclick="buildOutAttr()"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back To Attributes</button></div>';
        $html .= '<div class="sysmess col-md-12"></div>';
        $html .= '<div class="col-md-12">&nbsp;</div>';
        $html .= '<div class="col-md-6"><label>Group Name</label><br><input type="text" class="form-control" name="group_attr_name" id="group_attr_name" value="" placeholder="e.g. T-Shirt Sizes" required="required"></div>';
        $html .= '<div class="col-md-3"><label>&nbsp;</label><br><input type="hidden" name="attrtid" id="attrtid" value=""><button class="btn btn-success">Proceed <i class="fa fa-arrow-right" aria-hidden="true"></i></button></div>';
        $html .= '<div class="col-md-12">&nbsp;</div>';
        $html .= '</div>';
        $html .= '</form>';

        $logger->log("BuildAttrs_StepOne() Completed Successfully!", "INFO");
    } catch (Exception $e) {
        $logger->log("ERROR:  Failed To Build Attribute in Step One of 'buildattrs_stepone'! - " . $e, "ERROR");
    }

    echo $html;
}


//ADD MULTIPLE ATTRIBUTES TO GROUP//
if ($act == 'buildattrs_steptwo') {
    try {
        $logger->log("BuildAttrs_StepTwo() Started...", "INFO");
        $new_group_name = $_POST["group_attr_name"];
        $logger->log("BuildAttrs_StepTwo() Group Attribute Group Name: " . $new_group_name, "INFO");

        $a = $data->query("SELECT id FROM custom_equipment_product_attr_parent WHERE attr_grp_name = '$new_group_name' AND active = 'true'");
        if ($a->num_rows == 0) {
            $data->query("INSERT INTO custom_equipment_product_attr_parent SET attr_grp_name = '" . $new_group_name . "'");
            $newatt_id = $data->insert_id;

            $html .= '<form id="attradd" name="attradd" method="post" action="">';
            $html .= '<div class="row">';
            $html .= '<div class="col-md-6"><h4>Add Attributes To <span style="color: #0a6aa1">' . $new_group_name . '</span></h4></div>';
            $html .= '</div>';
            $html .= '<div class="row">';
            $html .= '<div class="col-md-3"><label>Name</label><br><input type="text" class="form-control" name="attr_name" id="attr_name" value="" required="required"></div>';
            $html .= '<div class="col-md-3"><label>Value</label><br><input type="text" class="form-control" name="attr_value" id="attr_value" value="" required="required"></div>';
            $html .= '<div class="col-md-2"><label>Price</label><br><input type="text" class="form-control" name="attr_price" id="attr_price" value=""></div>';
            $html .= '<div class="col-md-2"><label>&nbsp;</label><br><button class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i></button></div>';
            $html .= '<input type="hidden" name="newgrp_id" id="newgrp_id" value="' . $newatt_id . '">';
            $html .= '</div>';
            $html .= '</form>';

            $html .= '<hr>';

            $html .= '<div class="attrlist" style="margin-top:20px">';
            $html .= '<table id="attrtabs" class="table">';
            $html .= '<thead>';
            $html .= '<tr><th>Name</th><th>Value</th><th>Price</th><th style="text-align: right">Action</th></tr>';
            $html .= '</thead>';
            $html .= '<tbody>';
            $html .= '</tbody>';
            $html .= '</table>';
            $html .= '<hr>';
            $html .= '<button style="float: right" type="button" class="btn btn-primary" onclick="buildOutAttr()">Save Attributes</button>';
            $html .= '</div>';

            $logger->log("BuildAttrs_StepTwo() Completed Successfully!", "INFO");
            $results = array("status" => "good", "message" => $html, "attr_id" => '');
        } else {
            $logger->log("ERROR:  Failed To Build Attributes In Step 2 of 'buildattrs_steptwo'! Row Was Not Inserted Into DB!!", "ERROR");
            $results = array("status" => "bad", "message" => '<div class="alert alert-warning" style="margin: 10px"><strong>Whoops!.</strong><br><p>It appears you have a group with the same name already active.<br>Please re-name your group or try accessing it from the Attribute menu.</p></div>', "attr_id" => '');
        }
    } catch (Exception $e) {
        $logger->log("ERROR:  Failed To Build Attributes In Step 2 of 'buildattrs_steptwo'! - " . $e, "ERROR");
    }

    echo json_encode($results);
}

//RETURNS CREATED ATTRIBUTES//
if ($act == 'buildattrs_add') {
    try {
        $logger->log("BuildAttrs_Add() Started...", "INFO");

        $attr_name = $_POST["attr_name"];
        $attr_value = $_POST["attr_value"];
        $attr_price = $_POST["attr_price"];
        $newgrp_id = $_POST["newgrp_id"];
        $attrtid = $_POST["attrtid"];

        if ($attrtid != '') {
            $data->query("UPDATE custom_equipment_product_attr_childs SET attr_name = '" . $data->real_escape_string($attr_name) . "', attr_value = '" . $data->real_escape_string($attr_value) . "', attr_price = '$attr_price', attr_parent = '$newgrp_id'");
        } else {
            $data->query("INSERT INTO custom_equipment_product_attr_childs SET attr_name = '" . $data->real_escape_string($attr_name) . "', attr_value = '" . $data->real_escape_string($attr_value) . "', attr_price = '$attr_price', attr_parent = '$newgrp_id'");
            $attrtid = $data->insert_id;
        }
        if ($attr_price == '') {
            $attr_price = '--';
        } else {
            $attr_price = $attr_price;
        }

        $logger->log("BuildAttrs_Add() Completed Successfully!", "INFO");
    } catch (Exception $e) {
        $logger->log("ERROR:  Exception in 'buildattrs_add'! - " . $e, "ERROR");
    }

    echo '<tr class="attrdrg attrtr_' . $attrtid . '"><td><div class="editable" data-max-length="50" data-input-type="input" data-attrid="' . $attrtid . '" data-subtype="attr_name">' . $attr_name . '</div></td><td><div class="editable" data-max-length="50" data-input-type="input" data-attrid="' . $attrtid . '" data-subtype="attr_value">' . $attr_value . '</div></td><td><div class="editable" data-max-length="50" data-input-type="input" data-attrid="' . $attrtid . '" data-subtype="attr_price">' . $attr_price . '</div></td><td style="text-align: right"><button class="btn btn-danger btn-sm delbutton" data-delid="' . $attrtid . '"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button></td></tr>';
}

//EDIT ATTRIBUTES//
if ($act == 'modifyattrs_add') {
    try {
        $logger->log("ModifyAttrs_Add() Started...", "INFO");

        $attrid = $_POST["attrid"];
        $attrtype = $_POST["attrtype"];
        $updval = $_POST["updval"];

        if ($attrtype == 'attr_name') {
            $data->query("UPDATE custom_equipment_product_attr_childs SET attr_name = '" . $data->real_escape_string($updval) . "' WHERE id = '$attrid'");
        }

        if ($attrtype == 'attr_value') {
            $data->query("UPDATE custom_equipment_product_attr_childs SET attr_value = '" . $data->real_escape_string($updval) . "' WHERE id = '$attrid'");
        }

        if ($attrtype == 'attr_price') {
            if ($updval != '--') {
                $data->query("UPDATE custom_equipment_product_attr_childs SET attr_price = '" . $data->real_escape_string($updval) . "' WHERE id = '$attrid'");
            } else {
                $data->query("UPDATE custom_equipment_product_attr_childs SET attr_price = '' WHERE id = '$attrid'");
            }
        }

        $logger->log("ModifyAttrs_Add() Completed Successfully!", "INFO");
    } catch (Exception $e) {
        $logger->log("ERROR:  Exception in 'modifyattrs_add'! - " . $e, "ERROR");
    }
}

//DELETE ATTRIBUTES//
if ($act == 'deleteattrs') {
    try {
        $logger->log("DeleteAttrs() Started...", "INFO");

        $id = $_REQUEST["id"];
        $data->query("UPDATE custom_equipment_product_attr_parent SET active = 'false' WHERE id = '$id'");

        $logger->log("ModifyAttrs_Add() Completed Successfully!", "INFO");
    } catch (Exception $e) {
        $logger->log("ERROR:  Exception in 'deleteattrs'! - " . $e, "ERROR");
    }
}

//EDIT ATTRIBUTES FORM//
if ($act == 'editattr') {
    try {
        $logger->log("EditAttrs() Started...", "INFO");
        $attrid = $_REQUEST["attrid"];
        $logger->log("EditAttrs() Selected Attribute ID: " . $attrid, "INFO");

        $a = $data->query("SELECT * FROM custom_equipment_product_attr_parent WHERE id = '$attrid'");
        $b = $a->fetch_array();

        $html .= '<form id="attradd" name="attradd" method="post" action="">';
        $html .= '<div class="row">';
        $html .= '<div class="col-md-6"><h4>Add Attributes To <span style="color: #0a6aa1">' . $b["attr_grp_name"] . '</span></h4></div>';
        $html .= '</div>';
        $html .= '<div class="row">';
        $html .= '<div class="col-md-3"><label>Name</label><br><input type="text" class="form-control" name="attr_name" id="attr_name" value="" required="required"></div>';
        $html .= '<div class="col-md-3"><label>Value</label><br><input type="text" class="form-control" name="attr_value" id="attr_value" value="" required="required"></div>';
        $html .= '<div class="col-md-2"><label>Price</label><br><input type="text" class="form-control" name="attr_price" id="attr_price" value=""></div>';
        $html .= '<div class="col-md-2"><label>&nbsp;</label><br><button class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i></button></div>';
        $html .= '<input type="hidden" name="newgrp_id" id="newgrp_id" value="' . $attrid . '">';
        $html .= '</div>';
        $html .= '</form>';

        $html .= '<hr>';

        $html .= '<div class="attrlist" style="margin-top:20px">';
        $html .= '<table id="attrtabs" class="table">';
        $html .= '<thead>';
        $html .= '<tr><th>Name</th><th>Value</th><th>Price</th><th style="text-align: right">Action</th></tr>';
        $html .= '</thead>';
        $html .= '<tbody>';

        $c = $data->query("SELECT * FROM custom_equipment_product_attr_childs WHERE attr_parent = '$attrid' ORDER BY output_order ASC");
        while ($d = $c->fetch_array()) {
            $attr_name = $d["attr_name"];
            $attr_value = $d["attr_value"];
            $attr_price = $d["attr_price"];
            $singleId = $d["id"];
            if ($attr_price != '') {
                $attr_price = $attr_price;
            } else {
                $attr_price = '--';
            }
            $html .= '<tr class="attrdrg attrtr_' . $singleId . '" data-id="' . $singleId . '"><td><div class="editable" data-max-length="50" data-input-type="input" data-attrid="' . $singleId . '" data-subtype="attr_name">' . $attr_name . '</div></td><td><div class="editable" data-max-length="50" data-input-type="input" data-attrid="' . $singleId . '" data-subtype="attr_value">' . $attr_value . '</div></td><td><div class="editable" data-max-length="50" data-input-type="input" data-attrid="' . $singleId . '" data-subtype="attr_price">' . $attr_price . '</div></td><td style="text-align: right"><button class="btn btn-danger btn-sm delbutton" data-delid="' . $singleId . '"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button></td></tr>';
        }

        $html .= '</tbody>';


        $html .= '</table>';
        $html .= '<hr>';
        $html .= '<button style="float: right" type="button" class="btn btn-primary" onclick="buildOutAttr()">Save Attributes</button>';
        $html .= '</div>';

        $logger->log("EditAttrs() Completed Successfully!", "INFO");
    } catch (Exception $e) {
        $logger->log("ERROR:  Exception in 'editattr'! - " . $e, "ERROR");
    }

    echo $html;
}

//SAVE ORDER FOR ATTRIBUTES//
if ($act == 'setattrorder') {
    try {
        $logger->log("SetAttrOrder() Started...", "INFO");
        $theOrder = $_POST["attrid_order"];
        $parentId = $_POST["parent_id"];
        $i = 1;
        foreach ($theOrder as $key) {
            //echo $key. ' - '.$i;
            $data->query("UPDATE custom_equipment_product_attr_childs SET output_order = '$i' WHERE id = '$key' AND attr_parent = '$parentId'") or die($data->error);
            $i++;
        }
        $logger->log("SetAttrOrder() Completed Successfully!", "INFO");
    } catch (Exception $e) {
        $logger->log("ERROR:  Exception in 'setattrorder'! - " . $e, "ERROR");
    }
}

//IMPORT OPTIONS FOR PRODUCTS//
if ($act == 'importpanel') {
    try {
        $logger->log("ImportPanel() Started...", "INFO");

        $html .= '<div class="row"><div class="col-md-12" style="text-align: right"><button class="btn btn-dark"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back To Options</button></div></div>';
        $html .= '<form name="importer" id="importer" method="post" enctype="multipart/form-data">';
        $html .= '<div class="row">';
        $html .= '<div class="col-md-12"><label style="margin: 0; font-size:18px; font-weight: bold">Select Import CSV</label><br><small>Notice - The CSV must match the systems requirements for successful import to occur.</small><br><br><input type="file" name="importfile" id="importfile"></div>';
        $html .= '<div class="col-md-12"><br><button class="btn btn-success">Import Products</button></div>';
        $html .= '</div>';
        $html .= '</form>';

        $logger->log("ImportPanel() Completed Successfully!", "INFO");
    } catch (Exception $e) {
        $logger->log("ERROR:  Exception in 'importpanel'! - " . $e, "ERROR");
    }

    echo $html;
}

//DO CSV PRODUCT IMPORT//
if ($act == 'importproducts') {
    try {
        $logger->log("ImportProducts() Started...", "INFO");

        $target_dir = "imports/";
        $target_file = $target_dir . basename($_FILES["importfile"]["name"]);
        $uploadOk = 1;
        $FileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if ($FileType != '.csv') {
            $uploadOk = 1;
            if (move_uploaded_file($_FILES["importfile"]["tmp_name"], $target_file)) {
                //echo "The file " . htmlspecialchars(basename($_FILES["importfile"]["name"])) . " has been uploaded.";

                $file = fopen('imports/' . $_FILES["importfile"]["name"], "r");
                while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
                    if ($getData[0] != 'title') {
                        $result = $data->query("INSERT INTO custom_equipment SET title = '" . $data->real_escape_string($getData[0]) . "', eq_image = '" . $data->real_escape_string($getData[1]) . "', short_description = '" . $data->real_escape_string($getData[2]) . "', description = '" . $data->real_escape_string($getData[3]) . "', meta_title = '" . $data->real_escape_string($getData[4]) . "', meta_description = '" . $data->real_escape_string($getData[5]) . "', reg_price = '" . $data->real_escape_string($getData[6]) . "', sales_price = '" . $data->real_escape_string($getData[7]) . "', features = '" . $data->real_escape_string($getData[8]) . "', sku = '" . $data->real_escape_string($getData[9]) . "', weight = '" . $data->real_escape_string($getData[10]) . "', ship_type = '" . $data->real_escape_string($getData[11]) . "', dimentions = '" . $data->real_escape_string($getData[12]) . "', stock = '" . $data->real_escape_string($getData[13]) . "'") or die($data->error);

                        if (!isset($result)) {
                            echo "invalid";
                        } else {
                            echo "success";
                        }
                    }
                }
                fclose($file);
            } else {
                //echo "Sorry, there was an error uploading your file." . $_FILES["importfile"]["name"];
            }
        } else {
            //echo "File is not an image.";
            $uploadOk = 0;
        }

        $logger->log("ImportProducts() Completed Successfully!", "INFO");
    } catch (Exception $e) {
        $logger->log("ERROR:  Exception in 'importproducts'! - " . $e, "ERROR");
    }
}

///SHIPPING STUFF///
if ($act == 'getshipping') {
    try {
        $logger->log("GetShipping() Started...", "INFO");

        $a = $data->query("SELECT * FROM custom_equipment_shipping WHERE id = '1'");
        $b = $a->fetch_array();

        $html .= '<h2 style="border-bottom: solid thin #efefef">SHIPPING SETTINGS</h2><br>';
        $html .= '<div class="row">';
        $html .= '<div class="col-md-12 theresults"></div>';
        $html .= '<div class="col-md-4"><label style="font-weight: bold">Shipping API</label><br>';
        $html .= '<select name="shiptyp" id="shiptyp" class="form-control">';
        $dropArs = array('Choose Shipping API' => '', 'Shippo' => 'shippo', 'ShipEngine' => 'shipengine');
        foreach ($dropArs as $key => $val) {
            if ($b["ship_type"] == $val) {
                $html .= '<option value="' . $val . '" selected="selected">' . $key . '</option>';
            } else {
                $html .= '<option value="' . $val . '">' . $key . '</option>';
            }
        }
        $html .= '</select></div>';
        $html .= '</div>';
        $html .= '<br>';

        if ($b["ship_type"] == '') {
            $blkdisplay = 'display:none';
        } else {
            $blkdisplay = 'display:block';
        }

        $html .= '<div class="row tokenarea" style="' . $blkdisplay . '">';
        $html .= '<div class="col-md-5"><label style="font-weight: bold">API Token Below</label><br><input class="form-control" type="text" name="tokenid" id="tokenid" value="' . $b["ship_token"] . '"></div>';
        $html .= '</div>';

        $html .= '<br>';

        $html .= '<div class="row">';
        $html .= '<div class="col-md-4"><label style="font-weight: bold">Shipping API Usage</label><br>';
        $html .= '<select name="ship_usage" id="ship_usage" class="form-control">';
        $html .= '<option value="">Select Option</option>';
        $shipUsage = array('get_estimate' => 'Use to estimate and charge', 'create_label' => 'Use to create shipping label');
        foreach ($shipUsage as $key => $val) {
            if ($b["ship_usage"] == $key) {
                $html .= '<option value="' . $key . '" selected="selected">' . $val . '</option>';
            } else {
                $html .= '<option value="' . $key . '">' . $val . '</option>';
            }
        }
        $html .= '</select>';
        $html .= '</div>';
        $html .= '</div>';


        $html .= '<br>';
        $html .= '<div class="row">';
        $html .= '<div class="col-md-3"><button class="btn btn-success" type="button" onclick="saveShipToken()">Save Settings</button> </div>';
        $html .= '</div>';

        $logger->log("GetShipping() Completed Successfully!", "INFO");
    } catch (Exception $e) {
        $logger->log("ERROR:  Exception in 'getshipping'! - " . $e, "ERROR");
    }

    echo $html;
}

//SET SHIPPING API TOKENS//
if ($act == 'settoken') {
    try {
        $logger->log("SetToken() Started...", "INFO");
        $token = $_REQUEST["token"];
        $shiptype = $_REQUEST["shiptype"];
        $shipusage = $_REQUEST["shipusage"];
        $logger->log("SetToken() Token: " . $token . "  |  shiptype: " . $shiptype . "  |  shipusage: " . $shipusage . ".", "INFO");

        $data->query("UPDATE custom_equipment_shipping SET ship_type = '" . $data->real_escape_string($shiptype) . "', ship_token = '" . $data->real_escape_string($token) . "', ship_usage = '" . $data->real_escape_string($shipusage) . "' WHERE id = '1'");

        $results = array("status" => "good", "message" => '<div class="alert alert-success"><strong>Awesome!</strong><br><p>Your Shipping Settings Have Been Updated!</p></div>');

        $logger->log("SetToken() Completed Successfully!", "INFO");
        echo json_encode($results);
    } catch (Exception $e) {
        $logger->log("ERROR:  Exception in 'settoken'! - " . $e, "ERROR");
        $results = array("status" => "bad", "message" => '<div class="alert alert-success"><strong>Whoops!</strong><br><p>There Was An Error Trying To Update Shipping Settings!</p></div>');
        echo json_encode($results);
    }
}

//TAX UPDATES//
if ($act == 'taxsettings') {
    try {
        $logger->log("TaxSettings() Started...", "INFO");

        $a = $data->query("SELECT ziptax_key FROM custom_equipment_tax_settings WHERE id = '1'");
        $b = $a->fetch_array();

        $html .= '<h2 style="border-bottom: solid thin #efefef">TAX SETTINGS</h2><br>';

        $html .= '<div class="row">';
        $html .= '<div class="col-md-12 theresults"></div>';
        $html .= '<div class="col-md-6">';
        $html .= '<label style="font-weight: bold">Zip-Tax API Key | <small><a href="https://zip-tax.com/" target="_blank">Go to ZipTax</a></small></label><br>';
        $html .= '<input class="form-control" type="text" name="ziptax" id="ziptax" value="' . $b["ziptax_key"] . '">';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<br>';

        $html .= '<div class="row">';
        $html .= '<div class="col-md-4"><button class="btn btn-success" onclick="updateTaxKey()">Update API</button></div>';
        $html .= '</div>';

        $logger->log("TaxSettings() Completed Successfully!", "INFO");
    } catch (Exception $e) {
        $logger->log("ERROR:  Exception in 'taxsettings'! - " . $e, "ERROR");
    }

    echo $html;
}

//SAVE Zip-Tax API KEY//
if ($act == 'finishtax') {
    try {
        $logger->log("FinishTax() Started...", "INFO");

        $apival = $_REQUEST["apival"];
        $logger->log("FinishTax() API Value: " . $apival, "INFO");

        $data->query("UPDATE custom_equipment_tax_settings SET ziptax_key = '" . $data->real_escape_string($apival) . "' WHERE id = '1'");
        $ars = array('status' => 'good', 'message' => '<div class="alert alert-success"><strong>Awesome!</strong><br><p>Your Tax Settings Have Been Successfully Updated. <br>You can now go back to the list or continue to edit your tax settings.</p></div>');

        $logger->log("FinishTax() Completed Successfully!", "INFO");
        echo json_encode($ars);
    } catch (Exception $e) {
        $logger->log("ERROR:  Exception in 'finishtax'! - " . $e, "ERROR");
        $ars = array('status' => 'bad', 'message' => '<div class="alert alert-danger"><strong>Whoops!</strong><br><p>An Error Occurred When Trying To Update Your Tax Settings!</p></div>');
        echo json_encode($ars);
    }
}

//PAYMENT API FORMS//
if ($act == 'payment_gatways') {
    try {
        $logger->log("Payment_Gateways() Started...", "INFO");

        $html .= '<h2 style="border-bottom: solid thin #efefef">PAYMENT API</h2><br>';
        $html .= '<form name="paymentsapis" id="paymentsapis" method="post" action="">';
        $html .= '<div class="row">';
        $html .= '<div class="col-md-12 theresults"></div>';
        $html .= '<div class="col-md-6"><label>Select Payment Gateway</label><br>';
        $html .= '<select class="form-control" name="payment_api" id="payment_api">';
        $a = $data->query("SELECT payment_type FROM custom_equipment_payment_method WHERE id = '1'");
        $b = $a->fetch_array();
        $paymentType = $b["payment_type"];

        $payapis = array('Choose Payment API' => '', 'Elavon' => 'elavon', 'Stripe' => 'stripe');
        foreach ($payapis as $val => $key) {
            if ($paymentType == $key) {
                $html .= '<option value="' . $key . '" selected="selected">' . $val . '</option>';
            } else {
                $html .= '<option value="' . $key . '">' . $val . '</option>';
            }
        }

        $html .= '</select>';
        $html .= '</div>';
        $html .= '</div>';

        $html .= '<br>';

        $html .= '<div class="jumbotron paydetails"><span style="font-style: italic;background: #fff; padding: 5px; width: 100%; display: block; font-weight: bold">Select Payment Processor Above...</span></div>';
        $html .= '</form>';

        $logger->log("Payment_Gateways() Completed Successfully!", "INFO");
    } catch (Exception $e) {
        $logger->log("ERROR:  Exception in 'payment_gateways'! - " . $e, "ERROR");
    }

    echo $html;
}

//PAYMENT GATEWAY TYPES//
if ($act == 'paytypes') {
    try {
        $logger->log("PayTypes() Started...", "INFO");
        $paytype = $_REQUEST["paytype"];
        $logger->log("PayTypes() PayType: " . $paytype, "INFO");

        if ($paytype == 'elavon') {
            $logger->log("PaymentTypes() Selected API: 'Elavon'", "INFO");

            $a = $data->query("SELECT payment_settings FROM custom_equipment_payment_method WHERE id = '1'");
            $b = $a->fetch_array();
            $payment_settings = json_decode($b["payment_settings"], true);

            $enpoint = $payment_settings["enpoint"];
            $merchantid = $payment_settings["merchant_id"];
            $merchantuser = $payment_settings["merchant_userid"];
            $merchantpin = $payment_settings["merchant_pin"];

            $html .= '<h2>Elavon Connection Details</h2><br>';
            $html .= '<div class="row">';
            $html .= '<div class="col-md-6"><label>Process Link</label><br><small>Live Link: https://api.convergepay.com/hosted-payments/transaction_token</small><input class="form-control" type="text" name="elavonendpoint" id="elavonendpoint" value="' . $enpoint . '" placeholder="https://api.demo.convergepay.com/hosted-payments/transaction_token"></div>';
            $html .= '</div>';

            $html .= '<br>';

            $html .= '<div class="row">';
            $html .= '<div class="col-md-3"><label>Merchant ID</label><br><input class="form-control" type="text" name="merchantid" id="merchantid" value="' . $merchantid . '" placeholder="Converge 6 or 7-Digit Account ID"></div>';
            $html .= '<div class="col-md-3"><label>Merchant User</label><br><input class="form-control" type="text" name="merchantuserid" id="" value="' . $merchantuser . '" placeholder="Converge User ID"></div>';
            $html .= '<div class="col-md-6"><label>Merchant Pin</label><br><input class="form-control" type="text" name="merchantpin" id="merchantpin" value="' . $merchantpin . '" placeholder="Converge PIN (64 CHAR A/N)"></div>';

            $html .= '</div>';
            $html .= '<br>';

            $html .= '<button class="btn btn-success btn-lg">Save Elavon Details</button>';
        }

        if ($paytype == 'stripe') {
            $logger->log("PayTypes() Selected API: 'Stripe'", "INFO");

            $a = $data->query("SELECT payment_settings FROM custom_equipment_payment_method WHERE id = '1'");
            $b = $a->fetch_array();
            $payment_settings = json_decode($b["payment_settings"], true);

            $public = $payment_settings["public"];
            $key = $payment_settings["key"];
            $html .= '<h2>Stripe API Details</h2><br>';
            $html .= '<div class="row">';
            $html .= '<div class="col-md-6"><label>Publishable key</label><br><input class="form-control" type="text" name="pubkey" id="pubkey" value="' . $public . '" placeholder="Converge 6 or 7-Digit Account ID"></div>';
            $html .= '<div class="col-md-6"><label>Secret key</label><br><input class="form-control" type="text" name="secrkey" id="secrkey" value="' . $key  . '" placeholder="Converge User ID"></div>';

            $html .= '</div>';

            $html .= '<br>';

            $html .= '<button class="btn btn-success btn-lg">Save Stripe Details</button>';
        }

        $logger->log("PayTypes() Completed Successfully!", "INFO");
    } catch (Exception $e) {
        $logger->log("ERROR:  Exception in 'paytypes'! - " . $e, "ERROR");
    }

    echo $html;
}

//PAYMENT API UPDATE//
if ($act == 'savepayment_api') {
    try {
        $logger->log("SavePayment_API() Started...", "INFO");
        $payment_api = $_POST["payment_api"];
        $logger->log("SavePayment_API() Selected API: " . $payment_api, "INFO");

        if ($payment_api == 'stripe') {
            $pubkey = $_POST["pubkey"];
            $secrkey = $_POST["secrkey"];
            $ars = array('public' => $pubkey, 'key' => $secrkey);
        }

        if ($payment_api == 'elavon') {
            $elavonendpoint = $_POST["elavonendpoint"];
            $merchantid = $_POST["merchantid"];
            $merchantuserid = $_POST["merchantuserid"];
            $merchantpin = $_POST["merchantpin"];
            $ars = array('enpoint' => $elavonendpoint, 'merchant_id' => $merchantid, 'merchant_userid' => $merchantuserid, 'merchant_pin' => $merchantpin);
        }

        $ars = json_encode($ars);

        $a = $data->query("UPDATE custom_equipment_payment_method SET payment_settings = '" . $data->real_escape_string($ars) . "', payment_type = '" . $data->real_escape_string($payment_api) . "' WHERE id = '1'");
        $b = $a->num_rows;
        $ars = "";

        $ars = array('status' => 'good', 'message' => '<div class="alert alert-success"><strong>Awesome!.</strong><br><p>Your Payment Settings Have Been Successfully Updated. <br>You can now go back to the list or continue to edit your payment settings.</p></div>');

        $logger->log("SavePayment_API() Completed Successfully!", "INFO");
    } catch (Exception $e) {
        $logger->log("ERROR:  Exception in 'savepayment_api'! - " . $e, "ERROR");
    }

    echo json_encode($ars);
}

//GET COUPON LIST//
if ($act == 'coupon_settings') {
    try {
        $logger->log("Coupon_Settings() Started...", "INFO");

        $html .= '<div class="theresults"></div>';
        $html .= '<div class="row"><div class="col-md-6"><h2 style="border-bottom: solid thin #efefef; max-width: 50%">COUPON SETTINGS</h2></div><div class="col-md-6" style="text-align: right"><button class="btn btn-dark" onclick="createNewCoupon()"><i class="fa fa-plus" aria-hidden="true"></i> Create New</button></div></div><br>';
        $html .= '<table id="example" class="table table-striped">';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th>Name</th>';
        $html .= '<th>Type</th>';
        $html .= '<th>Code</th>';
        $html .= '<th>Expire</th>';
        $html .= '<th style="text-align: right">Action</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $a = $data->query("SELECT * FROM custom_equipment_shop_discounts WHERE active = 'true'");
        while ($b = $a->fetch_array()) {
            $html .= '<tr><td>' . $b["coupon_name"] . '</td><td>' . $b["coupon_type"] . '</td><td>' . $b["dis_code"] . '</td><td>' . date('m/d/Y', $b["date_expire"]) . '</td><td style="text-align: right"><button class="btn btn-secondary" onclick="editCoupon(\'' . $b["id"] . '\')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button> <button class="btn btn-danger" onclick="deleteCoupon(\'' . $b["id"] . '\')"><i class="fa fa-trash" aria-hidden="true"></i></button></td></tr>';
        }
        $html .= '</table>';

        $logger->log("Coupon_Settings() Completed Successfully!", "INFO");
    } catch (Exception $e) {
        $logger->log("ERROR:  Exception in 'coupon_settings'! - " . $e, "ERROR");
    }

    echo $html;
}

//GET SHOP SETTINGS//
if ($act == 'store_settings') {
    try {
        $logger->log("Store_Settings() Started...", "INFO");
        include('settings/settings.php');
        $settingss = new EStore_Settings_Two();
        $shop_loc = $settingss->GetDefaultShopLocation();
        $do_tax_stuff = $settingss->GetDoTaxStuff() == 1 ? 'true' : 'false';
        $do_shipping_calcs = $settingss->GetDoShippingCalculations() == 1 ? 'true' : 'false';
        $create_labels = $settingss->CreateShippingLabels() == 1 ? 'true' : 'false';
        $auto_create_labels = $settingss->AutoGenerateLabels() == 1 ? 'true' : 'false';
        $demo_mode = $settingss->DEMO_MODE() == 1 ? 'true' : 'false';
        $use_default_tax = $settingss->UseDefaultTaxRateIfTaxAPIFails() == 1 ? 'true' : 'false';
        $use_default_ship_rate = $settingss->UseDefaultShippingRateIfTaxAPIFails() == 1 ? 'true' : 'false';
        $show_estore_homepage = $settingss->ShowEStoreHomePage() == 1 ? 'true' : 'false';
        $default_tax_rate = $settingss->DefaultTaxRate();
        $default_shipping_rate = $settingss->DefaultShippingRate();


        $html = '<div class="theresults"></div>';
        $html .= '<div class="row"><div class="col-md-6"><h2 style="border-bottom: solid thin #efefef; max-width: 50%">E-STORE SETTINGS</h2></div><div class="col-md-6" style="text-align: right"></div></div><br>';
        $html .= '<table id="example" class="table table-striped">';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th>Setting Name</th>';
        $html .= '<th>Setting Value</th>';
        $html .= '<th class="text-center">Change/Toggle</th>';
        $html .= '</tr>';
        $html .= '</thead>';

        $html .= '<tr>
                    <td>Default Tax Rate</td>
                    <td id="default_tax_rate">' . ($default_tax_rate) . '</td>
                    <td>
                        <div class="row justify-content-center">
                            <input class="form-control default_tax_rate w-25">
                            <button class="btn btn-success btn-default_tax_rate ml-2" onclick="ToggleSetting(\'default_tax_rate\', \'null\')">Update</button>
                        </div>
                    </td>
                </tr>';

        $html .= '<tr>
                    <td>Default Shipping Rate</td>
                    <td id="default_shipping_rate">' . ($default_shipping_rate) . '</td>
                    <td>
                        <div class="row justify-content-center">
                            <input class="form-control default_shipping_rate w-25">
                            <button class="btn btn-success btn-update-location ml-2" onclick="ToggleSetting(\'default_shipping_rate\', \'null\')">Update</button>
                        </div>
                    </td>
                </tr>';

        $html .= '<tr>
                    <td>Default Store Location</td>
                    <td id="default_shop_location">' . ($shop_loc) . '</td>
                    <td>
                        <div class="row justify-content-center">
                            <input class="form-control default_shop_location w-25">
                            <button class="btn btn-success btn-update-location ml-2" onclick="ToggleSetting(\'default_shop_location\', \'null\')">Update</button>
                        </div>
                    </td>
                </tr>';

        $html .= '<tr>
                    <td>Do Tax Calculations</td>
                    <td id="do_tax_stuff">' . ($do_tax_stuff) . '</td>
                    <td class="text-center"><button class="btn btn-' . ($do_tax_stuff == 'true' ? 'success' : 'danger') . ' do_tax_stuff" onclick="ToggleSetting(\'do_tax_stuff\', \'' . $do_tax_stuff . '\')">Toggle</button></td>
                </tr>';

        $html .= '<tr>
                    <td>Do Shipping Calculations</td>
                    <td id="do_shipping_calculations">' . ($do_shipping_calcs) . '</td>
                    <td class="text-center"><button class="btn btn-' . ($do_shipping_calcs == 'true' ? 'success' : 'danger') . ' do_shipping_calculations" onclick="ToggleSetting(\'do_shipping_calculations\', \'' . $do_shipping_calcs . '\')">Toggle</button></td>
                </tr>';

        $html .= '<tr>
                    <td>Create Shipping Labels</td>
                    <td id="create_shipping_labels">' . ($create_labels) . '</td>
                    <td class="text-center"><button class="btn btn-' . ($create_labels == 'true' ? 'success' : 'danger') . ' create_shipping_labels" onclick="ToggleSetting(\'create_shipping_labels\', \'' . $create_labels . '\')">Toggle</button></td>
                </tr>';

        $html .= '<tr>
                    <td>Automatically Create Shipping Labels</td>
                    <td id="auto_generate_labels">' . ($auto_create_labels) . '</td>
                    <td class="text-center"><button class="btn btn-' . ($auto_create_labels == 'true' ? 'success' : 'danger') . ' auto_generate_labels" onclick="ToggleSetting(\'auto_generate_labels\', \'' . $auto_create_labels . '\')">Toggle</button></td>
                </tr>';

        $html .= '<tr style="background-color: yellow;">
                    <td>DEMO MODE <b>   [USE WITH CAUTION]</b></td>
                    <td id="demo_mode">' . ($demo_mode) . '</td>
                    <td class="text-center"><button class="btn btn-' . ($demo_mode == 'true' ? 'success' : 'danger') . ' demo_mode" onclick="ToggleSetting(\'demo_mode\', \'' . $demo_mode . '\')">Toggle</button></td>
                </tr>';

        $html .= '<tr>
                    <td>Use Default Tax Rate - If Zip-Tax Fails</td>
                    <td id="continue_if_tax_api_fails">' . ($use_default_tax) . '</td>
                    <td class="text-center"><button class="btn btn-' . ($use_default_tax == 'true' ? 'success' : 'danger') . ' continue_if_tax_api_fails" onclick="ToggleSetting(\'continue_if_tax_api_fails\', \'' . $use_default_tax . '\')">Toggle</button></td>
                </tr>';

        $html .= '<tr>
                    <td>Use Default Shipping Rate - If Shipping API Calculations Fail</td>
                    <td id="continue_if_tax_api_fails">' . ($use_default_ship_rate) . '</td>
                    <td class="text-center"><button class="btn btn-' . ($use_default_ship_rate == 'true' ? 'success' : 'danger') . ' continue_if_shipping_api_fails" onclick="ToggleSetting(\'continue_if_shipping_api_fails\', \'' . $use_default_ship_rate . '\')">Toggle</button></td>
                </tr>';

        $html .= '<tr>
                    <td>Show EStore Home Page</td>
                    <td id="show_estore_homepage">' . ($show_estore_homepage) . '</td>
                    <td class="text-center"><button class="btn btn-' . ($show_estore_homepage == 'true' ? 'success' : 'danger') . ' show_estore_homepage" onclick="ToggleSetting(\'show_estore_homepage\', \'' . $show_estore_homepage . '\')">Toggle</button></td>
                </tr>';

        $html .= '</table>';

        $html .= '<script>
                    function ToggleSetting(column, current_val) {
                        if (current_val == "null") {
                            var current_val = $("." + column).val();
                        }

                        $.ajax({
                            type: "POST",
                            url: "update_setting.php",
                            data: { column: column, value: current_val },
                            success: function(response) {

                                var button = $("." + column);
                                var newVal = current_val == "true" ? \'false\' : \'true\';
                                button.attr("onclick", "ToggleSetting(\'"+column+"\', \'"+newVal+"\')");

                                if (button.hasClass("btn-success")){
                                    button.removeClass("btn-success");
                                    button.addClass("btn-danger");
                                } else {
                                    button.removeClass("btn-danger");
                                    button.addClass("btn-success");
                                }
        
                                $("#" + column).html(newVal);
        
                                $(".theresults").html("<div class=\"alert alert-success\"><strong>Your Settings Have Been Updated!</strong><br><p>"+column+" Has Been Updated!</p></div>");
                                $(".theresults").show();
        
                                // Start timer to hide alert after 5 seconds
                                setTimeout(function() {
                                    $(".theresults").hide();
                                }, 5000);
                            },
                            error: function(response) {

                                if (column != "default_shop_location" && column != "default_tax_rate" && column != "default_shipping_rate"){
                                    var button = $("." + column);
                                    var newVal = current_val == "true" ? \'false\' : \'true\';
                                    button.attr("onclick", "ToggleSetting(\'"+column+"\', \'"+newVal+"\')");

                                    if (button.hasClass("btn-success")){
                                        button.removeClass("btn-success");
                                        button.addClass("btn-danger");
                                    } else {
                                        button.removeClass("btn-danger");
                                        button.addClass("btn-success");
                                    }

                                    $("#" + column).html(newVal);
                                } else {
                                    var input = $("." + column);
                                    $("#" + column).html(input.val());
                                }
        
        
                                $(".theresults").html("<div class=\"alert alert-success\"><strong>Awesome!</strong><br><p>"+column+" Has Been Updated!</p></div>");
                                $(".theresults").show();
        
                                // Start timer to hide alert after 5 seconds
                                setTimeout(function() {
                                    $(".theresults").hide();
                                }, 5000);
                            }
                        });
                    }
                </script>';

        $logger->log("Store_Settings() Completed Successfully!", "INFO");
    } catch (Exception $e) {
        $logger->log("ERROR:  Exception in 'store_settings'! - " . $e, "ERROR");
    }

    echo $html;
}

//CREATE COUPON FORM//
if ($act == 'create_coupon') {
    try {
        $logger->log("Create_Coupon() Started...", "INFO");

        $html .= '<div class="theresults"></div>';
        $html .= '<div class="row"><div class="col-md-8"><h2 style="border-bottom: solid thin #efefef; max-width: 50%">CREATE NEW COUPON</h2></div><div class="col-md-4" style="text-align: right"><a href="javascript:coupon_settings()"><< Back to list</a> </div></div><br>';
        $html .= '<form name="createcoupon" id="createcoupon" method="post" action="">';
        //ROW START//
        $html .= '<div class="row">';
        $html .= '<div class="col-md-4"><label style="font-weight: bold">Coupon Name</label><br><input type="text" class="form-control" name="coupon_name" id="coupon_name" required="required"></div>';
        $html .= '<div class="col-md-4"><label style="font-weight: bold">Coupon Type</label><br>';
        $html .= '<select class="form-control" name="coupon_type" id="coupon_type" required="required">';
        $html .= '<option value="">Select Type</option>';

        $coupontype = array('Cart Coupon' => 'cart_discount', 'Product Coupon' => 'product_discount');

        foreach ($coupontype as $key => $val) {
            $html .= '<option value="' . $val . '">' . $key . '</option>';
        }

        $html .= '</select>';
        $html .= '</div>';
        $html .= '</div>';
        //ROW END//

        //ROW START//
        $html .= '<br><div class="row selprod">';
        $html .= '<div class="col-md-4 prodselparent" style="display: none"><label style="font-weight: bold">Select Associated Product</label>';
        $html .= '<select class="form-control" name="prodsel" id="prodsel">';
        $html .= '<option value="">Select Product</option>';
        $a = $data->query("SELECT id, title, reg_price FROM custom_equipment WHERE active = 'true' ORDER BY title ASC");
        while ($b = $a->fetch_array()) {
            $html .= '<option value="' . $b["id"] . '">' . $b["title"] . ' - ' . $b["reg_price"] . '</option>';
        }
        $html .= '</select>';
        $html .= '</div>';
        $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $res = "";
        for ($i = 0; $i < 10; $i++) {
            $res .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        $res = str_split($res, 5);
        $res = $res[0] . '-' . $res[1];
        $html .= '<div class="col-md-4"><label style="font-weight: bold">Coupon Code <small>Automatically Generated</small></label><br><input class="form-control" name="coupon_code" id="coupon_code" value="' . $res . '" required="required"></div>';
        $html .= '</div>';
        //ROW END//

        //ROW START//
        $html .= '<br><div class="row">';
        $html .= '<div class="col-md-4"><label style="font-weight: bold; margin: 0">Discount</label><br><small>Discounts can be dollar amount or percentage</small><br><input class="form-control" type="text" name="discount" id="discount" value="" placeholder="example. 25% or 10.00" required="required"></div>';
        //$html .= '<div class="col-md-4"><label style="font-weight: bold; margin: 0">Usage Amount: </label><br><small>How many times can this code be used. If no restriction set to 0</small><br><input class="form-control" type="number" name="usage_amount" id="usage_amount" value="1" min="0"></div>';
        $html .= '</div>';
        //ROW END//

        //ROW START//
        $html .= '<br><div class="row">';
        $html .= '<div class="col-md-4"><label style="font-weight: bold; margin: 0">Expire Date</label><br><small>If coupon does not expire, leave blank</small><br><input class="form-control" type="date" name="exp_date" id="exp_date" value="" placeholder="example. 25% or 10.00"></div>';
        $html .= '<div class="col-md-6 usageparent" style="display:none;"><label style="font-weight: bold; margin: 0">Usage Scenario: </label><br><small>Specify minimum amount for use. This will be the total of the cart before usage.</small><br><input class="form-control" type="text" name="usage_scenario" id="usage_scenario" value="" placeholder="example. 200.00"></div>';
        $html .= '</div>';
        //ROW END//

        //ROW START//
        $html .= '<br><div class="row">';
        $html .= '<div class="col-md-6"><button class="btn btn-success">Create Coupon</button></div>';
        $html .= '</div>';
        //ROW END//

        $html .= '</form>';

        $logger->log("Create_Coupon() Completed Successfully!", "INFO");
    } catch (Exception $e) {
        $logger->log("ERROR:  Exception in 'create_coupon'! - " . $e, "ERROR");
    }
    echo $html;
}

//EDIT COUPON//
if ($act == 'edit_coupon') {
    try {
        $logger->log("Edit_Coupon() Started...", "INFO");

        $coupon_id = $_REQUEST["coupon_id"];
        $logger->log("Edit_Coupon() Coupon ID: " . $coupon_id, "INFO");

        $a = $data->query("SELECT * FROM custom_equipment_shop_discounts WHERE id = '$coupon_id' AND active = 'true'") or die($data->error);
        $b = $a->fetch_array();

        $coupon_name = $b["coupon_name"];
        $coupon_type = $b["coupon_type"];
        $assign_prod = $b["assign_prod"];
        $dis_code = $b["dis_code"];
        $discount = $b["discount"];
        $usage_amount = $b["usage_amount"];
        $date_expire = $b["date_expire"];
        $usage_scenario = $b["usage_scenario"];


        $html .= '<div class="theresults"></div>';
        $html .= '<div class="row"><div class="col-md-8"><h2 style="border-bottom: solid thin #efefef; max-width: 50%">EDIT COUPON</h2></div><div class="col-md-4" style="text-align: right"><a href="javascript:coupon_settings()"><< Back to list</a> </div></div><br>';
        $html .= '<form name="createcoupon" id="createcoupon" method="post" action="">';
        //ROW START//
        $html .= '<input type="hidden" name="coup_id" id="coup_id" value="' . $coupon_id . '">';
        $html .= '<div class="row">';
        $html .= '<div class="col-md-4"><label style="font-weight: bold">Coupon Name</label><br><input type="text" class="form-control" name="coupon_name" id="coupon_name" required="required" value="' . $coupon_name . '"></div>';
        $html .= '<div class="col-md-4"><label style="font-weight: bold">Coupon Type</label><br>';
        $html .= '<select class="form-control" name="coupon_type" id="coupon_type" required="required">';
        $html .= '<option value="">Select Type</option>';
        $coupontype = array('Cart Coupon' => 'cart_discount', 'Product Coupon' => 'product_discount');
        foreach ($coupontype as $key => $val) {
            if ($coupon_type == $val) {
                $html .= '<option value="' . $val . '" selected="selected">' . $key . '</option>';
            } else {
                $html .= '<option value="' . $val . '">' . $key . '</option>';
            }
        }

        $html .= '</select>';
        $html .= '</div>';
        $html .= '</div>';
        //ROW END//

        //ROW START//
        if ($coupon_type == 'cart_discount') {
            $assho = 'none';
            $usageBlock = 'block';
        } else {
            $assho = 'block';
            $usageBlock = 'none';
        }
        $html .= '<br><div class="row selprod">';
        $html .= '<div class="col-md-4 prodselparent" style="display: ' . $assho . '"><label style="font-weight: bold">Select Associated Product</label>';
        $html .= '<select class="form-control" name="prodsel" id="prodsel">';
        $html .= '<option value="">Select Product</option>';
        $a = $data->query("SELECT id, title, reg_price FROM custom_equipment WHERE active = 'true' ORDER BY title ASC");
        while ($b = $a->fetch_array()) {
            if ($assign_prod == $b["id"]) {
                $html .= '<option value="' . $b["id"] . '" selected="selected">' . $b["title"] . ' - ' . $b["reg_price"] . '</option>';
            } else {
                $html .= '<option value="' . $b["id"] . '">' . $b["title"] . ' - ' . $b["reg_price"] . '</option>';
            }
        }
        $html .= '</select>';
        $html .= '</div>';
        $html .= '<div class="col-md-4 usageparent" style="display:' . $usageBlock . '"><label style="font-weight: bold;">Usage Scenario: <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="This is the amount the cart has to total before use."></i></label><br><input class="form-control" type="text" name="usage_scenario" id="usage_scenario" value="' . $usage_scenario . '" placeholder="example. 200.00"></div>';
        $html .= '<div class="col-md-4"><label style="font-weight: bold; ">Coupon Code: <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Code is automatically generated, but can be changed. "></i></label><br><input class="form-control" name="coupon_code" id="coupon_code" value="' . $dis_code . '" required="required"></div>';
        $html .= '</div>';
        //ROW END//

        //ROW START//
        $html .= '<br><div class="row">';
        $html .= '<div class="col-md-4"><label style="font-weight: bold; margin: 0">Discount</label><br><small>Discounts can be dollar amount or percentage</small><br><input class="form-control" type="text" name="discount" id="discount" value="' . $discount . '" placeholder="example. 25% or 10.00" required="required"></div>';
        //$html .= '<div class="col-md-4"><label style="font-weight: bold; margin: 0">Usage Amount: </label><br><small>How many times can this code be used. If no restriction set to 0</small><br><input class="form-control" type="number" name="usage_amount" id="usage_amount" value="'.$usage_amount.'" min="0"></div>';
        $html .= '</div>';
        //ROW END//

        //ROW START//
        $html .= '<br><div class="row">';
        $html .= '<div class="col-md-4"><label style="font-weight: bold; margin: 0">Expire Date</label><br><small>If coupon does not expire, leave blank</small><br><input class="form-control" type="date" name="exp_date" id="exp_date" value="' . date('m/d/Y', $date_expire) . '" placeholder="example. 25% or 10.00"></div>';

        $html .= '</div>';
        //ROW END//

        //ROW START//
        $html .= '<br><div class="row">';
        $html .= '<div class="col-md-6"><button class="btn btn-success">Update Coupon</button></div>';
        $html .= '</div>';
        //ROW END//

        $html .= '</form>';

        $logger->log("Edit_Coupon() Completed Successfully!", "INFO");
    } catch (Exception $e) {
        $logger->log("ERROR:  Exception in 'edit_coupon'! - " . $e, "ERROR");
    }

    echo $html;
}

//CREATE/EDIT COUPON FINISH//
if ($act == 'createcoupon_fin') {
    try {
        $logger->log("CreateCoupon_Fin() Started...", "INFO");
        $coupon_name = $_POST["coupon_name"];
        $coupon_type = $_POST["coupon_type"];
        $prodsel = $_POST["prodsel"];
        $coupon_code = $_POST["coupon_code"];
        $discount = $_POST["discount"];
        $usage_amount = $_POST["usage_amount"];
        $exp_date = $_POST["exp_date"];
        $usage_scenario = $_POST["usage_scenario"];
        $coup_id = $_POST["coup_id"];
        $exp_date = strtotime($exp_date);


        if (isset($coup_id) && $coup_id != null) {
            //UPDATES COUPON//
            $data->query("UPDATE custom_equipment_shop_discounts SET coupon_name = '" . $data->real_escape_string($coupon_name) . "', coupon_type = '" . $data->real_escape_string($coupon_type) . "', assign_prod = '" . $data->real_escape_string($prodsel) . "', dis_code = '" . $data->real_escape_string($coupon_code) . "', discount = '" . $data->real_escape_string($discount) . "', usage_amount = '" . $data->real_escape_string($usage_amount) . "', date_expire = '" . $data->real_escape_string($exp_date) . "', usage_scenario = '" . $data->real_escape_string($usage_scenario) . "' WHERE id = '$coup_id'");
            $results = array("status" => "good", "message" => '<div class="alert alert-success"><strong>Awesome!.</strong><br><p>Your coupon has been successfully updated. </p></div>', "coupon_id" => $coup_id);
        } else {
            //ADDS NEW COUPON//
            $a = $data->query("SELECT * FROM custom_equipment_shop_discounts WHERE coupon_name = '$coupon_name' AND active = 'true'");
            if ($a->num_rows == 0) {
                $data->query("INSERT INTO custom_equipment_shop_discounts SET coupon_name = '" . $data->real_escape_string($coupon_name) . "', coupon_type = '" . $data->real_escape_string($coupon_type) . "', assign_prod = '" . $data->real_escape_string($prodsel) . "', dis_code = '" . $data->real_escape_string($coupon_code) . "', discount = '" . $data->real_escape_string($discount) . "', usage_amount = '" . $data->real_escape_string($usage_amount) . "', date_expire = '" . $data->real_escape_string($exp_date) . "', usage_scenario = '" . $data->real_escape_string($usage_scenario) . "', active = 'true'");
                $coup_id = $data->insert_id;
                $results = array("status" => "good", "message" => '<div class="alert alert-success"><strong>Awesome!.</strong><br><p>Your coupon has been successfully created. <br>You can now go back to the list or continue to edit this coupon.</p></div>');
            } else {
                $results = array("status" => "bad", "message" => '<div class="alert alert-danger"><strong>Whoops!.</strong><br><p>It appears you already have coupon with the name "' . $coupon_name . '"<br>Please enter a diffirent name and try again.</p></div>');
            }
        }

        $logger->log("CreateCoupon_Fin() Completed Successfully!", "INFO");
    } catch (Exception $e) {
        $logger->log("ERROR:  Exception in 'createcoupon_fin'! - " . $e, "ERROR");
    }

    echo json_encode($results);
}

if ($act == 'deletecoupon') {
    try {
        $logger->log("DeleteCoupon() Started...", "INFO");

        $couponid = $_REQUEST["couponid"];
        $logger->log("DeleteCoupon() Coupon ID: " . $couponid, "INFO");

        $data->query("UPDATE custom_equipment_shop_discounts SET active = 'false' WHERE id = '$couponid'");

        $logger->log("DeleteCoupon() Completed Successfully!", "INFO");
    } catch (Exception $e) {
        $logger->log("ERROR:  Exception in 'deletecoupon'! - " . $e, "ERROR");
    }
}

if ($act == 'modsalesreceipt') {
    try {
        $logger->log("ModSalesReceipt() Started...", "INFO");

        $html .= '<div class="theresults"></div>';
        $html .= '<div class="row"><div class="col-md-8"><h2 style="border-bottom: solid thin #efefef; max-width: 50%">EDIT RECEIPT DETAILS</h2></div></div><br>';
        $html .= '<form name="savesalesreceipt" id="savesalesreceipt" method="post" action="">';

        $html .= '<h4><b>Add Receipt Logo</b></h4>
            <div class="input-group mb-3">';

        $a = $data->query("SELECT * FROM custom_equipment_receipt_settings WHERE id = 1");
        $b = $a->fetch_array();

        $html .= '<input type="text" class=" col-6 form-control" name="receipt_img" id="receipt_img" placeholder="No Image" aria-label="Category Image" value="' . $b["receipt_img"] . '">
                <div class="input-group-append"><button class="btn btn-light img-browser" data-setter="receipt_img" type="button" style="height: 50px;">Browse Images</button></div>
                     
            <div class="col-6 imgprev receipt_img mb-3"><img style="background-image: url(\'../../img/no-image.jpg\'); background-position: center; background-size: contain; background-repeat: no-repeat; width: 500px; height: 200px;" src="../../' . $b["receipt_img"] . '">

            </div>   
            </div>  
            <div>    
            <h4><b>Add Receipt Email Subject</b></h4>
            <input type="text" class="form-control mb-3" name="receipt_subject" id="receipt_subject" placeholder="Email Subject" value="' . $b["receipt_subject"] . '">
            </div>
            <div>
            <h4><b>Add Receipt Headline</b></h4>
            <input type="text" class="form-control mb-3" name="receipt_headline" id="receipt_headline" placeholder="Receipt Headline" value="' . $b["receipt_headline"] . '">
            </div>
            <h4><b>Add Receipt Details</b></h4>
            <label>Page Details</label><br>
            <textarea class="summernote form-control mb-3" id="receipt-text" name="receipt-text"> ' . $b["receipt_sales_message"] . '</textarea><br><br>
            <button class="btn btn-success" type="submit" name="invoiceSubmit">Save Receipt Settings</button>';

        $html .= '</form>';
        $html .= '</div>';
        $html .= '</div>';

        $logger->log("ModSalesReceipt() Completed Successfully!", "INFO");
    } catch (Exception $e) {
        $logger->log("ERROR:  Exception in 'modsalesreceipt'! - " . $e, "ERROR");
    }

    echo ($html);
}

if ($act == 'savesalesreceipt') {
    try {
        $logger->log("ModSalesReceipt() Started...", "INFO");

        if (isset($_POST["invoiceSubmit"])) {
            // echo "submitted";
            $img = $_POST["receipt_img"];
            //  echo $img;
            $receiptText = $_POST["receipt-text"];
            $receipt_subject = $_POST["receipt_subject"];
            $receipt_headline = $_POST["receipt_headline"];
            $a = $data->query("UPDATE custom_equipment_receipt_settings SET receipt_img = '$img', receipt_sales_message = '" . $data->real_escape_string($receiptText) . "', receipt_subject = '" . $data->real_escape_string($receipt_subject) . "', receipt_headline = '" . $data->real_escape_string($receipt_headline) . "' WHERE id = 1") or die($data->error);
            if ($a->num_rows == 0) {
                $results = array("status" => "good", "message" => '<div class="alert alert-success"><strong>Awesome!.</strong><br><p>Your Receipt settings have been successfully modified.</p></div>');
            } else {
                $results = array("status" => "bad", "message" => '<div class="alert alert-danger"><strong>Whoops!.</strong><br><p>There was an issue updating receipt settings!</p></div>');
            }
        } else {
            $logger->log("SaveSalesReceipt() FAILED! POST['invoiceSubmit'] NOT Set!", "ERROR");
        }

        $logger->log("SaveSalesReceipt() Completed Successfully!", "INFO");
    } catch (Exception $e) {
        $logger->log("ERROR:  Exception in 'savesalesreceipt'! - " . $e, "ERROR");
    }

    echo json_encode($results);
}
