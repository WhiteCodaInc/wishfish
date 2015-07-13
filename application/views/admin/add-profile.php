<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/password/strength.css"/>
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="display: none">
            Add New Profile
        </h1>
        <button type="button" id="addProfile" class="btn btn-primary">Create New Admin Profile</button>
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
                        <h3 class="box-title">Admin Profile</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form id="profileForm" role="form" action="<?= site_url() ?>admin/admin_profile/createProfile" method="post">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="userid" autofocus="autofocus" class="form-control" placeholder="Userid"/>
                            </div>
                            <div class="form-group" id="strengthForm">
                                <label for="password">Password</label>
                                <input id="myPassword" name="password" type="password" class="form-control" id="password" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-5">
                                        <label>Assign Admin Access Class</label>
                                        <select name="class_id" id="class" class="form-control" >
                                            <option value="-1">--Select--</option>
                                            <?php foreach ($class as $value) { ?>
                                                <option value="<?= $value->class_id ?>"><?= $value->class_name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                    </form>
                </div><!-- /.box -->
            </div><!--/.col (left) -->
            <div class="col-md-3"></div>
            <!-- right column -->
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->
</div><!-- ./wrapper -->
<script type="text/javascript" src="<?= base_url() ?>assets/password/strength.js"></script>
<script type="text/javascript">
    $(document).ready(function () {

        $('#myPassword').strength({
            strengthClass: 'strength',
            strengthMeterClass: 'strength_meter',
            strengthButtonClass: 'button_strength',
            strengthButtonText: 'Show Password',
            strengthButtonTextToggle: 'Hide Password'
        });

        $('#addProfile').click(function () {
            $('#profileForm').submit();
        });
    });
</script>