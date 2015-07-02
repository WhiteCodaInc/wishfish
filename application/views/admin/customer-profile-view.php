<style type="text/css">
    .title{
        color: #3c8dbc;
    }
</style>
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style=" display: none">
            Customer Profile
        </h1>
        <a href="<?= site_url() ?>admin/customers/editCustomer/<?= $customer->user_id ?>" class="create btn bg-navy">
            <i class="fa fa-edit"></i>
            Edit
        </a>
        <a href="<?= site_url() ?>admin/customers/loginAsUser/<?= $customer->user_id ?>" class="create btn bg-maroon">
            <i class="fa fa-lock"></i>
            Log in As User
        </a>
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
                        $userInfo = $this->wi_common->getUserInfo($customer->user_id);
                        $currPlan = $this->wi_common->getCurrentPlan($customer->user_id);
                        if (count($currPlan) && $currPlan->plan_id == 1) {
                            $trialD = $this->common->getDateDiff($userInfo, $currPlan);
                            ?>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4"><label>Days Left on Trial</label></div>
                                    <div class="col-md-8">
                                        <span class="title" style="color:<?= (!$trialD) ? 'red' : '' ?>">
                                            <?= ($trialD) ? $trialD : "Expired" ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside><!-- /.right-side -->
</div><!-- ./wrapper -->
<script type="text/javascript">
<?php if ($this->session->flashdata('msg') != ""): ?>
        alertify.error("<?= $this->session->flashdata('msg') ?>");
<?php endif; ?>
</script>