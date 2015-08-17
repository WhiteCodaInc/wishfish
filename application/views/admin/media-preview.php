<div id='mediaplayer'></div>
<script type="text/javascript">
    jwplayer('mediaplayer').setup({
        file: 'rtmp://s12e6wqr7fb3zu.cloudfront.net/cfx/st/<?= $media->path ?>',
        width: "auto",
        height: "300"
    });
</script>