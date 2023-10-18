<?php
include('inc/harness.php');
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- DataTables -->
    <link href="plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Multi Item Selection examples -->
    <link href="plugins/datatables/select.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <style>
        #DataTables_Table_0_filter{
            text-align: right;
        }
    </style>

    <title>Hello, world!</title>

</head>
<body>

<?php

if(isset($_REQUEST["viewtype"])) {

    if ($_REQUEST["viewtype"] == 'forms') {
        $contenView = 'false';
        $contentArs = '';
        $formView = 'true';
        $formArs = 'show active';
        $locationView = 'false';
        $locationArs = '';
    }

    if ($_REQUEST["viewtype"] == 'Locations') {
        $contenView = 'false';
        $contentArs = '';
        $formView = 'false';
        $formArs = '';
        $locationView = 'true';
        $locationArs = 'show active';

    }

    if ($_REQUEST["viewtype"] == 'Plugins') {
        $contenView = 'false';
        $contentArs = '';
        $formView = 'false';
        $formArs = '';
        $locationView = 'false';
        $locationArs = '';

    }

    if ($_REQUEST["viewtype"] == 'Menus') {
        $contenView = 'false';
        $contentArs = '';
        $formView = 'false';
        $formArs = '';
        $locationView = 'false';
        $locationArs = '';
        $menuView = 'false';
        $menuArs = 'show active';
    }
}else{
    $contenView = 'true';
    $contentArs = 'show active';
}



?>

<div class="row" style="margin:0">
    <div class="col-sm-4" style="height:400px; overflow-y:scroll ">
        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical" style="position: sticky;
  position: -webkit-sticky;
  top: 0;">
            <h3 style="margin: 20px 0;border-bottom: solid thin #efefef;padding: 10px 0;">Core Items</h3>
            <a class="nav-link <?php echo $contentArs; ?>" id="v-pills-content-tab" data-toggle="pill" href="#v-pills-content" role="tab" aria-controls="v-pills-content" aria-selected="<?php echo $contenView; ?>">Content</a>
            <a class="nav-link <?php echo $formArs; ?>" id="v-pills-forms-tab" data-toggle="pill" href="#v-pills-forms" role="tab" aria-controls="v-pills-forms" aria-selected="<?php echo $formView; ?>">Forms</a>
            <a class="nav-link <?php echo $locationArs; ?>" id="v-pills-locations-tab" data-toggle="pill" href="#v-pills-locations" role="tab" aria-controls="v-pills-locations" aria-selected="<?php echo $locationView; ?>">Locations</a>
            <a class="nav-link <?php echo $menuArs; ?>" id="v-pills-menus-tab" data-toggle="pill" href="#v-pills-menus" role="tab" aria-controls="v-pills-menus" aria-selected="<?php echo $menuView; ?>">Menus</a>
            <h3 style="margin: 20px 0;border-bottom: solid thin #efefef;padding: 10px 0;">Plugins</h3>

            <?php

                $a = $data->query("SELECT * FROM mod_tokens WHERE mod_parent != '' GROUP BY mod_parent");

                while($b = $a->fetch_array()){
                    $c = $data->query("SELECT * FROM beans WHERE id = '".$b["mod_parent"]."'");
                    $d = $c->fetch_array();

                    echo '<a class="nav-link" id="v-pills-'.$d["bean_name"].'-tab" data-toggle="pill" href="#v-pills-'.$d["bean_name"].'" role="tab" aria-controls="v-pills-'.$d["bean_name"].'" aria-selected="false">'.$d["bean_name"].'</a>';

                    $tabAreas .= '<div class="tab-pane fade show" id="v-pills-'.$d["bean_name"].'" role="tabpanel" aria-labelledby="v-pills-'.$d["bean_name"].'-tab">
                <div style="text-align: right; background: #fff;position: sticky; top: 0; z-index: 5;">
                <h2>'.$d["bean_name"].'</h2><small>Select one of the following plugin tokens and copy and paste into page areas.</small><br><hr>
                </div>
                <table class="table ousttabs">
                    <thead><tr><th>Name</th><th>Created</th><th style="text-align: right">Token</th></tr></thead>
                    <tbody>';

            $e = $data->query("SELECT * FROM mod_tokens WHERE mod_parent = '".$b["mod_parent"]."'");

            while($f = $e->fetch_array()){
                $tabAreas2 = '';
                if($f["token_name"] != ''){
                    $beanName = $f["token_name"];
                }else{
                    $beanName = 'No Name Added';
                }

                if($f["created"] != ''){
                    $created = date('m/d/Y h:i a',$f["created"]);
                }else{
                    $created = 'No Date';
                }
                $copbutton = '<div class="input-group mb-3">
  <input type="text" name="bean'.$f["id"].'" id="bean'.$f["id"].'" class="form-control" value="'.$f["the_token"].'" readonly="readonly">
  <div class="input-group-append">
    <button class="btn btn-outline-primary copybtn" type="button" data-clipboard-target="#bean'.$f["id"].'">Copy</button>
  </div>
</div>';
                $tabAreas .= '<tr><td>'.$beanName.'</td><td>'.$created.'</td><td>'.$copbutton.'</td></tr>';

            }

            //echo $tabAreas2;

            $tabAreas .= $tabAreas2;


                    $tabAreas .= '</tbody>
                </table>
            </div>';

                }

            ?>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="tab-content" id="v-pills-tabContent">
            <div class="tab-pane fade show <?php echo $contentArs; ?>" id="v-pills-content" role="tabpanel" aria-labelledby="v-pills-content-tab">
                <div style="text-align: right; background: #fff;position: sticky; top: 0; z-index: 5;">
                <h2>Content</h2><small>Select one of the following beans and copy and paste into page areas.</small><br><hr>
                </div>
                <table class="table ousttabs">
                    <thead><tr><th>Name</th><th>Category</th><th style="text-align: right">Action</th></tr></thead>
                    <tbody>
                    <?php
                        $a = $data->query("SELECT * FROM beans WHERE category != 'Modules' AND bean_type != 'eq_bean' AND active = 'true'");
                        while($b = $a->fetch_array()){
                            $copbutton = '<div class="input-group mb-3">
  <input type="text" name="bean'.$b["id"].'" id="bean'.$b["id"].'" class="form-control" value="{bean}'.$b["bean_id"].'{/bean}" readonly="readonly">
  <div class="input-group-append">
    <button class="btn btn-outline-primary copybtn" type="button" data-clipboard-target="#bean'.$b["id"].'">Copy</button>
  </div>
</div>';
                            echo '<tr><td>'.$b["bean_name"].'</td><td>'.$b["category"].'</td><td>'.$copbutton.'</td></tr>';
                        }
                    ?>
