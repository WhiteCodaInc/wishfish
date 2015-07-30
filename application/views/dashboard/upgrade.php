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
                <a href="#" id="cardPersonal" class="create btn btn-info" style="display: none" data-toggle="modal" data-target="#personal-card-modal">
                    Pay
                </a>
                <a href="#" id="cardEnterprise" class="create btn btn-info" style="display: none" data-toggle="modal" data-target="#enterprise-card-modal">
                    Pay
                </a>
                <!-------------------------------Personal Card Detail Model------------------------------------>
                <div class="modal fade" id="personal-card-modal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" style="max-width: 425px">
                        <div class="modal-content">
                            <form id="personalCardForm" role="form" action="<?= site_url() ?>stripe_payment/pay"  method="post">
                                <div class="modal-header" style="text-align: center">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h2 class="modal-title">$9.99</h2>
                                    <span class="modal-descritpion">1-month of wish-fish Personal</span>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input  type="email" name="stripeEmail" class="form-control" placeholder="Email" required=""/>
                                    </div>
                                    <div class="form-group">
                                        <label>Credit Card Number </label>
                                        <input data-stripe="number" value=""  type="text" maxlength="16" class="card_number form-control" placeholder="Card Number" required=""/>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Expiration (MM/YYYY)</label>
                                                <div class="row">
                                                    <div class="col-md-5" style="padding-right: 0">
                                                        <input value=""  data-stripe="exp-month" maxlength="2" type="text" class="month form-control" placeholder="MM" required=""/>
                                                    </div>
                                                    <div class="col-md-1" style="font-size: 25px;padding-left: 10px;">/</div>
                                                    <div class="col-md-5" style="padding-left: 0">
                                                        <input value="" data-stripe="exp-year" type="text" maxlength="4" class="year form-control" placeholder="YYYY" required="" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label>CVC</label>
                                                <input maxlength="3" type="password" class="cvc form-control" required=""/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" style="text-align: center">
                                        <span style="color: red;display: none" id="msgCard"></span>
                                    </div>
                                    <div class="form-group" style="text-align: center">
                                        <button style="width: 50%" id="payPersonal" type="submit" class="btn btn-success btn-lg">Pay</button>
                                    </div>
                                </div>
                                <input type="hidden" name="plan" value="wishfish-personal"/>
                                <input type="hidden" name="planid" value="2"/>
                                <input type="hidden" name="coupon" value=""/>
                            </form>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>
                <!------------------------------------------------------------------------>

                <!-------------------------------Enterprise Card Detail Model------------------------------------>
                <div class="modal fade" id="enterprise-card-modal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" style="max-width: 425px">
                        <div class="modal-content">
                            <form id="enterpriseCardForm" role="form" action="<?= site_url() ?>stripe_payment/pay"  method="post">
                                <div class="modal-header" style="text-align: center">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h2 class="modal-title">$49.99</h2>
                                    <span class="modal-descritpion">1-month of wish-fish Personal</span>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input  type="email" name="stripeEmail" class="form-control" placeholder="Email" required=""/>
                                    </div>
                                    <div class="form-group">
                                        <label>Credit Card Number </label>
                                        <input data-stripe="number" value=""  type="text" maxlength="16" class="card_number form-control" placeholder="Card Number" required=""/>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Expiration (MM/YYYY)</label>
                                                <div class="row">
                                                    <div class="col-md-5" style="padding-right: 0">
                                                        <input value=""  data-stripe="exp-month" maxlength="2" type="text" class="month form-control" placeholder="MM" required=""/>
                                                    </div>
                                                    <div class="col-md-1" style="font-size: 25px;padding-left: 10px;">/</div>
                                                    <div class="col-md-5" style="padding-left: 0">
                                                        <input value="" data-stripe="exp-year" type="text" maxlength="4" class="year form-control" placeholder="YYYY" required="" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label>CVC</label>
                                                <input maxlength="3" type="password" class="cvc form-control" required=""/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" style="text-align: center">
                                        <span style="color: red;display: none" id="msgCard"></span>
                                    </div>
                                    <div class="form-group" style="text-align: center">
                                        <button style="width: 50%" id="payEnterprise" type="submit" class="btn btn-success btn-lg">Pay</button>
                                    </div>
                                </div>
                                <input type="hidden" name="plan" value="wishfish-enterprise"/>
                                <input type="hidden" name="planid" value="3"/>
                                <input type="hidden" name="coupon" value=""/>
                            </form>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>
                <!------------------------------------------------------------------------>
        <!--                <form style="display: none" id="personal" action="<?= site_url() ?>app/upgrade/pay" method="post">
                    <input type="hidden" name="plan" value="wishfish-personal"/>
                    <input type="hidden" name="planid" value="2">
                    <input type="hidden" name="coupon" value="">
                    <script
                        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                        data-key="<?= $stripe->publish_key ?>"
                        data-image="/square-image.png"
                        data-name="$9.99"
                        data-description="1-month of Wish-Fish Personal"                    
                        data-label="Stripe"                    
                        >
                    </script>
                </form>-->
        <!--                <form style="display: none" id="enterprise" action="<?= site_url() ?>app/upgrade/pay" method="post">
                    <input type="hidden" name="plan" value="wishfish-enterprise"/>
                    <input type="hidden" name="planid" value="3">
                    <input type="hidden" name="coupon" value="">
                    <script
                        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                        data-key="<?= $stripe->publish_key ?>"
                        data-image="/square-image.png"
                        data-name="$49.99"
                        data-description="1-month of Wish-Fish Enterprise"                    
                        data-label="Stripe"                    
                        >
                    </script>
                </form>-->
            <?php endif; ?>
        <?php endif; ?>

    </section>
