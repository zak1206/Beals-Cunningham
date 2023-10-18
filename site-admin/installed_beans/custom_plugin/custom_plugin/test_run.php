<!doctype html>
<div lang="en">
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
         p {
             font-family: Arial, Helvetica, sans-serif;
         }
         .row-application {
             background-color: #eceeef;
             padding: 20px;
             margin: 26px 0;
             box-shadow: 0 3px 6px rgba(0,0,0,.16), 0 3px 6px rgba(0,0,0,.23);
         }
    </style>
</head>
    <!--modal -->
    <div class="modal" tabindex="-1" role="dialog" id="myModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" style="color:#ff0000;">ALERT</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p style="font-size: 18px; text-transform:uppercase; font-weight:bold;">Export a copy before importing a new CSV</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- -->

<div class="container">
    <h4 class="title" style="color: #000; font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 25px;">Import File</h4><hr>
        <div class="row">
            <div class="col-md-6">
                <div class="row-application" style="height:150px;">
                    <img src="../../../../img/JDOUG-step1.png" class="img-responsive" style="float:left;"><p style="font-size: 15px; text-align: right; color:#C8C8C8; margin-top:30px;"> Export the current Custom Products database csv file.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row-application" style="height:150px;">
                    <img src="../../../../img/JDOUG_Step2.png" class="img-responsive" style="float:left;"> <p style="font-size: 15px; text-align: right; color:#C8C8C8; margin-top:30px;">Open the csv file and a make any required product changes or additions. <strong>DO NOT CHANGE THE STRUCTURE OF THE FILE.</strong></p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row-application" style="height:150px;">
                    <img src="../../../../img/JDOUG-step3.png" class="img-responsive" style="float:left;"><p style="font-size: 15px; text-align: right; color:#C8C8C8; margin-top:30px;">Export a new csv file and verify that its format is exactly the same as the original exported file. If the file structure is not exactly the same, it will not work.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row-application" style="height:150px;">
                    <img src="../../../../img/step4.png" class="img-responsive" style="float:left;"><p style="font-size: 15px; text-align: right; margin-top:30px;">Upload the new csv file to import it into the custom products database.</p>
                </div>
            </div>
            <div class="col-md-12">
                <p style="color:#ff0000;"><strong><span style="font-size:18px;">NOTE:</span></strong> The import file format has to be formatted in exactly the same way as the original export file. Any misplaced commas or information will not render correctly.</p>
            </div>
        </div>
    </div>
    <div class="container card" style="border-radius: 0px;box-shadow: 0 2px 2px rgba(204, 197, 185, 0.5); background-color: #eceeef; color: #252422; margin-bottom: 20px; position: relative; z-index: 1; padding:116px;width: 100%; display:block; margin: 0px auto; margin-left:-15px;">
        <form class="form-horizontal" action="google_test.php" method="post" name="uploadCSV" enctype="multipart/form-data">
        <div class="input-row">
            <div class="col-md-6">
        <label class="control-label" style="font-family: Arial, Helvetica, sans-serif; font-size:25px; float:right;">Choose CSV File</label>
                <!--<p style="font-family: Arial, Helvetica, sans-serif; font-size:12px;">*Export a copy before importing a new CSV</p>-->
            </div>
            <div class="col-md-6">
        <input type="file" name="file" id="file" accept=".csv" style="padding: 10px;">
            </div>
            <div class="col-md-6">
        <button type="submit" id="submit" name="import"
                class="btn-submit" style="background-color: #28a745; border-color: #28a745; color: #fff; min-width: 150px; font-weight: bold; font-size: 1.5rem; text-transform: uppercase; margin:10px;">Import</button>
            </div>
            <div class="col-md-6"></div>

    </div>
    <div id="labelError"></div>
</form>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script>
    $( document ).ready(function() {
        $('#myModal').modal('show');
    });
</script>