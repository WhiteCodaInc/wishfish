<style type="text/css">
    #product-data-table tr td,#product-data-table tr th{
        text-align: center;
    }
    audio{
        width: 45px !important;
    }
    span.copyText {
        position: relative;
        display: inline;
        cursor: pointer
    }
    .callout textarea {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 0 none transparent;
        margin: 0;
        padding: 0;
        outline: none;
        resize: none;
        overflow: hidden;
        font-family: inherit;
        font-size: 1em;
        cursor: pointer
    }
</style>
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style=" display: none">
            Promote Products
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <!--        <div class="callout callout-info">
                    <h4>Unique Affiliate Link :</h4>
                    <p><span class="copyText">https://www.wish-fish.com?aff=<?= $affInfo->fname . $affInfo->lname ?></span></p>
                </div>-->
        <div class="row">
            <div class="col-xs-12">
                <div class="box" >
                    <div class="box-header">
                        <h3 class="box-title">Product Detail</h3>
                    </div><!-- /.box-header -->
                    <form name="checkForm" id="checkForm" action="" method="post">
                        <div class="box-body table-responsive" id="data-panel">

                            <table id="product-data-table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Offer Name</th>
                                        <th>Payment Plan</th>
                                        <th>Payout On Immediate Purchase</th>
                                        <th>Payout On Upsell Purchase</th>
                                        <th>Payout On Recurring Purchase</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <?php
                                ($affInfo->payout_type != '3') ? $n = $affInfo->normal_payout : '';
                                ($affInfo->payout_type != '3') ? $u = $affInfo->upsell_payout : '';
                                ($affInfo->payout_type != '3') ? $r = $affInfo->recurring_payout : '';
                                ?>
                                <tbody>
                                    <?php foreach ($product as $value) { ?>
                                        <tr id="<?= $value->offer_id ?>">
                                            <td class="name"><?= $value->offer_name ?></td>
                                            <td>
                                                <?php if ($value->payment_plan_id): ?>
                                                    <strong><?= $value->payment_plan ?></strong><br/>
                                                    <strong>$ <?= $value->initial_amt ?></strong> immediately,
                                                    and <strong>$ <?= $value->amount . ' / ' . $value->interval ?></strong> 
                                                    after <strong><?= $value->trial_period ?> days.</strong>
                                                <?php else: ?>
                                                    N/A
                                                <?php endif; ?>
                                            </td>
                                            <td><?= (isset($n)) ? $n : $value->normal ?> %</td>
                                            <td><?= (isset($u)) ? $u : $value->upsell ?> %</td>
                                            <td><?= (isset($r)) ? $r : $value->recurring ?> %</td>
                                            <td>
                                                <button type="button"  value="html" class="btn btn-info btn-xs html">
                                                    <i class="fa fa-eye"></i>
                                                    Html Code
                                                </button>
                                                <button type="button"  value="link" 
                                                        data-aff_link="<?= $value->page_url ?>?offer=<?= $value->offer_id ?>&aff=<?= $affInfo->affiliate_id ?>" 
                                                        class="btn btn-primary btn-xs link" >
                                                    <i class="fa fa-eye"></i>
                                                    Link
                                                </button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Offer Name</th>
                                        <th>Payment Plan</th>
                                        <th>Payout On Immediate Purchase</th>
                                        <th>Payout On Upsell Purchase</th>
                                        <th>Payout On Recurring Purchase</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->
</div><!-- ./wrapper -->


<!-- NEW EVENT MODAL -->
<div class="modal fade" id="preview-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <div class="row m-bot15">                        
                    <div id="view" class="col-md-12" style="text-align: center">

                    </div>
                </div>
                <div class="modal-footer clearfix">
                    <button type="button" id="n_discard" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Discard</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</div>


<script type="text/javascript">
</script>

<!-- DATA TABES SCRIPT -->
<script src="<?= base_url() ?>assets/dashboard/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/dashboard/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

<!-- page script -->
<script type="text/javascript">
    $(function () {
        $("#product-data-table").dataTable({
            bSort: false
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.copyText').click(
                function () {
                    if ($('#tmp').length) {
                        $('#tmp').remove();
                    }
                    var clickText = $(this).text();
                    $('<textarea id="tmp" />')
                            .appendTo($(this))
                            .val(clickText)
                            .focus()
                            .select();
                    return false;
                });
        $(':not(.copyText)').click(
                function () {
                    $('#tmp').remove();
                });


        $('button.html1').click(function () {
            var type = $(this).val();
            var offerid = $(this).parents('tr').attr('id');
            var name = $('#product-data-table tr#' + offerid).find('td.name').text();
            $('.modal-title').text(name);

            $img = $('tr#' + offerid).find('img');
            $img.removeAttr('style');
            $('#view').html("<textarea class='form-control'></textarea>");
            $('#view textarea').text("<img alt='" + $img.attr('alt') + "' src='" + $img.attr('src') + "' />");
            $('#preview-modal').modal('show');
            setTimeout(function () {
                $('#view textarea').focus();
                $('#view textarea').select();
            }, 500);
        });

        $('button.link').click(function () {
            var offerid = $(this).parents('tr').attr('id');
            var aff_link = $(this).attr('data-aff_link');
            var name = $('#product-data-table tr#' + offerid).find('td.name').text();
            $('.modal-title').text(name);
            $('#view').html("<textarea class='form-control'></textarea>");
            $('#view textarea').text(aff_link);
            $('#preview-modal').modal('show');
            setTimeout(function () {
                $('#view textarea').focus();
                $('#view textarea').select();
            }, 500);
        });
    });
</script>