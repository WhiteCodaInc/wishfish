<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="float: left">
            Add New SMS Template
        </h1>
        <button type="button" id="submitSMS"  class="btn btn-warning">
            <?= isset($template) ? 'Update SMS Template' : 'Add SMS Template' ?>
        </button>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3"></div>
            <!-- left column -->
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">New SMS Template</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php
                    $method = isset($template) ? "updateTemplate" : "createTemplate";
                    $c = isset($controller) ? "template" : "sms_template";
                    $m = isset($controller) ? "/sms" : "";
                    ?>
                    <form id="templateForm" role="form" action="<?= site_url() . "app/{$c}/{$method}{$m}" ?>" method="post">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="title">SMS Title</label>
                                        <input value="<?= isset($template) ? $template->title : '' ?>" type="text" autofocus="autofocus" name="title" class="form-control" placeholder="SMS Title" required="" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <div class='row'>
                                            <div class='col-md-12'>
                                                <div class='box box-info'>
                                                    <div class='box-header'>
                                                        <h3 class='box-title'>Editor</h3>
                                                    </div><!-- /.box-header -->
                                                    <div class='box-body pad'>
                                                        <textarea  name="body" rows="10" cols="60" required=""><?= isset($template) ? $template->body : '' ?></textarea>
                                                    </div>
                                                </div><!-- /.box -->
                                            </div>
                                        </div><!-- /.box-body -->
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <!-- Default box -->
                                    <div class="box collapsed-box">
                                        <div class="box-header">
                                            <h3 class="box-title">Token List</h3>
                                            <div class="box-tools pull-right">
                                                <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="box-body" style="display: none">
                                            <strong>{FIRST_NAME}</strong><br/>
                                            <strong>{LAST_NAME}</strong><br/>
                                            <strong>{EMAIL}</strong><br/>
                                            <strong>{PHONE}</strong><br/>
                                            <!--<strong>{GROUP}</strong><br/>-->
                                            <strong>{BIRTHDAY}</strong><br/>
                                            <strong>{ZODIAC}</strong><br/>
                                            <strong>{AGE}</strong><br/>
                                            <strong>{BIRTHDAY_ALERT}</strong><br/>
                                            <strong>{SOCIAL}</strong><br/>
                                            <strong>{CONTACT}</strong><br/>
                                            <strong>{COUNTRY}</strong><br/>
                                            <strong>{CITY}</strong><br/>
                                            <strong>{ADDRESS}</strong><br/>
                                            <strong>{RATING}</strong><br/>
                                        </div><!-- /.box-body -->
                                    </div><!-- /.box -->
                                </div><!-- /.col -->
                            </div>
                        </div>
                        <?php if (isset($template)): ?>
                            <input type="hidden" name="templateid" value="<?= $template->template_id ?>" />
                        <?php endif; ?>
                        <input type="submit" style="display: none" class="submit"/>
                    </form>
                </div><!-- /.box -->
            </div><!--/.col (left) -->
            <!-- right column -->
            <div class="col-md-3"></div>
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->

<!-- CK Editor -->
<!--<script src="//cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>-->
<!-- Bootstrap WYSIHTML5 -->
<!--<script src="<?= base_url() ?>assets/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>-->

<script type="text/javascript">
//    $(function () {
//        // Replace the <textarea id="editor1"> with a CKEditor
//        // instance, using default configuration.
//        CKEDITOR.replace('editor1');
//        //bootstrap WYSIHTML5 - text editor
//        $(".textarea").wysihtml5();
//    });
</script>
<script type="text/javascript">
    $(document).ready(function (e) {

        $('#submitSMS').click(function () {
            $('.submit').trigger('click');
        });
    });
</script>