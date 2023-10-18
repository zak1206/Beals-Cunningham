<?php
//USE EXISTING CONNECTION FILE//
include('../../inc/harness.php');

//CHECK FOR CURRENT VERSION//
$a = $data->query("SELECT * FROM beans WHERE bean_name = 'Deere Equipment'");
if($a->num_rows < 1){

//COPY DEPENDANTS//
    function recurse_copy($src,$dst) {
        $dir = opendir($src);
        @mkdir($dst);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    recurse_copy($src . '/' . $file,$dst . '/' . $file);
                }
                else {
                    copy($src . '/' . $file,$dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

    recurse_copy('front/equip_images','../../../img/equip_images/');
    rmdir('front/equip_images');
    recurse_copy('front','../../../inc/mods/');
    recurse_copy('back','../../installed_beans/');


    //RUN INSTALL QUERIES//
    $data->query("INSERT INTO beans SET bean_name = 'Deere Equipment', bean_content = 'John Deere Equipment', bean_description = '', bean_type = 'installed', user_type = 'all', created = '".time()."', bean_folder = 'deere_plugin', bean_id = 'DEERE_PLUGv2.5', active = 'true', category = 'Modules'")or die($data->error);
    $last_id = $data->insert_id;
    $data->query("INSERT INTO beans_dep SET file = 'inc/mods/deere_equipment/deere_functions.js', bean_id = '$last_id', headload = 'true', type = 'js', active = 'true', load_type = 'mod'")or die($data->error);
    $data->query("INSERT INTO beans_dep SET file = 'inc/mods/deere_equipment/deere-output/js/new-output.js', bean_id = '$last_id', headload = 'true', type = 'js', active = 'true', load_type = 'mod'")or die($data->error);
    $data->query("INSERT INTO beans_dep SET file = 'inc/mods/deere_equipment/lightslider.js', bean_id = '$last_id', headload = 'true', type = 'js', active = 'true', load_type = 'mod'")or die($data->error);
    $data->query("INSERT INTO beans_dep SET file = 'inc/mods/deere_equipment/deere-output/js/jquery.paginate.js', bean_id = '$last_id', headload = 'true', type = 'js', active = 'true', load_type = 'mod'")or die($data->error);

    $data->query("INSERT INTO beans_dep SET file = 'inc/mods/deere_equipment/deere-output/css/lightslider.css', bean_id = '$last_id', headload = 'true', type = 'css', active = 'true', load_type = 'mod'")or die($data->error);
    $data->query("INSERT INTO beans_dep SET file = 'inc/mods/deere_equipment/deere-output/css/jquery.paginate.css', bean_id = '$last_id', headload = 'true', type = 'css', active = 'true', load_type = 'mod'")or die($data->error);
    $data->query("INSERT INTO beans_dep SET file = 'inc/mods/deere_equipment/deere-output/css/main.css', bean_id = '$last_id', headload = 'true', type = 'css', active = 'true', load_type = 'mod'")or die($data->error);

    //INSTALL PAGE MOD//
    $data->query("INSERT INTO page_mods SET page_mod_name = 'deere_equipment', active = 'true'")or die($data->error);



//CREATE THE DEERE EQUIPMENT TABLE//

    $sql = "CREATE TABLE deere_equipment (
    id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  title varchar(100) NOT NULL,
  sub_title varchar(200) DEFAULT NULL,
  deere_cats varchar(200) DEFAULT NULL,
  parent_cat varchar(100) DEFAULT NULL,
  cat_one varchar(100) DEFAULT NULL,
  cat_two varchar(100) DEFAULT NULL,
  cat_three varchar(100) DEFAULT NULL,
  cat_four varchar(100) DEFAULT NULL,
  bullet_points text,
  price varchar(45) DEFAULT NULL,
  dealer_price varchar(45) DEFAULT NULL,
  opt_links text,
  eq_image varchar(200) DEFAULT NULL,
  features longtext,
  videos longtext,
  specs longtext,
  offers_link longtext,
  cta_text varchar(45) DEFAULT NULL,
  finance_url text,
  accessories longtext,
  last_updated int(11) DEFAULT NULL,
  active varchar(12) DEFAULT true,
  quick_links_active varchar(45) DEFAULT true,
  offers_active varchar(45) DEFAULT true,
  videos_active varchar(45) DEFAULT true,
  access_active varchar(45) DEFAULT true,
  api_price_active varchar(45) DEFAULT true,
  reviews_active varchar (45),
  extra_content text,
  offers_storage text,
  video_storage text,
  accessories_storage longtext,
  site_link text,
  equip_link text,
  sys_updates int(20) DEFAULT NULL,
  review_rating_data longtext)";


    $data->query($sql)or die($data->error);

    $sql2 = "CREATE TABLE deere_pages (
  id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  page_name varchar(45) NOT NULL,
  page_content text DEFAULT NULL,
  content_edit text DEFAULT NULL,
  page_title varchar(200) DEFAULT NULL,
  page_desc text DEFAULT NULL,
  last_user int(11) DEFAULT NULL,
  iseqcat varchar(12) DEFAULT NULL,
  page_js varchar(200) DEFAULT NULL,
  created varchar(45) DEFAULT NULL,
  last_edit varchar(45) DEFAULT NULL,
  page_lock varchar(45) NOT NULL DEFAULT 'false',
  page_type varchar(45) DEFAULT NULL,
  page_desc_copy1 text DEFAULT NULL,
  check_out varchar(100) DEFAULT NULL,
  check_out_date varchar(45) DEFAULT NULL,
  cat_img text DEFAULT NULL,
  equipment_content text DEFAULT NULL,
  cat_type varchar(100) DEFAULT NULL,
  site_link text DEFAULT NULL,
  parent_page varchar(200) DEFAULT NULL,
  active varchar(12) NOT NULL DEFAULT 'true')";

    $data->query($sql2)or die($data->error);


    $url = 'http://caffeinerde.com/plugins/john_deere_equipment/deere_data.php';
    $key = 'IBN72234957UTYGALAXY!@';
    $password = 'YELLOANDGREENMAKEBLUE434';

    $dataset = array('key' => $key, 'password' => $password);

// use key 'http' even if you send the request to https://...
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($dataset),
        ),
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);



    $theArs = json_decode($result,true);

    if($theArs["status"] == 'Good'){

        //PROCESS DATA TO DATABASE//

        $deereEquip = $theArs["objects"];


        for($i=0; $i < count($deereEquip); $i++){
            $data->query("INSERT INTO deere_equipment SET title = '".$data->real_escape_string(html_entity_decode($deereEquip[$i]["title"]))."', sub_title = '".$data->real_escape_string($deereEquip[$i]["sub_title"])."', deere_cats = '".$data->real_escape_string($deereEquip[$i]["deere_cats"])."', parent_cat = '".$data->real_escape_string($deereEquip[$i]["parent_cat"])."', cat_one = '".$data->real_escape_string($deereEquip[$i]["cat_one"])."', cat_two = '".$data->real_escape_string($deereEquip[$i]["cat_two"])."', cat_three = '".$data->real_escape_string($deereEquip[$i]["cat_three"])."', cat_four = '".$data->real_escape_string($deereEquip[$i]["cat_four"])."', bullet_points = '".$data->real_escape_string(html_entity_decode($deereEquip[$i]["bullet_points"]))."', price = '".$data->real_escape_string($deereEquip[$i]["price"])."', dealer_price = '".$data->real_escape_string($deereEquip[$i]["dealer_price"])."', opt_links = '".$data->real_escape_string(html_entity_decode($deereEquip[$i]["opt_links"]))."', eq_image = '".$data->real_escape_string(html_entity_decode($deereEquip[$i]["eq_image"]))."', features = '".$data->real_escape_string(html_entity_decode($deereEquip[$i]["features"]))."', videos = '".$data->real_escape_string(html_entity_decode($deereEquip[$i]["videos"]))."', specs = '".$data->real_escape_string(html_entity_decode($deereEquip[$i]["specs"]))."', offers_link = '".$data->real_escape_string(html_entity_decode($deereEquip[$i]["offers_link"]))."', cta_text = '".$data->real_escape_string(html_entity_decode($deereEquip[$i]["cta_text"]))."', accessories = '".$data->real_escape_string(html_entity_decode($deereEquip[$i]["accessories"]))."', last_updated = '".$data->real_escape_string($deereEquip[$i]["last_updated"])."', active = '".$data->real_escape_string($deereEquip[$i]["active"])."', quick_links_active = '".$data->real_escape_string(html_entity_decode($deereEquip[$i]["quick_links_active"]))."', offers_active = '".$data->real_escape_string($deereEquip[$i]["offers_active"])."', videos_active = '".$data->real_escape_string($deereEquip[$i]["videos_active"])."', access_active = '".$data->real_escape_string($deereEquip[$i]["access_active"])."', api_price_active = '".$data->real_escape_string($deereEquip[$i]["api_price_active"])."', reviews_active = '".$data->real_escape_string($deereEquip[$i]["reviews_active"])."', extra_content = '".$data->real_escape_string($deereEquip[$i]["extra_content"])."', offers_storage = '".$data->real_escape_string($deereEquip[$i]["offers_storage"])."', video_storage = '".$data->real_escape_string($deereEquip[$i]["video_storage"])."', accessories_storage = '".$data->real_escape_string($deereEquip[$i]["accessories_storage"])."', site_link = '".$data->real_escape_string($deereEquip[$i]["site_link"])."', equip_link = '".$data->real_escape_string($deereEquip[$i]["equip_link"])."', sys_updates = '".$data->real_escape_string($deereEquip[$i]["sys_updates"])."', review_rating_data = '".$data->real_escape_string(html_entity_decode($deereEquip[$i]["review_rating_data"]))."'")or die($data->error);
        }

        echo '<i>Deere Plugin Installed Successfully</i>';

    }else{
        //NOPE//
        echo $theArs["message"];
    }




}else{
    echo "<strong style='\"font-color:red\"'>Cannot install Deere Plugin</strong><br><i>Plugin already installed.. Please use update package.</i>";
}