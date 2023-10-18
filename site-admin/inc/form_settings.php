<?php
error_reporting(0);
$act = $_REQUEST["action"];

if($act == 'createnew'){
    if($_REQUEST["type"] == 'text_field'){
        $rand = rand(5, 500).date('is');
        $html .= '<div style="padding: 10px; background: #efefef; margin: 3px;" class="allcont-'.$rand.' row"><div class="col-md-4"><i class="textfld_icon"></i> &nbsp; &nbsp; <span class="fldnames-'.$rand.'">Text Field</span></div><div style="text-align: right" class="col-md-8"><button class="btn btn-sm btn-secondary edits-area" data-fieldars="'.$rand.'">Edit</button> <button class="btn btn-sm btn-danger theremoves" data-frmitm="'.$rand.'">Remove</button></div><div class="clearfix"></div>';
        $html .= '<div class="text_filed_edits_'.$rand.' frmarrs" style="background: #fff; padding:5px; margin-top:5px; display:none; width:100%" data-elmtype="text_field">';

        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Required</label></div><div class="col-md-9"><input class="reqs" data-checkdata="'.$rand.'" type="checkbox" name="required-'.$rand.'" id="required-'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Label</label></div><div class="col-md-9"><input class="form-control labsset"  type="text" value="Text Field" name="lab-'.$rand.'" id="lab-'.$rand.'" data-fldname="'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Placeholder</label></div><div class="col-md-9"><input class="form-control" type="text" value="" name="placeholder-'.$rand.'" id="placeholder-'.$rand.'"></div></div>';
        $html .= '<div class="clearfix" class="row"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Field Class</label></div><div class="col-md-9"><input class="form-control" type="text" value="form-control" name="fieldclass-'.$rand.'" id="fieldclass-'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Container Class</label></div><div class="col-md-9"><input class="form-control" type="text" value="" name="containerclass-'.$rand.'" id="containerclass-'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Name</label></div><div class="col-md-9"><input class="form-control" type="text" value="text_'.$rand.'" name="fieldname-'.$rand.'" id="fieldname-'.$rand.'"></div></div>';
        $html .= '<div class="clearfix" class="row"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Value</label></div><div class="col-md-9"><input class="form-control" type="text" value="" name="fieldvalue-'.$rand.'" id="fieldvalue-'.$rand.'"></div></div>';
        $html .= '<div class="clearfix" class="row"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Type</label></div><div class="col-md-9"><select class="form-control" name="fieldtype-'.$rand.'" id="fieldtype-'.$rand.'"><option value="text">Text Field</option><option value="email">Email</option><option value="password">Password</option></select></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Max Length</label></div><div class="col-md-2"><input class="form-control" type="text" value="" name="maxlength-'.$rand.'" id="maxlenght-'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<hr>';
        $html .= '<div style="padding:5px; text-align: center"><button class="btn btn-default edits-area" data-fieldars="'.$rand.'">Done</button></div>';
        $html .= '<div class="clearfix"></div>';

        $html .= '</div></div>';
    }

    if($_REQUEST["type"] == 'text_area'){
        $rand = rand(5, 500).date('is');
        $html .= '<div style="padding: 10px; background: #efefef; margin: 3px;" class="allcont-'.$rand.' row"><div class="col-md-4"><i class="textars_icon"></i> &nbsp; &nbsp; <span class="fldnames-'.$rand.'">Text Area</span></div><div style="text-align: right" class="col-md-8"><button class="btn btn-sm btn-secondary edits-area" data-fieldars="'.$rand.'">Edit</button> <button class="btn btn-sm btn-danger theremoves" data-frmitm="'.$rand.'">Remove</button></div><div class="clearfix"></div>';
        $html .= '<div class="text_filed_edits_'.$rand.' frmarrs" style="background: #fff; padding:5px; margin-top:5px; display:none; width:100%" data-elmtype="text_area">';

        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Required</label></div><div class="col-md-9"><input class="reqs" data-checkdata="'.$rand.'" type="checkbox" name="required-'.$rand.'" id="required-'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Label</label></div><div class="col-md-9"><input class="form-control labsset"  type="text" value="Text Area" name="lab-'.$rand.'" id="lab-'.$rand.'" data-fldname="'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Placeholder</label></div><div class="col-md-9"><input class="form-control" type="text" value="" name="placeholder-'.$rand.'" id="placeholder-'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Field Class</label></div><div class="col-md-9"><input class="form-control" type="text" value="form-control" name="fieldclass-'.$rand.'" id="fieldclass-'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Container Class</label></div><div class="col-md-9"><input class="form-control" type="text" value="" name="containerclass-'.$rand.'" id="containerclass-'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Name</label></div><div class="col-md-9"><input class="form-control" type="text" value="text_'.$rand.'" name="fieldname-'.$rand.'" id="fieldname-'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Value</label></div><div class="col-md-9"><input class="form-control" type="text" value="" name="fieldvalue-'.$rand.'" id="fieldvalue-'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<input type="hidden" name="fieldtype-'.$rand.'" id="fieldtype-'.$rand.'" value="textarea">';

        $html .= '<div class="clearfix"></div>';
        $html .= '<hr>';
        $html .= '<div style="padding:5px; text-align: center"><button class="btn btn-default edits-area" data-fieldars="'.$rand.'">Done</button></div>';
        $html .= '<div class="clearfix"></div>';

        $html .= '</div></div>';
    }

    if($_REQUEST["type"] == 'hidden'){
        $rand = rand(5, 500).date('is');
        $html .= '<div style="padding: 10px; background: #efefef; margin: 3px;" class="allcont-'.$rand.' row"><div class="col-md-4"><i class="hidden_icon"></i> &nbsp; &nbsp; <span class="fldnames-'.$rand.'">Hidden Input</span></div><div style="text-align: right" class="col-md-8"><button class="btn btn-sm btn-secondary edits-area" data-fieldars="'.$rand.'">Edit</button> <button class="btn btn-sm btn-danger theremoves" data-frmitm="'.$rand.'">Remove</button></div><div class="clearfix"></div>';
        $html .= '<div class="text_filed_edits_'.$rand.' frmarrs" style="background: #fff; padding:5px; margin-top:5px; display:none" data-elmtype="hidden">';



        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Name</label></div><div class="col-md-9"><input class="form-control" type="text" value="text_'.$rand.'" name="fieldname-'.$rand.'" id="fieldname-'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Value</label></div><div class="col-md-9"><input class="form-control" type="text" value="" name="fieldvalue-'.$rand.'" id="fieldvalue-'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Field Class</label></div><div class="col-md-9"><input class="form-control" type="text" value="form-control" name="fieldclass-'.$rand.'" id="fieldclass-'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<input type="hidden" name="fieldtype-'.$rand.'" id="fieldtype-'.$rand.'" value="hidden">';

        $html .= '<div class="clearfix"></div>';
        $html .= '<hr>';
        $html .= '<div style="padding:5px; text-align: center"><button class="btn btn-default edits-area" data-fieldars="'.$rand.'">Done</button></div>';
        $html .= '<div class="clearfix"></div>';

        $html .= '</div></div>';
    }

    if($_REQUEST["type"] == 'select'){
        $rand = rand(5, 500).date('is');
        $html .= '<div style="padding: 10px; background: #efefef; margin: 3px;" class="allcont-'.$rand.' row"><div class="col-md-4"><i class="select_icon"></i> &nbsp; &nbsp; <span class="fldnames-'.$rand.'">Select</span></div><div style="text-align: right" class="col-md-8"><button class="btn btn-sm btn-secondary edits-area" data-fieldars="'.$rand.'">Edit</button> <button class="btn btn-sm btn-danger theremoves" data-frmitm="'.$rand.'">Remove</button></div><div class="clearfix"></div>';
        $html .= '<div class="text_filed_edits_'.$rand.' frmarrs" style="background: #fff; padding:5px; margin-top:5px; display:none" data-elmtype="select">';

        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Required</label></div><div class="col-md-9"><input type="checkbox" class="reqs" data-checkdata="'.$rand.'" name="required-'.$rand.'" id="required-'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Label</label></div><div class="col-md-9"><input class="form-control labsset"  type="text" value="Select" name="lab-'.$rand.'" id="lab-'.$rand.'" data-fldname="'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Placeholder</label></div><div class="col-md-9"><input class="form-control" type="text" value="" name="placeholder-'.$rand.'" id="placeholder-'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Field Class</label></div><div class="col-md-9"><input class="form-control" type="text" value="form-control" name="fieldclass-'.$rand.'" id="fieldclass-'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Container Class</label></div><div class="col-md-9"><input class="form-control" type="text" value="" name="containerclass-'.$rand.'" id="containerclass-'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Name</label></div><div class="col-md-9"><input class="form-control" type="text" value="text_'.$rand.'" name="fieldname-'.$rand.'" id="fieldname-'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<input type="hidden" name="fieldtype-'.$rand.'" id="fieldtype-'.$rand.'" value="select">';
        $html .= '<div class="clearfix"></div>';
        $html .= '<br><br>';

        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Options</label></div><div class="col-md-9">';

        $html .= '<ul class="list-group sele-opt'.$rand.' sortable">
  <li class="list-group-item"><div class="row"><div class="col-md-5"><input class="form-control" type="text" name="option-'.$rand.'-0" id="option-'.$rand.'-1" value="Option 1"></div><div class="col-md-5"><input class="form-control" type="text" name="value-'.$rand.'-1" id="value-'.$rand.'-1" value="option 1"></div><div class="col-md-2"></div></div><div style="clear: both"></div></li>
</ul>';

        $html .= '<button style="float: right; margin:20px" class="btn btn-primary addopts" data-optionfld="'.$rand.'">Add Option +</button>';

        $html .='</div></div>';
        $html .= '<hr>';
        $html .= '<div style="padding:5px; text-align: center"><button class="btn btn-success edits-area" data-fieldars="'.$rand.'">Done</button></div>';
        $html .= '<div class="clearfix"></div>';

        $html .= '</div></div>';
    }

    if($_REQUEST["type"] == 'location_selector'){
        $rand = rand(5, 700).date('is');
        $html .= '<div style="padding: 10px; background: #efefef; margin: 3px;" class="allcont-'.$rand.' row"><div class="col-md-4"><i class="select_icon"></i> &nbsp; &nbsp; <span class="fldnames-'.$rand.'">Location Recipients</span></div><div style="text-align: right" class="col-md-8"><button class="btn btn-sm btn-secondary edits-area" data-fieldars="'.$rand.'">Edit</button> <button class="btn btn-sm btn-danger theremoves" data-frmitm="'.$rand.'">Remove</button></div><div class="clearfix"></div>';
        $html .= '<div class="text_filed_edits_'.$rand.' frmarrs" style="background: #fff; padding:5px; margin-top:5px; display:none" data-elmtype="location_selector">';

        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Required</label></div><div class="col-md-9"><input type="checkbox" class="reqs" data-checkdata="'.$rand.'" name="required-'.$rand.'" id="required-'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Label</label></div><div class="col-md-9"><input class="form-control labsset"  type="text" value="Select Location" name="lab-'.$rand.'" id="lab-'.$rand.'" data-fldname="'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Placeholder</label></div><div class="col-md-9"><input class="form-control" type="text" value="" name="placeholder-'.$rand.'" id="placeholder-'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Field Class</label></div><div class="col-md-9"><input class="form-control" type="text" value="form-control" name="fieldclass-'.$rand.'" id="fieldclass-'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Container Class</label></div><div class="col-md-9"><input class="form-control" type="text" value="" name="containerclass-'.$rand.'" id="containerclass-'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Name</label></div><div class="col-md-9"><input class="form-control" type="text" value="recpt_loc" name="fieldname-'.$rand.'" id="fieldname-'.$rand.'" disabled="disabled"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<input type="hidden" name="fieldtype-'.$rand.'" id="fieldtype-'.$rand.'" value="location_selector">';
        $html .= '<div class="clearfix"></div>';
        $html .= '<br><br>';

        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Options</label></div><div class="col-md-9">';

        $html .= '<ul class="list-group sele-opt'.$rand.' sortable">';

        include('harness.php');
        $a = $data->query("SELECT * FROM location WHERE active = 'true' ORDER BY location_name ASC") or die($data->error);
        $bn=0;
        while($b = $a->fetch_array()){
            $rand = rand(5, 700).date('is');
            $html .= '<li class="list-group-item"><div class="row"><div class="col-md-5"><input class="form-control" type="text" name="option-'.$rand.'-'.$bn.'" id="option-'.$rand.'-'.$bn.'" value="'.$b["location_name"].'" disabled="disabled"></div><div class="col-md-5"><input class="form-control" type="text" name="value-'.$rand.'-'.$bn.'" id="value-'.$rand.'-'.$bn.'" value="" autocomplete="off" placeholder="Email Address"></div><div class="col-md-2"></div></div><div style="clear: both"></div></li>';
            $bn++;
        }


$html .='</ul>';

        //$html .= '<button style="float: right; margin:20px" class="btn btn-primary addopts" data-optionfld="'.$rand.'">Add Option +</button>';

        $html .='</div></div>';
        $html .= '<hr>';
        $html .= '<div style="padding:5px; text-align: center"><button class="btn btn-success edits-area" data-fieldars="'.$rand.'">Done</button></div>';
        $html .= '<div class="clearfix"></div>';

        $html .= '</div></div>';
    }



    if($_REQUEST["type"] == 'file_upload'){
        $rand = rand(5, 500).date('is');
        $html .= '<div style="padding: 10px; background: #efefef; margin: 3px;" class="allcont-'.$rand.' row"><div class="col-md-4"><i class="fileups_icon"></i>&nbsp; &nbsp; <span class="fldnames-'.$rand.'">File Upload</span></div><div style="text-align: right" class="col-md-8"><button class="btn btn-sm btn-secondary edits-area" data-fieldars="'.$rand.'">Edit</button> <button class="btn btn-sm btn-danger theremoves" data-frmitm="'.$rand.'">Remove</button></div><div class="clearfix"></div>';
        $html .= '<div class="text_filed_edits_'.$rand.' frmarrs" style="background: #fff; padding:5px; margin-top:5px; display:none" data-elmtype="file_upload">';
        $html .= '<small style="padding: 17px; color: red;"><strong>NOTICE!</strong> - "form_files" is a system handler, Do not remove from below name field if you would like to keep file auto processing. </small>';

        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Required</label></div><div class="col-md-9"><input type="checkbox" class="reqs" data-checkdata="'.$rand.'" name="required-'.$rand.'" id="required-'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Label</label></div><div class="col-md-9"><input class="form-control labsset"  type="text" value="File Upload" name="lab-'.$rand.'" id="lab-'.$rand.'" data-fldname="'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Placeholder</label></div><div class="col-md-9"><input class="form-control" type="text" value="" name="placeholder-'.$rand.'" id="placeholder-'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Field Class</label></div><div class="col-md-9"><input class="form-control" type="text" value="file_area" name="fieldclass-'.$rand.'" id="fieldclass-'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Container Class</label></div><div class="col-md-9"><input class="form-control" type="text" value="" name="containerclass-'.$rand.'" id="containerclass-'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Name</label></div><div class="col-md-9"><input class="form-control" type="text" value="form_files" name="fieldname-'.$rand.'" id="fieldname-'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Destination Folder</label></div><div class="col-md-9"><div class="input-group mb-3">
                        <input type="text" class="form-control" name="fielddesti-'.$rand.'" id="fielddesti-'.$rand.'" placeholder="img/foldername/" aria-label="Category Image" value="">
                        <div class="input-group-append">
                            <button class="btn btn-success img-browser" data-setter="fielddesti-'.$rand.'" type="button">Select Directory</button>
                        </div>
                    </div></div>
</div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<input type="hidden" name="fieldtype-'.$rand.'" id="fieldtype-'.$rand.'" value="fileupload">';

        $html .= '<div class="clearfix"></div>';
        $html .= '<hr>';
        $html .= '<div style="padding:5px; text-align: center"><button class="btn btn-success edits-area" data-fieldars="'.$rand.'">Done</button></div>';
        $html .= '<div class="clearfix"></div>';

        $html .= '</div></div>';
    }

    if($_REQUEST["type"] == 'checkbox_group'){
        $rand = rand(5, 500).date('is');
        $html .= '<div style="padding: 10px; background: #efefef; margin: 3px;" class="allcont-'.$rand.' row"><div class="col-md-4"><i class="checkbox_icon"></i> &nbsp; &nbsp; <span class="fldnames-'.$rand.'">Checkbox</span></div><div style="text-align: right" class="col-md-8"><button class="btn btn-sm btn-secondary edits-area" data-fieldars="'.$rand.'">Edit</button> <button class="btn btn-sm btn-danger theremoves" data-frmitm="'.$rand.'">Remove</button></div><div class="clearfix"></div>';
        $html .= '<div class="text_filed_edits_'.$rand.' frmarrs" style="background: #fff; padding:5px; margin-top:5px; display:none" data-elmtype="checkbox">';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Required</label></div><div class="col-md-9"><input type="checkbox" class="reqs" data-checkdata="'.$rand.'" name="required-'.$rand.'" id="required-'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Label</label></div><div class="col-md-9"><input class="form-control labsset"  type="text" value="Checkbox" name="lab-'.$rand.'" id="lab-'.$rand.'" data-fldname="'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Field Class</label></div><div class="col-md-9"><input class="form-control" type="text" value="form-control" name="fieldclass-'.$rand.'" id="fieldclass-'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Container Class</label></div><div class="col-md-9"><input class="form-control" type="text" value="" name="containerclass-'.$rand.'" id="containerclass-'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Name</label></div><div class="col-md-9"><input class="form-control" type="text" value="text_'.$rand.'" name="fieldname-'.$rand.'" id="fieldname-'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Inline</label></div><div class="col-md-9"><input type="checkbox" name="inline-'.$rand.'" id="inline-'.$rand.'"> | <small>Display checkboxes inline.</small></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<input type="hidden" name="fieldtype-'.$rand.'" id="fieldtype-'.$rand.'" value="checkbox">';
        $html .= '<div class="clearfix"></div>';
        $html .= '<br><br>';

        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Checkbox Options</label></div><div class="col-md-9">';

        $html .= '<ul class="list-group sele-opt'.$rand.' sortable">
  <li class="list-group-item"><div class="row"><div class="col-md-5"><input class="form-control" type="text" name="option-'.$rand.'-0" id="option-'.$rand.'-1" value="Option 1"></div><div class="col-md-5"><input class="form-control" type="text" name="value-'.$rand.'-1" id="value-'.$rand.'-1" value="option 1"></div><div class="col-md-2"></div></div><div style="clear: both"></div></li>
</ul>';

        $html .= '<button style="float: right; margin:20px" class="btn btn-primary addopts" data-optionfld="'.$rand.'">Add Option +</button>';

        $html .='</div></div>';
        $html .= '<hr>';
        $html .= '<div style="padding:5px; text-align: center"><button class="btn btn-success edits-area" data-fieldars="'.$rand.'">Done</button></div>';
        $html .= '<div class="clearfix"></div>';

        $html .= '</div></div>';
    }

    if($_REQUEST["type"] == 'radio_group'){
        $rand = rand(5, 500).date('is');
        $html .= '<div style="padding: 10px; background: #efefef; margin: 3px;" class="allcont-'.$rand.' row"><div class="col-md-4"><i class="radio_icon"></i> &nbsp; &nbsp; <span class="fldnames-'.$rand.'">Radio</span></div><div style="text-align: right" class="col-md-8"><button class="btn btn-sm btn-secondary edits-area" data-fieldars="'.$rand.'">Edit</button> <button class="btn btn-sm btn-danger theremoves" data-frmitm="'.$rand.'">Remove</button></div><div class="clearfix"></div>';
        $html .= '<div class="text_filed_edits_'.$rand.' frmarrs" style="background: #fff; padding:5px; margin-top:5px; display:none" data-elmtype="radio">';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Required</label></div><div class="col-md-9"><input type="checkbox" class="reqs" data-checkdata="'.$rand.'" name="required-'.$rand.'" id="required-'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Label</label></div><div class="col-md-9"><input class="form-control labsset"  type="text" value="Radio" name="lab-'.$rand.'" id="lab-'.$rand.'" data-fldname="'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Field Class</label></div><div class="col-md-9"><input class="form-control" type="text" value="form-control" name="fieldclass-'.$rand.'" id="fieldclass-'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Container Class</label></div><div class="col-md-9"><input class="form-control" type="text" value="" name="containerclass-'.$rand.'" id="containerclass-'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Name</label></div><div class="col-md-9"><input class="form-control" type="text" value="text_'.$rand.'" name="fieldname-'.$rand.'" id="fieldname-'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Inline</label></div><div class="col-md-9"><input type="checkbox" name="inline-'.$rand.'" id="inline-'.$rand.'"> | <small>Display radios inline.</small></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<input type="hidden" name="fieldtype-'.$rand.'" id="fieldtype-'.$rand.'" value="checkbox">';
        $html .= '<div class="clearfix"></div>';
        $html .= '<br><br>';

        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Radio Options</label></div><div class="col-md-9">';

        $html .= '<ul class="list-group sele-opt'.$rand.' sortable">
  <li class="list-group-item"><div class="row"><div class="col-md-5"><input class="form-control" type="text" name="option-'.$rand.'-0" id="option-'.$rand.'-1" value="Option 1"></div><div class="col-md-5"><input class="form-control" type="text" name="value-'.$rand.'-1" id="value-'.$rand.'-1" value="option 1"></div><div class="col-md-2"></div></div><div style="clear: both"></div></li>
</ul>';

        $html .= '<button style="float: right; margin:20px" class="btn btn-primary addopts" data-optionfld="'.$rand.'">Add Option +</button>';

        $html .='</div></div>';
        $html .= '<hr>';
        $html .= '<div style="padding:5px; text-align: center"><button class="btn btn-success edits-area" data-fieldars="'.$rand.'">Done</button></div>';
        $html .= '<div class="clearfix"></div>';

        $html .= '</div></div>';
    }

    if($_REQUEST["type"] == 'header'){
        $rand = rand(5, 500).date('is');
        $html .= '<div style="padding: 10px; background: #efefef; margin: 3px;" class="allcont-'.$rand.' row"><div class="col-md-4"><i class="header_icon"></i> &nbsp; &nbsp; <span class="fldnames-'.$rand.'">Header</span></div><div style="text-align: right" class="col-md-8"><button class="btn btn-sm btn-secondary edits-area" data-fieldars="'.$rand.'">Edit</button> <button class="btn btn-sm btn-danger theremoves" data-frmitm="'.$rand.'">Remove</button></div><div class="clearfix"></div>';
        $html .= '<div class="text_filed_edits_'.$rand.' frmarrs" style="background: #fff; padding:5px; margin-top:5px; display:none" data-elmtype="header">';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Label</label></div><div class="col-md-9"><input class="form-control labsset"  type="text" value="Header" name="lab-'.$rand.'" id="lab-'.$rand.'" data-fldname="'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Header Type</label></div><div class="col-md-9"><select class="form-control" name="headertype-'.$rand.'" id="headertype-'.$rand.'"><option value="h1">H1</option><option value="h2">H2</option><option value="h3">H3</option><option value="h4">H4</option></select></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Container Class</label></div><div class="col-md-9"><input class="form-control" type="text" value="" name="containerclass-'.$rand.'" id="containerclass-'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<input type="hidden" name="fieldtype-'.$rand.'" id="fieldtype-'.$rand.'" value="header">';
        $html .= '<div class="clearfix"></div>';
        $html .= '<hr>';
        $html .= '<div style="padding:5px; text-align: center"><button class="btn btn-success edits-area" data-fieldars="'.$rand.'">Done</button></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '</div></div>';
    }

    if($_REQUEST["type"] == 'paragraph'){
        $rand = rand(5, 500).date('is');
        $html .= '<div style="padding: 10px; background: #efefef; margin: 3px;" class="allcont-'.$rand.' row"><div class="col-md-4"><i class="para_icon"></i> &nbsp; &nbsp; <span class="fldnames-'.$rand.'" style="display:none">Paragraph</span></div><div style="text-align: right" class="col-md-8"><button class="btn btn-sm btn-secondary edits-area" data-fieldars="'.$rand.'">Edit</button> <button class="btn btn-sm btn-danger theremoves" data-frmitm="'.$rand.'">Remove</button></div><div class="clearfix"></div>';
        $html .= '<div class="text_filed_edits_'.$rand.' frmarrs" style="background: #fff; padding:5px; margin-top:5px; display:none" data-elmtype="paragraph">';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Content</label></div><div class="col-md-9"><textarea class="form-control" name="para-'.$rand.'" id="para-'.$rand.'">Content Here...</textarea></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Paragraph Class</label></div><div class="col-md-9"><input class="form-control" type="text" value="" name="fieldclass-'.$rand.'" id="fieldclass-'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Container Class</label></div><div class="col-md-9"><input class="form-control" type="text" value="" name="containerclass-'.$rand.'" id="containerclass-'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<input type="hidden" name="fieldtype-'.$rand.'" id="fieldtype-'.$rand.'" value="paragraph">';
        $html .= '<div class="clearfix"></div>';
        $html .= '<hr>';
        $html .= '<div style="padding:5px; text-align: center"><button class="btn btn-success edits-area" data-fieldars="'.$rand.'">Done</button></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '</div></div>';
    }

    if($_REQUEST["type"] == 'div'){
        $rand = rand(5, 500).date('is');
        $html .= '<div style="padding: 10px; background: #efefef; margin: 3px;" class="allcont-'.$rand.' row"><div class="col-md-4"><i class="div_icon"></i> &nbsp; &nbsp; <span class="fldnames-'.$rand.'" style="display:none">Div</span></div><div style="text-align: right" class="col-md-8"><button class="btn btn-sm btn-secondary edits-area" data-fieldars="'.$rand.'">Edit</button> <button class="btn btn-sm btn-danger theremoves" data-frmitm="'.$rand.'">Remove</button></div><div class="clearfix"></div>';
        $html .= '<div class="text_filed_edits_'.$rand.' frmarrs" style="background: #fff; padding:5px; margin-top:5px; display:none" data-elmtype="div">';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Contents</label></div><div class="col-md-9"><textarea class="form-control" name="div-'.$rand.'" id="div-'.$rand.'" placeholder="You can put contents here or use this as a clear"></textarea></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Div Class</label></div><div class="col-md-9"><input class="form-control" type="text" value="" name="divclass-'.$rand.'" id="containerclass-'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<input type="hidden" name="fieldtype-'.$rand.'" id="fieldtype-'.$rand.'" value="div">';
        $html .= '<div class="clearfix"></div>';
        $html .= '<hr>';
        $html .= '<div style="padding:5px; text-align: center"><button class="btn btn-success edits-area" data-fieldars="'.$rand.'">Done</button></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '</div></div>';
    }

    if($_REQUEST["type"] == 'button'){
        $rand = rand(5, 500).date('is');
        $html .= '<div style="padding: 10px; background: #efefef; margin: 3px;" class="allcont-'.$rand.' row"><div class="col-md-4"><i class="button_icon"></i> &nbsp; &nbsp; <span class="fldnames-'.$rand.'">button</span></div><div style="text-align: right" class="col-md-8"><button class="btn btn-sm btn-secondary edits-area" data-fieldars="'.$rand.'">Edit</button> <button class="btn btn-sm btn-danger theremoves" data-frmitm="'.$rand.'">Remove</button></div><div class="clearfix"></div>';
        $html .= '<div class="text_filed_edits_'.$rand.' frmarrs" style="background: #fff; padding:5px; margin-top:5px; display:none" data-elmtype="button">';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Label</label></div><div class="col-md-9"><input class="form-control labsset"  type="text" value="Button" name="lab-'.$rand.'" id="lab-'.$rand.'" data-fldname="'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Button Class</label></div><div class="col-md-9"><input class="form-control" type="text" value="btn btn-success" name="buttonclass-'.$rand.'" id="buttonclass-'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Data Attributes</label></div><div class="col-md-9"><input class="form-control" type="text" value="" name="buttonattr-'.$rand.'" id="buttonattr-'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div style="padding:5px" class="row"><div class="col-md-3"><label>Container Class</label></div><div class="col-md-9"><input class="form-control" type="text" value="" name="containerclass-'.$rand.'" id="containerclass-'.$rand.'"></div></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<input type="hidden" name="fieldtype-'.$rand.'" id="fieldtype-'.$rand.'" value="button">';
        $html .= '<div class="clearfix"></div>';
        $html .= '<hr>';
        $html .= '<div style="padding:5px; text-align: center"><button class="btn btn-success edits-area" data-fieldars="'.$rand.'">Done</button></div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '</div></div>';
    }

    echo $html;
}