<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="display: none">
            <?= isset($lists) ? "Edit" : "Add New" ?> Email List
        </h1>
        <button type="button" id="addList" class="btn btn-primary">
            <?= isset($lists) ? 'Update Existing List' : 'Create New List' ?>
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
                        <h3 class="box-title"><?= isset($lists) ? "Existing" : "New" ?> Email List</h3>
                    </div><!-- /.box-header -->
                    <?php $method = isset($lists) ? "updateEmailList" : "createEmailList"; ?>
                    <!-- form start -->
                    <form id="listForm" role="form" action="<?= site_url() ?>admin/email_list/<?= $method ?>" method="post">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="group name">List Name</label>
                                <input type="text" name="name" value="<?= isset($lists) ? $lists->name : '' ?>" autofocus="autofocus" class="form-control" placeholder="Enter List Name" />
                            </div>
                        </div><!-- /.box-body -->
                        <input type="submit" style="display: none" />
                        <?php if (isset($lists)): ?>
                            <input type="hidden" name="listid" value="<?= $lists->list_id ?>" />
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
        $('#addList').click(function () {
            ('#listForm input[type="submit"]').trigger('click');
        });
    });
</script>