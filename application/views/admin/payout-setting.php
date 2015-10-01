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
                                            <a href="<?= site_url() ?>admin/pay/editContactGroup/<?= $value->group_id ?>" class="btn bg-navy btn-xs">
                                                <i class="fa fa-edit"></i>
                                                Edit
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
<?php $msg = $this->input->get('msg'); ?>

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
    });
</script>