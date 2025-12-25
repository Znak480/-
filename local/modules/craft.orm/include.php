<?php
$modulePath = $_SERVER["DOCUMENT_ROOT"] . '/local/modules/craft.orm';
$loaderPath = $modulePath . '/vendor/autoload.php';

if(file_exists($loaderPath))
{
	include_once $loaderPath;
}