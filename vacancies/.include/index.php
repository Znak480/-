<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>

<?php
/**
 * @global CMain $APPLICATION
 * @global $currentCity
 */

global $currentCity, $APPLICATION;
?>

<div class="title-block-full ps-0">
	<h1 class="big-din">Вакансии</h1>
</div>

<?php
$APPLICATION->IncludeComponent(
	'craft:content.area',
	'html.render',
	[
		'CODE' => 'vacancies.text.before-form',
	],
	false,
	['HIDE_ICONS' => 'Y']
);

$APPLICATION->IncludeComponent(
	'craft:form.vacancies.assign',
	'.default',
	[],
	false,
	['HIDE_ICONS' => 'Y']
);
?>
<br>
