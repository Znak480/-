<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<?php
/**
 * @global CMain $APPLICATION
 */

global $APPLICATION;
?>


<div class="common-content-full contacts-page regular-block">
	<div class="title-block-full">
		<h1 class="big-din">О компании</h1>
	</div>
	<?php
	$APPLICATION->IncludeComponent(
		'craft:content.area',
		'html.render',
		[
			'CODE' => 'about.text',
		],
		false,
		['HIDE_ICONS' => 'Y']
	);
	?>
</div>
<br>