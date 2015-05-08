<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dashboard/css/checkbox.css"/>
<style type="text/css">
    /*    .alert1 {
            position: relative;
            padding: 10px 35px;
            margin: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        .alert-danger1 {
            color: #a94442;
            background-color: #f2dede;
            border-color: #ebccd1;
        }
    
        .alert1 > .fa, .alert1 > .glyphicon {
            position: absolute;
            left: -15px;
            top: -15px;
            width: 35px;
            height: 35px;
            -webkit-border-radius: 50%;
            -moz-border-radius: 50%;
            border-radius: 50%;
            line-height: 35px;
            text-align: center;
            background: inherit;
            border: inherit;
    }*/
</style>
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="margin-left: 15%;float: left">User Profile</h1>
        <button type="button" id="save-profile" class="btn btn-primary">Save User Detail</button>
    </section>
    <!-- Main content -->
    <section class="content">
        <?php
        $img_src = ($user->profile_pic != "") ?
                "http://mikhailkuznetsov.s3.amazonaws.com/" . $user->profile_pic :
                base_url() . 'assets/dashboard/img/default-avatar.png';
        ?>
        <div class="row">
            <div class="col-md-3"></div>
            <!-- left column -->
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header" >
                        <h3  class="box-title">User Profile</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form id="userForm" role="form" action="<?= site_url() ?>app/profile/updateProfile" enctype="multipart/form-data" method="post">
                        <div class="box-body">
                            <div class="form-group" id="profile-pic">
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
                            <div class="form-group" id="full-name">
                                <label>Full Name</label>
                                <input value="<?= isset($user) ? $user->name : '' ?>" type="text" name="name" autofocus="autofocus" class="form-control" placeholder="Full Name" required=""/>
                            </div>

                            <div class="form-group" id="phone-number">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label>Country Code</label>
                                        <select name="code" class="form-control">
                                            <option value="+1">+1</option>
                                        </select>
                                    </div>
                                    <?php
                                    $phone = (isset($user)) ?
                                            substr($user->phone, -10) : "";
                                    ?>
                                    <div class="col-sm-9">
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
                            <div class="form-group" id="birthday">
                                <label>Birthday</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input name="birthday" value="<?= isset($user->birthday) ? $this->common->getUTCDate($user->birthday) : NULL ?>"  class="form-control form-control-inline input-medium default-date-picker" size="16" type="text">
                                </div><!-- /.input group -->
                            </div><!-- /.form group -->
                            <div class="form-group">
                                <label>Email</label>
                                <input value="<?= isset($user) ? $user->email : '' ?>" type="email" name="email" class="form-control" placeholder="Email"/>
                            </div>

                            <div class="form-group">
                                <label>Date Format</label>
                                <select name="date_format" id="date-format" class="form-control m-bot15">
                                    <option value="mm-dd-yyyy">mm-dd-yyyy</option>
                                    <option value="dd-mm-yyyy">dd-mm-yyyy</option>
                                </select>
                            </div>
                            <div class="form-group" id="select-timezone">
                                <label>Timezone </label>
                                <?= timezone_menu('UTC') ?>
                            </div>

                            <div class="form-group">
                                <label>Credit Card Number </label>
                                <input id="card_number" data-stripe="number"  type="text" maxlength="16" class="form-control" placeholder="Card Number"/>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Expiration (MM/YYYY)</label>
                                        <div class="row">
                                            <div class="col-md-5" style="padding-right: 0">
                                                <input id="month" data-stripe="exp-month" maxlength="2" type="text" class="form-control" placeholder="MM">
                                            </div>
                                            <div class="col-md-1" style="padding: 0 8px;font-size: 23px">/</div>
                                            <div class="col-md-5" style="padding-left: 0">
                                                <input id="year" data-stripe="exp-year" type="text" maxlength="4" class="form-control" placeholder="YYYY">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label>CVC</label>
                                        <input id="cvc" maxlength="3" type="password" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" class="simple"  name="is_repeat" >
                                <span class="lbl padding-8">Automatically bill me,When my trial over</span>
                            </div>
                        </div><!-- /.box-body -->
                    </form>
                </div><!-- /.box -->
            </div><!--/.col (left) -->
            <div class="col-md-3"></div>
            <!-- right column -->
        </div>
        <div id="error" class="row" style="background-color: #ecf0f5;margin: 0;">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="alert alert-danger alert-dismissable">
                    <i class="fa fa-ban"></i>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <b>Error!</b> <span id="error-msg"></span>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<!-- InputMask -->
