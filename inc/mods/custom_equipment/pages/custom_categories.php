<?php

$catOut .= '
                                        <div class="container mt-5">
                                            <div class="row mb-3">
                                                <h1 class="m-0 bcss_ecommerce" itemprop="name">' . $categoryTitle . '</h1>
                                            </div>
                                            <div class="row mb-3">
                                                <p class="bcss_ecommerce_category-short" itemprop="description">
                                                ' . $b["page_desc"] . '
                                                </p>
                                            </div>';
$catOut .= '<div class="row mb-2 align-items-center">
                                                <div class="col-md-6"><strong class="bcss_ecommerce_serch_result"><span itemprop="numberOfItems">' . $prodct . '</span> Results</strong></div>
                                                <div class="col-md-6 d-flex justify-content-end align-items-center">
                                                    <span class="col d-block mr-0 text-right">Sort by: </span>
                                                    <select class="col-8 col-md-6 form-control" id="sort_by">
                                                        <option value="mp">Most Popular</option>
                                                        <option value="nl2h">Name (A-Z)</option>
                                                        <option value="nh2l">Name (Z-A)</option>
                                                        <option value="pl2h">Price (Low to High)</option>
                                                        <option value="ph2l">Price (High to Low)</option>
                                                        <option value="tr">Top Rated</option>
                                                        <option value="mr">Most Reviewed</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3 py-3 bcss_ecommerce_details_background" style="background-color: silver; border-radius: 10px;">
                                                <div class="col-md-6">Products: 1 of ' . $prodct . '</div>
                                                <div class="col-md-6 d-flex justify-content-end">
                                                    <span class="mr-2">Number of Results: </span>
                                                    <div class="d-flex">
                                                        <div class="form-check form-check-inline border-right pr-2 mr-2">
                                                            <input class="form-check-input" type="radio" id="list_product_12" name="list_product" value="3">
                                                            <label class="form-check-label" for="list_product_12">3</label>
                                                        </div>
                                                        <div class="form-check form-check-inline border-right pr-2 mr-2">
                                                            <input class="form-check-input" type="radio" id="list_product_24" name="list_product" value="6">
                                                            <label class="form-check-label" for="list_product_24">6</label>
                                                        </div>
                                                        <div class="form-check form-check-inline border-right pr-2 mr-2">
                                                            <input class="form-check-input" type="radio" id="list_product_48" name="list_product" value="12">
                                                            <label class="form-check-label" for="list_product_48">12</label>
                                                        </div>
                                                        <div class="form-check form-check-inline border-right pr-2 mr-2">
                                                            <input class="form-check-input" type="radio" id="list_product_96" name="list_product" value="24">
                                                            <label class="form-check-label" for="list_product_96">24</label>
                                                        </div>
                                                        <div class="form-check form-check-inline border-right pr-2 mr-2">
                                                            <input class="form-check-input" type="radio" id="list_product_all" name="list_product" value="">
                                                            <label class="form-check-label" for="list_product_all">all</label>
                                                        </div>

                                                        <!--<li class="border-right pr-2 mr-2">12</li>-->
                                                        <!--<li class="border-right pr-2 mr-2 bcss_ecommerce_cpp-active">24</li>-->
                                                        <!--<li class="border-right pr-2 mr-2">36</li>-->
                                                        <!--<li class="border-right pr-2 mr-2">64</li>-->
                                                        <!--<li class="">all</li>-->
                                                    </div>
                                                </div>
                                            </div>';

$catOut .= '<div class="row bcss_ecommerce_product_list_grid">';

for ($i = 0; $i < count($equip_content); $i++) {
    if ($equip_content[$i]["type"] == 'cat' || $equip_content[$i]["type"] == 'prodcat') {
        include("categories.php");
    } elseif ($equip_content[$i]["type"] == "prod") {

        include("category_products.php");
    }
}

$catOut .= '</div>';
