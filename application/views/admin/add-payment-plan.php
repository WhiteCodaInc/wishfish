<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="display: none">
            <?= isset($plans) ? "Edit" : "Add New" ?> Payment Plan
        </h1>
        <button type="submit" id="addPlan" class="btn btn-primary">
            <?= isset($plans) ? 'Update Existing Payment Plan' : 'Create New Payment Plan' ?>
        </button>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3"></div>
            <!-- left column -->
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title"><?= isset($plans) ? "Existing" : "New" ?> Payment Plan</h3>
                    </div><!-- /.box-header -->
                    <?php $method = isset($plans) ? "updatePlan" : "createPlan"; ?>
                    <!-- form start -->
                    <form id="planForm" role="form" action="<?= site_url() ?>admin/plans/<?= $method ?>" method="post">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Payment Plan</label>
                                <input value="<?= isset($plans) ? $plans->payment_plan : '' ?>" type="text" name="payment_plan" autofocus="autofocus" class="form-control" placeholder="Payment Plan Name" />
                            </div>
                            <div class="form-control">
                                Charge Customer <strong>$</strong>
                                <input name="initial_amt" type="number" class="form-control-inline" required="" >
                                immediately<br/>
                                <input name="trial_period" type="number" class="form-control-inline" required="" >
                                days<br/>
                                charge <strong>$</strong>
                                <input name="amount" type="number" class="form-control-inline" required="" ><br/>
                                every <input name="interval_count" type="number" class="form-control-inline" required="" >
                                <select name="interval" class="form-control-inline">
                                    <option value="day">Days</option>
                                    <option value="week">Week</option>
                                    <option value="month">Months</option>
                                    <option value="year">Year</option>
                                </select>
                            </div>
                        </div><!-- /.box-body -->

                        <?php if (isset($plans)): ?>
                            <input type="hidden" name="planid" value="<?= $plans->payment_plan_id ?>" />
                        <?php endif; ?>
                    </form>
                </div><!-- /.box -->
            </div><!--/.col (left) -->
            <div class="col-md-3"></div>
            <!-- right column -->
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->
</div><!-- ./wrapper -->
<script type="text/javascript">
    $(document).ready(function () {
        $('#addPlan').click(function () {
            $('#planForm').submit();
        });
    });
</script>