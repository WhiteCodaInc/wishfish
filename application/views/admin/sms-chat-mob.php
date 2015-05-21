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
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Conversation</h1>
    </section>
    <?php
    $from_src = ($contactInfo->contact_avatar != "") ?
            "http://mikhailkuznetsov.s3.amazonaws.com/" . $contactInfo->contact_avatar :
            base_url() . 'assets/dashboard/img/default-avatar.png';

    $avatar = $this->session->userdata('avatar');
    $to_src = ($avatar != "") ?
            "http://mikhailkuznetsov.s3.amazonaws.com/" . $avatar :
            base_url() . 'assets/dashboard/img/default-avatar.png';
    ?>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3"></div>
            <!-- left column -->
            <div class="col-md-6">

                <div  class="box box-success effect">
                    <div class="box-header">
                        <i class="fa fa-comments-o"></i>
                        <h3 class="box-title">Conversation</h3>
                    </div>
                    <div class="box-body chat" id="chat-box">
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
                                        <?= str_ireplace("<p>,</p>", "", $sms->body) ?>
                                    </p>
                                </div><!-- /.item -->	
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <div class="box-footer">
                        <form method="post" action="<?= site_url() ?>admin/sms/sendSMS">
                            <div class="form-group">
                                <textarea id="reply" name="msg" class="form-control" rows="3" placeholder="Type message..."></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-success">Send</button>
                                    <a href="<?= site_url() ?>admin/sms/inbox?ver=mobile" class="btn btn-danger">
                                        Back
                                    </a>
                                </div>                                
                            </div>
                            <input name="to" value="<?= $contactInfo->phone ?>" type="hidden" />
                            <input name="ver" value="mobile" type="hidden" />
                        </form>
                    </div>
                </div>

            </div>
            <div class="col-md-3"></div>
            <!-- right column -->
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->
</div><!-- ./wrapper -->
<script type="text/javascript">
    $(document).ready(function () {
        setTimeout(function () {
            $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
        }, 1000);
    });
</script>