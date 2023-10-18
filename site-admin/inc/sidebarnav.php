<!-- ========== Left Sidebar Start ========== -->

<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        <!--- Divider -->
        <div id="sidebar-menu">
            <ul>
                <li class="menu-title">Main</li>

                <li>
                    <a href="dashboard.php" class="waves-effect waves-primary">
                        <i class="ti-home"></i><span> Dashboard </span>
                    </a>
                </li>

                <li>
                    <a href="pages.php" class="waves-effect waves-primary"><i class="ti-layout"></i><span> Pages </span></a>
                </li>

                <li>
                    <a href="content.php" class="waves-effect waves-primary"><i class="ti-package"></i><span> Content / Plugins </span></a>
                </li>

                <li>
                    <a href="site-forms.php" class="waves-effect waves-primary"><i class="ti-view-list"></i><span> Site Forms </span></a>
                </li>

                <li>
                    <a href="locations.php" class="waves-effect waves-primary"><i class="ti-location-pin"></i><span> Locations </span></a>
                </li>

                <li>
                    <a href="navigation.php" class="waves-effect waves-primary"><i class="ti-layout-menu-separated"></i><span> Navigation </span></a>
                </li>

                <li>
                    <a href="media.php" class="waves-effect waves-primary"><i class="ti-image"></i><span> Media </span></a>
                </li>
                <li>
                    <a href="checklist.php">
                        <i style="color:#009688" class="ti-checklist"></i>
                        <p>Checklist</p>
                    </a>
                </li>
                <li>
                    <a href="#" class="waves-effect waves-primary"><span> No Updates </span></a>
                </li>


                <?php
                if ($site->checkerrorstat() == 'true') {
                    echo ' <li>
                    <a href="core-settings.php" class="waves-effect waves-primary"><span style="background: #f76767;padding: 10px;color: #fff;border: solid thin red;"> Error Reporting ON! </span></a>
                </li>';
                } else {
                }
                ?>

                <li>
                    <img style="width: 100%; padding: 5px" src="img/eq_gif.gif">
                </li>


            </ul>

            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<!-- Left Sidebar End -->