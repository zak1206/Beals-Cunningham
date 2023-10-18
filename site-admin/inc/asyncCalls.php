<?php
$act = $_REQUEST["action"];
include('caffeine.php');
$site = new caffeine();
$userArray = $site->auth();

if($act == 'getpageLines'){
    $pages = $site->getPages();
    $html .= '<table class="table table-bordered">
    <thead>
      <tr>
        <th>Page</th>
        <th style="text-align: right">Action</th>
      </tr>
    </thead>
    <tbody>';
    $j=0;
    for($i=0; $i< count($pages); $i++){
        if($pages[$i]["active"] != 'false' && $pages[$i]["page_type"] != 'link') {
            if($j == 0){
                $j=1;
                $back = 'background:#fff';
            }else{
                $j=0;
                $back = '';
            }

            if($pages[$i]["page_lock"] == 'User' || $pages[$i]["page_lock"] == 'false' || $pages[$i]["page_lock"] == 'none'){
                if($userArray["user_type"] == 'Developer' || $userArray["user_type"] == 'Admin' || $userArray["user_type"] == 'User' || $pages[$i]["page_lock"] == 'false' || $pages[$i]["page_lock"] == 'none'){
                    $editCon = '<a href="edit-page.php?id=' . $pages[$i]["id"] . '" style="" class="btn btn-xs btn-success"><i class="fa fa-pencil"></i> Edit</a>';
                }else{
                    $editCon = '<button style="" class="btn btn-xs btn-warning" disabled><i class="fa fa-pencil"></i> Page Locked :( </button>';
                }
            }else{
                if($pages[$i]["page_lock"] == 'Admin' && $userArray["user_type"] == 'Admin' || $pages[$i]["page_lock"] == 'Admin' && $userArray["user_type"] == 'Developer' || $pages[$i]["page_lock"] == 'Developer' && $userArray["user_type"] == 'Developer'){
                    $editCon = '<a href="edit-page.php?id=' . $pages[$i]["id"] . '" style="" class="btn btn-xs btn-success"><i class="fa fa-pencil"></i> Edit</a>';
                }else{
                    $editCon = '<button style="" class="btn btn-xs btn-warning" disabled><i class="fa fa-pencil"></i> Page Locked :( </button>';
                }

            }

            $html .= '
      <tr style="' . $back . '">
        <td><h4 style="display:block; padding:3px;">' . $pages[$i]["page_name"] .'</h4></td>
        <td style="text-align:right">'.$editCon.'</td>
      </tr>';
        }
    }
    $html .= '</tbody>
  </table>';

    session_start();
    $_SESSION["page_view_options"] = 'lines';

    echo $html;
}

if($act == 'getpageBoxs'){
    $pages = $site->getPages();
    $j=0;
    for($i=0; $i< count($pages); $i++){

        if($pages[$i]["page_lock"] == 'User' || $pages[$i]["page_lock"] == 'false' || $pages[$i]["page_lock"] == 'none'){
            if($userArray["user_type"] == 'Developer' || $userArray["user_type"] == 'Admin' || $userArray["user_type"] == 'User' || $pages[$i]["page_lock"] == 'false' || $pages[$i]["page_lock"] == 'none'){
                $editCon = '<a href="edit-page.php?id=' . $pages[$i]["id"] . '" style="position: absolute; right:20px; top: 20px" class="btn btn-xs btn-success"><i class="fa fa-pencil"></i> Edit</a>';
            }else{
                $editCon = '<button style="position: absolute; right:20px; top: 20px" class="btn btn-xs btn-warning" disabled><i class="fa fa-pencil"></i> Page Locked :( 1</button>';
            }
        }else{
            if($pages[$i]["page_lock"] == 'Admin' && $userArray["user_type"] == 'Admin' || $pages[$i]["page_lock"] == 'Admin' && $userArray["user_type"] == 'Developer' || $pages[$i]["page_lock"] == 'Developer' && $userArray["user_type"] == 'Developer'){
                $editCon = '<a href="edit-page.php?id=' . $pages[$i]["id"] . '" style="position: absolute; right:20px; top: 20px" class="btn btn-xs btn-success"><i class="fa fa-pencil"></i> Edit</a>';
            }else{
                $editCon = '<button style="position: absolute; right:20px; top: 20px" class="btn btn-xs btn-warning" disabled><i class="fa fa-pencil"></i> Page Locked :( 2</button>';
            }

        }

        if($pages[$i]["active"] != 'false'  && $pages[$i]["page_type"] != 'link') {
            $html .= '<div class="col-md-4 cards" style="text-align: center; background: ' . $pages[$i]["color"] . '; padding: 50px; position: relative; margin:0px">
            '.$editCon.'
            <h4 style="display:block; padding:3px; background:#efefef;">' . $pages[$i]["page_name"] . '</h4></div>';
        }
    }
    session_start();
    $_SESSION["page_view_options"] = 'boxes';

    echo $html;
}

if($act == 'createpage'){
    $valSet = $site->createPage($_POST);
    echo $valSet;
}

if($act == 'deletepage'){
    $site->deletePage($_REQUEST["pageid"]);
}

if($act == 'getbeansLine'){
    $bean = $site->getBeans();
    $html .= '<table class="table table-bordered">
    <thead>
      <tr>
        <th style="font-weight: bold;background: #5d5d5d;color: #fff; border-right:solid thin #efefef">Bean Name</th>
        <th style="font-weight: bold;background: #5d5d5d;color: #fff; border-right:solid thin #efefef">Category</th>
        <th style="font-weight: bold;background: #5d5d5d;color: #fff; border-right:solid thin #efefef">Status</th>
        <th style="font-weight: bold;background: #5d5d5d;color: #fff; border-right:solid thin #efefef">Action</th>
      </tr>
    </thead>
    <tbody>';
    $j=0;
    for($i=0; $i< count($bean); $i++){
        if($j == 0){
            $j=1;
            $back = 'background:#fff';
        }else{
            $j=0;
            $back = '';
        }

        if($bean[$i]["bean_lock"] == 'User' || $bean[$i]["bean_lock"] == 'false' || $bean[$i]["bean_lock"] == 'none' || $bean[$i]["bean_lock"] == ''){
            if($userArray["user_type"] == 'Developer' || $userArray["user_type"] == 'Admin' || $userArray["user_type"] == 'User' || $bean[$i]["bean_lock"] == 'false' || $bean[$i]["bean_lock"] == 'none' || $bean[$i]["bean_lock"] == ''){
                $editCon = '<a href="edit-content.php?id=' . $bean[$i]["id"] . '" style="" class="btn btn-xs btn-success"><i class="ti-check"></i> Checkout</a>';
            }else{
                $editCon = '<button style="" class="btn btn-xs btn-warning" disabled><i class="fa fa-pencil"></i> Bean Locked :( a</button>';
            }
        }else{
            if($bean[$i]["bean_lock"] == 'Admin' && $userArray["user_type"] == 'Admin' || $bean[$i]["bean_lock"] == 'Admin' && $userArray["user_type"] == 'Developer' || $bean[$i]["bean_lock"] == 'Developer' && $userArray["user_type"] == 'Developer'){
                $editCon = '<a href="edit-content.php?id=' . $bean[$i]["id"] . '" style="" class="btn btn-xs btn-success"><i class="ti-check"></i> Checkout</a>';
            }else{
                $editCon = '<button style="" class="btn btn-xs btn-warning" disabled><i class="fa fa-pencil"></i> Bean Locked :( b</button>';
            }

        }

        if($bean[$i]["category"] != ''){
            $catOut = $bean[$i]["category"];
        }else{
            $catOut = 'Not Set';
        }

        if($bean[$i]["end_time"] != 0 && time() >= $bean[$i]["end_time"]){
            $expired = '<span style="color:red">Expired: '.date('m/d/Y h:i A',$bean[$i]["end_time"]).'</span>';

        }else{
            $expired = '<span style="color:green">Active</span>';
        }

        if($_REQUEST["cat"] != 'none'){
            if($_REQUEST["cat"] == $catOut){
                $html .= '
      <tr>
        <td>' . $bean[$i]["bean_name"] . '</td>
        <td>'.$catOut.'</td>
        <td>'.$expired.'</td>
        <td style="text-align: right">'.$editCon.'</td>
      </tr>';
            }
        }else{
            $html .= '
      <tr>
        <td>' . $bean[$i]["bean_name"] . '</td>
        <td>'.$catOut.'</td>
        <td>'.$expired.'</td>
        <td style="text-align: right">'.$editCon.'</td>
      </tr>';
        }


    }

    $html .= '</tbody>
  </table>';

    session_start();
    $_SESSION["bean_view_options"] = 'lines';

    echo $html;
}

