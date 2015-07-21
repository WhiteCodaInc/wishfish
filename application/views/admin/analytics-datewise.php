<?php foreach ($phistory as $value) { ?>
    <tr id="<?= $value->pdate ?>">
        <td><?= date('m-d-Y', strtotime($value->pdate)) ?></td>
        <td>
            <a href="#" class="totalP"><?= $value->totalP ?></a>
        </td>
        <td><?= number_format($value->totalA, 2) ?></td>
    </tr>
<?php } ?>