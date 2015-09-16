<?php foreach ($contacts as $value) { ?>
    <tr>
        <td><?= $value->contact_name ?></td>
        <td><?= $value->contact_email ?></td>
    </tr>
<?php } ?>