<?php

$html = '<!-- Bootstrap row -->
<div class="row" id="body-row">
    <!-- Sidebar -->
    <div id="sidebar-container" class="sidebar-expanded d-none d-md-block">
        <!-- d-* hiddens the Sidebar in smaller devices. Its itens can be kept on the Navbar \'Menu\' -->
        <!-- Bootstrap List Group -->
        <ul class="list-group">
            <!-- Separator with title -->
            <li class="list-group-item sidebar-separator-title text-muted d-flex align-items-center menu-collapsed">
                <small>Package Builder</small>
            </li>
            <a onclick="location.reload();" class="bg-dark list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fa fa-dashboard fa-fw mr-3"></span>
                    <span class="menu-collapsed">Dashboard</span>
                </div>
            </a>
         
            <a href="#submenu1" data-toggle="collapse" aria-expanded="false" class="bg-dark list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fa fa-list-alt fa-fw mr-3"></span>
                    <span class="menu-collapsed">Categories</span>
                     <span class="submenu-icon ml-auto"></span>
                </div>
            </a>
               <div id=\'submenu1\' class="collapse sidebar-submenu">
                <a onclick="createNewCat();" class="list-group-item list-group-item-action bg-dark text-white">
                    <span class="menu-collapsed">Create Category</span>
                </a>
                <a onclick="getMainCats();" class="list-group-item list-group-item-action bg-dark text-white">
                    <span class="menu-collapsed">Manage Categories</span>
                </a>
            </div>
          
             <a  href="#submenu3" data-toggle="collapse" aria-expanded="false" class="bg-dark list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fa fa-th fa-fw mr-3"></span>
                    <span class="menu-collapsed">Packages </span>
                      <span class="submenu-icon ml-auto"></span>
                </div>
            </a>
            <div id=\'submenu3\' class="collapse sidebar-submenu">
                <a onclick="createPackage();" class="list-group-item list-group-item-action bg-dark text-white">
                    <span class="menu-collapsed">Create Package</span>
                </a>
                <a onclick="location.reload();" class="list-group-item list-group-item-action bg-dark text-white">
                    <span class="menu-collapsed">Manage Package</span>
                </a>
            </div>
              <a  href="#submenu2" data-toggle="collapse" aria-expanded="false" class="bg-dark list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fa fa-plus-square fa-fw mr-3"></span>
                    <span class="menu-collapsed">Addons </span>
                        <span class="submenu-icon ml-auto"></span>
                </div>
            </a>
            <div id=\'submenu2\' class="collapse sidebar-submenu">
                <a  onclick="createNewAddon();" class="list-group-item list-group-item-action bg-dark text-white">
                    <span class="menu-collapsed">Create Addon</span>
                </a>
                <a onclick="manageLines();" class="list-group-item list-group-item-action bg-dark text-white">
                    <span class="menu-collapsed">Manage Addons</span>
                </a>
            </div>
                <a onclick="getUsage();" class="bg-dark list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fa fa-book fa-fw mr-3"></span>
                    <span class="menu-collapsed">Usage </span>
                </div>
            </a>
            <a href="#top" data-toggle="sidebar-colapse" class="bg-dark list-group-item list-group-item-action d-flex align-items-center">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span id="collapse-icon" class="fa fa-2x mr-3"></span>
                    <span id="collapse-text" class="menu-collapsed">Collapse</span>
                </div>
            </a>
        </ul><!-- List Group END-->
    </div><!-- sidebar-container END -->';

echo $html;

?>