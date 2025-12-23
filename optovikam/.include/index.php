<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>

<?php

/**
 * @global CMain $APPLICATION
 */

global $APPLICATION;
?>

<div class="common-content-full wholesalers-page regular-block">
	<div class="title-block-full">
		<h1 class="big-din">Оптовикам мы предлагаем:</h1>
	</div>
	<div class="content-block-full">
		<?php
		$APPLICATION->IncludeComponent(
			'craft:form.optovikam.prices',
			'.default',
			[],
			false,
			['HIDE_ICONS' => 'Y']
		);
		$APPLICATION->IncludeComponent(
			'craft:content.area',
			'html.render',
			[
				'CODE' => 'opt.delivery.byPreOrder',
			],
			false,
			['HIDE_ICONS' => 'Y']
		);
		$APPLICATION->IncludeComponent(
			'craft:content.area',
			'html.render',
			[
				'CODE' => 'opt.delivery.order',
			],
			false,
			['HIDE_ICONS' => 'Y']
		);
		?>


		<?php
		$APPLICATION->IncludeComponent(
			'craft:form.optovikam.delivery',
			'.default',
			[],
			false,
			['HIDE_ICONS' => 'Y']
		);
		?>

		<?php
		$APPLICATION->IncludeComponent(
			'craft:content.area',
			'html.render',
			[
				'CODE' => 'opt.personal.manager',
			],
			false,
			['HIDE_ICONS' => 'Y']
		);
		?>

	</div>
</div>
<br>
