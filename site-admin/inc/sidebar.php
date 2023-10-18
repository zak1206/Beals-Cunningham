<div class="sidebar-wrapper">
    <div class="logo">
        <a href="#" class="simple-text">
            <img style="width: 100%" src="img/logo-EQ-Harvest-HORIZ.png">
        </a>
    </div>

    <ul class="nav">
        <li class="">
            <a href="dashboard.php">
                <i style="color: #2196f3" class="ti-panel"></i>
                <p>Dashboard</p>
            </a>
        </li>
        <li>
            <a href="pages.php">
                <i style="color: #78554D" class="ti-layers-alt"></i>
                <p>Page Templatessdsd</p>
            </a>
        </li>
        <li>
            <a href="content.php">
                <i style="color:#2196f3;" class="ti-write"></i>
                <p>Content / Plugin's</p>
            </a>
        </li>
        <li>
            <a href="forms.php">
                <i style="color: #ff5722" class="ti-clipboard"></i>
                <p>Site Forms</p>
            </a>
        </li>
        <li>
            <a href="locations.php">
                <i style="color: #673ab7" class="ti-location-pin"></i>
                <p>Locations</p>
            </a>
        </li>
        <li>
            <a href="menus.php">
                <i style="color:#3f51b5" class="ti-menu"></i>
                <p>Menu's</p>
            </a>
        </li>

        <li>
            <a href="media-manager.php">
                <i style="color:#009688" class="ti-gallery"></i>
                <p>Media</p>
            </a>
        </li>
        <li>
            <a href="checklist.php">
                <i style="color:#009688" class="ti-checklist"></i>
                <p>Checklist</p>
            </a>
        </li>

        <!--<li>
            <a href="deere-categories.php">
                <img style="width: 30px;display: inline-block;float: left;margin: 2px 3px 0px;margin-right: 13px;" src="img/deere_ico.png">
                <p>Deere Products</p>
            </a>
        </li>
        <li>
            <a href="edit-content.php?id=2">
                <img style="width: 30px;display: inline-block;float: left;margin: 2px 3px 0px;margin-right: 13px;" src="img/mfp_ico.png">
                <p>Machine Finder</p>
            </a>
        </li>
        <li>
            <a href="honda-categories.php">
                <img style="width: 30px;display: inline-block;float: left;margin: 2px 3px 0px;margin-right: 13px;" src="img/honda_ico.png">
                <p>Honda Equipment</p>
            </a>
        </li>
        <li>
            <a href="stihl-categories.php">
                <img style="width: 30px;display: inline-block;float: left;margin: 2px 3px 0px;margin-right: 13px;" src="img/stihl_ico.png">
                <p>Stihl Equipment</p>
            </a>
        </li>
        <li>
            <a href="packages.php">
                <i class="ti-package"></i>
                <p>Package Builder</p>
            </a>
        </li>
        <li>
            <a href="reviews.php">
                <i class="ti-comment-alt"></i>
                <p>Equipment Reviews</p>
            </a>
        </li>

        <?php

            $shops = $site->getUnProcessedOrders();
            if($shops > 0){
                $labsOutsz = ' <span style="background: red" class="badge sav-nums">'.$shops.'</span> New Orders';
            }else{
                $labsOutsz = 'Review Orders';
            }

        ?>

        <li>
            <a href="orders.php">
                <i class="ti-shopping-cart"></i>
                <p><?php echo $labsOutsz; ?></p>
            </a>
        </li>-->
    </ul>
    <div style="padding: 5px; background: #e2e0e0">
        <div class="alert alert-success" style="margin: 0; text-align: center">No Updates Available.</div>
   <!-- <div class="alert alert-warning" style="margin: 0"><strong><i class="ti-alert"></i> System Updates Are Available.</strong><br><br><a class="btn btn-primary btn-xs btn-fill" href="">Review Updates</a></div>
    <div class="alert alert-danger" style="margin: 0"><strong><i class="ti-alert"></i> Plugin Updates Are Available.</strong><br><br><a class="btn btn-primary btn-xs btn-fill" href="">Review Updates</a></div>-->
    </div>
</div>