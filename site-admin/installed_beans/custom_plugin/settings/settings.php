<?php

class EStore_Settings_Two
{

    public function __construct()
    {
    }

    public function GetDefaultShopLocation(): int
    {
        include('config.php');

        $query = "SELECT * FROM custom_equipment_shop_settings WHERE id = 1";
        $a = $data->query($query);
        $b = $a->fetch_array();
        return intval($b['default_shop_location']);
    }

    public function GetDoTaxStuff(): int
    {
        include('config.php');

        $query = "SELECT * FROM custom_equipment_shop_settings WHERE id = 1";
        $a = $data->query($query);
        $b = $a->fetch_array();
        return intval($b['do_tax_stuff']);
    }

    public function GetDoShippingCalculations(): int
    {
        include('config.php');

        $query = "SELECT * FROM custom_equipment_shop_settings WHERE id = 1";
        $a = $data->query($query);
        $b = $a->fetch_array();
        return intval($b['do_shipping_calculations']);
    }

    public function CreateShippingLabels(): int
    {
        include('config.php');

        $query = "SELECT * FROM custom_equipment_shop_settings WHERE id = 1";
        $a = $data->query($query);
        $b = $a->fetch_array();
        return intval($b['create_shipping_labels']);
    }

    public function AutoGenerateLabels(): int
    {
        include('config.php');

        $query = "SELECT * FROM custom_equipment_shop_settings WHERE id = 1";
        $a = $data->query($query);
        $b = $a->fetch_array();
        return intval($b['auto_generate_labels']);
    }

    public function DefaultTaxRate(): float
    {
        include('config.php');

        $query = "SELECT * FROM custom_equipment_shop_settings WHERE id = 1";
        $a = $data->query($query);
        $b = $a->fetch_array();
        return floatval($b['default_tax_rate']);
    }
}
