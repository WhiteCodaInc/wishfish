<style type="text/css">
    .icheckbox_minimal{
        vertical-align: text-bottom;
        margin: 0 5px
    }
    .plabel{
        cursor: pointer
    }
    .well .row{
        margin-bottom: 10px;
        /*border-bottom: 1px solid lightgray;*/
    }
</style>
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="display: none">
            Add New Admin Access Class
        </h1>
        <a style="float: left" class="btn btn-success btn-sm create" data-toggle="modal" data-target="#compose-modal">
            <i class="fa fa-plus"></i> Add Admin Access Class
        </a>
        <div style="float: left;margin-right: 2%">
            <select  name="class_id" id="class" class="form-control" >
                <option value="-1">--Choose Access Class--</option>
                <?php foreach ($class as $value) { ?>
                    <option value="<?= $value->class_id ?>"><?= $value->class_name ?></option>
                <?php } ?>
            </select>
        </div>
        <button class="btn btn-success btn-sm add" id="Update" type="button" >Update</button>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Admin Access Class</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <form id="permissionForm" method="post" action="<?= site_url() ?>admin/admin_access/addPermission">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box box-primary">
                                        <div class="box-header">
                                            <h3 class="box-title">Permission</h3>
                                        </div><!-- /.box-header -->
                                        <div class="box-body">
                                            <div class="row well" style="margin: 10px 5px;">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-3 text-right">
                                                            <label>Contacts</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="col-md-3">
                                                                <input name="coni" id="coni"  type="checkbox" >
                                                                <span class="plabel">Create</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="conu" id="conu"  type="checkbox" >
                                                                <span class="plabel">Update</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="cond" id="cond"  type="checkbox" >
                                                                <span class="plabel">Delete</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 text-right">
                                                            <label>Contact Groups</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="col-md-3">
                                                                <input name="congi" id="congi"  type="checkbox" >
                                                                <span class="plabel">Create</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="congu" id="congu"  type="checkbox" >
                                                                <span class="plabel">Update</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="congd" id="congd"  type="checkbox" >
                                                                <span class="plabel">Delete</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 text-right">
                                                            <label>Contact Block List</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="col-md-3">
                                                                <input name="cbl" id="cbl"  type="checkbox" >
                                                                <span class="plabel">Update</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 text-right">
                                                            <label>Affiliates</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="col-md-3">
                                                                <input name="affi" id="affi"  type="checkbox" >
                                                                <span class="plabel">Create</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="affu" id="affu"  type="checkbox" >
                                                                <span class="plabel">Update</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="affd" id="affd"  type="checkbox" >
                                                                <span class="plabel">Delete</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 text-right">
                                                            <label>Affiliate Groups</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="col-md-3">
                                                                <input name="affgi" id="affgi"  type="checkbox" >
                                                                <span class="plabel">Create</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="affgu" id="affgu"  type="checkbox" >
                                                                <span class="plabel">Update</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="affgd" id="affgd"  type="checkbox" >
                                                                <span class="plabel">Delete</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 text-right">
                                                            <label>Customers</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="col-md-3">
                                                                <input name="cusu" id="cusu"  type="checkbox" >
                                                                <span class="plabel">Update</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="cusd" id="cusd"  type="checkbox" >
                                                                <span class="plabel">Delete</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 text-right">
                                                            <label>Customer Groups</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="col-md-3">
                                                                <input name="cusgi" id="cusgi"  type="checkbox" >
                                                                <span class="plabel">Create</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="cusgu" id="cusgu"  type="checkbox" >
                                                                <span class="plabel">Update</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="cusgd" id="cusgd"  type="checkbox" >
                                                                <span class="plabel">Delete</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 text-right">
                                                            <label>SMS Blast</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="col-md-3">
                                                                <input name="smsb" id="smsb"  type="checkbox" >
                                                                <span class="plabel">SMS Blast</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 text-right">
                                                            <label>SMS List Builder</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="col-md-3">
                                                                <input name="smslbi" id="smslbi"  type="checkbox" >
                                                                <span class="plabel">Create</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="smslbu" id="smslbu"  type="checkbox" >
                                                                <span class="plabel">Update</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="smslbd" id="smslbd"  type="checkbox" >
                                                                <span class="plabel">Delete</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 text-right">
                                                            <label>SMS Template</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="col-md-3">
                                                                <input name="smsti" id="smsti"  type="checkbox" >
                                                                <span class="plabel">Create</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="smstu" id="smstu"  type="checkbox" >
                                                                <span class="plabel">Update</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="smstd" id="smstd"  type="checkbox" >
                                                                <span class="plabel">Delete</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="class_id" value="" />
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->

