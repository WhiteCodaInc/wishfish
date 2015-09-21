<!-- Right side column. Contains the navbar and content of the page -->
<style type="text/css">
    #category-data-table tr td,#category-data-table tr th{
        text-align: center;
    }
</style>
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="display: none">FAQ Categories</h1>
        <?php if ($p->faqci): ?>
            <a style="float: left" href="<?= site_url() ?>admin/faq/addFaqCategory" class="btn btn-success btn-sm create">
                <i class="fa fa-plus"></i>
                Create New FAQ Category
            </a>
        <?php endif; ?>
        <?php if ($p->faqcd): ?>
            <button style="margin-left: 10px" value="Delete" class="btn btn-danger btn-sm delete" id="Delete" type="button" >Delete</button>
        <?php endif; ?>
        <?php if ($p->faqcu): ?>
            <button style="margin-left: 10px" value="Order" class="btn btn-primary btn-sm remove" id="Order" type="button" >Set Order</button>
        <?php endif; ?>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box" >
                    <div class="box-header">
                        <h3 class="box-title">FAQ Category Detail</h3>
                    </div><!-- /.box-header -->
                    <form name="checkForm" id="checkForm" action="" method="post">
                        <div class="box-body table-responsive" id="data-panel">

                            <table id="category-data-table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <?php if ($p->faqcu || $p->faqcd): ?>
                                            <th style="padding: 10px;">
                                                <input type="checkbox"/>
                                            </th>
                                        <?php endif; ?>
                                        <th class="hidden-xs hidden-sm">Category Id</th>
                                        <th class="hidden-xs hidden-sm">Category Order</th>
                                        <th>Category Name</th>
                                        <th>Total Question</th>
                                        <?php if ($p->faqcu): ?>
                                            <th>Edit</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($category as $value) { ?>
                                        <tr>
                                            <?php if ($p->faqcu || $p->faqcd): ?>
                                                <td>
                                                    <div>
                                                        <label>
                                                            <input type="checkbox" name="category[]" value="<?= $value->category_id ?>"/>
                                                        </label>
                                                    </div>
                                                </td>
                                            <?php endif; ?>
                                            <td class="hidden-xs hidden-sm"><?= $value->category_id ?></td>
                                            <td class="hidden-xs hidden-sm">
                                                <input value="<?= $value->order ?>" name="order[]" type="number" class="form-control" placeholder="Order" /> 
                                                <input type="hidden" name="catid[]" value="<?= $value->category_id ?>" />
                                            </td>
                                            <td><?= $value->category_name ?></td>
                                            <td><?= $value->totalQ ?></td>
                                            <?php if ($p->faqcu): ?>
                                                <td>
                                                    <a href="<?= site_url() ?>admin/faq/editFaqCategory/<?= $value->category_id ?>" class="btn bg-navy btn-xs">
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
                                        <?php if ($p->faqcu || $p->faqcd): ?>
                                            <th></th>
                                        <?php endif; ?>
                                        <th class="hidden-xs hidden-sm">Category Id</th>
                                        <th class="hidden-xs hidden-sm">Category Order</th>
                                        <th>Category Name</th>
                                        <th>Total Question</th>
                                        <?php if ($p->faqcu): ?>
                                            <th>Edit</th>
                                        <?php endif; ?>
                                    </tr>
                                </tfoot>
                            </table>
                            <?php if ($p->faqcu || $p->faqcd): ?>
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
        $m = "FAQ Category Successfully Created..!";
        $t = "success";
        break;
    case "U":
        $m = "FAQ Category Successfully Updated..!";
        $t = "success";
        break;
    case "D":
        $m = "FAQ Category(s) Successfully Deleted..!";
        $t = "error";
        break;
    case "OU":
        $m = "Category Order Successfully Set..!";
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
        $("#category-data-table").dataTable({bSort: false});
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
<?php if ($p->faqcu): ?>
            $('#Order').click(function (e) {
                var act = $(this).val();
                action(act);
            });
<?php endif; ?>
<?php if ($p->faqcd): ?>
            $('#Delete').click(function (e) {
                var bcat = "";
                var act = $(this).val();
                $('#category-data-table tbody tr').each(function () {
                    if ($(this).children('td:first').find('div.checked').length) {
                        $txt = $(this).children('td:nth-child(3)').text();
                        bcat += $txt.trim() + ",";
                    }
                });

                bcat = bcat.substring(0, bcat.length - 1);

                alertify.confirm("Are you sure want to delete FAQ Category(s):<br/>" + bcat, function (e) {
                    if (e) {
                        action(act);
                        return true;
                    }
                    else {
                        return false;
                    }
                });
            });
<?php endif; ?>
<?php if ($p->faqcu || $p->faqcd): ?>
            function action(actiontype) {
                $('#actionType').val(actiontype);
                $('#checkForm').attr('action', "<?= site_url() ?>admin/faq/delete");
                $('#checkForm').submit();
            }
<?php endif; ?>
    });

</script>