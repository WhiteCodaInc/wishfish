<div class="row">
    <div class="col-md-7">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Email List Contacts</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <?php
                foreach ($contacts as $value) {
                    $contactInfo = $this->common->getContactInfo($value);
                    echo $contactInfo->fname . ' ' . $contactInfo->lname . ' | ', $contactInfo->email . '<br>';
                }
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Email List Groups</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <?php
                foreach ($groups as $value) {
                    echo $value->group_name . '<br>';
                }
                ?>
            </div>
        </div>
    </div>
</div>