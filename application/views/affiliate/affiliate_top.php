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

<!-- header logo: style can be found in header.less -->

<header class="header">
    <?php
    $avatar = $this->session->userdata('avatar');

    $aff_img_src = ($avatar != "") ?
            "https://mikhailkuznetsov.s3.amazonaws.com/" . $avatar :
            base_url() . 'assets/dashboard/img/default-avatar.png';
    ?>
    <a href="<?= site_url() ?>affiliate/dashboard" class="logo">
        <!-- Add the class icon to your logo image or logo icon to add the margining -->
        <?= $this->session->userdata('a_name') ?> 
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
                            <ul class="menu"></ul>
                        </li>
                        <li class="footer"><a href="#">See All Payment</a></li>
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
                        <li class="header">You have 0 Customer</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu"></ul>
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
                        <li class="header">You have 0 sms</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu"></ul>
                        </li>
                        <li class="footer"><a href="#">See All sms</a></li>
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
                                <?= $this->session->userdata('a_name') ?>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-right">
                                <a href="<?= site_url() ?>affiliate/logout" class="btn btn-default btn-flat">Sign out</a>
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
