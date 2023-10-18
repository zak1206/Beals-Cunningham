<!--Footer section-->
<div class="container-fluid" id="footer" style="background-color: #D2D3D4;">
 <div class="row">
  <div class="col-md-6" align="center">
   <img class="img-responsive" src="../img/footer-map.png" alt="legacy locations map" style="width: 300px;">
  </div>
  <div class="col-md-6">
   <div class="row">
    <div class="col-md-3">
     <ul class="footer-link-list">
      <a href="About-us">About</a>
      <li><a href="Our-Team">Our Team</a></li>
      <li><a href="Careers">Careers</a></li>
      <li><a href="Contact">Contact</a></li>
      <li><a href="Donation-Request">Donation Request</a></li>
      <li><a href="scholarship-application">Sponsorship Application</a></li>
     </ul>
     <br />
     <ul class="footer-link-list"><a href="Locations">Locations</a></ul>
    </div>
    <div class="col-md-3">
     <ul class="footer-link-list">Equipment
      <li><a href="">New John Deere Equipment</a></li>
      <li><a href="Used-Equipment">Used Equipment</a></li>
      <li><a href="parts-stihl">New Stihl</a></li>
      <li><a href="">New Honda</a></li>
      <li><a href="dealer-transfer-request">Dealer Transfer Request</a></li>
     </ul>
     <br />
     <ul class="footer-link-list"><a href="Specials">Specials</a>
      <!-- <li><a href="">Service Specials</a></li>
      <li><a href="">Current Specials</a></li>
      <li><a href="">Deere Specials</a></li> -->
     </ul>
    </div>
    <div class="col-md-3">
     <ul class="footer-link-list"><a href="Parts">Parts</a>
      <li><a href="Parts-Specials">Parts-Specials</a></li>
      <li><a href="online-parts">Order Parts</a></li>
      <li><a href="">Find a Store</a></li>
      <li><a href="">View Catalog</a></li>
     </ul>
     <br />
     <ul class="footer-link-list"><a href="Service">Service</a>
      <li><a href="Request-Service">Request Service</a></li>
      <li><a href="Service-Specials">Service Specials</a></li>
      <li><a href="Service-Tips-Videos">Service Tips & Videos</a></li>
     </ul>
    </div>
    <div class="col-md-3">
     <ul class="footer-link-list"><a href="Get-A-Quote">Get a Quote</a></ul>
     <br />
     <ul class="footer-link-list"><a href="Precision-Ag">Precision Ag</a>
      <li><a href="equipment-optimization">Equipment Optimization</a></li>
      <li><a href="land-forming">Land Forming</a></li>
      <li><a href="seed-meter-test-stand">Seed Meter Test Stand</a></li>
      <li><a href="yieldpro">YieldPRO</a></li>
     </ul>
     <br />
    </div>
   </div>
  </div>
 </div>
</div>
<div class="row" style="background: black; position: fixed; bottom: 0; margin-top: 30px; width: 100vw;">
 <div class="col-md-12">
  <p class="text-center" style="margin: 0 auto; font-size: .75rem; color:#fff;">© COPYRIGHT 2020 LEGACY EQUIPMENT - ALL RIGHTS RESERVED| <a href="Privacy-Policy">Privacy Policy</a> | Powered By<img class="lozad" data-src="img/ST-05-24-19-Web-Site-Redesign-EQHarvestLogo.png" alt="EQHarvest logo" src="img/ST-05-24-19-Web-Site-Redesign-EQHarvestLogo.png" data-loaded="true"></p>
 </div>
</div>

<!--BELOW ARE SYSTEM REQUIREMENTS AND SHOULD NOT BE ALTERED -->
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js' type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.0/js/ion.rangeSlider.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/lozad/dist/lozad.min.js"></script>
<script src="js/list.min.js"></script>
<script src="js/site.js"></script>



<?php
///CORE CAFFEINE ELEMENTS DO NOT REMOVE THIS///
$dependenciesjs = $info->loadBeanDepsjs();
for ($i = 0; $i < count($dependenciesjs); $i++) {
 echo '<script src="' . $dependenciesjs[$i]["file"] . '"></script>' . PHP_EOL;
}

$depJs = $dependants["js"];

foreach ($depJs as $jsKey) {
 echo '<script src="' . $jsKey . '"></script>' . PHP_EOL;
}
?>

<?php


