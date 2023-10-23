<?php

class ShipEngineHandler implements ShippingInterface
{
    public function __construct()
    {
    }

    /**
     * 
     * Grabs The Carrier ID - Using The LTL Freight Shipping API Call
     * 
     * 
     * @return returns String Value Containing Carrier ID Code
     */
    public function GetLTLCarrierCodes(): string
    {
        $api_key = $this->Get_API_Key();

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.shipengine.com/v-beta/ltl/connections',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
          "credentials": {}
        }',
            CURLOPT_HTTPHEADER => array(
                'Host: api.shipengine.com',
                'API-Key: ' . $api_key,
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        echo var_dump(($response));
        $response = json_decode($response, true);

        curl_close($curl);
        return strval($response['carrier_id']);
    }

    /**
     * 
     * Grabs The Carrier ID - Using The Sanbox Testing LTL Freight Shipping Test API Call
     * 
     * [FOR DEMO PURPOSES]
     * 
     * @return returns String Value Containing Carrier ID Code
     */
    private function GetSandBoxLTLCarrierCode(): string
    {
        $api_key = $this->Get_API_Key();

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.shipengine.com/v-beta/ltl/connections/test',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
          "credentials": {}
        }',
            CURLOPT_HTTPHEADER => array(
                'Host: api.shipengine.com',
                'API-Key: ' . $api_key,
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        $response = json_decode($response, true);

        curl_close($curl);
        return strval($response['carrier_id']);
    }

    private function CreateSandBoxShipment()
    {
        $api_key = $this->Get_API_Key();

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.shipengine.com/v1/shipments',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
            "shipments": [
                {
                "validate_address": "no_validation",
                "service_code": "usps_priority_mail",
                "external_shipment_id": "1daa0c22-0519-46d0-8653-9f3dc62e7d2c",
                "ship_to": {
                    "name": "Amanda Miller",
                    "phone": "555-555-5555",
                    "address_line1": "525 S Winchester Blvd",
                    "city_locality": "San Jose",
                    "state_province": "CA",
                    "postal_code": "95128",
                    "country_code": "US",
                    "address_residential_indicator": "yes"
                },
                "ship_from": {
                    "company_name": "Example Corp.",
                    "name": "John Doe",
                    "phone": "111-111-1111",
                    "address_line1": "4009 Marathon Blvd",
                    "address_line2": "Suite 300",
                    "city_locality": "Austin",
                    "state_province": "TX",
                    "postal_code": "78756",
                    "country_code": "US",
                    "address_residential_indicator": "no"
                },
                "confirmation": "none",
                "advanced_options": {},
                "insurance_provider": "none",
                "tags": [],
                "packages": [
                    {
                    "weight": {
                        "value": 1.0,
                        "unit": "ounce"
                    }
                    }
                ]
                }
            ]
            }',
            CURLOPT_HTTPHEADER => array(
                'Host: api.shipengine.com',
                'API-Key: ' . $api_key,
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        $response = json_decode($response, true);

        curl_close($curl);
        return $response['carrier_id'];
    }

