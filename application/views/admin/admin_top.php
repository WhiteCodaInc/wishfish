<style type="text/css">
    .title-blue{
        float: left;
        width: 80%;
        text-align: center;
        /* padding: 0px; */
        font-size: 28px;
        color: white
    }
</style>

<!-- header logo: style can be found in header.less -->
<?php
$CI = & get_instance();
$CI->load->library("common");
?>
<header class="header">
    <?php
    $avatar = $this->session->userdata('avatar');

    $admin_img_src = ($avatar != "") ?
            "http://mikhailkuznetsov.s3.amazonaws.com/" . $avatar :
            base_url() . 'assets/dashboard/img/default-avatar.png';
    ?>
    <a href="<?= site_url() ?>admin/dashboard" class="logo">
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
                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope"></i>
                        <span class="label label-success">
                            <?= $CI->common->getTotalUnreadMsg() ?>
                        </span>
                    </a>
                    <?php $inbox = $CI->common->getUnreadMsg(); ?>
                    <ul class="dropdown-menu">
                        <li class="header">You have <?= $CI->common->getTotalUnreadMsg() ?> messages</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu unreadSMS">
                                <?php foreach ($inbox as $sms) { ?>
                                    <?php
                                    $img_src = "";
                                    $img_src = ($sms->contact_avatar != "") ?
                                            "http://mikhailkuznetsov.s3.amazonaws.com/" . $sms->contact_avatar :
                                            base_url() . 'assets/dashboard/img/default-avatar.png';
                                    ?>
                                    <li><!-- start message -->
                                        <a id="<?= $sms->sid ?>" href="<?= site_url() . 'admin/sms/inbox/' ?>">
                                            <div class="pull-left">
                                                <img style="width:60px;height:60px" src="<?= $img_src ?>" class="img-circle" alt="User Image"/>
                                            </div>
                                            <h4>
                                                <?= $sms->fname . ' ' . $sms->lname ?>
                                                <small><i class="fa fa-clock-o"></i> 2 hours</small>
                                            </h4>
                                            <p><?= $sms->body ?></p>
                                        </a>
                                    </li><!-- end message -->
                                <?php } ?>
                            </ul>
                        </li>
                        <li class="footer"><a href="<?= site_url() . 'admin/sms/inbox' ?>">See All Messages</a></li>
                    </ul>
                </li>
                <!-- Notifications: style can be found in dropdown.less -->
                <!--                <li class="dropdown notifications-menu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <i class="fa fa-warning"></i>
                                        <span class="label label-warning">10</span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="header">You have 10 notifications</li>
                                        <li>
                                             inner menu: contains the actual data 
                                            <ul class="menu">
                                                <li>
                                                    <a href="<?= site_url() ?>admin/notification">
                                                        <i class="ion ion-ios7-people info"></i> 5 new members joined today
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?= site_url() ?>admin/notification">
                                                        <i class="fa fa-warning danger"></i> Very long des="#">cription here that may not fit into the page and may cause design problems
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?= site_url() ?>admin/notification">
                                                        <i class="fa fa-users warning"></i> 5 new members joined
                                                    </a>
                                                </li>
                
                                                <li>
                                                    <a href="<?= site_url() ?>admin/notification">
                                                        <i class="ion ion-ios7-cart success"></i> 25 sales made
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?= site_url() ?>admin/notification">
                                                        <i class="ion ion-ios7-person danger"></i> You changed your username
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="footer"><a href="<?= site_url() ?>admin/notification">View all</a></li>
                                    </ul>
                                </li>-->
                <!-- Tasks: style can be found in dropdown.less -->
                <!--                <li class="dropdown tasks-menu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <i class="fa fa-tasks"></i>
                                        <span class="label label-danger">9</span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="header">You have 9 tasks</li>
                                        <li>
                                             inner menu: contains the actual data 
                                            <ul class="menu">
                                                <li> Task item 
                                                    <a href="#">
                                                        <h3>
                                                            Design some buttons
                                                            <small class="pull-right">20%</small>
                                                        </h3>
                                                        <div class="progress xs">
                                                            <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                                <span class="sr-only">20% Complete</span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li> end task item 
                                                <li> Task item 
                                                    <a href="#">
                                                        <h3>
                                                            Create a nice theme
                                                            <small class="pull-right">40%</small>
                                                        </h3>
                                                        <div class="progress xs">
                                                            <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                                <span class="sr-only">40% Complete</span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li> end task item 
                                                <li> Task item 
                                                    <a href="#">
                                                        <h3>
                                                            Some task I need to do
                                                            <small class="pull-right">60%</small>
                                                        </h3>
                                                        <div class="progress xs">
                                                            <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                                <span class="sr-only">60% Complete</span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li> end task item 
                                                <li> Task item 
                                                    <a href="#">
                                                        <h3>
                                                            Make beautiful transitions
                                                            <small class="pull-right">80%</small>
                                                        </h3>
                                                        <div class="progress xs">
                                                            <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                                <span class="sr-only">80% Complete</span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li> end task item 
                                            </ul>
                                        </li>
                                        <li class="footer">
                                            <a href="#">View all tasks</a>
                                        </li>
                                    </ul>
                                </li>-->
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="glyphicon glyphicon-user"></i>
                        <span><i class="caret"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header bg-light-blue">
                            <img src="<?= $admin_img_src ?>" class="img-circle" alt="User Image" />
                            <p>
                                <?= $this->session->userdata('name') ?> - Web Developer
                                <small>Member since Nov. 2012</small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="col-xs-4 text-center">
                                <a href="#">Followers</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Sales</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Friends</a>
                            </div>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="<?= site_url() ?>admin/logout" class="btn btn-default btn-flat">Sign out</a>
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
<script>
    $(document).ready(function () {
        $('ul.unreadSMS > li > a').on('click', function () {
            var id = $(this).attr('id');
            $.post("<?= site_url() ?>admin/sms/updateStatus/" + id);
        });
    });
</script>
