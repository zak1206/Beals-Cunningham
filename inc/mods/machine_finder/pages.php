<?php
class machine_finder
{
    function page($page)
    {

        include('inc/config.php');

        $pos = strrpos($page, '-');
        $id = $pos === false ? $page : substr($page, $pos + 1);
        //$id = substr($page, strrpos($page, '-') + 1);

        if (is_numeric($id)) {

            $a = $data->query("SELECT * FROM used_equipment WHERE id = $id");
            $b = $a->fetch_array();

            if ($a->num_rows > 0) {

                //====== New Schema.org generator for single product in Machine Finder ======//
                //* Insert that code inside pages.php under line 18(default)"if ($a->num_rows > 0) {"

                $htmlOut .= '<script type="application/ld+json">{';
                $htmlOut .= '"@context": "https://schema.org",';
                $htmlOut .= '"@type": "Product",';
                $htmlOut .= '"brand": "'.$b["manufacturer"].'",';
                $htmlOut .= '"model": "'.$b["model"].'",';
                $htmlOut .= '"productionDate": "'.$b["modelYear"].'",';
                $htmlOut .= '"sku": "'.$b["stockNumber"].'",';
                $htmlOut .= '"name": "'.$b["modelYear"].' '.$b["manufacturer"].' '.$b["model"].'",';
                $htmlOut .= '"category": "'.$b["category"].'",';

                $cleanImgforSchema = trim($b["images"], ')');
                $cleanImgforSchema = trim($cleanImgforSchema, '(');
                $cleanImgforSchema = stripcslashes($cleanImgforSchema);
                $imagesforSchema = json_decode($cleanImgforSchema, true);
                $theImagesforSchema = $imagesforSchema["image"];

                if ($theImagesforSchema["filePointer"] == "") {
                    $htmlOut .= '"image": "'.$theImagesforSchema[0]["filePointer"].'",';
                } else {
                    $htmlOut .= '"image": "'.$theImagesforSchema["filePointer"].'",';
                }
                $htmlOut .= '"description": "'.$b["description"].'",';
                $htmlOut .= '"offers": {"@type": "Offer","priceCurrency": "USD",';
                if ($b["price"] != null) {
                    $htmlOut .= '"price": "'.$b["price"].'",';
                } else {
                    $htmlOut .= '"price": "'.$b["single_price"].'",';
                }
                $htmlOut .= '"itemCondition": "http://schema.org/UsedCondition","availability": "http://schema.org/InStock"}';
                $htmlOut .= '}</script>';
                //====== End of Schema.org generator for single product in Machine Finder ======//

                $htmlOut .= '<div class="row">';
                $htmlOut .= '<div class="col-md-7">';
                //PROCESS IMAGES//
                $cleanImg = trim($b["images"], ')');
                $cleanImg = trim($cleanImg, '(');

                $cleanImg = stripcslashes($cleanImg);

                $images = json_decode($cleanImg, true);


                $theImages = $images["image"];

                for ($i = 0; $i < count($theImages); $i++) {
                    if(count($theImages[0]["filePointer"]) == 0){
                        $imgBox .= '<div><img style="width: 100%" src="img/noimg.jpg" alt="' .$b["modelYear"] .' '. $b["manufacturer"] . ' ' . $b["model"] . '"></div>';
                    }else {
                        $imgBox .= '<div><img style="width: 100%" src="' . $theImages[$i]["filePointer"] . '" alt="' .$b["modelYear"] .' '. $b["manufacturer"] . ' ' . $b["model"] . '"></div>';
                        $imgThumb .= '<div style="border:solid 3px #fff; max-height: 200px; overflow: hidden"><img style="width: 100%" src="' . $theImages[$i]["filePointer"] . '" alt="' .$b["modelYear"] .' '. $b["manufacturer"] . ' ' . $b["model"] . '"></div>';
                    }
                }


                $htmlOut .= '<div class="your-class">
                              ' . $imgBox . '
                            </div> ';

                $htmlOut .= '<div class="slider-nav">
                            ' . $imgThumb . '
                            </div> ';

                $htmlOut .= '<h3>Description</h3><p>' . $b["description"] . '</p>';
                $htmlOut .= '</div>';
                $htmlOut .= '<div class="col-md-5">';
                $htmlOut .= '<h2>' .$b["modelYear"] .' '. $b["manufacturer"] . ' ' . $b["model"] . '</h2>';
                $htmlOut .= '<div>';
                if ($b["price"] != null) {
                    $htmlOut .= '<div style="font-size: 20px; background: #efefef; padding: 5px;"><strong>Only: </strong><span>$' . number_format($b["price"], 2) . '</span></div>';
                } else {
                    $htmlOut .= '<span>Price: ' . number_format($b["single_price"], 2) . '</span>';
                }
                $htmlOut .= '</div>';
                $htmlOut .= '<table class="table">';
                $htmlOut .= '<tr><td><strong>Category:</strong></td><td>' . $b["category"] . '</td></tr>';
                $htmlOut .= '<tr><td><strong>Manufacturer:</strong></td><td>' . $b["manufacturer"] . '</td></tr>';
                $htmlOut .= '<tr><td><strong>Model:</strong></td><td>' . $b["model"] . '</td></tr>';
                $htmlOut .= '<tr><td><strong>Year:</strong></td><td>' . $b["modelYear"] . '</td></tr>';
                if ($b["operationHours"] != null) {
                    $htmlOut .= '<tr><td><strong>Hours:</strong></td><td>' . $b["operationHours"] . '</td></tr>';
                }

                $htmlOut .= '<tr><td><strong>Stock / DSID #:</strong></td><td>' . $b["stockNumber"] . '</td></tr>';
                $htmlOut .= '</table>';
                $htmlOut .= '<h3>Features</h3>';



                if ($b["options"] != 'null') {
                    $cleanOpts = trim($b["options"], ')');
                    $cleanOpts = trim($cleanOpts, '(');

                    $options = json_decode($cleanOpts, true);

                    //  var_dump($options);

                    $options = $options["option"];

                    $htmlOut .= '<table class="table">';


                    for ($j = 0; $j < count($options); $j++) {
                        if ($options[$j]["label"] != null) {
                            $htmlOut .= '<tr><td><strong>' . ucwords($options[$j]["label"]) . '</strong></td><td>' . $options[$j]["value"] . '</td></tr>';
                        } else {
                            $htmlOut .= '<tr style="background: #f7f7f7; font-size: 12px"><td colspan="2">' . $options[$j]["value"] . '</td></tr>';
                        }
                    }

                    $htmlOut .= '</table>';
                }

                //                $htmlOut .= '<h3>Contact Details</h3>';
                //                $htmlOut .= '<table class="table">';
                //                $htmlOut .= '<tr><td><strong>Contact Name:</strong></td><td>' . $b["contact_name"] . '</td></tr>';
                //                $htmlOut .= '<tr><td><strong>Phone:</strong></td><td>' . $b["contact_phone"] . '</td></tr>';
                //                $htmlOut .= '<tr><td><strong>Address:</strong></td><td><a href="https://www.google.com/maps/search/' . str_replace(' ', '+', $b["address"]) . '+' . $b["city"] . ',+' . $b["state"] . ',+' . $b["zip"] . '/" target="_blank">' . $b["address"] . '<br>' . $b["city"] . ', ' . $b["state"] . ' ' . $b["zip"] . '</a></td></tr>';
                //                $htmlOut .= '</table>';

                $htmlOut .= '';

                $htmlOut .= '<div>';

                $htmlOut .= '</div>';

                $bv = $data->query("SELECT settings FROM beans WHERE bean_id = 'MF-v3'") or die($data->error);
                $bvres = $bv->fetch_array();

                $formTok = json_decode($bvres["settings"], true);

                if ($formTok["form_token"] != '') {
                    $htmlOut .= '<div class="modal" id="exampleModal" tabindex="-1" role="dialog">
                                  <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title">Request More Info</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                      ' . $formTok["form_token"] . '
                                      </div>
                                      <div class="modal-footer">
                                      
                                      </div>
                                    </div>
                                  </div>
                                </div>';
                    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
                    $htmlOut .= '<button class="btn btn-success moreinfo" data-url="' . $actual_link . '" data-equipment="' . $b["modelYear"] . '-' . $b["manufacturer"] . '-' . $b["model"] . '" data-toggle="modal" data-target="#exampleModal">REQUEST MORE INFO</button><br><br>';
                }




                $htmlOut .= '<!-- AddToAny BEGIN -->
                            <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                            <a class="a2a_dd" href="https://www.addtoany.com/share"></a>
                            <a class="a2a_button_facebook"></a>
                            <a class="a2a_button_twitter"></a>
                            <a class="a2a_button_email"></a>
                            </div>
                            <script async src="https://static.addtoany.com/menu/page.js"></script>
                            <!-- AddToAny END -->';

                $htmlOut .= '</div>';
                $htmlOut .= '</div>';

                $pageDescription = $b["manufacturer"].' '.$b["model"].', Category: '.$b["category"].', Year of Production: '.$b["modelYear"].',';
                if ($b["operationHours"] != null) {
                    $pageDescription .=' Operating hours: '.$b["operationHours"].' Hours';
                }
                $pageDescription .=', Stock/DSID #: '.$b["stockNumber"].' | Stellar Equipment';
                $content[] = array("page_name" => $b["modelYear"].' '.$b["manufacturer"].' '.$b["model"], "page_title" => $b["modelYear"].' '.$b["manufacturer"].' '.$b["model"], "page_content" => '<div class="container">' . $htmlOut . '</div>', "active" => true, "created" => time(), "last_edit" => '', "last_user" => '', "page_lock" => 'none', "page_type" => '', "page_desc" => $pageDescription, "check_out" => false, "check_out_date" => '', "page_js" => '');


                return $content;
            }
        } else {

            if (strpos($_SERVER['REQUEST_URI'], 'Used-Equipment') !== false) {


                //IF CATEGORY DETECTED//

                $category = str_replace('-', ' ', $page);



                //DO COUNT STUFF//
                $aa = $data->query("SELECT COUNT(*) as num FROM used_equipment WHERE category = '" . $data->real_escape_string($category) . "' ORDER BY manufacturer ASC") or die($data->error . 'error v');
                $total_pages = $aa->fetch_array();
                $total_pages = $total_pages['num'];

                $limit = 24;                                //how many items to show per page
                $page = $_GET["page"];

                if ($page)
                    $start = ($page - 1) * $limit;          //first item to display on this page
                else
                    $start = 0;                             //if no page var is given, set start to
                /* Get data. */
                $result = $data->query("SELECT images, model, manufacturer, modelYear, clearnace, operationHours, single_price FROM used_equipment WHERE category = '" . $data->real_escape_string($category) . "' ORDER BY manufacturer ASC") or die($data->error . 'error c');

                /* Setup page vars for display. */
                if ($page == 0) $page = 1;                  //if no page var is given, default to 1.
                $prev = $page - 1;                          //previous page is page - 1
                $next = $page + 1;                          //next page is page + 1
                $lastpage = ceil($total_pages / $limit);      //lastpage is = total pages / items per page, rounded up.
                $lpm1 = $lastpage - 1;                      //last page minus 1

                $pagination = "";
                if ($lastpage > 1) {
                    $pagination .= '<div class="btn-group" role="group" aria-label="Basic example">';
                    //previous button
                    if ($page > 1)
                        //$pagination.= "<a href=\"videos-$prev.html\">« previous</a>";
                        $pagination .= '<button type="button" class="btn btn-secondary" onclick="pageData(\'' . $prev . '\')"><i class="fa fa-chevron-left"></i> Previous</button><button type="button" class="btn btn-secondary" onclick="pageData(\'1\')">First Page</button>';

                    else
                        //$pagination.= "<span class=\"disabled\">« previous</span>";
                        $pagination .= '<button type="button" class="btn btn-secondary disabled">Previous</button>';

                    //next button
                    if ($page < $lastpage)
                        //$pagination.= "<a href=\"videos-$next.html\">next »</a>";
                        $pagination .= '<button type="button" class="btn btn-secondary" onclick="pageData(\'' . $lastpage . '\')">Last Page</button><button type="button" class="btn btn-secondary" onclick="pageData(\'' . $next . '\')">Next <i class="fa fa-chevron-right"></i></button>';
                    else
                        //$pagination.= "<span class=\"disabled\">next »</span>";
                        $pagination .= '<button type="button" class="btn btn-secondary disabled">Next</button>';
                    $pagination .= "</div>";
                }



                $sortableObje = array("Recent" => 'recent', "Model A-Z" => 'mod-a-z', "Model Z-A" => 'mod-z-a', "Price Low-High" => 'price-low-high', "Price High-Low" => 'price-high-low', "Hours Low-High" => 'hours-low-high', "Hours High-Low" => 'hours-high-low', "Year New-Old" => 'year-new-old', "Year Old-New" => 'year-old-new', "Manufacturer A-Z" => 'man-a-z', "Manufacturer Z-A" => 'man-z-a', "Category A-Z" => 'cat-a-z', "Category Z-A" => 'cat-z-a');

                $sortnot = false;
                foreach ($sortableObje as $key => $val) {

                    if ($sorttype == $val && $sortnot == false) {
                        $sorterset = $key;
                        $sortnot = true;
                    } else {
                        if ($sortnot != true) {
                            $sorterset = 'Sort';
                        } else {
                        }
                    }
                    $thesorts .= '<a class="dropdown-item sorters" href="javascript:void(0)" data-dorttype="' . $val . '">' . $key . '</a>';
                }

                //VIEW TYPE SET//

                $viewType = $_POST["viewtype"];

                if ($viewType == 'grid' || $viewType == null) {
                    $gridActive = 'active';
                    $listActive = '';
                } else {
                    $gridActive = '';
                    $listActive = 'active';
                }


                $a = $data->query("SELECT images, model, manufacturer, modelYear, clearnace, operationHours, single_price, stockNumber, city, category, serialNumber, description, id FROM used_equipment WHERE category = '" . $data->real_escape_string($category) . "' ORDER BY manufacturer ASC ") or die($data->error . 'error t');
                $html .= '<h2>Used Equipment Category: ' . $category . '</h2>';
                $html .= '<a style="float: right" href="Used-Equipment" class="btn btn-success">Back To Filters</a>';
                $html .= '<div class="clearfix"></div><br><br>';
                $html .= '<div class="row">';

                $htmlNO .= '<div class="col-md-4"><div class="btn-group">
  <button type="button" class="btn btn-primary show-sort">' . $sorterset . '</button>
  <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="sr-only">Toggle Dropdown</span>
  </button>
  <div class="dropdown-menu">
  
  
    ' . $thesorts . '
  </div>
</div> <div class="btn-group" role="group" aria-label="Basic example">
  <button type="button" class="btn btn-secondary ' . $gridActive . '" onclick="setViewType(\'grid\')"><i class="fa fa-th-large" style="margin:0"></i></button>
  <button type="button" class="btn btn-secondary ' . $listActive . '" onclick="setViewType(\'list\')"><i class="fa fa-list" style="margin:0"></i></button>
  
</div></div><div class="col-md-8" style="text-align: right; padding: 20px"><span class="badge badge-primary">Total Results: ' . $total_pages . '</span> | <span class="badge badge-warning">Total Pages: ' . $lastpage . '</span> <span class="badge badge-success">Current Page: ' . $page . '</span> <span class="badge badge-info">Current Price Range: $' . number_format($price_from, 2) . '-$' . number_format($price_to, 2) . '</span></div>';

                if ($a->num_rows > 0) {

                    while ($b = $a->fetch_assoc()) {

                        $fixImg = ltrim($b["images"], "(");
                        $fixImg = rtrim($fixImg, ")");

                        $fixImg = stripcslashes($fixImg);

                        $imageDecode = json_decode($fixImg, true);

                        $cleanImg = $imageDecode["image"][0]["filePointer"];
                        $cleanImg2 = $imageDecode["image"][1]["filePointer"];

                        if ($cleanImg != null) {
                            $mainImg = $cleanImg;
                        } else {
                            $mainImg = 'img/noimg.jpg';
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

                        if ($_POST["viewtype"] == 'list') {


                            $html .= '<div class="col-md-12 row" style="margin: 15px 0; border-bottom: solid thin #333">
                            <div class="col-md-4">
                                <div class="product-grid" style="min-height: 100%; padding: 0">
                                    <div class="product-image">
                                        <a href="#">
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
</table><p style="padding: 10px">' . $b["description"] . '</p><br><button class="btn btn-success">Get More Details</button>
                           </div>
                           <div class="clearfix"></div>
                           <br><br>
                    </div>';
                        } else {
                            $link = str_replace(' ', '-', $b["category"]) . '/' . str_replace(' ', '-', $b["manufacturer"]) . '-' . str_replace(' ', '-', $b["model"]) . '-' . $b["id"];
                            $html .= '<div class="col-md-6 col-lg-3 col-sm-6">
            <div class="product-grid drop-shadow" style="max-height: 200px; min-height: 300px; margin-bottom: 20px">
                <div class="product-image">
                    <a href="Used-Equipment/' . $link . '">
                        <img class="pic-1" src="' . $mainImg . '">
                        <img class="pic-2" src="' . $cleanImg2 . '">
                    </a>
                    ' . $theHours . '
                    ' . $theClearance . '
                    ' . $theYear . '

                </div>

                <div class="product-content">
                    <h3 class="title" style="background: none"><a style="font-size: 20px; color:#000" href="#">' . $b["manufacturer"] . ' ' . $b["model"] . '</a></h3>
                    <div class="price" style="font-size:18px; color: red">Only $' . number_format($b["single_price"]) . '
                    </div>
                </div>
            </div>
        </div>';
                        }
                    }
                }





                $content[] = array("page_name" => 'Neat', "page_title" => $page, "page_content" => '<div class="container">' . $html . '</div>', "active" => true, "created" => time(), "last_edit" => '', "last_user" => '', "page_lock" => 'none', "page_type" => '', "page_desc" => '', "check_out" => false, "check_out_date" => '', "page_js" => '');
                return $content;

                ///END CAT OUTPUT///
            }
        }
    }
}
