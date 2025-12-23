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
 * @var CraftContentAreaComponent $component
 */

$text = $component->getValue('TEXT');

if($text)
{
	?>
	<div id="<?=$component->editAreaId();?>">
		<?=$text;?>
	</div>
	<?php
} else
{
	$component->showNoActiveMessage();
}
