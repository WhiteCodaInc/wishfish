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
                        <form id="profileForm">
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
                                            <div class="col-sm-8">
                                                <label>Phone Number</label>
                                                <i title="The coolest thing about Wish-Fish is that you can setup text message notification for yourself,These way you never miss an important event like a birthday or anniversary! We will only message you with the notifications you set,We promise." class="fa fa-question-circle"></i>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-phone"></i>
                                                    </div>
                                                    <input style="z-index: 0" type="text" name="phone" class="form-control" placeholder="Enter Phone Number" data-inputmask='"mask": "(999) 999-9999"' data-mask/>
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
                                            <input style="z-index: 0;" name="birthday" class="form-control form-control-inline input-medium default-date-picker" size="16" type="text">
                                        </div><!-- /.input group -->
                                    </div><!-- /.form group -->
                                </div>
                            </div>
                            <span id="msgProfile"></span>
                        </form>
                    </div>
                    <div class="modal-footer clearfix">
                        <div class="row">
                            <div class="col-md-3">
                                <button type="button" id="profileBtn" class="btn btn-primary pull-left">Save Profile</button>
                            </div>
                            <div class="col-md-2">
                                <div id="loadProfile" style="display: none">
                                    <img src="<?= base_url() ?>assets/dashboard/img/load.GIF" alt="" />
                                </div>
                            </div>
                            <div class="col-md-7" style="text-align: right">
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
                        <h4 class="modal-title">Upload Your Profile Picture</h4>
                    </div>
                    <form id="uploadForm" action=""  method="post" enctype="multipart/form-data">
                        <div class="modal-body">

                            <div class="form-group">
                                <div class="row" style="margin-bottom: 5%">
                                    <div class="col-md-12" style="text-align: center">
                                        <div  class="image" style="text-align: center">
                                            <img id="profile_previewing" style="width: 100px;height: 100px"  src="<?= $img_src ?>" class="img-circle" alt="User Image" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12" style="text-align: center">
                                        <input title="Add a photo so we can recognize you !" name="profile_pic"  type="file" id="profilePic" class="form-control" />
                                        <span id="error_message"></span>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer clearfix">
                            <div class="row">
                                <div class="col-md-3">
                                    <button type="submit" id="uploadBtn" class="btn btn-primary pull-left">Upload</button>
                                </div>
                                <div class="col-md-2">
                                    <div id="loadUpload" style="display: none">
                                        <img src="<?= base_url() ?>assets/dashboard/img/load.GIF" alt="" />
                                    </div>
                                </div>
                                <div class="col-md-7" style="text-align: right">
                                    <button type="button" class="btn btn-danger discard" data-dismiss="modal"><i class="fa fa-times"></i> Discard</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!-----------------------End Upload Your Profile Photo---------------------------->

        <!---------------------------Add New Contact------------------------------->
        <div class="modal fade" id="contactSetup" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 400px">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Add New Contact</h4>
                    </div>
                    <div class="modal-body">
                        <form id="contactForm" method="post">
                            <div id="add-name" class="form-group">
                                <div class="row">
                                    <div  class="col-md-6">
                                        <label>First Name</label>
                                        <input type="text" name="fname" autofocus="autofocus" class="form-control" placeholder="First Name" required=""/>
                                    </div>
                                    <div  class="col-md-6">
                                        <label>Last Name</label>
                                        <input type="text" name="lname" class="form-control" placeholder="Last Name" required=""/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" id="add-birthday">
                                <label>Birthday</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input style="z-index: 0" name="birthday" placeholder="Enter Birthdate" value="<?= isset($contacts) ? $this->common->getUTCDate($contacts->birthday) : '' ?>"  class="form-control form-control-inline input-medium default-date-picker" size="16" type="text" required="">
                                </div><!-- /.input group -->
                            </div><!-- /.form group -->
                            <div class="form-group" id="add-phone">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label>Country Code</label>
                                        <select name="code" class="form-control">
                                            <option value="+1">+1</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-8">
                                        <label>Phone Number </label>
                                        <i title="You can send your contact a pre scheduled text message.In case you`r busy or vacation,so you don`t miss an important date ! (its kind of magical!)" class="fa fa-question-circle"></i>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-phone"></i>
                                            </div>
                                            <input name="phone" type="text" class="form-control"  placeholder="Enter Phone Number" data-inputmask='"mask": "(999) 999-9999"' data-mask required=""/>
                                        </div><!-- /.input group -->
                                    </div>
                                </div>
                            </div><!-- /.form group -->
                            <div class="form-group">
                                <label for="password">Email</label>
                                <input name="email" type="email" class="form-control"  placeholder="Enter Their Email">
                            </div>
                            <span id="msgProfile"></span>
                            <input value="" name="zodiac" type="hidden" class="form-control" >
                            <input value="" name="age" type="hidden" class="form-control" >
                        </form>
                    </div>
                    <div class="modal-footer clearfix">
                        <div class="row">
                            <div class="col-md-3">
                                <button type="button" id="contactBtn" class="btn btn-primary pull-left">Save Profile</button>
                            </div>
                            <div class="col-md-2">
                                <div id="loadContact" style="display: none">
                                    <img src="<?= base_url() ?>assets/dashboard/img/load.GIF" alt="" />
                                </div>
                            </div>
                            <div class="col-md-7" style="text-align: right">
                                <button type="button" class="btn btn-danger discard" data-dismiss="modal"><i class="fa fa-times"></i> Discard</button>
                            </div>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!-------------------------End Add Contact------------------------------>

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

        $('#contactForm .default-date-picker').datepicker({
            format: "<?= $this->session->userdata('date_format') ?>",
            todayBtn: "linked",
            autoclose: true,
            todayHighlight: true
        }).on('changeDate', function (ev) {
            $('#contactForm input[name="birthday"]').focusout();
        });

        $('#profileForm .default-date-picker').datepicker({
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
        var isValid = true;
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

        /**************************Upload Profile Pic**************************/
        $("#uploadForm input:file").change(function () {
            $("#uploadForm #error_message").empty(); // To remove the previous error message
            var file = this.files[0];
            var imagefile = file.type;
            var match = ["image/jpeg", "image/png", "image/jpg", "image/gif"];
            if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]) || (imagefile == match[3])))
            {
                $("#uploadForm #error_message").html("<p id='error' style='color:red'>Please Select A valid Image File.<br>" + "<span id='error_message'>Only jpeg, jpg and png Images type allowed</span></p>");
                isValid = false;
                return false;
            }
            else
            {
                var reader = new FileReader();
                reader.onload = imageIsLoaded;
                reader.readAsDataURL(this.files[0]);
                isValid = true;
            }
        });

        function imageIsLoaded(e) {
            $("#uploadForm #profilePic").css("color", "green");
            $("#uploadForm #profile_previewing").attr('src', e.target.result);
        }

        $('#uploadForm').on('submit', (function (e) {
            if (!isValid)
                return false;
            $('#uploadBtn').prop('disabled', true);
            e.preventDefault();
            $('#loadUpload').show();
            $("#error_message").empty();
            $.ajax({
                url: "<?= site_url() ?>app/profile/upload",
                type: "POST",
                data: new FormData(this), // Data sent to server, a set of key/value pairs representing form fields and values 
                contentType: false, // The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
                cache: false, // To unable request pages to be cached
                processData: false, // To send DOMDocument or non processed data file it is set to false (i.e. data should not be in the form of string)
                success: function (data)
                {
                    $('#loadUpload').hide();
                    if (data == "1") {
                        $("#error_message").css('color', 'green');
                        $("#error_message").html("Profile Picture Successfully Uploaded..!");
                        setTimeout(function () {
                            $('.discard').trigger('click');
                            location.reload(true);
                        }, 1000);
                    } else {
                        $('#uploadBtn').prop('disabled', false);
                        $("#error_message").css('color', 'red');
                        $("#error_message").html("Profile Picture Uploading Failed..!");
                    }
                }
            });
        }));
        /**********************************************************************/

        /*************************Complete Your Profile************************/
        $('#profileBtn').on('click', function () {
            var id = $(this).prop('id');
            var bdate = $('#profileForm input[name="birthday"]').val();
            var phone = $('#profileForm input[name="phone"]').val();
            var code = $('#profileForm select[name="code"]').val();
            $('#' + id).prop('disabled', true);
            $('#loadProfile').show();
            $.ajax({
                type: 'POST',
                data: {birthday: bdate, phone: phone, code: code},
                url: "<?= site_url() ?>app/profile/updateProfileSetup",
                success: function (data, textStatus, jqXHR) {
                    $('#loadProfile').hide();
                    if (data == "1") {
                        $("#msgProfile").css('color', 'green');
                        $("#msgProfile").html("Profile Successfully Updated..!");
                        setTimeout(function () {
                            $('.discard').trigger('click');
                            location.reload(true);
                        }, 1000);
                    } else {
                        $("#msgProfile").css('color', 'red');
                        $("#msgProfile").html("Profile has not been Updated..!");
                        $('#' + id).prop('disabled', false);
                    }
                }
            });
        });
        /**********************************************************************/
        /*************************Add New Contact************************/
        $('#contactForm input[name="fname"]').focusout(function () {
            var str = $(this).val() + "'s";
            $('#contactForm input[name="birthday"]').attr('placeholder', 'Enter ' + str + ' Birthdate');
            $('#contactForm input[name="phone"]').attr('placeholder', 'Enter ' + str + ' Phone Number');
        });
        $('#contactForm input[name="birthday"]').focusout(function () {
            var dt = $(this).val();
            var pastYear = dt.split('-');
            var now = new Date();
            var nowYear = now.getFullYear();
            var age = nowYear - pastYear[2];
            if (dt != "") {
                $.ajax({
                    type: 'POST',
                    data: {birthdate: dt},
                    url: "<?= site_url() ?>app/contacts/getZodiac/" + dt,
                    success: function (data, textStatus, jqXHR) {
                        $('#contactForm input[name="zodiac"]').val(data);
                        $('#contactForm input[name="age"]').val(age);
                    }
                });
            } else {
                $('#contactForm input[name="zodiac"]').val('');
                $('#contactForm input[name="age"]').val('');
            }
        });
        $('#contactBtn').on('click', function () {
            var id = $(this).prop('id');
//            var bdate = $('#contactForm input[name="birthday"]').val();
//            var phone = $('#contactForm input[name="phone"]').val();
//            var code = $('#contactForm select[name="code"]').val();
            $('#' + id).prop('disabled', true);
            $('#loadContact').show();
            $.ajax({
                type: 'POST',
//                data: {birthday: bdate, phone: phone, code: code},
                data: $('#contactForm').serialize(),
                url: "<?= site_url() ?>app/contacts/add_contact",
                success: function (data, textStatus, jqXHR) {
                    $('#loadContact').hide();
                    if (data == "1") {
                        $("#msgContact").css('color', 'green');
                        $("#msgContact").html("Contact Successfully added..!");
                        setTimeout(function () {
                            $('.discard').trigger('click');
                            location.reload(true);
                        }, 1000);
                    } else {
                        $("#msgContact").css('color', 'red');
                        $("#msgContact").html("Profile has not been Updated..!");
                        $('#' + id).prop('disabled', false);
                    }
                }
            });
        });
    });
</script>
