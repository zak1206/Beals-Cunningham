<?php
include('e-commerce-header.php');
?>

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="max-width: 800px;">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body" id="print-div-id">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" onclick="printDiv();">Print</button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    <script>
      function printDiv() {
        let printContents, popupWin;
        printContents = document.getElementById('print-div-id').innerHTML;
        popupWin = window.open('', '_blank', 'top=0,left=0,height=100%,width=auto');
        popupWin.document.open();
        popupWin.document.write(`
          <html>
            <head>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
            </head>
            <style>
              body{
              margin: 80px;
              }
              @media print{
  .noprint{
    visibility: hidden;
  }
}
            </style>
        <body onload="window.print();window.close()">${printContents}</body>
          </html>`);
        popupWin.document.close();
      }
    </script>
  </div>
</div>

<div class="row" style="margin:0;">
  <div class="col-md-12">
    <div class="page-title-box">
      <ol class="breadcrumb float-right">
        <li class="breadcrumb-item active">Site Orders</li>
      </ol>
      <p class="text-muted font-14 m-b-30">
        List of all site orders.
      </p>
      <hr>
      <?php
      $ords = $site->getOrders();
      echo '<table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th style="font-weight: bold;background: #5d5d5d;color: #fff; border-right:solid thin #efefef">Id</th>
        <th style="font-weight: bold;background: #5d5d5d;color: #fff; border-right:solid thin #efefef">Name</th>
        <th style="font-weight: bold;background: #5d5d5d;color: #fff; border-right:solid thin #efefef">Email</th>
        <th style="font-weight: bold;background: #5d5d5d;color: #fff; border-right:solid thin #efefef;">Purchase Price</th>
        <th style="font-weight: bold;background: #5d5d5d;color: #fff; border-right:solid thin #efefef;">Purchase Date</th>
        <th style="font-weight: bold;background: #5d5d5d;color: #fff; border-right:solid thin #efefef;">Purchase #</th>
        <th style="font-weight: bold;background: #5d5d5d;color: #fff; border-right:solid thin #efefef;">Status</th>
        <th style="font-weight: bold;background: #5d5d5d;color: #fff; border-right:solid thin #efefef; text-align: right">Action</th>
      </tr>
    </thead>
    <tbody>';


      for ($i = 0; $i < count($ords); $i++) {
        if ($ords[$i]["approved"] == 'true') {
          $approved = 'Approved';
        } else {
          $approved = 'Not Approved';
        }
        echo '<tr class="revlin' . $ords[$i]["id"] . '"><td>' . ($i + 1) . '</td><td>' . $ords[$i]["first_name"] . ' ' . $ords[$i]["last_name"] . '</td><td>' . $ords[$i]["email"] . '</td><td>$' . $ords[$i]["purchase_price"] . '</td><td>' . date('m/d/Y h:ia', $ords[$i]["date_sub"]) . '</td><td>' . $ords[$i]["purchase_num"] . '</td><td class="revstat' . $ords[$i]["id"] . '">' . $ords[$i]["status"] . '</td><td style="text-align: right"><button class="btn btn-success btn-sm read-order" data-id="' . $ords[$i]["id"] . '">Review Order</button></td></tr>';
      }

      echo '</tbody>
  </table>';
      ?>
      <div class="clearfix"></div>
    </div>



  </div>
  <!-- end container -->
</div>
<!-- end content -->
<script>
  $(function() {
    $(".read-order").on('click', function() {
      var eqid = $(this).data('id');
      $.ajax({
        url: 'async.php?action=openorder&id=' + eqid,
        success: function(data) {
          $("#myModal .modal-body").html(data);
          $("#myModal .modal-header").html('Review Order');
          $("#myModal").modal();
          $(".delrev").on('click', function() {
            var ids = $(this).data('id');
          })

          $(".delrev").on('click', function() {
            var ids = $(this).data('id');
            $(".review-message").html('Are you sure you want to delete this order?<br><br><button class="btn btn-default btn-sm btn-fill complete-del-order" data-id="' + ids + '">Yes</button> <button class="btn btn-success btn-sm btn-fill cansdel">Cancel</button>');
            $(".review-message").show();
            $(".cansdel").on('click', function() {
              $(".review-message").hide();
            })

            $(".complete-del-order").on('click', function() {

              var ids = $(this).data('id');
              $.ajax({
                url: '../../inc/asyncCalls.php?action=completeorddel&id=' + ids,
                success: function(msg) {
                  $('#myModal').modal('toggle');
                  $(".revlin" + ids).remove();
                }
              })
            })
          })

          $(".apprvrv").on('click', function() {

            var ids = $(this).data('id');
            $.ajax({
              url: '../../inc/asyncCalls.php?action=approverev&id=' + ids,
              success: function(msg) {
                $(".review-message").html('Processed! - You may now close this window.');
                $(".review-message").show();
                $(".revstat" + ids).html('Processed');
              }
            })
          })
        }
      })
    })
  })
</script>
<?php
include('e-commerce-footer.php');
?>