<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<?php
/**
 * @var string $componentPath
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @global CDatabase $DB
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $templateFile
 * @var string $templateFolder
 * @var string $componentPath
 * @var CraftCookieAgreeComponent $component
 */

$text = $arResult['TEXT'];

if(mb_strlen($text) <= 0 || $arResult['IS_HIDE'])
{
	return;
}

?>


<div class="cookie-agree " data-accept-cookie>
	<div class="cookie-agree-wrapper">
		<div class="cookie-agree__text">
			<?=htmlspecialchars_decode($text);?>
		</div>
		<div class="cookie-agree__button">
			<div class="site-button" data-accept-cookie-button>
				<div class="site-button__button">Понятно</div>
			</div>
		</div>
	</div>
</div>
