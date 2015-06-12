<link rel="stylesheet" href="<?= base_url() ?>assets/dashboard/timeline/timeglider/Timeglider.css" type="text/css" media="screen" title="no title" charset="utf-8">
<link rel="stylesheet" href="<?= base_url() ?>assets/dashboard/timeline/timeglider/timeglider.datepicker.css" type="text/css" media="screen" charset="utf-8">
<link rel="stylesheet" href="<?= base_url() ?>assets/dashboard/timeline/css/docs.css" type="text/css" media="screen" title="no title" charset="utf-8">
<!--<link rel="stylesheet" href="<?= base_url() ?>assets/dashboard/timeline/css/jquery-ui-1.10.3.custom.css" type="text/css" media="screen" title="no title" charset="utf-8">-->
<style type='text/css'>


    .header {
        margin:32px;
    }

    #p1 {
        margin:32px;
        margin-bottom:0;
        height:450px;
    }



    .timeglider-legend {
        width:180px;
    }


    *.no-select {
        -moz-user-select: -moz-none;
        -khtml-user-select: none;
        -webkit-user-select: none;
        user-select: none;
    }


    .timeglider-timeline-event.ongoing .timeglider-event-title {
        color:green;
    }



    .dragger {
        float:right;
        width:40%;
        text-align:right;
        margin-right:8px;
        font-size:18px;
        color:green;
        font-size:12px;
        cursor:pointer;	
    }

