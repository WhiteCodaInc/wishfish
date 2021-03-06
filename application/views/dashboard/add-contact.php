<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="margin-left: 11%;float: left">
            Add New Contact
        </h1>
        <button id="save-contact" type="button" class="btn btn-primary save-contact">Create New Contact</button>
        <button style="color:white" class="btn btn-info"  data-toggle="modal" data-target="#import-modal">
            Import From Facebook
        </button>
    </section>
    <!-- Main content -->
    <section class="content">
        <?php
        $img_src = base_url() . 'assets/dashboard/img/default-avatar.png';
        ?>
        <div class="row">
            <div class="col-md-3"></div>
            <!-- left column -->
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header" id="add-contact">
                        <h3 class="box-title">New Contact</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form id="contactForm" role="form" action="" enctype="multipart/form-data" method="post">
                        <div class="box-body">
                            <div class="form-group" id="add-profile-pic">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div  class="image" style="text-align: center">
                                            <img id="profile_previewing" style="width: 100px;height: 100px"  src="<?= $img_src ?>" class="img-circle" alt="User Image" />
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <label for="contact avatar">Profile Picture</label>
                                        <input title="Have a photo of your awesome friend ?" name="contact_avatar"  type="file" id="profilePic" class="form-control" />
                                        <span id="error_message"></span>
                                    </div>
                                </div>
                            </div>

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
                                    <input style="z-index: 0" name="birthday" placeholder="Enter Birthdate" value="<?= isset($contacts) ? $this->wi_common->getUTCDate($contacts->birthday) : '' ?>"  class="form-control form-control-inline input-medium default-date-picker" size="16" type="text" >
                                </div><!-- /.input group -->
                            </div><!-- /.form group -->
                            <div class="form-group" id="add-phone">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label>Country Code</label>
                                        <select name="code" class="form-control">
                                            <option value="+1">+1</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-9">
                                        <label>Phone Number </label>
                                        <i title="You can send your contact a pre scheduled text message.In case you`r busy or vacation,so you don`t miss an important date ! (its kind of magical!)" class="fa fa-question-circle"></i>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-phone"></i>
                                            </div>
                                            <input name="phone" type="text" class="form-control"  placeholder="Enter Phone Number" data-inputmask='"mask": "(999) 999-9999"' data-mask />
                                        </div><!-- /.input group -->
                                    </div>
                                </div>
                            </div><!-- /.form group -->
                            <div class="form-group">
                                <label for="password">Email</label>
                                <input name="email" type="email" class="form-control"  placeholder="Enter Their Email">
                            </div>
                            <div class="form-group">
                                <button  type="button" class="btn btn-primary save-contact">Create This Contact</button>
                            </div>
                        </div><!-- /.box-body -->
                        <input value="" name="zodiac" type="hidden" class="form-control" >
                        <input value="" name="age" type="hidden" class="form-control" >
                        <input type="hidden" name="importUrl" value="" />
                        <input type="submit" style="display: none" class="submit"/>
                    </form>
                </div><!-- /.box -->
            </div><!--/.col (left) -->
            <div class="col-md-3"></div>
            <!-- right column -->
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->

<!-------------------------------Import Model------------------------------------>
<div class="modal fade" id="import-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 490px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Import Contact</h4>
            </div>
            <div class="modal-body">
                <div class="box box-primary parse">
                    <div class="box-body">
                        <form id="importForm" method="post">
                            <div class="row">
                                <div class="col-md-8">
                                    <label>Facebook Username</label>
                                    <input id="url"  type="text" class="form-control" required=""/>
                                </div>
                                <div class="col-md-2" style="margin-top: 5%;">
                                    <button class="btn btn-success" type="submit" id="parse">Get Contact</button>
                                </div>
                            </div>
                            <br/>
                            <div style="display: none;margin-top: 10px;background-color: #f2dede !important;border-color: #ebccd1;" class="alert alert-danger alert-dismissable">
                                <span style="color: #a94442;" class="errorMsg"></span> 
                            </div>
                        </form>
                    </div>
                    <div class="overlay" style="display: none"></div>
                    <div class="loading-img" style="display: none"></div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!------------------------------------------------------------------------>


<!-- InputMask -->
<!--<script src="<?= base_url() ?>assets/dashboard/js/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/dashboard/js/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/dashboard/js/plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>-->

<script type="text/javascript">
    $(function () {
        $("[data-mask]").inputmask();
        $('.default-date-picker').datepicker({
            format: "<?= $this->session->userdata('u_date_format') ?>",
            todayBtn: "linked",
            autoclose: true,
            todayHighlight: true
        }).on('changeDate', function (ev) {
            $('input[name="birthday"]').focusout();
        });
    });
    $(document).ready(function () {

        $('#importForm').submit(function () {
            $('#import-modal .parse .overlay').show();
            $('#import-modal .parse .loading-img').show();
            $.ajax({
                type: 'POST',
                data: {userid: $('#import-modal #url').val()},
                url: "<?= site_url() ?>app/scrape/facebook",
                success: function (data, textStatus, jqXHR) {
                    $('.parse .overlay').hide();
                    $('.parse .loading-img').hide();
                    if (data == "0") {
                        $('#import-modal .parse .alert').show();
                        $('#import-modal span.errorMsg').text("Please Enter Valid Username..!");
                        $('input[name="importUrl"]').val("");
                    } else if (data == "1") {
                        $('#import-modal .parse .alert').show();
                        $('#import-modal span.errorMsg').text("Your Profile Is Not Visible Publically..!");
                        $('input[name="importUrl"]').val("");
                    } else {
                        $('#import-modal .close').trigger("click");
                        $('#import-modal #url').val("");
                        $('#import-modal .alert').hide();
                        var json = JSON.parse(data);
                        var name = json.name.split(' ');
                        $('#contactForm input[name="fname"]').val(name[0]);
                        $('#contactForm input[name="lname"]').val(name[1]);
                        $('#contactForm #profile_previewing').prop('src', json.profile);
                        $('input[name="importUrl"]').val(json.profile);
                    }
                }
            });
            return false;
        });

        $('.save-contact').click(function () {
            var tourStep = hopscotch.getState();
            var href = "";
            if (tourStep == "welcome:17:10") {
                href = "<?= site_url() ?>app/contacts/createContact?type=ajax";
                hopscotch.nextStep();
            } else {
                href = "<?= site_url() ?>app/contacts/createContact";
            }
            $('#contactForm').attr('action', href);
            $('.submit').trigger('click');
        });

        $('input[name="fname"]').focusout(function () {
            var str = $(this).val() + "'s";
            $('input[name="birthday"]').attr('placeholder', 'Enter ' + str + ' Birthdate');
            $('input[name="phone"]').attr('placeholder', 'Enter ' + str + ' Phone Number');
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
                    url: "<?= site_url() ?>app/contacts/getZodiac/" + dt,
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

        //----------------------Profile Picture Setting-----------------------//
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
            $('input[name="importUrl"]').val("");
        }
    });
</script>