if($act == 'getbeansBoxes'){
    $bean = $site->getBeans();
    $j=0;
    for($i=0; $i< count($bean); $i++){

        if($bean[$i]["bean_lock"] == 'User' || $bean[$i]["bean_lock"] == 'false' || $bean[$i]["bean_lock"] == 'none' || $bean[$i]["bean_lock"] == ''){
            if($userArray["user_type"] == 'Developer' || $userArray["user_type"] == 'Admin' || $userArray["user_type"] == 'User' || $bean[$i]["bean_lock"] == 'false' || $bean[$i]["bean_lock"] == 'none'|| $bean[$i]["bean_lock"] == ''){
                $editCon = '<a href="edit-content.php?id=' . $bean[$i]["id"] . '" style="position: absolute; right:20px; top: 20px" class="btn btn-xs btn-success"><i class="fa fa-pencil"></i> Edit</a>';
            }else{
                $editCon = '<button style="position: absolute; right:20px; top: 20px" class="btn btn-xs btn-warning" disabled><i class="fa fa-pencil"></i> Bean Locked :( a</button>';
            }
        }else{
            if($bean[$i]["bean_lock"] == 'Admin' && $userArray["user_type"] == 'Admin' || $bean[$i]["bean_lock"] == 'Admin' && $userArray["user_type"] == 'Developer' || $bean[$i]["bean_lock"] == 'Developer' && $userArray["user_type"] == 'Developer'){
                $editCon = '<a href="edit-content.php?id=' . $bean[$i]["id"] . '" style="position: absolute; right:20px; top: 20px" class="btn btn-xs btn-success"><i class="fa fa-pencil"></i> Edit</a>';
            }else{
                $editCon = '<button style="position: absolute; right:20px; top: 20px" class="btn btn-xs btn-warning" disabled><i class="fa fa-pencil"></i> Bean Locked :( b</button>';
            }

        }

        if($bean[$i]["category"] != ''){
            $catOut = $bean[$i]["category"];
        }else{
            $catOut = 'Not Set';
        }

        if($_REQUEST["cat"] != 'none') {
            if ($_REQUEST["cat"] == $catOut) {
                echo '<div class="col-md-4 cards" style="text-align: center; background: '.$bean[$i]["color"].'; padding: 50px; position: relative; margin:0px">
        <button style="position: absolute; left:20px; top: 20px" class="btn btn-xs btn-default" disabled>Cat: '.$catOut.'</button>
            '.$editCon.'
            <h4 style="display:block; padding:3px; background:#efefef;">'.$bean[$i]["bean_name"].'</h4></div>';
            }
        }else{
            echo '<div class="col-md-4 cards" style="text-align: center; background: '.$bean[$i]["color"].'; padding: 50px; position: relative; margin:0px">
        <button style="position: absolute; left:20px; top: 20px" class="btn btn-xs btn-default" disabled>Cat: '.$catOut.'</button>
            '.$editCon.'
            <h4 style="display:block; padding:3px; background:#efefef;">'.$bean[$i]["bean_name"].'</h4></div>';
        }
    }

    echo $html;

    session_start();
    $_SESSION["bean_view_options"] = 'boxes';
}

if($act == 'deletebean'){
    $beanid = $_REQUEST["beanid"];
    $site->deleteBean($beanid);
}

if($act == 'setmenu'){
$_POST['list'];
    $postJson = json_encode($_POST["list"]);
    $site->updateMenu($_REQUEST["menuid"],$postJson);
}

if($act == 'checknavs'){
$request = $site->removeNavObj($_REQUEST["id"],$_REQUEST["menuid"]);
    $site->navItemActive($_REQUEST["menuid"]);

}

if($act == 'getnavLines'){
    $nav = $site->getNavList();
    $html .= '<table class="table table-bordered">
    <thead>
      <tr>
        <th>Menu Name</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>';
    $j = 0;
    for($i=0; $i< count($nav); $i++){

        if($j == 0){
            $j = 1;
            $back = 'background:#fff';
        }else{
            $j = 0;
            $back = '';
        }
        $html .= '
      <tr style="'.$back.'">
        <td><h4 style="display:block; padding:3px;">'.$nav[$i]["menu_name"].'</h4></td>
        <td><a href="edit-menu.php?id='.$nav[$i]["id"].'" style="margin-top: 11px;" class="btn btn-xs btn-success"><i class="fa fa-pencil"></i> Edit</a></td>
      </tr>';
    }
    $html .= '</tbody>
  </table>';

    session_start();
    $_SESSION["nav_view_options"] = 'lines';

    echo $html;
}

if($act == 'getnavBoxs'){
$nav = $site->getNavList();
$j=0;
for($i=0; $i< count($nav); $i++){
    $html .= '<div class="col-md-4 cards" style="text-align: center; background: '.$nav[$i]["color"].'; padding: 50px; position: relative; margin:0px">
            <a href="edit-menu.php?id='.$nav[$i]["id"].'" style="position: absolute; right:20px; top: 20px" class="btn btn-xs btn-success"><i class="fa fa-pencil"></i> Edit</a>
            <h4 style="display:block; padding:3px; background:#efefef;">'.$nav[$i]["menu_name"].'</h4></div>';
}

    session_start();
    $_SESSION["nav_view_options"] = 'boxes';

echo $html;
}

