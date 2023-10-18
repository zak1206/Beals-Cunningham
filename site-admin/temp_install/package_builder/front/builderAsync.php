<?php
include('../../config.php');
include("builderFunctions.php");


$builder = new builder();

$act = $_REQUEST["action"];

if($act == 'getcats') {
    $packagename = $_REQUEST["id"];
    $catArr = $builder->getCats($packagename);

    $html .= '<label>Choose A Subcategory</label><br>';
        $html .= '<select name="subcategory" id="subcat-select" class="form-control" onchange="getCategory(this);">';
        $html .= '<option value="">Choose A Subcategory</option>';

        foreach ($catArr as $value) {
            $html .= '<option value"'.$value.'">'.$value.'</option>';
        }

        $html .= '</select>';

        echo $html;
}

if($act == 'getequip'){
    setlocale(LC_MONETARY, 'en_US');
    $equipcat = $_REQUEST["value"];
    $equipmentPieces = $builder->getEquipment($equipcat);

    $html .= '<label>Choose Equipment</label><br>';
    $html .= '<select name="equipment" id="equipment" class="form-control" required>';
    $html .= '<option value="">Choose Equipment</option>';

    foreach ($equipmentPieces as $value) {
        if($value["price"] == ''){
            $html .= '<option value="'.$value["id"].'">'.$value["equipment_title"].' - $'.number_format($value["msrp"]). "\n".'</option>';
        } else {

            $html .= '<option value="' . $value["id"] . '">' . $value["equipment_title"] . ' -$' . number_format($value["price"]) . "\n" . '</option>';
        }
    }

    $html .= '</select>';

    $html .= '<div class="clearfix"></div><button id="config" type="button" class="btn btn-success" style="margin-top: 50px;" onclick="startConfig();">Configure</button>';

    echo $html;


}

if($act == 'getimplements'){
    $id = $_REQUEST["id"];

    $equip = $builder->getEquipById($id);

    $details = $builder->getEquipDetail($equip["equip_id"]);

    $equiplink = $details["equip_link"];

    $originallinkjson = file_get_contents($equiplink, false, stream_context_create($arrContextOptions));

    $decodeorg = json_decode($originallinkjson, true);

    $brochlink = $decodeorg["Page"]["product-summary"]["OptionalLinks"][1]["LinkUrl"];

    $imps = $builder->getImplements($id);

    if(count($imps) < 1) {

    $html = null;

    echo $html;


    } else {

      //  $details = $builder->getEquipDetail($equip["equip_id"]);

        if ($equip["price"] == $equip["msrp"] || $equip["price"] == '') {
            $price = '<span class="base-equip-price" style="font-family: Arial, sans-serif;">$' . $equip["msrp"] . '<span></span>';
        } else {
            $price = '<span class="base-equip-price" style="font-family: Arial, sans-serif;"><span class="line-through">$' . $equip["msrp"] . '</span><br>$' . $equip["price"] . '</span>';
        }

        $image = json_decode($details["eq_image"], true);


        $html .= '<div class="row">';
        $html .= '<div class="col-lg-6 col-md-12"><img src="img/equip_images/' . $image[0] . '" class="img-responsive"><a class="text-center" href="' . $brochlink . '" target="_blank">View Brochure</a><div class="panel-group">
  <div class="panel panel-success card">
				<div class="panel-heading">
					<h3 class="panel-title">My Selections</h3>
					<span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-up"></i></span>
				</div>
				<div class="panel-body selections" ></div>
		</div>
  </div></div><div class="col-lg-6 col-md-12"><h2 style="font-family: Arial, sans-serif;">Base Price ' . $price . '</span></h2> <div class="clearfix"></div>';

        for ($i = 0; $i < count($imps); $i++) {
            $catArr[] = $imps[$i]["category"];
            $uniqueCatArr = array_unique($catArr);

        }

        foreach ($uniqueCatArr as $cat) {

            $html .= '<label>' . $cat . '</label>';
            $html .= '<select name="' . str_replace(' ', '-', $cat) . '" id="' . str_replace(' ', '-', $cat) . '" class="form-control" onchange="getSelections();"><option value="">Choose An Option</option>';

            for ($i = 0; $i < count($imps); $i++) {
                if (in_array($cat, $imps[$i])) {
                    $html .= '<option data-name="' . $imps[$i]["name"] . '" data-price="' . $imps[$i]["price"] . '" value="' . $imps[$i]["name"] . '-' . $imps[$i]["price"] . '">' . $imps[$i]["name"] . ' $' . $imps[$i]["price"]. '</option>';
                }
            }
            $html .= '</select>';
        }

        $html .= '</div></div><div class="row"><div class="col-md-12"><button type="button" class="btn btn-warning previous" style="margin-top: 50px;" onclick="stepper.previous()">Previous</button><button id="attachments" type="button" class="btn btn-success" style="margin-top: 50px; float: right;" onclick="getAttach(' . $equip["id"] . ')">Attachments</button></div></div>';

        echo $html;
    }

}

