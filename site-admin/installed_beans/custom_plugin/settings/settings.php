<?php

class EStore_Settings_Two
{

    public function __construct()
    {
    }

    /**
     *
     * Gets the default shipping/pickup location ID.
     *
     * @return   int     $default_shipping_location -> The Location ID of the default shipping location
     * to use for shipping calculations and shipping labels.
     * 
     * [Only used if the user did not select a pickup location, or if a product does not have a pickup location set.]
     *
     */
    public function GetDefaultShopLocation(): int
    {
        include('config.php');

        $query = "SELECT * FROM custom_equipment_shop_settings WHERE id = 1";
        $a = $data->query($query);
        $b = $a->fetch_array();
        return intval($b['default_shop_location']);
    }

    /**
     *
     * Gets the int value 0/1 for whether or not to do tax calculations and include taxes during checkout.
     *
     * @return   int     $do_tax_stuff -> [0 = No Taxes] [1 = Include Taxes]
     * 
     *
     */
    public function GetDoTaxStuff(): int
    {
        include('config.php');

        $query = "SELECT * FROM custom_equipment_shop_settings WHERE id = 1";
        $a = $data->query($query);
        $b = $a->fetch_array();
        return intval($b['do_tax_stuff']);
    }

    /**
     *
     * Gets the int value 0/1 for whether or not to do shipping calculations and include shipping charges during checkout.
     *
     * @return   int     $do_shipping_calculations -> [0 = No Shipping Calculations] [1 = Calculate Shipping]
     * 
     *
     */
    public function GetDoShippingCalculations(): int
    {
        include('config.php');

        $query = "SELECT * FROM custom_equipment_shop_settings WHERE id = 1";
        $a = $data->query($query);
        $b = $a->fetch_array();
        return intval($b['do_shipping_calculations']);
    }

    /**
     *
     * Gets the int value 0/1 for whether or not to create shipping labels.
     * 
     * If true, then shipping labels will be created for each order.
     * 
     * [If Auto-Generate-Labels = 0] -> The user will have to manually create the shipping labels from the order invoice page.
     * 
     * [If Auto-Generate-Labels = 1] -> 
     * The shipping labels will be automatically created after successful payment, and the shipping/ltl pickup dates will be set for 2 days following when the order was placed.
     *
     * @return   int     $do_shipping_calculations -> [0 = Shipping Labels Not Allowed] [1 = Shipping Labels Allowed]
     * 
     *
     */
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

    public function DefaultShippingRate(): float
    {
        include('config.php');

        $query = "SELECT * FROM custom_equipment_shop_settings WHERE id = 1";
        $a = $data->query($query);
        $b = $a->fetch_array();
        return floatval($b['default_shipping_rate']);
    }

    public function DEMO_MODE(): int
    {
        include('config.php');

        $query = "SELECT * FROM custom_equipment_shop_settings WHERE id = 1";
        $a = $data->query($query);
        $b = $a->fetch_array();
        return intval($b['demo_mode']);
    }

    public function UseDefaultTaxRateIfTaxAPIFails(): int
    {
        include('config.php');

        $query = "SELECT * FROM custom_equipment_shop_settings WHERE id = 1";
        $a = $data->query($query);
        $b = $a->fetch_array();
        return intval($b['continue_if_tax_api_fails']);
    }

    public function UseDefaultShippingRateIfTaxAPIFails(): int
    {
        include('config.php');

        $query = "SELECT * FROM custom_equipment_shop_settings WHERE id = 1";
        $a = $data->query($query);
        $b = $a->fetch_array();
        return intval($b['continue_if_shipping_api_fails']);
    }

    public function ShowEStoreHomePage(): int
    {
        include('config.php');

        $query = "SELECT * FROM custom_equipment_shop_settings WHERE id = 1";
        $a = $data->query($query);
        $b = $a->fetch_array();
        return intval($b['show_estore_homepage']);
    }
}
