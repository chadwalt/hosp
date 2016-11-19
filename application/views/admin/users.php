<!---------------------------------------------Header section---------------------------------------------------->
<!---------------------------------------------Navigation section---------------------------------------------------->
<!---------------------------------------------Notification section---------------------------------------------------->


<!-- page head start-->
<div class="page-head">
    <h3>
        Users
    </h3>
    <span class="sub-title">View/Add/Edit User</span>
    <div class="state-information">
        <div class="state-graph">
            <div class="info" id="active_users_dash">Active Users: 0</div>
        </div>
        <div class="state-graph">
            <div class="info" id="inactive_users_dash">Inactive Users: 0</div>
        </div>
    </div>
</div>
<!-- page head end-->

<!--body wrapper start-->
<div class="wrapper">

    <div class="row">
        <div class="col-md-12">
            <section class="panel">
<!--                <header class="panel-heading">
                    View/Add/Edit Users
                    <span class="tools pull-right">
                        <a class="fa fa-repeat box-refresh" href="javascript:;"></a>
                        <a class="t-collapse fa fa-chevron-down" href="javascript:;"></a>
                        <a class="t-close fa fa-times" href="javascript:;"></a>
                    </span>
                </header>-->
                <div class="panel-body">
                    <!--User Datagrid.-->
                    <table class="easyui-datagrid" id="users_dg" style="width:100%;height:350px" pagination="true" toolbar="#users_toolbar" data-options="url:'<?php echo site_url('Users/get_users') ?>',fitColumns:true,singleSelect:true,striped:true,rownumbers:true">
                        <thead>
                            <tr>
                                <th data-options="field:'id',width:1,hidden:true">id</th>
                                <th data-options="field:'full_name',width:20">Full Name</th>
                                <th data-options="field:'username',width:20">Username</th>
                                <th data-options="field:'contact',width:20">Contact </th>
                                <th data-options="field:'email',width:20">Email</th>
                                <th data-options="field:'positions',width:20">Position</th>                                                                        
                                <th data-options="field:'active_status',width:20,formatter:active_formatter">Status</th>
                            </tr>
                        </thead>
                    </table>
                    <!-- User datagrid toolbar-->
                    <div id="users_toolbar">
                        <button id="add_user"><a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true">Add User</a></button>
                        <button id="edit_user"><a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-edit',plain:true">Edit User</a></button>
                        <button id="delete_user"><a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-remove',plain:true">Delete User</a></button>

                        <!--<button id="users_positions"><a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-redo',plain:true">Positions</a></button>-->
                        <button id="active-deactive"><a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-undo',plain:true">Activate/Deactivate</a></button>

                        <span style="float: right;"><input type="search" class="easyui-searchbox" placeholder="Search User"  style="left: 50px;" id="search_student" name="search_student"/></span>
                    </div>
                    <!-- End of view users datagrid-->

                    <div class="easyui-dialog" id="user_dlg" data-options="iconCls:'icon-save',resizable:true,modal:true,closed:true" style="width: 700px; height: auto;top: 40px;" buttons="#user_info_toolbar">
                        <form method="POST" name="user_form" id="user_form" enctype="multipart/form-data" action="<?php echo site_url('Users/save_user') ?>">
                            <div class="row" style="margin-top: 20px; width: 690px;" >
                                <!--This div will hold the student's picture-->
                                <div class="col-sm-4">
                                    <img src="" alt="Users Picture" style="margin-left: 5px;" class="user_picture" width="200px" height="200px">
                                </div>
                                <input type="hidden" class="form-control" name="id" id="user_id" />
                                <div class="col-sm-7" style="margin-left: 40px;">
                                    <div class="form-group">
                                        <label for="full_name" class="col-sm-4 control-label">Full Name</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="full_name" id="full_name">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <label for="username" class="col-sm-4 control-label">Username</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="username" id="username">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group" id="password_group">
                                        <label for="password" class="col-sm-4 control-label">Password</label>
                                        <div class="col-sm-8">
                                            <input type="password" name="password" id="password">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <label for="gender" class="col-sm-4 control-label">Sex</label>
                                        <div class="col-sm-8">
                                            <input type="radio" name="gender" id="male" value="M">Male &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="radio" name="gender" id="female" checked value="F">Female
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <label for="address" class="col-sm-4 control-label">Address</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="address" id="address" data-options="required:true" />
                                        </div>
                                    </div>

                                    <br>
                                    <div class="form-group">
                                        <label for="email" class="col-sm-4 control-label">Email</label>
                                        <div class="col-sm-8">
                                            <input type="email" name="email" id="email" data-options="required:true" />
                                        </div>
                                    </div>

                                    <br>

                                    <div class="form-group">
                                        <label for="phone" class="col-sm-4 control-label">Phone</label>
                                        <div class="col-sm-8">
                                            <input type="tel" name="phone" id="phone">
                                        </div>
                                    </div>                                    

                                    <br>
                                    <div class="form-group">
                                        <label for="position" class="col-sm-4 control-label">Position</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="positions" id="position">
                                        </div>
                                    </div>                                    

                                    <br>
                                    <div class="form-group">
                                        <label for="picture" class="col-sm-4 control-label">Picture</label>
                                        <div class="col-sm-8">
                                            <input class="easyui-filebox" name="upload_picture" accept="image/*" id="upload_picture">
                                        </div>
                                    </div>
                                    <br>
                                </div>
                            </div>
                        </form>
                        <div id="user_info_toolbar">
                            <button id="save_student"><a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-save',plain:true">Save</a></button>
                            <button id="cancel_user_dlg"><a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-cancel',plain:true">Cancel</a></button>
                        </div>
                    </div>

                </div>
            </section>
        </div>

    </div>

