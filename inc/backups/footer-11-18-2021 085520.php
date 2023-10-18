<!--Footer section-->
<div class="container-fluid" id="footer" style="background-color: #387D3C; padding-bottom: 50px;">
  <div class="row">
    <div class="col-sm-12 col-md-4 col-xl-4 my-auto" align="center">
      <div>
        <img class="img-responsive" src="img/Homepage/footer-logo.png" alt="Valley Plains Logo" style="max-width: 300px;">
      </div>
      <div class="row" style="margin-top: 30px;">
        <div class="col-12 col-sm-6 col-md-6">
          <h5><a href="" class="vp-footer-locations">Jamestown, ND</a></h5>
          <h5><a href="" class="vp-footer-locations">Valley City, ND</a></h5>
          <h5><a href="" class="vp-footer-locations">Galesburg, ND</a></h5>
        </div>
        <div class="col-12 col-sm-6 col-md-6">
          <h5><a href="" class="vp-footer-locations">Hillsboro, ND</a></h5>
          <h5><a href="" class="vp-footer-locations">Hunter, ND</a></h5>
          <h5><a href="" class="vp-footer-locations">Crookston, MN</a></h5>
        </div>
      </div>
    </div>

    <div class="col-sm-12 col-md-4 col-xl-4" align="center">
      <div>
        <img src="../img/Homepage/footer-section-map.png" alt="Vally Plains Map" class="img-responsive footer-map-image">
      </div>
    </div>

    <div class="col-sm-12 col-md-4 col-xl-4 my-auto" align="center">
      <label style="margin-top:20px; margin-right: 8px; font-size: 16px; color: #fff;">EMAIL SIGNUP</label><br class="location-finder-breaker">
      <div class="email-signup-div">
        <input type="text" name="emailSignUp" id="emailSignUp" class="form-control" value="" placeholder="YOUR EMAIL" class="emailsignup-input-field">
        <button class="btn btn-blue" type="submit"><span>SUBMIT</span></button>
      </div>

      <div>
        <p style="margin-top: 20px; color:#fff;">© <?php echo date('Y'); ?> Valley Plains Equipment LLC - Powered By<img alt="EQHarvest logo" src="../img/Homepage/EQ-Harvest Logo.png"></p>
      </div>
    </div>
    <div class="col-lg-1 d-none d-lg-block d-xl-block"></div>
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
<script async
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA3kOtMBhpbkLT1MT9LgXQjpgwwNqCH0EU&callback=initMap">
</script>
<script>
let map;
// The following example creates complex markers to indicate beaches near
// Sydney, NSW, Australia. Note that the anchor is set to (0,32) to correspond
// to the base of the flagpole.
function initMap() {
  const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 10,
    center: { lat: 47.3, lng: -97.0 },
  });

  setMarkers(map);
}

// Data for the markers consisting of a name, a LatLng and a zIndex for the
// order in which these markers should display on top of each other.
const vplocations = [
  ["Crookston", 47.763489, -96.629032, 4],
  ["Galesburg", 47.267265, -97.405783, 5],
  ["Hillsboro", 47.3999036, -97.0728175, 3],
  ["Hunter", 47.193865, -97.216654, 2],
  ["Jamestown", 46.887658, -98.717209, 1],
  ["Valley City", 46.923065, -97.983608, 6],
];

function setMarkers(map) {
  const image = {
    url: "https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png",
    // This marker is 20 pixels wide by 32 pixels high.
    size: new google.maps.Size(20, 32),
    // The origin for this image is (0, 0).
    origin: new google.maps.Point(0, 0),
    // The anchor for this image is the base of the flagpole at (0, 32).
    anchor: new google.maps.Point(0, 32),
  };
  // Shapes define the clickable region of the icon. The type defines an HTML
  // <area> element 'poly' which traces out a polygon as a series of X,Y points.
  // The final coordinate closes the poly by connecting to the first coordinate.
  const shape = {
    coords: [1, 1, 1, 20, 18, 20, 18, 1],
    type: "poly",
  };

  for (let i = 0; i < vplocations.length; i++) {
    const beach = vplocations[i];

    new google.maps.Marker({
      position: { lat: beach[1], lng: beach[2] },
      map,
      icon: image,
      shape: shape,
      title: beach[0],
      zIndex: beach[3],
    });
  }
}
</script>


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
  document.addEventListener("DOMContentLoaded", function() {

    /////// Prevent closing from click inside dropdown
    document.querySelectorAll('.dropdown-menu').forEach(function(element) {
      element.addEventListener('click', function(e) {
        e.stopPropagation();
      });
    });

    // make it as accordion for smaller screens
    if (window.innerWidth < 992) {
      // close all inner dropdowns when parent is closed
      document.querySelectorAll('.navbar .dropdown').forEach(function(everydropdown) {
        everydropdown.addEventListener('hidden.bs.dropdown', function() {
          // after dropdown is hidden, then find all submenus
          this.querySelectorAll('.megasubmenu').forEach(function(everysubmenu) {
            // hide every submenu as well
            everysubmenu.style.display = 'none';
          });
        })
      });

      document.querySelectorAll('.has-submenu a').forEach(function(element) {
        element.addEventListener('click', function(e) {
          let nextEl = this.nextElementSibling;
          if (nextEl && nextEl.classList.contains('megasubmenu')) {
            // prevent opening link if link needs to open dropdown
            e.preventDefault();
            if (nextEl.style.display == 'block') {
              nextEl.style.display = 'none';
            } else {
              nextEl.style.display = 'block';
            }
          }
        });
      }) // end foreach
    }
    // end if innerWidth
  });
  // DOMContentLoaded  end
</script>
<script type="text/javascript">
  const menuBtn = document.querySelector('.menu-btn');
  let menuOpen = false;
  menuBtn.addEventListener('click', () => {
    if (!menuOpen) {
      menuBtn.classList.add('open');
      menuOpen = true;
    } else {
      menuBtn.classList.remove('open');
      menuOpen = false;
    }
  });
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