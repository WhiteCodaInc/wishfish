<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="display: none">
            About Us
        </h1>
        <button type="button" id="aboutus" class="btn btn-primary">
            <?= isset($aboutus) ? "Update" : "Save" ?>     
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
                        <h3 class="box-title">About Us</h3>
                    </div><!-- /.box-header -->

                    <?php
                    $method = (isset($aboutus)) ? "updateAboutus" : "addAboutus";
                    ?>

                    <!-- form start -->
                    <form id="aboutForm" role="form" action="<?= site_url() ?>admin/cms/<?= $method ?>" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Aboutus Title</label>
                                        <input value="<?= isset($aboutus) ? $aboutus->title : '' ?>" type="text" autofocus="autofocus" name="title" class="form-control" placeholder="Aboutus Title" />
                                    </div>
                                </div>
                            </div>
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
                                                            <?= isset($aboutus) ? $aboutus->content : '' ?>
                                                        </textarea>
                                                    </div>
                                                </div><!-- /.box -->
                                            </div>
                                        </div><!-- /.box-body -->
                                    </div>
                                </div>
                            </div>


                        </div>
                        <?php if (isset($aboutus)): ?>
                            <input type="hidden" name="aboutusid" value="<?= $aboutus->aboutus_id ?>" />
                        <?php endif; ?>
                    </form>
                </div><!-- /.box -->
            </div><!--/.col (left) -->
            <!-- right column -->
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<?php $msg = $this->input->get('msg'); ?>
<?php
switch ($msg) {
    case "I":
        $m = "About Us Content Successfully Added..!";
        $t = "success";
        break;
    case "U":
        $m = "About Us Content Successfully Updated..!";
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

<script type="text/javascript">
    $(document).ready(function () {
        $('#aboutus').click(function () {
            $('#aboutForm').submit();
        });
    });
</script>s
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