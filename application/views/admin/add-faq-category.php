<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="display: none">
            <?= (isset($category)) ? "Edit" : "Add New" ?> FAQ Category
        </h1>
        <button type="button" id="save-fcat" class="btn btn-primary">
            <?= (isset($category)) ? "Update Existing FAQ Category" : "Create New FAQ Category" ?>
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
                        <h3 class="box-title"><?= (isset($category)) ? "Existing" : "New" ?> FAQ Category</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php $method = (isset($category)) ? "updateFaqCategory" : "createFaqCategory" ?>
                    <form id="fcatForm" role="form" action="<?= site_url() ?>admin/faq/<?= $method ?>" method="post">
                        <div class="box-body">
                            <div class="form-group">
                                <label >Category Name</label>
                                <input type="text" name="category_name" value="<?= (isset($category)) ? $category->category_name : '' ?>" autofocus="autofocus" class="form-control" placeholder="Category Name" />
                            </div>
                        </div><!-- /.box-body -->
                        <?php if (isset($category)): ?>
                            <input type="hidden" name="categoryid" value="<?= isset($category) ? $category->category_id : '' ?>" />
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
        $('#save-fcat').click(function () {
            $('#fcatForm').submit();
        });
    });
</script>