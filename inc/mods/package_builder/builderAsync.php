<?php
include('../../config.php');
include("builderFunctions.php");
setlocale(LC_MONETARY, 'en_US');


$builder = new builder();

$act = $_REQUEST["action"];

if ($act == 'getcats') {
    $packagename = $_REQUEST["id"];
    $catArr = $builder->getCats($packagename);

    //My Version ----------------------------------
    $html .= '<div id="accordion">';
    $html .= '<div class="card" style="border: none;">';
    $html .= '<div class="card-header" id="headingOne" style="background-color: #D3D3D3;">';
    $html .= '<h1 class="proxima-nova-condensed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"><i class="fa fa-angle-right" aria-hidden="true" style="font-size: 42px; font-weight: bold; display: inline; color: #367C2B;"></i> <b><i>Select a Performance Category</i></b></h1>';
    $html .= '</div>';
    $html .= '<div id="collapseTwo" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">';
    $html .= '<div class="card-body">';
    $html .= '<div class="row">';
    foreach ($catArr as $value) {
        $html .= '<div class="col-md-2" align="center" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" >
                                <div class="card show" data-value="' . $value . '" onclick="callDoublefunctions(this)" style="border-radius: 10px; border: transparent;  width: 75%;">
                                <img src="img/builderlogos/' . $value . '.jpg" class="img-responsive " style="width: 100%;" >
                                <p align="center" style="color: #367C2B; font-size: 18px;">' . $value . '</p></div></div><script>function callDoublefunctions(elem){
                                    console.log($(elem).data("value"));
                                    getCategory($(elem).data("value"));
                                    //recallcaffEvent();
                                }</script>';
    }
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';

    echo $html;
}


if ($act == 'getequip') {
    setlocale(LC_MONETARY, 'en_US');
    $equipcat = $_REQUEST["value"];
    $equipmentPieces = $builder->getEquipment($equipcat);

    //My Version -------------------------------------
    $html .= '<div id="accordion">';
    $html .= '<div class="card" style="border: none;">';
    $html .= '<div class="card-header" id="headingOne" style="background-color: #D3D3D3;">';
    $html .= '<h1 class="proxima-nova-condensed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree"><i class="fa fa-angle-right" aria-hidden="true" style="font-size: 42px; font-weight: bold; color: #367C2B;"></i> <b><i>Select Equipment</i></b></h1>';
    $html .= '</div>';
    $html .= '<div id="collapseThree" class="collapse show" aria-labelledby="headingThree" data-parent="#accordion">';
    $html .= '<div class="card-body">';
    $html .= '<div class="row">';
    foreach ($equipmentPieces as $value) {
        $details = $builder->getEquipBriefDetail($value["equip_id"]);
        $image = json_decode($details["eq_image"], true);

        if ($value["price"] == '') {
            if ($image[0] !== null) {
                $html .= '<div class="col-md-2" id="equipment" data-value="' . $value["id"] . '" onclick="startConfig()"><div style="display:none;" id="hidden-input-id"></div><div class="card" style="border-radius: 10px; border: transparent; width: 100%; margin-top: 20px;">';
                $html .= '<img src="img/equip_images/' . $image[0] . '" class="img-responsive" >';
                $html .= '<p align="center" style="color: #367C2B; font-size: 18px;">' . $value["equipment_title"] . '<br>$' . number_format($value["msrp"]) . '</p>';
                $html .= '</div></div>';
            }
        } else {
            $html .= '<img src="img/equip_images/' . $image[0] . '" class="img-responsive">';
        }
    }
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';

    echo $html;
}



