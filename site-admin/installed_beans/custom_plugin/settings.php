<?php

class EStore_Settings_Two
{

    public function __construct()
    {
        //$this->GetDefaultShopLocation();
    }

    public function GetDefaultShopLocation(): int
    {
        include('config.php');

        $query = "SELECT * FROM custom_equipment_shop_settings WHERE id = 1";
        $a = $data->query($query);
        $b = $a->fetch_array();
        return intval($b['default_shop_location']);
    }
}