<!--                    <tr><td>Thing</td><td>Category</td><td style="text-align: right"><button class="btn btn-xs btn-primary">Copy</button></td></tr>-->
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade <?php echo $formArs; ?>" id="v-pills-forms" role="tabpanel" aria-labelledby="v-pills-forms-tab">
                <div style="text-align: right; background: #fff;position: sticky; top: 0; z-index: 5;">
                    <h2>Contact Forms</h2><small>Select one of the following form codes and copy and paste into page areas.</small><br><hr>
                </div>
                <table class="table ousttabs">
                    <thead><tr><th>Name</th><th>Subject</th><th style="text-align: right">Action</th></tr></thead>
                    <tbody>
                    <?php
                    $a = $data->query("SELECT * FROM forms_data WHERE active = 'true'");
                    while($b = $a->fetch_array()){
                        $copbutton = '<div class="input-group mb-3">
  <input type="text" name="form'.$b["id"].'" id="form'.$b["id"].'" class="form-control" value="{form}'.$b["form_name"].'{/form}" readonly="readonly">
  <div class="input-group-append">
    <button class="btn btn-outline-primary copybtn" type="button" data-clipboard-target="#form'.$b["id"].'">Copy</button>
  </div>
</div>';
                        echo '<tr><td>'.$b["form_name"].'</td><td>'.$b["subject"].'</td><td>'.$copbutton.'</td></tr>';
                    }
                    ?>
                    <!--                    <tr><td>Thing</td><td>Category</td><td style="text-align: right"><button class="btn btn-xs btn-primary">Copy</button></td></tr>-->
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade <?php echo $locationArs; ?>" id="v-pills-locations" role="tabpanel" aria-labelledby="v-pills-locations-tab">
                <div style="text-align: right; background: #fff;position: sticky; top: 0; z-index: 5;">
                    <h2>Location Tokens</h2><small>Select one of the following location tokens and copy and paste into page areas.</small><br><hr>
                </div>
                <table class="table ousttabs">
                    <thead><tr><th>Name</th><th>Subject</th><th style="text-align: right">Box Tokens</th><th>Page Tokens</th></tr></thead>
                    <tbody>
                    <?php
                    $a = $data->query("SELECT * FROM location WHERE active = 'true'");
                    while($b = $a->fetch_array()){
                        $copbutton = '<div class="input-group mb-3">
  <input type="text" name="location'.$b["id"].'" id="location'.$b["id"].'" class="form-control" value="{locsmall}'.$b["id"].'{/locsmall}" readonly="readonly">
  <div class="input-group-append">
    <button class="btn btn-outline-primary copybtn" type="button" data-clipboard-target="#location'.$b["id"].'">Copy</button>
  </div>
</div>';

                        $copbutton2 = '<div class="input-group mb-3">
  <input type="text" name="locationpage'.$b["id"].'" id="locationpage'.$b["id"].'" class="form-control" value="{locpage}'.$b["id"].'{/locpage}" readonly="readonly">
  <div class="input-group-append">
    <button class="btn btn-outline-primary copybtn" type="button" data-clipboard-target="#locationpage'.$b["id"].'">Copy</button>
  </div>
</div>';
                        echo '<tr><td>'.$b["location_name"].'</td><td>'.$b["location_address"].'</td><td>'.$copbutton.'</td><td>'.$copbutton2.'</td></tr>';
                    }
                    ?>
                    <!--                    <tr><td>Thing</td><td>Category</td><td style="text-align: right"><button class="btn btn-xs btn-primary">Copy</button></td></tr>-->
                    </tbody>
                </table>
            </div>

            <div class="tab-pane fade <?php echo $menuArs; ?>" id="v-pills-menus" role="tabpanel" aria-labelledby="v-pills-menus-tab">
                <div style="text-align: right; background: #fff;position: sticky; top: 0; z-index: 5;">
                    <h2>Menu Tokens</h2><small>Select one of the following menu tokens and copy and paste into page areas.</small><br><hr>
                </div>
                <table class="table ousttabs">
                    <thead><tr><th>Name</th><th>Menu Tokens</th></tr></thead>
                    <tbody>
                    <?php
                    $a = $data->query("SELECT * FROM navigation WHERE active = 'true'");
                    while($b = $a->fetch_array()){
                        $copbutton = '<div class="input-group mb-3">
  <input type="text" name="menu'.$b["id"].'" id="menu'.$b["id"].'" class="form-control" value="{nav}'.$b["menu_name"].'{/nav}" readonly="readonly">
  <div class="input-group-append">
    <button class="btn btn-outline-primary copybtn" type="button" data-clipboard-target="#menu'.$b["id"].'">Copy</button>
  </div>
</div>';
                        echo '<tr><td>'.$b["menu_name"].'</td><td>'.$copbutton.'</td></tr>';
                    }
                    ?>
                    <!--                    <tr><td>Thing</td><td>Category</td><td style="text-align: right"><button class="btn btn-xs btn-primary">Copy</button></td></tr>-->
                    </tbody>
                </table>
            </div>

            <?php echo $tabAreas; ?>

            <div class="tab-pane fade <?php echo $pluginArs; ?>" id="v-pills-plugins" role="tabpanel" aria-labelledby="v-pills-plugins-tab">Plugins Stuff</div>
        </div>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<!-- Required datatable js -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap4.min.js"></script>
<!-- Buttons examples -->
<script src="plugins/datatables/dataTables.buttons.min.js"></script>
<script src="plugins/datatables/buttons.bootstrap4.min.js"></script>
<script src="plugins/datatables/jszip.min.js"></script>
<script src="plugins/datatables/pdfmake.min.js"></script>
<script src="plugins/datatables/vfs_fonts.js"></script>
<script src="plugins/datatables/buttons.html5.min.js"></script>
<script src="plugins/datatables/buttons.print.min.js"></script>
<!-- Key Tables -->
<script src="plugins/datatables/dataTables.keyTable.min.js"></script>

<!-- Responsive examples -->
<script src="plugins/datatables/dataTables.responsive.min.js"></script>
<script src="plugins/datatables/responsive.bootstrap4.min.js"></script>

<!-- Selection table -->
<script src="plugins/datatables/dataTables.select.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.4/clipboard.min.js"></script>

<script>

$('.ousttabs').DataTable({
    "paging": false
});

$(function(){
    new ClipboardJS('.copybtn');

    $( ".copybtn" ).on( "click", function() {
        $(this).text('Copied!')
    });
})

</script>
</body>
</html>