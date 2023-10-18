<?php
if(file_exists('../../inc/harness.php')){
    include('../../inc/harness.php');
}else{
    include('inc/harness.php');
}

include("functions.php");
$contentStuff = new content_block();

$act = $_REQUEST["action"];

if($act == 'updatedate') {
    $id = $_REQUEST["id"];
    $start = $_REQUEST["start"];
    $end = $_REQUEST["end"];

    $contentStuff->editDates($id, $start, $end);
}

if($act == 'updatedrag') {
    $id = $_REQUEST["id"];
    $end = $_REQUEST["end"];

    $contentStuff->editDateDrag($id, $end);
}

if($act == 'addexternalevent') {
    $id = $_REQUEST["id"];
    $date = $_REQUEST["date"];
//    $date = strtotime($date, 0, 10);

    $contentStuff->editExDate($id, $date);

}

if($act == 'quickadd'){

    $html = '<form name="quick-add-form" id="quick-add-form" method="post" action="">
                    <div class="form-group">
                        <label class="control-label">Event Name</label>
                        <input class="form-control form-white" placeholder="Enter name" type="text" id="event-name" name="event-name" value="" required/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Choose Category Color</label>
                        <select class="form-control form-white" data-placeholder="Choose a color..." id="class-color" name="class-color" value="">
                            <option value="bg-primary">Primary</option>
                            <option value="bg-success">Success</option>
                            <option value="bg-danger">Danger</option>
                            <option value="bg-info">Info</option>
                            <option value="bg-warning">Warning</option>
                            <option value="bg-dark">Dark</option>
                        </select>
                    </div>

                
                <div class="text-right pt-2">
                    <button type="button" class="btn btn-light " data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary ml-1">Save</button>
                </div>
                </form>';

    echo $html;
}

if($act == 'quickaddsave') {
        $contentStuff->quickAdd($_POST);
}

if($act == 'nodatesrecall') {
    $blocks = $contentStuff->get_nodates();
    $html .= '<br><p class="text-muted">Drag and drop your event or click in the calendar</p>';

    for($i = 0; $i < count($blocks); $i++) {

        $html .= '<div class="external-event '.$blocks[$i]['className'].' ui-draggable ui-draggable-handle" data-id="'.$blocks[$i]['id'].'" data-class="'.$blocks[$i]['className'].'" style="position: relative;">
                   <i class="mdi mdi-checkbox-blank-circle mr-2 vertical-middle"></i>'.$blocks[$i]['title'].'
               <a style="float: right; cursor: pointer" onclick="editEvent('.$blocks[$i]['id'].');"><i class="fa fa-edit"></i></a></div>';
    }

    echo $html;

}

if($act == 'addevent'){
    $date = $_REQUEST["eventdate"];
    $formdate = $_REQUEST["eventform"];
    $date = substr($date, 0, 10);
    $date = strtotime("+1 day", $date);
    $date = date('m/d/Y h:ia', $date);




    $html = '<form name="save-event" id="save-event" method="post" action="">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Event Name</label>
                            <input class="form-control form-white" placeholder="Enter name" type="text" name="category-name" id="category-name" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Choose Category Color</label>
                                <select class="form-control form-white" data-placeholder="Choose a color..." name="category-color" id="category-color">
                                  <option value="">Select an Option</option>   
                                    <option value="bg-primary">Primary</option>
                                    <option value="bg-success">Success</option>
                                    <option value="bg-danger">Danger</option>
                                    <option value="bg-info">Info</option>
                                    <option value="bg-warning">Warning</option>
                                    <option value="bg-dark">Dark</option>
                                </select>
                        </div>
                    </div>
                </div>
                <div class="date-wrapper">
                <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
             <label class="control-label">Start Date</label>
             <div class="form-group">
                <div class="input-group date" id="startdate" data-target-input="nearest">
                    <input type="text" class="form-control datetimepicker-input" data-target="#startdate" name="startday" id="startday" value="'.$date.'"/>
                    <div class="input-group-append" data-target="#startdate" data-toggle="datetimepicker" >
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
            </div>
            </div>
            
        </div>
           <div class="col-sm-6">
            <div class="form-group">
             <label class="control-label">End Date</label>
             <div class="form-group">
                <div class="input-group date" id="enddate" data-target-input="nearest">
                    <input type="text" class="form-control datetimepicker-input" data-target="#enddate" name="endday" id="endday" value=""/>
                    <div class="input-group-append" data-target="#enddate" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
            </div>
            </div>
        </div>
        </div>
        </div>
     
                <div class="row">
                    <div class="col-md-12">
                        <textarea class="summernote" name="content" id="content"></textarea>
                    </div>
                    <input type="hidden" value="'.$date.'"/>
                </div>
            <div class="text-right p-3">
                <button type="button" class="btn btn-light " data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success save-event">Create event</button>
            </div>
           </form>
          <div class="message-container"></div>';

    echo $html;
}

