<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Wish-Fish</title>
        <link href="<?= base_url() ?>assets/img/favicon.ico" rel="Shortcut Icon" type="image/x-icon" />

        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet" type="text/css">
        <link href="http://fonts.googleapis.com/css?family=Raleway:500,400,300" rel="stylesheet" type="text/css">

        <link rel="stylesheet" href="<?= base_url() ?>assets/wow/css/themes/default/default.css">
        <link rel="stylesheet" href="<?= base_url() ?>assets/wow/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="<?= base_url() ?>assets/wow/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?= base_url() ?>assets/wow/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?= base_url() ?>assets/wow/css/style.css">
        <link rel="stylesheet" href="<?= base_url() ?>assets/wow/css/responsive.css">

        <!-- Color CSS -->
        <link rel="stylesheet" href="<?= base_url() ?>assets/wow/css/colors/blue.css">

        <!--DARK CSS-->
        <!-- <link rel="stylesheet" href="<?= base_url() ?>assets/wow/css/colors/dark.css">-->

        <!-- Alertify -->
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/alertify/alertify.core.css"/>
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/alertify/alertify.default.css"/>

        <style type="text/css">
            .form-group{
                margin: 10px 0
            }
            .btn-social {
                position: relative;
                text-align: right;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                padding: 11px 37px;
                border-radius: 0;
                float: left;
                width: 40%;
                margin: 10px !important;
            }
            .btn-social :first-child {
                position: absolute;
                left: 0;
                top: 0;
                bottom: 0;
                width: 45px !important;
                line-height: 46px !important;
                font-size: 1.4em!important;
                text-align: center;
                border-right: 1px solid rgba(0, 0, 0, 0.2);
            }
            .btn-facebook {
                color: #ffffff;
                background-color: #3b5998;
                border-color: rgba(0, 0, 0, 0.2);
            }
            .btn-facebook:hover,
            .btn-facebook:focus{
                color: #ffffff;
                background-color: #30487b;
                border-color: rgba(0, 0, 0, 0.2);
            }
            .btn-google-plus {
                color: #ffffff;
                background-color: #dd4b39;
                border-color: rgba(0, 0, 0, 0.2);
            }
            .btn-google-plus:hover,
            .btn-google-plus:focus{
                color: #ffffff;
                background-color: #ca3523;
                border-color: rgba(0, 0, 0, 0.2);
            }
        </style>

        <script src="<?= base_url() ?>assets/wow/js/vendor/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>assets/wow/js/bootstrap.min.js"></script>
        <script src="<?= base_url() ?>assets/wow/js/vendor/modernizr-2.6.2.min.js"></script>

        <!--Alertify-->
        <script type="text/javascript" src="<?= base_url() ?>assets/alertify/alertify.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>assets/alertify/alertify.min.js"></script>

    </head>
    <body>
        <!--Contact form-->
        <section id="contact" class="sections" style="height: 578px">
            <div class="container">
                <div class="row contact-2">
                    <!--  Heading-->
                    <div class="heading wow fadeIn animated" data-wow-offset="120" data-wow-duration="1.5s">
                        <div class="title text-center"><h1>Login</h1></div>
                        <div class="separator text-center" style="margin-bottom: 40px;"></div>
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <!-- CONTACT FORM -->
                        <div data-wow-offset="10" data-wow-duration="1.55s" class="wow rollIn animated contact-form m-bot15">
                            <form method="post" action="<?= site_url() ?>login/signin" role="form" >
                                <fieldset>
                                    <div class="row m-bot15">
                                        <div class="col-md-12">
                                            <input value="<?= $uname ?>" type="email" class="form-control " name="email"  placeholder="Your Email Address" required="">
                                        </div>
                                    </div>

                                    <div class="row m-bot15">
                                        <div class="col-md-12">
                                            <input type="password" value="<?= $passwd ?>" class="form-control " name="password"  placeholder="Your Password" required="">
                                        </div>
                                    </div>
                                    <div class="row m-bot15">
                                        <div class="col-md-1">
                                            <input  class="form-control" style="width: 20px;margin: 0;" type="checkbox" name="remember"/> 
                                        </div>
                                        <div style="margin-top: 13px;" class="col-md-11">
                                            <span  id="remember" style="cursor: pointer">Remember me</span>
                                        </div>
                                    </div>
                                    <?php $msg = $this->input->get('msg'); ?>
                                    <?php if (isset($msg) && $msg == "F"): ?>
                                        <div class="row m-bot15">
                                            <div class="col-md-12" style="text-align: center">

                                                <span style="color:red">Username or Passsword is invalid..!</span>

                                            </div>
                                        </div>
                                        <br/>
                                    <?php endif; ?>

                                    <div class="row m-bot15">
                                        <div class="col-md-12">
                                            <button class="btn btn-primary btn-lg" type="submit" > Log In</button>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-4"></div>
                </div>
                <div class="row" style="margin-top: 15px">
                    <div class="col-md-1"></div>
                    <div  style="text-align: center" class="col-md-10">
                        Don't have an account?
                        <a href="<?= site_url() ?>register">Create account</a> | 
                        <a href="javascript:void(0);"  data-toggle="modal" data-target="#new-event">Forgot Password</a>
                    </div>
                    <div class="col-md-1"></div>
                </div>
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6" style="margin: 0 50px;">
                        <a  href = "<?= $url ?>" style="padding: 11px 40px;" class="btn btn-block btn-social btn-google-plus">
                            <i class="fa fa-google-plus"></i> Login with Google
                        </a>
                        <a   style="padding: 11px 21px;" class="btn btn-block btn-social btn-facebook facebook"  href = "javascript:void(0);">
                            <i class="fa fa-facebook"></i> Login with Facebook
                        </a>
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>
            <div class="modal fade" id="new-event" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" style="width: 400px">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3>Forgot Password</h3>
                        </div>
                        <div class="modal-body" >
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="email" id="forgotEmail" placeholder="Enter your email address" class="form-control" />
                                    <span id="msg" style="color: red;"></span>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-6">
                                    <h1 id="captcha_img" style="text-align: center;background-image:url(<?= base_url() ?>assets/wow/images/captcha_background.png); ">
                                        <?= $word ?>
                                    </h1>
                                </div>
                                <div class="col-md-3">
                                    <img id="refresh" src="<?= base_url() ?>assets/refresh.png" alt="refresh" />
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="text" id="captcha_word" class="form-control" placeholder="Enter Captcha Here" />
                                    <span id="msgCaptcha" style="color: red"></span>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-4" style="text-align: center">
                                    <button type="button" id="send" class="btn btn-primary btn-lg">Send</button>
                                </div>
                                <div class="col-md-8">
                                    <div style="display: none" id="loadSend">
                                        <img src="<?= base_url() ?>assets/dashboard/img/load.GIF" alt="" />
                                    </div>
                                    <span id="msgSend"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- FOOTER Section-->
        <footer id="footer" class="footer-2 bg-midnight-blue">
            <div class="container">
                <div class="col-sm-12" style="text-align: center">
                    <div class="additional-links editContent">
                        <a style="text-decoration: none" href="#">Privacy Policy</a> | <a style="text-decoration: none" href="#">Terms of Service</a> |
                        <span class="footer-entry last">
                            Copyright 2015 White Coda Inc. All rights reserved.
                        </span>
                    </div>
                </div>
            </div>
        </footer>
        <?php
        switch ($msg) {
            case "R":
                $m = "This Email Has Already Been Used! Please Use Forgot Password!..:)";
                $t = "error";
                break;
            default:
                $m = 0;
                break;
        }
        ?>
        <script type="text/javascript">
