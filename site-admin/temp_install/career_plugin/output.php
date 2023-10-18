<?php
    include('site-admin/installed_beans/content_plugin/functions.php');
    $contentblock = new content_block();

    $theEvents = $contentblock->get_blocks_outputs();


    $events = array();

    for($i=0; $i<=count($theEvents); $i++){
        $eventData = array();
        $eventData["id"] = $theEvents[$i]["id"];
        $eventData["title"] = $theEvents[$i]["content_title"];
        $eventData["start"] = $theEvents[$i]["date_set"];
        $eventData["end"] = $theEvents[$i]["date_set_end"];
        $eventData["allDay"] = false;
        $eventData["backgroundColor"] = '#000';
        array_push($events, $eventData);
    }

    echo json_encode($events);

?>