</aside>
</div>

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
    $(function () {
        var formType = "";
        Stripe.setPublishableKey('<?= $stripe->publish_key ?>');
        $('#personalCardForm,#enterpriseCardForm').on('submit', function () {
            formType = $(this).prop('id');
            (formType == "personalCardForm") ?
                    $('#payPersonal').prop('disabled', true) :
                    $('#payEnterprise').prop('disabled', true);
            var error = false;
            var ccNum = $(this).find('.card_number').val(),
                    cvcNum = $(this).find('.cvc').val(),
                    expMonth = $(this).find('.month').val(),
                    expYear = $(this).find('.year').val();

            // Validate the number:
            if (!Stripe.card.validateCardNumber(ccNum)) {
                error = true;
                $('#' + formType + ' #msgCard').text('The credit card number appears to be invalid.');
                $('#' + formType + ' #msgCard').show();
                (formType == "personalCardForm") ?
                        $('#payPersonal').prop('disabled', false) :
                        $('#payEnterprise').prop('disabled', false);
                return false;
            }
            // Validate the CVC:
            if (!Stripe.card.validateCVC(cvcNum)) {
                error = true;
                $('#' + formType + ' #msgCard').text('The CVC number appears to be invalid.');
                $('#' + formType + ' #msgCard').show();
                (formType == "personalCardForm") ?
                        $('#payPersonal').prop('disabled', false) :
                        $('#payEnterprise').prop('disabled', false);
                return false;
            }
            // Validate the expiration:
            if (!Stripe.card.validateExpiry(expMonth, expYear)) {
                error = true;
                $('#' + formType + ' #msgCard').text('The expiration date appears to be invalid.');
                $('#' + formType + ' #msgCard').show();
                (formType == "personalCardForm") ?
                        $('#payPersonal').prop('disabled', false) :
                        $('#payEnterprise').prop('disabled', false);
                return false;
            }
            // Check for errors:
            if (!error) {
                // Get the Stripe token:
                $('#' + formType + ' #msgCard').hide();
                Stripe.card.createToken({
                    number: ccNum,
                    cvc: cvcNum,
                    exp_month: expMonth,
                    exp_year: expYear
                }, stripeResponseHandler);
                return false;
            } else {
                $('#' + formType + ' #msgCard').show();
                return false;
            }
            return false;
        });

        function stripeResponseHandler(status, response) {
            if (response.error) {
                reportError(response.error.message);
            } else { // No errors, submit the form:
                var f = $('#' + formType);
                var token = response['id'];
                // Insert the token into the form so it gets submitted to the server
                f.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
                // Submit the form:
                f.get(0).submit();
            }
        }
    });
</script>               

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
            var amt = (id == "p_coupon") ? "9.99" : "49.99";
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
                    data: {code: code, amount: amt},
                    url: "<?= site_url() ?>app/upgrade/checkCoupon",
                    success: function (data, textStatus, jqXHR) {
                        if (data == "0") {
                            $('#' + id + ' button').show();
                            $('#' + id + ' img').hide();
                            $('#' + id + ' .msgCoupon').text("Coupon Code is Invalid..!");
                        } else {
                            var json = JSON.parse(data);
                            couponCode = code;
                            $('#' + id + ' div.couponbox').hide();
                            $('#' + id + ' span.success').html("Coupon <b style='color:#1ac6ff'>" + code + "</b> was apply successfully..!");
                            $('#' + id + ' span.success').show();

                            (id == "p_coupon") ?
                                    $('#personalCardForm .modal-title').text("$" + json.discAmt) :
                                    $('#enterpriseCardForm .modal-title').text("$" + json.discAmt);

                            (id == "p_coupon") ?
                                    $('#personalCardForm input[name="coupon"]').val(code) :
                                    $('#enterpriseCardForm input[name="coupon"]').val(code);

                            if (json.flag == "1") {
                                $('form#paypal input[name="coupon"]').val(code);
                            } else {
                                (id == "p_coupon") ?
                                        $('#wishfish-personal').hide() :
                                        $('#wishfish-enterprise').hide();
                            }
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
//                    $('#personal button').trigger('click');
                    $('#cardPersonal').trigger('click');
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
//                    $('#enterprise button').trigger('click');
                    $('#cardEnterprise').trigger('click');
                    $('#planUpgrade .box-body button').prop('disabled', false);
                    $('.enterprise .overlay').hide();
                    $('.enterprise .loading-img').hide();
                }, 2000);
            } else {
                $.ajax({
                    type: 'POST',
                    data: {plan: "wishfish-enterprise", planid: 3, coupon: code},
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
                        $('#pay_personal').prop('disabled', false);
                        $('#error').show();
                        $('#error-msg').text("You can not upgrade your plan until your first invoice was created.!");
                    } else {
                        window.location = answer;
                    }
                }
            });
        }

        function upgradeWithStripe() {
            $('#planUpgrade .box-body button').prop('disabled', true);
            $('.personal .overlay').show();
            $('.personal .loading-img').show();
            $.ajax({
                type: 'POST',
                data: {plan: "wishfish-personal", planid: 2, coupon: code},
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