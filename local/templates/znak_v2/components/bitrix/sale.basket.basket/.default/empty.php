<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
?>
 <section class="cart">
	<div class="container">
		<div class="cart-content cart-content--empty">
			<h2 class="empty-title"><?= Loc::getMessage("SBB_EMPTY_BASKET_TITLE")?></h2>
			<p class="empty-description">
				<?=Loc::getMessage("SBB_EMPTY_BASKET_DESCRIPTION",["#LINE_BREAK#"=>"<br>"]);?>
			</p>
			<? if (!empty($arParams['EMPTY_BASKET_HINT_PATH'])) : ?>
				<?=Loc::getMessage(
					'SBB_BASKET_HINT_TEXT',
					[
						'#TAG_OPEN#' => '<a class="btn btn-primary" href="'.$arParams['EMPTY_BASKET_HINT_PATH'].'">',
						'#TAG_CLOSE#' => '</a>',
					]
				)?>
			<? endif; ?>
		</div>
	</div>
</section>

