<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="margin-left: 15%;float: left">Google Calender Setting</h1>
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
                    <form id="userForm" role="form" action="<?= site_url() ?>app/setting/updateSetting" method="post">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Application Name</label>
                                <input value="<?= $setting->app_name ?>" type="text" name="app_name" autofocus="autofocus" class="form-control" placeholder="Application Name" required=""/>
                            </div>
                            <div class="form-group">
                                <label>Client Id</label>
                                <input value="<?= $setting->client_id ?>"  name="client_id" placeholder="Client Id" type="text"  class="form-control" required=""/>
                            </div>
                            <div class="form-group">
                                <label>Client Secret</label>
                                <input value="<?= $setting->client_secret ?>"  name="client_secret" placeholder="Client Secret" type="text"  class="form-control" required=""/>
                            </div>
                            <div class="form-group">
                                <label>Redirect URI</label>
                                <input value="<?= $setting->redirect_uri ?>"  name="redirect_uri" placeholder="Redirect URI" type="text"  class="form-control" disabled=""/>
                            </div>
                            <div class="form-group">
                                <label>API Key</label>
                                <input value="<?= $setting->api_key ?>"  name="api_key" placeholder="API Key" type="text"  class="form-control" required=""/>
                            </div>

                            <div class="form-group">
                                <ul>
                                    <li>1. First Open  <a href="https://console.developers.google.com/project/">
                                            https://console.developers.google.com/project/ 
                                        </a> and login with google account.
                                    </li>
                                    <li>2. Create a new project.</li>
                                    <li>3. Enter your project name.</li>
                                    <li>4. Click on APIs & auth from left an sidebar and click on Credentials</li>
                                    <li>4. Click on 'create Client ID' and choose 'web application' click on configure consent screen.</li>
                                    <li>5. On Consent screen Enter Project name as a 'Wish-Fish' and save it.</li>
                                    <li>6. Enter Authorized redirect URIs "https://www.wish-fish.com/app/calender".</li>
                                    <li>7. Copy Client ID and Client secret key and paste it on above setting form.</li>
                                    <li>8. Click on 'Create new key' and select 'Server key'.</li>
                                    <li>9. Enter following IP Address '50.28.18.90'.</li>
                                    <li>9. Copy API key and paste it on above setting form.</li>
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
        $('#save-setting').click(function () {
            $('#setting_submit').trigger('click');
        });
    });
</script>
