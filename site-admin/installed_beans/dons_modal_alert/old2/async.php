<?php
error_reporting(0);
$act = $_REQUEST["action"];
include('functions.php');
$slideAct = new caffeineSlide();

if($act == 'getsliders'){
    $slides = $slideAct->getSlideList();

    $html .= '<table id="example" class="display" style="width:100%"> 
                <thead> 
                    <tr> 
                        <th style="font-weight: bold; background: rgb(93, 93, 93); color: rgb(255, 255, 255); border-right: thin solid rgb(239, 239, 239);">Modal Name</th> 
                        <th style="font-weight: bold; background: rgb(93, 93, 93); color: rgb(255, 255, 255); border-right: thin solid rgb(239, 239, 239);">Bean Token</th> 
                        <th style="font-weight: bold; background: rgb(93, 93, 93); color: rgb(255, 255, 255); border-right: thin solid rgb(239, 239, 239);">Created</th> 
                        <th style="font-weight: bold; background: rgb(93, 93, 93); color: rgb(255, 255, 255); border-right: thin solid rgb(239, 239, 239); text-align: right">Action</th> 
                    </tr>
                </thead> 
              <tbody>';

    for($i = 0; $i<count($slides); $i++){
        $slideCount = $slideAct->getCountSlides($slides[$i]["id"]);
        $html .= '<tr>
                    <td>'.$slides[$i]["slide_name"].'</td>
                    <td>{mod}caffeine_modal-modalMod-'.$slides[$i]["id"].'{/mod}</td>
                    <td>'.date('m/d/Y',$slides[$i]["created"]).'</td>
                    <td style="text-align: right">
                        <a href="?addslides=true&id='.$slides[$i]["id"].'" class="btn btn-success">
                            <i class="fas fa-edit"></i>
                        </a> 
                        <button class="btn btn-primary" onclick="modSlideSets(\''.$slides[$i]["id"].'\')">
                            <i class="fas fa-cog"></i>
                        </button> 
                        <button class="btn btn-danger" onclick="delSlider(\''.$slides[$i]["id"].'\')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>';
    }

    $html .='</tbody></table>';

    echo $html;
}

//Create a new modal
if($act == 'createnewslide'){
    $html .= '<form name="slides_settings" id="slides_settings" method="post" action="">';
    $html .= '<lable>Modal Name</lable><br>
                <input class="form-control" type="text" name="slide_name" id="slide_name" value="" required="required">';
    $html .= '<br><br>';
    $html .= '<label style="font-size: 20px; background: #efefef; padding: 10px; display: block">Modal Settings</label><br><br>';

    $html .= '<div class="row">';
        $html .= '<div class="col-md-12 slidespeed" style="display: block">
                    <label>Modal Timer.</label><br>
                    <small>This will set the time the modal will display before it closes in milliseconds.</small><br>
                    <input style="max-width: 200px" class="form-control" type="text" name="speedslide" id="speedslide" value="3000">
                  </div>';
        $html .= '<div style="padding: 20px; width: 100%; clear:both"><hr></div>';
    $html .= '</div>';

    $html .= '<div class="row">';
    $html .= '<div class="col-md-12">Infinite <br><small>When on this active the modal will stay on the page until it is closed.</small><br><label class="switch"><input class="primary" type="checkbox" name="slides[]" data-sett="multi" value="infinite" '.$lazy.'><span class="slider round"></span></label></div>';
    $html .= '</div>';


    $html .= '<hr>';
    $html .= '<div class="row">';
    $html .= '<div class="col-md-12" style="text-align: right">';
    $html .= '<button class="btn btn-outline-primary">Create Modal</button>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</form>';
    echo $html;
}

if($act == 'finishcreate'){
    $slideAct->createnew($_POST);
    echo '<div class="alert alert-success">The modal has been successfully created.</div>';
}

if($act == 'addslide'){
    echo $slideAct->addTheSlide($_POST);
}

