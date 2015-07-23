<?php if (count($phistory) > 0): ?>
    <?php foreach ($phistory as $value) { ?>
        <tr id="<?= $value->pdate ?>">
            <td><?= date('m-d-Y', strtotime($value->pdate)) ?></td>
            <td>
                <a href="javascript:void(0);" class="totalP"><?= $value->totalP ?></a>
            </td>
            <td>$ <?= number_format($value->totalA, 2) ?></td>
        </tr>
    <?php } ?>
<?php else: ?>
    <tr class="odd">
        <td valign="top" colspan="2" class="dataTables_empty">
            No data available in table
        </td>
    </tr>
<?php endif; ?>
