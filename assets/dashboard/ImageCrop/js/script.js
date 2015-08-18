$(document).ready(createUploader);
$(document).ready(function () {
    var thumb = $(".thumbnails");

    $('#thumbnail').imgAreaSelect({aspectRatio: '1:1', onSelectChange: preview});

    $('#save_thumb').click(function () {
        var x1 = $('#x1').val();
        var y1 = $('#y1').val();
        var x2 = $('#x2').val();
        var y2 = $('#y2').val();
        var w = $('#w').val();
        var h = $('#h').val();
        if (x1 == "" || y1 == "" || x2 == "" || y2 == "" || w == "" || h == "") {
            alert("You must make a selection first");
            return false;
        }
        else {
            $.ajax({
                type: 'POST',
                url: "https://wish-fish.com/imagecrop/crop_script.php",
                data: "filename=" + $('#filename').val() + "&x1=" + x1 + "&x2=" + x2 + "&y1=" + y1 + "&y2=" + y2 + "&w=" + w + "&h=" + h,
                success: function (data) {
                    thumb.attr('src', 'https://wish-fish.com/uploads/thumb_' + $('#filename').val());
                    thumb.addClass('thumbnail');
                    $('#thumbnail').imgAreaSelect({hide: true, x1: 0, y1: 0, x2: 0, y2: 0});
                    // let's clear the modal
                    $('#thumbnail').attr('src', '');
                    $('#crop-section').hide();
                    $('#uploader-section').show();
                    $('#thumb_preview').attr('src', '');
                    $('#filename').attr('value', '');
                }
            });

            return true;
        }
    });
});

function createUploader() {
    var button = $('#upload');
    var uploader = new qq.FileUploaderBasic({
        button: document.getElementById('file-uploader'),
        action: 'https://wish-fish.com/imagecrop/upload.php',
        allowedExtensions: ['jpg', 'gif', 'png', 'jpeg'],
        onSubmit: function (id, fileName) {
            // change button text, when user selects file			
            button.text('Uploading');
            // Uploding -> Uploading. -> Uploading...
            interval = window.setInterval(function () {
                var text = button.text();
                if (text.length < 13) {
                    button.text(text + '.');
                } else {
                    button.text('Uploading');
                }
            }, 200);
        },
        onComplete: function (id, fileName, responseJSON) {
            button.text('Change profile picture');
            window.clearInterval(interval);

            if (responseJSON['success'])
            {
                load_original(responseJSON['filename']);
            }
        },
        debug: true
    });
}

function load_original(filename) {
    $('#thumbnail').attr('src', "https://wish-fish.com/uploads/" + filename);
    $('#thumb_preview').attr('src', "https://wish-fish.com/uploads/" + filename);
    $('#filename').attr('value', filename);
    if ($.browser.msie) {
        $('#thumb_preview_holder').remove();
    }
    $('#crop-section').show();
    $('#uploader-section').hide();
}

function preview(img, selection) {
    var mythumb = $('#thumbnail');
    var scaleX = 156 / selection.width;
    var scaleY = 156 / selection.height;

    $('#thumbnail + div > img').css({
        width: Math.round(scaleX * mythumb.outerWidth()) + 'px',
        height: Math.round(scaleY * mythumb.outerHeight()) + 'px',
        marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px',
        marginTop: '-' + Math.round(scaleY * selection.y1) + 'px'
    });
    $('#x1').val(selection.x1);
    $('#y1').val(selection.y1);
    $('#x2').val(selection.x2);
    $('#y2').val(selection.y2);
    $('#w').val(selection.width);
    $('#h').val(selection.height);
}