if($act == 'getslideslist'){
    $slideLines = $slideAct->getSlides($_REQUEST["slidesid"]);



    $html .= '<table id="example" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th style="font-weight: bold; background: rgb(93, 93, 93); color: rgb(255, 255, 255); border-right: thin solid rgb(239, 239, 239);">Modal Name</th>
                        <th style="font-weight: bold; background: rgb(93, 93, 93); color: rgb(255, 255, 255); border-right: thin solid rgb(239, 239, 239);">Modal Content</th>
                        <th style="font-weight: bold; background: rgb(93, 93, 93); color: rgb(255, 255, 255); border-right: thin solid rgb(239, 239, 239);">Status</th>
                        <th style="font-weight: bold; background: rgb(93, 93, 93); color: rgb(255, 255, 255); border-right: thin solid rgb(239, 239, 239); text-align: right">Action</th>
                    </tr>
                </thead>
            <tbody>';

    //for($i=0; $i<count($slideLines); $i++){

        if($slideLines["slide_end"] != '' && time() > $slideLines["slide_end"]){
            $status = '<span style="color:red">Expired</span>';
        }else{
            $status = '<span style="color:green">Active</span>';
        }

        $html .= '<tr>
                    <td>'.$slideLines["slide_name"].'</td>
                    <td>
                        <div style="zoom: 10%; position:relative">'.$slideLines["slide_content"].'
                            <div class="clearfix"></div>
                        </div>
                    </td>
                    <td>
                        <span style="color:green;">'.$status.'</span>
                    </td>
                    <td style="text-align: right">
                        <button class="btn btn-primary" onclick="editSlide(\''.$slideLines["id"].'\')">Edit</button> 
                        <button class="btn btn-danger" onclick="deleteSlide(\''.$slideLines["id"].'\')">Delete</button>
                    </td>
                 </tr>';
    //}
            $html .= '</tbody>
        </table>';

    echo $html;
}

if($act == 'postorder'){
    $slideAct->updateOrder($_POST["myData"]);
}

if($act == 'getsingleslide'){
    $slidesid = $_REQUEST["slidesid"];
echo $slideAct->getSingleSlide($slidesid);
}

if($act == 'deleteslide'){
    $slideAct->deleteSlide($_REQUEST["slideid"]);
}

if($act == 'modifyslidesettings'){

$theSettings = $slideAct->getSlideSettings($_REQUEST["slideid"]);


    $html .= '<form name="slides_settings_edit" id="slides_settings_edit" method="post" action="">';
        $html .= '<lable>Modal Name</lable><br>
                    <input class="form-control" type="text" name="slide_name" id="slide_name" value="'.$theSettings["slide_name"].'" required="required">';
        $html .= '<br><br>';
        $html .= '<label style="font-size: 20px; background: #efefef; padding: 10px; display: block">Modal Settings</label><br><br>';

        $html .= '<div class="row">';
            $html .= '<div class="col-md-12 slidespeed" style="display: block">
                    <label>Modal Timer.</label><br>
                    <small>This will set the speed of the slide/fade animations in milliseconds.</small><br>
                    <input style="max-width: 200px" class="form-control" type="text" name="speedslide" id="speedslide" value="'.$theSettings["slide_speed"].'">
                </div>';
        $html .= '<div style="padding: 20px; width: 100%; clear:both"><hr></div>';
    $html .= '</div>';

    if($theSettings["infinite"] == 'true'){
        $infinite = 'checked="checked"';
    }else{
        $infinite = '';
    }

    $html .= '<div class="row">';
        $html .= '<div class="col-md-12">Infinite<br>
                    <small>When on this will continue to slide any direction endlessly. Not for use with videos that have autoplay enabled.</small><br>
                    <label class="switch"><input class="primary" type="checkbox" name="slides[]" data-sett="multi" value="infinite" '.$infinite.'>
                        <span class="slider round"></span>
                    </label>
                  </div>';
    $html .= '</div>';


    $html .= '<hr>';
    $html .= '<input type="hidden" name="sliderid" id="sliderid" value="'.$_REQUEST["slideid"].'">';
    $html .= '<div class="row">';
    $html .= '<div class="col-md-12" style="text-align: right">';
    $html .= '<button class="btn btn-outline-primary">Edit Modal Settings</button>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</form>';
    echo $html;
}

if($act == 'finishedit'){
    $slideAct->editsetss($_POST);
    echo '<div class="alert alert-success">Slider has been successfully edited.</div>';
}

if($act == 'deleteslider'){
    $slideAct->deleteSlider($_REQUEST["sliderid"]);
}