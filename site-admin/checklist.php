<?php include('inc/header.php'); ?>
<link rel="stylesheet" href="assets/css/checklistStyles.css"/>
<!-- Begin page -->
<div id="wrapper">

    <?php include('inc/topnav.php'); ?>


    <?php include('inc/sidebarnav.php'); ?>

    <!-- Top Bar Start -->



    <?php include('inc/sidebarnav.php'); ?>


    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <ul class="nav nav-tabs mx-auto checklist-navbar">
                    <li class="nav-item"><a class="nav-link navig-tab active" data-toggle="tab" href="#pre-launch">PreLaunch</a></li>
                    <li class="nav-item"><a class="nav-link navig-tab " data-toggle="tab" href="#technical-seo">Technical SEO</a></li>
                    <li class="nav-item"><a class="nav-link navig-tab " data-toggle="tab" href="#onpage-seo">OnPage SEO</a></li>
                    <li class="nav-item"><a class="nav-link navig-tab " data-toggle="tab" href="#offpage-seo">Off Page SEO</a></li>
                </ul>
                <div>
                    <?php
                    include('inc/harness.php');
                    $authCredentails = $site->auth();
                    $userEdited = $authCredentails["profileId"];
                    $a = $data->query("SELECT fname FROM caffeine_users WHERE id = '$userEdited'");
                    if ($a->num_rows > 0) {
                        $b = $a->fetch_array();
                    }
                    
                    function getChecklistData($tableName)
                    {
                        include('inc/harness.php');
                        $listData = array();
                        $listQuery = $data->query("SELECT * FROM " . $tableName);
                        while ($listQ = $listQuery->fetch_array()) {
                            $listData[] = array("id" => $listQ["id"], "checked" => $listQ["checked"], "taskTitle" => $listQ["taskTitle"], "taskDesc" => $listQ["taskDesc"], "resources" => $listQ["resources"], "completedBy" => $listQ["completedBy"], "checkedOutOn" => $listQ["checkedOutOn"], "workingOnIt" => $listQ["workingOnIt"]);
                        }
                        return $listData;
                    }
                    
                    function updateCheckboxData($table, $checkboxVal, $id){
                        include('inc/harness.php');
                        global $b;
                        date_default_timezone_set('America/Chicago');
                        $data->query("UPDATE ".$table." SET checked = '".$checkboxVal."', completedBy = '".$b['fname']."', checkedOutOn = '".date("Y-m-d h:i:sa")."' WHERE id = $id");
                    }
                    ?>
                </div>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="pre-launch" role="tabpanel" aria-labelledby="pre-launch-tab">
                        <div class="checklist-container active">
                            <div class="checklist-wrapper">
                                <table class="checklist-table">
                                    <thead class="checklist-thead">
                                        <tr class="checklist-thead-tr">
                                            <th>Check/Uncheck</th>
                                            <th>Task</th>
                                            <th>Completed By</th>
                                            <th>Checked Out On</th>
                                            <th>Working on it</th>
                                        </tr>
                                    </thead>
                                    <tbody class="checklist-tbody">
                                    <?php
                                        $itemCheckedPreLaunch = "";
                                        $preLaunchLists = getChecklistData('preLaunchChecklist');
                                        foreach ($preLaunchLists as $preLaunchList) {
                                            if($preLaunchList["checked"] == "true"){
                                                $itemCheckedPreLaunch = "checked";
                                            }else{
                                                $itemCheckedPreLaunch = "";
                                            }
                                            $htmlpreLaunch .= '<tr class="checklist-tbody-tr">
                                            <td class="checklist-tbody-td-checkbox"><input id = "checkboxValue'.$preLaunchList["id"].'" type="checkbox" OnClick="checkboxClicked('.$preLaunchList["id"].','."'preLaunchChecklist'".')" '.$itemCheckedPreLaunch.'></td>

                                            <td class="checklist-tbody-td-task">
                                                <h4>' . $preLaunchList["taskTitle"] . '</h4>
                                                <p>' . $preLaunchList["taskDesc"] . '</p>'.$preLaunchList["resources"].'
                                            </td>
                                            <td class="checklist-tbody-td-completed-by">' . $preLaunchList["completedBy"] . '</td>
                                            <td class="checklist-tbody-td-checkedout-on">' . $preLaunchList["checkedOutOn"] . '</td>
                                            <td><form onsubmit="UserWorkingValueUpdate('.$preLaunchList["id"].','."'preLaunchChecklist'".'); return false">
                                            <input type="text" name="userName" placeholder="Enter your name" id="userNamepreLaunchChecklist'.$preLaunchList["id"].'">
                                            <input type="submit" value="submit" name="submit"><br>
                                            <div id="responsepreLaunchChecklist'.$preLaunchList["id"].'">'. $preLaunchList["workingOnIt"] .'</div>
                                        </form></td>
                                        </tr>';
                                        }
                                        echo $htmlpreLaunch;
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="technical-seo" role="tabpanel" aria-labelledby="technical-seo-tab">
                        <div class="checklist-container">
                            <div class="checklist-wrapper">
                                <table class="checklist-table">
                                    <thead class="checklist-thead">
                                        <tr class="checklist-thead-tr">
                                            <th>Check/Uncheck</th>
                                            <th>Task</th>
                                            <th>Completed By</th>
                                            <th>Checked Out On</th>
                                            <th>Working on it</th>
                                        </tr>
                                    </thead>
                                    <tbody class="checklist-tbody">
                                    <?php
                                        $itemCheckedTechSEO = "";
                                        $technicalSEOLists = getChecklistData('technicalSEO');
                                        foreach ($technicalSEOLists as $technicalSEOList) {
                                            if($technicalSEOList["checked"] == "true"){
                                                $itemCheckedTechSEO = "checked";
                                            }else{
                                                $itemCheckedTechSEO = "";
                                            }
                                            $htmlTechSEO .= '<tr class="checklist-tbody-tr">
                                            <td class="checklist-tbody-td-checkbox"><input id = "checkboxValue'.$technicalSEOList["id"].'" type="checkbox" OnClick="checkboxClicked('.$technicalSEOList["id"].','."'technicalSEO'".')" '.$itemCheckedTechSEO.'></td>

                                            <td class="checklist-tbody-td-task">
                                                <h4>' . $technicalSEOList["taskTitle"] . '</h4>
                                                <p>' . $technicalSEOList["taskDesc"] . '</p>'.$technicalSEOList["resources"].'
                                            </td>
                                            <td class="checklist-tbody-td-completed-by">' . $technicalSEOList["completedBy"] . '</td>
                                            <td class="checklist-tbody-td-checkedout-on">' . $technicalSEOList["checkedOutOn"] . '</td>
                                            <td><form onsubmit="UserWorkingValueUpdate('.$technicalSEOList["id"].','."'technicalSEO'".'); return false">
                                            <input type="text" name="userName" placeholder="Enter your name" id="userNametechnicalSEO'.$technicalSEOList["id"].'">
                                            <input type="submit" value="submit" name="submit"><br>
                                            <div id="responsetechnicalSEO'.$technicalSEOList["id"].'">'. $technicalSEOList["workingOnIt"] .'</div>
                                        </form></td>
                                        </tr>';
                                        }
                                        echo $htmlTechSEO;
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="onpage-seo" role="tabpanel" aria-labelledby="onpage-seo-tab">
                        <div class="checklist-container">
                            <div class="checklist-wrapper">
                                <table class="checklist-table">
                                    <thead class="checklist-thead">
                                        <tr class="checklist-thead-tr">
                                            <th>Check/Uncheck</th>
                                            <th>Task</th>
                                            <th>Completed By</th>
                                            <th>Checked Out On</th>
                                            <th>Working on it</th>
                                        </tr>
                                    </thead>
                                    <tbody class="checklist-tbody">
                                    <?php
                                        $itemCheckedOnPageSEO = "";
                                        $onPageSEOLists = getChecklistData('onPageSEO');
                                        foreach ($onPageSEOLists as $onPageSEOList) {
                                            if($onPageSEOList["checked"] == "true"){
                                                $itemCheckedOnPageSEO = "checked";
                                            }else{
                                                $itemCheckedOnPageSEO = "";
                                            }
                                            $htmlOnPageSEO .= '<tr class="checklist-tbody-tr">
                                            <td class="checklist-tbody-td-checkbox"><input id = "checkboxValue'.$onPageSEOList["id"].'" type="checkbox" OnClick="checkboxClicked('.$onPageSEOList["id"].','."'onPageSEO'".')" '.$itemCheckedOnPageSEO.'></td>

                                            <td class="checklist-tbody-td-task">
                                                <h4>' . $onPageSEOList["taskTitle"] . '</h4>
                                                <p>' . $onPageSEOList["taskDesc"] . '</p>'.$onPageSEOList["resources"].'
                                            </td>
                                            <td class="checklist-tbody-td-completed-by">' . $onPageSEOList["completedBy"] . '</td>
                                            <td class="checklist-tbody-td-checkedout-on">' . $onPageSEOList["checkedOutOn"] . '</td>
                                            <td><form onsubmit="UserWorkingValueUpdate('.$onPageSEOList["id"].','."'onPageSEO'".'); return false">
                                            <input type="text" name="userName" placeholder="Enter your name" id="userNameonPageSEO'.$onPageSEOList["id"].'">
                                            <input type="submit" value="submit" name="submit"><br>
                                            <div id="responseonPageSEO'.$onPageSEOList["id"].'">'. $onPageSEOList["workingOnIt"] .'</div>
                                        </form></td>
                                        </tr>';
                                        }
                                        echo $htmlOnPageSEO;                                
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="offpage-seo" role="tabpanel" aria-labelledby="offpage-seo-tab">
                        <div class="checklist-container">
                            <div class="checklist-wrapper">
                                <table class="checklist-table">
                                    <thead class="checklist-thead">
                                        <tr class="checklist-thead-tr">
                                            <th>Check/Uncheck</th>
                                            <th>Task</th>
                                            <th>Completed By</th>
                                            <th>Checked Out On</th>
                                            <th>Working on it</th>
                                        </tr>
                                    </thead>
                                    <tbody class="checklist-tbody">
                                    <?php
                                        $itemCheckedOffPage = "";
                                        $offPageSEOLists = getChecklistData('offPageSEO');
                                        foreach ($offPageSEOLists as $offPageSEOList) {
                                            if($offPageSEOList["checked"] == "true"){
                                                $itemCheckedOffPage = "checked";
                                            }else{
                                                $itemCheckedOffPage = "";
                                            }
                                            $htmloffPageSEO .= '<tr class="checklist-tbody-tr">
                                            <td class="checklist-tbody-td-checkbox"><input id = "checkboxValue'.$offPageSEOList["id"].'" type="checkbox" OnClick="checkboxClicked('.$offPageSEOList["id"].','."'offPageSEO'".')" '.$itemCheckedOffPage.'></td>

                                            <td class="checklist-tbody-td-task">
                                                <h4>' . $offPageSEOList["taskTitle"] . '</h4>
                                                <p>' . $offPageSEOList["taskDesc"] . '</p>'.$offPageSEOList["resources"].'
                                            </td>
                                            <td class="checklist-tbody-td-completed-by">' . $offPageSEOList["completedBy"] . '</td>
                                            <td class="checklist-tbody-td-checkedout-on">' . $offPageSEOList["checkedOutOn"] . '</td>
                                            <td><form onsubmit="UserWorkingValueUpdate('.$offPageSEOList["id"].','."'offPageSEO'".'); return false">
                                                <input type="text" name="userName" placeholder="Enter your name" id="userNameoffPageSEO'.$offPageSEOList["id"].'">
                                                <input type="submit" value="submit" name="submit"><br>
                                                <div id="responseoffPageSEO'.$offPageSEOList["id"].'">'. $offPageSEOList["workingOnIt"] .'</div>
                                            </form></td>
                                        </tr>';
                                        }
                                        echo $htmloffPageSEO;
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end container-fluid -->
            <div id="testContent"></div>
            <?php include('inc/footer.php'); ?>
        </div><!-- end content -->

    </div><!-- end content-page -->

    <script src="assets/js/popper.min.js"></script><!-- Popper for Bootstrap -->
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/detect.js"></script>
    <script src="assets/js/fastclick.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/jquery.blockUI.js"></script>
    <script src="assets/js/waves.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="plugins/switchery/switchery.min.js"></script>
    <script src="plugins/sweet-alert/sweetalert2.min.js"></script>
    <script src="assets/pages/jquery.sweet-alert.init.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

    <!-- Required datatable js -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Buttons examples -->

    <!-- Key Tables -->
    <script src="plugins/datatables/dataTables.keyTable.min.js"></script>

    <!-- Responsive examples -->
    <script src="plugins/datatables/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables/responsive.bootstrap4.min.js"></script>

    <!-- Selection table -->
    <script src="plugins/datatables/dataTables.select.min.js"></script>


    <script src="assets/js/pace.min.js"></script>
    <!-- Custom main Js -->
    <script src="assets/js/jquery.core.js"></script>
    <script src="assets/js/jquery.app.js"></script>
    <script>
        $(function() {

            $(".selection").on('click', function() {
                var vals = $(this).val();
                if (vals == 'content') {
                    $("#bean-content-holder").show();
                    $("#bean-install-holder").hide();
                }

                if (vals == 'real_bean') {
                    $("#bean-install-holder").show();
                    $("#bean-content-holder").hide();
                }
            })

            $('input[type=file]').change(function(e) {
                var str = $(this).val();
                var result = str.split('\\').pop();
                $(".progress-filename").html(result);


            });
        })

        $(function($, window, undefined) {
            //is onprogress supported by browser?
            var hasOnProgress = ("onprogress" in $.ajaxSettings.xhr());

            //If not supported, do nothing
            if (!hasOnProgress) {
                return;
            }

            //patch ajax settings to call a progress callback
            var oldXHR = $.ajaxSettings.xhr;
            $.ajaxSettings.xhr = function() {
                var xhr = oldXHR.apply(this, arguments);
                if (xhr instanceof window.XMLHttpRequest) {
                    xhr.addEventListener('progress', this.progress, false);
                }

                if (xhr.upload) {
                    xhr.upload.addEventListener('progress', this.progress, false);
                }

                return xhr;
            };
        });

         function checkboxClicked(row_id, table_name){
            console.log(row_id);
             $.ajax({
                url:'checklist-ajax.php?action=getRowVal&row_id='+row_id+'&table_name='+table_name,
                success:function(data){
                     $("#testContent").html(data);
                 }
             });
            
         }
         
        window.checkboxClicked= checkboxClicked;

        function UserWorkingValueUpdate(row_id, table_name){
            var userName = $('#userName'+(table_name)+(row_id)).val();
            $.ajax({
                    url:'checklist-ajax.php?action=userWorking&row_id='+row_id+'&table_name='+table_name+'&userName='+userName,
                    success:function(data){
                    $('#response'+(table_name)+(row_id)).html(data);
                 }
                });
                return false;   
        } 
    </script>
    </body>

    </html>