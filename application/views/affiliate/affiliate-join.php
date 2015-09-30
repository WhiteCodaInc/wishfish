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
        <link href="<?= base_url() ?>favicon.ico" rel="Shortcut Icon" type="image/x-icon" />

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
                        <div class="title text-center"><h1>Create Account</h1></div>
                        <div class="separator text-center" style="margin-bottom: 40px;"></div>
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <!-- CONTACT FORM -->
                        <div data-wow-offset="10" data-wow-duration="1.55s" class="wow rollIn animated contact-form m-bot15">
                            <form method="post" action="<?= site_url() ?>affiliate/join/signup" role="form" >
                                <fieldset>
                                    <div class="row m-bot15">
                                        <div class="col-md-12">
                                            <input maxlength="255" type="text" class="form-control" name="fullname"  placeholder="Your Name" required="">
                                        </div>
                                    </div>
                                    <div class="row m-bot15">
                                        <div class="col-md-12">
                                            <input type="email" class="form-control " name="email"  placeholder="Your Email Address" required="">
                                        </div>
                                    </div>
                                    <?php $msg = $this->input->get('msg'); ?>
                                    <?php if (isset($msg) && $msg == "R"): ?>
                                        <div class="row m-bot15">
                                            <div class="col-md-12" style="text-align: center">
                                                <span style="color:red">Email Already Exists..!</span>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <div class="row m-bot15">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <p style="text-align: center">
                                                    By clicking Register, I agree to the 
                                                    <a href="#">Terms of Service</a> and 
                                                    <a href="#">Privacy Policy</a>.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row m-bot15">
                                        <div class="col-md-12">
                                            <button class="btn btn-primary btn-lg" type="submit" > Create Account</button>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                        <div class="row" style="margin-top: 15px">
                            <div class="col-md-1"></div>
                            <div style="padding-left: 10%" class="col-md-10">
                                Already have an account?
                                <a  href="<?= site_url() ?>affiliate/login">Sign in</a>
                            </div>
                            <div class="col-md-1"></div>
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
            case "RF":
                $m = "It`s look like you have a Google App account,But the Login Services are disabled.Please contact your Google App account administrator";
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
