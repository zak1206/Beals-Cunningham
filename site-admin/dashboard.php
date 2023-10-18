<?php include('inc/header.php'); ?>

<!-- Begin page -->
<div id="wrapper">

    <?php include('inc/topnav.php'); ?>


    <?php include('inc/sidebarnav.php'); ?>

            <!-- Top Bar Start -->



            <?php include('inc/sidebarnav.php'); ?>



    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Data Caffeine Track</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    NOTICE! To use in system conversion tracking via "Data Attributes Class" field below, copy and paste the following: data-cafftrak='Your Value' Do not use double quotes to wrap value. Only excepts single quotes.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container-fluid">

                        <!-- Page-Title -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="page-title-box">
                                    <?php include('inc/welcomears.php'); ?>
                                    <ol class="breadcrumb float-right">
                                        <li class="breadcrumb-item active">Dashboard</li>
                                    </ol>

                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 col-xl-4">
                                <div class="widget-simple-chart text-right card-box">
                                    <i style="font-size: 40px; float: left" class="ti-server tp-ico-media"></i>
                                    <h3 class="text-success counter m-t-10">Media</h3>
                                    <a href="media.php" class="text-muted text-nowrap m-b-10">Go to Media Manager</a>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xl-4">
                                <div class="widget-simple-chart text-right card-box">
                                    <i class="ti-notepad tp-ico-pages" style="font-size: 40px; float: left"></i>
                                    <h3 class="text-primary counter m-t-10">Pages</h3>
                                    <a href="pages.php" class="text-muted text-nowrap m-b-10">View Site Pages</a>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xl-4">
                                <div class="widget-simple-chart text-right card-box">
                                    <i class="ti-comment tp-ico-messages" style="font-size: 40px; float: left"></i>
                                    <h3 class="text-pink m-t-10"> <span class="counter">System Messages</span></h3>
                                    <a href="site-forms.php" class="text-muted text-nowrap m-b-10">Systems messages</a>
                                </div>
                            </div>

                        </div>
                        <!-- end row -->





                        <div class="row">

                            <div class="col-xl-6">
                                <div class="card-box" style="">
                                    <h4 class="text-dark  header-title m-t-0" style="margin-bottom: 0">Popular Pages</h4>
                                    <small>Shows up to 6 of your sites popular pages.</small>
                                    <br><br>

                                    <canvas id="myChart"></canvas>

                                </div>

                            </div>

                            <div class="col-xl-6">
                                <div class="card-box" style="">
                                    <h4 class="text-dark  header-title m-t-0" style="margin-bottom: 0">Object Event Tracking</h4>
                                    <small>Shows object click conversion data. | <a style="color: #2acaff; font-weight:bold" href="#" data-toggle="modal" data-target="#exampleModal"><i class="ti-info-alt"></i> Usage Instructions</a></small>
                                    <br><br>

                                    <canvas id="myChart4"></canvas>

                                </div>

                            </div>

                        </div>

                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card-box">
                                    <h4 class="text-dark header-title m-t-0" style="margin-bottom: 0">Site Visitors</h4>
                                    <small>Overview of site visits by unique visitors and returning visitors.</small>
                                    <br><br>
                                    <canvas id="myChart2"></canvas>
                                </div>

                            </div>

                            <div class="col-xl-6">
                                <div class="card-box">
                                    <h4 class="text-dark header-title m-t-0" style="margin-bottom: 0">Site Visits</h4>
                                    <small>View of last 6 days of site traffic.</small>
                                    <br><br>
                                    <canvas id="myChart3"></canvas>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card-box">
                                    <h4 class="text-dark header-title m-t-0" style="margin-bottom: 0">Visitors Data</h4>
                                    <small>Light traffic analysis.</small>
                                    <span style="max-width: 200px; float:right;">
                                        Last 12 Days of User Data.
                                    </span>
                                    <br><br>

                                    <div class="analytics-set" style="height: 393px;overflow-y: scroll;">

                                        <div id="accordion">


                                            <?php
                                            $userSets = $site->getUserAnalytics();


                                            for($i=0; $i < count($userSets); $i++){
                                                $analyti .= '<div class="card" style="border: solid thin #fff; border-radius: 0">
                                                <div class="card-header" id="headingTwo" style="background: #F9CD46">
                                                    <h5 class="mb-0">
                                                        <button style="color: #525252; font-weight:bold" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse'.$i.'" aria-expanded="true" aria-controls="collapse'.$i.'">
                                                            '.$userSets[$i]["country"].' - Total Visits '.$userSets[$i]["totalcount"].'
                                                        </button>
                                                    </h5>
                                                </div>
                                                <div id="collapse'.$i.'" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion">
                                                    <div class="card-body">
                                                        <ul>
                                                            <table class="table">
                                                                <thead>
                                                                    <tr class="table-warning">
                                                                        <th>State</th>
                                                                        <th>Visits</th>
                                                                    </tr>
                                                                </thead>';

                                                $statesData = $userSets[$i]["states_data"];

                                                for($j=0; $j < count($statesData); $j++){
                                                    $analyti .= '<tr>
                                                                    <td>'.$statesData[$j]["state"].'</td>
                                                                    <td>'.$statesData[$j]["hitcount"].'</td>
                                                                </tr>';
                                                }


                                                $analyti .='</table>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>';
                                            }

                                            echo $analyti;

                                            ?>

                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>



                    </div>
                    <!-- end container -->
                </div>
                <!-- end content -->

                <?php include('inc/footer.php'); ?>

            </div>


        </div>
        <!-- END wrapper -->



        <script>
            var resizefunc = [];
        </script>

