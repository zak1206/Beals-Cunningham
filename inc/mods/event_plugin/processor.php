<?php
class eventCall
{
    function runOutput($comid)
    {

        include('inc/config.php');

        $a = $data->query("SELECT * FROM content_blocks WHERE active = 'true' AND end_date >= '".time()."' ORDER BY start_date ASC LIMIT 10") or die($data->error);

        while($b = $a->fetch_array()){
            $events[] = array("id"=>$b["id"], "title"=>$b["title"], "content"=>$b["content"],"className"=>$b["className"], "start_time"=>$b["start_date"], "end_time"=>$b["end_date"]);
        }

        $eventOut .= '<div class="container">
<div class="row">
    <div class="col-md-8">
        <div id="calendar" style="text-align: center;"></div>
    </div>
    <div class="col-md-4">
        <div id="cal-sidebar">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Upcoming Events</h3>
                </div>
                <div class="panel-body">';

        $eventOut .= '<table class="table">';

        for($i=0; $i<count($events); $i++){

            if($events[$i]["title"] != ''){
                $start = date('F d',$events[$i]["start_time"]);
                $end = date('F d',$events[$i]["end_time"]);

                if($start == $end){
                    $startTime =  date('g:ia',$events[$i]["start_time"]);
                    $endTime =  date('g:ia',$events[$i]["end_time"]);
                    $eventTime = $start.' '. $startTime.' - '.$endTime;
                }else{
                    $startTime =  date('g:ia',$events[$i]["start_time"]);
                    $endTime =  date('g:ia',$events[$i]["end_time"]);
                    $eventTime = $start .' '.  $startTime.' - '. $end.' '. $endTime;
                }
                $eventOut .= '<tr><td><a style="cursor:pointer;" class="side-cal-event" data-id="'.$events[$i]["id"].'"><strong>'.$events[$i]["title"].'</strong></a></td><td>'.$eventTime.'</td></tr>';
            }
        }

        $eventOut .= '</table></div>
            </div></div>
        </div>    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>';

        return $eventOut;
    }
}

class eventListCall {
    function runOutput($comid)
    {

        include('inc/config.php');

        $a = $data->query("SELECT * FROM content_blocks WHERE active = 'true' AND start_date >= '".time()."' ORDER BY start_date ASC LIMIT 10") or die($data->error);

        while($b = $a->fetch_array()){
            $events[] = array("id"=>$b["id"], "title"=>$b["title"], "content"=>$b["content"],"category"=>$b["className"], "start_time"=>$b["start_date"], "end_time"=>$b["end_date"]);
        }


        for($i=0; $i<count($events); $i++){

            if($events[$i]["title"] != ''){
                $start = date('F d',$events[$i]["start_time"]);
                $end = date('F d',$events[$i]["end_time"]);

                if($start == $end){
                    $startTime =  date('g:ia',$events[$i]["start_time"]);
                    $endTime =  date('g:ia',$events[$i]["end_time"]);
                    $eventTime = $start.' '. $startTime.' - '.$endTime;
                }else{
                    $startTime =  date('g:ia',$events[$i]["start_time"]);
                    $endTime =  date('g:ia',$events[$i]["end_time"]);
                    $eventTime = $start .' '.  $startTime.' - '. $end.' '. $endTime;
                }
                $eventOut .= '<div class="event-information" data-id="'.$events[$i]["id"].'"><div class="event-title"><a href="Events">'.$events[$i]["title"].'</a></div><div class="event-time">'.$eventTime.'</div></div>';
            }
        }



        return $eventOut;
    }
}