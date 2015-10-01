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


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js"></script>

        <!-- JQuery -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

        <!-- JQuery UI -->
        <script src="//code.jquery.com/ui/1.11.1/jquery-ui.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="<?= base_url() ?>assets/dashboard/js/AdminLTE/jquery.resize.js"></script>


        <!--BOOTSTRAP--> 
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" type="text/javascript"></script>

        <style type="text/css">
            .title-blue{
                float: left;
                width: 74%;
                text-align: center;
                /* padding: 0px; */
                font-size: 28px;
                color: white
            }
            .overlay{
                /*display:none;*/
                position:absolute;
                background:rgba(0,0,0,0.50) 0%;
                top:0;
                left:0;
                z-index:99999;
                width:100%;
                height: 100%;
            }
            .overlay div.msg{
                padding: 14% 20%;
                color: white
            }
        </style>
    </head>
    <?php
    $avatar = $this->session->userdata('a_avatar');

    $aff_img_src = ($avatar != "") ?
            "https://mikhailkuznetsov.s3.amazonaws.com/" . $avatar :
            base_url() . 'assets/dashboard/img/default-avatar.png';
    ?>
    <body class="skin-blue">
        <header class="header">
            <a href="<?= site_url() ?>admin/dashboard" class="logo">
                <!--Add the class icon to your logo image or logo icon to add the margining--> 
                <?= (!$affInfo) ? $this->session->userdata('d-name') : $affInfo->fname . ' ' . $affInfo->lname ?> 
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
                        <!-- New Payment Notification -->
                        <li class="dropdown messages-menu payment-notification">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-tasks"></i>
                                <span class="label label-success">
                                    0
                                </span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 0 payments</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">

                                    </ul>
                                </li>
                                <li class="footer"><a href="#">See All Payments</a></li>
                            </ul>
                        </li>
                        <!-- ENd Payment Notification -->
                        <!-- New Customer Join Notification -->
                        <li class="dropdown messages-menu customer-notification">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-tasks"></i>
                                <span class="label label-success">
                                    0
                                </span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 0 Customers</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu newCustomer">

                                    </ul>
                                </li>
                                <li class="footer"><a href="#">See All Customers</a></li>
                            </ul>
                        </li>
                        <!-- ENd New Customer Join Notification -->
                        <!-- SMS Inbox -->
                        <li class="dropdown messages-menu sms-notification">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-envelope"></i>
                                <span class="label label-success">
                                    0
                                </span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 0 messages</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu unreadSMS">

                                    </ul>
                                </li>
                                <li class="footer"><a href="#">See All Messages</a></li>
                            </ul>
                        </li>
                        <!-- End SMS Inbox -->
                        <!-- Emails -->
                        <li class="dropdown messages-menu email-notify">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-envelope-o"></i>
                                <span class="label label-success ebadge">0</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 0 emails</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu"></ul>
                                </li>
                                <li class="footer"><a href="#">See All Emails</a></li>
                            </ul>
                        </li>
                        <!-- ENd Email -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <img src="<?= $aff_img_src ?>" class="img-circle" alt="User Image" />
                                    <p>
                                        <?= (!$affInfo) ? $this->session->userdata('d-name') : $affInfo->fname . ' ' . $affInfo->lname ?>
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
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <div class="overlay" style="">
                <div class="msg">
                    <?php if (!$flag): ?>
                        <h1 style="text-align: center">Welcome to Wish-Fish!<br/>Please click the 'Activate Your Account' Button in your Email To Get Started!</h1>
                        <h3>Didn't get our Email? No worries, <a href="javascript:void(0);" id="sendAgain">Click Here</a> and We'll send you another one!</h3>
                    <?php else : ?>
                        <div class="row" >
                            <div class="col-md-3"></div>
                            <form id="passForm" action="<?= site_url() ?>affiliate/dashboard/updatePassword" method="post">
                                <div class="col-md-6" style="text-align: center;">
                                    <?php if (!$isForgot) : ?>
                                        <lable><h2>Email confirmed!</h2></lable>
                                    <?php endif; ?>
                                    <lable><h2>Please set a password:</h2></lable>
                                    <input id="passwd" type="password" name="password" placeholder="Please Enter a New Password" class="form-control" required /><br/>
                                    <input id="confirm_passwd" type="password" placeholder="Please Confirm your new password" class="form-control" required /><br/>
                                    <button  type="submit" class="btn btn-primary">Let's Get Started!</button> <br/>
                                    <span id="msgPass" style="color: red"></span>
                                </div>
                                <input type="hidden" name="affid" value="<?= $affInfo->affiliate_id ?>" />
                                <input type="hidden" name="type" value="<?= ($isForgot) ? "forgot" : "welcome" ?>" />
                            </form>
                            <div class="col-md-3"></div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <aside class="left-side sidebar-offcanvas">
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="<?= $aff_img_src ?>" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p><?= (!$affInfo) ? $this->session->userdata('d-name') : $affInfo->fname . ' ' . $affInfo->lname ?></p>
                        </div>
                    </div>
                    <ul class="sidebar-menu">
                        <li class="active" id="1">
                            <a href="#">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="" id="2">
                            <a href="#">
                                <i class="fa fa-angle-double-right"></i> <span>Promote Product</span>
                            </a>
                        </li>
                        <li class="" id="3">
                            <a href="#">
                                <i class="fa fa-angle-double-right"></i> <span>Analytics</span>
                            </a>
                        </li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>


            <!-- header logo: style can be found in header.less -->


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
                </section>
            </aside><!-- /.right-side -->
        </div>
    </body>
    <script type="text/javascript">
        $('#titleblue').text($('.content-header h1').text());
    </script>
    <!-- AdminLTE App -->
    <script src="<?= base_url() ?>assets/dashboard/js/AdminLTE/app.js" type="text/javascript"></script>

    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="<?= base_url() ?>assets/dashboard/js/AdminLTE/dashboard.js" type="text/javascript"></script>
</html>
