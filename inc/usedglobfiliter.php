<?php include('config.php'); ?>

<div id="mySidenav" class="sidenav" style="z-index: 9000; background-color: #194E21;">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <div style="padding: 20px">
        <strong style="color:#fff; font-size: 20px">Quick Equipment Search</strong>
        <hr style="border: solid thin #fff">
        <form name="usdfrmsr" id="usdfrmsr" action="Used-Equipment" method="post">
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="usdsereq" id="usdsereq" value="" placeholder="Search categories, models or keywords">
                <div class="input-group-append">
                    <button class="btn btn-success" type="submit">Search</button>
                </div>
            </div>
        </form>

        <strong style="color:#fff; font-size: 20px">Equipment Fliter</strong>
        <hr style="border: solid thin #fff">
        <div class="search-equip">
            <!--            <ul class="nav nav-pills justify-content-center">-->
            <!--                <li><a data-toggle="pill" href="#new-equipment">NEW</a></li>-->
            <!--                <li><a data-toggle="pill" href="#used-equipment" class="active">USED</a></li>-->
            <!--                <li><a data-toggle="pill" href="#all-equipment">ALL</a></li>-->
            <!--            </ul>-->
        </div>
        <div class="tab-content">
            <div id="used-equipment" class="tab-pane active">
                <!-- <h3>USED</h3>
                <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p> -->
                <form name="quickserc" id="quickserc" action="Used-Equipment" method="post">
                    <label style="color: #fff;">1. Select Category</label><br>
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
                    <br>
                    <label style="color: #fff;">2. Select Manufacturer</label><br>
                    <select class="form-control" name="usedmansel" id="usedmansel">
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
        <br><br>
    </div>
</div>

<!-- Use any element to open the sidenav -->
<span class="eq-search-span" onclick="openNav()"><img id="open-sideNav" class="open-side-nav-img" src="img/Web-EQ-search-tab-v3.png" alt="used search tag"></span>

<span class="d-none d-sm-none d-sm-block close-sidenav-span" id="close-nav-hide-img" onclick="closeNav()"><img id="close-sideNav" class="close-sidenav-img" src="img/Web-EQ-search-tab-CLOSE-v3.png" alt="used search tag"></span>