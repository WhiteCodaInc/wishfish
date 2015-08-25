<link rel="stylesheet" href="<?= base_url() ?>assets/dashboard/timeline/timeglider/Timeglider.css" type="text/css" media="screen" title="no title" charset="utf-8">
<link rel="stylesheet" href="<?= base_url() ?>assets/dashboard/timeline/timeglider/timeglider.datepicker.css" type="text/css" media="screen" charset="utf-8">
<link rel="stylesheet" href="<?= base_url() ?>assets/dashboard/timeline/css/docs.css" type="text/css" media="screen" title="no title" charset="utf-8">
<!--<link rel="stylesheet" href="<?= base_url() ?>assets/dashboard/timeline/css/jquery-ui-1.10.3.custom.css" type="text/css" media="screen" title="no title" charset="utf-8">-->

<link href="<?= base_url() ?>assets/dashboard/js/plugins/form-wizard/gsdk-base.css" rel="stylesheet" type="text/css"/>
<style type='text/css'>
    .header {
        margin:32px;
    }
    #p1 {
        margin:32px;
        margin-bottom:0;
        height:460px;
    }
    #p1 #tg-container{
        z-index: 0
    }
    .timeglider-legend {
        width:180px;
    }
    *.no-select {
        -moz-user-select: -moz-none;
        -khtml-user-select: none;
        -webkit-user-select: none;
        user-select: none;
    }
    .timeglider-timeline-event.ongoing .timeglider-event-title {
        color:green;
    }
    .dragger {
        float:right;
        width:40%;
        text-align:right;
        margin-right:8px;
        font-size:18px;
        color:green;
        font-size:12px;
        cursor:pointer;	
    }
    .event{
        max-width: 40%;
        margin-right: 15px;
        z-index: 999;
        position: absolute;
        right: 0;
        top: 10px;
    }
    .feedback {
        max-width: 400px;
        position: absolute;
        right: 15px;
        bottom: 0;
        z-index: 1;
        margin: 0
    }
    // data-backdrop="static" data-keyboard="false"

</style>
<aside class="right-side" style="min-height: 542px;">

    <section class="content-header">
        <h1 style="float: left">
            Dashboard
        </h1>
        <a href="<?= site_url() ?>app/contacts/addContact" class="btn btn-primary btn-sm create">
            <i class="fa fa-plus"></i>
            Create New Contact
        </a>
        <a href="<?= site_url() ?>app/calender" class="btn btn-info btn-sm create">
            <i class="fa fa-plus"></i>
            Create New Event
        </a>
        <div class="box box-solid box-primary collapsed-box event">
            <div class="box-header" data-widget="collapse"  style="cursor: pointer;padding: 7px">
                <h4 class="box-title" style="font-size: 15px">Events</h4>
            </div>
            <div class="box-body"  style="display: none">
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
    </section>

    <!-- Main content -->
    <section class="content">
        <style type="text/css">
            #p1{
                margin: 0 !important;
            }
        </style>
        <div id='p1'></div>
    </section>
</aside>

<div class="modal-dialog feedback">
    <div class="modal-content" style="border: 2px solid #3c8dbc;">
        <div class="modal-header" style="text-align: center">
            <button type="button" class="close">&times;</button>
            <h4 class="modal-title">Have feedback? Let us know!</h4>
        </div>
        <div class="modal-body" style="padding: 0">
            <div class="box box-primary review" style="border-radius: 0;border-top: 2px solid #3c8dbc;">
                <div class="box-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12" style="text-align: center">
                                <textarea id="review" rows="5" style="border: 1px solid #3c8dbc;" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div id="review_error" class="form-group" style="text-align: center;display: none">
                        <span></span>
                    </div>
                    <div class="form-group" style="text-align: center">
                        <button type="submit" id="review_submit" class="btn btn-primary btn-lg">Submit</button>
                    </div>
                </div>
                <div class="overlay" style="display: none"></div>
                <div class="loading-img" style="display: none"></div>
            </div>
        </div>
    </div>
</div>

