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
                        $rule->coni || $rule->conu || $rule->cond || $rule->congi ||
                        $rule->congu || $rule->congd || $rule->cbl
                ):
                    ?>
                    <li class="treeview" id="4">
                        <a style="float: right" href="#">
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <a href="<?= site_url() ?>admin/contacts">
                            <i class="fa fa-wrench"></i> <span>Company Contacts</span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="<?= site_url() ?>admin/contacts/addContact">
                                    <i class="fa fa-plus"></i>
                                    <span>Create New Contact</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= site_url() ?>admin/contact_groups">
                                    <i class="fa fa-angle-double-right"></i> <span>Contact Groups</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= site_url() ?>admin/contacts/block_list">
                                    <i class="fa fa-lock"></i>
                                    <span>Contact Block List</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= site_url() ?>admin/scrape">
                                    <i class="fa fa-angle-double-right"></i>
                                    <span>Scrape Contacts</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <!--                <li class="treeview" id="11">
                                    <a style="float: right" href="#">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <a  href="<?= site_url() ?>admin/faq">
                                        <i class="fa fa-angle-double-right"></i>
                                        <span>FAQ'S</span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li>
                                            <a href="<?= site_url() ?>admin/faq/faqCategory">
                                                <i class="fa fa-angle-double-right"></i> <span>FAQ'S Category</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="treeview" id="12">
                                    <a style="float: right" href="#">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <a  href="<?= site_url() ?>admin/pages">
                                        <i class="fa fa-angle-double-right"></i>
                                        <span>Web Pages</span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li>
                                            <a href="<?= site_url() ?>admin/sections/">
                                                <i class="fa fa-angle-double-right"></i> <span>Homepage Section</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="" id="13">
                                    <a href="<?= site_url() ?>admin/feedback">
                                        <i class="fa fa-angle-double-right"></i> <span>Feedback/Support</span>
                                    </a>
                                </li>
                                <li class="" id="14">
                                    <a href="<?= site_url() ?>admin/coupons">
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
                                            <a href="<?= site_url() ?>admin/analytics">
                                                <i class="fa fa-angle-double-right"></i> <span>Total Payment</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= site_url() ?>admin/analytics/totalUser">
                                                <i class="fa fa-angle-double-right"></i> <span>Total Users</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= site_url() ?>admin/analytics/totalNewUser">
                                                <i class="fa fa-angle-double-right"></i> <span>Total New User</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= site_url() ?>admin/analytics/adminReport">
                                                <i class="fa fa-angle-double-right"></i> <span>Admin Report</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="" id="16">
                                    <a href="<?= site_url() ?>admin/products">
                                        <i class="fa fa-angle-double-right"></i> <span>Product Builder</span>
                                    </a>
                                </li>
                                <li class="" id="17">
                                    <a href="<?= site_url() ?>admin/plans">
                                        <i class="fa fa-angle-double-right"></i> <span>Payment Plan Builder</span>
                                    </a>
                                </li>
                                <li class="" id="18">
                                    <a href="<?= site_url() ?>admin/offers">
                                        <i class="fa fa-angle-double-right"></i> <span>Offer Builder</span>
                                    </a>
                                </li>
                                <li class="" id="19">
                                    <a href="<?= site_url() ?>page-builder/" target="_blank">
                                        <i class="fa fa-angle-double-right"></i> <span>Page Builder</span>
                                    </a>
                                </li>
                                <li class="" id="20">
                                    <a href="<?= site_url() ?>admin/media/">
                                        <i class="fa fa-angle-double-right"></i> <span>Media Library</span>
                                    </a>
                                </li>
                                <li class="" id="21">
                                    <a href="<?= site_url() ?>admin/email_list">
                                        <i class="fa fa-angle-double-right"></i> <span>Funnel Email List</span>
                                    </a>
                                </li>-->
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