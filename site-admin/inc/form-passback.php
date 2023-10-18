<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <!-- DataTables -->
    <link href="../plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="../plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="../plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Multi Item Selection examples -->
    <link href="../plugins/datatables/select.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <link href="../plugins/switchery/switchery.min.css" rel="stylesheet" />

    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/style.css" rel="stylesheet" type="text/css">

    <script src="../assets/js/modernizr.min.js"></script>
</head>
<body>
<div style="background: #fff; padding: 20px; margin: 10px">
<table id="forms" class="table table-bordered">
    <thead>
    <tr>
        <th>Form Name</th>
        <th style="text-align: right">Action</th>

    </tr>
    </thead>
    <tbody>
    <tr>
        <td>Contact Form</td>
        <td style="text-align: right"><button class="btn btn-primary btn-sm" onclick="window.parent.setFormDat('FORM22333235R');">Insert Form</button></td>
    </tr>
    <tr>
        <td>Location Form</td>
        <td style="text-align: right"><button class="btn btn-primary btn-sm" onclick="window.parent.setFormDat('FORMAVDFWCC34');">Insert Form</button></td>
    </tr>
    <tr>
        <td>Location Form</td>
        <td style="text-align: right"><button class="btn btn-primary btn-sm">Insert Form</button></td>
    </tr>
    <tr>
        <td>Location Form</td>
        <td style="text-align: right"><button class="btn btn-primary btn-sm">Insert Form</button></td>
    </tr>
    <tr>
        <td>Location Form</td>
        <td style="text-align: right"><button class="btn btn-primary btn-sm">Insert Form</button></td>
    </tr>

</table>
</div>

<div class="clearfix"></div>

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.0.min.js" integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<!-- Required datatable js -->
<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../plugins/datatables/dataTables.bootstrap4.min.js"></script>
<!-- Buttons examples -->
<script src="../plugins/datatables/dataTables.buttons.min.js"></script>
<script src="../plugins/datatables/buttons.bootstrap4.min.js"></script>
<script src="../plugins/datatables/jszip.min.js"></script>
<script src="../plugins/datatables/pdfmake.min.js"></script>
<script src="../plugins/datatables/vfs_fonts.js"></script>
<script src="../plugins/datatables/buttons.html5.min.js"></script>
<script src="../plugins/datatables/buttons.print.min.js"></script>

<!-- Key Tables -->
<script src="../plugins/datatables/dataTables.keyTable.min.js"></script>

<!-- Responsive examples -->
<script src="../plugins/datatables/dataTables.responsive.min.js"></script>
<script src="../plugins/datatables/responsive.bootstrap4.min.js"></script>

<!-- Selection table -->
<script src="../plugins/datatables/dataTables.select.min.js"></script>


<script>
    $(document).ready(function() {
        $('#forms').DataTable();
    } );
</script>

</body>
</html>