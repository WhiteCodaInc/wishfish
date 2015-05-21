<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dashboard/js/plugins/multi-select/css/multi-select.css" />
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dashboard/css/checkbox.css"/>
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="display: none">Contact Detail</h1>
        <button type="button" id="addContact" class="btn btn-primary">Save Contact Detail</button>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3"></div>
            <!-- left column -->
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Edit Existing Contact</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form id="contactForm" role="form" action="<?= site_url() ?>admin/contacts/updateContact" enctype="multipart/form-data" method="post">
                        <div class="box-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>First Name</label>
                                        <input value="<?= isset($contacts) ? $contacts->fname : '' ?>" type="text" name="fname" autofocus="autofocus" class="form-control" placeholder="First Name" required=""/>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Last Name</label>
                                        <input value="<?= isset($contacts) ? $contacts->lname : '' ?>" type="text" name="lname" class="form-control" placeholder="Last Name" required=""/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name">Email</label>
                                <input value="<?= isset($contacts) ? $contacts->email : '' ?>" type="email" name="email" class="form-control" placeholder="Email"/>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label>Country Code</label>
                                        <select name="code" class="form-control">
                                            <option value="+1" selected="">+1</option>
                                        </select>
                                    </div>
                                    <?php
                                    $phone = (isset($contacts)) ?
                                            substr($contacts->phone, -10) : "";
                                    ?>
                                    <div class="col-sm-9">
                                        <label>Phone Number</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-phone"></i>
                                            </div>
                                            <input value="<?= $phone ?>" type="text" name="phone" class="form-control" placeholder="Phone" data-inputmask='"mask": "(999) 999-9999"' data-mask/>
                                        </div><!-- /.input group -->
                                    </div>
                                </div>
                            </div><!-- /.form group -->
                            <div class="form-group">
                                <label for="contact avatar">Contact Avatar</label>
                                <input name="contact_avatar"  type="file" class="form-control" />
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-7">
                                        <label>Contact Groups</label><a style="margin-left: 10px" href="<?= site_url() . 'admin/contact_groups/addContactGroup' ?>" >Create New Contact Group</a>
                                        <select multiple="" name="group_id[]" class="form-control searchable">
                                            <?php foreach ($groups as $value) { ?>
                                                <option value="<?= $value->group_id ?>" <?= (in_array($value->group_id, $cgroup)) ? "selected" : '' ?>><?= $value->group_name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Birthday</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input name="birthday" value="<?= isset($contacts) ? date('d-m-Y', strtotime($contacts->birthday)) : '' ?>"  class="form-control form-control-inline input-medium default-date-picker" size="16" type="text">
                                </div><!-- /.input group -->
                            </div><!-- /.form group -->
                            <div class="form-group">
                                <label for="zodiac">Zodiac</label>
                                <input value="<?= isset($contacts) ? $contacts->zodiac : '' ?>" name="zodiac" placeholder="Zodiac" type="text" class="form-control" readonly="readonly" >
                            </div>
                            <div class="form-group">
                                <label>Age</label>
                                <input value="<?= isset($contacts) ? $contacts->age : '' ?>" name="age" class="form-control" placeholder="Age" type="text" readonly="readonly">
                            </div>
                            <div class="form-group">
                                <label>Contact Sex</label><br/>
                                <div style="float: left;padding-right: 5px;cursor: pointer">
                                    <input type="radio" id="male" value="male"  name="gender" checked="" class="simple form-control">                          
                                    <span class="lbl padding-8">Male&nbsp;</span>
                                </div>
                                <div style="float: left;padding:0 5px;cursor: pointer">
                                    <input type="radio" id="female" value="female"  name="gender" class="simple form-control">                          
                                    <span class="lbl padding-8">Female&nbsp;</span>
                                </div>
                            </div>
                            <br/>
                            <div id="rating_block" class="form-group" style="display: none">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Crazy (0-10)</label>
                                            <select name="crazy" class="form-control m-bot15">
                                                <option value="-1">--Select--</option>
                                                <option value="0">0</option>
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
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Hot (0-10)</label>
                                            <select name="hot" class="form-control m-bot15">
                                                <option value="-1">--Select--</option>
                                                <option value="0">0</option>
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
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Company">Company</label>
                                <input value="<?= isset($contacts) ? $contacts->company : '' ?>" name="company" type="text" class="form-control" placeholder="Company">
                            </div>
                            <div class="form-group">
                                <label for="social media">Social Media</label>
                                <input value="<?= isset($contacts) ? $contacts->social_media : '' ?>" name="social_media" type="text" class="form-control" placeholder="Social Media">
                            </div>
                            <div class="form-group">
                                <label for="url">Url</label>
                                <input value="<?= isset($contacts) ? $contacts->url : '' ?>" name="url" type="text" class="form-control" placeholder="Url">
                            </div>
                            <div class="form-group">
                                <label for="rating">Profile Rating(1-10)</label>
                                <select name="rating" class="form-control m-bot15">
                                    <option value="-1">--Select--</option>
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
                            <div class="form-group">
                                <label for="country">Country</label>
                                <input value="<?= isset($contacts) ? $contacts->country : '' ?>" name="country" type="text" class="form-control" placeholder="Country" >
                            </div>
                            <div class="form-group">
                                <label for="country">City</label>
                                <input value="<?= isset($contacts) ? $contacts->city : '' ?>" name="city" type="text" class="form-control" placeholder="City">
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input value="<?= isset($contacts) ? $contacts->address : '' ?>" name="address" type="text" class="form-control" placeholder="Address" >
                            </div>
                            <div class="form-group">
                                <label for="phone">Notes</label>
                                <textarea type="text" name="notes" class="form-control" placeholder="Notes"><?= isset($contacts) ? $contacts->notes : '' ?></textarea>
                            </div>
                        </div><!-- /.box-body -->

                        <input type="hidden" name="contactid" value="<?= isset($contacts) ? $contacts->contact_id : '' ?>" />
                    </form>
                </div><!-- /.box -->
            </div><!--/.col (left) -->
            <div class="col-md-3"></div>
            <!-- right column -->
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<!-- InputMask -->
<script src="<?= base_url() ?>assets/dashboard/js/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/dashboard/js/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/dashboard/js/plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>
<!-- Multi Select -->
<script src="<?= base_url() ?>assets/dashboard/js/plugins/multi-select/js/jquery.multi-select.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/dashboard/js/plugins/multi-select/js/jquery.quicksearch.js" type="text/javascript"></script>

<script type="text/javascript">
    $(function () {
        $("[data-mask]").inputmask();
        $('.default-date-picker').datepicker({
            format: "dd-mm-yyyy",
            todayBtn: "linked",
            autoclose: true,
            todayHighlight: true
        }).on('changeDate', function (ev) {
            $('input[name="birthday"]').focusout();
        });
        ;
    });
    $(document).ready(function () {
<?php if (isset($contacts)): ?>
            $("#<?= $contacts->gender ?>").attr('checked', 'true');
    <?php if ($contacts->phone): ?>
                $('select[name="code"]').val("<?= substr($contacts->phone, -strlen($contacts->phone), 2) ?>");
    <?php endif; ?>
            $('select[name="rating"]').val("<?= ($contacts->rating) ? $contacts->rating : -1 ?>");
<?php endif; ?>
        $('input[name="gender"]').change(function () {
            var type = $('input[name="gender"]:checked').val();
            if (type == "female") {
                $('#rating_block').css('display', 'block');
            } else {
                $('#rating_block').css('display', 'none');
            }
        });

        $('#addContact').click(function () {
            $('#contactForm').submit();
        });

        $('input[name="birthday"]').focusout(function () {
            var dt = $(this).val();
            var pastYear = dt.split('-');
            var now = new Date();
            var nowYear = now.getFullYear();
            var age = nowYear - pastYear[2];
            if (dt != "") {
                $.ajax({
                    type: 'POST',
                    data: {birthdate: dt},
                    url: "<?= site_url() ?>admin/affiliates/getZodiac/" + dt,
                    success: function (data, textStatus, jqXHR) {
                        $('input[name="zodiac"]').val(data);
                        $('input[name="age"]').val(age);
                    }
                });
            } else {
                $('input[name="zodiac"]').val('');
                $('input[name="age"]').val('');
            }
        });
    });
</script>

<script type="text/javascript">
    $('.searchable').multiSelect({
        selectableHeader: "<input style='margin-bottom: 5%;' type='text' class='search-input form-control' autocomplete='off' placeholder='Search By Contact'>",
        selectionHeader: "<input style='margin-bottom: 5%;' type='text' class='search-input form-control' autocomplete='off' placeholder='Search By Contact'>",
        afterInit: function (ms) {
            var that = this,
                    $selectableSearch = that.$selectableUl.prev(),
                    $selectionSearch = that.$selectionUl.prev(),
                    selectableSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)',
                    selectionSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selection.ms-selected';

            that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                    .on('keydown', function (e) {
                        if (e.which === 40) {
                            that.$selectableUl.focus();
                            return false;
                        }
                    });

            that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                    .on('keydown', function (e) {
                        if (e.which == 40) {
                            that.$selectionUl.focus();
                            return false;
                        }
                    });
        },
        afterSelect: function () {
            this.qs1.cache();
            this.qs2.cache();
        },
        afterDeselect: function () {
            this.qs1.cache();
            this.qs2.cache();
        }
    });
</script>