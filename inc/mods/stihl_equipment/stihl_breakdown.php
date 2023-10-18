<?php
//error_reporting(E_ERROR | E_PARSE);

function getAccess()
{
    $curl = curl_init();
    curl_setopt_array(
        $curl,
        array(
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_URL            => "https://api-q.stihlusa.com/token",
            CURLOPT_POST           => TRUE,
            CURLOPT_POSTFIELDS     => http_build_query(
                array(
                    'grant_type'    => "client_credentials",
                    'client_id'     => "g9js0ko0jfwZRxmhs_9wbNOPnfUa",
                    'client_secret' => "M1hOvdDV4Jn4p_wwywEk8agxCGIa"
                )
            )
        )
    );

    $response = json_decode(curl_exec($curl));
    curl_close($curl);

    $access_token = (isset($response->access_token) && $response->access_token != "") ? $response->access_token : die("Error - access token missing from response!");
    /// $instance_url = (isset($response->instance_url) && $response->instance_url != "") ? $response->instance_url : die("Error - instance URL missing from response!");

    return array(
        "accessToken" => $access_token
    );
}

$token = getAccess();
$tokenSet = $token["accessToken"];


$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api-q.stihlusa.com/API_Products/1.0/Products/Search?salesOrganizationId=A43601AC-1A68-4534-AE87-663E8DADF0B7",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
        "Authorization: Bearer ".$tokenSet."",
        "Cookie: TS01d53875=0128bb5afb8137fbffc503e5d0ed8c54cbdc5b3c0653ccae2a156fe55922a84037891ffdcb6ff3b2297ba796aa77d30fc53736e31e"
    ),
));

$stihlArs = curl_exec($curl);

curl_close($curl);




$convert = json_decode($stihlArs,true);
echo '<pre>';
var_dump($convert);
echo '</pre>';
//
//die();
$html = '';
for($i=0; $i<count($convert); $i++){

    $materialShortDescription = $convert[$i]["materialShortDescription"];
    $commonName = $convert[$i]["materialShortDescription"];
    $price = $convert[$i]["priceLevelPricing"][0]["listPrice"];
    $sku = $convert[$i]["retailProductDetail"]["sku"];
    $category = $convert[$i]["retailProductDetail"]["categoryName"];
    $description = $convert[$i]["retailProductDetail"]["cmsContent"]["corporate"]["longDescription"];
    $specs = $convert[$i]["retailProductDetail"]["specifications"];
    $images = $convert[$i]["retailProductDetail"]["imageURLs"];
    $features = $convert[$i]["retailProductDetail"]["modelFeatures"];

    //LOOP THE SPECS//
    $specOut = array();
    for($j=0; $j<count($specs); $j++){

        $specOut[] = array("name"=>$specs[$j]["name"], "description"=>$specs[$j]["description"]);
    }

    $specOutz = json_encode($specOut);

    //LOOP THE IMAGES//
    $imags = array();
    for($k=0; $k<count($images); $k++){
        $correctImg = explode('?',$images[$k]);
        $imags[] = $correctImg[0];
    }

    $jsonImgs = json_encode($imags);

    //LOOP THE FEATURES//
    $theFeaturs = array();
    for($l=0; $l<count($features); $l++){
        $theFeaturs[] = array('imageurl'=>$features[$l]["imageURL"],"description"=>$features[$l]["descriptionHTML"],"extra"=>$features[$l]["name"]);
    }

    $theFeaturss = json_encode($theFeaturs);
//    $materialShortDescription = explode('-',$materialShortDescription);
//    $materialShortDescription = $materialShortDescription[1];
    $materialShortDescription = preg_replace('/[^ \w-]/', '', $materialShortDescription);
    $materialShortDescription = str_replace('-','_',$materialShortDescription);
    $materialShortDescription = str_replace(' ','',$materialShortDescription);



    $html .= '<div style="padding: 20px; border-bottom: solid thin #333">';
    $html .= '<b>Short Description</b> - '.$materialShortDescription.'<br>';
    $html .= '<b>Images</b> - '.$jsonImgs.'<br>';
    $html .= '<b>Price</b> - '.$price.'<br>';
    $html .= '<b>SKU</b> - '.$sku.'<br>';
    $html .= '<b>Category</b> - '.$category.'<br>';
    $html .= '<b>Description</b> - '.$description.'<br>';
    $html .= '<b>Specs</b> - '.$specrow.'<br>';
    $html .= '</div>';

    include('../../config.php');

//    $a = $data->query("SELECT title FROM stihl_equipment WHERE title = '".$data->real_escape_string($materialShortDescription)."'")or die($data->error);
//    if($a->num_rows > 0){
//        $data->query("UPDATE stihl_equipment SET common_name = '".$data->real_escape_string($commonName)."', parent_cat = '".$data->real_escape_string($category)."', price = '".$data->real_escape_string($price)."', eq_image = '".$data->real_escape_string($jsonImgs)."', features = '".$data->real_escape_string($theFeaturss)."', specs = '".$data->real_escape_string($specOutz)."', sku = '".$data->real_escape_string($sku)."', last_updated = '".time()."' WHERE title = '$materialShortDescription'")or die($data->error);
//        $message .= 'update '.$materialShortDescription.'<br>';
//    }else{
//        $data->query("INSERT INTO stihl_equipment SET title = '".$data->real_escape_string($materialShortDescription)."', common_name = '".$data->real_escape_string($commonName)."', parent_cat = '".$data->real_escape_string($category)."', price = '".$data->real_escape_string($price)."', eq_image = '".$data->real_escape_string($jsonImgs)."', features = '".$data->real_escape_string($theFeaturss)."', specs = '".$data->real_escape_string($specOutz)."', sku = '".$data->real_escape_string($sku)."'")or die($data->error);
//        $message .= 'insert<br>';
//    }


}


echo 'DONE PROCESSING';

