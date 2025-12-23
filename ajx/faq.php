<?require($_SERVER["DOCUMENT_ROOT"]."/include/libmail.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$adminEmail = COption::GetOptionString('main', 'email_from', 'default@admin.email');

	$message=('Вам пришел вопрос<br>');
	$message.=("От: ".$_POST["fio"]."<br>");
	$message.=("Email: ".$_POST["email"]."<br>");
	$message.=("Телефон: ".$_POST["phone"]."<br>");
	$message.=("Вопрос: ".$_POST["comment"]."<br>");
	$m= new Mail;
	$m->From("noreply@znakooo.ru"); // от кого отправляется почта
	$m->To( $adminEmail ); // кому адресованно
	$m->Subject("Вопрос с сайта");
	$m->Body( $message , "html");    
	$m->smtp_on( "mail.nic.ru", "noreply@znakooo.ru", "97kw2fKjvz6ZQ", 25) ; // если указана эта команда, отправка пойдет через SMTP 
	$m->log_on(true);
	$m->Send();    // а теперь пошла отправка
	$msg = $m->Get(); // получение в переменную
	echo($msg);
?>