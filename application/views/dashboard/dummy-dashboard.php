<html>
    <head>
        <meta charset="UTF-8">
        <title>Wish-Fish</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

        <link rel="shortcut icon" href="<?= base_url() ?>assets/dashboard/favicon.ico" type="image/x-icon">
        <link rel="icon" href="<?= base_url() ?>assets/dashboard/favicon.ico" type="image/x-icon">

        <!-- Bootstrap -->
        <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"/>


        <!-- Ionicons -->
        <link rel="stylesheet" type="text/css" href="//code.ionicframework.com/ionicons/1.5.2/css/ionicons.min.css"/>


        <!-- Theme Style -->
        <!--<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dashboard/css/AdminLTE.css"/>-->
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dashboard/css/AdminLTE.min.css"/>
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dashboard/css/all-skins.min.css"/>



        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->


        <!-- JQuery -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

        <!-- JQuery UI -->
        <script src="//code.jquery.com/ui/1.11.1/jquery-ui.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="<?= base_url() ?>assets/dashboard/js/AdminLTE/jquery.resize.js"></script>

        <!--BOOTSTRAP--> 
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" type="text/javascript"></script>

        <!-- Alertify -->
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dashboard/css/alertify.core.css"/>
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dashboard/css/alertify.default.css"/>

        <!--Alertify-->
        <script type="text/javascript" src="<?= base_url() ?>assets/dashboard/js/alertify.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>assets/dashboard/js/alertify.min.js"></script>



    </head>

    <body class="skin-blue layout-top-nav">
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
        </style>
        <?php
        $profile_pic = $this->session->userdata('profile_pic');

        $img_src = ($profile_pic != "") ?
                "http://mikhailkuznetsov.s3.amazonaws.com/" . $profile_pic :
                base_url() . 'assets/dashboard/img/default-avatar.png';
        ?>
        <header style="z-index: 0" class="main-header">
            <nav class="navbar navbar-static-top">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a href="<?= site_url() ?>app/dashboard" class="title-logo">
                            <?= (!$userInfo) ? $this->session->userdata('d-name') : $userInfo->name ?>
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
                            <li>
                                <a href="<?= site_url() ?>app/calender">
                                    <i class="fa fa-th"></i> <span>Calender</span>
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
                        </ul>
                        <ul class="nav navbar-nav navbar-right" id="wishfish-profile">
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="glyphicon glyphicon-user"></i>
                                    <span><i class="caret"></i></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li class="user-header bg-light-blue">
                                        <form id="profileForm" method="post" action="" enctype="multipart/form-data">
                                            <input name="profile" style="position: absolute;left: -9999px" id="profile-image-upload" class="hidden" type="file">
                                            <div id="image_preview">
                                                <img id="profile_pic" style="cursor: pointer;" src="<?= $img_src ?>" class="img-circle" alt="User Image" />
                                            </div>
                                            <p>
                                                <?= (!$userInfo) ? $this->session->userdata('d-name') : $userInfo->name ?>
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
                                        <div class="pull-left">
                                            <a href="<?= site_url() ?>app/profile" class="btn btn-default btn-flat">Profile</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="<?= site_url() ?>app/logout" class="btn btn-default btn-flat">Sign out</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>
        </header>
        <style type="text/css">
            .overlay{
                /*display:none;*/
                position:absolute;
                background:rgba(0,0,0,0.50) 0%;
                background:-moz-linear-gradient(top, rgba(0,0,0,0.50) 0% 0%, rgba(0,0,0,0.60) 100% 100%);
                background:-webkit-gradient(linear, left top, left bottom, color-stop(0%, rgba(0,0,0,0.50) 0%), color-stop(100%, rgba(0,0,0,0.60) 100%));
                background:-webkit-linear-gradient(top, rgba(0,0,0,0.50) 0% 0%, rgba(0,0,0,0.60) 100% 100%);
                background:-o-linear-gradient(top, rgba(0,0,0,0.50) 0% 0%, rgba(0,0,0,0.60) 100% 100%);
                background:-ms-linear-gradient(top, rgba(0,0,0,0.50) 0% 0%, rgba(0,0,0,0.60) 100% 100%);
                background:linear-gradient(to bottom, rgba(0,0,0,0.50) 0% 0%, rgba(0,0,0,0.60) 100% 100%);
                filter:progid:DXImageTransform.Microsoft.gradient( startColorstr='rgba(0,0,0,0.50) 0%', endColorstr='rgba(0,0,0,0.60) 100%', GradientType=0 );
                filter:progid:DXImageTransform.Microsoft.gradient(startColorStr='#444444', EndColorStr='#000000');
                top:0;
                left:0;
                z-index:30;
                width:100%;
                height:100%
            }
            .overlay div.msg{
                padding: 14% 21%;
                color: white
            }
        </style>
        <aside class="right-side" style="min-height: 542px;">
            <div class="overlay" style="">
                <div class="msg">
                    <div class="welcome" style="display: none">
                        <h1 style="text-align: center">Welcome to Wish-Fish!<br/>Please click the 'Activate Your Account' Button in your Email To Get Started!</h1>
                        <h3>Didn't get our Email? No worries, <a href="javascript:void(0);" id="active">Click Here</a> To Active Your Account.</h3>
                    </div>
                    <div class="row set-passwd" style="display: none" >
                        <div class="col-md-3"></div>
                        <form id="passForm" action="<?= site_url() ?>app/dashboard/updatePassword" method="post">
                            <div class="col-md-6" style="text-align: center;">
                                <lable><h2>Please set a password:</h2></lable>
                                <input id="passwd" type="password" name="password" placeholder="Please Enter a New Password" class="form-control" required /><br/>
                                <input id="confirm_passwd" type="password" placeholder="Please Confirm your new password" class="form-control" required /><br/>
                                <button  type="submit" class="btn btn-primary">Let's Get Started!</button> <br/>
                                <span id="msgPass" style="color: red"></span>
                            </div>
                            <input type="hidden" name="userid" value="<?= ($userInfo) ? $userInfo->user_id : $this->session->userdata('d-userid') ?>" />
                            <input type="hidden" name="type" value="<?= (isset($isForgot) && $isForgot) ? 'forgot' : 'welcome' ?>" />
                        </form>
                        <div class="col-md-3"></div>
                    </div>
                </div>
            </div>
            <section class="content-header">
                <h1>
                    Dashboard
                </h1>
            </section>
            <!-- Main content -->
            <section class="content">
                <!--                <div class="row" style="margin: 10%">
                                    <div class="col-md-3"></div>
                                    <div id="wishfish-title" class="col-md-6" style="text-align: center">
                                        <h1>Welcome To Wish Fish</h1>
                                    </div>
                                    <div class="col-md-3"></div>
                                </div>-->
            </section>
        </aside>
        <footer class="main-footer">
            <div class="container-fluid">
                <strong>Copyright &copy; 2015 White Coda Inc.</strong> All rights reserved.
            </div><!-- /.container -->
        </footer>
        <script type="text/javascript">
            $(function () {
<?php if (!$flag): ?>
                    $('div.welcome').show();
                    $('div.set-passwd').hide();
<?php else: ?>
                    $('div.welcome').hide();
                    $('div.set-passwd').show();
<?php endif; ?>
            });
            $(document).ready(function () {

                var pass = 1;
                var confirmpass = 1;

                $('#active').on('click', function () {
                    $('div.welcome').hide();
                    $('div.set-passwd').show();
                });

                $('#passwd').focusout(function () {
                    var passwd = $(this).val();
                    var confirmpasswd = $('#confirm_passwd').val();
                    if (confirmpasswd !== "") {
                        if (passwd !== confirmpasswd) {
                            $('#msgPass').text("Password must be same as above!");
                            pass = 0;
                        } else {
                            pass = 1;
                        }
                    }
                });

                $('#confirm_passwd').focusout(function () {
                    var confirmpasswd = $(this).val();
                    var passwd = $('#passwd').val();
                    if (passwd !== confirmpasswd) {
                        $('#msgPass').text("Password must be same as above!");
                        confirmpass = 0;
                    }
                    else {
                        $('#msgPass').empty();
                        confirmpass = 1;
                    }
                });

                $('#passForm').on('submit', function () {
                    if (pass === 0 || confirmpass === 0)
                    {
                        $('#msgPass').text("Password Must be Same..!");
                        return false;
                    }
                });

                $('#sendAgain').on('click', function () {
                    $.ajax({
                        type: 'POST',
                        url: "<?= site_url() ?>app/dashboard/sendActivationEmail",
                        success: function (data, textStatus, jqXHR) {
                            if (data == 1) {
                                alertify.success("Email has been successfully sent..!");
                            } else {
                                alertify.error("Email sending failed! Try Again..!");
                            }
                        }
                    });
                });
            });
        </script>
    </body>
</html>