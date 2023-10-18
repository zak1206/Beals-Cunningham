<?php

$act = $_REQUEST["action"];

if($act == 'dourlwork'){
    $url = $_REQUEST["urlstring"];
    $url = str_replace('?','',$url);
    $url = explode('&',$url);

    foreach($url as $key){
        if (strpos($key, 'category') !== false){
            $cats[] = urldecode(str_replace('category=','',$key));
        }

        if (strpos($key, 'manufacturer') !== false){
            $mans[] = str_replace('manufacturer=','',$key);
        }

        if (strpos($key, 'model') !== false){
            $model[] = str_replace('model=','',$key);
        }


    }

    $rets = array("cats"=>$cats, "mans"=>$mans, "mods"=>$model);
    echo json_encode($rets);
}

if($act == 'filter'){
    include('../../config.php');
   $filters = json_decode($_POST["filters"],true);
    //var_dump($filters);

    //echo 'sdfsdfs';

    $theType = key($filters[0]);

    for($i=0; $i< count($filters); $i++){
        $theType = key($filters[$i]);

       // var_dump($filters[$i][$theType]);
        if(!empty($filters[$i][$theType])){

            $selections = $filters[$i][$theType];
            unset($ids);
            for($j=0; $j<count($selections); $j++){
                $ars[] = $selections[$j]["item"];
            }

            $ids[$i] = implode("','",$ars);

            unset($ars);
            //var_dump($ars);

            $sql[] = "$theType IN ('$ids[$i]')";

        }
    }


//    var_dump($sql);

    for($u=0; $u<count($sql); $u++){
        if($u > 0){
            $sqlOut .= ' AND '.$sql[$u].'AND active=\'true\'';
        }else{
            $sqlOut .= $sql[$u].' AND active=\'true\'';
        }
    }

//echo $sqlOut;
    $bounce = array();
    $bounce2 = array();
    $bounce3 = array();
    $bounce4 = array();
    $a = $data->query("SELECT model, modelYear FROM used_equipment WHERE $sqlOut");
    while($b = $a->fetch_assoc()){
//        $bounce[] = $b["manufacturer"];
//        $bounce2[] = $b["category"];
        $bounce3[] = $b["model"];
        $bounce4[] = $b["modelYear"];

    }

   // $dits[] = array();

//    $dits["category"] = array_unique($bounce2);
//    $dits["manufacturer"] = array_unique($bounce);
    $dits["models"] = array_unique($bounce3);
    $dits["years"] = array_unique($bounce4);

    echo json_encode($dits);


}


////===========GET RESULTS============////

