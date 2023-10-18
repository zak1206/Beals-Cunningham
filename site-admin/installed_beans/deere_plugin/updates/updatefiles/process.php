<?php
//process new files//

if (!file_exists('backups')) {
    mkdir("backups", 0777);
}

//DO BACKUP WE ALWAYS BACKUP FILES... ALWAYS!!!!!!!!//
copy('functions.php', 'backups/functions'.time().'.php');
copy('ui.php', 'backups/ui'.time().'.php');

//REMOVE THE OLD FILES - HOPE YOU BACKED UP THE FILES ABOVE//
unlink('functions.php');
unlink('ui.php');

//ADD UPDATED OR NEW FILE BELOW//
copy('updates/updatefiles/functions.php', 'functions.php');
copy('updates/updatefiles/ui.php', 'ui.php');

//HERE YOU CAN RUN SQL FOR UPDATE INFORMATION//
include('../../inc/harness.php');
$systemtime = $_REQUEST["systemtime"];
$data->query("UPDATE beans SET last_updated = '".$systemtime."' WHERE bean_folder = 'deere_plugin'");

echo 'UPDATE APPLIED';