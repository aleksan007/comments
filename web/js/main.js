
$(document).ready(function() {

});

$(document).on('click', 'reply', function () {
    var id_comment = $(this).attr('attr_id_comment');
    var modal =  $('#modal');

    modal.attr('action','comment/reply');
    modal.find('#comment_input').attr('id_comment',id_comment);
    modal.find('#comment_input').val('');
    modal.modal('show');
});


$(document).on('click', 'change', function () {
    var id_comment = $(this).attr('attr_id_comment');
    var text = $(this).parent('.comment').find('text').html();
    var modal =  $('#modal');

    modal.modal('show');
    modal.attr('action','comment/update');
    modal.find('#comment_input').attr('id_comment',id_comment);
    modal.find('#comment_input').val(text);
});

$(document).on('click', 'delete', function () {
    var id_comment = $(this).attr('attr_id_comment');
    if(confirm('Вы действительно хотите удалить коммент?')) {
        $.ajax({
            type: "POST",
            url: "comment/delete",
            data: {"id_comment":id_comment},
            success: function(msg){
                if(msg.status == 'ok') {
                    $.pjax.reload({container:"#all_comments",timeout: false});
                }
            }
        });
    };
});

$(document).on('click', '#saveComment', function () {
    var text = $('#comment_input').val();
    var id_comment = $('#comment_input').attr('id_comment');
    var action =  $('#modal').attr('action');

    if (text !== '') {
        $.ajax({
            type: 'POST',
            url: action,
            data: {"id_comment":id_comment,"text":text},
            success: function(msg){
                 if(msg.status == 'ok')
                 {
                     $.pjax.reload({container:"#all_comments",timeout: false});
                     $('#modal').modal('hide');
                 } else {
                     $('#modal').find('#status_messages').html(msg.message);
                 }
            }
        });
    } else {
        alert('Комментарий не может быть пустым');
    }

});

$(document).on('submit', '#new_message_form', function (event) {
    var text_field = $("#comments-text");
    var formData = {
        text: text_field.val(),
    };

    $.ajax({
        type: "POST",
        url: "comment/new",
        data: formData,
        success: function(msg){
            if(msg.status == 'ok') {
                $.pjax.reload({container:"#all_comments",timeout: false});
                text_field.val('');
            }
        }
    });
    event.preventDefault();
});