if($act == 'callbeans'){
    $beans = $site->getBeans();
    $html .= '<p>Select one of the following beans and copy and paste into page areas.</p>';
    $html .= '<div style="width:100%;" class="btn-group thefiltercontent" role="group" aria-label="Basic example">
                                            <button style="width: 33%" type="button" class="btn btn-primary btn-xs btn-fill active filterbuttoncontent" data-type="content" onclick="sortContents(\'content\')">Content</button>
                                            <button style="width: 33%" type="button" class="btn btn-primary btn-xs btn-fill filterbuttoncontent" data-type="form" onclick="sortContents(\'forms\')">Forms</button>
                                            <button style="width: 33%" type="button" class="btn btn-primary btn-xs btn-fill filterbuttoncontent" data-type="form" onclick="sortContents(\'locations\')">Locations</button>
                                        </div>';
    $html .= '<div style="height: 20px"></div>';
    $html .= '<div class="right-inner-addon" style="position: relative"><i style="position: absolute; right:20px; top: 13px" class="fa fa-search"></i><input type="search" id="beansearch" name="beansearch" class="form-control"  placeholder="Search" onkeyup="searchBeans()"/></div><br>';
    $html .= '<div id="bean-ser-holder" style="height: 300px; overflow-y: scroll">';
    $html .= '<table class="table table-bordered">';
    $html .='<thead></thead><tr><th>Bean Name</th><th>Category</td><th>Bean Code</td></th></thead>';

    for($i=0;$i<count($beans);$i++){
        $cat = $beans[$i]["category"];
        if($cat != ''){
            $catOut = $beans[$i]["category"];
        }else{
            $catOut = '<span style="font-style: italic; color:#ff7471">Not Set</span>';
        }
        $html .= '<tr><td>'.$beans[$i]["bean_name"].'</td><td>'.$catOut.'</td><td>

        <div class="input-group">
      <input type="text" class="form-control" value="{bean}'.$beans[$i]["bean_id"].'{/bean}" readonly="readonly">
      <span class="input-group-btn">
        <button class="btn btn-primary btn-fill copysett" type="button" data-clipboard-text="{bean}'.$beans[$i]["bean_id"].'{/bean}">Copy</button>
      </span>
    </div>
        </td></tr>';
    }


    $html .= '</table>';
    $html .= '</div>';

    echo $html;
}

if($act == 'searchbeans'){
    if($_REQUEST["type"] == 'content') {


        $beans = $site->searchBeans($_REQUEST["beanitem"]);
        $html .= '<table class="table table-bordered">';
        $html .= '<thead></thead><tr><th>Bean Name</th><th>Category</td><th>Bean Code</td></th></thead>';

        for ($i = 0; $i < count($beans); $i++) {
            $html .= '<tr><td>' . $beans[$i]["bean_name"] . '</td><td>' . $beans[$i]["category"] . '</td><td><input type="text"class="form-control selectall" id="bean' . $beans[$i]["id"] . '" name="bean' . $beans[$i]["id"] . '" value="{bean}' . $beans[$i]["bean_id"] . '{/bean}" onfocus="this.select();" readonly="readonly"></td></tr>';
        }

        $html .= '</table>';
    }else{
        $form = $site->searchForms($_REQUEST["beanitem"]);
        $html .= '<table class="table table-bordered">';
        $html .= '<thead></thead><tr><th>Form Name</th><th>Form Code</td></th></thead>';

        for ($i = 0; $i < count($form); $i++) {
            $html .= '<tr><td>' . $form[$i]["form_name"] . '</td><td><input type="text"class="form-control selectall" id="form' . $form[$i]["id"] . '" name="form' . $form[$i]["id"] . '" value="{form}' . $form[$i]["id"] . '{/form}" onfocus="this.select();" readonly="readonly"></td></tr>';
        }

        $html .= '</table>';
    }
    echo $html;
}

if($act == 'recallbeans'){
    $beans = $site->getBeans();
    $html .= '<table class="table table-bordered">';
    $html .='<thead></thead><tr><th>Bean Name</th><th>Category</td><th>Bean Code</td></th></thead>';

    for($i=0;$i<count($beans);$i++){
        $cat = $beans[$i]["category"];
        if($cat != ''){
            $catOut = $beans[$i]["category"];
        }else{
            $catOut = '<span style="font-style: italic; color:#ff7471">Not Set</span>';
        }
        $html .= '<tr><td>'.$beans[$i]["bean_name"].'</td><td>'.$catOut.'</td><td>

        <div class="input-group">
      <input type="text" class="form-control" value="{bean}'.$beans[$i]["bean_id"].'{/bean}" readonly="readonly">
      <span class="input-group-btn">
        <button class="btn btn-primary btn-fill copysett" type="button" data-clipboard-text="{bean}'.$beans[$i]["bean_id"].'{/bean}">Copy</button>
      </span>
    </div>
        </td></tr>';
    }


    $html .= '</table>';

    echo $html;
}

if($act == 'getforms'){
    $forms = $site->getForms();
    $html .= '<table class="table table-bordered">';
    $html .='<thead></thead><tr><th>Form Name</th><th>Form Code</th></thead>';

    for($i=0;$i<count($forms);$i++){
        $html .= '<tr><td>'.$forms[$i]["form_name"].'</td><td>

        <div class="input-group">
      <input type="text" class="form-control" value="{form}'.$forms[$i]["id"].'{/form}" readonly="readonly">
      <span class="input-group-btn">
        <button class="btn btn-primary btn-fill copysett" type="button" data-clipboard-text="{form}'.$forms[$i]["id"].'{/form}">Copy</button>
      </span>
    </div>
        </td></tr>';
    }


    $html .= '</table>';

    echo $html;
}

if($act == 'getlocs'){
    $loc= $site->getLocations();
    $html .= '<table class="table table-bordered">';
    $html .='<thead></thead><tr><th>Location Name</th><th>Location Box Code</th><th>Location Page Code</th></thead>';

    for($i=0;$i<count($loc);$i++){
        $html .= '<tr><td>'.$loc[$i]["location_name"].'</td><td>

        <div class="input-group">
      <input type="text" class="form-control" value="{locsmall}'.$loc[$i]["id"].'{/locsmall}" readonly="readonly">
      <span class="input-group-btn">
        <button class="btn btn-primary btn-fill copysett" type="button" data-clipboard-text="{locsmall}'.$loc[$i]["id"].'{/locsmall}">Copy</button>
      </span>
    </div>
        </td>
        <td>
        <div class="input-group">
      <input type="text" class="form-control" value="{locpage}'.$loc[$i]["id"].'{/locpage}" readonly="readonly">
      <span class="input-group-btn">
        <button class="btn btn-primary btn-fill copysett" type="button" data-clipboard-text="{locpage}'.$loc[$i]["id"].'{/locpage}">Copy</button>
      </span>
    </div>
        </td></tr>';
    }


    $html .= '</table>';

    echo $html;
}

if($act == 'deletelocation'){
    $site->deleteLocation($_REQUEST["locationid"]);
}

if($act == 'updateimgpos'){
    $profid = $_REQUEST["profid"];
    $lefts = $_REQUEST["left"];
    $top = $_REQUEST["top"];
    $site->updateImgPos($profid,$lefts,$top);
}

if($act == 'getpagesfiles'){
    $pages = $site->getPages();
    $html .='<h3>Site Pages</h3>';
    $html .= '<table class="table" style="width: 100%">
    <thead>
      <tr>
        <th>Page</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>';
    $j=0;
    for($i=0; $i< count($pages); $i++){
        if($j==0){$back = 'background:#fff';$j=1;}else{$back = '';$j=0;}
        if($pages[$i]["active"] != 'false' && $pages[$i]["page_type"] != 'link') {
            $html .= '
      <tr style="' . $back . '">
        <td><span style="display:block; padding:3px;">' . $pages[$i]["page_name"] . '</span></td>
        <td><button style="margin-top: 0px;" class="btn btn-xs btn-success" onClick="insertLink(\''.$pages[$i]["page_name"].'\')" type="button"><i class="fa fa-link"></i> Add Link</button></td>
      </tr>';
        }
    }
    $html .= '</tbody>
  </table>';

    echo $html;
}

