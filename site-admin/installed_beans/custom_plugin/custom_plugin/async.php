<?php
if (file_exists('../../inc/harness.php')) {
  include('../../inc/harness.php');
} else {
  include('inc/harness.php');
}

// include('functions.php');
// $tractorstuff = new packageclass();
$act = $_REQUEST["action"];
include('../../inc/caffeine.php');
$site = new caffeine();
$userArray = $site->auth();
if ($act == 'clicked') {
  $value = $_REQUEST["value"];
  $html = '<div class="wrapper">
    <h2><strong>' . $value . '</strong></h2>            
    </div>';

  echo $html;
}

if ($act == 'openorder') {
  $messData = $site->readOrder($_REQUEST["id"]);
  $MsgData = stripslashes(trim($messData["items_list"], '"'));
  $jsonMsgData = json_decode($MsgData, true);
  $storeLocation = $jsonMsgData["shop_location"];
  $a = $data->query("SELECT * FROM location WHERE id = '$storeLocation'");
  $b = $a->fetch_array();

  // ORDER NOTES=================================

  if ($messData["order_notes"] != "") {
    $orderNotes = "<div>
        <p><b>Order Notes</b>
" . $messData["order_notes"] . "
        </p>
       </div>";
  } else {
    $orderNotes = "";
  }
  $html .= '<div class="review-message alert alert-danger" style="display: none"></div>';
  $html .= '<h2
    class=""
    style="
      text-align: center;
      margin: 20px auto 30px;
      padding: 30px;
      background-color: #F9CC48;
    "
  >
    Order Details
  </h2>';

  $html .= '<table>
    <tr><td style="padding: 20px;">
      <p style="margin-bottom:5px;">
        Billed To: <br /><b
          >' . $messData["address"] . '<br />' . $messData["city"] . ' ' . $messData["state"] . ', ' . $messData["zip"] . '<br /><a
            href="' . $messData["email"] . '"
            ><i>' . $messData["email"] . '</i></a
          ><br />' . $messData["phone"] . '</b
        >
      </p>
    </td>';

  if ($jsonMsgData["shipping_type"] == "Customer Pickup") {
    $shipLoc = $data->query("SELECT * FROM location WHERE location_name = '" . $jsonMsgData["pickup"] . "'");
    $shipLocData = $shipLoc->fetch_array();
    // var_dump($shipLocData);
    $html .= '<td style="padding: 20px;">
      <p style="margin-bottom:5px;">
        Pickup Address: <br /><b
          >West Central Equipment<br>' . $shipLocData["location_address"] . '<br />' . $shipLocData["location_city"] . ' ' . $shipLocData["location_state"] . ', ' . $shipLocData["location_zip"] . '</b
        >
      </p><p style="margin-bottom:5px;">Store Location: <br /><b>' . $b["location_name"] . '</b></p>
    </td>';
    $shippinglabel = "";
    $trackingNo = '';
  } else {
    $html .= '<td style="padding: 20px;">
      <p style="margin-bottom:5px;">
        Shipping Address: <br /><b
          >' . $messData["ship_address"] . '<br />' . $messData["ship_city"] . ' ' . $messData["ship_state"] . ', ' . $messData["ship_zip"] . '</b
        >
      </p><p style="margin-bottom:5px;">Store Location: <br /><b>' . $b["location_name"] . '</b></p>
    </td>';
    $shippinglabel = '<a style="float:left;" class="btn btn-primary printShipLabel" href="' . $messData["ship_label_url"]  . '" target="_blank">Print Label</a>';
    $trackingNo = '<p style="margin-bottom:5px;">Tracking Number: <br /><b>' .$messData["ship_tracking"]. '</b></p>';
  }

  // var_dump($jsonMsgData["shipping_type"]);
  // var_dump($jsonMsgData["pickup"]);

  $html .= '<td style="padding: 20px;">
      <p style="margin-bottom:5px;">Purchase Number: <br /><b>' . $messData["purchase_num"] . '</b></p>
      <p style="margin-bottom:5px;">Purchase Date: <br /><b>' . date('m/d/Y h:ia', $messData["date_sub"]) . '</b></p>'.$trackingNo.'
      
    </td></tr>
  </table>';
  $html .= $orderNotes;


  $html .= '<table class="table" style="width: 100%; text-align: left">
    <thead>
      <tr>
        <th scope="col">Equipment</th>
        <th scope="col">Price</th>
      </tr>
    </thead>
    <tbody>';

  foreach ($jsonMsgData["cartitems"] as $item) {
    $itemqty = (float)$item["qty"];
    $itemPrice = (float)$item["price"];
    $itemTotalPrice = $itemqty * $itemPrice;
    $html .= '<tr style="background-color: #e7e7e791">
        <td>
          <p style="margin-bottom:5px;">
            <a
              href="' . $item["url"] . '"
              target="_blank"
              >' . $item["name"] . '</a
            ><br />
            <small>Quantity: ' . $item["qty"] . '</small>
          </p>
        </td>
        <td>
          <p style="margin-bottom:5px;">$' . number_format($itemTotalPrice, 2) . '<br /><small>$' . number_format($item["price"], 2) . '/ea</small></p>
        </td>
      </tr>';
  }
  $html .= '
      <tr>
        <td>
          <p style="margin-bottom:5px;">
            Tax
          </p>
        </td>
        <td><p style="margin-bottom:5px;">$' . number_format($messData["applied_tax"], 2) . '</p></td>
      </tr>';
  $html .= '
      <tr>
        <td>
          <p style="margin-bottom:5px;">
            Shipping Price<br />
            <small>' . $jsonMsgData["shipping_type"] . '</small>
          </p>
        </td>
        <td><p style="margin-bottom:5px;">$' . number_format($jsonMsgData["shipping_price"], 2) . '</p></td>
      </tr>';

  $html .= '
      <tr>
        <td><p style="margin-bottom:5px;">Total</p></td>
        <td><p style="margin-bottom:5px;">$' . number_format($messData["purchase_price"], 2) . '</p></td>
      </tr>
    </tbody>
  </table>';


  if ($messData["status"] == 'New') {
    $approved = '<button class="btn btn-primary apprvrv" data-id="' . $messData["id"] . '">Mark Completed</button>';
  } else {
    $approved = '';
  }
  // $printShipLabel = '';

  $html .= '<div class="noprint" style="text-align: right">'.$shippinglabel.'<button class="btn btn-danger delrev" data-id="' . $messData["id"] . '">Delete Order</button> ' . $approved . '</div>';
  echo $html;
}

