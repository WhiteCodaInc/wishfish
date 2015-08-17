<div class="row m-bot15">
    <div class="col-md-12">
        <h3><?= $media->name ?></h3>
    </div>
</div>
<div class="row m-bot15">
    <div class="col-md-12">
        <div id='mediaplayer'></div>
        <script type="text/javascript">
            jwplayer('mediaplayer').setup({
//                file: 'rtmp://s12e6wqr7fb3zu.cloudfront.net/cfx/st/<?= $media->path ?>',
                file: 'rtmp://s12e6wqr7fb3zu.cloudfront.net/cfx/st/video/video_14.mp4',
                width: "auto",
                height: "300"
            });
        </script>
    </div>
</div>