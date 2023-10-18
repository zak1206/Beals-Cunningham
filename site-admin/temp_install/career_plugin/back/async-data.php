<?php
if(file_exists('../../inc/harness.php')){
    include('../../inc/harness.php');
}else{
    include('inc/harness.php');
}
include("functions.php");
$contentStuff = new career_block();

$act = $_REQUEST["action"];
if($act == 'addloc'){
    $html .= '<div class="container"><h3>Location Details</h3>
<form id="addloc" name="addloc" method="post" action="">
                                <div class="row"><div class="col-12">
                                    <label>Location Name</label><br>
                                    <input type="text" class="form-control" name="location-name" id="location-name" value="" required="">
                                    </div></div>
                                    <div class="row">
                                    <div class="form-group col-4">
                                    
                                        <label for="location-address">Address</label>
                                        <input type="text" class="form-control" name="location-address" placeholder="Address" required="" value="">
                                    </div>
                                    <div class="form-group col-4">
                                        <label for="location-city">City</label>
                                        <input type="text" class="form-control" name="location-city" placeholder="City" required="" value="">
                                    </div>
                                    <div class="form-group col-2">
                                        <label for="location-state">State</label>
                                        <select class="form-control" name="location-state" id="location-state" required="">
                                            <option value="">State</option>';

                                            $state = $contentStuff->stateArs();
                                            foreach($state as $stateout=> $val){
                                                    $html .= '<option value="'.$val.'">'.$stateout.'</option>';
                                            }

$html .='</select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="location-city">Zip</label>
                                        <input type="text" class="form-control" id="location-zip" name="location-zip" placeholder="Zip" value="" required>
                                    </div>
                                    </div>
                                    <div class="clearfix"></div>';

                                            $html .= '<div class="clearfix"></div>
                <div class="row"><button class="btn btn-success btn-fill">Create Location</button></form></div></div>';

                                            echo $html;
}

if($act == 'addlocfin'){
    $contentStuff->createLocation($_POST,'','','','');
}

if($act == 'getnewlocs'){
                $locs = $contentStuff->getLocations();
                $html .= '<option value="">Select Job Location</option>';
                for($i=0; $i<count($locs); $i++){
                    $html .= '<option value="'.$locs[$i]["id"].'">'.$locs[$i]["location_name"].'</option>';
                }

                echo $html;
}

if($act == 'newform'){
    $html .= '<form id="new_job_posting" name="new_job_posting" method="post" action="" style="padding: 10px">
        <div class="clearfix"></div>
          <div class="row">
        <div class="col-md-6">
            <label>Job Title</label><br>
            <input class="form-control" type="text" id="title" name="title" value="" required>
        </div>
          </div>

        <div class="clearfix"></div>
         <div class="row">
        <div class="col-md-4">
            <label>Job Category</label><br>

                <select class="form-control" id="category" name="category">
                    <option value="">Select Category OR ADD NEW</option>
                    ';
                    $cats = $contentStuff->getCategories();
                    foreach($cats as $cateogories){
                        $html .= '<option value="'.$cateogories.'">'.$cateogories.'</option>';
                    }
            $html .= '
                </select>
        </div>
        <div class="col-4">
            <label>New Job Category</label><br>
            <input class="form-control" type="text" id="new_cat" name="new_cat" value="">
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="row">
        <div class="col-4">
            <label>Job Location</label><br>
            <div class="location_manage">
            <select class="form-control" id="location" name="location" required>
                <option value="">Select Job Location</option>
                ';
                $locs = $contentStuff->getLocations();

                for($i=0; $i<count($locs); $i++){
                    $html .= '<option value="'.$locs[$i]["id"].'">'.$locs[$i]["location_name"].'</option>';
                }
                $html .='

            </select>
            </div>
            
            
  

        <div class="col-4"><label>&nbsp;</label><br><a class="btn btn-warning btn-fill" onclick="addNewLoc()">+ Add New Location</a></div>
        </div>

        <div class="clearfix"></div>

        <div class="col-4">
            <label>Position Type</label><br>
            <select class="form-control" id="position_type" name="position_type" required>
                <option value="">Select Position Type</option>
                <option value="Full Time">Full Time</option>
                <option value="Part Time">Part Time</option>
            </select>
        </div>
        </div>

        <div class="clearfix"></div></div>
     
        <div class="row">
        <div class="col-md-12">
            <label>Job Description</label><br>
            <textarea class="summernote" name="description" id="description"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi<br /><br /></p>
<strong>Job Responsibilities/Duties<br /></strong>
<ul>
 <li>Sed ut perspiciatis unde omnis iste</li>
 <li>Sed ut perspiciatis unde omnis isteSed ut perspiciatis unde omnis iste</li>
 <li>Sed ut perspiciatis unde omnis iste</li>
 <li>Sed ut perspiciatis unde omnis iste</li>
</ul></textarea>
        </div>
        </div>
<div class="row">
        <div class="col-md-12">
            <label>Qualifications</label><br>
            <textarea class="summernote" name="qualifications" id="qualifications">
<strong>Experience, Skills, and Knowledge:<br /></strong>
<ul>
 <li>Sed ut perspiciatis unde omnis iste</li>
 <li>Sed ut perspiciatis unde omnis isteSed ut perspiciatis unde omnis iste</li>
 <li>Sed ut perspiciatis unde omnis iste</li>
 <li>Sed ut perspiciatis unde omnis iste</li>
</ul></textarea>
        </div>
        </div>
        <div class="clearfix"></div>

       <button style="float: right; margin: 20px;" type="button" class="btn btn-danger btn-fill canempadd">Cancel</button> <button style="float: right; margin: 20px;" type="submit" class="btn btn-default btn-fill">Create New Job Listing</button>
        <div class="clearfix"></div>

    </form>';

                echo $html;
}

