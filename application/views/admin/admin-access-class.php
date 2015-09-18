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
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Admin Access Class</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <form id="permissionForm" method="post">
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
                                                            <label>Admin</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="col-md-12">
                                                                <input name="admin" type="checkbox" >
                                                                <span class="plabel">Admin</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 text-right">
                                                            <label>Calendar</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="col-md-12">
                                                                <input name="cal" type="checkbox" >
                                                                <span class="plabel">Calendar</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 text-right">
                                                            <label>Contacts</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="col-md-3">
                                                                <input name="coni" type="checkbox" >
                                                                <span class="plabel">Create</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="conu" type="checkbox" >
                                                                <span class="plabel">Update</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="cond" type="checkbox" >
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
                                                                <input name="congi" type="checkbox" >
                                                                <span class="plabel">Create</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="congu" type="checkbox" >
                                                                <span class="plabel">Update</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="congd" type="checkbox" >
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
                                                                <input name="cbl" type="checkbox" >
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
                                                                <input name="affi" type="checkbox" >
                                                                <span class="plabel">Create</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="affu" type="checkbox" >
                                                                <span class="plabel">Update</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="affd" type="checkbox" >
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
                                                                <input name="affgi" type="checkbox" >
                                                                <span class="plabel">Create</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="affgu" type="checkbox" >
                                                                <span class="plabel">Update</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="affgd" type="checkbox" >
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
                                                                <input name="cusu" type="checkbox" >
                                                                <span class="plabel">Update</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="cusd" type="checkbox" >
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
                                                                <input name="cusgi" type="checkbox" >
                                                                <span class="plabel">Create</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="cusgu" type="checkbox" >
                                                                <span class="plabel">Update</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="cusgd" type="checkbox" >
                                                                <span class="plabel">Delete</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 text-right">
                                                            <label>SMS Inbox</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="col-md-12">
                                                                <input name="smsi" type="checkbox" >
                                                                <span class="plabel">SMS Inbox</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 text-right">
                                                            <label>SMS Blast</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="col-md-12">
                                                                <input name="smsb" type="checkbox" >
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
                                                                <input name="smslbi" type="checkbox" >
                                                                <span class="plabel">Create</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="smslbu" type="checkbox" >
                                                                <span class="plabel">Update</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="smslbd" type="checkbox" >
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
                                                                <input name="smsti" type="checkbox" >
                                                                <span class="plabel">Create</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="smstu" type="checkbox" >
                                                                <span class="plabel">Update</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="smstd" type="checkbox" >
                                                                <span class="plabel">Delete</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 text-right">
                                                            <label>Email Mailbox</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="col-md-12">
                                                                <input name="emailm" type="checkbox" >
                                                                <span class="plabel">Email Mailbox</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 text-right">
                                                            <label>Email Blast</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="col-md-12">
                                                                <input name="emailb" type="checkbox" >
                                                                <span class="plabel">Email Blast</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 text-right">
                                                            <label>Email List Builder</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="col-md-3">
                                                                <input name="emaillbi" type="checkbox" >
                                                                <span class="plabel">Create</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="emaillbu" type="checkbox" >
                                                                <span class="plabel">Update</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="emaillbd" type="checkbox" >
                                                                <span class="plabel">Delete</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 text-right">
                                                            <label>Email Template</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="col-md-3">
                                                                <input name="emailti" type="checkbox" >
                                                                <span class="plabel">Create</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="emailtu" type="checkbox" >
                                                                <span class="plabel">Update</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="emailtd" type="checkbox" >
                                                                <span class="plabel">Delete</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 text-right">
                                                            <label>Email Notification</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="col-md-12">
                                                                <input name="emailn" type="checkbox" >
                                                                <span class="plabel">Email Notification</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 text-right">
                                                            <label>Email Accounts</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="col-md-3">
                                                                <input name="emailai" type="checkbox" >
                                                                <span class="plabel">Create</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="emailau" type="checkbox" >
                                                                <span class="plabel">Update</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="emailad" type="checkbox" >
                                                                <span class="plabel">Delete</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 text-right">
                                                            <label>SMS Setting</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="col-md-3">
                                                                <input name="smssi" type="checkbox" >
                                                                <span class="plabel">Create</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="smssu" type="checkbox" >
                                                                <span class="plabel">Update</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 text-right">
                                                            <label>Calendar Setting</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="col-md-12">
                                                                <input name="cals" type="checkbox" >
                                                                <span class="plabel">Calendar Setting</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 text-right">
                                                            <label>Payment Setting</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="col-md-3">
                                                                <input name="pays" type="checkbox" >
                                                                <span class="plabel">Calendar Setting</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 text-right">
                                                            <label>FAQ's</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="col-md-3">
                                                                <input name="faqi" type="checkbox" >
                                                                <span class="plabel">Create</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="faqu" type="checkbox" >
                                                                <span class="plabel">Update</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="faqd" type="checkbox" >
                                                                <span class="plabel">Delete</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 text-right">
                                                            <label>FAQ Category</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="col-md-3">
                                                                <input name="faqci" type="checkbox" >
                                                                <span class="plabel">Create</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="faqcu" type="checkbox" >
                                                                <span class="plabel">Update</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="faqcd" type="checkbox" >
                                                                <span class="plabel">Delete</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 text-right">
                                                            <label>Web Pages</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="col-md-12">
                                                                <input name="webp" type="checkbox" >
                                                                <span class="plabel">Webpages</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 text-right">
                                                            <label>Homepage Section</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="col-md-12">
                                                                <input name="webp" type="checkbox" >
                                                                <span class="plabel">Homepage Section</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 text-right">
                                                            <label>Feedback</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="col-md-12">
                                                                <input name="webp" type="checkbox" >
                                                                <span class="plabel">Feedback</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 text-right">
                                                            <label>Coupon</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="col-md-3">
                                                                <input name="coui" type="checkbox" >
                                                                <span class="plabel">Create</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="couu" type="checkbox" >
                                                                <span class="plabel">Update</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="coud" type="checkbox" >
                                                                <span class="plabel">Delete</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 text-right">
                                                            <label>Analytics</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="col-md-3">
                                                                <input name="totalp" type="checkbox" >
                                                                <span class="plabel">Total Payment</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="totalu" type="checkbox" >
                                                                <span class="plabel">Total Users</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="totalnu" type="checkbox" >
                                                                <span class="plabel">Total New Users</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="admr" type="checkbox" >
                                                                <span class="plabel">Admin Reports</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 text-right">
                                                            <label>Product Builder</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="col-md-3">
                                                                <input name="probi" type="checkbox" >
                                                                <span class="plabel">Create</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="probu" type="checkbox" >
                                                                <span class="plabel">Update</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="probd" type="checkbox" >
                                                                <span class="plabel">Delete</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 text-right">
                                                            <label>Payment Plan Builder</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="col-md-3">
                                                                <input name="paypi" type="checkbox" >
                                                                <span class="plabel">Create</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="paypu" type="checkbox" >
                                                                <span class="plabel">Update</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="paypd" type="checkbox" >
                                                                <span class="plabel">Delete</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 text-right">
                                                            <label>Offer Builder</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="col-md-3">
                                                                <input name="offi" type="checkbox" >
                                                                <span class="plabel">Create</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="offu" type="checkbox" >
                                                                <span class="plabel">Update</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="offd" type="checkbox" >
                                                                <span class="plabel">Delete</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 text-right">
                                                            <label>Page Builder</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="col-md-12">
                                                                <input name="pageb" type="checkbox" >
                                                                <span class="plabel">Page Builder</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 text-right">
                                                            <label>Media Libraries</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="col-md-3">
                                                                <input name="medi" type="checkbox" >
                                                                <span class="plabel">Create</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="medu" type="checkbox" >
                                                                <span class="plabel">Update</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="medd" type="checkbox" >
                                                                <span class="plabel">Delete</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 text-right">
                                                            <label>Funnel Email List</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="col-md-3">
                                                                <input name="funi" type="checkbox" >
                                                                <span class="plabel">Create</span>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input name="funv" type="checkbox" >
                                                                <span class="plabel">View</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="display: none" class="overlay"></div>
                                        <div style="display: none" class="loading-img"></div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="class_id" value="" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->

