<?php foreach ($phistory as $value) { ?>
    <tr>
        <td><?= date('m-d-Y', strtotime($value->payment_date)) ?></td>
        <td><?= $value->totalP ?></td>
        <td><?= $value->totalA ?></td>
    </tr>
<?php } ?>