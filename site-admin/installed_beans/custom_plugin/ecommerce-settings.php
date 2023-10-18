<?php
include('e-commerce-header.php');
?>
<?php
include('../../inc/harness.php');
if (isset($_POST['submit'])) {


  // $message = "Shipping Method Updated";
  echo "<script  type='text/javascript'>swal({
    title: 'Page Saved',
    text: 'I will now close.',
    type: 'success',
    timer: 2000
}).then(
    function () {
    },
    // handling the promise rejection
    function (dismiss) {
        if (dismiss === 'timer') {
            console.log('I was closed by the timer')
        }
    });</script>";
}
?>
<?php
function getSettingsData($settingName)
{
  include('../../inc/harness.php');
  $a = $data->query("SELECT * FROM shop_settings WHERE setting_name = '$settingName'");
  $b = $a->fetch_array();
  return ($b["setting_value"] == "true") ? "True" : "False";
}

function isToggleChecked($toggleName)
{
  if (getSettingsData($toggleName) == "True") {
    return "checked";
  } else {
    return "";
  }
}

function shipTypeSelected($shipType, $settingName)
{
  include('../../inc/harness.php');
  $a = $data->query("SELECT * FROM shop_settings WHERE setting_name = '$settingName'");
  $b = $a->fetch_array();
  if ($shipType == $b["setting_value"]) {
    return "selected";
  } else {
    return "";
  }
}

function inputFieldVal($settingName)
{
  include('../../inc/harness.php');
  $a = $data->query("SELECT * FROM shop_settings WHERE setting_name = '$settingName'");
  $b = $a->fetch_array();
  return $b["setting_value"];
}

function textFieldVal($settingName)
{
  include('../../inc/harness.php');
  $a = $data->query("SELECT * FROM shop_settings WHERE setting_name = '$settingName'");
  $b = $a->fetch_array();
  return strip_tags($b["information"]);
}
?>