<!-- NEW ADMIN ACCESS CLASS MODAL -->
<div class="modal fade" id="compose-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 400px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Admin Access Class</h4>
            </div>
            <form id="classForm"  method="post">
                <div class="modal-body">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Admin Access Class</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-7">
                                    <label>Admin Access Class</label>
                                    <div class="form-group" >
                                        <input type="text" id="class_name" name="class_name" class="form-control"   />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <span id="#msg"></span>
                            </div>
                        </div>
                        <div style="display: none" class="overlay"></div>
                        <div style="display: none" class="loading-img"></div>
                    </div>
                </div>
                <div class="modal-footer clearfix">
                    <div class="row">
                        <div class="col-md-3">
                            <button type="button" id="addClass" class="btn btn-primary pull-left">Create Now</button>
                        </div>
                        <div class="col-md-3">
                            <button type="button" id="discard" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Discard</button>
                        </div>
                    </div>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


<?php
$msg = (isset($msg)) ? $msg : 0;
switch ($msg) {
    case "U":
        $m = "Access Permission Successfully Updated..!";
        $t = "success";
        break;
    case "F":
        $m = "Access Permission not Successfully Updated..!";
        $t = "error";
        break;
    default:
        $m = 0;
        break;
}
?>
<script type="text/javascript">
<?php if ($msg): ?>
        alertify.<?= $t ?>("<?= $m ?>");
<?php endif; ?>
</script>

<!-- /.modal -->
<script type="text/javascript">
    $(document).ready(function () {

        $('span.plabel').click(function () {
            if ($(this).prev('.icheckbox_minimal').hasClass('checked')) {
                $(this).prev('.icheckbox_minimal').iCheck('uncheck');
            } else {
                $(this).prev('.icheckbox_minimal').iCheck('check');
            }
        });

        $('#Update').click(function () {
            if ($('#class').val() == "-1") {
                alertify.error("Please Select Admin Access Class..!");
                return false;
            } else {

                $('#permissionForm').submit();
            }
        });
        $('#addClass').click(function () {
            $button = $(this);
            $button.prop('disabled', true)
            var cname = $('#class_name').val();

            if (cname.trim() == '') {
                $('#msg').css('color', 'red');
                $('#msg').html("Enter Valid Class Name..!");
                return false;
            } else {
                $('#msg').empty();
                return false;
            }

            $('#classForm .overlay').show();
            $('#classForm .loading-img').show();
            $.ajax({
                type: 'POST',
                url: "<?= site_url() ?>admin/admin_access/addClass",
                data: {class_name: cname},
                success: function (data, textStatus, jqXHR) {
                    $('#classForm .overlay').hide();
                    $('#classForm .loading-img').hide();
                    $button.prop('disabled', false);
                    if (data == "0") {
                        $('#msg').css('color', 'red');
                        $('#msg').html("Insertion Failed. Try again..!");
                    }
                    else {
                        $('#class_name').val('');
                        $('#class').append('<option value="' + data + '">' + cname + '</option>');
                        $('#class').val(data);
                        alertify.success("Access class successfully created..!");
                        $('#discard').trigger('click');
                    }
                }
            });
        });

//        $('input[type="checkbox"]').change(function () {
//            if (!this.checked) {
//                $(this).removeAttr('checked');
//            }
//        });

        $('select#class').change(function () {
            $('input[name="class_id"]').val($(this).val());
//            $('input[type="checkbox"]').each(function () {
//                $(this).removeAttr('checked');
//            });
            if ($(this).val() == "-1") {
                return false;
            }
            else if ($(this).val() != "-1") {
                var cid = $(this).val();
                $.ajax({
                    type: 'POST',
                    datatype: 'json',
                    url: "<?= site_url() ?>admin/admin_access/permission",
                    data: {'class_id': cid},
                    success: function (json, textStatus, jqXHR) {
                        var data = JSON.parse(json);
                        setPermission(data);
                    }
                });
            }
        });

<?php if (isset($id)): ?>
            $('#class').val("<?= $id ?>");
            $('#class').trigger('change');
<?php endif; ?>


        function setPermission(data) {
            var cnt = 1;
            $.each(data, function (i, item) {
                (item == 1) ?
                        $('.well #' + i).parent('.icheckbox_minimal').iCheck('check') :
                        $('.well #' + i).parent('.icheckbox_minimal').iCheck('uncheck');
            });
        }
    });
</script>