<!-- Theme Style -->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dashboard/css/AdminLTE.css"/>
<!-- Bootstrap -->
<link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"/>
<section class="content">
    <div class="row">
        <div class="col-md-3"></div>
        <div  style="text-align: center;font-size: 20px;color: blueviolet" class="col-md-6">
            <p>Please wait, you are being redirected to the checkout page.</p>
            <p>Click here if you're not automatically redirected...</p>
            <br/>
            <form id="stripe" action="<?= site_url() ?>app/upgrade/pay" method="post">
                <input type="hidden" name="amount" value="<?= $pdetail->amount ?>"/>
                <input type="hidden" name="frequency" value="1"/>
                <input type="hidden" name="id" value="<?= $pdetail->id ?>"/>
                <input type="hidden" name="name" value="<?= $pdetail->plan_name ?>"/>

                <script
                    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                    data-key="<?= $gatewayInfo->publish_key ?>"
                    data-image="/square-image.png"
                    data-name="Demo payment"
                    data-description="Product"                    
                    data-label="Stripe"                    
                    >
                </script>
            </form>
        </div>
        <div class="col-md-3"></div>
    </div>
</section>


<script type="text/javascript">
    $(function () {
        $('.stripe-button-el').trigger('click');
    });
</script>
