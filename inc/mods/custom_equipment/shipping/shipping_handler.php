<?php

$shipping_handler = new ShippingHandler();

class ShippingHandler
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

    public function base64ToPdf($base64String, $outputFileName)
    {
        $outputFilePath = '../../../../shipping_labels/' . $outputFileName;

        // Decode the base64 string into binary data.
        $pdfData = base64_decode($base64String);

        if ($pdfData === false) {
            return false; // Return false if base64 decoding fails.
        }

        // Save the binary data as a PDF file.
        if (file_put_contents($outputFilePath, $pdfData) !== false) {
            return $outputFilePath; // Return the full path of the saved PDF file.
        } else {
            return false; // Return false if saving the file fails.
        }
    }

    public function CreateShippingLabel($toName, $toAddr, $toAddr2, $toCity, $toState, $toZip, $length, $width, $height, $measure_unit = "in", $weight, $weight_unit = "lb", $phone, $email)
    {
        $links = array();

        //Create label
        if ($this->Get_Shipping_Type() == 'shippo') {
            //Shippo Label Create
            $shippo_handler = new ShippoHandler();
            $labelReturn = $shippo_handler->CreateShippingLabel($toName, $toAddr, $toAddr2, $toCity, $toState, $toZip, $length, $width, $height, "in", $weight, "lb", $phone, $email);

            return $labelReturn;
        } else {
            //Ship-Engine Label Create
            $ship_engine_handler = new ShipEngineHandler();
            if (floatval($weight) > 50) {
                $labelReturn = $ship_engine_handler->RequestDemoModeLTLFreightPickup($toName, $toAddr, $toAddr2, $toCity, $toState, $toZip, $email, $phone, $weight, $length, $width, $height);
                $labelReturn = $this->base64ToPdf($labelReturn, "Shipping_Label_" . str_replace($toName, ' ', '_') . ".pdf");
                $shipData = json_decode($_COOKIE['shippingData'], true);
                if (isset($shipData["label_links"]) && !empty($shipData["label_links"])) {
                    foreach ($shipData["label_links"] as $link) {
                        $url = $link['url'];
                        $existingLink = array("url" => $url);
                        array_push($links, $existingLink);
                    }

                    $newLink = array("url" => $labelReturn);
                    array_push($links, $newLink);
                }

                $newShipData = [
                    "carrier_id" => $shipData["carrier_id"],
                    "service_code" => $shipData["service_code"],
                    "label_links" => $links
                ];

                setcookie('shippingData', json_encode($newShipData), 0, '/');
            } else {
                $labelReturn = $ship_engine_handler->CreateShippingLabel($toName, $toAddr, $toAddr2, $toCity, $toState, $toZip, $phone, $email, $weight, $length, $width, $height);
            }

            return $labelReturn;
        }
    }

    public function CalculateShippingCharges($toName, $toAddr, $toAddr2, $toCity, $toState, $toZip, $phone, $email): float
    {
        include('../shipping/shipping-interface.php');
        include('../shipping/shippo-handler.php');
        include('../shipping/ship-engine-handler.php');
        include('../shipping/shipping_handler.php');

        //Create label
        if ($this->Get_Shipping_Type() == 'shippo') {
            //Shippo Label Create
            $shippo_handler = new ShippoHandler();
            $amount_array = $shippo_handler->CalculateCharges($toName, $toAddr, $toAddr2, $toCity, $toState, $toZip, $phone, $email);

            //Check For Errors Calculating Charges
            if (str_contains(strval($amount_array), 'ERROR')) {
                //Return Error Code If ERROR Exists
                //echo "ERROR: " . $amount_array;
                return 0;
            }
            return doubleval($amount_array['shipping_cost']);
        } else {
            //Ship-Engine Label Create
            $ship_engine_handler = new ShipEngineHandler();
            $amount_array = $ship_engine_handler->CalculateCharges($toName, $toAddr, $toAddr2, $toCity, $toState, $toZip, $phone, $email);
            $carrier_id = $amount_array['rate_id'];

            if ($amount_array['has_error'] == true) {
                return 0;
            }
            return floatval($amount_array['shipping_cost']);
        }
    }

    public function ValidateAddress($toName, $toAddr, $toAddr2, $toCity, $toState, $toZip)
    {
        include('../shipping/shipping-interface.php');
        include('../shipping/shippo-handler.php');
        include('../shipping/ship-engine-handler.php');
        include('../shipping/shipping_handler.php');

        if ($this->Get_Shipping_Type() == 'shippo') {
            //Shippo Validation
            $shippo_handler = new ShippoHandler();
            $valid = $shippo_handler->ValidateAddress($toAddr, $toAddr2, $toCity, $toState, $toZip);
        } else {
            //Ship-Engine Validation
            $ship_engine_handler = new ShipEngineHandler();
            $valid = $ship_engine_handler->ValidateAddress($toAddr, $toAddr2, $toCity, $toState, $toZip);
        }

        return $valid;
    }

    public function GetCarrierID()
    {
        if ($this->Get_Shipping_Type() == 'shippo') {
            $id = '';
        } else {
            //Ship-Engine Validation
            $ship_engine_handler = new ShipEngineHandler();
            $id = $ship_engine_handler->GetCarrierID();
        }

        return $id;
    }
}