if ($act == 'getimplements') {
    $id = $_REQUEST["id"];

    $equip = $builder->getEquipById($id);

    $details = $builder->getEquipDetail($equip["equip_id"]);

    $equiplink = $details["equip_link"];

    $originallinkjson = file_get_contents($equiplink, false, stream_context_create($arrContextOptions));

    $decodeorg = json_decode($originallinkjson, true);

    $brochlink = $decodeorg["Page"]["product-summary"]["OptionalLinks"][1]["LinkUrl"];

    $imps = $builder->getImplements($id);

    if (count($imps) < 1) {

        $html = null;

        echo $html;
    } else {

        //  $details = $builder->getEquipDetail($equip["equip_id"]);

        if ($equip["price"] == $equip["msrp"] || $equip["price"] == '') {
            $price = '<span class="base-equip-price" style="font-family: Arial, sans-serif;">$' . number_format($equip["msrp"], 2, '.', ',') . '<span></span>';
        } else {
            $price = '<span class="base-equip-price" style="font-family: Arial, sans-serif;"><span class="line-through">$' . number_format($equip["msrp"], 2, '.', ',') . '</span><br>$' . number_format($equip["price"], 2, '.', ',') . '</span>';
        }

        $image = json_decode($details["eq_image"], true);


        $html .= '<div class="row select-box">';
        $html .= '<div class="col-lg-6 col-md-12"><img src="img/equip_images/' . $image[0] . '" class="img-responsive"><h2 class="equip-title">' . $equip["equipment_title"] . '</h2>' . $details["bullet_points"] . '<a class="text-center" href="' . $brochlink . '" target="_blank">View Brochure</a><div class="panel-group">
  <div class="panel panel-success card">
				<div class="panel-heading selection-heading" style="background: none;">
					<h3 class="panel-title" style="color: #3E7B30; font-size: 1.2rem; font-weight: bold; padding: 0;">My Selections</h3>
						<p>All prices include installation</p>
					<span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-up"></i></span>
				</div>
				<div class="panel-body selections" ></div>
		</div>
  </div></div><div class="col-lg-6 col-md-12"><h2 style="font-family: Arial, sans-serif;">Base Price ' . $price . '</span></h2> <div class="clearfix"></div><hr>';

        for ($i = 0; $i < count($imps); $i++) {
            $catArr[] = $imps[$i]["category"];
            $uniqueCatArr = array_unique($catArr);
        }

        foreach ($uniqueCatArr as $cat) {
            $getimpdescrip = $builder->getImpDetails($cat);
            if ($getimpdescrip[0]["add_image"] != '') {
                $tooltip = '<a style="margin-left: 10px" class="att-info" data-toggle="tooltip" data-placement="top" title="<img class=\'img-thumbnail\' style=\'width: 100%;\' src=\'' . $getimpdescrip[0]["add_image"] . '\' />"><i class="fa fa-info-circle"></i></a>';
            } else {
                $tooltip = '';
            }


            $html .= '<label style="font-weight: bold;">' . $cat . $tooltip . '</label>
            <p>' . $getimpdescrip[0]["description"] . '</p>';
            $html .= '<select name="' . str_replace(' ', '-', $cat) . '" id="' . str_replace(' ', '-', $cat) . '" class="form-control" onchange="getSelections();" style="margin-bottom: 20px"><option value="">Choose An Option</option>';

            for ($i = 0; $i < count($imps); $i++) {
                if (in_array($cat, $imps[$i])) {
                    $html .= '<option data-name="' . $imps[$i]["name"] . '" data-price="' . $imps[$i]["price"] . '" value="' . $imps[$i]["name"] . '-' . number_format($imps[$i]["price"], 2, '.', ',') . '">' . $imps[$i]["name"] . ' $' . number_format($imps[$i]["price"], 2, '.', ',') . '</option>';
                }
            }
            $html .= '</select>';
        }

        $html .= '</div></div><div class="row"><div class="col-md-12"><button type="button" class="btn btn-warning previous" style="margin-top: 50px;" onclick="stepper.previous()">Previous</button><button id="attachments" type="button" class="btn btn-success" style="margin-top: 50px; float: right; background: #3E7B30;" onclick="getAttach(' . $equip["id"] . ')">Accessories</button></div></div>';

        echo $html;
    }
}

