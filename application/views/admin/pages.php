<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dashboard/autocomplete/jquery-ui.css"/>
<style type="text/css">
    .cke_contents{
        height: 350px !important;
    } 
</style>
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="display: none">
            Web Pages
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
                        <h3 class="box-title">Page</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Choose Webpage</label>
                                    <input type="text" class="form-control"  id="pages" />
                                    <select name="page_id" id="pageid" class="form-control" >
                                        <option value="-1">--Select--</option>

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
                                                    <h3 class='box-title'>Content Editor</h3>
                                                </div><!-- /.box-header -->
                                                <div class='box-body pad'>
                                                    <textarea id="editor1" name="content" rows="10" cols="80"></textarea>
                                                </div>
                                            </div><!-- /.box -->
                                        </div>
                                    </div><!-- /.box-body -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="display: none" class="overlay"></div>
                    <div style="display: none" class="loading-img"></div>
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

        var pages = new Array();
        var ids = new Array();

        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace('editor1');
        //bootstrap WYSIHTML5 - text editor
        $(".textarea").wysihtml5();

<?php foreach ($pages as $value) { ?>
            pages[] = "<?= $value->title ?>";
                    ids[] = "<?= $value->page_id ?>";
<?php } ?>

        $('#users').autocomplete({
            source: pages,
            minLength: 0,
            scroll: true
        }).focus(function () {
            $(this).autocomplete("search", "");
        });


    });
    $(document).ready(function () {

        $('#pageid').change(function () {

            var val = $(this).val();
            if (val == "-1") {
                CKEDITOR.instances['editor1'].setData("");
            } else {
                $('.overlay').show();
                $('.loading-img').show();
                $.ajax({
                    type: 'POST',
                    data: {pageid: val},
                    url: "<?= site_url() ?>admin/pages/getContent",
                    success: function (data, textStatus, jqXHR) {
                        $('.overlay').hide();
                        $('.loading-img').hide();
                        CKEDITOR.instances['editor1'].setData(data);
                    }
                });
            }
        });

        $('#save-page').click(function () {
            $('.overlay').show();
            $('.loading-img').show();
            var pageid = $('#pageid').val();
            var content = CKEDITOR.instances['editor1'].getData();
            $.ajax({
                type: 'POST',
                data: {pageid: pageid, content: content},
                url: "<?= site_url() ?>admin/pages/update",
                success: function (data, textStatus, jqXHR) {
                    $('.overlay').hide();
                    $('.loading-img').hide();
                    alertify.success("Content Successfully Updated..!");
                }
            });
        });
    });
</script>
