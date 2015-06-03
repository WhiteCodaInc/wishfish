<?php foreach ($inbox as $key => $sms) { ?>
    <?php
    $img_src = "";
    $img_src = ($sms->contact_avatar != "") ?
            "http://mikhailkuznetsov.s3.amazonaws.com/" . $sms->contact_avatar :
            base_url() . 'assets/dashboard/img/default-avatar.png';
    ?>
    <tr id="<?= $sms->from ?>">
        <td style="width:15%">
            <a href="<?= site_url() . 'admin/contacts/profile/' . $sms->contact_id ?>" class="name">
                <img style="width:60px;height:60px" src="<?= $img_src ?>" class="img-circle" alt="User Image" />
            </a>
        </td>
        <td style="width:25%">
            <a href="<?= site_url() . 'admin/contacts/profile/' . $sms->contact_id ?>" class="name">
                <?= $sms->fname . ' ' . $sms->lname ?>
            </a>
        </td>
        <td style="width:40%" ><?= $sms->body ?></td>
        <td style="width:20%" >
            <?php if ($sms->status == 0) { ?>
                <span class="btn btn-success btn-xs">Replied</span>
            <?php } else if ($sms->status == 1) { ?>
                <span class="btn btn-danger btn-xs">Unread</span>
            <?php } else if ($sms->status == 2) { ?>
                <span class="btn btn-warning btn-xs">Read</span>
            <?php } ?>
        </td>
    </tr>
<?php } ?>