<?php

use Bitrix\Main\Localization\Loc;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$arComponentParameters = [
	'GROUPS' => [],
	'PARAMETERS' => [
		'CACHE_TIME' => [
            'PARENT' => 'BASE',
            'NAME' => Loc::getMessage('CACHE_TIME'),
            'TYPE' => 'STRING',
            'DEFAULT' => 86400
        ],
		'SHOW_CLEAR_BUTTON' => [
            'PARENT' => 'BASE',
            'NAME' => Loc::getMessage('SHOW_CLEAR_BUTTON'),
            'TYPE' => 'STRING',
            'DEFAULT' => 'Y'
        ],
	],
];