if($act == 'captureversion'){
    $content = $site->renderContent($_REQUEST["id"]);
    echo str_replace('../../../../img','../img',$content);
    echo '<div style="clear:both"></div>';
}

if($act == 'restoreversion'){
    $type = $_REQUEST["type"];
    echo $site->restorePageContent($_REQUEST["id"],$type);
}

if($act == 'createbackup'){
    $type = $_REQUEST["type"];
    if($type == 'header'){
        copy("../../inc/header.php","../../inc/backups/header-".date('m-d-Y His').".php");
        echo '<i class="fa fa-floppy-o" aria-hidden="true"></i> &nbsp; &nbsp; Header Backup Created Successfully!';
    }

    if($type == 'footer'){
        copy("../../inc/footer.php","../../inc/backups/footer-".date('m-d-Y His').".php");
        echo '<i class="fa fa-floppy-o" aria-hidden="true"></i> &nbsp; &nbsp; Header Backup Created Successfully!';
    }

    if($type == 'sitejs'){
        copy("../../js/site.js","../../inc/backups/site-".date('m-d-Y His').".js");
        echo '<i class="fa fa-floppy-o" aria-hidden="true"></i> &nbsp; &nbsp; JS Backup Created Successfully!';
    }

}

if($act == 'lockpage'){
$theReturn = $site->lockPage($_REQUEST["id"]);
    echo json_encode($theReturn);
}

if($act == 'checkpage'){
    $PageCheck = $site->checkPage($_REQUEST["pageid"]);
    echo $PageCheck;
}

if($act == 'reviewcodes'){
    include('finediff-code.php');
    $ccheckContent = $site->getPageRepoLine($_REQUEST["id"]);
    $old = $ccheckContent["old"];
    $new = $ccheckContent["new"];
    $opcodes = FineDiff::getDiffOpcodes($old, $new);
    $to_text = FineDiff::renderDiffToHTMLFromOpcodes($old, $opcodes);


    echo '<code id="htmldiff">';
    echo $to_text;
    echo '</code>';
//    include('class.Diff.php');
//    $ccheckContent = $site->getPageRepoLine($_REQUEST["id"]);
//    echo Diff::toTable(Diff::compare($ccheckContent["old"], $ccheckContent["new"]));

}

if($act == 'externallink'){
    $images = scandir("../../img", 1);
    foreach($images as $key){
        if($key != '.' && $key != '..' && $key != '.DS_Store') {
            $imgout[] = array('thumb'=>'../img/'.$key,'image'=>'../img/'.$key,'title'=>'');
        }
    }


    $pages = $site->getPages();

    $html .= '<div class="pagessethold" style="padding: 2px; background: #efefef; margin: 10px; font-size: 12px; display: none; height: 150px; overflow-y: scroll"><table class="table table-bordered dataTable no-footer"><thead>
      <tr role="row"><th>Page</th><th style="text-align: right">Action</th></tr>
    </thead>';

    for($i=0; $i < count($pages); $i++){
        $html .='<tr><td>'.$pages[$i]["page_name"].'</td><td style="text-align:right"><a href="javascript:addToBox(\''.$pages[$i]["page_name"].'\')">Add Link</a></td></tr>';
    }

    $html .='</table></div>';
    $html .= '<div class="input-group"><input type="text" name="externallink" id="externallink" class="form-control" placeholder="http://yoursite.com" value="" required=""><span class="input-group-btn"><button class="btn btn-default" type="button" onclick="viewPageslLinks()"><i class="fa fa-list" aria-hidden="true"></i></button></span></div><!-- /input-group -->';
    $html .= '<br><input type="text" class="form-control" id="readlink" name="readlink" placeholder="Link to Read" required=""><br> - OR - <br><br> <a href="javascript:opendImgsd()">Use Image as Click Area</a> ';
    $html .= '<div class="imagesection" style="display: none">';
    $html .= '<hr><strong>Image Properties</strong><br><small>You can enter you image properties here but you must do so before image selection.</small><br><div class="col-md-3"><label>Image Width</label><br><input type="text" style="max-width: 100px" class="form-control input-sm" name="imgwid" id="imgwid" value=""></div>';
    $html .= '<div class="col-md-3"><label>Image Height</label><br><input type="text" style="max-width: 100px" class="form-control input-sm" name="imghe" id="imghe" value=""></div>';
    $html .= '<div class="col-md-3"><label>Image Class</label><br><input type="text" style="max-width: 100px" class="form-control input-sm" name="imgclass" id="imgclass" value=""></div>';
    $html .= '<div class="clearfix"></div>';
    $html .= '<input type="hidden" id="isimage" name="isimage" value="">';
    $html .='<div class="imagesethold" style="padding: 2px; background: #efefef; margin: 10px; font-size: 12px; display: block; height: 220px; overflow-y: scroll">';

    for($j=0; $j<count($imgout); $j++){
        if(exif_imagetype('../'.$imgout[$j]["thumb"])) {
            $correctImg = str_replace('../','',$imgout[$j]["thumb"]);
            $html .= '<img style="width:70px" class="img-thumbnail" src="'.$imgout[$j]["thumb"].'" onClick="addToBoxView(\''.$correctImg.'\')"/>';
        }
    }

    $html .= '</div>';
    $html .= '<small></small><a href="javascript:openUploadimg()">Upload New Image</a></small><br><div class="imgloads" style="display: none"><hr><form id="imageform" method="post" enctype="multipart/form-data"><strong>Upload New Image</strong>
    <input name="image" type="file" /><br>
    <button type="submit" class="btn btn-xs btn-primary">Upload New Image</button> <span class="loads" style="display: none"> | <img style="width: 20px" src="img/small_ld.gif"/> uploading...</span>
</form></div>';
    $html .= '<a href="javascript:opendImgsd()">Close Image Selection</a>';
    $html .= '</div>';
    $html .= '<div style="clear: both"></div><hr><button class="btn btn-primary" type="button" onclick="createExterna()">Create External Link</button>';
    echo $html;
}


if($act == 'uploadnewimage') {

    $dir = '../../img/';

    $_FILES['image']['type'] = strtolower($_FILES['image']['type']);

    if ($_FILES['image']['type'] == 'image/png'
        || $_FILES['image']['type'] == 'image/jpg'
        || $_FILES['image']['type'] == 'image/gif'
        || $_FILES['image']['type'] == 'image/jpeg'
        || $_FILES['image']['type'] == 'image/pjpeg'
    ) {
        // setting file's mysterious name
        $filename = md5(date('YmdHis')) . '.jpg';
        $file = $dir . $filename;

        // copying
        move_uploaded_file($_FILES['image']['tmp_name'], $file);

        // displaying file
        $array = array(
            'filelink' => '../img/' . $filename
        );

        echo stripslashes(json_encode($array));
    }
}

if($act == 'refreshimgs'){
    $images = scandir("../../img", 1);
    foreach($images as $key){
        if($key != '.' && $key != '..' && $key != '.DS_Store') {
            $imgout[] = array('thumb'=>'../img/'.$key,'image'=>'../img/'.$key,'title'=>'');
        }
    }

    for($j=0; $j<count($imgout); $j++){
        if(exif_imagetype('../'.$imgout[$j]["thumb"])) {
            $correctImg = str_replace('../','',$imgout[$j]["thumb"]);
            $html .= '<img style="width:70px" class="img-thumbnail" src="'.$imgout[$j]["thumb"].'" onClick="addToBoxView(\''.$correctImg.'\')"/>';
        }
    }

    echo $html;
}

