<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 >
            Video
        </h1>

    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Upload New Video</h3>
                    </div><!-- /.box-header -->

                    <!-- form start -->
                    <form role="form" action="<?= site_url() ?>admin/cms/upload" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Video Title</label>
                                        <input value="" type="text" autofocus="autofocus" name="name" class="form-control" placeholder="Video Title" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Select Video</label>
                                        <input name="video_url"  type="file" class="form-control" required=""/>
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
                                <div class="row">
                                    <div class="col-md-1">
                                        <button type="submit" class="btn btn-primary">
                                            Upload     
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div><!-- /.box -->
            </div><!--/.col (left) -->
            <!-- right column -->
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->
</div><!-- ./wrapper -->

