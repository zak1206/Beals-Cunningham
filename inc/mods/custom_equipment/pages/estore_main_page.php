<?php

include('inc/config.php');
$catOut .= '<div class="container mt-5">
                
                <div class="row mb-3">
                    <div class="col-md-3">
                        <h2 class="mt-2 pb-2 text-center text-success"><b>Categories</b></h2>
                        <div class="list-group">';

$x = $data->query("SELECT * FROM custom_equipment_pages WHERE active = 'true'") or die($data->error);
while ($z = $x->fetch_array()) {
    $pageName = str_replace("-", " ", $z['page_name']);
    if ($pageName != 'EStore') {
        $catOut .= '<a href="' . $z['page_name'] . '"><button type="button" class="list-group-item list-group-item-action">' . $pageName . '</button></a>';
    }
}
$catOut .= '</div>
                    </div>
                    <div class="col-md-9 mt-2">
                        <div class="row mb-5 justify-content-center estore-banner">
                            <a href="#"><img src="img/BE 05-31-23 4 Series Slider.jpg" class="img-responsive"></a>
                        </div>
                        <div class="row text-center">
                            <h1 class="m-0 bcss_ecommerce text-center" style="font-size: 50px;" itemprop="name"><b>E-Store Home Page</b></h1>
                        </div>
                        <div class="row">
                            <p class="" itemprop="description">
                                Shop custom Deere equipment right from your home!<br>
                                Great prices and great discounts.<br><br>
                                <b>Shop from a list of our categories below!</b>
                            </p>
                        </div>
                        <div class="row">';

$catOut .= '<div class="row bcss_ecommerce_product_list_grid">';

for ($i = 0; $i < count($equip_content); $i++) {
    if ($equip_content[$i]["type"] == 'cat' || $equip_content[$i]["type"] == 'prodcat') {
        include("categories.php");
    } elseif ($equip_content[$i]["type"] == "prod") {
        include("category_products.php");
    }
}
$catOut .= '</div>
        </div>
    </div>
</div>';