<div class="row" style="margin:0;">
  <div class="col-md-12">
    <div class="header">
      <h3 class="title">EQ-Commerce Settings</h3>
      <p class="category">Set your EQ-Commerce settings here.</p>
      <hr>
    </div>
    <div class="content table-responsive table-full-width">

      <form name="ecommerceSettings" id="ecommerceSettings" method="post" action="">

        <!-- LOCATION SELECT================================= -->
        <div class="form-group">
          <h4 class="form-toggle-label"><b>Location Select</b></h4>
          <input type="checkbox" id="switch1" name="switch1" class="checkbox1" <?php echo isToggleChecked('location_select'); ?> />
          <label for="switch1" class="toggle1"></label><span class="switchValClass" id="locationSelect">
            <?php echo (getSettingsData('location_select')) ?>
          </span>
          <p style="color:brown">Setting to "True" will force customers to select a location before adding to cart. Setting to "False" will disable location selection and allow customers to add without selecting a location.</p>
        </div>
        <hr>

        <!-- SHIP TYPE======================================= -->
        <div class="form-group">
          <h4><b>Select Ship Type</b></h4>
          <p style="color:brown">Create Label = Will create shipment with labels. Ship Price = Will only use the suggested price of the shipping API and not create label. Flat Rate = Will use the systems flat rate shipping price on all products in the cart.</p>
          <select class="form-control" id="shipType" name="shipType">
            <option value="">Select an option</option>
            <option value="create_label" <?php echo shipTypeSelected("create_label", "ship_type_global") ?>>Create Label</option>
            <option value="ship_price" <?php echo shipTypeSelected("ship_price", "ship_type_global") ?>>Ship Price</option>
            <option value="flat_rate" <?php echo shipTypeSelected("flat_rate", "ship_type_global") ?>>Flat Rate</option>
          </select>
          <hr>
        </div>


        <!-- FLAT RATE SHIPPING PRICE============================ -->
        <div class="form-group" id="flateRateDiv">
          <h4><b>Set Flat Rate Shipping Price</b></h4>
          <p style="color:brown">If Flat Rate is set as the Ship Type the system will use this price for shipping</p>
          <input type="text" class="form-control" id="flatRatePrice" name="flatRatePrice" value="<?php echo inputFieldVal('flat_rate_shipping_price') ?>">
          <hr>
        </div>


        <!-- DISPLAY QUANTITY ON PRODUCT PAGE==================== -->
        <div class="form-group">
          <h4 class="form-toggle-label"><b>Display Quantity on Product Page</b></h4>
          <input type="checkbox" id="switch2" name="switch2" class="checkbox2" <?php echo isToggleChecked('qty_sel_prod_page'); ?> />
          <label for="switch2" class="toggle2"></label><span class="switchValClass" id="displayQty"><?php echo (getSettingsData('qty_sel_prod_page')) ?></span>
          <p style="color:brown">If this is set to "True" this will allow quantity input on the product page. This should be set to "False" in conjunction with Location Select being set to true.</p>
        </div>
        <hr>

        <!-- SELL PER QUANTITY SETTINGS========================== -->
        <div class="form-group">
          <h4 class="form-toggle-label"><b>Sell Per Quantity Settings</b></h4>
          <input type="checkbox" id="switch3" name="switch3" class="checkbox3" <?php echo isToggleChecked('sell_per_qty'); ?> />
          <label for="switch3" class="toggle3"></label><span class="switchValClass" id="sellQty"><?php echo (getSettingsData('sell_per_qty')) ?></span>
          <p style="color:brown">If this is set to "True" this will keep count of quantity of product and will not allow purchase if product is over stock.</p>
        </div>
        <hr>

        <!-- SELECT DEFAULT SHIP LOCATION========================= -->
        <div class="form-group" id="shipLocDiv">
          <h4><b>Select Default Ship Location</b></h4>
          <p style="color:brown">If Location Select = False and Ship Type = Ship Price</p>
          <select class="form-control" id="shipLocation" name="shipLocation">
            <option value="">Select an option</option>

            <?php
            include('../../inc/harness.php');
            $a = $data->query("SELECT * FROM location WHERE id != 15");
            while ($b = $a->fetch_array()) {
              echo '<option value="' . $b["id"] . '"' . shipTypeSelected($b["id"], "default_ship_location") . '>' . $b["location_name"] . '</option>';
            }
            ?>
          </select>
          <hr>
        </div>


        <!-- INCLUDE TAX CALCULATIONS============================= -->
        <div class="form-group">
          <h4 class="form-toggle-label"><b>Include Tax Calculations</b></h4>
          <input type="checkbox" id="switch4" name="switch4" class="checkbox4" <?php echo isToggleChecked('do_tax_stuff'); ?> />
          <label for="switch4" class="toggle4"></label><span class="switchValClass" id="taxCalc"><?php echo (getSettingsData('do_tax_stuff')) ?></span>
          <p style="color:brown">If this is set to "True" this will include the tax calculations from the locations input tax rate and the tax API.</p>
        </div>
        <hr>

        <!-- PAYMENT SUCCESS MESSAGE============================== -->
        <div class="form-group">
          <h4><b>Payment Success Message</b></h4>
          <p style="color:brown">This message will be displayed once the payment is successfully processed.</p>
          <textarea class="form-control" id="paymentSuccessMsg" rows="3" name="paymentSuccessMsg"><?php echo textFieldVal('payment_success') ?></textarea>
        </div>

        <button class="btn btn-success" type="button" id="ecommSubmit" name="ecommSubmit">Save</button>
      </form>
    </div>
  </div>
</div>

<?php
include('e-commerce-footer.php');
?>

