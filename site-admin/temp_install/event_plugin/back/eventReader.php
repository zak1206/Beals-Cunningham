<?php
include('functions.php');
$contentblock = new content_block();

$theEvents = $contentblock->get_blocks_outputs();


//echo  'this is' .date('N', strtotime('monday'));

$events = array();


//GET COUNT OF DAYS FOR RECURRENCE//
function getDayInfo($y, $m, $d)
{
    return new DatePeriod(
        new DateTime("first $d of $y-$m"),
        DateInterval::createFromDateString('next '.$d.''),
        new DateTime("last day of $y-$m")
    );
}

foreach (getDayInfo(2019, 11, 'friday') as $day) {
    //echo $day->format("l, Y-m-d\n");
}

for($i=0; $i<=count($theEvents); $i++){


    if($theEvents[$i]["id"] != '' && $theEvents[$i]["start_date"] > 0) {
        $eventData = array();



        $eventData["id"] = $theEvents[$i]["id"];
        $eventData["title"] = $theEvents[$i]["title"];
        $eventData["start"] = date('Y-m-d H:i:00',$theEvents[$i]["start_date"]);
        $eventData["end"] = date('Y-m-d H:i:00',$theEvents[$i]["end_date"]);
        $eventData["className"] = $theEvents[$i]["className"];
        $eventData["allDay"] = true;


        array_push($events, $eventData);
    }
}

echo json_encode($events);

?>
