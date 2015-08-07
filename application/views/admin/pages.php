<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dashboard/autocomplete/jquery-ui.css"/>
<style type="text/css">
    .cke_contents{
        height: 350px !important;
    } 
    .ui-autocomplete { 
        cursor:pointer; 
        height:120px; 
        overflow-y:scroll;
        z-index: 9999
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
                                    <input type="text" class="form-control"  id="pages" value="" />
                                </div>
                            </div>
                            <div class="col-md-9 goto" style="display: none">
                                <a href="#" class="link">View</a>
                            </div>
                        </div>
                        <form id="pageForm" action="<?= site_url() ?>admin/pages/update" method="post">
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
                            <input type="hidden" name="pageid" value="" />
                        </form>
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
    var pages = new Array();
    var ids = new Array();
    $(function () {
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.

        CKEDITOR.replace('editor1');
        //bootstrap WYSIHTML5 - text editor
        $(".textarea").wysihtml5();

<?php foreach ($pages as $key => $value) { ?>
            pages["<?= $key ?>"] = "<?= $value->title ?>";
            ids["<?= $key ?>"] = "<?= $value->page_id ?>";
<?php } ?>

        $('#pages').autocomplete({
            source: pages,
            minLength: 0,
            scroll: true
        }).focus(function () {
            $(this).autocomplete("search", "");
        });
    });

<?php $pageid = $this->input->get('id'); ?>

    $(document).ready(function () {
        function getPage(page) {
            $('.overlay').show();
            $('.loading-img').show();
            $.ajax({
                type: 'POST',
                data: {pageid: page},
                url: "<?= site_url() ?>admin/pages/getContent",
                success: function (data, textStatus, jqXHR) {
                    $('.overlay').hide();
                    $('.loading-img').hide();
                    if (data == "0") {
                        alertify.error("Page does not exists..!");
                        $('#pages').val("");
                        CKEDITOR.instances['editor1'].setData("");
                        $('.box-title').text("Page");
                    } else {
                        CKEDITOR.instances['editor1'].setData(data);
                    }
                }
            });
        }
        $('ul.ui-autocomplete').on('click', function () {
            var page = $('#pages').val();
            getPage(ids[pages.indexOf(page)]);
            $('.box-title').text(page);
        });
        $('#pages').on("keypress", function (e) {
            if (e.keyCode == 13) {
                var page = $('#pages').val();
                if (page.trim() != "" && pages.indexOf(page) != "-1") {
                    getPage(ids[pages.indexOf(page)]);
                    $('.box-title').text(page);

                } else {
                    alertify.error("Page does not exists..!");
                    $('#pages').val("");
                    CKEDITOR.instances['editor1'].setData("");
                    $('.box-title').text("Page");
                }
            }
        });

        $('#save-page').click(function () {
            var page = $('#pages').val();
            var pageid = ids[pages.indexOf(page)];
            $('input[name="pageid"]').val(pageid);
            $('#pageForm').submit();
        });

<?php if ($pageid != ""): ?>
            if (ids.indexOf("<?= $pageid ?>") != "-1") {
                var id = ids.indexOf("<?= $pageid ?>");
                $('#pages').val(pages[id]);
                $('.box-title').text(pages[id]);
                setTimeout(function () {
                    $('ul.ui-autocomplete').trigger('click');
                }, 1000);
            }
<?php endif; ?>
    });
</script>