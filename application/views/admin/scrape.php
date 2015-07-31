<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="display: none">
            Import Contact
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary parse">
                    <div class="box-header">
                        <h3 class="box-title">Import Contact</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <form id="parseForm" method="post">
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Import From</label>
                                        <select name="type" id="type"  class="form-control" required="">
                                            <option value="facebook" selected="">Facebook</option>
                                            <option value="linkedin">LinkedIn</option>
                                            <option value="twitter">Twitter</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <label id="title">Facebook Username</label>
                                    <input name="url" id="url"  type="text" class="form-control" required=""/>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div style="text-align: right" class="col-md-8">
                                    <button class="btn btn-success" type="submit" id="parse">Get Contact</button>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                            <div style="display: none;margin-top: 10px" class="alert alert-danger alert-dismissable">
                                <!--<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>-->
                                <span class="errorMsg"></span> 
                            </div>
                        </form>
                    </div>
                    <div class="overlay" style="display: none"></div>
                    <div class="loading-img" style="display: none"></div>
                </div>
                <div class="box box-solid box-primary contactInfo" style="display: none">
                    <div class="box-header">
                        <h3 class="box-title">Contact Information</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-3">
                                <img style="width: 100px" class="picture" src="#" alt="profile picture" />
                            </div>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h4><label>First Name</label></h4>
                                    </div>
                                    <div class="col-md-8">
                                        <h4 class="fname"></h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <h4><label>Last Name</label></h4>
                                    </div>
                                    <div class="col-md-8">
                                        <h4 class="lname"></h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <button class="btn btn-success btn-sm save" type="button">
                                            Add in Contact List
                                        </button> 
                                    </div>
                                    <div class="col-md-4">
                                        <button class="btn btn-danger btn-sm cancel" type="button">
                                            Go Back
                                        </button> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="display: none;margin-top: 10px" class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <span class="successMsg"></span> 
                        </div>
                    </div><!-- /.box-body -->
                    <div class="overlay" style="display: none"></div>
                    <div class="loading-img" style="display: none"></div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
        <div class="row">
            <div class="col-md-12 temp">

            </div>
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->
<!-- /.modal -->
<script type="text/javascript">
    $(document).ready(function () {

        $('.contactInfo .cancel').click(function () {
            $('.contactInfo').hide();
            $('span.successMsg').hide();
            $('#type').val("facebook");
            $('.save').show();
            $('#title').val("Facebook Username");
            $('#url').val('');
            $('.picture').prop('src', '#');
            $('.parse').show();
        });
        $('#type').change(function () {
            var type = $(this).val();
            if (type == "facebook") {
                $('#title').text("Facebook Username");
            } else if (type == "linkedin") {
                $('#title').text("LinkedIn Profile Url");
            } else {
                $('#title').text("Twitter Username");
            }
        });
        $('#parseForm').submit(function () {
            var type = $('#type').val();
            $('.parse .overlay').show();
            $('.parse .loading-img').show();
            if (type == "facebook") {
                facebook();
            } else if (type == "linkedin") {
                linkedin();
            } else {
                twitter();
            }
            return false;
        });
        function facebook() {
            $.ajax({
                type: 'POST',
                data: {userid: $('#url').val()},
                url: "<?= site_url() ?>admin/scrape/facebook",
                success: function (data, textStatus, jqXHR) {
                    $('.parse .overlay').hide();
                    $('.parse .loading-img').hide();

                    if (data == "0") {
                        $('.parse .alert').show();
                        $('span.errorMsg').text("Please Enter Valid Username..!");
                    } else if (data == "1") {
                        $('.parse .alert').show();
                        $('span.errorMsg').text("Your Profile Is Not Visible Publically..!");
                    } else {
                        var json = JSON.parse(data);
                        var name = json.name.split(' ');
                        $('.parse').hide();
                        $('.fname').text(name[0]);
                        $('.lname').text(name[1]);
                        $('.picture').prop('src', json.profile);
                        $('.contactInfo').show();
                    }
                }
            });
        }

        function linkedin() {
            $.ajax({
                type: 'POST',
                data: {url: $('#url').val()},
                url: "<?= site_url() ?>admin/scrape/linkedin",
                success: function (data, textStatus, jqXHR) {
                    var _html = $(data);
                    $('.parse .overlay').hide();
                    $('.parse .loading-img').hide();
                    console.log();
                    var name = _html.find('span.full-name').text().split(' ');
                    $('.parse').hide();
                    $('.fname').text(name[0]);
                    $('.lname').text(name[1]);
                    $('.picture').prop('src', _html.find('.profile-picture img').prop('src'));
                    $('.contactInfo').show();
                }
            });
        }

        function twitter() {
            $.ajax({
                type: 'POST',
                data: {userid: $('#url').val()},
                url: "<?= site_url() ?>admin/scrape/twitter",
                success: function (data, textStatus, jqXHR) {
                    var _html = $(data);
                    $('.parse .overlay').hide();
                    $('.parse .loading-img').hide();
                    var name = _html.find('h1.ProfileHeaderCard-name a').text().split(' ');
                    $('.parse').hide();
                    $('.fname').text(name[0]);
                    $('.lname').text(name[1]);
                    $('.picture').prop('src', _html.find('.ProfileAvatar img').prop('src'));
                    $('.contactInfo').show();
                }
            });
        }

        $('.contactInfo .save').on('click', function () {
            $('.contactInfo .overlay').show();
            $('.contactInfo .loading-img').show();
            $.ajax({
                type: 'POST',
                data: {
                    type: $('#type').val(),
                    fname: $('.fname').text(),
                    lname: $('.lname').text(),
                    url: $('.picture').prop('src')
                },
                url: "<?= site_url() ?>admin/scrape/addContact",
                success: function (data, textStatus, jqXHR) {
                    $('.contactInfo .overlay').hide();
                    $('.contactInfo .loading-img').hide();
                    $('.save').hide();
                    $('.contactInfo .alert').show();
                    $('span.successMsg').text("Contact has been successfully created..!");
                }
            });
        });
    });
</script>