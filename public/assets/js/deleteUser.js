$('.deleteUser').on('click',function () {
   onDeleteUser(this);
});
function onDeleteUser(_this) {
    var id = $(_this).attr('data-id');
    $.ajax({
        url : '/admin/user/delete/'+id+'',
        type : 'DELETE',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function () {
            $(_this).parents('.gradeX').first().remove();
        }
    });
};