<!-------------------------------Welcome Tour Model------------------------------------>
<div class="modal fade" id="tour-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 1000px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card wizard-card ct-wizard-blue" id="wizard">
                            <ul>
                                <li style="margin: 0"><a href="#step1" data-toggle="tab">STEP 1</a></li>
                                <li style="margin: 0"><a href="#step2" data-toggle="tab">STEP 2</a></li>
                                <li style="margin: 0"><a href="#step3" data-toggle="tab">STEP 3</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane" id="step1">
                                    <h1 class="info-text">Add a Friend / Family Member :</h1>
                                    <form id="step1Form" method="post">
                                        <div class="row">
                                            <div class="col-md-1"></div>
                                            <div class="col-md-10">

                                                <div class="form-group">
                                                    <input type="text" name="fname" autofocus="autofocus" class="form-control" placeholder="First Name" required=""/>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" name="lname" class="form-control" placeholder="Last Name" required=""/>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input name="birthday" placeholder="Enter Birthdate" value=""  class="form-control form-control-inline input-medium default-date-picker" size="16" type="text" required="">
                                                    </div><!-- /.input group -->
                                                </div>

                                            </div>
                                            <div class="col-md-1"></div>
                                        </div>
                                        <input value="" name="zodiac" type="hidden" class="form-control" >
                                        <input value="" name="age" type="hidden" class="form-control" >
                                    </form>

                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <strong>Don't want to add manually?</strong>
                                            </div>
                                            <div class="form-group">

                                                <a href="#" class="btn btn-danger">
                                                    <i class="fa fa-google-plus-square"></i>
                                                    Add from Google
                                                </a>
                                            </div>
                                            <div class="form-group">

                                                <a href="#" class="btn btn-primary">
                                                    <i class="fa fa-facebook-square"></i>
                                                    Add from Facebook
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-1"></div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="step2">
                                    <h1 class="info-text">Verify Your Phone Number:</h1>
                                    <p style="text-align: center">
                                        Please verify your phone number so that when it is First Name's  birthday,<br/>
                                        Wish-Fish can send you a reminder.
                                    </p>
                                    <div class="box box-primary">
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-md-2"></div>
                                                <div class="col-md-10">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                <label>Country Code</label>
                                                                <select name="code" class="form-control">
                                                                    <option value="+1">+1</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label>Phone Number</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-phone"></i>
                                                                    </div>
                                                                    <input autofocus="" id="varify_phone" name="phone" type="text" class="form-control"  placeholder="Phone Number" data-inputmask='"mask": "(999) 999-9999"' data-mask/>
                                                                </div><!-- /.input group -->
                                                                <a href="javascript:void(0);" id="non-us" data-toggle="modal" data-target="#step2-nonus-modal">
                                                                    Have a Non-US Number?
                                                                </a> 
                                                            </div>
                                                            <div style="padding: 5px" class="col-sm-2">
                                                                <br/>
                                                                <button id="sendcode" class="btn btn-success">Verify</button>
                                                            </div>
                                                        </div>
                                                    </div><!-- /.form group -->
                                                </div>
                                                <div class="col-md-1"></div>
                                            </div>
                                            <div id="verifyRow" style="display: none;margin-bottom: 15px" class="row">
                                                <div class="col-md-4"></div>
                                                <div class="col-sm-4" style="margin-left: 25px;">
                                                    <label>Verification Code</label>
                                                    <input maxlength="6" name="verifycode" type="text" class="form-control"  placeholder="Verification Code" />
                                                </div>
                                                <div class="col-md-2" style="padding: 5px">
                                                    <br/>
                                                    <button type="button" id="code_submit" class="btn btn-primary pull-left">Submit</button>
                                                </div>
                                            </div>
                                            <div id="loadRow" style="display: none;margin-bottom: 15px" class="row">
                                                <div class="col-md-12 text-center">
                                                    <img class="load" src="<?= base_url() ?>assets/dashboard/img/load.GIF" alt=""  />
                                                    <span style="display: none;" class="msg"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <strong>Don't want to cerify phone number?</strong>
                                            </div>
                                            <div class="form-group">
                                                <strong>No Problem...</strong>
                                            </div>
                                            <div class="form-group">
                                                <a href="#" class="btn btn-danger continue">
                                                    continue without verifying...
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-1"></div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="step3">
                                    <h1 class="info-text">STEP - 3</h1>
                                </div>
                            </div>
                            <br/>
                            <div class="wizard-footer">
                                <div class="pull-right">
                                    <input style="width: 160px;height: 60px;" type='button' class='btn btn-next btn-info btn-lg' name='next' value='Next' />
                                    <input style="width: 160px;height: 60px;" type='button' class='btn btn-finish btn-info' name='finish' value='Finish' />
                                </div>
                            </div>	
                        </div>
                        <!--</form>-->
                    </div>
                </div> <!-- row -->
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!------------------------------------------------------------------------>
<!-----------------------------   STEP -2 -------------------------------->
<div class="modal fade" id="step2-nonus-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 400px">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <p>
                            Unfortunately as of right now we don't support non-US phone numbers (bear with us, we're still a startup!).
                            However, please <a href="javascript:void(0);" id="feedback" data-toggle="modal" data-target="#step2-feedback-modal">send us an email</a> with your country, and we will let you know as soon as it is available (hopefully soon!)
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="text-align: center">
                        <button type="button" class="btn btn-danger discard" data-dismiss="modal"><i class="fa fa-times"></i> Discard</button>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="step2-feedback-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 400px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Feedback / Support</h4>
            </div>
            <form id="feedbackForm"  method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group" >
                                <label>Select Country</label>
                                <select id="country" class="form-control">
                                    <option value="-1">--Select Country--</option>
                                    <option value="India">India</option>
                                    <option value="Pakistan">Pakistan</option>
                                    <option value="Canada">Canada</option>
                                    <option value="Australia">Australia</option>
                                </select>
                            </div>
                            <div class="form-group" >
                                <textarea id="query" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <img  src="<?= base_url() ?>assets/dashboard/img/load.GIF" alt="" class="load" style="display: none" />
                            <span style="display: none" class="msg"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer clearfix">
                    <div class="row">
                        <div class="col-md-4">
                            <button type="button" value="feedback" class="btn btn-primary pull-left send-query">Send</button>
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
<!------------------------------------------------------------------------>

