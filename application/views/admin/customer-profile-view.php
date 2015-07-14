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
        <?php
        $life = $customer->is_lifetime;
        $id = ($life == NULL || !$life) ? "assign" : "remove";
        $color = ($life == NULL || !$life) ? "bg-purple" : "btn-danger";
        ?>
        <a href="#" id="<?= $id ?>" class="create btn <?= $color ?> access">
            <?= ucfirst($id) ?> Lifetime Access
        </a>
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
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($phistory as $value) { ?>
                                        <tr>
                                            <td><?= date('m-d-Y', strtotime($value->payment_date)) ?></td>
                                            <td>$ <?= $value->mc_gross ?></td>
                                            <td><?= $value->transaction_id ?></td>
                                            <td><?= $value->gateway ?></td>
                                            <td><?= $value->plan_name ?></td>
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
                                        <div class="col-md-1" style="padding: 0 8px;font-size: 23px">/</div>
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
</aside>
</div>

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<!-- DATA TABES SCRIPT -->
<script src="<?= base_url() ?>assets/dashboard/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/dashboard/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

<script type="text/javascript">

    $(function () {
        Stripe.setPublishableKey('<?= $gatewayInfo->publish_key ?>');

        $("#payment-data-table").dataTable({
            aLengthMenu: [
                [25, 50, 100, 200, -1],
                [25, 50, 100, 200, "All"]
            ],
            aoColumnDefs: [{
                    bSortable: false,
                    aTargets: [0, 1, 2, 3, 4]
                }],
            iDisplayLength: -1,
//            aaSorting: [[0, 'asc']]
        });

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

        $('a.access').click(function () {
            var type = $(this).prop('id');
            $('#lifetimeForm input[name="type"]').val(type);
            $('#lifetimeForm').submit();
        });

        $('#cardForm').on('submit', function () {
            $('#save').prop('disabled', true);
            var error = false;
            var ccNum = $(this).find('.card_number').val(),
                    cvcNum = $(this).find('.cvc').val(),
                    expMonth = $(this).find('.month').val(),
                    expYear = $(this).find('.year').val();

            // Validate the number:
            if (!Stripe.card.validateCardNumber(ccNum)) {
                error = true;
                $('#msgCard').text('The credit card number appears to be invalid.');
                $('#msgCard').show();
                $('#save').prop('disabled', false);
                return false;
            }
            // Validate the CVC:
            if (!Stripe.card.validateCVC(cvcNum)) {
                error = true;
                $('#msgCard').text('The CVC number appears to be invalid.');
                $('#msgCard').show();
                $('#save').prop('disabled', false);
                return false;
            }
            // Validate the expiration:
            if (!Stripe.card.validateExpiry(expMonth, expYear)) {
                error = true;
                $('#msgCard').text('The expiration date appears to be invalid.');
                $('#msgCard').show();
                $('#save').prop('disabled', false);
                return false;
            }
            // Check for errors:
            if (!error) {
                // Get the Stripe token:
                $('#msgCard').hide();
                $('#error').hide();
                Stripe.card.createToken({
                    number: ccNum,
                    cvc: cvcNum,
                    exp_month: expMonth,
                    exp_year: expYear
                }, stripeResponseHandler);
                return false;
            } else {
                $('#error').show();
                $('#msgCard').show();
                return false;
            }
            return false;
        });

        function stripeResponseHandler(status, response) {
            // Check for an error:
            if (response.error) {
                reportError(response.error.message);
            } else { // No errors, submit the form:
                var f = $("#cardForm");

                // Token contains id, last4, and card type:
                var token = response['id'];

                // Insert the token into the form so it gets submitted to the server
                f.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
                // Submit the form:
                f.get(0).submit();
            }

        }

        /*
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
         */
    });
</script>