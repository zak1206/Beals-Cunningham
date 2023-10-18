<?php
if (isset($_REQUEST["disCode"])) {
 $disCode = $_REQUEST["disCode"];
 include('../../inc/harness.php');
 $data->query("UPDATE shop_discounts SET active = 'false' WHERE dis_code='$disCode'") or die($data->error);
 $message = "Coupon Deleted";
 echo "<script type='text/javascript'>alert('$message');
 window.location.href = 'list-coupons.php';
 </script>";
}
?>

<?php
include('../../inc/harness.php');
// echo "Hello";
$couponName = $_POST["couponName"];
$couponCode = $_POST["couponCode"];
$percentageOff = $_POST["percentageOff"];
$expirationDate = $_POST["expirationDate"];
$status = $_POST["couponStatus"];

if (isset($_POST['submit'])) {
 //  echo "Hello Again";
 $data->query("UPDATE shop_discounts SET coupon_name = '" . $data->real_escape_string($couponName) . "', dis_code = '" . $data->real_escape_string($couponCode) . "', percentage_off = '" . $data->real_escape_string($percentageOff) . "', date_expire = '" . $data->real_escape_string($expirationDate) . "', status = '" . $data->real_escape_string($status) . "', active = 'true' WHERE dis_code='$disCode'") or die($data->error);
 $message = "Coupon Updated";
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
   <h4 class="title">Coupons</h4>
   <div style="margin-top: 20px; margin-bottom:20px;">
    <a onclick="location.href='create-coupons.php'" class="btn btn-warning">
     <span>Create Coupon</span>
    </a>
   </div>
  </div>
  <div class="content table-responsive table-full-width">
   <table class="table table-bordered">
    <thead>
     <tr>
      <th style="font-weight: bold;background: #5d5d5d;color: #fff; border-right:solid thin #efefef; width: 10%">No.</th>
      <th style="font-weight: bold;background: #5d5d5d;color: #fff; border-right:solid thin #efefef; width: 20%">Coupon Name</th>
      <th style="font-weight: bold;background: #5d5d5d;color: #fff; border-right:solid thin #efefef; width: 20%">Discount Code</th>
      <th style="font-weight: bold;background: #5d5d5d;color: #fff; border-right:solid thin #efefef; width: 20%">Percentage Off</th>
      <th style="font-weight: bold;background: #5d5d5d;color: #fff; border-right:solid thin #efefef; width: 20%">Expiry Date</th>
      <th style="font-weight: bold;background: #5d5d5d;color: #fff; border-right:solid thin #efefef; width: 10%">Status</th>
      <th style="font-weight: bold;background: #5d5d5d;color: #fff; border-right:solid thin #efefef; width: 10%">Edit</th>
      <th style="font-weight: bold;background: #5d5d5d;color: #fff; border-right:solid thin #efefef; width: 10%">Delete</th>
     </tr>
    </thead>
    <tbody>
     <?php
     // $offers = $site->getOffers();
     include('../../inc/harness.php');
     $a = $data->query("SELECT * FROM shop_discounts WHERE active = 'true' ORDER BY id ASC");
     $i = 1;
     foreach ($a as $b) {
      $editCon = '<a href="edit-coupon.php?disCode=' . $b["dis_code"] . '" style="" class="btn btn-xs btn-success">Edit <i class="fa fa-pencil" aria-hidden="true"></i></a>';
      $deleteCon = '<a href="list-coupons.php?disCode=' . $b["dis_code"] . '" onclick="if (confirm(\'Delete selected item?\')){return true;}else{event.stopPropagation(); event.preventDefault();};" style="" class="btn btn-xs btn-danger">Delete <i class="fa fa-trash" aria-hidden="true"></i></a>';
      if ($b["status"] == "new") {
       $couponStatus = '<p style="text-align:center"><span class="badge badge-success" style="font-size:16px;">' . $b["status"] . '</span></p>';
      } elseif ($b["status"] == "used") {
       $couponStatus = '<p style="text-align:center"><span class="badge badge-danger" style="font-size:16px;">' . $b["status"] . '</span></p>';
      }

      echo '
        <tr>
        <th scope="row" style="width: 10%"><p style="color: #333">' . $i . '</p></th>
        <td style="width: 20%"><p style="color: #333">' . $b["coupon_name"] . '</p></td>
        <td style="width: 20%"><p style="color: #333">' . $b["dis_code"] . '</p></td>
        <td style="width: 20%"><p style="color: #333">' . $b["percentage_off"] . '</p></td>
        <td style="width: 20%"><p style="color: #333">' . $b["date_expire"] . '</p></td>
        <td style="width: 20%">' . $couponStatus . '</td>
        <td style="text-align:right;width: 10%">' . $editCon . '</td>
        <td style="text-align:right;width: 10%">' . $deleteCon . '</td>
        </tr>';
      $i++;
     }
     ?>
    </tbody>
   </table>
  </div>


 </div>
 <!-- end container -->
</div>
<!-- end content -->

<?php
include('e-commerce-footer.php');
?>

<script>
 var resizefunc = [];
</script>

<!-- Plugins  -->
<script src="../../assets/js/jquery.min.js"></script>
<script src="../../assets/js/popper.min.js"></script><!-- Popper for Bootstrap -->
<script src="../../assets/js/bootstrap.min.js"></script>
<script src="../../assets/js/detect.js"></script>
<script src="../../assets/js/fastclick.js"></script>
<script src="../../assets/js/jquery.slimscroll.js"></script>
<script src="../../assets/js/jquery.blockUI.js"></script>
<script src="../../assets/js/waves.js"></script>
<script src="../../assets/js/wow.min.js"></script>
<script src="../../assets/js/jquery.nicescroll.js"></script>
<script src="../../assets/js/jquery.scrollTo.min.js"></script>
<script src="../../plugins/switchery/switchery.min.js"></script>
<script src="../../plugins/sweet-alert/sweetalert2.min.js"></script>
<script src="../../assets/pages/jquery.sweet-alert.init.js"></script>

<!-- Required datatable js -->
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables/dataTables.bootstrap4.min.js"></script>
<!-- Buttons examples -->

<!-- Key Tables -->
<script src="../../plugins/datatables/dataTables.keyTable.min.js"></script>

<!-- Responsive examples -->
<script src="../../plugins/datatables/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables/responsive.bootstrap4.min.js"></script>

<!-- Selection table -->
<script src="../../plugins/datatables/dataTables.select.min.js"></script>


<script src="../../assets/js/pace.min.js"></script>
<!-- Custom main Js -->
<script src="../../assets/js/jquery.core.js"></script>
<script src="../../assets/js/jquery.app.js"></script>

<script>
 $(document).ready(function() {
  var tables = $('.table').DataTable();

  tables.on('search.dt', function() {
   $(".forcecheck").on('click', function() {
    var pagename = $(this).data('pagename');
    var curruser = $(this).data('curruser');
    var checkDate = $(this).data('checkdate');
    var pageid = $(this).data('pageids');
    swal({
     title: 'Are you sure you want to force check in?',
     text: "Changes made by others may be overwritten if you do this.",
     type: 'warning',
     showCancelButton: true,
     confirmButtonText: 'Yes, check in!',
     cancelButtonText: 'No, cancel!',
     confirmButtonClass: 'btn btn-success mt-2',
     cancelButtonClass: 'btn btn-danger ml-2 mt-2',
     buttonsStyling: false
    }).then(function() {

     $.ajax({
      url: 'inc/asyncCalls.php?action=runforce&pageid=' + pageid,
      success: function(data) {
       window.location = 'edit-page.php?page=' + pageid
      }
     })


    }, function(dismiss) {
     // dismiss can be 'cancel', 'overlay',
     // 'close', and 'timer'
     if (dismiss === 'cancel') {
      swal({
       title: 'Cancelled',
       text: "Ok we will keep it checked out :)",
       type: 'error',
       confirmButtonClass: 'btn btn-confirm mt-2'
      })
     }
    })

   })
  });

  $(".forcecheck").on('click', function() {
   var pagename = $(this).data('pagename');
   var curruser = $(this).data('curruser');
   var checkDate = $(this).data('checkdate');
   var pageid = $(this).data('pageids');
   swal({
    title: 'Are you sure you want to force check in?',
    text: "Changes made by others may be overwritten if you do this.",
    type: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, check in!',
    cancelButtonText: 'No, cancel!',
    confirmButtonClass: 'btn btn-success mt-2',
    cancelButtonClass: 'btn btn-danger ml-2 mt-2',
    buttonsStyling: false
   }).then(function() {

    $.ajax({
     url: 'inc/asyncCalls.php?action=runforce&pageid=' + pageid,
     success: function(data) {
      window.location = 'edit-page.php?page=' + pageid
     }
    })


   }, function(dismiss) {
    // dismiss can be 'cancel', 'overlay',
    // 'close', and 'timer'
    if (dismiss === 'cancel') {
     swal({
      title: 'Cancelled',
      text: "Ok we will keep it checked out :)",
      type: 'error',
      confirmButtonClass: 'btn btn-confirm mt-2'
     })
    }
   })

  })
 });

 function createPage() {
  alert('sdfsdf');
  $("#pagecreate").modal();
  setForm();
 }

 function setForm() {
  $("#createpage").submit(function(e) {

   e.stopImmediatePropagation(); // avoid to execute the actual submit of the form.

   var form = $(this);
   var url = 'inc/asyncCalls.php?action=createpage';

   $.ajax({
    type: "POST",
    url: url,
    data: form.serialize(), // serializes the form's elements.
    success: function(data) {

     alert(data);
     window.location.replace("edit-page.php?page=" + data);
    }
   });


  });
 }

 $(function() {
  $(".paginate_button").on('click', function() {
   $(".forcecheck").on('click', function() {
    var pagename = $(this).data('pagename');
    var curruser = $(this).data('curruser');
    var checkDate = $(this).data('checkdate');
    var pageid = $(this).data('pageids');
    swal({
     title: 'Are you sure you want to force check in?',
     text: "Changes made by others may be overwritten if you do this.",
     type: 'warning',
     showCancelButton: true,
     confirmButtonText: 'Yes, check in!',
     cancelButtonText: 'No, cancel!',
     confirmButtonClass: 'btn btn-success mt-2',
     cancelButtonClass: 'btn btn-danger ml-2 mt-2',
     buttonsStyling: false
    }).then(function() {

     $.ajax({
      url: 'inc/asyncCalls.php?action=runforce&pageid=' + pageid,
      success: function(data) {
       window.location = 'edit-page.php?page=' + pageid
      }
     })


    }, function(dismiss) {
     // dismiss can be 'cancel', 'overlay',
     // 'close', and 'timer'
     if (dismiss === 'cancel') {
      swal({
       title: 'Cancelled',
       text: "Ok we will keep it checked out :)",
       type: 'error',
       confirmButtonClass: 'btn btn-confirm mt-2'
      })
     }
    })

   })
  })

 })
</script>


</body>

</html>