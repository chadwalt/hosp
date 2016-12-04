<!-- sidebar left start-->
<div class="sidebar-left">
    <!--responsive view logo start-->
    <div class="logo dark-logo-bg visible-xs-* visible-sm-*">
        <a href="index.html">
            <img src="<?php echo base_url(); ?>libraries/img/logo-icon.png" alt="">
            <!--<i class="fa fa-maxcdn"></i>-->
            <span class="brand-name">SlickLab</span>
        </a>
    </div>
    <!--responsive view logo end-->

    <div class="sidebar-left-info">
        <!-- visible small devices start-->
        <div class=" search-field">  </div>
        <!-- visible small devices end-->

        <!--sidebar nav start-->
        <ul class="nav nav-pills nav-stacked side-navigation">
            <li>
                <h3 class="navigation-title">Navigation</h3>
            </li>
            <li class="active"><a href="index.html"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>
            <!--            <li class="menu-list">
                            <a href=""><i class="fa fa-laptop"></i>  <span>Layouts</span></a>
                            <ul class="child-list">
                                <li><a href="boxed-layout.html"> Boxed Page</a></li>
                                <li><a href="collapsed-menu.html"> Sidebar Collapsed</a></li>
                                <li><a href="blank-page.html"> Blank page</a></li>
                                <li><a href="different-theme-layouts.html"> Different Theme Layouts</a></li>
                            </ul>
                        </li>-->
            <!--            <li class="menu-list"><a href=""><i class="fa fa-book"></i> <span>UI Elements</span></a>
                            <ul class="child-list">
                                <li><a href="general.html"> BS Elements</a></li>
                                <li><a href="buttons.html"> Buttons</a></li>
                                <li><a href="toastr.html"> Toaster Notification</a></li>
                                <li><a href="widgets.html"> Widgets</a></li>
                                <li><a href="ion-slider.html"> Ion Slider</a></li>
                                <li><a href="tree.html"> Tree View</a></li>
                                <li><a href="nestable.html"> Nestable</a></li>
                                <li><a href="fontawesome.html"> Fontawesome</a></li>
                                <li><a href="line-icon.html"> Line Icon</a></li>
                            </ul>
                        </li>-->
            <li>
                <h3 class="navigation-title">Components</h3>
            </li>
<!--            <li class="menu-list"><a href=""><i class="fa fa-cogs"></i> <span>Components <span class="badge noti-arrow bg-success pull-right">3</span> </span></a>
                <ul class="child-list">
                    <li><a href="grid.html"> Grids</a></li>
                    <li><a href="calendar.html"> Calendar</a></li>
                    <li><a href="timeline.html"> Timeline </a></li>
                    <li><a href="gallery.html"> Gallery </a></li>
                </ul>
            </li>-->
            <li>
                <a href="<?php echo site_url('Admin/departments') ?>"> <i class="fa fa-sitemap"></i> <span>Departments</span></a>
            </li>
            
            <li>
                <a href="<?php echo site_url('Admin/patients') ?>"> <i class="fa fa-user"></i> <span>Patients</span></a>
            </li>
            
            <li>
                <a href="<?php echo site_url('Admin/wards') ?>"> <i class="fa  fa-krw"></i> <span>Wards</span></a>
            </li>

            <li>
                <a href="<?php echo site_url('Users/index') ?>"> <i class="fa fa-users"></i> <span>Users</span></a>
            </li>

            <li class="menu-list"><a href="javascript: undefined;"><i class="fa fa-archive"></i> <span>Inventory</span></a>
                <ul class="child-list">
                    <li><a href="<?php echo site_url('Admin/categories') ?>"> <i class="fa fa-list"></i> Categories</a></li>
                    <li><a href="<?php echo site_url('Admin/suppliers') ?>"> <i class="fa fa-users"></i> Suppliers</a></li>
                    <li><a href="<?php echo site_url('Admin/drugs') ?>"> <i class="fa fa-medkit"></i> Drugs</a></li>
                </ul>
            </li>

<!--            <li class="menu-list"><a href=""><i class="fa fa-bar-chart-o"></i> <span>Charts </span></a>
                <ul class="child-list">
                    <li><a href="flot-chart.html"> Flot Charts</a></li>
                    <li><a href="morris-chart.html"> Morris Charts</a></li>
                    <li><a href="chartjs.html"> Chartjs</a></li>
                </ul>
            </li>-->
            <!--            <li>
                            <h3 class="navigation-title">Extra</h3>
                        </li>-->

<!--            <li class="menu-list"><a href="javascript:;"><i class="fa fa-envelope-o"></i> <span>Email <span class="label noti-arrow bg-danger pull-right">4 Unread</span> </span></a>
                <ul class="child-list">
                    <li><a href="inbox.html"> Inbox</a></li>
                    <li><a href="inbox-details.html"> View Mail</a></li>
                    <li><a href="inbox-compose.html"> Compose Mail</a></li>
                </ul>
            </li>-->

<!--            <li class="menu-list"><a href="javascript:;"><i class="fa fa-map-marker"></i> <span>Maps</span></a>
                <ul class="child-list">
                    <li><a href="google-map.html"> Google Map</a></li>
                    <li><a href="vector-map.html"> Vector Map</a></li>
                </ul>
            </li>-->

<!--            <li class="menu-list"><a href=""><i class="fa fa-file-text"></i> <span>Extra Pages</span></a>
                <ul class="child-list">
                    <li><a href="profile.html"> Profile</a></li>
                    <li><a href="invoice.html"> Invoice</a></li>
                    <li><a href="login.html"> Login </a></li>
                    <li><a href="registration.html"> Registration </a></li>
                    <li><a href="lock.html"> Lock Screen </a></li>
                    <li><a href="404.html"> 404 Error</a></li>
                    <li><a href="500.html"> 500 Error</a></li>

                </ul>
            </li>-->

        </ul>
        <!--sidebar nav end-->

        <!--sidebar widget start-->
        <!--        <div class="sidebar-widget">
                    <h4>Server Status</h4>
                    <ul class="list-group">
                        <li>
                            <span class="label label-danger pull-right">33%</span>
                            <p>CPU Used</p>
                            <div class="progress progress-xs">
                                <div class="progress-bar progress-bar-danger" style="width: 33%;">
                                    <span class="sr-only">33%</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <span class="label label-warning pull-right">65%</span>
                            <p>Bandwidth</p>
                            <div class="progress progress-xs">
                                <div class="progress-bar progress-bar-warning" style="width: 65%;">
                                    <span class="sr-only">65%</span>
                                </div>
                            </div>
                        </li>
                        <li><a href="javascript:;" class="btn btn-success btn-sm ">View Details</a></li>
                    </ul>
                </div>-->
        <!--sidebar widget end-->

    </div>
</div>
<!-- sidebar left end-->