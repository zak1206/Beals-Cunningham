<?php
$view = $b['view_type'];
$type = $equip_content[$i]["type"];
$id = $equip_content[$i]["id"];

if ($view == "grid") {
    //Grid View
    $catOut .= '<div class="col-lg-4 col-md-6 col-sm-12 bcss_ecommerce_product_list">';
} else {
    //List View
    $catOut .= '<div class="col-lg-4 col-md-12 col-sm-12 bcss_ecommerce_product_list">';
}

$c = $data->query("SELECT * FROM custom_equipment_pages WHERE id = " . $id . "") or die($data->error);
while ($d = $c->fetch_array()) {
    $prodct = json_decode($d["equipment_content"], true);
    $prodct = count($prodct);

    $catOut .= '
            <div class="card text-center" style="margin-bottom: 20px; border-radius: 0px; border: transparent;" >
                
                <div class="product-image6">
                    <a href="' . $d["page_name"] . '">
                        <img class="pic-1 img-responsive fadeIn" src="' . $d["cat_img"] . '" itemprop="image">
                    </a>
                </div>

                <div class="product-content" style="border: transparent;">

                    <h3 class="text-center">
                        <a class="m-0 small" href="' . $d["page_name"] . '" style="font-family:Bebas Neue" itemprop="name"><b>' . str_replace("-", " ", $d['page_name']) . '</b></a>
                    </h3>
                    
                    <meta itemprop="description" value="">
                    <meta itemprop="sku" value="">

                </div>
            </div>
        </div>';
}
