<div class="row m-bot15">
    <div class="col-md-12">
        <h3><?= $blog->title ?></h3>
    </div>
</div>
<?php if ($blog->feature_video != ""): ?>
    <div class="row m-bot15">
        <div class="col-md-12">
            <div id='mediaplayer'></div>

            <script type="text/javascript">
                jwplayer('mediaplayer').setup({
                    file: 'rtmp://s12e6wqr7fb3zu.cloudfront.net/cfx/st/video/<?= $blog->feature_video ?>',
                    width: "auto",
                    height: "300"
                });
            </script>
        </div>
    </div>
<?php endif; ?>
<br/>
<div class="row">
    <div class="col-md-12">
        <?= $blog->content ?>
    </div>
</div>