if ($act == 'getattachments') {

    $id = $_REQUEST["id"];

    $equip = $builder->getEquipById($id);

    $details = $builder->getEquipDetail($equip["equip_id"]);

    $equiplink = $details["equip_link"];

    $originallinkjson = file_get_contents($equiplink, false, stream_context_create($arrContextOptions));

    $decodeorg = json_decode($originallinkjson, true);

    $brochlink = $decodeorg["Page"]["product-summary"]["OptionalLinks"][1]["LinkUrl"];

    //$html .= '<p style="border: 2px solid red;">EQ ID: '.$equip["id"].'</p>';

    if (count($builder) < 1) {
        $html =  null;
    } else {



        $image = json_decode($details["eq_image"], true);

        if ($equip["price"] == $equip["msrp"] || $equip["price"] == '') {
            $price = '<span class="base-equip-price" style="font-family: Arial, sans-serif;">$' . number_format($equip["msrp"], 2, '.', ',') . '<span></span>';
        } else {
            $price = '<span class="base-equip-price" style="font-family: Arial, sans-serif;"><span class="line-through">$' . number_format($equip["msrp"], 2, '.', ',') . '</span><br>$' . number_format($equip["price"], 2, '.', ',') . '</span>';
        }

        $atts = $builder->getAttachments($id);
        $html .= '<div class="row select-box">';
        $html .= '<div class="col-lg-6 col-md-12"><img src="img/equip_images/' . $image[0] . '" class="img-responsive"><h2 class="equip-title">' . $equip["equipment_title"] . '</h2>' . $details["bullet_points"] . '<a class="text-center" href="' . $brochlink . '" target="_blank">View Brochure</a><div class="panel-group">
  <div class="panel panel-success card">
				<div class="panel-heading" style="background: transparent;">
					<h3 class="panel-title" style="color: #3E7B30; font-size: 1.2rem; font-weight: bold;  padding: 0;">My Selections</h3>
						<p>All prices include installation</p>
					<span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-up"></i></span>
				</div>
				<div class="panel-body selections" ></div>
				<div class="panel-body attachments"></div>
		</div>
  </div></div><div class="col-lg-6 col-md-12"><h2 style="font-family: Arial, sans-serif;">Base Price ' . $price . '</span></h2> <div class="clearfix"></div>';

        $html .= '<input id="search-atts" class="form-control" placeholder="Search Attachments"/><table id="attachment-table" class="table table-striped"><thead><th><b>Accessories</b></th><td></td></th></thead>';

        for ($i = 0; $i < count($atts); $i++) {
            if (!empty($atts[$i]['description'])) {
                if (!empty($atts[$i]['add_image'])) {
                    $attimg = '<img class=\'img-thumbnail\' style=\'width: 100%;\' src=\'' . $atts[$i]["add_image"] . '\' /><br>';
                } else {
                    $attimg = '';
                }


                $tooltip = '<a style="margin-left: 10px" class="att-info" data-toggle="tooltip" data-placement="top" title="' . $attimg . $atts[$i]["description"] . '"><i class="fa fa-info-circle"></i></a>';
            } else {
                $tooltip = '';
            }

            $html .= '<tr><td>';
            $html .= '<table>';
            $html .= '<tr>';

            $html .= '<td><div class="input-group">
  <div class="input-group-append" style=" margin-right: 10px;">
    <div class="input-group-text">
      <input style="padding: 0px 10px;" class="attchecks" name="' . str_replace(' ', '-', $atts[$i]["name"]) . '" type="checkbox" value="' . $atts[$i]["name"] . '-' . $atts[$i]["price"] . '" data-id="' . $atts[$i]["id"] . '">
    </div>
  </div></div></td>';

            $html .= '<td><p class="att-text" style="max-width: 350px;">' . $atts[$i]["name"] . $tooltip . '</p></td>';
            $html .= '<td style="text-align:right"><span style="font-weight: bold; text-align:right">$' . $atts[$i]["price"] . '</span></td>';

            $html .= '</tr>';
            $html .= '</table>';




            $htmlOR .= '<tr><td><div class="input-group">
  <div class="input-group-append" style=" margin-right: 10px;">
    <div class="input-group-text">
      <input style="padding: 0px 10px;" class="attchecks" name="' . str_replace(' ', '-', $atts[$i]["name"]) . '" type="checkbox" value="' . $atts[$i]["name"] . '-' . $atts[$i]["price"] . '" data-id="' . $atts[$i]["id"] . '">
    </div>
  </div><div class="row"><div><p class="att-text" style="max-width: 350px;">' . $atts[$i]["name"] . $tooltip . '</p></div><div class=""><span style="float: right; position: absolute; right: 10px; font-weight: bold;">$' . $atts[$i]["price"] . '</span></div></div></td></tr>';
        }


        $html .= '</table></div></div><div class="row"><div class="col-md-12"><button id="att-prev" type="button" class="btn btn-warning previous" style="margin-top: 50px; float: left;" onclick="stepper.to(2)">Previous</button><button id="subpack" type="submit" class="btn btn-success" style="margin-top: 50px; float: right; background: #3E7B30;">Get Summary</button></div></div>';

        echo $html;
    }
}