</div>
<!--body wrapper end-->


<!--footer section start-->
<footer>
    2015 &copy; SlickLab by VectorLab.
</footer>
<!--footer section end-->


<!-- Right Slidebar start -->
<div class="sb-slidebar sb-right sb-style-overlay">
    <div class="right-bar">

        <span class="r-close-btn sb-close"><i class="fa fa-times"></i></span>

        <ul class="nav nav-tabs nav-justified-">
            <li class="active">
                <a href="#chat" data-toggle="tab">Chat</a>
            </li>
            <li class="">
                <a href="#info" data-toggle="tab">Info</a>
            </li>
            <li class="">
                <a href="#settings" data-toggle="tab">Settings</a>
            </li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active " id="chat">
                <div class="online-chat">
                    <div class="online-chat-container">
                        <div class="chat-list">
                            <h3>Chat list</h3>
                            <h5>34 Friends Online, 80 Offline</h5>
                            <a href="#" class="add-people tooltips" data-original-title="Add People" data-toggle="tooltip" data-placement="left">
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                        <div class="side-title">
                            <h2>online</h2>
                            <div class="title-border-row">
                                <div class="title-border"></div>
                            </div>
                        </div>

                        <ul class="team-list chat-list-side">
                            <li>
                                <a href="#">
                                    <span class="thumb-small">
                                        <img class="circle" src="img/img2.jpg" alt="">
                                        <i class="online dot"></i>
                                    </span>
                                    <div class="inline">
                                        <span class="name">
                                            Alison Jones
                                        </span>
                                        <small class="text-muted">Start exploring</small>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="thumb-small">
                                        <img class="circle" src="img/img3.jpg" alt="">
                                        <i class="online dot"></i>
                                    </span>
                                    <div class="inline">
                                        <span class="name">
                                            Jonathan Smith
                                        </span>
                                        <small class="text-muted">Alien Inside</small>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="thumb-small">
                                        <img class="circle" src="img/img1.jpg" alt="">
                                        <i class="away dot"></i>
                                    </span>
                                    <div class="inline">
                                        <span class="name">
                                            Anjelina Doe
                                        </span>
                                        <small class="text-muted">Screaming...</small>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="thumb-small">
                                        <img class="circle" src="img/img3.jpg" alt="">
                                        <i class="busy dot"></i>
                                    </span>
                                    <div class="inline">
                                        <span class="name">
                                            Franklin Adam
                                        </span>
                                        <small class="text-muted">Don't lose the hope</small>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="thumb-small">
                                        <img class="circle" src="img/img2.jpg" alt="">
                                        <i class="online dot"></i>
                                    </span>
                                    <div class="inline">
                                        <span class="name">
                                            Jeff Crowford
                                        </span>
                                        <small class="text-muted">Just flying</small>
                                    </div>
                                </a>
                            </li>

                        </ul>

                        <div class="side-title">
                            <h2>Offline</h2>
                            <div class="title-border-row">
                                <div class="title-border"></div>
                            </div>
                        </div>
                        <ul class="team-list chat-list-side">
                            <li>
                                <a href="#">
                                    <span class="thumb-small">
                                        <img class="circle" src="img/img2.jpg" alt="">
                                        <i class="offline dot"></i>
                                    </span>
                                    <div class="inline">
                                        <span class="name">
                                            Alison Jones
                                        </span>
                                        <small class="text-muted">Start exploring</small>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="thumb-small">
                                        <img class="circle" src="img/img3.jpg" alt="">
                                        <i class="offline dot"></i>
                                    </span>
                                    <div class="inline">
                                        <span class="name">
                                            Jonathan Smith
                                        </span>
                                        <small class="text-muted">Alien Inside</small>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="thumb-small">
                                        <img class="circle" src="img/img1.jpg" alt="">
                                        <i class="offline dot"></i>
                                    </span>
                                    <div class="inline">
                                        <span class="name">
                                            Anjelina Doe
                                        </span>
                                        <small class="text-muted">Screaming...</small>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="thumb-small">
                                        <img class="circle" src="img/img3.jpg" alt="">
                                        <i class="offline dot"></i>
                                    </span>
                                    <div class="inline">
                                        <span class="name">
                                            Franklin Adam
                                        </span>
                                        <small class="text-muted">Don't lose the hope</small>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="thumb-small">
                                        <img class="circle" src="img/img2.jpg" alt="">
                                        <i class="offline dot"></i>
                                    </span>
                                    <div class="inline">
                                        <span class="name">
                                            Jeff Crowford
                                        </span>
                                        <small class="text-muted">Just flying</small>
                                    </div>
                                </a>
                            </li>

                        </ul>
                    </div>


                </div>


            </div>

            <div role="tabpanel" class="tab-pane " id="info">
                <div class="chat-list info">
                    <h3>Latest Information</h3>
                    <a  href="javascript:;" class="add-people tooltips" data-original-title="Refresh" data-toggle="tooltip" data-placement="left">
                        <i class="fa fa-repeat"></i>
                    </a>
                </div>

                <div class="aside-widget">
                    <div class="side-title-alt">
                        <h2>Revenue</h2>
                        <a href="#" class="close side-w-close">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                    <ul class="team-list chat-list-side info">
                        <li>
                            <span class="thumb-small">
                                <i class="fa fa-circle green-color"></i>
                            </span>
                            <div class="inline">
                                <span class="name">
                                    Received Money from John Doe
                                </span>
                                <span class="value green-color">$12300</span>
                            </div>
                        </li>
                        <li>
                            <span class="thumb-small">
                                <i class="fa fa-circle purple-color"></i>
                            </span>
                            <div class="inline">
                                <span class="name">
                                    Total Admin Template Sales
                                </span>
                                <span class="value purple-color">$40100</span>
                            </div>
                        </li>
                        <li>
                            <span class="thumb-small">
                                <i class="fa fa-circle red-color"></i>
                            </span>
                            <div class="inline">
                                <span class="name">
                                    Monty Revenue
                                </span>
                                <span class="value red-color">$322300</span>
                            </div>
                        </li>
                        <li>
                            <span class="thumb-small">
                                <i class="fa fa-circle blue-color"></i>
                            </span>
                            <div class="inline">
                                <span class="name">
                                    Received Money from John Doe
                                </span>
                                <span class="value blue-color">$1520</span>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="aside-widget">

                    <div class="side-title-alt">
                        <h2>Statistics</h2>
                        <a href="#" class="close side-w-close">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                    <ul class="team-list chat-list-side info statistics border-less-list">
                        <li>
                            <div class="inline">
                                <span class="name">
                                    Foreign Visit
                                </span>
                                <small class="text-muted">25% Increase</small>
                            </div>
                            <span class="thumb-small">
                                <span id="foreign-visit" class="chart"></span>
                            </span>
                        </li>
                        <li>
                            <div class="inline">
                                <span class="name">
                                    Montly Visit
                                </span>
                                <small class="text-muted">Average visit 12% Increase</small>
                            </div>
                            <span class="thumb-small">
                                <span id="monthly-visit" class="chart"></span>
                            </span>
                        </li>
                        <li>
                            <div class="inline">
                                <span class="name">
                                    Unique Visit
                                </span>
                                <small class="text-muted">35% unique visitor </small>
                            </div>
                            <span class="thumb-small">
                                <span id="unique-visit" class="chart"></span>
                            </span>
                        </li>
                    </ul>
                </div>

                <div class="aside-widget">
                    <div class="side-title-alt">
                        <h2>Notification</h2>
                        <a href="#" class="close side-w-close">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                    <ul class="team-list chat-list-side info border-less-list">
                        <li>
                            <span class="thumb-small">
                                <i class="fa fa-bell green-color"></i>
                            </span>
                            <div class="inline">
                                <span class="name">
                                    Meeting with John Doe at
                                </span>
                                <span class="value text-muted">11.30 am</span>
                            </div>
                        </li>
                        <li>
                            <span class="thumb-small">
                                <i class="fa fa-users green-color"></i>
                            </span>
                            <div class="inline">
                                <span class="name">
                                    3 membership request pending
                                </span>
                                <span class="value text-muted">John, Smith, Lira</span>
                            </div>
                        </li>
                    </ul>

                </div>

                <div class="aside-widget">


                    <div class="side-title-alt">
                        <h2>System</h2>
                        <a href="#" class="close side-w-close">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                    <ul class="team-list chat-list-side info border-less-list">
                        <li>
                            <div class="inline">
                                <span class="name">
                                    Received database error report from hosting provider
                                </span>
                                <span class="value text-muted">11.30 am</span>
                            </div>
                        </li>
                        <li>
                            <div class="inline">
                                <span class="name">
                                    Hosting Renew notification
                                </span>
                                <span class="value text-muted">12.00 pm</span>
                            </div>
                        </li>

                    </ul>
                </div>

                <div class="aside-widget">
                    <div class="side-title-alt">
                        <h2>Work Progress</h2>
                        <a href="#" class="close side-w-close">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                    <ul class="team-list chat-list-side info border-less-list sale-monitor">
                        <li>
                            <div class="states">
                                <div class="info">
                                    <div class="desc pull-left">Server Setup and Configuration</div>
                                </div>
                                <div class="progress progress-xs">
                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 50%"></div>
                                </div>
                                <div class="info">
                                    <small class="percent pull-left text-muted">50% completed</small>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="states">
                                <div class="info">
                                    <div class="desc pull-left">Website Design & Development</div>
                                </div>
                                <div class="progress progress-xs">
                                    <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 85%"></div>
                                </div>
                                <div class="info">
                                    <small class="percent pull-left text-muted">85% completed</small>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

            </div>

            <div role="tabpanel" class="tab-pane " id="settings">
                <div class="chat-list bottom-border settings-head">
                    <h3>Account Setting</h3>
                    <h5>Configure your account as per your need.</h5>
                </div>
                <ul class="team-list chat-list-side info statistics border-less-list setting-list">
                    <li>
                        <div class="inline">
                            <span class="name">
                                Make my feature post public?
                            </span>
                            <small class="text-muted">Everyone will be able to see, like, comment
                                and share your feature post.</small>
                        </div>
                        <span class="thumb-small">
                            <input type="checkbox" class="js-switch-small" checked/>
                        </span>
                    </li>
                    <li>
                        <div class="inline">
                            <span class="name">
                                Show offline Contacts
                            </span>
                            <small class="text-muted">Lorem ipsum dolor sit amet, consectetuer
                                adipiscing elit.</small>
                        </div>
                        <span class="thumb-small">
                            <input type="checkbox" class="js-switch-small2" checked/>
                        </span>
                    </li>

                    <li>
                        <div class="inline">
                            <span class="name">
                                Everyone will see my stuff
                            </span>
                            <small class="text-muted">Lorem ipsum dolor sit amet, consectetuer
                                adipiscing elit.</small>
                        </div>
                        <span class="thumb-small">
                            <input type="checkbox" class="js-switch-small3"/>
                        </span>
                    </li>

                </ul>

                <div class="chat-list bottom-border settings-head">
                    <h3>General Setting</h3>
                    <h5>Configure your account as per your need.</h5>
                </div>
                <ul class="team-list chat-list-side info statistics border-less-list setting-list">
                    <li>
                        <div class="inline">
                            <span class="name">
                                Show me Online
                            </span>
                        </div>
                        <span class="thumb-small">
                            <input type="checkbox" class="js-switch-small4" checked/>
                        </span>
                    </li>
                    <li>
                        <div class="inline">
                            <span class="name">
                                Status visible to all
                            </span>
                        </div>
                        <span class="thumb-small">
                            <input type="checkbox" class="js-switch-small5" />
                        </span>
                    </li>

                    <li>
                        <div class="inline">
                            <span class="name">
                                Show my work progess to all
                            </span>
                        </div>
                        <span class="thumb-small">
                            <input type="checkbox" class="js-switch-small6" checked/>
                        </span>
                    </li>

                </ul>

            </div>

        </div>
    </div>
