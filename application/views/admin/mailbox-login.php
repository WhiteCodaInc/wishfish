<aside class="right-side">
    <section class="content-header" style="display: none">
    </section>
    <section class="content">
        <div class="form-box" id="login-box" style="border: 1px solid green;border-radius: 6px;">
            <div class="header">Sign In</div>
            <form action="<?= site_url() ?>admin/mailbox/login" method="post">
                <div class="body bg-gray">
                    <div class="form-group">
                        <label>Select User</label>
                        <select name="account_id" class="form-control">
                            <?php foreach ($accounts as $value) { ?>
                                <option value="<?= $value->account_id ?>" selected=""><?= $value->email ?></option>
                            <?php } ?>
                        </select>
                    </div>  
                    <?php $msg = $this->session->flashdata('error'); ?>
                    <?php if (isset($msg) && $msg != ""): ?>
                        <div class="form-group">
                            <span style="color:red"><?= $msg ?></span>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <button type="submit" class="btn bg-olive btn-block">Sign me in</button>
                    </div>
                </div>

            </form>
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->
</div><!-- ./wrapper -->