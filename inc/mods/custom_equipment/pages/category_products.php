<?php

$e = $data->query("SELECT * FROM custom_equipment WHERE id = '" . $equip_content[$i]["id"] . "'") or die($data->error);
while ($f = $e->fetch_array()) {

    if ($f["price"] != null) {
        $priceOuts = '<span class="product-new-label" style="color: #333; font-weight:bold; font-size: 14px">Only $' . $f["sales_price"] . '</span>';
    }

    $imageMain = json_decode($f["eq_image"], true);
    $mainImage = $imageMain[0];

    //Setup Page View [Grid or List]
    // if ($view == "grid") {
    //     //Grid View
    //     $catOut .= '<div class="col-lg-4 col-md-6 col-sm-12 text-center" data-boxval="' . $f["id"] . '">';
    // } else {
    //     //List View
    //     $catOut .= '<div class="col-lg-12 col-md-12 col-sm-12 text-center" data-boxval="' . $f["id"] . '">';
    // }
    $theprice = $f["sales_price"];
    $shipType = ucwords(str_replace("_", " ", $f["ship_type"]));
    $title = $f['title'];

    if ($shipType == 'Api System') {
        $shipType = 'Shipping Available';
    }

    $ratingAvg = 0;
    $ratingCt = 0;

    $g = $data->query("SELECT * FROM custom_equipment_reviews WHERE product_name = '" . $title . "'") or die($data->error);
    while ($h = $g->fetch_array()) {
        $ratingCt++;
        $ratingAvg += doubleval($h['rating']);
    }

    $ratingAvg = $ratingAvg / $ratingCt;
    $hasReviews = $ratingCt > 0;

    $catOut .= '
                                                    <div class="card mx-2 text-center" style="margin-bottom: 20px; border-radius: 0px; border: transparent;" >
                                                        <div class="product-image6">
                                                            <a href="' . $b["page_name"] . '/' . $f["title"] . '">
                                                                <img class="pic-1 img-responsive fadeIn bcss_ecommerce_product_list_img" style="max-height: 245px; min-height: 245px; object-fit: cover;" src="' . $mainImage . '" itemprop="image">
                                                            </a>
                                                        </div>
                                                        <div class="product-content" style="border: transparent;">
                                                            <h3 class="title text-center bcss_ecommerce">
                                                                <a class="m-0 bcss_ecommerce small" href="' . $b["page_name"] . '/' . $f['title'] . '" itemprop="name">' . str_replace("-", " ", $f['title']) . '</a>
                                                            </h3>
                                                            <div class="d-flex flex-row justify-content-center align-items-center mt-2">';
    $catOut .= '<div class="ratings bcss_ecommerce d-flex flex-row mx-1" itemprop="aggregateRating" itemscope itemtype="https://schema.org/AggregateRating">';
    // ------- Star Ratings
    if (doubleval($ratingAvg) >= 1) {
        $html .= '<i class="bi bi-star-fill"></i>';
    } else {
        $html .= '<i class="bi bi-star"></i>';
    }
    if (doubleval($ratingAvg) >= 2) {
        $html .= '<i class="bi bi-star-fill"></i>';
    } else {
        $html .= '<i class="bi bi-star"></i>';
    }
    if (doubleval($ratingAvg) >= 3) {
        $html .= '<i class="bi bi-star-fill"></i>';
    } else {
        $html .= '<i class="bi bi-star"></i>';
    }
    if (doubleval($ratingAvg) >= 4) {
        $html .= '<i class="bi bi-star-fill"></i>';
    } else {
        $html .= '<i class="bi bi-star"></i>';
    }
    if (doubleval($ratingAvg) == 5) {
        $html .= '<i class="bi bi-star-fill"></i>';
    } else {
        $html .= '<i class="bi bi-star"></i>';
    }
    $catOut .= '</div>
                <strong class="font-weight-normal"><i class="bi bi-star-fill"></i>   <span itemprop="ratingValue">' . ($hasReviews ? $ratingAvg : 5) . '</span>/5 (<span itemprop="reviewCount">' . $ratingCt . '</span>)</strong>
            </div>
            <meta itemprop="description" value="">
            <!--discounted prize-->
            <div class="mt-3" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                <meta itemprop="url" href="https://www.example.com/trinket_offer" />
                <meta itemprop="priceCurrency" content="USD" />
                <h4 class="my-0">$<span itemprop="price">' . number_format($theprice, 2) . '</span></h4>
                <!--additional option-->
                <p class="mt-3 bcss_ecommerce_primary-color">
                    <i class="fa fa-map-marker" aria-hidden="true"></i> <span itemprop="itemCondition" content="https://schema.org/InStoreOnly">' . $shipType . '</span>
                </p>
                <!--end additional option-->
            </div>
            <!--end discounted prize-->
                <meta itemprop="sku" value="">
        </div>
    </div>';
}
