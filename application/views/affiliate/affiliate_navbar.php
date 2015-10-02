<!-- Right side column. Contains the navbar and content of the page -->
<?php
//$CI = & get_instance();
//$CI->load->library("common");
//
//$rule = $CI->common->getPermission();

$avatar = $this->session->userdata('a_avatar');
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
                    <p><?= $this->session->userdata('a_name') ?></p>
                </div>
            </div>
            <!-- /.search form -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li class="active" id="1">
                    <a href="<?= site_url() ?>affiliate/dashboard">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li class="" id="2">
                    <a href="<?= site_url() ?>affiliate/products">
                        <i class="fa fa-angle-double-right"></i> <span>Promote Product</span>
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
                            <a href="<?= site_url() ?>affiliate/analytics">
                                <i class="fa fa-angle-double-right"></i> <span>Total Payment</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= site_url() ?>affiliate/analytics/totalUser">
                                <i class="fa fa-angle-double-right"></i> <span>Total Users</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= site_url() ?>affiliate/analytics/totalNewUser">
                                <i class="fa fa-angle-double-right"></i> <span>Total New User</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!--                <li class="" id="1">
                                    <a href="<?= site_url() ?>affiliate/analytics">
                                        <i class="fa fa-angle-double-right"></i> <span>Analytics</span>
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