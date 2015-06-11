<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dashboard/autocomplete/jquery-ui.css"/>
<!-- Normal Checkbox -->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dashboard/css/checkbox.css"/>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dashboard/js/plugins/Qtip/css/jquery.qtip.css"/>
<style>
    .ui-autocomplete { 
        cursor:pointer; 
        height:120px; 
        overflow-y:scroll;
        z-index: 9999
    } 
    /*    #color-chooser > li > a:hover{
            background-color: gainsboro
        }*/
    .dl-horizontal dd {
        margin-left: 100px;
    }
    .dl-horizontal dt {
        width: 88px
    }
    #calendar table tbody tr td{
        cursor: pointer
    }
    /*    .fc-event:hover{
            cursor: pointer
        }
        .fc-day-number:hover{
            cursor: pointer
        }*/
    .fc-widget-content:hover{
        border: 1px solid darkturquoise;
    }
</style>
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header" style="z-index: 999">
        <h1 style="float: left">
            Calendar
            <small>Control panel</small>
        </h1>
        <button disabled="" style="margin-left: 2%"  class="btn btn-success btn-sm create" id="popup" data-toggle="modal" data-target="#compose-modal">
            <i class="fa fa-plus"></i>
            Create New Event
        </button>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body no-padding">
                        <!-- THE CALENDAR -->
                        <div id="calendar"></div>
                    </div><!-- /.box-body -->
                </div><!-- /. box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</aside><!-- /.right-side -->

<span style="display: none" id="event_desc" data-toggle="modal" data-target="#event-description"></span>
<span style="display: none" id="create_event" data-toggle="modal" data-target="#new-event"></span>

