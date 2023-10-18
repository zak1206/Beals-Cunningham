<?php
include('functions.php');
$contentblock = new content_block();

$theEvents = $contentblock->get_blocks_outputs();


//echo  'this is' .date('N', strtotime('monday'));

$events = array();


//GET COUNT OF DAYS FOR RECURRENCE//
function getDayInfo($y, $m, $d)
{

    //echo $m.$d;
    return new DatePeriod(
        new DateTime("first $d of $y-$m"),
        DateInterval::createFromDateString('next '.$d.''),
        new DateTime("last day of $y-$m")
    );
}



for($i=0; $i<=count($theEvents); $i++){


    if($theEvents[$i]["id"] != '') {
        $eventData = array();
        if($theEvents[$i]["reoccuring"] == "yes") {
//echo date('Y-m-d',$theEvents[$i]["end_date"]);
            $start    = new DateTime( date('Y-m-d',$theEvents[$i]["start_date"]));
            $start->modify('first day of this month');
            $end      = new DateTime(date('Y-m-d',$theEvents[$i]["end_date"]));
            $end->modify('first day of next month');
            $interval = DateInterval::createFromDateString('1 month');
            $period   = new DatePeriod($start, $interval, $end);
            $breakdays = json_decode($theEvents[$i]["days"], true);

            foreach ($period as $dt) {
                $year = $dt->format("Y") . PHP_EOL;
                $month = $dt->format("m") . PHP_EOL;
                //echo $month;
                foreach($breakdays as $day) {

                   // echo $month;

                    foreach (getDayInfo($year, $month, $day) as $day) {
                        echo $day->format("l, Y-m-d\n").'<br>'.$day;
                    }
                }

                echo '<br>---------------<br>';
            }





        } else {


            $eventData["id"] = $theEvents[$i]["id"];
            $eventData["title"] = $theEvents[$i]["title"];
            $eventData["start"] = date('Y-m-d H:i:00',$theEvents[$i]["start_date"]);
            $eventData["end"] = date('Y-m-d H:i:00',$theEvents[$i]["end_date"]);
            $eventData["className"] = $theEvents[$i]["className"];
            $eventData["allDay"] = false;
            $eventData["editable"] = true;
        }

        array_push($events, $eventData);
    }
}

//echo json_encode($events);

?>


