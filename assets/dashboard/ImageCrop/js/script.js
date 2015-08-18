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
                url: "https://wish-fish.com/app/crop",
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
    console.log("FIRST CALL");
    var uploader = new qq.FileUploaderBasic({
        button: document.getElementById('file-uploader'),
        action: 'https://wish-fish.com/app/upload',
        allowedExtensions: ['jpg', 'gif', 'png', 'jpeg'],
        onSubmit: function (id, fileName) {
            // change button text, when user selects file			
            console.log("SUBMIT CALLED");
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
            console.log("COMPLETE");
            console.log(responseJSON);
            if (responseJSON['success'])
            {
                console.log("SUCCESS");
                load_original(responseJSON['filename']);
            } else {
                console.log("FAILD");
            }
        },
        debug: true
    });
}

function load_original(filename) {
    console.log("PREVIEW");
    console.log("THUMBNAIL : " + "https://wish-fish.com/uploads/" + filename);
    $('#crop-modal #thumbnail').attr('src', "https://wish-fish.com/uploads/" + filename);
    $('#crop-modal #thumb_preview').attr('src', "https://wish-fish.com/uploads/" + filename);
    $('#crop-modal #filename').attr('value', filename);
//    if ($.browser.msie) {
//        $('#crop-modal #thumb_preview_holder').remove();
//    }
    $('#crop-modal #crop-section').show();
    $('#crop-modal #uploader-section').hide();
}

function preview(img, selection) {
    var mythumb = $('#crop-modal #thumbnail');
    var scaleX = 156 / selection.width;
    var scaleY = 156 / selection.height;

    $('#crop-modal #thumbnail + div > img').css({
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