<!-- NEW EVENT MODAL -->
<div class="modal fade" id="new-event" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button style="margin: -20px;opacity: 1;border-radius: 100%;" type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <img src="<?= base_url() ?>assets/dashboard/img/close.png" width="20px" alt="close" style="" />
                </button>
                <h4 class="modal-title"><i class="fa fa-envelope-o"></i> Schedule SMS/Email For <label><?= $contactInfo->fname . ' ' . $contactInfo->lname ?></label></h4>
            </div>
            <form id="neweventForm"  method="post">
                <div class="modal-body">

                    <div class="row m-bot15">                        
                        <div class="col-md-12">	
                            <div class="form-group">
                                <div  style="float: left;padding:0 5px;cursor: pointer">
                                    <input id="n_rd_notification" type="radio" value="notification"  name="event_type" checked="" class="simple">                          
                                    <span class="lbl padding-8">No Notification&nbsp;</span>
                                </div>
                                <div  style="float: left;padding-right: 5px;cursor: pointer">
                                    <input id="n_rd_sms" type="radio" value="sms"  name="event_type"  class="simple">                          
                                    <span class="lbl padding-8">Schedule SMS&nbsp;</span>
                                </div>
                                <div style="float: left;padding:0 5px;cursor: pointer">
                                    <input id="n_rd_email" type="radio" value="email"  name="event_type" class="simple">                          
                                    <span class="lbl padding-8">Schedule Email&nbsp;</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div class="row m-bot15">                        
                        <div class="col-md-12">	
                            <div class="form-group">
                                <div  style="float: left;padding:0 5px;cursor: pointer">
                                    <input type="radio" value="them"  name="notify" checked="" class="simple">                          
                                    <span class="lbl padding-8">Notify Them&nbsp;</span>
                                </div>
                                <div  style="float: left;padding-right: 5px;cursor: pointer">
                                    <input type="radio" value="me"  name="notify"  class="simple">                          
                                    <span class="lbl padding-8">Notify Me&nbsp;</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Select Date</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input name="date" value="<?= (isset($flag) && $flag) ? date('d-m-Y', strtotime($contactInfo->birthday)) : '' ?>"  class="form-control form-control-inline input-medium default-date-picker" size="16" type="text">
                                </div><!-- /.input group -->
                            </div><!-- /.form group -->
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-md-5">
                            <label>Event Name</label>
                            <div class="form-group" >
                                <input type="text" name="event" class="form-control"   />
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Choose Template</label>
                                <select name="template_id" id="n_template" class="form-control" >
                                    <option value="-1">--Select--</option>
                                    <?php foreach ($template as $value) { ?>
                                        <option value="<?= $value->template_id ?>"><?= $value->title ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="n_subject" class="row" style="display: none">
                        <div class="col-md-5">
                            <label>Subject</label>
                            <div class="form-group" >
                                <input type="text" name="subject" class="form-control"  />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div id="n_sms_block" class="col-md-9">
                            <div class="form-group">
                                <div class='row'>
                                    <div class='col-md-12'>
                                        <div class='box box-info'>
                                            <div class='box-header'>
                                                <h3 class='box-title'>Editor</h3>
                                            </div><!-- /.box-header -->
                                            <div class='box-body pad'>
                                                <textarea id="n_smsbody" rows="7" class="form-control"  name="smsbody"></textarea>
                                            </div>
                                        </div><!-- /.box -->
                                    </div>
                                </div><!-- /.box-body -->
                            </div>
                        </div>
                        <div id="n_email_block" class="col-md-9" style="display: none">
                            <div class="form-group">
                                <div class='row'>
                                    <div class='col-md-12'>
                                        <div class='box box-info'>
                                            <div class='box-header'>
                                                <h3 class='box-title'>Editor</h3>
                                            </div><!-- /.box-header -->
                                            <div class='box-body pad '>
                                                <textarea id="n_emailbody" rows="10" class="form-control"  name="emailbody" ></textarea>
                                            </div>
                                        </div><!-- /.box -->
                                    </div>
                                </div><!-- /.box-body -->
                            </div>
                        </div>
                        <div class="col-md-3">
                            <!-- Default box -->
                            <div class="box collapsed-box">
                                <div class="box-header" data-widget="collapse" style="cursor: pointer">
                                    <h3 class="box-title" style="cursor: pointer">Token List</h3>
                                    <div class="box-tools pull-right">
                                    </div>
                                </div>
                                <div class="box-body" style="display: none">
                                    <strong>{FIRST_NAME}</strong><br/>
                                    <strong>{LAST_NAME}</strong><br/>
                                    <strong>{EMAIL}</strong><br/>
                                    <strong>{PHONE}</strong><br/>
                                    <!--<strong>{GROUP}</strong><br/>-->
                                    <strong>{BIRTHDAY}</strong><br/>
                                    <strong>{ZODIAC}</strong><br/>
                                    <strong>{AGE}</strong><br/>
                                    <strong>{BIRTHDAY_ALERT}</strong><br/>
                                    <strong>{SOCIAL}</strong><br/>
                                    <strong>{CONTACT}</strong><br/>
                                    <strong>{COUNTRY}</strong><br/>
                                    <strong>{CITY}</strong><br/>
                                    <strong>{ADDRESS}</strong><br/>
                                    <strong>{RATING}</strong><br/>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!-- /.col -->
                    </div>
                    <!-- time Picker -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="bootstrap-timepicker">
                                <div class="form-group">
                                    <label>Time picker:</label>
                                    <div class="input-group">
                                        <input name="time" type="text" value=" " class="form-control timepicker" />
                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                    </div><!-- /.input group -->
                                </div><!-- /.form group -->
                            </div>
                        </div>
                    </div>
                    <div id="n_check_block" class="row">
                        <div class="col-md-12">
                            <input id="n_is_repeat"  type="checkbox" class="simple"  name="is_repeat" >
                            <span class="lbl padding-8 set_repeat">Set Repeat</span>
                        </div>
                    </div>
                    <br/>
                    <div id="n_repeat_block" class="row" style="display: none">
                        <div class="col-md-9">
                            <div class="box box-solid box-primary">
                                <div class="box-header" data-widget="collapse">
                                    <h3 class="box-title" style="cursor: pointer">Repeat Schedule</h3>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Repeats<span style="color: red">*</span></label>
                                            <div class="form-group">
                                                <select name="freq_type" id="n_freq_type" class="form-control" >
                                                    <option value="-1">Select</option>
                                                    <option value="days">DAILY</option>
                                                    <option value="weeks">WEEKLY</option>
                                                    <option value="months">MONTHLY</option>
                                                    <option value="years">YEARLY</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Repeat Every <span id="n_txt_freq_type">Days</span><span style="color: red">*</span></label>
                                            <div class="form-group">
                                                <select name="freq_no" id="n_freq_no" class="form-control" >
                                                    <option value="-1">Select</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <label>Ends</label>
                                            <div class="form-group" >
                                                <div  style="float: left;padding:7px 5px;cursor: pointer">
                                                    <input  type="radio" value="never"  name="end_type" checked="" class="simple">                          
                                                    <span class="lbl padding-8">Never&nbsp;</span>
                                                </div>
                                                <div  style="float: left;padding:7px 5px;cursor: pointer">
                                                    <input  type="radio" value="after"  name="end_type"  class="simple">
                                                    <span class="lbl padding-8">After&nbsp;</span>
                                                </div>
                                                <div id="n_end_block" style="display: none" >
                                                    <div style="float: left;padding-right: 5px;cursor: pointer;">
                                                        <input value="0" type="text" name="occurance" class="form-control"   /> 
                                                    </div>
                                                    <div  style="float: left;padding:7px 5px;cursor: pointer">
                                                        Occurances
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
                </div>
                <?php
                if (isset($contactInfo->profile_id)) {
                    $userid = $contactInfo->profile_id;
                    $user = 1;
                }
                if (isset($contactInfo->contact_id)) {
                    $userid = $contactInfo->contact_id;
                    $user = 2;
                }
                if (isset($contactInfo->affiliate_id)) {
                    $userid = $contactInfo->affiliate_id;
                    $user = 3;
                }
                if (isset($contactInfo->customer_id)) {
                    $userid = $contactInfo->customer_id;
                    $user = 4;
                }
                ?>
                <div class="modal-footer clearfix">
                    <button type="button" id="n_discard" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Discard</button>
                    <button type="button" id="n_insert" class="btn btn-primary pull-left"><i class="fa fa-envelope"></i> Schedule Now</button>
<!--                    <input type="hidden" name="color" value="#f4543c" />-->
                    <input type="hidden" name="assign" value="all_c" />
                    <input type="hidden" name="contactid" value="<?= isset($contactInfo) ? $contactInfo->contact_id : '' ?>" />
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- EVENT DESCRIPTION MODAL -->
<div class="modal fade" id="event-description" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button style="margin: -20px;opacity: 1;border-radius: 100%;" type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <img src="<?= base_url() ?>assets/dashboard/img/close.png" width="20px" alt="close" style="" />
                </button>
                <h4 class="modal-title">
                    <a href="#" id="e_user_img">
                        <img  src="" class="img-circle" alt="User Image" style="width: 45px;height: 45px" />
                    </a>
                    <div id="event_status" style="margin-left: 60px;padding-left: 10px;display: none" class="alert alert-info alert-dismissable">
                        This event will send <b><span class="e_user_name"></span></b> a <span id="e_event_type"></span> on <span class="e_event_time"></span>
                    </div>
                    <div id="event_empty" style="margin-left: 60px;padding-left: 10px;display: none" class="alert alert-info alert-dismissable">
                        This event is turned off, to turn on please select a notification type.
                    </div>
                </h4>
            </div>
            <form id="editForm"  method="post">
                <div class="modal-body">
                    <div class="row m-bot15" id="tour-notification">                        
                        <div class="col-md-12">	
                            <div class="form-group">
                                <div  style="float: left;padding:0 5px;cursor: pointer">
                                    <input id="e_rd_notification" type="radio" value="notification"  name="event_type" checked="" class="simple">                          
                                    <span class="lbl padding-8">No Notification&nbsp;</span>
                                </div>
                                <div  style="float: left;padding-right: 5px;cursor: pointer">
                                    <input id="e_rd_sms" type="radio" value="sms"  name="event_type"  class="simple">                          
                                    <span class="lbl padding-8">Schedule SMS&nbsp;</span>
                                </div>
                                <div style="float: left;padding:0 5px;cursor: pointer">
                                    <input id="e_rd_email" type="radio" value="email"  name="event_type" class="simple">                          
                                    <span class="lbl padding-8">Schedule Email&nbsp;</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div class="row m-bot15">                        
                        <div class="col-md-12">	
                            <div class="form-group">
                                <div  style="float: left;padding:0 5px;cursor: pointer">
                                    <input id="e_notify_them" type="radio" value="them"  name="notify" checked="" class="simple">                          
                                    <span class="lbl padding-8">Notify Them&nbsp;</span>
                                </div>
                                <div  style="float: left;padding-right: 5px;cursor: pointer">
                                    <input id="e_notify_me" type="radio" value="me"  name="notify"  class="simple">                          
                                    <span class="lbl padding-8">Notify Me&nbsp;</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div class="row" id="tour-datetime">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Select Date</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input name="date" value=""  class="form-control form-control-inline input-medium default-date-picker" size="16" type="text">
                                </div><!-- /.input group -->
                            </div><!-- /.form group -->
                        </div>
                        <div class="col-md-5">
                            <div class="bootstrap-timepicker">
                                <div class="form-group">
                                    <label>Time picker:</label>
                                    <div class="input-group">
                                        <input id="e_time" name="time" type="text" value=" " class="form-control timepicker" />
                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                    </div><!-- /.input group -->
                                </div><!-- /.form group -->
                            </div>
                        </div>
                    </div>
                    <br/>
                    <!-- time Picker -->
                    <div id="e_check_block" class="row">
                        <div class="col-md-12">
                            <input id="e_is_repeat"  type="checkbox" class="simple" name="is_repeat" >
                            <span class="lbl padding-8 set_repeat">Set Repeat</span>
                        </div>
                    </div>
                    <br/>
                    <div id="e_repeat_block" class="row" style="display: none">
                        <div class="col-md-9">
                            <div class="box box-solid box-primary">
                                <div class="box-header" data-widget="collapse">
                                    <h3 class="box-title" style="cursor: pointer">Repeat Schedule</h3>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Repeats<span style="color: red">*</span></label>
                                            <div class="form-group">
                                                <select name="freq_type" id="e_freq_type" class="form-control" >
                                                    <option value="-1">Select</option>
                                                    <option value="days">DAILY</option>
                                                    <option value="weeks">WEEKLY</option>
                                                    <option value="months">MONTHLY</option>
                                                    <option value="years">YEARLY</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Repeat Every <span id="e_txt_freq_type">Days</span><span style="color: red">*</span></label>
                                            <div class="form-group">
                                                <select name="freq_no" id="e_freq_no" class="form-control" >
                                                    <option value="-1">Select</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <label>Ends</label>
                                            <div class="form-group" >
                                                <div  style="float: left;padding:7px 5px;cursor: pointer">
                                                    <input id="rd_never"  type="radio" value="never"  name="end_type" checked="" class="simple">                          
                                                    <span class="lbl padding-8">Never&nbsp;</span>
                                                </div>
                                                <div  style="float: left;padding:7px 5px;cursor: pointer">
                                                    <input id="rd_after" type="radio" value="after"  name="end_type"  class="simple">
                                                    <span class="lbl padding-8">After&nbsp;</span>
                                                </div>
                                                <div id="e_end_block" style="display: none" >
                                                    <div style="float: left;padding-right: 5px;cursor: pointer;">
                                                        <input value="0" type="text" name="occurance" class="form-control"   /> 
                                                    </div>
                                                    <div  style="float: left;padding:7px 5px;cursor: pointer">
                                                        Occurances
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-md-5">
                            <label>Event Name</label>
                            <div class="form-group" >
                                <input id="e_event" type="text" name="event" class="form-control"   />
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Choose Template</label>
                                <select name="template_id" id="e_template" class="form-control" >
                                    <option value="-1">--Select--</option>
                                    <?php foreach ($template as $value) { ?>
                                        <option value="<?= $value->template_id ?>"><?= $value->title ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="e_subject" class="row" style="display: none">
                        <div class="col-md-5">
                            <label>Subject</label>
                            <div class="form-group" >
                                <input id="e_txt_subject" type="text" name="subject" class="form-control"  />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div id="e_sms_block" class="col-md-9">
                            <div class="form-group">
                                <div class='row'>
                                    <div class='col-md-12'>
                                        <div class='box box-info'>
                                            <div class='box-header'>
                                                <h3 class='box-title'>Editor</h3>
                                            </div><!-- /.box-header -->
                                            <div class='box-body pad'>
                                                <textarea id="e_smsbody" rows="7" class="form-control"  name="smsbody"></textarea>
                                            </div>
                                        </div><!-- /.box -->
                                    </div>
                                </div><!-- /.box-body -->
                            </div>
                        </div>
                        <div id="e_email_block" class="col-md-9" style="display: none">
                            <div class="form-group">
                                <div class='row'>
                                    <div class='col-md-12'>
                                        <div class='box box-info'>
                                            <div class='box-header'>
                                                <h3 class='box-title'>Editor</h3>
                                            </div><!-- /.box-header -->
                                            <div class='box-body pad '>
                                                <textarea id="e_emailbody" rows="10" class="form-control"  name="emailbody" ></textarea>
                                            </div>
                                        </div><!-- /.box -->
                                    </div>
                                </div><!-- /.box-body -->
                            </div>
                        </div>
                        <div class="col-md-3">
                            <!-- Default box -->
                            <div class="box collapsed-box">
                                <div class="box-header" data-widget="collapse" style="cursor: pointer">
                                    <h3 class="box-title" style="cursor: pointer">Token List</h3>
                                    <div class="box-tools pull-right">
                                    </div>
                                </div>
                                <div class="box-body" style="display: none">
                                    <strong>{FIRST_NAME}</strong><br/>
                                    <strong>{LAST_NAME}</strong><br/>
                                    <strong>{EMAIL}</strong><br/>
                                    <strong>{PHONE}</strong><br/>
                                    <!--<strong>{GROUP}</strong><br/>-->
                                    <strong>{BIRTHDAY}</strong><br/>
                                    <strong>{ZODIAC}</strong><br/>
                                    <strong>{AGE}</strong><br/>
                                    <strong>{BIRTHDAY_ALERT}</strong><br/>
                                    <strong>{SOCIAL}</strong><br/>
                                    <strong>{CONTACT}</strong><br/>
                                    <strong>{COUNTRY}</strong><br/>
                                    <strong>{CITY}</strong><br/>
                                    <strong>{ADDRESS}</strong><br/>
                                    <strong>{RATING}</strong><br/>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!-- /.col -->
                    </div>

                </div>
                <div class="modal-footer clearfix">
                    <button type="button" id="e_discard" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Discard</button>
                    <button type="button" id="edit" class="btn btn-primary pull-left"><i class="fa fa-envelope"></i> Update Schedule Now</button>
                    <button type="button" id="delete" value="" class="btn btn-danger pull-left"> Delete Event</button>
                    <input type="hidden" id="eventid" name="eventid" value="" />
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- COMPOSE MESSAGE MODAL -->
<div class="modal fade" id="compose-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <button style="margin: -20px;opacity: 1;border-radius: 100%;" type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <img src="<?= base_url() ?>assets/dashboard/img/close.png" width="20px" alt="close" style="" />
                </button>
                <h4 class="modal-title"><i class="fa fa-envelope-o"></i> Schedule SMS/Email On : <span id="dt"></span></h4>
            </div>
            <form id="eventForm"  method="post">
                <div class="modal-body">

                    <div class="row m-bot15">                        
                        <div class="col-md-12">	
                            <div class="form-group">
                                <div class="rd" style="float: left;padding:0 5px;cursor: pointer">
                                    <input id="rd_notification" type="radio" value="notification"  name="event_type" checked="" class="simple">                          
                                    <span class="lbl padding-8">No Notification&nbsp;</span>
                                </div>
                                <div class="rd" style="float: left;padding-right: 5px;cursor: pointer">
                                    <input id="rd_sms" type="radio" value="sms"  name="event_type"  class="simple">                          
                                    <span class="lbl padding-8">Schedule SMS&nbsp;</span>
                                </div>
                                <div class="rd" style="float: left;padding:0 5px;cursor: pointer">
                                    <input id="rd_email" type="radio" value="email"  name="event_type" class="simple">                          
                                    <span class="lbl padding-8">Schedule Email&nbsp;</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div class="row m-bot15">                        
                        <div class="col-md-12">	
                            <div class="form-group">
                                <div  style="float: left;padding:0 5px;cursor: pointer">
                                    <input type="radio" value="them"  name="notify" checked="" class="simple">                          
                                    <span class="lbl padding-8">Notify Them&nbsp;</span>
                                </div>
                                <div  style="float: left;padding-right: 5px;cursor: pointer">
                                    <input type="radio" value="me"  name="notify"  class="simple">                          
                                    <span class="lbl padding-8">Notify Me&nbsp;</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div class="row m-bot15">                        
                        <div class="col-md-12">	
                            <div class="form-group">
                                <div class="form-group">
                                    <div id="individual"  style="float: left;padding-right: 5px;cursor: pointer">
                                        <input id="rd_individual"  type="radio" value="all_c"  name="assign" checked=""  class="simple">                          
                                        <span class="lbl padding-8">
                                            Individual Contacts&nbsp;
                                        </span>
                                    </div>
                                    <div id="group"  style="float: left;padding:0 5px;cursor: pointer;">
                                        <input id="rd_group" type="radio" value="all_gc"  name="assign" class="simple">                          
                                        <span class="lbl padding-8">
                                            Group Contacts&nbsp;
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div class="row choose">
                        <div class="col-md-5">
                            <label>Choose <span id="lbl_select">Contact</span></label>
                            <div class="form-group" id="user-tag">
                                <input type="text" class="form-control"  id="users" />
                            </div>
                        </div>
                        <div class="col-md-7" style="margin-top: 20px">
                            <span style="color: red" class="msgChoose"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <label>Event Name</label>
                            <div class="form-group" >
                                <input type="text" name="event" class="form-control"   />
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Choose Template</label>
                                <select name="template_id" id="template" class="form-control" >
                                    <option value="-1">--Select--</option>
                                    <?php foreach ($template as $value) { ?>
                                        <option value="<?= $value->template_id ?>"><?= $value->title ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="subject" class="row" style="display: none">
                        <div class="col-md-5">
                            <label id="lbl_select">Subject</label>
                            <div class="form-group" >
                                <input type="text" name="subject" class="form-control"  />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div id="sms_block" class="col-md-9">
                            <div class="form-group">
                                <div class='row'>
                                    <div class='col-md-12'>
                                        <div class='box box-info'>
                                            <div class='box-header'>
                                                <h3 class='box-title'>Editor</h3>
                                            </div><!-- /.box-header -->
                                            <div class='box-body pad'>
                                                <textarea id="smsbody" rows="7" class="form-control"  name="smsbody"></textarea>
                                            </div>
                                        </div><!-- /.box -->
                                    </div>
                                </div><!-- /.box-body -->
                            </div>
                        </div>
                        <div id="email_block" class="col-md-9" style="display: none">
                            <div class="form-group">
                                <div class='row'>
                                    <div class='col-md-12'>
                                        <div class='box box-info'>
                                            <div class='box-header'>
                                                <h3 class='box-title'>Editor</h3>
                                            </div><!-- /.box-header -->
                                            <div class='box-body pad '>
                                                <textarea id="emailbody" rows="10" class="form-control"  name="emailbody" ></textarea>
                                            </div>
                                        </div><!-- /.box -->
                                    </div>
                                </div><!-- /.box-body -->
                            </div>
                        </div>
                        <div class="col-md-3">
                            <!-- Default box -->
                            <div class="box collapsed-box">
                                <div class="box-header" data-widget="collapse" style="cursor: pointer">
                                    <h3 class="box-title" style="cursor: pointer">Token List</h3>
                                    <div class="box-tools pull-right">
                                    </div>
                                </div>
                                <div class="box-body" style="display: none">
                                    <strong>{FIRST_NAME}</strong><br/>
                                    <strong>{LAST_NAME}</strong><br/>
                                    <strong>{EMAIL}</strong><br/>
                                    <strong>{PHONE}</strong><br/>
                                    <!--<strong>{GROUP}</strong><br/>-->
                                    <strong>{BIRTHDAY}</strong><br/>
                                    <strong>{ZODIAC}</strong><br/>
                                    <strong>{AGE}</strong><br/>
                                    <strong>{BIRTHDAY_ALERT}</strong><br/>
                                    <strong>{SOCIAL}</strong><br/>
                                    <strong>{CONTACT}</strong><br/>
                                    <strong>{COUNTRY}</strong><br/>
                                    <strong>{CITY}</strong><br/>
                                    <strong>{ADDRESS}</strong><br/>
                                    <strong>{RATING}</strong><br/>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!-- /.col -->
                    </div>
                    <!-- time Picker -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="bootstrap-timepicker">
                                <div class="form-group">
                                    <label>Time picker:</label>
                                    <div class="input-group">
                                        <input name="time" type="text" class="form-control timepicker" />
                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                    </div><!-- /.input group -->
                                </div><!-- /.form group -->
                            </div>
                        </div>
                    </div>
                    <div id="check_block" class="row">
                        <div class="col-md-12">
                            <input id="is_repeat"  type="checkbox" class="simple"  name="is_repeat" >
                            <span class="lbl padding-8 set_repeat">Set Repeat</span>
                        </div>
                    </div>
                    <br/>
                    <div id="repeat_block" class="row" style="display: none">
                        <div class="col-md-12">
                            <div class="box box-solid box-primary">
                                <div class="box-header" data-widget="collapse">
                                    <h3 class="box-title" style="cursor: pointer">Repeat Schedule</h3>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Repeats<span style="color: red">*</span></label>
                                            <div class="form-group">
                                                <select name="freq_type" id="freq_type" class="form-control" >
                                                    <option value="-1" selected="">Select</option>
                                                    <option value="days">DAILY</option>
                                                    <option value="weeks">WEEKLY</option>
                                                    <option value="months">MONTHLY</option>
                                                    <option value="years">YEARLY</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Repeat Every <span id="txt_freq_type"></span><span style="color: red">*</span></label>
                                            <div class="form-group">
                                                <select name="freq_no" id="freq_no" class="form-control" >
                                                    <option value="-1" selected="">Select</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <label>Ends</label>
                                            <div class="form-group" >
                                                <div  style="float: left;padding:7px 5px;cursor: pointer">
                                                    <input  type="radio" value="never"  name="end_type" checked="" class="simple">                          
                                                    <span class="lbl padding-8">Never&nbsp;</span>
                                                </div>
                                                <div  style="float: left;padding:7px 5px;cursor: pointer">
                                                    <input  type="radio" value="after"  name="end_type"  class="simple">
                                                    <span class="lbl padding-8">After&nbsp;</span>
                                                </div>
                                                <div id="end_block" style="display: none" >
                                                    <div style="float: left;padding-right: 5px;cursor: pointer;">
                                                        <input value="0" type="text" name="occurance" class="form-control"   /> 
                                                    </div>
                                                    <div  style="float: left;padding:7px 5px;cursor: pointer">
                                                        Occurances
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer clearfix">
                    <button type="button" id="discard" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Discard</button>
                    <button type="button" id="insert" class="btn btn-primary pull-left"><i class="fa fa-envelope"></i> Schedule Now</button>
                    <input type="hidden" name="contact_id" value="" />
                    <input type="hidden" name="date" value="" />
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- CK Editor -->
<script src="//cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?= base_url() ?>assets/dashboard/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
<!-- bootstrap time picker -->
<script src="<?= base_url() ?>assets/dashboard/js/plugins/timepicker/bootstrap-timepicker.min.js" type="text/javascript"></script>
<!-- QTip -->
<script src="<?= base_url() ?>assets/dashboard/js/plugins/Qtip/js/jquery.qtip.js" type="text/javascript"></script>



<!-- Auto complete TextBox -->
<script>
    var contact = new Array();
    var ids = new Array();
    function BindControls(ar1, ar2) {
        contact = ar1;
        ids = ar2;
        $('#users').autocomplete({
            source: contact,
            minLength: 0,
            scroll: true
        }).focus(function () {
            $(this).autocomplete("search", "");
        });
    }
</script>
<!-- End Auto complete -->
<?php
$planInfo = $this->wi_common->getCurrentPlan();
$userInfo = $this->wi_common->getUserInfo($this->session->userdata('userid'));
?>

<script type="text/javascript">

    function varifyEmail() {
        $('#sendAgain').on('click', function () {
            $.ajax({
                type: 'POST',
                url: "<?= site_url() ?>app/calender/sendActivationEmail",
                success: function (data, textStatus, jqXHR) {
                    if (data == 1) {
                        alertify.success("Email has been successfully sent..!");
                    } else {
                        alertify.error("Email sending failed! Try Again..!");
                    }
                }
            });
        });
    }

    function validateContact(user) {
        var con = user.split('||');
        if (con[1].trim() == "") {
            return false;
        } else {
            return true;
        }
    }

    function chooseContact() {
        $('div.choose input:text').focusout(function () {
            var event_type = $('#eventForm input[name="event_type"]:checked').val();
            var user = $('#users').val().trim();
            if (user != "") {
                if (!validateContact(user)) {
                    $msg = (event_type == "notification" || event_type == "sms") ?
                            "Can not SMS this user because no phone number is assigned!" :
                            "Can not Email this user because no email address is assigned!";
                    $('.msgChoose').text($msg);
                } else {
                    $('.msgChoose').empty();
                }
            }
        });
    }

    var groupEvent = "<?= $planInfo->group_events ?>";
    var planid = "<?= $planInfo->plan_id ?>";
    $('#eventForm input[name="assign"]').change(function () {
        $('.msgChoose').empty();
        var event_type = $('#eventForm input[name="event_type"]:checked').val();
        if ($(this).val() == "all_c") {
            $.ajax({
                type: 'POST',
                url: "<?= site_url() ?>app/calender/allContacts/" + event_type,
                success: function (json, textStatus, jqXHR) {
                    $("#lbl_select").text("Contact");
                    var data = JSON.parse(json);
                    var ar1 = data['user'];
                    var ar2 = data['ids'];
                    $('#user-tag').html('<input type="text" class="form-control"  id="users" />');
                    chooseContact();
                    BindControls(ar1, ar2);
                }
            });
        } else if ($(this).val() == "all_gc") {
            if (groupEvent == "0") {
                $('#rd_individual').trigger('click');
                alertify.confirm("Your Account does not support this feature if you want this feature you should need to upgrade your account.Would you like to upgrade your plan?", function (e) {
                    if (e) {
                        window.location.href = "<?= site_url() ?>app/upgrade";
                    }
                });
            } else {
                $.ajax({
                    type: 'POST',
                    url: "<?= site_url() ?>app/calender/allGroup",
                    success: function (data, textStatus, jqXHR) {
                        if (data != 0) {
                            $("#lbl_select").text("Group");
                            $('#user-tag').html(data);
                        } else {
                            $('#rd_individual').trigger('click');
                            alertify.alert("You have already reach your Group event  limit..!\nYou can not add more..!");
                        }
                    }
                });
            }
        } else {
            return false;
        }
    });</script>


<script type="text/javascript">

    $(function () {
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace('emailbody');
        CKEDITOR.replace('e_emailbody');
        CKEDITOR.replace('n_emailbody');
        //bootstrap WYSIHTML5 - text editor
        $(".textarea").wysihtml5();
        $(".timepicker").timepicker({
            showInputs: false,
            showMeridian: false
        });
        $('.default-date-picker').datepicker({
            format: "<?= $this->session->userdata('date_format') ?>",
            todayBtn: "linked",
            autoclose: true,
            todayHighlight: true
        });
        $('.set_repeat').click(function () {
            var id = $(this).prev().attr('id');
            $('#' + id).trigger('click');
        });
        $('.set_repeat').hover(function () {
            $(this).css('cursor', 'pointer');
        });
    });
    $(document).ready(function () {

<?php if (isset($contactInfo) && $contactInfo): ?>
            $('#create_event').trigger('click');
<?php elseif (isset($contactInfo) && !$contactInfo): ?>
            alertify.error('User Not Available..!');
<?php endif; ?>

        $('#popup').click(function () {
<?php if (!$userInfo->email_verification): ?>
                alertify.alert("You can not schedule an events until you verify your email address.<br/><a href='javascript:void(0);' id='sendAgain'>Click Here</a> to send verification email.");
                varifyEmail();
                return false;
<?php endif; ?>
        });



        $('#freq_type,#e_freq_type,#n_freq_type').change(function () {
            var type = $(this).val();
            $msg = type.charAt(0).toUpperCase() + type.substring(1);
            if (type != "-1") {
                $('#txt_freq_type').text($msg);
                $('#e_txt_freq_type').text($msg);
                $('#n_txt_freq_type').text($msg);
            } else {
                $('#txt_freq_type').text("");
                $('#e_txt_freq_type').text("");
                $('#n_txt_freq_type').text("");
            }
        });
        $('#is_repeat,#e_is_repeat,#n_is_repeat').change(function () {
            if (planid == "1") {
                $(this).removeAttr('checked');
                alertify.confirm("Your Account is under 14 days trial period if you want this feature you should need to upgrade your account.Would you like to upgrade your plan?", function (e) {
                    if (e) {
                        window.location.href = "<?= site_url() ?>app/upgrade";
                    }
                });
            } else {
                if ($(this).is(':checked')) {
                    $('#repeat_block').css('display', 'block');
                    $('#e_repeat_block').css('display', 'block');
                    $('#n_repeat_block').css('display', 'block');
                } else {
                    $('#repeat_block').css('display', 'none');
                    $('#e_repeat_block').css('display', 'none');
                    $('#n_repeat_block').css('display', 'none');
                    $('#freq_type').val("-1");
                    $('#e_freq_type').val("-1");
                    $('#n_freq_type').val("-1");
                    $('#freq_no').val("-1");
                    $('#e_freq_no').val("-1");
                    $('#n_freq_no').val("-1");
                }
            }
        });
        $('input[name="end_type"]').change(function () {
            var end = $(this).val();
            if (end == "never") {
                $('#end_block').css('display', 'none');
                $('#e_end_block').css('display', 'none');
                $('#n_end_block').css('display', 'none');
            } else {
                $('#end_block').css('display', 'block');
                $('#e_end_block').css('display', 'block');
                $('#n_end_block').css('display', 'block');
            }
        });
        $('#rd_individual').trigger('click');
        $('#delete').click(function () {
            var eid = $(this).val();
            $.ajax({
                type: 'POST',
                url: "<?= site_url() ?>app/calender/deleteEvent/" + eid,
                success: function (data, textStatus, jqXHR) {
                    $('#e_discard').trigger('click');
                    if (data == 1) {
                        $("#calendar").fullCalendar("refetchEvents");
                        alertify.success("Event has been successfully Deleted..!");
                    } else {
                        alertify.error("Event has not been successfully Deleted..!");
                    }
                }
            });
        });
        $('#edit').click(function () {
            var id = $(this).prop('id');
            if ($('#editForm input[name="date"]').val().trim() == "") {
                alertify.error("Please Select Date..!");
                return false;
            }
            if ($('#editForm input[name="event"]').val().trim() == "") {
                alertify.error("Please Enter Event Name..!");
                return false;
            }
            if ($("#e_is_repeat").is(':checked')) {
                if ($('#e_freq_type').val() == "-1" || $('#e_freq_no').val() == "-1") {
                    alertify.error("Please Select Mandatory Field..!");
                    return false;
                }
                if ($('#editForm input[name="end_type"]:checked').val() == "after") {
                    var occur = parseInt($('#editForm input[name="occurance"]').val());
                    if (!/^[0-9]+$/.test(occur)) {
                        alertify.error("Please Enter Valid Occurance Number..!");
                    } else if (occur <= 0) {
                        alertify.error("Occurance Must be greater than 0..!");
                    }
                }
            }
            if (hopscotch.getState() == "welcome:15:7") {
                hopscotch.nextStep();
            }
            var data = CKEDITOR.instances['e_emailbody'].getData();
            $('#e_emailbody').val(data);
            $('#' + id).prop('disabled', 'disabled');
            $.ajax({
                type: 'POST',
                data: $('#editForm').serialize(),
                url: "<?= site_url() ?>app/calender/updateEvent",
                success: function (data, textStatus, jqXHR) {
                    $('#e_discard').trigger('click');
                    $('#' + id).prop('disabled', false);
                    if (data == 1) {
                        $("#calendar").fullCalendar("refetchEvents");
                        alertify.success("Event has been successfully Updated..!");
                    } else if (data == 0) {
                        alertify.error("Event has not been successfully Updated..!");
                    } else {
                        alertify.error(data);
                    }
                }
            });
        });
        $('#insert,#n_insert').click(function () {
            var id = $(this).prop('id');
            if (id == "insert") {
                if ($("#rd_individual").prop("checked")) {
                    var cnt = $('#users').val();
                    if (cnt.trim() == "") {
                        alertify.error("Please Select Contact..!");
                        return false;
                    } else if ($.inArray(cnt, contact) == "-1") {
                        alertify.error("Please Select Valid Contact..!");
                        return false;
                    }
                }
                if ($('#eventForm input[name="event"]').val().trim() == "") {
                    alertify.error("Please Enter Event Name..!");
                    return false;
                }
                if ($("#is_repeat").is(':checked')) {
                    if ($('#freq_type').val() == "-1" || $('#freq_no').val() == "-1") {
                        alertify.error("Please Select Mandatory Field..!");
                        return false;
                    }
                    if ($('#eventForm input[name="end_type"]:checked').val() == "after") {
                        var occur = parseInt($('#eventForm input[name="occurance"]').val());
                        if (!/^[0-9]+$/.test(occur)) {
                            alertify.error("Please Enter Valid Occurance Number..!");
                        } else if (occur <= 0) {
                            alertify.error("Occurance Must be greater than 0..!");
                        }
                    }
                }
            } else {
                if ($('#neweventForm input[name="date"]').val().trim() == "") {
                    alertify.error("Please Select Event Date..!");
                    return false;
                }
                if ($('#neweventForm input[name="event"]').val().trim() == "") {
                    alertify.error("Please Enter Event Name..!");
                    return false;
                }
                if ($("#n_is_repeat").is(':checked')) {
                    if ($('#n_freq_type').val() == "-1" || $('#n_freq_no').val() == "-1") {
                        alertify.error("Please Select Mandatory Field..!");
                        return false;
                    }
                    if ($('#neweventForm input[name="end_type"]:checked').val() == "after") {
                        var occur = parseInt($('#neweventForm input[name="occurance"]').val());
                        if (!/^[0-9]+$/.test(occur)) {
                            alertify.error("Please Enter Valid Occurance Number..!");
                        } else if (occur <= 0) {
                            alertify.error("Occurance Must be greater than 0..!");
                        }
                    }
                }
            }
            var form = "";
            if (id == "insert") {
                var data = CKEDITOR.instances['emailbody'].getData();
                $('#emailbody').val(data);
            } else if (id == "n_insert") {
                var data = CKEDITOR.instances['n_emailbody'].getData();
                $('#n_emailbody').val(data);
            }
<?php if (isset($contactInfo) && $contactInfo): ?>
                form = "neweventForm";
<?php else: ?>
                form = "eventForm";
                if (validateContact($('#users').val())) {
                    $('input[name="contact_id"]').val(ids[contact.indexOf($('#users').val())]);
                } else {
                    return false;
                }
<?php endif; ?>
            $('#' + id).prop('disabled', 'disabled');
            $.ajax({
                type: 'POST',
                data: $('#' + form).serialize(),
                url: "<?= site_url() ?>app/calender/addEvent",
                success: function (data, textStatus, jqXHR) {
                    $('#discard').trigger('click');
                    $('#n_discard').trigger('click');
                    $('#eventForm').trigger("reset");
                    $('#neweventForm').trigger("reset");
                    $('#' + id).prop('disabled', false);
                    if (data == 1) {
                        $("#calendar").fullCalendar("refetchEvents");
                        alertify.success("Event has been successfully created..!");
                    } else {
                        alertify.error("Event has not been successfully created..!");
                    }
                }
            });
        });
        $('#neweventForm input[name="event_type"],#eventForm input[name="event_type"],#editForm input[name="event_type"]').change(function ()
        {

            if ($(this).val() == "sms" || $(this).val() == "notification") {
                $type = "sms";
                $('#smsbody').val('');
                $('#n_msbody').val('');
                $('#e_msbody').val('');
                $('#email_block').css('display', 'none');
                $('#n_email_block').css('display', 'none');
                $('#e_email_block').css('display', 'none');
                $('#subject').css('display', 'none');
                $('#n_subject').css('display', 'none');
                $('#e_subject').css('display', 'none');
                $('#sms_block').css('display', 'block');
                $('#n_sms_block').css('display', 'block');
                $('#e_sms_block').css('display', 'block');
            } else {
                $type = "email";
                $('#emailbody').val('');
                $('#n_mailbody').val('');
                $('#e_mailbody').val('');
                $('#sms_block').css('display', 'none');
                $('#n_sms_block').css('display', 'none');
                $('#e_sms_block').css('display', 'none');
                $('#email_block').css('display', 'block');
                $('#n_email_block').css('display', 'block');
                $('#e_email_block').css('display', 'block');
                $('#subject').css('display', 'block');
                $('#n_subject').css('display', 'block');
                $('#e_subject').css('display', 'block');
            }
            $('#rd_individual').trigger('change');
            $('.msgChoose').empty();
            $.ajax({
                type: 'POST',
                url: "<?= site_url() ?>app/calender/getTemplates/" + $type,
                success: function (data, textStatus, jqXHR) {
                    $('#template').html(data);
                    $('#n_template').html(data);
                    $('#e_template').html(data);
                }
            });
        });
        $('#e_template,#n_template,#template').change(function () {
            if ($(this).attr('id') == "template") {
                var event_type = $('#eventForm input[name="event_type"]:checked').val();
            } else if ($(this).attr('id') == "n_template") {
                var event_type = $('#neweventForm input[name="event_type"]:checked').val();
            } else if ($(this).attr('id') == "e_template") {
                var event_type = $('#editForm input[name="event_type"]:checked').val();
            }
            var tempid = $(this).val();
            if (tempid == "-1") {
                return false;
            } else {
                $.ajax({
                    type: 'POST',
                    url: "<?= site_url() ?>app/calender/getTemplate/" + event_type + "/" + tempid,
                    success: function (json, textStatus, jqXHR) {
                        var data = JSON.parse(json);
                        if (event_type == "email") {
                            $('#n_smsbody').val("");
                            $('#e_smsbody').val("");
                            $('#smsbody').val("");
                            CKEDITOR.instances['emailbody'].setData(data.body);
                            CKEDITOR.instances['n_emailbody'].setData(data.body);
                            CKEDITOR.instances['e_emailbody'].setData(data.body);
                            $('#emailbody').val(data.body);
                            $('#n_emailbody').val(data.body);
                            $('#e_emailbody').val(data.body);
                            $('input[name="subject"]').val(data.subject);
                        } else if (event_type == "sms" || event_type == "notification") {
                            CKEDITOR.instances['emailbody'].setData('');
                            CKEDITOR.instances['n_emailbody'].setData('');
                            CKEDITOR.instances['e_emailbody'].setData('');
                            $('#emailbody').val('');
                            $('#n_emailbody').val('');
                            $('#e_emailbody').val('');
                            $('input[name="subject"]').val('');
                            $('#n_smsbody').val(data.body);
                            $('#e_smsbody').val(data.body);
                            $('#smsbody').val(data.body);
                        }
                    }
                });
            }
        });
    });</script>

<!-- fullCalendar -->
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.7.0/moment.min.js" type="text/javascript"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.0.2/fullcalendar.min.js" type="text/javascript"></script>

<script>
    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date();
    var d = date.getDate(),
            m = date.getMonth(),
            y = date.getFullYear();
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            //right: 'month,agendaWeek,agendaDay'
            right: 'month'
        },
        buttonText: {
            today: 'today',
            month: 'month'
        },
        events: function (start, end, timezone, callback) {
            $.ajax({
                type: 'POST',
                url: '<?= site_url() ?>app/calender/getEvents',
                data: {
                    // our hypothetical feed requires UNIX timestamps
                    start: start.unix(),
                    end: end.unix()
                },
                success: function (json, textStatus, jqXHR) {
                    var events = [];
                    var data = JSON.parse(json);
                    if (data.length) {
                        for (var key in data) {
                            if (json.hasOwnProperty(key)) {
                                events.push({
                                    id: data[key].event_id,
                                    title: data[key].event,
                                    start: data[key].date, // will be parsed
                                    color: data[key].color
                                });
                            }
                        }
                        callback(events);
                    }
                }
            });
        },
        dayClick: function (date, jsEvent, view) {
            var check = date.format();
            var today = $.datepicker.formatDate('yy-mm-dd', new Date());
            if ($(jsEvent.target).is('td.fc-day')) {
                if (check >= today) {
                    // Clicked on the day number 
                    $('#rd_sms').removeAttr("disabled");
                    $('#rd_email').removeAttr("disabled");
                } else {
                    $('#rd_sms').attr("disabled", "true");
                    $('#rd_email').attr("disabled", "true");
                    $('#rd_sms').attr("title", "You are not allowed to schedule this Event on previous date.");
                    $('#rd_email').attr("title", "You are not allowed to schedule this Event on previous date.");
                }
                highlightDay(jsEvent);
                $('#dt').text(date.format("DD-MM-YYYY"));
                $('input[name="date"]').val(date.format());
                $('#eventForm').trigger("reset");
                $('#all_c').trigger("change");
                $('#rd_individual').trigger('change');
                $('#popup').removeAttr('disabled');
            }
        },
        eventClick: function (calEvent, jsEvent, view) {
            highlightDay(jsEvent);
            $('#delete').val(calEvent.id);
            $.ajax({
                type: 'POST',
                url: '<?= site_url() ?>app/calender/getEvent/' + calEvent.id,
                success: function (json, textStatus, jqXHR) {
                    var data = JSON.parse(json);
                    $('#event-description input[name="date"]').val(data.format_date);
                    $('#eventid').val(data.event_id);
                    if (data.notify == "them") {
                        $('#e_notify_them').trigger('click');
                    } else {
                        $('#e_notify_me').trigger('click');
                    }
                    if (data.group_type == "individual") {
                        $('.e_user_name').text(data.name);
                        $url = (data.contact_avatar != null) ?
                                "http://mikhailkuznetsov.s3.amazonaws.com/" + data.contact_avatar :
                                "<?= base_url() . 'assets/dashboard/img/default-avatar.png' ?>";
                        $href = "<?= site_url() ?>app/contacts/profile/" + data.contact_id;
                        $('#e_user_img').attr('href', $href);
                        $('#e_user_img img').attr('src', $url);
                        $('#e_user_img').css('display', 'block');
                        $('#e_user_img').css('float', 'left');
                        $('#event_status').css('margin', '0 0 0 50px');
                        $('#event_empty').css('margin', '0 0 0 50px');
                    } else {
                        $('#event_status').css('margin', '0');
                        $('#event_empty').css('margin', '0');
                        $('.e_user_name').text(data.group_name);
                        $('#e_user_img').css('display', 'none');
                    }
                    $('#e_event_name').text(data.event);
                    $('.e_event_time').text(data.date);
                    $('#e_event').val(data.event);
                    $('#e_time').val(data.time);
                    $('#e_template').val(data.template_id);
//                    $('#e_color-chooser-btn').css('background-color', data.color);
                    if (data.event_type == "sms" || data.event_type == "notification") {
                        $('#e_event_type').text("Text SMS");
                        $('#e_smsbody').val(data.body);
                        if (data.event_type == "sms") {
                            $('#event_status').css('display', 'block');
                            $('#event_empty').css('display', 'none');
                            $('#e_rd_sms').trigger('click');
                        } else {
                            $('#event_status').css('display', 'none');
                            $('#event_empty').css('display', 'block');
                            $('#e_rd_notification').trigger('click');
                        }
                        $('#e_email_block').css('display', 'none');
                        $('#e_subject').css('display', 'none');
                        $('#e_sms_block').css('display', 'block');
                    } else {
                        $('#event_status').css('display', 'block');
                        $('#event_empty').css('display', 'none');
                        $('#e_event_type').text("Email");
                        $('#e_rd_email').trigger('click');
//                        $('input[name="event_type"]').trigger('change');
                        $('#e_sms_block').css('display', 'none');
                        $('#e_email_block').css('display', 'block');
                        $('#e_subject').css('display', 'block');
                        $('#e_txt_subject').val(data.subject);
                        CKEDITOR.instances['e_emailbody'].setData(data.body);
                        $('#e_emailbody').val(data.body);
                    }

                    if (!data.refer_id) {
                        $('#e_check_block').css('display', 'block');
                        if (data.is_repeat == 1) {
                            $('#e_is_repeat').attr('checked', 'true');
                            $('#e_repeat_block').css('display', 'block');
                        } else {
                            $('#e_is_repeat').removeAttr('checked');
                            $('#e_repeat_block').css('display', 'none');
                        }
                        $('#e_freq_type').val(data.freq_type);
                        if (data.freq_type != "-1") {
                            $('#e_txt_freq_type').text(data.freq_type.charAt(0).toUpperCase() + data.freq_type.substring(1));
                        } else {
                            $('#e_txt_freq_type').text("");
                        }
                        $('#e_freq_no').val(data.freq_no);
                        if (data.end_type == "never") {
                            $('#rd_never').attr('checked', 'true');
                            $('#rd_after').removeAttr('checked');
                            $('#e_end_block').css('display', 'none');
                        } else {
                            $('#rd_after').attr('checked', 'true');
                            $('#e_end_block').css('display', 'block');
                            $('#rd_never').removeAttr('checked');
                        }
                        $('input[name="occurance"]').val(data.occurance);
                    } else {
                        $('#e_repeat_block').css('display', 'none');
                        $('#e_check_block').css('display', 'none');
                    }
                }
            });
            $('#event_desc').trigger('click');
        },
        eventDrop: function (event, delta, revertFunc) {
            var new_date = event.start.format("YYYY-MM-DD");
            if (!confirm("Are you sure about this change?")) {
                revertFunc();
            } else {
                $.ajax({
                    type: 'POST',
                    data: {date: new_date, eventid: event.id},
                    url: "<?= site_url() ?>app/calender/updateEvent",
                    success: function (data, textStatus, jqXHR) {
                        if (data == 0) {
                            revertFunc();
                        }
                    }
                });
            }
        },
        editable: true,
        droppable: false // this allows things to be dropped onto the calendar !!!
    });
