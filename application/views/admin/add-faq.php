<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Add New FAQ
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
                        <h3 class="box-title">New FAQ</h3>
                    </div><!-- /.box-header -->
                    <?php $method = (isset($faqs)) ? "updateFaq" : "createFaq" ?>
                    <!-- form start -->
                    <form role="form" action="<?= site_url() ?>admin/faq/<?= $method ?>" method="post">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="username">FAQ Question</label>
                                        <input value="<?= isset($faqs) ? $faqs->question : '' ?>" type="text" autofocus="autofocus" name="Question" class="form-control" placeholder="FAQ Question" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Choose FAQ Category</label>
                                        <select name="category_id" class="form-control" required="">
                                            <option value="-1">--Select--</option>
                                            <?php foreach ($category as $value) { ?>
                                                <?php
                                                $selected = "";
                                                if (isset($faqs)) {
                                                    $selected = ($faqs->category_id == $value->category_id) ?
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
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class='row'>
                                            <div class='col-md-12'>
                                                <div class='box box-info'>
                                                    <div class='box-header'>
                                                        <h3 class='box-title'>Editor</h3>
                                                    </div><!-- /.box-header -->
                                                    <div class='box-body pad'>
                                                        <textarea id="editor1" name="answer" rows="10" cols="80">
                                                            <?= isset($faqs) ? $faqs->answer : '' ?>
                                                        </textarea>
                                                    </div>
                                                </div><!-- /.box -->
                                            </div>
                                        </div><!-- /.box-body -->
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
                                <div class="row">
                                    <div class="col-md-2">
                                        <button type="submit"  class="btn btn-warning">
                                            <?= isset($faqs) ? 'Update' : 'Save' ?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if (isset($faqs)): ?>
                            <input type="hidden" name="faqid" value="<?= $faqs->faq_id ?>" />
                        <?php endif; ?>
                    </form>
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
</script>
