<?php
include('../../inc/harness.php');

if (isset($_POST['stripeSubmit'])) {
  $paymentType = "Stripe";
  $stripe->secretKey = $_POST["secretKey"];
  $stripe->publishKey = $_POST["publishKey"];
  $stripe->url = $_POST["stripeurl"];
  $paymentSettings = json_encode($stripe);;

  $data->query("UPDATE payment_method SET payment_type = '" . $data->real_escape_string($paymentType) . "', payment_settings = '" . $data->real_escape_string($paymentSettings) . "' WHERE id=1") or die($data->error);
  $message = "Payment Method Updated to Stripe";
  echo "<script type='text/javascript'>alert('$message');</script>";
} else if (isset($_POST['elavonSubmit'])) {
  $paymentType = "Elavon";
  $elavon->merchantID = $_POST["merchantID"];
  $elavon->merchantUserID = $_POST["merchantUserID"];
  $elavon->merchantPin = $_POST["merchantPin"];
  $elavon->elavonurl = $_POST["elavonurl"];
  $paymentSettings = json_encode($elavon);;

  $data->query("UPDATE payment_method SET payment_type = '" . $data->real_escape_string($paymentType) . "', payment_settings = '" . $data->real_escape_string($paymentSettings) . "' WHERE id=1") or die($data->error);
  $message = "Payment Method Updated to Elavon";
  echo "<script type='text/javascript'>alert('$message');</script>";
}
?>
<?php
include('e-commerce-header.php');
?>
<div class="row" style="margin:0;">
  <div class="col-md-12">
    <div class="header">
      <h4 class="title">Payment Method</h4>
      <p class="category">Set your payment method here.</p>
    </div>
    <div class="content table-responsive table-full-width">
      <!-- RADIO BUTTON Payment START======================== -->
      <?php
      $payment = $data->query("SELECT * FROM payment_method WHERE id = 1");
      $payment_row = $payment->fetch_assoc();
      ?>
      <div>
        <p>Payment Accepted by</p>
        <input type="radio" name="flexRadioDefault" id="flexRadioDefault1" value="Stripe" <?php
                                                                                          if ($payment_row["payment_type"] == "Stripe") {
                                                                                            echo "checked";
                                                                                          }
                                                                                          ?>>
        <label for="flexRadioDefault1">
          Stripe
        </label><br>
        <input type="radio" name="flexRadioDefault" id="flexRadioDefault2" value="Elavon" <?php
                                                                                          if ($payment_row["payment_type"] == "Elavon") {
                                                                                            echo "checked";
                                                                                          }
                                                                                          ?>>
        <label for="flexRadioDefault2">
          Elavon
        </label>
      </div>

      <?php
      if ($payment_row["payment_type"] == "Stripe") {
        $payment_decode = json_decode($payment_row["payment_settings"]);
      }
      ?>
      <div id="stripe-details" style="display: none;">
        <h5 style="margin-top: 20px;">Stripe Details</h5>
        <form name="stripePaymentForm" method="post" action="">
          <label>Secret Key</label><br>
          <input class="form-control" type="password" id="secretKey" name="secretKey" value="<?php echo $payment_decode->secretKey ?>"><br>
          <label>Publish Key</label><br>
          <input class="form-control" type="text" id="publishKey" name="publishKey" value="<?php echo $payment_decode->publishKey ?>"><br>
          <label>URL</label><br>
          <input class="form-control" type="text" id="stripeurl" name="stripeurl" value="<?php echo $payment_decode->url ?>"><br>
          <button class="btn btn-success" type="submit" id="submit" name="stripeSubmit">Save</button>
        </form>
      </div>

      <div id="elavon-details" style="display: none;">
        <h5 style="margin-top: 20px;">Elavon Details</h5>
        <?php
        if ($payment_row["payment_type"] == "Elavon") {
          $payment_decode = json_decode($payment_row["payment_settings"]);
        }
        ?>
        <form name="elavonPaymentForm" method="post" action="">
          <label>Merchant ID</label><br>
          <input class="form-control" type="text" id="merchantID" name="merchantID" value="<?php echo $payment_decode->merchantID ?>"><br>
          <label>Merchant User ID</label><br>
          <input class="form-control" type="text" id="merchantUserID" name="merchantUserID" value="<?php echo $payment_decode->merchantUserID ?>"><br>
          <label>Merchant PIN</label><br>
          <input class="form-control" type="password" id="merchantPin" name="merchantPin" value="<?php echo $payment_decode->merchantPin ?>"><br>
          <label>URL</label><br>
          <input class="form-control" type="text" id="elavonurl" name="elavonurl" value="<?php echo $payment_decode->elavonurl ?>"><br>
          <button class="btn btn-success" type="submit" id="submit" name="elavonSubmit">Save</button>
        </form>
      </div>
      <!-- RADIO BUTTON Payment END========================== -->
    </div>
  </div>
</div>

<?php
include('e-commerce-footer.php');
?>
<script>
  $(document).ready(function() {
    if ($('#flexRadioDefault1').is(':checked')) {
      $('#stripe-details').show();
    } else if ($('#flexRadioDefault2').is(':checked')) {
      $('#elavon-details').show();
    }

    $('input[type=radio][name="flexRadioDefault"]').change(function() {
      if ($(this).val() === "Stripe") {
        $('#elavon-details').removeAttr("style").hide();
        $('#stripe-details').show();
      } else if ($(this).val() === "Elavon") {
        $('#stripe-details').removeAttr("style").hide();
        $('#elavon-details').show();
      }
      console.log($(this).val()); // or, use `this.value`
    });
  });
</script>