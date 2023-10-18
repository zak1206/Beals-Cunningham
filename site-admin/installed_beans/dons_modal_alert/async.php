<?php
error_reporting(0);
$act = $_REQUEST["action"];
include('functions.php');
//$slideAct = new caffeineSlide();

$modalImg = '';

if($act = 'createNewModal') {
    $html .= '<form id="modalCreation" name="modalCreation" method="post" action="">';
        $html .= '<div class="row">';
            $html .= '<div class="col-md-12">';
                $html .= '<label>Modal Name</label>';
                $html .= '<input id="modalName" name="modalName" class="form-control" type="text">';
            $html .= '</div>';
            $html .= '<hr>';
            $html .= '<div class="col-md-12">';
                $html .= '<p style="font-size: 20px; background: #efefef; padding: 10px; margin-top: 15px;">Modal Settings</p>';
            $html .= '</div>';
            $html .= '<div class="col-md-6">';
                $html .= '<label>URL</label>';
                $html .= '<input id="modalLink" name="modalLink" class="form-control" type="text">';
            $html .= '</div>';
            $html .= '<div class="col-md-6">';
                $html .= '<label>Image</label>';
                $html .= '<div class="input-group mb-3">';
                    $html .= '<input type="text" class="form-control" name="modalImg" id="modalImg" placeholder="No Image" aria-label="Category Image" value="'.$modalImg.'">';
                    $html .= '<div class="input-group-append">';
                        $html .= '<button class="btn btn-success img-browser" data-setter="cat_img" type="button">Browse Images</button>';
                    $html .= '</div>';
                $html .= '</div>';
            $html .= '</div>';
            $html .= '<div class="col-md-6 my-auto">';
                $html .= '<input type="checkbox" class="form-check-input" id="infinite" placeholder="0">';
                $html .= '<label class="form-check-label" for="infinite">  Timer</label>';
            $html .= '</div>';
            $html .= '<div class="col-md-6">';
                $html .= '<label>Set Timer</label>';
                $html .= '<input id="modalTimer" name="modalTimer" class="form-control" type="number" min="0">';
            $html .= '</div>';
            $html .= '<hr>';
        $html .= '</div>';
    $html .= '</form>';
    echo $html;
}