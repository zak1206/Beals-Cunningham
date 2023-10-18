<?php

if($act == 'getspecs') {


    header('Content-Type: application/json');
    echo json_encode($ars);
}