<footer class="main-footer">
    <div class="container-fluid">
        <strong>Copyright &copy; 2015 White Coda Inc.</strong> All rights reserved.
    </div><!-- /.container -->
</footer>
<?php
//$userid = $this->session->userdata('u_userid');
//if ($userid != "") {
//    $userInfo = $this->wi_common->getUserInfo($userid);
//    if ($userInfo->phone_verification) {
//        
?>
        <!--<script type="text/javascript" src="//<?= base_url() ?>assets/hopscotch/demo.js"></script>-->
//<?php
//    }
//}
?>
<script type="text/javascript">
    $(function () {
        $("[data-mask]").inputmask();
        //-----------------------------iCheck All-----------------------------//
        $('table thead :checkbox').on('ifChecked ifUnchecked', function (event) {
            if (event.type == 'ifChecked') {
                $('.icheckbox_minimal').iCheck('check');
            } else {
                $('.icheckbox_minimal').iCheck('uncheck');
            }
        });
        $('table tbody :checkbox').on('ifChanged', function (event) {
            if ($('table tbody :checkbox').filter(':checked').length == $('table tbody :checkbox').length) {
                $('table thead :checkbox').prop('checked', true);
            } else {
                $('table thead :checkbox').prop('checked', false);
            }
            $('table thead :checkbox').iCheck('update');
        });
        $('.paging_bootstrap').on('click', function () {
            $('.icheckbox_minimal').iCheck('uncheck');
        });
    });
</script>
<!-- Bootstrap Slider -->
<!--<script src="<?= base_url() ?>assets/dashboard/js/plugins/bootstrap-slider/bootstrap-slider.js" type="text/javascript"></script>-->

<!-- Morris.js charts -->
<!--<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="<?= base_url() ?>assets/dashboard/js/plugins/morris/morris.min.js" type="text/javascript"></script>-->

<!-- InputMask -->
<script src="<?= base_url() ?>assets/dashboard/js/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/dashboard/js/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/dashboard/js/plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>

<!-- Sparkline -->
<script src="<?= base_url() ?>assets/dashboard/js/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>

<!-- jvectormap -->
<script src="<?= base_url() ?>assets/dashboard/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/dashboard/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>

<!-- jQuery Knob -->
<!--<script src="<?= base_url() ?>assets/dashboard/js/plugins/jqueryKnob/jquery.knob.js" type="text/javascript"></script>-->

<!-- Date Range Picker -->
<!--<script src="<?= base_url() ?>assets/dashboard/js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>-->

<!-- Datepicker -->
<!--<script src="<?= base_url() ?>assets/dashboard/js/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>-->

<!--pickers plugins-->
<script type="text/javascript" src="<?= base_url() ?>assets/dashboard/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<!-- iCheck -->
<script src="<?= base_url() ?>assets/dashboard/js/plugins/iCheck/icheck.js" type="text/javascript"></script>
<!--<script src="<?= base_url() ?>assets/dashboard/js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>-->

<!-- AdminLTE App -->
<script src="<?= base_url() ?>assets/dashboard/js/AdminLTE/app.js" type="text/javascript"></script>

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?= base_url() ?>assets/dashboard/js/AdminLTE/dashboard.js" type="text/javascript"></script>

<!-- AdminLTE for demo purposes -->
<!--<script src="<?= base_url() ?>assets/dashboard/js/AdminLTE/demo.js" type="text/javascript"></script>-->

<!-- CK Editor -->
<script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
</body>
</html>