if($act == 'getresults'){
    include('../../config.php');
    $filters = json_decode($_POST["filters"],true);

    //var_dump($filters);


    ///PRICE INFO///
    $price_from = $_POST["price_from"];
    $price_to = $_POST["price_to"];

    $hours_from = $_POST["hours_from"];
    $hours_to = $_POST["hours_to"];

    $year_from = $_POST["year_from"];
    $year_to = $_POST["year_to"];

    $sorttype = $_POST["sorttype"];

    $storage = array("filters_saved"=>$filters,"price_from"=>$price_from,"price_to"=>$price_to, "hours_from"=>$hours_from, "hours_to"=>$hours_to, "year_from"=>$year_from, "year_to"=>$year_to, "viewtype"=>$_POST["viewtype"], "pageon"=>$_GET["page"], "sorttype"=>$sorttype);

    $storage = json_encode($storage);
    session_start();
    $_SESSION["used_filters"] = $storage;



    $adjacents = 5;

    $theType = key($filters[0]);

    for($i=0; $i< count($filters); $i++){
        $theType = key($filters[$i]);

        // var_dump($filters[$i][$theType]);
        if(!empty($filters[$i][$theType])){

            $selections = $filters[$i][$theType];
            unset($ids);
            for($j=0; $j<count($selections); $j++){
                $ars[] = $selections[$j]["item"];
            }

            $ids[$i] = implode("','",$ars);

            unset($ars);
            //var_dump($ars);

            $sql[] = "$theType IN ('$ids[$i]')";

        }
    }


    // var_dump($sql);

    for($u=0; $u<count($sql); $u++){
        if($u > 0){
            $sqlOut .= ' AND '.$sql[$u].' AND active = \'true\'';
        }else{
            $sqlOut .= $sql[$u]. 'AND active = \'true\'';
        }
    }

    if($sqlOut != null){
        $sqlOut = $sqlOut;
    }else{
        $sqlOut = 'active = \'true\'';
    }

    ///echo "This is price to".$sqlOut;
    ///

    ///CHECK SORTERS//
    $sorttype = $_POST["sorttype"];

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

    }else{
        $order = 'ORDER BY order_pro ASC';
    }


    if($year_from == '1900'){
        $year_from = 0;
    }


    //DO COUNT STUFF//
    $aa = $data->query("SELECT COUNT(*) as num FROM used_equipment WHERE $sqlOut AND single_price BETWEEN $price_from AND $price_to AND operationHours BETWEEN $hours_from AND $hours_to AND modelYear BETWEEN $year_from AND $year_to $order")or die($data->error.'error v');
    $total_pages = $aa->fetch_array();
    $total_pages = $total_pages['num'];

    $limit = 24;                                //how many items to show per page
    $page = $_GET["page"];

    if($page)
        $start = ($page - 1) * $limit;          //first item to display on this page
    else
        $start = 0;                             //if no page var is given, set start to
    /* Get data. */
    $result = $data->query("SELECT images, model, manufacturer, modelYear, clearnace, operationHours, single_price FROM used_equipment WHERE $sqlOut AND single_price BETWEEN $price_from AND $price_to AND operationHours BETWEEN $hours_from AND $hours_to AND modelYear BETWEEN $year_from AND $year_to $order LIMIT $start, $limit")or die($data->error.'error c');

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
            $pagination .= '<button type="button" class="btn btn-secondary" onclick="pageData(\''.$prev.'\')"><i class="fa fa-chevron-left"></i> Previous</button><button type="button" class="btn btn-secondary" onclick="pageData(\'1\')">First Page</button>';

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



    $sortableObje = array("Recent"=>'recent', "Model A-Z"=>'mod-a-z', "Model Z-A"=>'mod-z-a', "Price Low-High"=>'price-low-high', "Price High-Low"=>'price-high-low', "Hours Low-High"=>'hours-low-high', "Hours High-Low"=>'hours-high-low', "Year New-Old"=>'year-new-old', "Year Old-New"=>'year-old-new', "Manufacturer A-Z"=>'man-a-z', "Manufacturer Z-A"=>'man-z-a', "Category A-Z"=>'cat-a-z', "Category Z-A"=>'cat-z-a');

    $sortnot=false;
    foreach($sortableObje as $key=>$val){

        if($sorttype == $val && $sortnot == false){
            $sorterset = $key;
            $sortnot = true;

        }else{
            if($sortnot != true){
                $sorterset = 'Sort';
            }else{

            }

        }
        $thesorts .= '<a class="dropdown-item sorters" href="javascript:void(0)" data-dorttype="'.$val.'">'.$key.'</a>';
    }

    //VIEW TYPE SET//

    $viewType = $_POST["viewtype"];

    if($viewType == 'grid' || $viewType == null){
        $gridActive = 'active';
        $listActive = '';
    }else{
        $gridActive = '';
        $listActive = 'active';
    }


    $a = $data->query("SELECT id, images, model, manufacturer, modelYear, clearnace, operationHours, single_price, stockNumber, city, category, serialNumber, description FROM used_equipment WHERE $sqlOut AND single_price BETWEEN $price_from AND $price_to AND operationHours BETWEEN $hours_from AND $hours_to AND modelYear BETWEEN $year_from AND $year_to $order LIMIT $start, $limit")or die($data->error.'error t');
    $html .= '<div class="row">';




    $html .= '<div class="col-md-4"><div class="btn-group">
  <button type="button" class="btn btn-primary show-sort">'.$sorterset.'</button>
  <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="sr-only">Toggle Dropdown</span>
  </button>
  <div class="dropdown-menu">
  
  
    '.$thesorts.'
  </div>
