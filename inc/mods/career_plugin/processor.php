<?php
class careerCall
{
    function runOutput($comid)
    {

        include('inc/config.php');

        if(isset($_POST['search'])) {
            $new_value=$_GET['search'];
            echo "Search Text: " . $new_value;
        } else {
            echo "No Search Set~~~~~~~~";
        }

        $jobOut .= '<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div><div class="row container" style="margin-left: auto; margin-right: auto; justify-content: center;"><div class="col-md-4">';
        $jobOut .= '<form name="jobsearch" id="jobsearch" action="" method="post">';
        $jobOut .= '<div class="panel panel-success careers-body"> <div class=""> <h3 class="career-filter">Filters</h3> </div> <div class="panel-body">

      <input type="text" name="keywordserjob" id="keywordserjob" class="form-control" placeholder="Search by Job Title, Keyword" value="' . $_POST["keywordserjob"] . '">
      <!-- /input-group --></div> 
    <strong style="display: block; padding: 10px; background: #efefef; margin: 0px 15px;">Locations</strong>
    <div style="padding: 10px; margin: 0px 15px;">
    <table class="table">';

        if (isset($_POST["keywordserjob"])) {

            if (isset($_POST["locationser"])) {
                $cg = 1;
                foreach ($_POST["locationser"] as $locs) {
                    if (count($_POST["locationser"]) > 0) {

                        if ($cg == count($_POST["locationser"])) {
                            $endsql = '';
                        } else {
                            $endsql = ' OR ';
                        }
                    }
                    $sql .= "career_title LIKE '%" . $_POST["keywordserjob"] . "%' AND active = 'true' AND location = '" . $locs . "' OR category LIKE '%" . $_POST["keywordserjob"] . "%' AND active = 'true' AND location = '" . $locs . "' OR position_type = '" . $_POST["keywordserjob"] . "' AND active = 'true' AND location = '" . $locs . "' OR description LIKE '%" . $_POST["keywordserjob"] . "%' AND active = 'true' AND location = '" . $locs . "' $endsql";
                    $cg++;
                }
            } else {
                $sql = "career_title LIKE '%" . $_POST["keywordserjob"] . "%' AND active = 'true' OR category LIKE '%" . $_POST["keywordserjob"] . "%' AND active = 'true' OR position_type = '" . $_POST["keywordserjob"] . "' AND active = 'true' OR description LIKE '%" . $_POST["keywordserjob"] . "%' AND active = 'true'";
            }
        } else {
            $sql = "active = 'true'";
        }

        $o = $data->query("SELECT * FROM career_blocks WHERE $sql GROUP BY location") or die('ERROR');
        $locArs = array();
        while ($v = $o->fetch_array()) {
            $n = $data->query("SELECT * FROM location WHERE id = '" . $v["location"] . "'") or die('ERROR2');
            $u = $n->fetch_array();


            $locArs[] = array('location' => $v["location"], 'location_name' => $u["location_name"], 'location_state' => $u["location_state"]);
        }

        function compareByName($a, $b)
        {
            return strcmp($a["location_name"], $b["location_name"]);
        }


        usort($locArs, 'compareByName');
        $locationslist = $data->query("SELECT * FROM location") or die('ERROR');
        $locationArs = array();
        while ($locaArs = $locationslist->fetch_array()) {

            $locationArs[] = array('location' => $locaArs["id"], 'location_name' => $locaArs["location_name"]);
        }
        for ($i = 0; $i <= count($locationArs); $i++) {
            if (in_array($locationArs[$i]["location_name"], $_POST["locationser"])) {
                if ($locationArs[$i]["location_name"] == 'All') {
                    $jobOut .= '<tr><td><input type="checkbox" name="locationser[]" value="' . $locationArs[$i]["location"] . '" checked></td><td>' . $locationArs[$i]["location_name"] . '</td> </tr>';
                } else {
                    $jobOut .= '<tr><td><input type="checkbox" name="locationser[]" value="' . $locationArs[$i]["location"] . '" checked></td><td>' . $locationArs[$i]["location_name"] .  '</td> </tr>';
                }
            } else {
                if ($locationArs[$i]["location_name"] != null) {
                    if ($locationArs[$i]["location_name"] == 'All') {
                        $jobOut .= '<tr><td><input type="checkbox" name="locationser[]" value="' . $locationArs[$i]["location"] . '"></td><td>' . $locationArs[$i]["location_name"] . '</td> </tr>';
                    } else {
                        $jobOut .= '<tr><td><input type="checkbox" name="locationser[]" value="' . $locationArs[$i]["location"] . '"></td><td>' . $locationArs[$i]["location_name"] .  '</td> </tr>';
                    }
                }
            }
        }




        $jobOut .= '</table>
</div>
<div style="padding: 10px; background: #efefef; text-align: center"><a href="careers" class="btn btn-sm btn-warning" type="button" >Reset Form</a> <button class="btn btn-sm btn-success" type="submit">Search</button></div>
    </div></form>';

        $jobOut .= '</div>';


        $jobOut .= '<div class="col-md-8 career-col-8">';

        $jobOut .= '<ul id="pager">';

        if (isset($_POST["keywordserjob"])) {

            if (isset($_POST["locationser"])) {
                $cgg = 1;
                foreach ($_POST["locationser"] as $locss) {
                    if (count($_POST["locationser"]) > 0) {

                        if ($cgg == count($_POST["locationser"])) {
                            $endsqls = '';
                        } else {
                            $endsqls = ' OR ';
                        }
                    }
                    $sqls .= "career_title LIKE '%" . $_POST["keywordserjob"] . "%' AND active = 'true' AND (location = '" . $locss . "' OR location = 24) OR category LIKE '%" . $_POST["keywordserjob"] . "%' AND active = 'true' AND (location = '" . $locss . "' OR location = 24) OR position_type = '" . $_POST["keywordserjob"] . "' AND active = 'true' AND (location = '" . $locss . "' OR location = 24) OR description LIKE '%" . $_POST["keywordserjob"] . "%' AND active = 'true' AND (location = '" . $locss . "' OR location = 24) $endsqls";
                    $cgg++;
                }
            } else {
                $sqls = "career_title LIKE '%" . $_POST["keywordserjob"] . "%' AND active = 'true' OR category LIKE '%" . $_POST["keywordserjob"] . "%' AND active = 'true' OR position_type = '" . $_POST["keywordserjob"] . "' AND active = 'true' OR description LIKE '%" . $_POST["keywordserjob"] . "%' AND active = 'true'";
            }
        } else {
            $sqls = "active = 'true'";
        }

        $a = $data->query("SELECT * FROM career_blocks WHERE $sqls ORDER BY date_set DESC") or die($data->error);
        while ($b = $a->fetch_array()) {

            //Location info//
            $c = $data->query("SELECT * FROM location WHERE id = '" . $b["location"] . "'");
            $d = $c->fetch_array();

            if ($d["location_city"] == 'All') {
                $locationInfo = 'All Locations';
            } else {
                $locationInfo = $d["location_city"] . ', ' . $d["location_state"] . ', ' . $d["location_zip"];
            }

            $descript = strip_tags($b["description"]);

            $countLen = strlen($descript);

            if ($countLen > 319) {
                $dezOut = substr($descript, 0, 319) . '...';
            } else {
                $dezOut = $descript;
            }


            $jobOut .= '<li style="padding: 10px;"><strong><a href="javascript:openJob(\'' . $b["id"] . '\')" style="font-size: 20px; color:#7b7a7a">' . $b["career_title"] . '</a> </strong><br><small style="color:#457442">' . $locationInfo . '</small><br><small>' . $b["position_type"] . '</small><br><small>' . $dezOut . '</small></li>';
        }
        $jobOut .= '</ul>';

        $jobOut .= '</div></div>';



        return $jobOut;
    }
}
?>
<script>
    function openJob(id) {

        $.ajax({
            url: 'site-admin/installed_beans/career_plugin/async-data.php?action=readjob&id=' + id,
            cache: false,
            success: function(data) {
                $("#myModal .modal-body").html(data);
                $("#myModal .modal-body").addClass('career-modal');
                $("#myModal .modal-header").addClass('career-modal-header');
                $("#myModal .modal-title").html('Job Listing');
                $("#myModal").modal();
                $("#myModal .modal-dialog").css('width', '70%');
            }
        })


    }
</script>