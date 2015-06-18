<a href="#" class="dropdown-toggle" data-toggle="dropdown">
    <i class="fa fa-envelope-o"></i>
    <span class="label label-success ebadge"><?= count($emails) ?></span>
</a>
<ul class="dropdown-menu">
    <li class="header">You have <span class="totalC"><?= count($emails) ?></span> emails</li>
    <li>
        <!-- inner menu: contains the actual data -->
        <ul class="menu unreadSMS">
            <?php foreach ($emails as $email) { ?>
                <li><!-- start message -->
                    <a href="<?= site_url() . 'admin/mailbox/login/' . $email['id'] ?>">
                        <?php $arr = explode("/", $email['from'], 2); ?>
                        <h4 style="margin: 0">
                            <?= $arr[0] ?>
                            <small style="float: right"><i class="fa fa-clock-o"></i><?= $email['date'] ?></small>
                        </h4>
                        <p style="margin: 0"><?= $email['subject'] ?></p>
                    </a>
                </li><!-- end message -->
            <?php } ?>
        </ul>
    </li>
    <li class="footer"><a href="#">See All emails</a></li>
</ul>

