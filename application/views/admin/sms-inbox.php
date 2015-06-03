<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<style type="text/css">
    #inbox-data-table tr td,#inbox-data-table tr th{
        text-align: center;
    }
    #inbox-data-table tr td{
        cursor:default;
    }
    .reply{
        position: absolute;
        top: 40%;
        left: 50%;
    }
</style>
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header" style="display: none">
        <h1 style="display: none">
            SMS Inbox
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-7" >
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">SMS Inbox</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive" id="data-panel">
                        <table id="inbox-data-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Profile</th>
                                    <th>Contact Name</th>
                                    <th>Message</th>
                                    <th>Status</th>
                                    <!--<th>Action</th>-->
                                </tr>
                            </thead>
                            <tbody>
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
                                        <td style="width:20%" class="status">
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
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Profile</th>
                                    <th>Contact Name</th>
                                    <th>Message</th>
                                    <th>Status</th>
                                    <!--<th>Action</th>-->
                                </tr>
                            </tfoot>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
            <div class="col-md-5" id="chatbox">
                <!-- Chat box -->
                <div style="display:none" class="box box-success effect">
                    <div class="box-header">
                        <i class="fa fa-comments-o"></i>
                        <h3 class="box-title">Conversation</h3>
                    </div>
                    <div class="box-body chat" id="chat-box">
                    </div>
                    <div class="box-footer">
                        <form id="replyForm" method="post">
                            <div class="form-group">
                                <textarea id="reply" name="msg" class="form-control" rows="3" placeholder="Type message..."></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <button name="send" type="button" class="btn btn-success">Send</button>
                                </div>
                                <div style="display:none;" id="loadReply" class="col-md-2">
                                    <img src="<?= base_url() ?>assets/dashboard/img/load.GIF" alt="" />
                                </div>
                            </div>
                            <input id="from" name="to" value="" type="hidden" />
                        </form>
                    </div>
                </div>
                <!-- /.box (chat box) -->
            </div>
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<?php $msg = $this->input->get('msg'); ?>
<?php
switch ($msg) {
    case "send":
        $m = "SMS Successfully Delivered..!";
        $t = "success";
        break;
    case "fail":
        $m = "SMS Sending Failed..!";
        $t = "error";
        break;
    default:
        $m = 0;
        break;
}
?>
<script type="text/javascript">
<?php if ($msg): ?>
        alertify.<?= $t ?>("<?= $m ?>");
<?php endif; ?>
</script>

<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<!-- DATA TABES SCRIPTS -->
<script src="<?= base_url() ?>assets/dashboard/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/dashboard/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

<!-- page script -->
<script type="text/javascript">


    $(function () {
        $("#inbox-data-table").dataTable({
            aLengthMenu: [
                [25, 50, 100, 200, -1],
                [25, 50, 100, 200, "All"]
            ],
            iDisplayLength: -1,
            //aaSorting: [[1, 'asc']]
        });
    });
    $(function () {

        function scrollDown() {
            $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
        }

        function runEffect() {
            var options = {};
            // run the effect
            $(".effect").toggle("slide", options, 500);
        }
        $('#inbox-data-table tbody tr').click(function () {
            $msg = $(this).find('td.status > span').text();
            if ($msg == "Unread") {
                $(this).find('td.status > span').removeClass('btn-danger');
                $(this).find('td.status > span').addClass('btn-warning');
                $(this).find('td.status > span').text("Read");
            }

            $(".effect").hide();
            var from = $(this).attr('id');
            $('#from').val(from);
            var loadMsg = "<div id='loadMsg' class='reply'><img src='<?= base_url() ?>assets/dashboard/img/load.GIF' alt='' /></div>";
            $('#chat-box').html(loadMsg);
            $.ajax({
                type: 'POST',
                data: {from: from},
                url: "<?= site_url() ?>admin/sms/viewconversation",
                success: function (data, textStatus, jqXHR) {
                    $('#chat-box').html(data);
                    scrollDown();
                }
            });
            runEffect();
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
//        setInterval(function () {
//            $.ajax({
//                url: "<?= site_url() ?>admin/sms/smsNotification",
//                success: function (data, textStatus, jqXHR) {
//                    $('li.sms-notification').html(data);
//                }
//            });
//            $.ajax({
//                url: "<?= site_url() ?>admin/sms/inbox?type=ajax",
//                success: function (data, textStatus, jqXHR) {
//                    $('#inbox-data-table tbody').html(data);
//                }
//            });
//        }, 30000);

        $('button[name="send"]').bind('click', function () {
            var from = $('#from').val();
            var msg = $('#reply').val();
            $('#loadReply').css('display', 'block');
            $.ajax({
                type: 'POST',
                data: {to: from, msg: msg},
                url: "<?= site_url() ?>admin/sms/sendSMS",
                success: function (data, textStatus, jqXHR) {
                    $('#loadReply').css('display', 'none');
                    $('#reply').val('');
                    if (data == 0) {
                        alertify.error("SMS Sending Failed..!");
                    } else {
                        $('#inbox-data-table tbody').html(data);
                        //-------------------chat-Box----------------------//
                        $clone = $('#chat-box').children('div.out:first').clone();
                        $time = "<i class='fa fa-clock-o'></i>";
                        $time = $time + "<?= date('D,j M Y H:i:s') ?>";
                        $clone.find('small.text-muted').html($time);
                        $clone.find('span.body').html(msg);
                        $('#chat-box').append($clone);
                        alertify.success("SMS Successfully Delivered..!");
                    }
                }
            });
        });
    });
</script>