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
                <small>EQ-Commerce</small>
            </li>
            <!--DO NOT DELETE THE LINK(<a> TAG) BELOW. IT IS TEMPORARILY COMMENTED OUT--> 
            <!--<a onclick="location.href=\'custom-categories.php\'"  class="bg-dark list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fa fa-dashboard fa-fw mr-3"></span>
                    <span class="menu-collapsed">Dashboard</span>
                </div>
            </a>-->
            <!--DO NOT DELETE THE LINK(<a> TAG) ABOVE. IT IS TEMPORARILY COMMENTED OUT--> 
            <a href="#submenu1" data-toggle="collapse" aria-expanded="false" class="bg-dark list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fa fa-list-alt fa-fw mr-3"></span>
                    <span class="menu-collapsed">Categories</span>
                     <span class="submenu-icon ml-auto"></span>
                </div>
            </a>
               <div id=\'submenu1\' class="collapse sidebar-submenu">
                <a onclick="location.href=\'create-category.php\'" class="list-group-item list-group-item-action bg-dark text-white">
                    <span class="menu-collapsed">Create Category</span>
                </a>
                <a onclick="location.href=\'custom-categories.php\'" class="list-group-item list-group-item-action bg-dark text-white">
                    <span class="menu-collapsed">Manage Categories</span>
                </a>
            </div>
          
             <a  href="#submenu3" data-toggle="collapse" aria-expanded="false" class="bg-dark list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fa fa-th fa-fw mr-3"></span>
                    <span class="menu-collapsed">Products </span>
                      <span class="submenu-icon ml-auto"></span>
                </div>
            </a>
            <div id=\'submenu3\' class="collapse sidebar-submenu">
                <a onclick="location.href=\'add-products.php\'" class="list-group-item list-group-item-action bg-dark text-white">
                    <span class="menu-collapsed">New Product</span>
                </a>
                <a onclick="location.href=\'edit-product.php\'" class="list-group-item list-group-item-action bg-dark text-white">
                    <span class="menu-collapsed">Manage Products</span>
                </a>
            </div>


              <a  href="#submenu2" data-toggle="collapse" aria-expanded="false" class="bg-dark list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fa fa-shopping-cart fa-fw mr-3"></span>
                    <span class="menu-collapsed">EQ Commerce </span>
                        <span class="submenu-icon ml-auto"></span>
                </div>
            </a>
            <div id=\'submenu2\' class="collapse sidebar-submenu">
                <a  onclick="location.href=\'orders.php\'" class="list-group-item list-group-item-action bg-dark text-white">
                    <span class="menu-collapsed">Orders</span>
                </a>
                <!--DO NOT DELETE THE LINK(<a> TAG) BELOW. IT IS TEMPORARILY COMMENTED OUT--> 
                <!--<a onclick="location.href=\'customer-list.php\'" class="list-group-item list-group-item-action bg-dark text-white">
                    <span class="menu-collapsed">Customers</span>
                </a>--> 
                <!--DO NOT DELETE THE LINK(<a> TAG) ABOVE. IT IS TEMPORARILY COMMENTED OUT--> 
                <a onclick="location.href=\'list-coupons.php\'" class="list-group-item list-group-item-action bg-dark text-white">
                    <span class="menu-collapsed">Coupons</span>
                </a>
                <a onclick="location.href=\'invoice-details.php\'" class="list-group-item list-group-item-action bg-dark text-white">
                    <span class="menu-collapsed">Invoice Details</span>
                </a>
                <a onclick="location.href=\'shipping-methods.php\'" class="list-group-item list-group-item-action bg-dark text-white">
                    <span class="menu-collapsed">Shipping</span>
                </a>
                <a onclick="location.href=\'payment-selection.php\'" class="list-group-item list-group-item-action bg-dark text-white">
                    <span class="menu-collapsed">Payment</span>
                </a>
                <a onclick="location.href=\'tax-rates.php\'" class="list-group-item list-group-item-action bg-dark text-white">
                    <span class="menu-collapsed">Tax Rates</span>
                </a>
                <a onclick="location.href=\'ecommerce-settings.php\'" class="list-group-item list-group-item-action bg-dark text-white">
                    <span class="menu-collapsed">Shop Settings</span>
                </a>
            </div>

            <a  href="#submenu4" data-toggle="collapse" aria-expanded="false" class="bg-dark list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fa fa-wrench fa-fw mr-3"></span>
                    <span class="menu-collapsed">Tools</span>
                        <span class="submenu-icon ml-auto"></span>
                </div>
            </a>
            <div id=\'submenu4\' class="collapse sidebar-submenu">
                <a  onclick="clickedIt(\'This is the Import Data\')" class="list-group-item list-group-item-action bg-dark text-white">
                    <span class="menu-collapsed">Import Data</span>
                </a>
                <a onclick="clickedIt(\'This is the Export Data\')" class="list-group-item list-group-item-action bg-dark text-white">
                    <span class="menu-collapsed">Export Data</span>
                </a>
                
            </div>
        </ul><!-- List Group END-->
    </div><!-- sidebar-container END -->';

echo $html;