///CORE CAFFEINE ELEMENTS DO NOT REMOVE THIS///
if ($pageDetails[0]["page_js"] == '') {
 $pageScripts = 'js/page_js/' . $page . '_js_events.js';
 if (file_exists($pageScripts)) {
  echo '<script src="' . $pageScripts . '"></script>';
 }
} else {
 $pageScripts = 'js/page_js/' . $pageDetails[0]["page_js"] . '';
 echo '<script src="' . $pageScripts . '"></script>';
}




?>



<script type="text/javascript">
 (function() {
  var css = document.createElement('link');
  css.href = '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css';
  css.rel = 'stylesheet';
  css.type = 'text/css';
  document.getElementsByTagName('head')[0].appendChild(css);
 })();

 /* Set the width of the side navigation to 250px and the left margin of the page content to 250px */
 function openNav() {
  if (window.innerWidth > 575) {
   document.getElementById("mySidenav").style.width = "450px";
   document.getElementById("main").style.marginLeft = "450px";
   document.getElementById("close-sideNav").style.width = "22px";
   document.getElementById("close-nav-hide-img").style.cursor = "pointer";
  } else {
   document.getElementById("mySidenav").style.width = "100%";

  }
 }

 /* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
 function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  document.getElementById("close-sideNav").style.width = "0";
  document.getElementById("main").style.marginLeft = "0";
  document.getElementById("close-nav-hide-img").style.cursor = "default";
 }

 //close quick equipment search start
 // var mySideNav = document.getElementById('mySidenav');
 // var openSideNav = document.getElementById('open-sideNav');
 // var closeSideNav = document.getElementById('close-sideNav');

 // window.onclick = function(event) {
 //     console.log("close side nav");
 //     if ((event.target !== mySidenav && event.target !== openSideNav) || (event.target == closeSideNav)) {
 //         //element clicked wasn't the div; hide the div
 //         mySideNav.style.width = "0";
 //         document.getElementById("main").style.marginLeft = "0";
 //         document.getElementById("close-sideNav").style.width = "0";
 //     }
 // };

 $(document).click(function() {
  var container = $("#mySidenav");
  var main = $("#main");
  var closeSideNav = $("#close-sideNav");
  var openSideNav = $("#openSideNav");
  var closeNavHideImg = $("#close-nav-hide-img");

  if (!container.is(event.target) &&
   !container.has(event.target).length && !openSideNav.is(event.target)) {

   if (closeSideNav.width() == 22) {
    closeSideNav.css('width', '0');
    closeNavHideImg.css('display', 'none');
    openSideNav.css('width', '0');
    main.css('margin-left', '0');
    container.css('width', '0');
   }
   // container.css('width', '0');
  }
 });
 //close quick equipment search end
 //Quick Search for used equipments Start ===========================
 $(function() {
  $("#usedcatsel").on('change', function() {

   var selCat = $(this).val();
   var formaction = $('#quickserc').attr('action');


   if (formaction.indexOf('?') > -1) {
    var url = '&categories=' + encodeURIComponent(selCat + '~');
   } else {
    var url = '?categories=' + encodeURIComponent(selCat + '~');
   }

   $('#quickserc').attr('action', formaction + url);


   var prifrm = $("#prifrm").val();
   var prito = $("#prito").val();
   var yrfrm = $("#yrfrm").val();
   var yrto = $("#yrto").val();
   var hrfrm = $("#hrfrm").val();
   var hrto = $("#hrto").val();
   $.ajax({
    url: 'inc/sideprocess.php?action=processcats&selcat=' + encodeURIComponent(selCat) + '&prifrm=' + prifrm + '&prito=' + prito + '&yrfrm=' + yrfrm + '&yrto=' + yrto + '&hrfrm=' + hrfrm + '&hrto=' + hrto,
    cache: false,
    success: function(data) {
     console.log(data);
     $("#usedmansel").html(data);
    }
   })

  })

  $("#usedmansel").on('change', function() {

   var selman = $(this).val();
   var selCat = $("#usedcatsel").val();

   var formaction = $('#quickserc').attr('action');


   if (formaction.indexOf('?') > -1) {
    var url = '&manufacturer=' + encodeURIComponent(selman + '~');
   } else {
    var url = '?manufacturer=' + encodeURIComponent(selman + '~');
   }

   $('#quickserc').attr('action', formaction + url);

   var prifrm = $("#prifrm").val();
   var prito = $("#prito").val();
   var yrfrm = $("#yrfrm").val();
   var yrto = $("#yrto").val();
   var hrfrm = $("#hrfrm").val();
   var hrto = $("#hrto").val();
   $.ajax({
    url: 'inc/sideprocess.php?action=processmans&selcat=' + encodeURIComponent(selCat) + '&selman=' + encodeURIComponent(selman) + '&prifrm=' + prifrm + '&prito=' + prito + '&yrfrm=' + yrfrm + '&yrto=' + yrto + '&hrfrm=' + hrfrm + '&hrto=' + hrto,
    cache: false,
    success: function(data) {
     $("#usedmodsel").html(data);
    }
   })

  })



  $(".js-range-slider-side").ionRangeSlider({
   skin: "modern",
   onFinish: function(a) {
    // $("#price_from").val(a.from), $("#price_to").val(a.to), pageData(1)
    var selmod = $("#usedmodsel").val();
    var selman = $('#usedmansel').val();
    var selCat = $("#usedcatsel").val();

    var prifrm = a.from;
    var prito = a.to;




    if (selCat == '') {
     $(".showissues").html('<strong>NOTICE!</strong> You must select a category first.');
     $(".showissues").show();
     var slider_instance = $('.js-range-slider-side').data("ionRangeSlider");
     slider_instance.reset();
    } else {
     $(".showissues").hide();

     var formaction = $('#quickserc').attr('action');


     if (formaction.indexOf('?') > -1) {
      var url = '&price=' + encodeURIComponent(prifrm + '-' + prito);
     } else {
      var url = '?price=' + encodeURIComponent(prifrm + '-' + prito);
     }

     $('#quickserc').attr('action', formaction + url);


    }

   }

  })

  $(".js-range-slider-slide2").ionRangeSlider({
   skin: "modern",
   prettify_enabled: !1,
   onFinish: function(a) {
    //$("#year_from").val(a.from), $("#year_to").val(a.to), pageData(1)
    var selmod = $("#usedmodsel").val();
    var selman = $('#usedmansel').val();
    var selCat = $("#usedcatsel").val();

    var yrfrm = a.from;
    var yrto = a.to;

    if (selCat == '') {
     $(".showissues").html('<strong>NOTICE!</strong> You must select a category first.');
     $(".showissues").show();
     var slider_instance2 = $('.js-range-slider-slide2').data("ionRangeSlider");
     slider_instance2.reset();
    } else {
     $(".showissues").hide();

     var formaction = $('#quickserc').attr('action');


     if (formaction.indexOf('?') > -1) {
      var url = '&years=' + encodeURIComponent(yrfrm + '-' + yrto);
     } else {
      var url = '?years=' + encodeURIComponent(yrfrm + '-' + yrto);
     }

     $('#quickserc').attr('action', formaction + url);

    }
   }
  })

  $(".js-range-slider-slide3").ionRangeSlider({
   skin: "modern",
   onFinish: function(a) {
    //$("#year_from").val(a.from), $("#year_to").val(a.to), pageData(1)
    var selmod = $("#usedmodsel").val();
    var selman = $('#usedmansel').val();
    var selCat = $("#usedcatsel").val();

    var hrfrm = a.from;
    var hrto = a.to;

    if (selCat == '') {
     $(".showissues").html('<strong>NOTICE!</strong> You must select a category first.');
     $(".showissues").show();
     var slider_instance3 = $('.js-range-slider-slide3').data("ionRangeSlider");
     slider_instance3.reset();
    } else {
     $(".showissues").hide();

     var formaction = $('#quickserc').attr('action');


     if (formaction.indexOf('?') > -1) {
      var url = '&hours=' + encodeURIComponent(hrfrm + '-' + hrto);
     } else {
      var url = '?hours=' + encodeURIComponent(hrfrm + '-' + hrto);
     }

     $('#quickserc').attr('action', formaction + url);

    }
   }
  })

  $("#usdsereq").keyup(function() {

   var serqrt = $(this).val();
   var formaction = $('#usdfrmsr').attr('action');


   var url = '?search=' + encodeURIComponent(serqrt);


   $('#usdfrmsr').attr('action', 'Used-Equipment' + url);
  })
 })
</script>
</footer>
</body>

</html>

<?php include('site_tracker.php'); ?>