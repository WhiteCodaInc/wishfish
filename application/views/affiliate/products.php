<script type='text/javascript' src='https://d2f058tgxz31a7.cloudfront.net/video_setting/jwplayer.js'></script>
<style type="text/css">
    #product-data-table tr td,#product-data-table tr th{
        text-align: center;
    }
    audio{
        width: 45px !important;
    }
</style>
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style=" display: none">
            Promote Products
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box" >
                    <div class="box-header">
                        <h3 class="box-title">Product Detail</h3>
                    </div><!-- /.box-header -->
                    <form name="checkForm" id="checkForm" action="" method="post">
                        <div class="box-body table-responsive" id="data-panel">

                            <table id="product-data-table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Offer Name</th>
                                        <th>commission</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php //foreach ($product as $value) { ?>
                                    <tr id="1">
                                        <td>10-02-2015</td>
                                        <td class="name">DIWALI OFFER</td>
                                        <td>70%</td>
                                        <td>
                                            <button type="button"  value="html" class="btn btn-info btn-xs html">
                                                <i class="fa fa-eye"></i>
                                                Html Code
                                            </button>
                                            <button type="button"  value="link" class="btn btn-primary btn-xs link">
                                                <i class="fa fa-eye"></i>
                                                Link
                                            </button>
                                        </td>
                                    </tr>
                                    <?php // } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Date</th>
                                        <th>Offer Name</th>
                                        <th>commission</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->
</div><!-- ./wrapper -->



<script type="text/javascript">
</script>

<!-- DATA TABES SCRIPT -->
<script src="<?= base_url() ?>assets/dashboard/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/dashboard/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

<!-- page script -->
<script type="text/javascript">
    $(function () {
        $("#product-data-table").dataTable({
            bSort: false
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('button.html1').click(function () {
            var type = $(this).val();
            var offerid = $(this).parents('tr').attr('id');
            var name = $('tr#' + offerid).find('td.name').text();
            $('.modal-title').text(name);
            switch (type) {
                case "audio":
                    $('#view').html("<textarea class='form-control' rows='5'></textarea>");
                    $audio = $('tr#' + offerid + ' td:nth-child(3)').html();
                    $('#view textarea').text(($audio.replace(/  +/g, ' ')).trim());
                    $('#video_preview').trigger('click');
                    setTimeout(function () {
                        $('#view textarea').focus();
                        $('#view textarea').select();
                    }, 500);
                    break;
                case "picture":
                    $img = $('tr#' + offerid).find('img');
                    $img.removeAttr('style');
                    $('#view').html("<textarea class='form-control'></textarea>");
                    $('#view textarea').text("<img alt='" + $img.attr('alt') + "' src='" + $img.attr('src') + "' />");
                    $('#video_preview').trigger('click');
                    setTimeout(function () {
                        $('#view textarea').focus();
                        $('#view textarea').select();
                    }, 500);
                    break;
                case "video":
                    $('#view').html("<textarea class='form-control'  rows='9'></textarea>");
                    $.ajax({
                        type: 'POST',
                        data: {offerid: offerid},
                        url: "<?= site_url() ?>admin/media/getMedia",
                        success: function (data, textStatus, jqXHR) {
                            $('#view textarea').text(data);
                            $('#video_preview').trigger('click');
                            setTimeout(function () {
                                $('#view textarea').focus();
                                $('#view textarea').select();
                            }, 500);
                        }
                    });
                    break;
            }


        });

        $('button.link').click(function () {
            var offerid = $(this).parents('tr').attr('id');
            var name = $('tr#' + offerid).find('td.name').text();
            $('.modal-title').text(name);
            $('#view').html("<textarea class='form-control'></textarea>");
            $('#view textarea').text("<?= site_url() ?>?offer=" + offerid);
            $('#video_preview').trigger('click');
            setTimeout(function () {
                $('#view textarea').focus();
                $('#view textarea').select();
            }, 100);
        });
    });
</script>