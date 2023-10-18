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
$a = $data->query("SELECT * FROM beans WHERE bean_name = 'Event Plugin'")or die($data->error);
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

    recurse_copy('front','../../../inc/mods/event_plugin/');
    recurse_copy('back','../../installed_beans/event_plugin/');


//RUN INSTALL QUERIES//
    $data->query("INSERT INTO beans SET bean_name = 'Event Plugin', bean_content = 'Add Your Events to the Website', bean_description = '', bean_type = 'installed', user_type = 'all', created = '".time()."', bean_folder = 'event_plugin', bean_id = 'EVENT_PLUGINv.1.0', active = 'true', category = 'Modules'");
    $last_id = $data->insert_id;

    $data->query("INSERT INTO beans_dep SET file = 'inc/mods/event_plugin/js/fullcalendar.js', bean_id = '$last_id', headload = 'true', type = 'js', load_type = 'mod', active = 'true'");
    $data->query("INSERT INTO beans_dep SET file = 'inc/mods/event_plugin/js/moment.js', bean_id = '$last_id', headload = 'true', type = 'js', load_type = 'mod', active = 'true'");
    $data->query("INSERT INTO beans_dep SET file = 'inc/mods/event_plugin/css/fullcalendar.css', bean_id = '$last_id', headload = 'true', load_type = 'mod', type = 'css', active = 'true'");
    $data->query("INSERT INTO beans_dep SET file = 'inc/mods/event_plugin/js/events_functions.js', bean_id = '$last_id', headload = 'true', load_type = 'mod', type = 'js', active = 'true'");
    $data->query("INSERT INTO page_mods SET page_mod_name = 'event_plugin', active = 'true'");





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


    echo '<i>Event Plugin Installed Successfully</i>';


}else{
    echo "<strong style='\"font-color:red\"'>Cannot install Event Plugin</strong><br><i>Plugin already installed.. Please use update package.</i>";
}