if($act == 'createnav'){
    $html .= '<form name="createnav" id="createnav" method="post" action="">';
    $html .= '<div class="createmess"></div>';
    $html .= '<label>Menu Name</label><br>';
    $html .= '<input type="text" class="form-control" name="menu_name" id="menu_name" value=""><br>';
    $html .= '<button class="btn btn-success">Create</button>';
    $html .= '</form>';

    echo $html;
}

if($act == 'changemenuinfo'){
    $site->updateMenuInfo($_POST);
}

if($act == 'completenavcreate'){
    echo $site->createNavi($_POST);
}

if($act == 'createimagevan'){
    $externallink = $_REQUEST["externallink"];
    $readlink = $_REQUEST["readlink"];
    $site->createExternalLink($externallink,$readlink);
}

if($act == 'addnavobject'){
    echo $site->createMenuShell($_POST);
}

if($act == 'addsinglenavobject'){

    //var_dump($_POST);
    echo $site->addMenuItem($_POST);
}

if($act == 'updatenavigation'){
$site->updatesNavi($_POST);
}

if($act == 'editnavobject'){
    $id = $_REQUEST["id"];
    echo json_encode($site->getSingleNavObj($id));
}

if($act == 'removesinglenavobject'){

}

if($act == 'getnavobjects'){
    $navigationMenuObjects = $site->getNavObjects($_REQUEST["menuid"]);
    $html .= '<table class="table"><thead><tr><th>Is Active</th><th>Nav Read / Image</th><th>Nav Link</th><th style="text-align: right">Actions</th></tr></thead><tbody>';
    for($i=0; $i < count($navigationMenuObjects); $i++) {
        if($navigationMenuObjects[$i]["active"] == 'true'){
            $activeCheck = 'checked="checked"';
        }else{
            $activeCheck = '';
        }
        if($navigationMenuObjects[$i]["is_image"] == 'true'){
            $read = '<img class="img-thumbnail" src="'.$navigationMenuObjects[$i]["nav_read"] .'" style="max-height:27px"/>';
        }else{
            $read = $navigationMenuObjects[$i]["nav_read"];
        }
        $html .= '<tr><td><input type="checkbox" id="selpage" name="selpage[]" value="'.$navigationMenuObjects[$i]["id"].'" '.$activeCheck.' onClick="checkNavItems(\''.$navigationMenuObjects[$i]["id"].'\')"></td><td>'.$read.'</td><td>'.$navigationMenuObjects[$i]["nav_link"].'</td><td style="text-align: right"><button class="btn btn-sm btn-success" type="button" onClick="reviseNav(\''.$navigationMenuObjects[$i]["id"].'\')">Edit</button> <button class="btn btn-sm btn-warning" type="button" onClick="deleteNav(\''.$navigationMenuObjects[$i]["id"].'\')">Delete</button></td></tr>';
    }
    $html .='</tbody></table>';

    echo $html;
}

if($act == 'processsorting'){
    $pagesSet = $site->getPagesNav($_REQUEST["navid"]);
    $html .= '<div class="">
                    <div class="dd">
                        <ol class="dd-list">
                            '.$pagesSet.'
                        </ol>
                    </div>
                    <div class="clearfix"></div>
                </div>';

    echo $html;
}

if($act == 'editnavobj'){
    $nabOut = $site->getSingelNavObj($_REQUEST["navobid"]);
    $html .= ' <div style="padding: 5px; background: #F9F0C3"><label>Nav Link</label>
                <div class="input-group">
                    <input type="text" id="nav-link" name="nav-link" class="form-control" placeholder="http://www.yourlinkwillgohere.com" required="" value="'.$nabOut[0]["nav_link"].'">
                    <span class="input-group-btn">
        <button class="btn btn-secondary img-browser" type="button" data-setter="nav-link" data-systemlink="true"><i class="fa fa-link" aria-hidden="true"></i></button>
      </span>
                </div>
                <br>
                <label>Nav to Read / Image</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="nav-image" name="nav-image" placeholder="Enter Display Text or Select an Image." required="" value="'.$nabOut[0]["nav_read"].'">
                    <span class="input-group-btn">
        <button class="btn btn-secondary img-browser" type="button" data-setter="nav-link" data-systemlink="false"><i class="fa fa-file-image-o" aria-hidden="true"></i></button>
      </span>
                </div>
                <br><br>
                <label>';
    if($nabOut[0]["is_image"] == 'true'){
        $checked = 'checked="checked"';
    }else{
        $checked = '';
    }

    if($nabOut[0]["add_parent"] == 'true'){
        $parentOuts = 'checked="checked"';
    }else{
        $parentOuts = '';
    }
                $html .='<input type="checkbox" id="is_image" name="is_image" value="true" '.$checked.'> Is this an image?
                </label> <br><br>
                                        <label>
                                            <input type="checkbox" id="parent_link" name="parent_link" '.$parentOuts.' value="true"> Inherent Parents Directory?
                                        </label>
                <br><br>
                <input type="hidden" id="editid" name="editid" value="'.$_REQUEST["navobid"].'">
                <input type="hidden" id="nav_id2" name="nav_id2" value="'.$nabOut[0]["navigation_id"].'">
                <button class="btn btn-default" type="submit"><i class="fa fa-plus" aria-hidden="true"></i> Edit Nav Item</button> | <a href="javascript:resetnavsets()">Cancel</a></div>';

    echo $html;
}

if($act == 'resetnaviob'){

    $html .= ' <label>Nav Link</label>
                <div class="input-group">
                    <input type="text" id="nav-link" name="nav-link" class="form-control" placeholder="http://www.yourlinkwillgohere.com" required="" value="'.$nabOut[0]["nav_link"].'">
                    <span class="input-group-btn">
        <button class="btn btn-secondary img-browser" type="button" data-setter="nav-link" data-systemlink="true"><i class="fa fa-link" aria-hidden="true"></i></button>
      </span>
                </div>
                <br>
                <label>Nav to Read / Image</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="nav-image" name="nav-image" placeholder="Enter Display Text or Select an Image." required="" value="'.$nabOut[0]["nav_read"].'">
                    <span class="input-group-btn">
        <button class="btn btn-secondary img-browser" type="button" data-setter="nav-image" data-systemlink="false"><i class="fa fa-file-image-o" aria-hidden="true"></i></button>
      </span>
                </div>
                <br><br>
                <label>
                <input type="checkbox" id="is_image" name="is_image" value="true"> Is this an image?
                </label>
                <br><br>
                <label>
                                            <input type="checkbox" id="parent_link" name="parent_link" value="true"> Inherent Parents Directory?
                                        </label><br><br>
                <input type="hidden" id="nav_id2" name="nav_id2" value="'.$_REQUEST["navids"].'">
                <button class="btn btn-default" type="submit"><i class="fa fa-plus" aria-hidden="true"></i> Add Nav Item</button>';

    echo $html;

}

if($act == 'delmenuitem'){
    $site->deleteNavItem($_REQUEST["id"]);
    $request = $site->removeNavObj($_REQUEST["menuid"],$_REQUEST["id"]);
    echo 'didnt die';
}

