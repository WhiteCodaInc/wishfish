<?php
$from_src = ($contactInfo->contact_avatar != "") ?
        "http://mikhailkuznetsov.s3.amazonaws.com/" . $contactInfo->contact_avatar :
        base_url() . 'assets/dashboard/img/default-avatar.png';

$avatar = $this->session->userdata('avatar');
$to_src = ($avatar != "") ?
        "http://mikhailkuznetsov.s3.amazonaws.com/" . $avatar :
        base_url() . 'assets/dashboard/img/default-avatar.png';
?>
<style>
    .in{
        background-color: aliceblue;
        padding: 15px 0;
    }
    .out{
        background-color: antiquewhite;
        padding: 15px 0;
    }
</style>
<?php
foreach ($messages as $sms) {
    if (($sms->from == $contactInfo->phone && $sms->to == "+17606422366") ||
            ($sms->from == "+17606422366" && $sms->to == $contactInfo->phone)) {
        $cls = ($sms->direction == "inbound") ? "in" : "out";
        $path = ($sms->direction == "inbound") ? $from_src : $to_src;
        $name = ($sms->direction == "inbound") ?
                $contactInfo->fname . ' ' . $contactInfo->lname :
                $this->session->userdata('name');
        ?>
        <!-- chat item -->
        <div class="item <?= $cls ?>">
            <img src="<?= $path ?>" alt="user image" class="online"/>
            <p class="message">
                <a href="#" class="name">
                    <small class="text-muted pull-right">
                        <i class="fa fa-clock-o"></i>
                        <?= substr($sms->date_sent, 0, -5) ?>
                    </small>
                    <?= $name ?>
                </a>
            <span class="body">
                <?= str_ireplace("<p>,</p>", "", $sms->body) ?>
            </span>

        </p>
        </div><!-- /.item -->	
        <?php
    }
}
?>
</div><!-- /.chat -->