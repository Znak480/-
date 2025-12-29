<?php

if(!$_SERVER['DOCUMENT_ROOT'])
{
	$_SERVER['DOCUMENT_ROOT'] = __DIR__ . '/../../..';
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

if(!\Bitrix\Main\Loader::includeModule('craft.orm'))
{
	throw new Exception('Модуль не установлен craft.orm');
}

use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new \Craft\Orm\Cli\OrmAnnotateCommand());
$application->run();

