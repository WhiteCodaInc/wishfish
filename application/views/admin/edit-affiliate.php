<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dashboard/js/plugins/multi-select/css/multi-select.css" />
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/password/strength.css"/>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dashboard/css/checkbox.css"/>
<style type="text/css">
    .strength_meter div p {
        position: absolute;
        top: 34px;
        right: 0px;
        font-size: 13px;
    }
    a.button_strength{
        padding: 0;
    }
</style>
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="display: none">Affiliate Detail</h1>
        <button type="button" id="addAffiliate" class="btn btn-primary">Save Affiliate Detail</button>
    </section>
    <!-- Main content -->
    <section class="content">
        <?php
        $img_src = ($affiliates->affiliate_avatar != "") ?
                "http://mikhailkuznetsov.s3.amazonaws.com/" . $affiliates->affiliate_avatar :
                base_url() . 'assets/dashboard/img/default-avatar.png';
        ?>
        <div class="row">
            <div class="col-md-3"></div>
            <!-- left column -->
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Edit Existing Affiliate</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form id="affiliateForm" role="form" action="<?= site_url() ?>admin/affiliates/updateAffiliate" enctype="multipart/form-data" method="post">
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
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>First Name</label>
                                        <input value="<?= isset($affiliates) ? $affiliates->fname : '' ?>" type="text" name="fname" autofocus="autofocus" class="form-control" placeholder="First Name" required=""/>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Last Name</label>
                                        <input value="<?= isset($affiliates) ? $affiliates->lname : '' ?>" type="text" name="lname" class="form-control" placeholder="Last Name" required=""/>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label>Country Code</label>
                                        <select name="code" class="form-control">
                                            <option value="+1" selected="">+1</option>
                                        </select>
                                    </div>
                                    <?php
                                    $phone = (isset($affiliates)) ?
                                            substr($affiliates->phone, -10) : "";
                                    ?>
                                    <div class="col-sm-9">
                                        <label>Phone Number</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-phone"></i>
                                            </div>
                                            <input value="<?= $phone ?>" type="text" name="phone" class="form-control" placeholder="Phone" data-inputmask='"mask": "(999) 999-9999"' data-mask/>
                                        </div><!-- /.input group -->
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Birthday</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input name="birthday" value="<?= ($affiliates->birthday != NULL) ? date('d-m-Y', strtotime($affiliates->birthday)) : '' ?>"  class="form-control form-control-inline input-medium default-date-picker" size="16" type="text">
                                </div><!-- /.input group -->
                            </div><!-- /.form group -->
                            <div class="form-group">
                                <label>Email</label>
                                <input value="<?= isset($affiliates) ? $affiliates->email : '' ?>" type="email" name="email" class="form-control" placeholder="Email"/>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-7">
                                        <label>Affiliate Groups</label><a style="margin-left: 10px" href="<?= site_url() . 'admin/affiliate_groups/addAffiliateGroup' ?>" >Create New Affiliate Group</a>
                                        <select multiple="" name="group_id[]" class="form-control searchable">
                                            <?php foreach ($groups as $value) { ?>
                                                <option value="<?= $value->group_id ?>" <?= (in_array($value->group_id, $agroup)) ? "selected" : '' ?>><?= $value->group_name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="zodiac">Zodiac</label>
                                <input value="<?= isset($affiliates) ? $affiliates->zodiac : '' ?>" name="zodiac" placeholder="Zodiac" type="text" class="form-control" readonly="readonly" >
                            </div>
                            <div class="form-group">
                                <label>Age</label>
                                <input value="<?= isset($affiliates) ? $affiliates->age : '' ?>" name="age" class="form-control" placeholder="Age" type="text" readonly="readonly">
                            </div>
                            <div class="form-group">
                                <label>Affiliate Sex</label><br/>
                                <div style="float: left;padding-right: 5px;cursor: pointer">
                                    <input type="radio" id="male" value="male"  name="gender" checked="" class="simple form-control">                          
                                    <span class="lbl padding-8">Male&nbsp;</span>
                                </div>
                                <div style="float: left;padding:0 5px;cursor: pointer">
                                    <input type="radio" id="female" value="female"  name="gender" class="simple form-control">                          
                                    <span class="lbl padding-8">Female&nbsp;</span>
                                </div>
                            </div>
                            <br/>
                            <div class="form-group">
                                <label for="birthday alert">Birthday Alert</label>
                                <input value="<?= isset($affiliates) ? $affiliates->birthday_alert : '' ?>" name="birthday_alert"  type="text" class="form-control" placeholder="" disabled="">
                            </div>
                            <div class="form-group">
                                <label for="social media">Social Media</label>
                                <input value="<?= isset($affiliates) ? $affiliates->social_media : '' ?>" name="social_media" type="text" class="form-control" placeholder="Social Media">
                            </div>
                            <div class="form-group">
                                <label for="url">Url</label>
                                <input value="<?= isset($affiliates) ? $affiliates->url : '' ?>" name="url" type="text" class="form-control" placeholder="Url">
                            </div>
                            <div class="form-group">
                                <label for="password">Contact</label>
                                <input value="<?= isset($affiliates) ? $affiliates->contact : '' ?>" name="contact" type="text" class="form-control" placeholder="" disabled="">
                            </div>
                            <div class="form-group">
                                <label for="rating">Profile Rating(1-10)</label>
                                <select name="rating" class="form-control m-bot15">
                                    <option value="-1">--Select--</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Country</label>
                                <input value="<?= isset($affiliates) ? $affiliates->country : '' ?>" name="country" type="text" class="form-control" placeholder="Country" >
                            </div>
                            <div class="form-group">
                                <label>City</label>
                                <input value="<?= isset($affiliates) ? $affiliates->city : '' ?>" name="city" type="text" class="form-control" placeholder="City">
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input value="<?= isset($affiliates) ? $affiliates->address : '' ?>" name="address" type="text" class="form-control" placeholder="Address" >
                            </div>
                            <div class="form-group">
                                <label for="phone">Notes</label>
                                <textarea type="text" name="notes" class="form-control" placeholder="Notes"><?= isset($affiliates) ? $affiliates->notes : '' ?></textarea>
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
                            <div class="form-group" id="strengthForm">
                                <label>Password</label>
                                <a href="javascript:void(0);" id="change_password">Change Password</a>
                                <input value="**********" id="myPassword" type="password" name="password" class="form-control" disabled="" style="background-color: #eee;" />
                            </div>
                        </div>
                        <input type="hidden" name="affiliateid" value="<?= $affiliates->affiliate_id ?>" />
                        <button type="submit" style="display: none"></button>
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

<!-- Multi Select -->
<script src="<?= base_url() ?>assets/dashboard/js/plugins/multi-select/js/jquery.multi-select.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/dashboard/js/plugins/multi-select/js/jquery.quicksearch.js" type="text/javascript"></script>

<script type="text/javascript" src="<?= base_url() ?>assets/password/strength.js"></script>

<script type="text/javascript">
    $(function () {
        $("[data-mask]").inputmask();
        $('.default-date-picker').datepicker({
            format: "<?= $affiliates->date_format ?>",
            todayBtn: "linked",
            autoclose: true,
            todayHighlight: true
        }).on('changeDate', function (ev) {
            $('input[name="birthday"]').focusout();
        });
        $('select[name="timezones"]').addClass('form-control m-bot15');
        $('select[name="timezones"] option').each(function () {
            if ($(this).val() == "<?= $affiliates->timezones ?>") {
                $(this).prop('selected', true);
            }
        });
        $('#date-format option').each(function () {
            if ($(this).val() == "<?= $affiliates->date_format ?>") {
                $(this).prop('selected', true);
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


<?php if (isset($affiliates)): ?>
            $("#<?= $affiliates->gender ?>").attr('checked', 'true');
    <?php if ($affiliates->phone): ?>
                $('select[name="code"]').val("<?= substr($affiliates->phone, -strlen($affiliates->phone), 2) ?>");
    <?php endif; ?>
            $('select[name="rating"]').val("<?= ($affiliates->rating) ? $affiliates->rating : -1 ?>");
<?php endif; ?>

        $('span.lbl').click(function () {
            $name = $(this).prev().prop('name');
            $('input[name="' + $name + '"]').prop('checked', false);
            $(this).prev().trigger('click');
        });

        $('#affiliateForm').submit(function () {
            if ($('input[name="fname"]').val().trim() == "") {
                alertify.error("First Name is Required...!");
                return false;
            }
            if ($('input[name="lname"]').val().trim() == "") {
                alertify.error("Last Name is Required...!");
                return false;
            }
            if ($('input[name="email"]').val().trim() == "") {
                alertify.error("Email is Required...!");
                return false;
            }
            if ($('input[name="password"]').prop('disabled')) {
                return true;
            } else {
                var passwd = $('input[name="password"]').val();
                if (passwd.trim() == "") {
                    alertify.error("Password can not be blank..!");
                    return false;
                } else {
                    return true;
                }
            }
        });

        $('#addAffiliate').click(function () {
            $('#affiliateForm').submit();
        });

        $('#change_password').click(function () {
            $('input[name="password"]').val('');
            $('input[name="password"]').removeAttr('style');
            $('input[name="password"]').prop('disabled', false);
            $('a.button_strength').show();
        });

        $('input[name="birthday"]').focusout(function () {
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

<script type="text/javascript">
    $('.searchable').multiSelect({
        selectableHeader: "<input style='margin-bottom: 5%;' type='text' class='search-input form-control' autocomplete='off' placeholder='Search By Contact'>",
        selectionHeader: "<input style='margin-bottom: 5%;' type='text' class='search-input form-control' autocomplete='off' placeholder='Search By Contact'>",
        afterInit: function (ms) {
            var that = this,
                    $selectableSearch = that.$selectableUl.prev(),
                    $selectionSearch = that.$selectionUl.prev(),
                    selectableSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)',
                    selectionSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selection.ms-selected';

            that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                    .on('keydown', function (e) {
                        if (e.which === 40) {
                            that.$selectableUl.focus();
                            return false;
                        }
                    });

            that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                    .on('keydown', function (e) {
                        if (e.which == 40) {
                            that.$selectionUl.focus();
                            return false;
                        }
                    });
        },
        afterSelect: function () {
            this.qs1.cache();
            this.qs2.cache();
        },
        afterDeselect: function () {
            this.qs1.cache();
            this.qs2.cache();
        }
    });
</script>