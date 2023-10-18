<?php
error_reporting(0);
include('../inc/caffeine.php');
$site = new caffeine();
$userArray = $site->auth();
$act = $_REQUEST["action"];
if($act == 'getpagehistory') {
    echo '<table class="table table-bordered">';
    echo '<tr><td><strong>Version Date</strong></td><td><strong>Modified By</strong></td><td style="text-align: right"><strong>Actions</strong></td></tr>';
    $pageHistory = $site->getPageHistory($_REQUEST["page"]);
    $wt = 0;
    for ($i = 0; $i < count($pageHistory); $i++) {
        if ($wt == 0) {
            $bak = 'style="background:#fff"';
            $wt = 1;
        } else {
            $bak = '';
            $wt = 0;
        }



        if ($pageHistory[$i]["codediff"] == 'true') {
            $codeRepo = '| <button class="btn btn-xs btn-secondary btn-fill btn-sm" data-toggle="tooltip" title="View Code Changes" onclick="reviewSource(\'' . $pageHistory[$i]["id"] . '\')"><i class="fa fa-download" aria-hidden="true"></i> View Source Changes</button>';
        } else {
            $codeRepo = '';
        }

        echo '<tr ' . $bak . '><td id="version_info_' . $pageHistory[$i]["id"] . '" class="backup-items">' . date('m/d/Y H:i:s', $pageHistory[$i]["backup_date"]) . '</td><td>' . $pageHistory[$i]["last_user"] . '</td><td style="text-align:right"><button class="btn btn-xs btn-warning btn-fill btn-sm" data-toggle="tooltip" title="Restore Version" onclick="restoreVersion(\'' . $pageHistory[$i]["id"] . '\')"><i class="fa fa-download" aria-hidden="true"></i> Restore</button> | <button class="btn btn-xs btn-primary btn-fill btn-sm" onclick="openRevision(\'' . $pageHistory[$i]["id"] . '\')"><i class="fa fa-search" aria-hidden="true"></i> View Version</button> ' . $codeRepo . '</td></tr>';


    }
    echo '</table>';
}
?>