<?php

$theSession = $_COOKIE["savedData"];
$obj = $a->fetch_array();
$title = str_replace('_', ' ', $obj["title"]);
$description = $obj["description"];
$id = $obj["id"];
$imageMain = json_decode($obj["eq_image"], true);
$productAttrs = json_decode($obj['product_attributes'], true);
$image = $imageMain[0];
$theprice = $obj["sales_price"];
$shipType = $obj["ship_type"];
$parentCatID = $obj["parent_cat"];
$catDetails = $data->query("SELECT * FROM custom_equipment_pages WHERE id = '$parentCatID'") or die($data->error);
$objCat = $catDetails->fetch_array();
$parentcat = $objCat["page_name"];
$sku = $obj["sku"];
$reviews_temp = $obj["product_reviews"];
$reviews = json_decode($obj["product_reviews"], true);
$rev = $data->query("SELECT * FROM custom_equipment_reviews WHERE active = 'true' AND product_name = '" . $obj['title'] . "'") or die($data->error);

$reviewsOut = '';
$ratingsAvg = 0;
$ratingCount = 0;


if (!isset($theSession)) {
    //Location Getter//

    // check if location sel is turned on //
    $chk = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'location_select'");
    $chk1 = $chk->fetch_array();

    if ($chk1["setting_value"] == true) {

        $cv = $data->query("SELECT id,location_name FROM location WHERE active = 'true'") or die($data->error);
        while ($x = $cv->fetch_array()) {
            //CHECK QTY FOR EACH LOCATION//

            $u = $data->query("SELECT stock FROM equipment_location_manager WHERE equip_id = '" . $obj["id"] . "' AND location_id = '" . $x["id"] . "'");

            if ($u->num_rows > 0) {
                $w = $u->fetch_array();

                if ($w["stock"] > 0) {
                    $locasel .= '<option value="' . $x["id"] . '">' . $x["location_name"] . '</option>';
                } else {
                    $locasel .= '<option value="' . $x["id"] . '" disabled="disabled">' . $x["location_name"] . ' - Out of stock</option>';
                }
            } else {
                $locasel .= '<option value="' . $x["id"] . '" disabled="disabled">' . $x["location_name"] . ' - Out of stock</option>';
            }
        }
    }
}

$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
$uniqIDs = md5(date('djsi'));


//check location selection//
if (isset($theSession)) {
    $convertJsn = json_decode($theSession, true);
    $locids = $convertJsn["shop_location"];
    $chk = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'location_select'");
    $chk1 = $chk->fetch_array();
    if ($chk1["setting_value"] == 'true') {

        $m = $data->query("SELECT location_name FROM location WHERE id = '$locids'");
        $l = $m->fetch_array();

        $locationSet = $l["location_name"];
        $locOut .= '<b>Store Location:</b> <i>' . $locationSet . '</i><input type="hidden" name="locasel" id="locasel" value="' . $locids . '">';

        //check stock for selected location//
        $u = $data->query("SELECT stock FROM equipment_location_manager WHERE equip_id = '" . $obj["id"] . "' AND location_id = '" . $locids . "'");
        $x = $u->fetch_array();


        if ($x["stock"] > 0) {
            if (array_search($obj["title"], array_column($convertJsn["cartitems"], 'name')) !== FALSE && $convertJsn["cartitems"] != null) {
                $disabs = 'disabled="disabled"';
                $buttonText = 'Already in Cart';
            } else {
                $disabs = '';
                $buttonText = 'Add to Cart';
            }
        } else {
            $disabs = 'disabled="disabled"';
            $buttonText = 'Out of stock';
        }
    } else {

        // check if sell_per_qty is true //

        $chk = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'sell_per_qty'");
        $chk1 = $chk->fetch_array();
        if ($chk1["setting_value"] == 'true') {
            //check stock for selected location//
            $u = $data->query("SELECT stock FROM equipment_location_manager WHERE equip_id = '" . $obj["id"] . "' AND location_id = '" . $locids . "'");
            $x = $u->fetch_array();


            if ($x["stock"] > 0) {
                if (array_search($obj["title"], array_column($convertJsn["cartitems"], 'name')) !== FALSE && $convertJsn["cartitems"] != null) {
                    $disabs = 'disabled="disabled"';
                    $buttonText = 'Already in Cart';
                } else {
                    $disabs = '';
                    $buttonText = 'Add to Cart';
                    $chk = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'qty_sel_prod_page'");
                    $chk1 = $chk->fetch_array();
                    if ($chk1["setting_value"] == 'true') {
                        $qtyBox = '<input style="padding: 10px" class="" type="number" name="qty" id="qty" value="1">';
                    } else {
                        $qtyBox = '<input class="" type="hidden" name="qty" id="qty" value="1">';
                    }
                }
            } else {
                $disabs = 'disabled="disabled"';
                $buttonText = 'Out of stock';
            }
        } else {
            if (array_search($obj["title"], array_column($convertJsn["cartitems"], 'name')) !== FALSE && $convertJsn["cartitems"] != null) {
                $disabs = 'disabled="disabled"';
                $buttonText = 'Already in Cart';
            } else {
                $disabs = '';
                $buttonText = 'Add to Cart';
                $chk = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'qty_sel_prod_page'");
                $chk1 = $chk->fetch_array();
                if ($chk1["setting_value"] == 'true') {
                    $qtyBox = '<input style="padding: 10px" class="" type="number" name="qty" id="qty" value="1">';
                } else {
                    $qtyBox = '<input class="" type="hidden" name="qty" id="qty" value="1">';
                }
            }
        }
    }
} else {
    $chk = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'location_select'");
    $chk1 = $chk->fetch_array();
    if ($chk1["setting_value"] == 'true') {
        $locOut .= 'Select Store Location<br><select class="form-control" id="locasel" name="locasel"><option value="">Select Store Location</option>' . $locasel . '</select>';
        $disabs = 'disabled="disabled"';
        $buttonText = 'Add to Cart';
        $qtyBox = '<input class="" type="hidden" name="qty" id="qty" value="1">';
    } else {
        $chk = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'qty_sel_prod_page'");
        $chk1 = $chk->fetch_array();
        if ($chk1["setting_value"] == 'true') {

            // some checking for stock if sell_per_qty enabled //
            $chk = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'sell_per_qty'");
            $chk1 = $chk->fetch_array();
            if ($chk1["setting_value"] == 'true') {
                $locs = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'default_ship_location'");
                $local = $locs->fetch_array();
                $theLocation = $local["setting_value"];
                if ($theLocation != null) {
                    $stockInd = 'false';
                    $aa = $data->query("SELECT stock FROM equipment_location_manager WHERE equip_id = '" . $obj["id"] . "' AND location_id = '$theLocation'");
                    $bb = $aa->fetch_array();

                    if ($bb["stock"] > 0) {
                        $stockInd = 'true';
                        $locOut = 'Quantity';
                        $qtyBox = '<input style="padding: 10px" class="" type="number" name="qty" id="qty" value="1">';
                        $buttonText = 'Add to Cart';
                    } else {
                        $stockInd = 'true';
                        $locOut = '';
                        $qtyBox = '';
                        $disabs = 'disabled="disabled"';
                        $buttonText = 'Out of Stock';
                    }
                } else {
                    $stockInd = 'false';
                    $disabs = 'disabled="disabled"';
                    $buttonText = 'Out of Stock';
                }
            } else {
                $locOut = 'Quantity';
                $qtyBox = '<input style="padding: 10px" class="" type="number" name="qty" id="qty" value="1">';
                $buttonText = 'Add to Cart';
            }
        } else {
            $locOut = '';
            $qtyBox = '<input class="" type="hidden" name="qty" id="qty" value="1">';
            $buttonText = 'Add to Cart';
        }
    }
}

