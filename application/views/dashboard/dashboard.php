<link rel="stylesheet" href="<?= base_url() ?>assets/dashboard/js/plugins/clock/css/experiment.css" />
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
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
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
