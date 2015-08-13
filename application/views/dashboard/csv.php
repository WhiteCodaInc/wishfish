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
                                <form id="csv_form" action="<?= site_url() ?>app/csv/importcsv" enctype="multipart/form-data" method="post">
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
                                        <div class="col-md-2">
                                            <a href="<?= FCPATH ?>/example.csv" target="_blank">Download Sample File</a> 
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
                                        <th>Profile</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Birth Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($contacts as $key => $value) { ?>
                                        <?php
                                        $img_src = ($value['contact_avatar'] != "") ?
                                                $value['contact_avatar'] :
                                                base_url() . 'assets/dashboard/img/default-avatar.png';
                                        $image = ($value['contact_avatar'] != "") ? $value['contact_avatar'] : "";
                                        ?>
                                        <tr>
                                            <td>
                                                <div>
                                                    <label>
                                                        <input type="checkbox" name="contact[<?= $key ?>]" value="<?= $key ?>"/>
                                                    </label>
                                                </div>
                                            </td>
                                            <td >
                                                <img style="width:60px;height:60px" src="<?= $img_src ?>" class="img-circle" alt="User Image" />
                                                <input type="hidden" name="contact_avatar[<?= $key ?>]" value="<?= $image ?>" />
                                            </td>
                                            <td>
                                                <?= ($value['fname'] != "") ? $value['fname'] : 'N/A' ?>
                                                <input type="hidden" name="fname[<?= $key ?>]" value="<?= $value['fname'] ?>" />
                                            </td>
                                            <td>
                                                <?= ($value['lname'] != "") ? $value['lname'] : 'N/A' ?>
                                                <input type="hidden" name="lname[<?= $key ?>]" value="<?= $value['lname'] ?>" />
                                            </td>
                                            <td>
                                                <?= ($value['email'] != "") ? $value['email'] : 'N/A' ?>
                                                <input type="hidden" name="email[<?= $key ?>]" value="<?= $value['email'] ?>" />
                                            </td>
                                            <td>
                                                <?= ($value['phone'] != "") ? "+1" . $value['phone'] : 'N/A' ?>
                                                <input type="hidden" name="phone[<?= $key ?>]" value="<?= $value['phone'] ?>" />
                                            </td>
                                            <td>
                                                <?= ($value['birthday'] != "") ? $value['birthday'] : 'N/A' ?>
                                                <input type="hidden" name="birthday[<?= $key ?>]" value="<?= $value['birthday'] ?>" />
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <input type="hidden" id="actionType" name="actionType" value="" />
                        </form>
                    </div><!-- /.box-body -->
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
            $('#csv_form #csv').prop('disabled', true);
            $("#csv_form span.errorMsg").empty();
            $('#csv_form .calert').hide();
        }));


        $('#Add').click(function (e) {
            var act = $(this).val();
            action(act);
        });

        function action(actiontype) {
            $('#actionType').val(actiontype);
            $('#checkForm').attr('action', "<?= site_url() ?>app/csv/addContacts");
            $('#checkForm').submit();
        }
    });

</script>