if($act == 'getattachments'){
    $id = $_REQUEST["id"];

    $equip = $builder->getEquipById($id);

    $details = $builder->getEquipDetail($equip["equip_id"]);

    $equiplink = $details["equip_link"];

    $originallinkjson = file_get_contents($equiplink, false, stream_context_create($arrContextOptions));

    $decodeorg = json_decode($originallinkjson, true);

    $brochlink = $decodeorg["Page"]["product-summary"]["OptionalLinks"][1]["LinkUrl"];

    if(count($builder) < 1) {

        $html =  null;

    } else {



        $image = json_decode($details["eq_image"], true);

        if ($equip["price"] == $equip["msrp"] || $equip["price"] == '') {
            $price = '<span class="base-equip-price" style="font-family: Arial, sans-serif;">$' . $equip["msrp"] . '<span></span>';
        } else {
            $price = '<span class="base-equip-price" style="font-family: Arial, sans-serif;"><span class="line-through">$' . $equip["msrp"] . '</span><br>$' . $equip["price"] . '</span>';
        }

        $atts = $builder->getAttachments($id);
        $html .= '<div class="row">';
        $html .= '<div class="col-lg-6 col-md-12"><img src="img/equip_images/' . $image[0] . '" class="img-responsive"><a class="text-center" href="' . $brochlink . '" target="_blank">View Brochure</a><div class="panel-group">
  <div class="panel panel-success card">
				<div class="panel-heading">
					<h3 class="panel-title">My Selections</h3>
					<span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-up"></i></span>
				</div>
				<div class="panel-body selections" ></div>
				<div class="panel-body attachments"></div>
		</div>
  </div></div><div class="col-lg-6 col-md-12"><h2 style="font-family: Arial, sans-serif;">Base Price ' . $price . '</span></h2> <div class="clearfix"></div>';

        $html .= '<table id="attachment-table" class="table table-striped"><tr><th>Attachments</th></tr>';

        for ($i = 0; $i < count($atts); $i++) {
            if(!empty($atts[$i]['description'])) {
                $tooltip = '<a style="margin-left: 10px" class="att-info" data-toggle="tooltip" data-placement="top" title="' . $atts[$i]["description"] . '"><i class="fa fa-info-circle"></i></a>';
            }
            else $tooltip = '';

            $html .= '<tr><td><div class="input-group">
  <div class="input-group-append" style=" margin-right: 10px;">
    <div class="input-group-text">
      <input class="attchecks" name="' . str_replace(' ', '-', $atts[$i]["name"]) . '" type="checkbox" value="' . $atts[$i]["name"] . '-' . $atts[$i]["price"] . '" data-id="' . $atts[$i]["id"] . '">
    </div>
  </div><div class="row"><div class="col-md-10"><p>' . $atts[$i]["name"] . $tooltip.'</p></div><div class=""><span style="float: right; position: absolute; right: 10px; font-weight: bold;">$' . $atts[$i]["price"] . '</span></div></div></td></tr>';
        }

        $html .= '</table></div></div><div class="row"><div class="col-md-12"><button type="button" class="btn btn-warning previous" style="margin-top: 50px; float: left;" onclick="stepper.to(2)">Previous</button><button id="subpack" type="submit" class="btn btn-success" style="margin-top: 50px; float: right;">Get Summary</button></div></div>';

        echo $html;
    }

}

