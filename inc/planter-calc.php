<?php
        include("config.php");

        if(isset($_POST['submit'])){
            $planterNumOfRows = $_POST['rowNo'];
            $currentRowSpacing = $_POST['currentspacing'];
            $planterAverageSpeed = $_POST['averageSpeed'];
            $planterPercDroppingSeed = $_POST['timeDrop'];
            $eeNumOfRows = $_POST['eeRowNo'];
            $eeRowSpacing = $_POST['eeSpacing'];
            $eeAverageSpeed = $_POST['eeAverageSpeed'];
            $eePercDroppingSeed = $_POST['eeTimeDrop'];
            $planterAcres = $_POST['acres'];
            $eeAcres = $_POST['eeAcres'];
            $currentNumHoursWorked = $_POST['hoursWorked'];
            $eeNumHoursWorked = $_POST['eeHoursWorked'];


            //Current Planting Operation
            $rowVar1 = ($planterNumOfRows * $currentRowSpacing)/12;
            $rowVar2 = ($rowVar1 * 5280)/43560;
            $rowVar3 = $rowVar2 * $planterAverageSpeed;
            $planterAcresPerHour = $rowVar3 * $planterPercDroppingSeed;
            //echo $planterAcresPerHour;

            //Exact Emerge Planting Operation
            $rowVar11 = ($eeNumOfRows * $eeRowSpacing)/12;
            $rowVar21 = ($rowVar11 * 5280)/43560;
            $rowVar31 = $rowVar21 * $eeAverageSpeed;
            $eeAcresPerHour = $rowVar31 * $eePercDroppingSeed;
            //echo $eeAcresPerHour;

            //Totals
            //echo $planterAcresPerHour;
            //echo $eeAcres;
            //echo $eeNumHoursWorked;
            $currentNumDaysToPlant = $planterAcres/($planterAcresPerHour * $currentNumHoursWorked);
            $eeNumDaysToPlant = $eeAcres/($eeAcresPerHour * $eeNumHoursWorked);
            $hoursSaved = ($planterAcres/$planterAcresPerHour) - ($eeAcres/$eeAcresPerHour);
            //echo $currentNumDaysToPlant ;


            $data->query("INSERT INTO planter_calculator SET current_rows='$planterNumOfRows', current_spacing = '$currentRowSpacing', current_avg_speed = '$planterAverageSpeed', current_acres = '$planterAcres', current_hours = '$currentNumHoursWorked',
            ee_rows= '$eeNumOfRows', ee_spacing = '$eeRowSpacing', ee_avg_speed = '$eeAverageSpeed', ee_acres = '$eeAcres', ee_hours = '$eeNumHoursWorked'");



}
?>


<div class="container mt-5">
    <div class="row" style="border: 2px solid green; border-radius: 7px; background: #ECEEEF;">
        <div class="col-4">
            <h2 class="text-center mb-0"><?php echo number_format(round($currentNumDaysToPlant)); ?></h2>
            <h2 class="text-center pt-0 mt-0">Days</h2>
            <p class="text-center" style="font-size: 14px;">Current # of days to plant</p>
        </div>

        <div class="col-4">
            <h2 class="text-center mb-0"><?php echo number_format(round($eeNumDaysToPlant)); ?></h2>
            <h2 class="text-center pt-0 mt-0">Days</h2>
            <p class="text-center" style="font-size: 14px;">EE # of days to plant</p>
        </div>

        <div class="col-4">
            <h2 class="text-center mb-0"><?php echo number_format(round($hoursSaved)); ?></h2>
            <h2 class="text-center pt-0 mt-0">Hours</h2>
            <p class="text-center" style="font-size: 14px;">Saved with EE Planter</p>
        </div>
    </div>
    <div class="row">
        <h1 class="text-center">What Would You Do With the Hours Saved?</h1>
    </div>
    <div class="clearfix"></div>
    <div class="row align-items-start">
        <div class="col-lg-8">
            <h2 style="text-transform: none">Current Planting Operation</h2><br>
            <form name="planter_calculator" id="planter_calculator" action="" method="post">
                <div class="row align-items-start">
                    <div class="col-12 col-md-4 col-lg-6 col-xl-4">
                        <select class="form-control" name="rowNo" id=rowNo"">
                            <option value=""># Rows</option>
                            <option value="12" <?php echo (isset($_POST['rowNo']) && $_POST['rowNo'] == '12') ? 'selected="selected"' : ''; ?>>12</option>
                            <option value="16" <?php echo (isset($_POST['rowNo']) && $_POST['rowNo'] == '16') ? 'selected="selected"' : ''; ?>>16</option>
                            <option value="31" <?php echo (isset($_POST['rowNo']) && $_POST['rowNo'] == '31') ? 'selected="selected"' : ''; ?>>31</option>
                            <option value="36" <?php echo (isset($_POST['rowNo']) && $_POST['rowNo'] == '36') ? 'selected="selected"' : ''; ?>>36</option>
                        </select>
                        <p>Number of Rows</p>
                    </div>
                    <div class="col-12 col-md-4 col-lg-6 col-xl-4">
                        <select class="form-control form-control-default" name="currentspacing" id="currentspacing">
                            <option value="">Spacing</option>
                            <option value="20" <?php echo (isset($_POST['currentspacing']) && $_POST['currentspacing'] == '20') ? 'selected="selected"' : ''; ?>>20</option>
                            <option value="30" <?php echo (isset($_POST['currentspacing']) && $_POST['currentspacing'] == '30') ? 'selected="selected"' : ''; ?>>30</option>
                        </select>
                        <p>Spacing</p>
                    </div>
                    <div class="col-12 col-md-4 col-lg-6 col-xl-4">
                        <select class="form-control form-control-default" id="averageSpeed" name="averageSpeed">
                            <option value="3.5" <?php echo (isset($_POST['averageSpeed']) && $_POST['averageSpeed'] == '3.5') ? 'selected="selected"' : ''; ?>>3.5</option>
                            <option value="4.0" <?php echo (isset($_POST['averageSpeed']) && $_POST['averageSpeed'] == '4.0') ? 'selected="selected"' : ''; ?>>4.0</option>
                            <option selected="selected" value="4.5" <?php echo (isset($_POST['averageSpeed']) && $_POST['averageSpeed'] == '4.5') ? 'selected="selected"' : ''; ?>>4.5</option>
                            <option value="5.0" <?php echo (isset($_POST['averageSpeed']) && $_POST['averageSpeed'] == '5.0') ? 'selected="selected"' : ''; ?>>5.0</option>
                            <option value="5.5" <?php echo (isset($_POST['averageSpeed']) && $_POST['averageSpeed'] == '5.5') ? 'selected="selected"' : ''; ?>>5.5</option>
                            <option value="6.0" <?php echo (isset($_POST['averageSpeed']) && $_POST['averageSpeed'] == '6.0') ? 'selected="selected"' : ''; ?>>6.0</option>
                            <option value="6.5" <?php echo (isset($_POST['averageSpeed']) && $_POST['averageSpeed'] == '6.5') ? 'selected="selected"' : ''; ?>>6.5</option>
                            <option value="7.0" <?php echo (isset($_POST['averageSpeed']) && $_POST['averageSpeed'] == '7.0') ? 'selected="selected"' : ''; ?>>7.0</option>
                            <option value="7.5" <?php echo (isset($_POST['averageSpeed']) && $_POST['averageSpeed'] == '7.5') ? 'selected="selected"' : ''; ?>>7.5</option>
                            <option value="8.0" <?php echo (isset($_POST['averageSpeed']) && $_POST['averageSpeed'] == '8.0') ? 'selected="selected"' : ''; ?>>8.0</option>
                            <option value="8.5" <?php echo (isset($_POST['averageSpeed']) && $_POST['averageSpeed'] == '8.5') ? 'selected="selected"' : ''; ?>>8.5</option>
                            <option value="9.0" <?php echo (isset($_POST['averageSpeed']) && $_POST['averageSpeed'] == '9.0') ? 'selected="selected"' : ''; ?>>9.0</option>
                            <option value="9.5" <?php echo (isset($_POST['averageSpeed']) && $_POST['averageSpeed'] == '9.5') ? 'selected="selected"' : ''; ?>>9.5</option>
                            <option value="10.0" <?php echo (isset($_POST['averageSpeed']) && $_POST['averageSpeed'] == '10.0') ? 'selected="selected"' : ''; ?>>10.0</option>
                            <option value="10.5" <?php echo (isset($_POST['averageSpeed']) && $_POST['averageSpeed'] == '10.5') ? 'selected="selected"' : ''; ?>>10.5</option>

                        </select>
                        <p>Average Speed</p>

                    </div>

                    <div class="col-12 col-md-4 col-lg-6 col-xl-4">
                        <select class="form-control form-control-default" name="timeDrop" id="timeDrop" >
                            <option value=".70" <?php echo (isset($_POST['timeDrop']) && $_POST['timeDrop'] == '70%') ? 'selected="selected"' : ''; ?>>70%</option>
                            <option selected="selected" value=".75" <?php echo (isset($_POST['timeDrop']) && $_POST['timeDrop'] == '75%') ? 'selected="selected"' : ''; ?>>75%</option>
                            <option value=".80" <?php echo (isset($_POST['timeDrop']) && $_POST['timeDrop'] == '80%') ? 'selected="selected"' : ''; ?>>80%</option>
                            <option value=".85" <?php echo (isset($_POST['timeDrop']) && $_POST['timeDrop'] == '85%') ? 'selected="selected"' : ''; ?>>85%</option>
                            <option value=".90" <?php echo (isset($_POST['timeDrop']) && $_POST['timeDrop'] == '90%') ? 'selected="selected"' : ''; ?>>90%</option>
                            <option value=".95" <?php echo (isset($_POST['timeDrop']) && $_POST['timeDrop'] == '95%') ? 'selected="selected"' : ''; ?>>95%</option>
                            <option value="1.0" <?php echo (isset($_POST['timeDrop']) && $_POST['timeDrop'] == '100%') ? 'selected="selected"' : ''; ?>>100%</option>
                        </select>
                        <p>% of Time Dropping Seed</p>
                    </div>
                    <div class="col-12 col-md-4 col-lg-6 col-xl-4">
                        <input type="text" class="form-control" id="acres" name="acres" value="<?php if(isset($_POST['acres'])) { echo $_POST['acres']; }?>">
                        <p>Acres</p>
                    </div>
                    <div class="col-12 col-md-4 col-lg-6 col-xl-4">
                        <input type="text" class="form-control" id="hoursWorked" name="hoursWorked" value="<?php if(isset($_POST['hoursWorked'])) { echo $_POST['hoursWorked']; }?>">
                        <p># of Hours Worked in a Day</p>
                    </div>

                </div>

                <br>
                <h2 style="text-transform: none">ExactEmerge Planting Operation</h2><br>

                <div class="row">
                    <div class="col-12 col-md-4 col-lg-6 col-xl-4">

                        <select class="form-control" name="eeRowNo" id="eeRowNo">
                            <option value=""># Rows</option>
                            <option value="12" <?php echo (isset($_POST['eeRowNo']) && $_POST['eeRowNo'] == '12') ? 'selected="selected"' : ''; ?>>12</option>
                            <option value="16" <?php echo (isset($_POST['eeRowNo']) && $_POST['eeRowNo'] == '16') ? 'selected="selected"' : ''; ?>>16</option>
                            <option value="24" <?php echo (isset($_POST['eeRowNo']) && $_POST['eeRowNo'] == '24') ? 'selected="selected"' : ''; ?>>24</option>
                            <option value="31" <?php echo (isset($_POST['eeRowNo']) && $_POST['eeRowNo'] == '31') ? 'selected="selected"' : ''; ?>>31</option>
                            <option value="31" <?php echo (isset($_POST['eeRowNo']) && $_POST['eeRowNo'] == '36') ? 'selected="selected"' : ''; ?>>36</option>
                        </select>

                        <p>Number of Rows</p>
                    </div>
                    <div class="col-12 col-md-4 col-lg-6 col-xl-4">
                        <select class="form-control" name="eeSpacing" id="eeSpacing">
                            <option value="">Spacing</option>
                            <option value="20" <?php echo (isset($_POST['eeSpacing']) && $_POST['eeSpacing'] == '20') ? 'selected="selected"' : ''; ?>>20</option>
                            <option value="30" <?php echo (isset($_POST['eeSpacing']) && $_POST['eeSpacing'] == '30') ? 'selected="selected"' : ''; ?>>30</option>
                        </select>
                        <p>Spacing</p>
                    </div>
                    <div class="col-12 col-md-4 col-lg-6 col-xl-4">
                        <select class="form-control form-control-default" id="eeAverageSpeed" name="eeAverageSpeed">
                            <option value="3.5" <?php echo (isset($_POST['eeAverageSpeed']) && $_POST['eeAverageSpeed'] == '3.5') ? 'selected="selected"' : ''; ?>>3.5</option>
                            <option value="4.0" <?php echo (isset($_POST['eeAverageSpeed']) && $_POST['eeAverageSpeed'] == '4.0') ? 'selected="selected"' : ''; ?>>4.0</option>
                            <option value="4.5" <?php echo (isset($_POST['eeAverageSpeed']) && $_POST['eeAverageSpeed'] == '4.5') ? 'selected="selected"' : ''; ?>>4.5</option>
                            <option value="5.0" <?php echo (isset($_POST['eeAverageSpeed']) && $_POST['eeAverageSpeed'] == '5.0') ? 'selected="selected"' : ''; ?>>5.0</option>
                            <option value="5.5" <?php echo (isset($_POST['eeAverageSpeed']) && $_POST['eeAverageSpeed'] == '5.5') ? 'selected="selected"' : ''; ?>>5.5</option>
                            <option value="6.0" <?php echo (isset($_POST['eeAverageSpeed']) && $_POST['eeAverageSpeed'] == '6.0') ? 'selected="selected"' : ''; ?>>6.0</option>
                            <option value="6.5" <?php echo (isset($_POST['eeAverageSpeed']) && $_POST['eeAverageSpeed'] == '6.5') ? 'selected="selected"' : ''; ?>>6.5</option>
                            <option value="7.0" <?php echo (isset($_POST['eeAverageSpeed']) && $_POST['eeAverageSpeed'] == '7.0') ? 'selected="selected"' : ''; ?>>7.0</option>
                            <option value="7.5" <?php echo (isset($_POST['eeAverageSpeed']) && $_POST['eeAverageSpeed'] == '7.5') ? 'selected="selected"' : ''; ?>>7.5</option>
                            <option selected="selected" value="8.0" <?php echo (isset($_POST['eeAverageSpeed']) && $_POST['eeAverageSpeed'] == '8.0') ? 'selected="selected"' : ''; ?>>8.0</option>
                            <option value="8.5" <?php echo (isset($_POST['eeAverageSpeed']) && $_POST['eeAverageSpeed'] == '8.5') ? 'selected="selected"' : ''; ?>>8.5</option>
                            <option value="9.0" <?php echo (isset($_POST['eeAverageSpeed']) && $_POST['eeAverageSpeed'] == '9.0') ? 'selected="selected"' : ''; ?>>9.0</option>
                            <option value="9.5" <?php echo (isset($_POST['eeAverageSpeed']) && $_POST['eeAverageSpeed'] == '9.5') ? 'selected="selected"' : ''; ?>>9.5</option>
                            <option value="10.0" <?php echo (isset($_POST['eeAverageSpeed']) && $_POST['eeAverageSpeed'] == '10.0') ? 'selected="selected"' : ''; ?>>10.0</option>
                            <option value="10.5" <?php echo (isset($_POST['eeAverageSpeed']) && $_POST['eeAverageSpeed'] == '10.5') ? 'selected="selected"' : ''; ?>>10.5</option>

                        </select>
                        <p>Average Speed</p>

                    </div>
                    <div class="col-12 col-md-4 col-lg-6 col-xl-4">
                        <select class="form-control form-control-default" name="eeTimeDrop" id="eeTimeDrop" >
                            <option value=".70" <?php echo (isset($_POST['eeTimeDrop']) && $_POST['eeTimeDrop'] == '70%') ? 'selected="selected"' : ''; ?>>70%</option>
                            <option value=".75" selected="selected"<?php echo (isset($_POST['eeTimeDrop']) && $_POST['eeTimeDrop'] == '75%') ? 'selected="selected"' : ''; ?>>75%</option>
                            <option value=".80" <?php echo (isset($_POST['eeTimeDrop']) && $_POST['eeTimeDrop'] == '80%') ? 'selected="selected"' : ''; ?>>80%</option>
                            <option value=".85" <?php echo (isset($_POST['eeTimeDrop']) && $_POST['eeTimeDrop'] == '85%') ? 'selected="selected"' : ''; ?>>85%</option>
                            <option value=".90" <?php echo (isset($_POST['eeTimeDrop']) && $_POST['eeTimeDrop'] == '90%') ? 'selected="selected"' : ''; ?>>90%</option>
                            <option value=".95" <?php echo (isset($_POST['eeTimeDrop']) && $_POST['eeTimeDrop'] == '95%') ? 'selected="selected"' : ''; ?>>95%</option>
                            <option value="1.0" <?php echo (isset($_POST['eeTimeDrop']) && $_POST['eeTimeDrop'] == '100%') ? 'selected="selected"' : ''; ?>>100%</option>
                        </select>
                        <p>% of Time Dropping Seed</p>
                    </div>
                    <div class="col-12 col-md-4 col-lg-6 col-xl-4">
                        <input type="text" class="form-control" id="eeAcres" name="eeAcres" value="<?php if(isset($_POST['eeAcres'])) { echo $_POST['eeAcres']; }?>">
                        <p>Acres</p>
                    </div>
                    <div class="col-12 col-md-4 col-lg-6 col-xl-4">
                        <input type="text" class="form-control" id="eeHoursWorked" name="eeHoursWorked" value="<?php if(isset($_POST['eeHoursWorked'])) { echo $_POST['eeHoursWorked']; }?>">
                        <p># of Hours Worked in a Day</p>
                    </div>

                </div>
                <div class="col-12">

                    <button class="btn btn-success" type="submit" name="submit">Find Out the Difference</button>
                    <button class="btn btn-success" type="button" name="irhd" value="Clear Form" onclick="clearForm(this.form);" style="background: #dc3545; border-color: #dc3545;">Clear Form</button>

                </div>

            </form>

        </div>
        <div class="col-lg-4" style="margin-top: 50px; border: 2px solid green; border-radius: 7px; background: #ECEEEF;">
            <p style="text-transform: none"><b>Current Planting Operation</b></p>
            <h1><?php echo number_format(round($planterAcresPerHour)); ?></h1>
            <p>Current Acres per Hour</p>
            <p style="text-transform: none"><b>ExactEmerge Planting Operation</b></p>
            <h1><?php echo number_format(round($eeAcresPerHour)); ?></h1>
            <p>ExactEmerge Acres per Hour</p>
        </div>
    </div>
    <div class="clearfix"></div>


</div>
