<?php
//USE EXISTING CONNECTION FILE//
$startTime = time();
//your code or
sleep(10);
$endTime = time() - $startTime;
header('Content-Length: '.strlen($endTime));
$response['success'] = true;
echo json_encode($response);

include('../../inc/harness.php');

//CHECK FOR CURRENT VERSION//
$a = $data->query("SELECT * FROM beans WHERE bean_name = 'Career Plugin'")or die($data->error);
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

    recurse_copy('front','../../../inc/mods/career_plugin/');
    recurse_copy('back','../../installed_beans/career_plugin/');


//RUN INSTALL QUERIES//
    $data->query("INSERT INTO beans SET bean_name = 'Career Builder', bean_content = 'Add Job Listings to Your Website', bean_description = '', bean_type = 'installed', user_type = 'all', created = '".time()."', bean_folder = 'career_plugin', bean_id = 'CAREER_PLUGINv.1.0', active = 'true', category = 'Modules'");
    $last_id = $data->insert_id;
    $data->query("INSERT INTO beans_dep SET file = 'inc/mods/career_plugin/js/career_functions.js', bean_id = '$last_id', headload = 'true', load_type = 'mod', active = 'true'");
    $data->query("INSERT INTO beans_dep SET file = 'inc/mods/career_plugin/js/jquery.paginate.js', bean_id = '$last_id', headload = 'true', load_type = 'mod', active = 'true'");
    $data->query("INSERT INTO beans_dep SET file = 'inc/mods/career_plugin/css/jquery.paginate.css', bean_id = '$last_id', headload = 'true', load_type = 'mod', active = 'true'");
    $data->query("INSERT INTO beans_dep SET file = 'inc/mods/career_plugin/css/main.css', bean_id = '$last_id', headload = 'true', load_type = 'mod', active = 'true'");
    $data->query("INSERT INTO page_mods SET page_mod_name = 'career_plugin', active = 'true'");




    
    /// CREATES THE JOB LISTING TABLE ///
    
    $careertable = "CREATE TABLE `career_blocks` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `career_title` varchar(100) NOT NULL,
  `career_level` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `location` text NOT NULL,
  `position_type` varchar(90) NOT NULL,
  `description` text NOT NULL,
  `qualifications` text NOT NULL,
  `active` varchar(30) NOT NULL,
  `date_set` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
";



    $data->query($careertable)or die($data->error);

//    $data->query($slidetable)or die($data->error);



//    $url = 'http://caffeinerde.com/plugins/john_deere_equipment/deere_data.php';
//    $key = 'IBN72234957UTYGALAXY!@';
//    $password = 'YELLOANDGREENMAKEBLUE434';
//
//    $dataset = array('key' => $key, 'password' => $password);
//
//// use key 'http' even if you send the request to https://...
//    $options = array(
//        'http' => array(
//            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
//            'method'  => 'POST',
//            'content' => http_build_query($dataset),
//        ),
//    );
//    $context  = stream_context_create($options);
//    $result = file_get_contents($url, false, $context);
//
//
//    $theArs = json_decode($result,true);
//
//    if($theArs["status"] == 'Good'){
//
//
//        echo '<i>Carousel Plugin Installed Successfully</i>';
//
//    }else{
//        //NOPE//
//        echo $theArs["message"];
//    }

    echo '<i>Career Plugin Installed Successfully</i>';


}else{
    echo "<strong style='\"font-color:red\"'>Cannot install Carousel Plugin</strong><br><i>Plugin already installed.. Please use update package.</i>";
}