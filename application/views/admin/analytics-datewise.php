<table id="payment-data-table" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Payment Date </th>
            <th>Total Payment</th>
            <th>Total Amount</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($phistory as $value) { ?>
            <tr>
                <td><?= date('m-d-Y', strtotime($value->pdate)) ?></td>
                <td><?= $value->totalP ?></td>
                <td><?= $value->totalA ?></td>
            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <th>Payment Date </th>
            <th>Total Payment</th>
            <th>Total Amount</th>
        </tr>
    </tfoot>
</table>
<!-- DATA TABES SCRIPT -->
<script src="<?= base_url() ?>assets/dashboard/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/dashboard/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script type="text/javascript">
    $(function () {
        $("#payment-data-table").dataTable({
            aLengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            aoColumnDefs: [{
                    targets: 'no-sort',
                    bSortable: false,
                    aTargets: [0, 1, 2]
                }],
            iDisplayLength: 10,
        });
    });
</script>