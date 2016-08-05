$('.confirm-password').on('keyup',function () {
    var password = $(".password").val(),
        re_password = $(".confirm-password").val();

    if($.trim(password) === $.trim(re_password)){
        $('.btn-default').attr('disabled', false);
        $('.passwordStatus').text('Password match');
    }else{
        $('.btn-default').attr('disabled', true);
        $('.passwordStatus').text('Password donot match');
    }
});