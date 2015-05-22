<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="margin-left: 6%;float: left">
            <?= isset($groups) ? "Edit" : "Add New" ?> Contact Group
        </h1>
        <button type="button" id="submitGroup" class="btn btn-primary">
            <?= isset($groups) ? 'Update Existing Group' : 'Create New Group' ?>
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
                        <h3 class="box-title"><?= isset($groups) ? "Existing" : "New" ?> Contact Group</h3>
                    </div><!-- /.box-header -->
                    <?php $method = isset($groups) ? "updateContactGroup" : "createContactGroup"; ?>
                    <!-- form start -->
                    <form id="groupForm" role="form" action="<?= site_url() ?>app/contact_groups/<?= $method ?>" method="post">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="group name">Group Name</label>
                                <input value="<?= isset($groups) ? $groups->group_name : '' ?>" type="text" name="group_name" autofocus="autofocus" class="form-control" placeholder="Group Name" required=""/>
                            </div>
                        </div><!-- /.box-body -->
                        <?php if (isset($groups)): ?>
                            <input type="hidden" name="groupid" value="<?= $groups->group_id ?>" />
                        <?php else : ?>
                            <input type="hidden" name="type" value="simple" />
                        <?php endif; ?>
                        <input type="submit" style="display: none" class="submit"/>
                    </form>
                </div><!-- /.box -->
            </div><!--/.col (left) -->
            <div class="col-md-3"></div>
            <!-- right column -->
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->
<script type="text/javascript">
    $(document).ready(function (e) {

        $('#submitGroup').click(function () {
            $('.submit').trigger('click');
        });
    });
</script>