<!-- Plugins  -->
<script src="assets/js/jquery.min.js"></script>
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

<!-- Counter Up  -->
<script src="plugins/waypoints/lib/jquery.waypoints.min.js"></script>
<script src="plugins/counterup/jquery.counterup.min.js"></script>

<!-- circliful Chart -->
<script src="plugins/jquery-circliful/js/jquery.circliful.min.js"></script>
<script src="plugins/jquery-sparkline/jquery.sparkline.min.js"></script>

<!-- skycons -->
<script src="plugins/skyicons/skycons.min.js" type="text/javascript"></script>

<!-- Page js  -->
<script src="assets/pages/jquery.dashboard.js"></script>

<!-- Custom main Js -->
<script src="assets/js/jquery.core.js"></script>
<script src="assets/js/jquery.app.js"></script>

<?php


$waves = $site->returnDates();

$datesLine = json_encode($waves["dates"]);

$datesLine = rtrim($datesLine,'"');
$datesLine = ltrim($datesLine,'"');

echo $datesLine;
$datesHits = json_encode($waves["hits"]);
$datesHits = rtrim($datesHits,'"');
$datesHits = ltrim($datesHits,'"');


$pageBarData = $site->pageViews();
for($i=0; $i< count($pageBarData); $i++){
    if($i<6) {
        $barPage[] = $pageBarData[$i]["page"];
    }
}

for($j=0; $j< count($pageBarData); $j++){
    if($j<6) {
        $barPageNum[] = $pageBarData[$j]["page_hits"];
    }
}

$pagesBars =  json_encode($barPage);
$pageHits = json_encode($barPageNum);

$pieChart = $site->getPageviews();
$new = $pieChart["new_visits"];
$returning = $pieChart["returning"];

$newout = $returning/$new*100;

$old = 100 - $newout;

$olds = round($newout);
$news = round($old);

?>

<script>

    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo $pagesBars; ?>,
            datasets: [{
                label: 'Popular Pages',
                data: <?php echo $pageHits; ?>,
                backgroundColor: [
                    'rgba(242, 73, 72, 0.7)',
                    'rgba(242, 123, 80, 0.7)',
                    'rgba(242, 202, 91, 0.7)',
                    'rgba(242, 230, 193, 0.7)',
                    'rgba(201, 201, 90, 0.7)',
                    'rgba(255, 159, 64, 0.7)'
                ],
                borderColor: [
                    'rgba(242, 73, 72, 1)',
                    'rgba(242, 123, 80, 1)',
                    'rgba(242, 202, 91, 1)',
                    'rgba(242, 230, 193, 1)',
                    'rgba(201, 201, 90, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    // And for a doughnut chart
    var ctx2 = document.getElementById('myChart2').getContext('2d');
    var myDoughnutChart = new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: ['New Users', 'Returning Visitors'],
            datasets: [{
                data: [<?php echo $news; ?>, <?php echo $olds; ?>],
                backgroundColor: [
                    'rgba(242, 202, 91, 0.7)',
                    'rgba(242, 230, 193, 0.7)'
                ],
                borderColor: [
                    'rgba(242, 202, 91, 1)',
                    'rgba(242, 230, 193, 1)',
                ],
                borderWidth: 1
            }]
        },
    });



    var ctx3 = document.getElementById('myChart3').getContext('2d');
    var myChart = new Chart(ctx3, {
        type: 'line',
        data: {
            labels: [<?php echo stripcslashes($datesLine); ?>],
            datasets: [{
                label: 'Site Visits',
                data: [<?php echo stripcslashes($datesHits); ?>],
                backgroundColor: [
                    'rgba(242, 73, 72, 0.7)',
                ],
            }],

        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });

    <?php
    $dataPoints = $site->getCaffDataEvents();

    for($i=0; $i< count($dataPoints); $i++){
        if($i<10) {
            $dataNames[] = $dataPoints[$i]["target"];
        }
    }

    for($i=0; $i< count($dataPoints); $i++){
        if($i<10) {
            $dataCounts[] = $dataPoints[$i]["hits"];
        }
    }

    $targetNames = json_encode($dataNames);
    $targetHits = json_encode($dataCounts);

    echo $targetHits;
    ?>

    // And for a doughnut chart
    var ctx4 = document.getElementById('myChart4').getContext('2d');
    var myDoughnutChart = new Chart(ctx4, {
        type: 'polarArea',
        data: {
            labels: <?php echo $targetNames; ?>,
            datasets: [{
                data: <?php echo $targetHits; ?>,
                backgroundColor: [
                    'rgba(242, 202, 91, 0.7)',
                    'rgba(242, 230, 193, 0.7)',
                    'rgba(242, 123, 80, 0.7)',
                    'rgba(242, 202, 91, 0.7)',
                    'rgba(242, 230, 193, 0.7)',
                    'rgba(242, 123, 80, 0.7)',
                    'rgba(242, 202, 91, 0.7)',
                    'rgba(242, 230, 193, 0.7)',
                    'rgba(242, 123, 80, 0.7)'
                ],
                borderColor: [
                    'rgba(242, 202, 91, 1)',
                    'rgba(242, 230, 193, 1)',
                    'rgba(242, 123, 80, 1)',
                    'rgba(242, 202, 91, 1)',
                    'rgba(242, 230, 193, 1)',
                    'rgba(242, 123, 80, 1)',
                    'rgba(242, 202, 91, 1)',
                    'rgba(242, 230, 193, 1)',
                    'rgba(242, 123, 80, 1)',
                ],
                borderWidth: 1
            }]
        },
    });

    function openDataAttusage(){
        alert('HELLO THERE')
    }
</script>


    </body>
</html>