ProductPageHeader();

function ProductPageHeader()
{
    $html = '';
    $html .= '
                    <style>
            @import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css");
            :root {
                --ecommerce-primary-color: #005797;
                --ecommerce-secondary-color: #343a40;
                --ecommerce-star-color: #005797;
                --ecommerce-background-color: #f2f2f2;
            }

            /*header styling*/
            h1.bcss_ecommerce{
                font-size: 2rem;
            }
            h2.bcss_ecommerce{
                font-size: 1.1rem;
            }
            h2.bcss_ecommerce.big{
                font-size: 2rem;
            }
            h3.bcss_ecommerce{
                font-size: 2rem;
            }
            h3.bcss_ecommerce.small{
                font-size: 1.6rem;
            }
            h3.bcss_ecommerce_primary-background{
                color: #fff;
                background-color: var(--ecommerce-primary-color);
            }
            h4.bcss_ecommerce,
            h4.bcss_ecommerce span{
                font-family: bebas neue,cursive;
                text-transform: uppercase;
                font-size: 1.6rem;
            }
            /*end header styling*/

            /*elements styling*/
            a.bcss_ecommerce{
                text-decoration: none !important;
                color: var(--ecommerce-primary-color)!important;
            }
            ul.bcss_ecommerce{
                padding: 0;
                margin: 0;
                list-style: none;
            }
            .bi-star,
            .bi-star-fill,
            .bi-star-half{
                color: var(--ecommerce-star-color);
            }
            .bcss_ecommerce_primary-color{
                color: var(--ecommerce-primary-color);
            }
            .bcss_ecommerce_button-main{
                background-color: var(--ecommerce-secondary-color);
                color: #fff;
                border-radius:0;
                margin: 0 0 0 5px;
                font-size: 17px;
            }
            .bcss_ecommerce_button{
                background-color: var(--ecommerce-secondary-color);
                color: #fff;
                border-radius:0;
                margin: 0;
                font-size: 17px;
            }
            .bcss_ecommerce_details_background{
                background-color: var(--ecommerce-background-color);
            }
            /*end elements styling*/

            /*styling for color choose*/
            .pill img{
                height:50px;
                width: 100%;
                cursor: pointer;
                transition: transform 1s;
                object-fit: cover;
            }
            .pill label{
                overflow: hidden;
                position: relative;
            }
            .imgbgchk:checked + label>.tick_container{
                opacity: 1;
            }
            .imgbgchk:checked + label>img{
                transform: scale(1.25);
                opacity: 0.3;
            }
            .tick_container {
                transition: .5s ease;
                opacity: 0;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                -ms-transform: translate(-50%, -50%);
                cursor: pointer;
                text-align: center;
            }
            .tick {
                background-color: var(--ecommerce-primary-color);
                color: white;
                font-size: 12px;
                padding: 3px 3px;
                height: 20px;
                width: 20px;
                border-radius: 100%;
            }
            /*end styling for color choose*/

            /*promo price styling*/
            .bcss_ecommerce_promotion-price{
                color: var(--ecommerce-secondary-color);
                font-size: 1rem;
                font-weight: 700;
            }
            .bcss_ecommerce_promotion-difference{
                padding: 0 3px;
                background: red;
                font-size: .8rem;
                color: #fff;
                font-weight: 700;
            }
            .bcss_ecommerce_promotion-old{
                margin-left: 5px;
                color: var(--ecommerce-secondary-color);
                font-size: .8rem;
                font-weight: 500;
            }
            /*end promo price styling*/

            /*other products slider*/
            .other_product_slide .slick-prev:before,
            .other_product_slide .slick-next:before {
                font-size: 24pt;
                color: var(--ecommerce-primary-color);
            }
            .other_product_slide .slick-prev {
                left: -5vw;
            }
            .other_product_slide .slick-next {
                right: -5vw;
            }
            .other_product_slide .slick-dots li button,
            .slick-dots li.slick-active button:before {
                color: var(--ecommerce-primary-color);
            }
            .other_product_slide .slick-dots li button:before {
                font-size: 50px;
            }
            .bcss_ecommerce_card{
                margin-bottom: 20px;
                border-radius: 0px;
                border: transparent;
                width: 278px;
            }
            .bcss_ecommerce_img{
                object-fit: cover;
                width: 100%;
                height: 240px;
            }
            /*end other products slider*/

            /*product reviews*/
            .reviews article:nth-child(odd){
                background-color: var(--ecommerce-background-color);
            }
            .bcss_ecommerce_light{
                font-weight: 400;
                display: inline;
            }
            .hidden.bcss_ecommerce_comment_list{
                height: 0;
                visibility: collapse;
                padding: 0!important;
                margin: 0!important;
            }
            /*end product reviews*/

            /*rating form*/
            /*.form_rating {*/
                /*display: flex;*/
                /*flex-direction: row-reverse;*/
                /*justify-content: flex-end;*/
            /*}*/

            .form_rating > input[type="radio"]{ display:none;}

            .form_rating > label {
                position: relative;
                width: 1em;
                font-size: 2rem;
                /*color: #005797;*/
                cursor: pointer;
            }
            /*.form_rating > label::before{*/
                /*content: "\2605";*/
                /*position: absolute;*/
                /*opacity: 0;*/
            /*}*/
            /*.form_rating > label:hover:before,*/
            /*.form_rating > label:hover ~ label:before {*/
                /*opacity: 1 !important;*/
            /*}*/

            /*.form_rating > input:checked ~ label:before{*/
                /*opacity:1;*/
            /*}*/

            /*.form_rating:hover > input:checked ~ label:before{ opacity: 0.4; }*/
            /*end rating form*/

            /*product listing page*/
            .bcss_ecommerce_serch_result{
                font-size: 1.6rem;
            }
            .bcss_ecommerce_cpp-active{
                font-weight: 700;
            }
            .bcss_ecommerce_product_list_img{
                object-fit: cover;
                width: 80%;
                height: 240px;
            }
            .hidden{
                height: 0;
                visibility: collapse;
            }
            input[type="radio"]:checked + label{
                font-weight: 700;
            }
            .form_rating >  input{
                visibility: hidden;
                width: 0;
                height:0;
            }
            @font-face {
            font-family: "FontAwesome";
            font-display: block;
            src: url(https://ka-f.fontawesome.com/releases/v5.15.4/webfonts/free-fa-solid-900.eot);
            src: url(https://ka-f.fontawesome.com/releases/v5.15.4/webfonts/free-fa-solid-900.eot?#iefix) format("embedded-opentype"), url(https://ka-f.fontawesome.com/releases/v5.15.4/webfonts/free-fa-solid-900.woff2) format("woff2"), url(https://ka-f.fontawesome.com/releases/v5.15.4/webfonts/free-fa-solid-900.woff) format("woff"), url(https://ka-f.fontawesome.com/releases/v5.15.4/webfonts/free-fa-solid-900.ttf) format("truetype"), url(https://ka-f.fontawesome.com/releases/v5.15.4/webfonts/free-fa-solid-900.svg#fontawesome) format("svg")
        }

        @font-face {
            font-family: "FontAwesome";
            font-display: block;
            src: url(https://ka-f.fontawesome.com/releases/v5.15.4/webfonts/free-fa-brands-400.eot);
            src: url(https://ka-f.fontawesome.com/releases/v5.15.4/webfonts/free-fa-brands-400.eot?#iefix) format("embedded-opentype"), url(https://ka-f.fontawesome.com/releases/v5.15.4/webfonts/free-fa-brands-400.woff2) format("woff2"), url(https://ka-f.fontawesome.com/releases/v5.15.4/webfonts/free-fa-brands-400.woff) format("woff"), url(https://ka-f.fontawesome.com/releases/v5.15.4/webfonts/free-fa-brands-400.ttf) format("truetype"), url(https://ka-f.fontawesome.com/releases/v5.15.4/webfonts/free-fa-brands-400.svg#fontawesome) format("svg")
        }

        @font-face {
            font-family: "FontAwesome";
            font-display: block;
            src: url(https://ka-f.fontawesome.com/releases/v5.15.4/webfonts/free-fa-regular-400.eot);
            src: url(https://ka-f.fontawesome.com/releases/v5.15.4/webfonts/free-fa-regular-400.eot?#iefix) format("embedded-opentype"), url(https://ka-f.fontawesome.com/releases/v5.15.4/webfonts/free-fa-regular-400.woff2) format("woff2"), url(https://ka-f.fontawesome.com/releases/v5.15.4/webfonts/free-fa-regular-400.woff) format("woff"), url(https://ka-f.fontawesome.com/releases/v5.15.4/webfonts/free-fa-regular-400.ttf) format("truetype"), url(https://ka-f.fontawesome.com/releases/v5.15.4/webfonts/free-fa-regular-400.svg#fontawesome) format("svg");
            unicode-range: U+f004-f005, U+f007, U+f017, U+f022, U+f024, U+f02e, U+f03e, U+f044, U+f057-f059, U+f06e, U+f070, U+f075, U+f07b-f07c, U+f080, U+f086, U+f089, U+f094, U+f09d, U+f0a0, U+f0a4-f0a7, U+f0c5, U+f0c7-f0c8, U+f0e0, U+f0eb, U+f0f3, U+f0f8, U+f0fe, U+f111, U+f118-f11a, U+f11c, U+f133, U+f144, U+f146, U+f14a, U+f14d-f14e, U+f150-f152, U+f15b-f15c, U+f164-f165, U+f185-f186, U+f191-f192, U+f1ad, U+f1c1-f1c9, U+f1cd, U+f1d8, U+f1e3, U+f1ea, U+f1f6, U+f1f9, U+f20a, U+f247-f249, U+f24d, U+f254-f25b, U+f25d, U+f271-f274, U+f279, U+f28b, U+f28d, U+f2b5-f2b6, U+f2b9, U+f2bb, U+f2bd, U+f2c1-f2c2, U+f2d0, U+f2d2, U+f2dc, U+f2ed, U+f3a5, U+f3d1, U+f410
        }

        @font-face {
            font-family: "FontAwesome";
            font-display: block;
            src: url(https://ka-f.fontawesome.com/releases/v5.15.4/webfonts/free-fa-v4deprecations.eot);
            src: url(https://ka-f.fontawesome.com/releases/v5.15.4/webfonts/free-fa-v4deprecations.eot?#iefix) format("embedded-opentype"), url(https://ka-f.fontawesome.com/releases/v5.15.4/webfonts/free-fa-v4deprecations.woff2) format("woff2"), url(https://ka-f.fontawesome.com/releases/v5.15.4/webfonts/free-fa-v4deprecations.woff) format("woff"), url(https://ka-f.fontawesome.com/releases/v5.15.4/webfonts/free-fa-v4deprecations.ttf) format("truetype"), url(https://ka-f.fontawesome.com/releases/v5.15.4/webfonts/free-fa-v4deprecations.svg#fontawesome) format("svg");
            unicode-range: U+f003, U+f006, U+f014, U+f016, U+f01a-f01b, U+f01d, U+f040, U+f045-f047, U+f05c-f05d, U+f07d-f07e, U+f087-f088, U+f08a-f08b, U+f08e, U+f090, U+f096-f097, U+f0a2, U+f0e4-f0e6, U+f0ec-f0ee, U+f0f5-f0f7, U+f10c, U+f112, U+f114-f115, U+f11d, U+f123, U+f132, U+f145, U+f147-f149, U+f14c, U+f166, U+f16a, U+f172, U+f175-f178, U+f18e, U+f190, U+f196, U+f1b1, U+f1d9, U+f1db, U+f1f7, U+f20c, U+f219, U+f230, U+f24a, U+f250, U+f278, U+f27b, U+f283, U+f28c, U+f28e, U+f29b-f29c, U+f2b7, U+f2ba, U+f2bc, U+f2be, U+f2c0, U+f2c3, U+f2d3-f2d4
        }
    </style>
    <link href="css/jamesriver.css?v=0.1" rel="stylesheet">
    <link rel="stylesheet" href="inc/mods/machine_finder/slick-theme.min.css">
    <link rel="stylesheet" href="inc/mods/machine_finder/slick.min.css">
    <link rel="stylesheet" href="">
    <script src="inc/mods/custom_equipment/custom_functions.js"></script>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>';
}

if ($rev->num_rows > 0) {
    while ($review = $rev->fetch_array()) {
        if ($review['product_name'] == $title) {
            $date = date('Y-m-d H:i:s', $review['post_date']);
            //$dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $date);
            $dateVal = explode(" ", strval($date));
            $dateString = date('Y-m-d', $review['post_date']);
            $timestamp = strtotime($date);
            $month = date('F', $timestamp);
            $day = date('jS', $timestamp);
            $year = date('Y', $timestamp);

            // Format the date string
            $formattedDate = $month . ' ' . $day . ', ' . $year;
            $reviewsOut .= '<article class="row g-0 py-3 mx-0 bcss_ecommerce_comment_list" data-rating="4" itemprop="review" itemscope="" itemtype="https://schema.org/Review">
                                        <section class="col-md-3">
                                            <ul class="bcss_ecommerce">
                                                <li><strong>Posted on <time class="bcss_ecommerce_light" datetime="' . $date . '" itemprop="datePublished" content="' . $dateVal[0] . '">' . $formattedDate . '</time></strong></li>
                                                <li><strong itemscope="" itemprop="author" itemtype="http://schema.org/Person">by <span class="bcss_ecommerce_light" itemprop="name">' . $review['from'] . '</span></strong></li>
                                                <li><strong>Location: <address class="bcss_ecommerce_light">' . $review['location'] . '</address></strong></li>
                                                <li><strong>Length of Ownership: <span class="bcss_ecommerce_light">' . $review['ownership_length'] . '</span></strong></li>
                                                <li><strong>Usage: <span class="bcss_ecommerce_light">' . $review['usage'] . '</span></strong></li>
                                            </ul>
                                        </section>
                                        <section class="col-md-9">
                                            <h4 class="bcss_ecommerce" itemprop="name" style="font-family: sans-serif;">' . $review['review_title'] . '</h4>
                                            <div class="d-flex flex-row align-items-center my-1">
                                                <strong>Customer Rating: </strong>
                                                <div class="ratings bcss_ecommerce d-flex flex-row mx-1" itemprop="reviewRating" itemscope="" itemtype="https://schema.org/Rating">';
            // ------- Star Ratings
            if (doubleval($review['rating']) >= 1) {
                $reviewsOut .= '<i class="bi bi-star-fill"></i>';
            } else {
                $reviewsOut .= '<i class="bi bi-star"></i>';
                if (doubleval($review['rating']) >= .5) {
                    $reviewsOut .= '<i class="bi bi-star-half"></i>';
                } else {
                    $reviewsOut .= '<i class="bi bi-star"></i>';
                }
            }
            if (doubleval($review['rating']) >= 2) {
                $reviewsOut .= '<i class="bi bi-star-fill"></i>';
            } else {
                if (doubleval($review['rating']) >= 1.5) {
                    $reviewsOut .= '<i class="bi bi-star-half"></i>';
                } else {
                    $reviewsOut .= '<i class="bi bi-star"></i>';
                }
            }
            if (doubleval($review['rating']) >= 3) {
                $reviewsOut .= '<i class="bi bi-star-fill"></i>';
            } else {
                if (doubleval($review['rating']) >= 2.5) {
                    $reviewsOut .= '<i class="bi bi-star-half"></i>';
                } else {
                    $reviewsOut .= '<i class="bi bi-star"></i>';
                }
            }
            if (doubleval($review['rating']) >= 4) {
                $reviewsOut .= '<i class="bi bi-star-fill"></i>';
            } else {
                if (doubleval($review['rating']) >= 3.5) {
                    $reviewsOut .= '<i class="bi bi-star-half"></i>';
                } else {
                    $reviewsOut .= '<i class="bi bi-star"></i>';
                }
            }
            if (doubleval($review['rating']) == 5) {
                $reviewsOut .= '<i class="bi bi-star-fill"></i>';
            } else {
                if (doubleval($review['rating']) >= 4.5) {
                    $reviewsOut .= '<i class="bi bi-star-half"></i>';
                } else {
                    $reviewsOut .= '<i class="bi bi-star"></i>';
                }
            }
            $reviewsOut .= '<meta itemprop="worstRating" content="1">
                                                    <meta itemprop="ratingValue" content="4">
                                                    <meta itemprop="bestRating" content="5">
                                                </div>
                                            </div>
                                            <p itemprop="reviewBody">' . $review['review_description'] . '
                                            </p>
                                        </section>
                                    </article>';
            $ratingCount++;
            $ratingsAvg = ($ratingsAvg + doubleval($review['rating'])) / $ratingCount;
        }
    }
}

$html .= '
                    <div class="container-fluid mx-5 my-5">
                        <section class="row g-0 mb-5">
                            <div class="col-md-6">
                                <!--product gallery-->
                                <div class="row justify-content-center align-items-center">
                                    <!--product gallery image-->
                                    <div class="col-12 product-slide">
                                        <img class="img-fluid mx-auto d-block main-img" data-toggle="modal" data-target=".bd-example-modal-lg" src="' . $image . '" itemprop="image">
                                        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <img class="img-fluid mx-auto d-block pop-img" src="' . $image . '" itemprop="image">
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    <!--end product gallery image-->

                                    <!--product gallery thumbnails-->
                                    <div class="row g-0 justify-content-center product-slide-thumbs">';
for ($z = 0; $z < count($imageMain); $z++) {
    $path = str_replace("/", "//", $imageMain[$z]);
    $html .= '<script>console.log("' . $imageMain[$z] . '");</script>';
    $html .= '<div class="col-3"><a onclick="ChangeImage(\'' . $imageMain[$z] . '\')"><img class="img-thumbnail w-100" src="' . $imageMain[$z] . '" itemprop="image"></a></div>';
}
$html .= '</div>
                                    <!--end product gallery thumbnails-->

                                </div>
                                <!--end product gallery-->
                            </div>
                            <div class="col-md-6">
                                <!--product name-->
                                <div class="d-flex justify-content-between align-items-center">
                                    <h1 class="m-0 bcss_ecommerce" itemprop="name">' . str_replace("-", " ", $title) . '</h1>
                                    <meta itemprop="brand" content="John Deere" />
                                </div>
                                <!--product name-->

                                <!--product category-->
                                <h2 class="m-0 bcss_ecommerce"><a class="text-capitalize bcss_ecommerce" href="' . $parentcat . '" >' . str_replace("-", " ", $parentcat) . '</a></h2>
                                <!--end product category-->

                                <!--rating -->
                                <div class="d-flex flex-row align-items-center mt-2 bcss_ecommerce_product_rating" data-rating="4.45" itemprop="aggregateRating" itemscope itemtype="https://schema.org/AggregateRating">
                                    <div class="ratings bcss_ecommerce d-flex flex-row mx-1">';
// ------- Star Ratings
if (doubleval($ratingsAvg) >= 1) {
    $html .= '<i class="bi bi-star-fill"></i>';
} else {
    if (doubleval($ratingsAvg) >= .5) {
        $html .= '<i class="bi bi-star-half"></i>';
    } else {
        $html .= '<i class="bi bi-star"></i>';
    }
}
if (doubleval($ratingsAvg) >= 2) {
    $html .= '<i class="bi bi-star-fill"></i>';
} else {
    if (doubleval($ratingsAvg) >= 1.5) {
        $html .= '<i class="bi bi-star-half"></i>';
    } else {
        $html .= '<i class="bi bi-star"></i>';
    }
}
if (doubleval($ratingsAvg) >= 3) {
    $html .= '<i class="bi bi-star-fill"></i>';
} else {
    if (doubleval($ratingsAvg) >= 2.5) {
        $html .= '<i class="bi bi-star-half"></i>';
    } else {
        $html .= '<i class="bi bi-star"></i>';
    }
}
if (doubleval($ratingsAvg) >= 4) {
    $html .= '<i class="bi bi-star-fill"></i>';
} else {
    if (doubleval($ratingsAvg) >= 3.5) {
        $html .= '<i class="bi bi-star-half"></i>';
    } else {
        $html .= '<i class="bi bi-star"></i>';
    }
}
if (doubleval($ratingsAvg) == 5) {
    $html .= '<i class="bi bi-star-fill"></i>';
} else {
    if (doubleval($ratingsAvg) >= 4.5) {
        $html .= '<i class="bi bi-star-half"></i>';
    } else {
        $html .= '<i class="bi bi-star"></i>';
    }
}
$html .= '</div>
                                    <strong class="mr-1"><span itemprop="ratingValue">' . $ratingsAvg . '</span>/5 (<span itemprop="reviewCount">' . $ratingCount . '</span>)</strong>
                                    <a class="bcss_ecommerce" data-toggle="modal" data-target="#reviewModal"><strong>        Write a review</strong></a>
                                </div>
                                <!--end rating -->

                                <!--short product description-->
                                <div class="mt-2 content">
                                    <h3 class="m-0 my-2 bcss_ecommerce small">Product description</h3>
                                    <div class="product attribute description">
                                        <p class="value" itemprop="description">' . $description . '</p>
                                    </div>
                                </div>';

// Product Attributes
if ($productAttrs != null && $productAttrs != "") {


    $parent = $data->query("SELECT * FROM custom_equipment_product_attr_parent WHERE id = " . $productAttrs[0] . "");
    $parents = $parent->fetch_array();

    $html .= '<div class="col-md-6 mt-2">
                                    <h4 class="m-0">Choose ' . $parents["attr_grp_name"] . '</h4>
                                    <select class="custom-select mt-2" id="prod-attr" onchange="UpdateProductPrice()">';

    //Get Attributes
    $child = $data->query("SELECT * FROM custom_equipment_product_attr_childs WHERE attr_parent = " . $productAttrs[0] . "");
    while ($childs = $child->fetch_array()) {
        $html .= '<option class"sel-attr" data-price="' . $childs["attr_price"] . '">' . $childs["attr_name"] . '</option>';
    }

    $html .=
        '</select>

                                <script>
                                function UpdateProductPrice(){
                                    var price = $("#prod-attr").find(":selected").data("price");

                                    console.log(price);   

                                    $("#price-out").text("$ " + price.toFixed(2));
                                    $(".add-to-cart").attr("data-price", price.toFixed(2))
                                    $(".add-to-cart").data("price", price.toFixed(2))
                                }
                                </script>
                                </div>';
}

$html .= '<!--discounted prize-->
                                <div class="mt-3" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                                    <meta itemprop="url" href="https://www.example.com/trinket_offer" />
                                    <meta itemprop="priceCurrency" content="USD" />
                                    <h4 class="my-0 price-out" id="price-out">$ ' . number_format($theprice, 2) . '</h4>
                                    <meta itemprop="availability" content="https://schema.org/InStock" />
                                    <meta itemprop="itemCondition" content="https://schema.org/NewCondition" />
                                    <meta itemprop="priceValidUntil" content="30-11-2023" />';


$html .= '<!--additional option-->';

if ($shipType == "pickup_only") {
    $html .= '<p class="mt-3 bcss_ecommerce_primary-color">
                                                    <i class="fa fa-map-marker" aria-hidden="true"></i> <span>In-Store Pickup Only</span>
                                                </p>';
} else {
    $html .= '<p class="mt-3 bcss_ecommerce_primary-color">
                                                    <i class="fa fa-map-marker" aria-hidden="true"></i> <span>Available To Ship</span>
                                                </p>';
}

$html .= '<!--end additional option-->

                                </div>
                                <!--end discounted prize-->

                                <!--sku number-->
                                <p class="mt-3 text-muted">SKU: <span itemprop="sku">' . $sku .
    '</span></p>
                                <!--end sku number-->

                                <!--social media shearing -->
                                <ul class="mb-2 d-none">
                                    <li><a href="" rel="nofollow"></a></li>
                                    <li><a href="" rel="nofollow"></a></li>
                                    <li><a href="" rel="nofollow"></a></li>
                                    <li><a href="" rel="nofollow"></a></li>
                                </ul>
                                <!--end of social media shearing -->

                                <!--j have no idea what is that-->
                                <script async="" src="https://static.addtoany.com/menu/page.js"></script>
                                <!--end i have no idea what is that-->

                                <!-- add to cart-->
                                                                     <div class="mt-2">';
$locOut = '';
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
$uniqIDs = md5(date('djsi'));
$html .= '
        <input type="text" class="form-control d-none" name="id" id="id" value="' . $obj['id'] . '">
        <input type="text" class="form-control d-none" name="title" id="title" value="' . $obj['title'] . '">
        <input type="text" class="form-control d-none" name="price" id="price" value="' . $theprice . '">
        <input type="text" class="form-control d-none" name="url" id="url" value="' . $actual_link . '">
        <input type="text" class="form-control d-none" name="itemid" id="itemid" value="' . $uniqIDs . '">
        <input type="text" class="form-control d-none" name="shiptype" id="shiptype" value="' . $obj['ship_type'] . '">';
$html .= '<a onclick="AddToCart()"><button class="btn btn-dark add-to-cart disabs" data-id="' . $obj['id'] . '" data-title="' . $obj['title'] . '" data-shiptype="' . $obj['ship_type'] . '" data-price="' . $theprice . '" data-url="' . $actual_link . '" data-uniq="' . $uniqIDs . '" style="border-radius:0;">Add To Cart</button></a>';
$html .= '
                <script type="text/javascript" src="inc/mods/custom_equipment/custom_functions.js"></script>
                    </div>
                   
                            </div>
                        </section>
                        <div class="row mt-4 mx-5 px-5">
                            <nav class="col-md-12 w-100">
                            <div class="nav nav-tabs" id="product-tab" role="tablist">
                                <a class="nav-item nav-link" id="product-desc-tab" data-toggle="tab" href="#product-desc" role="tab" aria-controls="product-desc" aria-selected="false">Product Details</a>
                                <a class="nav-item nav-link" id="product-comments-tab" data-toggle="tab" href="#product-comments" role="tab" aria-controls="product-comments" aria-selected="false">Other Products From Category</a>
                                <a class="nav-item nav-link active" id="product-rating-tab" data-toggle="tab" href="#product-rating" role="tab" aria-controls="product-rating" aria-selected="true">Reviews</a>
                            </div>
                            </nav>
                            <div class="tab-content p-3" id="nav-tabContent">
                            <div class="tab-pane fade" id="product-desc" role="tabpanel" aria-labelledby="product-desc-tab"> 
                                <article class="p-3">
                                <div class="row justify-content-center">
                                <div class="col-md-12">
                                    <table width="984">
                                        <tbody>
                                            <tr>
                                                <td width="492">Specifications:</td>
                                                <td width="492">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>Manufacturer</td>
                                                <td>Frontier</td>
                                            </tr>
                                            <tr>
                                                <td>PCI Model</td>
                                                <td>AP10FXF</td>
                                            </tr>
                                            <tr>
                                                <td>Model</td>
                                                <td>AP10F</td>
                                            </tr>
                                            <tr>
                                                <td>Locale Code</td>
                                                <td>en_NA</td>
                                            </tr>
                                            <tr>
                                                <td>SBU</td>
                                                <td>at</td>
                                            </tr>
                                            <tr>
                                                <td>Key Specs</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Current series style</td>
                                                <td>100, 200&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>Fork tines</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>Type</td>
                                                <td>Fixed&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>Length</td>
                                                <td>91.4 and 106.7 cm&nbsp;&nbsp; 36 and 42 in.&nbsp;&nbsp;&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>Dimensions</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Overall height</td>
                                                <td>62.2 cm&nbsp;&nbsp; 24.5 in.&nbsp;&nbsp;&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>Overall width</td>
                                                <td>125.1 cm&nbsp;&nbsp; 49.25 in.&nbsp;&nbsp;&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>Overall length</td>
                                                <td width="492">Length with 91.4-cm (36-in.) tines - 114.3 cm&nbsp;&nbsp; 45 in.&nbsp;&nbsp; Length with 106.7-cm (42-in.) tines - 129.5 cm&nbsp;&nbsp; 51 in.&nbsp;&nbsp;&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>Weight</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Operational</td>
                                                <td>With 36-inch tines: 77.1 kg&nbsp;&nbsp; 170 lb&nbsp;&nbsp; With 42-inch tines: 89.8 kg&nbsp;&nbsp; 198 lb&nbsp;&nbsp;&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>Shipping</td>
                                                <td>With 36-inch tines: 97.1 kg&nbsp;&nbsp; 214 lb&nbsp;&nbsp; With 42-inch tines: 109.8 kg&nbsp;&nbsp; 242 lb&nbsp;&nbsp;&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>Fork tines</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Type</td>
                                                <td>Fixed&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>Capacity</td>
                                                <td width="492">Capacity with 91.4-cm (36-in.) tines - 567 kg&nbsp;&nbsp; 1250 lb&nbsp;&nbsp; Capacity with 106.7-cm (42-in.) tines - 567 kg&nbsp;&nbsp;&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>Section</td>
                                                <td width="492">Section with 91.4-cm (36-in.) tines - 25.4 x 76.6 mm&nbsp;&nbsp; 1.0 x 3.0 in.&nbsp;&nbsp; Section with 106.7-cm (42-in.) tines - 30 x 80 mm&nbsp;&nbsp; 1.18 x 3.13 in.&nbsp;&nbsp;&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>Length</td>
                                                <td>91.4 and 106.7 cm&nbsp;&nbsp; 36 and 42 in.&nbsp;&nbsp;&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>Set-up time</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Labor hours</td>
                                                <td>0.25&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>Warranty</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Time period</td>
                                                <td>1 year&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>Additional information</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Date collected</td>
                                                <td>1-August-2017&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                            </tr>
                                        </tbody>
                                        </table>
                                        </div>
                                        </div>
                                </article>
                            </div>
                            <div class="tab-pane fade" id="product-comments" role="tabpanel" aria-labelledby="product-comments-tab"> 
                                <section class="row mb-5">
                                    <div class="col-12 text-center">
                                        <h3 class="my-0 bcss_ecommerce">Other Products From Category</h3>
                                    </div>
                                    
                    <div class="col-12 col-lg-10 col-xl-12 mx-auto">

  <script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
  <script src="./slick/slick.js" type="text/javascript" charset="utf-8"></script>
                        <section class="regular slider">
                            <div>
                            <img src="http://placehold.it/350x300?text=1">
                            </div>
                            <div>
                            <img src="http://placehold.it/350x300?text=2">
                            </div>
                            <div>
                            <img src="http://placehold.it/350x300?text=3">
                            </div>
                            <div>
                            <img src="http://placehold.it/350x300?text=4">
                            </div>
                            <div>
                            <img src="http://placehold.it/350x300?text=5">
                            </div>
                            <div>
                            <img src="http://placehold.it/350x300?text=6">
                            </div>
                        </section>
                        <script>
                            $(".regular").slick({
                                dots: true,
                                infinite: true,
                                slidesToShow: 3,
                                slidesToScroll: 3
                            });
                        </script>
                    </div>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
                                </section>
                            </div>
                            <div class="tab-pane fade active show" id="product-rating" role="tabpanel" aria-labelledby="product-rating-tab">
                                <section class="row g-0 mb-5">
                                    <div class="col-12">
                                        <h3 class="my-0 bcss_ecommerce">Product Reviews</h3>
                                    </div>';

$html .= '<div class="col-12">
                            <div class="row g-0 mt-3">
                                <div class="col-12 mb-3 mb-md-0 col-md-2">
                                    <img class="img-thumbnail mx-auto d-block" src="' . $image . '">
                                </div>
                                <div class="col-12 col-md-8 col-md-10 bcss_ecommerce_product_rating" data-rating="4.45">
                                    <strong style="font-size: 1.2rem;">' . $title . '</strong><br>
                                    <strong><a class="bcss_ecommerce" href="">' . str_replace("-", " ", $parentcat) . '</a></strong><br>
                                    <div class="d-flex flex-row align-items-center mt-1">
                                        <strong>Average Customer Rating: </strong>
                                        <div class="ratings bcss_ecommerce d-flex flex-row mx-1">';

// ------- Star Ratings
if (doubleval($ratingsAvg) >= 1) {
    $html .= '<i class="bi bi-star-fill"></i>';
} else {
    if (doubleval($ratingsAvg) >= .5) {
        $html .= '<i class="bi bi-star-half"></i>';
    } else {
        $html .= '<i class="bi bi-star"></i>';
    }
}
if (doubleval($ratingsAvg) >= 2) {
    $html .= '<i class="bi bi-star-fill"></i>';
} else {
    if (doubleval($ratingsAvg) >= 1.5) {
        $html .= '<i class="bi bi-star-half"></i>';
    } else {
        $html .= '<i class="bi bi-star"></i>';
    }
}
if (doubleval($ratingsAvg) >= 3) {
    $html .= '<i class="bi bi-star-fill"></i>';
} else {
    if (doubleval($ratingsAvg) >= 2.5) {
        $html .= '<i class="bi bi-star-half"></i>';
    } else {
        $html .= '<i class="bi bi-star"></i>';
    }
}
if (doubleval($ratingsAvg) >= 4) {
    $html .= '<i class="bi bi-star-fill"></i>';
} else {
    if (doubleval($ratingsAvg) >= 3.5) {
        $html .= '<i class="bi bi-star-half"></i>';
    } else {
        $html .= '<i class="bi bi-star"></i>';
    }
}
if (doubleval($ratingsAvg) == 5) {
    $html .= '<i class="bi bi-star-fill"></i>';
} else {
    if (doubleval($ratingsAvg) >= 4.5) {
        $html .= '<i class="bi bi-star-half"></i>';
    } else {
        $html .= '<i class="bi bi-star"></i>';
    }
}

$modalReview = '<!-- Modal -->
<div class="modal modal fade bd-example-modal-lg" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Write A Review</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
            <div class="row">
                <div class="col-md-6">
                <div class="form-group">
                    <label for="mod-name">Name</label>
                    <input type="text" class="form-control" id="mod-name" name="mod-name" required>
                </div>
                <div class="form-group">
                    <label for="mod-loc">Location</label>
                    <input type="text" class="form-control" id="mod-loc" name="mod-loc" required>
                </div>
                <div class="form-group">
                    <label for="mod-title">Title</label>
                    <input type="text" class="form-control" id="mod-title" name="mod-title" required>
                </div>
                </div>
                <div class="col-md-6">
                <div class="form-group">
                    <label for="mod-desc">Description</label>
                    <textarea class="form-control" id="mod-desc" name="mod-desc" rows="5" required></textarea>
                </div>
                <div class="form-group">
                    <label for="usage">Usage</label>
                    <select class="form-control" id="mod-usage" name="mod-usage">
                    <option value="Daily">Daily</option>
                    <option value="Monthly">Monthly</option>
                    <option value="Yearly">Yearly</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="mod-length">Length of Ownership</label>
                    <select class="form-control" id="mod-length" name="mod-length">
                        <option value="Less Than 1 Year">Less Than 1 Year</option>
                        <option value="1 Year or Less">More than 1 Year</option>
                        <option value="More than 3 Years">More than 3 Years</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="mod-rating">Rating</label>
                    <select class="form-control" id="mod-rating" name="mod-rating">
                        <option value="1">1</option>
                        <option value="1.5">1.5</option>
                        <option value="2">2</option>
                        <option value="2.5">2.5</option>
                        <option value="3">3</option>
                        <option value="3.5">3.5</option>
                        <option value="4">4</option>
                        <option value="4.5">4.5</option>
                        <option value="5">5</option>
                    </select>
                </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary submit-review" name="submit" onclick="WriteReview(\'' . $obj['title'] . '\')">Submit</button>
                </div>
                <div class="col-md-8" id="review-msg" name="review-msg">
                
                </div>
            </div>
            </form>
      </div>
    </div>
  </div>
</div>';

$html .= '</div>
                <strong>' . $ratingsAvg . '/5 (' . $ratingCount . ')</strong>
            </div>
            <div class="buttons mt-3">
                <button class="btn btn-dark save-later disabs bcss_ecommerce_button" data-toggle="modal" data-target="#reviewModal">Write A Review</button>
            </div>
        </div>
    </div>
</div>
' . $reviewsOut;
if ($ratingCount > 5) {
    $html .= '<div class="col-12 text-center">
            <button id="show_more" class="btn btn-dark show-more disabs bcss_ecommerce_button">Show More</button>
        </div>';
}
$html .= '</div>
                                </section>
                                </div>
                            </div>
                        </div>
                    </div>
                    ' . $modalReview . '';

$js[] = [
    '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js',
    'inc/mods/custom_equipment/custom_functions.js'
];
$css[] = '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css';
$ars = array("css" => $css, "js" => $js);
$arsOut = json_encode($ars);
$content[] = array("page_name" => $page, "page_title" => '', "page_content" => $html, "active" => true, "created" => time(), "last_edit" => '', "last_user" => '', "page_lock" => 'none', "page_type" => '', "page_desc" => '', "check_out" => false, "check_out_date" => '', "page_js" => '', 'dependants' => $arsOut);