if ($act == 'getfinal') {
    $id = $_POST["equipmentId"];
    $equip = $builder->getEquipById($id);

    $details = $builder->getEquipDetail($equip["equip_id"]);

    $equiplink = $details["equip_link"];

    $originallinkjson = file_get_contents($equiplink, false, stream_context_create($arrContextOptions));

    $decodeorg = json_decode($originallinkjson, true);

    $brochlink = $decodeorg["Page"]["product-summary"]["OptionalLinks"][1]["LinkUrl"];

    $image = json_decode($details["eq_image"], true);

    // echo $equip["msrp"];
    if ($equip["price"] == $equip["msrp"] || $equip["price"] == '') {
        $price = '<span class="base-equip-price addit" style="font-family: Arial, sans-serif;">$' . number_format($equip["msrp"], 2, '.', ',') . '<span></span>';
    } else {
        $price = '<span class="base-equip-price addit" style="font-family: Arial, sans-serif;">$' . number_format($equip["msrp"], 2, '.', ',') . '<span></span>';
    }
    $html .= '<div class="row">';
    $html .= '<div class="col-md-6"><img src="img/equip_images/' . $image[0] . '" class="img-responsive"><a class="text-center" href="' . $brochlink . '" target="_blank">View Brochure</a><br><button type="button" class="btn btn-success offer-btn" data-toggle="modal" onclick="getOffers(' . $equip["id"] . ')">

  Offers & Discounts</button>
  <div style="clear:both; margin-top: 40px"><button type="button" class="btn btn-warning previous" onclick="stepper.previous()">Previous</button></div>
  <div class="panel-group">
    </div>' . $offershtml . '</div><div class="col-md-6"><h2 class="form-gen" style="font-family: Arial, sans-serif;"><span class="eqinfo">' . $equip["equipment_title"] . ' - Base Price ' . $price . '</span></span></h2> <div class="clearfix"></div><div class="config-info"><table id="gen-info" class="table">';

    if (!empty($equip["additional_discounts"])) {
        $addiscount = '<tr><td style="width: 32%;"></td><td class="capture">Additional Savings</td><td style="width: 37%;" class="add-discount capture" data-val="' . $equip["additional_discounts"] . '">$' . number_format($equip["additional_discounts"], 2, '.', '') . '</td></tr>';
    } else {
        $addiscount = '';
    }

    foreach ($_POST as $key => $value) {
        if (strstr($key, 'subcategory') || strstr($key, 'equipment')) {
        } else {
            if ($value == '' || $value == '10') {
            } else {
                $newval = explode('-', $value);

                $html .= '<tr><td><b></b></td><td class="formdets capture">' . $newval[0] . '</td><td class="addit formdets capture">$' . $newval[1] . '</td></tr>';
            }
        }
    }

    $html .= '<tr style="background: transparent; visibility: hidden"><td style="border: none;"></td><td style="border: none;"><b>Sub Total</b></td><td id="subtal" class="sumit" style="border: none;"></td></tr>';
    $html .= '<tr style="background: transparent"><td style="border: none;"></td><td style="border: none;" class="capture"><b>Delivery Fee</b></td><td id="delivery" class="addit capture" style="border: none;">$' . number_format($equip["delivery_fee"], 2, '.', '') . '</td></tr>';
    $html .= '<tr style="background: transparent"><td style="border: none;"></td><td style="border: none;" class="capture"><b>Sales Tax(percentage)</b></td><td style="border: none;"><input id="interest" type="number" class="form-control" /></td><td style="display: none;" class="tax-val capture"></td></tr>';
    $html .= '<tr style="background: #3E7B30; color: white;"><td style="border: none;"></td><td style="border: none;" class="capture"><b>Total</b></td><td id="total" class="sumit capture" style="border: none;"></td></tr>';

    $html .= '</table>';
    $html .= '<table id="pay-info" class="table table-borderless"><tbody>';
    $html .= $addiscount;
    $html .= '<tr><td style="width: 32%;"></td><td class="capture">Down Payment</td><td style="width: 37%;"><input id="downpay" type="number" class="form-control" value="0"/></td><td style="display: none" class="downpay-val capture"></td></tr>';
    $html .= '<tr><td style="width: 32%;"></td><td class="capture">Months</td><td style="width: 37%;"><div class="range-slider">
    <input class="range-slider__range" id="monthslider" type="range" value="60" min="60" max="84" step="12" list = "monthsetting" onchange="calculateMonthly()" oninput="monthOutputUpdate(value)">
    <datalist id="monthsetting">
    <option>60</option>
    <option>72</option>
    <option>84</option>
    </datalist>
    <output id="monthvalue" for="monthslider" class="range-slider__value">60</output>
    <script>
        function monthOutputUpdate(vol) {
            console.log(vol);
        document.querySelector("#monthvalue").value = vol;
    }</script>
    </div></td><td style="display: none;" class="month-val capture"></td></tr><tr><td style="width: 32%;"></td><td class="capture">Finance Charge</td><td style="width: 37%; class="capture"><p id="financeCharge"></p><small id="interest-rate-desc"></small></td></tr>';
    // $html .= '<tr><td style="width: 32%;"></td></tr>';
    $html .= '<tr style="font-size: 1.6rem;"><td></td><td class="capture">Monthly Payment</td><td style="width: 37%;" id="monthlypayment" class="capture"></td><td style="display: none;" class="monthly-pay-val"></td></tr>';
    $html .= '</table></form><p>All financing subject to credit approval and current offers and discounts available in your area. This is an estimate and may be subject to change. Please finalize quote to determine exact monthly payment.</p><button type="button" class="btn btn-success finalize-btn" data-cafftrak="Finalize Quote now" data-toggle="modal" data-target="#exampleModal" onclick="recallCaffTrak();" style="border-radius: 0px;background: #097F0E;padding: 10px 30px;text-transform: uppercase;margin-top: 20px;float: right;">
  Finalize Quote NOW!!
</button>';


    $html .= '</div></div></div>';

    echo $html;
}

