<?php
include('../../inc/harness.php');
// echo "Hello";
$parent = $_POST["parent"];
$child = $_POST["child"];
$title = $_POST["title"];
$description = $_POST["description"];
$msrp = $_POST["msrp"];
$price = $_POST["price"];
$img = $_POST["cat_img"];
$features = $_POST["features"];
$weight = $_POST["weight"];
$dimensions = $_POST["dimensions"];
$flatRate = $_POST["flatRatePrice"];
$shippingMethod = $_POST["shippingMethod"];

if (isset($_POST['submit'])) {
  //  echo "Hello Again";
  $data->query("INSERT INTO custom_equipment SET parent_cat = '$parent', cat_one = '$child', title = '$title', description = '$description', eq_image = '\[\"$img\"\]', msrp = '$msrp' , sales_price = '$price', features = '$features', weight = '$weight', ship_type = '$shippingMethod', dimentions = '$dimensions', flat_rate_shiping = '$flatRate',active= 'true' ") or die($data->error);
  $message = "Custom Equipments Data Entry Completed";
  echo "<script type='text/javascript'>alert('$message');</script>";
}


?>

<!-- Modal -->
<?php
include('e-commerce-header.php');
?>
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

      </div>
    </div>
  </div>
</div>

<div class="row" style="margin:0;">
  <div class="col-md-12">
    <div class="header">
      <h2 class="title">Create New Product</h2>
      <p class="category">Use this to create custom product.</p>
    </div>

    <!-- DIV STARTS=================================== -->
    <div class="content table-responsive table-full-width">
      <form class="validforms" id="page-layout" name="page-layout" style="padding: 20px" method="post" action="">
        <div class="product-details">
          <input class="form-control" type="hidden" name="line_type" id="line_type" value="custom">
          <h3 class="title" style="margin-bottom: 20px;">Product Details</h3>
          <div class="row">
            <div class="col-md-6">
              <label for="parent">Enter Parent Category</label><small>(Choose from the existing dropdown or add new)</small></br>
              <?php
              include('../../inc/harness.php');
              echo '<input class="form-control" list="parent1" id="parent" name="parent">
          <datalist id="parent1">';
              $result = $data->query("SELECT DISTINCT page_name FROM custom_pages WHERE active = 'true'");
              foreach ($result as $row) {
                echo  '<option value="' . $row["page_name"] . '"/>'; // Format for adding options
              }
              echo "</datalist>";
              ?>
              </br>
            </div>
            <div class="col-md-6">
              <label>Child Category</label><small>(Choose from the existing dropdown or add new)</small></br>
              <?php
              include('../../inc/harness.php');
              $catImg = $_POST["cat_img"];
              echo '<input class="form-control" list="child1" id="child" name="child">
          <datalist id="child1">';
              $result1 = $data->query("SELECT DISTINCT page_name FROM custom_pages WHERE active = 'true'");
              foreach ($result1 as $row) {
                echo  '<option value="' . $row["page_name"] . '"/>'; // Format for adding options
              }
              echo "</datalist>";
              ?>
              </br>
            </div>
            <div class="col-md-6">
              <label>Title</label><br>
              <input class="form-control" type="text" id="title" name="title" value="" required=""><br>
            </div>
            <div class="col-md-6">
              <label>Category Image</label><small>(Ex: hello.png. Select an image and remove url path)</small><br>
              <div class="input-group mb-3">
                <input type="text" class="form-control" name="cat_img" id="cat_img" placeholder="No Image" aria-label="Category Image" value="<?php echo $catImg; ?>">
                <div class="input-group-append">
                  <button class="btn btn-success img-browser" data-setter="cat_img" type="button">Browse Images</button>
                </div>
              </div>
            </div>
          </div>
          <br>
          <hr>
          <br>
          <h3 class="title" style="margin-bottom: 20px;">Pricing and Shipping</h3>
          <div class="row">
            <div class="col-md-4">
              <label>MSRP</label><small>(Integers Only)</small><br>
              <input class="form-control" type="text" id="msrp" name="msrp" value="" required=""><br>
            </div>
            <div class="col-md-4">
              <label>Sales Price</label><small>(Integers Only)</small><br>
              <input class="form-control" type="text" id="price" name="price" value="" required="">
            </div>
            <div class="col-md-4">
              <label>Flat Rate Shipping Price</label><small>(Integers Only)</small><br>
              <input class="form-control" type="text" id="flatRatePrice" name="flatRatePrice" value="" required="">
            </div>
            <div class="col-md-4">
              <label>Weight</label><small>(Integers Only)</small><br>
              <input class="form-control" type="text" id="weight" name="weight" value="" required="">
            </div>
            <div class="col-md-4">
              <label>Dimensions</label><small>(Example: 10X2X7)</small><br>
              <input class="form-control" type="text" id="dimensions" name="dimensions" value="" required="">
            </div>
            <div class="col-md-4">
              <!-- RADIO BUTTON SHIPPING START======================== -->
              <div>
                <label>Shipping Method</label><br>
                <input type="radio" name="shippingMethod" value="Parcel">
                <label class="form-check-label" for="shippingMethod">
                  Parcel
                </label><br>
                <input type="radio" name="shippingMethod" value="Pick up">
                <label class="form-check-label" for="shippingMethod">
                  Pick up
                </label>
              </div>
              <!-- RADIO BUTTON SHIPPING END========================== -->
            </div>
          </div>
          <br>
          <hr>
          <br>
          <h3 class="title" style="margin-bottom: 20px;">Summary and Description</h3>
          <div class="row">
            <div class="col-md-12">
              <label>Summary</label><small>(Character Limit: 300)</small><br>
              <textarea class="summernotes" id="description" name="description"></textarea>
              <br>
            </div>
            <div class="col-md-12">
              <label>Description</label><br>
              <br><textarea class="summernotes" id="features" name="features"></textarea><br><br>
            </div>
          </div>
        </div>
        <button class="btn btn-success" type="submit" id="submit" name="submit">Save Page</button>
      </form>
    </div>


    <!-- DIV ENDS===================================== -->


  </div>

</div>

<?php
include('e-commerce-footer.php');
?>