<script src="<?= base_url() ?>assets/dashboard/js/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/dashboard/js/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/dashboard/js/plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>

<script type="text/javascript">
    $(function () {

        Stripe.setPublishableKey('pk_test_qVqwj9LKS3yljQVTRh15YB2K');

        $("[data-mask]").inputmask();
        $('.default-date-picker').datepicker({
            format: "<?= $this->session->userdata('date_format') ?>",
            todayBtn: "linked",
            autoclose: true,
            todayHighlight: true
        });
        $('select[name="timezones"]').addClass('form-control m-bot15');
        $('select[name="timezones"] option').each(function () {
            if ($(this).val() == "<?= $user->timezones ?>") {
                $(this).attr('selected', 'selected');
            }
        });
        $('#date-format option').each(function () {
            if ($(this).val() == "<?= $user->date_format ?>") {
                $(this).attr('selected', 'selected');
            }
        });
    });
    function reportError(msg) {
        // Show the error in the form:
        $('#error-msg').text(msg);
        // re-enable the submit button:
        $('#save-profile').prop('disabled', false);
        return false;
    }
</script>
<script type="text/javascript">
    $(document).ready(function (e) {

        $('#save-profile').click(function () {
            //$(this).attr("disabled", "disabled");
            $('#userForm').submit();
        });

        $('#userForm').on('submit', function () {
            var error = false;
            var ccNum = $('#card_number').val(),
                    cvcNum = $('#cvc').val(),
                    expMonth = $('#month').val(),
                    expYear = $('#year').val();

            // Validate the number:
            if (!Stripe.card.validateCardNumber(ccNum)) {
                error = true;
                reportError('The credit card number appears to be invalid.');
                return false;
            }

            // Validate the CVC:
            if (!Stripe.card.validateCVC(cvcNum)) {
                error = true;
                reportError('The CVC number appears to be invalid.');
                return false;
            }

            // Validate the expiration:
            if (!Stripe.card.validateExpiry(expMonth, expYear)) {
                error = true;
                reportError('The expiration date appears to be invalid.');
                return false;
            }

            // Check for errors:
            if (!error) {
                // Get the Stripe token:
                Stripe.card.createToken({
                    number: ccNum,
                    cvc: cvcNum,
                    exp_month: expMonth,
                    exp_year: expYear
                }, stripeResponseHandler);
            }
            // Prevent the form from submitting:
            return false;
        });

        // Function handles the Stripe response:
        function stripeResponseHandler(status, response) {

            // Check for an error:
            if (response.error) {
                reportError(response.error.message);
            } else { // No errors, submit the form:
                var f = $("#userForm");

                // Token contains id, last4, and card type:
                var token = response['id'];

                // Insert the token into the form so it gets submitted to the server
                f.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
                // Submit the form:
                // f.get(0).submit();
            }

        } // End of stripeResponseHandler() function.

        $("input:file").change(function () {
            $("#error_message").empty(); // To remove the previous error message
            var file = this.files[0];
            var imagefile = file.type;
            var match = ["image/jpeg", "image/png", "image/jpg"];
            if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2])))
            {
                $("#error_message").html("<p id='error' style='color:red'>Please Select A valid Image File.<br>" + "<span id='error_message'>Only jpeg, jpg and png Images type allowed</span></p>");
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
            $("#profilePic").css("color", "green");
            $("#profile_previewing").attr('src', e.target.result);
        }
    });
</script>