if($act == 'saveevent'){
    $contentStuff->addEvent($_POST);
}

if($act == 'editevent') {

    $id = $_REQUEST["id"];
    $event = $contentStuff->getBlockDetails($id);

    if($event["start_date"] == 0) {
        $startdate = '';
    } else {
        $startdate  = date('m/d/Y h:ia', $event["start_date"]);
    }

    if($event["end_date"] == 0) {
        $enddate = '';
    } else {
        $enddate  = date('m/d/Y h:ia', $event["end_date"]);
    }
    $classname = $event["className"];




    $html = '<form name="edit-event" id="edit-event" method="post" action="">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Event Name</label>
                            <input class="form-control form-white" placeholder="Enter name" type="text" name="category-name" id="category-name" value="'.$event["title"].'" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Choose Category Color</label>
                               
                            
                            
                            
                                <select class="form-control form-white" data-placeholder="Choose a color..." name="category-color" id="category-color">';

                                $ReoCu = array("bg-primary", "bg-success", "bg-danger", "bg-info", "bg-warning", "bg-dark");

                                foreach($ReoCu as $key){
                                    if($event["className"] == $key){
                                        $html .= '<option value="'.$key.'" selected="selected">'.ucfirst(substr($key, 3)).'</option>';
                                    }else{
                                        $html .= '<option value="'.$key.'">'.ucfirst(substr($key, 3)).'</option>';
                                    }

                                }
                                                         
                     $html .= '</select>
                        </div>
                    </div>
                </div>
                <div class="date-wrapper">
                      <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
             <label class="control-label">Start Date</label>
             <div class="form-group">
                <div class="input-group date" id="startdate" data-target-input="nearest">
                    <input type="text" class="form-control datetimepicker-input" data-target="#startdate" name="startday" id="startday" value="'.$startdate.'"/>
                    <div class="input-group-append" data-target="#startdate" data-toggle="datetimepicker" >
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
            </div>
            </div>
        </div>
           <div class="col-sm-6">
            <div class="form-group">
             <label class="control-label">End Date</label>
             <div class="form-group">
                <div class="input-group date" id="enddate" data-target-input="nearest">
                    <input type="text" class="form-control datetimepicker-input" data-target="#enddate" name="endday" id="endday" value="'.$enddate.'"/>
                    <div class="input-group-append" data-target="#enddate" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
            </div>
            </div>
           
        </div>
        </div>
        </div>
                <div class="row">
                    <div class="col-md-12">
                        <textarea class="summernote" name="content" id="content">'.$event["content"].'</textarea>
                    </div>
                </div>
                <input type="hidden" name="eventid" id="eventid" value="'.$id.'">
            <div class="text-right p-3">
                <button type="button" class="btn btn-light " data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Update Event</button>
               
            </div>
           </form><button id="delete-btn" type="button" class="btn btn-danger" onClick="deleteAlert('.$id.');">Delete Event</button>';

    echo $html;
}

if($act == 'processedit') {
    $contentStuff->editEvent($_POST);
}



if($act == 'deleteconfirm') {
   $id = $_REQUEST["id"];
    $html = '<div class="text-center"><button class="btn btn-danger" onClick="deleteEvent('.$id.');">Yes, I want to Delete</button><button class="btn btn-warning" style="margin-left: 20px;" data-dismiss="modal">No</button></div>';

    echo $html;
}

if($act == 'deletetheevent') {
    $contentStuff->deleteIndEvent($_REQUEST["id"]);

    var_dump($_REQUEST["id"]);
}
//
//if($act = 'deleteevent') {
//    $id = $_REQUEST["id"];
//    $contentStuff->deleteIndEvent($id);
//}



