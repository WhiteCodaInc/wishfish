<style type="text/css">
    #contact-data-table tr td,#contact-data-table tr th{
        text-align: center;
    }
</style>
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side" style="margin : <?= (isset($flag) && $flag) ? 0 : '' ?>">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="display: none">
            Google Contacts
        </h1>
        <a href="<?= $url ?>" class="btn btn-success btn-sm create">
            <i class="fa fa-plus"></i>
            Import
        </a>
        <button style="margin-left: 10px" value="Add" class="btn btn-danger btn-sm delete" id="Add" type="button" >Add Contacts</button>
    </section>
    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-xs-12">
                <div class="box" >
                    <div class="box-header">
                        <h3 class="box-title">Google Contact Detail</h3>
                    </div><!-- /.box-header -->
                    <div class="row">
                        <div class="col-xs-12" style="margin-left: 1%">

                        </div>
                    </div>
                    <form name="checkForm" id="checkForm" action="" method="post">
                        <div class="box-body table-responsive" id="data-panel">

                            <table id="contact-data-table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="padding: 10px;">
                                            <input type="checkbox"/>
                                        </th>
                                        <th>Contact Name</th>
                                        <th>Contact Email</th>
                                        <th>Contact Phone Number</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $contacts = (isset($gc)) ? $gc : array(); ?>
                                    <?php foreach ($contacts as $key => $value) { ?>
                                        <tr>
                                            <td>
                                                <div>
                                                    <label>
                                                        <input type="checkbox" name="contact[<?= $key ?>]" value="<?= $key ?>"/>
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <?= ($value['name'] != "") ? $value['name'] : 'N/A' ?>
                                                <input type="hidden" name="name[<?= $key ?>]" value="<?= $value['name'] ?>" />
                                            </td>
                                            <td>
                                                <?= ($value['email'] != "") ? $value['email'] : 'N/A' ?>
                                                <input type="hidden" name="email[<?= $key ?>]" value="<?= $value['email'] ?>" />
                                            </td>
                                            <td>
                                                <?= ($value['phone'] != "") ? $value['phone'] : 'N/A' ?>
                                                <input type="hidden" name="phone[<?= $key ?>]" value="<?= $value['phone'] ?>" />
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th>Contact Name</th>
                                        <th>Contact Email</th>
                                        <th>Contact Phone Number</th>
                                    </tr>
                                </tfoot>
                            </table>
                            <input type="hidden" id="actionType" name="actionType" value="" />
                        </div><!-- /.box-body -->
                    </form>
                </div><!-- /.box -->
            </div>
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->
</div><!-- ./wrapper -->


<!-- DATA TABES SCRIPT -->
<script src="<?= base_url() ?>assets/dashboard/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/dashboard/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

<!-- page script -->
<script type="text/javascript">
    $(function () {
//        $("#contact-data-table").dataTable();
        $("#contact-data-table").dataTable({
            aLengthMenu: [
                [25, 50, 100, 200, -1],
                [25, 50, 100, 200, "All"]
            ],
            aoColumnDefs: [{
                    bSortable: false,
                    aTargets: [0, 2, 3]
                }],
            iDisplayLength: -1,
            aaSorting: [[1, 'asc']]
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#Add').click(function (e) {
            var act = $(this).val();
            action(act);
        });

        function action(actiontype) {
            $('#actionType').val(actiontype);
            $('#checkForm').attr('action', "<?= site_url() ?>admin/import/addContacts");
            $('#checkForm').submit();
        }
    });

</script>