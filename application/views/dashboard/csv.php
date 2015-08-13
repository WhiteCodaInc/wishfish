<style type="text/css">
    #csv-data-table tr td,#csv-data-table tr th{
        text-align: center;
    }
    .dataTables_wrapper > div.row:first-child{
        display: none
    }
</style>
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="float: left">
            CSV Contacts
        </h1>
        <button style="margin-left: 10px" value="Add" class="btn btn-success" id="Add" type="button" >Add Selected Contacts</button>
        <div class="search" style="float:right;width: 25%">
            <select id="page_length" class="form-control" style="float: left;width: 30%">
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="200">200</option>
                <option value="-1" selected="">All</option>
            </select>
            <input class="form-control" type="text" id="searchbox" placeholder="Search" style="float: left;width: 70%">
        </div>   
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary csv-contact" >
                    <div class="box-body table-responsive" id="data-panel">
                        <div class="row">
                            <div class="col-xs-12"  style="margin: 2% 0;">
                                <form id="csv_form" enctype="multipart/form-data" method="post">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <input name="upload"  type="file" class="form-control" />
                                        </div>
                                        <div class="col-md-1">
                                            <button class="btn btn-success" type="submit" id="csv">Upload</button>
                                        </div>
                                        <div class="col-md-5">
                                            <div style="display: none;margin-top: 10px;" class="calert">
                                                <span style="color: red" class="errorMsg"></span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <form name="checkForm" id="checkForm" action="" method="post">
                            <table id="csv-data-table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="padding: 10px;">
                                            <input type="checkbox"/>
                                        </th>
                                        <th>Contact Name</th>
                                        <th>Contact Email</th>
                                        <th>Contact Phone Number</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th>Contact Name</th>
                                        <th>Contact Email</th>
                                        <th>Contact Phone Number</th>
                                    </tr>
                                </tfoot>
                            </table>
                            <input type="hidden" id="actionType" name="actionType" value="" />
                        </form>
                    </div><!-- /.box-body -->
                    <div class="overlay" style="display: none"></div>
                    <div class="loading-img" style="display: none"></div>
                </div><!-- /.box -->
            </div>
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<style type="text/css">
    .dataTables_filter {
        display: none;
    }
</style>
<!-- DATA TABES SCRIPT -->
<script src="<?= base_url() ?>assets/dashboard/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/dashboard/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

<!-- page script -->
<script type="text/javascript">
    $(function () {
//        $("#contact-data-table").dataTable();
        oTable = $("#csv-data-table").dataTable({
            aLengthMenu: [
                [25, 50, 100, 200, -1],
                [25, 50, 100, 200, "All"]
            ],
            aoColumnDefs: [{
                    bSortable: false,
                    aTargets: [0, 2, 3]
                }],
            iDisplayLength: -1,
            aaSorting: [[1, 'asc']]
        });
        $("#searchbox").on("keyup search input paste cut", function () {
            oTable.fnFilter(this.value);
        });
        $('#page_length').change(function () {
            var length = parseInt($(this).val());
            console.log(length);
            var oSettings = oTable.fnSettings();
            oSettings._iDisplayLength = length;
            oTable.fnPageChange("first");
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        var isValid = true;
        $("#csv_form input:file").change(function () {
            $("#csv_form span.errorMsg").empty(); // To remove the previous error message
            var file = this.files[0];
            if (file.type != "application/vnd.ms-excel")
            {
                $('#csv_form .calert').show();
                $('#csv_form span.errorMsg').html("Please Select a valid Image File! Only csv type allowed.");
                isValid = false;
                return false;
            }
            else
            {
                $("#csv_form span.errorMsg").empty();
                $('#csv_form .calert').hide();
                var reader = new FileReader();
                reader.readAsDataURL(this.files[0]);
                isValid = true;
            }
        });

        $('#csv_form').on('submit', (function (e) {
            if (!isValid)
                return false;
            e.preventDefault();
            $('#csv_form #csv').prop('disabled', true);
            $("#csv_form span.errorMsg").empty();
            $('#csv_form .calert').hide();

            $('.csv-contact .overlay').show();
            $('.csv-contact .loading-img').show();
            $.ajax({
                url: "<?= site_url() ?>app/csv/importcsv",
                type: "POST",
                data: new FormData(this), // Data sent to server, a set of key/value pairs representing form fields and values 
                contentType: false, // The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
                cache: false, // To unable request pages to be cached
                processData: false, // To send DOMDocument or non processed data file it is set to false (i.e. data should not be in the form of string)
                success: function (data) {
                    $('.csv-contact .overlay').hide();
                    $('.csv-contact .loading-img').hide();
                    $('#csv_form #csv').prop('disabled', false);
                    if (data == "0") {
                        $('#csv_form span.errorMsg').html("Faild to upload CSV File..!Try Again..!");
                        $('#csv_form .calert').show();
                    } else {
                        alert();
                        $('#csv-data-table table tbody').html(data);
                    }
                }
            });
            return false;
        }));


        $('#Add').click(function (e) {
            var act = $(this).val();
            action(act);
        });

        function action(actiontype) {
            $('#actionType').val(actiontype);
            $('#checkForm').attr('action', "<?= site_url() ?>app/import/addContacts");
            $('#checkForm').submit();
        }
    });

</script>