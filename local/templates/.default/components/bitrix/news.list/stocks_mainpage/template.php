<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
		<ul>
			<?foreach ($arResult["ITEMS"] as $arItem):?>
			<li>
				<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="g-ffffff">
					<div class="share">
						<?$file = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']["ID"], array('width'=>150, 'height'=>150), BX_RESIZE_IMAGE_PROPRORTIONAL, true);?>
						<div class="image" style=""><img src="<?=$file["src"]?>" alt="" ></div>
						<div class="title">
							<h3>Акция</h3>
							<div class="quantity"><?=$arItem["NAME"]?></div>
						</div>
					</div>
				</a>
			</li>
			<?endforeach;?>	
		</ul>
		<div class="mobile-clear"></div>