<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="display: none">
            <?= isset($product) ? 'Edit Existing Product' : 'Add New Product' ?>
        </h1>
        <button type="button" id="addProduct"  class="btn btn-warning">
            <?= isset($product) ? 'Update Product' : 'Add Product' ?>
        </button>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">
                            <?= isset($product) ? $product->plan_name : 'New Product' ?>
                        </h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php $method = isset($product) ? "updateProduct" : "createProduct"; ?>
                    <form id="productForm" role="form" action="<?= site_url() . "admin/products/$method" ?>" method="post">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="title">Product Name</label>
                                        <input value="<?= isset($product) ? $product->plan_name : '' ?>" type="text" autofocus="autofocus" name="plan_name" class="form-control" placeholder="Product Name" required="" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Total SMS Event</label><span style="color: red;margin-left: 5px">(-1 For Infinite)</span>
                                        <input value="<?= isset($product) ? $product->sms_events : '' ?>" type="text" name="sms_events" class="form-control" placeholder="No. of SMS Event" required="" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Total Email Event</label>
                                        <input value="<?= isset($product) ? $product->email_events : '' ?>" type="text" name="email_events" class="form-control" placeholder="No. of Email Event" required="" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Total Group Event</label>
                                        <input value="<?= isset($product) ? $product->group_events : '' ?>" type="text" name="group_events" class="form-control" placeholder="No. of Email Event" required="" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="title">Product Setting</label>
                                        <input value="<?= isset($product) ? $product->setting : '' ?>" type="text" name="setting" class="form-control" placeholder="Product Setting" required="" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <div class='row'>
                                            <div class='col-md-12'>
                                                <div class='box box-info'>
                                                    <div class='box-header'>
                                                        <h3 class='box-title'>Editor</h3>
                                                    </div><!-- /.box-header -->
                                                    <div class='box-body pad'>
                                                        <textarea id="editor1" name="content" rows="10" cols="80">
                                                            <?= isset($product) ? $product->content : '' ?>
                                                        </textarea>
                                                    </div>
                                                </div><!-- /.box -->
                                            </div>
                                        </div><!-- /.box-body -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if (isset($product)): ?>
                            <input type="hidden" name="planid" value="<?= $product->plan_id ?>" />
                        <?php endif; ?>
                    </form>
                </div><!-- /.box -->
            </div><!--/.col (left) -->
            <!-- right column -->
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<!-- CK Editor -->
<script src="//cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?= base_url() ?>assets/dashboard/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>

<script type="text/javascript">
    $(function () {
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace('editor1');
        //bootstrap WYSIHTML5 - text editor
        $(".textarea").wysihtml5();
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#addProduct').click(function () {
            $('#productForm').submit();
        });
    });
</script>