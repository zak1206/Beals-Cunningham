<?php
$a = $data->query("SELECT * FROM custom_equipment_pages WHERE page_name = '$page' AND active = 'true'") or die($data->error);

if ($a->num_rows > 0) {
    $b = $a->fetch_array();
    $pageTemplate = $b["page_content"];
    $matach = 'equipment_get';
    $categoryOut = preg_replace_callback('#{prodcat}data{/prodcat}#', function ($match) use ($page) {
        ////RETURN THE CATEGORIES HERE////

        include('inc/config.php');
        $a = $data->query("SELECT * FROM custom_equipment_pages WHERE page_name = '$page'") or die($data->error);
        $b = $a->fetch_array();

        $equip_content = json_decode($b["equipment_content"], true);
        $cat = $b["cat_type"];
        $view = $b['view_type']; //Grid || List
        $prodct = json_decode($b["equipment_content"], true);
        $prodct = count($prodct);

        // $catOut = '<div class="row justify-content-center my-5">';

        // $catOut .= '<div class="col-md-12 text-center">
        //                 <h1>' . str_replace("-", " ", $page) . '</h1>
        //             </div>';
        $categoryTitle = str_replace("-", " ", $b["page_name"]);



        if ($page == "EStore") {
            //-----    E-Store Home Page - Categories Listing
            include("pages/estore_main_page.php");
        } else {
            if ($cat == 'parent-category') {
                include("pages/parent_categories.php");
            } elseif ($cat == 'child-category') {
                include("pages/child_categories.php");
            } elseif ($cat == 'custom-category') {
                include("pages/custom_categories.php");
            } elseif ($cat == 'product-category') {
                include("pages/product_categories.php");
            }
        }

        $catOut .= '</div></div>'; //End of Row

        return $catOut;
    }, $pageTemplate);

    //$categoryOut = preg_replace_callback('#{prodcat}data{/prodcat}#',"equipment_get", $pageTemplate);

    $js[] = 'inc/mods/custom_equipment/custom_functions.js'; //Javascript To Include In The Page
    $css[] = '';                                             //CSS To Include In The Page

    $ars = array("css" => $css, "js" => $js);
    $arsOut = json_encode($ars);
    $content[] = array("page_name" => $page, "page_title" => 'CATEGORY PAGE', "page_content" => $categoryOut, "active" => true, "created" => time(), "last_edit" => '', "last_user" => '', "page_lock" => 'none', "page_type" => '', "page_desc" => '', "check_out" => false, "check_out_date" => '', "page_js" => '', 'dependants' => $arsOut);
} else {
    ////DO NOTHING TO RETURN 404////
    $html = '<div class="row justify-content-center">
                            <div class="col-md-12 text-center">
                                <h1>ERROR: 404 - Page Not Found!</h1>
                            </div>
                        </div>';
}
