<?php
$act = $_REQUEST["action"];
if($act == 'pullmans'){
    include('../../config.php');
    //echo json_encode($_POST["cats"]);

    $html .= '<h4 class="fliterheaders">Manufacturer</h4>';

    $cats_selected = json_decode($_POST["cats"],true);
    $manus = array();
    foreach ($cats_selected as $key){
        $a = $data->query("SELECT manufacturer FROM used_equipment WHERE category = '$key' AND active = 'true' GROUP BY manufacturer")or die($data->error);
        while($b = $a->fetch_array()){
            $manus[] = $b["manufacturer"];
        }
    }

$mans = array_unique($manus);

    foreach ($mans as $key){
        $html .= '<div class="col-md-2 col-sm-4 manobj" style="margin: 5px" data-mans="'.$key.'"><span class="filtertext"><i class="fa fa-check checknon"></i> ' . $key . '</span></div>';
    }

    echo $html;
}

if($act == 'pullunits'){
    include('../../config.php');

    //DO THINGS FOR CATEGORY//



    if(isset($_POST["?categories"])){
        $cats_selected = $_POST["?categories"];
    }else{
        $cats_selected = $_POST["categories"];
    }


    if(isset($_POST["?listtype"])){
        $listType = $_POST["?listtype"];
    }else{
        $listType = $_POST["listtype"];
    }

    if(isset($listType) && $listType == 'list'){
        $setrow = '';
    }else{
        $setrow = 'row';
    }
    $unitOutput .= '<div class="mainusframe '.$setrow.'">';
   if($cats_selected != '') {
       $cats_selected = explode('~', $cats_selected);

       foreach ($cats_selected as $cats) {
           if ($cats != '') {
               $catsOut .= "'$cats',";
           }
       }

       $catsOut = rtrim($catsOut, ',');

       $totSql .= "AND category IN ($catsOut) ";
   }

    //DO THINGS FOR MANUFACTURER//

   if(isset($_POST["?manufacturer"])){
       $mans_selected = $_POST["?manufacturer"];
   }else{
       $mans_selected = $_POST["manufacturer"];
   }

    if($mans_selected != '') {
        $mans_selected = explode('~', $mans_selected);

            foreach ($mans_selected as $mans) {
                if ($mans != '') {
                    $mansOut .= "'$mans',";
                }
            }

            $mansOut = rtrim($mansOut, ',');

            $totSql .= "AND manufacturer IN ($mansOut) ";

    }

    if(isset($_POST["?locations"])){
        $location_selected = $_POST["?locations"];
    }else{
        $location_selected = $_POST["locations"];
    }

    if($location_selected != '') {
        $location_selected = explode('~', $location_selected);

        foreach ($location_selected as $locs) {
            if ($locs != '') {
                $locOut .= "'".$data->real_escape_string($locs)."',";
            }
        }

        $locOut = rtrim($locOut, ',');



        //$locOut = addslashes($locOut);

        $totSql .= "AND city IN ($locOut) ";

    }

    if(isset($_POST["?years"])){
        $year_selected = $_POST["?years"];
    }else{
        $year_selected = $_POST["years"];
    }

    if($year_selected != '') {

       $fixYear = explode('-',$year_selected);

       $startYear = $fixYear[0];
       $endYear = $fixYear[1];

        $totSql .= ' AND modelYear BETWEEN '.$startYear.' AND '.$endYear.'';
    }

    if(isset($_POST["?price"])){
        $price_selected = $_POST["?price"];
    }else{
        $price_selected = $_POST["price"];
    }

    if($price_selected != '') {

        $fixPrice = explode('-',$price_selected);

        $startPrice = $fixPrice[0];
        $endPrice = $fixPrice[1];

//        if($endPrice >= '95000'){
//            $totSql .= ' AND single_price > '.$startPrice.'';
//        }else{
//            $totSql .= ' AND single_price BETWEEN '.$startPrice.' AND '.$endPrice.'';
//        }

        $totSql .= ' AND single_price BETWEEN '.$startPrice.' AND '.$endPrice.'';
    }

    if(isset($_POST["?hours"])){
        $hours_selected = $_POST["?hours"];
    }else{
        $hours_selected = $_POST["hours"];
    }

    if($hours_selected != '') {

        $fixHour = explode('-',$hours_selected);

        $startHour = $fixHour[0];
        $endHour = $fixHour[1];

        $totSql .= ' AND operationHours BETWEEN '.$startHour.' AND '.$endHour.'';
    }


    if(isset($_POST["?eqcondition"])){
        $cond_selected = $_POST["?eqcondition"];
    }else{
        $cond_selected = $_POST["eqcondition"];
    }

    if($cond_selected != ''){


        if($cond_selected == 'Used'){
            $totSql .= ' AND isNew = "false"';
        }else{
            if($cond_selected == 'New'){
                $totSql .= ' AND isNew = "true"';
            }else{

            }
        }
    }


    if(isset($_POST["?sort"])){
        $sorttype = $_POST["?sort"];
    }else{
        $sorttype = $_POST["sort"];
    }

    if($sorttype != null){
        if($sorttype == 'mod-a-z'){$order = 'ORDER BY MODEL ASC';}
        if($sorttype == 'mod-z-a'){$order = 'ORDER BY MODEL DESC';}
        if($sorttype == 'price-low-high'){$order = 'ORDER BY CAST(single_price AS DECIMAL(10,2)) ASC';}
        if($sorttype == 'price-high-low'){$order = 'ORDER BY CAST(single_price AS DECIMAL(10,2)) DESC';}
        if($sorttype == 'hours-low-high'){$order = 'ORDER BY CAST(operationHours AS DECIMAL(10,2)) ASC';}
        if($sorttype == 'hours-high-low'){$order = 'ORDER BY CAST(operationHours AS DECIMAL(10,2)) DESC';}
        if($sorttype == 'year-new-old'){$order = 'ORDER BY CAST(modelYear AS DECIMAL(10,2)) DESC';}
        if($sorttype == 'year-old-new'){$order = 'ORDER BY CAST(modelYear AS DECIMAL(10,2)) ASC';}
        if($sorttype == 'man-a-z'){$order = 'ORDER BY manufacturer ASC';}
        if($sorttype == 'man-z-a'){$order = 'ORDER BY manufacturer DESC';}
        if($sorttype == 'cat-a-z'){$order = 'ORDER BY category ASC';}
        if($sorttype == 'cat-z-a'){$order = 'ORDER BY category DESC';}
        if($sorttype == 'recent'){$order = 'ORDER BY modified DESC';}

    }else{
        $order = 'ORDER BY order_pro ASC';
    }


//echo "THis is ".$totSql. ' '.$sorttype;


///PAGINATION STUFF//
    if (isset($_GET['pageno'])) {
        $pageno = $_GET['pageno'];
    } else {
        $pageno = 1;
    }
    $limit = 24;                                //how many items to show per page
    $page = $_GET["page"];

    if(isset($_POST["?search"]) || isset($_POST["search"])){
        if(isset($_POST["?search"])){
            $searchInput = $_POST["?search"];
        }else{
            $searchInput = $_POST["search"];
        }


        $pages_sql = $data->query("SELECT COUNT(*) as num  FROM used_equipment WHERE serialNumber LIKE '$searchInput' $totSql AND active = 'true' OR stockNumber LIKE '$searchInput' $totSql AND active = 'true' OR category LIKE '%$searchInput%' $totSql AND active = 'true' OR model LIKE '%$searchInput%' $totSql AND active = 'true' OR manufacturer LIKE '%$searchInput%' $totSql AND active = 'true' OR
CONCAT ('manufacturer', 'model') LIKE '%$searchInput%' $totSql AND active = 'true' OR
CONCAT ('manufacturer', 'category') LIKE '%$searchInput%' $totSql AND active = 'true'");
    }else{
        $pages_sql = $data->query("SELECT COUNT(*) as num FROM used_equipment WHERE active = 'true' $totSql $order")or die($data->error);
    }

    $total_num = $pages_sql->fetch_array();
    $total_pages = $total_num['num'];


    $limit = 24;                                //how many items to show per page
    $page = $_GET["page"];

    if($page)
        $start = ($page - 1) * $limit;          //first item to display on this page
    else
        $start = 0;                             //if no page var is given, set start to
    /* Get data. */

    /* Setup page vars for display. */
    if ($page == 0) $page = 1;                  //if no page var is given, default to 1.
    $prev = $page - 1;                          //previous page is page - 1
    $next = $page + 1;                          //next page is page + 1
    $lastpage = ceil($total_pages/$limit);      //lastpage is = total pages / items per page, rounded up.
    $lpm1 = $lastpage - 1;                      //last page minus 1

    $pagination = "";
    if($lastpage > 1)
    {
        $pagination .= '<div class="btn-group" role="group" aria-label="Basic example">';
        //previous button
        if ($page > 1)
            //$pagination.= "<a href=\"videos-$prev.html\">« previous</a>";
            $pagination .= '<button type="button" class="btn btn-secondary previ" onclick="pageData(\''.$prev.'\')"><i class="fa fa-chevron-left"></i> Previous</button><button type="button" class="btn btn-secondary" onclick="pageData(\'1\')">First Page</button>';

        else
            //$pagination.= "<span class=\"disabled\">« previous</span>";
            $pagination .= '<button type="button" class="btn btn-secondary disabled">Previous</button>';

        //next button
        if ($page < $lastpage)
            //$pagination.= "<a href=\"videos-$next.html\">next »</a>";
            $pagination .= '<button type="button" class="btn btn-secondary" onclick="pageData(\''.$lastpage.'\')">Last Page</button><button type="button" class="btn btn-secondary" onclick="pageData(\''.$next.'\')">Next <i class="fa fa-chevron-right"></i></button>';
        else
            //$pagination.= "<span class=\"disabled\">next »</span>";
            $pagination .= '<button type="button" class="btn btn-secondary disabled">Next</button>';
        $pagination.= "</div>";
    }



    if(isset($_POST["?search"]) || isset($_POST["search"])){
        if(isset($_POST["?search"])){
            $searchInput = $_POST["?search"];
        }else{
            $searchInput = $_POST["search"];
        }

        $a = $data->query("SELECT id, category, equip_id, images, options, description, single_price, city, manufacturer, model, modelYear, stockNumber, operationHours  FROM used_equipment WHERE serialNumber LIKE '$searchInput' $totSql AND active = 'true' OR stockNumber LIKE '$searchInput' $totSql AND active = 'true' OR category LIKE '%$searchInput%' $totSql AND active = 'true' OR model LIKE '%$searchInput%' $totSql AND active = 'true' OR manufacturer LIKE '%$searchInput%' $totSql AND active = 'true' OR
CONCAT ('manufacturer', 'model') LIKE '%$searchInput%' $totSql AND active = 'true' OR
CONCAT ('manufacturer', 'category') LIKE '%$searchInput%' $totSql AND active = 'true' $order LIMIT $start, $limit");
    }else{
        $a = $data->query("SELECT id, category, equip_id, images, options, description, single_price, city, manufacturer, model, modelYear, stockNumber, operationHours  FROM used_equipment WHERE active = 'true' $totSql $order LIMIT $start, $limit");
    }

    //====== New Schema.org generator for product list in Machine Finder Two ======//
    //* Insert that code inside pages.php under line 18(default)"if ($a->num_rows > 0) {"

    $numbOfItems = count($a->fetch_array());
    $schemaOutput .= '<script type="application/ld+json">';
    $schemaOutput .= '{"@context": "https://schema.org","@type": "ItemList","url": "' . $actual_link . '","numberOfItems": "'.$numbOfItems.'",';
    $schemaOutput .= '"itemListElement": [';
    $r = 1;
    //====== End of Schema.org generator for product list in Machine Finder Two ======//

       while($b = $a->fetch_array()){
           if($b["equip_id"] != ''){
           //$equipUnits[] = array("equip_id"=>$b["equip_id"], "images"=>$b["images"], "options"=>$b["options"], "description"=>$b["description"], "single_price"=>$b["single_price"], "city"=>$b["city"], "manufacturer"=>$b["manufacturer"], "model"=>$b["model"], "modelYear"=>$b["modelYear"], "stockNumber"=>$b["stockNumber"]);

               $fixImg = ltrim($b["images"], "(");
               $fixImg = rtrim($fixImg, ")");

               $fixImg = stripcslashes($fixImg);

               $imageDecode = json_decode($fixImg, true);

               $cleanImg = $imageDecode["image"][0]["filePointer"];
               $cleanImg2 = $imageDecode["image"]["filePointer"];

               if ($cleanImg != null) {
                   $mainImg = $cleanImg;
               } else {
                   $mainImg = "img/noimg.jpg";
               }

               if($b["operationHours"] != ''){
                   $hours = $b["operationHours"];
               }else{
                   $hours = '0';
               }

               if($b["modelYear"] != ''){
                   $modYear = $b["modelYear"];
               }else{
                   $modYear = 'Not Specified';
               }

               $actual_link = 'Used-Equipment-Two';




               //$unitOutput .= '<div class="row" style="padding:20px; border-bottom: solid thin #a1a1a1; width: 100%"><div class="col-md-4 img-thumbnail" style="background-image: url(' .$mainImg.'); background-size: cover; background-position: top; background-repeat: no-repeat;"><img style="width: 100%" src="img/spacer.png"></div><div class="col-md-8"><h3 class="product-title">'.$b["manufacturer"].' '.$b["model"].'</h3><h4 class="price"><span>$'.number_format($b["single_price"]).'</span></h4><ul style="list-style: none; margin: 0; padding: 0"><li><strong>Category:</strong> '.$b["category"].'</li></ul></div></div>';



               if(isset($_POST["?listtype"])){
                   $listType = $_POST["?listtype"];
               }else{
                   $listType = $_POST["listtype"];
               }

               if(isset($listType) && $listType == 'list'){

                   if ($b["options"] != 'null' && $b["options"] != '(["\n  "])') {
                       $cleanOpts = trim($b["options"], ')');
                       $cleanOpts = trim($cleanOpts, '(');

                       $options = json_decode($cleanOpts, true);

                       //  var_dump($options);

                       $options = $options["option"];

                       $theOptions .= '<table class="table">';


                       for($j=0; $j < 3; $j++){

                           if($options[$j]["label"] != null){
                               $theOptions .= '<tr><td><strong>' . ucwords($options[$j]["label"]) . '</strong></td><td>' . $options[$j]["value"] . '</td></tr>';
                           }else{
                               if($options[$j]["value"] != '') {
                                   $theOptions .= '<tr style="background: #f7f7f7; font-size: 12px"><td colspan="2">' . $options[$j]["value"] . '</td></tr>';
                               }
                           }

                       }

                       $theOptions .= '</table>';
                   }

//           $theOptions .= '<li class="col">'..'</li>';



                   $unitOutput .= '<div class="row p-2 bg-white border rounded mt-2" style="margin: 0">
                <div class="col-md-3 mt-1"><a href="'.$actual_link.'/'.str_replace(' ', '-',$b["manufacturer"]).'/'.str_replace(' ', '-',$b["category"]).'/'.str_replace(' ', '-',$b["model"]).'/'.$b["id"].'"><img class="img-fluid img-responsive rounded product-image" src="'.$mainImg.'"></a></div>
                <div class="col-md-6 mt-1">
                    <a href="'.$actual_link.'/'.str_replace(' ', '-',$b["manufacturer"]).'/'.str_replace(' ', '-',$b["category"]).'/'.str_replace(' ', '-',$b["model"]).'/'.$b["id"].'"><h4>'.$b["manufacturer"].' '.$b["model"].'</h4></a>
                    
                    <div class="mt-1 mb-1 spec-1"><span class="dot"></span><span><strong>Type:</strong> '.$b["category"].'</span><br><span class="dot"></span><span><strong>Location:</strong> '.$b["city"].'<br></span></div>
                    <br>
                    <p class="text-justify text-truncate para mb-0">'.$b["description"].'<br><br>'.$theOptions.'<br></p>
                </div>
                <div class="align-items-center align-content-right col-md-3 border-left mt-1">
                    <div class="d-flex flex-row align-items-right" style="text-align: right">
                        <h4 class="mr-1">$'.number_format($b["single_price"]).'</h4>
                    </div>
                    Stock #: '.$b["stockNumber"].'<br>Year: '.$modYear.'<br>Hours: '.$hours.'<br>
                    <div class="d-flex flex-column mt-4"><a href="'.$actual_link.'/'.str_replace(' ', '-',$b["manufacturer"]).'/'.str_replace(' ', '-',$b["category"]).'/'.str_replace(' ', '-',$b["model"]).'/'.$b["id"].'" class="btn btn-primary btn-sm" type="button">More Details</a><!--<button class="btn btn-outline-primary btn-sm mt-2" type="button">Add to wishlist</button>--></div>
                </div>
            </div>';

                   $theOptions = '';

               }else{
                   $unitOutput .= '<div class="col-sm-12 col-md-6 col-lg-4 col-xl-3"><a style="text-decoration: none; color: #333" href="'.$actual_link.'/'.str_replace(' ', '-',$b["manufacturer"]).'/'.str_replace(' ', '-',$b["category"]).'/'.str_replace(' ', '-',$b["model"]).'/'.$b["id"].'">
                                      <div class="card mb-4 shadow-sm">
                                        <img src="'.$mainImg.'" alt="'.$b["manufacturer"].' '.$b["model"].'" style="object-fit: cover; height: 238px; width: 100%;" >
                                        <div class="card-body" style="background: #fff">
                                          
                                          <div class="row">
                                              <div class="col" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">
                                                <strong>'.$b["manufacturer"].'<br>'.$b["model"].'</strong><br><small>Type: '.$b["category"].'</small><br><small>Location: '.$b["city"].'</small>
                                              </div>
                                              <div class="col" style="text-align: right" >
                                                <span style="font-size: 30px"><span>$</span><span content="'.str_replace(",",".",number_format($b["single_price"])).'">'.number_format($b["single_price"]).'</span></span><br><small>Year: '.$modYear.'</small><br><small>Hours: '.$hours.'</small>
                                              </div>
                                          </div>
                                          <div class="d-flex justify-content-between align-items-center">
                                            <div class="btn-group">
                                              <!--nothing-->
                                            </div>
                                          </div>
                                        </div>
                                      </div></a>
                                    </div>';

                   $schemaOutput .= '{"@type": "Product",';
                   $schemaOutput .= '"image": "' . $mainImg . '",';
                   $schemaOutput .= '"position": "'.$r++.'",';
                   $schemaOutput .= '"url": "' . $actual_link . '/' . str_replace(' ', '-', $b["manufacturer"]) . '/' . str_replace(' ', '-', $b["category"]) . '/' . str_replace(' ', '-', $b["model"]) . '/' . $b["id"] . '",';
                   $schemaOutput .= '"brand": "' . $b["manufacturer"] . '",';
                   $schemaOutput .= '"model": "' . $b["model"] . '",';
                   $schemaOutput .= '"productionDate": "' . $b["modelYear"] . '",';
                   $schemaOutput .= '"sku": "' . $b["stockNumber"] . '",';
                   $schemaOutput .= '"name": "' . $b["modelYear"] . ' ' . $b["manufacturer"] . ' ' . $b["model"] . '",';
                   $schemaOutput .= '"category": "' . $b["category"] . '",';
                   $schemaOutput .= '"offers": {"@type": "Offer","priceCurrency": "USD",';
                   if ($b["price"] != null) {
                       $schemaOutput .= '"price": "' . $b["price"] . '",';
                   } else {
                       $schemaOutput .= '"price": "' . $b["single_price"] . '",';
                   }
                   $schemaOutput .= '"itemCondition": "http://schema.org/UsedCondition","availability": "http://schema.org/InStock"}},';
               }

           }
       }
       $unitOutput .= '<div class="col-md-12" style="text-align: right">'.$pagination.'</div>';

    $unitOutput .= '</div>';

    $schemaOutput = substr($schemaOutput, 0, -1);
    $schemaOutput .= ']}';
    $schemaOutput .= '</script>';
    echo $schemaOutput;

   echo $unitOutput;


}

if($act == 'searchunits'){
    include('../../config.php');
    $searchInput = $_POST["query"];

    $a = $data->query("SELECT id, images, model, manufacturer, modelYear, clearnace, operationHours, single_price, category  FROM used_equipment WHERE serialNumber LIKE '$searchInput' AND active = 'true' OR stockNumber LIKE '$searchInput' AND active = 'true' OR category LIKE '%$searchInput%' AND active = 'true' OR model LIKE '%$searchInput%' AND active = 'true' OR manufacturer LIKE '%$searchInput%' AND active = 'true' OR
CONCAT ('manufacturer', 'model') LIKE '%$searchInput%' AND active = 'true' OR
CONCAT ('manufacturer', 'category') LIKE '%$searchInput%' AND active = 'true' GROUP BY category ");

    while($b = $a->fetch_array()){

       $filterBreaks[] = array("category"=>$b["category"],"manufacturer"=>$b["manufacturer"]);
    }

    echo json_encode($filterBreaks);

}
