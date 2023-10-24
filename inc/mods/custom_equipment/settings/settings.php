<?php

$settings = new EStore_Settings();

class EStore_Settings
{
    public $DEFAULT_SHOP_LOCATION = 0;                 //DEFAULT SHIP-FROM STORE [ADDRESS TO SHIP-FROM]
    public $DO_TAX_CALCULATIONS = true;                //INCLUDE CALCULATIONG TAX RATE BASED ON PURCHASE LOCATION
    public $DO_SHIPPING_CALCULATIONS = true;           //INCLUDE CALCULATING COST OF SHIPPING AND ADDRESS VALIDATION
    public $CREATE_SHIPPING_LABELS = true;             //INCLUDE CREATING SHIPPING LABELS
    public $AUTO_GENERATE_LABELS = true;               //GENERATE SHIPPING LABELS AUTOMATICALLY AFTER SUCCESSFUL PAYMENT
    public $DEFAULT_TAX_RATE = 0.090;                  //DEFAULT TAX RATE TO USE IF TAX API FAILS
    public $CONTINUE_IF_TAX_API_FAILS = false;         //USE DEFAULT TAX RATE IF TAX API FAILS CALCULATION
    public $DEFAULT_SHIPPING_RATE = 5.00;              //DEFAULT SHIPPING RATE IF API FAILS  |  PRICE PER POUND
    public $CONTINUE_IF_SHIPPING_API_FAILS = false;    //USE DEFAULT SHIPPING RATE IF SHIPPING API FAILS CALCULATION
    public $SHOW_ESTORE_HOMEPAGE = true;               //SHOW E-STORE HOME PAGE WHEN CLICKING ESTORE  |  OTHERWISE GOES TO MAIN PARENT CATEGORY
    public $DEMO_MODE = true;                          //USE SANDBOX APIS DURING CHECKOUT

    public function __construct()
    {
        //$this->RefreshSettings();
    }

    public function RefreshSettings(): bool
    {
        try {
            $this->DEFAULT_SHOP_LOCATION = $this->GetDefaultShopLocation();
            $this->DO_TAX_CALCULATIONS = $this->DoTaxCalculations();
            $this->DO_SHIPPING_CALCULATIONS = $this->DoShippingCalculations();
            $this->CREATE_SHIPPING_LABELS = $this->CreateShippingLabels();
            $this->AUTO_GENERATE_LABELS = $this->AutoGenerateShippingLabels();
            $this->DEFAULT_TAX_RATE = $this->DefaultTaxRate();
            $this->CONTINUE_IF_TAX_API_FAILS = $this->ContinueIfTaxApiFails();
            $this->DEFAULT_SHIPPING_RATE = $this->DefaultShippingRatePerOunce();
            $this->CONTINUE_IF_SHIPPING_API_FAILS = $this->ContinueIfShippingApiFails();
            $this->SHOW_ESTORE_HOMEPAGE = $this->ShowEStoreHomePage();
            $this->DEMO_MODE = $this->DemoModeActive();

            return true;
        } catch (Exception $ex) {
            echo "Exception! Error: " . $ex->getMessage();
            return false;
        }
    }

    /**
     * Gets the ID of the location to use as the default store location for anything involving the E-Store
     * Ex.) default shipping location
     * 
     * If ID == -1  ->  No Default Location
     */
    public function GetDefaultShopLocation(): int
    {
        include('config.php');

        $query = "SELECT * FROM custom_equipment_shop_settings WHERE id = 1";
        $a = $data->query($query);
        $b = $a->fetch_array();
        return intval($b['default_shop_location']);
    }

    public function DoTaxCalculations(): bool
    {
        include('config.php');

        $query = "SELECT * FROM custom_equipment_shop_settings WHERE id = 1";
        $a = $data->query($query);
        $b = $a->fetch_array();
        return boolval($b['do_tax_calculations']);
    }

    public function DoShippingCalculations(): bool
    {
        include('config.php');

        $query = "SELECT * FROM custom_equipment_shop_settings WHERE id = 1";
        $a = $data->query($query);
        $b = $a->fetch_array();
        return boolval($b['do_shipping_calculations']);
    }

    public function CreateShippingLabels(): bool
    {
        include('config.php');

        $query = "SELECT * FROM custom_equipment_shop_settings WHERE id = 1";
        $a = $data->query($query);
        $b = $a->fetch_array();
        return boolval($b['create_shipping_labels']);
    }

    public function AutoGenerateShippingLabels(): bool
    {
        include('config.php');

        $query = "SELECT * FROM custom_equipment_shop_settings WHERE id = 1";
        $a = $data->query($query);
        $b = $a->fetch_array();
        return boolval($b['auto_generate_labels']);
    }

    public function DefaultTaxRate(): float
    {
        include('config.php');

        $query = "SELECT * FROM custom_equipment_shop_settings WHERE id = 1";
        $a = $data->query($query);
        $b = $a->fetch_array();
        return floatval($b['default_tax_rate']);
    }

    public function ContinueIfTaxApiFails(): bool
    {
        include('config.php');

        $query = "SELECT * FROM custom_equipment_shop_settings WHERE id = 1";
        $a = $data->query($query);
        $b = $a->fetch_array();
        return boolval($b['continue_if_tax_api_fails']);
    }

    public function DefaultShippingRatePerOunce(): float
    {
        include('config.php');

        $query = "SELECT * FROM custom_equipment_shop_settings WHERE id = 1";
        $a = $data->query($query);
        $b = $a->fetch_array();
        return floatval($b['default_shipping_rate']);
    }

    public function ContinueIfShippingApiFails(): bool
    {
        include('config.php');

        $query = "SELECT * FROM custom_equipment_shop_settings WHERE id = 1";
        $a = $data->query($query);
        $b = $a->fetch_array();
        return boolval($b['continue_if_shipping_api_fails']);
    }

    public function ShowEStoreHomePage(): bool
    {
        include('config.php');

        $query = "SELECT * FROM custom_equipment_shop_settings WHERE id = 1";
        $a = $data->query($query);
        $b = $a->fetch_array();
        return boolval($b['show_estore_homepage']);
    }

    public function DemoModeActive(): bool
    {
        include('config.php');

        $query = "SELECT * FROM custom_equipment_shop_settings WHERE id = 1";
        $a = $data->query($query);
        $b = $a->fetch_array();
        return boolval($b['demo_mode']);
    }
}
