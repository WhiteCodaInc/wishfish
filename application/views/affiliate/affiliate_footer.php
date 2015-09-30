<!-- GLOBAL ADMIN FOOTER INCLUDES -->
<script type="text/javascript">
    $('#titleblue').text($('.content-header h1').text());
</script>
</body>
</html>

<script type="text/javascript">
    $(function () {
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
<!--<script src="<?= base_url() ?>assets/dashboard/js/plugins/iCheck/icheck.js" type="text/javascript"></script>-->
<script src="<?= base_url() ?>assets/dashboard/js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>

<!-- AdminLTE App -->
<script src="<?= base_url() ?>assets/dashboard/js/AdminLTE/app.js" type="text/javascript"></script>

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?= base_url() ?>assets/dashboard/js/AdminLTE/dashboard.js" type="text/javascript"></script>

<!-- AdminLTE for demo purposes -->
<!--<script src="<?= base_url() ?>assets/dashboard/js/AdminLTE/demo.js" type="text/javascript"></script>-->

<!-- CK Editor -->
<script src="//cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>

