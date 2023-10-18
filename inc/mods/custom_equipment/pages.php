<?php
class custom_equipment
{
    function page($page)
    {
        $html = '';
        include('inc/config.php');
        $a = $data->query("SELECT * FROM custom_equipment WHERE title = '$page'") or die($data->error);

        if ($a->num_rows > 0) {
            // PRODUCT OUTPUT //
            include("pages_products.php");
            return $content;
        } else {
            // OUTPUT CATEGORY //
            include("pages_categories.php");
            return $content;
        }
    }
}
