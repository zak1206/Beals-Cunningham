<?php
include('harness.php');
file_put_contents('../../inc/header.php', $data->real_escape_string($_POST["myTextarea"]));
echo '<div class="alert alert-success">
  <strong>Success!</strong> Header file has been updated.
</div>';
?>