<?php
class getMachines
{
    function runMFequips()
    {


//        error_reporting(0);
//        ini_set('error_reporting', E_ALL);

        if (file_exists('../../inc/harness.php')) {
            include('../../inc/harness.php');
        } else {
            include('inc/harness.php');
        }

        $nb = $data->query("SELECT settings FROM beans WHERE bean_id = 'MF-v3'");
        $df = $nb->fetch_array();

//var_dump($df);

        $creddata = json_decode($df["settings"], true);


        $url = $creddata["mf_dealer_link"];
        $key = $creddata["token"];
        $password = $creddata["passcode"];

        $dataset = array('key' => $key, 'password' => $password);

// use key 'http' even if you send the request to https://...
        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($dataset),
            ),
        );


        $context = stream_context_create($options);
        $result = file_get_contents($url.'?'.mt_rand(), false, $context);

        if ($result == false) {
            $data->query("INSERT INTO machine_finder_pulls SET pulldate = '".time()."', status = 'Error'");
            return 'CONNECT ERROR';
            die();
        }
        $result = new SimpleXmlElement($result);



        $xml = json_encode($result);
        $xml = json_decode($xml, true);

        $machines = $xml["machine"];
//echo '<pre>';
//var_dump($machines);
//echo '</pre>';
//
//die();

        $timeNow = time();
        $runnner = $this->dataManagment($machines, $timeNow);
        if ($runnner == 'completed') {
            $this->getTrash($timeNow);
        }


        $image = stripslashes('({"image":[{"@attributes":{"primary":"true"},"filePointer":"http:\/\/www.machinefinder.com\/images\/machines\/28\/3569528\/9783637_large_83705.jpg"},{"filePointer":"http:\/\/www.machinefinder.com\/images\/machines\/28\/3569528\/9783636_large_96742.jpg"},{"filePointer":"http:\/\/www.machinefinder.com\/images\/machines\/28\/3569528\/9783638_large_10456.jpg"},{"filePointer":"http:\/\/www.machinefinder.com\/images\/machines\/28\/3569528\/9783640_large_64417.jpg"},{"filePointer":"http:\/\/www.machinefinder.com\/images\/machines\/28\/3569528\/9783642_large_66845.jpg"},{"filePointer":"http:\/\/www.machinefinder.com\/images\/machines\/28\/3569528\/9783643_large_37033.jpg"},{"filePointer":"http:\/\/www.machinefinder.com\/images\/machines\/28\/3569528\/9783644_large_92186.jpg"},{"filePointer":"http:\/\/www.machinefinder.com\/images\/machines\/28\/3569528\/9783645_large_14766.jpg"},{"filePointer":"http:\/\/www.machinefinder.com\/images\/machines\/28\/3569528\/9783641_large_21414.jpg"}]})');
        $image = str_replace('(', '', $image);
        $image = str_replace(')', '', $image);

