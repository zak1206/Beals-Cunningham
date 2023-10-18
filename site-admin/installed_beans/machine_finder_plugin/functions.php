<?php
class machinefinderui {

    function checkmachineSystem(){
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }

        $a = $data->query("SELECT * FROM used_equipment WHERE active = 'true'");
        if($a->num_rows > 0){
            return true;
        }else{
            return false;
        }
    }

    function getLastUpdate(){
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }

        $a = $data->query("SELECT * FROM machine_finder_pulls WHERE pulldate != '' ORDER BY pulldate DESC");
        $b = $a->fetch_array();

        $ars = array("pulldate"=>$b["pulldate"], "pullstatus"=>$b["status"]);

        return $ars;
    }

    function setupMachines($post){
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }
        $ars = array('form_token'=>'','mf_dealer_link'=>$post["feed_url"],'token'=>$post["secrete_key"],'passcode'=>$post["pass"]);
        $converts = json_encode($ars);
        $data->query("UPDATE beans SET settings = '$converts' WHERE bean_id = 'MF-v3'")or die($data->error);

        include('usedFeedParser.php');

        $runners = new getMachines();

        $gorun = $runners->runMFequips();

        if($gorun != 'CONNECT ERROR'){
             return 'good';
        }else{
            return 'connection error';
        }
    }

    function setorder($orders){
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }
        $post = json_decode($_POST["sortorder"],true);

        $ords = 0;
        foreach ($post as $key){
            $data->query("UPDATE used_equipment SET order_pro = '$ords' WHERE category = '$key'")or die($data->error);
            echo $key;
            $ords++;
        }
    }

    function updateFormToken($newtoken){
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }

        $a = $data->query("SELECT settings FROM beans WHERE bean_id = 'MF-v3'");
        $b = $a->fetch_array();

        $settings = json_decode($b["settings"],true);

        foreach ($settings as $key => $val){
            if($key == 'form_token'){
                $ars[$key] = $newtoken;
            }else{
                $ars[$key] = $val;
            }
        }

        $updates = json_encode($ars);

        $data->query("UPDATE beans SET settings = '".$data->real_escape_string($updates)."' WHERE bean_id = 'MF-v3'");
    }

    function getFeatureCats(){
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }

        $html .= '<small style="color: red">Copy and paste the code below on any page to output the Featured Used Equipment.</small><br>';
        $html .= '<p>{usedfeatured}MFv30{/usedfeatured}</p><br>';

        $html .= '<label>Select a Category</label><br>';

        $html .= '<select name="catsels" id="catsels" class="form-control" style="max-width:500px">';

        $a = $data->query("SELECT category FROM used_equipment WHERE active = 'true' GROUP BY category ORDER BY category ASC")or die($data->error);
        while($b = $a->fetch_array()){
            if($b["category"] != null) {
                    $v = $data->query("SELECT * FROM used_equipment WHERE category = '".$b["category"]."' AND featured = 'true'");
                    $counts = $v->num_rows;
                    if($counts == 0){
                        $counts = '';
                    }else{
                        $counts = '-----'.$counts.' Featured';
                    }
                $html .= '<option value="' . $b["category"] . '">' . $b["category"] . ' '.$counts.'</option>';
            }
        }

        $html .= '</select>';

        $html .= '<div style="height: 40px; margin-top: 30px">Click to check mark the models below to add to featured sections</div>';

        $html .= '<div class="featureselect row" style="padding: 20px">';

        $c = $data->query("SELECT * FROM used_equipment WHERE active = 'true' AND category != '' ORDER BY category ASC")or die($data->error);
        $sets = 0;
        while($d = $c->fetch_array()){

            if($sets == 0){
                $GLOBALS['MyGlobalVar'] = $d["category"];
            }

            if($GLOBALS['MyGlobalVar'] == $d["category"]){

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

                if($d["featured"] == 'true'){
                    $checks = '<div class="checked" style="position: absolute;top: 0;right: 0;padding: 1px 6px;color: #53ff65;font-size: 19px;background: #4a4a4a;border-radius: 30px"><i class="fa fa-check"></i></div>';
                }else{
                    $checks = '';
                }

                $html .= '<div class="col-md-2 fetselection" data-usedid="'.$d["id"].'" style="background-image: url('.$theImage.'); cursor: pointer; background-position:center; background-size:contain; border:solid 3px #fff"><img style="width:100%" src="spacer.png">'.$checks.' <div style="padding: 5px; background: #333; color: #fff; position: absolute; bottom:0; width: 100%; left: 0; text-align: center; font-size: 12px">'.$d["model"].'</div></div>';


            }

            $sets++;

        }


        $html .= '</div>';


        echo $html;
    }

    function doWorkSet($equipid,$isset){
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }

        if($isset == 'true'){
            $data->query("UPDATE used_equipment SET featured = '' WHERE id = '$equipid'");
        }else{
            $data->query("UPDATE used_equipment SET featured = 'true' WHERE id = '$equipid'");
        }
    }

    function getCat($cat){
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }

        $c = $data->query("SELECT * FROM used_equipment WHERE category = '$cat' ORDER BY model ASC")or die($data->error);
        while($d = $c->fetch_array()){
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

            if($d["featured"] == 'true'){
                $checks = '<div class="checked" style="position: absolute;top: 0;right: 0;padding: 1px 6px;color: #53ff65;font-size: 19px;background: #4a4a4a;border-radius: 30px;"><i class="fa fa-check"></i></div>';
            }else{
                $checks = '';
            }

            $html .= '<div class="col-md-2 fetselection" data-usedid="'.$d["id"].'" style="background-image: url('.$theImage.'); cursor: pointer; background-position:center; background-size:cover; border:solid 3px #fff; background-repeat:no-repeat"><img style="width:100%" src="spacer.png">'.$checks.' <div style="padding: 5px; background: #333; color: #fff; position: absolute; bottom:0; width: 100%; left: 0; text-align: center; font-size: 12px">'.$d["model"].'</div></div>';
        }

        echo $html;
    }

    function credUpdateForm(){
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }
        $a = $data->query("SELECT * FROM beans WHERE bean_id = 'MF-v3'");
        $b = $a->fetch_array();
        $settings = $b["settings"];
        $settings = json_decode($settings,true);

        $html .= '<form id="usedFeedUpdate" name="usedFeedUpdate" method="post" action="">
