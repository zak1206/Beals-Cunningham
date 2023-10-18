<?php
////////////
///
///
///
/// NOTICE DO NOT MODIFY THIS FILE - ALL CHANGES NEED TO BE APPLIED TO THE MODULES FOR UPDATING PURPOSES///
///
///
///
///
/////
require_once('vendor/autoload.php');

use Postmark\PostmarkClient;

class site
{
    function loadBeanDepscss()
    {
        include('config.php');
        $sql = "SELECT * FROM beans_dep WHERE headload = 'true' AND active = 'true' AND load_type = 'glob'";
        $a = $data->query($sql);
        while ($b = $a->fetch_array()) {
            $c = $data->query("SELECT * FROM beans WHERE bean_id = '" . $b["bean_id"] . "'");
            $d = $c->fetch_array();
            $chk = substr($b["file"], strrpos($b["file"], '.') + 1);

            if ($chk == 'css') {
                $file[] = array("file" => $b["file"]);
            }
        }
        return $file;
    }

    function loadBeanDepsjs()
    {
        include('config.php');
        $sql = "SELECT * FROM beans_dep WHERE headload = 'true' AND active = 'true' AND load_type = 'glob'";
        $a = $data->query($sql);
        while ($b = $a->fetch_array()) {
            $chk = substr($b["file"], strrpos($b["file"], '.') + 1);
            if ($chk == 'js') {
                $file[] = array("file" => $b["file"]);
            }
        }
        return $file;
    }

