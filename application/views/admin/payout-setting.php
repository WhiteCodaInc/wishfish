<style type="text/css">
    #payout-data-table tr td,#payout-data-table tr th{
        text-align: center;
    }
</style>
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="display: none">
            Payout Setting
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box" >
                    <div class="box-header">
                        <h3 class="box-title">Payout Setting</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive" id="data-panel">
                        <table id="payout-data-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Payout Type</th>
                                    <th>Immediate Purchase</th>
                                    <th>Recurring Purchase</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($setting as $value) { ?>
                                    <tr>
                                        <td><?= strtoupper($value->type) ?></td>
                                        <td><?= $value->normal ?> %</td>
                                        <td><?= $value->recurring ?> %</td>
                                        <td>
                                            <a href="javascript:void(0);" 
                                               data-payout_id ="<?= $value->payout_id ?>" 
                                               data-normal ="<?= $value->normal ?>" 
                                               data-recurring ="<?= $value->recurring ?>" 
                                               class="create btn btn-primary btn-xs edit"
                                               data-toggle="modal"
                                               data-target="#payout-modal">
                                                <i class="fa fa-pencil-square-o"></i> Edit
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Payout Type</th>
                                    <th>Immediate Purchase</th>
                                    <th>Recurring Purchase</th>
                                    <th>Edit</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div><!-- /.box-body -->
                    </form>
                </div><!-- /.box -->
            </div>
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->
</div><!-- ./wrapper -->


<!-------------------------------Card Detail Model------------------------------------>
<div class="modal fade" id="payout-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 400px">
        <div class="modal-content">
            <form id="payoutForm" role="form" action="<?= site_url() ?>admin/payout/updateSetting"  method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Payout On Immediate Purchase </label>
                        <input value=""  type="number" name="normal" class="form-control" placeholder="PER(%)" required="" />
                    </div>
                    <div class="form-group">
                        <label>Payout On Recurring Purchase </label>
                        <input value=""  type="number" name="recurring" class="form-control" placeholder="PER(%)" required="" />
                    </div>
                    <div class="form-group">
                        <span style="color: red;" id="msgPayout"></span>
                    </div>
                </div>
                <div class="modal-footer clearfix">
                    <div class="row">
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary pull-left">Save</button>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-danger discard" data-dismiss="modal">
                                <i class="fa fa-times"></i> Discard
                            </button>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="payoutid" value="" />
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!------------------------------------------------------------------------>



<!-- DATA TABES SCRIPT -->
<script src="<?= base_url() ?>assets/dashboard/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/dashboard/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

<!-- page script -->
<script type="text/javascript">
    $(function () {
        $("#payout-data-table").dataTable({
            bSort: false
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {

        $('a.edit').click(function () {
            $('input[name="payoutid"]').val($(this).attr('data-payout_id'));
            $('input[name="normal"]').val($(this).attr('data-normal'));
            $('input[name="recurring"]').val($(this).attr('data-recurring'));
        });

        $('#payoutForm').on('submit', function () {
            $form = $(this);
            var normal = $('input[name="normal"]').val();
            var recur = $('input[name="recurring"]').val();

            if (normal < 0 || normal > 100) {
                $('#msgPayout').text("Invalid Immediate Purchase Value..!");
                return false;
            } else {
                $('#msgPayout').empty();
            }
            if (recur < 0 || recur > 100) {
                $('#msgPayout').text("Invalid Recurring Purchase Value..!");
                return false;
            } else {
                $('#msgPayout').empty();
            }
        });
    });
</script>