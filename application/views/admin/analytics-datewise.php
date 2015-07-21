<?php foreach ($phistory as $value) { ?>
    <tr>
        <td><?= date('m-d-Y', strtotime($value->pdate)) ?></td>
        <td><?= $value->totalP ?></td>
        <td><?= $value->totalA ?></td>
    </tr>
<?php } ?>