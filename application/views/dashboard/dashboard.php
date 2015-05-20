<!--<link rel="canonical" href="http://www.paulrhayes.com/experiments/clock/" />-->
<link rel="stylesheet" href="<?= base_url() ?>assets/dashboard/js/plugins/clock/css/experiment.css" />
<aside class="right-side" >
    <section class="content-header">
        <h1>
            Dashboard
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row m-bot15">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>
                            <span><?= count($totalD) ?></span>
                        </h3>
                        <p>
                            Today
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                </div>
            </div><!-- ./col -->

            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>
                            <span><?= count($totalW) ?></span>
                        </h3>
                        <p>
                            This Week
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>

                </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>
                            <span><?= count($totalM) ?></span>
                        </h3>
                        <p>
                            This Month
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>
                            <span id="totalY">
                                <?= count($totalY) ?>
                            </span>
                        </h3>
                        <p>
                            This Year
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>

                </div>
            </div><!-- ./col -->
        </div><!-- /.row -->
        <div class="row ui-sortable">
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group-lg">
                            <div class="box box-primary">
                                <div class="box-header ui-sortable-handle" style="cursor: move;">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title">TODAY</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <ul class="todo-list ui-sortable">
                                        <?php foreach ($totalD as $value) { ?>
                                            <li>
                                                <a href="<?= site_url() ?>app/calender?date=<?= $value->date ?>"
                                                   <!-- drag handle -->
                                                   <span class="handle ui-sortable-handle">
                                                        <i class="fa fa-ellipsis-v"></i>
                                                        <i class="fa fa-ellipsis-v"></i>
                                                    </span>
                                                    <!-- todo text -->
                                                    <span class="text"><?= $value->event ?></span>
                                                    <!-- Emphasis label -->
                                                    <small class="label" style="background-color: <?= $value->color ?>">
                                                        <i class="fa fa-clock-o"></i>
                                                        <?= $value->format_date ?>
                                                    </small>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div><!-- /.box-body -->
                            </div>
                        </div>
                        <div class="form-group-lg">
                            <div class="box box-primary">
                                <div class="box-header ui-sortable-handle" style="cursor: move;">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title">THIS WEEK</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <ul class="todo-list ui-sortable">
                                        <?php foreach ($totalW as $value) { ?>
                                            <li>
                                                <a href="<?= site_url() ?>app/calender?date=<?= $value->date ?>"
                                                   <!-- drag handle -->
                                                   <span class="handle ui-sortable-handle">
                                                        <i class="fa fa-ellipsis-v"></i>
                                                        <i class="fa fa-ellipsis-v"></i>
                                                    </span>
                                                    <!-- todo text -->
                                                    <span class="text"><?= $value->event ?></span>
                                                    <!-- Emphasis label -->
                                                    <small class="label" style="background-color: <?= $value->color ?>">
                                                        <i class="fa fa-clock-o"></i>
                                                        <?= $value->format_date ?>
                                                    </small>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div><!-- /.box-body -->
                            </div>
                        </div>
                        <div class="form-group-lg">
                            <div class="box box-primary">
                                <div class="box-header ui-sortable-handle" style="cursor: move;">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title">THIS MONTH</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <ul class="todo-list ui-sortable">
                                        <?php foreach ($totalM as $value) { ?>
                                            <li>
                                                <a href="<?= site_url() ?>app/calender?date=<?= $value->date ?>"
                                                   <!-- drag handle -->
                                                   <span class="handle ui-sortable-handle">
                                                        <i class="fa fa-ellipsis-v"></i>
                                                        <i class="fa fa-ellipsis-v"></i>
                                                    </span>
                                                    <!-- todo text -->
                                                    <span class="text"><?= $value->event ?></span>
                                                    <!-- Emphasis label -->
                                                    <small class="label" style="background-color: <?= $value->color ?>">
                                                        <i class="fa fa-clock-o"></i>
                                                        <?= $value->format_date ?>
                                                    </small>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div><!-- /.box-body -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header ui-sortable-handle" style="cursor: move;">
                        <i class="fa fa-clock-o"></i>
                        <h3 class="box-title">Your Current Time</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div id="clock">
                            <div id="hour"><img src="<?= base_url() ?>assets/dashboard/js/plugins/clock/images/hourHand.png" /></div>
                            <div id="minute"><img src="<?= base_url() ?>assets/dashboard/js/plugins/clock/images/minuteHand.png" /></div>
                            <div id="second"><img src="<?= base_url() ?>assets/dashboard/js/plugins/clock/images/secondHand.png" /></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header ui-sortable-handle" style="cursor: move;">
                        <i class="ion ion-clipboard"></i>
                        <h3 class="box-title">Quick Link</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <a  href="<?= site_url() ?>app/contacts/addContact" class="btn btn-primary btn-sm create">
                                    <i class="fa fa-plus"></i>
                                    Create New Contact
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a  href="<?= site_url() ?>app/calender" class="btn btn-info btn-sm create">
                                    <i class="fa fa-plus"></i>
                                    Create New Event
                                </a>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-md-6">
                                <a  href="<?= site_url() ?>app/sms_template/addTemplate" class="btn btn-warning btn-sm create">
                                    <i class="fa fa-plus"></i>
                                    Create SMS Template
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="<?= site_url() ?>app/email_template/addTemplate" class="btn btn-danger btn-sm create">
                                    <i class="fa fa-plus"></i>
                                    Create Email Template
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box box-solid booster">
            <div class="box-header">
                <h3>Profile <?= $per ?>% completed</h3>
                <div class="progress progress-striped">
                    <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="<?= $per ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $per ?>%">
                        <span class="sr-only">40% Complete (success)</span>
                    </div>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body setup">
                <ul>
                    <li class="task-success">
                        <a class="task-success" href="javascript:void(0)">
                            <i class="fa fa-check-square"></i>
                            Setup Your Account
                        </a>
                    </li>
                    <li>
                        <a class="<?= ($upload) ? "task-success" : "" ?>" href="javascript:void(0)" id="upload" data-toggle="modal" data-target="<?= (!$upload) ? "#uploadSetup" : "" ?>">
                            <i class="fa <?= ($upload) ? "fa-check-square" : "fa-square-o" ?> i_upload"></i>
                            Upload Your Photo
                        </a>
                    </li>
                    <li>
                        <a class="<?= ($profile) ? "task-success" : "" ?>" href="javascript:void(0)" id="profile" data-toggle="modal" data-target="<?= (!$profile) ? "#profileSetup" : "" ?>">
                            <i class="fa <?= ($profile) ? "fa-check-square" : "fa-square-o" ?> i_profile"></i>
                            Complete Your Profile
                        </a>
                    </li>
                    <li>
                        <a class="<?= ($contact) ? "task-success" : "" ?>" href="javascript:void(0)" id="contact" data-toggle="modal" data-target="<?= (!$contact) ? "#contactSetup" : "" ?>">
                            <i class="fa <?= ($contact) ? "fa-check-square" : "fa-square-o" ?> i_contact"></i>
                            Add Contact
                        </a>
                    </li>
                    <li>
                        <a class="<?= ($event) ? "task-success" : "" ?>" href="javascript:void(0)" id="event" data-toggle="modal" data-target="<?= (!$event) ? "#eventSetup" : "" ?>">
                            <i class="fa <?= ($event) ? "fa-check-square" : "fa-square-o" ?> i_event"></i>
                            Schedule an Event
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!---------------------------Complete Your Profile------------------------------->
        <div class="modal fade" id="profileSetup" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 400px">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Complete Your Profile</h4>
                    </div>
                    <div class="modal-body">
                        <form id="profileForm"  method="post">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label>Country Code</label>
                                                <select name="code" class="form-control">
                                                    <option value="+1">+1</option>
                                                </select>
                                            </div>
                                            <?php
                                            $phone = (isset($user)) ?
                                                    substr($user->phone, -10) : "";
                                            ?>
                                            <div class="col-sm-8">
                                                <label>Phone Number</label>
                                                <i title="The coolest thing about Wish-Fish is that you can setup text message notification for yourself,These way you never miss an important event like a birthday or anniversary! We will only message you with the notifications you set,We promise." class="fa fa-question-circle"></i>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-phone"></i>
                                                    </div>
                                                    <input style="z-index: 0" value="<?= $phone ?>" type="text" name="phone" class="form-control" placeholder="Enter Phone Number" data-inputmask='"mask": "(999) 999-9999"' data-mask/>
                                                </div><!-- /.input group -->
                                            </div>
                                        </div>
                                    </div><!-- /.form group -->
                                    <div class="form-group">
                                        <label>Birthday</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input style="z-index: 0;" name="birthday" value="<?= isset($user->birthday) ? $this->common->getUTCDate($user->birthday) : NULL ?>"  class="form-control form-control-inline input-medium default-date-picker" size="16" type="text">
                                        </div><!-- /.input group -->
                                    </div><!-- /.form group -->
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <img  src="<?= base_url() ?>assets/dashboard/img/load.GIF" alt="" class="load" style="display: none" />
                                    <span style="display: none" class="msg"></span>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer clearfix">
                        <div class="row">
                            <div class="col-md-3">
                                <button type="button" id="profileBtn" class="btn btn-primary pull-left">Send</button>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-danger discard" data-dismiss="modal"><i class="fa fa-times"></i> Discard</button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!-------------------------End Complete Your Profile------------------------------>

        <!-------------------------Upload Your Profile Photo------------------------------>
        <?php
        $path = $this->session->userdata('profile_pic');
        $img_src = ($path != "") ?
                "http://mikhailkuznetsov.s3.amazonaws.com/" . $path :
                base_url() . 'assets/dashboard/img/default-avatar.png';
        ?>
        <div class="modal fade" id="uploadSetup" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 400px">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Complete Your Profile</h4>
                    </div>
                    <div class="modal-body">
                        <form id="uploadForm"  method="post">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div  class="image" style="text-align: center">
                                            <img id="profile_previewing" style="width: 100px;height: 100px"  src="<?= $img_src ?>" class="img-circle" alt="User Image" />
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <label for="profile pic">Profile Picture</label>
                                        <input title="Add a photo so we can recognize you !" name="profile_pic"  type="file" id="profilePic" class="form-control" />
                                        <span id="error_message"></span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer clearfix">
                        <div class="row">
                            <div class="col-md-3">
                                <button type="button" id="uploadBtn" class="btn btn-primary pull-left">Send</button>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-danger discard" data-dismiss="modal"><i class="fa fa-times"></i> Discard</button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!-----------------------End Upload Your Profile Photo---------------------------->

    </section>
</aside>
<?php $userInfo = $this->common->getUserInfo($this->session->userdata('userid')); ?>
<?php
$time = date('Y-m-d H:i:s', gmt_to_local(time(), $userInfo->timezones, TRUE));


$hour = date('H', strtotime($time));
$minute = date('i', strtotime($time));
$second = date('s', strtotime($time));

$hour = ($userInfo->timezones == "UM9") ? $hour : $hour - 1;
?>
<script type="text/javascript" >
    $(function () {
        $('.default-date-picker').datepicker({
            format: "<?= $this->session->userdata('date_format') ?>",
            todayBtn: "linked",
            autoclose: true,
            todayHighlight: true
        });

        var props = 'transform WebkitTransform MozTransform OTransform msTransform'.split(' '),
                prop,
                el = document.createElement('div');
        for (var i = 0, l = props.length; i < l; i++) {
            if (typeof el.style[props[i]] !== "undefined") {
                prop = props[i];
                break;
            }
        }
        startClock();
        function startClock() {
            var angle = 360 / 60,
                    hour = <?= $hour ?> % 12,
                    minute = <?= $minute ?>,
                    second = <?= $second ?>;

            setInterval(function () {
                second++;
                if (second > 59) {
                    minute++;
                    second = 0;
                }
                if (minute > 59) {
                    hour++;
                    minute = 0;
                }
                hourAngle = (360 / 12) * hour + (360 / (12 * 60)) * minute;
                if (prop) {
                    $('#minute')[0].style[prop] = 'rotate(' + angle * minute + 'deg)';
                    $('#second')[0].style[prop] = 'rotate(' + angle * second + 'deg)';
                    $('#hour')[0].style[prop] = 'rotate(' + hourAngle + 'deg)';
                }
            }, 1000);
        }
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.setup a').on('click', function () {
            var id = $(this).prop('id');
            switch (id) {
                case "upload":
                    $('#setup .modal-title').text("Complete Your Profile");
                    break;
                case "profile":
                    $('#setup .modal-title').text("Upload Your Profile Photo");
                    break;
                case "contact":
                    $('#setup .modal-title').text("Complete Your Profile");
                    break;
                case "event":
                    $('#setup .modal-title').text("Complete Your Profile");
                    break;
            }
        });
        $("#uploadForm input:file").change(function () {
            $("#uploadForm #error_message").empty(); // To remove the previous error message
            var file = this.files[0];
            var imagefile = file.type;
            var match = ["image/jpeg", "image/png", "image/jpg"];
            if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2])))
            {
                $("#uploadForm #error_message").html("<p id='error' style='color:red'>Please Select A valid Image File.<br>" + "<span id='error_message'>Only jpeg, jpg and png Images type allowed</span></p>");
                return false;
            }
            else
            {
                var reader = new FileReader();
                reader.onload = imageIsLoaded;
                reader.readAsDataURL(this.files[0]);
            }
        });

        function imageIsLoaded(e) {
            $("#uploadForm #profilePic").css("color", "green");
            $("#uploadForm #profile_previewing").attr('src', e.target.result);
        }
    });
</script>