if ($act == 'ecommerceSettings') {
  $locationSelect = $_REQUEST['locationSelect'];
  $shipType = $_REQUEST['shipType'];
  $flatRatePrice = $_REQUEST['flatRatePrice'];
  $qtyProdPage = $_REQUEST['qtyProdPage'];
  $sellPerQty = $_REQUEST['sellPerQty'];
  $shipLocation = $_REQUEST['shipLocation'];
  $taxInclusion = $_REQUEST['taxInclusion'];
  $paymentSuccessMsg = $_REQUEST['paymentSuccessMsg'];
  // UPDATE `randsdatabase`.`shop_settings` SET `setting_value`='true' WHERE `id`='1';
  $data->query("UPDATE shop_settings SET setting_value = '" . $data->real_escape_string($locationSelect) . "' WHERE id = 1") or die($data->error);
  $data->query("UPDATE shop_settings SET setting_value = '" . $data->real_escape_string($shipType) . "' WHERE id = 2") or die($data->error);
  $data->query("UPDATE shop_settings SET setting_value = '" . $data->real_escape_string($flatRatePrice) . "' WHERE id = 3") or die($data->error);
  $data->query("UPDATE shop_settings SET setting_value = '" . $data->real_escape_string($qtyProdPage) . "' WHERE id = 4") or die($data->error);
  $data->query("UPDATE shop_settings SET setting_value = '" . $data->real_escape_string($sellPerQty) . "' WHERE id = 5") or die($data->error);
  $data->query("UPDATE shop_settings SET setting_value = '" . $data->real_escape_string($shipLocation) . "' WHERE id = 6") or die($data->error);
  $data->query("UPDATE shop_settings SET setting_value = '" . $data->real_escape_string($taxInclusion) . "' WHERE id = 7") or die($data->error);
  $data->query("UPDATE shop_settings SET information = '" . $data->real_escape_string($paymentSuccessMsg) . "' WHERE id = 8") or die($data->error);
}
