<?php
class content_block {
    function addEvent($post){
        date_default_timezone_set('America/Chicago');
        include('../../inc/harness.php');

        $eventname = $post["category-name"];
        $eventdetails = $post["content"];
        $eventcat = $post["category-color"];
        $startdate = strtotime($post["startday"]);
        $enddate = strtotime($post["endday"]);

        $a = $data->query("INSERT INTO content_blocks SET title = '".$data->real_escape_string($eventname)."',
                                                          content = '".$data->real_escape_string($eventdetails)."', 
                                                          className = '".$data->real_escape_string($eventcat)."', 
                                                          start_date = '".$startdate."', 
                                                          end_date  = '".$enddate."', 
                                                          active = 'true', 
                                                          created  = '".time()."'");

    }

    function quickAdd($post){
        date_default_timezone_set('America/Chicago');
        include('../../inc/harness.php');
        $eventname = $_POST["event-name"];
        $classname = $_POST["class-color"];


        $a = $data->query("INSERT INTO content_blocks SET title = '".$data->real_escape_string($eventname)."', className = '".$data->real_escape_string($classname)."', active = 'true', created  = '".time()."'");
    }

    function editEvent($post){
        date_default_timezone_set('America/Chicago');
        include('../../inc/harness.php');
        $id = $post["eventid"];
        $title = $post["category-name"];
        $classname = $post["category-color"];

        $content = $post["content"];
        $startdate = strtotime($post["startday"]);
        $enddate = strtotime($post["endday"]);


        $a = $data->query("UPDATE content_blocks SET title = '".$data->real_escape_string($title)."', className = '".$data->real_escape_string($classname)."', content = '".$data->real_escape_string($content)."', className = '$classname', start_date = '$startdate', end_date = '$enddate' WHERE id = '$id'") or die($data->error);

       // var_dump($post);
    }

    function editDates($id, $start, $end) {

        $startdate = strtotime($start);
        $enddate = strtotime($end);

        include('../../inc/harness.php');
        $a = $data->query("UPDATE content_blocks SET start_date = '$startdate', end_date = '$enddate' WHERE id = '$id'") or die($data->error);

    }


    function editDateDrag($id, $end) {
        include('../../inc/harness.php');

        $enddate = strtotime($end);
        $a = $data->query("UPDATE content_blocks SET end_date = '$enddate' WHERE id = '$id'") or die($data->error);
    }

    function editExDate($id, $date) {
        include('../../inc/harness.php');

        $date = strtotime($date);

        $a = $data->query("UPDATE content_blocks SET start_date = '$date', end_date = '$date' WHERE id = '$id'") or die($data->error);

    }

    function getCategories(){
        include('../../inc/harness.php');
        $a = $data->query("SELECT * FROM content_blocks WHERE active = 'true' GROUP BY category");
        while($b = $a->fetch_array()){
            $catOps[] = $b["category"];
        }

        return $catOps;
    }


    function get_nodates(){
        include('../../inc/harness.php');

        $a = $data->query("SELECT * FROM content_blocks WHERE start_date = '0' AND active = 'true'");
        while($b = $a->fetch_assoc()){
            $content[] = $b;
        }
        return $content;
    }



    function getBlockDetails($id){
        include('../../inc/harness.php');
        $a = $data->query("SELECT * FROM content_blocks WHERE id = '$id'");
        $b = $a->fetch_assoc();
        return $b;
    }

    function get_blocks_outputs(){
        date_default_timezone_set('America/Chicago');
        include('../../inc/harness.php');
        // $timeNow = strtotime(date('m/d/Y h:i A'));
        $a = $data->query("SELECT * FROM content_blocks WHERE active = 'true'")or die('asdasdasd');
        while($b = $a->fetch_assoc()){
            $content[] = $b;
        }
        return $content;

    }
//
    function deleteIndEvent($id){
        include('../../inc/harness.php');
       $a = $data->query("UPDATE content_blocks SET active = 'false' WHERE id = '$id'") or die($data->error);
        var_dump($id);
    }

}