<?php
include('../../inc/harness.php');
// echo "Hello";
$antigo = $_POST["antigo"];
$Campbellsport = $_POST["Campbellsport"];
$Chilton = $_POST["Chilton"];
$Denmark = $_POST["Denmark"];
$FondduLac = $_POST["Fond-du-Lac"];
$Marion = $_POST["Marion"];
$Hortonville = $_POST["Hortonville"];
$Neenah = $_POST["Neenah"];
$Pound = $_POST["Pound"];
$Pulaski = $_POST["Pulaski"];
$Shawano = $_POST["Shawano"];
$StevensPoint = $_POST["Stevens-Point"];
$Stratford = $_POST["Stratford"];
$Westfield = $_POST["Westfield"];


if (isset($_POST['submit'])) {
 //  echo "Hello Again";
 $data->query("UPDATE equipment_tax SET tax_rate = CASE relid 
 WHEN 1 THEN '" . $data->real_escape_string($antigo) . "'
 WHEN 2 THEN '" . $data->real_escape_string($Campbellsport) . "'
 WHEN 3 THEN '" . $data->real_escape_string($Chilton) . "'
 WHEN 4 THEN '" . $data->real_escape_string($Denmark) . "'
 WHEN 5 THEN '" . $data->real_escape_string($FondduLac) . "'
 WHEN 6 THEN '" . $data->real_escape_string($Marion) . "'
 WHEN 7 THEN '" . $data->real_escape_string($Hortonville) . "'
 WHEN 8 THEN '" . $data->real_escape_string($Neenah) . "'
 WHEN 9 THEN '" . $data->real_escape_string($Pound) . "'
 WHEN 10 THEN '" . $data->real_escape_string($Pulaski) . "'
 WHEN 11 THEN '" . $data->real_escape_string($Shawano) . "'
 WHEN 12 THEN '" . $data->real_escape_string($StevensPoint) . "'
 WHEN 13 THEN '" . $data->real_escape_string($Stratford) . "'
 WHEN 14 THEN '" . $data->real_escape_string($Westfield) . "'
END 
WHERE relid BETWEEN 1 AND 14 AND active = 'true'");
 $message = "Tax Rates Data Entry Completed";
 echo "<script type='text/javascript'>alert('$message');</script>";
}


?>

<?php
include('e-commerce-header.php');
?>

<div class="row" style="margin:0;">
 <div class="col-md-12">
  <div class="header">
   <h4 class="title">Tax Rates</h4>
   <p class="category">Set your tax rates here.</p>
  </div>
  <div class="content table-responsive table-full-width">
   <!-- RADIO BUTTON Shipping START======================== -->
   <form name="taxRatesForm" method="post" action="">
    <div>
     <p>Enter Tax Rates based on Locations(Integers Only)</p>
     <?php
     include('../../inc/harness.php');
     $result = $data->query("SELECT * FROM location WHERE active = 'true'");
     foreach ($result as $row) {
      if ($row["location_link"] != "") {
       $locationid = $data->query("SELECT * FROM equipment_tax WHERE relid = " . $row["id"] . " AND active = 'true'");
       $location_row = $locationid->fetch_assoc();
       echo '<label for="' . $row["location_link"] . '">' . $row["location_name"] . '</label><input class="form-control" id="' . $row["location_link"] . '" name="' . $row["location_link"] . '" value="' . $location_row["tax_rate"] . '" style="width: 40%;">';
      }
     }
     ?>

    </div>
    <button class="btn btn-success" type="submit" id="submit" name="submit" style="margin-top: 10px;">Save</button>
   </form>
   <!-- RADIO BUTTON Shipping END========================== -->
  </div>
 </div>
</div>

<?php
include('e-commerce-footer.php');
?>