<div class="row">
<div class="col-md-3" style="margin: 2px; padding: 5px">
            <input class="form-control" type="text" name="feed_url" id="feed_url" placeholder="Feed URL" value="'.$settings["mf_dealer_link"].'" required="">
            </div>
            <div class="col-md-3" style="margin: 2px; padding: 5px">
            <input class="form-control" type="text" name="secrete_key" id="secrete_key" placeholder="Secrete Key" value="'.$settings["token"].'" required="">
            </div>
<div class="col-md-3" style="margin: 2px; padding: 5px">
            <input class="form-control" type="password" name="pass" id="pass" placeholder="Password" value="'.$settings["passcode"].'" required="">
            </div>
            <button style="padding: 5px 10px; font-size: 12px;height: 40px; margin-top: 6px;" type="submit" name="login" class="btn btn-primary">UPDATE ACCOUNT</button>
            </div>
        </form>';

        return $html;
    }

    function finishCredUpdate($post){
        if(file_exists('../../inc/harness.php')){
            include('../../inc/harness.php');
        }else{
            include('inc/harness.php');
        }

        ///BE SURE TO ADD THE FORM TOKEN HERE///

        $ars = array('mf_dealer_link'=>$post["feed_url"],'token'=>$post["secrete_key"],'passcode'=>$post["pass"]);
        $converts = json_encode($ars);
        $data->query("UPDATE beans SET settings = '$converts' WHERE bean_id = 'MF-v3'")or die($data->error);
        echo 'KEYS UPDATED.';
    }

    function updateMacs(){
        include('usedFeedParser.php');
        $runners = new getMachines();
        $gorun = $runners->runMFequips();
    }

    function getUsage(){
        $html .= '<h2>Usage Instructions</h2>';

        $html .= '<p>Create a page in the system called "Used Equipment" and paste the following source code.</p>';

        $html .= '<label style="font-weight: bold">HTML PAGE CODE:</label><br>';
        $html .= '<code style="display: block;max-height: 200px;overflow-y: scroll;background: #2d2d2d;padding: 10px;color: #fff">'.htmlspecialchars('<div class="row" style="margin:0"><div class=" col-3"><h3></h3></div><div class=" col-9"><h1 style="">Used Equipment</h1></div></div><div class="">{include}site-admin/installed_beans/machine_finder_plugin/output.php{/include}</div> <div class="clearfix"></div>').' </code>';

        $html .= '<br><label style="font-weight: bold">JAVASCRIPT PAGE CODE:</label><br>';

        $jsCode = htmlspecialchars('function pageData(a){parentObj=[],$(".target-box").each(function(){var a=$(this).data("filter-box");jsonObj=[],$(this).children("span").each(function(){itemsz={},itemsz.item=$(this).data(a+"-set"),jsonObj.push(itemsz)}),firstitem={},firstitem[a]=jsonObj,parentObj.push(firstitem)});var t=JSON.stringify(parentObj),e=$("#price_from").val(),i=$("#price_to").val(),s=$("#hours_from").val(),r=$("#hours_to").val(),o=$("#year_from").val(),n=$("#year_to").val(),c=$("#sorterset").val(),l=$("#viewtype").val();$.ajax({url:"inc/mods/machine_finder/asyncfile.php?action=getresults&page="+a,cache:!1,type:"POST",data:{filters:t,price_from:e,price_to:i,hours_from:s,hours_to:r,year_from:o,year_to:n,viewtype:l,sorttype:c},success:function(a){$(".rezout").html(a),$(window).scrollTop(0),getSortobj()}})}function recallEvent(){$(".clickobjtabs").on("click",function(){var a=$(this).data("labtype"),t=$(this).data(a+"-set");$("[data-"+a+\'-set="\'+t+\'"]\').remove(),$(\'[data-vals="\'+t+\'"]\').find(".thecheck").remove();var e=a;if("category"==e){$(".man-item").hide(),$(\'[data-vals="\'+t+\'"]\').removeClass("catfilter");var i=$(".catfilter").length;0==parseInt(i)&&($(".man-item").show(),$(".mod-item").show()),$(".catfilter").each(function(a,t){var e=$(this).data("manus").split(",");$.each(e,function(a,t){$(\'[data-vals="\'+t+\'"]\').show()})})}if("manufacturer"==e){$(".cat-item").hide(),$(\'[data-vals="\'+t+\'"]\').removeClass("manfilter");var s=$(".manfilter").length;0==parseInt(s)&&($(".cat-item").show(),$(".man-item").show()),$(".manfilter").each(function(a,t){var e=$(this).data("cats").split(",");$.each(e,function(a,t){$(\'[data-vals="\'+t+\'"]\').show()});var i=$(this).data("mods");$(".mod-item").show();var s=i.split(",");$(".mod-item").hide(),$.each(s,function(a,t){$(\'[data-vals="\'+t+\'"]\').show()})})}if("model"==e){$(".cat-item").hide(),$(".man-item").hide(),$(\'[data-vals="\'+t+\'"]\').removeClass("modfilter");var r=$(".modfilter").length;if(0==parseInt(r)){$(".mod-item").show(),$(".man-item").hide(),$(".cat-item").show();i=$(".catfilter").length;0!=parseInt(i)?$(".catfilter").each(function(a,t){var e=$(this).data("manus").split(",");$.each(e,function(a,t){$(\'[data-vals="\'+t+\'"]\').show()})}):$(".man-item").show()}$(".modfilter").each(function(a,t){var e=$(this).data("cats").split(",");$.each(e,function(a,t){$(\'[data-vals="\'+t+\'"]\').show()});var i=$(this).data("manus").split(",");$.each(i,function(a,t){$(\'[data-vals="\'+t+\'"]\').show()})})}parentObj=[],$(".target-box").each(function(){var a=$(this).data("filter-box");jsonObj=[],$(this).children("span").each(function(){itemsz={},itemsz.item=$(this).data(a+"-set"),jsonObj.push(itemsz)}),firstitem={},firstitem[a]=jsonObj,parentObj.push(firstitem)});var o=JSON.stringify(parentObj),n=$("#price_from").val(),c=$("#price_to").val(),l=$("#hours_from").val(),h=$("#hours_to").val(),m=$("#year_from").val(),f=$("#year_to").val();$.ajax({url:"inc/mods/machine_finder/asyncfile.php?action=filter",cache:!1,type:"POST",data:{filters:o},success:function(a){var t=$.parseJSON(a),i=t.models,s=t.years;if("model"!=e){var r=[];$(".mod-item").each(function(){r.push($(this).data("vals"))}),$(".mod-item").hide(),$.each(i,function(a,t){var e=!1;$.map(r,function(a,i){a==t&&($(\'[data-vals="\'+t+\'"]\').show(),e=!0)}),e||$(\'[data-vals="\'+t+\'"]\').hide()})}var o=[];$(".year-item").each(function(){o.push($(this).data("vals"))}),$(".year-item").hide(),$.each(s,function(a,t){var e=!1;$.map(o,function(a,i){a==t&&($(\'[data-vals="\'+t+\'"]\').show(),e=!0)}),e||$(\'[data-vals="\'+t+\'"]\').hide()})}});var d=$("#sorterset").val();$.ajax({url:"inc/mods/machine_finder/asyncfile.php?action=getresults",cache:!1,type:"POST",data:{filters:o,price_from:n,price_to:c,hours_from:l,hours_to:h,year_from:m,year_to:f,sorttype:d},success:function(a){$(".rezout").html(a),getSortobj()}})})}function resetFilters(){$("#searchinput").val(""),$(".clickobjtabs").remove(),$(".thecheck").remove(),$(".cat-item").show(),$(".cat-item").each(function(){$(this).removeClass("catfilter")}),$(".man-item").each(function(){$(this).removeClass("manfilter")}),$(".mod-item").each(function(){$(this).removeClass("modfilter")}),$(".man-item").show(),$(".mod-item").show(),$(".year-item").show(),$(".js-range-slider").data("ionRangeSlider").update({from:0,to:9e5}),$(".js-range-slider-2").data("ionRangeSlider").update({from:0,to:9e3}),$(".js-range-slider-3").data("ionRangeSlider").update({from:1900,to:(new Date).getFullYear()}),$("#price_from").val("0"),$("#price_to").val("900000"),$("#hours_from").val("0"),$("#hours_to").val("9000"),$("#year_from").val("1900"),$("#year_to").val((new Date).getFullYear()),$("#sorterset").val(""),$(".show-sort").text("Sort"),pageData(1)}function getSortobj(){$(".sorters").on("click",function(){var a=$(this).data("dorttype");$(this).text();$("#sorterset").val(a),pageData(1)})}function setViewType(a){$("#viewtype").val(a),pageData(1)}function rerunFiltration(){parentObj=[],$(".target-box").each(function(){var a=$(this).data("filter-box");jsonObj=[],$(this).children("span").each(function(){itemsz={},itemsz.item=$(this).data(a+"-set"),jsonObj.push(itemsz)}),firstitem={},firstitem[a]=jsonObj,parentObj.push(firstitem)});var a=JSON.stringify(parentObj);$("#price_from").val(),$("#price_to").val(),$("#hours_from").val(),$("#hours_to").val(),$("#year_from").val(),$("#year_to").val();$.ajax({url:"inc/mods/machine_finder/asyncfile.php?action=filter",cache:!1,type:"POST",data:{filters:a},success:function(a){var t=$.parseJSON(a),e=t.models,i=t.years;$(".man-item").hide(),$(".catfilter").each(function(a,t){var e=$(this).data("manus").split(",");$.each(e,function(a,t){$(\'[data-vals="\'+t+\'"]\').show()})});var s=[];$(".mod-item").each(function(){s.push($(this).data("vals"))}),$(".mod-item").hide(),$.each(e,function(a,t){var e=!1;$.map(s,function(a,i){a==t&&($(\'[data-vals="\'+t+\'"]\').show(),e=!0)}),e||$(\'[data-vals="\'+t+\'"]\').hide()});var r=[];$(".year-item").each(function(){r.push($(this).data("vals"))}),$(".year-item").hide(),$.each(i,function(a,t){var e=!1;$.map(r,function(a,i){a==t&&($(\'[data-vals="\'+t+\'"]\').show(),e=!0)}),e||$(\'[data-vals="\'+t+\'"]\').hide()})}})}$(function(){$(".clickobj").on("click",function(){var a=$(this).data("obj"),t=$(this).data("vals");if(1==$(this).find(".thecheck").length?($(this).find(".thecheck").remove(),$("[data-"+a+\'-set="\'+t+\'"]\').remove()):($(this).append(\' <span class="thecheck"> <i class="fa fa-check green-check"></i></span>\'),$("."+a+"-labs").append(\'<span class="badge badge-secondary badge-lab clickobjtabs" data-labtype="\'+a+\'" data-\'+a+\'-set="\'+t+\'">\'+t+\' <i class="fa fa-times-circle"></i></span>\'),recallEvent()),"category"==a){$(".man-item").hide(),$(this).hasClass("catfilter")?$(this).removeClass("catfilter"):$(this).addClass("catfilter");var e=$(".catfilter").length;0==parseInt(e)&&$(".man-item").show(),$(".catfilter").each(function(a,t){var e=$(this).data("manus").split(",");$.each(e,function(a,t){$(\'[data-vals="\'+t+\'"]\').show()})})}if("manufacturer"==a){$(".cat-item").hide(),$(this).hasClass("manfilter")?$(this).removeClass("manfilter"):$(this).addClass("manfilter");var i=$(".manfilter").length;0==parseInt(i)&&$(".cat-item").show(),$(".manfilter").each(function(a,t){var e=$(this).data("cats").split(",");$.each(e,function(a,t){$(\'[data-vals="\'+t+\'"]\').show()});var i=$(this).data("mods").split(",");$(".mod-item").hide(),$.each(i,function(a,t){$(\'[data-vals="\'+t+\'"]\').show()})})}if("city"==a&&($(this).hasClass("locfilter")?$(this).removeClass("locfilter"):$(this).addClass("locfilter")),"model"==a){$(".cat-item").hide(),$(".man-item").hide(),$(this).hasClass("modfilter")?$(this).removeClass("modfilter"):$(this).addClass("modfilter");var s=$(".modfilter").length;if(0==parseInt(s)){$(".mod-item").show(),$(".man-item").hide(),$(".cat-item").show();e=$(".catfilter").length;0!=parseInt(e)?$(".catfilter").each(function(a,t){var e=$(this).data("manus").split(",");$.each(e,function(a,t){$(\'[data-vals="\'+t+\'"]\').show()})}):$(".man-item").show()}$(".modfilter").each(function(a,t){var e=$(this).data("cats").split(",");$.each(e,function(a,t){$(\'[data-vals="\'+t+\'"]\').show()});var i=$(this).data("manus").split(",");$.each(i,function(a,t){$(\'[data-vals="\'+t+\'"]\').show()})})}parentObj=[],$(".target-box").each(function(){var a=$(this).data("filter-box");jsonObj=[],$(this).children("span").each(function(){itemsz={},itemsz.item=$(this).data(a+"-set"),jsonObj.push(itemsz)}),firstitem={},firstitem[a]=jsonObj,parentObj.push(firstitem)});var r=JSON.stringify(parentObj),o=$("#price_from").val(),n=$("#price_to").val(),c=$("#hours_from").val(),l=$("#hours_to").val(),h=$("#year_from").val(),m=$("#year_to").val(),f=$("#sorterset").val(),d=$("#viewtype").val();$.ajax({url:"inc/mods/machine_finder/asyncfile.php?action=filter",type:"POST",cache:!1,data:{filters:r,price_from:o,price_to:n,hours_from:c,hours_to:l,year_from:h,year_to:m,viewtype:d,sorttype:f},success:function(t){var e=$.parseJSON(t),i=e.models,s=e.years;if("model"!=a){var r=[];$(".mod-item").each(function(){r.push($(this).data("vals"))}),$(".mod-item").hide(),$.each(i,function(a,t){var e=!1;$.map(r,function(a,i){a==t&&($(\'[data-vals="\'+t+\'"]\').show(),e=!0)}),e||$(\'[data-vals="\'+t+\'"]\').hide()})}var o=[];$(".year-item").each(function(){o.push($(this).data("vals"))}),$(".year-item").hide(),$.each(s,function(a,t){var e=!1;$.map(o,function(a,i){a==t&&($(\'[data-vals="\'+t+\'"]\').show(),e=!0)}),e||$(\'[data-vals="\'+t+\'"]\').hide()})}}),$.ajax({url:"inc/mods/machine_finder/asyncfile.php?action=getresults&page=1",cache:!1,type:"POST",data:{filters:r,price_from:o,price_to:n,hours_from:c,hours_to:l,year_from:h,year_to:m,viewtype:d,sorttype:f},success:function(a){$(".rezout").html(a),getSortobj()}})})}),$.fn.donetyping=function(a){var t,e=$(this);function i(){clearTimeout(t),a.call(e)}e.keyup(function(){clearTimeout(t),t=setTimeout(i,1e3)})},$(".theautos").donetyping(function(a){var t=$(this).val();$.ajax({url:"inc/mods/machine_finder/asyncfile.php?action=inputsearch",cache:!1,type:"POST",data:{searchinput:t},success:function(a){$(".rezout").html(a),getSortobj()}})}),$(function(){$(".js-range-slider").ionRangeSlider({skin:"round",onFinish:function(a){$("#price_from").val(a.from),$("#price_to").val(a.to),pageData(1)}}),$(".js-range-slider-2").ionRangeSlider({skin:"round",onFinish:function(a){$("#hours_from").val(a.from),$("#hours_to").val(a.to),pageData(1)}}),$(".js-range-slider-3").ionRangeSlider({skin:"round",prettify_enabled:!1,onFinish:function(a){$("#year_from").val(a.from),$("#year_to").val(a.to),pageData(1)}})}),$(function(){rerunFiltration();var a=$("#pageons").val();if("undefined"==a)var t="1";else t=a;pageData(t),$(".opnfilters").on("click",function(){$(".mob-sensor").toggle(),$("html, body").animate({scrollTop:0},0),$(".mob-sensor").is(":visible")?$(".opnfilters").text("Close Filters"):$(".opnfilters").text("Open Filters")})});');

        $html .= '<code style="display: block;max-height: 200px;overflow-y: scroll;background: #2d2d2d;padding: 10px;color: #fff">'.$jsCode.'</code>';

        return $html;
    }
}

?>