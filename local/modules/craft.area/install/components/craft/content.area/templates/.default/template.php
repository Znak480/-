<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<?php
/**
 * @var array $arParams
 * @var array $arResult
 * @var JediContentAreaComponent $component
 */
?>


<?php
if($component->isAreaActive())
{
	?>
	<div id="<?=$component->editAreaId();?>">
		<?=$component->getValue('STRING_PROPERTY');?>
	</div>
	<?php
} else
{
	$component->showNoActiveMessage();
}
?>