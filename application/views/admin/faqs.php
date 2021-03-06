<!-- Right side column. Contains the navbar and content of the page -->
<style type="text/css">
    #blog-data-table tr td,#blog-data-table tr th{
        text-align: center;
    }
</style>
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="display: none">FAQs</h1>
        <?php if ($p->faqi): ?>
            <a style="float: left" href="<?= site_url() ?>admin/faq/addFaq" class="btn btn-success btn-sm create">
                <i class="fa fa-plus"></i>
                Create New FAQ Question
            </a>
        <?php endif; ?>
        <?php if ($p->faqd): ?>
            <button value="Delete" class="btn btn-danger btn-sm delete" id="Delete" type="button" >Delete</button>
        <?php endif; ?>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-xs-12">
                <div class="box" >
                    <div class="box-header">
                        <h3 class="box-title">FAQ Detail</h3>
                    </div><!-- /.box-header -->
                    <form name="checkForm" id="checkForm" action="" method="post">
                        <div class="box-body table-responsive" id="data-panel">

                            <table id="blog-data-table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <?php if ($p->faqd): ?>
                                            <th style="padding: 10px;">
                                                <input type="checkbox"/>
                                            </th>
                                        <?php endif; ?>
                                        <th class="hidden-xs hidden-sm">No.</th>
                                        <th class="hidden-xs hidden-sm">FAQ Category</th>
                                        <th>FAQ Question</th>
                                        <?php if ($p->faqu): ?>
                                            <th>Edit</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($faqs as $value) { ?>
                                        <tr>
                                            <?php if ($p->faqd): ?>
                                                <td>
                                                    <div>
                                                        <label>
                                                            <input type="checkbox" name="faq[]" value="<?= $value->faq_id ?>"/>
                                                        </label>
                                                    </div>
                                                </td>
                                            <?php endif; ?>
                                            <td class="hidden-xs hidden-sm"><?= $value->faq_id ?></td>
                                            <td class="hidden-xs hidden-sm"><?= $value->category_name ?></td>
                                            <td><?= $value->question ?></td>
                                            <?php if ($p->faqu): ?>
                                                <td>
                                                    <a href="<?= site_url() ?>admin/faq/editFaq/<?= $value->faq_id ?>" class="btn bg-navy btn-xs">
                                                        <i class="fa fa-edit"></i>
                                                        Edit
                                                    </a>
                                                </td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <?php if ($p->faqd): ?>
                                            <th></th>
                                        <?php endif; ?>
                                        <th class="hidden-xs hidden-sm">No.</th>

                                        <th class="hidden-xs hidden-sm">FAQ Category</th>
                                        <th>FAQ Question</th>
                                        <?php if ($p->faqu): ?>
                                            <th>Edit</th>
                                        <?php endif; ?>
                                    </tr>
                                </tfoot>
                            </table>
                            <?php if ($p->faqd): ?>
                                <input type="hidden" id="actionType" name="actionType" value="" />
                            <?php endif; ?>
                        </div><!-- /.box-body -->
                    </form>
                </div><!-- /.box -->
            </div>
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<?php $msg = $this->input->get('msg'); ?>
<?php
switch ($msg) {
    case "I":
        $m = "FAQ Successfully Created..!";
        $t = "success";
        break;
    case "U":
        $m = "FAQ Successfully Updated..!";
        $t = "success";
        break;
    case "D":
        $m = "FAQ(s) Successfully Deleted..!";
        $t = "error";
        break;
    case "SD":
        $m = "FAQ Post set as Default Successfully ..!";
        $t = "success";
        break;
    case "DR":
        $m = "FAQ Post set as Draft Successfully ..!";
        $t = "success";
        break;
    case "P":
        $m = "FAQ Post set as Publish Successfully ..!";
        $t = "success";
        break;
    default:
        $m = 0;
        break;
}
?>
<script type="text/javascript">
<?php if ($msg): ?>
        alertify.<?= $t ?>("<?= $m ?>");
<?php endif; ?>
</script>

<!-- DATA TABES SCRIPT -->
<script src="<?= base_url() ?>assets/dashboard/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/dashboard/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<!-- page script -->
<script type="text/javascript">
    $(function () {
        $("#blog-data-table").dataTable({bSort: false});
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
<?php if ($p->faqd): ?>
            $('#Delete').click(function (e) {
                var act = $(this).val();
                alertify.confirm("Are you sure you wish to delete blog(s)", function (e) {
                    if (e) {
                        action(act);
                        return true;
                    }
                    else {
                        return false;
                    }
                });
            });
            function action(actiontype) {
                $('#actionType').val(actiontype);
                $('#checkForm').attr('action', "<?= site_url() ?>admin/faq/action");
                $('#checkForm').submit();
            }
<?php endif; ?>
    });
</script>