    function checkFrontUsers()
    {
        include('config.php');
        if (isset($_SESSION["front_user"])) {
            $a = $data->query("SELECT * FROM caffeine_users WHERE usr_session = '" . $_SESSION["front_user"] . "'");
            if ($a->num_rows > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    function getpageDetails($page)
    {
        include('config.php');
        $sql = "SELECT * FROM pages WHERE page_name = '$page' AND active = 'true'";
        $a = $data->query($sql);
        if ($a->num_rows > 0) {
            $content = array();
            while ($b = $a->fetch_assoc()) {

                if ($b["secure_page"] == 'false' || $b["secure_page"] == '') {
                    $content[] = $b;
                } else {
                    session_start();
                    //check users login//
                    $usersess = $this->checkFrontUsers();
                    if ($usersess == true) {
                        //                       $content[] = $b;

                        $sendURL = substr($_SERVER["REQUEST_URI"], strrpos($_SERVER["REQUEST_URI"], '/') + 1);

                        $pageContent .= '<div style="display: block; padding: 20px; text-align: right"><a href="logoutfront.php?pageset=' . $sendURL . '" class="btn btn-sm btn-primary" onclick="logFrontOut()">Logout</a></div><hr>';

                        $pageContent .= $b["page_content"];

                        $content[] = array("page_name" => $b["page_name"], "page_title" => $b["page_title"], "page_content" => $pageContent, "active" => true, "created" => time(), "last_edit" => '', "last_user" => '', "page_lock" => 'none', "page_type" => '', "page_desc" => '', "check_out" => false, "check_out_date" => '', "page_js" => array('THis', 'is', 'awesome'), "page_css" => '');
                    } else {
                        $pageContent .= '<div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card card-signin my-5">
          <div class="card-body">
            <h5 class="card-title text-center">Sign In</h5>
            <form class="form-signin" name="front_signin" id="front_signin" method="post" action="">
              <div class="form-label-group">
                <input type="email" id="front_email" name="front_email" class="form-control" placeholder="Email address" required autofocus>
<br>
              </div>

              <div class="form-label-group">
                <input type="password" id="front_password" name="front_password" class="form-control" placeholder="Password" required>
                <br>
              </div>
              <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Sign in</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>';

                        ///PAGE IS LOCKED AND REQUIRES A USERNAME & PASSWORD///
                        $content[] = array("page_name" => $b["page_name"], "page_title" => 'Login', "page_content" => $pageContent, "active" => true, "created" => time(), "last_edit" => '', "last_user" => '', "page_lock" => 'none', "page_type" => '', "page_desc" => '', "check_out" => false, "check_out_date" => '', "page_js" => 'frontlog.js');
                    }
                }
            }


            return $content;
        } else {

            include_once('inc/mods/page_mod/functions.php');
            $pagecheck = new pagemods();

            return $pagecheck->checkOthers($page);
        }
    }


    function getpageDetailsRepot($repotid)
    {
        include('config.php');
        $sql = "SELECT * FROM page_repo WHERE id = '$repotid'";
        $a = $data->query($sql);
        $content = array();
        while ($b = $a->fetch_assoc()) {
            $content[] = $b;
        }
        return $content;
    }

    function getPageTitle($page)
    {
        include('config.php');
        $sql = "SELECT * FROM pages WHERE page_name = '$page'";
        $a = $data->query($sql);
        $b = $a->fetch_array();
        $title = $b["page_title"];
        return $title;
    }

    function getPageDesc($page)
    {
        include('config.php');
        $sql = "SELECT * FROM pages WHERE page_name = '$page'";
        $a = $data->query($sql);
        $b = $a->fetch_array();
        $desc = $b["page_desc"];
        return $desc;
    }

    function getLocationSmall($id)
    {
        include('config.php');
        $a = $data->query("SELECT * FROM location WHERE id = '$id'");
        $b = $a->fetch_array();

        $location_name = $b["location_name"];
        $address = $b["location_address"] . '<br>' . $b["location_city"] . ', ' . $b["location_state"] . ' ' . $b["location_zip"] . '';
        //$addresslink = 'Heritage Tractor '. $b["location_address"].' '.$b["location_city"].', '.$b["location_state"].' '.$b["location_zip"].'';
        $addresslink = $b["location_address"] . '<br>' . $b["location_city"] . ', ' . $b["location_state"] . ' ' . $b["location_zip"] . '';
        $googleadd = $b["location_address"] . ' ' . $b["location_city"] . ', ' . $b["location_state"] . ' ' . $b["location_zip"] . '';
        $addresslinkNew = '<a style="font-size: 13px;" href="http://maps.google.com/?q=' . $address . '">' . $address . '</a>';

        $phoneJson = json_decode($b["location_phones"], true);
        $phoneName = $phoneJson[0]["phoneName"];
        $phoneNum = $phoneJson[0]["phoneNum"];
        $phonelink = '<a style="font-size: 13px;" href="tel:' . $phoneNum . '">' . $phoneNum . '</a>';

        $phone = '<span style="font-size: 13px;">' . $phoneName . ':</span>' . $phonelink;

        if ($b["location_link"] != null) {
            $locationPage = '<div class="col-12 col-sm-12 col-md-12 col-lg-5 col-xl-5 btn btn-success m-1" style="padding: 5px 4px; background-color:#181E22;"><a style="width: 100%; padding: 5px; text-transform: uppercase;" href="Locations/' . $b["location_link"] . '">More Info</a></div>';
        }

        $html = '<div class="col-md-4 locations" data-zipcode="' . $b["location_zip"] . '" data-mileorder="0">
                <div class="row">
                <div class="col-md-12 col-lg-12 col-xl-7" style="padding: 10px 15px;">
                <a href="Locations/' . $b["location_link"] . '"><img src="' . $b["location_img"] . '" alt="" style="width: 100%" /></a><br />
                </div>
                <div class="col-md-12 col-lg-12 col-xl-5" style="padding: 10px 3px;">
                <h4 style="color:#367C2B;"><strong class="vp-font-heavy">' . $location_name . '</strong></h4>
                <p>' . $addresslinkNew . '</p><p>' . $phone . '</p>
                </div>
                <div class="col-md-12 col-lg-12 col-xl-12">
                <div class="row" style="margin-top: 10px;"> ' . $locationPage . '<div class="col-12 col-sm-12 col-md-12 col-lg-5 col-xl-5 btn btn-success btn-light-green m-1" style="padding: 5px 2px;"><a style="width: 100%; padding: 5px; text-transform: uppercase;" href="https://www.google.com/maps/place/' . $googleadd . '" target="_blank">Directions</a></div></div>
                </div>
                </div>
 </div>';

        return $html;
    }


    function getLocationPage($id)
    {
        include('config.php');
        $a = $data->query("SELECT * FROM location WHERE id = '$id'");
        $b = $a->fetch_array();

        $location_name = $b["location_name"];
        $address = $b["location_address"] . '<br>' . $b["location_city"] . ', ' . $b["location_state"] . ' ' . $b["location_zip"] . '';

        $addresslinkNew = '<a href="http://maps.google.com/?q=' . $address . '">' . $address . '</a>';

        $phoneJson = json_decode($b["location_phones"], true);
        $phoneName = $phoneJson[0]["phoneName"];
        $phoneNum = $phoneJson[0]["phoneNum"];

        $phone = $phoneName . ': ' . $phoneNum;

        if ($b["location_link"] != null) {
            $locationPage = '<a class="btn btn-dark btn-sm" href="Locations/' . $b["location_link"] . '">More Info</a>';
        }

        if ($b["form_code"] != null) {
            $formCode = '<div style="background: #457442; padding: 10px; font-size: 20px; font-weight: bold; color: #fff; margin-top: 20px; margin-bottom: 20px;">Contact Us</div>
  <div style="background: #efefef; padding: 20px;">' . $b["form_code"] . '</div>';
        } else {
            $formCode = '';
        }

        if ($b["location_img"] != null) {
            $locImg = '<img src="' . $b["location_img"] . '" alt="" class="img-responsive" /><br />';
        } else {
            $locImg = '';
        }

        $mapOut = '<div class="" style="background:#efefef"><div style="width:20px; height:20px; position:absolute; left:50%; top:50%;"></div>' . $b["location_map"] . '</div>';

        $html .= '<h1>' . $location_name . '</h1><div class="row"><div class="col-lg-8 helper_column_small">
        
        ' . $locImg . '
        ' . $formCode . '
      
       </div><div class="col-lg-4 helper_column_main">
       

  


  <div class="panel panel-success">
   <div class="panel-heading" style="background:#457442">
    <h3 class="panel-title">Location Info</h3>
   </div>
   <div class="panel-body">' . $addresslinkNew . ' <br /><br /> <strong>Phone Numbers</strong>';


        $html .= '<table class="table" style="margin-bottom: 0;">
     <tbody>';

        $phoneLocs = $b["location_phones"];
        $phonAes = json_decode($phoneLocs, true);
        for ($i = 0; $i < count($phonAes); $i++) {
            $html .= '<tr>
       <td>' . $phonAes[$i]["phoneName"] . ':</td>
       <td style="text-align: right;"><a href="tel:' . $phonAes[$i]["phoneNum"] . '">' . $phonAes[$i]["phoneNum"] . '</a></td>
      </tr>';
        }


        $html .= '</tbody>
    </table>';

        $html .= '<strong>Hours (In Season)</strong>';

        $html .= '<table class="table" style="margin-bottom: 0;">
     <tbody>';

        $hoursLocs = $b["location_hours"];
        $hoursAes = json_decode($hoursLocs, true);
        for ($i = 0; $i < count($hoursAes); $i++) {
            $html .= '<tr>
       <td>' . $hoursAes[$i]["day"] . ':</td>
       <td style="text-align: right;">' . $hoursAes[$i]["hours"] . '</td>
      </tr>';
        }


        $html .= '</tbody>
    </table>';

        $html .= '<strong>Hours (Winter)</strong>';

        $html .= '<table class="table" style="margin-bottom: 0;">
     <tbody>';

        $hoursLocs = $b["location_hours2"];
        $hoursAes = json_decode($hoursLocs, true);
        for ($i = 0; $i < count($hoursAes); $i++) {
            $html .= '<tr>
       <td>' . $hoursAes[$i]["day"] . ':</td>
       <td style="text-align: right;">' . $hoursAes[$i]["hours"] . '</td>
      </tr>';
        }


        $html .= '</tbody>
    </table>';
        $html .= '<strong>Email Contacts</strong>';
        $html .= '<table class="table" style="margin-bottom: 0;">
     <tbody>';

        $emailLocs = $b["location_emails"];
        $emailAes = json_decode($emailLocs, true);
        for ($i = 0; $i < count($emailAes); $i++) {
            $html .= ' <tr>
       <td>' . $emailAes[$i]["emailName"] . '</td>
       <td style="text-align: right;"><a href="mailto:' . $emailAes[$i]["emailOut"] . '"><i class="fa fa-envelope"></i> Email</a></td>
      </tr>';
        }

        $html .= '</tbody>
    </table>
   </div>
  </div>
  ' . $mapOut . '
 </div>
 </div>';

        return $html;
    }

    function coreItems()
    {
        include('config.php');
        $sql = "SELECT * FROM site_settings WHERE id = '1'";
        $a = $data->query($sql);
        $b = $a->fetch_array();
        $siteSettings = array("site_name" => $b["site_name"], "site_description" => $b["site_description"], "google_analytics" => $b["google_analytics"], "site_keywords" => $b["site_keywords"]);
        return $siteSettings;
    }

    function getComp($name)
    {
        include('config.php');
        $sql = "SELECT * FROM page_components WHERE component_name = '$name'";
        $a = $data->query($sql);
        $b = $a->fetch_array();
        return $b["content"] . $b["actions"];
    }

    function getInclude($name)
    {
        //include($name);
        ob_start();
        include $name;
        $string = ob_get_clean();
        return $string;
    }



    function getCompScripts($name)
    {
        include('config.php');
        $sql = "SELECT * FROM page_components WHERE component_name = '$name'";
        $a = $data->query($sql);
        $b = $a->fetch_array();
        return $b["actions"];
    }

    function get_all_string_between($string, $start, $end)
    {
        $result = array();
        $string = " " . $string;
        $offset = 0;
        while (true) {
            $ini = strpos($string, $start, $offset);
            if ($ini == 0)
                break;
            $ini += strlen($start);
            $len = strpos($string, $end, $ini) - $ini;
            $result[] = substr($string, $ini, $len);
            $offset = $ini + $len;
        }
        return $result;
    }

    function getBeanItems($tag, $id)
    {

        //
        include('config.php');
        $a = $data->query("SELECT start_time, end_time, bean_type, bean_content   FROM beans WHERE bean_id = '$tag' AND active = 'true'");
        $b = $a->fetch_array();
        if ($b["bean_type"] == 'native') {
            if ($b["start_time"] == 0 && $b["end_time"] == 0) {
                return $b["bean_content"];
            } else {
                if ($b["start_time"] == 0 && time() < $b["end_time"]) {
                    return $b["bean_content"];
                } else {
                    if ($b["end_time"] == 0 && time() >= $b["start_time"]) {
                        return $b["bean_content"];
                    } else {
                        if (time() >= $b["start_time"] && time() < $b["end_time"]) {
                            return $b["bean_content"];
                        }
                    }
                }
            }
        } else {
            //            ob_start();
            //            include 'site-admin/installed_beans/'.$b["bean_folder"].'/output.php';
            //            $string = ob_get_clean();
            //            return $string;
        }
    }


    function processNavs($ars, $ulset)
    {
        include('inc/config.php');
        $nav .= '<ul class="' . $ulset . '">';
        for ($i = 0; $i < count($ars); $i++) {
            if (count($ars[$i]) > 1) {
                $a = $data->query("SELECT * FROM pre_nav WHERE id = '" . $ars[$i]["id"] . "'");
                $b = $a->fetch_array();
                if ($b["nav_target"] != '' && $b["nav_target"] != 'Select Target') {
                    $target = 'target="' . $b["nav_target"] . '""';
                } else {
                    $target = '';
                }
                $nav .= '<li class="' . $b["li_class"] . '"><a href="' . $b["nav_link"] . '" ' . $target . ' class="' . $b["nav_class"] . '" ' . $b["nav_data_attr"] . '>' . $b["nav_read"] . '</a>';
                $nav .= '<div class="dropdown-menu">';

                $nav .= $this->processNavs($ars[$i]["children"], $b["ul_class"]);
                $nav .= '</div>';

                $nav .= '</li>';
            } else {

                $a = $data->query("SELECT * FROM pre_nav WHERE id = '" . $ars[$i]["id"] . "'");
                $b = $a->fetch_array();
                if ($b["nav_target"] != '' && $b["nav_target"] != 'Select Target') {
                    $target = 'target="' . $b["nav_target"] . '""';
                } else {
                    $target = '';
                }

                if ($b["mega_active"] == 'true') {
                    //MEGA MENU STUFF//
                    $nav .= '<li class="' . $b["li_class"] . '"><a href="' . $b["nav_link"] . '" ' . $target . ' class="' . $b["nav_class"] . '" ' . $b["nav_data_attr"] . '>' . $b["nav_read"] . '</a>';
                    $nav .= $b["mega_area"];
                    $nav .= '</li>';
                } else {
                    $nav .= '<li class="' . $b["li_class"] . '"><a href="' . $b["nav_link"] . '" ' . $target . ' class="' . $b["nav_class"] . '" ' . $b["nav_data_attr"] . '>' . $b["nav_read"] . '</a></li>';
                }
            }
        }

        $nav .= '</ul>';

        return $nav;
    }

    function getNavigations($token)
    {
        include('inc/config.php');
        $a = $data->query("SELECT * FROM navigation WHERE navigation_id = '$token'");
        $b = $a->fetch_array();

        $nvjson = json_decode($b["menu_json"], true);
        $navOut = $this->processNavs($nvjson, $b["menu_class"]);

        return $navOut;
    }


    function produceForm($id)
    {
        include('config.php');
        $a = $data->query("SELECT * FROM forms_data WHERE form_name = '$id'");
        $b = $a->fetch_array();
        if ($b["form_class"] != '') {
            $formClass = 'class="' . $b["form_class"] . ' row"';
        } else {
            $formClass = '';
        }

        if ($b["is_multi"] != 'false') {
            $mult = 'multipart/form-data';
        } else {
            $mult = '';
        }

        if ($b["post_link"] != null) {
            $postLink = $b["post_link"];
            $returnIt = '';
        } else {
            $postLink = '';
            $returnIt = 'onsubmit="return false"';
        }

        $form .= '<div id="' . $b["form_name"] . '_alerts"></div>';

        $form .= '<form ' . $formClass . ' name="' . $b["form_name"] . '" id="' . $b["form_name"] . '" ' . $mult . ' action="' . $postLink . '" method="post" ' . $returnIt . '>';
        $form .= '<input type="hidden" name="form_table" id="form_table" value="' . $b["form_name"] . '">';

        $form .= $b["form_elems"];

        $form .= '</form>';

        return $form;
    }

    function getRealIpAddr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
        {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
        {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    function saveCaffEvent($event, $page)
    {
        include('config.php');
        $theIp = $this->getRealIpAddr();

        $a = $data->query("SELECT * FROM caffeine_event_tracker WHERE DATE(FROM_UNIXTIME(date_set)) = CURDATE() AND page = '$page' AND target = '$event' AND user_ip = '$theIp'") or die($data->error);

        if ($a->num_rows > 0) {
        } else {
            if ($page != null) {
                $data->query("INSERT INTO caffeine_event_tracker SET target = '$event', page = '$page', user_ip = '$theIp', date_set = '" . time() . "'") or die($data->error);
                echo 'Good to Go!';
            }
        }
    }

    function getSaves()
    {
        include('config.php');
        if (isset($_COOKIE["savedData"])) {
            $theSessionOut = json_decode($_COOKIE["savedData"], true);
            $total = 0;
            for ($i = 0; $i < count($theSessionOut); $i++) {
                $mydataOut[] = array("machine" => array("id" => $theSessionOut[$i]["machine"]["id"], "name" => $theSessionOut[$i]["machine"]["name"], "eqtype" => $theSessionOut[$i]["machine"]["eqtype"], "price" => $theSessionOut[$i]["machine"]["price"], "url" => $theSessionOut[$i]["machine"]["url"], "eqtab" => $theSessionOut[$i]["machine"]["eqtab"]));
                if ($theSessionOut[$i]["machine"]["eqtype"] == 'deere') {
                    $a = $data->query("SELECT * FROM deere_equipment WHERE id = '" . $theSessionOut[$i]["machine"]["id"] . "'") or die($data->error);
                    $b = $a->fetch_array();
                    $img = 'img/' . $b["eq_image"];
                    $htmlOG .= '<div class="saveblock-' . $theSessionOut[$i]["machine"]["id"] . '" style="display: block; padding: 0; margin: 1px; text-align: center; border-bottom:solid thin #efefef; width:300px">
                    <div class="col-md-4" style="padding: 0"><a href="' . $theSessionOut[$i]["machine"]["url"] . '"><div style="width:50px; height: 50px; background: #efefef; background-image:url(\'' . $img . '\'); background-position: center; background-size:cover  "></div></a></div><div class="col-md-8" style="padding: 0"><a href="' . $theSessionOut[$i]["machine"]["url"] . '">' . $theSessionOut[$i]["machine"]["name"] . '</a><br><a href="javascript:void(0)" onclick="removeSaved(\'' . $theSessionOut[$i]["machine"]["name"] . '\')" class="text-danger"><i class="fa fa-times"></i> remove</a></div>
                    <div class="clearfix"></div>
                </div>';

                    $html .= ' <li class="clearfix">
                            <a href="' . $theSessionOut[$i]["machine"]["url"] . '"><div style="width:50px; height: 50px; background: #efefef; background-image:url(\'' . $img . '\'); background-position: center; background-size:cover;  float:left; margin:20px"></div></a>
                            <span class="item-name">' . $theSessionOut[$i]["machine"]["name"] . '</span>
                            <span class="item-price">$' . number_format($theSessionOut[$i]["machine"]["price"], 2) . '</span>
                            <span class="item-quantity">Quantity: 01</span><br>
                            <a href="javascript:void(0)" onclick="removeSaved(\'' . $theSessionOut[$i]["machine"]["name"] . '\')" class="text-danger"><i class="fa fa-times"></i> remove</a>
                        </li>';
                }
                if ($theSessionOut[$i]["machine"]["eqtype"] == 'honda') {
                    $a = $data->query("SELECT * FROM honda_equipment WHERE id = '" . $theSessionOut[$i]["machine"]["id"] . "'") or die($data->error);
                    $b = $a->fetch_array();
                    $outImg = json_decode($b["eq_image"]);
                    $img = 'img/Honda/' . $outImg[0];
                    $htmlOG .= '<div class="saveblock-' . $theSessionOut[$i]["machine"]["id"] . '" style="display: block; padding: 0; margin: 1px; text-align: center; border-bottom:solid thin #efefef; width:300px">
                    <div class="col-md-4" style="padding: 0"><a href="' . $theSessionOut[$i]["machine"]["url"] . '"><div style="width:50px; height: 50px; background: #efefef; background-image:url(\'' . $img . '\'); background-position: center; background-size:cover  "></div></a></div><div class="col-md-8" style="padding: 0"><a href="' . $theSessionOut[$i]["machine"]["url"] . '">' . $theSessionOut[$i]["machine"]["name"] . '</a><br><a href="javascript:void(0)" onclick="removeSaved(\'' . $theSessionOut[$i]["machine"]["name"] . '\')" class="text-danger"><i class="fa fa-times"></i> remove</a></div>
                    <div class="clearfix"></div>
                </div>';
                    $html .= ' <li class="clearfix">
                            <a href="' . $theSessionOut[$i]["machine"]["url"] . '"><div style="width:50px; height: 50px; background: #efefef; background-image:url(\'' . $img . '\'); background-position: center; background-size:cover;  float:left; margin:20px"></div></a>
                            <span class="item-name">' . $theSessionOut[$i]["machine"]["name"] . '</span>
                            <span class="item-price">$' . number_format($theSessionOut[$i]["machine"]["price"], 2) . '</span>
                            <span class="item-quantity">Quantity: 01</span><br>
                            <a href="javascript:void(0)" onclick="removeSaved(\'' . $theSessionOut[$i]["machine"]["name"] . '\')" class="text-danger"><i class="fa fa-times"></i> remove</a>
                        </li>';
                }

                if ($theSessionOut[$i]["machine"]["eqtype"] == 'stihl') {
                    $a = $data->query("SELECT * FROM stihl_equipment WHERE id = '" . $theSessionOut[$i]["machine"]["id"] . "'") or die($data->error);
                    $b = $a->fetch_array();
                    $outImg = json_decode($b["eq_image"]);
                    $img = 'img/Stihl/' . $outImg[0];
                    $htmlOG .= '<div class="saveblock-' . $theSessionOut[$i]["machine"]["id"] . '" style="display: block; padding: 0; margin: 1px; text-align: center; border-bottom:solid thin #efefef; width:300px">
                    <div class="col-md-4" style="padding: 0"><a href="' . $theSessionOut[$i]["machine"]["url"] . '"><div style="width:50px; height: 50px; background: #efefef; background-image:url(\'' . $img . '\'); background-position: center; background-size:cover  "></div></a></div><div class="col-md-8" style="padding: 0"><a href="' . $theSessionOut[$i]["machine"]["url"] . '">' . $theSessionOut[$i]["machine"]["name"] . '</a><br><a href="javascript:void(0)" onclick="removeSaved(\'' . $theSessionOut[$i]["machine"]["name"] . '\')" class="text-danger"><i class="fa fa-times"></i> remove</a></div>
                    <div class="clearfix"></div>
                </div>';
                    $html .= ' <li class="clearfix">
                            <a href="' . $theSessionOut[$i]["machine"]["url"] . '"><div style="width:50px; height: 50px; background: #efefef; background-image:url(\'' . $img . '\'); background-position: center; background-size:cover;  float:left; margin:20px"></div></a>
                            <span class="item-name">' . $theSessionOut[$i]["machine"]["name"] . '</span>
                            <span class="item-price">$' . number_format($theSessionOut[$i]["machine"]["price"], 2) . '</span>
                            <span class="item-quantity">Quantity: 01</span><br>
                            <a href="javascript:void(0)" onclick="removeSaved(\'' . $theSessionOut[$i]["machine"]["name"] . '\')" class="text-danger"><i class="fa fa-times"></i> remove</a>
                        </li>';
                }

                $total += $theSessionOut[$i]["machine"]["price"];
            }

            if (count($theSessionOut) > 0) {
                return array("count" => count($theSessionOut), "total" => $total, "saves" => $html);
            } else {
                return array("count" => '0', "total" => '0.00', "saves" => '<span style="font-style: italic">Nothing In Your Cart...</span>');
            }
        } else {
            return array("count" => '0', "total" => '0.00', "saves" => '<span style="font-style: italic">Nothing In Your Cart...</span>');
        }
    }

    function updateQty($itemname, $itemid, $realid, $itemqty, $eqtable)
    {
        include('config.php');
        if ($eqtable != null) {
            session_start();
            $theSessionOut = json_decode($_COOKIE["savedData"], true);
            $cartItems = $theSessionOut["cartitems"];
            $shopLocation = $theSessionOut["shop_location"];


            $chk = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'location_select'");
            $chk1 = $chk->fetch_array();
            if ($chk1["setting_value"] == 'true') {


                $a = $data->query("SELECT stock FROM equipment_location_manager WHERE equip_id = '$realid' AND equip_line = '$eqtable' AND location_id = '$shopLocation'") or die('Product Error! - Please try again.' . $data->error);
                if ($a->num_rows > 0) {
                    $b = $a->fetch_array();
                    $currentStock = $b["stock"];

                    if ($itemqty <= $currentStock) {

                        for ($i = 0; $i < count($cartItems); $i++) {
                            if ($cartItems[$i]["itemid"] == $itemid) {
                                $mydata[] = array("id" => $cartItems[$i]["id"], "name" => $cartItems[$i]["name"], "eqtype" => $cartItems[$i]["eqtype"], "price" => $cartItems[$i]["price"], "url" => $cartItems[$i]["url"], "eqtabs" => $cartItems[$i]["eqtabs"], "qty" => $itemqty, "itemid" => $cartItems[$i]["itemid"]);
                            } else {
                                $mydata[] = array("id" => $cartItems[$i]["id"], "name" => $cartItems[$i]["name"], "eqtype" => $cartItems[$i]["eqtype"], "price" => $cartItems[$i]["price"], "url" => $cartItems[$i]["url"], "eqtabs" => $cartItems[$i]["eqtabs"], "qty" => $cartItems[$i]["qty"], "itemid" => $cartItems[$i]["itemid"]);
                            }
                        }
                        $eq = json_encode(array("shop_location" => $shopLocation, "cartitems" => $mydata, "discount_code" => '', "shipping_type" => "", "shipping_token" => "", "shipping_price" => ""));
                        unset($_COOKIE["savedData"]);
                        setcookie("savedData", $eq, time() + (86400 * 30), "/", false);
                        return '{"status": "good","message": "Your cart has been updated."}';
                    } else {
                        //out of stock//
                        return '{"status": "bad","message": "Notice - Not enough in stock."}';
                    }
                } else {
                    return '{"status": "bad","message": "Product Error - No Product Found."}';
                }
            } else {

                $loc = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'default_ship_location'");
                $defloc = $loc->fetch_array();
                $locasel = $defloc["setting_value"];


                $chk = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'sell_per_qty'");
                $chk1 = $chk->fetch_array();

                for ($i = 0; $i < count($cartItems); $i++) {
                    if ($cartItems[$i]["itemid"] == $itemid) {
                        $mydata[] = array("id" => $cartItems[$i]["id"], "name" => $cartItems[$i]["name"], "eqtype" => $cartItems[$i]["eqtype"], "price" => $cartItems[$i]["price"], "url" => $cartItems[$i]["url"], "eqtabs" => $cartItems[$i]["eqtabs"], "qty" => $itemqty, "itemid" => $cartItems[$i]["itemid"]);
                    } else {
                        $mydata[] = array("id" => $cartItems[$i]["id"], "name" => $cartItems[$i]["name"], "eqtype" => $cartItems[$i]["eqtype"], "price" => $cartItems[$i]["price"], "url" => $cartItems[$i]["url"], "eqtabs" => $cartItems[$i]["eqtabs"], "qty" => $cartItems[$i]["qty"], "itemid" => $cartItems[$i]["itemid"]);
                    }
                }
                $eq = json_encode(array("shop_location" => $shopLocation, "cartitems" => $mydata, "discount_code" => '', "shipping_type" => "", "shipping_token" => "", "shipping_price" => ""));

                if ($chk1["setting_value"] == 'true') {
                    $aa = $data->query("SELECT stock FROM equipment_location_manager WHERE location_id = '$locasel' AND equip_id = '$realid' AND equip_line = '$eqtable'");
                    $bb = $aa->fetch_array();
                    if ($bb["stock"] >= $itemqty) {
                        setcookie("savedData", $eq, time() + (86400 * 30), "/", false);
                        return '{"status": "good","message": "Added to cart."}';
                    } else {
                        return '{"status": "good","message": "Not enough stock."}';
                    }
                } else {
                    setcookie("savedData", $eq, time() + (86400 * 30), "/", false);
                    return '{"status": "good","message": "Added to cart."}';
                }
            }
        } else {
            return '{"status": "bad","message": "Product Error - No Product Line Found."}';
        }
    }

    function removeSave($id, $eqtab)
    {
        session_start();
        //unset($_COOKIE['savedData']);
        $theSessionOut = json_decode($_COOKIE["savedData"], true);
        $cartItems = $theSessionOut["cartitems"];
        $shoplocation = $theSessionOut["shop_location"];

        for ($i = 0; $i < count($cartItems); $i++) {
            if ($cartItems[$i]["itemid"] == $id) {
            } else {
                $mydata[] = array("id" => $cartItems[$i]["id"], "name" => $cartItems[$i]["name"], "eqtype" => $cartItems[$i]["eqtype"], "price" => $cartItems[$i]["price"], "url" => $cartItems[$i]["url"], "eqtabs" => $cartItems[$i]["eqtabs"], "qty" => $cartItems[$i]["qty"], "itemid" => $cartItems[$i]["itemid"]);
            }
        }
        $eq = json_encode(array("shop_location" => $shoplocation, "cartitems" => $mydata, "discount_code" => '', "shipping_type" => "", "shipping_token" => "", "shipping_price" => ""));
        unset($_COOKIE["savedData"]);
        setcookie('savedData', '', time() - 60 * 60 * 24, $chatPath); // WebKit
        setcookie('savedData', '', time() - 60 * 60 * 24, $chatPath . '/'); // Gecko, IE
        setcookie("savedData", $eq, time() + (86400 * 30), "/", false);
        //return $mydata;
    }

    function checkCodes($code)
    {
        include('config.php');
        $a = $data->query("SELECT dis_code FROM shop_discounts WHERE dis_code = '" . $data->real_escape_string($code) . "' AND active = 'true'");

        if ($a->num_rows > 0) {
            $theSessionOut = json_decode($_COOKIE["savedData"], true);
            $cartItems = $theSessionOut["cartitems"];
            $shopLocation = $theSessionOut["shop_location"];
            for ($i = 0; $i < count($cartItems); $i++) {
                $mydata[] = array("id" => $cartItems[$i]["id"], "name" => $cartItems[$i]["name"], "eqtype" => $cartItems[$i]["eqtype"], "price" => $cartItems[$i]["price"], "url" => $cartItems[$i]["url"], "eqtabs" => $cartItems[$i]["eqtabs"], "qty" => $cartItems[$i]["qty"], "itemid" => $cartItems[$i]["itemid"]);
            }
            $eq = json_encode(array("shop_location" => $shopLocation, "cartitems" => $mydata, "discount_code" => $code, "shipping_type" => "", "shipping_token" => "", "shipping_price" => ""));
            unset($_COOKIE["savedData"]);
            setcookie("savedData", $eq, time() + (86400 * 30), "/", false);
            return '{"return_code": "1","message": "The code is good"}';
        } else {
            return '{"return_code": "0","message": "The code entered is not valid."}';
        }
    }

    function setShip($ship_code, $ship_price, $ship_read)
    {
        session_start();
        include('config.php');
        $cartRaw = $_COOKIE["savedData"];
        $cartRaw = json_decode($cartRaw, true);
        $theSessionOut = json_decode($_COOKIE["savedData"], true);
        $cartItems = $theSessionOut["cartitems"];
        $shopLocation = $theSessionOut["shop_location"];
        $code = $theSessionOut["discount_code"];
        $setTax = $theSessionOut["applied_tax"];
        $countOut = 0;
        for ($i = 0; $i < count($cartItems); $i++) {
            $mydata[] = array("id" => $cartItems[$i]["id"], "name" => $cartItems[$i]["name"], "eqtype" => $cartItems[$i]["eqtype"], "price" => $cartItems[$i]["price"], "url" => $cartItems[$i]["url"], "eqtabs" => $cartItems[$i]["eqtabs"], "qty" => $cartItems[$i]["qty"], "itemid" => $cartItems[$i]["itemid"]);
            $price = $cartItems[$i]["price"] * $cartItems[$i]["qty"];
            $countOut += str_replace(',', '', $price);
        }
        $eq = json_encode(array("shop_location" => $shopLocation, "cartitems" => $mydata, "discount_code" => $code, "shipping_type" => $ship_read, "shipping_token" => $ship_code, "shipping_price" => $ship_price, "applied_tax" => $setTax));

        //check coupons//
        if ($code != '') {
            $a = $data->query("SELECT percentage_off, date_expire, status FROM shop_discounts WHERE dis_code = '$code' AND active = 'true'") or die($data->error);
            if ($a->num_rows > 0) {
                $b = $a->fetch_array();
                $discountAval = $b["percentage_off"];
                $discountAval = $discountAval / 100;
                $percent = $discountAval * $countOut;
                $countOutFin = $countOut - $percent;
            } else {
                $countOutFin = $countOut;
            }
        } else {
            $countOutFin = $countOut;
        }


        // DO SOME TAX STUFF HERE WOW //
        $checkTax = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'do_tax_stuff'");
        $isTax = $checkTax->fetch_array();

        if ($isTax["setting_value"] == 'true') {

            if ($ship_read != 'Customer Pickup') {

                //OLD TAX PULLER//

                $tax = $setTax;
            } else {
                $location = $cartRaw["shop_location"];
                $tax = $data->query("SELECT tax_rate FROM equipment_tax WHERE relid = '$location' AND active = 'true'");
                $taxOut = $tax->fetch_array();
                if ($taxOut["tax_rate"] != '') {
                    $taxRate = $taxOut["tax_rate"];
                } else {
                    $taxRate = '0';
                }
                $taxrate = $taxRate;
                $tax = $countOutFin * $taxrate / 100;
            }
        } else {
            $tax = '0.00';
        }

        if ($ship_price != '') {
            $countOut = $countOutFin + $tax + $ship_price;
        } else {
            $countOut = $countOutFin + $tax;
        }



        unset($_COOKIE["savedData"]);
        setcookie("savedData", $eq, time() + (86400 * 30), "/", false);

        return json_encode(array("totalAmout" => number_format($countOut, 2), "taxOut" => number_format($tax, 2)));
    }

    function updateSaerch($pagename, $title, $url, $content)
    {
        include('config.php');
        $a = $data->query("SELECT last_crawl,id FROM search_table WHERE pagename = '$pagename'");
        if ($a->num_rows > 0) {
            $b = $a->fetch_array();
            $days = time() - $b["last_crawl"];
            $days = floor($days / (60 * 60 * 24));
            if ($days > 10) {
                $data->query("UPDATE search_table SET page_title = '" . $data->real_escape_string($title) . "', url = '" . $data->real_escape_string($url) . "', page_content = '" . $data->real_escape_string($content) . "', last_crawl = '" . time() . "'");
            }
        } else {
            $data->query("INSERT INTO search_table SET pagename = '$pagename', page_title = '" . $data->real_escape_string($title) . "', url = '" . $data->real_escape_string($url) . "', page_content = '" . $data->real_escape_string($content) . "', last_crawl = '" . time() . "'");
        }
    }

    function findProductDet($name)
    {
        include('config.php');
        $h = $data->query("SELECT * FROM custom_addons WHERE addon_name = '$name'");
        if ($h->num_rows > 0) {
            $i = $h->fetch_array();
            return array("image" => str_replace('../img', '', $i["addon_image"]), "price" => $i["addon_price"], "iscustom" => true, "details" => $i["addon_details"], "new_name" => $i["new_name"], "checkbox" => $i["checkbox"]);
        }
    }


    function processMod($modinfo)
    {
        $mod = explode('-', $modinfo);
        $modName = $mod[0];
        $class = $mod[1];
        $modId = $mod[2];
        require_once('inc/mods/' . $modName . '/processor.php');
        $processContent = new $class;
        $returnProcess = $processContent->runOutput($modId);
        return $returnProcess;
        $processContent = null;
    }

    function getUsedEquipFet()
    {
        include('config.php');

        $a = $data->query("SELECT * FROM used_equipment WHERE featured = 'true' AND active = 'true'");
        while ($b = $a->fetch_array()) {
            $cleanImg = trim($b["images"], ')');
            $cleanImg = trim($cleanImg, '(');
            $cleanImg = stripcslashes($cleanImg);
            $images = json_decode($cleanImg, true);
            $theImages = $images["image"];

            if ($theImages[0]["filePointer"] != '') {
                $theImage = $theImages[0]["filePointer"];
            } else {
                $theImage = 'no-image.png';
            }

            $modelInfo = $b["manufacturer"] . ' ' . $b["model"];

            //            echo $theImage;

            $link = 'Used-Equipment/' . str_replace(' ', '-', $b["category"]) . '/' . str_replace(' ', '-', $b["manufacturer"]) . '-' . str_replace(' ', '-', $b["model"]) . '-' . $b["id"];

            /*$html .= '<div class="col-md-3 col-sm-6 col-xs-6 col-unisp-12 item new" style="display: inline-block;">
                        <div class="row no-gutters">
                            <div class="col-md-12" style="background-color: white;" align="left">
                                <div style="position: relative;">
                                    <a href="' . $link . '" aria-label="' . $modelInfo . '">
                                        <img class="lozad img-responsive" src="' . $theImage . '"  data-cafftrak="' . $b["featured_value"] . '" style="position: relative; width: 100%; object-fit:cover;"/>
                                        <span class="proxima-nova heavy font-medium my-auto shadow" style="font-size: 22px; background: #367C2B;color: white;padding: 10px 20px 10px 20px;position:absolute;right:-5%;top: 90%;"><i>$' . number_format(floatval($b["single_price"])) . '</i></span>
                                    </a>
                                </div>
                                <p style="margin-top: 10%; margin-left: 12px;"><a href="' . $link . '" class="font-medium proxima-nova heavy" style="font-size: 26px; font-style: italic;">' . $modelInfo . '</a><br/><span style="color: #585858; margin-top: -10px;">Stock #: ' . $b["stockNumber"] . '</span><br></p>
                            </div>
                        </div>
                    </div>';*/
            $html .= '<div class="col-md-6 col-lg-4 col-xl-3">
                <div class="row no-gutters">
                    <div class="col-md-12">
                        <div class="used-image-container">
                            <a href="' . $link . '" aria-label="' . $modelInfo . '">
                                <img class="used-image" src="' . $theImage . '"  data-cafftrak="' . $b["featured_value"] . '" style="height: 200.25px; width: 100%; object-fit: cover;"/>
                                <span class="proxima-nova heavy font-medium my-auto shadow used-price"><i>$' . number_format(floatval($b["single_price"])) . '</i></span>
                            </a>
                        </div>
                        <div class="used-container pt-3" align="left">
                            <br>
                            <a class="used-title proxima-nova heavy" href="' . $link . '"><i>' . $modelInfo . '</i></a>
                            <br>
                            <a class="used-details proxima-nova light">Stock #: ' . $b["stockNumber"] . '</a>
                        </div>
                    </div>
                </div>
            </div>';
        }

        return $html;
    }

    function mailIt($toArs, $fromemail, $fromName, $subject, $message)
    {
        // Import the Postmark Client Class:
        include('config.php');

        $a = $data->query("SELECT * FROM mail_settings WHERE id = '1'");
        $b = $a->fetch_array();
        $client = new PostmarkClient($b["postmrk_ids"]);

        for ($i = 0; $i <= count($toArs); $i++) {
            if ($toArs[$i]["name"] != '' && $toArs[$i]["email"] != '') {
                $toEmails .= $toArs[$i]["email"] . ',';
            }
        }

        $toEmails = rtrim($toEmails, ',');

        // Send an email:
        $sendResult = $client->sendEmail(
            $b["frm_email"],
            $toEmails,
            $subject,
            $message
        );
    }
}