<script type="text/javascript">
    $(function () {
        $('#step1Form .default-date-picker').datepicker({
            format: "<?= $this->session->userdata('u_date_format') ?>",
            todayBtn: "linked",
            autoclose: true,
            todayHighlight: true
        }).on('changeDate', function (ev) {
            $('#step1Form input[name="birthday"]').focusout();
        });
    });
</script>
<script type="text/javascript" >

    $(document).ready(function () {

        $('#tour-modal').modal('show');



        //---------------------------------- STEP 1 --------------------------//
        $('#step1Form input[name="fname"]').focusout(function () {
            var str = $(this).val() + "'s";
            $('#step1Form  input[name="birthday"]').attr('placeholder', 'Enter ' + str + ' Birthdate');
            $('#step1Form input[name="phone"]').attr('placeholder', 'Enter ' + str + ' Phone Number');
        });
        $('#step1Form input[name="birthday"]').focusout(function () {
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
                        $('#step1Form  input[name="zodiac"]').val(data);
                        $('#step1Form  input[name="age"]').val(age);
                    }
                });
            } else {
                $('#step1Form  input[name="zodiac"]').val('');
                $('#step1Form  input[name="age"]').val('');
            }
        });


        //--------------------------------------------------------------------//
        //---------------------------------- STEP 2 --------------------------//
        $('a.continue').click(function () {
            $('.wizard-footer .btn-next').trigger('click');
        });

        $('#step2-nonus-modal #feedback').click(function () {
            $('#step2-feedback-modal #feedbackForm span.msg').text('');
            $('#step2-nonus-modal .discard').trigger('click');
        });

        $('#step2 #varify_phone').on("keypress", function (e) {
            if (e.keyCode == 13) {
                $('#sendcode').trigger('click');
            }
        });

        $('#step2 input[name="verifycode"]').on("keypress", function (e) {
            if (e.keyCode == 13) {
                $('#code_submit').trigger('click');
            }
        });

        $('#step2 #sendcode').click(function () {
            $('.wizard-card').css('height', '500px');
            $('.tab-content').css('height', '280px');
            var phone = $('#step2 #varify_phone').val();
            var code = $('#step2 select[name="code"]').val();
            $('#step2 #loadRow').css('display', 'block');
            $.ajax({
                type: 'POST',
                data: {phone: phone, code: code},
                url: "<?= site_url() ?>app/dashboard/sendVerificationCode",
                success: function (data, textStatus, jqXHR) {
                    $('#step2 .load').css('display', 'none');
                    $('#step2 .msg').css('display', 'block');
                    if (data == 1) {
                        $('.msg').css('color', 'green');
                        $('.msg').text("Verification Code Successfully Sent To +1" + phone);
                        $('#verifyRow').css('display', 'block');
                        $('#submitRow').css('display', 'block');
                        $('.wizard-card').css('height', '545px');
                        $('.tab-content').css('height', '340px');
                    } else {
                        $('.msg').css('color', 'red');
                        $('.msg').text("Invalid Phone Number..!");
                        $('#verifyRow').css('display', 'none');
                        $('#submitRow').css('display', 'none');
                    }
                }
            });
        });

        $('#step2 #code_submit').click(function () {
            $('.msg').css('display', 'none');
            $('.load').css('display', 'block');
            var code = $('input[name="verifycode"]').val();
            if (!(code.length == 6) || !$.isNumeric(code)) {
                $('.load').css('display', 'none');
                $('.msg').css('display', 'block');
                $('.msg').css('color', 'red');
                $('.msg').text("Invalid Verification Code..!");
                return false;
            }
            $.ajax({
                type: 'POST',
                data: {code: code},
                url: "<?= site_url() ?>app/dashboard/checkVerificationCode",
                success: function (data, textStatus, jqXHR) {
                    if (data == '1') {
                        $('.load').css('display', 'none');
                        $('.msg').css('display', 'block');
                        $('.msg').css('color', 'green');
                        $('.msg').text("Congratulations! You have verified your phone number successfully!");
                    } else {
                        $('.load').css('display', 'none');
                        $('.msg').css('display', 'block');
                        $('.msg').css('color', 'red');
                        $('.msg').text("Invalid Verification Code..!");
                    }
                }
            });
        });
        //--------------------------------------------------------------------//

        $('button.close').click(function () {
            $('div.feedback').hide();
        });

        $('#review_submit').click(function () {
            var msg = $('#review').val();
            var id = $(this).prop('id');
            if (msg.trim() == "") {
                alertify.error('Please Write Your Feedback In Box..!');
                return false;
            }
            $(this).prop('disabled', true);
            $('div.review .overlay').show();
            $('div.review .loading-img').show();
            $.ajax({
                type: 'POST',
                url: "<?= site_url() ?>app/dashboard/sendQuery",
                data: {query: msg},
                success: function (data, textStatus, jqXHR) {
                    $('#' + id).prop('disabled', false);
                    $('div.review .overlay').hide();
                    $('div.review .loading-img').hide();
                    $('#review_error').show();
                    if (data == "1") {
                        $('#review_error span').css('color', 'green');
                        $('#review_error span').text("Thank You..!");
                    } else {
                        $('#review_error span').css('color', 'red');
                        $('#review_error span').text("We can't receive your feedback..! Try Again..!");
                    }
                    $('#review').val("");
//                    setTimeout(function () {
//                        $('#feedback-model .close').trigger('click');
//                    }, 500);
                }
            });
        });
    });
