<?php foreach ($users as $value) { ?>
    <tr id="<?= $value->rdate ?>">
        <td><?= date('m-d-Y', strtotime($value->rdate)) ?></td>
        <td>
            <a href="javascript:void(0);" class="totalU"><?= $value->totalU ?></a>
        </td>
        <td></td>
        <td>$ <?= number_format($value->totalA, 2) ?></td>
    </tr>
<?php } ?>