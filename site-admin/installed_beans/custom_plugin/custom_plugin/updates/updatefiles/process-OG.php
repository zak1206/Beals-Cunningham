<?php
//process new files//


if (!file_exists('backups')) {
    mkdir("backups", 0777);
}

//DO BACKUP WE ALWAYS BACKUP FILES... ALWAYS!!!!!!!!//
copy('ui.php', 'backups/ui'.time().'.php');

//REMOVE THE OLD FILES - HOPE YOU BACKED UP THE FILES ABOVE//
unlink('ui.php');

//ADD UPDATED OR NEW FILE BELOW//
copy('updates/updatefiles/ui.php', 'ui.php');

//HERE YOU CAN RUN SQL FOR UPDATE INFORMATION//
include('../../inc/harness.php');
$data->query("UPDATE beans SET last_updated = '".time()."' WHERE bean_folder = 'kuhn_plugin'");

echo 'UPDATE APPLIED';