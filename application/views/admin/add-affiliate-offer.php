<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="display: none">
            Add New Offer
        </h1>
        <button type="button" id="save-offer"  class="btn btn-warning">
            <?= isset($offer) ? 'Update' : 'Save' ?>
        </button>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">New Offer</h3>
                    </div><!-- /.box-header -->
                    <?php $method = (isset($offer)) ? "updateOffer" : "createOffer" ?>
                    <!-- form start -->
                    <form id="offerForm" role="form" action="<?= site_url() ?>admin/affiliate_offers/<?= $method ?>" method="post">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="username">Offer Name</label>
                                        <input value="<?= isset($offer) ? $offer->offer_name : '' ?>" type="text" autofocus="autofocus" name="offer_name" class="form-control" placeholder="Offer Name" required=""/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Choose Product</label>
                                        <select name="product_id" class="form-control" required="">
                                            <option value="-1">--Select--</option>
                                            <?php foreach ($products as $value) { ?>
                                                <?php
                                                $selected = "";
                                                if (isset($offer)) {
                                                    $selected = ($offer->product_id == $value->product_id) ?
                                                            "selected" : '';
                                                }
                                                ?>
                                                <option value="<?= $value->product_id ?>" <?= $selected ?>>
                                                    <?= $value->product_name ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Choose Payment Plan</label>
                                        <select name="payment_plan_id" class="form-control" required="">
                                            <option value="-1">--Select--</option>
                                            <?php foreach ($plans as $value) { ?>
                                                <?php
                                                $selected = "";
                                                if (isset($offer)) {
                                                    $selected = ($offer->payment_plan_id == $value->payment_plan_id) ?
                                                            "selected" : '';
                                                }
                                                ?>
                                                <option value="<?= $value->payment_plan_id ?>" <?= $selected ?>>
                                                    <?= $value->payment_plan ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Funnel / Page URL</label>
                                        <input value="<?= isset($offer) ? $offer->page_url : '' ?>" type="text" name="page_url" class="form-control" placeholder="Enter Funnel / Page URL" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group ">
                                        <a href="javascript:void(0);" class="aff-link"></a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Payout On Immediate Purchase (%) </label>
                                <input value="<?= isset($offer) ? $offer->normal : '' ?>"  type="number" name="normal" class="form-control" placeholder="PER(%)" required=""/>
                            </div>
                            <div class="form-group">
                                <label>Payout On Upsell Purchase (%) </label>
                                <input value="<?= isset($offer) ? $offer->upsell : '' ?>"  type="number" name="upsell" class="form-control" placeholder="PER(%)" required=""/>
                            </div>
                            <div class="form-group">
                                <label>Payout On Recurring Purchase (%) </label>
                                <input value="<?= isset($offer) ? $offer->recurring : '' ?>"  type="number" name="recurring" class="form-control" placeholder="PER(%)" required=""/>
                            </div>
                            <div class="form-group">
                                <span style="color: red;" id="msgPayout"></span>
                            </div>
                            <button type="submit" style="display: none"></button>
                        </div>
                        <?php if (isset($offer)): ?>
                            <input type="hidden" name="offerid" value="<?= $offer->offer_id ?>" />
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
    $(document).ready(function () {

        $('input[name="page_url"]').focusout(function () {
            $('.aff-link').html('<h4>' + $(this).val() + '?offer={ID}&aff={ID}</h4>');
        });

        $('#save-offer').click(function () {
            $('#offerForm button:submit').trigger('click');
        });

        $('#offerForm').on('submit', function () {
            alert();
            var normal = $('input[name="normal"]').val();
            var upsell = $('input[name="upsell"]').val();
            var recur = $('input[name="recurring"]').val();
            if (normal.trim() == "" || normal < 0 || normal > 100) {
                $('#msgPayout').text("Invalid Immediate Purchase Value..!");
                return false;
            } else {
                $('#msgPayout').empty();
            }
            if (upsell.trim() == "" || upsell < 0 || upsell > 100) {
                $('#msgPayout').text("Invalid Immediate Purchase Value..!");
                return false;
            } else {
                $('#msgPayout').empty();
            }
            if (recur.trim() == "" || recur < 0 || recur > 100) {
                $('#msgPayout').text("Invalid Recurring Purchase Value..!");
                return false;
            } else {
                $('#msgPayout').empty();
            }
            $('#save-offer').prop('disabled', true);
        });
    });
</script>
