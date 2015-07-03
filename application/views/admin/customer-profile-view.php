<style type="text/css">
    .title{
        color: #3c8dbc;
    }
</style>
<aside class="right-side">

    <?php
    $userInfo = $this->wi_common->getUserInfo($customer->user_id);
    $currPlan = $this->wi_common->getCurrentPlan($customer->user_id);
    ?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style=" display: none">
            Customer Profile
        </h1>
        <a href="<?= site_url() ?>admin/customers/editCustomer/<?= $customer->user_id ?>" class="create btn bg-navy">
            <i class="fa fa-edit"></i>
            Edit
        </a>
        <a href="<?= site_url() ?>admin/customers/loginAsUser/<?= $customer->user_id ?>" class="create btn bg-maroon" target="_blank">
            <i class="fa fa-lock"></i>
            Log in As User
        </a>
        <?php if (count($currPlan) && $currPlan->plan_id == 1) : ?>
            <a href="#" id="extend" class="create btn bg-olive" data-toggle="modal" data-target="#trial-modal">
                <i class="fa fa-edit"></i>
                Extend Trial
            </a>
        <?php endif; ?>
    </section>
    <?php
    $img_src = ($customer->profile_pic != "") ?
            "http://mikhailkuznetsov.s3.amazonaws.com/" . $customer->profile_pic :
            base_url() . 'assets/dashboard/img/default-avatar.png';
    ?>
    <!-- Main content -->
    <section class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="user-panel">
                            <div class="image" style="text-align: center">
                                <img style="width: 150px;height: 150px"  src="<?= $img_src ?>" class="img-circle" alt="User Image" />
                            </div>
                            <div class="info" style="text-align: center">
                                <h3 class="title" style="margin: 0"><?= $customer->name ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4" style="margin-top:10px ">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4"><label>Profile Status</label></div>
                                <div class="col-md-8">
                                    <?php if ($customer->status): ?>
                                        <span class="btn btn-success btn-xs">Active</span>
                                    <?php else : ?>
                                        <span class="btn btn-danger btn-xs">Deactivate</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4"><label>E-mail</label></div>
                                <div class="col-md-8">
                                    <span class="title"><?= $customer->email ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4"><label>Birthday</label></div>
                                <div class="col-md-8">
                                    <span class="title">
                                        <?= ($customer->birthday != NULL) ? date('d-m-Y', strtotime($customer->birthday)) : 'N/A' ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4"><label>Phone</label></div>
                                <div class="col-md-8">
                                    <span class="title"><?= $customer->phone ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4"><label>Timezone</label></div>
                                <div class="col-md-8">
                                    <span class="title"><?= ($customer->timezones != NULL) ? $customer->timezones : 'N/A' ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4"><label>Profile Type</label></div>
                                <div class="col-md-8">
                                    <span class="title"><?= ($customer->profile_type != "-1") ? $customer->profile_type : 'N/A' ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4"><label>Profile Link</label></div>
                                <div class="col-md-8">
                                    <span class="title"><?= ($customer->profile_link != NULL) ? $customer->profile_link : 'N/A' ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4"><label>Plan</label></div>
                                <div class="col-md-8">
                                    <span class="title"><?= $customer->plan_name ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4"><label>Payment Gateway</label></div>
                                <div class="col-md-8">
                                    <span class="title"><?= $customer->gateway ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4"><label>Join Date</label></div>
                                <div class="col-md-8">
                                    <span class="title"><?= date('d-m-Y', strtotime($customer->register_date)) ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4"><label>Join Time</label></div>
                                <div class="col-md-8">
                                    <span class="title"><?= date('H : i : s', strtotime($customer->register_date)) ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4"><label>Join Via</label></div>
                                <div class="col-md-8">
                                    <span class="title"><?= ($customer->join_via != NULL) ? $customer->join_via : 'N/A' ?></span>
                                </div>
                            </div>
                        </div>
                        <?php
                        if (count($currPlan) && $currPlan->plan_id == 1) {
                            $trialD = $this->common->getDateDiff($userInfo, $currPlan);
                            ?>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4"><label>Days Left on Trial</label></div>
                                    <div class="col-md-6">
                                        <span class="title" style="color:<?= (!$trialD) ? 'red' : '' ?>">
                                            <?= ($trialD) ? $trialD : "Expired" ?>
                                        </span>
                                    </div>
                                    <div class="col-md-2">
                                        <button id="extend" class="btn btn-xs bg-">Extend</button>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- NEW ADMIN ACCESS CLASS MODAL -->
    <div class="modal fade" id="trial-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 400px">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Extend Trial Period</h4>
                </div>
                <!-- FORM MODULE -->
                <form action="<?= site_url() ?>customers/extendTrial" method="post">
                    <div class="modal-body">                    
                        <div class="row">
                            <div class="col-md-3">
                                <label>Expiry Date</label>
                            </div>
                            <div class="col-md-1">
                                <label>:</label>
                            </div>
                            <div class="col-md-8">
                                <label><?= $currPlan->expiry_date ?></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label>Extend Trial Date</label>
                            </div>
                            <div class="col-md-1">
                                <label>:</label>
                            </div>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input name="extend_date" value=""  class="form-control form-control-inline input-medium default-date-picker" size="16" type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer clearfix">
                        <div class="row">
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary pull-left">Extend Trial Period</button>
                            </div>
                            <div class="col-md-3">
                                <button type="button" id="discard" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Discard</button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="userid" value="<?= $customer->user_id ?>" />
                </form>
                <!-- END  FORM MODULE -->

                <!-- AJAX MODULE -->
                <!-- 
                <div class="modal-body">                    
                    <div class="row">
                        <div class="col-md-3">
                            <label>Expiry Date</label>
                        </div>
                        <div class="col-md-1">
                            <label>:</label>
                        </div>
                        <div class="col-md-8">
                            <label><?= $currPlan->expiry_date ?></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label>Extend Trial Date</label>
                        </div>
                        <div class="col-md-1">
                            <label>:</label>
                        </div>
                        <div class="col-md-8">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input name="extend_date" value=""  class="form-control form-control-inline input-medium default-date-picker" size="16" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <img id="load" src="<?= base_url() ?>assets/dashboard/img/load.GIF" alt="" style="display: none" />
                            <span style="display: none" id="msg"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer clearfix">
                    <div class="row">
                        <div class="col-md-3">
                            <button type="button" id="extendDate" class="btn btn-primary pull-left">Extend Trial Period</button>
                        </div>
                        <div class="col-md-3">
                            <button type="button" id="discard" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Discard</button>
                        </div>
                    </div>
                </div>
                -->
                <!-- END  AJAX MODULE -->
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

</aside>
</div>
<script type="text/javascript">

    $(function () {
        $('.default-date-picker').datepicker({
            format: "mm-dd-yyyy",
            todayBtn: "linked",
            autoclose: true,
            todayHighlight: true
        });
    });

<?php if ($this->input->get('msg') != ""): ?>
        alertify.error("Customer account currently was deactivated..!");
<?php endif; ?>
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#extendDate').click(function () {
            var edate = $('input[name="extend_date"]').val();
            var userid = "<?= $customer->user_id ?>";
            $('#load').css('display', 'block');
            $('#msg').css('display', 'none');
            $.ajax({
                type: 'POST',
                url: "<?= site_url() ?>admin/admin_access/addClass",
                data: {userid: userid, edate: edate},
                success: function (data, textStatus, jqXHR) {
                    setTimeout(function () {
                        if (data == "1") {
                            $('#msg').html("Trial Period Extend Successfully..");
                            $('#load').css('display', 'none');
                            $('#msg').css('display', 'block');
                            $('#msg').css('color', 'green');
                            $('#discard').trigger('click');
                            location.reload(true);
                        }
                        else if (data == "0") {
                            $('#loadDept').html("Insertion Failed. Try again..!");
                            $('#load').css('display', 'none');
                            $('#msg').css('display', 'block');
                            $('#msg').css('color', 'red');
                        }
                    }, 1000);
                }
            });
        });
    });
</script>