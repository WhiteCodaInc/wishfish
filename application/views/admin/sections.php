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
            Homepage Sections
        </h1>
        <button type="button" id="save-section"  class="btn btn-warning">
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
                        <h3 class="box-title">Section</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Choose Section</label>
                                    <input type="text" class="form-control"  id="sections" />
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
    var sections = new Array();
    var ids = new Array();
    $(function () {
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace('editor1');
        //bootstrap WYSIHTML5 - text editor
        $(".textarea").wysihtml5();

<?php foreach ($sections as $key => $value) { ?>
            sections["<?= $key ?>"] = "<?= $value->title ?>";
            ids["<?= $key ?>"] = "<?= $value->section_id ?>";
<?php } ?>

        $('#sections').autocomplete({
            source: sections,
            minLength: 0,
            scroll: true
        }).focus(function () {
            $(this).autocomplete("search", "");
        });
    });
    $(document).ready(function () {

        function getSection(section) {
            $('.overlay').show();
            $('.loading-img').show();
            $.ajax({
                type: 'POST',
                data: {sectionid: section},
                url: "<?= site_url() ?>admin/sections/getContent",
                success: function (data, textStatus, jqXHR) {
                    $('.overlay').hide();
                    $('.loading-img').hide();
                    CKEDITOR.instances['editor1'].setData(data);
                }
            });
        }
        $('ul.ui-autocomplete').on('click', function () {
            var section = $('#sections').val();
            getSection(ids[sections.indexOf(section)]);
        });
        $('#sections').on("keypress", function (e) {
            if (e.keyCode == 13) {
                var section = $('#sections').val();
                if (section.trim() != "") {
                    getSection(ids[sections.indexOf(section)]);
                } else {
                    CKEDITOR.instances['editor1'].setData("");
                }
            }
        });

        $('#save-section').click(function () {
            $('.overlay').show();
            $('.loading-img').show();
            var sectionid = $('#sectionid').val();
            var content = CKEDITOR.instances['editor1'].getData();
            $.ajax({
                type: 'POST',
                data: {sectionid: sectionid, content: content},
                url: "<?= site_url() ?>admin/sections/update",
                success: function (data, textStatus, jqXHR) {
                    $('.overlay').hide();
                    $('.loading-img').hide();
                    alertify.success("Content Successfully Updated..!");
                }
            });
        });
    });
</script>