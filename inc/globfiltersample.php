<?php include('config.php'); ?>
<div>
 <div id="mySidenav" class="sidenav" style="z-index: 9000; background-color: #1D405A;">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <div style="padding: 20px;">
   <h3 class="text-white wt-300" align="center" style="background-color: transparent;">
    <i>Entire Site Search</i>
   </h3>
   <form id="site-search" name="site-search" action="Search-Results" method="post" style="display: none;">
    <div class=""><input style="width: 100%;padding: 10px;background: #333;border: none;color: #a7a7a7;font-size: 30px; text-align: center; outline: none;" type="text" name="serterm" id="serterm" pattern=".{3,}" title="At least 3 characters" required autocomplete="off" placeholder="Search Site..."></div>
    <div style="clear: both;"></div>
   </form>

   <h3 class="text-white" align="center" style="background-color: transparent;">
    USED EQUIPMENT SEARCH
   </h3>
   <div class="search-equip">

   </div>
   <div class="tab-content">
    <div id="used-equipment" class="tab-pane active">
     <form name="quickserc" id="quickserc" action="Used-Equipment" method="post">
      <label class="text-white" style="font-family: text-MyriadPro;"><b>CATEGORY</b></label><br />
      <select class="form-control" name="usedcatsel" id="usedcatsel">
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
      <br />
      <label class="text-white" style="font-family: text-MyriadPro;"><b>MANUFACTURER</b></label><br />
      <select class="form-control" name="usedmansel" id="usedmansel">
       <option value="">Select Manufacturer</option>
      </select>
      <br />
      <label class="text-white" style="text-MyriadPro"><b>MODEL</b></label><br />
      <select class="form-control" name="usedmansel" id="usedmansel">
       <option value="">Select Model</option>
      </select>

      <br />
      <label class="text-white" style="text-MyriadPro"><b>LOCATION</b></label><br />
      <select class="form-control" name="usedmansel" id="usedmansel">
       <option value="">Select Location</option>
      </select>
      <br />

      <button class="btn btn-success quick-search-btn">Filter</button>
     </form>
     <br />
     <h3 class="text-white">
      <b>LEGACY</b><br />
      <span class="wt-100">LEADS.</span>
     </h3>
    </div>
   </div>
  </div>
 </div>
</div>