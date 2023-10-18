<!--Footer section-->
<div class="container-fluid" id="footer">
 <div class="row">
 <div class="col-md-6" align="center">
 <img class="img-responsive" src="" alt="" style="border: 1px solid black; width: 400px; height: 400px;">
 </div>
 <div class="col-md-6">
 <div class="row">
 <div class="col-md-3">
 <ul class="footer-link-list">
 About
 <li><a href="">About</a></li>
 <li><a href="">Our Team</a></li>
 <li><a href="">Careers</a></li>
 <li><a href="">Contact</a></li>
 <li><a href="">Donation Request</a></li>
 </ul>
 <br />
 <ul class="footer-link-list">Locations</ul>
 </div>
 <div class="col-md-3">
 <ul class="footer-link-list">Equipment
 <li><a href="">New John Deere Equipment</a></li>
 <li><a href="">Used Equipment</a></li>
 <li><a href="">New STIHL</a></li>
 <li><a href="">New Honda</a></li>
 <li><a href="">Dealer Transfer Request</a></li>
 </ul>
 <br />
 <ul class="footer-link-list">Specials
 <li><a href="">Service Specials</a></li>
 <li><a href="">Current Specials</a></li>
 <li><a href="">Deere Specials</a></li>
 </ul>
 </div>
 <div class="col-md-3">
 <ul class="footer-link-list">Parts
 <li><a href="">Online Parts</a></li>
 <li><a href="">Parts Promotions</a></li>
 <li><a href="">STIHL</a></li>
 </ul>
 <br />
 <ul class="footer-link-list">Service
 <li><a href="">Request Service</a></li>
 <li><a href="">Service Tips & Videos</a></li>
 <li><a href="">Service Specials</a></li>
 </ul>
 </div>
 <div class="col-md-3">
 <ul class="footer-link-list">Get a Quote</ul>
 <br />
 <ul class="footer-link-list">Precision Ag
 <li><a href="">Services</a></li>
 <li><a href="">Products</a></li>
 </ul>
 <br />
 </div>
 </div>
 </div>
 </div>
</div>
<div class="row" style="background: black;">
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
<script src="inc/mods/caffeine_chat/caffeine_chat.js"></script>



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




</footer>
</body>

</html>

<?php include('site_tracker.php'); ?>