    /**
     * 
     * [Live Mode] Gets a Quote For Shipping LTL Freight - Shipments Over 50-70 Lbs.
     * Returns - [Double] total estimated shipping cost
     * 
     * @return returns (float)
     */
    private function RequestLiveLTLQuote($shipments_array, $service_code): float
    {
        $api_key = $this->Get_API_Key();
        $carrier_id = $this->GetSandBoxLTLCarrierCode();
        $total = 0;
        $currentDate = new DateTime();
        $ship_date = $currentDate->modify('+1 day');
        $ship_date = $currentDate->format("Y-m-d");
        $shipmentData = [
            "shipment" => [
                "service_code" => $service_code,
                "pickup_date" => $ship_date,
                "packages" => [
                    [
                        "code" => "PKG",
                        "freight_class" => 60,
                        "nmfc_code" => "161630",
                        "description" => "Paperback books",
                        "dimensions" => [
                            "width" => 45,
                            "height" => 45,
                            "length" => 45,
                            "unit" => "inches"
                        ],
                        "weight" => [
                            "value" => 150,
                            "unit" => "pounds"
                        ],
                        "quantity" => 3,
                        "stackable" => false,
                        "hazardous_materials" => false
                    ]
                ],
                "options" => [
                    ["code" => "LFTP"],
                    [
                        "code" => "HAZ",
                        "attributes" => [
                            "name" => "Contact Person",
                            "phone" => "7704865900"
                        ]
                    ]
                ],
                "ship_from" => [
                    "account" => "123456",
                    "contact" => [
                        "name" => "John Doe",
                        "phone_number" => "1111111111",
                        "email" => "johndoe@test.com"
                    ],
                    "address" => [
                        "company_name" => "Example Corp.",
                        "address_line1" => "4009 Marathon Blvd",
                        "city_locality" => "Austin",
                        "state_province" => "TX",
                        "postal_code" => "78756",
                        "country_code" => "US"
                    ]
                ],
                "ship_to" => [
                    "account" => "123456",
                    "contact" => [
                        "name" => "John Doe",
                        "phone_number" => "1111111111",
                        "email" => "johndoe@test.com"
                    ],
                    "address" => [
                        "company_name" => "Widget Company",
                        "address_line1" => "525 S Winchester Blvd",
                        "city_locality" => "San Jose",
                        "state_province" => "CA",
                        "postal_code" => "95128",
                        "country_code" => "US"
                    ]
                ],
                "bill_to" => [
                    "type" => "third_party",
                    "payment_terms" => "prepaid",
                    "account" => "123456",
                    "address" => [
                        "company_name" => "Example Corp.",
                        "address_line1" => "4009 Marathon Blvd",
                        "city_locality" => "Austin",
                        "state_province" => "TX",
                        "postal_code" => "78756",
                        "country_code" => "US"
                    ],
                    "contact" => [
                        "name" => "John Doe",
                        "phone_number" => "1111111111",
                        "email" => "johndoe@test.com"
                    ]
                ],
                "requested_by" => [
                    "company_name" => "Example Corp.",
                    "contact" => [
                        "name" => "John Doe",
                        "phone_number" => "1111111111",
                        "email" => "johndoe@test.com"
                    ]
                ]
            ],
            "shipment_measurements" => [
                "total_linear_length" => [
                    "value" => 45,
                    "unit" => "inches"
                ],
                "total_width" => [
                    "value" => 45,
                    "unit" => "inches"
                ],
                "total_height" => [
                    "value" => 45,
                    "unit" => "inches"
                ],
                "total_weight" => [
                    "value" => 45,
                    "unit" => "pounds"
                ]
            ]
        ];

        $jsonData = json_encode($shipmentData);


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.shipengine.com/v-beta/ltl/quotes/' . $carrier_id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'Host: api.shipengine.com',
                'API-Key: ' . $api_key,
                'Content-Type: application/json'
            ),
        ));
        curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);

        $response = curl_exec($curl);
        $quote_data = json_decode($response, true);

        //Add Charge Amount To Shipping Cost Total
        foreach ($quote_data['charges'] as $charge) {
            //Make Sure We Don't Add Discounts - We Subtract Them
            if ($charge['type'] === 'total') {
                $total = floatval($total) + floatval($charge['amount']['value']);
                break; // We found the total charge, so break out of the loop
            }
        }

        //Remove After Testing

        curl_close($curl);

        return floatval($total);
    }

    public function ListLiveLTLCarriers(): string
    {
        $api_key = $this->Get_API_Key();
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.shipengine.com/v-beta/ltl/carriers',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Host: api.shipengine.com',
                'API-Key: ' . $api_key
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    public function RequestDemoLTLQuote($shipments): string
    {
        $api_key = $this->Get_API_Key();
        $carrier_id = $this->GetSandBoxLTLCarrierCode();
        $total = 0;
        $currentDate = new DateTime();
        $currentDate->modify('+1 day');
        $ship_date = $currentDate->format("Y-m-d");
        $response_array = array('total' => 0, 'shipments' => array());

        foreach ($shipments as $shipment) {
            $curl = curl_init();

            $data = '{
                "shipment": {
                    "service_code": "stnd",
                    "pickup_date": "' . $ship_date . '",
                    "packages": [
                        {
                            "code": "PKG",
                            "freight_class": 60,
                            "nmfc_code": "161630",
                            "description": "Tractor Parts",
                            "dimensions": {
                                "width": ' . intval($shipment['width']) . ',
                                "height": ' . intval($shipment['height']) . ',
                                "length": ' . intval($shipment['length']) . ',
                                "unit": "inches"
                            },
                            "weight": {
                                "value": ' . intval($shipment['weight']) . ',
                                "unit": "pounds"
                            },
                            "quantity": ' . intval($shipment['qty']) . ',
                            "stackable": false,
                            "hazardous_materials": false
                        }
                    ],
                    "options": [
                        {"code": "LFTP"},
                        {
                            "code": "HAZ",
                            "attributes": {
                                "name": "Zak Rowton",
                                "phone": "8178998723"
                            }
                        }
                    ],
                    "ship_from": {
                        "account": "123456",
                        "contact": {
                            "name": "John Doe",
                            "phone_number": "1111111111",
                            "email": "johndoe@test.com"
                        },
                        "address": {
                            "company_name": "Example Corp.",
                            "address_line1": "4009 Marathon Blvd",
                            "city_locality": "Austin",
                            "state_province": "TX",
                            "postal_code": "78756",
                            "country_code": "US"
                        }
                    },
                    "ship_to": {
                        "account": "123456",
                        "contact": {
                            "name": "John Doe",
                            "phone_number": "1111111111",
                            "email": "johndoe@test.com"
                        },
                        "address": {
                            "company_name": "Widget Company",
                            "address_line1": "525 S Winchester Blvd",
                            "city_locality": "San Jose",
                            "state_province": "CA",
                            "postal_code": "95128",
                            "country_code": "US"
                        }
                    },
                    "bill_to": {
                        "type": "third_party",
                        "payment_terms": "prepaid",
                        "account": "123456",
                        "address": {
                            "company_name": "Example Corp.",
                            "address_line1": "4009 Marathon Blvd",
                            "city_locality": "Austin",
                            "state_province": "TX",
                            "postal_code": "78756",
                            "country_code": "US"
                        },
                        "contact": {
                            "name": "John Doe",
                            "phone_number": "1111111111",
                            "email": "johndoe@test.com"
                        }
                    },
                    "requested_by": {
                        "company_name": "Example Corp.",
                        "contact": {
                            "name": "John Doe",
                            "phone_number": "1111111111",
                            "email": "johndoe@test.com"
                        }
                    }
                },
                "shipment_measurements": {
                    "total_linear_length": {
                        "value": ' . intval($shipment['total_length']) . ',
                        "unit": "inches"
                    },
                    "total_width": {
                        "value": ' . intval($shipment['total_width']) . ',
                        "unit": "inches"
                    },
                    "total_height": {
                        "value": ' . intval($shipment['total_height']) . ',
                        "unit": "inches"
                    },
                    "total_weight": {
                        "value": ' . intval($shipment['weight_total']) . ',
                        "unit": "pounds"
                    }
                }
            }';

            $headers = array(
                'Host: api.shipengine.com',
                'API-Key: ' . $api_key,
                'Content-Type: application/json'
            );

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.shipengine.com/v-beta/ltl/quotes/' . $carrier_id,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_HTTPHEADER => $headers,
            ));

            $response = curl_exec($curl);
            $quote_data = json_decode($response, true);

            // Add Charge Amount To Shipping Cost Total
            foreach ($quote_data['charges'] as $charge) {
                // Make Sure We Don't Add Discounts - We Subtract Them
                if ($charge['type'] === 'total') {
                    $total = floatval($total) + floatval($charge['amount']['value']);
                    $shipment_array = array(
                        "carrier_quote_id" => $quote_data['carrier_quote_id'],
                        "cost" => $charge['amount']['value'],
                        'quote_json' => $quote_data
                    );
                    array_push($response_array['shipments'], $shipment_array);
                    break; // We found the total charge, so break out of the loop
                }
            }

            // Remove After Testing
            curl_close($curl);
        }

        $response_array['total'] = doubleval($total);
        $response_json = json_encode($response_array, true);

        return $response_json;
    }

    public function convertBase64ToPDF($base64String, $outputPdfPath)
    {
        $decodedData = base64_decode($base64String);

        if ($decodedData !== false) {
            // Save the decoded data to the specified output path as a PDF file
            file_put_contents($outputPdfPath, $decodedData);

            return true;
        }

        return false;
    }

    public function RequestDemoModeLTLFreightPickup($toName, $toAddr, $toAddr2, $toCity, $toState, $toZip, $phone, $email, $shipments): array
    {
        $api_key = $this->Get_API_Key();
        $carrier_id = $this->GetSandBoxLTLCarrierCode();
        $labels = array();
        $shippingData = json_decode($_COOKIE['shippingData'], true);
        $carrier_quote_id = $shippingData['quote_id']['carrier_quote_id'];
        $path = '';

        //Schedule Pickup
        foreach ($shipments as $shipment) {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.shipengine.com/v-beta/ltl/pickups/' . $carrier_id,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
            "carrier": {
                "test": true,
                "instructions": "deliver to submarine hatch"
                },
            "options": [
              {
                "code": "HAZ",
                "attributes": {
                  "name": "Hazardous Contact Name",
                  "phone": "7704865900"
                }
              }
            ],
            "shipment": {
                "pickup_date": "2023-10-23",
                "pickup_window": {
                "start_at": "08:00:00-06:00",
                "end_at": "17:00:00-06:00",
                "closing_at": "17:00:00-06:00"
              },
              "delivery_date": "2023-10-24",
              "service_code": "stnd",
              "bill_to": {
                "account": "123456",
                "address": {
                  "address_line1": "4009 Marathon Blvd",
                  "city_locality": "Austin",
                  "company_name": "Example Corp.",
                  "country_code": "US",
                  "postal_code": "78756",
                  "state_province": "TX"
                },
                "contact": {
                  "email": "johndoe@test.com",
                  "name": "John Doe",
                  "phone_number": "111-111-1111"
                },
                "payment_terms": "prepaid",
                "type": "third_party"
              },
              "packages": [
                {
                  "code": "PKG",
                  "description": "Paperback books",
                  "dimensions": {
                    "height": ' . intval($shipment['height']) . ',
                    "length": ' . intval($shipment['length']) . ',
                    "unit": "inches",
                    "width": ' . intval($shipment['width']) . '
                  },
                  "freight_class": 60,
                  "hazardous_materials": false,
                  "nmfc_code": "161630",
                  "quantity": ' . intval($shipment['qty']) . ',
                  "stackable": false,
                  "weight": {"unit": "pounds", "value": ' . intval($shipment['weight']) . '}
                }
              ],
              "requested_by": {
                "company_name": "Example Corp.",
                "contact": {
                  "email": "johndoe@test.com",
                  "name": "John Doe",
                  "phone_number": "111-111-1111"
                }
              },
              "ship_from": {
                "account": "123456",
                "address": {
                  "address_line1": "4009 Marathon Blvd",
                  "city_locality": "Austin",
                  "company_name": "Example Corp.",
                  "country_code": "US",
                  "postal_code": "78756",
                  "state_province": "TX"
                },
                "contact": {
                  "email": "johndoe@test.com",
                  "name": "John Doe",
                  "phone_number": "111-111-1111"
                }
              },
              "ship_to": {
                "account": "123456",
                "address": {
                  "address_line1": "525 S Winchester Blvd",
                  "city_locality": "San Jose",
                  "company_name": "Widget Company",
                  "country_code": "US",
                  "postal_code": "95128",
                  "state_province": "CA"
                },
                "contact": {
                  "email": "johndoe@test.com",
                  "name": "John Doe",
                  "phone_number": "111-111-1111"
                }
              }
            }
          }',
                CURLOPT_HTTPHEADER => array(
                    'Host: api.shipengine.com',
                    'API-Key: ' . $api_key,
                    'Content-Type: application/json'
                ),
            ));

            $response = curl_exec($curl);
            $response = json_decode($response, true);
            foreach ($response['documents'] as $doc) {
                $img = $doc['image'];
                $path = '../../../../shipping_labels/' . $response['shipment_id'] . '.pdf';
                $this->convertBase64ToPDF($img, $path);
            }

            curl_close($curl);
        }

        $output = array('label_url' => str_replace('../../../../', '', $path));

        return $output;
    }

    public function CreateDemoShippingLabel($toName, $toAddr, $toAddr2, $toCity, $toState, $toZip, $phone, $email, $shipments): string
    {
        $api_key = $this->Get_API_Key();

        // Endpoint for creating a shipping label
        $endpoint = 'https://api.shipengine.com/v1/labels';
        $shipData = json_decode($_COOKIE['shippingData'], true);
        $code = $shipData['service_code'];
        $links = array();
        $packages = array();

        for ($i = 0; $i < count($shipments); $i++) {
            $package = [
                'weight' => [
                    'value' => floatval($shipments[$i]['weight_total']) * 16,
                    'unit' => 'ounce',
                ],
                "dimensions" => [
                    "height" => doubleval($shipments[$i]['total_height']),
                    "width" => doubleval($shipments[$i]['total_width']),
                    "length" => doubleval($shipments[$i]['total_length']),
                    "unit" => "inch"
                ]
            ];
        }

        // Data to send to the API
        $data = [
            'shipment' => [
                'service_code' => $code,

                'ship_to' => [
                    'name' => $toName,
                    'phone' => $phone,
                    'address_line1' => $toAddr,
                    'address_line2' => $toAddr2,
                    'city_locality' => $toCity,
                    'state_province' => $toState,
                    'postal_code' => $toZip,
                    'country_code' => 'US',
                ],

                'ship_from' => [
                    'name' => 'Zak Rowton',
                    'company_name' => 'Beals Cunningham',
                    'phone' => '817-899-8723',
                    'address_line1' => '2333 East Britton Road',
                    'city_locality' => 'Oklahoma City',
                    'state_province' => 'OK',
                    'postal_code' => '73131',
                    'country_code' => 'US',
                ],
                'packages' => [
                    $package
                ],
            ],
        ];

        $data_json = json_encode($data);

        // Initialize cURL session
        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'API-Key: ' . $api_key,
        ]);

        // Execute the cURL session
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            return strval(curl_error($ch));
        } else {
            // Close the cURL session
            curl_close($ch);

            // Handle the response from ShipEngine
            $label_data = json_decode($response, true);

            if (isset($label_data['errors'])) {
                // Handle errors
                return strval($label_data['errors']);
            } else {
                // Print the label URL
                $links = array();

                if (isset($shipData["label_links"]) && !empty($shipData["label_links"])) {
                    foreach ($shipData["label_links"] as $link) {
                        $url = $link['url'];
                        $existingLink = array("url" => $url);
                        array_push($links, $existingLink);
                    }
                }

                //Grab Any Previous Links
                array_push($links, array("url" => $label_data['label_download']['pdf']));

                $newShipData = [
                    "carrier_id" => $shipData["carrier_id"],
                    "service_code" => $shipData["service_code"],
                    "label_links" => $links
                ];

                setcookie('shippingData', json_encode($newShipData), 0, '/');

                //echo strval($label_data['label_download']['pdf']);
                return strval($label_data['label_download']['pdf']);
            }
        }
    }
    public function RequestDemoCarrierShipmentQuote(): float
    {
        $api_key = $this->Get_API_Key();
        $quote = $this->CalculateChargesOG('Zak Rowton', '3968 Rochelle Lane', '', 'Heartland', 'TX', '75126', '8178998723', 'zak.rowton@gmail.com');

        return floatval($quote);
    }

    public function RequestLiveCarrierShipmentQuote(): float
    {
        $api_key = $this->Get_API_Key();
        $quote = 0.0;

        return floatval($quote);
    }

    private function CreateLiveShippingLabel($toName, $toAddr, $toAddr2, $toCity, $toState, $toZip, $phone, $email): string
    {
        return '';
    }

    private function CalculateChargesOG($toName, $toAddr, $toAddr2, $toCity, $toState, $toZip, $phone, $email)
    {
        $json = json_decode($_COOKIE['shippingData'], true);
        $carrier_id = $json[0]['carrier_id'];
        $service_code = $json[0]['service_code'];
        $api_key = $this->Get_API_Key();

        // Endpoint for calculating shipping rates
        $endpoint = 'https://api.shipengine.com/v1/rates';

        // Data to send to the API
        $data = [
            'shipment' => [
                'carrier_id' => $carrier_id, // Replace with the actual carrier ID
                'service_code' => $service_code, // Replace with the desired service code

                //TODO - Replace w/ Shop-Settings Default Address
                'ship_from' => [
                    'name' => 'Zak Rowton',
                    'company_name' => 'Beals Cunningham',
                    'phone' => '817-899-8723',
                    'address_line1' => '2333 East Britton Road',
                    'city_locality' => 'Oklahoma City',
                    'state_province' => 'OK',
                    'postal_code' => '73131',
                    'country_code' => 'US',
                ],

                'ship_to' => [
                    'name' => $toName,
                    'phone' => $phone,
                    'address_line1' => $toAddr,
                    'address_line2' => $toAddr2,
                    'city_locality' => $toCity,
                    'state_province' => ucwords($toState),
                    'postal_code' => $toZip,
                    'country_code' => 'US',
                ],

                'packages' => [
                    [
                        'weight' => [
                            'value' => doubleval(40),
                            'unit' => 'pound',
                        ],
                    ],
                ],
            ],
        ];

        // Convert the data to JSON
        $data_json = json_encode($data);

        // Initialize cURL session
        $ch = curl_init($endpoint);

        // Set cURL options
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'API-Key: ' . $api_key,
        ]);

        // Execute the cURL session
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            return 'Error: ' . curl_error($ch);
        } else {
            // Close the cURL session
            curl_close($ch);

            // Handle the response from ShipEngine
            $rates_data = json_decode($response, true);

            $return_data = array(
                'carrier_id' => $rates_data['rate_response']['rates'][0]['carrier_id'],
                'rate_id' => $rates_data['rates_response']['rates'][0]['rate_id'],
                'shipping_cost' => $rates_data['rate_response']['rates'][0]['shipping_amount']['amount'],
                'package_type' => $rates_data['rate_response']['rates'][0]['package_type'],
                'delivery_days' => $rates_data['rate_response']['rates'][0]['delivery_days'],
                'estimated_arrival_date' => $rates_data['rate_response']['rates'][0]['estimated_delivery_date'],
                'estimated_ship_date' => $rates_data['rate_response']['rates'][0]['ship_date'],
                'service_type' => $rates_data['rate_response']['rates'][0]['service_type'],
                'carrier_nickname' => $rates_data['rate_response']['rates'][0]['carrier_nickname'],
                'valid' => $rates_data['rate_response']['rates'][0]['validation_status'],
                'warning_messages' => $rates_data['rate_response']['rates'][0]['warning_messages'],
                'error_messages' => $rates_data['rate_response']['rates'][0]['error_messages']
            );

            return $return_data;
        }
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

    public function EstimateCartShippingCharges($toName, $toAddr, $toAddr2, $toCity, $toState, $toZip, $phone, $email, $service_code = "stdn", $demo = true): float
    {
        include('config.php');
        $shipment_weight_limit = 50;
        $settings = array(); //$this->GetShopSettings();
        $shipping_total = 0;
        $error = false;
        $critical_error = false;
        $error_msg = 'no errors';
        $is_LTL_Freight = false;
        $max_crate_weight = 50;
        $crate_restriction = 'crate_weight_restriction';
        $current_shipment_weight = 0;
        $current_shipment_length = 0;
        $current_shipment_width = 0;
        $current_shipment_height = 0;
        $current_shipment_items = array();

        //Get CartData COOKIE
        $cartDataJSON = json_decode($_COOKIE['cartData'], true);
        $cartItems = $cartDataJSON[0]['cartItems'];

        //Return Cart Data
        //This is so we can auto remove any items that we had an error with during calculations
        $newCartData = array();
        $newCartItems = array();
        $newCartDataJSON = json_encode($newCartData, true);

        $shipments_array = array();
        $totalWeight = 0;
        //Loop through items To Create Shipment/s ^
        foreach ($cartItems as $item) {
            try {
                //Search each item in DataBase custom_equipment
                $a = $data->query("SELECT * FROM custom_equipment WHERE id = " . $item['id'] . "") or die($data->error);
                $equipment_row = $a->fetch_array();

                //Get dimensions/weight
                $dimensions = $equipment_row['dimentions'];
                $dimensions_splitted = explode('X', $dimensions);
                $length = floatval($dimensions_splitted[0]);
                $width = floatval($dimensions_splitted[1]);
                $height = floatval($dimensions_splitted[2]);
                $height_with_qty = floatval($height);
                $length_with_qty = floatval($length) * intval($item['qty']);
                $width_with_qty = floatval($width) * intval($item['qty']);
                $weight = floatval($equipment_row['weight']);
                $weight_with_qty = floatval($weight) * intval($item['qty']);
                $totalWeight = floatval($totalWeight) + floatval($weight_with_qty);

                //Add Dimension Totals
                $current_shipment_length = floatval($current_shipment_length) + floatval($length_with_qty);
                $current_shipment_width = floatval($current_shipment_width) + floatval($width_with_qty);
                $current_shipment_height = floatval($current_shipment_width) + floatval($height_with_qty);

                //Add each items weight to $current_shipment_weight
                $current_shipment_weight = floatval($current_shipment_weight) + floatval($weight_with_qty);


                //Check Individual Items - If Under Weight Limit, 
                if (doubleval($weight) < doubleval($shipment_weight_limit)) {
                    //Check If Total Weight Exceeds Limit
                    if (doubleval($totalWeight) > doubleval($shipment_weight_limit)) {
                        //If So -> Push To Shipment Array
                        //Add Item To New Cart tems
                        $weightTotal = 0;
                        $count = 1;
                        //Loop Through Multiplying weight X qty numbers to see how many can fit in a package
                        for ($i = 1; $i < intval($item['qty']); $i++) {
                            if (doubleval($weight) * intval($i) < doubleval($shipment_weight_limit)) {
                                $count = intval($i);
                                $weightTotal = doubleval($weight) * intval($i);
                            }
                        }

                        $new_cart_item = array(
                            'uniqId' => $item['uniqId'],
                            'id' => $item['id'],
                            'name' => $item['name'],
                            'length' => $length,
                            'width' => $width,
                            'height' => $height,
                            'weight' => $weight,
                            'weight_total' => $weightTotal,
                            'ship_type' => $item['ship_type'],
                            'price' => $item['price'],
                            'qty' => $count
                        );
                        array_push($newCartItems, $new_cart_item);
                        array_push($current_shipment_items, $new_cart_item);
                        array_push($shipments_array, $current_shipment_items);
                        //Reset Current Shipment Items
                        $current_shipment_items = array();
                        //Add New Cart ITem
                    } else {
                        //Add Item To New Cart tems
                        $new_cart_item = array(
                            'uniqId' => $item['uniqId'],
                            'id' => $item['id'],
                            'name' => $item['name'],
                            'length' => $length,
                            'width' => $width,
                            'height' => $height,
                            'weight' => $weight,
                            'total_length' => $length_with_qty,
                            'total_width' => $width_with_qty,
                            'total_height' => $height_with_qty,
                            'weight_total' => $weight_with_qty,
                            'ship_type' => $item['ship_type'],
                            'price' => $item['price'],
                            'qty' => $item['qty']
                        );
                        array_push($newCartItems, $new_cart_item);
                        //If Not -> 
                        array_push($current_shipment_items, $new_cart_item);
                    }
                } else {
                    $new_cart_item = array(
                        'uniqId' => $item['uniqId'],
                        'id' => $item['id'],
                        'name' => $item['name'],
                        'length' => $length,
                        'width' => $width,
                        'height' => $height,
                        'weight' => $weight,
                        'total_length' => $length_with_qty,
                        'total_width' => $width_with_qty,
                        'total_height' => $height_with_qty,
                        'weight_total' => $weight_with_qty,
                        'ship_type' => $item['ship_type'],
                        'price' => $item['price'],
                        'qty' => $item['qty']
                    );
                    array_push($newCartItems, $new_cart_item);
                    //Add Shipment To Generate Label For
                    array_push($shipments_array, $new_cart_item);
                    $current_shipment_items = array();
                }

                //Check If Over Weight Limit
            } catch (Exception $ex) {
                $error = true;
                $critical_error = false; //Not a Critical Error We Can Still Calculate and Proceed By Removing Item From Cart
                $error_msg = "Estimate Exception While Looping Through Cart Items - Exception: " . $ex->getMessage();
                //break;
            }
        }

        //Set CartData COOKIE w/ New CartData In-Case Items Had Failure
        array_push($newCartData, $newCartItems);
        $newCartDataJSON = json_encode($newCartData, true);
        //setcookie('cartData', $newCartDataJSON, 0, '/');
        //echo var_dump($shipments_array);

        //Calculate Total Shipping From Total Weight
        if (floatval($totalWeight) > floatval($shipment_weight_limit)) {
            //LTL Quote
            if ($demo) {
                $quote_amount = $this->RequestDemoLTLQuote($shipments_array);
                $quote_amount = json_decode($quote_amount, true);
                $quote_id = '';
                foreach ($quote_amount['shipments'] as $quote) {
                    $shippingDataJSON = json_decode($_COOKIE['shippingData'], true);
                    $newShippingData = array(
                        'service_code' => $shippingDataJSON[0]['service_code'],
                        'carrier_id' => $shippingDataJSON[0]['carrier_id'],
                        'quote_id' => array(
                            'carrier_quote_id' => $quote['carrier_quote_id']
                        )
                    );
                    setcookie('shippingData', json_encode($newShippingData, true), 0, '/');
                }
                $shipping_total = floatval($shipping_total) + floatval($quote_amount['total']);
            } else {
                $quote_amount = $this->RequestLiveLTLQuote($shipments_array, $service_code);
                $shipping_total = floatval($shipping_total) + floatval($quote_amount['total']);
            }
        } else {
            //Regular Carrier Quote
            if ($demo) {
                $quote_amount = $this->RequestDemoCarrierShipmentQuote($shipments_array);
                $shipping_total = floatval($shipping_total) + floatval($quote_amount);
                echo "Demo LTL Quote: " . $quote_amount;
            } else {
                $quote_amount = $this->RequestLiveCarrierShipmentQuote();
                $shipping_total = floatval($shipping_total) + floatval($quote_amount);
                echo "Live LTL Quote: " . $quote_amount;
            }
        }

        return number_format(floatval($shipping_total), 2, '.', ',');
    }

    public function CreateCartShippingLabels($toName, $toAddr, $toAddr2, $toCity, $toState, $toZip, $phone, $email, $service_code = "stdn", $demo = true): array
    {
        include('config.php');
        $shipment_weight_limit = 50;
        $settings = array(); //$this->GetShopSettings();
        $shipping_total = 0;
        $error = false;
        $critical_error = false;
        $error_msg = 'no errors';
        $is_LTL_Freight = false;
        $max_crate_weight = 50;
        $crate_restriction = 'crate_weight_restriction';
        $current_shipment_weight = 0;
        $current_shipment_length = 0;
        $current_shipment_width = 0;
        $current_shipment_height = 0;
        $current_shipment_items = array();
        $labels_output = array('labels' => array());

        //Get CartData COOKIE
        $cartDataJSON = json_decode($_COOKIE['cartData'], true);
        $cartItems = $cartDataJSON[0]['cartItems'];

        //Return Cart Data
        //This is so we can auto remove any items that we had an error with during calculations
        $newCartData = array();
        $newCartItems = array();
        $newCartDataJSON = json_encode($newCartData, true);

        $shipments_array = array();
        $totalWeight = 0;
        //Loop through items To Create Shipment/s ^
        foreach ($cartItems as $item) {
            try {
                //Search each item in DataBase custom_equipment
                $a = $data->query("SELECT * FROM custom_equipment WHERE id = " . $item['id'] . "") or die($data->error);
                $equipment_row = $a->fetch_array();

                //Get dimensions/weight
                $dimensions = $equipment_row['dimentions'];
                $dimensions_splitted = explode('X', $dimensions);
                $length = floatval($dimensions_splitted[0]);
                $width = floatval($dimensions_splitted[1]);
                $height = floatval($dimensions_splitted[2]);
                $height_with_qty = floatval($height);
                $length_with_qty = floatval($length) * intval($item['qty']);
                $width_with_qty = floatval($width) * intval($item['qty']);
                $weight = floatval($equipment_row['weight']);
                $weight_with_qty = floatval($weight) * intval($item['qty']);
                $totalWeight = floatval($totalWeight) + floatval($weight_with_qty);

                //Add Dimension Totals
                $current_shipment_length = floatval($current_shipment_length) + floatval($length_with_qty);
                $current_shipment_width = floatval($current_shipment_width) + floatval($width_with_qty);
                $current_shipment_height = floatval($current_shipment_width) + floatval($height_with_qty);

                //Add each items weight to $current_shipment_weight
                $current_shipment_weight = floatval($current_shipment_weight) + floatval($weight_with_qty);

                //Add Item To New Cart tems
                $new_cart_item = array(
                    'uniqId' => $item['uniqId'],
                    'id' => $item['id'],
                    'name' => $item['name'],
                    'length' => $length,
                    'width' => $width,
                    'height' => $height,
                    'weight' => $weight,
                    'total_length' => $length_with_qty,
                    'total_width' => $width_with_qty,
                    'total_height' => $height_with_qty,
                    'weight_total' => $weight_with_qty,
                    'ship_type' => $item['ship_type'],
                    'price' => $item['price'],
                    'qty' => $item['qty']
                );

                array_push($newCartItems, $new_cart_item);
                array_push($shipments_array, $new_cart_item);
                //Check If Over Weight Limit
            } catch (Exception $ex) {
                $error = true;
                $critical_error = false; //Not a Critical Error We Can Still Calculate and Proceed By Removing Item From Cart
                $error_msg = "Estimate Exception While Looping Through Cart Items - Exception: " . $ex->getMessage();
                //break;.
            }
        }

        //Set CartData COOKIE w/ New CartData In-Case Items Had Failure
        array_push($newCartData, $newCartItems);
        $newCartDataJSON = json_encode($newCartData, true);
        //setcookie('cartData', $newCartDataJSON, 0, '/');

        //Calculate Total Shipping From Total Weight
        if (floatval($totalWeight) > floatval($shipment_weight_limit)) {
            //LTL Quote
            if ($demo) {
                $bol_path = $this->RequestDemoModeLTLFreightPickup($toName, $toAddr, $toAddr2, $toCity, $toState, $toZip, $phone, $email, $shipments_array);

                array_push($labels_output['labels'], $bol_path);
            } else {
                //Live LTL Pickup
            }
        } else {
            //Regular Carrier Quote
            if ($demo) {
            } else {
                //Demo Carrier Quote
            }
        }

        return $labels_output;
    }

    public function CreateShippingLabel($toName, $toAddr, $toAddr2, $toCity, $toState, $toZip, $phone, $email, $weight, $length, $width, $height, $demo = true): string
    {
        if ($demo) {
            return $this->CreateDemoShippingLabel($toName, $toAddr, $toAddr2, $toCity, $toState, $toZip, $phone, $email, $weight, $length, $width, $height);
        } else {
            return $this->CreateLiveShippingLabel($toName, $toAddr, $toAddr2, $toCity, $toState, $toZip, $phone, $email, $weight, $length, $width, $height);
        }
    }

    public function GetCarrierID()
    {
        $primary = '';
        $api_key = $this->Get_API_Key();

        // Initialize cURL session
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.shipengine.com/v1/carriers',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Host: api.shipengine.com',
                'API-Key: ' . $api_key
            ),
        ));

        // Execute the cURL session
        $response = curl_exec($curl);

        // Check for cURL errors
        curl_close($curl);

        // Handle the response from ShipEngine
        $label_data = json_decode($response, true);
        $carriers = $label_data['carriers'];
        $primaryCarrier = '';
        $services = array([]);

        foreach ($carriers as $carrier) {
            foreach ($carrier['services'] as $service) {
                array_push($services, array('carrier_id' => $service['carrier_id'], 'service_code' => $service['service_code']));
            }
        }

        return $services;
    }

    public function CalculateCharges($toName, $toAddr, $toAddr2, $toCity, $toState, $toZip, $phone, $email)
    {
        if (isset($_COOKIE['shippingData'])) {
            $service_code = $_COOKIE['shippingData']['service_code'];
        }
        return $this->EstimateCartShippingCharges($toName, $toAddr, $toAddr2, $toCity, $toState, $toZip, $phone, $email, $service_code);
    }

    public function ValidateAddress($street, $street2, $city, $state, $zip): bool
    {
        $api_key = $this->Get_API_Key();

        // Endpoint for address validation
        $endpoint = 'https://api.shipengine.com/v1/addresses/validate';

        // Initialize cURL session
        $ch = curl_init($endpoint);

        // Set cURL options
        curl_setopt_array($ch, array(
            CURLOPT_URL => 'https://api.shipengine.com/v1/addresses/validate',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '[
                {
                    "address_line1": "' . $street . '",
                    "city_locality": "' . $city . '",
                    "state_province": "' . $state . '",
                    "postal_code": "' . $zip . '",
                    "country_code": "US"
                }
            ]',
            CURLOPT_HTTPHEADER => array(
                'Host: api.shipengine.com',
                'API-Key: ' . $api_key,
                'Content-Type: application/json'
            ),
        ));

        // Execute the cURL session
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            return false;
        }

        // Handle the response from ShipEngine
        $validation_data = json_decode($response, true);

        // Close the cURL session
        curl_close($ch);

        // Check if the address is valid
        if ($validation_data[0]['status'] === 'verified') {
            return true;
        } else {
            return false;
        }
    }
}
