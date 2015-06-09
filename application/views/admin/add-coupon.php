<style type="text/css">
    .error{
        color: red
    }
</style>
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="display: none">
            <?= isset($coupon) ? "Edit" : "Add New" ?> Coupon
        </h1>
        <button type="button" id="addCoupon" class="btn btn-primary">
            <?= isset($coupon) ? 'Update Existing Coupon' : 'Create New Coupon' ?>
        </button>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3"></div>
            <!-- left column -->
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title"><?= isset($coupon) ? "Existing" : "New" ?> Coupon</h3>
                    </div><!-- /.box-header -->
                    <?php $method = isset($coupon) ? "updateCoupon" : "createCoupon"; ?>
                    <!-- form start -->
                    <form id="couponForm" role="form" action="<?= site_url() ?>admin/coupons/<?= $method ?>" method="post">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Coupon Name</label>
                                <input type="text" name="coupon_name" value="<?= isset($coupon) ? $coupon->coupon_name : '' ?>" placeholder="Coupon Name" autofocus="autofocus" class="form-control" required=""/>
                                <span class="error msgcname"></span>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <label>Coupon Code</label>
                                    <input type="text" name="coupon_code" value="<?= isset($coupon) ? $coupon->coupon_code : '' ?>" placeholder="Coupon Code" class="form-control" required="" readonly="" />
                                    <span class="error msgcode"></span>
                                </div>
                                <div class="col-md-3" style="margin-top: 25px">
                                    <button type="button" class="btn btn-primary" id="randomCode">Generate</button>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Discount Type</label>
                                    <select name="disc_type" class="form-control">
                                        <option value="F">Flate Rate</option>
                                        <option value="P">Percentage</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="lbl_type">Amount</label>
                                    <input type="text" name="disc_amount" value="<?= isset($coupon) ? $coupon->disc_amount : '' ?>" placeholder="Enter Amount" class="form-control" required="" />
                                    <span class="error msgamt"></span>
                                </div>
                            </div>
                            <br/>
                            <div class="form-group">
                                <label>Duration in Month</label>
                                <select name="coupon_validity" class="form-control">
                                    <option value="1">One Time</option>
                                    <option value="2">Disc For x Month</option>
                                    <option value="3">LifeTime</option>
                                </select>
                            </div>
                            <div class="form-group month-duration" style="display: none">
                                <label>Month</label>
                                <input type="text" name="month_duration" value="<?= isset($coupon) ? $coupon->month_duration : '' ?>" placeholder="Month" class="form-control" disabled="" required=""  />
                                <span class="error msgduration"></span>
                            </div>
                            <div class="form-group">
                                <label>Expired On</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input name="expiry_date" value="<?= isset($coupon) ? date('d-m-Y', strtotime($coupon->expiry_date)) : '' ?>"  class="form-control form-control-inline input-medium default-date-picker" size="16" type="text" required="">
                                </div><!-- /.input group -->
                            </div><!-- /.form group -->
                            <div class="form-group">
                                <label>Redemption</label>
                                <input type="text" name="no_of_use" value="<?= isset($coupon) ? $coupon->no_of_use : '' ?>" placeholder="Number Of Use" class="form-control" required="" />
                                <span class="error msguse"></span>
                            </div>
                            <div class="box-footer" style="display: none">
                                <button type="submit" class="coupon-submit"></button>
                            </div>
                        </div><!-- /.box-body -->
                        <?php if (isset($coupon)): ?>
                            <input type="hidden" name="couponid" value="<?= $coupon->coupon_id ?>" />
                        <?php endif; ?>
                    </form>
                </div><!-- /.box -->
            </div><!--/.col (left) -->
            <div class="col-md-3"></div>
            <!-- right column -->
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->
</div><!-- ./wrapper -->
<script type="text/javascript">
    $(function () {
        $('.default-date-picker').datepicker({
            format: "dd-mm-yyyy",
            todayBtn: "linked",
            autoclose: true,
            todayHighlight: true
        });
<?php if (isset($coupon)): ?>
            $('select[name="disc_type"]').val("<?= $coupon->disc_type ?>");
            $('select[name="coupon_validity"]').val("<?= $coupon->coupon_validity ?>");
            if ("<?= $coupon->coupon_validity ?>" == "2") {
                $('.month-duration').show();
                $('input[name="month_duration"]').prop('disabled', false);
            }

<?php endif; ?>

    });
    $(document).ready(function () {
        var c_code = 1, c_amt = 1, c_use = 1, c_month = 1;
        $('#addCoupon').click(function () {
            $('.coupon-submit').trigger('click');
        });

        $('select[name="disc_type"]').change(function () {
            var type = $(this).val();
            if (type == "P") {
                $('.lbl_type').text("Percentage");
                $('input[name="disc_amount"]').prop('placeholder', 'Enter Percentage');
            } else {
                $('.lbl_type').text("Amount");
                $('input[name="disc_amount"]').prop('placeholder', 'Enter Amount');
            }
        });

        $('input[name="coupon_code"]').focusout(function () {
            var code = $(this).val().trim();
            var rgex_code = /^[A-Za-z0-9]+$/;
            if (code != "" && !rgex_code.test(code)) {
                $('.msgcode').text("Please Enter Valid Coupon Code..!");
                c_code = 0;
            } else {
                $('.msgcode').empty();
                c_code = 1;
            }
        });

        $('input[name="disc_amount"]').focusout(function () {
            var amt = $(this).val();
            var dtype = $('select[name="disc_type"]').val();
            var rgex_amt = /^\d+$/;
            if (amt != "" && !rgex_amt.test(amt)) {
                $('.msgamt').text("Please Enter Valid Amount..!");
                c_amt = 0;
            } else {
                if (dtype == "F" && amt < 0) {
                    $('.msgamt').text("Your Amount Must be Greater Than 0..!");
                    c_amt = 0;
                } else if (dtype == "P" && (amt < 1 || amt > 100)) {
                    $('.msgamt').text("Percentage Value Must Between  1 to 100..!");
                    c_amt = 0;
                } else {
                    $('.msgamt').empty();
                    c_amt = 1;
                }
            }
        });

        $('select[name="coupon_validity"]').change(function () {
            var validity = $(this).val();
            if (validity == "2") {
                $('.month-duration').show();
                $('input[name="month_duration"]').prop('disabled', false);
            } else {
                $('.month-duration').hide();
                $('input[name="month_duration"]').prop('disabled', true);
            }
        });

        $('input[name="month_duration"]').focusout(function () {
            var month = $(this).val();
            var rgex_month = /^\d+$/;
            if (!rgex_month.test(month) || month <= 0) {
                $('.msgduration').text("Minimum 1 Month Required..!");
                c_month = 0;
            } else {
                c_month = 1;
                $('.msgduration').empty();
            }
        });

        $('input[name="no_of_use"]').focusout(function () {
            var use = $(this).val();
            var rgex_use = /^\d+$/;
            if (!rgex_use.test(use) || use <= 0) {
                $('.msguse').text("Value Must be Greater Than 0..!");
                c_use = 0;
            } else {
                c_use = 1;
                $('.msguse').empty();
            }
        });

        $('#couponForm').submit(function () {
//            alert(c_code + " " + c_amt + " " + c_month + " " + c_use);
            if ((c_code === 0 || c_amt === 0 || c_month === 0 || c_use === 0)) {
                return false;
            }
        });
    });
</script>