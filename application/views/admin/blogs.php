<!-- Right side column. Contains the navbar and content of the page -->
<style type="text/css">
    #blog-data-table tr td,#blog-data-table tr th{
        text-align: center;
    }
</style>
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style=" display: none">
            Blogs
        </h1>
        <a href="<?= site_url() ?>admin/cms/addBlog" class="create btn btn-success btn-sm">
            <i class="fa fa-plus"></i>
            Create New Blog Post
        </a>
        <button  value="Default" class="default btn btn-warning btn-sm" id="Default" type="button" >Set as Default</button>
        <button  value="Publish" class="publish btn btn-info btn-sm" id="Publish" type="button" >Publish</button>
        <button value="Draft" class="draft btn btn-primary btn-sm" id="Draft" type="button" >Draft</button>
        <button  value="Delete" class="delete btn btn-danger btn-sm" id="Delete" type="button" >Delete</button>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-xs-12">
                <div class="box" >
                    <div class="box-header">
                        <h3 class="box-title">Blog Detail</h3>
                    </div><!-- /.box-header -->
                    <div class="row">
                        <div class="col-xs-12" style="margin-left: 1%">
<!--                            <a href="<?= site_url() ?>admin/cms/addBlog" class="create btn btn-success btn-sm">
                                <i class="fa fa-plus"></i>
                                Create New Blog Post
                            </a>
                            <button style="margin-left: 10px" value="Default" class="default btn btn-warning btn-sm" id="Default" type="button" >Set as Default</button>
                            <button style="margin-left: 10px" value="Publish" class="publish btn btn-info btn-sm" id="Publish" type="button" >Publish</button>
                            <button style="margin-left: 10px" value="Draft" class="draft btn btn-primary btn-sm" id="Draft" type="button" >Draft</button>
                            <button style="margin-left: 10px" value="Delete" class="delete btn btn-danger btn-sm" id="Delete" type="button" >Delete</button>-->
                        </div>
                    </div>

                    <form name="checkForm" id="checkForm" action="" method="post">
                        <div class="box-body table-responsive" id="data-panel">

                            <table id="blog-data-table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="padding: 10px;">
                                            <input type="checkbox"/>
                                        </th>
                                        <th>Default Post</th>
                                        <th class="hidden-xs hidden-sm">No.</th>
                                        <th>Blog Title</th>
                                        <th class="hidden-xs hidden-sm">Status</th>
                                        <th class="hidden-xs hidden-sm">Publish On</th>
                                        <th>Blog Preview</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($blogs as $value) { ?>
                                        <tr id="<?= $value->blog_id ?>">
                                            <td>
                                                <div>
                                                    <label>
                                                        <input type="checkbox" name="blog[]" value="<?= $value->blog_id ?>"/>
                                                    </label>
                                                </div>
                                            </td>
                                            <td style="width: 10%;text-align: center">
                                                <div>
                                                    <label>
                                                        <input type="radio"  name="default" value="<?= $value->blog_id ?>" <?= ($value->default_post) ? "checked" : '' ?>/>
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="hidden-xs hidden-sm"><?= $value->blog_id ?></td>
                                            <td><?= $value->title ?></td>
                                            <td class="hidden-xs hidden-sm">
                                                <?php
                                                switch ($value->status) {
                                                    case 1:
                                                        echo 'Publish';
                                                        break;
                                                    case 0:
                                                        echo 'Draft';
                                                        break;
                                                    default:
                                                        break;
                                                }
                                                ?>
                                            </td>
                                            <td class="hidden-xs hidden-sm"><?= date('d-m-Y', strtotime($value->publish_on)) ?></td>
                                            <td>
                                                <button type="button"  value="<?= $value->blog_id ?>" class="btn btn-warning btn-xs preview">
                                                    <i class="fa fa-eye"></i>
                                                    Blog Preview
                                                </button>
                                            </td>
                                            <td>
                                                <a href="<?= site_url() ?>admin/cms/editBlog/<?= $value->blog_id ?>" class="btn bg-navy btn-xs">
                                                    <i class="fa fa-edit"></i>
                                                    Edit
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th>Default Post</th>
                                        <th class="hidden-xs hidden-sm">No.</th>
                                        <th>Blog Title</th>
                                        <th class="hidden-xs hidden-sm">Status</th>
                                        <th class="hidden-xs hidden-sm">Publish On</th>
                                        <th>Blog Preview</th>
                                        <th>Action</th>
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

<span style="display: none" id="blog" data-toggle="modal" data-target="#blog-preview"></span>
<!-- NEW EVENT MODAL -->
<div class="modal fade" id="blog-preview" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-envelope-o"></i></h4>
            </div>
            <div class="modal-body">
                <div class="row m-bot15">                        
                    <div id="blog-view" class="col-md-12"></div>
                </div>
                <div class="modal-footer clearfix">
                    <button type="button" id="n_discard" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Discard</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</div>
<!-- /.modal -->
<?php $msg = $this->input->get('msg'); ?>
<?php
switch ($msg) {
    case "I":
        $m = "Blog Successfully Created..!";
        $t = "success";
        break;
    case "U":
        $m = "Blog Successfully Updated..!";
        $t = "success";
        break;
    case "D":
        $m = "Blog(s) Successfully Deleted..!";
        $t = "error";
        break;
    case "SD":
        $m = "Blog Post set as Default Successfully ..!";
        $t = "success";
        break;
    case "DR":
        $m = "Blog Post set as Draft Successfully ..!";
        $t = "success";
        break;
    case "P":
        $m = "Blog Post set as Publish Successfully ..!";
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
<script type='text/javascript' src='https://d2f058tgxz31a7.cloudfront.net/video_setting/jwplayer.js'></script>
<!-- page script -->
<script type="text/javascript">
    $(function () {
        $("#blog-data-table").dataTable({
            aoColumnDefs: [{
                    bSortable: false,
                    aTargets: [0, 1, 6, 7]
                }]
        });

        $('#blog-data-table tbody').sortable({
            cursor: "move",
            update: function () {
                var blogid = new Array();
                $("#blog-data-table tbody").children().each(function (i) {
                    var td = $(this);
                    blogid[i] = td.attr("id");
                });
//                console.log(blogid);
                $.ajax({
                    type: "POST",
                    url: "<?= site_url() . 'admin/cms/updateOrder' ?>",
                    data: {blogid: blogid},
                    success: function (data, textStatus, jqXHR) {
                        console.log(data);
                    }
                });
            }
        });
        $("#sortable").disableSelection();
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('button.delete').click(function (e) {
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
        $('button.default').click(function (e) {
            action($(this).val());
            e.preventDefault();
        });
        $('button.publish').click(function (e) {
            action($(this).val());
            e.preventDefault();
        });
        $('button.draft').click(function (e) {
            action($(this).val());
            e.preventDefault();
        });

        function action(actiontype) {
            $('#actionType').val(actiontype);
            $('#checkForm').attr('action', "<?= site_url() ?>admin/cms/action");
            $('#checkForm').submit();
        }

        $('.preview').click(function () {
            var blogid = $(this).val();
            $.ajax({
                type: 'POST',
                data: {blogid: blogid},
                url: "<?= site_url() ?>admin/cms/getBlog",
                success: function (data, textStatus, jqXHR) {
                    $('#blog-view').html(data);
                    $('#blog').trigger('click');
                }
            });
        });
    });

</script>