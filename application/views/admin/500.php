<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            500 Error Page
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Examples</a></li>
            <li class="active">500 error</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="error-page">
            <h2 class="headline">500</h2>
            <div class="error-content">
                <h3><i class="fa fa-warning text-yellow"></i> Oops! Something went wrong.</h3>
                <p>
                    You don't have permission to access the requested URL.<br/>
                    Why not try refreshing you page? Or you can contact to your Company if the problem persists.
                    Meanwhile, you may <a href='<?= site_url() ?>admin/dashboard'>return to dashboard</a>.
                </p>
            </div>
        </div><!-- /.error-page -->
    </section><!-- /.content -->
</aside><!-- /.right-side -->
</div>