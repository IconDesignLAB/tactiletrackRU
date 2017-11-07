

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

        if(name.length >= 1 && email.length >= 1){
            $('#btn-checkout').addClass('active');
        }else {
            $('#btn-checkout').removeClass('active');
        }
    });


    $('#order-message').on('keyup',function(){

         var message = $('#order-message').val();
       
        if(message.length >= 1){
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
        url: 'ajax-email.php',
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
	  var message = $('#order-message').val();
       
        if(message.length <= 5){
		
			 $("#mes_err_2").empty().append('<p class="center">Пожалуйста заполните форму перед отправкой.</p>');
			return false;
		}
     e.preventDefault();

    var notes =  $("#order-message").val();


    $.ajax({
        url: 'ajax-email.php',
        type: 'post',
        data: ({  action:'notes', notes:notes}),
        dataType: 'json',
        success: function (data) {
            if(data == 'ok'){

                $('#form_2').empty().append('<h4>Спасибо за обращение</h4><p>Мы свяжемся с Вами в ближайшее время.</p>');
                setTimeout(function() { $('.close').click(); }, 5000);
            }
            if(data == ''){
                $("#mes_err").empty().append('<p>Введите корректный E-mail</p>');
            }
            if(data == 'error'){
                $("#mes_err").empty().append('<p>Сообщение не отправлено. Попробуйте позже</p>');
            }
        }
    });
});
	$('.tel-btn').on('click', function() {
		$('.tel-btn_drop').toggleClass('active');
	});
})(jQuery);