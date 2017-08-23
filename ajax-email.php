<?php
if ( ! session_id() ) @ session_start();
/* SETTINGS */
//$yourEmail = "itactiletrack@gmail.com";
const Y_EMAIL = "itactiletrack@gmail.com";
const EMAIL_S = "Tactile Track Preorder";



        if($_POST['action'] == 'index'){
            if(!empty($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                index();
                exit;
            }else{
                echo  json_encode('no email');
                exit;
            }

        }

        if($_POST['action'] == 'notes'){
            notes();
            exit;
        }


function is_injected($mess)
// Проверяет, является ли $mess нормальным сообщением или это СПАМ
{
		$res=0;
		$max_entries=5; //максимальное количество повторов ключесвых строк в письме

        if ($mess) // Если сообщение не пустое
        {
          $mess=strtolower($mess);
    	  $mess = urldecode($mess);
          if ((substr_count($mess, '@')>=$max_entries))
          {
             $res=1;
          }
          if (eregi("(\r|\n)", $mess)) {
			 $res=1;
		  }
        }
        return $res;
}

function index(){
        /* DATA FROM HTML FORM */
        $name = $_POST['name'];
        $email = $_POST['email'];
        $model = $_POST['mark'];
        $quantity = 1;
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['model'] = $model;


        $headers = "From: $name <$email>\r\n" .
            "Reply-To: $name <$email>\r\n" .
            "Subject: ".EMAIL_S."\r\n" .
            "Content-type: text/plain; charset=UTF-8\r\n" .
            "MIME-Version: 1.0\r\n" .
            "X-Mailer: PHP/" . phpversion() . "\r\n";

        // защита от Mail-Injection***
        $_is_injected=false;
        if (is_injected($_POST["edt_Email"])){$_is_injected=true;};
        if (is_injected($_POST["edt_Features"])){$_is_injected=true;};
        if (is_injected($_POST["edt_Reason"])){$_is_injected=true;};



        $message=
            'New preorder of Tactile Track.

Name: '.$name.'
Email: '.$email.'
Model: '.$model.'
Quantity: '.$quantity.'


-----------------------------------------------------
User-Agent:
'.$_SERVER['HTTP_USER_AGENT'].'

User Accept Language :'.@$_SERVER['HTTP_ACCEPT_LANGUAGE'].'
User IP              :'.@$_SERVER['REMOTE_ADDR'].'
-----------------------------------------------------
';


        /* SEND EMAIL */
        if ($_is_injected===false) {
            if (mail(Y_EMAIL, EMAIL_S, $message, $headers))
            {
                echo  json_encode('ok');
            }
        }
}


function notes(){
    /* DATA FROM HTML FORM */
    $name =  $_SESSION['name'];
    $email =  $_SESSION['email'];
    $model = $_SESSION['model'];
    $notes = $_POST['notes'];
    $quantity = 1;
    $headers = "From: $name <$email>\r\n" .
        "Reply-To: $name <$email>\r\n" .
        "Subject: ".EMAIL_S."\r\n" .
        "Content-type: text/plain; charset=UTF-8\r\n" .
        "MIME-Version: 1.0\r\n" .
        "X-Mailer: PHP/" . phpversion() . "\r\n";

    // защита от Mail-Injection***
    $_is_injected=false;
    if (is_injected($_POST["edt_Email"])){$_is_injected=true;};
    if (is_injected($_POST["edt_Features"])){$_is_injected=true;};
    if (is_injected($_POST["edt_Reason"])){$_is_injected=true;};



    $message=
        'New preorder of Tactile Track.

Name: '.$name.'
Email: '.$email.'
Model: '.$model.'
Quantity: '.$quantity.'


Additional information:
'.print_r($notes, TRUE).'

-- \r\n
-----------------------------------------------------
User-Agent:
'.$_SERVER['HTTP_USER_AGENT'].'

User Accept Language :'.@$_SERVER['HTTP_ACCEPT_LANGUAGE'].'
User IP              :'.@$_SERVER['REMOTE_ADDR'].'
-----------------------------------------------------
';


    /* SEND EMAIL */
    if ($_is_injected===false) {
        if (mail(Y_EMAIL, EMAIL_S, $message, $headers))
        {

            echo  json_encode('ok');
        }else{
            echo  json_encode('error');
            exit;
        }
    }
}



?>