if($act == 'getcatfilter'){
    $html .= '<select style="margin-left: 5px;" class="form-control-sm" id="category" name="category" onchange="beanSwitchFilter(this.value)">
                                    <option value="none">All Categories</option>';

                                    $cats = $site->getBeanCategory();
                                    foreach($cats as $category){
                                        if($_REQUEST["setcat"] == $category){
                                            $html .= '<option value="'.$category.'" selected="selected">'.$category.'</option>';
                                        }else{
                                            $html .= '<option value="'.$category.'">'.$category.'</option>';
                                        }

                                    }

                                $html .= '</select>';

                                    echo $html;
}

if($act == 'minimod'){

    $theBean = $site->checkBean($_REQUEST["beanid"]);

    if(!(empty($theBean))){
        //edit-content.php?id=3&minimod=true
        echo '<iframe src="edit-content.php?id='.$theBean["id"].'&minimod=true" style="width:100%; height:400px; border:0; resize: vertical;"></iframe>';
    }else{
        echo '<div class="alert alert-danger">Sorry! - No content was found for token.</div>';
    }

}

if($act == 'createbean'){
  //createbean&beanname=productbean&bean_id
    include('harness.php');
    $data->query("INSERT INTO beans SET bean_name = '".$data->real_escape_string($_REQUEST["beanname"])."', bean_type = 'native', user_type = 'all', created = '".time()."', bean_id = '".$_REQUEST["bean_id"]."', category = '$category', active = 'true'");
}

if($act == 'saveform'){
    $formProcess = $site->createForm($_POST);
    echo $formProcess;
}

if($act == 'getformrequest'){
    //getformrequest&requestid&form
    $messagOut = $site->getFormMessage($_REQUEST["requestid"],$_REQUEST["form"]);
    $html .= '<table class="table">';
    foreach($messagOut as $key=>$val){
        if($key != 'active') {
            if($key == 'receive_date'){$val = date('m/d/Y h:ia',$val);}else{$val = $val;}
            $html .= '<tr><td style="width:200px"><strong>' . ucwords(str_replace('_',' ',$key)) . ':</strong></td><td>' . $val . '</td></tr>';
        }

        if($key == 'email'){$email = $val;}
    }

    $html .= '</table>';

    if(isset($email)){
        $reply = '<a href="mailto:'.$email.'" class="btn btn-success btn-fill">Reply To Message</a>';
    }

    $html .= '';

    echo $html;
}

if($acgt == 'deleteformrequest'){
    $site->delMess($_REQUEST["requestid"],$_REQUEST["form"]);

}

if($act == 'deleteform'){
    $site->deleteForm($_REQUEST["formid"]);
}

if($act == 'filtercustomcats'){
    $realCats = $site->getEqCats($_REQUEST["filter"]);

    if($realCats != null) {
        for ($b = 0; $b <= count($realCats); $b++) {
            if ($realCats[$b]["catname"] != null) {
                $categoryOutReal .= '<div class="productitem draggable" data-thename="' . $realCats[$b]["catname"] . '" data-listtype="category" style="padding: 5px; text-align: center; background: #fff; margin: 5px; cursor:pointer"><div class="dragsa col-md-2" style="cursor:move; text-align: left"><img style="width: 6px" src="img/grip.png"></div><div class="col-md-10" style="text-align: left">' . $realCats[$b]["catname"] . '</div><div class="clearfix"></div></div>';
            }
        }
    }else{
        $categoryOutReal = '<div class="col-md-12"><div class="box_message">No active categories.</div></div>';
    }

    echo $categoryOutReal;
}



if($act == 'deletemess'){
    $form = $_REQUEST["form"];
    $id = $_REQUEST["messid"];
    $site->delMess($id,$form);
}

if($act == 'updateform'){
   echo $site->updateForm($_POST);
}

if($act == 'pullarchive'){

    $html .= '<table id="example" class="display table" style="width:100%"><thead><tr><th>File Name</th><th>Action</th></tr></thead><tbody>';
    $files = $site->getArchive($_REQUEST["formname"]);

    foreach($files as $key){
        if($key != '.' && $key != '..' && $key != '.DS_Store'){
            $html .= '<tr><td>'.$key.'</td><td><a href="form_backups/'.$_REQUEST["formname"].'/'.$key.'">Download</a></td></tr>';
        }
    }



    $html .= '</tbody>';
    $html .= '</table>';

    echo $html;
}

if($act == 'openreview'){
    $messData = $site->readMess($_REQUEST["id"]);
        $html .= '<div class="review-message alert alert-danger" style="display: none"></div>';
        $html .= '<table class="table">';
        $html .= '<tbody>';
        $html .= '<tr><td>Full Name: </td><td>'.$messData["name"].'</td></tr>';
        $html .= '<tr><td>Email: </td><td>'.$messData["email"].'</td></tr>';
        $html .= '<tr><td>Equipment Reviewed: </td><td>'.$messData["equipment_name"].'</td></tr>';
        $html .= '<tr><td>Rating: </td><td>'.$messData["reveiw_stars"].' Stars</td></tr>';
        $html .= '<tr><td>Equipment Review: </td><td>'.$messData["review_text"].'</td></tr>';
        $html .= '<tr><td>Date Submited: </td><td>'.date('m/d/Y h:ia',$messData["date_submited"]).'</td></tr>';
        $html .= '</tbody>';
        $html .= '</table>';
        if($messData["approved"] == 'true'){
            $approved = '';
        }else{
            $approved = '<button class="btn btn-primary apprvrv" data-id="'.$messData["id"].'">Approve Review</button>';
        }
        $html .= '<div style="text-align: right"><button class="btn btn-danger delrev" data-id="'.$messData["id"].'">Delete Review</button> '.$approved.'</div>';
        echo $html;
}

if($act == 'completerevdel'){
    $id = $_REQUEST["id"];
    $site->delRevs($id);
}

if($act == 'approverev'){
    $id = $_REQUEST["id"];
    $site->apprvRevs($id);
}

if($act == 'openorder'){
    $messData = $site->readOrder($_REQUEST["id"]);
    $html .= '<div class="review-message alert alert-danger" style="display: none"></div>';
    $html .= '<h2>Order Details</h2>';
    $html .= '<strong>Purchase Number: '.$messData["purchase_num"].'</strong>';
    $html .= '<table class="table">';
    $html .= '<tbody>';
    $html .= '<tr><td>Full Name: </td><td>'.$messData["first_name"].' '.$messData["last_name"].'</td></tr>';
    $html .= '<tr><td>Email: </td><td>'.$messData["email"].'</td></tr>';
    $html .= '<tr><td>Phone: </td><td>'.$messData["phone"].'</td></tr>';
    $html .= '<tr><td>Address: </td><td>'.$messData["address"].'<br>'.$messData["city"].' '.$messData["state"].', '.$messData["zip"].'</td></tr>';
    $html .= '<tr><td>Shipping Address: </td><td>'.$messData["ship_address"].'<br>'.$messData["ship_city"].' '.$messData["ship_state"].', '.$messData["ship_zip"].'</td></tr>';
    $html .= '<tr><td>Order Date: </td><td>'.date('m/d/Y h:ia',$messData["date_sub"]).'</td></tr>';
    $html .= '<tr><td>Order Notes: </td><td>'.$messData["order_notes"].'</td></tr>';
    $html .= '</tbody>';
    $html .= '</table>';

    $html .= '<hr>';

    $html .= '<h2>Ordered Items</h2>';

    $html .= $messData["items_list"];

    $html .= '<hr>';
    if($messData["status"] == 'New'){
        $approved = '<button class="btn btn-primary apprvrv" data-id="'.$messData["id"].'">Mark Completed</button>';
    }else{
        $approved = '';
    }
    $html .= '<div style="text-align: right"><button class="btn btn-danger delrev" data-id="'.$messData["id"].'">Delete Order</button> '.$approved.'</div>';
    echo $html;
}