if($act == 'getfinal') {
        $id = $_POST["equipment"];


    $equip = $builder->getEquipById($id);

    $details = $builder->getEquipDetail($equip["equip_id"]);

    $equiplink = $details["equip_link"];

    $originallinkjson = file_get_contents($equiplink, false, stream_context_create($arrContextOptions));

    $decodeorg = json_decode($originallinkjson, true);

    $brochlink = $decodeorg["Page"]["product-summary"]["OptionalLinks"][1]["LinkUrl"];

    $image = json_decode($details["eq_image"], true);

    //Get offers from API

    $equiplink = $details["equip_link"];
    $offerlinkform = preg_replace('#[^/]*$#', '', $equiplink).'offers-json.html';


    $offers = file_get_contents($offerlinkform, false, stream_context_create($arrContextOptions));


    $offerstags = str_replace('<esi:assign name="jsonincludedata">', '', $offers);
    $offerstags = str_replace('</esi:assign>', '', $offerstags);


    $offerstags = str_replace('\'', '"', $offerstags);

    $offersOut = json_decode($offerstags, true);

//                var_dump($offersOut);

    $finnalyOfffers = $offersOut["values"][0]["offers"];




    $q = 0;
    foreach ($finnalyOfffers as $offerlink) {


        $offerLinkClean = str_replace('/html/deere/us/', '', $offerlink);
        $offersLinkNow = 'https://www.deere.com/' . $offerLinkClean . '/index.json';

        $jsonOffer = file_get_contents($offersLinkNow, false, stream_context_create($arrContextOptions));
        $objOffers = json_decode($jsonOffer, true);


        $today = strtotime("today midnight");



        if(is_null($objOffers["Page"]["special-offers"]["OfferEndDate"])) {
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
       // $offerZZa .= '<div class="disclaimers" style="font-size: .7rem; padding: 20px;">'.$disclaimer.'</div>';

        ///Store offers in db///
//                    $data->query("UPDATE deere_equipment SET offers_storage = '".$data->real_escape_string($offerZZa)."' WHERE id = '".$id."'");

        $offershtml .= $offerZZa;
    }
    // Offer End

    if ($equip["price"] == $equip["msrp"] || $equip["price"] == '') {
        $price = '<span class="base-equip-price addit" style="font-family: Arial, sans-serif;">$' . $equip["msrp"] . '<span></span>';
    } else {
        $price = '<span class="base-equip-price" style="font-family: Arial, sans-serif;"><span class="line-through">$' . $equip["msrp"] . '</span><br><span class="addit">$' . $equip["price"] . '</span></span>';
    }
    $html .= '<div class="row">';
    $html .= '<div class="col-md-6"><img src="img/equip_images/'.$image[0].'" class="img-responsive"><a class="text-center" href="'.$brochlink.'" target="_blank">View Brochure</a><div class="panel-group">
    </div>'.$offershtml.'</div><div class="col-md-6"><h2 class="form-gen" style="font-family: Arial, sans-serif;">'.$equip["equipment_title"].' - Base Price '.$price.'</span></h2> <div class="clearfix"></div><div class="config-info"><table id="gen-info" class="table">';



    foreach($_POST as $key => $value)
    {
        if (strstr($key, 'subcategory') || strstr($key, 'equipment'))
        {

        } else {
            if ($value == '') {

            } else {
                $newval = explode('-', $value);

                $html .= '<tr><td><b></b></td><td class="formdets">' . $newval[0] . '</td><td class="addit formdets">$' . $newval[1] . '</td></tr>';
            }
        }
    }

    $html .= '<tr style="background: transparent; visibility: hidden"><td style="border: none;"></td><td style="border: none;"><b>Sub Total</b></td><td id="subtal" class="sumit" style="border: none;"></td></tr>';
    $html .= '<tr style="background: transparent"><td style="border: none;"></td><td style="border: none;"><b>Delivery Fee</b></td><td id="delivery" class="addit" style="border: none;">$250.00</td></tr>';
    $html .= '<tr style="background: transparent"><td style="border: none;"></td><td style="border: none;"><b>Sales Tax(percentage)</b></td><td style="border: none;"><input id="interest" type="number" class="form-control" /></td></tr>';
    $html .= '<tr style="background: RGBA(95, 141, 109, 0.3);"><td style="border: none;"></td><td style="border: none;"><b>Total</b></td><td id="total" class="sumit" style="border: none;"></td></tr>';

    $html .= '</table>';
    $html .= '<table id="pay-info" class="table table-borderless"><tbody>';
    $html .= '<tr><td style="width: 32%;"></td><td>Down Payment</td><td style="width: 37%;"><input id="downpay" type="number" class="form-control" value="0"/></td></tr>';
    $html .= '<tr><td style="width: 32%;"></td><td>Months</td><td style="width: 37%;"><div class="range-slider">
  <input class="range-slider__range" type="range" value="36" min="36" max="84">
  <span class="range-slider__value">0</span>
</div></td></tr>';
    $html .= '<tr><td style="width: 32%;"></td><td>Interest Rate</td><td style="width: 37%;"><input id="interestrate" type="number" class="form-control" value="0" /></td></tr>';
    $html .= '<tr style="font-size: 1.6rem;"><td></td><td>Monthly Payment</td><td style="width: 37%;" id="monthlypayment"></td></tr>';
    $html .= '</table>';

//    $formname = 'Package_Builder_Form';

//    $packform = $builder->produceForm($formname);

//    $packform = '<div id="Package_Builder_Form_alerts"></div><form class="form-process row" name="Package_Builder_Form" id="Package_Builder_Form" action="" method="post" onsubmit="return false" novalidate="novalidate"><input type="hidden" name="form_table" id="form_table" value="Package_Builder_Form"><input type="hidden" name="equipment_title" id="equipment_title" value=""><input type="hidden" name="attachment_information" id="attachment_information" value=""><div class="col-md-6"><label>Full Name</label><br><input class="form-control" type="text" name="full_name" id="full_name" value="" required="required"></div><div class="col-md-6"><label>Email</label><br><input class="form-control" type="text" name="email" id="email" value="" required="required"></div><div class="col-md-12"><label>Phone</label><br><input class="form-control" type="text" name="phone" id="phone" value="" required="required"></div><div><button class="btn btn-success package-builder-btn">Contact Us Now</button></div></form>';

//    $html .= '<div class="row"><h4 style="font-family: Arial, sans-serif;">Get In Touch Now</h4><hr style="width: 100%;"><div class="clearfix"></div>'.$packform.'</div>';


    $html .= '</div></div></div>';

    echo $html;
}

