<?php
include('e-commerce-header.php');
if (isset($_POST["invoiceSubmit"])) {
  // echo "submitted";
 $img = $_POST["cat_img"];
//  echo $img;
 $invoiceText = $_POST["invoice-text"];
 $invoice_subject = $_POST["invoice_subject"];
 $invoice_headline = $_POST["invoice_headline"];
 include('../../inc/harness.php');
 $a = $data->query("UPDATE invoice_settings SET invoice_img = '$img', invoice_sales_message = '" . $data->real_escape_string($invoiceText) . "', invoice_subject = '" . $data->real_escape_string($invoice_subject) . "', invoice_headline = '" . $data->real_escape_string($invoice_headline) . "' WHERE id = 1") or die($data->error);
 echo '<div class="alert alert-success" role="alert">
 Invoice Details Saved Successfully.
</div>';
}
?>
<!-- Modal -->
<div id="myModal" class="modal" tabindex="-1" role="dialog">
 <div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
   <div class="modal-header">
    <h5 class="modal-title">Modal title</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
     <span aria-hidden="true">&times;</span>
    </button>
   </div>
   <div class="modal-body">
    <p>Modal body text goes here.</p>
   </div>
   <div class="modal-footer">

   </div>
  </div>
 </div>
</div>

<div id="myModalAS" class="modal" tabindex="-1" role="dialog">
 <div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
   <div class="modal-header">
    <h5 class="modal-title">Modal title</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
     <span aria-hidden="true">&times;</span>
    </button>
   </div>
   <div class="modal-body">
    <p>Modal body text goes here.</p>
   </div>
   <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary">Save changes</button>
   </div>
  </div>
 </div>
</div>
<div class="row" style="margin:0;">

 <div class="col-md-12">
  <h1>Invoice Details</h1>
  <form class="validforms" id="invoice-details" name="invoice-details" style="padding: 20px" method="post" action="">
   <h4><b>Add Invoice Logo</b></h4>
   <div class="input-group mb-3">
    <?php
    include('../../inc/harness.php');
    $a = $data->query("SELECT * FROM invoice_settings WHERE id = 1");
    $b = $a->fetch_array();
    ?>
    <input type="text" class="form-control" name="cat_img" id="cat_img" placeholder="No Image" aria-label="Category Image" value="<?php echo $b["invoice_img"]; ?>">
    <div class="input-group-append">
     <button class="btn btn-success img-browser" data-setter="cat_img" type="button">Browse Images</button>
    </div>
   </div>
   <div>
   <h4><b>Add Invoice Email Subject</b></h4>
   <input type="text" class="form-control" name="invoice_subject" id="invoice_subject" placeholder="Email Subject" value="<?php echo $b["invoice_subject"]; ?>">
   </div>
   <div>
   <h4><b>Add Invoice Headline</b></h4>
   <input type="text" class="form-control" name="invoice_headline" id="invoice_headline" placeholder="Invoice Headline" value="<?php echo $b["invoice_headline"]; ?>">
   </div>
   <h4><b>Add Invoice Note</b></h4>
   <label>Page Details</label><br>
   <textarea class="summernote form-control" id="invoice-text" name="invoice-text"><?php echo $b["invoice_sales_message"]; ?></textarea><br><br>
   <button class="btn btn-success" type="submit" name="invoiceSubmit">Save Page</button>
  </form>
  </div>
  </div>
  <?php
  include('e-commerce-footer.php');
  ?>