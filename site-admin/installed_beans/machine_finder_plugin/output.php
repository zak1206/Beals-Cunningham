<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

if(isset($_SESSION["used_filters"])){
   $setSetting = json_decode($_SESSION["used_filters"],true);


    $thePricefrom = $setSetting["price_from"];
    $thePriceto = $setSetting["price_to"];
    $theHoursfrom = $setSetting["hours_from"];
    $theHoursto = $setSetting["hours_to"];
    $theYearsfrom = $setSetting["year_from"];
    $theYearsto =$setSetting["year_to"];
    $theSorter = $setSetting["sorttype"];
    $theViewtype = $setSetting["viewtype"];
    $thePageon = $setSetting["pageon"];

}else{

    $thePricefrom = '0';
    $thePriceto = '900000';
    $theHoursfrom = '0';
    $theHoursto = '9000';
    $theYearsfrom = '1900';
    $theYearsto = date('Y');
    $theSorter = '';
    $theViewtype = 'grid';
    $thePageon = '1';
}

function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }
    return false;
}
?>


<div class="row" style="padding: 10px; margin: 0">
    <button class="btn btn-success opnfilters" style="width: 100%; margin-bottom: 30px; position: -webkit-sticky; position: sticky; top:0; z-index: 5">Open Filters</button>
    <div class="clearfix"></div>
    <div class="col-md-3 mob-sensor">
        <label class="bold-label">Quick Search</label><br>
        <div class="btn-group" style="width: 100%">
            <input id="searchinput" type="search" class="form-control theautos" placeholder="Search...">
            <span id="searchclear" class="fa fa-times-circle" onclick="resetFilters()"></span>
        </div>

        <!--start filters -->
        <br><br>
        <div style="text-align: right"><button class="btn btn-primary btn-xs" style="font-size: 12px" onclick="resetFilters()"><i class="fa fa-times-circle"></i> Reset All Filters</button></div>
        <br>



        <div class="catsselbox">
            <label class="bold-label">Categories</label><br>
            <div class="category-labs target-box" data-filter-box="category" style="margin-bottom: 10px">
                <?php
                $setCategories = $setSetting["filters_saved"][0]["category"];
                for($i=0; $i<count($setCategories); $i++){
                    echo '<span class="badge badge-secondary badge-lab clickobjtabs" data-labtype="category" data-category-set="'.$setCategories[$i]["item"].'">'.$setCategories[$i]["item"].' <i class="fa fa-times-circle"></i></span>';
                }
                ?>
            </div>
            <ul class="cat-tags">
                <?php


                    include('inc/config.php');
                    $a = $data->query("SELECT * FROM used_equipment WHERE active = 'true' GROUP BY category");
                    while($b = $a->fetch_array()){
                        if($b["category"] != '') {

                            $c = $data->query("SELECT manufacturer FROM used_equipment WHERE category = '".$b["category"]."' GROUP BY manufacturer");
                            while($d = $c->fetch_array()){
                                $mans .= $d["manufacturer"].',';
                            }

                            $c = $data->query("SELECT model FROM used_equipment WHERE category = '".$b["category"]."' GROUP BY model");
                            while($d = $c->fetch_array()){
                                $modscats .= $d["model"].',';
                            }



                            if(in_array_r($b["category"], $setCategories)){
                                $check = '<span class="thecheck">&nbsp;<i class="fa fa-check green-check"></i></span>';
                                $checkClass = 'catfilter';
                            }else{
                                $check = '';
                                $checkClass = '';
                            }


                            echo '<li class="cat-item clickobj '.$checkClass.'" data-obj="category" data-vals="' . $b["category"] . '" data-manus="'.$mans.'" data-mods="'.$modscats.'">' . $b["category"] . '<div style="display: none; background: #efefef; padding: 10px"></div> '.$check.'</li>';
                            $mans = '';
                        }
                    }
                ?>
            </ul>
        </div>

        <br>


        <div class="manselbox">
            <label class="bold-label">Manufacturer</label><br>
            <div class="manufacturer-labs target-box" data-filter-box="manufacturer" style="margin-bottom: 10px">
                <?php
                $setManufaturers = $setSetting["filters_saved"][1]["manufacturer"];
                for($i=0; $i<count($setManufaturers); $i++){
                    echo '<span class="badge badge-secondary badge-lab clickobjtabs" data-labtype="manufacturer" data-manufacturer-set="'.$setManufaturers[$i]["item"].'">'.$setManufaturers[$i]["item"].' <i class="fa fa-times-circle"></i></span>';
                }
                ?>
            </div>
            <ul class="cat-tags" style="max-height: 190px">
                <?php
                include('inc/config.php');
                $a = $data->query("SELECT manufacturer, count(*) AS counter FROM used_equipment WHERE active = 'true' GROUP BY manufacturer");
                while($b = $a->fetch_array()){
                    if($b["manufacturer"] != '') {
                        $c = $data->query("SELECT category FROM used_equipment WHERE manufacturer = '".$b["manufacturer"]."' GROUP BY category") or die($data->error);
                        while($d = $c->fetch_array()){
                            $cats .= $d["category"].',';
                        }

                        $c = $data->query("SELECT model FROM used_equipment WHERE manufacturer = '".$b["manufacturer"]."' GROUP BY model");
                        while($d = $c->fetch_array()){
                            $mods .= $d["model"].',';

                            if(in_array_r($b["manufacturer"], $setManufaturers)){
                                $checkman = '<span class="thecheck">&nbsp;<i class="fa fa-check green-check"></i></span>';
                                $checkmanClass = 'manfilter';
                            }else{
                                $checkman = '';
                                $checkmanClass = '';
                            }
                        }
                        echo '<li style="display:inline-block;" class="man-item clickobj '.$checkmanClass.'" data-obj="manufacturer" data-vals="' . $b["manufacturer"] . '" data-cats="'.$cats.'" data-mods="'.$mods.'">' . $b["manufacturer"] . '<div style="display: none; background: #efefef; padding: 10px"></div> '.$checkman.'</li>';
                        $cats = '';
                        $mods = '';
                    }
                }
                ?>
            </ul>
        </div>

        <br>

        <div class="modselbox">
        <label class="bold-label">Models</label><br>
            <div class="model-labs target-box" data-filter-box="model" style="margin-bottom: 10px">
                <?php
                $setModels = $setSetting["filters_saved"][2]["model"];
                for($i=0; $i<count($setModels); $i++){
                    echo '<span class="badge badge-secondary badge-lab clickobjtabs" data-labtype="model" data-model-set="'.$setModels[$i]["item"].'">'.$setModels[$i]["item"].' <i class="fa fa-times-circle"></i></span>';
                }
                ?>
            </div>
            <ul class="mod-tags" style="max-height: 190px">
                <?php
                include('inc/config.php');
                $a = $data->query("SELECT model, count(*) AS counter FROM used_equipment WHERE active = 'true' GROUP BY model");
                while($b = $a->fetch_array()){
                    if($b["model"] != '') {

                        $c = $data->query("SELECT category FROM used_equipment WHERE model = '".$data->real_escape_string($b["model"])."' GROUP BY category") or die($data->error);
                        while($d = $c->fetch_array()){
                            $cats .= $d["category"].',';
                        }

                        $c = $data->query("SELECT manufacturer FROM used_equipment WHERE model = '".$data->real_escape_string($b["model"])."' GROUP BY manufacturer")or die($data->error);
                        while($d = $c->fetch_array()){
                            $manus .= $d["manufacturer"].',';
                        }

                        if(in_array_r($b["model"], $setModels)){
                            $checkmod = '<span class="thecheck">&nbsp;<i class="fa fa-check green-check"></i></span>';
                            $checkmodClass = 'modfilter';
                        }else{
                            $checkmod = '';
                            $checkmodClass = '';
                        }

                        echo '<li style="display: inline-block" class="mod-item clickobj '.$checkmodClass.'" data-obj="model" data-vals="' . $b["model"] . '" data-cats="'.$cats.'" data-manus="'.$manus.'">' . $b["model"] . '<div style="display: none; background: #efefef; padding: 10px"></div>'.$checkmod.'</li>';
                        $cats = '';
                        $manus = '';
                    }
                }
                ?>
            </ul>
        </div>

        <div class="locselbox">
            <label class="bold-label">Location</label><br>
            <div class="city-labs target-box" data-filter-box="city" style="margin-bottom: 10px">
                <?php
                $setCity = $setSetting["filters_saved"][3]["city"];

                //var_dump($setCity);
                for($i=0; $i<count($setCity); $i++){
                    echo '<span class="badge badge-secondary badge-lab clickobjtabs" data-labtype="city" data-model-set="'.$setCity[$i]["item"].'">'.$setCity[$i]["item"].' <i class="fa fa-times-circle"></i></span>';
                }
                ?>
            </div>
            <ul class="loc-tags" style="max-height: 190px">
                <?php
                include('inc/config.php');
                $a = $data->query("SELECT city, count(*) AS counter FROM used_equipment WHERE active = 'true' GROUP BY city")or die($data->error);
                while($b = $a->fetch_array()){
                    if($b["city"] != '') {

                        echo '<li style="display: inline-block" class="loc-item clickobj '.$checkmodClass.'" data-obj="city" data-vals="' . $b["city"] . '">' . $b["city"] . '<div style="display: none; background: #efefef; padding: 10px"></div>'.$checkmod.'</li>';
                        $cats = '';
                        $manus = '';
                    }
                }
                ?>
            </ul>
        </div>

        <br>
        <div class="yearselbox" style="display: none">
            <label class="bold-label">Years</label><br>
            <div class="year-labs target-box" data-filter-box="year" style="margin-bottom: 10px"></div>
            <ul class="year-tags" style="max-height: 190px">
                <?php
                include('inc/config.php');
                $a = $data->query("SELECT modelYear, count(*) AS counter FROM used_equipment WHERE active = 'true' GROUP BY modelYear")or die($data->error);
                while($b = $a->fetch_array()){
                    if($b["modelYear"] != '') {
                        echo '<li style="display: inline-block" class="year-item clickobj" data-obj="year" data-vals="' . $b["modelYear"] . '">' . $b["modelYear"] . '<div style="display: none; background: #efefef; padding: 10px"></div></li>';
                    }
                }
                ?>
                <li class="year-item"><span class="fa fa-close"></span></li>
            </ul>
        </div>
        <br>
        <small style="color: red">Notice: Below slide filters do not effect above filters, only your results.</small><br><br>

        <div class="yearrange">
            <label class="bold-label">Year Filter</label>
            <input type="text" class="js-range-slider-3" name="year_range" value="" data-type="double" data-min="1900" data-max="<?php echo date('Y'); ?>" data-from="<?php echo $theYearsfrom; ?>" data-to="<?php echo $theYearsto; ?>" data-grid="true"/>
        </div>


        <br>
        <div class="pricerange">
            <label class="bold-label">Price Filter</label>
            <input type="text" class="js-range-slider" name="price_range" value="" data-type="double" data-step="500" data-min="0" data-max="900000" data-from="<?php echo $thePricefrom; ?>" data-to="<?php echo $thePriceto; ?>" data-grid="true"/>
        </div>
        <br>
        <div class="hourrsrange">
            <label class="bold-label">Hours Filter</label>
            <input type="text" class="js-range-slider-2" name="hours_range" value="" data-type="double" data-min="0" data-max="9000" data-from="<?php echo $theHoursfrom; ?>" data-to="<?php echo $theHoursto; ?>" data-grid="true"/>
        </div>


        <input type="hidden" name="price_from" id="price_from" value="<?php echo $thePricefrom; ?>">
        <input type="hidden" name="price_to" id="price_to" value="<?php echo $thePriceto; ?>">

        <input type="hidden" name="hours_from" id="hours_from" value="<?php echo $theHoursfrom; ?>">
        <input type="hidden" name="hours_to" id="hours_to" value="<?php echo $theHoursto; ?>">

        <input type="hidden" name="year_from" id="year_from" value="<?php echo $theYearsfrom; ?>">
        <input type="hidden" name="year_to" id="year_to" value="<?php echo $theYearsto; ?>">

        <input type="hidden" name="sorterset" id="sorterset" value="<?php echo $theSorter; ?>">

        <input type="hidden" name="viewtype" id="viewtype" value="<?php echo $theViewtype; ?>">

        <input type="hidden" name="pageons" id="pageons" value="<?php echo $thePageon; ?>">
        <br><br>
    </div>
    <div class="col-md-9 rezout">Loading Equipment - Please Wait ...</div>
</div>

<?php

$de = $data->query("SELECT id FROM beans WHERE bean_id = 'MF-v3'");
$pe = $de->fetch_array();

$depId = $pe["id"];

$op = $data->query("SELECT * FROM beans_dep WHERE bean_id = '$depId' AND active = 'true' AND load_type = 'mod'")or die($data->error);
while($fg = $op->fetch_array()){
    if($fg["type"] == 'css'){
        $css[] = $fg["file"];
    }

    if($fg["type"] == 'js'){
        $js[] = $fg["file"];
    }
}


?>