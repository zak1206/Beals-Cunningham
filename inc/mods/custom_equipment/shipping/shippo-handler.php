<?php

class ShippoHandler implements ShippingInterface
{
    public $DEMO_MODE = true;

    public function __construct()
    {
    }

    public function Get_API_Key()
    {
        include('config.php');

        $a = $data->query("SELECT * FROM custom_equipment_shipping WHERE id = 1") or die($data->error);
        $b = $a->fetch_assoc();

        return $b['ship_token'];
    }

    public function Get_Shipping_Type()
    {
        include('config.php');

        $a = $data->query("SELECT * FROM custom_equipment_shipping WHERE id = 1") or die($data->error);
        $b = $a->fetch_assoc();

        return $b['ship_type'];
    }

    public function Get_Shipping_Usage()
    {
        include('config.php');

        $a = $data->query("SELECT * FROM custom_equipment_shipping WHERE id = 1") or die($data->error);
        $b = $a->fetch_assoc();

        return $b['ship_usage'];
    }

    public function CreateShippingLabel($toName, $toAddr, $toAddr2, $toCity, $toState, $toZip, $phone, $email, $weight = 0, $length = 0, $width = 0, $height = 0)
    {
        //Get Shippo Settings
        require_once('lib/Shippo.php');

        $api_key = $this->Get_API_Key();

        $fromAddress = array(
            'name' => 'Stellar BCSS Develop',
            'company' => 'Beals Cunningham',
            'street1' => '3968 Rochelle Ln',
            'city' => 'Heartland',
            'state' => 'TX',
            'zip' => '75126',
            'country' => 'US',
            'phone' => '+1 555 341 9393',
            'email' => 'shippotle@goshippo.com'
        );

        $toAddress = array(
            'name' => $toName,
            'company' => '',
            'street1' => $toAddr,
            'street2' => $toAddr2,
            'city' => $toCity,
            'state' => $toState,
            'zip' => $toZip,
            'country' => 'US',
            'phone' => $phone,
            'email' => $email
        );

        $parcel = array(
            'length' => $length,
            'width' => $width,
            'height' => $height,
            'distance_unit' => 'in',
            'weight' => $weight,
            'mass_unit' => 'lb',
        );

        $shipment = Shippo_Shipment::create(array(
            'address_from' => $fromAddress,
            'address_to' => $toAddress,
            'parcels' => array($parcel),
        ), $api_key);

        $rate = $shipment["rates"][0];

        // Purchase the desired rate.
        $transaction = Shippo_Transaction::create(array(
            'rate' => $rate["object_id"],
            'label_file_type' => "PDF",
            'async' => false
        ), $api_key);

        return $transaction['label_url'];
    }

    public function GetCarrierID()
    {
    }

    public function CalculateCharges($toName, $toAddr, $toAddr2, $toCity, $toState, $toZip, $phone, $email): float
    {
        try {
            //Get Shippo Settings
            include('config.php');
            require_once('lib/Shippo.php');

            $a = $data->query("SELECT * FROM custom_equipment_shipping WHERE id = '1'") or die($data->error);
            $b = $a->fetch_assoc();

            $api_key = $b['ship_token'];

            $fromAddress = array(
                'name' => 'Stellar BCSS Develop',
                'company' => 'Beals Cunningham',
                'street1' => '3968 Rochelle Ln',
                'city' => 'Heartland',
                'state' => 'TX',
                'zip' => '75126',
                'country' => 'US',
                'phone' => '+1 555 341 9393',
                'email' => 'shippotle@goshippo.com'
            );

            $toAddress = array(
                'name' => $toName,
                'company' => '',
                'street1' => $toAddr,
                'street2' => $toAddr2,
                'city' => $toCity,
                'state' => $toState,
                'zip' => $toZip,
                'country' => 'US',
                'phone' => $phone,
                'email' => $email
            );

            $parcel = array(
                'length' => $length,
                'width' => $width,
                'height' => $height,
                'distance_unit' => $measure_unit,
                'weight' => $weight,
                'mass_unit' => $weight_unit,
            );

            $shipment = Shippo_Shipment::create(array(
                'address_from' => $fromAddress,
                'address_to' => $toAddress,
                'parcels' => array($parcel),
            ), $api_key);

            return doubleval($shipment['rates'][0]['amount_local']);
        } catch (Exception $ex) {
            return "ERROR: " . $ex->getMessage();
        }
    }

    public function EstimateCartShippingCharges($toName, $toAddr, $toAddr2, $toCity, $toState, $toZip, $phone, $email): float
    {
        $total = $this->CalculateCharges($toName, $toAddr, $toAddr2, $toCity, $toState, $toZip, $phone, $email);
        return $total;
    }

    public function GetZipcodeFromLatitudeLongitude($lat, $lon){
        
    }

    public function ValidateAddress($street, $street2, $city, $state, $zip)
    {
        return true;
    }
}