</div> <div class="btn-group" role="group" aria-label="Basic example">
  <button type="button" class="btn btn-secondary '.$gridActive.'" onclick="setViewType(\'grid\')"><i class="fa fa-th-large" style="margin:0"></i></button>
  <button type="button" class="btn btn-secondary '.$listActive.'" onclick="setViewType(\'list\')"><i class="fa fa-list" style="margin:0"></i></button>
  
</div></div><div class="col-md-8" style="text-align: right; padding: 20px"><span class="badge badge-primary">Total Results: '.$total_pages.'</span> | <span class="badge badge-warning">Total Pages: '.$lastpage.'</span> <span class="badge badge-success">Current Page: '.$page.'</span> <span class="badge badge-info">Current Price Range: $'.number_format($price_from,2).'-$'.number_format($price_to,2).'</span></div>';

    if($a->num_rows > 0) {

        while ($b = $a->fetch_assoc()) {

            $fixImg = ltrim($b["images"], "(");
            $fixImg = rtrim($fixImg, ")");

            $fixImg = stripcslashes($fixImg);

            $imageDecode = json_decode($fixImg, true);


            ////GET MAIN IMAGE///
            for($t=0; $t<count($imageDecode);$t++){
                if(!empty($imageDecode["image"][$t]["@attributes"]) && $imageDecode["image"][$t]["filePointer"] != null){
                    $cleanImg = $imageDecode["image"][$t]["filePointer"];
                }else{
                    $cleanImg = '';
                }
            }



            //$cleanImg = $imageDecode["image"][0]["filePointer"];
            $cleanImg2 = $imageDecode["image"][1]["filePointer"];

            if ($cleanImg != null) {
                $mainImg = $cleanImg;
            } else {
                $mainImg = 'https://via.placeholder.com/150?text=No Image';
            }

            if ($b["modelYear"] != null) {
                $theYear = '<span class="product-new-label" style="background: #fff80f; color: #000">Year: ' . $b["modelYear"] . '</span>';
            } else {
                $theYear = '';
            }

            if ($b["clearnace"] != null) {
                $theClearance = '<span class="product-new-label" style="background: #ed5564">Clearance</span>';
            } else {
                $theClearance = '';
            }

            if ($b["operationHours"] != 0) {
                $theHours = '<span class="product-discount-label" style="background: #ed5564; color: #fff">Hours: ' . $b["operationHours"] . '</span>';
            } else {
                $theHours = '';
            }

            //ar_dump($imageDecode);


            //$html .= '<div class="col-md-3"><img style="width: 100%" src="'.$mainImg.'"><br><small>'.$b["model"].'</small></div>';

            if($_POST["viewtype"] == 'list') {

                $link = str_replace(' ','-',$b["category"]).'/'.str_replace(' ','-',$b["manufacturer"]).'-'.str_replace(' ','-',$b["model"]).'-'.$b["id"];


                $html .= '<div class="col-md-12 row" style="margin: 15px 0; border-bottom: solid thin #333; padding-bottom:20px">
                            <div class="col-md-4">
                                <div class="product-grid" style="min-height: 100%; padding: 0">
                                    <div class="product-image">
                                        <a href="Used-Equipment/'.$link.'">
                                            <img class="pic-1" src="' . $mainImg . '">
                                            <img class="pic-2" src="' . $cleanImg2 . '">
                                        </a>
                                    </div>
                                 </div>
                             </div>
                           <div class="col-md-8">
                           <strong style="font-size: 25px">' . $b["manufacturer"] . ' ' . $b["model"] . '</strong> - $' . number_format($b["single_price"], 2) . '<br>
                           <table class="table">
                           <tr><td><b>Stock#</b> ' . $b["stockNumber"] . '</td><td><b><b>Serial#</b> ' . $b["serialNumber"] . '</td></tr>
                           <tr><td><b>Hours:</b> ' . $b["operationHours"] . '</td><td><b>Year</b> ' . $b["modelYear"] . '</td></tr>
                           <tr><td><b>Category:</b> ' . $b["category"] . '</td><td><b>Location:</b> ' . $b["city"] . '</td></tr>
</table><p style="padding: 10px">' . $b["description"] . '</p><br><a href="Used-Equipment/'.$link.'" class="btn btn-success">Get More Details</a>
                           </div>
                           <div class="clearfix"></div>
                           <br><br>
                    </div>';

                $mainImg = '';
            }else{

                $link = str_replace(' ','-',$b["category"]).'/'.str_replace(' ','-',$b["manufacturer"]).'-'.str_replace(' ','-',$b["model"]).'-'.$b["id"];

                $html .= '<div class="col-md-4 col-lg-3 col-sm-6">
            <div class="product-grid drop-shadow" style="max-height: 200px; min-height: 300px; margin-bottom: 20px">
                <div class="product-image">
                    <a href="Used-Equipment/'.$link.'">
                        <img class="pic-1" src="' . $mainImg . '">
                        <img class="pic-2" src="' . $cleanImg2 . '">
                    </a>
                    ' . $theHours . '
                    ' . $theClearance . '
                    ' . $theYear . '

                </div>

                <div class="product-content">
                    <h3 class="title" style="background: none"><a style="font-size: 20px; color:#000" href="Used-Equipment/'.$link.'">' . $b["manufacturer"] . ' ' . $b["model"] . '</a></h3>
                    <div class="price" style="font-size:18px; color: red">Only $' . number_format($b["single_price"]) . '
                    </div>
                </div>
            </div>
        </div>';
                $mainImg = '';
            }



        }

    }else{
        $html .= '<div class="alert alert-warning alert-dismissible fade show" role="alert" style="width: 100%">
  <strong>Whoops!</strong> No results were found with the current filter / search parameters.<br>
  <ul>
  <li>Try adjusting the pricing filter</li>
  <li>Try adjusting the year / hours filter</li>
  <li>Make sure you have spelled the word correct when searching.</li>
</ul>
  
</div>';
    }



        $html .= '</div>';

    $html .= '<div class="row"><div class="col-md-4" style="text-align: left">'.$pagination.'</div><div class="col-md-8" style="text-align: right"><span class="badge badge-primary">Total Results: '.$total_pages.'</span> | <span class="badge badge-warning">Total Pages: '.$lastpage.'</span> <span class="badge badge-success">Current Page: '.$page.'</span> <span class="badge badge-info">Current Price Range: $'.number_format($price_from,2).'-$'.number_format($price_to,2).'</span></div></div>';


    
    echo $html;
}


