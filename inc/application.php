<div style="padding: 5px; margin: auto; width:550px"></div>

<div id="response-frame">

<div style="padding: 15px;">
    <span style="text-align: center"><h2>EMPLOYMENT APPLICATIONs</h2></span>
    <ul>
        <li>All information obtained within this application will be held in strict confidence, subject to applicable law.</li>
        <li>Please complete all applicable sections.</li>
        
    </ul>

    <br><br>
    <p><strong class="error"> * = Required </strong></p>
</div>


    <!-- Modal -->
    <div id="res_att" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                </div>
                <div class="modal-body">
                    <h2>Attach Resume</h2>
                    <form class="form-inline empl-appli-att" name="empform_att" id="empform_att" role="form" style="padding: 20px" method="post" action="" onsubmit="return false" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="ChooseFile">Submit Resume</label>
                                <input type="file" class="form-control-file" id="resumeAtt" name="resumeAtt" aria-describedby="fileHelp">
                                <p style="font-size: 20px;">Submit resume here.</p>
                            </div>

                        <button class="btn btn-wanring" type="submit">Attach</button>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>


<form class="form-inline empl-appli" name="empforms" id="empforms" role="form" style="padding: 20px" method="post" action="" onsubmit="return false" enctype="multipart/form-data">
    <div clas="row">
 <div class="col-md-6">
    <div class="form-group" style="margin-top:20px;">
        <label>First Name <span class="error"> *</span></label><br>
        <input style="width: 100%;" type="text" class="form-control" id="first_name" name="first_name" required>
    </div>
 </div>
    <div class="col-md-6">
    <div class="form-group" style="margin-top:20px;">
        <label>Last Name <span class="error"> *</span></label><br>
        <input style="width: 100%;" type="text" class="form-control" id="last_name" name="last_name" required>
    </div>
    </div>
    <div class="clear" style="height: 30px;"></div>
    <div class="col-md-6">
    <div class="form-group">
        <label>Telephone: <span class="error"> *</span></label><br>
        <input style="width: 100%;" type="text" class="form-control phone" id="phone" name="phone" required>
    </div>
    </div>
    <div class="col-md-6">
    <div class="form-group" style="margin-top:20px;">
        <label>Email Address: <span class="error"></span></label><br>
        <input style="width: 100%;" type="email" class="form-control" id="email" name="email">
    </div>
    </div>

    <div class="clear" style="height: 30px;"></div>
    <div class="col-md-6">
    <div class="form-group" style="margin-top:20px;">
        <label>Address: <span class="error"> *</span></label><br>
        <input style="width: 100%;" type="text" class="form-control" id="address" name="address" required>
    </div>
    </div>
    <div class="col-md-6">
    <div class="form-group" style="margin-top:20px;">
        <label>City: <span class="error"> *</span></label><br>
        <input style="width:100%;" type="text" class="form-control" id="city" name="city" required>
    </div>
    </div>
    <div class="col-md-6">
    <div class="form-group">
        <label>State: <span class="error"> *</span></label><br>
        <select style="width: 100%;" class="form-control" id="state" name="state" required>
            <?php
            $us_state_abbrevs_names = array(
                'AL'=>'Alabama',
                'AK'=>'Alaska',
                'AZ'=>'Arizona',
                'AR'=>'Arkansas',
                'CA'=>'California',
                'CO'=>'Colorado',
                'CT'=>'Connecticut',
                'DE'=>'Delaware',
                'DC'=>'District of Columbia',
                'FL'=>'Florida',
                'GA'=>'Georgia',
                'HI'=>'Hawaii',
                'ID'=>'Idaho',
                'IL'=>'Illinois',
                'IN'=>'Indiana',
                'IA'=>'Iowa',
                'KS'=>'Kansas',
                'KY'=>'Kentucky',
                'LA'=>'Louisiana',
                'ME'=>'Maine',
                'MD'=>'Maryland',
                'MA'=>'Massachusetts',
                'MI'=>'Michigan',
                'MN'=>'Minnesota',
                'MS'=>'Mississippi',
                'MO'=>'Missouri',
                'MT'=>'Montana',
                'NE'=>'Nebraska',
                'NV'=>'Nevada',
                'NH'=>'New Hampshire',
                'NJ'=>'New Jersey',
                'NM'=>'New Mexico',
                'NY'=>'New York',
                'NC'=>'North Carolina',
                'ND'=>'North Dakota',
                'OH'=>'Ohio',
                'OK'=>'Oklahoma',
                'OR'=>'Oregon',
                'PA'=>'Pennsylvania',
                'RI'=>'Rhode Island',
                'SC'=>'South Carolina',
                'SD'=>'South Dakota',
                'TN'=>'Tennessee',
                'TX'=>'Texas',
                'UT'=>'Utah',
                'VT'=>'Vermont',
                'VA'=>'Virginia',
                'WA'=>'Washington',
                'WV'=>'West Virginia',
                'WI'=>'Wisconsin',
                'WY'=>'Wyoming',
            );

            foreach($us_state_abbrevs_names as $key => $val){
                echo '<option value="'.$key.'">'.$val.'</option>';
            }
            ?>
        </select>
    </div>
    </div>
    <div class="col-md-6">
    <div class="form-group" style="margin-top:20px;">
        <label>Zip: <span class="error"> *</span></label><br>
        <input style="width:100%;" type="text" class="form-control zip" id="zip" name="zip" required>
    </div>
    </div>

    <div class="clear" style="height: 30px;"></div>
    <div class="col-md-12">

    <div class="form-group">
        <label>Select Location(s): <span class="error"> *</span></label><br>

        <?php
        $locationsArr = array("Aiken, SC","Ridge Spring, SC","St. George, SC","St. Matthews, SC","Hampton, SC","Newberry, SC", "Orangeburg, SC", "Augusta, GA", "Pooler, GA", "Greenwood, GA", "Dublin, GA","Statesboro, GA","Swainsboro, GA","Louisville, GA","Tennille, GA","Waynesboro, GA");
        $i=0;
        foreach($locationsArr as $key){
            echo ' <label style="display:inline-block; margin: 3px; background: #fff; padding: 3px;"> <input type="checkbox" id="location(s)[]" name="location(s)[]" value="'.$key.'"/> '.$key.'</label> ';
            $i++;
        }
        ?>

        </div>
    </div>

    <div class="clear" style="height: 30px;"></div>
    <div class="col-md-12">
    <div class="form-group">
        <label>Are you legally entitled to work in the USA? <span class="error"> *</span></label><br>
        <label><input type="radio" name="legal_to_work" id="legal_to_work" value="Yes" required> Yes</label>
        <label><input type="radio" name="legal_to_work" id="legal_to_work" value="No" required> No</label>
    </div>
    </div>


    <div style="padding: 38px 0px 14px"><button class="btn btn-success" type="button" onclick="attachRes()"><i class="fa fa-paperclip" aria-hidden="true"></i> Attach Resume</button></div>
    <span id="filsst"></span>
    <input type="hidden" name="resume_atttcg" id="resume_atttcg" value="">

    <div class="clear" style="height: 30px;"></div>


    <div class="col-md-12">
    <div class="form-group">
        <label>Position applying for: <span class="error"> *</span></label><br>
        <input style="width:100%;" type="text" class="form-control" id="position" name="position" required>
    </div>
    </div>
    <div class="col-md-12">
    <div class="form-group" style="margin-top:20px;">
        <label>Desired Wage / Salary: <span class="error"> *</span></label><br>
        <input style="width:100%;" type="text" class="form-control" id="salary_desired" name="salary_desired" required>
    </div>
    </div>
    </div>
    <div class="clear" style="height: 30px;"></div>


    <div class="employment_history" style="width:100%;">
        <input type="hidden" id="area-sep" name="area-sep" value="new-area"/>
        <div style="background: #efefef; padding: 10px; margin-top: 10px">
            <h3>Employment History</h3>
            <div class="form-group" style="margin-top:20px;">
                <label>Employer's Name:</label><br>
                <input style="width:100%;" type="text" class="form-control" id="employers_name" name="employers_name" required>
            </div>

            <div class="clear" style="height: 30px;"></div>

            <label>Employed Date Range: <span class="error"> *</span></label><br>
            <div class="input-daterange input-group" id="datepicker">

                <input type="text" class="input-sm form-control" name="start" id="start" required/>
                <span class="input-group-addon">to</span>
                <input type="text" class="input-sm form-control" name="end" id="end" required/>
            </div>

            <div class="clear" style="height: 30px;"></div>

            <div class="form-group" style="margin-top:20px;">
                <label>Reason for leaving: <span class="error"> *</span></label><br>
                <input style="width:100%;" type="text" class="form-control" id="reason_for_leaving" name="reason_for_leaving" required>
            </div>

            <div class="form-group" style="margin-top:20px;">
                <label>Supervisors Name: <span class="error"> *</span></label><br>
                <input style="width:100%;" type="text" class="form-control" id="supervisors_name" name="supervisors_name" required>
            </div>

            <div class="clear" style="height: 30px;"></div>

            <div class="form-group">
                <label>Phone: <span class="error"> *</span></label><br>
                <input style="width:100%;" type="text" class="form-control phone" id="employer_phone" name="employer_phone" required>
            </div>

            <div class="form-group" style="margin-top:20px;">
                <label>Position Held: <span class="error"> *</span></label><br>
                <input style="width:100%;" type="text" class="form-control" id="position_held" name="position_held" required>
            </div>

            <div class="clear" style="height: 30px;"></div>

            <div class="form-group" style="margin-top:20px;">
                <label>Duties: <span class="error"> *</span></label><br>
                <textarea style="width:100%; height: 120px"  id="duties" name="duties" class="form-control" required></textarea>
            </div>

            <div class="clear" style="height: 30px;"></div>

        </div>
    </div>

    <div class="add_emply"></div>

    <hr>

    <p>Add at least your last 3 Employment Positions by clicking the button below to add the record.</p>

    <button class="btn btn-warning" onclick="copyEmps()" type="button"><i class="fa fa-plus"></i> Add Another Employment Record</button>

    <div class="clear" style="height: 30px;"></div>

    <hr>

    <p><strong>False information given or implied on an application form is grounds for immediate dismissal, without further notice.</strong></p>

    <p>I certify that all answers given herein are true and complete to the best of my knowledge. I authorize investigation of all statements contained in this application for employment as may be necessary in arriving at an employment decision. This application for employment shall be considered active for a period of time not to exceed 45 days. Any applicant wishing to be considered for employment beyond this time should inquire as to whether or not applications are being accepted at this time. with this organization of an at will nature, which means that Employee may resign at any time and the Employer may discharge Employee at any time with or without cause. It is further understood that this at will employment relationship may not be changed by any written document or by conduct unless such change is specifically acknowledged in writing by an authorized executive of this organization. In the event of employment, I understand that false or misleading information given in my application or interview(s) may result in discharge. I also understand that I am required to abide by all rules and regulations of the Employer.
    </p>

    <hr>

    <button type="submit" class="btn btn-danger">Submit Application</button>
</form>

<div style="padding: 50px"></div>
    </div>


