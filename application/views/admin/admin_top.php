<style type="text/css">
    .title-blue{
        float: left;
        width: 74%;
        text-align: center;
        /* padding: 0px; */
        font-size: 28px;
        color: white
    }
    ul.menu,.slimScrollDiv{
        height: 550px !important;
    }
</style>

<!-- header logo: style can be found in header.less -->

<header class="header">
    <?php
    $avatar = $this->session->userdata('avatar');

    $admin_img_src = ($avatar != "") ?
            "https://mikhailkuznetsov.s3.amazonaws.com/" . $avatar :
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
                <!-- New Payment Notification -->
                <li class="dropdown messages-menu payment-notification">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-tasks"></i>
                        <span class="label label-success">
                            <?= $this->common->getTotalPayment() ?>
                        </span>
                    </a>
                    <?php $payments = $this->common->getNewPayment(); ?>
                    <ul class="dropdown-menu">
                        <li class="header">You have <?= $this->common->getTotalPayment() ?> payments</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <?php foreach ($payments as $value) { ?>
                                    <?php
                                    $img_src = ($value->profile_pic != "") ?
                                            "https://mikhailkuznetsov.s3.amazonaws.com/" . $value->profile_pic :
                                            base_url() . 'assets/dashboard/img/default-avatar.png';
                                    ?>
                                    <li><!-- start message -->
                                        <a href="<?= site_url() . 'admin/customers/profile/' . $value->user_id ?>">
                                            <div class="pull-left">
                                                <img style="width:60px;height:60px" src="<?= $img_src ?>" class="img-circle" alt="User Image"/>
                                            </div>
                                            <h4>
                                                New Payment
                                                <small><i class="fa fa-clock-o"></i><?= $value->payment_date ?></small>
                                            </h4>
                                            <p style="margin: 0;white-space: normal">
                                                <?= $value->name ?> Sent you $<?= $value->mc_gross ?> via <?= $value->gateway ?>
                                            </p>
                                        </a>
                                    </li><!-- end message -->
                                <?php } ?>
                            </ul>
                        </li>
                        <li class="footer"><a href="<?= site_url() ?>admin/analytics">See All Payments</a></li>
                    </ul>
                </li>
                <!-- ENd Payment Notification -->
                <!-- New Customer Join Notification -->
                <li class="dropdown messages-menu customer-notification">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-tasks"></i>
                        <span class="label label-success">
                            <?= $this->common->getTotalNewCustomer() ?>
                        </span>
                    </a>
                    <?php $customers = $this->common->getNewCustomer(); ?>
                    <ul class="dropdown-menu">
                        <li class="header">You have <?= $this->common->getTotalNewCustomer() ?> Customers</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu newCustomer">
                                <?php foreach ($customers as $value) { ?>
                                    <?php
                                    $img_src = ($value->profile_pic != "") ?
                                            "https://mikhailkuznetsov.s3.amazonaws.com/" . $value->profile_pic :
                                            base_url() . 'assets/dashboard/img/default-avatar.png';
                                    ?>
                                    <li><!-- start message -->
                                        <a href="<?= site_url() . 'admin/customers/profile/' . $value->user_id ?>">
                                            <div class="pull-left">
                                                <img style="width:60px;height:60px" src="<?= $img_src ?>" class="img-circle" alt="User Image"/>
                                            </div>
                                            <h4>
                                                New Customer
                                                <small><i class="fa fa-clock-o"></i><?= $value->register_date ?></small>
                                            </h4>
                                            <p style="margin: 0;white-space: normal"><?= $value->name ?> Join as <?= $value->plan_name ?> </p>
                                        </a>
                                    </li><!-- end message -->
                                <?php } ?>
                            </ul>
                        </li>
                        <li class="footer"><a href="<?= site_url() . 'admin/customers/' ?>">See All Customers</a></li>
                    </ul>
                </li>
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
                                            "https://mikhailkuznetsov.s3.amazonaws.com/" . $sms->contact_avatar :
                                            base_url() . 'assets/dashboard/img/default-avatar.png';
                                    ?>
                                    <li><!-- start message -->
                                        <a id="<?= $sms->sid ?>" href="<?= site_url() . 'admin/sms/inbox/' ?>">
                                            <div class="pull-left">
                                                <img style="width:60px;height:60px" src="<?= $img_src ?>" class="img-circle" alt="User Image"/>
                                            </div>
                                            <h4>
                                                <?= $sms->fname . ' ' . $sms->lname ?>
                                                <!--<small><i class="fa fa-clock-o"></i><?= $sms->date_sent ?></small>-->
                                            </h4>
                                            <p style="margin: 0;white-space: normal"><?= $sms->body ?></p>
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
        $('li.customer-notification > a.dropdown-toggle').on('click', function () {
            var totalC = $(this).children('span.label').text();
            if (totalC != 0) {
                $(this).children('span.label').text('0');
                $.post("<?= site_url() ?>admin/customers/updateCustomerNotification");
            }
        });
        $('li.payment-notification > a.dropdown-toggle').on('click', function () {
            var totalP = $(this).children('span.label').text();
            if (totalP != 0) {
                $(this).children('span.label').text('0');
                $.post("<?= site_url() ?>admin/customers/updatePaymentNotification");
            }
        });
    });
</script>
