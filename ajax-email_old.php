<?php

/* SETTINGS */
//$yourEmail = "itactiletrack@gmail.com";
$yourEmail = "itactiletrack@gmail.com";
$emailSubject = "Tactile Track Preorder";



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



if($_POST){

  /* DATA FROM HTML FORM */
  $name = $_POST['name55'];
  $email = $_POST['email55'];  
  $notes = $_POST['notes55'];
  $model = $_POST['model55'];
  $quantity = $_POST['quantity55'];
  $headers = "From: $name <$email>\r\n" .
             "Reply-To: $name <$email>\r\n" . 
             "Subject: $emailSubject\r\n" .
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
'.print_r($notes, TRUE)."

-- \r\n

-----------------------------------------------------
User-Agent:
".$_SERVER['HTTP_USER_AGENT']."

User Accept Language :".@$_SERVER['HTTP_ACCEPT_LANGUAGE']."
User IP              :".@$_SERVER['REMOTE_ADDR']."
-----------------------------------------------------
";


	/* SEND EMAIL */
	if ($_is_injected===false) 
	{
	mail($yourEmail, $emailSubject, $message, $headers);
	}
	
}
?>