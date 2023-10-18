<?php
error_reporting(0);
$act = $_REQUEST["action"];
include('functions.php');
$modalAct = new caffeineSlide();

/*if($act == 'createnewmodal'){
    $html .= '<form name="slides_settings" id="slides_settings" method="post" action="">';
    $html .= '<lable>Slider Name</lable><br><input class="form-control" type="text" name="slide_name" id="slide_name" value="" required="required">';
    $html .= '<br><br>';
    $html .= '<label style="font-size: 20px; background: #efefef; padding: 10px; display: block">Slider Settings</label><br><br>';

    $html .= '<div class="row">';
    $html .= '<div class="col-md-12 slidespeed" style="display: block"><label>Slide Speed.</label><br><small>This will set the speed of the slide/fade animations in milliseconds.</small><br><input style="max-width: 200px" class="form-control" type="text" name="speedslide" id="speedslide" value="3000"></div>';
    $html .= '<div style="padding: 20px; width: 100%; clear:both"><hr></div>';
    $html .= '</div>';

    $html .= '<div class="row">';
    $html .= '<div class="col-md-4">Multiple Slides <br><label class="switch"><input class="primary settings" type="checkbox" name="slides[]" data-sett="multi" value="multi_slide"><span class="slider round"></span></label></div>';
    $html .= '<div class="col-md-8 numslide" style="display: none"><label>Number of slides shown per slide.</label><br><input style="max-width: 50px" class="form-control" type="text" name="numbslide" id="numbslide" value=""></div>';
    $html .= '</div>';
    $html .= '<hr>';
    $html .= '<div class="row">';
    $html .= '<div class="col-md-6">Navigation <br><small>Turn on to show navigation dots.</small><br><label class="switch"><input class="primary" type="checkbox" name="slides[]" data-sett="multi" value="navi_slide"><span class="slider round"></span></label></div>';
    $html .= '<div class="col-md-6">Arrows <br><small>When turned on this will show slide arrows.</small><br><label class="switch"><input class="primary" type="checkbox" name="slides[]" data-sett="multi" value="arrows_slide"><span class="slider round"></span></label></div>';

    $html .= '</div>';
    $html .= '<div class="row">';
    $html .= '<div class="col-md-6">Fade <br><small>When turned on slides will fade in & out instead of slide.</small><br><label class="switch"><input class="primary" type="checkbox" name="slides[]" data-sett="multi" value="fade_slide"><span class="slider round"></span></label></div>';
    $html .= '<div class="col-md-6">Auto Play <br><small>When on this will auto slide your slides.</small><br><label class="switch"><input class="primary" type="checkbox" name="slides[]" data-sett="multi" value="auto_slide"><span class="slider round"></span></label></div>';
    $html .= '</div>';

    $html .= '<div class="row">';
    $html .= '<div class="col-md-6">Lazy Load <br><small>This will load images when visible.</small><br><label class="switch"><input class="primary" type="checkbox" name="slides[]" data-sett="multi" value="lazy"><span class="slider round"></span></label></div>';
    $html .= '<div class="col-md-6">Infinite <br><small>When on this will continue to slide any direction endlessly. Not for use with videos that have autoplay enabled.</small><br><label class="switch"><input class="primary" type="checkbox" name="slides[]" data-sett="multi" value="infinite" '.$lazy.'><span class="slider round"></span></label></div>';
    $html .= '</div>';


    $html .= '<hr>';
    $html .= '<div class="row">';
    $html .= '<div class="col-md-12" style="text-align: right">';
    $html .= '<button class="btn btn-outline-primary">Create Slider</button>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</form>';
    echo $html;
}*/

if($act == 'createnewmodal') {
    $html .= '<form name="modal_settings" id="modal_settings" method="post" action="">';
        $html .= '<label>Modal Name</label><br>';
        $html .= '<input class="form-control" type="text" name="slide_name" id="slide_name" value="" required="required">';
        $html .= '<br><br>';

        $html .= '<div class="row">';
            $html .= '<div class="col-md-4">';
                $html .= '<label>Multiple Slides</label><br>';
                $html .= '<label class="switch"><input class="primary settings" type="checkbox" name="slides[]" data-sett="multi" value="multi_slide"><span class="slider round"></span></label>';
            $html .= '</div>';
            $html .= '<div class="col-md-8 numslide">';
                $html .= '<label>Number of slides show per slide.</label><br>';
                $html .= '<input style="max-width: 50px" class="form-control" type="text" name="numbslide" id="numbslide" value="">';
            $html .= '</div>';
        $html .= '</div>';
    $html .= '</form>';
    echo $html;
}