<?php $dt = $this->input->get('date'); ?>
<?php $evt = $this->input->get('event'); ?>
<?php if ($dt != ""): ?>
        $('#calendar').fullCalendar('gotoDate', '<?= $dt ?>');
        $('td.fc-day').each(function () {
            if ($(this).attr('data-date') == "<?= $dt ?>") {
                $(this).find('div.fc-day-content').attr('id', 'birth_day');
            }
        });
<?php endif; ?>


    function highlightDay(jsEvent) {

        var mousex = jsEvent.pageX;
        var mousey = jsEvent.pageY;
        $('td').each(function (index) {
            var offset = $(this).offset();
            if ((offset.left + $(this).outerWidth()) > mousex && offset.left < mousex && (offset.top + $(this).outerHeight()) > mousey && offset.top < mousey) {

                if ($(this).hasClass('fc-other-month')) {
                    //Its a day on another month
                    //a high minus number means previous month
                    //a low minus number means next month
                    day = '-' + $(this).find('.fc-day-number').html();
                    $(this).css('border', '1px solid darkturquoise');
                }
                else
                {
                    //This is a day on the current month
                    day = $(this).find('.fc-day-number').html();
                    $(this).css('border', '1px solid darkorchid');
                }
            } else {
                $(this).removeAttr('style');
            }
        });
    }
    setTimeout(function () {
//        hopscotch.showStep(15);
//        console.log(hopscotch.getState());
//        hopscotch.showStep(16);
        console.log(hopscotch.getState());
    }, 2000);
</script>
