<?php
    include('../../inc/caffeine.php');
    $site = new caffeine();
    $userArray = $site->auth();
    // var_dump("Included");
     ?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href="../../plugins/switchery/switchery.min.css" rel="stylesheet" />

  <link href="../../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="../../codemirror/lib/codemirror.css" />
  <link rel="stylesheet" href="../../codemirror/theme/mbo.css">
  <link href="../../assets/css/icons.css" rel="stylesheet" type="text/css">
  <link href="../../plugins/sweet-alert/sweetalert2.min.css" rel="stylesheet">
  <link href="../../plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
  <link href="../../plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
  <!-- Responsive datatable examples -->
  <link href="../../plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

  <!-- Multi Item Selection examples -->
  <link href="../../plugins/datatables/select.bootstrap4.min.css" rel="stylesheet" type="text/css" />
  <link href="../../plugins/nestable/jquery.nestable.css" rel="stylesheet" />
  <link rel="stylesheet" href="../../assets/css/bootstrap-datetimepicker.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="../../assets/css/style.css" rel="stylesheet" type="text/css">

  <style>
    .dropitemsin {
      padding: 10px;
      text-align: center;
      background: #f5dda3;
      margin: 2px;
      font-weight: bold;
    }

    .droparea {
      padding: 20px;
      background: #efefef;
      border: dashed thin #333;
    }

    li.equiplist-item {
      padding: 10px;
      width: 100%;
      background: #E9ECEF;
      border: solid 1px #ccc;
      border-radius: 4px;
      list-style: none;
    }

    a {
      color: black;
    }

    #body-row {
      margin-left: 0;
      margin-right: 0;
    }

    #sidebar-container {
      min-height: 100vh;
      background-color: #333;
      padding: 0;
    }

    /* Sidebar sizes when expanded and expanded */
    .sidebar-expanded {
      width: 230px;
    }

    .sidebar-collapsed {
      width: 60px;
    }

    /* Menu item*/
    #sidebar-container .list-group a {
      height: 50px;
      color: white;
    }

    /* Submenu item*/
    #sidebar-container .list-group .sidebar-submenu a {
      height: 45px;
      padding-left: 30px;
    }

    .sidebar-submenu {
      font-size: 0.9rem;
    }

    /* Separators */
    .sidebar-separator-title {
      background-color: #333;
      height: 35px;
    }

    .sidebar-separator {
      background-color: #333;
      height: 25px;
    }

    .logo-separator {
      background-color: #333;
      height: 60px;
    }

    /* Closed submenu icon */
    #sidebar-container .list-group .list-group-item[aria-expanded="false"] .submenu-icon::after {
      content: " \f0d7";
      font-family: FontAwesome;
      display: inline;
      text-align: right;
      padding-left: 10px;
    }

    /* Opened submenu icon */
    #sidebar-container .list-group .list-group-item[aria-expanded="true"] .submenu-icon::after {
      content: " \f0da";
      font-family: FontAwesome;
      display: inline;
      text-align: right;
      padding-left: 10px;
    }

    .btn-primary {
      background-color: #097F0E;
      border: 1px solid #097F0E;
    }

    div.image-holder.col-sm-4.col-md-6.four-three {
      display: none;
    }

    div.ctas {
      display: none;
    }
  </style>

  <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js" integrity="" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <!-- Required datatable js -->
  <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="../../plugins/datatables/dataTables.bootstrap4.min.js"></script>
  <!-- Buttons examples -->

  <!-- Key Tables -->
  <script src="../../plugins/datatables/dataTables.keyTable.min.js"></script>

  <!-- Responsive examples -->
  <script src="../../plugins/datatables/dataTables.responsive.min.js"></script>
  <script src="../../plugins/datatables/responsive.bootstrap4.min.js"></script>

  <!-- Selection table -->
  <script src="../../plugins/datatables/dataTables.select.min.js"></script>

  <script src="../../codemirror/lib/codemirror.js"></script>
  <script src="../../codemirror/mode/css/css.js"></script>
  <script src="../../codemirror/mode/javascript/javascript.js"></script>
  <script src="../../codemirror/mode/xml/xml.js"></script>
  <script src="../../codemirror/mode/htmlmixed/htmlmixed.js"></script>
  <script src="../../tinymce/js/tinymce/tinymce.min.js"></script>
  <script src="md5.min.js"></script>
  <script src="jquery.sticky.js"></script>
  <script src="jquery.hideseek.js"></script>
  <script src="../../plugins/sweet-alert/sweetalert2.min.js"></script>
  <script src="../../assets/pages/jquery.sweet-alert.init.js"></script>

  <title>Hello, world!</title>

  <style>
    .modal-lg {
      max-width: 80%;
    }
  </style>
</head>

<body style="height: 100vh; background: white;">
  <div class="container-fluid">
    <?php
    include('sidebar.php');
    include('functions.php');
    $deere = new customClass();
     ?>

    <div class="col p-4">