<section role="main" class="content-body">
    <header class="page-header">
        <h2>Email Templates</h2>

        <div class="right-wrapper pull-right" style="padding-right: 10px;">
            <ol class="breadcrumbs">
                <li>
                    <a href="<?= site_url() ?>">
                        <i class="fa fa-home"></i>
                    </a>
                </li>                
                <li><span>Email Templates</span></li>
            </ol>           
        </div>
    </header>

    <!-- start: page -->
    <div class="row">
        <div class="col-md-12">             
            <section class="panel panel-featured panel-featured-primary">
                <header class="panel-heading">
                    <h2 class="panel-title">Email Templates Detail</h2>
                </header>
                <div class="panel-body">
                    <!--Dynamic Table-->
                    <table class="table table-bordered table-striped mb-none" id="datatable-default">
                        <thead>
                            <tr>                                    
                                <th>Template Name</th>
                                <th>Type</th>
                                <th>Subject Line</th>
                                <th>Color</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($automail as $value) { ?>                             
                                <tr>
                                    <td><?= $value->mail_type ?></td>
                                    <td><?= $value->type ?></td>
                                    <td><?= $value->mail_subject ?></td>
                                    <td>
                                        <span class="btn" style ="background:<?= $value->color ?>;"></span>
                                    </td>
                                    <td>
                                        <a href="<?= site_url() ?>admin/email_notification/edit/<?= $value->mail_id ?>" class="btn bg-navy btn-xs">
                                            <i class="fa fa-edit"></i>
                                            Edit
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <!--Dynamic End-->   
                </div>
            </section>
        </div>
    </div>
    <!-- end: page -->
</section>
<?php $msg = $this->input->get('msg'); ?>
<?php
switch ($msg) {
    case "U":
        $m = "Email Template Successfully Updated..!";
        $t = "success";
        break;
    default:
        $m = 0;
        break;
}
?>
<script type="text/javascript">
<?php if ($msg): ?>
        alertify. < ? = $t ? > ("<?= $m ?>");
<?php endif; ?></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#datatable-default').dataTable({
            order: [],
            aoColumnDefs: [{
                    bSortable: false,
                    aTargets: [0, 1, 2, 3, 4]
                }]
        });
    });
</script>