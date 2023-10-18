<?php
session_start();
unset($_SESSION['front_user']);
header('Location: '.$_REQUEST["pageset"].'');
?>