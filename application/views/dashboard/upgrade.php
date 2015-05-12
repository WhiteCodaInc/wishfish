<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Plan Details
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-1" style="margin-right: 5%;"></div>
            <div class="col-md-3">
                <div class="box box-solid">
                    <div class="box-header" style="text-align: center">
                        <h3>14-day Free Trial</h3>
                        <br/>
                        <h4>USD 0 / month</h4>
                    </div><!-- /.box-header -->
                    <div class="box-body" style="text-align: center">
                        <ul>
                            <li> Add Unlimited Contacts</li>
                            <li> Schedule Unlimited Events</li>
                            <li> <b>3</b> SMS Events per Contact</li>
                            <li> <b>3</b> Email Events per Contact</li>
                            <li> - </li>
                            <li> - </li>
                        </ul>
                        <a id="a_personal" href="javascript:void(0)" class="btn btn-info">Upgrade</a>
                    </div><!-- /.box-body -->
                </div>
            </div>
            <div class="col-md-3">
                <div class="box box-solid">
                    <div class="box-header" style="text-align: center">
                        <h3>Personal</h3>
                        <br/>
                        <h4>USD 9.99 / month</h4>
                    </div><!-- /.box-header -->
                    <div class="box-body" style="text-align: center">
                        <h4>Organize your life.</h4>
                        <ul style="text-align: left">
                            <li>Workspace for daily projects</li>
                            <li>Keep everything together</li>
                            <li>Sync across all devices</li>
                        </ul>
                        <a id="a_personal" href="javascript:void(0)" class="btn btn-info">Upgrade</a>
                    </div><!-- /.box-body -->
                </div>
            </div>
            <div class="col-md-3">
                <div class="box box-solid">
                    <div class="box-header" style="text-align: center">
                        <h3>Enterprise</h3>
                        <br/>
                        <h4>USD 49.9 / month</h4>
                    </div><!-- /.box-header -->
                    <div class="box-body" style="text-align: center">
                        <h4>Organize your life.</h4>
                        <ul style="text-align: left">
                            <li>Workspace for daily projects</li>
                            <li>Keep everything together</li>
                            <li>Sync across all devices</li>
                        </ul>
                        <a id="a_enterprise" href="javascript:void(0)"  class="btn btn-info">Upgrade</a>
                    </div><!-- /.box-body -->
                </div>
            </div>
        </div>
<!--        <form style="display: none" id="personal" action="<?= site_url() ?>app/upgrade/pay" method="post">
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
        </form>-->
<!--        <form style="display: none" id="enterprise" action="<?= site_url() ?>app/upgrade/pay" method="post">
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
    </form>-->
<!--        <script type="text/javascript">
$(document).ready(function () {
$('#a_personal').click(function () {
$('#personal button').trigger('click');
});
$('#a_enterprise').click(function () {
$('#enterprise button').trigger('click');
});
});
</script>-->
    </section>
</aside>
</div>