</script>

<!--   plugins 	 -->
<script src="<?= base_url() ?>assets/dashboard/js/plugins/form-wizard/jquery.bootstrap.wizard.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/dashboard/js/plugins/form-wizard/wizard.js" type="text/javascript"></script>

<script src="<?= base_url() ?>assets/dashboard/timeline/js/underscore-min.js" type="text/javascript" charset="utf-8"></script>
<script src="<?= base_url() ?>assets/dashboard/timeline/js/backbone-min.js" type="text/javascript" charset="utf-8"></script>
<script src="<?= base_url() ?>assets/dashboard/timeline/js/jquery.tmpl.js" type="text/javascript" charset="utf-8"></script>
<script src="<?= base_url() ?>assets/dashboard/timeline/js/ba-debug.min.js" type="text/javascript" charset="utf-8"></script>
<script src="<?= base_url() ?>assets/dashboard/timeline/js/ba-tinyPubSub.js" type="text/javascript" charset="utf-8"></script>
<script src="<?= base_url() ?>assets/dashboard/timeline/js/jquery.mousewheel.js" type="text/javascript" charset="utf-8"></script>
<script src="<?= base_url() ?>assets/dashboard/timeline/js/jquery.ui.ipad.js" type="text/javascript" charset="utf-8"></script>
<script src="<?= base_url() ?>assets/dashboard/timeline/js/globalize.js" type="text/javascript" charset="utf-8"></script>	



