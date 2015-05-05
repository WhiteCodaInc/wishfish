<!-- header logo: style can be found in header.less -->
<?php
//$CI = & get_instance();
//$CI->load->library("common");
?>
<style type="text/css">
    #image_preview > img {
        z-index: 5;
        height: 90px;
        width: 90px;
        border: 8px solid;
        border-color: transparent;
        border-color: rgba(255, 255, 255, 0.2);
    }
</style>
<header class="header">
    <?php
    $profile_pic = $this->session->userdata('profile_pic');

    $img_src = ($profile_pic != "") ?
            "http://mikhailkuznetsov.s3.amazonaws.com/" . $profile_pic :
            base_url() . 'assets/dashboard/img/default-avatar.png';
    ?>
    <a href="#" class="logo">
        <!-- Add the class icon to your logo image or logo icon to add the margining -->
        <?= $this->session->userdata('name') ?> 
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <div class="navbar-right">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->
                <!--                <li class="dropdown messages-menu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <i class="fa fa-envelope"></i>
                                        <span class="label label-success">
                                            4
                                        </span>
                                    </a>
                
                                    <ul class="dropdown-menu">
                                        <li class="header">You have 4 messages</li>
                                        <li>
                                             inner menu: contains the actual data 
                                            <ul class="menu">
                                                <li> start message 
                                                    <a href="#">
                                                        <div class="pull-left">
                                                            <img style="width:60px;height:60px" src="<?= base_url() . 'assets/dashboard/img/default-avatar.png' ?>" class="img-circle" alt="User Image"/>
                                                        </div>
                                                        <h4>
                                                            Joie Desouza
                                                            <small><i class="fa fa-clock-o"></i> 2 hours</small>
                                                        </h4>
                                                        <p>Hello Joie</p>
                                                    </a>
                                                </li> end message 
                                            </ul>
                                        </li>
                                        <li class="footer"><a href="#">See All Messages</a></li>
                                    </ul>
                                </li>-->
                <!-- Notifications: style can be found in dropdown.less -->
                <!--                <li class="dropdown notifications-menu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <i class="fa fa-warning"></i>
                                        <span class="label label-warning">10</span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="header">You have 10 notifications</li>
                                        <li>
                                             inner menu: contains the actual data 
                                            <ul class="menu">
                                                <li>
                                                    <a href="#">
                                                        <i class="ion ion-ios7-people info"></i> 5 new members joined today
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        <i class="fa fa-warning danger"></i> Very long des="#">cription here that may not fit into the page and may cause design problems
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        <i class="fa fa-users warning"></i> 5 new members joined
                                                    </a>
                                                </li>
                
                                                <li>
                                                    <a href="#">
                                                        <i class="ion ion-ios7-cart success"></i> 25 sales made
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        <i class="ion ion-ios7-person danger"></i> You changed your username
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="footer"><a href="#">View all</a></li>
                                    </ul>
                                </li>-->
                <!-- Tasks: style can be found in dropdown.less -->
                <!--                <li class="dropdown tasks-menu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <i class="fa fa-tasks"></i>
                                        <span class="label label-danger">9</span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="header">You have 9 tasks</li>
                                        <li>
                                             inner menu: contains the actual data 
                                            <ul class="menu">
                                                <li> Task item 
                                                    <a href="#">
                                                        <h3>
                                                            Design some buttons
                                                            <small class="pull-right">20%</small>
                                                        </h3>
                                                        <div class="progress xs">
                                                            <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                                <span class="sr-only">20% Complete</span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li> end task item 
                                                <li> Task item 
                                                    <a href="#">
                                                        <h3>
                                                            Create a nice theme
                                                            <small class="pull-right">40%</small>
                                                        </h3>
                                                        <div class="progress xs">
                                                            <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                                <span class="sr-only">40% Complete</span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li> end task item 
                                                <li> Task item 
                                                    <a href="#">
                                                        <h3>
                                                            Some task I need to do
                                                            <small class="pull-right">60%</small>
                                                        </h3>
                                                        <div class="progress xs">
                                                            <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                                <span class="sr-only">60% Complete</span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li> end task item 
                                                <li> Task item 
                                                    <a href="#">
                                                        <h3>
                                                            Make beautiful transitions
                                                            <small class="pull-right">80%</small>
                                                        </h3>
                                                        <div class="progress xs">
                                                            <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                                <span class="sr-only">80% Complete</span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li> end task item 
                                            </ul>
                                        </li>
                                        <li class="footer">
                                            <a href="#">View all tasks</a>
                                        </li>
                                    </ul>
                                </li>-->
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="glyphicon glyphicon-user"></i>
                        <span><i class="caret"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header bg-light-blue">
                            <form id="profileForm" method="post" action="" enctype="multipart/form-data">
                                <input name="profile" style="position: absolute;left: -9999px" id="profile-image-upload" class="hidden" type="file">
                                <div id="image_preview">
                                    <img id="profile_pic" style="cursor: pointer;" src="<?= $img_src ?>" class="img-circle" alt="User Image" />
                                </div>
                                <p>
                                    <?= $this->session->userdata('name') ?> <!-- - Web Developer -->
                                    <!--<small>Member since Nov. 2012</small>-->
                                </p>
                            </form>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <h4 id='loading' style="display:none;">loading...</h4>
                            <div id="msg"></div>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?= site_url() ?>app/profile" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="<?= site_url() ?>app/logout" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <script type="text/javascript">
            $(function () {
                $('#profile_pic').on('click', function () {
                    $('#profile-image-upload').click();
                });
            });

        </script>
        <script type="text/javascript">
            $(document).ready(function (e) {
                // Function to preview image
                $("#profileForm input:file").change(function () {
                    $("#msg").empty(); // To remove the previous error message
                    var file = this.files[0];
                    var imagefile = file.type;
                    var match = ["image/jpeg", "image/png", "image/jpg", "image/gif"];
                    if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]) || (imagefile == match[3])))
                    {
                        $("#msg").html("<p id='error' style='color:red'>Please Select A valid Image File<br>" + "<span id='error_message'>Only jpeg, jpg and png Images type allowed</span></p>");
                        return false;
                    }
                    else
                    {
                        var reader = new FileReader();
                        reader.onload = imageIsLoaded;
                        reader.readAsDataURL(this.files[0]);
                    }
                    $('#profileForm').submit();
                });
                function imageIsLoaded(e) {
                    $("#image_preview").css("display", "block");
                    $("#profile_pic").attr('src', e.target.result);
                }

                //Upload Image Form Submit
                $('#profileForm').on('submit', (function (e) {
                    e.preventDefault();
                    $("#msg").empty();
                    $("#loading").show();
                    $.ajax({
                        url: "<?= site_url() ?>app/dashboard/uploadProfilePic", // Url to which the request is send
                        type: "POST", // Type of request to be send, called as method
                        data: new FormData(this), // Data sent to server, a set of key/value pairs representing form fields and values 
                        contentType: false, // The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
                        cache: false, // To unable request pages to be cached
                        processData: false, // To send DOMDocument or non processed data file it is set to false (i.e. data should not be in the form of string)
                        success: function (data)  		// A function to be called if request succeeds
                        {
                            $("#loading").hide();
                            $("#msg").html(data);
                            $("#msg").fadeOut(7000);
                        }
                    });
                }));
            });
        </script>
    </nav>
</header>