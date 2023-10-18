<?php
header('Content-Type: text/html; charset=utf-8');
include('inc/caffeine.php');
$site = new caffeine();
$userArray = $site->auth();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="EQHarvest">

    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <title>EQHarvest</title>

    <link href="plugins/switchery/switchery.min.css" rel="stylesheet" />

    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="codemirror/lib/codemirror.css" />
    <link rel="stylesheet" href="codemirror/theme/mbo.css">
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="plugins/sweet-alert/sweetalert2.min.css" rel="stylesheet">
    <link href="plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <!-- Responsive datatable examples -->
    <link href="plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Multi Item Selection examples -->
    <link href="plugins/datatables/select.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="plugins/nestable/jquery.nestable.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.css">
    <link rel="stylesheet" href="assets/css/bootstrap-switch.css">
    <link href="plugins/jquery-circliful/css/jquery.circliful.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="assets/css/Chart.min.css" />
    <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/Chart.min.js"></script>
    <script src="codemirror/lib/codemirror.js"></script>
    <script src="codemirror/mode/css/css.js"></script>
    <script src="codemirror/mode/javascript/javascript.js"></script>
    <script src="codemirror/mode/xml/xml.js"></script>
    <script src="codemirror/mode/htmlmixed/htmlmixed.js"></script>
    <script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script src="tinymce/js/tinymce/tinymce.min.js"></script>


    <script src="assets/js/modernizr.min.js"></script>

</head>


<body class="fixed-left">