<script src="<?= base_url() ?>assets/dashboard/timeline/timeglider/TG_Date.js" type="text/javascript" charset="utf-8"></script>
<script src="<?= base_url() ?>assets/dashboard/timeline/timeglider/TG_Org.js" type="text/javascript" charset="utf-8"></script>
<script src="<?= base_url() ?>assets/dashboard/timeline/timeglider/TG_Timeline.js" type="text/javascript" charset="utf-8"></script> 
<script src="<?= base_url() ?>assets/dashboard/timeline/timeglider/TG_TimelineView.js" type="text/javascript" charset="utf-8"></script>
<script src="<?= base_url() ?>assets/dashboard/timeline/timeglider/TG_Mediator.js" type="text/javascript" charset="utf-8"></script> 
<script src="<?= base_url() ?>assets/dashboard/timeline/timeglider/timeglider.timeline.widget.js" type="text/javascript"></script>

<script src="<?= base_url() ?>assets/dashboard/timeline/timeglider/timeglider.datepicker.js" type="text/javascript"></script>


<script src="<?= base_url() ?>assets/dashboard/timeline/js/jquery.jscrollpane.min.js" type="text/javascript"></script>


<!-- JUST FOR KITCHEN SINK: NOT NEEDED FOR TG WIDGET -->
<script src="<?= base_url() ?>assets/dashboard/timeline/js/jquery.ui.sortable.js" type="text/javascript" charset="utf-8"></script>

