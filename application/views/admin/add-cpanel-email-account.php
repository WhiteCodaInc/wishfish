<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="display: none">
            <?= (isset($account)) ? "Edit" : "Add New" ?> Email Account
        </h1>
        <button type="button" id="addAccount" class="btn btn-primary">
            <?= (isset($account)) ? "Update Existing Email Account" : "Create New Email Account" ?>
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
                        <h3 class="box-title"><?= (isset($account)) ? "Existing" : "New" ?> Email Account</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php $method = (isset($account)) ? "updateAccount/{$account->account_id}" : "createAccount" ?>
                    <form id="accountForm" role="form" action="<?= site_url() ?>admin/cpanel/<?= $method ?>" method="post">
                        <div class="box-body">
                            <?php
                            if (isset($account)) {
                                $email = explode('@', $account->email);
                                $name = $email[0];
                            }
                            ?>
                            <div class="form-group">
                                <label >Username</label>
                                <div class="input-group">
                                    <input name="email" type="text" value="<?= (isset($name)) ? $name : '' ?>" class="form-control" placeholder="Username" <?= (isset($name)) ? 'disabled' : '' ?>>
                                    <span class="input-group-addon">@mikhailkuznetsov.com</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label >Password</label>
                                <input type="password" name="password" value="" class="form-control" placeholder="Enter New Password"  required="" />
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
<script type="text/javascript">
    $(document).ready(function () {
        $('#addAccount').click(function () {
            $('#accountForm').submit();
        });
    });
</script>