<script>
  $('input[type="checkbox"]').click(function(event) {
    var toggleSpan = "";
    switch (event.target.id) {
      case 'switch1':
        toggleSpan = '#locationSelect';
        break;
      case 'switch2':
        toggleSpan = '#displayQty';
        break;
      case 'switch3':
        toggleSpan = '#sellQty';
        break;
      case 'switch4':
        toggleSpan = '#taxCalc';
        break;
    }
    switchClicked(event.target.id, toggleSpan);
  });

  function switchClicked(toggleID, toggleSpan) {
    if ($('#' + toggleID).prop('checked')) {
      $(toggleSpan).html("True");
    } else {
      $(toggleSpan).html("False");
    }
  }

  // FLAT RATE PRICE if SHIP TYPE is FLAT RATE START===================
  $(document).ready(function() {
    $('#shipType').find(":selected").text() === "Flat Rate" ? $('#flateRateDiv').show() : $('#flateRateDiv').hide();
    $('#switch1').prop('checked') === true ? $("#switch2").prop("checked", false) : $("#switch2").prop("checked", true);
    ($('#switch1').prop('checked') === false && $('#shipType').find(":selected").text() === "Ship Price") ? $('#shipLocDiv').show(): $('#shipLocDiv').hide();

    $('#switch1').prop('checked') === true ? $("#locationSelect").html("True") : $("#locationSelect").html("False");
    $('#switch2').prop('checked') === true ? $("#displayQty").html("True") : $("#displayQty").html("False");
    $('#switch3').prop('checked') === true ? $("#sellQty").html("True") : $("#sellQty").html("False");
    $('#switch4').prop('checked') === true ? $("#taxCalc").html("True") : $("#taxCalc").html("False");

  });

  $('#shipType').change(function() {
    $('#shipType').find(":selected").text() === "Flat Rate" ? $('#flateRateDiv').show() : $('#flateRateDiv').hide();
    ($('#switch1').prop('checked') === false && $('#shipType').find(":selected").text() === "Ship Price") ? $('#shipLocDiv').show(): $('#shipLocDiv').hide();
  });

  $('#switch1').change(function() {
    if ($('#switch1').prop('checked') === true) {
      $("#switch2").prop("checked", false);
      $("#displayQty").html("False");
    } else {
      $("#switch2").prop("checked", true);
      $("#displayQty").html("True");
    }

    ($('#switch1').prop('checked') === false && $('#shipType').find(":selected").text() === "Ship Price") ? $('#shipLocDiv').show(): $('#shipLocDiv').hide();
  });
  $('#switch2').change(function() {
    if ($('#switch2').prop('checked') === true) {
      $("#switch1").prop("checked", false);
      $("#locationSelect").html("False")
    } else {
      $("#switch1").prop("checked", true);
      $("#locationSelect").html("True")
    }
  });

  function isCheckedVal(id) {
    if ($(id).prop('checked') === true) {
      return "true";
    } else {
      return "false";
    }
  }
  $("#ecommSubmit").on('click', function() {
    var locationSelect = isCheckedVal('#switch1');
    // console.log(locationSelect);
    var shipType = $('#shipType').find(":selected").val();
    var flatRatePrice = $('#flatRatePrice').val();
    var qtyProdPage = isCheckedVal('#switch2');
    var sellPerQty = isCheckedVal('#switch3');
    var shipLocation = $('#shipLocation').find(":selected").val();
    console.log(shipLocation);
    var taxInclusion = isCheckedVal('#switch4');
    var paymentSuccessMsg = $('#paymentSuccessMsg').val();
    $.ajax({
      url: 'async.php?action=ecommerceSettings&locationSelect=' + locationSelect + '&shipType=' + shipType + '&flatRatePrice=' + flatRatePrice + '&qtyProdPage=' + qtyProdPage + '&sellPerQty=' + sellPerQty + '&shipLocation=' + shipLocation + '&taxInclusion=' + taxInclusion + '&paymentSuccessMsg=' + paymentSuccessMsg,
      success: function(msg) {
        swal({
          title: 'Settings Saved',
          text: 'I will now close.',
          type: 'success',
          timer: 2000
        }).then(
          function() {},
          // handling the promise rejection
          function(dismiss) {
            if (dismiss === 'timer') {
              console.log('I was closed by the timer')


            }
          });
      }

    })
  })
</script>