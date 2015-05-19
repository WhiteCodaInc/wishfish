<!-- header logo: style can be found in header.less -->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dashboard/js/plugins/Qtip/css/jquery.qtip.css"/>
<style type="text/css">
    #image_preview > img {
        z-index: 5;
        height: 90px;
        width: 90px;
        border: 8px solid;
        border-color: transparent;
        border-color: rgba(255, 255, 255, 0.2);
    }
    a.title-logo{
        float: left;
        font-size: 20px;
        line-height: 50px;
        text-align: center;
        padding: 0 10px;
        width: 220px;
        font-family: 'Kaushan Script', cursive;
        font-weight: 500;
        height: 50px;
        display: block;
        color: white
    }
    a.title-logo:focus{
        color: white
    }
    #navbar-collapse .dropdown-menu > li a{
        padding: 10px 20px;
    }
    ul.menubar li.dropdown:hover ul.dropdown-menu{ display: block; }
    //.nav .dropdown-toggle .caret { display:none; }
    /*    .modal-backdrop{
            z-index: 0
        }*/
</style>
<?php
$profile_pic = $this->session->userdata('profile_pic');

$img_src = ($profile_pic != "") ?
        "http://mikhailkuznetsov.s3.amazonaws.com/" . $profile_pic :
        base_url() . 'assets/dashboard/img/default-avatar.png';
?>
<header class="main-header">
    <nav class="navbar navbar-static-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="<?= site_url() ?>app/dashboard" class="title-logo">
                    <?= $this->session->userdata('name') ?>
                </a>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                    <i class="fa fa-bars"></i>
                </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav menubar">
                    <li class="dropdown" id="wishfish-contact">
                        <a href="<?= site_url() ?>app/contacts" class="dropdown-toggle">
                            <i class="fa fa-user"></i>
                            Contact Management 
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li id="create-contact">
                                <a href="<?= site_url() ?>app/contacts/addContact">
                                    <i class="fa fa-plus"></i>
                                    <span>Create New Contact</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= site_url() ?>app/contact_groups">
                                    <i class="fa fa-users"></i> <span>Contact Groups</span>
                                </a>
                            </li>
                            <!--<li class="divider"></li>-->
                            <li>
                                <a href="<?= site_url() ?>app/contacts/block_list">
                                    <i class="fa fa-lock"></i>
                                    <span>Contact Block List</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="<?= site_url() ?>app/template" class="dropdown-toggle">
                            <i class="fa fa-credit-card"></i>
                            Templates 
                        </a>
                        <ul class="dropdown-menu" role="menu" >
                            <li>
                                <a href="<?= site_url() ?>app/sms_template">
                                    <i class="fa fa-mobile-phone"></i>
                                    <span>SMS Template</span>
                                </a>
                            </li>
                            <!--<li class="divider"></li>-->
                            <li>
                                <a href="<?= site_url() ?>app/email_template">
                                    <i class="fa fa-envelope"></i> <span>Email Template</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="<?= site_url() ?>app/calender">
                            <i class="fa fa-th"></i> <span>Calender</span>
                        </a>
                    </li>
                    <?php
                    $userid = $this->session->userdata('userid');
                    $currPlan = $this->common->getCurrentPlan($userid);
                    if (count($currPlan) && $currPlan->plan_id == 1) {
                        ?>
                        <li style="margin: 10px 60px;color: white;">
                            <span style="font-size: 20px">
                                Days Left on Trial: <?= $this->common->getDateDiff($currPlan) ?>
                            </span>
                        </li>
                    <?php } ?>
                </ul>
                <a class="btn btn-warning" href="<?= site_url() ?>app/upgrade">
                    Upgrade
                </a>
                <ul class="nav navbar-nav navbar-right" id="wishfish-title">
                    <li class="dropdown user user-menu">
                        <a style="padding: 10px" href="#" class="dropdown-toggle" data-toggle="dropdown">
