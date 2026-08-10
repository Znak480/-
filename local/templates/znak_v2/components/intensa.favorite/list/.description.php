<?php

use Bitrix\Main\Localization\Loc;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
    "NAME" => Loc::getMessage('IF_CL_NAME'),
    "DESCRIPTION" => "",
    "SORT" => 10,
    "CACHE_PATH" => "Y",
    "PATH" => array(
        "ID" => "favorite",
    ),
    "COMPLEX" => "N",
);
