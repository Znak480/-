<?php

use Craft\Core\Component\AjaxComponent;
use Craft\Core\Rest\ResponseBx;

class CraftFormVacanciesAssign extends AjaxComponent
{

	function componentNamespace(): string
	{
		return 'craftFormVacanciesAssign';
	}

	protected function validate(array $postData): void
	{
	}

	protected function store(array $formData): void
	{
		try
		{
			if(!file_exists($_SERVER["DOCUMENT_ROOT"] . "/include/libmail.php"))
			{
				return;
			}

			require($_SERVER["DOCUMENT_ROOT"] . "/include/libmail.php");
			$adminEmail = COption::GetOptionString('main', 'email_from', 'default@admin.email');

			$message = ('Вам пришел отклик на вакансию<br>');
			$message .= ("От: " . $formData["fio"] . "<br>");
			$message .= ("Email: " . $formData["email"] . "<br>");
			$message .= ("Телефон: " . $formData["phone"] . "<br>");
			$message .= ("Должность: " . $formData["dolzhnost"] . "<br>");
			$m = new Mail;
			$m->From("noreply@wznakooo.ru"); // от кого отправляется почта
			$m->To($adminEmail); // кому адресованно
			$m->Subject("Отклик на вакансию");
			$m->Body($message, "html");
			$m->Attach($_FILES["file"]["tmp_name"], $_FILES["file"]["name"], "", "attachment"); // прикрепленный файл
			$m->smtp_on("mail.nic.ru", "noreply@znakooo.ru", "8RdG5eY1wC", 25); // если указана эта команда, отправка пойдет через SMTP
			$m->log_on(true);
			$m->Send();    // а теперь пошла отправка
			$msg = $m->Get(); // получение в переменную


			ResponseBx::success([
				'data' => $msg,
			]);
		} catch(Exception $e)
		{
		}
	}

	protected function modules(): ?array
	{
		return [];
	}

	protected function loadData(): void
	{
	}

	public function loadServices(): void
	{
	}
}