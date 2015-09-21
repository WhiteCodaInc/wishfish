<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dashboard/css/checkbox.css"/>
<style type="text/css">
    .title{
        color: #3c8dbc;
    }
    #payment-data-table tr td,#payment-data-table tr th{
        text-align: center;
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
        <?php if ($p->cusu): ?>
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
                    Extend Trial
                </a>
            <?php endif; ?>
            <?php if (!$customer->is_set || ($customer->is_set && $customer->gateway == "STRIPE")): ?>
                <a href="#" id="card" class="create btn btn-info" data-toggle="modal" data-target="#card-modal">
                    Change Payment Detail
                </a>
            <?php endif; ?>
            <?php if ($customer->plan_id == 1): ?>
                <?php
                $life = $customer->is_lifetime;
                $id = ($life == NULL || !$life) ? "assign" : "remove";
                $color = ($life == NULL || !$life) ? "bg-purple" : "btn-danger";
                ?>
                <a href="#" id="<?= $id ?>" class="create btn <?= $color ?> access">
                    <?= ucfirst($id) ?> Lifetime Access
                </a>
            <?php endif; ?>
            <a href="#" class="create btn bg-green" data-toggle="modal" data-target="#charge-modal">
                Manually Charge User
            </a>
            <?php
            $test = $customer->testmode;
            $lbl = ($test) ? "disable" : "enable";
            $clr = ($test) ? "btn-danger" : "bg-maroon";
            ?>
            <a href="<?= site_url() ?>admin/customers/<?= $lbl ?>Testmode/<?= $customer->user_id ?>" class="create btn <?= $clr ?>">
                <?= ucfirst($lbl) ?> Test mode
            </a>
        <?php endif; ?>
    </section>
    <?php
    $img_src = ($customer->profile_pic != "") ?
            "http://mikhailkuznetsov.s3.amazonaws.com/" . $customer->profile_pic :
            base_url() . 'assets/dashboard/img/default-avatar.png';
    $error = $this->session->flashdata('error');
    ?>
    <!-- Main content -->
    <section class="content">
        <form id="lifetimeForm" action="<?= site_url() ?>admin/customers/lifetimeAccess" method="post">
            <input type="hidden" name="type" value="" />
            <input type="hidden" name="planid" value="<?= $customer->id ?>" />
            <input type="hidden" name="userid" value="<?= $customer->user_id ?>" />
        </form>
        <?php if ($error): ?>
            <div  class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div style="background-color: mistyrose !important;border-color: mintcream;color: red !important;" class="alert alert-danger alert-dismissable">
                        <i class="fa fa-ban"></i>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <b>Error!</b> <?= $error ?> 
                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>
        <?php endif; ?>
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
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4"><label>Plan</label></div>
                                <div class="col-md-8">
                                    <span class="title"><?= ($customer->is_lifetime) ? "Free Lifetime Access" : $customer->plan_name ?></span>
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
                                        <span class="title" style="<?= ($customer->is_lifetime) ? "" : ((!$trialD) ? "color:red" : "") ?>">
                                            <?= ($customer->is_lifetime) ? "Lifetime" : (($trialD) ? $trialD : "Expired") ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- START CUSTOM TABS -->
        <div class="row">
            <div class="col-md-12">
                <!-- Custom Tabs -->
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_1" data-toggle="tab">SMS</a></li>
                        <li><a href="#tab_2" data-toggle="tab">Email</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <form id="smsForm" role="form" action="<?= site_url() ?>admin/customers/send_message" method="post" >
                                <div class="row">
                                    <?php $adminInfo = $this->common->getAdminInfo(); ?>
                                    <div class="col-md-3">
                                        <div class="pull-left" style="padding: 10px"><label>From</label></div>
                                        <div class="pull-left" style="padding: 10px"><span class="title"><?= ($adminInfo->twilio_number) ? $adminInfo->twilio_number : "N/A" ?></span></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="pull-left" style="padding: 10px"><label>To</label></div>
                                        <div class="pull-left" style="padding: 10px">
                                            <span class="title">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <?= $customer->phone ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Choose SMS Template</label>
                                            <select name="sms_template_id" class="form-control" required="">
                                                <option value="-1">--Select--</option>
                                                <?php foreach ($sms_template as $value) { ?>
                                                    <option value="<?= $value->template_id ?>"><?= $value->title ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <div class='row'>
                                                <div class='col-md-12'>
                                                    <div class='box box-info'>
                                                        <div class='box-header'>
                                                            <h3 class='box-title'>Editor</h3>
                                                        </div><!-- /.box-header -->
                                                        <div class='box-body pad'>
                                                            <textarea id="smsbody"  name="body" rows="10" cols="80" required=""></textarea>
                                                        </div>
                                                    </div><!-- /.box -->
                                                </div>
                                            </div><!-- /.box-body -->
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <!-- Default box -->
                                        <div class="box collapsed-box">
                                            <div class="box-header">
                                                <h3 class="box-title">Token List</h3>
                                                <div class="box-tools pull-right">
                                                    <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="box-body" style="display: none">
                                                <strong>{FIRST_NAME}</strong><br/>
                                                <strong>{LAST_NAME}</strong><br/>
                                                <strong>{EMAIL}</strong><br/>
                                                <strong>{PHONE}</strong><br/>
                                                <strong>{BIRTHDAY}</strong><br/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-1">
                                        <button type="submit" class="btn btn-primary">SEND</button>
                                    </div>
                                </div>
                                <input type="hidden" name="uid" value="<?= $customer->user_id ?>" />
                            </form>
                        </div><!-- /.tab-pane -->
                        <div class="tab-pane" id="tab_2">
                            <form id="emailForm" role="form" action="<?= site_url() ?>admin/customers/send_email" method="post" >
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="pull-left" style="padding: 10px"><label>From</label></div>
                                        <div class="pull-left" style="padding: 10px"><span class="title">mikhail@wish-fish.com</span></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="pull-left" style="padding: 10px"><label>To</label></div>
                                        <div class="pull-left" style="padding: 10px">
                                            <span class="title">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <?= $customer->email ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Choose Email Template</label>
                                            <select name="email_template_id" class="form-control" required="">
                                                <option value="-1">--Select--</option>
                                                <?php foreach ($email_template as $value) { ?>
                                                    <option value="<?= $value->template_id ?>"><?= $value->name ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <label for="title">Email Subject</label>
                                            <input  type="text" name="subject" class="form-control" placeholder="Email Subject" required="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <div class='row'>
                                                <div class='col-md-12'>
                                                    <div class='box box-info'>
                                                        <div class='box-header'>
                                                            <h3 class='box-title'>Editor</h3>
                                                        </div><!-- /.box-header -->
                                                        <div class='box-body pad'>
                                                            <textarea id="emailbody"  name="body" rows="10" cols="80" required=""></textarea>
                                                        </div>
                                                    </div><!-- /.box -->
                                                </div>
                                            </div><!-- /.box-body -->
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <!-- Default box -->
                                        <div class="box collapsed-box">
                                            <div class="box-header">
                                                <h3 class="box-title">Token List</h3>
                                                <div class="box-tools pull-right">
                                                    <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="box-body" style="display: none">
                                                <strong>{FIRST_NAME}</strong><br/>
                                                <strong>{LAST_NAME}</strong><br/>
                                                <strong>{EMAIL}</strong><br/>
                                                <strong>{PHONE}</strong><br/>
                                                <strong>{BIRTHDAY}</strong><br/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <button type="submit" class="btn btn-primary">SEND</button>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="uid" value="<?= $customer->user_id ?>" />
                            </form>
                        </div><!-- /.tab-pane -->
                    </div><!-- /.tab-content -->
                </div><!-- nav-tabs-custom -->
            </div><!-- /.col -->
        </div> <!-- /.row -->
        <!-- END CUSTOM TABS -->

        <div class="row">
            <div class="col-xs-12">
                <div class="box" >
                    <div class="box-header">
                        <h3 class="box-title">Payment History</h3>
                    </div> 
                    <form name="checkForm" id="checkForm" action="" method="post">
                        <div class="box-body table-responsive">
                            <table id="payment-data-table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Date & Time</th>
                                        <th>Amount</th>
                                        <th>Installment Number</th>
                                        <th>Payment Method</th>
                                        <th>Plan</th>
                                        <th>Status</th>
                                        <?php if ($p->cusu): ?>
                                            <th>Refund</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($phistory as $value) { ?>
                                        <tr>
                                            <td><?= date('m-d-Y H:i:s', strtotime($value->payment_date)) ?></td>
                                            <td>$ <?= $value->mc_gross ?></td>
                                            <td><?= ($value->invoice_id) ? $value->invoice_id : "N/A" ?></td>
                                            <td><?= $value->gateway ?></td>
                                            <td><?= $value->plan_name ?></td>
                                            <td>
                                                <?php if ($value->status): ?>
                                                    <span class="btn btn-success btn-xs">Approved</span>
                                                <?php else : ?>
                                                    <span class="btn btn-warning btn-xs">Refunded</span>
                                                <?php endif; ?>
                                            </td>
                                            <?php if ($p->cusu): ?>
                                                <td>
                                                    <?php $method = ($value->gateway == "STRIPE") ? "refundStripe" : "refundPaypal"; ?>
                                                    <?php if ($value->status && $value->mc_gross > 0 && $value->invoice_id): ?>
                                                        <a class="btn btn-primary btn-xs refund" href="<?= site_url() ?>admin/customers/<?= $method ?>/<?= $customer->user_id ?>/<?= $value->invoice_id ?>">
                                                            Refund
                                                        </a>
                                                    <?php endif; ?>
                                                </td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Date & Time</th>
                                        <th>Amount</th>
                                        <th>Installment Number</th>
                                        <th>Payment Method</th>
                                        <th>Plan</th>
                                        <th>Status</th>
                                        <?php if ($p->cusu): ?>
                                            <th>Refund</th>
                                        <?php endif; ?>
                                    </tr>
                                </tfoot>
                            </table>
                        </div> 
                    </form>
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
                <form action="<?= site_url() ?>admin/customers/extendTrial" method="post">
                    <div class="modal-body">                    
                        <div class="row">
                            <div class="col-md-4"><label>Expiry Date</label></div>
                            <div class="col-md-8">
                                <label><?= $currPlan->expiry_date ?></label>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-md-4">
                                <label>Extend Trial Date</label>
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
                            <div class="col-md-5">
                                <button type="submit" class="btn btn-primary pull-left">Extend Trial Period</button>
                            </div>
                            <div class="col-md-3">
                                <button type="button" id="discard" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Discard</button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="userid" value="<?= $customer->user_id ?>" />
                    <input type="hidden" name="planid" value="<?= $customer->id ?>" />
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

    <!-------------------------------Card Detail Model------------------------------------>
    <div class="modal fade" id="card-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 400px">
            <div class="modal-content">
                <form id="cardForm" role="form" action="<?= site_url() ?>admin/customers/updatePaymentDetail"  method="post">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Card Detail</h4>
                    </div>
                    <div class="modal-body">
                        <?php ($card) ? $cardNo = "************{$card['last4']}" : ""; ?>
                        <div class="form-group">
                            <label>Credit Card Number </label>
                            <input data-stripe="number" value="<?= ($card) ? $cardNo : "" ?>"  type="text" maxlength="16" class="card_number form-control" placeholder="Card Number" required=""/>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Expiration (MM/YYYY)</label>
                                    <div class="row">
                                        <div class="col-md-5" style="padding-right: 0">
                                            <input value="<?= ($card) ? $card['exp_month'] : "" ?>"  data-stripe="exp-month" maxlength="2" type="text" class="month form-control" placeholder="MM" required=""/>
                                        </div>
                                        <div class="col-md-1" style="padding: 0 5px;font-size: 23px">/</div>
                                        <div class="col-md-5" style="padding-left: 0">
                                            <input value="<?= ($card) ? $card['exp_year'] : "" ?>" data-stripe="exp-year" type="text" maxlength="4" class="year form-control" placeholder="YYYY" required="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>CVC</label>
                                    <input maxlength="3" type="password" class="cvc form-control" required=""/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <span style="color: red;display: none" id="msgCard"></span>
                        </div>
                    </div>
                    <div class="modal-footer clearfix">
                        <div class="row">
                            <div class="col-md-3">
                                <button type="submit" id="save" class="btn btn-primary pull-left">Save</button>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-danger discard" data-dismiss="modal">
                                    <i class="fa fa-times"></i> Discard
                                </button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="userid" value="<?= $customer->user_id ?>" />
                    <?php if (!$card): ?>
                        <input type="hidden" name="isNew" value="1" />
                    <?php endif; ?>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!------------------------------------------------------------------------>

    <!-------------------------------Charge  Model------------------------------------>
    <div class="modal fade" id="charge-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 400px">
            <div class="modal-content">
                <form id="chargeForm" role="form" action="<?= site_url() ?>admin/customers/chargeUser"  method="post">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Manually Charge User</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Credit Card Number </label>
                            <input data-stripe="number" value=""  type="text" maxlength="16" class="card_number form-control" placeholder="Card Number" required=""/>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Expiration (MM/YYYY)</label>
                                    <div class="row">
                                        <div class="col-md-5" style="padding-right: 0">
                                            <input value=""  data-stripe="exp-month" maxlength="2" type="text" class="month form-control" placeholder="MM" required=""/>
                                        </div>
                                        <div class="col-md-1" style="padding: 0 5px;font-size: 23px">/</div>
                                        <div class="col-md-5" style="padding-left: 0">
                                            <input value="" data-stripe="exp-year" type="text" maxlength="4" class="year form-control" placeholder="YYYY" required="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>CVC</label>
                                    <input maxlength="3" type="password" class="cvc form-control" required=""/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <p><?= $customer->name ?>'s Active Plan is <strong><?= $customer->plan_name ?></strong></p>
                        </div>
                        <div class="form-group">
                            <div  style="float: left;padding:0 5px;cursor: pointer">
                                <input type="radio" value="onetime"  name="type" checked="" class="simple">                          
                                <span class="lbl padding-8">One-time&nbsp;</span>
                            </div>
                            <div  style="cursor: pointer">
                                <input type="radio" value="forever"  name="type"  class="simple">                          
                                <span class="lbl padding-8">Recurring&nbsp;</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Choose Plan</label>
                            <select name="plan" class="form-control m-bot15">
                                <?php
                                foreach ($plans as $value) {
                                    if ($value->plan_id == 1)
                                        continue;
                                    ?>
                                    <option value="<?= $value->plan_id ?>">
                                        <?= $value->plan_name ?>  ($<?= $value->amount ?> / Month)
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Interval</label>
                            <select name="interval" class="form-control m-bot15">
                                <option value="1" selected="">1 Months</option>
                                <option value="2">2 Months</option>
                                <option value="3">3 Months</option>
                                <option value="6">6 Months</option>
                                <option value="9">9 Months</option>
                                <option value="12">12 Months</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Amount</label>
                            <div class="row">
                                <div class="col-md-8">
                                    <input type="text" value="9.99" name="amount" class="form-control" required=""/>
                                </div>
                                <div class="col-md-4" style="padding-top: 7px;padding-left: inherit;">
                                    For <span id="month">1</span> Month
                                </div>
                            </div>
                        </div>
                        <style type="text/css">
                            .line_onetime,
                            .line_recur{
                                float: left;
                                padding-right: 10px;
                            }
                        </style>
                        <div class="form-group">
                            <p class="line_onetime">Account will disable on : </p>
                            <p class="line_recur" style="display: none">Next Recurring Date : </p>
                            <strong>
                                <span id="recur_date">
                                    <?= date('m-d-Y', strtotime($this->wi_common->getNextDate(date('Y-m-d'), "1 months"))); ?>
                                </span>
                            </strong>
                            </p>
                        </div>
                        <div class="form-group">
                            <span style="color: red;display: none" id="msgCard"></span>
                        </div>
                    </div>
                    <div class="modal-footer clearfix">
                        <div class="row">
                            <div class="col-md-3">
                                <button type="submit" id="charge" class="btn btn-primary pull-left">Pay Now</button>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-danger discard" data-dismiss="modal">
                                    <i class="fa fa-times"></i> Discard
                                </button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="userid" value="<?= $customer->user_id ?>" />
<!--                    <input type="hidden" name="amount" value="9.99" />-->
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!------------------------------------------------------------------------>
</aside>
</div>

<script src="//cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?= base_url() ?>assets/dashboard/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<!-- DATA TABES SCRIPT -->
<script src="<?= base_url() ?>assets/dashboard/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/dashboard/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

<?php $msg = $this->input->get('msg'); ?>
<?php
switch ($msg) {
    case "C":
        $m = "Manually charge to this user successfully ..!";
        $t = "success";
        break;
    case "MS":
        $m = "Message Successfully Delivered..!";
        $t = "success";
        break;
    case "MF":
        $m = "Message has not been delivered..!";
        $t = "error";
        break;
    case "ES":
        $m = "Email Successfully Delivered..!";
        $t = "success";
        break;
    case "EF":
        $m = "Email has not been delivered..!";
        $t = "error";
        break;
    default:
        $m = 0;
        break;
}
?>
<script type="text/javascript">
<?php if ($msg): ?>
        alertify.<?= $t ?>("<?= $m ?>");
<?php endif; ?>
</script>


<script type="text/javascript">

    $(function () {

        CKEDITOR.replace('emailbody');
        $(".textarea").wysihtml5();

        Stripe.setPublishableKey('<?= $gatewayInfo->publish_key ?>');

        $("#payment-data-table").dataTable({
            order: [],
            aLengthMenu: [
                [25, 50, 100, 200, -1],
                [25, 50, 100, 200, "All"]
            ],
//            aoColumnDefs: [{
//                    targets: 'no-sort',
//                    bSortable: false,
//                    aTargets: [0, 1, 2, 3, 4, 5, 6]
//                }],
            iDisplayLength: -1
        });

        $('.default-date-picker').datepicker({
            format: "mm-dd-yyyy",
            todayBtn: "linked",
            autoclose: true,
            todayHighlight: true
        });
    });
</script>
<script type="text/javascript" >
    $(document).ready(function () {

        $('select[name="sms_template_id"]').change(function () {
            var tempid = $(this).val();
            if (tempid == "-1") {
                return false;
            } else {
                $.ajax({
                    type: 'POST',
                    url: "<?= site_url() ?>admin/sms/getTemplate/" + tempid,
                    success: function (json, textStatus, jqXHR) {
                        var data = JSON.parse(json);
                        $('#smsbody').val(data.body);
                    }
                });
            }
        });
        $('select[name="email_template_id"]').change(function () {
            var tempid = $(this).val();
            if (tempid == "-1") {
                return false;
            } else {
                $.ajax({
                    type: 'POST',
                    url: "<?= site_url() ?>admin/email/getTemplate/" + tempid,
                    success: function (json, textStatus, jqXHR) {
                        var data = JSON.parse(json);
//                        $('#body').val(data.body);
                        $('input[name="subject"]').val(data.subject);
                        CKEDITOR.instances['emailbody'].setData(data.body);
                    }
                });
            }
        });

        $('span.lbl').click(function () {
            $name = $(this).prev().prop('name');
            $('input[name="' + $name + '"]').prop('checked', false);
            $(this).prev().trigger('click');
        });

        var formType = "";

        $('a.access').click(function () {
            var type = $(this).prop('id');
            $('#lifetimeForm input[name="type"]').val(type);
            $('#lifetimeForm').submit();
        });

        $('#cardForm,#chargeForm').on('submit', function () {
            formType = $(this).prop('id');
            (formType == "cardForm") ?
                    $('#save').prop('disabled', true) :
                    $('#charge').prop('disabled', true);
            var error = false;
            var ccNum = $(this).find('.card_number').val(),
                    cvcNum = $(this).find('.cvc').val(),
                    expMonth = $(this).find('.month').val(),
                    expYear = $(this).find('.year').val();

            // Validate the number:
            if (!Stripe.card.validateCardNumber(ccNum)) {
                error = true;
                $('#' + formType + ' #msgCard').text('The credit card number appears to be invalid.');
                $('#' + formType + ' #msgCard').show();
                (formType == "cardForm") ?
                        $('#save').prop('disabled', false) :
                        $('#charge').prop('disabled', false);
                return false;
            }
            // Validate the CVC:
            if (!Stripe.card.validateCVC(cvcNum)) {
                error = true;
                $('#' + formType + ' #msgCard').text('The CVC number appears to be invalid.');
                $('#' + formType + ' #msgCard').show();
                (formType == "cardForm") ?
                        $('#save').prop('disabled', false) :
                        $('#charge').prop('disabled', false);
                return false;
            }
            // Validate the expiration:
            if (!Stripe.card.validateExpiry(expMonth, expYear)) {
                error = true;
                $('#' + formType + ' #msgCard').text('The expiration date appears to be invalid.');
                $('#' + formType + ' #msgCard').show();
                (formType == "cardForm") ?
                        $('#save').prop('disabled', false) :
                        $('#charge').prop('disabled', false);
                return false;
            }
            // Check for errors:
            if (!error) {
                // Get the Stripe token:
                $('#' + formType + ' #msgCard').hide();
                $('#' + formType + ' #error').hide();
                Stripe.card.createToken({
                    number: ccNum,
                    cvc: cvcNum,
                    exp_month: expMonth,
                    exp_year: expYear
                }, stripeResponseHandler);
                return false;
            } else {
                $('#' + formType + ' #error').show();
                $('#' + formType + ' #msgCard').show();
                return false;
            }
            return false;
        });

        function stripeResponseHandler(status, response) {
            // Check for an error:
            if (response.error) {
                reportError(response.error.message);
            } else { // No errors, submit the form:
                var f = $('#' + formType);

                // Token contains id, last4, and card type:
                var token = response['id'];

                // Insert the token into the form so it gets submitted to the server
                f.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
                // Submit the form:
                f.get(0).submit();
//                $('#charge').prop('disabled', false);
//                return false;
            }

        }

        $('input[name="type"]').change(function () {
            var type = $(this).val();
            if (type == "onetime") {
                $('p.line_onetime').show();
                $('p.line_recur').hide();
            } else {
                $('p.line_onetime').hide();
                $('p.line_recur').show();
            }
        });

        $('select[name="plan"]').change(function () {
            var planid = $(this).val();
            var interval = $('select[name="interval"]').val();
            $amt = (planid == '2') ?
                    parseFloat('9.99') * parseInt(interval) :
                    parseFloat('49.99') * parseInt(interval);
            $('input[name="amount"]').val($amt);
        });

        $('select[name="interval"]').change(function () {
            var interval = $(this).val();
            var planid = $('select[name="plan"]').val();
            $('#month').text(interval);
            $amt = (planid == '2') ?
                    parseFloat('9.99') * parseInt(interval) :
                    parseFloat('49.99') * parseInt(interval);
            $('input[name="amount"]').val($amt);
            $.ajax({
                type: 'POST',
                url: "<?= site_url() ?>admin/customers/getRecurDate",
                data: {interval: interval},
                success: function (data, textStatus, jqXHR) {
                    $('#recur_date').text(data);
                }
            });
        });

        $('a.refund').click(function (e) {
            var href = $(this).prop('href');
            alertify.confirm("Are you sure want to Refund to <?= $customer->name ?>", function (e) {
                if (e) {
                    window.location.href = href;
                    return true;
                }
                else {
                    return false;
                }
            });
            return false;
        });
    });
</script>