<!--                            <i class="glyphicon glyphicon-user"></i>-->
                            <img style="width: 30px;border-radius: 50%;" src="<?= $img_src ?>"  />
                            <span><i class="caret"></i></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li class="user-header bg-light-blue">
                                <div class="row">
                                    <div class="col-lg-9"></div>
                                    <div class="col-lg-1">
                                        <a class="query_popup" style="color: white;" data-toggle="modal" data-target="#query-modal">
                                            <i id="help" class="fa fa-question-circle"></i>
                                        </a>
                                    </div>
                                </div>

                                <form id="profileForm" method="post" action="" enctype="multipart/form-data">
                                    <input name="profile" style="position: absolute;left: -9999px" id="profile-image-upload" class="hidden" type="file">
                                    <div id="image_preview">
                                        <img id="profile_pic" style="cursor: pointer;" src="<?= $img_src ?>" class="img-circle" alt="User Image" />
                                    </div>
                                    <p>
                                        <?= $this->session->userdata('name') ?>
                                    </p>
                                </form>
                            </li>
                            <!-- Menu Body -->
                            <li style="display: none" id="user-body" class="user-body">
                                <h4 id='loading' style="display:none;">loading...</h4>
                                <div id="msg"></div>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left" id="wishfish-profile">
                                    <a href="<?= site_url() ?>app/profile" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <a href="<?= site_url() ?>app/logout" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>



                <div class="modal fade" id="query-modal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" style="max-width: 400px">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Feedback / Support</h4>
                            </div>
                            <form id="supportForm"  method="post">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Have questions or feedback?<br/>We`re always happy to hear from you!</label>
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
                                        <div class="col-md-3">
                                            <button type="button" id="send" class="btn btn-primary pull-left">Send</button>
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

                <style type="text/css">
                    .tooltip-width{
                        width: 200px
                    }
                </style>
                <script src="<?= base_url() ?>assets/dashboard/js/plugins/Qtip/js/jquery.qtip.js" type="text/javascript"></script>
                <script type="text/javascript">
                    $(function () {
                        $('#profile_pic').on('click', function () {
                            $('#profile-image-upload').click();
                        });

                        $('#help').qtip({
                            content: {
                                text: "Have question or feddback?<br/> We`re always happy to hear from you!",
                                title: {text: "Feddback / Support"}
                            },
                            position: {
                                my: "top center",
                                at: "left center",
                                container: false,
                                viewport: $(window)
                            },
                            style: {classes: 'tooltip-width'},
                            hide: {fixed: true}
                        });
//                        $('#help').tooltip({
//                            position: {
//                                my: "bottom center",
//                                at: "top center",
//                                container: false,
//                                viewport: $(window)
//                            }
//                        });

                    });
                </script>
                <script type="text/javascript">
                    $(document).ready(function (e) {
                        $('.query_popup').click(function () {
                            $('#supportForm .msg').text('');
                            setTimeout(function () {
                                $('.modal-backdrop').css('z-index', '999');
                            }, 1000);
                        });
                        $('#send').click(function () {
                            var query = $('#query').val();
                            $('#supportForm .load').css('display', 'block');
                            $('#supportForm .msg').css('display', 'none');
                            $.ajax({
                                type: 'POST',
                                url: "<?= site_url() ?>app/dashboard/sendQuery",
                                data: {query: query},
                                success: function (data, textStatus, jqXHR) {
                                    setTimeout(function () {
                                        if (data) {
                                            $('#supportForm .msg').html("Thank you for your Feebback!");
                                            $('#supportForm .load').css('display', 'none');
                                            $('#supportForm .msg').css('display', 'block');
                                            $('#supportForm .msg').css('color', 'green');
                                            $('#supportForm').trigger('reset');
//                                            setTimeout(function () {
//                                                $('.discard').trigger('click');
//                                            }, 1000);
//                                            $('.modal-backdrop').removeAttr('style');
                                        }
                                        else {
                                            $('#loadDept').html("Your Query Not Sent..!Please Try Again..!");
                                            $('#load').css('display', 'none');
                                            $('#msg').css('display', 'block');
                                            $('#msg').css('color', 'red');
                                        }
                                    }, 1000);
                                }
                            });
                        });
                        // Function to preview image
                        $("#profileForm input:file").change(function () {
                            $("#msg").empty(); // To remove the previous error message
                            var file = this.files[0];
                            var imagefile = file.type;
                            var match = ["image/jpeg", "image/png", "image/jpg", "image/gif"];
                            if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]) || (imagefile == match[3])))
                            {

                                $("#msg").html("<p id='error' style='color:red'>Please Select A valid Image File<br>" + "<span id='error_message'>Only jpeg, jpg and png Images type allowed</span></p>");
                                $('#user-body').css('display', 'block');
                                $('#user-body').fadeOut(5000);
                                return false;
                            }
                            else
                            {
                                var reader = new FileReader();
                                reader.onload = imageIsLoaded;
                                reader.readAsDataURL(this.files[0]);
                            }
                            $('#profileForm').submit();
                        });
                        function imageIsLoaded(e) {

                            $("#image_preview").css("display", "block");
                            $("#profile_pic").attr('src', e.target.result);
                        }
                        //Upload Image Form Submit
                        $('#profileForm').on('submit', (function (e) {
                            e.preventDefault();
                            $("#msg").empty();
                            $('#user-body').css('display', 'block');
                            $("#loading").show();
                            $.ajax({
                                url: "<?= site_url() ?>app/dashboard/uploadProfilePic", // Url to which the request is send
                                type: "POST", // Type of request to be send, called as method
                                data: new FormData(this), // Data sent to server, a set of key/value pairs representing form fields and values 
                                contentType: false, // The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
                                cache: false, // To unable request pages to be cached
                                processData: false, // To send DOMDocument or non processed data file it is set to false (i.e. data should not be in the form of string)
                                success: function (data)  		// A function to be called if request succeeds
                                {
                                    $("#loading").hide();
                                    $("#msg").html(data);
                                    $("#msg").fadeOut(7000);
                                    $('#user-body').css('display', 'none');
                                }
                            });
                        }));
                    });
                </script>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</header>
