<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dashboard/js/plugins/multi-select/css/multi-select.css" />
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="display: none">
            <?= isset($group) ? "Edit" : "Add New" ?> Block Contacts
        </h1>
        <button type="button" id="block" class="btn btn-primary">
            <?= isset($group) ? "Save Current Block List" : "Create New Block List" ?>
        </button>
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
                        <h3 class="box-title">Contact Block List</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php $method = (isset($group)) ? "updateList" : "createList"; ?>
                    <form id="blockForm" role="form" action="<?= site_url() . "admin/contacts/" . $method ?>" method="post">
                        <div class="box-body">
                            <!--<div class="form-group">
                                <label for="group name">Group Name</label>
                                <input type="text" value="<?= isset($group) ? $group->group_name : '' ?>" name="group_name" autofocus="autofocus" class="form-control" placeholder="Group Name" />
                            </div>-->
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-7">
                                        <label id="lbl_select">Choose Contacts</label>
                                        <select  multiple='multiple' id="contact" name="contact_id[]" class="form-control searchable">
                                            <?php foreach ($contacts as $value) { ?>
                                                <option value="<?= $value->contact_id ?>" <?= (isset($gcontacts) && in_array($value->contact_id, $gcontacts)) ? "selected" : '' ?>>
                                                    <?= $value->fname . '' . $value->lname ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                        <input type="hidden" name="groupid" value="<?= isset($group) ? $group->group_id : '' ?>" />
                        <input type="hidden" name="type" value="block" />
                    </form>
                </div><!-- /.box -->
            </div><!--/.col (left) -->
            <div class="col-md-3 "></div>
            <!-- right column -->
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->
</div><!-- ./wrapper -->
<script src="<?= base_url() ?>assets/dashboard/js/plugins/multi-select/js/jquery.multi-select.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/dashboard/js/plugins/multi-select/js/jquery.quicksearch.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {

        $('#block').click(function () {
            $('#blockForm').submit();
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
<?php $msg = $this->input->get('msg'); ?>
<?php
switch ($msg) {
    case "I":
        $m = "New Block Contact Group Successfully Created..!";
        $t = "success";
        break;
    case "U":
        $m = "Block Contact Group Successfully Updated..!";
        $t = "success";
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