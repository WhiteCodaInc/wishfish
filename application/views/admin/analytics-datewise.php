<style type="text/css">
    #payment-data-table tr td,#payment-data-table tr th{
        text-align: center;
    }
</style>
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