<?php $userInfo = $this->common->getUserInfo($this->session->userdata('userid')); ?>



<?php if (!$userInfo->phone_verification): ?>
    <style type="text/css">
        .alert1 {
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
        }
    </style>
    <!-- InputMask -->
    <script src="<?= base_url() ?>assets/dashboard/js/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>assets/dashboard/js/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>assets/dashboard/js/plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>

    <div class="row" style="background-color: #ecf0f5;margin: 0">
        <div class="col-md-12">
            <div class="alert1 alert-danger1">
                <i class="fa fa-ban"></i>
                <div class="row">
                    <div class="col-md-3">
                        <h4>Please Verify Your Phone Number.</h4>
                    </div>
                    <div class="col-md-2">
                        <a style="color: white;  margin: 2px -48px;" class="btn btn-info" data-toggle="modal" data-target="#varify-modal">
                            Click Here To Verify
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="varify-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 440px">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Phone Verification</h4>
                </div>
                <div class="modal-body">
                    <div class="row" style="margin-bottom: 15px">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-4">
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
                                    </div>
                                    <div style="padding: 5px" class="col-sm-3">
                                        <br/>
                                        <button id="sendcode" class="btn btn-success">Verify</button>
                                    </div>
                                </div>
                            </div><!-- /.form group -->
                        </div>
                    </div>
                    <div id="verifyRow" style="display: none;margin-bottom: 15px" class="row">
                        <div class="col-sm-4" style="  margin-top: 6px;">
                            <label>Verification Code</label>
                        </div>
                        <div class="col-sm-5">
                            <input maxlength="6" name="verifycode" type="text" class="form-control"  placeholder="Verification Code" />
                        </div>
                    </div>
                    <div id="loadRow" style="display: none;margin-bottom: 15px" class="row">
                        <div class="col-md-12">
                            <img class="load" src="<?= base_url() ?>assets/dashboard/img/load.GIF" alt=""  />
                            <span style="display: none;" class="msg"></span>
                        </div>
                    </div>
                    <div id="submitRow" style="display: none" class="row m-bot15">
                        <div class="col-md-3">
                            <button type="button" id="code_submit" class="btn btn-primary pull-left">Submit</button>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <script type="text/javascript">
                        $(function () {
                            $("[data-mask]").inputmask();
                        });
                        $(document).ready(function () {
                            $('#sendcode').click(function () {
                                var phone = $('#varify_phone').val();
                                var code = $('select[name="code"]').val();
                                $('#loadRow').css('display', 'block');
                                $.ajax({
                                    type: 'POST',
                                    data: {phone: phone, code: code},
                                    url: "<?= site_url() ?>app/dashboard/sendVerificationCode",
                                    success: function (data, textStatus, jqXHR) {
                                        $('.load').css('display', 'none');
                                        $('.msg').css('display', 'block');
                                        if (data == 1) {
                                            $('.msg').css('color', 'green');
                                            $('.msg').text("Verification Code Successfully Sent To +1" + phone);
                                            $('#verifyRow').css('display', 'block');
                                            $('#submitRow').css('display', 'block');
                                        } else {
                                            $('.msg').css('color', 'red');
                                            $('.msg').text("Invalid Phone Number..!");
                                            $('#verifyRow').css('display', 'none');
                                            $('#submitRow').css('display', 'none');
                                        }
                                    }
                                });
                            });
                            $('#code_submit').click(function () {
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
                                        if (data == 1) {
                                            $('.close').trigger('click');
                                            alertify.success("Congratulations! You have verified your phone number successfully!");
                                            setTimeout(function () {
                                                location.reload(true);
                                            }, 1000);
                                        } else {
                                            $('.load').css('display', 'none');
                                            $('.msg').css('display', 'block');
                                            $('.msg').css('color', 'red');
                                            $('.msg').text("Invalid Verification Code..!");
                                        }
                                    }
                                });
                            });
                        });
    </script>
<?php endif; ?>