<script type='text/javascript' src='https://d2f058tgxz31a7.cloudfront.net/video_setting/jwplayer.js'></script>
<style type="text/css">
    #media-data-table tr td,#media-data-table tr th{
        text-align: center;
    }
    audio{
        width: 45px !important;
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
            <div class="col-md-12">
                <!-- Primary box -->
                <div class="box box-solid box-primary collapsed-box">
                    <div class="box-header" data-widget="collapse"  style="cursor: pointer">
                        <h3 class="box-title">Filterable Search</h3>
                    </div>
                    <div class="box-body" style="display: none">
                        <form action="<?= site_url() ?>admin/media/search" method="post">
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
                                    <label>Contact Group</label>
                                    <select name="type_search" class="form-control m-bot15">
                                        <option value="-1">--Select--</option>
                                        <option value="audio">Audio</option>
                                        <option value="picture">Picture</option>
                                        <option value="Video">Video</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>Media Name</label>
                                    <input name="name_search" class="form-control" placeholder="Media Name" type="text">
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
                                                        <input type="hidden" name="path" value="https://d2f058tgxz31a7.cloudfront.net/<?= $value->path ?>" />
                                                    <?php } elseif ($value->type == "picture") { ?>
                                                        <a id="img" href="javascript:void(0)" >
                                                            <img alt="<?= $value->name ?>" src="https://d2f058tgxz31a7.cloudfront.net/<?= $value->path ?>" style="width:100px" />
                                                        </a>
                                                    <?php } else if ($value->type == "audio") { ?>
                                                        <audio controls>
                                                            <source src="https://d2f058tgxz31a7.cloudfront.net/<?= $value->path ?>" type="audio/mpeg">
                                                        </audio>
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
                                            <td class="name"><?= $value->name ?></td>
                                            <td>
                                                <button type="button"  value="<?= $value->type ?>" class="btn btn-info btn-xs html">
                                                    <i class="fa fa-eye"></i>
                                                    Html Code
                                                </button>
                                                <button type="button"  value="<?= $value->type ?>" class="btn btn-primary btn-xs link">
                                                    <i class="fa fa-eye"></i>
                                                    Link
                                                </button>
                                                <a href="<?= site_url() ?>admin/media/editMedia/<?= $value->media_id ?>" class="btn bg-navy btn-xs">
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

<span style="display: none" id="video_preview" data-toggle="modal" data-target="#video-preview"></span>
<!-- NEW EVENT MODAL -->
<div class="modal fade" id="video-preview" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <div class="row m-bot15">                        
                    <div id="view" class="col-md-12" style="text-align: center">

                    </div>
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
    $('.input-daterange').datepicker({
        format: "mm-dd-yyyy",
        todayBtn: "linked",
        autoclose: true,
        todayHighlight: true
    });
</script>

<!-- DATA TABES SCRIPT -->
<script src="<?= base_url() ?>assets/dashboard/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/dashboard/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

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
            var mediaid = $(this).parents('tr').attr('id');
            var name = $('tr#' + mediaid).find('td.name').text();
            $img = $(this).children('img').clone();
            $img.removeAttr('style');
            $('#view').html($img);
            $('.modal-title').text(name);
            $('#video_preview').trigger('click');
        });

        $('button.html').click(function () {
            var type = $(this).val();
            var mediaid = $(this).parents('tr').attr('id');
            var name = $('tr#' + mediaid).find('td.name').text();
            $('.modal-title').text(name);
            switch (type) {
                case "audio":
                    $('#view').html("<textarea class='form-control' rows='5'></textarea>");
                    $audio = $('tr#' + mediaid + ' td:nth-child(3)').html();
                    $('#view textarea').text(($audio.replace(/  +/g, ' ')).trim());
                    $('#video_preview').trigger('click');
                    setTimeout(function () {
                        $('#view textarea').focus();
                        $('#view textarea').select();
                    }, 500);
                    break;
                case "picture":
                    $img = $('tr#' + mediaid).find('img');
                    $img.removeAttr('style');
                    $('#view').html("<textarea class='form-control'></textarea>");
                    $('#view textarea').text("<img alt='" + $img.attr('alt') + "' src='" + $img.attr('src') + "' />");
                    $('#video_preview').trigger('click');
                    setTimeout(function () {
                        $('#view textarea').focus();
                        $('#view textarea').select();
                    }, 500);
                    break;
                case "video":
                    $('#view').html("<textarea class='form-control'  rows='9'></textarea>");
                    $.ajax({
                        type: 'POST',
                        data: {mediaid: mediaid},
                        url: "<?= site_url() ?>admin/media/getMedia",
                        success: function (data, textStatus, jqXHR) {
                            $('#view textarea').text(data);
                            $('#video_preview').trigger('click');
                            setTimeout(function () {
                                $('#view textarea').focus();
                                $('#view textarea').select();
                            }, 500);
                        }
                    });
                    break;
            }


        });

        $('button.link').click(function () {
            var type = $(this).val();
            var mediaid = $(this).parents('tr').attr('id');
            var name = $('tr#' + mediaid).find('td.name').text();
            $('.modal-title').text(name);
            $('#view').html("<textarea class='form-control' rows='2'></textarea>");
            switch (type) {
                case "audio":
                    $src = $('tr#' + mediaid).find('audio > source').attr('src');
                    break;
                case "picture":
                    $src = $('tr#' + mediaid).find('img').attr('src');
                    break;
                case "video":
                    $src = $('tr#' + mediaid).find('input[name="path"]').val();
                    break;
            }
            $('#view textarea').text($src);
            $('#video_preview').trigger('click');
            setTimeout(function () {
                $('#view textarea').focus();
                $('#view textarea').select();
            }, 500);

        });

        $('.view-video,.view-audio').click(function () {
            var mediaid = $(this).val();
            var name = $('tr#' + mediaid).find('td.name').text();
            $.ajax({
                type: 'POST',
                data: {mediaid: mediaid},
                url: "<?= site_url() ?>admin/media/getMedia",
                success: function (data, textStatus, jqXHR) {
                    $('.modal-title').text(name);
                    $('#view').html(data);
                    $('#video_preview').trigger('click');
                }
            });
        });
    });
</script>