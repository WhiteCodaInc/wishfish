<?php if (count($contacts)): ?>
    <?php foreach ($contacts as $key => $value) { ?>
        <tr>
            <td>
                <div>
                    <label>
                        <input type="checkbox" name="contact[<?= $key ?>]" value="<?= $key ?>"/>
                    </label>
                </div>
            </td>
            <td>
                <?= ($value['name'] != "") ? $value['name'] : 'N/A' ?>
                <input type="hidden" name="name[<?= $key ?>]" value="<?= $value['name'] ?>" />
            </td>
            <td>
                <?= ($value['email'] != "") ? $value['email'] : 'N/A' ?>
                <input type="hidden" name="email[<?= $key ?>]" value="<?= $value['email'] ?>" />
            </td>
            <td>
                <?= ($value['phone'] != "") ? $value['phone'] : 'N/A' ?>
                <input type="hidden" name="phone[<?= $key ?>]" value="<?= $value['phone'] ?>" />
            </td>
        </tr>
    <?php } ?>
    <?php
else:
    echo '0';
endif;
?>