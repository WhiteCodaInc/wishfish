<style type="text/css">

    #planUpgrade{
        margin: 0 5%;
    }

    #planUpgrade ul li{
        line-height: 50px;
        border-bottom: 1px solid #dee2e4;
        text-align: center;
        font-size: 16px;
    }
    #planUpgrade ul{
        list-style: none;
        padding: 0;
    }
    #planUpgrade p{
        font-size: 20px;
        line-height: 25px;
    }
    #planUpgrade .box-body{
        padding: 0;
    }
    #planUpgrade .box-body button{
        width: 65%;
        margin: 5%;
    }
    #planUpgrade .box-header{
        text-align: center;
        background-color: #1ac6ff;
        color: white;
    }
    #planUpgrade .box-header h2{
        font-weight: 600
    }
    #planUpgrade .box-header b{
        font-size: 60px;
        line-height: 70px;
        color: #fff;
    }
    #planUpgrade .box-header span.currency{
        font-size: 24px;
        line-height: 54px;
        vertical-align: top;
        display: inline-block;
    }
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
                            if ($userInfo->gateway == "STRIPE") {
                                $id = ($plan->plan_id == 2) ? "a_personal" : "a_enterprise";
                                $prop = ($currPlan->plan_id == $plan->plan_id && $currPlan->plan_status != 0) ? 'disabled' : '';
                            } else if ($userInfo->gateway == "PAYPAL") {
                                $id = ($plan->plan_id == 2) ? "pay_personal" : "pay_enterprise";
                            } else {
                                $id = "";
                                $prop = "";
                            }
                            ?>
                            <button <?= $prop ?> type="button" id="<?= $id ?>" class="btn btn-info btn-lg">
                                Upgrade
                            </button>
                            <button <?= $prop ?> type="button" id="<?= $id ?>" class="btn btn-info btn-lg">
                                    Upgrade
                                </button>
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
        <?php if ($userInfo->is_set == 1 && $userInfo->gateway == "STRIPE"): ?>
            <?php if (!$card): ?>
                <form style="display: none" id="personal" action="<?= site_url() ?>app/upgrade/pay" method="post">
                    <input type="hidden" name="plan" value="wishfish-personal"/>
                    <script
                        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                        data-key="<?= $gatewayInfo->publish_key ?>"
                        data-image="/square-image.png"
                        data-name="Personal"
                        data-description="Product"                    
                        data-label="Stripe"                    
                        >
                    </script>
                </form>
                <form style="display: none" id="enterprise" action="<?= site_url() ?>app/upgrade/pay" method="post">
                    <input type="hidden" name="plan" value="wishfish-enterprise"/>
                    <script
                        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                        data-key="<?= $gatewayInfo->publish_key ?>"
                        data-image="/square-image.png"
                        data-name="Enterprise"
                        data-description="Product"                    
                        data-label="Stripe"                    
                        >
                    </script>
                </form>
            <?php endif; ?>
        <?php endif; ?>

        <!--        <form id="paypal" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">
                    <input type="hidden" name="cmd" value="_xclick-subscriptions">
                    <input type="hidden" name="business" value="<?= $paypal->business_id ?>">
                    <input type="hidden" name="item_name" value="">
                    <input type="hidden" name="no_note" value="1">
                    <input type="hidden" name="src" value="1">
                    <input type="hidden" name="a3" value="">
                    <input type="hidden" name="p3" value="1">
                    <input type="hidden" name="t3" value="M">
                    <input type="hidden" name="currency_code" value="USD">
                    <input type="hidden" name="return" value="<?= site_url() ?>login" >
                    <input type="hidden" name="cancel_return" value="<?= site_url() ?>home">
                    <input type="hidden" name="bn" value="PP-SubscriptionsBF:btn_subscribeCC_LG.gif:NonHostedGuest">
                </form>-->

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
                $('#a_personal').click(function () {
                    $('#planUpgrade .box-body button').prop('disabled', 'disabled');
                    $('.personal .overlay').show();
                    $('.personal .loading-img').show();
                    $.ajax({
                        type: 'POST',
                        url: "<?= site_url() ?>app/upgrade/isAllowToDowngrade",
                        success: function (data, textStatus, jqXHR) {
                            $('#a_personal').prop('disabled', false);
                            $('.personal .overlay').hide();
                            $('.personal .loading-img').hide();
                            if (data == 1) {
                                if (!cardFlag) {
                                    $('#personal button').trigger('click');
                                } else {
                                    upgradePlan();
                                }
                            } else {
                                $('#error').show();
                                $('#error-msg').text("You can not downgrade your plan..! ");
                            }
                        }
                    });
                });
                $('#a_enterprise').click(function () {
                    $('#planUpgrade .box-body button').prop('disabled', 'disabled');
                    $('.enterprise .overlay').show();
                    $('.enterprise .loading-img').show();
                    if (!cardFlag) {
                        $('#enterprise button').trigger('click');
                        $('#a_enterprise').prop('disabled', false);
                        $('.enterprise .overlay').hide();
                        $('.enterprise .loading-img').hide();
                    } else {
                        $.ajax({
                            type: 'POST',
                            data: {plan: "wishfish-enterprise"},
                            url: "<?= site_url() ?>app/upgrade/upgradePlan",
                            success: function (data, textStatus, jqXHR) {
                                $('#a_enterprise').prop('disabled', false);
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
                function upgradePlan() {
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