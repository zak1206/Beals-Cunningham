<?php
    include('config.php');

    $a = $data->query("SELECT * FROM location WHERE active = 'true'") or die;

    $htmlOut='
        <div class="container2 mb-3">
            <form method="POST" action="careers">
                <div class="row search-form justify-content-between">
                    <i class="fa fa-search" style="font-size: 36px;" aria-hidden="true"></i>
                    <div class="input-group col-4 border-right">
                        <input type="text" size="10" class="form-control" placeholder="Job Title or Keyword" name="keywordserjob">
                    </div>
                    <i class="fa fa-map-marker" style="font-size: 36px;" aria-hidden="true"></i>
                    <div class="dropdown col-3 drop-white" name="locationser" style="border: none;">
                            <select name="locationser" class="form-control">
                                <option><a class="dropdown-item" value=""></a></option>';
                    while($b = $a->fetch_array()){
                        if($b["location_link"] != null) {
                            $htmlOut .= '<option><a class="dropdown-item" value="'. $b['id'] .'">'. $b["location_name"] .'</a></option>';
                        }
                    }

                    $htmlOut .= '
                                </select>
                            </div>
                            <button class="btn btn-success mr-5" style="width: 150px;" type="submit">Search</button>
                        </div>
                    </form>
                </div>';

    echo $htmlOut;

?>