<script type='text/javascript'>
    $(function () {
        var tg_instance = {};
        var timezone = {UM12: "-12:00", UM11: "-11:00", UM10: "-10:00", UM95: "-09:30", UM9: "-09:00", UM8: "-08:00", UM7: "-07:00", UM6: "-06:00", UM5: "-05:00", UM45: "-04:30", UM4: "-04:00", UM35: "-03:30", UM3: "-03:00", UM2: "-02:00", UM1: "-01:00", UTC: "00:00", UP1: "+01:00", UP2: "+02:00", UP3: "+03:00", UP35: "+03:30", UP4: "+04:00", UP45: "+04:30", UP5: "+05:00", UP55: "+05:30", UP575: "+05:45", UP6: "+06:00", UP65: "+06:30", UP7: "+07:00", UP8: "+08:00", UP875: "+08:45", UP9: "+09:00", UP95: "+09:30", UP10: "+10:00", UP105: "+10:30", UP11: "+11:00", UP115: "+11:30", UP12: "+12:00", UP1275: "+12:45", UP13: "+13:00", UP14: "+14:00"};
        $.ajax({
            url: "<?= site_url() ?>app/dashboard/getTimelineEvent",
            success: function (data, textStatus, jqXHR) {
                json = JSON.parse(data);
                tg1 = $("#p1").timeline({
                    "min_zoom": 1,
                    "max_zoom": 50,
//                    "timezone": "-12:00",
                    "timezone": timezone.<?= $userInfo->timezones ?>,
                    "icon_folder": "<?= base_url() ?>assets/dashboard/timeline/timeglider/icons/",
                    "data_source": json,
                    "show_footer": true,
                    "display_zoom_level": true,
                    "mousewheel": "zoom", // zoom | pan | none
                    "constrain_to_data": true,
                    "image_lane_height": 100,
                    "legend": {type: "default"}, // default | checkboxes
                    "loaded": function () {
                        // loaded callback function
                    }
                }).resizable({
                    stop: function () {
                        // $(this).data("timeline").resize();
                    }
                });
                tg_instance = tg1.data("timeline");
            }
        });
        $(".goto").click(function () {
            var d = $(this).attr("date");
            var z = $(this).attr("zoom");
            tg_instance.goTo(d, z);
        });

        $(".zoom").click(function () {
            var z = Number($(this).attr("z"));
            tg_instance.zoom(z);
        });

        $("#getScope").click(function () {
            var so = tg_instance.getScope();
            var ml = "RETURNS: <br><br>container (jquery dom object): " + so.container.toString()
                    + "<br>focusDateSec (tg sec):" + so.focusDateSec
                    + "<br>focusMS (js timestamp): " + so.focusMS
                    + "<br>leftMS (js timestamp): " + so.leftMS
                    + "<br>left_sec (tg sec): " + so.left_sec
                    + "<br>rightMS (js timestamp): " + so.rightMS
                    + "<br>right_sec (tg sec): " + so.right_sec
                    + "<br>spp (seconds per pixel): " + so.spp
                    + "<br>timelineBounds (object, left- & right-most in tg sec): " + JSON.stringify(so.timelineBounds)
                    + "<br>timelines (array of ids): " + JSON.stringify(so.timelines);
            var d = new Date(so.focusMS);
            ml += "<br><br>Date using focusMS:" + d.toString('yyyy-MM-dd');
            $(".scope-view").html(ml);
        });

        $("#loadData").click(function () {
            var src = $("#loadDataSrc").val();
            var cb_fn = function (args, timeline) {
                // called after parsing data, after load
//                debug.log("args", args, "timeline", timeline[0].id);
            };
            var cb_args = {}; // {display:true};
            tg_instance.getMediator().emptyData();
            tg_instance.loadTimeline(src, function () {
//                debug.log("cb!");
            }, true);
            $("#reloadDataDiv").hide();
        });

        $("#refresh").click(function () {
            debug.log("timeline refreshed!");
            tg_instance.refresh();
        });

        $("#scrolldown").bind("click", function () {
            $(".timeglider-timeline-event").animate({top: "+=100"});
        });

        $("#scrollup").bind("click", function () {
            $(".timeglider-timeline-event").animate({top: "-=100"});
        });

        timeglider.eventActions = {
            nagavigateTo: function (obj) {
                // event object must have a "navigateTo"
                // element with zoom, then ISO date delimited
                // with a pipe | 
                // one can use
                var nav = obj.navigateTo;
                tg_instance.goTo(nav.focus_date, nav.zoom_level);

                setTimeout(function () {
                    $el = $(".timeglider-timeline-event#" + obj.id);
                    $el.find(".timeglider-event-spanner").css({"border": "1px solid green"}); // 
                }, 50);
            }
        }

        $("#adjustNow").click(function () {
            tg_instance.adjustNowEvents();
        });

        $("#addEvent").click(function () {
            var rando = Math.floor((Math.random() * 1000) + 1);
            var impo = Math.floor((Math.random() * 50) + 20);
            var obj = {
                id: "new_" + rando,
                title: "New Event!",
                startdate: "today",
                importance: impo,
                icon: "star_red.png",
                timelines: ["js_history"]
            };
            tg_instance.addEvent(obj, true);
        });

        $("#updateEvent").click(function () {
            var updatedEventModel = {
                id: "deathofflash",
                title: "Flash struggles to survive in the age of HTML5."
            }
            tg_instance.updateEvent(updatedEventModel);
        });

        $(".method").each(function () {
            $(this).find("h4").addClass("clearfix");
            $(this).prepend("<div class='dragger'>drag me</div>");
        });

        $("#sorters").sortable({"handle": ".dragger"});
        $("#sorters").disableSelection();


    }); // end document-ready
</script>

