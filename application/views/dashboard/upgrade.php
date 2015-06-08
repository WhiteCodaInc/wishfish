<style type="text/css">


</style>
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Plan Details
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row" id="planUpgrade">
            <div class="col-md-2"></div>
            <?php
            foreach ($pdetail as $plan) {
                if ($plan->plan_id == 1)
                    continue;
                ?>
                <div class="col-md-4">
                    <div class="box box-solid <?= ($plan->plan_id == 2) ? "personal" : "enterprise" ?>">
                        <div class="box-header" style="text-align: center">
                            <h2><?= $plan->plan_name ?></h2>
                            <p class="price">
                                <span class="currency">$</span>
                                <b><?= $plan->amount ?></b> 
                                <span class="month">/month</span>
                            </p>
                        </div><!-- /.box-header -->
                        <div class="box-body" style="text-align: center">
                            <ul>
                                <li> Add <?= ($plan->contacts == -1) ? "Unlimited" : $plan->contacts ?> Contacts</li>
                                <li> Schedule Unlimited Events</li>
                                <li> <b><?= ($plan->sms_events == -1) ? "Unlimited" : $plan->sms_events ?></b> SMS Events per Contact</li>
                                <li> <b><?= ($plan->email_events == -1) ? "Unlimited" : $plan->email_events ?></b> Email Events per Contact</li>
                                <li> 
                                    <?=
                                    ($plan->group_events == -1) ?
                                            "<b>Unlimited</b>" :
                                            (($plan->group_events == 0) ? "No" : '<b>' . $plan->group_events . '</b>')
                                    ?>
                                    Group Events
                                </li>
                                <li> Import Contacts From Google</li>
                                <li> Import Contacts From Spreadsheet or CSV File</li>
                            </ul>
                            <?php
                            $prop = ($currPlan->plan_id == $plan->plan_id && $currPlan->plan_status != 0) ? 'disabled' : '';
                            $couponbox = ($plan->plan_id == 2) ? "p_coupon" : "e_coupon";
                            if (!$userInfo->is_set || $userInfo->gateway == "STRIPE") {
                                $id = ($plan->plan_id == 2) ? "a_personal" : "a_enterprise";
                                ?>
                                <button <?= $prop ?> type="button" id="<?= $id ?>" class="btn btn-info btn-lg">
                                    <?= ($userInfo->is_set) ? "Upgrade" : "Upgrade With Credit Card" ?>
                                </button>
                            <?php } ?>
                            <?php
                            if (!$userInfo->is_set || $userInfo->gateway == "PAYPAL") {
                                $id = ($plan->plan_id == 2) ? "pay_personal" : "pay_enterprise";
                                ?>
                                <button <?= $prop ?> type="button" id="<?= $id ?>" class="btn btn-info btn-lg">
                                    <?= ($userInfo->is_set) ? "Upgrade" : "Upgrade With Paypal" ?>
                                </button>
                            <?php } ?>
                            <?php if (!($currPlan->plan_id == $plan->plan_id && $currPlan->plan_status != 0)): ?>
                                <div id="<?= $couponbox ?>">
                                    <span class="link" style="line-height: 3">
                                        Have you a coupon code? 
                                        <a href="javascript:void(0);" class="coupon">Click Here</a>
                                    </span>
                                    <span style="color:green;display: none;line-height: 3" class="success"></span>
                                    <div class="row couponbox" style="padding: 10px;display: none">
                                        <div class="col-md-8">
                                            <input type="text" class="form-control couponcode" placeholder="Coupon Code" />
                                            <span style="color: red" class="msgCoupon"></span>
                                        </div>
                                        <div class="col-md-4">
                                            <button class="btn btn-success btn-xxs apply" type="button" >Apply</button>
                                            <img style="display: none" src="<?= base_url() ?>assets/dashboard/img/load.GIF" />
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div><!-- /.box-body -->
                        <div style="display: none" class="overlay"></div>
                        <div style="display: none" class="loading-img"></div>
                    </div>
                </div>
            <?php } ?>
            <div class="col-md-2"></div>
        </div>
        <div id="error" class="row" style="display: none">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div style="background-color: mistyrose !important;border-color: mintcream;color: red !important;" class="alert alert-danger alert-dismissable">
                    <i class="fa fa-ban"></i>
                    <b>Error!</b> <span id="error-msg"></span>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
        <?php if ($userInfo->is_set == 0 || ($userInfo->is_set == 1 && $userInfo->gateway == "STRIPE")): ?>
            <?php if (!$card): ?>
                <form style="display: none" id="personal" action="<?= site_url() ?>app/upgrade/pay" method="post">
                    <input type="hidden" name="plan" value="wishfish-personal"/>
                    <input type="hidden" name="coupon" value="">
                    <script
                        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                        data-key="<?= $stripe->publish_key ?>"
                        data-image="/square-image.png"
                        data-name="Personal"
                        data-description="Product"                    
                        data-label="Stripe"                    
                        >
                    </script>
                </form>
                <form style="display: none" id="enterprise" action="<?= site_url() ?>app/upgrade/pay" method="post">
                    <input type="hidden" name="plan" value="wishfish-enterprise"/>
                    <input type="hidden" name="coupon" value="">
                    <script
                        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                        data-key="<?= $stripe->publish_key ?>"
                        data-image="/square-image.png"
                        data-name="Enterprise"
                        data-description="Product"                    
                        data-label="Stripe"                    
                        >
                    </script>
                </form>
            <?php endif; ?>
        <?php endif; ?>

        <script type="text/javascript">
            planid = "<?= $currPlan->plan_id ?>";
            if (planid == 3) {
                $('#a_personal').text("Downgrade");
            }
            $(document).ready(function () {
                var cardFlag;
<?php if (!$card): ?>
                    cardFlag = false;
<?php else: ?>
                    cardFlag = true;
<?php endif; ?>
                var code = "";
                $('.coupon').click(function () {
                    var id = $(this).parents().eq(1).prop('id');
                    $('#' + id + ' .link').hide();
                    $('#' + id + ' div.couponbox').show();
                });
                $('button.apply').click(function () {
                    var id = $(this).parents().eq(2).prop('id');
                    code = $('#' + id + ' .couponcode').val().trim();
                    var rgex_code = /^[A-Za-z0-9]+$/;
                    if (code != "" && !rgex_code.test(code)) {
                        $('#' + id + ' .msgCoupon').text("Please Enter Valid Coupon Code..!");
                        return false;
                    } else {
                        $('#' + id + ' .msgCoupon').empty();
                        $(this).hide();
                        $(this).next().show();
                        $.ajax({
                            type: 'POST',
                            data: {code: code},
                            url: "<?= site_url() ?>app/upgrade/checkCoupon",
                            success: function (data, textStatus, jqXHR) {
                                if (data == "1") {
                                    $('#' + id + ' div.couponbox').hide();
                                    $('#' + id + ' span.success').html("Coupon <b style='color:#1ac6ff'>" + code + "</b> was apply successfully..!");
                                    $('#' + id + ' span.success').show();
                                    $('form#paypal input[name="coupon"]').val(code);
                                    if (id == "p_coupon")
                                        $('form#personal input[name="coupon"]').val(code);
                                    else if (id == "e_coupon")
                                        $('form#enterprise input[name="coupon"]').val(code);
                                } else {
                                    $('#' + id + ' button').show();
                                    $('#' + id + ' img').hide();
                                    $('#' + id + ' .msgCoupon').text("Coupon Code is Invalid..!");
                                }
                            }
                        });
                    }
                });

                $('#pay_personal').click(function () {
                    $('#planUpgrade .box-body button').prop('disabled', true);
                    $('.personal .overlay').show();
                    $('.personal .loading-img').show();
                    $.ajax({
                        type: 'POST',
                        url: "<?= site_url() ?>app/upgrade/isAllowToDowngrade",
                        success: function (data, textStatus, jqXHR) {
                            if (data == "1") {
                                upgradeWithPaypal();
                            } else {
                                $('#planUpgrade .box-body button').prop('disabled', false);
                                $('.personal .overlay').hide();
                                $('.personal .loading-img').hide();
                                $('#error').show();
                                $('#error-msg').text("You can not downgrade your plan..! ");
                            }
                        }
                    });
                });

                $('#pay_enterprise').click(function () {
                    $('#planUpgrade .box-body button').prop('disabled', true);
                    $('.enterprise .overlay').show();
                    $('.enterprise .loading-img').show();
                    $.ajax({
                        type: 'POST',
                        url: "<?= site_url() ?>app/pay",
                        data: {item_name: "wishfish-enterprise", amount: "49.99", upgrade: "1", code: code},
                        success: function (answer) {
                            if (answer == "0") {
                                $('#pay_enterprise').prop('disabled', false);
                                $('.enterprise .overlay').hide();
                                $('.enterprise .loading-img').hide();
                                $('#error').show();
                                $('#error-msg').text("You can not upgrade your plan until your first invoice was created.!");
                            } else {
                                window.location = answer;
                            }
                        }
                    });
                });

                $('#a_personal').click(function () {
                    $('#planUpgrade .box-body button').prop('disabled', true);
                    $('.personal .overlay').show();
                    $('.personal .loading-img').show();
                    if (!cardFlag) {
                        setTimeout(function () {
                            $('#personal button').trigger('click');
                            $('#planUpgrade .box-body button').prop('disabled', false);
                            $('.personal .overlay').hide();
                            $('.personal .loading-img').hide();
                        }, 2000);
                    } else {
                        $.ajax({
                            type: 'POST',
                            url: "<?= site_url() ?>app/upgrade/isAllowToDowngrade",
                            success: function (data, textStatus, jqXHR) {
                                $('#planUpgrade .box-body button').prop('disabled', false);
                                $('.personal .overlay').hide();
                                $('.personal .loading-img').hide();
                                if (data == "1") {
                                    if (!cardFlag) {
                                        $('#personal button').trigger('click');
                                    } else {
                                        upgradeWithStripe();
                                    }
                                } else {
                                    $('#error').show();
                                    $('#error-msg').text("You can not downgrade your plan..! ");
                                }
                            }
                        });
                    }
                });

                $('#a_enterprise').click(function () {
                    $('#planUpgrade .box-body button').prop('disabled', true);
                    $('.enterprise .overlay').show();
                    $('.enterprise .loading-img').show();
                    if (!cardFlag) {
                        setTimeout(function () {
                            $('#enterprise button').trigger('click');
                            $('#planUpgrade .box-body button').prop('disabled', false);
                            $('.enterprise .overlay').hide();
                            $('.enterprise .loading-img').hide();
                        }, 2000);
                    } else {
                        $.ajax({
                            type: 'POST',
                            data: {plan: "wishfish-enterprise", code: code},
                            url: "<?= site_url() ?>app/upgrade/upgradePlan",
                            success: function (data, textStatus, jqXHR) {
                                $('#planUpgrade .box-body button').prop('disabled', false);
                                $('.enterprise .overlay').hide();
                                $('.enterprise .loading-img').hide();
                                if (data == 1) {
                                    window.location.assign("<?= site_url() ?>app/dashboard");
                                } else {
                                    $('#error').show();
                                    $('#error-msg').text(data);
                                }
                            }
                        });
                    }

                });

                function upgradeWithPaypal() {
                    $.ajax({
                        type: 'POST',
                        url: "<?= site_url() ?>app/pay",
                        data: {item_name: "wishfish-personal", amount: "9.99", upgrade: "1"},
                        success: function (answer) {
                            if (answer == "0") {
                                $('.personal .overlay').hide();
                                $('.personal .loading-img').hide();
                                $('#planUpgrade .box-body button').prop('disabled', false);
                                $('#error').show();
                                $('#error-msg').text("You can not upgrade your plan until your first invoice was created.!");
                            } else {
                                //window.location = answer;
                            }
                        }
                    });
                }

                function upgradeWithStripe() {
                    $('#planUpgrade .box-body button').prop('disabled', 'disabled');
                    $('.personal .overlay').show();
                    $('.personal .loading-img').show();
                    $.ajax({
                        type: 'POST',
                        data: {plan: "wishfish-personal"},
                        url: "<?= site_url() ?>app/upgrade/upgradePlan",
                        success: function (data, textStatus, jqXHR) {
                            $('#a_personal').prop('disabled', false);
                            $('.personal .overlay').hide();
                            $('.personal .loading-img').hide();
                            if (data == 1) {
                                window.location.assign("<?= site_url() ?>app/dashboard");
                            } else {
                                $('#error').show();
                                $('#error-msg').text(data);
                            }
                        }
                    });
                }
            });
        </script>
    </section>
</aside>
</div>