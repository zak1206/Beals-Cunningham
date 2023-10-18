<?php
$chatAct = $_REQUEST["chataction"];

if($chatAct == 'getchat'){
    $outPut .= '<div class="basecht animated bounceIn" style="display: block; padding: 15px 11px; position: fixed; bottom: 20px; right: 10px; background: #fff; border-radius: 50%; box-shadow: 0px 3px 5px #868686;"><img style="width: 40px" src="inc/mods/caffeine_chat/chat_icon.png"></div>';
    echo $outPut;
}