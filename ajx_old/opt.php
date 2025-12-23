<?require($_SERVER["DOCUMENT_ROOT"]."/include/libmail.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$adminEmail = COption::GetOptionString('main', 'email_from', 'default@admin.email');

	$message=('Вам пришла заявка на оптовый прайс<br>');
	$message.=("Организация: ".$_POST["fio"]."<br>");
	$message.=("От: ".$_POST["fio"]."<br>");
	$message.=("Email: ".$_POST["email"]."<br>");
	$message.=("Телефон: ".$_POST["phone"]."<br>");
	$message.=("Примечание: ".$_POST["comment"]."<br>");
	$m= new Mail;
	$m->From("noreply@znakooo.ru"); // от кого отправляется почта
	$m->To( $adminEmail ); // кому адресованно
	$m->Subject("Заявка на оптовый прайс");
	$m->Body( $message , "html");    
	$m->smtp_on( "mail.nic.ru", "noreply@znakooo.ru", "8RdG5eY1wC", 25) ; // если указана эта команда, отправка пойдет через SMTP
	$m->log_on(true);
	$m->Send();    // а теперь пошла отправка
	$msg = $m->Get(); // получение в переменную
	echo($msg);
?>