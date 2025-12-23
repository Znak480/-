<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<ul>
<?foreach ($arResult["ITEMS"] as $arItem):?>
	<li style="background: url('<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>') no-repeat;">		
		<div class="wrapper">
				<?=$arItem["PREVIEW_TEXT"]?>
		</div>
	</li>
				

<?endforeach;?>
				</ul>