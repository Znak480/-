<?require($_SERVER["DOCUMENT_ROOT"]."/include/libmail.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$adminEmail = COption::GetOptionString('main', 'email_from', 'default@admin.email');

	$message=('Вам пришел отклик на вакансию<br>');
	$message.=("От: ".$_POST["fio"]."<br>");
	$message.=("Email: ".$_POST["email"]."<br>");
	$message.=("Телефон: ".$_POST["phone"]."<br>");
	$message.=("Должность: ".$_POST["dolzhnost"]."<br>");
	$m= new Mail;
	$m->From("noreply@wznakooo.ru"); // от кого отправляется почта
	$m->To( $adminEmail  ); // кому адресованно
	$m->Subject("Отклик на вакансию");
	$m->Body( $message , "html");    
	$m->Attach( $_FILES["file"]["tmp_name"], $_FILES["file"]["name"], "", "attachment" ); // прикрепленный файл 
	$m->smtp_on( "mail.nic.ru", "noreply@znakooo.ru", "8RdG5eY1wC", 25) ; // если указана эта команда, отправка пойдет через SMTP 
	$m->log_on(true);
	$m->Send();    // а теперь пошла отправка
	$msg = $m->Get(); // получение в переменную
	echo($msg);
?>