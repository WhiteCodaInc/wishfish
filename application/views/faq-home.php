<!-- Hero Section -->
<div id="hero" class="hero-image">
    <div class="container">

        <div class="row">
            <div class="col-sm-12">
                <h1>Create a Knowledge Base with Ease</h1>
                <p class="subtitle">Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit</p>      
            </div>
        </div>  

        <div class="row">
            <div class="hero-box col-sm-8 col-sm-offset-2">
                <form role="search" method="get" id="searchform" class="form-search" action="#">
                    <div class="input-group">
                        <input type="text" id="autocomplete-dynamic" name="s" id="s" class="form-control input-lg" autocomplete="off" placeholder="Find help! Enter search term here.">
                        <span class="input-group-btn">
                            <input type="submit" id="searchsubmit" value="Search" class="btn">
                        </span>
                    </div>
                </form>
            </div>   
        </div>  
    </div>
</div><!-- /#hero -->
<!-- Boxes Section -->
<div class="container">
    <div id="boxes">
        <div class="home-title">
            <h2>Welcome To Our Support Center</h2>
            <p>Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum.</p>        </div>
        <div class="row">
            <div class="col-sm-4">
                <article class="box box-left">
                    <div class="circle">
                        <a href="#"><span></span><i class="fa fa-file-text-o"></i></a>
                    </div>
                    <h3><a href="#">Knowledge Base</a></h3>
                    <p>Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum</p>
                    <a class="btn" href="knowledgebase.html">Continue</a>
                </article>
            </div>
            <div class="col-sm-4">
                <article class="box box-middle">
                    <div class="circle">
                        <a href="<?= site_url() ?>faq/questions"><span></span><i class="fa fa-question-circle"></i></a>
                    </div>
                    <h3><a href="<?= site_url() ?>faq/questions">FAQ</a></h3>
                    <p>Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum</p>
                    <a class="btn" href="<?= site_url() ?>faq/questions">Continue</a>
                </article>
            </div>
            <div class="col-sm-4">
                <article class="box box-right">
                    <div class="circle">
                        <a href="#l"><span></span><i class="fa fa-envelope-o"></i></a>
                    </div>
                    <h3><a href="#">Contact</a></h3>
                    <p>Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum</p>
                    <a class="btn" href="contact.html">Continue</a>
                </article>
            </div>
        </div>
    </div>
</div>

<!-- Featured Articles Section -->
<div id="home-featured">
    <div class="container">
        <div class="home-title">
            <h2>Knowledge Base Featured Articles</h2> 
            <p>Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum.</p> 
        </div>
        <div class="row recent-posts">

            <div class="col-sm-3">
                <article>
                    <header>
                        <h4 class="entry-title"><i class="fa fa-picture-o"></i> <a href="#">Responsive Design</a></h4>
                    </header>
                    <div class="entry-media">
                        <a href="#" title="Responsive Design">
                            <img width="870" height="490" src="<?= base_url() ?>assets/faq/img/responsive.jpg" alt="Responsive" />                
                        </a>
                    </div>
                    <div class="entry-content">
                        <p>One morning, when Greg woke from troubled dreams, he found himself formed <a class="blog-more btn btn-xxs btn-primary" href="#">Read more</a></p>
                    </div>
                </article>
            </div>

            <div class="col-sm-3">
                <article>
                    <header>
                        <h4 class="entry-title"><i class="fa fa-picture-o"></i> <a href="#">Live Search</a></h4>
                    </header>
                    <div class="entry-media">
                        <a href="#" title="Live Search">
                            <img width="870" height="490" src="<?= base_url() ?>assets/faq/img/colors-870x490.jpg" alt="colors" />                
                        </a>
                    </div>
                    <div class="entry-content">
                        <p>A wonderful serenity has taken possession of my entire soul, like these <a class="blog-more btn btn-xxs btn-primary" href="#">Read more</a></p>
                    </div>
                </article>
            </div>

            <div class="col-sm-3">
                <article>
                    <header>
                        <h4 class="entry-title"><i class="fa fa-film"></i> <a href="video.html">Using Custom Fields</a></h4>
                    </header>
                    <div class="entry-media fitvids">
                        <iframe src="../../../player.vimeo.com/video/69712594@title=0&byline=0&portrait=0&color=ffffff" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                    </div> 
                    <div class="entry-content">
                        <p>Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming <a class="blog-more btn btn-xxs btn-primary" href="video.html">Read more</a></p>
                    </div>
                </article>
            </div>

            <div class="col-sm-3">
                <article>
                    <header>
                        <h4 class="entry-title"><i class="fa fa-film"></i> <a href="video.html">Customizing Forms</a></h4>
                    </header>
                    <div class="entry-media fitvids">
                        <iframe src="../../../player.vimeo.com/video/75660130@title=0&byline=0&portrait=0&badge=0&color=ffffff" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                    </div> 
                    <div class="entry-content">
                        <p>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse <a class="blog-more btn btn-xxs btn-primary" href="video.html">Read more</a></p>
                    </div>
                </article>
            </div>

        </div>
    </div>
</div>

<!-- Video Section -->
<div id="home-video">
    <div class="container">
        <div class="home-title">
            <h2>Getting Started Video Tutorials</h2>          
            <p>Claritas est etiam processus dynamicus</p>        
        </div>
        <div class="row">
            <div class="col-sm-8">
                <div class="box-video">
                    <a href="video.html"><i class="fa fa-play-circle"></i></a>
                    <h3><a href="video.html">Video Post Format</a></h3>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="box-video-list">
                    <h3>Video Tutorials</h3>
                    <ul>            
                        <li><h4><i class="fa-film fa fa-fw"></i> <a href="video.html">Video Post Format</a></h4></li>
                        <li><h4><i class="fa-film fa fa-fw"></i> <a href="video.html">Multiple Ship to Addresses</a></h4></li>
                        <li><h4><i class="fa-film fa fa-fw"></i> <a href="video.html">Theme Installation</a></h4></li>
                        <li><h4><i class="fa-film fa fa-fw"></i> <a href="video.html">Plugin Installation</a></h4></li>
                        <li><h4><i class="fa-film fa fa-fw"></i> <a href="video.html">Warnings and errors</a></h4></li>
                        <li><h4><i class="fa-film fa fa-fw"></i> <a href="video.html">Rewrite configuration</a></h4></li>
                        <li><h4><i class="fa-film fa fa-fw"></i> <a href="video.html">Using Custom Fields</a></h4></li>
                        <li><h4><i class="fa-film fa fa-fw"></i> <a href="video.html">Customizing Forms</a></h4></li>
                    </ul>
                    <a class="btn-videos" href="#" title="">View all videos <i class="icon-chevron-right"></i></a>          
                </div>  
            </div>
        </div>
    </div>
</div>