<?php
$error = true;


if (isset($_POST["firstname"])) {


    /////File Upload

    // In PHP versions earlier than 4.1.0, $HTTP_POST_FILES should be used instead
    // of $_FILES.

    $uploaddir = 'uploads/';
    $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);


    if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
        // echo "File is valid, and was successfully uploaded.\n";
    } else {
        // echo "Possible invalid file upload !\n";
    }


    // Email

    $a = new site();

    $to[] = array('email' => 'asandeford@blanchardequipment.com', 'name' => 'Heritage Tractor');
    // $to[] = array('email'=> 'marketing@heritagetractor.com','name'=>'Heritage Tractor Marketing');
    // $to[] = array('email'=> 'joycem@bealscunningham.com','name'=>'Joyce McMillar');
    $fromemail = 'no-reply@blanchardequipment.com';
    $fromName = 'Blanchard Equipment';
    $subject = 'New Employment Interest Form Received';
    $firstname = $_POST['firstname'];
    $lastname =  $_POST['lastname'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zipcode = $_POST['zipcode'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $legal_to_work = $_POST['legal_to_work'];
    $position = $_POST['position'];
    $salary_desired = $_POST['salary_desired'];
    $employers_name = $_POST['employers_name'];
    $employment_start = $_POST['employment_start'];
    $employment_end = $_POST['employment_end'];
    $reason_for_leaving = $_POST['reason_for_leaving'];
    $supervisors_name = $_POST['supervisors_name'];
    $employer_phone = $_POST['employer_phone'];
    $position_held = $_POST['position_held'];
    $duties = $_POST['duties'];
    $select_location = implode(', ', $_POST['select_location']);


    if (basename($_FILES['userfile']['name']) != null) {
        $ifFile = ' <p>Attachment: <br><a href="http://blanchard.bcssdevelop.com//' . $uploadfile . '">Download</a></p>';
    } else {
        $ifFile = ' ';
    }


    $message = '<html>
                <body>
                    <h2>Employment Interest Form</h2>
                    <p>First Name: <br>' . $firstname . '</p>
                    <p>Last Name: <br>' . $lastname . '</p>
                    <p>Email: <br>' . $email . '</p>
                    <p>Phone: <br>' . $phone . '</p>
                    <p>Address: <br>' . $address . '</p>
                    <p>City: <br>' . $city . '</p>
                    <p>State: <br>' . $state . '</p>
                    <p>Zipcode: <br>' . $zipcode . '</p>
                    <p>Location of Interest: <br>' . $select_location . '</p>
                    <p>Legal to Work: <br>' . $legal_to_work . '</p>
                    <p>Position: <br>' . $position . '</p>
                    <p>Salary Desired: <br>' . $salary_desired . '</p>
                    <p>Employers Name: <br>' . $employers_name . '</p>
                    <p>Employment Start: <br>' . $employment_start . '</p>
                    <p>Employment End: <br>' . $employment_end . '</p>
                    <p>Reason for Leaving: <br>' . $reason_for_leaving . '</p>
                    <p>Supervisors Name: <br>' . $supervisors_name . '</p>
                    <p>Employer Phone: <br>' . $employer_phone . '</p>
                    <p>Position Held: <br>' . $position_held . '</p>
                    <p>Duties: <br>' . $duties . '</p>
                    <p>Select Location: <br>' . $select_location . '</p>' . $ifFile . '
                </body>
            </html>';


    $send = $a->mailIt($to, $fromemail, $fromName, $subject, $message);

    //if($send == true) {
    //echo '<div class="alert alert-success"><strong>Thank You - We have received your message and will get back with you shortly.</strong></div>';
    //}else{
    //echo '<div class="alert alert-danger">Mailer Error: ' . $mail->ErrorInfo . '</div>';
    //}

    echo '<div class="alert alert-success"><strong>Thank You - We have received your message and will get back with you shortly.</strong></div>';
}
?>

<?php
if ($error == true) {



?>

    <form method="post" action="" id="apply" name="apply" enctype="multipart/form-data">
        <input type="hidden" id="job_title" name="job_title" value="<?php echo $_POST["title"]; ?>">
        <input type="hidden" id="job_location" name="job_location" value="<?php echo $_POST["location"]; ?>">


        <!--<label> First Name</label><br>-->
        <div class="col-md-6 col-sm-6"><br>
            <input type="text" name="firstname" class="form-control" placeholder="First Name" value="" required>
        </div>


        <!--<label> Last Name</label><br>-->
        <div class="col-md-6 col-sm-6"><br>
            <input type="text" name="lastname" class="form-control" placeholder="Last Name" value="" required>
        </div>

        <!--<label> Email</label><br>-->
        <div class="col-md-6 col-sm-6"><br>
            <input type="text" name="email" class="form-control" placeholder="Email" value="" required>
        </div>



        <!--<label> Phone </label><br>-->
        <div class="col-md-6 col-sm-6"><br>
            <input type="text" name="phone" class="form-control" placeholder="Phone" value="" required>
        </div>

        <!--<label> Address</label> <br>-->
        <div class="col-md-6 col-sm-6"><br>
            <input type="text" name="address" class="form-control" placeholder="Address" value="" required>
        </div>


        <!--<label> City  </label><br>-->
        <div class="col-md-6 col-sm-6"><br>
            <input type="text" name="city" class="form-control" placeholder="City" value="" required>
        </div>

        <!-- <label> State  </label><br>-->
        <div class="col-md-6 col-sm-6"><br>
            <input type="text" name="state" class="form-control" placeholder="State" value="" required>
        </div>

        <!--<label> Zip Code</label> <br>-->
        <div class="col-md-6 col-sm-6"><br>
            <input type="text" name="zipcode" class="form-control" placeholder="Zip Code" value="" required>
        </div>


        <!--<label style="width: 100%;"> Select Location </label> <br>-->
        <div class="form-group">
            <label>Select Location(s): <span class="error"> *</span></label><br>

            <label style="display:inline-block; margin: 3px; background: #fff; padding: 3px;"> <input type="checkbox" id="select_location[]" name="select_location[]" value="Aiken, SC"> Aiken, SC</label> <label style="display:inline-block; margin: 3px; background: #fff; padding: 3px;"> <input type="checkbox" id="select_location[]" name="select_location[]" value="Ridge Spring, SC"> Ridge Spring, SC</label> <label style="display:inline-block; margin: 3px; background: #fff; padding: 3px;"> <input type="checkbox" id="select_location[]" name="select_location[]" value="St. George, SC"> St. George, SC</label> <label style="display:inline-block; margin: 3px; background: #fff; padding: 3px;"> <input type="checkbox" id="select_location[]" name="select_location[]" value="St. Matthews, SC"> St. Matthews, SC</label> <label style="display:inline-block; margin: 3px; background: #fff; padding: 3px;"> <input type="checkbox" id="select_location[]" name="select_location[]" value="Hampton, SC"> Hampton, SC</label> <label style="display:inline-block; margin: 3px; background: #fff; padding: 3px;"> <input type="checkbox" id="select_location[]" name="select_location[]" value="Newberry, SC"> Newberry, SC</label> <label style="display:inline-block; margin: 3px; background: #fff; padding: 3px;"> <input type="checkbox" id="select_location[]" name="select_location[]" value="Orangeburg, SC"> Orangeburg, SC</label> <label style="display:inline-block; margin: 3px; background: #fff; padding: 3px;"> <input type="checkbox" id="select_location[]" name="select_location[]" value="Augusta, GA"> Augusta, GA</label> <label style="display:inline-block; margin: 3px; background: #fff; padding: 3px;"> <input type="checkbox" id="select_location[]" name="select_location[]" value="Pooler, GA"> Pooler, GA</label> <label style="display:inline-block; margin: 3px; background: #fff; padding: 3px;"> <input type="checkbox" id="select_location[]" name="select_location[]" value="Greenwood, GA"> Greenwood, GA</label> <label style="display:inline-block; margin: 3px; background: #fff; padding: 3px;"> <input type="checkbox" id="select_location[]" name="select_location[]" value="Dublin, GA"> Dublin, GA</label> <label style="display:inline-block; margin: 3px; background: #fff; padding: 3px;"> <input type="checkbox" id="select_location[]" name="select_location[]" value="Statesboro, GA"> Statesboro, GA</label> <label style="display:inline-block; margin: 3px; background: #fff; padding: 3px;"> <input type="checkbox" id="select_location[]" name="select_location[]" value="Swainsboro, GA"> Swainsboro, GA</label> <label style="display:inline-block; margin: 3px; background: #fff; padding: 3px;"> <input type="checkbox" id="select_location[]" name="select_location[]" value="Louisville, GA"> Louisville, GA</label> <label style="display:inline-block; margin: 3px; background: #fff; padding: 3px;"> <input type="checkbox" id="select_location[]" name="select_location[]" value="Tennille, GA"> Tennille, GA</label> <label style="display:inline-block; margin: 3px; background: #fff; padding: 3px;"> <input type="checkbox" id="select_location[]" name="select_location[]" value="Waynesboro, GA"> Waynesboro, GA</label>
        </div>

        <!-- Legally Entitled to Work in the USA -->
        <div class="form-group">
            <label>Are you legally entitled to work in the USA? <span class="error"> *</span></label><br>
            <label><input type="radio" name="legal_to_work" id="legal_to_work" value="Yes" required=""> Yes</label>
            <label><input type="radio" name="legal_to_work" id="legal_to_work" value="No" required=""> No</label>
        </div>

        <!-- Resume -->
        <div class="col-md-12 col-sm-12"><br>
            <label class="custom-file">Resume and other documents
                <input type="file" id="userfile" name="userfile" class="custom-file-input" required>
                <span class="custom-file-control"></span>
            </label>
        </div>



        <!--<label> Comments/Questions </label><br>-->
        <div class="col-md-12 col-sm-12"><br>
            <textarea name="message" cols="60" rows="4" class="form-control" value="" placeholder="Comments/Questions" required></textarea>
        </div>

        <div class="col-md-12 col-sm-12"><br>
            <label> Pick your area(s) of Interest:<br>
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="interest[]" value="sales"> Sales
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="interest[]" value="admin"> Administration/Office
                    </label>
                </div>

                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="interest[]" value="parts"> Parts and Accessories
                    </label>
                </div>


                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="interest[]" value="service"> Service
                    </label>
                </div>


                <div class="form-check">

                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" id="interest" value="other">Other
                    </label>
                </div>



            </label>
        </div>

        <div class="col-md-12 col-sm-12"><br>
            <label class="custom-file">Resume
                <input type="file" id="userfile" name="userfile" class="custom-file-input" required>
                <span class="custom-file-control"></span>
            </label>
        </div>

        <div class="form-group">
            <label>Position applying for <span class="error"> *</span></label><br>
            <input style="width:250px" type="text" class="form-control" id="position" name="position" required="">
        </div>

        <div class="form-group">
            <label>Desired Wage / Salary <span class="error"> *</span></label><br>
            <input type="text" class="form-control" id="salary_desired" name="salary_desired" required="">
        </div>

        <div class="employment_history">
            <input type="hidden" id="area-sep" name="area-sep" value="new-area">
            <div style="background: #efefef; padding: 10px; margin-top: 10px">
                <h3>Employment History</h3>
                <div class="form-group">
                    <label>Employer's Name:</label><br>
                    <input style="width:250px" type="text" class="form-control" id="employers_name" name="employers_name" required="">
                </div>

                <div class="clear" style="height: 30px;"></div>

                <label>Employed Date Range: <span class="error"> *</span></label><br>
                <div class="input-daterange input-group" id="datepicker">

                    <input type="text" class="input-sm form-control" name="employment_start" id="start" required="">
                    <span class="input-group-addon">to</span>
                    <input type="text" class="input-sm form-control" name="employment_end" id="end" required="">
                </div>

                <div class="clear" style="height: 30px;"></div>

                <div class="form-group">
                    <label>Reason for leaving: <span class="error"> *</span></label><br>
                    <input style="width:600px" type="text" class="form-control" id="reason_for_leaving" name="reason_for_leaving" required="">
                </div>

                <div class="form-group">
                    <label>Supervisors Name: <span class="error"> *</span></label><br>
                    <input style="width:250px" type="text" class="form-control" id="supervisors_name" name="supervisors_name" required="">
                </div>

                <div class="clear" style="height: 30px;"></div>

                <div class="form-group">
                    <label>Phone: <span class="error"> *</span></label><br>
                    <input style="width:250px" type="text" class="form-control phone" id="employer_phone" name="employer_phone" required="">
                </div>

                <div class="form-group">
                    <label>Position Held: <span class="error"> *</span></label><br>
                    <input style="width:250px" type="text" class="form-control" id="position_held" name="position_held" required="">
                </div>

                <div class="clear" style="height: 30px;"></div>

                <div class="form-group">
                    <label>Duties: <span class="error"> *</span></label><br>
                    <textarea style="width:450px; height: 120px" id="duties" name="duties" class="form-control" required=""></textarea>
                </div>

                <div class="clear" style="height: 30px;"></div>


            </div>
        </div>

        <hr>

        <p><strong>False information given or implied on an application form is grounds for immediate dismissal, without further notice.</strong></p>

        <p>I certify that all answers given herein are true and complete to the best of my knowledge. I authorize investigation of all statements contained in this application for employment as may be necessary in arriving at an employment decision. This application for employment shall be considered active for a period of time not to exceed 45 days. Any applicant wishing to be considered for employment beyond this time should inquire as to whether or not applications are being accepted at this time. with this organization of an at will nature, which means that Employee may resign at any time and the Employer may discharge Employee at any time with or without cause. It is further understood that this at will employment relationship may not be changed by any written document or by conduct unless such change is specifically acknowledged in writing by an authorized executive of this organization. In the event of employment, I understand that false or misleading information given in my application or interview(s) may result in discharge. I also understand that I am required to abide by all rules and regulations of the Employer.
        </p>

        <hr>


        <div class="col-md-12 col-sm-12"><br>
            <button type="submit" value="submit" class="btn btn-success btn-online">Submit Application</button>

        </div>


    </form>

<?php }

?>


<div class="message-container"></div>