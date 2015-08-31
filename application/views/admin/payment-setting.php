<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="display: none">
            Payment Setting
        </h1> 
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary paypal">
                    <div class="box-header">
                        <h3 class="box-title">Paypal</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <form id="paypalForm" method="post">
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label>API Username</label>
                                        <input name="api_username" value="<?= $paypal->api_username ?>" type="text" class="form-control" required=""/>
                                    </div>
                                    <div class="form-group">
                                        <label>API Username</label>
                                        <input name="api_password" value="<?= $paypal->api_password ?>" type="text" class="form-control" required=""/>
                                    </div>
                                    <div class="form-group">
                                        <label>API Password</label>
                                        <input name="api_signature" value="<?= $paypal->api_signature ?>" type="text" class="form-control" required=""/>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-success" type="submit">Update</button>
                                    </div>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                        </form>
                    </div>
                    <div style="display: none" class="overlay"></div>
                    <div style="display: none" class="loading-img"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-primary stripe">
                    <div class="box-header">
                        <h3 class="box-title">Stripe</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <form id="stripeForm" method="post">
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label>Publish Key</label>
                                        <input name="publish_key" value="<?= $stripe->publish_key ?>" type="text" class="form-control" required=""/>
                                    </div>
                                    <div class="form-group">
                                        <label>API Username</label>
                                        <input name="secret_key" value="<?= $stripe->secret_key ?>" type="text" class="form-control" required=""/>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-success" type="submit">Update</button>
                                    </div>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                        </form>
                    </div>
                    <div style="display: none" class="overlay"></div>
                    <div style="display: none" class="loading-img"></div>
                </div>
            </div>
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->




<!-- /.modal -->
<script type="text/javascript">
    $(document).ready(function () {
        $('#paypalForm').submit(function (e) {
            e.preventDefault();
            $('.paypal .overlay').show();
            $('.paypal .loading-img').show();
            $.ajax({
                type: 'POST',
                data: $('#paypalForm').serialize(),
                url: "<?= site_url() ?>admin/setting/updatePaypal",
                success: function (data, textStatus, jqXHR) {
                    $('.paypal .overlay').hide();
                    $('.paypal .loading-img').hide();
                    if (data == '1') {
                        alertify.success("Paypal Credential Updated..!");
                    } else {
                        alertify.error("Paypal Credential Not Updated..!");
                    }
                }
            });

        });
        $('#stripeForm').submit(function (e) {
            e.preventDefault();
            $('.stripe .overlay').show();
            $('.stripe .loading-img').show();
            $.ajax({
                type: 'POST',
                data: $('#stripeForm').serialize(),
                url: "<?= site_url() ?>admin/setting/updateStripe",
                success: function (data, textStatus, jqXHR) {
                    $('.stripe .overlay').hide();
                    $('.stripe .loading-img').hide();
                    if (data == "1") {
                        alertify.success("Stripe Credential Updated..!");
                    } else {
                        alertify.error("Stripe Credential Not Updated..!");
                    }
                }
            });
        });
    });
</script>