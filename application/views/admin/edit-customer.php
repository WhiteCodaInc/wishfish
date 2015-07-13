<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/password/strength.css"/>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dashboard/css/checkbox.css"/>
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="display: none">Customer Detail</h1>
        <button type="button" id="addCustomer" class="btn btn-primary">Save Customer Detail</button>
    </section>
    <!-- Main content -->
    <section class="content">
        <?php
        $img_src = ($customers->profile_pic != "") ?
                "http://mikhailkuznetsov.s3.amazonaws.com/" . $customers->profile_pic :
                base_url() . 'assets/dashboard/img/default-avatar.png';
        ?>
        <div class="row">
            <div class="col-md-3"></div>
            <!-- left column -->
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Edit Existing Customer</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form id="customerForm" role="form" action="<?= site_url() ?>admin/customers/updateCustomer" enctype="multipart/form-data" method="post">
                        <div class="box-body">
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
                            <div class="form-group">
                                <label>Full Name</label>
                                <input value="<?= isset($customers) ? $customers->name : '' ?>" type="text" name="name" autofocus="autofocus" class="form-control" placeholder="Full Name" required=""/>
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
                                    $phone = (isset($customers)) ?
                                            substr($customers->phone, -10) : "";
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
                            </div>
                            <div class="form-group" id="birthday">
                                <label>Birthday</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input style="z-index: 0;" name="birthday" value="<?= isset($customers->birthday) ? $this->wi_common->getUTCDate($customers->birthday, $customers->timezones, $customers->date_format) : NULL ?>"  class="form-control form-control-inline input-medium default-date-picker" size="16" type="text">
                                </div><!-- /.input group -->
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input value="<?= isset($customers) ? $customers->email : '' ?>" type="email" name="email" class="form-control" placeholder="Email" />
                            </div>
                            <div class="form-group">
                                <label>Date Format</label>
                                <select name="date_format" id="date-format" class="form-control m-bot15">
                                    <option value="mm-dd-yyyy">mm-dd-yyyy</option>
                                    <option value="dd-mm-yyyy">dd-mm-yyyy</option>
                                </select>
                            </div>
                            <div class="form-group" id="select-timezone">
                                <label >Timezone </label>
                                <?= timezone_menu('UTC') ?>
                            </div>
                            <div class="form-group">
                                <label>Profile Type</label>
                                <select name="profile_type" id="type" class="form-control m-bot15">
                                    <option value="-1">--Select--</option>
                                    <option value="facebook">Facebook</option>
                                    <option value="linkedin">LinkedIn</option>
                                    <option value="twitter">Twitter</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label id="title">Profile Url</label>
                                <input value="<?= isset($customers) ? $customers->profile_link : '' ?>" type="text" name="profile_link" class="form-control" />
                            </div>
                            <div class="form-group" id="strengthForm">
                                <label>Password</label>
                                <a href="javascript:void(0);" id="change_password">Change Password</a>
                                <input id="myPassword" value="****************" type="password" name="password" class="form-control" />
                            </div>
                        </div><!-- /.box-body -->
                        <input type="hidden" name="customerid" value="<?= $customers->user_id ?>" />
                    </form>
                </div><!-- /.box -->
            </div><!--/.col (left) -->
            <div class="col-md-3"></div>
            <!-- right column -->
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<!-- InputMask -->
<script src="<?= base_url() ?>assets/dashboard/js/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/dashboard/js/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/dashboard/js/plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>

<script type="text/javascript" src="<?= base_url() ?>assets/password/strength.js"></script>

<script type="text/javascript">
    $(function () {
        $("[data-mask]").inputmask();
        $('.default-date-picker').datepicker({
            format: "<?= $customers->date_format ?>",
            todayBtn: "linked",
            autoclose: true,
            todayHighlight: true
        });
        $('select[name="timezones"]').addClass('form-control m-bot15');
        $('#type').val("<?= $customers->profile_type ?>");
        $('select[name="timezones"] option').each(function () {
            if ($(this).val() == "<?= $customers->timezones ?>") {
                $(this).prop('selected', true);
            }
        });
        $('#date-format option').each(function () {
            if ($(this).val() == "<?= $customers->date_format ?>") {
                $(this).prop('selected', true);
            }
        });
        $('#type').change(function () {
            var type = $(this).val();
            if (type == "facebook") {
                $('#title').text("Facebook Username");
            } else if (type == "linkedin") {
                $('#title').text("LinkedIn Profile Url");
            } else if (type == "twitter") {
                $('#title').text("Twitter Username");
            } else {
                $('#title').text("Url");
            }
        });
    });
    $(document).ready(function () {

        $('#myPassword').strength({
            strengthClass: 'strength',
            strengthMeterClass: 'strength_meter',
            strengthButtonClass: 'button_strength',
            strengthButtonText: 'Show Password',
            strengthButtonTextToggle: 'Hide Password'
        });

<?php if ($customers->phone): ?>
            $('select[name="code"]').val("<?= substr($customers->phone, -strlen($customers->phone), 2) ?>");
<?php endif; ?>

        $('#addCustomer').click(function () {
            var passwd = $('input[name="password"]').val();
            if (passwd.trim() == "") {
                alertify.error("Password can not be blank..!");
                return false;
            }
            $('#customerForm').submit();
        });

        $('#change_password').click(function () {
            $('input[name="password"]').val('');
            $('input[name="password"]').prop('disabled', false);
        });

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
    }
    );
</script>