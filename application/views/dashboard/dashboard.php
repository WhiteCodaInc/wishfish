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
    $(function () {
        var tg_instance = {};
        var jsonEvent = "";
        $.post("<?= site_url() ?>app/dashboard/getTimelineEvent", function (data) {
            jsonEvent = data;
        });
        tg1 = $("#p1").timeline({
            "min_zoom": 1,
            "max_zoom": 50,
            "timezone": "-06:00",
            "icon_folder": "<?= base_url() ?>assets/dashboard/timeline/timeglider/icons/",
            "data_source": jsonEvent,
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
            };
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
