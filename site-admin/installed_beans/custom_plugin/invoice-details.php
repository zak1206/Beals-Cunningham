<?php
include('e-commerce-header.php');
if (isset($_POST["invoiceSubmit"])) {
 $img = $_POST["cat_img"];
 $invoiceText = $_POST["invoice-text"];
 include('../../inc/harness.php');
 $a = $data->query("UPDATE invoice_settings SET invoice_img = '$img', invoice_sales_message = '" . $data->real_escape_string($invoiceText) . "' WHERE id = 1") or die($data->error);
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
   <h4><b>Add Invoice Note</b></h4>
   <label>Page Details</label><br>
   <textarea class="summernote" id="invoice-text" name="invoice-text"><?php echo $b["invoice_sales_message"]; ?></textarea><br><br>
   <button class="btn btn-success" type="submit" name="invoiceSubmit">Save Page</button>
  </form>
 </div>

</div>
<script>
 $(function() {
  $(".img-browser").on('click', function() {
   var itemsbefor = $(this).data('setter');
   $("#myModalAS .modal-title").html('Select an Image For Link');
   $("#myModalAS .modal-body").html('<iframe id="themedia" style="width: 100%; height: 450px; border: none" src="../../media_manager.php?typeset=simple&returntarget=' + itemsbefor + '"></iframe>');
   $(".modal-dialog").css('width', '869px');
   $("#myModalAS").modal();
  })

  $('#page_desc').keyup(function() {
   var left = 300 - $(this).val().length;
   if (left < 0) {
    left = 0;
   }
   $('.counter-text').text('Characters left: ' + left);
  });

  tinymce.init({
   selector: ".summernote",
   skin: "caffiene",
   plugins: [
    "advlist autolink link image lists charmap print preview hr anchor pagebreak",
    "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
    "table contextmenu directionality emoticons paste textcolor codemirror"
   ],
   content_css: '../css/bootstrap.css, assets/css/helpers.css',

   contextmenu: "link image | myitem",
   setup: function(editor) {
    editor.addMenuItem('myitem', {
     text: 'Open Content',
     onclick: function() {
      var beanName = editor.selection.getContent();

      $.ajax({
       url: 'asyncData,php?action=minimod&beanid=' + beanName,
       success: function(data) {
        $("#myModal .modal-body").html(data);
        $("#myModal").modal();
        $(".modal-dialog").css('width', '70%');

       }
      })
     }
    });
   },
   file_browser_callback: function(field_name, url, type, win) {
    setplacer(field_name, url);
   },
   image_description: true,
   verify_html: false,
   toolbar1: "styleselect  bold italic underline alignleft aligncenter alignright alignjustify  bullist numlist outdent indent link unlink responsivefilemanager image media fontsizeselect forecolor backcolor code",
   menubar: false,
   image_advtab: true,
   height: '400',
   forced_root_block: false,
   image_dimensions: false,
   image_class_list: [{
     title: 'Responsive',
     value: 'img-responsive'
    },
    {
     title: 'Image 100% Width',
     value: 'img-full-width'
    }
   ],
   codemirror: {
    indentOnInit: true,
    path: 'codemirror-4.8',
    config: {
     lineNumbers: true,
     mode: "htmlmixed",
     autoCloseTags: true,

    }
   },
  });
 })


 function setImgDat(inputTarget, img, alttext) {
  //alert(inputTarget);
  // $('input[name="'+inputTarget+'"]').val(img);
  // $('input[name="alt"]').val(alttext);
  // $('input[name="'+inputTarget+'"]').focus();
  // $('input[name="alt"]').focus();
  var imgClean = img.replace("../../../../", "../");
  $('#' + inputTarget).val(imgClean);
  imgSucc();
 }

 function imgSucc() {
  $("#myModalAS").modal('hide');
 }
</script>

</body>

</html>