//////////////////=============SEARCH FOR EQUIPMENT================///////////////

if($act == 'inputsearch'){
    include('../../config.php');
    $searchInput = $_POST["searchinput"];

    $multiWord = explode(' ',$searchInput);



//    $a = $data->query("SELECT images, model, manufacturer, modelYear, clearnace, operationHours, single_price  FROM used_equipment WHERE category LIKE '%$searchInput%' OR model LIKE '%$searchInput%' OR MATCH(description) AGAINST('$searchInput') OR MATCH(options) AGAINST('$searchInput') OR MATCH(model) AGAINST('$searchInput') OR manufacturer LIKE '%$searchInput%' OR
//CONCAT ('manufacturer', 'model') LIKE '%$searchInput%' OR
//CONCAT ('manufacturer', 'category') LIKE '%$searchInput%' ORDER BY category");

    $a = $data->query("SELECT id, images, model, manufacturer, modelYear, clearnace, operationHours, single_price  FROM used_equipment WHERE category LIKE '%$searchInput%' AND active = 'true' OR model LIKE '%$searchInput%' AND active = 'true' OR manufacturer LIKE '%$searchInput%' AND active = 'true' OR
CONCAT ('manufacturer', 'model') LIKE '%$searchInput%' AND active = 'true' OR
CONCAT ('manufacturer', 'category') LIKE '%$searchInput%' AND active = 'true' ORDER BY category");

////FOR TRUE SEARCH ENGINE RUN THIS ON DB COLUMNS ALTER TABLE used_equipment ADD FULLTEXT(columnnamehere);
   //$a = $data->query("SELECT * FROM used_equipment WHERE MATCH(description) AGAINST('$searchInput') ORDER BY category") or die($data->error);


    $html .= '<h4>Quick Search: <i>'.$searchInput.'</i></h4><br>';
    $html .= '<div style="padding: 20px; text-align: right">'.$a->num_rows. ' Results Found</div>';
    $html .= '<div class="row" style="margin: 0" itemscope itemtype="https://schema.org/ItemList">';



    while($b = $a->fetch_assoc()) {

        $fixImg = ltrim($b["images"], "(");
        $fixImg = rtrim($fixImg, ")");

        $fixImg = stripcslashes($fixImg);

        $imageDecode = json_decode($fixImg, true);

        $cleanImg = $imageDecode["image"]["filePointer"];
        $cleanImg2 = $imageDecode["image"][0]["filePointer"];

        if ($cleanImg != null) {
            $mainImg = $cleanImg;
        }else {
            $mainImg = "img/noimg.jpg";
        }

        if($b["modelYear"] != null){
            $theYear = '<span class="product-new-label" style="background: #fff80f; color: #000">Year: ' .$b["modelYear"].'</span>';
        }else{
            $theYear = '';
        }

        if($b["clearnace"] != null){
            $theClearance = '<span class="product-new-label" style="background: #ed5564">Clearance</span>';
        }else{
            $theClearance = '';
        }

        if($b["operationHours"] != 0){
            $theHours = '<span class="product-discount-label" style="background: #ed5564; color: #fff">Hours: ' .$b["operationHours"].'</span>';
        }else{
            $theHours = '';
        }

        $link = str_replace(' ','-',$b["category"]).'/'.str_replace(' ','-',$b["manufacturer"]).'-'.str_replace(' ','-',$b["model"]).'-'.$b["id"];


        //ar_dump($imageDecode);


        $html .= '<div class="col-md-4 col-lg-3 col-sm-6">
            <div class="product-grid" style="max-height: 200px; min-height: 300px; box-shadow: 1px 2px 4px #949292; margin-bottom: 20px" itemprop="itemListElement" itemscope itemtype="https://schema.org/Product">
                <div class="product-image">
                    <a href="Used-Equipment'.$link.'" target="_blank">
                        <img class="pic-1" itemprop="image" src="'.$mainImg.'" alt="'.$b["manufacturer"].' '.$b["model"].'">
                        <img class="pic-2" itemprop="image" src="'.$cleanImg2.'" alt="'.$b["manufacturer"].' '.$b["model"].'">
                    </a>
                    '.$theHours.'
                    '.$theClearance.'
                    '.$theYear.'
                    
                </div>
               
                <div class="product-content">
                    <h3 class="title" style="background: none"><a style="font-size: 20px; color:#000" href="Used-Equipment/'.$link.'" itemprop="name">'.$b["manufacturer"].' '.$b["model"].'</a></h3>
                    <div itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                    <div class="price" style="font-size:18px; color: red">Only <span itemprop="priceCurrency" content="USD">$</span><span itemprop="price">'.number_format($b["single_price"]).'</span></div>
                    </div>
                </div>
            </div>
        </div>';
    }

    $html .= '</div>';

    echo $html;
}