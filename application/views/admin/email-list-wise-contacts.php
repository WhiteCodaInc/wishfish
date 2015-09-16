<?php foreach ($contacts as $value) { ?>
    <tr>
        <td><?= $value->name ?></td>
        <td><?= $value->email ?></td>
    </tr>
<?php } ?>