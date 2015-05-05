<!-- Theme Style -->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dashboard/css/AdminLTE.css"/>
<!-- Bootstrap -->
<link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"/>

<div class="wrapper">
    <?php
    $path = site_url() . 'home';
    ?>
    <div class="row">
        <div class="col-md-3"></div>
        <div  style="text-align: center;font-size: 20px;color: black" class="col-md-6">
            <p>ERROR : <?= $error ?></p>
            <p>Your Transaction is Fail..! Try Again..!</p>
            <br/>
            <a href="<?= $path ?>" class="btn btn-info">Back to Home</a>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>
