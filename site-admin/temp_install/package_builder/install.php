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
$a = $data->query("SELECT * FROM beans WHERE bean_name = 'Package_Builder'")or die($data->error);
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

    recurse_copy('front','../../../inc/mods/package_builder/');
    recurse_copy('back','../../installed_beans/package_builder/');


//RUN INSTALL QUERIES//
    $data->query("INSERT INTO beans SET bean_name = 'Package Builder Plugin', bean_content = 'Create Equipment Packages', bean_description = '', bean_type = 'installed', user_type = 'all', created = '".time()."', bean_folder = 'package_builder', bean_id = 'PACKAGE_BUILDERv.2.0', active = 'true', category = 'Modules'");
    $last_id = $data->insert_id;

    $data->query("INSERT INTO beans_dep SET file = 'inc/mods/package_builder/js/pack-config.js', bean_id = '$last_id', headload = 'true', type = 'js', load_type = 'mod', active = 'true'");
    $data->query("INSERT INTO beans_dep SET file = 'inc/mods/package_builder/js/ion.rangeSlider.min.js', bean_id = '$last_id', headload = 'true', type = 'js', load_type = 'mod', active = 'true'");
    $data->query("INSERT INTO beans_dep SET file = 'inc/mods/package_builder/js/bs-stepper.min.js', bean_id = '$last_id', headload = 'true', load_type = 'mod', type = 'js', active = 'true'");
    $data->query("INSERT INTO beans_dep SET file = 'inc/mods/event_plugin/css/pack-config.css', bean_id = '$last_id', headload = 'true', load_type = 'mod', type = 'css', active = 'true'");
    $data->query("INSERT INTO beans_dep SET file = 'inc/mods/event_plugin/css/bs-stepper.min.css', bean_id = '$last_id', headload = 'true', load_type = 'mod', type = 'css', active = 'true'");
    $data->query("INSERT INTO beans_dep SET file = 'inc/mods/event_plugin/css/ionRangeSlider.min.css', bean_id = '$last_id', headload = 'true', load_type = 'mod', type = 'css', active = 'true'");
    $data->query("INSERT INTO page_mods SET page_mod_name = 'package_builder', active = 'true'");





    /// CREATES THE JOB LISTING TABLE ///

    $eventtable = "CREATE TABLE `content_blocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) NOT NULL,
  `content` longtext NOT NULL,
  `className` varchar(45) NOT NULL,
  `start_date` int(11) NOT NULL DEFAULT '0',
  `end_date` int(11) NOT NULL DEFAULT '0',
  `active` varchar(45) NOT NULL DEFAULT 'true',
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
";



    $data->query($eventtable)or die($data->error);


    echo '<i>Package Builder Installed Successfully</i>';


}else{
    echo "<strong style='\"font-color:red\"'>Cannot install Event Plugin</strong><br><i>Plugin already installed.. Please use update package.</i>";
}