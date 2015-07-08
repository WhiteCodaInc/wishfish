<style type="text/css">
    span.copyText {
        position: relative;
        display: inline;
        cursor: pointer
    }
    li.copy textarea {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 0 none transparent;
        margin: 0;
        padding: 0;
        outline: none;
        resize: none;
        overflow: hidden;
        font-family: inherit;
        font-size: 1em;
        cursor: pointer
    }
    ul.instruction li{
        list-style-type: decimal
    }
</style>
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="display: none">Google Calender Setting</h1>
        <button type="button" id="save-setting" class="btn btn-primary">Save Setting</button>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3"></div>
            <!-- left column -->
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header" >
                        <h3  class="box-title">Setting</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form id="userForm" role="form" action="<?= site_url() ?>admin/setting/updateCalenderSetting" method="post">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Application Name</label>
                                <input value="<?= $calender->app_name ?>" type="text" name="app_name" autofocus="autofocus" class="form-control" placeholder="Application Name" required=""/>
                            </div>
                            <div class="form-group">
                                <label>Client Id</label>
                                <input value="<?= $calender->client_id ?>"  name="client_id" placeholder="Client Id" type="text"  class="form-control" required=""/>
                            </div>
                            <div class="form-group">
                                <label>Client Secret</label>
                                <input value="<?= $calender->client_secret ?>"  name="client_secret" placeholder="Client Secret" type="text"  class="form-control" required=""/>
                            </div>
                            <div class="form-group">
                                <label>Redirect URI</label>
                                <input value="<?= $calender->redirect_uri ?>"  name="redirect_uri" placeholder="Redirect URI" type="text"  class="form-control" disabled=""/>
                            </div>
                            <div class="form-group">
                                <label>API Key</label>
                                <input value="<?= $calender->api_key ?>"  name="api_key" placeholder="API Key" type="text"  class="form-control" required=""/>
                            </div>

                            <div class="form-group">
                                <ul class="instruction">
                                    <li>First Open  <a href="https://console.developers.google.com/project/">
                                            https://console.developers.google.com/project/ 
                                        </a> and login with google account.
                                    </li>
                                    <li>Create a new project.</li>
                                    <li>Enter your project name.</li>
                                    <li>Click on APIs & auth from left an sidebar and click on Credentials</li>
                                    <li>Click on 'create Client ID' and choose 'web application' click on configure consent screen.</li>
                                    <li>On Consent screen Enter Project name as a 'Wish-Fish' and save it.</li>
                                    <li class="copy">Enter Authorized redirect URIs "<span class="copyText">https://www.wish-fish.com/admin/calender</span>".</li>
                                    <li>Copy Client ID and Client secret key and paste it on above setting form.</li>
                                    <li>Click on 'Create new key' and select 'Server key'.</li>
                                    <li>Enter following IP Address '50.28.18.90'.</li>
                                    <li>Copy API key and paste it on above setting form.</li>
                                </ul>
                            </div>
                        </div>
                        <input type="submit" id="setting_submit" style="display: none" />
                    </form>
                </div><!-- /.box -->
            </div><!--/.col (left) -->
            <div class="col-md-3"></div>
            <!-- right column -->
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->


<script type="text/javascript">
    $(document).ready(function (e) {
        $('.copyText').click(
                function () {
                    if ($('#tmp').length) {
                        $('#tmp').remove();
                    }
                    var clickText = $(this).text();
                    $('<textarea id="tmp" />')
                            .appendTo($(this))
                            .val(clickText)
                            .focus()
                            .select();
                    return false;
                });
        $(':not(.copyText)').click(
                function () {
                    $('#tmp').remove();
                });

        $('#save-setting').click(function () {
            $('#setting_submit').trigger('click');
        });
    });
</script>
