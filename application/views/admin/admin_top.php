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
                <!-- New Customer Join Notification -->
                
                <!-- ENd New Customer Join Notification -->
                <!-- SMS Inbox -->
                <li class="dropdown messages-menu sms-notification">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope"></i>
                        <span class="label label-success">
                            <?= $this->common->getTotalUnreadMsg() ?>
                        </span>
                    </a>
                    <?php $inbox = $this->common->getUnreadMsg(); ?>
                    <ul class="dropdown-menu">
                        <li class="header">You have <?= $this->common->getTotalUnreadMsg() ?> messages</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu unreadSMS">
                                <?php foreach ($inbox as $sms) { ?>
                                    <?php
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
                                                <small><i class="fa fa-clock-o"></i></small>
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
                            <img src="<?= $admin_img_src ?>" class="img-circle" alt="User Image" />
                            <p>
                                <?= $this->session->userdata('name') ?>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <!--                            <div class="pull-left">
                                                            <a href="#" class="btn btn-default btn-flat">Profile</a>
                                                        </div>-->
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
    $(function () {
        $.ajax({
            type: 'POST',
            url: "<?= site_url() ?>admin/cpanel/getTotalUnreadEmail",
            success: function (data, textStatus, jqXHR) {
                $('.email-notify').html(data);
            }
        });
    });
    $(document).ready(function () {
        $('ul.unreadSMS > li > a').on('click', function () {
            var id = $(this).attr('id');
            $.post("<?= site_url() ?>admin/sms/updateStatus/" + id);
        });
    });
</script>
