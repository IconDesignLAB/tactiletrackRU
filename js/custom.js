

setTimeout(function () {
	'use strict';
    document.getElementById("top-video").play();
    /*$('.slide-start').hide(200);
    $('.hide-fade').removeClass('fade');*/
}, 8000);


(function($) {

    $('#name_s , #email_s').on('keyup',function(){

         var name = $('#name_s').val();
         var email = $('#email_s').val();

        if(name.length >= 2 && email.length >= 5){
            $('#btn-checkout').addClass('active');
        }else {
            $('#btn-checkout').removeClass('active');
        }
    });


    $('#order-message').on('keyup',function(){

         var message = $('#order-message').val();
       
        if(message.length >= 8){
            $('#btn-checkout-2').addClass('active');
        }else {
            $('#btn-checkout-2').removeClass('active');
        }
    });


 $(document).on('click', '.go_form', function(e){
     e.preventDefault();

    var name =  $("#name_s").val();
    var email =  $("#email_s").val();
    var mark =  $("#mark").val();

    $.ajax({
        url: '/ajax-email.php',
        type: 'post',
        data: ({  action:'index', name:name, email:email, mark:mark }),
        dataType: 'json',
        success: function (data) {
            if(data == 'ok'){
                $('#form_1').removeClass('active');
                $('#form_2').addClass('active');
            }
            if(data == 'no email'){
                $("#mes_err").empty().append('<p>Введите корректный E-mail</p>');
            }
        }
    });
});

 $(document).on('click', '.go_form_2', function(e){
     e.preventDefault();

    var notes =  $("#order-message").val();


    $.ajax({
        url: '/ajax-email.php',
        type: 'post',
        data: ({  action:'notes', notes:notes}),
        dataType: 'json',
        success: function (data) {
            if(data == 'ok'){

                $('#form_2').empty().append('<h4>СПАСИБО ЗА ОБРАЩЕНИЕ, НАШИ МЕНЕДЖЕРЫ СВЯЖУТСЯ С ВАМИ В БЛИЖАЙШЕЕ ВРЕМЯ</h4>');
                setTimeout(function() { $('.close').click(); }, 3000);
            }
            if(data == 'error'){
                $("#mes_err").empty().append('<p>Сообщение не отправлено. Попробуйте позже</p>');
            }
        }
    });
});

})(jQuery);