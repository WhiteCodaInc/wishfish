<a href="#" class="dropdown-toggle" data-toggle="dropdown">
    <i class="fa fa-envelope"></i>
    <span class="label label-success">
        <?= $this->common->getTotalUnreadMsg() ?>
    </span>
</a>
<?php $inbox = $this->common->getUnreadMsg(); ?>
<ul class="dropdown-menu">
    <li class="header">You have <?= $this->common->getTotalUnreadMsg() ?> messages</li>
    <li>
        <!-- inner menu: contains the actual data -->
        <ul class="menu unreadSMS">
            <?php foreach ($inbox as $sms) { ?>
                <?php
                $img_src = ($sms->contact_avatar != "") ?
                        "http://mikhailkuznetsov.s3.amazonaws.com/" . $sms->contact_avatar :
                        base_url() . 'assets/dashboard/img/default-avatar.png';
                ?>
                <li><!-- start message -->
                    <a id="<?= $sms->sid ?>" href="<?= site_url() . 'admin/sms/inbox/' ?>">
                        <div class="pull-left">
                            <img style="width:60px;height:60px" src="<?= $img_src ?>" class="img-circle" alt="User Image"/>
                        </div>
                        <h4>
                            <?= $sms->fname . ' ' . $sms->lname ?>
                            <small><i class="fa fa-clock-o"></i></small>
                        </h4>
                        <p><?= $sms->body ?></p>
                    </a>
                </li><!-- end message -->
            <?php } ?>
        </ul>
    </li>
    <li class="footer"><a href="<?= site_url() . 'admin/sms/inbox' ?>">See All Messages</a></li>
</ul>