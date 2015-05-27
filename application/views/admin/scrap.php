<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dashboard/css/checkbox.css"/>
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="display: none">
            Import Contact
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary parse">
                    <div class="box-header">
                        <h3 class="box-title">Import Contact</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <form id="parseForm" method="post">
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Inmport From</label>
                                        <select name="type" id="type"  class="form-control" required="">
                                            <option value="facebook" selected="">Facebook</option>
                                            <option value="linkedin">LinkedIn</option>
                                            <option value="twitter">Twitter</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <label id="title">Username</label>
                                    <input name="url" id="url"  type="text" class="form-control" required=""/>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div style="text-align: right" class="col-md-8">
                                    <button class="btn btn-success" type="submit" id="parse">Get Contact</button>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                            <div style="display: none;background-color: mistyrose !important;border-color: mintcream;color: red !important;" class="alert alert-danger alert-dismissable">
                                <i class="fa fa-ban"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <b>Error!</b><span class="errorMsg"></span> 
                            </div>
                        </form>
                    </div>
                    <div class="overlay" style="display: none"></div>
                    <div class="loading-img" style="display: none"></div>
                </div>
                <div class="box box-solid box-primary contactInfo" style="display: none">
                    <div class="box-header">
                        <h3 class="box-title">Contact Information</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>First Name</label>
                                    </div>
                                    <div class="col-md-8 fname"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Last Name</label>
                                    </div>
                                    <div class="col-md-8 lname">

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <img class="picture" src="#" alt="profile picture" />
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                    <div class="overlay" style="display: none"></div>
                    <div class="loading-img" style="display: none"></div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->

<!-- InputMask -->
<script src="<?= base_url() ?>assets/dashboard/js/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/dashboard/js/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/dashboard/js/plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>


<!-- /.modal -->
<script type="text/javascript">
    $(document).ready(function () {
        $('#parseForm').submit(function () {
            $('.parse .overlay').show();
            $('.parse .loading-img').show();
            if ($('#type').val() == "facebook") {
                $.ajax({
                    type: 'POST',
                    data: {userid: $('#url').val()},
                    url: "<?= site_url() ?>admin/scrap/facebook",
                    success: function (data, textStatus, jqXHR) {
                        $('.parse .overlay').hide();
                        $('.parse .loading-img').hide();
                        if (data != "0") {
                            var json = JSON.parse(data);
                            $('.parse').hide();
                            $('.fname').text(json.first_name);
                            $('.lname').text(json.last_name);
                            $('.picture').prop('src', json.profile);
                            $('.contactInfo').show();

                        } else {
                            $('.parse .alert').show();
                            $('span.errorMsg').text("Please Enter Valid Username..!");
                        }
                    }
                });
            }
            return false;
        });
    });
</script>