if($act == 'editform'){


    $jobInfo = $contentStuff->getSingleJob($_REQUEST["id"]);


    $html .= '<div class="container-fluid"><form id="edit_job_posting" name="edit_job_posting" method="post" action="" style="padding: 10px">
<input type="hidden" name="editform" id="editform" value="'.$_REQUEST["id"].'">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-6">
                <label>Job Title</label><br>
                <input class="form-control" type="text" id="title" name="title" value="'.$jobInfo["career_title"].'" required>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-4">
                <label>Job Category</label><br>
    
                    <select class="form-control" id="category" name="category">
                        <option value="">Select Category OR ADD NEW</option>
                        ';
        $cats = $contentStuff->getCategories();
        foreach($cats as $cateogories){
            if($jobInfo["category"] == $cateogories){
                $html .= '<option value="'.$cateogories.'" selected="selected">'.$cateogories.'</option>';
            }else{
                $html .= '<option value="'.$cateogories.'">'.$cateogories.'</option>';
            }

        }
        $html .= '
                    </select>
            </div>
      
            <div class="col-md-4">
                <label>New Job Category</label><br>
                <input class="form-control" type="text" id="new_cat" name="new_cat" value="">
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-4">
                <label>Job Location</label><br>
                <div class="location_manage">
                <select class="form-control" id="location" name="location" required>
                    <option value="">Select Job Location</option>
                    ';
        $locs = $contentStuff->getLocations();

        for($i=0; $i<count($locs); $i++){
            if($jobInfo["location"] == $locs[$i]["id"]){
                $html .= '<option value="'.$locs[$i]["id"].'" selected="selected">'.$locs[$i]["location_name"].'</option>';
            }else{
                $html .= '<option value="'.$locs[$i]["id"].'">'.$locs[$i]["location_name"].'</option>';
            }

        }

        $postionType = array("Full Time","Part Time");

        $html .='
    
                </select>
                </div>
            </div>
       

            <div class="col-md-4"><label>&nbsp;</label><br><a class="btn btn-warning btn-fill" href="javascript:addNewLoc()">+ Add New Location</a></div>
            
        </div>

        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-4">
                <label>Position Type</label><br>
                <select class="form-control" id="position_type" name="position_type" required>
                    <option value="">Select Position Type</option>';

            foreach($postionType as $postionTy){
                if($jobInfo["position_type"] == $postionTy){
                    $html .= '<option value="'.$postionTy.'" selected="selected">'.$postionTy.'</option>';
                }else{
                    $html .= '<option value="'.$postionTy.'">'.$postionTy.'</option>';
                }

            }

                $html .='</select>
            </div>
        </div>

        <div class="clearfix"></div>
<div class="row">
        <div class="col-md-12">
            <label>Job Description</label><br>
            <textarea class="summernote" name="description" id="description">'.$jobInfo["description"].'</textarea>
        </div>
        </div>
<div class="row">
        <div class="col-md-12">
            <label>Qualifications</label><br>
            <textarea class="summernote" name="qualifications" id="qualifications">
'.$jobInfo["qualifications"].'</textarea>
        </div>
        </div>
        <div class="clearfix"></div>

       <button style="float: right; margin: 20px;" type="button" class="btn btn-danger btn-fill canempadd">Cancel</button> <button style="float: right; margin: 20px;" type="submit" class="btn btn-default btn-fill">Edit Job Listing</button>
        <div class="clearfix"></div>

    </form></div>';

    echo $html;
}


if($act == 'deleteit'){
    $contentStuff->removeListing($_REQUEST["id"]);
}

if($act == 'readjob'){
    include('../../inc/harness.php');
    $a = $data->query("SELECT * FROM career_blocks WHERE id = '".$_REQUEST["id"]."'");
    $b = $a->fetch_array();

    $location = $b["location"];

    $c = $data->query("SELECT * FROM location WHERE id = '$location'");
    $d = $c->fetch_array();

    $careertitle = str_replace('/', '', $b["career_title"]);

    $locationDetails = $d["location_city"].', '.$d["location_state"];

    $html .= '<table class="table" style="border: none;">';
    $html .= '<tr><td><strong>Job Title:</strong></td><td>'.$b["career_title"].'</td><td><strong>Category:</strong></td><td>'.$b["category"].'</td></tr>';
    $html .= '<tr><td><strong>Job Location:</strong></td><td>'.$locationDetails.'</td><td><strong>Position Type:</strong></td><td>'.$b["position_type"].'</td></tr>';
    $html .= '</table>';

    $html .= '<div style="height: 30px"></div>';

    $html .= '<div class="panel panel-success"> <div class="panel-heading" style="background:#457442"> <h3 class="panel-title" style="background:#457442; color: white; padding: 0px 20px;">Description</h3> </div> <div class="panel-body">'.$b["description"].'</div> </div>';
    $html .= '<div style="height: 30px"></div>';
    $html .= '<div class="panel panel-success"> <div class="panel-heading" style="background:#457442"> <h3 class="panel-title" style="background:#457442; color: white; padding: 0px 20px;">Qualifications</h3> </div> <div class="panel-body">'.$b["qualifications"].'<a class="btn btn-success" href="Career-Apply?careertitle='.str_replace(' ','-', $careertitle).'&careerlocation='.str_replace(' ','-', $locationDetails).'">Apply</a></div> </div>';


    echo $html;
}


        ?>