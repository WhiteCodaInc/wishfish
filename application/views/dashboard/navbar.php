<!-- Right side column. Contains the navbar and content of the page -->
<?php
//$CI = & get_instance();
//$CI->load->library("common");
//$rule = $CI->common->getPermission();

$profile_pic = $this->session->userdata('u_profile_pic');
$img_src = ($profile_pic != "") ?
        "https://mikhailkuznetsov.s3.amazonaws.com/" . $profile_pic :
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
                    <p><?= $this->session->userdata('u_name') ?></p>
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li class="active" id="1">
                    <a href="#">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li class="treeview" id="3">
                    <a href="#">
                        <i class="fa fa-envelope"></i>
                        <span>Contact Management</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="<?= site_url() ?>app/contacts/addContact">
                                <i class="fa fa-plus"></i>
                                <span>Create New Contact</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= site_url() ?>app/contacts">
                                <i class="fa fa-wrench"></i> <span>Manage Contacts</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= site_url() ?>app/contact_groups">
                                <i class="fa fa-wrench"></i> <span>Contact Groups</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= site_url() ?>app/contacts/block_list">
                                <i class="fa fa-lock"></i>
                                <span>Lock Contacts</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="treeview" id="4">
                    <a href="#">
                        <i class="fa fa-envelope"></i>
                        <span>Templates</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="<?= site_url() ?>app/sms_template">
                                <i class="fa fa-plus"></i>
                                <span>SMS Template</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= site_url() ?>app/email_template">
                                <i class="fa fa-wrench"></i> <span>Email Template</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="" id="9">
                    <a href="<?= site_url() ?>app/calender">
                        <i class="fa fa-th"></i> <span>Calender</span>
                    </a>
                </li>
            </ul>
            <!--<script type="text/javascript">
                $(document).ready(function () {
                    var last = $.cookie('activeLI');
                    if (last != null) {
                        //remove default collapse settings
                        $(".sidebar-menu li").removeClass('active');
                        //show the last visible group
                        $("#" + last).addClass("active");
                        $("#" + last + " a").trigger("click");
                    }
                });
                $("ul.treeview-menu li a").click(function () {
                    var active = $(this).parent('li');
                    console.log(active);
                    return false;
                    $.cookie('activeLI', active);
                });
            </script>-->
            <script type="text/javascript">
//                $('li#create-contact > a').on('click', function () {
//                    hopscotch.nextStep();
//                });
//                var list = $('ul.sidebar-menu');
//                var listItems = list.children('li').sort(function (a, b) {
//                    return $(a).attr('id') - $(b).attr('id');
//                });
//                list.children('li').remove();
//                list.append(listItems);
//                $('ul.sidebar-menu  li.treeview ul.treeview-menu').each(function () {
//                    var sublist = $(this);
//                    var sublistItems = sublist.children('li').sort(function (a, b) {
//                        return $(a).attr('id') - $(b).attr('id');
//                    });
//                    sublist.children('li').remove();
//                    sublist.append(sublistItems);
//                });
            </script>
        </section>
        <!-- /.sidebar -->
    </aside>