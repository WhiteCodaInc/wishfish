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
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">New Offer</h3>
                    </div><!-- /.box-header -->
                    <?php $method = (isset($offer)) ? "updateOffer" : "createOffer" ?>
                    <!-- form start -->
                    <form id="offerForm" role="form" action="<?= site_url() ?>admin/offers/<?= $method ?>" method="post">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="username">Offer Name</label>
                                        <input value="<?= isset($offer) ? $offer->offer_name : '' ?>" type="text" autofocus="autofocus" name="offer_name" class="form-control" placeholder="Offer Name" />
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
                        </div>
                        <?php if (isset($offer)): ?>
                            <input type="hidden" name="offerid" value="<?= $offer->offer_id ?>" />
                        <?php endif; ?>
                    </form>
                </div><!-- /.box -->
            </div><!--/.col (left) -->
            <div class="col-md-4"></div>
            <!-- right column -->
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->
</div><!-- ./wrapper -->
<script type="text/javascript">
    $(document).ready(function () {
        $('#save-offer').click(function () {
            if ($('input[name="offer_name"]').val().trim() == "") {
                alertify.error("Enter Offer Name..!");
                return false;
            }
            $('#offerForm').submit();
        });
    });
</script>
