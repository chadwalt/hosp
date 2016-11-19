<!---------------------------------------------Header section---------------------------------------------------->
<!---------------------------------------------Navigation section---------------------------------------------------->
<!---------------------------------------------Notification section---------------------------------------------------->


<!-- page head start-->
<div class="page-head">
    <h3>
        Suppliers
    </h3>
    <span class="sub-title">View/Add/Edit Suppliers</span>
    <div class="state-information">
        <div class="state-graph">
            <div class="info" id="suppliers_num">Suppliers: 0</div>
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
                    <!--Supplier Datagrid.-->
                    <table  id="suppliers_dg" style="width:100%;height:350px" pagination="true" toolbar="#suppliers_toolbar" data-options="url:'<?php echo site_url('Admin/get_med_suppliers') ?>',fitColumns:true,singleSelect:true,striped:true,rownumbers:true">
                        <thead>
                            <tr>
                                <th field="id" width="100" hidden="true"> ID</th>
                                <th field="name" width="100" editor="text" >Supplier Name</th>
                                <th field="phone" width="150" editor="text">Phone</th>   
                                <th field="email" width="150" editor="text">Email</th>   
                                <th field="address" width="150" editor="text">Address</th>   
                            </tr>
                        </thead>
                    </table>
                    <!-- Supplier datagrid toolbar-->
                    <div id="suppliers_toolbar">
                        <button  onclick="javascript: $('#suppliers_dg').edatagrid('addRow'); " ><a href="javascript:undefined;"  class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true">Add Supplier</a></button>
                        <button onclick="javascript: $('#suppliers_dg').edatagrid('saveRow'); refresh('#suppliers_dg');"><a href="javascript:undefined;"   class="easyui-linkbutton" data-options="iconCls:'icon-edit',plain:true">Save Supplier</a></button>
                        <button id="delete_supplier"><a href="javascript:undefined;" class="easyui-linkbutton"  data-options="iconCls:'icon-remove',plain:true">Delete Supplier</a></button>

                        <!--<button id="users_positions"><a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-redo',plain:true">Positions</a></button>-->
                        <button onclick="javascript: $('#suppliers_dg').edatagrid('cancelRow');"><a href="javascript:undefined;"  class="easyui-linkbutton" data-options="iconCls:'icon-undo',plain:true">Cancel</a></button>

                        <span style="float: right;"><input type="search" class="easyui-searchbox" placeholder="Search Supplier"  style="left: 50px;" id="search_student" name="search_supplier"/></span>
                    </div>
                    <!-- End of view Suppliers datagrid-->

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
<script type="text/javascript" src="<?php echo base_url(); ?>libraries/easyui/jquery.edatagrid.js"></script>

<!--Mine Scripts-->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/mine/js/suppliers.js"></script>

<!--common scripts for all pages-->

<script src="<?php echo base_url(); ?>libraries/js/scripts.js"></script>

</body>
</html>
