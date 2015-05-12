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
            <div class="col-md-4">
                <div class="box box-solid">
                    <div class="box-header" style="text-align: center">
                        <h2>Personal</h2>
                        <p class="price"><span class="currency">$</span> <b>9.99</b> <span class="month">/month</span></p>
                    </div><!-- /.box-header -->
                    <div class="box-body" style="text-align: center">
                        <ul>
                            <li> Add Contact upto <b>10</b></li>
                            <li> Maximum <b>20</b> Events per Contact</li>
                            <li> <b>1</b> SMS Number per Customer</li>
                            <li> <b>1</b> Email Address per Customer</li>
                            <li> Import Contacts From Google</li>
                            <li> Import Contacts From Spreadsheet or CSV File</li>
                        </ul>
                        <button <?= ($currPlan->plan_id == 2 || $currPlan->plan_id == 3) ? 'disabled' : '' ?> type="button" id="a_personal" class="btn btn-info btn-lg">
                            Upgrade
                        </button>
                    </div><!-- /.box-body -->
                    <div class="overlay"></div>
                    <div class="loading-img"></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box box-solid">
                    <div class="box-header" style="text-align: center">
                        <h2>Enterprise</h2>
                        <p class="price"><span class="currency">$</span> <b>49.99</b> <span class="month">/month</span></p>
                    </div><!-- /.box-header -->
                    <div class="box-body" style="text-align: center">
                        <ul>
                            <li> Add Contact upto <b>20</b></li>
                            <li> Maximum <b>40</b> Events per Contact</li>
                            <li> <b>2</b> SMS Number per Customer</li>
                            <li> <b>2</b> Email Address per Customer</li>
                            <li> Import Contacts From Google</li>
                            <li> Import Contacts From Spreadsheet or CSV File</li>
                        </ul>
                        <button <?= ($currPlan->plan_id == 3) ? 'disabled' : '' ?> type="button" id="a_enterprise" class="btn btn-info btn-lg">
                            Upgrade
                        </button>
                    </div><!-- /.box-body -->
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
        <?php if (!$card): ?>
            <form style="display: none" id="personal" action="<?= site_url() ?>app/upgrade/pay" method="post">
                <input type="hidden" name="amount" value="<?= $pdetail[0]->amount ?>"/>
                <input type="hidden" name="frequency" value="1"/>
                <input type="hidden" name="name" value="<?= $pdetail[0]->plan_name ?>"/>
                <input type="hidden" name="id" value="<?= $pdetail[0]->plan_id ?>"/>

                <script
                    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                    data-key="<?= $gatewayInfo->publish_key ?>"
                    data-image="/square-image.png"
                    data-name="<?= $pdetail[0]->plan_name ?>"
                    data-description="Product"                    
                    data-label="Stripe"                    
                    >
                </script>
            </form>
            <form style="display: none" id="enterprise" action="<?= site_url() ?>app/upgrade/pay" method="post">
                <input type="hidden" name="amount" value="<?= $pdetail[1]->amount ?>"/>
                <input type="hidden" name="frequency" value="1"/>
                <input type="hidden" name="name" value="<?= $pdetail[1]->plan_name ?>"/>
                <input type="hidden" name="id" value="<?= $pdetail[1]->plan_id ?>"/>

                <script
                    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                    data-key="<?= $gatewayInfo->publish_key ?>"
                    data-image="/square-image.png"
                    data-name="<?= $pdetail[1]->plan_name ?>"
                    data-description="Product"                    
                    data-label="Stripe"                    
                    >
                </script>
            </form>
        <?php endif; ?>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#a_personal').click(function () {
                    $('#personal button').trigger('click');
                });
                $('#a_enterprise').click(function () {
                    $('#enterprise button').trigger('click');
                });
            });
        </script>
    </section>
</aside>
</div>