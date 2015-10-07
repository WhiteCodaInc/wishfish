<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/password/strength.css"/>
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="display: none">
            Add New Affiliate
        </h1>
        <button type="button" id="affiliate" class="btn btn-primary">Create New Affiliate</button>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3"></div>
            <!-- left column -->
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">New Affiliate</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form id="affiliateForm" role="form" action="<?= site_url() ?>admin/affiliates/createAffiliate" enctype="multipart/form-data" method="post">
                        <div class="box-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>First Name</label>
                                        <input type="text" name="fname" autofocus="autofocus" class="form-control" placeholder="First Name" required=""/>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Last Name</label>
                                        <input type="text" name="lname" class="form-control" placeholder="Last Name" required=""/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password">Email</label>
                                <input name="email" type="email" class="form-control"  placeholder="Email" required="">
                                <span style="color: red"></span>
                            </div>
                            <div class="form-group" id="strengthForm">
                                <label for="password">Password</label>
                                <input id="myPassword" name="password" type="password" class="form-control" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label>Country Code</label>
                                        <select name="code" class="form-control">
                                            <option value="+1">+1</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-9">
                                        <label>Phone Number</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-phone"></i>
                                            </div>
                                            <input name="phone" type="text" class="form-control"  placeholder="Phone Number" data-inputmask='"mask": "(999) 999-9999"' data-mask/>
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
                                    <input name="birthday" value="<?= isset($affiliates) ? date('d-m-Y', strtotime($affiliates->birthday)) : '' ?>"  class="form-control form-control-inline input-medium default-date-picker" size="16" type="text">
                                </div><!-- /.input group -->
                            </div><!-- /.form group -->
                            <div class="form-group">
                                <label>Affiliate Avatar</label>
                                <input name="affiliate_avatar"  type="file" class="form-control" />
                            </div>
                            <div class="form-group" style="display: none">
                                <button type="submit"></button>
                            </div>
                        </div><!-- /.box-body -->
                        <input value="" name="zodiac" type="hidden" class="form-control" >
                        <input value="" name="age" type="hidden" class="form-control" >
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
            format: "dd-mm-yyyy",
            todayBtn: "linked",
            autoclose: true,
            todayHighlight: true
        }).on('changeDate', function (ev) {
            $('input[name="birthday"]').focusout();
        });
        ;
    });
    $(document).ready(function () {
        var affEmail = false;
        $form = $('#affiliateForm');

        $('input[name="email"]', $form).focusout(function () {
            $email = $(this);
            var email = $(this).val();
            if (email.trim() != "") {
                $.ajax({
                    type: 'POST',
                    data: {email: email},
                    url: "<?= site_url() ?>admin/affiliates/isEmailRegister",
                    success: function (data, textStatus, jqXHR) {
                        if (data == '1') {
                            $email.next('span').text("Email Address is already Exists..!");
                            affEmail = false;
                        } else {
                            $email.next('span').text("");
                            affEmail = true;
                        }
                    }
                });
            }
        });

        $('#myPassword').strength({
            strengthClass: 'strength',
            strengthMeterClass: 'strength_meter',
            strengthButtonClass: 'button_strength',
            strengthButtonText: 'Show Password',
            strengthButtonTextToggle: 'Hide Password'
        });

        $('#affiliate').click(function () {
            if (!affEmail)
                return false;
            $('button:submit', $form).trigger('click');
        });

        $('input[name="birthday"]', $form).focusout(function () {
            var dt = $(this).val();
            var pastYear = dt.split('-');
            var now = new Date();
            var nowYear = now.getFullYear();
            var age = nowYear - pastYear[2];
            if (dt != "") {
                $.ajax({
                    type: 'POST',
                    data: {birthdate: dt},
                    url: "<?= site_url() ?>admin/affiliates/getZodiac/" + dt,
                    success: function (data, textStatus, jqXHR) {
                        $('input[name="zodiac"]').val(data);
                        $('input[name="age"]').val(age);
                    }
                });
            } else {
                $('input[name="zodiac"]').val('');
                $('input[name="age"]').val('');
            }
        });
    });
</script>