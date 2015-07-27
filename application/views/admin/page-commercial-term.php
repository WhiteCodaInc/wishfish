<style type="text/css">
    .cke_contents{
        height: 500px !important;
    } 
</style>
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="display: none">
            Commercial Terms
        </h1>
        <button type="button" id="save-page"  class="btn btn-warning">
            Update
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
                        <h3 class="box-title">Commercial Terms</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <div class="box-body">
                        <form id="termForm" action="<?= site_url() ?>admin/pages/updateTerm" method="post">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class='row'>
                                            <div class='col-md-12'>
                                                <div class='box box-info'>
                                                    <div class='box-header'>
                                                        <h3 class='box-title'>Content Editor</h3>
                                                    </div><!-- /.box-header -->
                                                    <div class='box-body pad'>
                                                        <textarea id="editor1" name="content" rows="10" cols="80"><?= $page->content ?></textarea>
                                                    </div>
                                                </div><!-- /.box -->
                                            </div>
                                        </div><!-- /.box-body -->
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.box -->
            </div><!--/.col (left) -->
            <!-- right column -->
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->
</div><!-- ./wrapper -->


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
    $(document).ready(function () {
        $('#save-page').click(function () {
            $('#termForm').submit();
        });
    });
</script>