</style>
<aside class="right-side" >
    <section class="content-header">
        <h1 style="float: left">
            Dashboard
        </h1>
        <a  href="<?= site_url() ?>app/contacts/addContact" class="btn btn-primary btn-sm create">
            <i class="fa fa-plus"></i>
            Create New Contact
        </a>
        <a  href="<?= site_url() ?>app/calender" class="btn btn-info btn-sm create">
            <i class="fa fa-plus"></i>
            Create New Event
        </a>
        <a  href="<?= site_url() ?>app/sms_template/addTemplate" class="btn btn-warning btn-sm create">
            <i class="fa fa-plus"></i>
            Create SMS Template
        </a>
        <a href="<?= site_url() ?>app/email_template/addTemplate" class="btn btn-danger btn-sm create">
            <i class="fa fa-plus"></i>
            Create Email Template
        </a>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row m-bot15">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>
                            <span><?= count($totalD) ?></span>
                        </h3>
                        <p>
                            Today
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                </div>
            </div><!-- ./col -->

            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>
                            <span><?= count($totalW) ?></span>
                        </h3>
                        <p>
                            This Week
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>

                </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>
                            <span><?= count($totalM) ?></span>
                        </h3>
                        <p>
                            This Month
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>
                            <span id="totalY">
                                <?= count($totalY) ?>
                            </span>
                        </h3>
                        <p>
                            This Year
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>

                </div>
            </div><!-- ./col -->
        </div><!-- /.row -->
        <div class="row ui-sortable">
            <div class="col-md-8">

            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-solid box-primary collapsed-box">
                            <div class="box-header" data-widget="collapse"  style="cursor: pointer">
                                <h3 class="box-title">Events</h3>
                            </div>
                            <div class="box-body"  style="display: none">
                                <div class="form-group-lg">
                                    <div class="box box-primary">
                                        <div class="box-header ui-sortable-handle" style="cursor: move;">
                                            <i class="ion ion-clipboard"></i>
                                            <h3 class="box-title">TODAY</h3>
                                        </div><!-- /.box-header -->
                                        <div class="box-body">
                                            <ul class="todo-list ui-sortable">
                                                <?php foreach ($totalD as $value) { ?>
                                                    <li>
                                                        <a href="<?= site_url() ?>app/calender?date=<?= $value->date ?>"
                                                           <!-- drag handle -->
                                                           <span class="handle ui-sortable-handle">
                                                                <i class="fa fa-ellipsis-v"></i>
                                                                <i class="fa fa-ellipsis-v"></i>
                                                            </span>
                                                            <!-- todo text -->
                                                            <span class="text"><?= $value->event ?></span>
                                                            <!-- Emphasis label -->
                                                            <small class="label" style="background-color: <?= $value->color ?>">
                                                                <i class="fa fa-clock-o"></i>
                                                                <?= $value->format_date ?>
                                                            </small>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </div><!-- /.box-body -->
                                    </div>
                                </div>
                                <div class="form-group-lg">
                                    <div class="box box-primary">
                                        <div class="box-header ui-sortable-handle" style="cursor: move;">
                                            <i class="ion ion-clipboard"></i>
                                            <h3 class="box-title">THIS WEEK</h3>
                                        </div><!-- /.box-header -->
                                        <div class="box-body">
                                            <ul class="todo-list ui-sortable">
                                                <?php foreach ($totalW as $value) { ?>
                                                    <li>
                                                        <a href="<?= site_url() ?>app/calender?date=<?= $value->date ?>"
                                                           <!-- drag handle -->
                                                           <span class="handle ui-sortable-handle">
                                                                <i class="fa fa-ellipsis-v"></i>
                                                                <i class="fa fa-ellipsis-v"></i>
                                                            </span>
                                                            <!-- todo text -->
                                                            <span class="text"><?= $value->event ?></span>
                                                            <!-- Emphasis label -->
                                                            <small class="label" style="background-color: <?= $value->color ?>">
                                                                <i class="fa fa-clock-o"></i>
                                                                <?= $value->format_date ?>
                                                            </small>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </div><!-- /.box-body -->
                                    </div>
                                </div>
                                <div class="form-group-lg">
                                    <div class="box box-primary">
                                        <div class="box-header ui-sortable-handle" style="cursor: move;">
                                            <i class="ion ion-clipboard"></i>
                                            <h3 class="box-title">THIS MONTH</h3>
                                        </div><!-- /.box-header -->
                                        <div class="box-body">
                                            <ul class="todo-list ui-sortable">
                                                <?php foreach ($totalM as $value) { ?>
                                                    <li>
                                                        <a href="<?= site_url() ?>app/calender?date=<?= $value->date ?>"
                                                           <!-- drag handle -->
                                                           <span class="handle ui-sortable-handle">
                                                                <i class="fa fa-ellipsis-v"></i>
                                                                <i class="fa fa-ellipsis-v"></i>
                                                            </span>
                                                            <!-- todo text -->
                                                            <span class="text"><?= $value->event ?></span>
                                                            <!-- Emphasis label -->
                                                            <small class="label" style="background-color: <?= $value->color ?>">
                                                                <i class="fa fa-clock-o"></i>
                                                                <?= $value->format_date ?>
                                                            </small>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </div><!-- /.box-body -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id='p1'></div>
    </section>
</aside>

<!--<script src="<?= base_url() ?>assets/dashboard/timeline/js/jquery-1.9.1.min.js" type="text/javascript" charset="utf-8"></script>-->
<!-- jquery-1.9.1.min.js  OR  jquery-1.10.1.min.js -->
<!--<script src="<?= base_url() ?>assets/dashboard/timeline/js/jquery-ui-1.10.3.custom.min.js" type="text/javascript" charset="utf-8"></script>-->


<script src="<?= base_url() ?>assets/dashboard/timeline/js/underscore-min.js" type="text/javascript" charset="utf-8"></script>
<script src="<?= base_url() ?>assets/dashboard/timeline/js/backbone-min.js" type="text/javascript" charset="utf-8"></script>
<script src="<?= base_url() ?>assets/dashboard/timeline/js/jquery.tmpl.js" type="text/javascript" charset="utf-8"></script>
<script src="<?= base_url() ?>assets/dashboard/timeline/js/ba-debug.min.js" type="text/javascript" charset="utf-8"></script>
<script src="<?= base_url() ?>assets/dashboard/timeline/js/ba-tinyPubSub.js" type="text/javascript" charset="utf-8"></script>
<script src="<?= base_url() ?>assets/dashboard/timeline/js/jquery.mousewheel.js" type="text/javascript" charset="utf-8"></script>
<script src="<?= base_url() ?>assets/dashboard/timeline/js/jquery.ui.ipad.js" type="text/javascript" charset="utf-8"></script>
<script src="<?= base_url() ?>assets/dashboard/timeline/js/globalize.js" type="text/javascript" charset="utf-8"></script>	



<script src="<?= base_url() ?>assets/dashboard/timeline/timeglider/TG_Date.js" type="text/javascript" charset="utf-8"></script>
<script src="<?= base_url() ?>assets/dashboard/timeline/timeglider/TG_Org.js" type="text/javascript" charset="utf-8"></script>
<script src="<?= base_url() ?>assets/dashboard/timeline/timeglider/TG_Timeline.js" type="text/javascript" charset="utf-8"></script> 
<script src="<?= base_url() ?>assets/dashboard/timeline/timeglider/TG_TimelineView.js" type="text/javascript" charset="utf-8"></script>
<script src="<?= base_url() ?>assets/dashboard/timeline/timeglider/TG_Mediator.js" type="text/javascript" charset="utf-8"></script> 
<script src="<?= base_url() ?>assets/dashboard/timeline/timeglider/timeglider.timeline.widget.js" type="text/javascript"></script>

<script src="<?= base_url() ?>assets/dashboard/timeline/timeglider/timeglider.datepicker.js" type="text/javascript"></script>


<script src="<?= base_url() ?>assets/dashboard/timeline/js/jquery.jscrollpane.min.js" type="text/javascript"></script>


<!-- JUST FOR KITCHEN SINK: NOT NEEDED FOR TG WIDGET -->
<script src="<?= base_url() ?>assets/dashboard/timeline/js/jquery.ui.sortable.js" type="text/javascript" charset="utf-8"></script>

<script type='text/javascript'>


    var ico = window.ico;

    window.pizzaShack = {
        clicker: function (tg_event) {
            alert("you clicked on " + tg_event.title);
        }
    };

    var tg1 = window.tg1 = "";

    $(function () {

        var tg_instance = {};
        var json = [
            {
                "id": "js_history",
                "title": "Birthday Events Timeline",
//"description":"<p>Javascript emerged in a specific context: the fast-paced development of Netscape's browser. When he was hired at Netscape, Brendan Eich was told that it would be \"Scheme for the browser\", but he was later told to make it more like C and Java. The first iteration of JS, created over a 10 day period, was a super-flexible, but also highly flawed child of the internet age.</p>",
                "focus_date": "1995-06-20 12:00:00",
                "initial_zoom": "39",
//"image_lane_height":50,
                "events": [
                    {
                        "id": "jshist-mochi_kit",
                        "title": "mochikit",
                        "description": "Mochikit was one of the earliest comprehensive JS DOM manipulation libraries. Wikipedia:<br>Ispired by the Python networking framework, Twisted, it uses the concept of deferred execution to allow asynchronous behaviour. This has made it useful in the development of interactive web pages which maintain a dialog with the web server, sometimes called Ajax applications.",
                        "startdate": "2005-05-01 12:00:00",
                        "high_threshold": 50,
                        "importance": "30",
                        "link": "http://en.wikipedia.org/wiki/MochiKit",
                        "icon": "triangle_orange.png"
                    },
                    {
                        "id": "jshist-qoox",
                        "title": "qooxdo",
                        "description": "qoxdoo, pronounced 'cooks do' was introduced in 2006. Wikipedia:<br>qooxdoo is entirely class-based and tries to leverage the features of object-oriented JavaScript. It is based on namespaces and does not modify or extend native JavaScript types",
                        "startdate": "2006-06-01 12:00:00",
                        "high_threshold": 50,
                        "importance": "30",
                        "link": "http://en.wikipedia.org/wiki/qooxdoo",
                        "icon": "triangle_orange.png"
                    },
                    {
                        "id": "jshist-script.aculo.us",
                        "title": "script.aculo.us",
                        "description": "Wikipedia:<br>script.aculo.us was extracted by Thomas Fuchs from his work on fluxiom, a web based digital asset management tool by the design company wollzelle. It was first released to the public in June 2005.",
                        "startdate": "2005-06-01 12:00:00",
                        "high_threshold": 50,
                        "importance": "30",
                        "icon": "triangle_orange.png"
                    },
                    {
                        "id": "jshist-underscore",
                        "title": "Underscore.js",
                        "description": "Created by Jeremy Ashkenas at DocumentCloud.",
                        "startdate": "2009-06-01 12:00:00",
                        "high_threshold": 50,
                        "importance": "35",
                        "icon": "triangle_orange.png"
                    },
                    {
                        "id": "jshist-backbone",
                        "title": "Backbone.js",
                        "description": "Backbone is created, filling the desperate need for a true \"framework\" in the JS-sphere.",
                        "startdate": "2010-06-01 12:00:00",
                        "high_threshold": 50,
                        "importance": "42",
                        "icon": "triangle_orange.png"
                    },
                    {
                        "id": "jshist-require",
                        "title": "Require.js",
                        "description": "JR Burke puts his first Github commit of Require.js",
                        "startdate": "2009-09-27 12:00:00",
                        "high_threshold": 50,
                        "importance": "35",
                        "icon": "triangle_orange.png"
                    },
                    {
                        "id": "jshist-lightbox",
                        "title": "Lightbox",
                        "description": "Lightbox",
                        "startdate": "2006-06-01 12:00:00",
                        "high_threshold": 50,
                        "importance": "25",
                        "icon": "triangle_orange.png"
                    },
                    {
                        "id": "jshist-thickbox",
                        "title": "ThickBox",
                        "description": "Created by Boise's own Cody Lindley",
                        "startdate": "2007-01-01 12:00:00",
                        "high_threshold": 50,
                        "importance": "25",
                        "icon": "triangle_orange.png"
                    },
                    {
                        "id": "jshist-06",
                        "title": "Prototype JS",
                        "description": "The Prototype JavaScript Framework is a JavaScript framework created by Sam Stephenson in February 2005 as part of the foundation for Ajax support in Ruby on Rails. It is implemented as a single file of JavaScript code, usually named prototype.js. Prototype is distributed standalone, but also as part of larger projects, such as Ruby on Rails, script.aculo.us and Rico.",
                        "startdate": "2005-02-01 12:00:00",
                        "enddate": "2005-02-01 12:00:00",
                        "high_threshold": 50,
                        "importance": "45",
                        "icon": "triangle_orange.png"
                    },
                    {
                        "id": "jshist-05",
                        "title": "Dojo Toolkit",
                        "description": "Dojo Released",
                        "startdate": "2004-06-01 12:00:00",
                        "enddate": "2004-06-01 12:00:00",
                        "link": "http://dojotoolkit.org/",
                        "video": "http://www.youtube.com/embed/RYlCVwxoL_g",
                        "image": "http://timeglider.com/widget/img/dojo.jpg",
                        "high_threshold": 50,
                        "importance": "35",
                        "icon": "triangle_orange.png"
                    },
                    {
                        "id": "jshist-09",
                        "title": "jQuery",
                        "description": "Released in January 2006 at BarCamp NYC by John Resig",
                        "startdate": "2005-12-01 12:00:00",
                        "enddate": "2005-12-01 12:00:00",
                        "link": "http://jquery.com/",
                        "high_threshold": 50,
                        "importance": "45",
                        "image": "http://timeglider.com/widget/_js_history/resig.jpg",
                        "icon": "triangle_orange.png"
                    },
                    {
                        "id": "jshist-16",
                        "title": "MooTools",
                        "description": "Valerio Proietti first authored the framework, taking as his inspiration Prototype and Dean Edward's base2. MooTools originated from Moo.fx, a popular plug-in Proietti produced for Prototype in October 2005, which is still maintained and used",
                        "startdate": "2006-09-01 12:00:00",
                        "enddate": "2006-09-01 12:00:00",
                        "date_display": "mo",
                        "link": "http://mootools.net/",
                        "high_threshold": 50,
                        "importance": "35",
                        "icon": "triangle_orange.png"
                    },
                    {
                        "id": "jshist-17",
                        "title": "YUI",
                        "description": "Development on YUI began in 2005 and Yahoo! properties such as My Yahoo! and the Yahoo! front page began using YUI in the summer of that year. YUI was released for public use in February 2006.",
                        "startdate": "2006-02-01 12:00:00",
                        "enddate": "2006-02-01 12:00:00",
                        "date_display": "mo",
                        "link": "http://developer.yahoo.com/yui/",
                        "high_threshold": 50,
                        "importance": "35",
                        "icon": "triangle_orange.png"
                    },
                    {
                        "id": "jshist-infscroll",
                        "title": "Infinite Scroll",
                        "description": "Said Irish: Essentially infinite scroll is using ajax to pre-fetch content from a subsequent page and add it directly to the user's current page. If you have no idea what I'm talking about, you should scroll down to the bottom of aurgasm.us, roflcon.org, or blog.molecular.com.",
                        "startdate": "2008-09-25 12:00:00",
                        "date_display": "mo",
                        "link": "http://paulirish.com/2008/release-infinite-scroll-com-jquery-and-wordpress-plugins/",
                        "high_threshold": 50,
                        "importance": "25",
                        "icon": "triangle_orange.png"
                    },
                    {
                        "id": "10things",
                        "title": "Ten Things I Learned About the jQuery Source",
                        "description": "Ten Things I Learned About the jQuery Source",
                        "startdate": "2010-06-13 11:39:00",
                        "link": "http://paulirish.com/2010/10-things-i-learned-from-the-jquery-source/",
                        "video": "http://player.vimeo.com/video/12529436",
                        "high_threshold": 50,
                        "importance": "20",
                        "icon": "triangle_orange.png"
                    },
                    {
                        "id": "jshist-18",
                        "title": "Google Web Toolkit",
                        "description": "Google Web Toolkit is an open source set of tools that allows web developers to create and maintain complex JavaScript front-end applications in Java. Other than a few native libraries, everything is Java source that can be built on any supported platform with the included GWT Ant build files.",
                        "startdate": "2006-05-17 12:00:00",
                        "enddate": "2006-05-17 12:00:00",
                        "date_display": "mo",
                        "link": "http://en.wikipedia.org/wiki/Google_Web_Toolkit",
                        "high_threshold": 50,
                        "importance": "35",
                        "icon": "triangle_orange.png"
                    },
                    {
                        "id": "jshist-googclosure",
                        "title": "Google Closure Tools",
                        "description": "Google Closure Tools is a set of tools to help developers build rich web applications with JavaScript. It was developed by Google for use in their web applications such as Gmail, Google Docs and Google Maps.",
                        "startdate": "2009-11-01 12:00:00",
                        "date_display": "mo",
                        "link": "http://en.wikipedia.org/wiki/Google_Web_Toolkit",
                        "high_threshold": 50,
                        "importance": "35",
                        "icon": "triangle_orange.png"
                    },
                    {
                        "id": "jshist-15",
                        "title": "ExtJS",
                        "description": "Ext.Ajax provided features such as global headers and parameters, cross library file uploads and global Ajax events.",
                        "startdate": "2007-08-02 12:00:00",
                        "enddate": "2007-08-02 12:00:00",
                        "date_display": "mo",
                        "link": "http://www.sencha.com/products/js/",
                        "high_threshold": 50,
                        "importance": "35",
                        "icon": "triangle_orange.png"
                    },
                    {
                        "id": "jshist-11",
                        "title": "jQuery Mobile / 1.4.3",
                        "description": "Released at the Boston JQuery Conference",
                        "startdate": "2010-10-16 12:00:00",
                        "enddate": "2010-10-16 12:00:00",
                        "link": "http://www.jquerymobile.com",
                        "high_threshold": 50,
                        "importance": "30",
                        "icon": "triangle_orange.png"
                    }
                ],
                "tags": {"mardigras": 2, "chris": 2, "arizona": 2, "netscape": 2, "flop": 1},
                "legend": [
                    {"title": "libs &amp; frameworks", "icon": "triangle_orange.png"},
                    {"title": "engines", "icon": "square_gray.png"},
                    {"title": "browsers", "icon": "triangle_yellow.png"},
                    {"title": "JS evolution", "icon": "triangle_green.png"},
                    {"title": "languages", "icon": "circle_green.png"},
                    {"title": "standards", "icon": "square_blue.png"},
                    {"title": "conferences", "icon": "circle_blue.png"},
                    {"title": "milestones", "icon": "circle_purple.png"}
                ]

            }
        ];

        tg1 = $("#p1").timeline({
            /*
             // custom hover & click callbacks
             // returning false prevents default
             
             eventHover: function($ev, ev) {
             debug.log("ev hover, no follow:", ev);
             return false;
             },
             
             eventClick: function($ev, ev) {
             debug.log("eventClick, no follow:", ev);
             return false;
             },
             */

            "min_zoom": 1,
            "max_zoom": 50,
            "timezone": "-06:00",
            "icon_folder": "<?= base_url() ?>assets/dashboard/timeline/timeglider/icons/",
            "data_source": json,
            "show_footer": true,
            "display_zoom_level": true,
            "mousewheel": "zoom", // zoom | pan | none
            "constrain_to_data": true,
            "image_lane_height": 100,
            "legend": {type: "default"}, // default | checkboxes
            "loaded": function () {
                // loaded callback function
            }

        }).resizable({
            stop: function () {
                // $(this).data("timeline").resize();
            }
        });



        tg_instance = tg1.data("timeline");


        $(".goto").click(function () {
            var d = $(this).attr("date");
            var z = $(this).attr("zoom");
            tg_instance.goTo(d, z);
        });

        $(".zoom").click(function () {
            var z = Number($(this).attr("z"));
            tg_instance.zoom(z);
        });


//        tg_instance.panButton($(".pan-left"), "left");
//        tg_instance.panButton($(".pan-right"), "right");


        $("#getScope").click(function () {

            var so = tg_instance.getScope();

            var ml = "RETURNS: <br><br>container (jquery dom object): " + so.container.toString()
                    + "<br>focusDateSec (tg sec):" + so.focusDateSec
                    + "<br>focusMS (js timestamp): " + so.focusMS
                    + "<br>leftMS (js timestamp): " + so.leftMS
                    + "<br>left_sec (tg sec): " + so.left_sec
                    + "<br>rightMS (js timestamp): " + so.rightMS
                    + "<br>right_sec (tg sec): " + so.right_sec
                    + "<br>spp (seconds per pixel): " + so.spp
                    + "<br>timelineBounds (object, left- & right-most in tg sec): " + JSON.stringify(so.timelineBounds)
                    + "<br>timelines (array of ids): " + JSON.stringify(so.timelines);

            var d = new Date(so.focusMS);

            ml += "<br><br>Date using focusMS:" + d.toString('yyyy-MM-dd');

            $(".scope-view").html(ml);

        });


        $("#loadData").click(function () {

            var src = $("#loadDataSrc").val();

            var cb_fn = function (args, timeline) {
                // called after parsing data, after load
//                debug.log("args", args, "timeline", timeline[0].id);
            };

            var cb_args = {}; // {display:true};

            tg_instance.getMediator().emptyData();
            tg_instance.loadTimeline(src, function () {
//                debug.log("cb!");
            }, true);

            $("#reloadDataDiv").hide();
        });


        $("#reloadTimeline").click(function () {
            tg_instance.reloadTimeline("js_history", json);
        });



        $("#refresh").click(function () {
            debug.log("timeline refreshed!");
            tg_instance.refresh();
        });



        $("#scrolldown").bind("click", function () {
            $(".timeglider-timeline-event").animate({top: "+=100"});
        });

        $("#scrollup").bind("click", function () {
            $(".timeglider-timeline-event").animate({top: "-=100"});
        });




        timeglider.eventActions = {
            nagavigateTo: function (obj) {
                // event object must have a "navigateTo"
                // element with zoom, then ISO date delimited
                // with a pipe | 
                // one can use
                var nav = obj.navigateTo;
                tg_instance.goTo(nav.focus_date, nav.zoom_level);

                setTimeout(function () {
                    $el = $(".timeglider-timeline-event#" + obj.id);
                    $el.find(".timeglider-event-spanner").css({"border": "1px solid green"}); // 
                }, 50);

            }
        }




        $("#adjustNow").click(function () {
            tg_instance.adjustNowEvents();
        });




        $("#addEvent").click(function () {

            var rando = Math.floor((Math.random() * 1000) + 1);
            var impo = Math.floor((Math.random() * 50) + 20);

            var obj = {
                id: "new_" + rando,
                title: "New Event!",
                startdate: "today",
                importance: impo,
                icon: "star_red.png",
                timelines: ["js_history"]
            }

            tg_instance.addEvent(obj, true);

        });




        $("#updateEvent").click(function () {

            var updatedEventModel = {
                id: "deathofflash",
                title: "Flash struggles to survive in the age of HTML5."
            }

            tg_instance.updateEvent(updatedEventModel);

        });


        $(".method").each(function () {
            $(this).find("h4").addClass("clearfix");
            $(this).prepend("<div class='dragger'>drag me</div>");
        });


        $("#sorters").sortable({"handle": ".dragger"});
        $("#sorters").disableSelection();



    }); // end document-ready







</script>



<script type="text/javascript" >
    $(function () {
        $('select[name="timezones"]').addClass('form-control m-bot15');
        //$('select[name="timezones"]').val('UTC');
        $('#contactForm .default-date-picker').datepicker({
            format: "<?= $this->session->userdata('date_format') ?>",
            todayBtn: "linked",
            autoclose: true,
            todayHighlight: true
        }).on('changeDate', function (ev) {
            $('#contactForm input[name="birthday"]').focusout();
        });

        $('#cprofileForm .default-date-picker').datepicker({
            format: "<?= $this->session->userdata('date_format') ?>",
            todayBtn: "linked",
            autoclose: true,
            todayHighlight: true
        });
    });
</script>
