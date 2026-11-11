<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 * @var array $arResult
 * @var CMain $APPLICATION 
 */

if ($arParams["SET_TITLE"] == "Y")
{
	$APPLICATION->SetTitle(Loc::getMessage("SOA_ORDER_COMPLETE"));
}
?>

<? if (!empty($arResult["ORDER"])): ?>
	<section class="section section-confirm">
        <div class="container">
			<div class="section-confirm-content">
				<span class="section-confirm-title">
					<?=Loc::getMessage("SOA_ORDER_SUC", array(
						"#ORDER_DATE#" => $arResult["ORDER"]["DATE_INSERT"]->toUserTime()->format('d.m.Y H:i'),
						"#ORDER_ID#" => htmlspecialcharsbx($arResult["ORDER"]["ACCOUNT_NUMBER"])
					))?>
				</span>

				<? if (!empty($arResult['ORDER']["PAYMENT_ID"])): ?>
				<span class="section-confirm-payment">
					<?=Loc::getMessage("SOA_PAYMENT_SUC", array(
						"#PAYMENT_ID#" => htmlspecialcharsbx($arResult['PAYMENT'][$arResult['ORDER']["PAYMENT_ID"]]['ACCOUNT_NUMBER'])
					))?>
				</span>
				<? endif ?>

				<p class="section-confirm-data">
					<?=Loc::getMessage("SOA_DESCRIPTION")?>
				</p>
				

				<?if (!empty($arPaySystem["ERROR"]))
					{
				?>
					<span class="section-confirm-error"><?=Loc::getMessage("SOA_ORDER_PS_ERROR")?></span>
				<?
					}
				?>

				<a href="/" class="btn btn-secondary btn-confirm"><?=Loc::getMessage("SOA_CONFIRM_BUTTON")?></a>

			</div>
		</div>
	</section>
<? else: ?>
	<section class="section section-confirm">
        <div class="container">
			<div class="section-confirm-content">
				<span class="section-confirm-title">
					<?=Loc::getMessage("SOA_ERROR_ORDER")?>
				</span>

				<span class="section-confirm-payment">
					<?=Loc::getMessage("SOA_ERROR_ORDER_LOST", ["#ORDER_ID#" => htmlspecialcharsbx($arResult["ACCOUNT_NUMBER"])])?>
				</span>

				<p class="section-confirm-data">
					<?=Loc::getMessage("SOA_ERROR_ORDER_LOST1")?>
				</p>


				<a href="/cart/" class="btn btn-secondary btn-confirm"><?=Loc::getMessage("SOA_ERROR_BUTTON")?></a>
			</div>
		</div>
	</section>
<? endif ?>