<link rel="stylesheet" href="<?= base_url() ?>assets/dashboard/timeline/timeglider/Timeglider.css" type="text/css" media="screen" title="no title" charset="utf-8">
<link rel="stylesheet" href="<?= base_url() ?>assets/dashboard/timeline/timeglider/timeglider.datepicker.css" type="text/css" media="screen" charset="utf-8">
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
                <div id='p1'></div>
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
    </section>
</aside>

<script src="<?= base_url() ?>assets/dashboard/timeline/js/jquery-1.9.1.min.js" type="text/javascript" charset="utf-8"></script>
<!-- jquery-1.9.1.min.js  OR  jquery-1.10.1.min.js -->
<script src="<?= base_url() ?>assets/dashboard/timeline/js/jquery-ui-1.10.3.custom.min.js" type="text/javascript" charset="utf-8"></script>


<script sr="<?= base_url() ?>assets/dashboard/timeline/js/underscore-min.js" type="text/javascript" charset="utf-8"></script>
<script sr="<?= base_url() ?>assets/dashboard/timeline/js/backbone-min.js" type="text/javascript" charset="utf-8"></script>
<script sr="<?= base_url() ?>assets/dashboard/timeline/js/jquery.tmpl.js" type="text/javascript" charset="utf-8"></script>
<script sr="<?= base_url() ?>assets/dashboard/timeline/js/ba-debug.min.js" type="text/javascript" charset="utf-8"></script>
<script sr="<?= base_url() ?>assets/dashboard/timeline/js/ba-tinyPubSub.js" type="text/javascript" charset="utf-8"></script>
<script sr="<?= base_url() ?>assets/dashboard/timeline/js/jquery.mousewheel.js" type="text/javascript" charset="utf-8"></script>
<script sr="<?= base_url() ?>assets/dashboard/timeline/js/jquery.ui.ipad.js" type="text/javascript" charset="utf-8"></script>
<script sr="<?= base_url() ?>assets/dashboard/timeline/js/globalize.js" type="text/javascript" charset="utf-8"></script>	



<script sr="<?= base_url() ?>assets/dashboard/timeline/timeglider/TG_Date.js" type="text/javascript" charset="utf-8"></script>
<script sr="<?= base_url() ?>assets/dashboard/timeline/timeglider/TG_Org.js" type="text/javascript" charset="utf-8"></script>
<script sr="<?= base_url() ?>assets/dashboard/timeline/timeglider/TG_Timeline.js" type="text/javascript" charset="utf-8"></script> 
<script sr="<?= base_url() ?>assets/dashboard/timeline/timeglider/TG_TimelineView.js" type="text/javascript" charset="utf-8"></script>
<script sr="<?= base_url() ?>assets/dashboard/timeline/timeglider/TG_Mediator.js" type="text/javascript" charset="utf-8"></script> 
<script sr="<?= base_url() ?>assets/dashboard/timeline/timeglider/timeglider.timeline.widget.js" type="text/javascript"></script>

<script sr="<?= base_url() ?>assets/dashboard/timeline/timeglider/timeglider.datepicker.js" type="text/javascript"></script>


<script sr="<?= base_url() ?>assets/dashboard/timeline/js/jquery.jscrollpane.min.js" type="text/javascript"></script>