</div>
<!-- Right Slidebar end -->

</div>
<!-- body content end-->
</section>



<!-- Placed js at the end of the document so the pages load faster -->
<script src="<?php echo base_url(); ?>libraries/js/jquery-1.10.2.min.js"></script>

<!--jquery-ui-->
<script src="<?php echo base_url(); ?>libraries/js/jquery-ui/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>

<script src="<?php echo base_url(); ?>libraries/js/jquery-migrate.js"></script>
<script src="<?php echo base_url(); ?>libraries/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>libraries/js/modernizr.min.js"></script>

<!--Nice Scroll-->
<script src="<?php echo base_url(); ?>libraries/js/jquery.nicescroll.js" type="text/javascript"></script>

<!--right slidebar-->
<script src="<?php echo base_url(); ?>libraries/js/slidebars.min.js"></script>

<!--switchery-->
<script src="<?php echo base_url(); ?>libraries/js/switchery/switchery.min.js"></script>
<script src="<?php echo base_url(); ?>libraries/js/switchery/switchery-init.js"></script>

<!--flot chart -->
<!--<script src="js/flot-chart/jquery.flot.js"></script>
<script src="js/flot-chart/flot-spline.js"></script>
<script src="js/flot-chart/jquery.flot.resize.js"></script>
<script src="js/flot-chart/jquery.flot.tooltip.min.js"></script>
<script src="js/flot-chart/jquery.flot.pie.js"></script>
<script src="js/flot-chart/jquery.flot.selection.js"></script>
<script src="js/flot-chart/jquery.flot.stack.js"></script>
<script src="js/flot-chart/jquery.flot.crosshair.js"></script>-->


