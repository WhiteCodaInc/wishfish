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


<!-- NEW EVENT MODAL -->
<div class="modal fade" id="preview-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <div class="row m-bot15">                        
                    <div id="view" class="col-md-12" style="text-align: center">

                    </div>
                </div>
                <div class="modal-footer clearfix">
                    <button type="button" id="n_discard" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Discard</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</div>


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

            $img = $('tr#' + offerid).find('img');
            $img.removeAttr('style');
            $('#view').html("<textarea class='form-control'></textarea>");
            $('#view textarea').text("<img alt='" + $img.attr('alt') + "' src='" + $img.attr('src') + "' />");
            $('#preview-modal').modal('show');
            setTimeout(function () {
                $('#view textarea').focus();
                $('#view textarea').select();
            }, 500);
        });

        $('button.link').click(function () {
            var offerid = $(this).parents('tr').attr('id');
            console.log(offerid);
            var name = $('tr#' + offerid).find('td.name').text();
            console.log(name);
            $('.modal-title').text(name);
            $('#view').html("<textarea class='form-control'></textarea>");
            $('#view textarea').text("<?= site_url() ?>?offer=" + offerid);
            $('#preview-modal').modal('show');
            setTimeout(function () {
                $('#view textarea').focus();
                $('#view textarea').select();
            }, 500);
        });
    });
</script>