<style type="text/css">
    #product-data-table tr td,#product-data-table tr th{
        text-align: center;
    }
</style>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style=" display: none">
            Products
        </h1>
        <?php if ($p->probi): ?>
            <a href="<?= site_url() ?>admin/products/addProduct" class="create btn btn-success btn-sm">
                <i class="fa fa-plus"></i>
                Create New Product
            </a>
        <?php endif; ?>
        <?php if ($p->probd): ?>
            <button value="Delete" class="delete btn btn-danger btn-sm" id="Delete" type="button" >Delete</button>
        <?php endif; ?>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Products</h3>
                    </div><!-- /.box-header -->
                    <form name="checkForm" id="checkForm" action="" method="post">
                        <div class="box-body table-responsive" id="data-panel">
                            <table id="product-data-table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <?php if ($p->probd): ?>
                                            <th style="padding: 10px;">
                                                <input type="checkbox"/>
                                            </th>
                                        <?php endif; ?>
                                        <th>Product</th>
                                        <th>Product Content</th>
                                        <th>Product Setting</th>
                                        <?php if ($p->probu): ?>
                                            <th>Edit</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($product as $value) { ?>
                                        <tr>
                                            <?php if ($p->probd): ?>
                                                <td>
                                                    <div>
                                                        <label>
                                                            <input type="checkbox" name="products[]" value="<?= $value->product_id ?>"/>
                                                        </label>
                                                    </div>
                                                </td>
                                            <?php endif; ?>
                                            <td><?= $value->product_name ?></td>
                                            <td><?= $value->content ?></td>
                                            <td><?= $value->setting ?></td>
                                            <?php if ($p->probu): ?>
                                                <td>
                                                    <a href="<?= site_url() ?>admin/products/editProduct/<?= $value->product_id ?>" class="btn bg-navy btn-xs">
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
                                        <?php if ($p->probd): ?>
                                            <th></th>
                                        <?php endif; ?>
                                        <th>Product</th>
                                        <th>Product Content</th>
                                        <th>Product Setting</th>
                                        <?php if ($p->probu): ?>
                                            <th>Edit</th>
                                        <?php endif; ?>
                                    </tr>
                                </tfoot>
                            </table>
                            <?php if ($p->probd): ?>
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
        $m = "Product Successfully Created..!";
        $t = "success";
        break;
    case "U":
        $m = "Products Successfully Updated..!";
        $t = "success";
        break;
    case "D":
        $m = "Product(s) Successfully Deleted..!";
        $t = "error";
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
        $("#product-data-table").dataTable({
            bSort: false,
//            aoColumnDefs: [{
//                    bSortable: false,
//                    aTargets: [0, 1, 2, 3, 4]
//                }]
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
<?php if ($p->probd): ?>
            $('button.delete').click(function (e) {
                var product = "";
                var act = $(this).val();
                $('#product-data-table tbody tr').each(function () {
                    if ($(this).children('td:first').find('div.checked').length) {
                        $txt = $(this).children('td:nth-child(2)').text();
                        product += $txt.trim() + ",";
                    }
                });
                product = product.substring(0, product.length - 1);

                alertify.confirm("Are you sure want to delete product(s):<br/>" + product, function (e) {
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
                $('#checkForm').attr('action', "<?= site_url() ?>admin/products/action");
                $('#checkForm').submit();
            }
<?php endif; ?>
    });
</script>