<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>Wish-Fish Admin | Log in</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="<?= base_url() ?>favicon.ico" rel="Shortcut Icon" type="image/x-icon" />


        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?= base_url() ?>assets/dashboard/css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="bg-black">

        <div class="form-box" id="login-box">
            <div class="header">Sign In</div>
            <form action="<?= site_url() ?>admin/admin_login/login" method="post">
                <div class="body bg-gray">
                    <div class="form-group">
                        <input  type="text" name="userid" class="form-control" placeholder="User ID"/>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Password"/>
                    </div>          
                    <div class="form-group">
                        <input type="checkbox" name="remember"/> 
                        <span id="remember" style="cursor: pointer">Remember me</span>
                    </div>
                    <?php $msg = $this->input->get('msg'); ?>
                    <?php if (isset($msg) && $msg == "fail"): ?>
                        <div class="form-group">
                            <span style="color:red">Invalid Username or password..!</span>
                        </div>
                    <?php elseif (isset($msg) && $msg == "NA"): ?>
                        <div class="form-group">
                            <span style="color:red">You have no access right to login this system...!</span>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="footer">                                                               
                    <button type="submit" class="btn bg-olive btn-block">Sign me in</button>

<!--                    <p><a href="#">I forgot my password</a></p>

                    <a href="<?= site_url() ?>admin/admin_login/register" class="text-center">Register a new membership</a>-->
                </div>
            </form>

            <!--            <div class="margin text-center">
                            <span>Sign in using social networks</span>
                            <br/>
                            <button class="btn bg-light-blue btn-circle"><i class="fa fa-facebook"></i></button>
                            <button class="btn bg-aqua btn-circle"><i class="fa fa-twitter"></i></button>
                            <button class="btn bg-red btn-circle"><i class="fa fa-google-plus"></i></button>
            
                        </div>-->
        </div>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#remember').click(function () {
                    $('input[name="remember"]').trigger('click');
                });
            });
        </script>
    </body>
</html>