<?php include('config.php'); ?>
<div style="padding: 20px">
 <h3 style="color:#fff;">Entire Site Search</h3>

 <form id="site-search" name="site-search" action="Search-Results" method="post">
  <div class=""><input class="form-control py-2 input-border-radius" type="search" name="serterm" id="serterm" pattern=".{3,}" title="At least 3 characters" required autocomplete="off" placeholder="Search Site..."></div>
  <div style="clear: both;"></div>
 </form>
 <hr style="border: solid thin #fff">
 <h3 style="color:#fff;">Equipment Fliter</h3>
 <div class="search-equip">
 </div>
 <div class="tab-content">
  <div id="used-equipment" class="tab-pane active">

   <form name="quickserc" id="quickserc" action="Used-Equipment" method="post">
    <label style="color: #fff;">1. Select Category</label><br>
    <select class="form-control input-border-radius" name="usedcatsel" id="usedcatsel">
     <option value="">Select Category</option>
     <?php
     $a = $data->query("SELECT category FROM used_equipment WHERE (active = 'true' AND isNew = 'false') GROUP BY category ASC");
     while ($b = $a->fetch_array()) {
      if ($b["category"] != null) {
       echo '<option value="' . $b["category"] . '">' . $b["category"] . '</option>';
      }
     }
     ?>
    </select>
    <br>
    <label style="color: #fff;">2. Select Manufacturer</label><br>
    <select class="form-control input-border-radius" name="usedmansel" id="usedmansel">
     <option value="">Select Manufacturer</option>
    </select>
    <br>

    <div class="showissues" style="color: red; display: none; padding: 10px 0px;"></div>
    <div class="pricerange" style="color: #fff">
     <label class="bold-label">Price Range</label>
     <input type="text" class="js-range-slider-side" name="price_range_sel" value="" data-type="double" data-step="500" data-min="0" data-max="900000" data-grid="true" />
    </div>
    <br>
    <div class="pricerange" style="color: #fff">
     <label class="bold-label">Year Range</label>
     <input type="text" class="js-range-slider-slide2" name="year_range" value="" data-type="double" data-min="1900" data-max="<?php echo date('Y'); ?>" data-grid="true" />
    </div>
    <br>
    <div class="hourrsrange" style="color:#fff">
     <label class="bold-label">Hours Filter</label>
     <input type="text" class="js-range-slider-slide3" name="hours_range" value="" data-type="double" data-min="0" data-max="9000" data-grid="true" />
    </div>
    <br><br>
    <input type="hidden" name="prifrm" id="prifrm" value="0">
    <input type="hidden" name="prito" id="prito" value="900000">
    <input type="hidden" name="yrfrm" id="yrfrm" value="1900">
    <input type="hidden" name="yrto" id="yrto" value="<?php echo date('Y'); ?>">
    <input type="hidden" name="hrfrm" id="hrfrm" value="0">
    <input type="hidden" name="hrto" id="hrto" value="9000">
    <button class="btn btn-success quick-search-btn">Filter</button>
   </form>
  </div>
 </div>
</div>