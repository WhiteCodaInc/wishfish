<style type="text/css">
    .overlay{
        position:absolute;
        background:rgba(0,0,0,0.85) 0%;
        background:-moz-linear-gradient(top, rgba(0,0,0,0.85) 0% 0%, rgba(0,0,0,0.95) 100% 100%);
        background:-webkit-gradient(linear, left top, left bottom, color-stop(0%, rgba(0,0,0,0.85) 0%), color-stop(100%, rgba(0,0,0,0.95) 100%));
        background:-webkit-linear-gradient(top, rgba(0,0,0,0.85) 0% 0%, rgba(0,0,0,0.95) 100% 100%);
        background:-o-linear-gradient(top, rgba(0,0,0,0.85) 0% 0%, rgba(0,0,0,0.95) 100% 100%);
        background:-ms-linear-gradient(top, rgba(0,0,0,0.85) 0% 0%, rgba(0,0,0,0.95) 100% 100%);
        background:linear-gradient(to bottom, rgba(0,0,0,0.85) 0% 0%, rgba(0,0,0,0.95) 100% 100%);
        filter:progid:DXImageTransform.Microsoft.gradient( startColorstr='rgba(0,0,0,0.85) 0%', endColorstr='rgba(0,0,0,0.95) 100%', GradientType=0 );
        filter:progid:DXImageTransform.Microsoft.gradient(startColorStr='#444444', EndColorStr='#000000');
        left:0;
        z-index:30;
        width:100%;
        height:100%
    }
    .social-register{
        display:none;
    }
    .sign{
        top: 0;
        display:none;
    }

    .overlay .cancel {
        position: absolute;
        right: 0;
        padding: 3%;
        color: white;
        text-decoration: none;
        text-transform: uppercase;
    }

    .btn-social {
        position: relative;
        text-align: left;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        padding: 11px 60px;
        border-radius: 0;
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
    .pricing2 .bottom > a {
        margin: 5% 16%;
        display: block;
        width: 75%;
        padding: 3%;
        font-size: 20px
    }
</style>



<!-- if you like to use surface. change class="home" to class="surface"-->
<section id="home" class="home">
    <div class="overlay sign" style="display: none;min-height: 0">
        <a style="padding: 6%"  href="javacript:void(0);" class="cancel">close <i class="fa fa-close"></i></a>
        <div class="row" style="  margin: 7% 10%;">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <form id="registerForm" action="<?= site_url() ?>register/createAccount"  method="post" class="registration" >
                    <h1 style="color: white;font-size: 30px;text-align: center">Register</h1>
                    <div class="row" style="color: white">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="text" name="name" class="form-control"   placeholder="Your Full Name" required="" />
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" class="form-control"   placeholder="Your Email address" required=""/>
                            </div>
                            <div class="form-group">
                                <p class="legal">
                                    By clicking Register, I agree to the 
                                    <a href="<?= site_url() ?>terms-of-services">Terms of Service</a> and 
                                    <a href="<?= site_url() ?>privacy-policy">Privacy Policy</a>.
                                </p>
                            </div>
                            <div style="text-align: center" class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg">Register</button>
                            </div>
                            <div class="form-group">
                                <p style="text-align: center">
                                    Already have an account? 
                                    <a id="log" href="#">Log In</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <a href = "<?= site_url() ?>register?from=home" class="btn btn-block btn-social btn-google-plus">
                                <i class="fa fa-google-plus"></i> Sign up with Google
                            </a>
                            <a style="cursor: pointer" id="fb-signup" class="btn btn-block btn-social btn-facebook fb"  href="javascript:void(0);">
                                <i class="fa fa-facebook"></i> Sign up with Facebook
                            </a>
                        </div>
                    </div>
                    <input type="hidden" name="join_via" value="<?= site_url() ?><br/>Join With Email">
                </form>

                <form id="loginForm" action="<?= site_url() ?>login/signin" method="post" class="login" novalidate="novalidate">
                    <h1 style="color: white;font-size: 30px;text-align: center">Log In</h1>
                    <div class="row" style="color: white">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="email" name="email" class="form-control"   placeholder="Your Email address" required=""/>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control"   placeholder="Your Password" required=""/>
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="checkbox" name="remember" style="width: 15px;display: inline;height: 15px;font-size: 20;"/> 
                                <span id="remember" style="cursor: pointer;color: white;font-size: 17px;">Remember me</span>
                            </div>
                            <div style="text-align: center" class="form-group">
                                <button type="submit"  class="btn btn-primary btn-lg">Log In</button>
                            </div>
                            <div class="form-group">
                                <p style="text-align: center">
                                    Don't have an account?<br/> <a href="#" id="reg">Create Account</a> |
                                    <a href="javascript:void(0);"  data-toggle="modal" data-target="#new-event">Forgot Password</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <a href = "<?= site_url() ?>login?from=home" class="btn btn-block btn-social btn-google-plus">
                                <i class="fa fa-google-plus"></i> Login with Google
                            </a>
                            <br/>
                            <a style="cursor: pointer" id="fb-signin" class="btn btn-block btn-social btn-facebook fb"  href = "javascript:void(0);">
                                <i class="fa fa-facebook"></i> Login with Facebook
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-4"></div>
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

    <!-- <div id="surface"></div>-->
    <canvas id="canvas"></canvas>
    <!-- for surface use class overlay to canvas-overlay-->
    <!-- for surface use class overlay to surface-overlay-->
    <div class="canvas-overlay">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="home-intro-subscribe">
                        <!--Header text -->
                        <h1>Discover the easiest way to schedule events with <b>Wish-Fish</b></h1>
                        <h3>Never Again Forget <span  id="typed" style="white-space:pre;color: #1ac6ff;"></span></h3>
                        <!--DOWNLOAD BUTTON -->
                        <div class=" home-subscribe center-block">
                            <form  action="<?= site_url() ?>register/createAccount"  method="post"  class="subscription-form mailchimp form-inline" role="form">
                                <!-- SUBSCRIPTION SUCCESSFUL OR ERROR MESSAGES -->
                                <div class="row">
                                    <div class="col-md-4">
                                        <input style="width: 100%" type="text" name="name"  placeholder="Your Name" class="form-control " required="">
                                    </div>
                                    <div class="col-md-4">
                                        <input style="width: 100%" type="email" name="email"  placeholder="Your Email" class="form-control " required="">
                                    </div>
                                    <div class="col-md-3">
                                        <button style="margin: 0;padding: 13px 30px;width: 100%" type="submit" id="subscribe-button" class="btn btn-primary btn-lg">Join Now!</button>
                                    </div>
                                </div>
                                <input type="hidden" name="join_via" value="<?= site_url() ?><br/>Join With Email">
                            </form>
                        </div>
                        <!-- SUBSCRIBE BUTTON -->
                        <!--<br/>-->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="service" class="sections colorsbg">
    <div class="container">
        <div class="row">
            <div class="col-sm-4 clearfix">
                <div class="feature text-center  wow fadeInLeft animated" data-wow-offset="120" data-wow-duration="1.5s">
                    <i class="fa fa-user" data-selector="i.fa" style="outline: none; cursor: default;"></i>
                    <h4 class="text-white"><?= $add_friend[0] ?></h4>
                    <p class="text-white">
                        <?= $add_friend[1] ?>
                        <!--The busier we get, the less time we have,<br/> but there are always those special people in our lives that we never want to forget.<br/> Wish-fish keeps track of their birthdays,<br/> so you don't have to.-->
                    </p>
                </div><!--end feature-->
            </div>

            <div class="col-sm-4 clearfix">
                <div class="feature text-center  wow fadeIn animated" data-wow-offset="120" data-wow-duration="1.5s">
                    <i class="fa fa-calendar" data-selector="i.fa" style="outline: none; cursor: default;"></i>
                    <h4 class="text-white"><?= $setup_reminder[0] ?></h4>
                    <p class="text-white">
                        <?= $setup_reminder[1] ?>
                        <!--                        If you've ever missed a friends birthday, anniversary, or special event,<br/> you know how embarrassing that can be!<br/> We get it, life can get crazy sometimes...<br/> wish-fish will remind you, so you can live your life to the fullest!-->
                    </p>
                </div><!--end feature-->
            </div>

            <div class="col-sm-4 clearfix">
                <div class="feature text-center  wow fadeInRight animated" data-wow-offset="120" data-wow-duration="1.5s">
                    <i class="fa fa-smile-o" data-selector="i.fa" style="outline: none; cursor: default;"></i>
                    <h4 class="text-white"><?= $sit_back_relax[0] ?></h4>
                    <p class="text-white">
                        <?= $sit_back_relax[1] ?>
                        <!--Once everything is setup, you can sit back, relax, and never have to worry about missing another birthday, anniversary, or special event again, because wish-fish will remind you<br/> at just the right moment!-->
                    </p>
                </div><!--end feature-->
            </div>

        </div><!--end row-->

    </div><!--end container-->
</section>

<section id="features" class="sections">
    <div class="container">
        <div class="row">
            <!--  Heading-->
            <div class="heading black-text wow fadeIn animated" data-wow-offset="120" data-wow-duration="1.5s">
                <div class="title text-center"><h1>Our Features</h1></div>
                <div class="subtitle text-center "><h5>You will love some of our features.</h5></div>
                <div class="separator text-center"></div>
            </div>

            <div class="col-sm-6 wow fadeInLeft animated" data-wow-offset="10" data-wow-duration="1.5s">
                <div class="feature-item text-right pull-left">
                    <div class="feature-icon2 text-right pull-right">
                        <i class="fa fa-thumbs-o-up" data-selector="i.fa" style="outline: none; cursor: default;"></i>
                    </div>
                    <h4><?= $easy_use[0] ?></h4>
                    <p>
                        <?= $easy_use[1] ?>
                        <!--Its as easy as riding a bike... actually... it's even easier, because you don't even have to get up!<br/> A couple clicks, and you're done!-->
                    </p>
                </div>
                <div class="feature-item text-right pull-left">
                    <div class="feature-icon2 text-right pull-right">
                        <i class="fa fa-calendar" data-selector="i.fa" style="outline: none; cursor: default;"></i>
                    </div>
                    <div class="feature-details">
                        <h4><?= $schedule_event[0] ?></h4>
                        <p>
                            <?= $schedule_event[1] ?>
                            <!--You can easily schedule events 24/7,&nbsp;&nbsp;any-time,&nbsp;&nbsp;any-where.  Sit back and relax, we will take care of the rest.-->
                        </p>
                    </div>

                </div>
                <div class="feature-item text-right pull-left">
                    <div class="feature-icon2 text-right pull-right">
                        <i class="fa fa-share" data-selector="i.fa" style="outline: none; cursor: default;"></i>
                    </div>
                    <h4><?= $recurring_event[0] ?></h4>
                    <p>
                        <?= $recurring_event[1] ?>
                        <!--Set it and forget it! Have a family member or client whose birthday you have to remember every year?<br/> Just set an event to repeat, and you'll never have to think about it again!-->
                    </p>
                </div>
            </div>
            <div class="col-sm-6 wow fadeInRight animated" data-wow-offset="10" data-wow-duration="1.5s">
                <div class="feature-item pull-left">
                    <div class="feature-icon2 pull-left">
                        <i class="fa fa-users" data-selector="i.fa" style="outline: none; cursor: default;"></i>
                    </div>
                    <h4><?= $contact_management[0] ?></h4>
                    <p>
                        <?= $contact_management[1] ?>
                        <!--Adding new contacts takes only few seconds.<br/> You can even import your contact list from Google, Facebook, or an excel spreadsheet.-->
                    </p>
                </div>
                <div class="feature-item pull-left">
                    <div class="feature-icon2  pull-left">
                        <i class="fa fa-arrows" data-selector="i.fa" style="outline: none; cursor: default;"></i>
                    </div>
                    <h4><?= $drag_drop_event[0] ?></h4>
                    <p>
                        <?= $drag_drop_event[1] ?>
                        <!--Our dynamic calendar allows you to quickly see what events are coming up, and re-arrange them if your schedule changes.-->
                    </p>
                </div>
                <div class="feature-item pull-left">
                    <div class="feature-icon2 pull-left">
                        <i class="fa fa-cloud-download" data-selector="i.fa" style="outline: none; cursor: default;"></i>
                    </div>
                    <h4><?= $nothing_install[0] ?></h4>
                    <p>
                        <?= $nothing_install[1] ?>
                        <!--Since Wish-Fish is web-based, you never need to worry about installation: just open your web browser & rock n' roll!-->
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- testimonial Section-->
<section class="testimonial">
    <div class="overlay-img">
        <div class="container">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1 padding-eighty">
                    <div class="testimonials">
                        <div class="testimonial-item2">
                            <div class="testimonial-msg"><i class="fa fa-quote-left"></i>
                                Wish-Fish helps me save so much time it's kind of insane!
                                <i class="fa fa-quote-right pull-right"></i></div>
                            <div class="white-separator"></div>
                            <!--  INFORMATION -->
                            <div class="testimonial-name">Mark</div>
                            <!--<div class="testimonial-info">CEO, Envato pty Ltd.</div>-->
                        </div>
                        <div class="testimonial-item2">
                            <div class="testimonial-msg"><i class="fa fa-quote-left"></i>
                                Since I got Wish-Fish I haven't forgotten a single birthday, I swear my friends think I'm psychic!
                                <i class="fa fa-quote-right pull-right"></i></div>
                            <div class="white-separator"></div>
                            <!--  INFORMATION -->
                            <div class="testimonial-name">Laura</div>
                            <!--<div class="testimonial-info">CEO, Envato pty Ltd.</div>-->
                        </div>
                        <div class="testimonial-item2">
                            <div class="testimonial-msg"><i class="fa fa-quote-left"></i>
                                It's weird....you don't think you need it until you get it,but after you get it you wonder how you ever lived without it!
                                <i class="fa fa-quote-right pull-right"></i></div>
                            <div class="white-separator"></div>
                            <!--  INFORMATION -->
                            <div class="testimonial-name">Steve</div>
                            <!--<div class="testimonial-info">CEO, Envato pty Ltd.</div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- testimonial Section End-->

<section id="describe" class="sections">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-push-6">


                <!--  Heading-->
                <div class="heading black-text wow fadeIn animated" data-wow-offset="120" data-wow-duration="1.5s">
                    <div class="title-half"><h1><?= $wishfish_awesome[0] ?></h1></div>
                    <div class="subtitle-half"><h5>Don't just think different, live different.</h5></div>
                    <div class="separator-left"></div>
                </div>

                <div class="describe-details wow fadeInRight animated" data-wow-offset="10" data-wow-duration="1.5s">
                    <p>
                        <?= $wishfish_awesome[1] ?>
                        <!--In a world of chaos, we all have those moments when we wish we could just take a deep breath. With an intuitive dashboard and a customer-driven feature set, not only will you be able to sleep like a baby at night, you will also experience new levels of accomplishment you never before thought possible, here's why:-->
                    </p>

                    <ul class="describe-list">
                        <li><i class="fa fa-h-square" data-selector="i.fa" style="outline: none; cursor: default;"></i> <span>Wish-Fish helps you automate your lifestyle, it does the work so you don't have to.</span> </li>
                        <li><i class="fa fa-database" data-selector="i.fa" style="outline: none; cursor: default;"></i> <span>Wish-Fish is built with you in mind, we actually listen to feedback, and act on it.</span> </li>
                        <li><i class="fa fa-shekel" data-selector="i.fa" style="outline: none; cursor: default;"></i> <span>Wish-Fish is the only software designed to minimize hassle, and maximize productivity.</span> </li>
                        <li><i class="fa fa-database" data-selector="i.fa" style="outline: none; cursor: default;"></i> <span>Wish-Fish cares, I know that sounds cheesy, but we do; if you're not happy, we're not happy.</span> </li>
                    </ul>
                </div>
            </div><!--end half-->

            <div class="col-md-6 col-md-pull-6">
                <div class="text-center describe-images wow fadeInLeft animated" data-wow-offset="10" data-wow-duration="1.5s">
                    <img src="<?= base_url() ?>assets/wow/images/describe-monitor1.png" alt="" data-selector="img" style="">
                </div>
            </div>
        </div><!--end row-->
    </div><!--end container-->
</section><!--end section-->



<!-- funfact Section-->
<section id="funfact" class="funfact">
    <div class="overlay-img">
        <div class="container">
            <div class="row">
                <!-- funfact -->
                <div class="heading white-text wow fadeIn animated" data-wow-offset="120" data-wow-duration="1.5s">
                    <div class="title text-center"><h1>Some Fun Facts About Wish-Fish</h1></div>
                    <div class="separator text-center"></div>
                </div>
                <div class="funfacts-counter white-text">
                    <div class="col-sm-3">
                        <i class="fa fa-trophy"></i>
                        <div class="statistic-counter">1,000</div>
                        <div class="statistic-text">Completed Events</div>
                    </div>
                    <div class="col-sm-3">
                        <i class="fa fa-group"></i>
                        <div class="statistic-counter">100</div>
                        <div class="statistic-text">Satisfied Clients</div>
                    </div>
                    <div class="col-sm-3">
                        <i class="fa fa-calendar"></i>
                        <div class="statistic-counter">2,100</div>
                        <div class="statistic-text">Scheduled Events</div>
                    </div>
                    <div class="col-sm-3">
                        <i class="fa fa-coffee"></i>
                        <div class="statistic-counter">1,356</div>
                        <div class="statistic-text">Cups Of Coffee</div>
                    </div>
                </div>
            </div><!-- funfact row End-->
        </div><!-- funfact Overlay End-->
    </div><!-- funfact Container End-->
</section>
<!-- funfact Section End-->

<!-- Pricing Section-->
<section id="plan" class="sections">
    <div class="pricing">
        <div class="container">
            <div class="row">
                <!--  Heading-->
                <div class="heading wow fadeIn animated" data-wow-offset="120" data-wow-duration="1.5s">
                    <div class="title text-center"><h1>Plans &amp; Pricing</h1></div>
                    <div class="subtitle text-center "><h5>Affordable event scheduling software made for everyone.</h5></div>
                    <div class="separator text-center"></div>
                </div>
                <?php foreach ($pdetail as $plan) { ?>
                    <div class="col-sm-4">
                        <div class="pricing2">
                            <div class="top">
                                <h2><?= $plan->plan_name ?></h2>
                                <p class="price">
                                    <span class="currency">$</span>
                                    <b><?= $plan->amount ?></b> 
                                    <span class="month">/month</span>
                                </p>
                            </div><!-- /.top -->
                            <div class="bottom">
                                <ul>
                                    <li> Add <?= ($plan->contacts == -1) ? "Unlimited" : $plan->contacts ?> Contacts</li>
                                    <li> Schedule Unlimited Events</li>
                                    <li> <b><?= ($plan->sms_events == -1) ? "Unlimited" : $plan->sms_events ?></b> SMS Events per Contact</li>
                                    <li> <b><?= ($plan->email_events == -1) ? "Unlimited" : $plan->email_events ?></b> Email Events per Contact</li>
                                    <li> 
                                        <?=
                                        ($plan->group_events == -1) ?
                                                "<b>Unlimited</b>" :
                                                (($plan->group_events == 0) ? "No" : '<b>' . $plan->group_events . '</b>')
                                        ?>
                                        Group Events
                                    </li>
                                    <li> <?= ($plan->plan_id == 1) ? "-" : "Import Contacts From Google" ?> </li>
                                    <li> <?= ($plan->plan_id == 1) ? "-" : "Import Contacts From Spreadsheet or CSV File" ?></li>
                                </ul>
                                <?php
                                switch ($plan->plan_id) {
                                    case 1:
                                        $id = "free";
                                        $pname = "wishfish-free";
                                        $lable = "Sign Up Now";
                                        break;
                                    case 2:
                                        $couponbox = "p_coupon";
                                        $id = "a_personal";
                                        $pname = "wishfish-personal";
                                        $lable = "Sign Up With Credit Card";
                                        break;
                                    case 3:
                                        $couponbox = "e_coupon";
                                        $id = "a_enterprise";
                                        $pname = "wishfish-enterprise";
                                        $lable = "Sign Up With Credit Card";
                                        break;
                                }
                                ?>
                                <a href="javascript:void(0);" id="<?= $id ?>" class="btn  btn-primary"><?= $lable ?></a>
                                <?php if ($plan->plan_id != 1): ?>
                                    <a href="javascript:void(0);" id="<?= $pname ?>" class="btn btn-primary">Sign Up With Paypal</a>
                                    <div id="<?= $couponbox ?>">
                                        <p class="link" style="text-align: center">
                                            Have you a coupon code? 
                                            <a href="javascript:void(0);" class="coupon">Click Here</a>
                                        </p>
                                        <p style="text-align: center;color:green;display: none;" class="success"></p>
                                        <div class="row couponbox" style="padding: 10px;display: none">
                                            <div class="col-md-9">
                                                <input style="height: 35px" type="text" class="form-control couponcode" placeholder="Coupon Code" />
                                                <span style="color: red" class="msgCoupon"></span>
                                            </div>
                                            <div class="col-md-3">
                                                <button class="btn btn-success apply" type="button" >Apply</button>
                                                <img style="display: none" src="<?= base_url() ?>assets/dashboard/img/load.GIF" />
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div><!-- /.bottom -->
                        </div><!-- /.pricing2 -->
                    </div><!-- /.col-md-4 col -->
                    <?php if ($plan->plan_id == 1): ?>
                        <div class="overlay social-register" style="display: none">
                            <a  href="javacript:void(0);" class="cancel">close <i class="fa fa-close"></i></a>
                            <div class="row" style="  margin: 18% 10%;">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <form  action="<?= site_url() ?>register/createAccount"  method="post"  class="subscription-form mailchimp form-inline" role="form">
                                        <!-- SUBSCRIPTION SUCCESSFUL OR ERROR MESSAGES -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input style="width: 100%;height: 45px" type="email" name="email"  placeholder="Your Email" class="form-control " required="">
                                            </div>
                                        </div><br/>
                                        <div class="row">    
                                            <div class="col-md-12">
                                                <button style="margin: 0;padding: 8px;width: 100%" type="submit" id="subscribe-button" class="btn btn-primary btn-lg">
                                                    <i class="fa fa-envelope-o"></i>
                                                    Sign up with Email
                                                </button>
                                            </div>
                                        </div>
                                        <input type="hidden" name="name" value="">
                                        <input type="hidden" name="join_via" value="<?= site_url() ?><br/>Join With Email">
                                    </form><br/>
                                    <a href = "<?= site_url() ?>register?from=home" class="btn btn-block btn-social btn-google-plus">
                                        <i class="fa fa-google-plus"></i> Sign up with Google
                                    </a>
                                    <br/>
                                    <a style="cursor: pointer" id="fb-signup" class="btn btn-block btn-social btn-facebook" id="facebook" href = "javascript:void(0);">
                                        <i class="fa fa-facebook"></i> Sign up with Facebook
                                    </a>
                                    <!--                                    <br/>
                                                                                        <a href = "<?= site_url() ?>register"  class="btn btn-block btn-social btn-info">
                                                                                            <i class="fa fa-envelope-o"></i>Sign up with Email
                                                                                        </a>-->

                                </div>
                                <div class="col-md-4"></div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php } ?>
            </div><!-- /.row -->
        </div><!-- /.container -->
    </div><!-- /.item -->
</section>

<!--Funfact section-->
<section id="tweets" class="tweets">
    <div class="overlay-img">
        <div class="container">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1 text-center">
                    <div class="twitter-icon"><i class="fa fa-twitter"></i></div>
                    <!--<div id="tweet"></div>-->
                </div>
            </div>
        </div>

    </div>
</section>

<section id="contact" class="sections">
    <div class="container">
        <div class="row">
            <!--  Heading-->
            <div class="heading wow fadeIn animated" data-wow-offset="120" data-wow-duration="1.5s">
                <div class="title text-center"><h1>Contact Us</h1></div>
                <div class="subtitle text-center "><h5>You can use the form below to send us a general inquiry or just say to hello.</h5></div>
                <div class="separator text-center"></div>
            </div>
            <div class="wow fadeIn animated" data-wow-offset="10" data-wow-duration="1.5s">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <!-- CONTACT FORM -->
                    <div class="contact-form">
                        <div id="message"></div>
                        <form action="<?= site_url() ?>home/contactus" class="form-horizontal contact-1" role="form" name="contactform" id="contactform">
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Name">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="email" id="email" placeholder="Email">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input class="form-control" id="subject" type="text" name="subject" placeholder="Subject">
                                    <textarea name="contact-message" id="inquiry_msg" class="form-control" cols="30" rows="5" placeholder="Message"></textarea>
                                    <button type="submit" class="btn btn-primary btn-block contact-1-button" data-loading-text="Loading...">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-4"></div>
            </div>
        </div> <!-- end row -->
    </div>
</section>

<form id="paypal" action="<?= site_url() ?>app/pay">
    <input type="hidden" name="item_name" value="">
    <input type="hidden" name="amount" value="">
    <input type="hidden" name="coupon" value="">
</form>
<form style="display: none" id="personal" action="<?= site_url() ?>stripe_payment/pay" method="post">
    <input type="hidden" name="plan" value="wishfish-personal"/>
    <input type="hidden" name="planid" value="2"/>
    <input type="hidden" name="coupon" value=""/>
    <!--data-image="/square-image.png"-->
    <script
        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
        data-key="<?= $stripe->publish_key ?>"
        data-name="$9.99"
        data-description="1-month of Wish-Fish Personal"                    
        data-label="Stripe"                    
        >
    </script>
</form>

<form style="display: none" id="enterprise" action="<?= site_url() ?>stripe_payment/pay" method="post">
    <input type="hidden" name="plan" value="wishfish-enterprise"/>
    <input type="hidden" name="planid" value="3"/>
    <input type="hidden" name="coupon" value=""/>
    <script
        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
        data-key="<?= $stripe->publish_key ?>"
        data-name="$49.99"
        data-description="1-month of Wish-Fish Enterprise"
        data-label="Stripe"                    
        >
    </script>
</form>

<script type="text/javascript">
    $(document).ready(function () {
        var couponCode = "";
        $('#remember').click(function () {
            $('input[name="remember"]').trigger('click');
        });
        $('.coupon').click(function () {
            var id = $(this).parents().eq(1).prop('id');
            $('#' + id + ' .link').hide();
            $('#' + id + ' div.couponbox').show();
        });
        $('button.apply').click(function () {
            var id = $(this).parents().eq(2).prop('id');
            var code = $('#' + id + ' .couponcode').val().trim();
            var rgex_code = /^[A-Za-z0-9]+$/;
            if (code != "" && !rgex_code.test(code)) {
                $('#' + id + ' .msgCoupon').text("Please Enter Valid Coupon Code..!");
                return false;
            } else {
                $('#' + id + ' .msgCoupon').empty();
                $(this).hide();
                $(this).next().show();
                $.ajax({
                    type: 'POST',
                    data: {code: code},
                    url: "<?= site_url() ?>home/checkCoupon",
                    success: function (data, textStatus, jqXHR) {
                        if (data == "0") {
                            $('#' + id + ' button').show();
                            $('#' + id + ' img').hide();
                            $('#' + id + ' .msgCoupon').text("Coupon Code is Invalid..!");
                        } else {
                            couponCode = code;
                            $('#' + id + ' div.couponbox').hide();
                            $('#' + id + ' p.success').html("Coupon <b style='color:#1ac6ff'>" + code + "</b> was apply successfully..!");
                            $('#' + id + ' p.success').show();
                            if (id == "p_coupon")
                                $('form#personal input[name="coupon"]').val(code);
                            else if (id == "e_coupon")
                                $('form#enterprise input[name="coupon"]').val(code);
                            if (data == "1") {
                                $('form#paypal input[name="coupon"]').val(code);
                            } else {
                                (id == "p_coupon") ?
                                        $('#wishfish-personal').hide() :
                                        $('#wishfish-enterprise').hide();
                            }

                        }
                    }
                });
            }
        });
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
        $('a#log,a#reg').click(function () {
            $("html, body").animate({scrollTop: 0}, 1000);
            setTimeout(function () {
                $('html, body').animate({scrollTop: 0}, 4000);
            }, 4000);
            $('.sign').css('display', 'block');
            var id = $(this).attr('id');
            if (id == "log") {
                $('form.login').css('display', 'block');
                $('form.registration').css('display', 'none');
            } else if (id == "reg") {
                $('form.login').css('display', 'none');
                $('form.registration').css('display', 'block');
            }
        });
        $('.pricing2 a').on('click', function () {
            var id = $(this).prop('id');
            switch (id) {
                case "free":
                    $('.social-register').css('display', 'block');
                    break;
                case "a_personal":
                    $('#personal button').trigger('click');
                    break;
                case "a_enterprise":
                    $('#enterprise button').trigger('click');
                    break;
                case "wishfish-personal":
                case "wishfish-enterprise":
                    var item_name = "";
                    var amount = "";
                    $(this).prop('disabled', 'disabled');
                    if (id == "wishfish-personal") {
                        item_name = "wishfish-personal";
                        amount = "9.99";
                    } else {
                        item_name = "wishfish-enterprise";
                        amount = "49.99";
                    }
                    $.ajax({
                        type: 'POST',
                        url: "<?= site_url() ?>paypal",
                        data: {item_name: item_name, amount: amount, code: couponCode},
                        success: function (answer) {
                            window.location = answer;
                        }
                    });
                    break;
            }
        });
        $('a.cancel').click(function () {
            $('.social-register').css('display', 'none');
            $('.overlay').css('display', 'none');
            $('.sign').css('display', 'none');
        });
    });</script>
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
    $('.btn-facebook').click(function (e) {
        var id = $(this).prop('id');
        var url = (id == "fb-signup") ?
                "<?= site_url() ?>register/fbsignup?from=home" :
                "<?= site_url() ?>login/fbsignin";
        FB.login(function (response) {
            if (response.authResponse) {
                parent.location = url; //redirect uri after closing the facebook popup
            }
        }, {scope: 'email,read_stream,user_birthday,user_photos'}); //permissions for facebook
    });</script>

<script src="<?= base_url() ?>assets/wow/js/typed.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/wow/js/jquery-contact.js" type="text/javascript"></script>
<script>
    $(function () {
        $("#typed").typed({
            strings: ["Birthdays", "Anniversaries", "Special Events", "Deadlines"],
            typeSpeed: 50,
            backDelay: 700,
            loop: true,
            contentType: 'html', // or text
            // defaults to false for infinite loop
            loopCount: false,
            callback: function () {
                foo();
            },
            resetCallback: function () {
                newTyped();
            }
        });
        $(".reset").click(function () {
            $("#typed").typed('reset');
        });
    });
    function newTyped() { /* A new typed object */
    }
    function foo() {

    }
</script>

