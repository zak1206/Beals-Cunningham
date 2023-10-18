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

        </div>
        <div class="col-md-3">
          <ul class="footer-link-list"><a href="Precision-Ag">Precision Ag</a>
            <li><a href="equipment-optimization">Equipment Optimization</a></li>
            <li><a href="land-forming">Land Forming</a></li>
            <li><a href="seed-meter-test-stand">Seed Meter Test Stand</a></li>
            <li><a href="yieldpro">YieldPRO</a></li>
          </ul>
          <br>

          <br />
        </div>
      </div>
      <div class="row">
        <div class="col-md-3">
          <ul class="footer-link-list"><a href="Service">Service</a>
            <li><a href="Request-Service">Request Service</a></li>
            <li><a href="Service-Specials">Service Specials</a></li>
            <li><a href="Service-Tips-Videos">Service Tips & Videos</a></li>
          </ul>
        </div>
        <div class="col-md-3">
          <ul class="footer-link-list"><a href="Specials">Specials</a>
        </div>
        <div class="col-md-3">
          <ul class="footer-link-list"><a href="Locations">Locations</a></ul>
        </div>
        <div class="col-md-3">
          <ul class="footer-link-list"><a href="Get-A-Quote">Get a Quote</a></ul>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row" style="background: black; width: 100vw;">
  <div class="col-md-12">
    <p class="text-center" style="margin: 0 auto; font-size: .75rem; color:#fff;">© COPYRIGHT <?php echo date('Y'); ?> LEGACY EQUIPMENT - ALL RIGHTS RESERVED| <a href="Privacy-Policy">Privacy Policy</a> | Powered By<img class="lozad img-responsive" style="width: 115px;" data-src="../img/eqharvest.png" alt="EQHarvest logo" src="../img/eqharvest.png" data-loaded="true"></p>
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
      document.getElementById("mySidenav").style.width = "350px";
      document.getElementById("sideSearch").style.width = "350px";
      document.getElementById("mySidenav").style.display = "block";
      document.getElementById("sideContent").style.marginLeft = "350px";
      document.getElementById("closeNavHideImg").style.display = "block";
      document.getElementById("closeSideNav").style.display = "block";
      document.getElementById("openSideNav").style.display = "none";
      document.getElementById("closeNavHideImg").style.cursor = "pointer";
    } else {
      document.getElementById("mySidenav").style.width = "100%";
      document.getElementById("sideSearch").style.width = "100%";
      document.getElementById("mySidenav").style.display = "block";
      document.getElementById("sideContent").style.clear = "both";
      document.getElementById("closeNavHideImg").style.display = "none";
      document.getElementById("closeSideNav").style.display = "none";
      document.getElementById("openSideNav").style.display = "none";
      document.getElementById("closeNavButton").style.display = "block";
    }
  }

  /* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
  function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("mySidenav").style.display = "none";
    document.getElementById("sideSearch").style.width = "0";
    document.getElementById("closeSideNav").style.display = "none";
    document.getElementById("sideContent").style.marginLeft = "0";
    document.getElementById("openSideNav").style.display = "block";
    document.getElementById("closeNavHideImg").style.display = "none";
    document.getElementById("sideContent").style.clear = "none";

  }

  function openMobileSearchBar() {
    document.getElementById("homepage-search-mobile").style.display = "block";
    document.getElementById("homepage-search-close-btn").style.display = "inline-block";
  }

  function homepageCloseNav() {
    document.getElementById("homepage-search-mobile").style.display = "none";
    document.getElementById("homepage-search-close-btn").style.display = "none";
  }

  $(document).click(function() {
    var container = $("#mySidenav");
    var containerdiv = $("#sideSearch");
    var sideContent = $("#sideContent");
    var closeSideNav = $("#closeSideNav");
    var openSideNav = $("#openSideNav");
    var closeNavHideImg = $("#closeNavHideImg");

    if (!container.is(event.target) &&
      !container.has(event.target).length && !openSideNav.is(event.target)) {

      if (container.width() == 350) {
        closeSideNav.css('display', 'none');
        closeNavHideImg.css('display', 'none');
        openSideNav.css('display', 'block');
        sideContent.css('margin-left', '0');
        container.css('width', '0');
        containerdiv.css('width', '0');
        container.css('display', 'none');
      }
      // container.css('width', '0');
    }
  });
  //close quick equipment search end
  //Quick Search for used equipments Start ===========================

  $(function() {
    // Catergory Filter
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
    // Manufacturer Filter
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

    // Model Filter
    $("#usedmodsel").on('change', function() {

      var selmod = $(this).val();
      var selCat = $("#usedcatsel").val();
      var selman = $("#usedmansel").val();

      var formaction = $('#quickserc').attr('action');


      if (formaction.indexOf('?') > -1) {
        var url = '&model=' + encodeURIComponent(selmod + '~');
      } else {
        var url = '?model=' + encodeURIComponent(selmod + '~');
      }

      $('#quickserc').attr('action', formaction + url);

      var prifrm = $("#prifrm").val();
      var prito = $("#prito").val();
      var yrfrm = $("#yrfrm").val();
      var yrto = $("#yrto").val();
      var hrfrm = $("#hrfrm").val();
      var hrto = $("#hrto").val();
      $.ajax({
        url: 'inc/sideprocess.php?action=processmods&selcat=' + encodeURIComponent(selCat) + '&selman=' + encodeURIComponent(selman) + '&selmod=' + encodeURIComponent(selmod) + '&prifrm=' + prifrm + '&prito=' + prito + '&yrfrm=' + yrfrm + '&yrto=' + yrto + '&hrfrm=' + hrfrm + '&hrto=' + hrto,
        cache: false,
        success: function(data) {
          $("#usedloc").html(data);
        }
      })

    })

    // Location Filter
    $("#usedloc").on('change', function() {

      var selloc = $(this).val();
      var selCat = $("#usedcatsel").val();
      var selman = $("#usedmansel").val();
      var selmod = $("#usedmodsel").val();

      var formaction = $('#quickserc').attr('action');


      if (formaction.indexOf('?') > -1) {
        var url = '&location=' + encodeURIComponent(selloc + '~');
      } else {
        var url = '?location=' + encodeURIComponent(selloc + '~');
      }

      $('#quickserc').attr('action', formaction + url);

      var prifrm = $("#prifrm").val();
      var prito = $("#prito").val();
      var yrfrm = $("#yrfrm").val();
      var yrto = $("#yrto").val();
      var hrfrm = $("#hrfrm").val();
      var hrto = $("#hrto").val();
      $.ajax({
        url: 'inc/sideprocess.php?action=processlocs&selcat=' + encodeURIComponent(selCat) + '&selman=' + encodeURIComponent(selman) + '&selmod=' + encodeURIComponent(selmod) + '&selloc=' + encodeURIComponent(selloc) + '&prifrm=' + prifrm + '&prito=' + prito + '&yrfrm=' + yrfrm + '&yrto=' + yrto + '&hrfrm=' + hrfrm + '&hrto=' + hrto,
        cache: false,
        success: function(data) {
          // $("#usedloc").html(data);
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