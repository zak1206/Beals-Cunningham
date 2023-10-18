<?php
$data = mysqli_connect("localhost","caffeine","BCss1957!@","caff_five_oh");
$data->set_charset("utf8");
include('pages.php');

$sql = "SELECT * FROM deere_equipment WHERE title ='$equipBase' AND active = 'true'";
if ($res = mysqli_query($data, $sql)) {
    $num_rows = mysqli_num_rows($res);
    if ($num_rows > 0) {
        while ($row = mysqli_fetch_assoc($res)) {


            $extra_content = $row["extra_content"];
            echo $extra_content;
            $offers_link = $row["offers_link"];
            echo $offers_link;

            if ($extra_content != "NULL") {
                $html .= '<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">';

                $html .= '<div class="carousel-inner">';
                $html .= '<div class="carousel-item active">';

                $html .= '';

                $html .= '';

                $html .= '';

                $html .= '';
            }
            else{
                $html .= '<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">';

                $html .= '<div class="carousel-inner">';

                $html .= '<div class="carousel-item active">';

                $html .= '<img class="d-block home-car-img" src="img/ST-05-24-19-Web-Site-Redesign-Ztrak-Tractors.png" alt="First slide"> </div>';

                $html .= '<div class="carousel-item">';

                $html .= '<img class="d-block home-car-img" src="img/ST-05-24-19-Web-Site-Redesign-Ztrak-Tractors.png" alt="Second slide"> </div>';

                $html .= '<div class="carousel-item"> <img class="d-block home-car-img" src="img/ST-05-24-19-Web-Site-Redesign-Ztrak-Tractors.png" alt="Third slide"> </div> </div>';

                $html .= '<a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> 
             <span class="sr-only">Previous</span> </a> 
             <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next"> 
             <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">Next</span> </a> ';

                $html .= '</div>';

            }



        }
    }
}




?>