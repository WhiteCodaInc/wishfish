<!-- Right side column. Contains the navbar and content of the page -->
<?php
$CI = & get_instance();
$CI->load->library("common");

$rule = $CI->common->getPermission();

$avatar = $this->session->userdata('avatar');
$img_src = ($avatar != "") ?
        "https://mikhailkuznetsov.s3.amazonaws.com/" . $avatar :
        base_url() . 'assets/dashboard/img/default-avatar.png';
?>
<div class="wrapper row-offcanvas row-offcanvas-left">
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="left-side sidebar-offcanvas">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="<?= $img_src ?>" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p><?= $this->session->userdata('name') ?></p>

<!--                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>-->
                </div>
            </div>
            <!-- search form -->
            <form action="#" method="get" class="sidebar-form">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Search..."/>
                    <span class="input-group-btn">
                        <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                    </span>
                </div>
            </form>
            <!-- /.search form -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li class="active" id="1">
                    <a href="<?= site_url() ?>admin/dashboard">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>
                <?php if ($rule->cal): ?>
                    <li class="" id="2">
                        <a href="<?= site_url() ?>admin/calender">
                            <i class="fa fa-th"></i> <span>Calendar</span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (isset($rule->admin) && $rule->admin): ?>
                    <li class="treeview" id="3">
                        <a style="float: right" href="#">
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <a  href="<?= site_url() ?>admin/admin_profile">
                            <i class="fa fa-envelope"></i>
                            <span>Admin</span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="<?= site_url() ?>admin/admin_access">
                                    <i class="fa fa-angle-double-right"></i> <span>Admin Access Class</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php
                if (
                        $rule->coni || $rule->conu || $rule->cond ||
                        $rule->congi || $rule->congu || $rule->congd ||
                        $rule->cbl
                ):
                    $url = ($rule->coni || $rule->conu || $rule->cond) ?
                            site_url() . "admin/contacts" : "#";
                    ?>
                    <li class="treeview" id="4">
                        <a style="float: right" href="#">
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <a href="<?= $url ?>">
                            <i class="fa fa-wrench"></i> <span>Company Contacts</span>
                        </a>
                        <ul class="treeview-menu">
                            <?php if ($rule->coni): ?>
                                <li>
                                    <a href="<?= site_url() ?>admin/contacts/addContact">
                                        <i class="fa fa-plus"></i>
                                        <span>Create New Contact</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($rule->congi || $rule->congu || $rule->congd): ?>
                                <li>
                                    <a href="<?= site_url() ?>admin/contact_groups">
                                        <i class="fa fa-angle-double-right"></i> <span>Contact Groups</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($rule->cbl): ?>
                                <li>
                                    <a href="<?= site_url() ?>admin/contacts/block_list">
                                        <i class="fa fa-lock"></i>
                                        <span>Contact Block List</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($rule->coni): ?>
                                <li>
                                    <a href="<?= site_url() ?>admin/scrape">
                                        <i class="fa fa-angle-double-right"></i>
                                        <span>Scrape Contacts</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php
                if (
                        $rule->affi || $rule->affu || $rule->affd ||
                        $rule->affgi || $rule->affgu || $rule->affgd
                ):
                    $url = ($rule->affi || $rule->affu || $rule->affd) ?
                            site_url() . "admin/affiliates" : "#";
                    ?>
                    <li class="treeview" id="5">
                        <a style="float: right" href="#">
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <a href="<?= $url ?>">
                            <i class="fa fa-wrench"></i> <span>Affiliates</span>
                        </a>
                        <ul class="treeview-menu">
                            <?php if ($rule->affi): ?>
                                <!--                                <li>
                                                                    <a href="<?= site_url() ?>admin/affiliates/addAffiliate">
                                                                        <i class="fa fa-plus"></i>
                                                                        <span>Create New Affiliate</span>
                                                                    </a>
                                                                </li>-->
                            <?php endif; ?>
                            <?php if ($rule->affgi || $rule->affgu || $rule->affgd): ?>
                                <li>
                                    <a href="<?= site_url() ?>admin/affiliate_groups">
                                        <i class="fa fa-angle-double-right"></i> <span>Affiliate Groups</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($rule->affs): ?>
                                <li>
                                    <a href="<?= site_url() ?>admin/payout">
                                        <i class="fa fa-angle-double-right"></i> <span>Affiliate Configuration</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= site_url() ?>admin/affiliate_offers">
                                        <i class="fa fa-angle-double-right"></i> <span>Affiliate Offer</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php
                if (
                        $rule->cusu || $rule->cusd ||
                        $rule->cusgi || $rule->cusgu || $rule->cusgd
                ):
                    $url = ($rule->cusu || $rule->cusd) ?
                            site_url() . "admin/customers" : "#";
                    ?>
                    <li class="treeview" id="6">
                        <a style="float: right" href="#">
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <a href="<?= $url ?>">
                            <i class="fa fa-envelope"></i>
                            <span>Customers</span>
                        </a>
                        <ul class="treeview-menu">
                            <?php if ($rule->cusgi || $rule->cusgu || $rule->cusgd): ?>
                                <li>
                                    <a href="<?= site_url() ?>admin/customer_groups">
                                        <!--<a href="#">-->
                                        <i class="fa fa-angle-double-right"></i> <span>Customer Groups</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php
                if (
                        $rule->smsi ||
                        $rule->smsb ||
                        $rule->smslbi || $rule->smslbu || $rule->smslbd ||
                        $rule->smsti || $rule->smstu || $rule->smstd
                ):
                    $url = ($rule->smsi) ?
                            site_url() . "admin/sms/inbox" : "#";
                    ?>
                    <li class="treeview" id="7">

                        <a style="float: right" href="#">
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <a class="tab-desktop" href="<?= $url ?>">
                            <i class="fa fa-wrench"></i> <span>SMS</span>
                        </a>
                        <a class="tab-mobile" href="<?= ($url != "#") ? "?ver=mobile" : $url ?>">
                            <i class="fa fa-wrench"></i> <span>SMS</span>
                        </a>
                        <ul class="treeview-menu">
                            <?php if ($rule->smsb): ?>
                                <li>
                                    <a href="<?= site_url() ?>admin/sms/send_sms">
                                        <i class="fa fa-angle-double-right"></i> 
                                        SMS Blast
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($rule->smslbi || $rule->smslbu || $rule->smslbd): ?>
                                <li>
                                    <a href="<?= site_url() ?>admin/sms_list_builder">
                                        <i class="fa fa-angle-double-right"></i> 
                                        SMS List Builder
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($rule->smsti || $rule->smstu || $rule->smstd): ?>
                                <li>
                                    <a href="<?= site_url() ?>admin/sms_template">
                                        <i class="fa fa-angle-double-right"></i> 
                                        SMS Template
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php
                if (
                        $rule->emailm ||
                        $rule->emailb ||
                        $rule->emaillbi || $rule->emaillbu || $rule->emaillbd ||
                        $rule->emailti || $rule->emailtu || $rule->emailtd ||
                        $rule->emailn ||
                        $rule->emailai || $rule->emailau || $rule->emailad
                ):
                    $url = ($rule->emailm) ?
                            site_url() . "admin/mailbox" : "#";
                    ?>
                    <li class="treeview" id="8">
                        <a style="float: right" href="#">
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <a href="<?= $url ?>">
                            <i class="fa fa-wrench"></i> <span>Email</span>
                        </a>
                        <ul class="treeview-menu">
                            <?php if ($rule->emailb): ?>
                                <li>
                                    <a href="<?= site_url() ?>admin/email/send_email">
                                        <i class="fa fa-angle-double-right"></i> 
                                        Email Blast
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($rule->emaillbi || $rule->emaillbu || $rule->emaillbd): ?>
                                <li>
                                    <a href="<?= site_url() ?>admin/email_list_builder">
                                        <i class="fa fa-angle-double-right"></i> 
                                        Email List Builder
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($rule->emailti || $rule->emailtu || $rule->emailtd): ?>
                                <li>
                                    <a href="<?= site_url() ?>admin/email_template">
                                        <i class="fa fa-angle-double-right"></i> 
                                        Email Template
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($rule->emailn): ?>
                                <li>
                                    <a href="<?= site_url() ?>admin/email_notification">
                                        <i class="fa fa-angle-double-right"></i> 
                                        Email Notification
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($rule->emailai || $rule->emailau || $rule->emailad): ?>
                                <li>
                                    <a href="<?= site_url() ?>admin/cpanel">
                                        <i class="fa fa-angle-double-right"></i> 
                                        Email Accounts
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php
                if (
                        $rule->smssi || $rule->smssu ||
                        $rule->cals || $rule->pays
                ):
                    ?>
                    <li class="treeview" id="10">
                        <a href="#">
                            <i class="fa fa-wrench"></i>
                            <span>Settings</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <?php if ($rule->smssi || $rule->smssu): ?>
                                <li>
                                    <a href="<?= site_url() ?>admin/setting/sms">
                                        <i class="fa fa-angle-double-right"></i> <span>SMS Setting</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($rule->cals): ?>
                                <li>
                                    <a href="<?= site_url() ?>admin/setting/calender">
                                        <i class="fa fa-angle-double-right"></i> <span>Calender Setting</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($rule->pays): ?>
                                <li>
                                    <a href="<?= site_url() ?>admin/setting/payment">
                                        <i class="fa fa-angle-double-right"></i> <span>Payment Setting</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php
                if (
                        $rule->faqi || $rule->faqu || $rule->faqd ||
                        $rule->faqci || $rule->faqcu || $rule->faqcd
                ):
                    $url = ($rule->faqi || $rule->faqu || $rule->faqd) ?
                            site_url() . "admin/faq" : "#";
                    ?>
                    <li class="treeview" id="11">
                        <a style="float: right" href="#">
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <a  href="<?= $url ?>">
                            <i class="fa fa-angle-double-right"></i>
                            <span>FAQ'S</span>
                        </a>
                        <ul class="treeview-menu">
                            <?php if ($rule->faqci || $rule->faqcu || $rule->faqcd): ?>
                                <li>
                                    <a href="<?= site_url() ?>admin/faq/faqCategory">
                                        <i class="fa fa-angle-double-right"></i> <span>FAQ'S Category</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php
                if ($rule->webp || $rule->homes):
                    $url = ($rule->webp) ?
                            site_url() . "admin/pages" : "#";
                    ?>
                    <li class="treeview" id="12">
                        <a style="float: right" href="#">
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <a  href="<?= $url ?>">
                            <i class="fa fa-angle-double-right"></i>
                            <span>Web Pages</span>
                        </a>
                        <ul class="treeview-menu">
                            <?php if ($rule->homes): ?>
                                <li>
                                    <a href="<?= site_url() ?>admin/sections">
                                        <i class="fa fa-angle-double-right"></i> <span>Homepage Section</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if ($rule->feed): ?>
                    <li class="" id="13">
                        <a href="<?= site_url() ?>admin/feedback">
                            <i class="fa fa-angle-double-right"></i> <span>Feedback/Support</span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if ($rule->coui || $rule->couu || $rule->coud): ?>
                    <li class="" id="14">
                        <a href="<?= site_url() ?>admin/coupons">
                            <i class="fa fa-angle-double-right"></i> <span>Coupons</span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if ($rule->totalp || $rule->totalu || $rule->totalnu || $rule->admr): ?>
                    <li class="treeview" id="15">
                        <a href="#">
                            <i class="fa fa-wrench"></i>
                            <span>Analytics</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <?php if ($rule->totalp): ?>
                                <li>
                                    <a href="<?= site_url() ?>admin/analytics">
                                        <i class="fa fa-angle-double-right"></i> <span>Total Payment</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($rule->totalu): ?>
                                <li>
                                    <a href="<?= site_url() ?>admin/analytics/totalUser">
                                        <i class="fa fa-angle-double-right"></i> <span>Total Users</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($rule->totalnu): ?>
                                <li>
                                    <a href="<?= site_url() ?>admin/analytics/totalNewUser">
                                        <i class="fa fa-angle-double-right"></i> <span>Total New User</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($rule->admr): ?>
                                <li>
                                    <a href="<?= site_url() ?>admin/analytics/adminReport">
                                        <i class="fa fa-angle-double-right"></i> <span>Admin Report</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if ($rule->probi || $rule->probu || $rule->probd): ?>
                    <li class="" id="16">
                        <a href="<?= site_url() ?>admin/products">
                            <i class="fa fa-angle-double-right"></i> <span>Product Builder</span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if ($rule->paypi || $rule->paypu || $rule->paypd): ?>
                    <li class="" id="17">
                        <a href="<?= site_url() ?>admin/plans">
                            <i class="fa fa-angle-double-right"></i> <span>Payment Plan Builder</span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if ($rule->offi || $rule->offu || $rule->offd): ?>
                    <li class="" id="18">
                        <a href="<?= site_url() ?>admin/offers">
                            <i class="fa fa-angle-double-right"></i> <span>Offer Builder</span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if ($rule->pagb): ?>
                    <li class="" id="19">
                        <a href="<?= site_url() ?>page-builder/" target="_blank">
                            <i class="fa fa-angle-double-right"></i> <span>Page Builder</span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if ($rule->medi || $rule->medu || $rule->medd): ?>
                    <li class="" id="20">
                        <a href="<?= site_url() ?>admin/media/">
                            <i class="fa fa-angle-double-right"></i> <span>Media Library</span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if ($rule->funi || $rule->funv): ?>
                    <li class="" id="21">
                        <a href="<?= site_url() ?>admin/email_list">
                            <i class="fa fa-angle-double-right"></i> <span>Funnel Email List</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
            <script type="text/javascript">
                $(document).ready(function () {

                    $("ul.sidebar-menu li a").click(function () {
                        if ($(this).attr("href") != "#") {
                            var active = $(this).parent('li').attr('id');
                            if (typeof active != 'undefined') {
                                $.cookie('activeLI', active);
                            }
                            else {
                                var active = $(this).parents().eq(2).attr('id');
                                $.cookie('activeLI', active);
                            }
                        }
                    });
                    var last = $.cookie('activeLI');
                    $(".sidebar-menu li").removeClass('active');
                    if (typeof last != 'undefined') {
                        $("#" + last).addClass("active");
                        $("#" + last + " a:first").trigger("click");
                    } else {
                        $("#1").addClass("active");
                    }

                });
            </script>
            <script type="text/javascript">
                var list = $('ul.sidebar-menu');
                var listItems = list.children('li').sort(function (a, b) {
                    return $(a).attr('id') - $(b).attr('id');
                });
                list.children('li').remove();
                list.append(listItems);
                $('ul.sidebar-menu  li.treeview ul.treeview-menu').each(function () {
                    var sublist = $(this);
                    var sublistItems = sublist.children('li').sort(function (a, b) {
                        return $(a).attr('id') - $(b).attr('id');
                    });
                    sublist.children('li').remove();
                    sublist.append(sublistItems);
                });
            </script>
        </section>
        <!-- /.sidebar -->
    </aside>