<?php
class machineFind{
    function runOutput(){
        include ('inc/config.php');

        if(isset($_REQUEST["categories"])){

            $catars = explode('~',$_REQUEST["categories"]);

            if(!empty($catars)){

                foreach ($catars as $keycat){
                    if($keycat != '') {
                        $saveName = $keycat;
                        $keycat = str_replace(' ', '-', $keycat); // Replaces all spaces with hyphens.
                        $keycat = preg_replace('/[^A-Za-z0-9\-]/', '', $keycat);
                        //$keycat = preg_replace("![^a-z0-9]+!i", "-", $keycat);
                        $tabs .= '<button type="button" class="btn btn-light filbu-'.$keycat.'" style="margin: 10px 10px 0px 0px; border:solid thin #cfcfcf; border-radius: 0; display: inline-block" onclick="clearTabs(\'' . $saveName . '\',\'categories\')">' . $saveName . ' <span class="badge"><i class="fas fa-times"></i></span></button>';
                    }
                }


            }
        }else{

        }

        $manars = explode('~',$_REQUEST["manufacturer"]);
            if(!empty($manars)){
                foreach ($manars as $keyman){
                    if($keyman != '') {
                        $saveName = $keyman;
                        $keyman = str_replace(' ', '-', $keyman); // Replaces all spaces with hyphens.
                        $keyman = preg_replace('/[^A-Za-z0-9\-]/', '', $keyman);
                        //$keycat = preg_replace("![^a-z0-9]+!i", "-", $keycat);
                        $tabs .= '<button type="button" class="btn btn-light filbu-'.$keyman.'" style="margin: 10px 10px 0px 0px; border:solid thin #cfcfcf; border-radius: 0; display: inline-block" onclick="clearTabs(\'' . $saveName . '\',\'manufacturer\')">' . $saveName . ' <span class="badge"><i class="fas fa-times"></i></span></button>';
                    }
                }
            }

            if(isset($_REQUEST["search"])){
                $serset = $_REQUEST["search"];
            }else{
                $serset = '';
            }

        $html .= '<div class="searchbarhold"><div class="col-12"><input class="form-control serbox" type="text" name="usedser" id="usedser" placeholder="Search categories, models or keywords" value="'.$serset.'">
<div class="tags" style="margin-top: 5px">'.$tabs.'</div></div>';



        //START FILTERS//

        if(isset($_REQUEST["eqcondition"])){
            $eqCond = $_REQUEST["eqcondition"];
        }else{
            $eqCond = 'New & Used';
        }

        if(isset($_REQUEST["sort"])){
            $eqSort = $_REQUEST["sort"];
        }else{
            $eqSort = 'Sort By';
        }

        if(isset($_REQUEST["listtype"])){
            if($_REQUEST["listtype"] == 'grid'){
                $girdvw = 'active';
                $listvw = '';
            }else{
                $girdvw = '';
                $listvw = 'active';
            }
        }else{
            $girdvw = 'active';
            $listvw = '';
        }



        $html .= '<div class="row" style="padding: 0px; display: none">
<div class="col-md-6">

<!-- Example single danger button -->
<div class="btn-group">
  <button style="border-radius: 0" type="button" class="btn btn-info btn-sm dropdown-toggle eqtparent" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    '.$eqCond.'
  </button>
  <div class="dropdown-menu">
    <a class="dropdown-item eqtypset" data-eqcond="Used" href="javascript:void(0)">Used</a>
    <a class="dropdown-item eqtypset" data-eqcond="New"  href="javascript:void(0)">New</a>
    <a class="dropdown-item eqtypset" data-eqcond="New & Used"  href="javascript:void(0)">New & Used</a>
  </div>
</div>

<div class="btn-group">
  <button style="border-radius: 0; text-transform:capitalize;" class="btn btn-secondary btn-sm dropdown-toggle sortparent" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    '.$eqSort. '
  </button>
  <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(54px, 47px, 0px); top: 0px; left: 0px; will-change: transform;">
  
  
    <a class="dropdown-item sorters" href="javascript:void(0)" data-dorttype="recent">Recent</a><a class="dropdown-item sorters" href="javascript:void(0)" data-dorttype="mod-a-z">Model A-Z</a><a class="dropdown-item sorters" href="javascript:void(0)" data-dorttype="mod-z-a">Model Z-A</a><a class="dropdown-item sorters" href="javascript:void(0)" data-dorttype="price-low-high">Price Low-High</a><a class="dropdown-item sorters" href="javascript:void(0)" data-dorttype="price-high-low">Price High-Low</a><a class="dropdown-item sorters" href="javascript:void(0)" data-dorttype="hours-low-high">Hours Low-High</a><a class="dropdown-item sorters" href="javascript:void(0)" data-dorttype="hours-high-low">Hours High-Low</a><a class="dropdown-item sorters" href="javascript:void(0)" data-dorttype="year-new-old">Year New-Old</a><a class="dropdown-item sorters" href="javascript:void(0)" data-dorttype="year-old-new">Year Old-New</a><a class="dropdown-item sorters" href="javascript:void(0)" data-dorttype="man-a-z">Manufacturer A-Z</a><a class="dropdown-item sorters" href="javascript:void(0)" data-dorttype="man-z-a">Manufacturer Z-A</a><a class="dropdown-item sorters" href="javascript:void(0)" data-dorttype="cat-a-z">Category A-Z</a><a class="dropdown-item sorters" href="javascript:void(0)" data-dorttype="cat-z-a">Category Z-A</a>
  </div>
</div></div>
<div class="col-md-6" style="text-align: right; display: none">
<a href="Used-Equipment" class="btn btn-warning btn-sm" style="border-radius: 0; font-weight: bold; color: #996500"><i class="fas fa-times"></i> Reset Filters</a>
<div class="btn-group" role="group" aria-label="Basic example">
  <button type="button" class="btn btn-secondary btn-sm '.$girdvw.' listtypout" data-listtype="grid" style="border-radius: 0"><i class="fas fa-th-large"></i></button>
  <button type="button" class="btn btn-secondary btn-sm listtypout '.$listvw.'" data-listtype="list" style="border-radius: 0"><i class="fas fa-list"></i></button>
</div>

</div></div>';


        $html .= '<div class="col-md-12" style=" position: relative">';
        $html .='<div class="row" style="padding: 15px">';
        $html .= '<button class="btn filt-itms col filt-cat">Categories <i class="fas fa-chevron-down"></i></button>';
        $html .= '<button class="btn filt-itms col man-cat">Manufacturer  <i class="fas fa-chevron-down"></i></button>';
        $html .= '<button class="btn filt-itms col mo-filters">Other Filters <i class="fas fa-chevron-down"></i></button>';



        $html .= '<div class="dropdown col mobsens" style="padding: 2px;">
  <button style="background: #fff;color: #636363;border: solid thin #c7c7c7;border-radius: 2px;padding: 14px;font-weight: bold; width: 100%; text-align: left;
" class="btn btn-secondary dropdown-toggle filt-itms" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Condition <i style="float: right; margin-top: 5px; color: #d4d4d4" class="fas fa-chevron-down"></i>
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width: 100%">
    <a class="dropdown-item eqtypset" data-eqcond="Used" href="javascript:void(0)">Used</a>
    <a class="dropdown-item eqtypset" data-eqcond="New"  href="javascript:void(0)">New</a>
    <a class="dropdown-item eqtypset" data-eqcond="New & Used"  href="javascript:void(0)">New & Used</a>
  </div>
</div>';
        $html .= '<div class="dropdown col mobsens" style="padding: 2px;">
  <button style="background: #fff;color: #636363;border: solid thin #c7c7c7;border-radius: 2px;padding: 14px;font-weight: bold; width: 100%; text-align: left;
" class="btn btn-secondary dropdown-toggle sorterset" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Sort By <i style="float: right; margin-top: 5px; color: #d4d4d4" class="fas fa-chevron-down"></i>
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width: 100%">
<a class="dropdown-item sorters" href="javascript:void(0)" data-dorttype="recent">Recent</a><a class="dropdown-item sorters" href="javascript:void(0)" data-dorttype="mod-a-z">Model A-Z</a><a class="dropdown-item sorters" href="javascript:void(0)" data-dorttype="mod-z-a">Model Z-A</a><a class="dropdown-item sorters" href="javascript:void(0)" data-dorttype="price-low-high">Price Low-High</a><a class="dropdown-item sorters" href="javascript:void(0)" data-dorttype="price-high-low">Price High-Low</a><a class="dropdown-item sorters" href="javascript:void(0)" data-dorttype="hours-low-high">Hours Low-High</a><a class="dropdown-item sorters" href="javascript:void(0)" data-dorttype="hours-high-low">Hours High-Low</a><a class="dropdown-item sorters" href="javascript:void(0)" data-dorttype="year-new-old">Year New-Old</a><a class="dropdown-item sorters" href="javascript:void(0)" data-dorttype="year-old-new">Year Old-New</a><a class="dropdown-item sorters" href="javascript:void(0)" data-dorttype="man-a-z">Manufacturer A-Z</a><a class="dropdown-item sorters" href="javascript:void(0)" data-dorttype="man-z-a">Manufacturer Z-A</a><a class="dropdown-item sorters" href="javascript:void(0)" data-dorttype="cat-a-z">Category A-Z</a><a class="dropdown-item sorters" href="javascript:void(0)" data-dorttype="cat-z-a">Category Z-A</a>
  </div>
</div>';

        $html .= '<div class="col mobsens2"><button class="btn btn-default shsowconds" style="padding: 14px; border-radius: 0;background: #fff;border: solid thin #c7c7c7;color: #b1b1b1;margin-top: 2px;"><i class="fas fa-ellipsis-v"></i></button></div>';

        $html .= '<div class="btn-group col special" style="margin: 0;padding: 2px 0px;" role="group" aria-label="Basic example">
  <button type="button" class="btn btn-secondary listtypout '.$girdvw.'" data-listtype="grid"><i class="fas fa-th-large"></i></button>
  <button type="button" class="btn btn-secondary listtypout '.$listvw. '" data-listtype="list"><i class="fas fa-list"></i></button>
  <button href="Used-Equipment" type="button" class="btn btn-warning" style="color: #b27e00"><i class="fas fa-times"></i> RESET</button>
</div>';
        $html .='</div>';



        $html .= '<div class="row catbox" style="width: 98%; background: #fff; padding: 20px; border: solid thin #e5e5e5; left: 30px; z-index: 5; display: none; overflow: scroll;">';
        $html .= '<span class="badge badge-primary moreshow">More Below <i class="fas fa-chevron-down"></i></span>';
        $html .= '<div style="position: sticky; top: -20px; background: #fff; width: 100%; z-index: 5"><span class="closthis" style="position: absolute;right: 20px;top: 18px;color: #868383;font-size: 20px; cursor: pointer"><i class="fas fa-times"></i></span><h4 class="fliterheaders">Categories</h4><input style="border-radius: 0;margin: 20px 0; background: #efefef" class="form-control" type="text" name="search_cat_list" id="search_cat_list" placeholder="Search Categories..."></div>';


        $a = $data->query("SELECT category FROM used_equipment WHERE active = 'true' GROUP BY category ORDER by category ASC")or die($data->error);
        while($b = $a->fetch_array()){
            if($b["category"] != '') {
                $c = $data->query("SELECT manufacturer FROM used_equipment WHERE category = '".$b["category"]."' GROUP BY manufacturer");
                while($d = $c->fetch_array()){
                    $manufa .= $d["manufacturer"].',';
                }

                $e = $data->query("SELECT isNew FROM used_equipment WHERE category = '".$b["category"]."' AND isNew = 'true'");
                $f = $e->num_rows;

                if($f > 0){
                    $isNew = 'true';
                }else{
                    $isNew = 'false';
                }

                //BREAKDOWN URL TO FIND CATEGORIES//
                if(!empty($catars)){
                    if(in_array($b["category"],$catars)){
                        $catAct = 'checknon-active';
                    }else{
                        $catAct = 'checknon';
                    }
                }else{
                    $catAct = 'checknon';
                }



                $html .= '<div class="col-lg-2 col-md-4 col-sm-5 catobj" style="margin: 5px" data-cats="'.$b["category"].'" data-cond="'.$isNew.'" data-toggle="tooltip" data-placement="top" title="' . $b["category"] . '" data-asscman="'.$manufa.'"><span class="filtertext catname"><i class="fa fa-check '.$catAct.'"></i> ' . $b["category"] . '</span></div>';
                $manufa = '';
            }
        }
        $html .= '<div style="clear:both; width: 100%; text-align: right">';
        $html .= '<button class="btn btn-sm btn-primary closthis" style="margin: 2px">Close</button>';
        $html .='</div>';
        $html .= '</div>';



        $html .= '<div class="row manbox" style="width: 98%; background: #fff; padding: 20px; border: solid thin #e5e5e5; left: 30px; z-index: 5; display: none;
    overflow: scroll;">';
        $html .= '<span class="badge badge-primary moreshow">More Below <i class="fas fa-chevron-down"></i></span>';
        $html .= '<div style="position: sticky; top: -20px; background: #fff; width: 100%; z-index: 5"><span class="closthis" style="position: absolute;right: 20px;top: 18px;color: #868383;font-size: 20px; cursor: pointer"><i class="fas fa-times"></i></span><h4 class="fliterheaders">Manufacturer</h4><input style="border-radius: 0;margin: 20px 0; background: #efefef" class="form-control" type="text" name="search_man_list" id="search_man_list" placeholder="Search Manufacturers..."></div>';
        $a = $data->query("SELECT manufacturer FROM used_equipment WHERE active = 'true' GROUP BY manufacturer ORDER by manufacturer ASC")or die($data->error);
        while($b = $a->fetch_array()){

            if($b["manufacturer"] != '') {

                $c = $data->query("SELECT category FROM used_equipment WHERE manufacturer = '".$data->real_escape_string($b["manufacturer"])."' GROUP BY category");
                while($d = $c->fetch_array()){
                    $catfa .= $d["category"].',';
                }

                //BREAKDOWN URL TO FIND CATEGORIES//
                if(!empty($manars)){
                    if(in_array($b["manufacturer"],$manars)){
                        $manAct = 'checknon-active';
                    }else{
                        $manAct = 'checknon';
                    }
                }else{
                    $manAct = 'checknon';
                }

                $html .= '<div class="col-lg-2 col-md-4 col-sm-5 manobj" style="margin: 5px" data-mans="'.$b["manufacturer"].'" data-asscat="'.$catfa.'"><span class="filtertext manname"><i class="fa fa-check '.$manAct.'"></i> ' . $b["manufacturer"] . '</span></div>';

            }
            $catfa = '';
        }
        $html .= '<div style="clear:both; width: 100%; text-align: right">';
        $html .= '<button class="btn btn-sm btn-primary closthis" style="margin: 2px">Close</button>';
        $html .='</div>';
        $html .= '</div>';


        $html .= '<div class="row morebox" style="width: 98%; background: #fff; padding: 20px; border: solid thin #e5e5e5; left: 30px; z-index: 5; display: none">';
        $html .= '<span class="closthis" style="position: absolute;    right: 33px; top: 38px;color: #868383;font-size: 20px; cursor: pointer"><i class="fas fa-times"></i></span><h4 class="fliterheaders">Additional Filters</h4>';

        $html .= '<div style="padding:20px; width: 100%">';

        $html .= '<label style="font-weight: bold">Locations</label><br>';

        $e = $data->query("SELECT city FROM used_equipment WHERE active = 'true' GROUP BY city");
        while($f = $e->fetch_array()){
            if($f["city"] != '') {

                if(isset($_REQUEST["locations"])){
                    $locOuts = explode('~',$_REQUEST["locations"]);
                    if(in_array($f["city"],$locOuts)){
                        $html .= '<button class="btn locbutt-active" data-loca="'.$f["city"].'">' . $f["city"] . '</button>';
                    }else{
                        $html .= '<button class="btn locbutt" data-loca="'.$f["city"].'">' . $f["city"] . '</button>';
                    }
                }else{
                    $html .= '<button class="btn locbutt" data-loca="'.$f["city"].'">' . $f["city"] . '</button>';
                }


            }
        }

        $html .= '<br><br>';
        $html .= '<div class="row input-group" style="padding: 6px 25px;">';

        if(isset($_REQUEST["years"])){
            $yearOuts = explode('-',$_REQUEST["years"]);
            $strYr = $yearOuts[0];
            $endYr = $yearOuts[1];
        }else{
            $strYr = 1900;
            $endYr = 2021;
        }

        $html .= '<div class="col-6"><label style="font-weight: bold">Year Range</label></div>';
        $html .= '<div class="col-6" style="text-align: right; color: #29aeff; font-weight: bold"><span id="stryear">1900</span> - <span id="endyear">2021</span></div>';
        $html .= '<input style="width: 100%" id="macyear" type="text" class="span2" value="" data-slider-min="1900" data-slider-max="2021" data-slider-step="5"  data-slider-value="['.$strYr.','.$endYr.']"/>';

        if(isset($_REQUEST["price"])){
            $priceOuts = explode('-',$_REQUEST["price"]);
            $strPr = $priceOuts[0];
            $endPr = $priceOuts[1];
        }else{
            $strPr = 0;
            $endPr = 200000;
        }

        $html .= '<div class="col-6"><label style="font-weight: bold">Price Range</label></div>';
        $html .= '<div class="col-6" style="text-align: right; color: #29aeff; font-weight: bold"><span id="strprice">0</span> - <span id="endprice">90000+</span></div>';
        $html .= '<input style="width: 100%" id="macprice" type="text" class="span2" value="" data-slider-min="0" data-slider-max="200000" data-slider-step="500" data-slider-value="['.$strPr.','.$endPr.']"/>';

        if(isset($_REQUEST["hours"])){
            $hoursOuts = explode('-',$_REQUEST["hours"]);
            $strHr = $hoursOuts[0];
            $endHr = $hoursOuts[1];
        }else{
            $strHr = 0;
            $endHr = 200000;
        }

        $html .= '<div class="col-6"><label style="font-weight: bold">Hour Range</label></div>';
        $html .= '<div class="col-6" style="text-align: right; color: #29aeff; font-weight: bold"><span id="strhour">0</span> - <span id="endhour">5000+</span></div>';
        $html .= '<input style="width: 100%" id="hourprice" type="text" class="span2" value="" data-slider-min="0" data-slider-max="5000" data-slider-step="10" data-slider-value="['.$strHr.','.$endHr.']"/>';

        $html .= '</div>';
        $html .= '</div>';


        $html .= '<div style="clear:both; width: 100%; text-align: right">';
        $html .= '<button class="btn btn-sm btn-primary closthis" style="margin: 2px">Close</button>';
        $html .='</div>';
        $html .= '</div>';
        $html .= '</div>';

        $html .= '<div class="row conbox" style="width: 98%; background: #fff; padding: 20px; border: solid thin #e5e5e5; left: 30px; z-index: 5; display: none;
    overflow: scroll;">';
        $html .= '<span class="badge badge-primary moreshow">More Below <i class="fas fa-chevron-down"></i></span>';
        $html .= '<div style="position: sticky; top: -20px; background: #fff; width: 100%; z-index: 5"><span class="closthis" style="position: absolute;right: 20px;top: 18px;color: #868383;font-size: 20px; cursor: pointer"><i class="fas fa-times"></i></span><h4 class="fliterheaders">Condition</h4></div>';
        $html .='HI JASON';
        $html .= '<div style="clear:both; width: 100%; text-align: right">';
        $html .= '<button class="btn btn-sm btn-primary closthis" style="margin: 2px">Close</button>';
        $html .='</div>';
        $html .= '</div>';





        $html .= '<div class="lds-ring"><div></div><div></div><div></div><div></div></div>';

        $html .= '<div class="useditems" style="background: #efefef; padding: 15px 10px; margin: 0 14px">';



        $html .= '</div>';




        $html .= '</div>';


        return $html;

    }
}