<?php if ($msg): ?>
                alertify.<?= $t ?>("<?= $m ?>");
<?php endif; ?>
        </script>
        <script type="text/javascript">
            $(document).ready(function () {

                var emailV = 1;
                var captchaV = 1;
                var sess_word = "<?= $this->session->userdata('captchaWord') ?>";
                $('#forgotEmail').focusout(function () {
                    var email = $(this).val();
                    if (email.trim() != "") {
                        $.ajax({
                            type: "POST",
                            data: {email: email},
                            url: "<?= base_url() ?>home/checkEmail",
                            success: function (res) {
                                if (res == 0) {
                                    emailV = 0;
                                    $('#msg').text('Your Email is not register!');
                                }
                                else {
                                    $('#msg').empty();
                                    emailV = 1;
                                }
                            }
                        });
                    } else {
                        emailV = 0;
                    }
                });
                $('#captcha_word').focusout(function () {
                    var word = $(this).val();
                    if (word.trim() != "") {
                        if (word != sess_word) {
                            captchaV = 0;
                            $('#msgCaptcha').text("Captcha Invalid..!");
                        } else {
                            captchaV = 1;
                            $('#msgCaptcha').empty();
                        }
                    } else {
                        captchaV = 0;
                    }
                });
                $('#send').click(function () {
                    var email = $('#forgotEmail').val();
                    if (emailV === 0 || captchaV === 0)
                        return false;
                    $('#refresh').trigger('click');
                    $('#loadSend').css('display', 'block');
                    $.ajax({
                        type: "POST",
                        data: {email: email},
                        url: "<?= base_url() ?>home/sendMail",
                        success: function (res) {
                            $('#loadSend').css('display', 'none');
                            if (res == 1) {
                                $('#msgSend').css('color', 'green');
                                $('#msgSend').text('Check your email to get your link..!');
                            } else {
                                $('#msgSend').css('color', 'red');
                                $('#msgSend').text('Email sending failed..!Try Again!');
                            }
                            $('#forgotEmail').val("");
                            $('#captcha_word').val("");
                            setTimeout(function () {
                                $('#msgSend').empty();
                                $('.close').trigger('click');
                            }, 1000);

                        }
                    });
                });

                $("#refresh").click(function () {
                    $(this).css('cursor', 'progress');
                    $.ajax({
                        type: "POST",
                        url: "<?= base_url() ?>home/captcha_refresh",
                        success: function (res) {
                            $('#refresh').removeAttr('style');
                            if (res) {
                                sess_word = res;
                                $("#captcha_img").html(res);
                            }
                        }
                    });
                });

                $('#remember').click(function () {
                    $('input[name="remember"]').trigger('click');
                });
            });
        </script>
        <script type="text/javascript">
            window.fbAsyncInit = function () {
                //Initiallize the facebook using the facebook javascript sdk
                FB.init({
                    appId: '<?= $this->config->item('appID'); ?>', // App ID 
                    cookie: true, // enable cookies to allow the server to access the session
                    status: true, // check login status
                    xfbml: true, // parse XFBML
                    oauth: true //enable Oauth 
                });
            };
            //Read the baseurl from the config.php file
            (function (d) {
                var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
                if (d.getElementById(id)) {
                    return;
                }
                js = d.createElement('script');
                js.id = id;
                js.async = true;
                js.src = "//connect.facebook.net/en_US/all.js";
                ref.parentNode.insertBefore(js, ref);
            }(document));
            //Onclick for fb login
            $('.facebook').click(function (e) {
                FB.login(function (response) {
                    if (response.authResponse) {
                        parent.location = '<?= site_url() ?>register/fbsignup'; //redirect uri after closing the facebook popup
                    }
                }, {scope: 'email,read_stream,user_birthday,user_photos'}); //permissions for facebook
            });
        </script>
    </body>
</html>
