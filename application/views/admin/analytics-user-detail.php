<?php foreach ($phistory as $value) { ?>
    <tr>
        <td>
            <a href="<?= site_url() ?>admin/customers/profile/<?= $value->user_id ?>">
                <?= $value->name ?>
            </a>
        </td>
        <td><?= $value->email ?></td>
        <td><?= $value->plan_name ?></td>
        <td><?= $value->gateway ?></td>
        <td>$ <?= number_format($value->mc_gross, 2) ?></td>
    </tr>
<?php } ?>