<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dashboard/css/checkbox.css"/>
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="display: none">
            Edit Payout Setting
        </h1>
        <button type="submit" id="pupdate" class="btn btn-primary">
            update
        </button>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3"></div>
            <!-- left column -->
            <div class="col-md-6">
                <form id="payoutForm" role="form" action="<?= site_url() ?>admin/affiliates/updateSetting" method="post">
                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="form-group">
                                <div style="float: left;padding-right: 5px;cursor: pointer">
                                    <input type="radio" value="global"  name="payouttype" <?= ($affInfo->payout_type == 1) ? "checked" : "" ?>  class="simple form-control">                          
                                    <span class="lbl padding-8">Global&nbsp;</span>
                                </div>
                                <div style="float: left;padding:0 5px;cursor: pointer">
                                    <input type="radio" value="aff"  name="payouttype" <?= ($affInfo->payout_type == 2) ? "checked" : "" ?> class="simple form-control">
                                    <span  class="lbl padding-8">Affiliate Specific&nbsp;</span>
                                </div>
                                <div style="float: left;padding:0 5px;cursor: pointer">
                                    <input type="radio" value="offer"  name="payouttype" <?= ($affInfo->payout_type == 3) ? "checked" : "" ?> class="simple form-control">
                                    <span  class="lbl padding-8">Offer Specific&nbsp;</span>
                                </div>
                            </div><br/>
                            <div class="form-group aff-specific" style="display: none">
                                <label>Payout On Immediate Purchase </label>
                                <input value=""  type="number" name="normal" class="form-control" placeholder="PER(%)" />
                            </div>
                            <div class="form-group aff-specific" style="display: none">
                                <label>Payout On Upsell Purchase </label>
                                <input value=""  type="number" name="upsell" class="form-control" placeholder="PER(%)" />
                            </div>
                            <div class="form-group aff-specific" style="display: none">
                                <label>Payout On Recurring Purchase </label>
                                <input value=""  type="number" name="recurring" class="form-control" placeholder="PER(%)" />
                            </div>
                            <div class="form-group">
                                <span style="color: red;" id="msgPayout"></span>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-primary pull-left save">Save</button>
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-danger discard" data-dismiss="modal">
                                        <i class="fa fa-times"></i> Discard
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="overlay" style="display: none"></div>
                        <div class="loading-img" style="display: none"></div>
                    </div>
                </form>
            </div>
            <div class="col-md-3"></div>
        </div>
    </section>
</aside>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#pupdate').click(function () {
            $('#groupForm').submit();
        });
        $('input[name="payouttype"]').change(function () {
            if ($(this).val() == "aff" || $(this).val() == "offer") {
                $('.aff-specific').show();
            } else {
                $('.aff-specific').hide();
                $('.aff-specific input').val('');
                $('#msgPayout').empty();
            }
        });
        $('input[name="payouttype"]:checked').trigger('change');
    });
</script>