if ($act == 'getoffers') {
    $id = $_REQUEST["id"];

    $equip = $builder->getEquipById($id);

    $details = $builder->getEquipDetail($equip["equip_id"]);

    $equiplink = $details["equip_link"];

    $originallinkjson = file_get_contents($equiplink, false, stream_context_create($arrContextOptions));

    $decodeorg = json_decode($originallinkjson, true);

    $brochlink = $decodeorg["Page"]["product-summary"]["OptionalLinks"][1]["LinkUrl"];

    $image = json_decode($details["eq_image"], true);

    //Get offers from API

    $equiplink = $details["equip_link"];
    $offerlinkform = preg_replace('#[^/]*$#', '', $equiplink) . 'offers-json.html';


    $offers = file_get_contents($offerlinkform, false, stream_context_create($arrContextOptions));


    $offerstags = str_replace('<esi:assign name="jsonincludedata">', '', $offers);
    $offerstags = str_replace('</esi:assign>', '', $offerstags);


    $offerstags = str_replace('\'', '"', $offerstags);

    $offersOut = json_decode($offerstags, true);

    $finnalyOfffers = $offersOut["values"][0]["offers"];




    $q = 0;
    foreach ($finnalyOfffers as $offerlink) {


        $offerLinkClean = str_replace('/html/deere/us/', '', $offerlink);
        $offersLinkNow = 'https://www.deere.com/' . $offerLinkClean . '/index.json';

        $jsonOffer = file_get_contents($offersLinkNow, false, stream_context_create($arrContextOptions));
        $objOffers = json_decode($jsonOffer, true);


        $today = strtotime("today midnight");



        if (is_null($objOffers["Page"]["special-offers"]["OfferEndDate"])) {
            $enddate = $objOffers["Page"]["special-offers"]["special-offers"][1]["OfferEndDate"];
        } else {
            $enddate = $objOffers["Page"]["special-offers"]["OfferEndDate"];
        }



        if ($today >= strtotime($enddate)) {
        } else {



            if (is_array($objOffers["Page"]["special-offers"])) {
                if (is_array($objOffers["Page"]["special-offers"]["special-offers"])) {
                    $jsonOfferOut = file_get_contents('https://www.deere.com' . $objOffers["Page"]["special-offers"]["special-offers"][1]["ESIFragments"], false, stream_context_create($arrContextOptions));
                } else {
                    $jsonOfferOut = file_get_contents('https://www.deere.com' . $objOffers["Page"]["special-offers"]["ESIFragments"], false, stream_context_create($arrContextOptions));
                }


                $disclaimer .= $objOffers["Page"]["disclaimer"]["DisclaimerContainer"]["Description"];


                $content = str_replace('srcset="', 'srcset="https://deere.com', $jsonOfferOut);
                $content = str_replace('/en/', 'https://www.deere.com/en/', $content);
                $content = str_replace('content', 'deerecontent', $content);
                $content = str_replace('col col-sm-8 col-md-6', '', $content);
                $content = str_replace('img', 'img style="display: none;"', $content);



                $offerZ = $content . '<div class="clearfix"></div>';


                if (strpos($offerZ, 'EXPIRED') !== false) {
                } else {
                    $offerZZ .= $offerZ . '<div class="clearfix"></div>';
                }
            } else {
                $offerZZ .= '';
            }
            $q = 1;
        }
    }


    if ($offerZZ != null) {
        $offerZZa .= '<div class="col-md-12" style="background: #fff">';

        $offerZZa .= '<h1 class="offers-header">Offers and Discounts</h1>';


        $offerZZa .= '<div class="offers-holder">';
        $offerZZa .= $offerZZ;
        $offerZZa .= '</div>';

        $offerZZa .= '</div>';

        $offershtml .= $offerZZa;
    }
    // Offer End

    echo $offershtml;
}

if ($act == 'processform') {
    $builder->saveForm($_POST);
}
