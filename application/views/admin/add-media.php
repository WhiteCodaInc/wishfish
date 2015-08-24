<script src="<?= base_url() ?>assets/dashboard/js/jquery.form.min.js" type="text/javascript"></script>
<style>
    #progressbox {
        border: 1px solid #0099CC;
        padding: 1px; 
        position:relative;
        width:340px;
        border-radius: 3px;
        margin: 10px 0;
        display:none;
    }
    #progressbar {
        height:20px;
        border-radius: 3px;
        background-color: #5cb85c;
        border-color: #4cae4c;
        width:1%;
    }
    #statustxt {
        top:3px;
        left:50%;
        position:absolute;
        display:inline-block;
        color: #000000;
    }
</style>
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="display: none">
            <?= (isset($media)) ? "Edit Existing Media" : "Add New Media" ?>
        </h1>
        <button class="save btn btn-primary">Save</button>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary media">
                    <div class="box-header">
                        <h3 class="box-title"><?= (isset($media)) ? $media->name : "New Media" ?></h3>
                    </div><!-- /.box-header -->
                    <?php $method = (isset($media)) ? "updateMedia" : "createMedia" ?>
                    <!-- form start -->
                    <div class="box-body">
                        <form id="mediaForm" role="form" action="<?= site_url() ?>admin/media/<?= $method ?>" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input value="<?= isset($media) ? $media->name : '' ?>" type="text" autofocus="autofocus" name="name" class="form-control" placeholder="Media Name" required=""/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Choose Media Category</label>
                                        <select name="type" class="form-control" required="">
                                            <option value="audio">Audio</option>
                                            <option value="picture">Picture</option>
                                            <option value="video">Video</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Upload</label>
                                        <input name="upload"  type="file" class="form-control" id="imageInput"  required=""/>
                                    </div>
                                </div>
                            </div>
                            <?php if (isset($media) && ($media->path != NULL)): ?>
                                <?php if ($media->type == "picture") { ?>
                                    <?php
                                    $img_src = "http://mikhailkuznetsov.s3.amazonaws.com/" . $media->path;
                                    ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <img src="<?= $img_src ?>" alt="<?= $media->name ?>" />
                                            </div>
                                        </div>
                                    </div>
                                <?php } else if ($media->type == "video") { ?>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div id='mediaplayer'></div>
                                            <script type='text/javascript' src='https://d2f058tgxz31a7.cloudfront.net/video_setting/jwplayer.js'></script>
                                            <script type="text/javascript">
                                                jwplayer('mediaplayer').setup({
                                                    file: 'rtmp://s12e6wqr7fb3zu.cloudfront.net/cfx/st/<?= $media->path ?>',
                                                    width: "340",
                                                    height: "238"
                                                });
                                            </script>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <audio controls>
                                                    <source src="https://d2f058tgxz31a7.cloudfront.net/<?= $media->path ?>" type="audio/mpeg">
                                                </audio>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php endif; ?>
                            <!--<div class="row progress_bar" style="display:  none">-->
                            <!--<div class="col-md-12">-->
                            <div id="progressbox" style="display:none;">
                                <div id="progressbar"></div>
                                <div id="statustxt">0%</div>
                            </div>
                            <div id="output"></div>
                            <!--</div>-->
                            <!--</div>-->
                            <div class="row">
                                <div class="col-md-12">
                                    <button id="save" type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                            <?php if (isset($media)): ?>
                                <input type="hidden" name="mediaid" value="<?= $media->media_id ?>" />
                            <?php endif; ?>
                        </form>
                    </div>
                    <!--                    <div class="overlay" style="display: none"></div>
                                        <div class="loading-img" style="display: none"></div>-->
                </div><!-- /.box -->
            </div><!--/.col (left) -->
            <!-- right column -->
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->
</div><!-- ./wrapper -->



<script type="text/javascript">
    $(document).ready(function () {
<?php if (isset($media)): ?>
            $('select[name="type"]').val("<?= $media->type ?>");
<?php endif; ?>
        $('button.save').click(function () {
            $(this).prop('disabled', true);
            $('#save').trigger('click');
        });

        var progressbox = $('#progressbox');
        var progressbar = $('#progressbar');
        var statustxt = $('#statustxt');
        var completed = '0%';

        var options = {
            target: '#output', // target element(s) to be updated with server response 
            beforeSubmit: beforeSubmit, // pre-submit callback 
            uploadProgress: OnProgress,
            success: afterSuccess, // post-submit callback 
            resetForm: true        // reset the form after successful submit 
        };

        $('#mediaForm').submit(function () {
            $('button.save').prop('disabled', true);
            $('#save').prop('disabled', true);
//            $('.media .overlay').show();
//            $('.media .loading-img').show();
//            $('.progress_bar').show();
            $(this).ajaxSubmit(options);
            // return false to prevent standard browser submit and page navigation 
            return false;
        });
        function OnProgress(event, position, total, percentComplete)
        {
            //Progress bar
            progressbar.width(percentComplete + '%'); //update progressbar percent complete
            statustxt.html(percentComplete + '%'); //update status text
            if (percentComplete > 50)
            {
                statustxt.css('color', '#fff'); //change status text to white after 50%
            }
        }
        function afterSuccess()
        {
            $url = "<?= (isset($media)) ? site_url() . 'admin/media?msg=U' : site_url() . 'admin/media?msg=I' ?>";
            window.location.replace($url);
        }
        function beforeSubmit() {
            //check whether browser fully supports all File API
            if (window.File && window.FileReader && window.FileList && window.Blob)
            {

                if (!$('#imageInput').val()) //check empty input filed
                {
                    $("#output").html("Are you kidding me?");
                    return false
                }

                var fsize = $('#imageInput')[0].files[0].size; //get file size
                var ftype = $('#imageInput')[0].files[0].type; // get file type

                //allow only valid image file types 
                switch (ftype)
                {
                    case 'image/png':
                    case 'image/gif':
                    case 'image/jpeg':
                    case 'image/pjpeg':
                        break;
                    default:
                        $("#output").html("<b>" + ftype + "</b> Unsupported file type!");
                        return false
                }

                //Allowed file size is less than 1 MB (1048576)
                if (fsize > 1048576)
                {
                    $("#output").html("<b>" + bytesToSize(fsize) + "</b> Too big Image file! <br />Please reduce the size of your photo using an image editor.");
                    return false
                }

                //Progress bar
                progressbox.show(); //show progressbar
                progressbar.width(completed); //initial value 0% of progressbar
                statustxt.html(completed); //set status text
                statustxt.css('color', '#000'); //initial color of status text


//                $('#submit-btn').hide(); //hide submit button
//                $('#loading-img').show(); //hide submit button
//                $("#output").html("");
            }
            else
            {
                //Output error to older unsupported browsers that doesn't support HTML5 File API
                $("#output").html("Please upgrade your browser, because your current browser lacks some new features we need!");
                return false;
            }
            //function to format bites bit.ly/19yoIPO
            function bytesToSize(bytes) {
                var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
                if (bytes == 0)
                    return '0 Bytes';
                var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
                return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
            }
        }
    });
</script>