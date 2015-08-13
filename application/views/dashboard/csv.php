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
                <div class="box" >
                    <div class="box-header">
                        <h3 class="box-title">CSV Contact Detail</h3>
                    </div><!-- /.box-header -->
                    <div class="row">
                        <div class="col-xs-12" style="margin-left: 1%">
                            <form id="csvForm" enctype="multipart/form-data" method="post">
                                <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-3">
                                        <input name="upload"  type="file" class="form-control" />
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-success" type="submit" id="csv">Upload</button>
                                    </div>
                                    <div class="col-md-5">
                                        <div style="display: none;margin-top: 10px;" class="calert">
                                            <span class="errorMsg"></span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <form name="checkForm" id="checkForm" action="" method="post">
                        <div class="box-body table-responsive" id="data-panel">
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
                                    <?php foreach ($contacts as $key => $value) { ?>
                                        <tr>
                                            <td>
                                                <div>
                                                    <label>
                                                        <input type="checkbox" name="contact[<?= $key ?>]" value="<?= $key ?>"/>
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <?= ($value['name'] != "") ? $value['name'] : 'N/A' ?>
                                                <input type="hidden" name="name[<?= $key ?>]" value="<?= $value['name'] ?>" />
                                            </td>
                                            <td>
                                                <?= ($value['email'] != "") ? $value['email'] : 'N/A' ?>
                                                <input type="hidden" name="email[<?= $key ?>]" value="<?= $value['email'] ?>" />
                                            </td>
                                            <td>
                                                <?= ($value['phone'] != "") ? $value['phone'] : 'N/A' ?>
                                                <input type="hidden" name="phone[<?= $key ?>]" value="<?= $value['phone'] ?>" />
                                            </td>
                                        </tr>
                                    <?php } ?>
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
                        </div><!-- /.box-body -->
                        <div class="overlay" style="display: none"></div>
                        <div class="loading-img" style="display: none"></div>
                    </form>
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
        $("#csvForm input:file").change(function () {
            $("#csvForm span.errorMsg").empty(); // To remove the previous error message
            var file = this.files[0];
            console.log(file.type);
            if (file.type != "application/vnd.ms-excel")
            {
                console.log("Faild");
                $('#csvForm .calert').show();
                $('#csvForm span.errorMsg').css('color', 'red');
                $('#csvForm span.errorMsg').html("Please Select A valid Image File! Only csv type allowed.");
                isValid = false;
                return false;
            }
            else
            {
                console.log("SUCCESS");
                $("#csvForm span.errorMsg").empty();
                $('#csvForm .calert').hide();
                var reader = new FileReader();
                reader.readAsDataURL(this.files[0]);
                isValid = true;
            }
        });

        $('#csvForm').on('submit', (function (e) {
            if (!isValid)
                return false;
            e.preventDefault();
            $('#csv').prop('disabled', true);
            $("#csvForm span.errorMsg").empty();
            $('#csvForm .calert').hide();

            $('#checkForm .overlay').show();
            $('#checkForm .loading-img').show();

            $.ajax({
                url: "<?= site_url() ?>app/scrape/importcsv",
                type: "POST",
                data: new FormData(this), // Data sent to server, a set of key/value pairs representing form fields and values 
                contentType: false, // The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
                cache: false, // To unable request pages to be cached
                processData: false, // To send DOMDocument or non processed data file it is set to false (i.e. data should not be in the form of string)
                success: function (data) {
                    $('#checkForm .overlay').hide();
                    $('#checkForm .loading-img').hide();
                    if (data == "1") {
                        $('#csvForm .calert').show();
                        $('#csvForm span.errorMsg').css('color', 'green');
                        $('#csvForm span.errorMsg').html("CSV File Successfully Imported..!");
                        setTimeout(function () {
                            $('#csvForm .close').trigger('click');
                        }, 1000);
                    } else {
                        $('#csv').prop('disabled', false);
                        $('#csvForm .calert').show();
                        $('#csvForm span.errorMsg').css('color', 'red');
                        $('#csvForm span.errorMsg').html(data);
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