//echo $image;
    }

        function dataManagment($machines, $timeNow)
        {
            // echo '<pre>';
            //var_dump($machines);
            // echo '</pre>';
            // include('config.php');

            include('../../inc/harness.php');
            for ($x = 0; $x <= count($machines); $x++) {
                //ID
                $id = $machines[$x]["id"];
                //IMAGES
                $images = $machines[$x]["images"]["image"];
                $imageCount = count($images);
                $jsonImage = array();
                $jsonOption = array();
                $o = 0;
                //IMAGES
                $jsonImage = $machines[$x]["images"];
                $imagesOut = $data->real_escape_string(json_encode($jsonImage));


                //OPTIONS
                $options = $machines[$x]["options"];
                $optionsOut = $data->real_escape_string(json_encode($options));

                //DESCRIPTION
                $description = $data->real_escape_string($machines[$x]["description"]);
                //ADVERTISED PRICE
                $ad_price = $machines[$x]["advertised_price"];
                $single_price = $machines[$x]["advertised_price"]["amount"];


                $jsonAddPrice = $data->real_escape_string(json_encode($ad_price));

                //WHOLESALE PRICE
                $wholesale_price = $machines[$x]["wholesale_price"];
                $jsonWholesalePrice = $data->real_escape_string(json_encode($wholesale_price));
                //DEALER ID
                $dealer_id = $machines[$x]["dealerId"];
                //CITY
                $city = $data->real_escape_string($machines[$x]["city"]);
                //CATEGORY
                $category = $data->real_escape_string($machines[$x]["category"]);
                //MANUFACTURER
                $manufacturer = $data->real_escape_string($machines[$x]["manufacturer"]);
                //MODEL
                $model = $data->real_escape_string($machines[$x]["model"]);
                //SERIAL NUMBER
                $serialNumber = $data->real_escape_string($machines[$x]["serialNumber"]);
                //OPERATION HOURS
                $operationHours = $data->real_escape_string($machines[$x]["operationHours"]);
                if (is_array($operationHours)) {
                    //RUN ARRAY I GUESS!
                } else {
                    $operationHours = $operationHours;
                }
                //SPECIAL METER
                if (isset($machines[$x]["specialMeter"])) {
                    $specialMeterKey = $machines[$x]["specialMeter"]["key"];
                    $specialMeterValue = $machines[$x]["specialMeter"]["value"];
                } else {
                    $specialMeterKey = '';
                    $specialMeterValue = '';
                }
                //MODEL YEAR
                $modelYear = $data->real_escape_string($machines[$x]["modelYear"]);
                //ISNEW
                $isNew = $data->real_escape_string($machines[$x]["isNew"]);
                //HORSEPOWER
                $horsePower = $data->real_escape_string($machines[$x]["horsePower"]);
                if (is_array($horsePower)) {
                    //WHY IS THIS HERE?
                } else {
                    $horsePower = $horsePower;
                }
                //VATPACT - I HAVE NO IDEA WHAT THIS IS BUT IT ALWAYS APPEARS TO BE AN EMPTY ARRAY///
                $vatPct = $data->real_escape_string($machines[$x]["vatPct"]);
                if (is_array($vatPct)) {
                    //DO NOTHING
                } else {
                    $vatPct = $vatPct;
                }
                $listContacts = $data->real_escape_string($machines[$x]["listing_contacts"]);
                if (is_array($listContacts)) {
                    $listContacts = $data->real_escape_string(json_encode($machines[$x]["listing_contacts"]));
                } else {
                    $listContacts = '';
                }
                //separatorHours - ANOTHER EMPTY ARRAY///
                $separatorHours = $data->real_escape_string($machines[$x]["separatorHours"]);
                if (is_array($separatorHours)) {
                    //DO NOTHING
                } else {
                    $separatorHours = $separatorHours;
                }
                //CREATED TIME
                $createdTimestamp = $data->real_escape_string($machines[$x]["createdTimestamp"]);
                //EDITED TIME
                $modifiedTimestamp = $data->real_escape_string($machines[$x]["modifiedTimestamp"]);
                //STOCK NUMBER
                $stockNumber = $data->real_escape_string($machines[$x]["stockNumber"]);
                //locationNotes - EMPTY ARRAY///
                $locationNotes = $data->real_escape_string($machines[$x]["locationNotes"]);
                if (is_array($locationNotes)) {
                    //DO NOTHING
                } else {
                    $locationNotes = $locationNotes;
                }
                //ON LOT
                $onLot = $data->real_escape_string($machines[$x]["onLot"]);
                //FINANACING OPTIONS
                $financingOptions = $data->real_escape_string($machines[$x]["financingOptions"]);
                if (is_array($financingOptions)) {
                    ///WHY WOULD THIS BE AN ARRAY? IT'S ALWAYS BLANK IF IT IS
                } else {
                    $financingOptions = $financingOptions;
                }
                //CERT?
                $cert = $machines[$x]["cert"];
                if (!empty($cert)) {
                    $certInside = $data->real_escape_string($machines[$x]["cert"]["cert"]);
                    $kind = $data->real_escape_string($machines[$x]["cert"]["kind"]);
                    $lastDay = $data->real_escape_string($machines[$x]["cert"]["lastDay"]);
                } else {
                    $certInside = '';
                    $kind = '';
                    $lastDay = '';
                }


                ///LETS PULL SOME ACTIVE REQUEST AND SEE IF THE EQUIPMENT NEEDS TO EXIST AND ALL THAT GOOD STUFF///
                $run = 'true';

                if ($run == 'true') {
                    $check = $data->query("SELECT * FROM used_equipment WHERE equip_id = '$id'");
                    if ($check->num_rows > 0) {
                        $query = "UPDATE used_equipment SET images = '$data->real_escape_string($imagesOut)', options = '$data->real_escape_string($optionsOut)', description = '$description', ad_price = '$jsonAddPrice', wholesale_price = '$jsonWholesalePrice', single_price = '$single_price', dealerId = '$dealer_id', city = '$city', category = '$category', manufacturer = '$manufacturer', model = '$model', serialNumber = '$serialNumber', operationHours = '$operationHours', specialMeterKey = '$specialMeterKey', specialMeterValue = '$specialMeterValue', modelYear = '$modelYear', isNew = '$isNew', horsePower = '$horsePower', vatPct = '$vatPct', separatorHours = '$separatorHours', created = '$createdTimestamp', modified = '$modifiedTimestamp', stockNumber = '$stockNumber', locationNotes = '$locationNotes', onLot = '$onLot', financingOptions = '$financingOptions', certInside = '$certInside', certKind = '$kind', certLastday = '$lastDay', update_date = '$timeNow', active = 'true' WHERE equip_id = '$id'";
                        $data->query($query) or die($data->error);
                    } else {
                        $query = "INSERT INTO used_equipment SET equip_id = '$id', images = '$data->real_escape_string($imagesOut)', options = '$data->real_escape_string($optionsOut)', description = '$description', ad_price = '$jsonAddPrice', wholesale_price = '$jsonWholesalePrice', single_price = '$single_price', dealerId = '$dealer_id', city = '$city', category = '$category', manufacturer = '$manufacturer', model = '$model', serialNumber = '$serialNumber', operationHours = '$operationHours', specialMeterKey = '$specialMeterKey', specialMeterValue = '$specialMeterValue', modelYear = '$modelYear', isNew = '$isNew', horsePower = '$horsePower', vatPct = '$vatPct', separatorHours = '$separatorHours', created = '$createdTimestamp', modified = '$modifiedTimestamp', stockNumber = '$stockNumber', locationNotes = '$locationNotes', onLot = '$onLot', financingOptions = '$financingOptions', certInside = '$certInside', certKind = '$kind', certLastday = '$lastDay', update_date = '$timeNow', contacts = '$listContacts'";
                        $data->query($query) or die($data->error);
                    }
                }

            }

            $data->query("INSERT INTO machine_finder_pulls SET pulldate = '".time()."', status = 'Good'")or die($data->error);
            return 'completed';
        }


    function getTrash($timeNow)
    {
        if (file_exists('../../inc/harness.php')) {
            include('../../inc/harness.php');
        } else {
            include('inc/harness.php');
        }
        $data->query("UPDATE used_equipment SET active = 'false' WHERE update_date != '$timeNow'");
    }

}
