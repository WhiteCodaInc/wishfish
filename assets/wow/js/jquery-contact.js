jQuery(document).ready(function () {


    $('button[data-loading-text]')
            .on('click', function () {
                var btn = $(this);
                btn.button('loading');
                setTimeout(function () {
                    btn.button('reset');
                }, 3000);
            });


    $('#contactform').submit(function () {

        var action = $(this).attr('action');

        $("#message").slideUp(750, function () {
            $('#message').hide();
            $.post(action, {
                name: $('#name').val(),
                email: $('#email').val(),
                subject: $('#subject').val(),
                msg: $('#inquiry_msg').val(),
            },
                    function (data) {
                        document.getElementById('message').innerHTML = data;
                        $('#message').slideDown('slow');
                        $('#submit').removeAttr('disabled');
                        if (data.match('success') != null)
                            $('#contactform').slideUp('slow');

                    }
            );

        });

        return false;

    });

    $('#register').submit(function () {

        var action = $(this).attr('action');

        $("#message").slideUp(750, function () {
            $('#message').hide();
            $.post(action, {
                name: $('#name').val(),
                email: $('#email').val(),
                number: $('#number').val(),
            },
                    function (data) {
                        document.getElementById('message').innerHTML = data;
                        $('#message').slideDown('slow');
                        $('#submit').removeAttr('disabled');
                        if (data.match('success') != null)
                            $('#register').slideUp('slow');

                    }
            );

        });

        return false;

    });

});