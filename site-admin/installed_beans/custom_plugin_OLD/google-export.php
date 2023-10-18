<?php
//export.php
if(isset($_POST["export"]))
{
    $connect = mysqli_connect("stellar.caffeinerde.com", "stellar_equip", "BCss1957!@", "admin_stellar");
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=data.csv');
    $output = fopen("php://output", "w");
    fputcsv($output, array('ID', 'title', 'item_description', 'link', 'image_link', 'mobile_link', 'additional_image_link', 'availability', 'availability_date','cost_of_goods_sold', 'expiration_date', 'price', 'sale_price', 'sale_price_effective_date', 'unit_pricing_measure', 'unit_pricing_base_measure', 'installment', 'subscription_cost', 'loyalty_points', 'google_product_category', 'product_type', 'brand', 'gtin', 'mpn','identifier_exists', 'item_condition', 'adult', 'multipack', 'is_bundle', 'age_group','color', 'gender', 'material','pattern','google_size','size_type','itemgroup_id','ads_direct','custom_label','promotion_id','excluded_destination','included_destination','shipping','shipping_label','shipping_weight','shipping_length','shipping_width','shipping_height','transmit_time_label','max_handling_time','min_handling_time','tax','tax_category','energy_efficiency_class','min_energy_efficiency_class','max_energy_efficiency_class','max_energy_efficiency_class','active'));
    $query = "SELECT * from google_shop order by id ASC ";
    $result = mysqli_query($connect, $query);
    while($row = mysqli_fetch_assoc($result))
    {
        fputcsv($output, $row);
    }
    fclose($output);
}
?>