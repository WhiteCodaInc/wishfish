<style type="text/css">
    #planForm row:first-child{
        text-align: right
    }
</style>
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
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">Charge Customer <strong>$</strong></div>
                                    <div class="col-md-4">
                                        <input value="<?= isset($plans) ? $plans->initial_amt : '' ?>" name="initial_amt" type="number" class="form-control" required="" >
                                    </div>
                                    <div class="col-md-4">immediately</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">then after</div>
                                    <div class="col-md-4">
                                        <input value="<?= isset($plans) ? $plans->trial_period : '' ?>" name="trial_period" type="number" class="form-control" required="" >
                                    </div>
                                    <div class="col-md-4">days</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">charge <strong>$</strong></div>
                                    <div class="col-md-4">
                                        <input value="<?= isset($plans) ? $plans->amount : '' ?>" name="amount" type="number" class="form-control" required="" >
                                    </div>
                                    <div class="col-md-4"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">every</div>
                                    <div class="col-md-4">
                                        <input value="<?= isset($plans) ? $plans->interval_count : '' ?>" name="interval_count" type="number" class="form-control" required="" >
                                    </div>
                                    <div class="col-md-4">
                                        <select name="interval" class="form-control">
                                            <option value="day">Day</option>
                                            <option value="week">Week</option>
                                            <option value="month">Month</option>
                                            <option value="year">Year</option>
                                        </select>
                                    </div>
                                </div>
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
<?php if (isset($plans)): ?>
            $('select[name="interval"]').val("<?= $plans->interval ?>");
<?php endif; ?>
        $('#addPlan').click(function () {
            var intervalC = parseInt($('input[name="interval_count"]').val());
            var interval = $('select[name="interval"]').val();
            console.log(intervalC);
            console.log(interval);
            if (interval == "day" && intervalC < 0 && intervalC > 365) {
                alertify.error("Please Enter Interval Between 1 To 365 Day");
                return false;
            } else if (interval == "week" && intervalC < 0 && intervalC > 52) {
                alertify.error("Please Enter Interval Between 1 To 52 Week");
                return false;
            } else if (interval == "month" && intervalC < 0 && intervalC > 12) {
                alertify.error("Please Enter Interval Between 1 To 12 Month");
                return false;
            } else if (interval == "year" && intervalC < 0 && intervalC > 1) {
                alertify.error("Maximum of 1 year interval allowed");
                return false;
            } else {
                $('#planForm').submit();
            }
        });
    });
</script>