//completeorddel

if($act == 'completeorddel'){
    $id = $_REQUEST["id"];
    $site->delOrds($id);
}

if($act == 'approverev'){
    $id = $_REQUEST["id"];
    $site->updatePros($id);
}

if($act == 'getequipmentlist'){
    $searchTerm = $_GET['term'];
    $arsreturn = $site->getEquipmentTitles($searchTerm);
    echo $arsreturn;
}


if($act == 'runforce'){
    $site->forceCheckIn($_REQUEST["pageid"]);
}

if($act == 'runforcecontent'){
    $site->forceCheckInContent($_REQUEST["conid"]);
}

if($act == 'compressfiles'){
    echo $_REQUEST["type"];
   echo $site->compressFiles($_REQUEST["type"]);
}

/////PERMISSIONS///
if($act == 'getpermission'){
    $perPan = $site->getSinglePermission($_REQUEST["id"]);

    $html .= '<h3>Edit Permission Group</h3>
                    <p>You can use this to turn on certain areas of the editor and assign this to users.</p>




                    <form name="permissions_edit" id="permissions_edit" method="post" action="">
                        <label>Group Name</label><br>
                        <input class="form-control" type="text" name="per-name-edit" id="per-name-edit" placeholder="Group Name Here..." required value="'.$perPan["name"].'"><br>
                        <div style="max-height: 300px; overflow-y: scroll">
                            <table class="table">';


    $permissions = array('Pages','Content','Site Forms','Locations','Menus','Media','Site Information','Header Tag Events','System Permissions','System Users','Core Site Files', 'Vendor Panel', 'End Users');

    foreach ($permissions as $pers){
        $inputName = str_replace(' ','_',$pers);

        $persArs = json_decode($perPan["permissions"],true);

        if(in_array($inputName,$persArs)){
            $checked = 'checked="checked"';
        }else{
            $checked = '';
        }

        $html .= '<tr><td><strong>'.$pers.'</strong></td><td><label class="switch"><input type="checkbox" name="permiss[]" value="'.$inputName.'" '.$checked.'><span class="slider round"></span></label></td></tr>';
    }


    $html .='</table>
                        </div><br>
                        <input type="hidden" name="permisid" id="permisid" value="'.$perPan["id"].'">
                        <button class="btn btn-primary">Edit Permission Group</button>
                    </form>';

    echo $html;
}

if($act == 'getcustomdrags'){

    $realCats = $site->getCustomItem();

    if($realCats != null) {
        for ($b = 0; $b <= count($realCats); $b++) {
            if ($realCats[$b]["title"] != null) {
                $categoryOutReal .= '<div class="productitem draggable" data-thename="' . $realCats[$b]["title"] . '" data-listtype="product" data-linetype="Custom" style="padding: 5px; text-align: center; background: #fff; margin: 5px; cursor:pointer"><div class="dragsa col-md-2" style="cursor:move; text-align: left"><img style="width: 6px" src="img/grip.png"></div><div class="col-md-10" style="text-align: left">' . $realCats[$b]["title"] . ' | <a href="javascript:editAddon(\''.$realCats[$b]["id"].'\')">Edit</a></div><div class="clearfix"></div></div>';
            }
        }
    }else{
        $categoryOutReal = '<div class="col-md-12"><div class="box_message">No active categories.</div></div>';
    }

    echo $categoryOutReal;
}

if($act == 'createaddon'){
    $html .= '<div style="padding:10px">';
    $html .= '<form name="item_creator" id="item_creator" method="post" action="">';
    //$html .= '<div class="row"><div class="col-md-12" style="margin-top:10px"><input type="text" style="background: #fff;" class="form-control" name="cat_ser_og" id="cat_ser_og" placeholder="Search Products" data-list=".dragbox" autocomplete="off" value=""> <span class="input-group-btn"></span></div></div>';
    $html .= '<div class="row">';
    $html .= '<div class="col-md-4" style="padding-left:5px; padding-right:5px;"><label>Name/Model Number</label><br><input class="form-control" type="text" name="addonname" id="addonname" placeholder="Search Products" autocomplete="off"><div class="results-out"></div></div><div class="col-md-4" style="padding-left:5px; padding-right:5px;"><label>Short Description</label><input class="form-control" placeholder="limit:25 characters" id="addondetails" name="addondetails"/></div><div class="col-md-4" style="padding-left:5px; padding-right:5px;"><label>Add-On Price</label><br><input class="form-control" type="text" name="addonprice" id="addonprice"></div>';
    $html .= '</div>';
    $html .= '<div class="row">';
    $html .= '<br>';
    $html .= '<div class="input-group col-md-12" style="padding-left: 5px; padding-right: 10px;"><input type="text" class="form-control" name="cat_img" id="cat_img" placeholder="No Image" value=""><span class="input-group-btn"><button class="btn btn-primary img-browser" style="border: solid thin #ccc;background: #cccccc; color: #333;" data-setter="cat_img" type="button">Browse Images</button></span></div>';
    $html .= '<p style="padding-left: 10px;font-weight: bold;">If Product not found</p>';
    $html .= '<div class="col-md-12" style="padding-left: 5px;"><input name="addoncheck" type="checkbox" id="addoncheck" value="checked"/> Select to Add a Custom Product</label></div>';
    $html .= '<br>';
    $html .= '</div><button class="btn btn-success btn-fill" type="submit">Save</button>';
    $html .= '</form>';

    echo $html;
}

if($act == 'finishaddon'){
    $site->addAddons($_POST);
    echo '<div class="alert alert-success">Item has been successfully added.</div>';
}

if($act == 'editaddon'){
    $details = $site->getCustomItems($_REQUEST["id"]);

    $html .= '<div style="padding:10px">';
    $html .= '<form name="item_creator_edit" id="item_creator_edit" method="post" action="">';
    //$html .= '<div class="input-group col-md-12" style="margin-top:10px"><input type="text" style="background: #fff" class="form-control" name="cat_ser_two" id="cat_ser_two" placeholder="Search Categories" data-list=".dragbox" autocomplete="off" value=""> <span class="input-group-btn"><button class="btn btn-primary ser-thcats1" style="border: solid thin #ccc;background: #cccccc; color: #333;" type="button" </button></span></div></div>';
    $html .= '<div><label>Name/Model Number</label><br><input class="form-control" type="text" name="addonname" id="addonname" value="'.$details["addon_name"].'"></div><br><br>';
    $html .= '<div class="input-group col-md-12"><input type="text" class="form-control" name="cat_img" id="cat_img" placeholder="No Image" value="'.$details["addon_image"].'"><span class="input-group-btn"><button class="btn btn-primary img-browser" style="border: solid thin #ccc;background: #cccccc; color: #333;" data-setter="cat_img" type="button">Browse Images</button></span></div>';
    $html .= '<div><label>Add-On Price</label><br><input class="form-control" type="text" name="addonprice" id="addonprice" value="'.$details["addon_price"].'"></div><br><br>';
    $html .= '<div><label>Details</label><br><textarea class="form-control" id="addondetails" name="addondetails">'.$details["addon_details"].'</textarea></div><br><br>';
    $html .= '<input type="hidden" name="itemnum" id="itemnum" value="'.$_REQUEST["id"].'">';
    $html .= '<div class="container"><br/>';
    $html .= '<div class="form-group">';
    //$html .= '<div class="" id="addoncheck" name="addoncheck[]" value="checked">';
    //$html .= '<label data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">';
    //$html .= '<input type="checkbox" id="addoncheck" name="addoncheck[]" value="'.$details["checkbox"].'"/> Product does not exists</label>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '<div id="collapseOne" aria-expanded="false" class="collapse">';
    $html .= '<label for="name">Name:</label>';
    $html .= '<input type="text" name="name" id="name" value="'.$details["new_name"].'">';
    $html .= '</div>';
    $html .= '<button class="btn btn-success btn-fill">Update</button>';
    $html .= '</form>';
    $html .= '</div>';

    echo $html;
}

