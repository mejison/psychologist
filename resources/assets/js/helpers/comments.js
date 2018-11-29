$( document ).ready(function() {
    $('#sendComment').click(function (event) {
        var message = $('#messageComment').val();
        var data = {'message':message };
        if (message.length>0){
            axios.post('/sendCommentMessage',data)
                .then(function (response) {
                    swal('Succes','Besked sendt!','success');
                })
                .catch(function (error) {
                    swal('Fejl','En serverfejl.','error');
                });
        }else {
            swal('Fejl','Udfylde kommentar formular!','error');
        }

        var messageBox = $('#message-content');

        $('.message-button').addClass('open-popup');
        $('.message-button').removeClass('close-popup');
        $(".overlay").fadeOut(300);
        $( '.message-button').animate({
            right: 0,
        }, 300, function() {
            // Animation complete.
        });

        $( messageBox ).animate({
            right: -messageBox.outerWidth(),
        }, 300, function() {
            // Animation complete.
        });

        $('#messageComment').val('');

        event.preventDefault();
    });
});