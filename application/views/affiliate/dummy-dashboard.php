<html>
    <head>
        <meta charset="UTF-8">
        <title>Wish-Fish</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

        <link href="<?= base_url() ?>favicon.ico" rel="Shortcut Icon" type="image/x-icon" />

        <!-- Bootstrap -->
        <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"/>

        <!-- Bootstrap Slider -->
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dashboard/css/bootstrap-slider/slider.css"/>

        <!-- Bootstrap Color Picker -->
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dashboard/css/colorpicker/bootstrap-colorpicker.min.css"/>

        <!-- Bootstrap Time Picker -->
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dashboard/css/timepicker/bootstrap-timepicker.min.css"/>

        <!-- DATA TABLES -->
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dashboard/css/datatables/dataTables.bootstrap.css"/>

        <!-- Bootstrap WYSIHTML5 (Text Editor) -->
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dashboard/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css"/>

        <!-- Font-Awesome -->
        <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css"/>

        <!-- Ionicons -->
        <link rel="stylesheet" type="text/css" href="//code.ionicframework.com/ionicons/1.5.2/css/ionicons.min.css"/>

        <!-- Ion Slider -->
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dashboard/css/ionslider/ion.rangeSlider.css"/>

        <!-- Ion Slider Nice -->
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dashboard/css/ionslider/ion.rangeSlider.skinNice.css"/>

        <!-- Morris chart -->
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dashboard/css/morris/morris.css"/>

        <!-- jvectormap -->
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dashboard/css/jvectormap/jquery-jvectormap-1.2.2.css"/>

        <!--pickers css-->
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dashboard/js/plugins/bootstrap-datepicker/css/datepicker.css" />
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dashboard/js/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" />

        <!-- Date Picker -->
        <!--<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dashboard/css/datepicker/datepicker3.css"/>-->

        <!-- Daterange Picker -->
        <!--<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dashboard/css/daterangepicker/daterangepicker-bs3.css"/>-->

        <!-- Full Calendar -->
        <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.0.2/fullcalendar.css"/>
        <link rel="stylesheet" type="text/css" media='print' href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.0.2/fullcalendar.print.css"/>

        <!-- iCheck for checkboxes and radio inputs -->
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dashboard/css/iCheck/all.css"/>

        <!-- iCheck for checkboxes and radio inputs -->
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dashboard/css/iCheck/minimal/blue.css"  />

        <!-- Theme Style -->
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dashboard/css/AdminLTE.css"/>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <!-- Alertify -->
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dashboard/css/alertify.core.css"/>
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dashboard/css/alertify.default.css"/>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js"></script>

        <!-- JQuery -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

        <!-- JQuery UI -->
        <script src="//code.jquery.com/ui/1.11.1/jquery-ui.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="<?= base_url() ?>assets/dashboard/js/AdminLTE/jquery.resize.js"></script>

        <script src="<?= base_url() ?>assets/dashboard/exportToExcel/jquery.battatech.excelexport.js"></script>

        <!--BOOTSTRAP--> 
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" type="text/javascript"></script>




        <!--pickers plugins-->
        <script type="text/javascript" src="<?= base_url() ?>assets/dashboard/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

        <!--Cookie-->
        <script type="text/javascript" src="<?= base_url() ?>assets/dashboard/js/jquery.cookie.js"></script>

        <!--Alertify-->
        <script type="text/javascript" src="<?= base_url() ?>assets/dashboard/js/alertify.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>assets/dashboard/js/alertify.min.js"></script>
        <style type="text/css">
            .title-blue{
                float: left;
                width: 74%;
                text-align: center;
                /* padding: 0px; */
                font-size: 28px;
                color: white
            }
            .navbar ul.menu,.navbar .slimScrollDiv{
                height: 550px !important;
            }
        </style>
    </head>
    <body class="skin-blue">

        <header class="header">
            <a href="#" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                <?= $this->session->userdata('name') ?> 
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top fixed"  role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <img src="<?= base_url() . 'assets/dashboard/img/default-avatar.png' ?>" class="img-circle" alt="User Image" />
                                    <p>
                                        <?= $this->session->userdata('name') ?>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-right">
                                        <a href="#" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="row title-blue">
                    <div id="titleblue" class="col-md-12"></div>
                </div>
            </nav>
        </header>
        <!-- Right side column. Contains the navbar and content of the page -->

        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="<?= base_url() . 'assets/dashboard/img/default-avatar.png' ?>" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p><?= $this->session->userdata('name') ?></p>
                        </div>
                    </div>

                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="active" id="1">
                            <a href="#">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="" id="2">
                            <a href="#">
                                <i class="fa fa-th"></i> <span>Calendar</span>
                            </a>
                        </li>
                        <li class="treeview" id="3">
                            <a style="float: right" href="#">
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <a  href="#">
                                <i class="fa fa-envelope"></i>
                                <span>Admin</span>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="#">
                                        <i class="fa fa-angle-double-right"></i> <span>Admin Access Class</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="treeview" id="4">
                            <a style="float: right" href="#">
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <a href="#">
                                <i class="fa fa-wrench"></i> <span>Company Contacts</span>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="#">
                                        <i class="fa fa-plus"></i>
                                        <span>Create New Contact</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-angle-double-right"></i> <span>Contact Groups</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-lock"></i>
                                        <span>Contact Block List</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-angle-double-right"></i>
                                        <span>Scrape Contacts</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="treeview" id="5">
                            <a style="float: right" href="#">
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <a href="#">
                                <i class="fa fa-wrench"></i> <span>Affiliates</span>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="#">
                                        <i class="fa fa-plus"></i>
                                        <span>Create New Affiliate</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-angle-double-right"></i> <span>Affiliate Groups</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="treeview" id="6">
                            <a style="float: right" href="#">
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <a href="#">
                                <i class="fa fa-envelope"></i>
                                <span>Customers</span>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="#">
                                        <i class="fa fa-plus"></i>
                                        <span>Create New Customer</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-angle-double-right"></i> <span>Customer Groups</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="treeview" id="7">
                            <a style="float: right" href="#">
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <a class="tab-desktop" href="#">
                                <i class="fa fa-wrench"></i> <span>SMS</span>
                            </a>
                            <a class="tab-mobile" href="#">
                                <i class="fa fa-wrench"></i> <span>SMS</span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="#"><i class="fa fa-angle-double-right"></i> SMS Blast</a></li>
                                <li><a href="#"><i class="fa fa-angle-double-right"></i> SMS List Builder</a></li>
                                <li><a href="#"><i class="fa fa-angle-double-right"></i> SMS Template</a></li>
                            </ul>
                        </li>
                        <li class="treeview" id="8">
                            <a style="float: right" href="#">
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <a href="#">
                                <i class="fa fa-wrench"></i> <span>Email</span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="#"><i class="fa fa-angle-double-right"></i> Email Blast</a></li>
                                <li><a href="#"><i class="fa fa-angle-double-right"></i> Email List Builder</a></li>
                                <li><a href="#"><i class="fa fa-angle-double-right"></i> <span>Email Template</span></a></li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-angle-double-right"></i>
                                        <span>Email Notification</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-angle-double-right"></i>
                                        <span>Email Accounts</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="treeview" id="10">
                            <a href="#">
                                <i class="fa fa-wrench"></i>
                                <span>Settings</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="#">
                                        <i class="fa fa-angle-double-right"></i> <span>Admin Panel Setting</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-angle-double-right"></i> <span>Email Setting</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-angle-double-right"></i> <span>SMS Setting</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-angle-double-right"></i> <span>Calender Setting</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-angle-double-right"></i> <span>Payment Setting</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="treeview" id="11">
                            <a style="float: right" href="#">
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <a  href="#">
                                <i class="fa fa-angle-double-right"></i>
                                <span>FAQ'S</span>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="#">
                                        <i class="fa fa-angle-double-right"></i> <span>FAQ'S Category</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="treeview" id="12">
                            <a style="float: right" href="#">
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <a  href="#">
                                <i class="fa fa-angle-double-right"></i>
                                <span>Web Pages</span>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="#">
                                        <i class="fa fa-angle-double-right"></i> <span>Homepage Section</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="" id="13">
                            <a href="#">
                                <i class="fa fa-angle-double-right"></i> <span>Feedback/Support</span>
                            </a>
                        </li>
                        <li class="" id="14">
                            <a href="#">
                                <i class="fa fa-angle-double-right"></i> <span>Coupons</span>
                            </a>
                        </li>
                        <li class="treeview" id="15">
                            <a href="#">
                                <i class="fa fa-wrench"></i>
                                <span>Analytics</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="#">
                                        <i class="fa fa-angle-double-right"></i> <span>Total Payment</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-angle-double-right"></i> <span>Total Users</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-angle-double-right"></i> <span>Total New User</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-angle-double-right"></i> <span>Admin Report</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="" id="16">
                            <a href="#">
                                <i class="fa fa-angle-double-right"></i> <span>Product Builder</span>
                            </a>
                        </li>
                        <li class="" id="17">
                            <a href="#">
                                <i class="fa fa-angle-double-right"></i> <span>Payment Plan Builder</span>
                            </a>
                        </li>
                        <li class="" id="18">
                            <a href="#">
                                <i class="fa fa-angle-double-right"></i> <span>Offer Builder</span>
                            </a>
                        </li>
                        <li class="" id="19">
                            <a href="#" target="_blank">
                                <i class="fa fa-angle-double-right"></i> <span>Page Builder</span>
                            </a>
                        </li>
                        <li class="" id="20">
                            <a href="#">
                                <i class="fa fa-angle-double-right"></i> <span>Media Library</span>
                            </a>
                        </li>
                        <li class="" id="21">
                            <a href="#">
                                <i class="fa fa-angle-double-right"></i> <span>Funnel Email List</span>
                            </a>
                        </li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header" style="display: none">
                    <h1 style="display: none">
                        Dashboard
                    </h1>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3>
                                        <span id="totalY">
                                            0
                                        </span>
                                    </h3>
                                    <p>
                                        This Year
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>

                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3>
                                        <span>0</span>
                                    </h3>
                                    <p>
                                        This Month
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>

                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h3>
                                        <span>0</span>
                                    </h3>
                                    <p>
                                        This Week
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>

                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3>
                                        <span>0</span>
                                    </h3>
                                    <p>
                                        This Day
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                            </div>
                        </div><!-- ./col -->
                    </div><!-- /.row -->
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div>
    </body>
</html>
<script type="text/javascript">
    $('#titleblue').text($('.content-header h1').text());
</script>
