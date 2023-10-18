<?php
include('../../inc/harness.php');
// echo "Hello";
$couponName = $_POST["couponName"];
$couponCode = $_POST["couponCode"];
$percentageOff = $_POST["percentageOff"];
$expirationDate = $_POST["expirationDate"];
$status = "new";

if (isset($_POST['submit'])) {
 //  echo "Hello Again";
 $data->query("INSERT INTO shop_discounts SET coupon_name = '" . $data->real_escape_string($couponName) . "', dis_code = '" . $data->real_escape_string($couponCode) . "', percentage_off = '" . $data->real_escape_string($percentageOff) . "', date_expire = '" . $data->real_escape_string($expirationDate) . "', status = 'new', active = 'true'") or die($data->error);
 $message = "Coupon Creation Completed";
 echo "<script type='text/javascript'>alert('$message');
 window.location.href = 'list-coupons.php';
 </script>";
}

?>

<?php
include('e-commerce-header.php');
?>

<div class="row" style="margin:0;">
 <div class="col-md-12">
  <div class="header">
   <h4 class="title">Create Coupon</h4>
   <p class="category">Create a new coupon below.</p>
  </div>
  <div class="content table-responsive table-full-width">
   <!-- RADIO BUTTON Shipping START======================== -->
   <form name="taxRatesForm" method="post" action="">
    <div>
     <label for="couponName">Coupon Name</label>
     <input class="form-control" id="couponName" name="couponName" value="">
    </div>
    <div>
     <label for="couponCode">Coupon Code</label>
     <input class="form-control" id="couponCode" name="couponCode" value="">
    </div>
    <div>
     <label for="percentageOff">Percentage Off <small>(Integers Only)</small></label>
     <input class="form-control" id="percentageOff" name="percentageOff" value="">
    </div>
    <div>
     <label for="expirationDate">Expiration Date <small>(Ex: 10/22/2021)</small></label>
     <input class="form-control" id="expirationDate" name="expirationDate" value="">
    </div>

    <button class="btn btn-success" type="submit" id="submit" name="submit" style="margin-top: 10px;">Save</button>
   </form>
   <!-- RADIO BUTTON Shipping END========================== -->
  </div>
 </div>
</div>

<?php
include('e-commerce-footer.php');
?>