<!-- JUST FOR KITCHEN SINK: NOT NEEDED FOR TG WIDGET -->
<script sr="<?= base_url() ?>assets/dashboard/timeline/js/jquery.ui.sortable.js" type="text/javascript" charset="utf-8"></script>

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
                        "id": "jshist-Lambda",
                        "title": "Lambda Calculus",
                        "description": "The lambda calculus (also written as λ-calculus) is a formal system in mathematical logic for expressing computation by way of variable binding and substitution. It was first formulated by Alonzo Church as a way to formalize mathematics through the notion of functions, in contrast to the field of set theory. Although not very successful in that respect, the lambda calculus found early successes in the area of computability theory, such as a negative answer to Hilbert's Entscheidungsproblem.<br><br>Because of the importance of the notion of variable binding and substitution, there is not just one system of lambda calculus. Historically, the most important system was the untyped lambda calculus. In the untyped lambda calculus, function application has no restrictions (so the notion of the domain of a function is not built into the system). In the Church–Turing Thesis, the untyped lambda calculus is claimed to be capable of computing all effectively calculable functions. The typed lambda calculus is a variety that restricts function application, so that functions can only be applied if they are capable of accepting the given input's \"type\" of data.",
                        "startdate": "1936-07-01 12:00:00",
                        "high_threshold": 50,
                        "importance": "50",
                        "image": "http://timeglider.com/widget/_js_history/alonzo_church.jpg",
                        "link": "http://en.wikipedia.org/wiki/Lisp_(programming_language)",
                        "date_display": "ye",
                        "icon": "circle_green.png"
                    },
                    {
                        "id": "jshist-z3",
                        "title": "Z3",
                        "description": "Wikipedia:<br>The Z3 was an electromechanical computer designed by Konrad Zuse. It was the world's first working programmable, fully automatic computing machine.",
                        "startdate": "1938-01-01 12:00:00",
                        "high_threshold": 50,
                        "importance": "40",
                        "link": "http://en.wikipedia.org/wiki/Zuse_Z3",
                        "date_display": "ye",
                        "icon": "square_black.png"
                    },
                    {
                        "id": "jshist-collossus",
                        "title": "Colossus",
                        "description": "Wikipedia:<br>Colossus was the world's first electronic, digital, programmable computer. Colossus and its successors were used by British codebreakers to help read encrypted German messages during World War II. They used thermionic valves (vacuum tubes) to perform the calculations.",
                        "startdate": "1943-12-01 12:00:00",
                        "high_threshold": 50,
                        "importance": "40",
                        "link": "http://en.wikipedia.org/wiki/Colossus_computer",
                        "date_display": "ye",
                        "click_callback": "timeglider.foo.boo",
                        "icon": "square_black.png"
                    },
                    {
                        "id": "jshist-lisp",
                        "title": "Lisp",
                        "description": "Created by the man who coined the term 'Artificial Intelligence', John McCarthy, Lisp was initially only described in an academic paper: It applies the lambda calculus, with potential heavy use of currying, to computer processes. The langauge was first implemented in hardware in March of 1960 on an IBM 704.",
                        "startdate": "1958-01-01 12:00:00",
                        "high_threshold": 50,
                        "importance": "40",
                        "link": "http://en.wikipedia.org/wiki/Lisp_(programming_language)",
                        "date_display": "ye",
                        "icon": "circle_green.png"
                    },
                    {
                        "id": "jshist-www",
                        "title": "WWW",
                        "description": "",
                        "startdate": "1990-12-01 12:00:00",
                        "high_threshold": 50,
                        "importance": "60",
                        "date_display": "ye",
                        "modal_type": "full",
                        "image": {"src": "http://timeglider.com/widget/_js_history/berners-lee.jpg", "display_class": "inline"},
                        "icon": "flag_yellow.png"
                    },
                    {
                        "id": "jshist-nojs",
                        "title": "There was no Javascript",
                        "description": "Amazingly, until Brendan Eich created Javascript in 1995, there was none.",
                        "startdate": "1936-01-01 12:00:00",
                        "enddate": "1994-06-01 12:00:00",
                        "low_threshold": 51,
                        "high_threshold": 52,
                        "importance": "60",
                        "date_display": "no",
                        "y_position": 200,
                        "icon": "none"
                    },
                    {
                        "id": "jshist-scheme",
                        "title": "Scheme",
                        "description": "Guy L. Steele and Gerald Jay Sussman created the Lambda Papers, part of a series of papers on AI (the 'AI Memos'), and described Scheme as a dialect of Lisp. Says Wikipedia:<br><em>The development of Scheme was heavily influenced by two predecessors that were quite different from one another: Lisp provided its general semantics and syntax, and ALGOL provided its lexical scope and block structure.</em><br><br>When Netscape hired Brendan Eich, he was apparently told that they wanted \"Scheme in the browser\". This was not to be.",
                        "startdate": "1975-01-01 12:00:00",
                        "importance": "40",
                        "high_threshold": 50,
                        "link": "http://en.wikipedia.org/wiki/Scheme_(programming_language)",
                        "date_display": "ye",
                        "modal_type": "full",
                        "icon": "circle_green.png"
                    },
                    {
                        "id": "jshist-self",
                        "title": "Self",
                        "description": "Self, one of the inspirations for Javascript's simplicity, and for its prototype-based object system (and therefore the system of delegation), was created at Xerox PARC ",
                        "startdate": "1986-01-01 12:00:00",
                        "importance": "40",
                        "high_threshold": 50,
                        "date_display": "ye",
                        "icon": "circle_green.png"
                    },
                    {
                        "id": "jshist-smalltalk",
                        "title": "Smalltalk",
                        "description": "Wikipedia<br>Smalltalk is an object-oriented, dynamically typed, reflective programming language. Smalltalk was created as the language to underpin the \"new world\" of computing exemplified by \"human–computer symbiosis.\" It was designed and created in part for educational use, more so for constructionist learning, at the Learning Research Group (LRG) of Xerox PARC.",
                        "startdate": "1972-01-01 12:00:00",
                        "importance": "40",
                        "high_threshold": 50,
                        "date_display": "ye",
                        "icon": "circle_green.png"
                    },
                    {
                        "id": "jshist-perl",
                        "title": "Perl",
                        "description": "Wikipedia:<br>Perl is a high-level, general-purpose, interpreted, dynamic programming language. Perl was originally developed by Larry Wall in 1987 as a general-purpose Unix scripting language to make report processing easier.",
                        "startdate": "1987-06-01 12:00:00",
                        "importance": "45",
                        "high_threshold": 50,
                        "date_display": "ye",
                        "icon": "circle_green.png"
                    },
                    {
                        "id": "jshist-assem",
                        "title": "Assembly Languages",
                        "description": "Wikipedia:<br>Assembly languages date to the introduction of the stored-program computer. The EDSAC computer (1949) had an assembler called initial orders featuring one-letter mnemonics.",
                        "startdate": "1949-06-01 12:00:00",
                        "importance": "48",
                        "link": "http://en.wikipedia.org/wiki/Assembly_language",
                        "date_display": "ye",
                        "high_threshold": 50,
                        "icon": "circle_green.png"
                    },
                    {
                        "id": "jshist-cobol",
                        "title": "COBOL",
                        "description": "Wikipedia:<br>COBOL is one of the oldest programming languages. Its name is an acronym for COmmon Business-Oriented Language, defining its primary domain in business, finance, and administrative systems for companies and governments.",
                        "startdate": "1959-06-01 12:00:00",
                        "importance": "35",
                        "date_display": "ye",
                        "high_threshold": 50,
                        "icon": "circle_green.png"
                    },
                    {
                        "id": "jshist-flowmatic",
                        "title": "FLOW-MATIC",
                        "description": "Wikipedia:<br>FLOW-MATIC, originally known as B-0, was the first English-like data processing language. It was developed for the UNIVAC I at Remington Rand under Grace Hopper. Hopper had found that business data processing customers were uncomfortable with mathematical notation....The FLOW-MATIC compiler became publicly available in early 1958 and was substantially complete in 1959.",
                        "startdate": "1955-06-01 12:00:00",
                        "importance": "41",
                        "date_display": "ye",
                        "high_threshold": 50,
                        "link": "http://en.wikipedia.org/wiki/Grace_Hopper",
                        "image": "http://timeglider.com/widget/_js_history/grace_hopper.jpg",
                        "icon": "circle_green.png"
                    },
                    {
                        "id": "jshist-fortran",
                        "title": "Fortran",
                        "description": "Wikipedia:<br>Fortran (previously FORTRAN) is a general-purpose, procedural, imperative programming language that is especially suited to numeric computation and scientific computing. Originally developed by IBM at their campus in south San Jose, California in the 1950s for scientific and engineering applications, Fortran came to dominate this area of programming early on and has been in continual use for over half a century in computationally intensive areas such as numerical weather prediction, finite element analysis, computational fluid dynamics, computational physics and computational chemistry.",
                        "startdate": "1957-06-01 12:00:00",
                        "importance": "35",
                        "date_display": "ye",
                        "high_threshold": 50,
                        "icon": "circle_green.png"
                    },
                    {
                        "id": "jshist-algol",
                        "title": "ALGOL",
                        "description": "Wikipedia:<br>ALGOL (short for ALGOrithmic Language) is a family of imperative computer programming languages originally developed in the mid 1950s which greatly influenced many other languages and was the standard method for algorithm description used by the ACM, in textbooks, and academic works for the next 30 years and more. In the sense that most modern languages are \"algol-like\", it was arguably the most successful of the four high level programming languages with which it was roughly contemporary, Fortran, Lisp, and COBOL.",
                        "startdate": "1958-06-01 12:00:00",
                        "importance": "35",
                        "date_display": "ye",
                        "high_threshold": 50,
                        "icon": "circle_green.png"
                    },
                    {
                        "id": "jshist-unix",
                        "title": "UNIX",
                        "description": "Wikipedia:<br>Unix (officially trademarked as UNIX, sometimes also written as Unix) is a multitasking, multi-user computer operating system originally developed in 1969 by a group of AT&T employees at Bell Labs, including Ken Thompson, Dennis Ritchie, Brian Kernighan, Douglas McIlroy, and Joe Ossanna. The Unix operating system was first developed in assembly language, but by 1973 had been almost entirely recoded in C, greatly facilitating its further development and porting to other hardware.",
                        "startdate": "1969-06-01 12:00:00",
                        "importance": "45",
                        "date_display": "ye",
                        "high_threshold": 50,
                        "icon": "circle_green.png"
                    },
                    {
                        "id": "jshist-c",
                        "title": "C",
                        "description": "Wikipedia:<br>The initial development of C occurred at AT&T Bell Labs between 1969 and 1973; according to Ritchie, the most creative period occurred in 1972. It was named \"C\" because its features were derived from an earlier language called \"B\", which according to Ken Thompson was a stripped-down version of the BCPL programming language.",
                        "startdate": "1972-06-01 12:00:00",
                        "importance": "55",
                        "high_threshold": 50,
                        "image": "http://timeglider.com/widget/_js_history/ritchie_thompson.jpg",
                        "date_display": "ye",
                        "icon": "circle_green.png"
                    },
                    {
                        "id": "jshist-php",
                        "title": "PHP",
                        "description": "Wikipedia:<br>PHP was originally created by Rasmus Lerdorf in 1995. The main implementation of PHP is now produced by The PHP Group and serves as the formal reference to the PHP language.",
                        "startdate": "1995-06-08 12:00:00",
                        "importance": "48",
                        "high_threshold": 50,
                        "low_threshold": 46,
                        "date_display": "da",
                        "icon": "circle_green.png"
                    },
                    {
                        "id": "jshist-csharp",
                        "title": "C#",
                        "description": "",
                        "startdate": "1999-01-01 12:00:00",
                        "low_threshold": 46,
                        "high_threshold": 50,
                        "importance": "45",
                        "date_display": "ye",
                        "icon": "circle_green.png"
                    },
                    {
                        "id": "jshist-cpp",
                        "title": "C++",
                        "description": "Wikipedia:<br>Bjarne Stroustrup began work on \"C with Classes\" in 1979. The idea of creating a new language originated from Stroustrup's experience in programming for his Ph.D. thesis. Stroustrup found that Simula had features that were very helpful for large software development, but the language was too slow for practical use, while BCPL was fast but too low-level to be suitable for large software development.",
                        "startdate": "1983-06-01 12:00:00",
                        "low_threshold": 46,
                        "importance": "52",
                        "high_threshold": 50,
                        "date_display": "ye",
                        "icon": "circle_green.png"
                    },
                    {
                        "id": "jshist-python",
                        "title": "Python",
                        "description": "Wikipedia:<br>Python was conceived in the late 1980s and its implementation was started in December 1989 by Guido van Rossum at CWI in the Netherlands as a successor to the ABC programming language (itself inspired by SETL) capable of exception handling and interfacing with the Amoeba operating system.",
                        "startdate": "1989-12-01 12:00:00",
                        "low_threshold": 46,
                        "high_threshold": 50,
                        "importance": "45",
                        "date_display": "ye",
                        "icon": "circle_green.png"
                    },
                    {
                        "id": "jshist-ror",
                        "title": "Ruby on Rails",
                        "description": "Wikipedia:<br>David Heinemeier Hansson extracted Ruby on Rails from his work on Basecamp, a project management tool by 37signals (now a web application company). Hansson first released Rails as open source in July 2004, but did not share commit rights to the project until February 2005.",
                        "startdate": "2004-12-13 12:00:00",
                        "low_threshold": 46,
                        "high_threshold": 50,
                        "importance": "45",
                        "date_display": "ye",
                        "icon": "circle_green.png"
                    },
                    {
                        "id": "jshist-macwww",
                        "title": "MacWWW",
                        "description": "Wikipedia:<br>MacWWW, also known as Samba, is an early minimalist web browser from 1992 meant to run on Macintosh computers. It was the first web browser for the Mac OS platform, and the first for any non-Unix operating system.",
                        "startdate": "1992-12-23 12:00:00",
                        "high_threshold": 50,
                        "importance": "30",
                        "date_display": "da",
                        "link": "http://en.wikipedia.org/wiki/MacWWW",
                        "icon": "triangle_yellow.png"
                    },
                    {
                        "id": "jshist-mosaic",
                        "title": "First Popular Browser: Mosaic",
                        "description": "Mosaic is the web browser credited with popularizing the World Wide Web. It was also a client for earlier protocols such as FTP, NNTP, and gopher. Its clean, easily understood user interface, reliability, Windows port and simple installation all contributed to making it the application that opened up the Web to the general public. Mosaic was also the first browser to display images inline with text instead of displaying images in a separate window. While often described as the first graphical web browser, Mosaic was preceded by the lesser-known Erwise and ViolaWWW.",
                        "startdate": "1993-01-23 12:00:00",
                        "high_threshold": 50,
                        "importance": "40",
                        "date_display": "da",
                        "link": "http://en.wikipedia.org/wiki/Mosaic_%28web_browser%29",
                        "icon": "triangle_yellow.png"
                    },
                    {
                        "id": "jshist-java",
                        "title": "Java",
                        "description": "<img src='_js_history/gosling.jpg' style='float:left'>From Wikipedia:<br>Java was originally designed for interactive television, but it was too advanced for the digital cable television industry at the time. The language was initially called Oak after an oak tree that stood outside James Gosling's office; it went by the name Green later, and was later renamed Java, from Java coffee, said to be consumed in large quantities by the language's creators. Gosling aimed to implement a virtual machine and a language that had a familiar C/C++ style of notation.",
                        "startdate": "1991-06-15 12:00:00",
                        "high_threshold": 50,
                        "importance": "50",
                        "date_display": "ye",
                        "link": "http://en.wikipedia.org/wiki/Mosaic_%28web_browser%29",
                        "icon": "circle_green.png"
                    },
                    {
                        "id": "jshist-nexus",
                        "title": "WorldWideWeb (Nexus) Browser",
                        "description": "Tim Berners-Lee creates the first browser, initially called WorldWideWeb, but renamed to 'Nexus' to clear up confusion between the www network and his browser.",
                        "startdate": "1990-12-23 12:00:00",
                        "high_threshold": 50,
                        "importance": "35",
                        "date_display": "da",
                        "link": "http://en.wikipedia.org/wiki/WorldWideWeb",
                        "icon": "triangle_yellow.png"
                    },
                    {
                        "id": "jshist-aol1",
                        "title": "AOL 1.0",
                        "description": "Tim Berners-Lee creates the first browser, initially called WorldWideWeb, but renamed to 'Nexus' to clear up confusion between the www network and his browser.",
                        "startdate": "1993-01-23 12:00:00",
                        "high_threshold": 50,
                        "importance": "30",
                        "date_display": "da",
                        "link": "http://en.wikipedia.org/wiki/WorldWideWeb",
                        "icon": "circle_purple.png"
                    },
                    {
                        "id": "jshist-booklink",
                        "title": "AOL acquires BookLink ",
                        "description": "...foiling Microsoft.",
                        "startdate": "1994-11-23 12:00:00",
                        "high_threshold": 50,
                        "importance": "30",
                        "date_display": "da",
                        "link": "http://en.wikipedia.org/wiki/BookLink",
                        "icon": "circle_purple.png"
                    },
                    {
                        "id": "jshist-booklink",
                        "title": "AOL acquires BookLink browser",
                        "description": "Tim Berners-Lee creates the first browser.",
                        "startdate": "1994-11-23 12:00:00",
                        "high_threshold": 50,
                        "importance": "35",
                        "date_display": "da",
                        "link": "http://en.wikipedia.org/wiki/WorldWideWeb",
                        "icon": "triangle_yellow.png"
                    },
                    {
                        "id": "jshist-netscape",
                        "title": "Netscape founded",
                        "description": "Jim Clark, of Silicon Graphics, and Mark Andreesen create Netscape.",
                        "startdate": "1994-04-04 12:00:00",
                        "high_threshold": 50,
                        "importance": "40",
                        "date_display": "da",
                        "image": "http://timeglider.com/widget/_js_history/andreesen.jpg",
                        "link": "http://en.wikipedia.org/wiki/Mosaic_%28web_browser%29",
                        "icon": "circle_purple.png"
                    },
                    {
                        "id": "jshist-nnavigator",
                        "title": "Netscape Navigator v1.0",
                        "description": "Wikipedia:<br>Netscape Navigator was a proprietary web browser that was popular in the 1990s. It was the flagship product of the Netscape Communications Corporation and the dominant web browser in terms of usage share, although by 2002 its usage had almost disappeared.",
                        "startdate": "1994-12-15 12:00:00",
                        "click_callback": "pizzaShack.clicker",
                        "high_threshold": 50,
                        "importance": "40",
                        "date_display": "da",
                        "link": "http://en.wikipedia.org/wiki/Mosaic_%28web_browser%29",
                        "icon": "triangle_yellow.png"
                    },
                    {
                        "id": "jshist-jvms",
                        "title": "Eich and Hickman work on JVMs",
                        "description": "Eich and Kipp Hickman work on Java Virtual Machines, create Netscape Portable Runtime (NSPR). This becomes the basis for creating Mocha.<br><br>Says Eich: Kipp Hickman and I had been studying Java in April and May 1995, and Kipp had started writing his own JVM. Kipp and I wrote the first version of NSPR as a portability layer underlying his JVM, and I used it for the same purpose when prototyping “Mocha” in early-to-mid-May.",
                        "startdate": "1995-04-01 12:00:00",
                        "enddate": "1995-05-15 12:00:00",
                        "high_threshold": 50,
                        "importance": "20",
                        "link": "http://brendaneich.com/2008/04/popularity/",
                        "date_display": "da",
                        "icon": "circle_gray.png"
                    },
                    {
                        "id": "jshist-ie1",
                        "title": "Internet Explorer v1.0",
                        "description": "The first version of Internet Explorer (later referred to as Internet Explorer 1) made its debut on August 16, 1995. It was a reworked version of Spyglass Mosaic, which Microsoft had licensed, like many other companies initiating browser development, from Spyglass Inc. It came with Microsoft Plus! for Windows 95 and the OEM release of Windows 95, and was installed as part of the Internet Jumpstart Kit in Plus!",
                        "startdate": "1995-08-16 12:00:00",
                        "date_display": "da",
                        "high_threshold": 50,
                        "importance": "30",
                        "link": "http://en.wikipedia.org/wiki/Internet_Explorer#Internet_Explorer_1",
                        "icon": "circle_purple.png"
                    },
                    {
                        "id": "jshist-whatwg",
                        "title": "WHATWG Founded",
                        "description": "The Web Hypertext Application Technology Working Group (WHATWG) is a community of people interested in evolving HTML and related technologies. The WHATWG was founded by individuals from Apple, the Mozilla Foundation and Opera Software in 2004.",
                        "startdate": "2004-06-04 12:00:00",
                        "high_threshold": 50,
                        "importance": "25",
                        "link": "http://www.whatwg.org/",
                        "icon": "circle_purple.png"
                    },
                    {
                        "id": "jshist-jscript",
                        "title": "jScript in IE3",
                        "description": "",
                        "startdate": "1996-08-01 12:00:00",
                        "high_threshold": 50,
                        "importance": "30",
                        "link": "http://www.whatwg.org/",
                        "icon": "circle_purple.png"
                    },
                    {
                        "id": "jshist-dhtml",
                        "title": "DHTML!!",
                        "description": "Rollovers! Animated Text! So cool. Basic DHTML support was introduced with Internet Explorer 4.0, although there was a basic dynamic system with Netscape Navigator 4.0. When it originally became widespread DHTML style techniques were difficult to develop and debug due to varying degrees of support among web browsers of the technologies involved.",
                        "startdate": "1997-09-01 12:00:00",
                        "high_threshold": 50,
                        "importance": "45",
                        "link": "http://www.whatwg.org/",
                        "icon": "circle_purple.png"
                    },
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
                        "id": "jshist-livewire",
                        "title": "Netscape LiveWire",
                        "description": "<img src='_js_history/livewire_cover.jpg' style='float:left'>LiveWire was a first attempt by Netscape to create a super-framework that included their Java back-end and database connectivity and front-end scripting. This was ostensibly to go head-to-head with Microsoft's new ASP framework. But also, Javascript could be included in the compile-time file to interpret server-side data (a .web file), much like today's PHP. It is uncanny how similar their system was to the later Flash compiled-bytecode system. It was a complete flop.",
                        "startdate": "1997-06-01 12:00:00",
                        "high_threshold": 50,
                        "importance": "35",
                        "modal_type": "full",
                        "icon": "square_orange.png",
                        "tags": "java,flop,netscape, aol"
                    },
                    {
                        "id": "jshist-coffee",
                        "title": "CoffeeScript",
                        "description": "Wikipedia:<br>On December 13, 2009, Jeremy Ashkenas made the first Git commit of CoffeeScript with the comment: \"initial commit of the mystery language.\" CoffeeScript was created after reading the \"Create Your Own Programming Language\" ebook.",
                        "startdate": "2009-12-13 12:00:00",
                        "high_threshold": 50,
                        "importance": "30",
                        "icon": "circle_green.png"
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
                        "id": "jshist-01",
                        "title": "\"Ten Days in May\": Mocha",
                        "description": "JavaScript was developed by Brendan Eich of Netscape, originally under the name Mocha.<br><br><a href='http://brendaneich.com/2008/04/popularity/'>Said Eich:</a><br><em>As I’ve often said, and as others at Netscape can confirm, I was recruited to Netscape with the promise of \"doing Scheme\" in the browser. At least client engineering management...were convinced that Netscape should embed a programming language, in source form, in HTML.</em>",
                        "startdate": "1995-05-15 06:00:00",
                        "enddate": "1995-05-25 23:00:00",
                        "date_display": "da",
                        "link": "http://en.wikipedia.org/wiki/JavaScript",
                        "high_threshold": 50,
                        "importance": "55",
                        "video": "http://www.youtube.com/embed/0lvMgMrNDlg",
                        "modal_type": "full",
                        "icon": "triangle_green.png",
                        "image": "http://timeglider.com/widget/_js_history/eich.gif"
                    },
                    {
                        "id": "jshist-nnav2",
                        "title": "LiveScript Ships in Netscape Navigator 2.0",
                        "description": "",
                        "startdate": "1995-06-01 06:00:00",
                        "date_display": "da",
                        "link": "http://en.wikipedia.org/wiki/JavaScript",
                        "high_threshold": 50,
                        "importance": "40",
                        "icon": "triangle_green.png"
                    },
                    {
                        "id": "jshist-02",
                        "title": "JavaScript",
                        "description": "<p>LiveScript is renamed JavaScript in a joint announcement with Netscape and Sun Microsystems.On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble that are bound to ensue; and equal blame belongs to those who fail in their duty through weakness of will, which is the same as saying through shrinking from toil and pain. These cases are perfectly simple and easy to distinguish. In a free hour, when our power of choice is untrammelled and when nothing prevents our being able to do what we like best, every pleasure is to be welcomed and every pain avoided. But in certain circumstances and owing to the claims of duty or the obligations of business it will frequently occur that pleasures have to be repudiated and annoyances accepted. The wise man therefore always holds in these matters to this principle of selection: he rejects pleasures to secure other greater pleasures, or else he endures pains to avoid worse pains.<br><br>On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble that are bound to ensue; and equal blame belongs to those who fail in their duty through weakness of will, which is the same as saying through shrinking from toil and pain. These cases are perfectly simple and easy to distinguish. In a free hour, when our power of choice is untrammelled and when nothing prevents our being able to do what we like best, every pleasure is to be welcomed and every pain avoided. But in certain circumstances and owing to the claims of duty or the obligations of business it will frequently occur that pleasures have to be repudiated and annoyances accepted. The wise man therefore always holds in these matters to this principle of selection: he rejects pleasures to secure other greater pleasures, or else he endures pains to avoid worse pains.</p>",
                        "startdate": "1995-12-04 12:00:00",
                        "enddate": "1995-12-04 12:00:00",
                        "date_display": "mo",
                        "link": "http://en.wikipedia.org/wiki/JavaScript",
                        "high_threshold": 50,
                        "importance": "55",
                        "date_display":"da",
                                "icon": "circle_green.png",
                        "image": "http://upload.wikimedia.org/wikipedia/commons/thumb/0/09/BEich.jpg/220px-BEich.jpg",
                        "video": "http://www.youtube.com/embed/c-kav7Tf834?rel=0"
                    },
                    {
                        "id": "jshist-bibliocene",
                        "title": "The Bibliocene",
                        "description": "The primordial forests of Javascript were rich with life, but until Prototype, dominant species of cross-browser helper-library had emerged. Then there was Dojo.",
                        "startdate": "2004-06-01 12:00:00",
                        "enddate": "today",
                        "date_display": "mo",
                        "low_threshold": 41,
                        "high_threshold": 45,
                        "importance": "60",
                        "date_display":"ye",
                                "css_class": "bibliocene",
                        "icon": "none"
                    },
                    {
                        "id": "jshist-js-era",
                        "title": "Javascript Era",
                        "description": "There was Javascript.",
                        "startdate": "1995-05-01 12:00:00",
                        "enddate": "today",
                        "date_display": "mo",
                        "low_threshold": 41,
                        "high_threshold": 52,
                        "importance": "60",
                        "date_display":"ye",
                                "y_position": 200,
                        "css_class": "js-era",
                        "icon": "none"
                    },
                    {
                        "id": "jshist-14rhino",
                        "title": "Mozilla Rhino Engine",
                        "description": "Fast, but flawed Java engine introduced",
                        "startdate": "1997-10-01 12:00:00",
                        "enddate": "1997-10-01 12:00:00",
                        "date_display": "mo",
                        "link": "http://www.mozilla.org/rhino/history.html",
                        "high_threshold": 50,
                        "importance": "35",
                        "icon": "square_gray.png"
                    },
                    {
                        "id": "jshist-squirrelfish",
                        "title": "Webkit Squirrelfish",
                        "description": "Wikipedia:<br>On June 2, 2008, the WebKit project announced they rewrote JavaScriptCore as \"SquirrelFish\", a bytecode interpreter. The project evolved into SquirrelFish Extreme (abbreviated SFX), announced on September 18, 2008, which compiles JavaScript into native machine code, eliminating the need for a bytecode interpreter and thus speeding up JavaScript execution.",
                        "startdate": "2008-06-02",
                        "date_display": "mo",
                        "link": "http://en.wikipedia.org/wiki/WebKit#Further_development",
                        "high_threshold": 50,
                        "importance": "35",
                        "icon": "square_gray.png"
                    },
                    {
                        "id": "deathofflash",
                        "title": "Slow death of Flash",
                        "description": "Flash begins its slow death. Many factors led to this: The rise of Javascript as a viable rich-application framework. Being a compiled, proprietary system reliant on IDEs, Flash never got developers <em>truly</em> excited; Integrating events in Flash with the DOM is headache defined; Even on Android mobile systems that allowed Flash, Adobe couldn't get a bug-free, non-gluttonous version. Apple's refusal to include it in iOS is a coup de grace, and Adobe finally (sort of) admits defeat.",
                        "startdate": "2009-06-01",
                        "enddate": "today",
                        "date_display": "ho",
                        "high_threshold": 50,
                        "importance": "35",
                        "icon": "flag_black.png",
                        "keepCurrent": "end"
                    },
                    {
                        "id": "jshist-tracemonkey",
                        "title": "TraceMonkey, JIT engine",
                        "description": "Firefox releases a turbo-charged version of SpiderMonkey with Firefox 3.5that is the first <a href='http://en.wikipedia.org/wiki/Just-in-time_compilation'>JIT</a> (Just In Time) compiler of Javascript.",
                        "startdate": "2009-06-30",
                        "date_display": "mo",
                        "link": "http://en.wikipedia.org/wiki/TraceMonkey#TraceMonkey",
                        "high_threshold": 50,
                        "importance": "35",
                        "icon": "square_gray.png"
                    },
                    {
                        "id": "jshist-resig-post",
                        "title": "Resig: ECMAScript Harmony",
                        "description": "There's been some turmoil in the world of ECMAScript.<br><br>While many are – even, at least, vaguely – familiar with the development of ECMAScript 4 the devil is in the details. I’ve blogged about ES4 extensively in the past – and even did a speaking tour last fall educating developers about its details and implementations, however, a lot has happened since that time.",
                        "startdate": "2008-08-14 12:00:00",
                        "enddate": "2008-08-14 12:00:00",
                        "date_display": "da",
                        "link": "http://ejohn.org/blog/ecmascript-harmony/",
                        "high_threshold": 50,
                        "importance": "30",
                        "icon": "inf_blue.png"
                    },
                    {
                        "id": "jshist-jj-garrett",
                        "title": "Ajax: A New Approach to Web Applications",
                        "description": "Jesse James Garrett publishes his seminal essay and coins the term \"ajax\". Said Garrett 'An Ajax application eliminates the start-stop-start-stop nature of interaction on the Web by introducing an intermediary—an Ajax engine—between the user and the server. It seems like adding a layer to the application would make it less responsive, but the opposite is true.'",
                        "startdate": "2005-02-18 12:00:00",
                        "enddate": "2005-02-18 12:00:00",
                        "date_display": "da",
                        "link": "http://www.adaptivepath.com/ideas/e000385",
                        "high_threshold": 50,
                        "importance": "42",
                        "image": "http://timeglider.com/widget/_js_history/garrett.jpg",
                        "icon": "inf_blue.png"
                    },
                    {
                        "id": "jshist-inception",
                        "title": "JS Inception",
                        "description": "...",
                        "startdate": "1995-05-15 06:00:00",
                        "enddate": "1997-11-01 12:00:00",
                        "date_display": "mo",
                        "link": "http://en.wikipedia.org/wiki/JavaScript",
                        "low_threshold": 41,
                        "high_threshold": 45,
                        "importance": 60,
                        "css_class": "inception",
                        "icon": "none"
                    },
                    {
                        "id": "jshist-browserwars",
                        "title": "Browserwars",
                        "description": "Wikipedia:<br>In 1996, Netscape's share of the browser market reached 86%; but then Microsoft began integrating its browser with its operating system and bundling deals with OEMs, and within two years the balance had reversed.",
                        "startdate": "1996-01-01 12:00:00",
                        "enddate": "1998-12-01 12:00:00",
                        "date_display": "mo",
                        "link": "http://en.wikipedia.org/wiki/JavaScript",
                        "high_threshold": 45,
                        "importance": 60,
                        "css_class": "browserwars",
                        "icon": "none"
                    },
                    {
                        "id": "jshist-shadow-years",
                        "title": "THE DHTML DOLDRUMS",
                        "description": "In these first years, JS seems like a necessary evil that had been avoidable but which was now entrenched. Of Javascript's initial insinuation into browsers, WWW founder Robert Cailliau said, 'the programming-vacuum filled itself with the most horrible kluge in the history of computing: Javascript.'",
                        "startdate": "1998-01-01 12:00:00",
                        "enddate": "2004-01-01 12:00:00",
                        "date_display": "mo",
                        "link": "http://en.wikipedia.org/wiki/JavaScript",
                        "high_threshold": 45,
                        "importance": 60,
                        "css_class": "shadow-years",
                        "icon": "none"
                    },
                    {
                        "id": "jshist-ajax-age",
                        "title": "The Ajax'aissance",
                        "description": "Ajax, seeded by the XMLHttpRequest object, is born.",
                        "startdate": "2005-01-01 12:00:00",
                        "enddate": "today",
                        "date_display": "ye",
                        "link": "http://en.wikipedia.org/wiki/Ajax_%28programming%29",
                        "low_threshold": 41,
                        "high_threshold": 45,
                        "importance": 60,
                        "span_color": "#FFFFFF",
                        "icon": "none"
                    },
                    {
                        "id": "jshist-hawt",
                        "title": "\"Hawt\"!",
                        "description": "The JS community is on fire! Libraries, widgets, evangelists, arguments, and the spread of the 'good bacteria' of JS.",
                        "startdate": "2010-01-01 12:00:00",
                        "enddate": "today",
                        "date_display": "mo",
                        "low_threshold": 41,
                        "high_threshold": 45,
                        "importance": 60,
                        "css_class": "hawt",
                        "icon": "none"
                    },
                    {
                        "id": "jshist-aolscape",
                        "title": "Netscape sold to AOL for $4.2 billion",
                        "description": "O'Reilly publishes the first comprehensive book on Javascript.",
                        "startdate": "1998-11-24 12:00:00",
                        "date_display": "mo",
                        "link": "http://news.cnet.com/2100-1023-218360.html",
                        "high_threshold": 50,
                        "importance": "45",
                        "icon": "flag_black.png",
                        "tags": "billion,book, netscape, aol"
                    },
                    {
                        "id": "jshist-04",
                        "title": "JS submitted to ECMA",
                        "description": "Netscape submits JavaScript to Ecma International for consideration as an industry standard. Interestingly, Sun Microsystems at one point submitted Java to Ecma, but withdrew the submission later.",
                        "startdate": "1996-11-01 12:00:00",
                        "date_display": "mo",
                        "link": "http://www.ecmascript.org/",
                        "high_threshold": 50,
                        "importance": "35",
                        "icon": "triangle_green.png"
                    },
                    {
                        "id": "jshist-flan",
                        "title": "JS The Definitive Guide",
                        "description": "O'Reilly publishes the first comprehensive book on Javascript.",
                        "startdate": "1996-06-01 12:00:00",
                        "date_display": "mo",
                        "link": "http://www.davidflanagan.com/",
                        "image": "http://timeglider.com/widget/_js_history/flanagan.jpg",
                        "high_threshold": 100,
                        "importance": "35",
                        "icon": "triangle_green.png"
                    },
                    {
                        "id": "jshist-ecma1",
                        "title": "ECMA-262 Edition 1",
                        "description": "ECMA standards body formally announces first standardized version of Javascript:ECMA-262 Edition 1",
                        "startdate": "1997-06-01 12:00:00",
                        "date_display": "mo",
                        "link": "http://www.ecmascript.org/",
                        "high_threshold": 50,
                        "importance": "35",
                        "icon": "triangle_green.png"
                    },
                    {
                        "id": "jshist-ecma2",
                        "title": "ECMA-262 Edition 2",
                        "description": "Editorial changes to keep the specification fully aligned with ISO/IEC 16262 international standard",
                        "startdate": "1998-06-01 12:00:00",
                        "date_display": "mo",
                        "link": "http://www.ecmascript.org/",
                        "high_threshold": 50,
                        "importance": "30",
                        "icon": "triangle_green.png"
                    },
                    {
                        "id": "jshist-ecma3",
                        "title": "ECMA-262 Edition 3",
                        "description": "Added regular expressions, better string handling, new control statements, try/catch exception handling, tighter definition of errors, formatting for numeric output and other enhancements",
                        "startdate": "1999-12-01 12:00:00",
                        "date_display": "mo",
                        "link": "http://en.wikipedia.org/wiki/ECMAScript",
                        "high_threshold": 50,
                        "importance": "45",
                        "icon": "triangle_green.png"
                    },
                    {
                        "id": "jshist-ecma4",
                        "title": "ECMA Ed. 4 TANKS",
                        "description": "Added regular expressions, better string handling, new control statements, try/catch exception handling, tighter definition of errors, formatting for numeric output and other enhancements",
                        "startdate": "2003-11-01 12:00:00",
                        "date_display": "mo",
                        "link": "http://en.wikipedia.org/wiki/ECMAScript",
                        "high_threshold": 50,
                        "importance": "45",
                        "icon": "triangle_green.png"
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
                        "id": "jshist-08",
                        "title": "JSON is introduced",
                        "description": "Wikipedia:<br>Douglas Crockford was the first to specify and popularize the JSON format. JSON was used at State Software, a company co-founded by Crockford, starting around 2001. The JSON.org website was launched in 2002. In December 2005, Yahoo! began offering some of its web services in JSON.  Google started offering JSON feeds for its GData web protocol in December 2006.",
                        "startdate": "2002-07-01 12:00:00",
                        "enddate": "2002-07-01 12:00:00",
                        "date_display": "mo",
                        "link": "http://json.org",
                        "image": "http://timeglider.com/widget/_js_history/crockford.jpg",
                        "high_threshold": 50,
                        "importance": "45",
                        "icon": "circle_orange.png"
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
                        "id": "jshist-as1",
                        "title": "Actionscript 1",
                        "description": "With the release of Flash 5 in September 2000, the \"actions\" from Flash 4 were enhanced once more and named \"ActionScript\" for the first time. This was the first version of ActionScript with influences from JavaScript.",
                        "startdate": "2000-09-01 12:00:00",
                        "link": "http://en.wikipedia.org/wiki/ActionScript",
                        "high_threshold": 50,
                        "importance": "35",
                        "icon": "square_red.png"
                    },
                    {
                        "id": "jshist-as2",
                        "title": "Actionscript 2",
                        "description": "In response to user demand for a language better equipped for larger and more complex applications, ActionScript 2.0 featured compile-time type checking and class-based syntax, such as the keywords class and extends.",
                        "startdate": "2003-09-01 12:00:00",
                        "link": "http://en.wikipedia.org/wiki/ActionScript",
                        "high_threshold": 50,
                        "importance": "40",
                        "icon": "square_red.png"
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
                        "id": "jshist-node",
                        "title": "Node.js",
                        "description": "Wikipedia:<br>Node.js was created by Ryan Dahl starting in 2009, and its growth is sponsored by Joyent, his employer.",
                        "startdate": "2009-02-01 12:00:00",
                        "date_display": "mo",
                        "link": "http://nodejs.org/",
                        "high_threshold": 50,
                        "importance": "45",
                        "icon": "square_orange.png"
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
                        "id": "jshist-spidermonk",
                        "title": "Spidermonkey",
                        "description": "Very fast Javascript engine introduced",
                        "startdate": "1996-10-01 12:00:00",
                        "date_display": "mo",
                        "link": "http://en.wikipedia.org/wiki/SpiderMonkey",
                        "high_threshold": 50,
                        "importance": "25",
                        "icon": "square_gray.png"
                    },
                    {
                        "id": "jshist-14",
                        "title": "Google Chrome V8",
                        "description": "Very fast Javascript engine introduced",
                        "startdate": "2008-12-01 12:00:00",
                        "enddate": "2008-12-01 12:00:00",
                        "date_display": "mo",
                        "link": "http://code.google.com/p/v8/",
                        "high_threshold": 50,
                        "importance": "35",
                        "icon": "square_gray.png"
                    },
                    {
                        "id": "jshist-10",
                        "title": "CommonJS project",
                        "description": "The official JavaScript spec does not define a standard library that is useful for building a broader range of applications. The CommonJS API will fill that gap by defining APIs that handle many common application needs, ultimately providing a standard library as rich as those of Python, Ruby and Java.",
                        "startdate": "2009-01-01 12:00:00",
                        "enddate": "2009-01-01 12:00:00",
                        "link": "http://www.commonjs.org/",
                        "high_threshold": 50,
                        "importance": "25",
                        "icon": "square_blue.png"
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
                    },
                    {
                        "id": "jshist-ffconf",
                        "title": "Full Frontal Conference",
                        "description": "Released at the Boston JQuery Conference",
                        "startdate": "2009-11-20 12:00:00",
                        "link": "http://2009.full-frontal.org/",
                        "high_threshold": 50,
                        "importance": "30",
                        "icon": "circle_blue.png"
                    },
                    {
                        "id": "jsconf2010",
                        "title": "JS Conf 2010",
                        "description": "The theme for JSConf US 2010 is 'Pirates' and we do intend on taking that to the limit. Already we have buried some treasure(.js) for a few lucky land lubbers. Everything you have seen, heard, or come to know of about JSConf is about to change once again. Prepare to cast away for an amazing time as the JavaScript community comes together once again in Washington, DC.",
                        "startdate": "2010-04-17 08:00:00",
                        "enddate": "2010-04-18 18:00:00",
                        "link": "http://jsconf.us/2010/",
                        "high_threshold": 50,
                        "importance": "40",
                        "icon": "circle_blue.png",
                        "map": {
                            "label": "JSConf 2010",
                            "latlong": "38.8969007, -77.0724308",
                            "markers": [
                                {
                                    "latlong": "38.8969007, -77.0724308",
                                    "icon": "http://timeglider.com/jquery/img/jsconf.png",
                                    "title": "JS Conf 2010, in Arlington/Washington DC",
                                    "zIndex": 99
                                }
                            ]
                        }
                    },
                    {
                        "id": "jsconf2011",
                        "title": "JS Conf 2011",
                        "description": "Portland, Oregon, at the Portland Art Museum. Highlights included Andrew Dupont's talk, 'Everything is Permitted: Extending Built-ins', doughnuts, and more.",
                        "startdate": "2011-05-02 08:00:00",
                        "enddate": "2011-05-03 18:00:00",
                        "link": "http://2011.jsconf.us/",
                        "high_threshold": 50,
                        "importance": "40",
                        "icon": "circle_blue.png",
                        "tags": "conference,arizona,chris",
                        "map": {
                            "label": "JSConf 2011",
                            "latlong": "45.51655690309638,-122.68299579620361",
                            "markers": [
                                {
                                    "latlong": "45.51655690309638, -122.68299579620361",
                                    "icon": "http://timeglider.com/jquery/img/jsconf.png",
                                    "title": "Portland Art Museum",
                                    "zIndex": 99
                                }
                            ]
                        }
                    },
                    {
                        "id": "jsconf2012",
                        "title": "JSConf 2012",
                        "description": "JSConf is one of the most exciting and cutting edge technical conferences ever and it's all about JS - what could be better? This year we put on our boots, saddle up our horses, and head out to that crazy little town with the epic western feel and perfect JSConf vibe, Scottsdale, Arizona! Come prepared as your curators Chris and Laura Williams pull out all the stops in the fourth edition of JSConf US.",
                        "startdate": "2012-04-01 08:00:00",
                        "enddate": "2012-04-04 18:00:00",
                        "link": "http://2012.jsconf.us",
                        "high_threshold": 50,
                        "importance": "40",
                        "icon": "circle_blue.png",
                        "tags": "conference,arizona,chris, mardigras"
                    },
                    {
                        "id": "_now",
                        "title": "nowEvent",
                        "date_display": "ho",
                        "description": "You can set a date to a \"floating\" current date by using either \"7777-12-31\" as the startdate, or \"now\". In an event span, either the start date or the end-date can be set this way to create living lifespans, or timespans with decreasing lengths (from the present) as time moves forward, such as a deal or a time-remaining episode.",
                        "startdate": "now",
                        "high_threshold": 100,
                        "importance": "40",
                        "css_class": "foo",
                        "icon": "triangle_red.png",
                        "keepCurrent": "start",
                        "tags": "mardigras"
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
            "icon_folder": "timeglider/icons/",
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


        tg_instance.panButton($(".pan-left"), "left");
        tg_instance.panButton($(".pan-right"), "right");


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

            var d = new Date(so.focusMS)

            ml += "<br><br>Date using focusMS:" + d.toString('yyyy-MM-dd');

            $(".scope-view").html(ml);

        });


        $("#loadData").click(function () {

            var src = $("#loadDataSrc").val();

            var cb_fn = function (args, timeline) {
                // called after parsing data, after load
                debug.log("args", args, "timeline", timeline[0].id);
            };

            var cb_args = {}; // {display:true};

            tg_instance.getMediator().emptyData();
            tg_instance.loadTimeline(src, function () {
                debug.log("cb!");
            }, true);

            $("#reloadDataDiv").hide();
        });


        $("#reloadTimeline").click(function () {
            tg_instance.reloadTimeline("js_history", "json/js_history.json");
        });



        $("#refresh").click(function () {
            debug.log("timeline refreshed!");
            tg_instance.refresh();
        });



        $("#scrolldown").bind("click", function () {
            $(".timeglider-timeline-event").animate({top: "+=100"})
        })

        $("#scrollup").bind("click", function () {
            $(".timeglider-timeline-event").animate({top: "-=100"})
        })




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
