$('#addUserBtn').on('click',function () {

    var t = '<tr role="row" class="adding odd">'+
        '<td class="name"><input placeholder="Full name" type="text" name="name" class="form-control input-block"></td>'+
        '<td class="email"><input placeholder="Email" type="email" name="email" class="form-control input-block"></td>'+
        '<td class="password"><input placeholder="Password" type="password" name="password" class="form-control input-block"></td>'+
        '<td style="cursor: pointer"><i  class="addUser fa fa-save" style="margin-right: 15px"></i>' +
        '<a href="#" class="cancelTemp cancel-row"><i class="fa fa-times"></i></a></td>'+
        '</tr>';
    $('tbody').prepend(t);

    $(this).attr('disabled',true);

    $('.cancelTemp').on('click',function () {
        $('#addUserBtn').attr('disabled',false);
    });

    $('.addUser').bind('click',addUser);
});

function addUser() {
    $('#addUserBtn').attr('disabled',false);
    var name = $('.addUser').parent().siblings('.name').children().val();
    var email = $('.addUser').parent().siblings('.email').children().val();
    var password = $('.addUser').parent().siblings('.password').children().val();
    $.ajax({
        url : '/admin/user/add',
        type : 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data : {
            name : name,
            email : email,
            password : password
        },
        success: function (res) {
            if(res.add){
                $('.addUser').parents('tr').remove();
                var temp = '<tr role="row" class="gradeX odd">'+
                '<input type="hidden" name="id" value="'+res.id+'">'+
                '<td class="name sorting_1">'+name+'</td>'+
                '<td class="email">'+email+'</td>'+
                '<td class="verified">1</td>'+
                '<td class="actions">'+
                    '<a href="#" class="hidden on-editing save-row glyphicon glyphicon-edit"></a>'+
                    '<a href="#" class="hidden on-editing cancel-row"><i class="fa fa-times"></i></a>'+
                    '<a href="#" class="on-default edit-row"><i class="fa fa-pencil"></i></a>'+
                    '<a style="cursor: pointer" data-id="'+res.id+'" class="on-default deleteUser"><i class="fa fa-trash-o"></i></a>'+
                    '</td>'+
                '</tr>';
                $('tbody').prepend(temp);

                $('.on-editing').on('click',function () {
                    onEditClick(this);
                });
                $('.deleteUser').on('click',function () {
                    onDeleteUser(this);
                });
                location.reload();
            }
        }
    });
}