<!--earning chart init-->
<!--<script src="js/earning-chart-init.js"></script>-->


<!--Sparkline Chart-->
<!--<script src="js/sparkline/jquery.sparkline.js"></script>
<script src="js/sparkline/sparkline-init.js"></script>-->

<!--easy pie chart-->
<!--<script src="js/jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script>
<script src="js/easy-pie-chart.js"></script>-->


<!--vectormap-->
<!--<script src="js/vector-map/jquery-jvectormap-1.2.2.min.js"></script>
<script src="js/vector-map/jquery-jvectormap-world-mill-en.js"></script>
<script src="js/dashboard-vmap-init.js"></script>-->

<!--Icheck-->
<script src="<?php echo base_url(); ?>libraries/js/icheck/skins/icheck.min.js"></script>
<script src="<?php echo base_url(); ?>libraries/js/todo-init.js"></script>

<!--jquery countTo-->
<script src="<?php echo base_url(); ?>libraries/js/jquery-countTo/jquery.countTo.js"  type="text/javascript"></script>

<!--owl carousel-->
<!--<script src="<?php echo base_url(); ?>libraries/js/owl.carousel.js"></script>-->

<!--Easyui Scripts-->
<script type="text/javascript" src="<?php echo base_url(); ?>libraries/easyui/jquery.easyui.min.js"></script>

<!--common scripts for all pages-->

<script src="<?php echo base_url(); ?>libraries/js/scripts.js"></script>

<!--Easyui Scripts-->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/mine/js/users.js"></script>

<script>
    var base_url = "<?php echo base_url(); ?>";
    var site_url = "<?php echo site_url(); ?>";
</script>
</body>
</html>
