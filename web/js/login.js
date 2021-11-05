
$(document).on('submit', '#login_form', function (event) {
    var username = $("#input_username").val();
    var formData = {
        username: username,
    };
    $.ajax({
        type: "POST",
        url: "site/login",
        data: formData,
        success: function(msg){
            if(msg.status == 'ok') {
                $.pjax.reload({container:"#header_block",async:false});
                $.pjax.reload({container:"#all_comments",async:false});

            }
        }
    });
    event.preventDefault();
});