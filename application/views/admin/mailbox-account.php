<aside class="right-side">
    <section class="content">
        <div class="form-box" id="login-box" style="border: 1px solid green;border-radius: 6px;">
            <div class="header">New Account</div>
            <form action="<?= site_url() ?>admin/mailbox/create" method="post">
                <div class="body bg-gray">
                    <div class="form-group">
                        <div class="input-group">
                            <input name="uname" type="text" class="form-control" placeholder="Username" required="">
                            <span class="input-group-addon">@mikhailkuznetsov.com</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="password" name="passwd" class="form-control" placeholder="Enter your new password" required=""/>
                    </div>          
                    <?php $msg = $this->session->flashdata('error'); ?>
                    <?php if (isset($msg) && $msg != ""): ?>
                        <div class="form-group">
                            <span style="color:red"><?= $msg ?></span>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="footer">                                               
                    <button type="submit" class="btn bg-olive btn-block">Create New Account</button>
                </div>
                <div class="form-group">
                    <p style="text-align: center">have you already Account ? <a href="<?= site_url() ?>admin/mailbox"> Sign in</a></p>
                </div>
            </form>
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->
</div><!-- ./wrapper -->