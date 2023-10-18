<div id="feat-used">
<ul class="flip-items">

<?php
                include('config.php');
                $a = $data->query("SELECT * FROM used_equipment WHERE featured = 'true' AND active = 'true' ORDER BY category ASC");
                $navs = 0;
                while($d = $a->fetch_array()){
                    $cleanImg = trim($d["images"], ')');
                    $cleanImg = trim($cleanImg, '(');

                    $cleanImg = stripcslashes($cleanImg);

                    $images = json_decode($cleanImg, true);


                    $theImages = $images["image"];


                    if($theImages[0]["filePointer"] != ''){
                        $theImage = $theImages[0]["filePointer"];
                    }else{
                        $theImage = 'no-image.png';
                    }

                    $link = 'Used-Equipment/'.str_replace(' ','-',$d["category"]).'/'.str_replace(' ','-',$d["manufacturer"]).'-'.str_replace(' ','-',$d["model"]).'-'.$d["id"];

                    $modelInfo = '<div style="position: absolute; bottom: 0; left: 0; text-align: center; background: #333; color: #fff; width: 100%; padding: 2px">'.$d["manufacturer"].' '.$d["model"].'</div>';

                    echo '<li style="background-image: url('.$theImage.'); background-position: center; background-repeat: no-repeat; background-size:cover; position:relative"><a href="'.$link.'"><img width="100%" src="img/spacer.png"></a>'.$modelInfo.'</li>';
                    $nav .= '<button class="glide__bullet" data-glide-dir="='.$navs.'"></button>';
                    $navs++;
                }
            ?>



<!--    <div class="glide__bullets" data-glide-el="controls[nav]">-->
<!--        --><?php //echo $nav; ?>
<!---->
    <!--    </div>--></ul>
</div>