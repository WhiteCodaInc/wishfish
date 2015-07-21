<?php foreach ($phistory as $value) { ?>
    <tr>
        <td><?= date('m-d-Y', strtotime($value->pdate)) ?></td>
        <td><?= $value->totalP ?></td>
        <td><?= number_format($value->totalA, 2) ?></td>
    </tr>
<?php } ?>