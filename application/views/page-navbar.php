<header>
    <!-- if you want dark nav bar just replace 2 css bottom line (av-dark navbar-inverse) and add this (nav-dark navbar-inverse)-->
    <nav class="navbar navbar-1 nav-light navbar-default navbar-fixed-top custom-nav" id="main-navbar" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <a href="<?= site_url() ?>" class="navbar-brand top-logo" data-selector="nav a" style=""><img src="<?= base_url() ?>assets/wow/images/logo.png" alt="logo" data-selector="img" style=""></a>
            </div>  <!--end navbar-header -->

            <div class="collapse navbar-collapse" id="navbar-collapse">
                <a id="reg" href="javascript:void(0);" class="btn btn-primary navbar-btn navbar-right">Register</a>
                <a id="log" href="javascript:void(0);" class="btn btn-primary navbar-btn navbar-right"> Login </a>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#home" >Home</a></li>
                    <!--<li><a href="#service" >service</a></li>-->
                    <li><a href="#features" >Features</a></li>
                    <li><a href="#describe" >Why Us</a></li>
                    <li><a href="#plan">Plans & Pricing</a></li>
                    <li><a href="#contact" >Contact</a></li>
                </ul>
            </div>  <!--end collapse -->
        </div>  <!--end container -->
    </nav>
</header><!--home section-->