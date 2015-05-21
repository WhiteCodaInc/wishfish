<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dashboard/css/checkbox.css"/>
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
            <div class="col-md-3"></div>
            <div class="col-md-6">
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
                                            <div class="row">
                                                <div class="col-md-1"></div>
                                                <div class="col-md-10">
                                                    <div class="row well" style="height: auto !important">
                                                        <div class="col-md-6">
                                                            <label>
                                                                <input name="admin" id="admin" class="simple"  type="checkbox" >
                                                                <span class="lbl padding-8">Admin</span>
                                                            </label>
                                                            <br/>
                                                            <label>
                                                                <input name="contacts" id="contacts" class="simple"  type="checkbox" >
                                                                <span class="lbl padding-8">Contacts</span>
                                                            </label>
                                                            <br/>
                                                            <label>
                                                                <input name="affiliates" id="affiliates" class="simple"  type="checkbox" >
                                                                <span class="lbl padding-8">Affiliates</span>
                                                            </label>
                                                            <br/>
                                                            <label>
                                                                <input name="customers" id="customers" class="simple"  type="checkbox" >
                                                                <span class="lbl padding-8">Customers</span>
                                                            </label>
                                                            <br/>
                                                            <label>
                                                                <input name="sms" id="sms" class="simple"  type="checkbox" >
                                                                <span class="lbl padding-8">SMS</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>
                                                                <input name="email" id="email" class="simple"  type="checkbox" >
                                                                <span class="lbl padding-8">Email</span>
                                                            </label>
                                                            <br/>
                                                            <label>
                                                                <input name="cms" id="cms" class="simple"  type="checkbox" >
                                                                <span class="lbl padding-8">CMS</span>
                                                            </label>
                                                            <br/>
                                                            <label>
                                                                <input name="calender" id="calender" class="simple"  type="checkbox" >
                                                                <span class="lbl padding-8">Calender</span>
                                                            </label>
                                                            <br/>
                                                            <label>
                                                                <input name="setting" id="setting" class="simple"  type="checkbox" >
                                                                <span class="lbl padding-8">Setting</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1"></div>
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
            <div class="col-md-3"></div>
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
                    <div class="row">
                        <div class="col-md-7">
                            <label>Admin Access Class</label>
                            <div class="form-group" >
                                <input type="text" id="class_name" name="class_name" class="form-control"   />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <img id="load" src="<?= base_url() ?>assets/dashboard/img/load.GIF" alt="" style="display: none" />
                            <span style="display: none" id="msg"></span>
                        </div>
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
        $('#Update').click(function () {
            $('#permissionForm').submit();
        });
        $('#addClass').click(function () {
            var cname = $('#class_name').val();
            $('#load').css('display', 'block');
            $('#msg').css('display', 'none');
            $.ajax({
                type: 'POST',
                url: "<?= site_url() ?>admin/admin_access/addClass",
                data: {class_name: cname},
                success: function (data, textStatus, jqXHR) {
                    console.log(data);
                    setTimeout(function () {
                        if (data == "1") {
                            $('#msg').html("Successfully Inserted");
                            $('#load').css('display', 'none');
                            $('#msg').css('display', 'block');
                            $('#msg').css('color', 'green');
                            $('#discard').trigger('click');
                            location.reload(true);
                        }
                        else if (data == "0") {
                            $('#loadDept').html("Insertion Failed. Try again..!");
                            $('#load').css('display', 'none');
                            $('#msg').css('display', 'block');
                            $('#msg').css('color', 'red');
                        }
                    }, 1000);
                }
            });
        });

        $('input[type="checkbox"]').change(function () {
            if (!this.checked) {
                $(this).removeAttr('checked');
            }
        });

        $('select#class').change(function () {
            $('input[name="class_id"]').val($(this).val());
            $('input[type="checkbox"]').each(function () {
                $(this).removeAttr('checked');
            });
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

        $('#submit').click(function () {
            if ($('#class').val() == "-1") {
                alertify.error("Please Select Admin Access Class..!");
                return false;
            }
        });
        function setPermission(data) {
            var cnt = 1;
            $.each(data, function (i, item) {
                if (item == 1)
                {
                    //$('.well #' + i).attr('checked', 'checked');
                    $('.well #' + i).trigger('click');
                }
                else
                {
                    $('.well #' + i).removeAttr('checked');
                }
            });
        }
    });
</script>