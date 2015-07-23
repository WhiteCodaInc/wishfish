<?php foreach ($udetail as $value) { ?>
    <tr>
        <td>
            <a href="<?= site_url() . 'admin/customers/profile/' . $value->user_id ?>">
                <?= $value->name ?>
            </a>
        </td>
        <td><?= $value->email ?></td>
        <td>
            <?=
            ($value->phone != NULL) ?
                    (($value->phone_verification) ? $value->phone : "Not Verified") :
                    "N/A"
            ?>
        </td>
        <td><?= $value->plan_name ?></td>
        <td><?= date('m-d-Y H:i:s', strtotime($value->register_date)) ?></td>
        <td>
            <?php if ($value->status): ?>
                <span class="btn btn-success btn-xs">Active</span>
            <?php else : ?>
                <span class="btn btn-danger btn-xs">Deactivate</span>
            <?php endif; ?>
        </td>
    </tr>
<?php } ?>