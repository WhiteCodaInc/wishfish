<!-- Right side column. Contains the navbar and content of the page -->
<style type="text/css">
    #media-data-table tr td,#media-data-table tr th{
        text-align: center;
    }
</style>
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style=" display: none">
            Media Library
        </h1>
        <a href="<?= site_url() ?>admin/media/addMedia" class="create btn btn-success btn-sm">
            <i class="fa fa-plus"></i>
            Create New Media
        </a>
        <button  value="Delete" class="delete btn btn-danger btn-sm" id="Delete" type="button" >Delete</button>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-xs-12">
                <div class="box" >
                    <div class="box-header">
                        <h3 class="box-title">Media Detail</h3>
                    </div><!-- /.box-header -->
                    <form name="checkForm" id="checkForm" action="" method="post">
                        <div class="box-body table-responsive" id="data-panel">

                            <table id="media-data-table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="padding: 10px;">
                                            <input type="checkbox"/>
                                        </th>
                                        <th>Date</th>
                                        <th>Media</th>
                                        <th>Media Type</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($media as $value) { ?>
                                        <tr id="<?= $value->media_id ?>">
                                            <td>
                                                <div>
                                                    <label>
                                                        <input type="checkbox" name="media[]" value="<?= $value->media_id ?>"/>
                                                    </label>
                                                </div>
                                            </td>
                                            <td><?= date('m-d-Y', strtotime($value->date)) ?></td>
                                            <td>
                                                <?php if ($value->path != NULL): ?>
                                                    <?php if ($value->type == "video") { ?>
                                                        <button type="button"  value="<?= $value->media_id ?>" class="btn btn-warning btn-xs view-video">
                                                            <i class="fa fa-eye"></i>
                                                            Watch Video
                                                        </button>
                                                        <input type="hidden" name="path" value="<?= $value->path ?>" />
                                                    <?php } elseif ($value->type == "picture") { ?>
                                                        <a id="img" href="javascript:void(0)" >
                                                            <img alt="<?= $value->name ?>" src="https://s3-us-west-2.amazonaws.com/mikhailkuznetsov/<?= $value->path ?>" style="width:100px" />
                                                        </a>
                                                    <?php } else if ($value->type == "audio") { ?>
                                                        <button type="button"  value="<?= $value->media_id ?>" class="btn btn-success btn-xs">
                                                            <i class="fa fa-eye"></i>
                                                            Watch Video
                                                        </button>
                                                        <input type="hidden" name="path" value="<?= $value->path ?>" />
                                                    <?php } ?>
                                                <?php else : ?>
                                                    N/A
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php
                                                switch ($value->type) {
                                                    case "audio":
                                                        echo "Audio (.$value->extension)";
                                                        break;
                                                    case "video":
                                                        echo "Video (.$value->extension)";
                                                        break;
                                                    case "picture":
                                                        echo "Picture (.$value->extension)";
                                                        break;
                                                }
                                                ?>
                                            </td>
                                            <td><?= $value->name ?></td>
                                            <td>
                                                <button type="button"  value="<?= $value->media_id ?>" class="btn btn-info btn-xs html">
                                                    <i class="fa fa-eye"></i>
                                                    Html Code
                                                </button>
                                                <button type="button"  value="<?= $value->media_id ?>" class="btn btn-primary btn-xs html">
                                                    <i class="fa fa-eye"></i>
                                                    Link
                                                </button>
                                                <a href="<?= site_url() ?>admin/cms/editMedia/<?= $value->media_id ?>" class="btn bg-navy btn-xs">
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
                                        <th>Date</th>
                                        <th>Media</th>
                                        <th>Media Type</th>
                                        <th>Name</th>
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

<span style="display: none" id="video" data-toggle="modal" data-target="#video-preview"></span>
<!-- NEW EVENT MODAL -->
<div class="modal fade" id="video-preview" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-envelope-o"></i></h4>
            </div>
            <div class="modal-body">
                <div class="row m-bot15">                        
                    <div id="view" class="col-md-12"></div>
                </div>
                <div class="modal-footer clearfix">
                    <button type="button" id="n_discard" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Discard</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</div>

<!--https://s3-us-west-2.amazonaws.com/mikhailkuznetsov/crossingthechasm.jpg-->

<!-- /.modal -->
<?php $msg = $this->input->get('msg'); ?>
<?php
switch ($msg) {
    case "I":
        $m = "Media Successfully Uploaded..!";
        $t = "success";
        break;
    case "U":
        $m = "Media Successfully Updated..!";
        $t = "success";
        break;
    case "D":
        $m = "Media(s) Successfully Deleted..!";
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
<script type='text/javascript' src='https://d2f058tgxz31a7.cloudfront.net/video_setting/jwplayer.js'></script>
<!-- page script -->
<script type="text/javascript">
    $(function () {
        $("#media-data-table").dataTable({
            aoColumnDefs: [{
                    bSortable: false,
                    aTargets: [0, 1, 2, 3, 5]
                }]
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('button.delete').click(function (e) {
            var act = $(this).val();
            alertify.confirm("Are you sure you wish to delete Media(s)", function (e) {
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
            $('#checkForm').attr('action', "<?= site_url() ?>admin/media/action");
            $('#checkForm').submit();
        }
        $('a#img').click(function () {
            $img = $(this).children('img').clone();
            $img.removeAttr('style');
            $('#video-view').html($img);
            $('#video').trigger('click');
        });
        $('.preview').click(function () {
            var mediaid = $(this).val();
            $.ajax({
                type: 'POST',
                data: {blogid: mediaid},
                url: "<?= site_url() ?>admin/media/getMedia",
                success: function (data, textStatus, jqXHR) {
                    $('#video-view').html(data);
                    $('#video').trigger('click');
                }
            });
        });
    });
</script>