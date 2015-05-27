<style type="text/css">
    #comment-data-table tr td,#comment-data-table tr th{
        text-align: center;
    }
</style>
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style=" display: none">
            Blog Comments
        </h1>
        <button value="Approve" class="delete btn btn-success btn-sm" id="Approve" type="button" >Approve</button>
        <button value="Disapprove" class="delete btn btn-warning btn-sm" id="Disapprove" type="button" >Disapprove</button>
        <button value="Delete" class="delete btn btn-danger btn-sm" id="Delete" type="button" >Delete</button>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Primary box -->
                <div class="box box-solid box-primary collapsed-box">
                    <div class="box-header" data-widget="collapse"  style="cursor: pointer">
                        <h3 class="box-title">Filterable Search</h3>
                    </div>
                    <div class="box-body" style="display: none">
                        <form action="<?= site_url() ?>admin/comment/search" method="post">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Date</label>
                                    <div class="input-group input-large input-daterange" >
                                        <input type="text" na class="form-control" name="from_search">
                                        <span class="input-group-addon">To</span>
                                        <input type="text" class="form-control" name="to_search">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label>Name</label>
                                    <input name="name_search" class="form-control" placeholder="Full Name" type="text">
                                </div>
                                <div class="col-md-4">
                                    <label>Email</label>
                                    <input name="email_search" class="form-control" placeholder="Email" type="text">
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Blog Title</label>
                                    <select name="blog_search" class="form-control m-bot15">
                                        <option value="-1">--Select--</option>
                                        <?php foreach ($blogs as $value) { ?>
                                            <option value="<?= $value->blog_id ?>">
                                                <?= $value->title ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>Comment Status</label>
                                    <select name="status_search" class="form-control m-bot15">
                                        <option value="-1">--Select--</option>
                                        <option value="1">Approve</option>
                                        <option value="0">Disapprove</option>
                                    </select>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="submit" name="search" id="search" value="Search" class="btn btn-success" />
                                    <input type="reset" value="Reset"  class="btn btn-danger"/>
                                </div>
                            </div>
                        </form>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box" >
                    <div class="box-header">
                        <h3 class="box-title">Comment Detail</h3>
                    </div><!-- /.box-header -->
                    <form name="checkForm" id="checkForm" action="" method="post">
                        <div class="box-body table-responsive" id="data-panel">

                            <table id="comment-data-table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="padding: 10px;">
                                            <input type="checkbox"/>
                                        </th>
                                        <th>Date</th>                             
                                        <th class="hidden-xs hidden-sm">Name</th>
                                        <th >Comment</th>
                                        <th >status</th>
                                        <th class="hidden-xs hidden-sm">Post Url</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($comments)) {
                                        $result = $comments;
                                    } elseif (isset($searchResult)) {
                                        $result = $searchResult;
                                    }
                                    ?>
                                    <?php foreach ($result as $value) { ?>
                                        <tr>
                                            <td>
                                                <div>
                                                    <label>
                                                        <input type="checkbox" name="comment[]" value="<?= $value->comment_id ?>"/>
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="hidden-xs hidden-sm"><?= date('d-m-Y', strtotime($value->dt)) ?></td>
                                            <td class="hidden-xs hidden-sm"><?= $value->name ?></td>
                                            <td><?= $value->comment ?></td>
                                            <td>
                                                <?php if ($value->status == 0) { ?>
                                                    <span class="btn btn-danger btn-xs">Disapproved</span>
                                                <?php } else if ($value->status == 1) { ?>
                                                    <span class="btn btn-success btn-xs">Approved</span>
                                                <?php } ?>
                                            </td>
                                            <td class="hidden-xs hidden-sm" >
                                                <a href="http://localhost/front-end/blogs/single_post/<?= $value->blog_id ?>" class="name">
                                                    View Blog Post
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th>Date</th>                             
                                        <th class="hidden-xs hidden-sm">Name</th>
                                        <th >Comment</th>
                                        <th >status</th>
                                        <th class="hidden-xs hidden-sm">Post Url</th>
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
<?php $msg = $this->input->get('msg'); ?>
<?php $data = $this->input->post(); ?>
<?php
switch ($msg) {
    case "A":
        $m = "Comment(s) Successfully Approved..!";
        $t = "success";
        break;
    case "DA":
        $m = "Comment(s) Successfully Disapproved..!";
        $t = "error";
        break;
    case "D":
        $m = "Comment(s) Successfully Deleted..!";
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
    $('.input-daterange').datepicker({
        format: "dd-mm-yyyy",
        todayBtn: "linked",
        autoclose: true,
        todayHighlight: true
    });
</script>

<!-- DATA TABES SCRIPT -->
<script src="<?= base_url() ?>assets/admin/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/admin/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

<!-- page script -->
<script type="text/javascript">
    $(function () {
        $("#comment-data-table").dataTable({
            aLengthMenu: [
                [25, 50, 100, 200, -1],
                [25, 50, 100, 200, "All"]
            ],
            aoColumnDefs: [{
                    bSortable: false,
                    aTargets: [0, 3, 5]
                }],
            iDisplayLength: -1,
            aaSorting: [[2, 'asc']]
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
<?php if (is_array($data)) { ?>
            $('input[name="name_search"]').val("<?= $data['name_search'] ?>");
            $('input[name="email_search"]').val("<?= $data['email_search'] ?>");
            $('input[name="from_search"]').val("<?= $data['from_search'] ?>");
            $('input[name="to_search"]').val("<?= $data['to_search'] ?>");
            $('select[name="blog_search"]').val("<?= $data['blog_search'] ?>");
            $('select[name="status_search"]').val("<?= $data['status_search'] ?>");
<?php } ?>
        $('#comment-data-table tbody tr').each(function () {
            $(this).children('td.sorting_1').find('div.checked');
        });


        $('button.delete').click(function (e) {
            var act = $(this).val();
            action(act);
        });

        function action(actiontype) {
            $('#actionType').val(actiontype);
            $('#checkForm').attr('action', "<?= site_url() ?>admin/comment/action");
            $('#checkForm').submit();
        }
    });

</script>