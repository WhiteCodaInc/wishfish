<?php if (count($users) > 0): ?>
    <?php foreach ($users as $value) { ?>
        <tr id="<?= $value->date ?>">
            <td><?= date('m-d-Y', strtotime($value->date)) ?></td>
            <td>
                <a href="javascript:void(0);" class="totalU"><?= $value->totalU ?></a>
            </td>
            <td><?= $value->non_expired ?></td>
            <td><?= $value->expired ?></td>
            <td><?= $value->totalP ?></td>
            <td><?= $value->totalE ?></td>
            <td>$ <?= number_format($value->personal, 2) ?></td>
            <td>$ <?= number_format($value->enterprise, 2) ?></td>
            <td>$ <?= number_format($value->personal + $value->enterprise, 2) ?></td>
        </tr>
    <?php } ?>
<?php endif; ?>
