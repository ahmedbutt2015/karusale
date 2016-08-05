$('.on-editing').on('click',function () {
    onEditClick(this);
});
function onEditClick(_this) {
    var name = $(_this).parent().siblings('.name').children();
    var email = $(_this).parent().siblings('.email').children();
    var verified = $(_this).parent().siblings('.verified').children();
    var id = $(_this).parent().siblings('input').first().val();
    $.ajax({
        url : '/admin/user/edit/'+id,
        type : 'PUT',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data : {
            name : name.val(),
            email : email.val(),
            verified : verified.val()
        },
        success : function () {
            $('.deleteUser').on('click',function () {
                onDeleteUser(this);
            });
        }
    });
}