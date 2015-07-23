<?php
print_r($users);
echo count($users);
die();
?>
<?php if (count($users) > 0): ?>
    <?php foreach ($users as $value) { ?>
        <tr id="<?= $value->date ?>">
            <td><?= date('m-d-Y', strtotime($value->date)) ?></td>
            <td>

                <a href="javascript:void(0);" class="totalU"><?= $value->totalU ?></a>

            </td>
        </tr>
    <?php } ?>
<?php else: ?>
    <tr class="odd">
        <td valign="top" colspan="2" class="dataTables_empty">
            No data available in table
        </td>
    </tr>
<?php endif; ?>
