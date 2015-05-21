<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="display: none">
            <?= (isset($blogs)) ? "Edit Existing Blog" : "Add New Blog" ?>
        </h1>
        <button class="publish btn btn-primary">Publish</button>
        <button class="draft btn btn-warning">
            <?= isset($blogs) ? 'Update as Draft' : 'Save as Draft' ?>
        </button>
        <button id="preview" type="button" data-toggle="modal" data-target="#blog-preview"  class="default btn btn-info">
            <i class="fa fa-eye"></i>
            Blog Preview
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
                        <h3 class="box-title"><?= (isset($blogs)) ? $blogs->title : "New Blog" ?></h3>
                    </div><!-- /.box-header -->
                    <?php $method = (isset($blogs)) ? "updateBlog" : "createBlog" ?>
                    <!-- form start -->
                    <form role="form" action="<?= site_url() ?>admin/cms/<?= $method ?>" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="username">Blog Title</label>
                                        <input value="<?= isset($blogs) ? $blogs->title : '' ?>" type="text" autofocus="autofocus" name="title" class="form-control" placeholder="Blog Title" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Choose Blog Category</label>
                                        <select name="category_id" class="form-control" required="">
                                            <option value="-1">--Select--</option>
                                            <?php foreach ($category as $value) { ?>
                                                <?php
                                                $selected = "";
                                                if (isset($blogs)) {
                                                    $selected = ($blogs->category_id == $value->category_id) ?
                                                            "selected" : '';
                                                }
                                                ?>
                                                <option value="<?= $value->category_id ?>" <?= $selected ?>>
                                                    <?= $value->category_name ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="blog image">Blog Image</label>
                                        <input name="feature_img"  type="file" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Blog Video</label>
                                        <input name="feature_video"  type="file" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <?php if (isset($blogs) && ($blogs->feature_img != "" || $blogs->feature_video != "")): ?>
                                <?php
                                $img_src = "http://mikhailkuznetsov.s3.amazonaws.com/" . $blogs->feature_img;
                                ?>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <img style="width: 340px;height: 238px" src="<?= $img_src ?>" alt="Blog Image" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div id='mediaplayer'></div>
                                        <script type='text/javascript' src='https://d2f058tgxz31a7.cloudfront.net/video_setting/jwplayer.js'></script>
                                        <script type="text/javascript">
                                            jwplayer('mediaplayer').setup({
                                                file: 'rtmp://s12e6wqr7fb3zu.cloudfront.net/cfx/st/<?= $blogs->feature_video ?>',
                                                width: "340",
                                                height: "238"
                                            });
                                        </script>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class='row'>
                                            <div class='col-md-12'>
                                                <div class='box box-info'>
                                                    <div class='box-header'>
                                                        <h3 class='box-title'>Editor</h3>
                                                    </div><!-- /.box-header -->
                                                    <div class='box-body pad'>
                                                        <textarea id="editor1" name="content" rows="10" cols="80">
                                                            <?= isset($blogs) ? $blogs->content : '' ?>
                                                        </textarea>
                                                    </div>
                                                </div><!-- /.box -->
                                            </div>
                                        </div><!-- /.box-body -->
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer" style="display: none">
                                <div class="row">
                                    <div class="col-md-1">
                                        <button id="publish" type="submit" name="submit" value="publish" class="btn btn-primary">Publish</button>
                                    </div>
                                    <div class="col-md-2">
                                        <button id="draft" type="submit" name="submit" value="draft"  class="btn btn-warning">
                                            <?= isset($blogs) ? 'Update as Draft' : 'Save as Draft' ?>
                                        </button>
                                    </div>
                                    <div class="col-md-2">
                                        <button id="preview" type="button" data-toggle="modal" data-target="#blog-preview"  class="btn btn-info">
                                            <i class="fa fa-eye"></i>
                                            Blog Preview
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if (isset($blogs)): ?>
                            <input type="hidden" name="blogid" value="<?= $blogs->blog_id ?>" />
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
<div class="modal fade" id="blog-preview" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <div class="row m-bot15">                        
                    <div id="blog-view" class="col-md-12">

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


<!-- CK Editor -->
<!--<script src="//cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>-->
<script src="<?= base_url() ?>assets/dashboard/js/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?= base_url() ?>assets/dashboard/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>

<script type="text/javascript">
                                            $(function () {
                                                // Replace the <textarea id="editor1"> with a CKEditor
                                                // instance, using default configuration.
                                                CKEDITOR.replace('editor1');
                                                //bootstrap WYSIHTML5 - text editor
                                                $(".textarea").wysihtml5();
                                            });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('button.publish').click(function () {
            $('#publish').trigger('click');
        });
        $('button.draft').click(function () {
            $('#draft').trigger('click');
        });
        $('#preview').click(function () {
            $('.modal-title').text($('input[name="title"]').val());
            $('#blog-view').html(CKEDITOR.instances['editor1'].getData());
        });
    });
</script>