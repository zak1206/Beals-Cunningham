<?php

interface ShippingInterface
{

    public function Get_API_Key();

    public function Get_Shipping_Type();

    public function Get_Shipping_Usage();

    public function CreateShippingLabel($toName, $toAddr, $toAddr2, $toCity, $toState, $toZip, $phone, $email, $weight, $length, $width, $height);

    public function CalculateCharges($toName, $toAddr, $toAddr2, $toCity, $toState, $toZip, $phone, $email);

    public function ValidateAddress($street, $street2, $city, $state, $zip);

    public function GetCarrierID();

    public function EstimateCartShippingCharges($toName, $toAddr, $toAddr2, $toCity, $toState, $toZip, $phone, $email);
}
