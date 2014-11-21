function friend_request(id) {
    $.ajax({
        type:'POST',
        url: Routing.generate('application_sonata_user_friend_request'),
        data: 'id='+id,
        dataType: 'json',
        success: function(data) {
            $('#btn').html('Friend Request Sent');
        },
        error: function (err, status, thrown) {
            alert('An unexpeded error occured.'+'('+err.status+' '+thrown.message+')');
        },
    });
}