if($act == 'editfinishaddon'){
    $site->editAddons($_POST);
    echo '<div class="alert alert-success">Item has been successfully updated.</div>';
}

if($act == 'yoursearch'){
    //DO THINGS WITH DB//
    $details1 = $site->getProdsItem($_REQUEST["serval"]);

    for($i=0; $i<count($details1); $i++){
        $items .= '<div style="padding: 4px;background: #efefef;margin: 2px; cursor:pointer" class="clickitem" data-title="'.$details1[$i]["title"].'" data-price="'.$details1[$i]["price"].'">'.$details1[$i]["title"].'</div>';
    }

    echo $items;
    //var_dump($details1);



    ///echo 'HI THERE WORLD'.$_REQUEST["serval"];
}

if($act == 'getsysmesss'){
    $messages = $site->getSystMesss();



    if(!empty($messages)) {


        $html .= '<div class="dropdown-item noti-title"><h5 class="font-16"><span class="badge badge-danger float-right">' . $messCount . '</span>Notification</h5></div>';
        for ($i = 0; $i < count($messages); $i++) {
            $messCount = count($messages);

            $title = $messages[$i]["title"];
            $userDets = $site->getUsersAccount($messages[$i]["user"]);


            $fullname = $userDets["fname"] . ' ' . $userDets["lname"];
            $priority = $messages[$i]["priority"];


            if ($priority == 'Low') {
                $pri = '<div class="notify-icon bg-success"><i class="mdi mdi-comment-account"></i></div>';
            }
            if ($priority == 'Medium') {
                $pri = '<div class="notify-icon bg-primary"><i class="mdi mdi-comment-account"></i></div>';
            }
            if ($priority == 'High') {
                $pri = '<div class="notify-icon bg-danger"><i class="mdi mdi-comment-account"></i></div>';
            }

            $readIds = json_decode($messages[$i]["read_ids"], true);

            $checkSubs = $site->checkSubs($messages[$i]["id"]);


            $userId = $site->auth();
            $userId = $userId["profileId"];


            if (in_array($userId, $readIds) && $checkSubs == 'true') {
                $stat = '';
            } else {
                $stat = '<span class="badge badge-info" style="font-size: 10px; float:right">Unread</span> <div class="clearfix"></div>';
            }

            if ($messages[$i]["completed"] == 'true') {
                $strike = 'text-decoration: line-through;';
            } else {
                $strike = '';
            }


            $html .= '<a href="javascript:openMessz(' . $messages[$i]["id"] . ');" class="dropdown-item notify-item">' . $pri . '<p class="notify-details" style="' . $strike . '">' . $fullname . ' ' . $title . '<small class="text-muted">Priority: ' . $priority . ' ' . date('m/d/Y H:ia', $messages[$i]["created"]) . '</small></p>' . $stat . '</a>';
            $stat = '';
        }
    }else{
        $html = '<div style="width: 300px; padding: 5px; font-style: italic; color: #c4c4c4">No New Messages</div>';
    }
    echo $html;
}

if($act == 'processsysmess'){
    $site->storeInsysMess($_POST);
}

if($act == 'getmessz'){
    $messid = $_REQUEST["messid"];
    $message = $site->getSingelMess($messid);
    /// var_dump($message);
    $userDets = $site->getUsersAccount($message["main_message"][0]["user"]);
    $fullname = $userDets["fname"].' '.$userDets["lname"];
    $priority = $message["main_message"][0]["priority"];

    $html .= '<h3>'.$message["main_message"][0]["title"].'</h3>';
    $html .= '<small class="text-muted">Created By: '.$fullname.' Priority: '.$priority.' Date: '.date('m/d/Y H:ia',$message["main_message"][0]["created"]).'</small><br>';
    $html .= '<hr>';
    $html .= '<label>Original Message:</label><br>';
    $html .= '<div style="background: #efefef; padding: 10px">'.$message["main_message"][0]["message"].'</div>';
    $html .= '<hr>';

    ///REPLIES HERE///
    $reply = $message["replies"];

    if(!empty($reply)){
        $jp = 0;
        for($i=0; $i<count($reply); $i++){
            $messRp = $reply[$i]["message"];
            $userDets = $site->getUsersAccount($reply[$i]["user"]);
            $fullname = $userDets["fname"].' '.$userDets["lname"];
            if($jp == 0){
                $html .= '<div class="speech-bubble" style="float: left">'.$messRp.'<small style="color: #000" class="text-muted">'.$fullname.' - Date: '.date('m/d/Y H:ia',$message["main_message"][0]["created"]).'</small></div><br>';
                $html .= '<div class="clearfix"></div><br>';
                $jp = 1;
            }else{
                $html .= '<div class="speech-bubble2" style="float: right">'.$messRp.'<small style="color: #000" class="text-muted">'.$fullname.' - Date: '.date('m/d/Y H:ia',$message["main_message"][0]["created"]).'</small></div><br>';
                $html .= '<div class="clearfix"></div><br>';
                $jp = 0;
            }

        }
        $html .= '<div class="clearfix"></div>';
    }else{
        $html .= '<div style="font-style: italic; padding: 5px">No Replies Yet!</div>';
    }


    $status = $message["main_message"][0]["completed"];

    echo "This is ".$status;

    if($status == 'true'){
        $state = 'checked="checked"';
        $stateClass = 'active';
    }else{
        $state = '';
        $stateClass = '';
    }

//    $html .= '<div class="speech-bubble" style="float: left>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt <br><small style="color: #000" class="text-muted">Joyce McMillar - 01/01/2019 13:45am</small></div><br>';
//    $html .= '<div class="clearfix"></div><br>';
//    $html .= '<div class="speech-bubble2" style="float: right">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat <br><small style="color: #000" class="text-muted">Joyce McMillar - 01/01/2019 13:45am</small></div>';
//    $html .= '<div class="clearfix"></div>';
    $html .= '<hr><br>';

    $html .= '<form name="insysmesss" id="insysmesss" method="post" action=""><br><label>Reply to Message</label><br><br><div id="editor"></div><input type="hidden" name="messys" id="messys" value=""><br><br><label>Mark Resolved</label><br><label class="switch tabers '.$stateClass.'"><input class="primary settings" type="checkbox" name="mess_resolve" data-sett="mess_resolve" value="mess_resolve" '.$state.'><span class="slider round"></span></label><br><input type="hidden" id="currmess" name="currmess" value="'.$message["main_message"][0]["messid"].'"> </form>';

    echo $html;
}

if($act == 'getmesscounts'){
    $cnts = $site->getUnreadCount();

    echo $cnts;
}

if($act == 'seterrsstatus'){
    $status = $_REQUEST["status"];
    $site->setErrorStatus($status);


}