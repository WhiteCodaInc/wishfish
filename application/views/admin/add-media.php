<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="display: none">
            <?= (isset($media)) ? "Edit Existing Media" : "Add New Midea" ?>
        </h1>
        <button class="save btn btn-primary">Save</button>
        <button id="preview" type="button" data-toggle="modal" data-target="#video-preview"  class=" btn btn-info">
            <i class="fa fa-eye"></i>
            Preview
        </button>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title"><?= (isset($media)) ? $media->name : "New Media" ?></h3>
                    </div><!-- /.box-header -->
                    <?php $method = (isset($media)) ? "updateMedia" : "createMedia" ?>
                    <!-- form start -->
                    <form role="form" action="<?= site_url() ?>admin/media/<?= $method ?>" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input value="<?= isset($media) ? $media->name : '' ?>" type="text" autofocus="autofocus" name="name" class="form-control" placeholder="Media Name" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Choose Media Category</label>
                                        <select name="type" class="form-control" required="">
                                            <option value="audio">Audio</option>
                                            <option value="picture">Picture</option>
                                            <option value="video">Video</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Upload</label>
                                        <input name="upload"  type="file" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <?php if (isset($media) && ($media->path != NULL)): ?>
                                <?php if ($media->type == "picture") { ?>
                                    <?php
                                    $img_src = "http://mikhailkuznetsov.s3.amazonaws.com/" . $media->path;
                                    ?>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <img style="width: 340px;height: 238px" src="<?= $img_src ?>" alt="<?= $media->name ?>" />
                                            </div>
                                        </div>
                                    </div>
                                <?php } else if ($media->type == "video") { ?>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div id='mediaplayer'></div>
                                            <script type='text/javascript' src='https://d2f058tgxz31a7.cloudfront.net/video_setting/jwplayer.js'></script>
                                            <script type="text/javascript">
                                                jwplayer('mediaplayer').setup({
                                                    file: 'rtmp://s12e6wqr7fb3zu.cloudfront.net/cfx/st/<?= $media->path ?>',
                                                    width: "340",
                                                    height: "238"
                                                });
                                            </script>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <img style="width: 340px;height: 238px" src="<?= $img_src ?>" alt="<?= $media->name ?>" />
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php endif; ?>
                            <div class="row">
                                <div class="col-md-1">
                                    <button id="publish" type="submit" class="btn btn-primary">Publish</button>
                                </div>
                                <div class="col-md-2">
                                    <button id="preview" type="button" data-toggle="modal" data-target="#video-preview"  class="btn btn-info">
                                        <i class="fa fa-eye"></i>
                                        Preview
                                    </button>
                                </div>
                            </div>
                        </div>
                        <?php if (isset($media)): ?>
                            <input type="hidden" name="mediaid" value="<?= $media->media_id ?>" />
                        <?php endif; ?>
                    </form>
                </div><!-- /.box -->
            </div><!--/.col (left) -->
            <!-- right column -->
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->
</div><!-- ./wrapper -->

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
                    <div id="video-view" class="col-md-12">

                    </div>
                </div>
                <div class="modal-footer clearfix">
                    <button type="button" id="n_discard" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Discard</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</div>
<!-- /.modal -->

<script type="text/javascript">
    $(document).ready(function () {
        $('button.publish').click(function () {
            $('#publish').trigger('click');
        });
        $('#preview').click(function () {
            $('.modal-title').text($('input[name="name"]').val());
            $('#video-view').html();
        });
    });
</script>