<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit Email Template
        </h1>

    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">
                            <?= $template->mail_type ?>
                        </h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="<?= site_url() ?>admin/email_notification/update" method="post">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label >From</label>
                                        <input value="<?= $template->from ?>" type="text" autofocus="autofocus" name="from" class="form-control" placeholder="From" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input value="<?= $template->name ?>" type="text" name="name" class="form-control" placeholder="Name" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Header</label>
                                        <input value="<?= $template->header ?>" type="text" name="header" class="form-control" placeholder="Header" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label >Trigger By</label>
                                        <input value="<?= $template->trigger_by ?>" type="text" name="trigger_by" class="form-control" placeholder="Trigger By" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Subject</label>
                                        <input value="<?= $template->mail_subject ?>" type="text" name="mail_subject" class="form-control" placeholder="Subject" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Color</label>
                                        <select id="color" name="color" class="form-control m-bot15">
                                            <option value="#235daa">Blue</option> 
                                            <option value="#45c29d">Green</option> 
                                            <option value="#424242">DarkGrey</option> 
                                            <option value="#52586a">DarkTeal</option>   
                                            <option value="#f6ba78">LightYello</option>                                
                                            <option value="#d5171d">LightRed</option>                                
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2" style="margin-top: 25px;">										
                                    <a id="preview" href="#myModal" data-toggle="modal" class="btn btn-success">Preview</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class='row'>
                                            <div class='col-md-9'>
                                                <div class='box box-info'>
                                                    <div class='box-header'>
                                                        <h3 class='box-title'>Editor</h3>
                                                    </div><!-- /.box-header -->
                                                    <div class='box-body pad'>
                                                        <textarea id="editor1" name="mail_content" rows="10" cols="80"><?= $template->mail_content ?></textarea>
                                                    </div>
                                                </div><!-- /.box -->
                                            </div>
                                            <div class="col-md-3">
                                                <!-- Default box -->
                                                <div class="box collapsed-box">
                                                    <div class="box-header">
                                                        <h3 class="box-title">Token List</h3>
                                                        <div class="box-tools pull-right">
                                                            <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="box-body" style="display: none">
                                                        <?= (isset($template->short_code)) ? $template->short_code : '' ?>
                                                    </div><!-- /.box-body -->
                                                </div><!-- /.box -->
                                            </div>
                                        </div><!-- /.box-body -->
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
                                <div class="row">
                                    <div class="col-md-2">
                                        <button type="submit"  class="btn btn-warning">
                                            <?php //echo isset($template) ? 'Update' : 'Save' ?>Update
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php //if (isset($template)): ?>
                        <input type="hidden" name="mailid" value="<?= $template->mail_id ?>" />
                        <?php //endif; ?>
                    </form>
                </div><!-- /.box -->
            </div><!--/.col (left) -->
            <!-- right column -->
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h4 class="modal-title">Email Template Preview</h4>
            </div>
            <div class="modal-body">
                <table id="emailBody" width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 0;margin-left: 0;margin-right: 0;margin-bottom: 0;padding-top: 0;padding-bottom: 0;padding-left: 0;padding-right: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0;height: auto;width: 100%;background-color: #ebebeb;">
                    <tr>
                        <td align="center" valign="top" class="emailBodyCell" style="margin-top: 0;margin-left: 0;margin-right: 0;margin-bottom: 0;padding-top: 32px;padding-bottom: 32px;padding-left: 16px;padding-right: 16px;border-collapse: collapse;border-spacing: 0;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;height: 100%;width: 100%;background-color: #ebebeb;">
                            <table width="544" border="0" cellpadding="0" cellspacing="0" class="eBox" style="margin-top: 0;margin-left: auto;margin-right: auto;margin-bottom: 0;padding-top: 0;padding-bottom: 0;padding-left: 0;padding-right: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0;width: 544px;">
                                <tr>
                                    <td class="eHeader bg-color" style="margin-top: 0;margin-left: 0;margin-right: 0;margin-bottom: 0;padding-left: 12px;padding-right: 12px;border-collapse: collapse;border-spacing: 0;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;width: 512px;background-color: #235daa;">
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top: 0;margin-left: 0;margin-right: 0;margin-bottom: 0;padding-top: 0;padding-bottom: 0;padding-left: 0;padding-right: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0;">
                                            <tr>
                                                <td class="eHeaderLogo" style="margin-top: 0;margin-left: 0;margin-right: 0;margin-bottom: 0;padding-top: 0;padding-bottom: 0;padding-left: 0;padding-right: 0;border-collapse: collapse;border-spacing: 0;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;height: 48px;text-align: left;font-weight: bold;color: #ffffff;">
                                                    <h1><?= $template->header ?></h1>
                                                </td>
                                                <!-- end .eHeaderLogo-->
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="eBody alignCenter pdTp32" style="margin-top: 0;margin-left: 0;margin-right: 0;margin-bottom: 0;padding-top: 32px;padding-bottom: 0;padding-left: 16px;padding-right: 16px;border-collapse: collapse;border-spacing: 0;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;text-align: center;width: 512px;color: #54565c;background-color: #ffffff;">
                                        <p style="margin-top: 0;margin-left: 0;margin-right: 0;margin-bottom: 24px;padding-top: 0;padding-bottom: 0;padding-left: 0;padding-right: 0;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;text-align: center;font-size: 14px;line-height: 22px;">
                                            <?= (isset($template->mail_content)) ? $template->mail_content : '' ?>
                                        <table border="0" align="center" cellpadding="0" cellspacing="0" class="mainBtn" style="margin-top: 0;margin-left: auto;margin-right: auto;margin-bottom: 0;padding-top: 0;padding-bottom: 0;padding-left: 0;padding-right: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0;">
                                            <tr>
                                                <td align="center" valign="middle" class="btnMain bg-color" style="margin-top: 0;margin-left: 0;margin-right: 0;margin-bottom: 0;padding-top: 12px;padding-bottom: 12px;padding-left: 22px;padding-right: 22px;border-collapse: collapse;border-spacing: 0;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;background-color: #7fbe56;height: 20px;font-size: 18px;line-height: 20px;mso-line-height-rule: exactly;text-align: center;vertical-align: middle;">
                                                    <a href="#" style="padding-top: 0;padding-bottom: 0;padding-left: 0;padding-right: 0;display: inline-block;text-decoration: none;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;color: #ffffff;font-weight: bold;">
                                                        <span style="text-decoration: none;color: #ffffff;">
                                                            Activate your Account
                                                        </span>
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                        </p>
                                    </td>
                                    <!-- end .eBody--> 
                                </tr>
                                <tr>
                                    <td class="bottomCorners" style="margin-top: 0;margin-left: 0;margin-right: 0;margin-bottom: 0;padding-top: 0;padding-bottom: 0;padding-left: 0;padding-right: 0;border-collapse: collapse;border-spacing: 0;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;width: 544px;height: 16px;background-color: #ffffff;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class="eFooter" style="margin-top: 0;margin-left: 0;margin-right: 0;margin-bottom: 0;padding-top: 14px;padding-bottom: 0;padding-left: 0;padding-right: 0;border-collapse: collapse;border-spacing: 0;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;text-align: center;font-size: 12px;line-height: 21px;width: 544px;color: #b2b2b2;">
                                        <strong>Copyright © 2015 White Coda Inc.</strong> All rights reserved. <br>
                                        <a href="#" class="highFix" style="padding-top: 0;padding-bottom: 0;padding-left: 0;padding-right: 0;display: inline-block;text-decoration: none;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;color: #b2b2b2;cursor: pointer;">
                                            <span style="text-decoration: none;color: #b2b2b2;cursor: pointer;">
                                                4170 Haymond St. • Mcdermitt • PA 18503 USA
                                            </span>
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            <!-- end .eBox -->
                        </td>
                        <!-- end .emailBodyCell --> 
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- CK Editor -->
<!--<script src="//cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>-->
<script src="<?= base_url() ?>assets/dashboard/js/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?= base_url() ?>assets/dashboard/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>

<script type="text/javascript">
    $(function () {
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace('editor1');
        //bootstrap WYSIHTML5 - text editor
        $(".textarea").wysihtml5();
    });
</script>
<script>
    $(document).ready(function () {
        $('#preview').click(function () {
            $('.bg-color').css('background-color', $('#color').val());
            $('.f-color').css('color', $('#color').val());
        });
    });
</script>
<script type="text/javascript">
<?php if (isset($template)) { ?>
        $('#color option').each(function () {
            if ($(this).val() == "<?= $template->color ?>") {
                $(this).attr('selected', 'selected');
            }
            else {
                $(this).removeAttr('selected');
            }
<?php } ?>
    });
</script>
