<?php

namespace Craft\Core\Component;

abstract class MailedComponent extends CacheableComponent
{

	public function onPrepareComponentParams($arParams)
	{
		$arParams = parent::onPrepareComponentParams($arParams);

		$arParams['MAIL_MESSAGE_ID'] = $arParams['MAIL_MESSAGE_ID'] ? intval($arParams['MAIL_MESSAGE_ID']) : '';
		$arParams['SEND_DUPLICATE'] = in_array($arParams['SEND_DUPLICATE'], ['Y', 'N']) ? $arParams['SEND_DUPLICATE'] : 'Y';
		$arParams['SEND_MAIL'] = in_array($arParams['SEND_MAIL'], ['Y', 'N']) ? $arParams['SEND_MAIL'] : 'N';

		return $arParams;
	}

	protected function sendMail(array $mailFields = []): void
	{

		if($this->arParams['SEND_MAIL'] != 'Y' || empty($this->arParams['MAIL_EVENT_TYPE']))
		{
			return;
		}

		$mailParams = [
			"EVENT_NAME" => $this->arParams['MAIL_EVENT_TYPE'],
			"LID"        => SITE_ID,
		];

		if($mailFields)
		{
			$mailParams = array_merge($mailParams, $mailFields);
		}

		$files = [];

		if($this->getUploadedFileIdList())
		{
			$files = $this->getAllFileIdList();
		}

		\CEvent::send(
			$this->arParams['MAIL_EVENT_TYPE'],
			SITE_ID,
			$mailParams,
			$this->arParams['SEND_DUPLICATE'],
			$this->arParams['MAIL_MESSAGE_ID'],
			$files
		);

		$event = new \Bitrix\Main\Event($this->componentNamespace(), 'afterSendMail', $mailFields);
		$event->send();
	}
}