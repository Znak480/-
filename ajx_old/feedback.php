<?require($_SERVER["DOCUMENT_ROOT"]."/include/libmail.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$adminEmail = COption::GetOptionString('main', 'email_from', 'default@admin.email');
$mailTo = \COption::GetOptionString( "askaron.settings", "UF_EMAIL_OPT");
CModule::IncludeModule("iblock");
if (empty($_POST)){
    exit();
}

$m= new Mail;
if (!empty($_POST['product'])){
    $m->Subject("Заявка  с формы \"Покупка в 1 клик\"");
    $message=('Вам пришла заявка  с формы "Покупка в 1 клик"<br>');
} else {
    $m->Subject("Заявка на обратный звонок");
	$message=('Вам пришла заявка на обратный звонок<br>');
}
	$message.=("От: ".$_POST["fio"]."<br>".PHP_EOL);
	$message.=("Email: ".$_POST["email"]."<br>".PHP_EOL);
	$message.=("Телефон: ".$_POST["phone"]."<br>".PHP_EOL);
	$message.=("Примечание: ".$_POST["comment"]."<br>".PHP_EOL);

if (!empty($_POST['product'])){
    $arSelect = Array("ID", "NAME", "DETAIL_PAGE_URL");
    $arFilter = Array("IBLOCK_ID"=>$currentCity['IBLOCK_CATALOG']['VALUE'], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y","ID"=>$_POST['product']);
    $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nTopCount"=>1), $arSelect);
    while($ob = $res->GetNextElement())
    {
        $arFields = $ob->GetFields();
        $message.=("Информация о товаре: "."<br>".PHP_EOL.
            "\tНазвание: ".$arFields['NAME']."<br>".PHP_EOL.
            "\tДетальная страницы: ".$arFields['DETAIL_PAGE_URL']."<br>".PHP_EOL);
    }
}

	$m->From("no-reply@znakooo.ru"); // от кого отправляется почта
	$m->To( $adminEmail ); // кому адресованно
//	$m->To("roman@e1media.ru"); // кому адресованно
	$m->To( $mailTo ); // кому адресованно
	//$m->To( "r.p.1993@mail.ru" ); // кому адресованно
	$m->Body( $message , "html");
//	$m->smtp_on( "mail.nic.ru", "noreply@znakooo.ru", "8RdG5eY1wC", 25) ; // если указана эта команда, отправка пойдет через SMTP
	$m->log_on(true);
if (!empty($_POST['product']) || ($_POST['fix']) == 5) {
    $m->Send();    // а теперь пошла отправка
} 
//	$m->Send();    // а теперь пошла отправка
	$msg = $m->Get(); // получение в переменную
//mail('rp1993@yandex.ru','Сообщение со знака',$adminEmail.$message);
	echo($msg);
?>