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
        <div class="row" style="margin: 10%">
            <div class="col-md-3"></div>
            <div id="wishfish-title" class="col-md-6" style="text-align: center">
                <h1>Welcome To Wish Fish</h1>
            </div>
            <div class="col-md-3"></div>
        </div>
    </section>
</aside>
<?php
$userInfo = $this->wi_common->getUserInfo($this->session->userdata('userid'));
$leftDay = $this->wi_common->getDateDiff();
?>
<?php
$time = date('Y-m-d H:i:s', gmt_to_local(time(), $userInfo->timezones, TRUE));


$hour = date('H', strtotime($time));
$minute = date('i', strtotime($time));
$second = date('s', strtotime($time));

$hour = ($userInfo->timezones == "UM9") ? $hour : $hour - 1;
?>
<script type="text/javascript" >
    var leftDay = parseInt("<?= $leftDay ?>");
    console.log(leftDay);
    if (leftDay <= 0) {
        alertify.set({
            labels: {ok: "Upgrade Plan", cancel: "Cancel"},
            buttonReverse: true
        });
        alertify.confirm("Your trial period is over & need to be upgrade your plan.\nWould you like to upgrade your plan ?", function (e) {
            if (e) {
                window.location.href = "<?= site_url() ?>app/upgrade";
            }
        });
    }
    $(function () {
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
