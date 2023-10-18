<?php
require_once('vendor/autoload.php');

class ZipTaxHandler
{

    public function __construct()
    {
    }

    public function GetTaxRateByZipCode($zip)
    {
        $apiKey = 'hvuGeQxLR5Y4ECyt';
        $zipTax = new vutran\ZipTax($apiKey);
        $rate = $zipTax->request($zip);

        //Grab Some Important Properties We May Want To Use
        $county_name = $rate->results[0]->geoCounty;

        $total_sales_tax_rate = $rate->results[0]->taxSales;
        $city_sales_tax_rate = $rate->results[0]->citySalesTax;
        $state_sales_tax_rate = $rate->results[0]->stateSalesTax;
        $county_sales_tax_rate = $rate->results[0]->countySalesTax;

        $city_tax_code = $rate->results[0]->cityTaxCode;


        return floatval($total_sales_tax_rate);
    }
}
