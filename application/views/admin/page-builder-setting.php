<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="display: none">
            Page Builder Setting
        </h1>
        <button type="button" id="updateSetting" class="btn btn-primary">
            Update
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
                        <h3 class="box-title">Edit Page Builder Setting</h3>
                    </div><!-- /.box-header -->

                    <!-- form start -->
                    <form id="groupForm" role="form" action="<?= site_url() ?>admin/setting/updatePageBuilderSetting" method="post">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" value="<?= $setting->username ?>" autofocus="autofocus" class="form-control" placeholder="Enter Username" required=""/>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="text" name="password" value="<?= $setting->password ?>" class="form-control" placeholder="Enter Password"  required=""/>
                            </div>
                            <div class="form-group" style="display: none">
                                <input type="submit" id="pageSubmit" style="display: none"/>
                            </div>
                        </div><!-- /.box-body -->
                        <?php if (isset($setting)): ?>
                            <input type="hidden" name="userid" value="<?= $setting->user_id ?>" />
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
        $('#updateSetting').click(function () {
            $('#pageSubmit').trigger('click');
        });
    });
</script>