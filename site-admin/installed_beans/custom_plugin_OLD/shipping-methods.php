<?php
include('../../inc/harness.php');
// echo "Hello";
$shipRadioDefault = $_POST["shipRadioDefault"];
$useShippo = "";
if ($shipRadioDefault == "Shippo") {
      $shippoAPIToken = $_POST["shippoAPIToken"];
      $useShippo = "true";
} else {
      $shippoAPIToken = "";
      $useShippo = "false";
}

// echo $shipRadioDefault;


if (isset($_POST['submit'])) {
      $data->query("UPDATE shipping SET shippo_api = '" . $data->real_escape_string($shippoAPIToken) . "', ship_type = '" . $data->real_escape_string($shipRadioDefault) . "', use_shippo = '" . $data->real_escape_string($useShippo) . "' WHERE id=1") or die($data->error);
      $message = "Shipping Method Updated";
      echo "<script type='text/javascript'>alert('$message');</script>";
}
?>
<?php
include('e-commerce-header.php');
?>
<div class="row" style="margin:0;">
      <div class="col-md-12">
            <div class="header">
                  <h4 class="title">Shipping Method</h4>
                  <p class="category">Set your shipping method here.</p>
            </div>
            <div class="content table-responsive table-full-width">
                  <!-- RADIO BUTTON Shipping START======================== -->
                  <?php
                  $shipping = $data->query("SELECT * FROM shipping WHERE id = 1");
                  $shipping_row = $shipping->fetch_assoc();
                  ?>
                  <form name="shippoShippingForm" method="post" action="">
                        <div>
                              <p>Shipping Accepted by</p>
                              <input type="radio" name="shipRadioDefault" id="shipRadioDefault1" value="Flate Rate Shipping" <?php
                                                                                                                              if ($shipping_row["ship_type"] == "Flate Rate Shipping") {
                                                                                                                                    echo "checked";
                                                                                                                              }
                                                                                                                              ?>>
                              <label for="shipRadioDefault1">
                                    Flate Rate Shipping
                              </label><br>
                              <input type="radio" name="shipRadioDefault" id="shipRadioDefault2" value="Shippo" <?php
                                                                                                                  if ($shipping_row["ship_type"] == "Shippo") {
                                                                                                                        echo "checked";
                                                                                                                  }
                                                                                                                  ?>>
                              <label for="shipRadioDefault2">
                                    Shippo
                              </label>
                        </div>

                        <div id="shippo-details" style="display: none;">
                              <h5 style="margin-top: 10px;">Shippo Details</h5>
                              <label for="shippoAPIToken">API token</label><br>
                              <input class="form-control" type="text" id="shippoAPIToken" name="shippoAPIToken" value="<?php echo $shipping_row["shippo_api"] ?>"><br>
                        </div>
                        <button class="btn btn-success" type="submit" id="submit" name="submit">Save</button>
                  </form>
                  <!-- RADIO BUTTON Shipping END========================== -->
            </div>
      </div>
</div>

<?php
include('e-commerce-footer.php');
?>
<script>
      $(document).ready(function() {
            if ($('#shipRadioDefault2').is(':checked')) {
                  $('#shippo-details').show();
            }

            $('input[type=radio][name="shipRadioDefault"]').change(function() {
                  if ($(this).val() === "Shippo") {
                        $('#shippo-details').show();
                  } else if ($(this).val() === "Flate Rate Shipping") {
                        $('#shippo-details').removeAttr("style").hide();
                  }
                  console.log($(this).val()); // or, use `this.value`
            });
      });
</script>