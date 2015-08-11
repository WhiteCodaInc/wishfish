<!-- header logo: style can be found in header.less -->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dashboard/js/plugins/Qtip/css/jquery.qtip.css"/>
<!--<link rel="stylesheet" href="<?= base_url() ?>assets/dashboard/js/plugins/clock/css/flipclock.css" />-->
<style type="text/css">
    #image_preview img {
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
        width: 180px;
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
    .separator{
        display: inline-block;
        height: 30px;
        vertical-align: top;
        margin: 10px;
        border-right: 1px solid lightseagreen;
        float: right;
    }
    .import:hover{
        color: #00c0ef
    }
    .import{
        color: white
    }
</style>
<?php
$profile_pic = $this->session->userdata('u_profile_pic');
$img_src = ($profile_pic != "") ?
        "https://mikhailkuznetsov.s3.amazonaws.com/" . $profile_pic :
        base_url() . 'assets/dashboard/img/default-avatar.png';
$userid = $this->session->userdata('u_userid');
?>
<header class="main-header">
    <nav class="navbar navbar-static-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="<?= site_url() ?>app/dashboard" class="title-logo">
                    <?= $this->session->userdata('u_name') ?>
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
                            Contacts
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li id="create-contact">
                                <a href="<?= site_url() ?>app/contacts/addContact">
                                    <i class="fa fa-plus"></i>
                                    <span>Create New Contact</span>
                                </a>
                            </li>
                            <li>
                                <a class="scrape-contact" href="javascript:void(0)" data-toggle="modal" data-target="#scrapeContact">
                                    <i class="fa fa-users"></i>
                                    <span>Import Contacts</span>
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
                            <li>
                                <a class="import" href="<?= site_url() ?>app/import">
                                    <i class="fa fa-google"></i>
                                    <span>Import Google Contacts</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="<?= site_url() ?>app/calender">
                            <i class="fa fa-th"></i> <span>Calendar</span>
                        </a>
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
                    <?php
                    $currPlan = $this->wi_common->getCurrentPlan($userid);
                    if (count($currPlan) && $currPlan->plan_id == 1) {
                        ?>
                        <li style="margin: 13px 30px;color: white;">
                            <span style="font-size: 17px">
                                <?php if ($currPlan->is_lifetime): ?>
                                    Free Lifetime Access
                                <?php else: ?>
                                    Days Left on Trial: <?= $this->wi_common->getDateDiff($currPlan) ?>
                                <?php endif; ?>
                            </span>
                        </li>
                    <?php } ?>
                    <li style="margin: 13px">
                        <!--<div class="clock"></div>-->
                        <span style="font-size: 17px;color: white" id="curr_time"></span>
                    </li>  
                </ul>
                <div class="modal fade" id="scrapeContact" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" style="max-width: 490px">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Import Contact</h4>
                            </div>
                            <div class="modal-body">
                                <div class="box box-primary parse">
                                    <div class="box-body">
                                        <form id="parseForm" method="post">
                                            <div class="row">
                                                <div class="col-md-2"></div>
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label>Import From</label>
                                                        <select name="type" id="type"  class="form-control" required="">
                                                            <option value="facebook" selected="">Facebook</option>
                                                            <option value="linkedin">LinkedIn</option>
                                                            <option value="twitter">Twitter</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2"></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2"></div>
                                                <div class="col-md-8">
                                                    <label id="title">Facebook Username</label>
                                                    <input name="url" id="url"  type="text" class="form-control" required=""/>
                                                </div>
                                                <div class="col-md-2"></div>
                                            </div>
                                            <br/>
                                            <div class="row">
                                                <div class="col-md-2"></div>
                                                <div style="text-align: right" class="col-md-8">
                                                    <button class="btn btn-success" type="submit" id="parse">Get Contact</button>
                                                </div>
                                                <div class="col-md-2"></div>
                                            </div>
                                            <div style="display: none;margin-top: 10px;background-color: #f2dede !important;border-color: #ebccd1;" class="alert alert-danger alert-dismissable">
                                                <!--<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>-->
                                                <span style="color: #a94442;" class="errorMsg"></span> 
                                            </div>
                                        </form>
                                    </div>
                                    <div class="overlay" style="display: none"></div>
                                    <div class="loading-img" style="display: none"></div>
                                </div>
                                <div class="box box-solid box-primary contactInfo" style="display: none">
                                    <div class="box-header">
                                        <h3 class="box-title">Contact Information</h3>
                                    </div>
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <img style="width: 100px" class="picture" src="#" alt="profile picture" />
                                            </div>
                                            <div class="col-md-9">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <h4><label>First Name</label></h4>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <h4 class="fname"></h4>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <h4><label>Last Name</label></h4>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <h4 class="lname"></h4>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <button class="btn btn-success btn-sm save" type="button">
                                                            Add in Contact List
                                                        </button> 
                                                    </div>
                                                    <div class="col-md-4">
                                                        <button class="btn btn-danger btn-sm cancel" type="button">
                                                            Go Back
                                                        </button> 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="display: none;margin-top: 10px" class="alert alert-success alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                            <span class="successMsg"></span> 
                                        </div>
                                    </div><!-- /.box-body -->
                                    <div class="overlay" style="display: none"></div>
                                    <div class="loading-img" style="display: none"></div>
                                </div>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>
                <script type="text/javascript">
                    $(document).ready(function () {

                        $('#scrapeContact .contactInfo .cancel').click(function () {
                            $('#scrapeContact .contactInfo').hide();
                            $('#scrapeContact span.successMsg').hide();
                            $('#scrapeContact #type').val("facebook");
                            $('#scrapeContact .save').show();
                            $('#scrapeContact #title').val("Facebook Username");
                            $('#scrapeContact #url').val('');
                            $('#scrapeContact .picture').prop('src', '#');
                            $('#scrapeContact .parse').show();
                        });

                        $('#scrapeContact #type').change(function () {
                            var type = $(this).val();
                            if (type == "facebook") {
                                $('#scrapeContact #title').text("Facebook Username");
                            } else if (type == "linkedin") {
                                $('#scrapeContact #title').text("LinkedIn Profile Url");
                            } else {
                                $('#scrapeContact #title').text("Twitter Username");
                            }
                        });

                        $('#scrapeContact #parseForm').submit(function () {
                            var type = $('#scrapeContact #type').val();
                            $('#scrapeContact .parse .overlay').show();
                            $('#scrapeContact .parse .loading-img').show();
                            if (type == "facebook") {
                                facebook();
                            } else if (type == "linkedin") {
                                linkedin();
                            } else {
                                twitter();
                            }
                            return false;
                        });

                        function facebook() {
                            $.ajax({
                                type: 'POST',
                                data: {userid: $('#scrapeContact #url').val()},
                                url: "<?= site_url() ?>app/scrape/facebook",
                                success: function (data, textStatus, jqXHR) {
                                    $('.parse .overlay').hide();
                                    $('.parse .loading-img').hide();
                                    if (data == "0") {
                                        $('#scrapeContact .parse .alert').show();
                                        $('#scrapeContact span.errorMsg').text("Please Enter Valid Username..!");
                                    } else if (data == "1") {
                                        $('#scrapeContact .parse .alert').show();
                                        $('#scrapeContact span.errorMsg').text("Your Profile Is Not Visible Publically..!");
                                    } else {
                                        var json = JSON.parse(data);
                                        var name = json.name.split(' ');
                                        $('#scrapeContact .parse').hide();
                                        $('#scrapeContact .fname').text(name[0]);
                                        $('#scrapeContact .lname').text(name[1]);
                                        $('#scrapeContact .picture').prop('src', json.profile);
                                        $('#scrapeContact .contactInfo').show();
                                    }
                                }
                            });
                        }

                        function linkedin() {
                            $.ajax({
                                type: 'POST',
                                data: {url: $('#url').val()},
                                url: "<?= site_url() ?>app/scrape/linkedin",
                                success: function (data, textStatus, jqXHR) {
                                    var _html = $(data);
                                    $('.parse .overlay').hide();
                                    $('.parse .loading-img').hide();
                                    var name = _html.find('span.full-name').text().split(' ');
                                    $('.parse').hide();
                                    $('.fname').text(name[0]);
                                    $('.lname').text(name[1]);
                                    $('.picture').prop('src', _html.find('.profile-picture img').prop('src'));
                                    $('.contactInfo').show();
                                }
                            });
                        }

                        function twitter() {
                            $.ajax({
                                type: 'POST',
                                data: {userid: $('#url').val()},
                                url: "<?= site_url() ?>app/scrape/twitter",
                                success: function (data, textStatus, jqXHR) {
                                    var _html = $(data);

                                    $('.parse .overlay').hide();
                                    $('.parse .loading-img').hide();
                                    var name = _html.find('h1.ProfileHeaderCard-name a').text().split(' ');
                                    $('.parse').hide();
                                    $('.fname').text(name[0]);
                                    $('.lname').text(name[1]);
                                    $('.picture').prop('src', _html.find('.ProfileAvatar img').prop('src'));
                                    $('.contactInfo').show();
                                }
                            });
                        }

                        $('.contactInfo .save').on('click', function () {
                            $('.contactInfo .overlay').show();
                            $('.contactInfo .loading-img').show();
                            $.ajax({
                                type: 'POST',
                                data: {
                                    type: $('#type').val(),
                                    fname: $('.fname').text(),
                                    lname: $('.lname').text(),
                                    url: $('.picture').prop('src')
                                },
                                url: "<?= site_url() ?>app/scrape/addContact",
                                success: function (data, textStatus, jqXHR) {
                                    $('.contactInfo .overlay').hide();
                                    $('.contactInfo .loading-img').hide();
                                    $('.save').hide();
                                    $('.contactInfo .alert').show();
                                    $('span.successMsg').text("Contact has been successfully created..!");
                                }
                            });
                        });
                    });
                </script>
                <ul class="nav navbar-nav navbar-right" >
                    <li class="dropdown user user-menu" id="wishfish-title">
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
                                        <?php if ($profile_pic != ""): ?>
                                            <a href="<?= site_url() ?>app/profile" >
                                                <img  style="cursor: pointer;" src="<?= $img_src ?>" class="img-circle" alt="User Image" />
                                            </a>
                                        <?php else: ?>
                                            <img id="profile_pic" style="cursor: pointer;" src="<?= $img_src ?>" class="img-circle" alt="User Image" />
                                        <?php endif; ?>
                                    </div>
                                    <p>
                                        <?= $this->session->userdata('u_name') ?>
                                    </p>
                                </form>
                            </li>
                            <!-- Menu Body -->
                            <li style="display: none" id="user-body" class="user-body">
                                <h4 id='loading' style="display:none;">loading...</h4>
                                <div id="msg"></div>
                            </li>
                            <?php $setup = $this->wi_common->getProfileSetup($userid); ?>
                            <li>
                                <?php if ($setup['per'] != "100"): ?>
                                    <div class="box box-solid booster">
                                        <div class="box-header" style="padding: 0 10px;">
                                            <h4>Profile <?= $setup['per'] ?>% completed</h4>
                                            <div style="height: 10px;  margin-bottom: 10px;" class="progress progress-striped">
                                                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="<?= $setup['per'] ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $setup['per'] ?>%">
                                                    <span class="sr-only"><?= $setup['per'] ?>% Complete (success)</span>
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
                                                    <a class="<?= ($setup['upload']) ? "task-success" : "" ?>" href="javascript:void(0)" data-toggle="modal" data-target="<?= (!$setup['upload']) ? "#uploadSetup" : "" ?>">
                                                        <i class="fa <?= ($setup['upload']) ? "fa-check-square" : "fa-square-o" ?> i_upload"></i>
                                                        Upload Your Photo
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="<?= ($setup['profile']) ? "task-success" : "" ?>" href="javascript:void(0)" data-toggle="modal" data-target="<?= (!$setup['profile']) ? "#profileSetup" : "" ?>">
                                                        <i class="fa <?= ($setup['profile']) ? "fa-check-square" : "fa-square-o" ?> i_profile"></i>
                                                        Enter Your Info
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="<?= ($setup['contact']) ? "task-success" : "" ?>" href="javascript:void(0)" data-toggle="modal" data-target="<?= (!$setup['contact']) ? "#contactSetup" : "" ?>">
                                                        <i class="fa <?= ($setup['contact']) ? "fa-check-square" : "fa-square-o" ?> i_contact"></i>
                                                        Add Contact
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="<?= ($setup['event']) ? "task-success" : "" ?>" href="<?= (!$setup['event']) ? site_url() . "app/calender" : "javascript:void(0)" ?>">
                                                        <i class="fa <?= ($setup['event']) ? "fa-check-square" : "fa-square-o" ?> i_event"></i>
                                                        Schedule an Event
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left" id="wishfish-profile">
                                    <a href="<?= site_url() ?>app/profile" class="btn btn-default btn-xs">Profile</a>
                                    <!--<a href="#" class="btn btn-default btn-xs">Profile</a>-->
                                </div>
                                <!--                                <div class="pull-left" style="margin-left: 7px;">
                                                                    
                                                                </div>-->
                                <div class="pull-right">
                                    <a href="<?= site_url() ?>app/logout" class="btn btn-default btn-xs">Sign out</a>
                                </div>
                            </li>
                        </ul>
                        <!---------------------------Complete Your Profile------------------------------->
                        <div class="modal fade" id="profileSetup" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" style="max-width: 400px">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title">Complete Your Profile</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form id="cprofileForm" method="post">
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

                                                    <div class="form-group">
                                                        <label>Date Format</label>
                                                        <select name="date_format" id="date-format" class="form-control m-bot15">
                                                            <option value="mm-dd-yyyy">mm-dd-yyyy</option>
                                                            <option value="dd-mm-yyyy">dd-mm-yyyy</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label >Timezone </label>
                                                        <?= timezone_menu('UTC') ?>
                                                    </div>
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
                        $path = $this->session->userdata('u_profile_pic');
                        $img_src_setup = ($path != "") ?
                                "https://mikhailkuznetsov.s3.amazonaws.com/" . $path :
                                base_url() . 'assets/dashboard/img/default-avatar.png';
                        ?>
                        <div class="modal fade" id="uploadSetup" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" style="max-width: 400px">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title">Upload Your Profile Picture</h4>
                                    </div>
                                    <form id="uploadForm" method="post" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <div class="row" style="margin-bottom: 5%">
                                                    <div class="col-md-12" style="text-align: center">
                                                        <div  class="image" style="text-align: center">
                                                            <img id="profile_previewing" style="width: 100px;height: 100px"  src="<?= $img_src_setup ?>" class="img-circle" alt="User Image" />
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
                                        <form id="conForm" method="post">
                                            <div class="form-group">
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
                                            <div class="form-group" >
                                                <label>Birthday</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input style="z-index: 0" name="birthday" placeholder="Enter Birthdate" value="<?= isset($contacts) ? $this->wi_common->getUTCDate($contacts->birthday) : '' ?>"  class="form-control form-control-inline input-medium default-date-picker" size="16" type="text" required="">
                                                </div><!-- /.input group -->
                                            </div><!-- /.form group -->
                                            <div class="form-group" >
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
                                            <span id="msgContact"></span>
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
                        <script type="text/javascript">
                            $(document).ready(function () {
                                var isValid = true;
                                $('.setup a').on('click', function () {
                                    var id = $(this).prop('id');
                                    setTimeout(function () {
                                        $('.modal-backdrop').css('z-index', '999');
                                    }, 300);
                                    switch (id) {
                                        case "upload":
                                            $('#uploadSetup .modal-title').text("Complete Your Profile");
                                            break;
                                        case "profile":
                                            $('#profileSetup .modal-title').text("Upload Your Profile Photo");
                                            break;
                                        case "contact":
                                            $('#contactSetup .modal-title').text("Complete Your Profile");
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
                                        reader.onload = UploadImageIsLoaded;
                                        reader.readAsDataURL(this.files[0]);
                                        isValid = true;
                                    }
                                });

                                function UploadImageIsLoaded(e) {
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
                                                $("#uploadForm #error_message").css('color', 'green');
                                                $("#uploadForm #error_message").html("Profile Picture Successfully Uploaded..!");
                                                setTimeout(function () {
                                                    $('.discard').trigger('click');
                                                    location.reload(true);
                                                }, 1000);
                                            } else {
                                                $('#uploadBtn').prop('disabled', false);
                                                $("#uploadForm #error_message").css('color', 'red');
                                                $("#uploadForm #error_message").html("Profile Picture Uploading Failed..!");
                                            }
                                        }
                                    });
                                }));
                                /**********************************************************************/

                                /*************************Complete Your Profile************************/
                                $('#profileBtn').on('click', function () {
                                    var id = $(this).prop('id');
                                    $('#' + id).prop('disabled', true);
                                    $('#loadProfile').show();
                                    $.ajax({
                                        type: 'POST',
                                        data: $('#cprofileForm').serialize(),
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
                                $('#contactSetup input[name="fname"]').focusout(function () {
                                    var str = $(this).val() + "'s";
                                    $('#contactSetup  input[name="birthday"]').attr('placeholder', 'Enter ' + str + ' Birthdate');
                                    $('#contactSetup input[name="phone"]').attr('placeholder', 'Enter ' + str + ' Phone Number');
                                });
                                $('#contactSetup input[name="birthday"]').focusout(function () {
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
                                                $('#contactSetup  input[name="zodiac"]').val(data);
                                                $('#contactSetup  input[name="age"]').val(age);
                                            }
                                        });
                                    } else {
                                        $('#contactSetup  input[name="zodiac"]').val('');
                                        $('#contactSetup  input[name="age"]').val('');
                                    }
                                });
                                $('#contactSetup #contactBtn').on('click', function () {
                                    var id = $(this).prop('id');
                                    $('#' + id).prop('disabled', true);
                                    $('#loadContact').show();
                                    $.ajax({
                                        type: 'POST',
                                        data: $('#contactSetup #conForm').serialize(),
                                        url: "<?= site_url() ?>app/contacts/add_contact",
                                        success: function (data, textStatus, jqXHR) {
                                            $('#loadContact').hide();
                                            if (data == "1") {
                                                $("#contactSetup #msgContact").css('color', 'green');
                                                $("#contactSetup #msgContact").html("Contact Successfully Added..!");
                                                setTimeout(function () {
                                                    $('.discard').trigger('click');
                                                    location.reload(true);
                                                }, 1000);
                                            } else {
                                                $("#contactSetup #msgContact").css('color', 'red');
                                                $("#contactSetup #msgContact").html("Contact has not been Added..!");
                                                $('#' + id).prop('disabled', false);
                                            }
                                        }
                                    });
                                });
                            });
                        </script>
                    </li>
                </ul>
                <span class="separator"></span>
                <div class="row" style="float: right">
                    <div class="col-md-12">
                        <a style="margin-top: 6px;font-size: 16px;" class="btn btn-info" href="<?= site_url() ?>app/upgrade">
                            Upgrade
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

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
                                        <div class="col-md-4">
                                            <button type="button" value="support" class="btn btn-primary pull-left send-query">Send</button>
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
                                        text: "Have question or feedback?<br/> We`re always happy to hear from you!",
                                        title: {text: "Feedback / Support"}
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
                        $('.scrape-contact,.query_popup').click(function () {
                            $('#supportForm .msg').text('');
                            setTimeout(function () {
                                $('.modal-backdrop').css('z-index', '999');
                            }, 100);
                        });
                        $('.send-query').click(function () {
                            var val = $(this).val();
                            var form = (val == "support") ? "#supportForm" : "#feedbackForm";
                            var country = $(form + ' #country').val();
                            var query = $(form + ' #query').val();
                            $(form + ' .load').css('display', 'block');
                            $(form + ' .msg').css('display', 'none');
                            $(this).prop('disabled', true);
                            $.ajax({
                                type: 'POST',
                                url: "<?= site_url() ?>app/dashboard/sendQuery",
                                data: {country: country, query: query},
                                success: function (data, textStatus, jqXHR) {
                                    $(form + ' .send-query').prop('disabled', false);
                                    $(form + ' .load').css('display', 'none');
                                    $(form + ' .msg').css('display', 'block');
                                    if (data) {
                                        $(form + ' .msg').html("Thank you for your Feedback!");
                                        $(form + ' .msg').css('color', 'green');
                                    }
                                    else {
                                        $(form + ' .msg').html("Your Query Not Sent..!Please Try Again..!");
                                        $(form + ' .msg').css('color', 'red');
                                    }
                                    $(form).trigger('reset');
                                    setTimeout(function () {
                                        $(form + ' .discard').trigger('click');
                                    }, 500);
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
                                reader.onload = profileImageIsLoaded;
                                reader.readAsDataURL(this.files[0]);
                            }
                            $('#profileForm').submit();
                        });
                        function profileImageIsLoaded(e) {

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
<?php $userInfo = $this->wi_common->getUserInfo($this->session->userdata('u_userid')); ?>



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
                    <h4 class="modal-title">
                        Phone Verification
                        <i 
                            title="Why do i need to verify my phone number?
                            We use your phone number to allow you to setup SMS notification for yourself." class="fa fa-question-circle"></i>
                    </h4>

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
                                        <a href="javascript:void(0);" id="non-us" data-toggle="modal" data-target="#nonus-modal">
                                            Have a Non-US Number?
                                        </a>
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

    <div class="modal fade" id="nonus-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 400px">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p>
                                Unfortunately as of right now we don't support non-US phone numbers (bear with us, we're still a startup!).
                                However, please <a href="javascript:void(0);" id="feedback" data-toggle="modal" data-target="#feedback-modal">send us an email</a> with your country, and we will let you know as soon as it is available (hopefully soon!)
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

    <div class="modal fade" id="feedback-modal" tabindex="-1" role="dialog" aria-hidden="true">
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

    <script type="text/javascript">
        $(function () {
            $("[data-mask]").inputmask();
        });
        $(document).ready(function () {

            $('#feedback').click(function () {
                $('#feedbackForm span.msg').text('');
                $('.discard').trigger('click');
            });

            $('#varify_phone').on("keypress", function (e) {
                if (e.keyCode == 13) {
                    $('#sendcode').trigger('click');
                }
            });
            $('input[name="verifycode"]').on("keypress", function (e) {
                if (e.keyCode == 13) {
                    $('#code_submit').trigger('click');
                }
            });

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
<?php
$time = date('Y-m-d H:i:s', gmt_to_local(time(), $userInfo->timezones, TRUE));


$hour = date('H', strtotime($time));
$minute = date('i', strtotime($time));
$second = date('s', strtotime($time));


if ($hour == 00) {
    $hour = 23;
} else {
    $hour = ($userInfo->timezones == "UM9") ? $hour : $hour - 1;
}
//echo $time.'<br>';
//echo $hour.'<br>';
?>
<script type="text/javascript">
    var hours = <?= $hour ?>;
    var minutes = <?= $minute ?>;
    var seconds = <?= $second ?>;
    setInterval(function () {
        seconds++;
        if (seconds > 59) {
            minutes++;
            seconds = 0;
        }
        if (minutes > 59) {
            hours++;
            minutes = 0;
        }

        var h = (hours < 10) ? "0" + hours : hours;
        var m = (minutes < 10) ? "0" + minutes : minutes;
        var s = (seconds < 10) ? "0" + seconds : seconds;
        $currTime = h + " : " + m + " : " + s;
        $('#curr_time').text($currTime);
    }, 1000);
</script>
<!--<script type="text/javascript"  src="<?= base_url() ?>assets/dashboard/js/plugins/clock/js/flipclock.js"></script>-->
<!--<script type="text/javascript">
                    var clock;
                    $(document).ready(function () {
                        var date = new Date('2014-01-01 05:02:12 pm');

                        clock = $('.clock').FlipClock(date, {
                            clockFace: 'TwentyFourHourClock'
                        });
                    });
</script>-->