<!-- NEW ADMIN ACCESS CLASS MODAL -->
<div class="modal fade" id="compose-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 400px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
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
                                <span id="msg"></span>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <button type="button" id="addClass" class="btn btn-primary pull-left">Create Now</button>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" id="discard" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Discard</button>
                                </div>
                            </div>
                        </div>
                        <div style="display: none" class="overlay"></div>
                        <div style="display: none" class="loading-img"></div>
                    </div>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


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
            $button = $(this);
            $button.prop('disabled', true);

            if ($('#class').val() == "-1") {
                alertify.error("Please Select Admin Access Class..!");
                return false;
            }
            $('#permissionForm .overlay').show();
            $('#permissionForm .loading-img').show();
            $.ajax({
                type: 'POST',
                url: "<?= site_url() ?>admin/admin_access/addPermission",
                data: $('#permissionForm').serialize(),
                success: function (data, textStatus, jqXHR) {
                    $('#permissionForm .overlay').hide();
                    $('#permissionForm .loading-img').hide();
                    $button.prop('disabled', false);
                    (data == "0") ?
                            alertify.error("Access class not successfully updated..!") :
                            alertify.success("Access class successfully updated..!");
                }
            });
        });

        $('#addClass').click(function () {
            var cname = $('#class_name').val();
            if (cname.trim() == '') {
                $('#msg').css('color', 'red');
                $('#msg').html("Enter Valid Class Name..!");
                return false;
            } else {
                $('#msg').empty();
            }

            $button = $(this);
            $button.prop('disabled', true);

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

        $('select#class').change(function () {
            $('input[name="class_id"]').val($(this).val());

            if ($(this).val() == "-1") {
                $('.icheckbox_minimal').each(function () {
                    $(this).iCheck('uncheck');
                });
                return false;
            }
            else if ($(this).val() != "-1") {
                $('#permissionForm .overlay').show();
                $('#permissionForm .loading-img').show();
                var cid = $(this).val();
                $.ajax({
                    type: 'POST',
                    datatype: 'json',
                    url: "<?= site_url() ?>admin/admin_access/permission",
                    data: {'class_id': cid},
                    success: function (json, textStatus, jqXHR) {
                        $('#permissionForm .overlay').hide();
                        $('#permissionForm .loading-img').hide();
                        var data = JSON.parse(json);
                        setPermission(data);
                    }
                });
            }
        });

        function setPermission(data) {
            var cnt = 1;
            $.each(data, function (i, item) {
                (item == 1) ?
                        $('.well input[name="' + i + '"]').parent('.icheckbox_minimal').iCheck('check') :
                        $('.well input[name="' + i + '"]').parent('.icheckbox_minimal').iCheck('uncheck');
            });
        }
    });
</script>